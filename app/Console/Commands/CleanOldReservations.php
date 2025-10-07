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
     * Run this command with:
     * php artisan reservations:cleanup
     */
    protected $signature = 'reservations:cleanup';

    /**
     * The console command description.
     */
    protected $description = 'Delete reservations (and related data) dated before October 5, 2025';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = '2025-10-05';

        $this->info("🧹 Cleaning up reservations before {$cutoffDate}...");

        // Use transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Get all old reservations
            $oldReservations = Reservation::where('date', '<', $cutoffDate)->get();

            $deletedCount = 0;

            foreach ($oldReservations as $reservation) {
                // 1️⃣ Delete reserved amenities
                ReservedAmenity::where('res_num', $reservation->id)->delete();

                // 2️⃣ Delete down payments
                DownPayment::where('res_num', $reservation->id)->delete();

                // 3️⃣ Delete related bills and balances
                $bills = Bill::where('res_num', $reservation->id)->get();
                foreach ($bills as $bill) {
                    Balance::where('bill_id', $bill->id)->delete();
                    $bill->delete();
                }

                // 4️⃣ Finally, delete the reservation itself
                $reservation->delete();

                $deletedCount++;
            }

            DB::commit();

            $this->info("✅ Successfully deleted {$deletedCount} reservations and related records.");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();

            $this->error("❌ Error during cleanup: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
