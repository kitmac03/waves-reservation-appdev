<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\DownPayment;
use App\Models\Bill;
use App\Models\Balance;
use App\Models\ReservedAmenity;
use Illuminate\Support\Facades\DB;

class CleanOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Run using:
     * php artisan reservations:cleanup
     */
    protected $signature = 'reservations:cleanup';

    /**
     * The console command description.
     */
    protected $description = 'Delete old reservations (and related data) before October 5, 2025 with total booking = 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = '2025-10-31';
        $this->info("🧹 Cleaning up reservations before {$cutoffDate} with total booking = 0...");

        DB::beginTransaction();

        try {
            // Get all reservations before cutoff where the total is 0
            $oldReservations = Reservation::where('date', '<', $cutoffDate)
                ->whereHas('bill', function ($q) {
                    $q->where('grand_total', '=', 0);
                })
                ->get();

            $deletedCount = 0;

            foreach ($oldReservations as $reservation) {
                // Delete reserved amenities
                ReservedAmenity::where('res_num', $reservation->id)->delete();

                // Delete down payments
                DownPayment::where('res_num', $reservation->id)->delete();

                // Delete related bills and balances
                $bills = \App\Models\Bill::where('res_num', $reservation->id)->get();
                foreach ($bills as $bill) {
                    Balance::where('bill_id', $bill->id)->delete();
                    $bill->delete();
                }

                // Delete the reservation itself
                $reservation->delete();

                $deletedCount++;
            }

            DB::commit();

            $this->info("✅ Deleted {$deletedCount} old reservations with total booking = 0.");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Cleanup failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
