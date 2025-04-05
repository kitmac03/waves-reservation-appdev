<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\DownPayment;
use App\Models\Bill;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'reservation_id' => 'required|uuid',
            'dp_id' => 'required|uuid',
            'bill_id' => 'required|uuid',
            'status' => 'required|string|in:verified,invalid,completed',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $downPayment = DownPayment::findOrFail($request->dp_id);
        $bill = Bill::findOrFail($request->bill_id);

        $existingBalance = Balance::where('bill_id', $bill->id)->sum('balance');
        $paymentAmount = $request->payment_amount;
        $newBalance = $existingBalance + $paymentAmount;
        $grandTotal = $bill->grand_total;
        $downPaymentAmount = $grandTotal * 0.5;

        DB::transaction(function () use (
            $newBalance, $grandTotal, $downPaymentAmount, $bill, $downPayment, $reservation, $request
        ) {
            // Determine Bill Status
            if ($newBalance >= $grandTotal) {
                $bill->update(['status' => 'paid']);
            } elseif ($newBalance > 0) {
                $bill->update(['status' => 'partially paid']);
            } else {
                $bill->update(['status' => 'unpaid']);
            }

            // Update Downpayment Status
            if ($request->status === 'invalid' || $newBalance == 0) {
                $downPayment->update(['status' => 'invalid']);
            } elseif ($newBalance > 0) {
                $downPayment->update([
                    'status' => 'verified',
                    'verified_by' => Auth::id(),
                ]);
            }

            // Update Reservation Status
            if ($reservation->status === 'pending' && $newBalance >= $downPaymentAmount) {
                $reservation->update(['status' => 'verified']);
            }

            // Update or Create Balance Record
            Balance::updateOrCreate(
                ['bill_id' => $bill->id, 'dp_id' => $downPayment->id],
                [
                    'balance' => $newBalance,
                    'status' => ($newBalance >= $grandTotal) ? 'paid' : 'partially paid',
                    'received_by' => Auth::id(),
                ]
            );
        });

        return back()->with([
            'success' => 'Payment successfully recorded.',
        ]);
    }

    public function invalidPayment(Request $request)
    {
        \Log::info('📢 INVALID PAYMENT REQUEST DATA', $request->all());
        
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'dp_id' => 'required|exists:down_payments,id', // Make sure this matches your table name
            'bill_id' => 'required|exists:bills,id',
            'status' => 'required|in:invalid',
        ]);
    
        try {
            DB::beginTransaction();
            
            // Update downpayment status
            $downpayment = DownPayment::findOrFail($request->dp_id);
            $downpayment->update(['status' => 'invalid']);

            DB::commit();
            
            \Log::info("Downpayment marked as invalid for reservation ID: {$request->reservation_id}");
            
            return redirect()->back()
                ->with('error', 'Payment marked as invalid.')
                ->with('invalid_payment', true);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Failed to mark payment as invalid: " . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to mark payment as invalid. Please try again.');
        }
    }
}
