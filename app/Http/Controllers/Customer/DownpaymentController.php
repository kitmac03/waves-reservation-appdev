<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\DownPayment;
use App\Models\Balance;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DownpaymentController extends Controller
{
    public function show(Reservation $reservation)
    {
        // Eager load bill (singular), not bills (plural)
        $reservation->load('reservedAmenities.amenity', 'bill');

        // Access the bill directly from the relationship
        $bill = $reservation->bill;

        if (!$bill) {
            return back()->withErrors(['bill' => 'No billing information found. Please contact support.']);
        }

        return view('customer.downpayment', compact('reservation', 'bill'));
    }

    public function store(Request $request, $reservationId)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'ref_number' => 'required|string|max:20',
            'payment_proof' => 'required|image|max:2048',
        ]);

        // Get the reservation with its bill
        $reservation = Reservation::with('reservedAmenities.amenity', 'bill')->findOrFail($reservationId);
        $bill = $reservation->bill;

        if (!$bill) {
            return back()->withErrors(['bill' => 'No billing information found. Please contact support.']);
        }


        // Store the uploaded image proof
        $imagePath = $request->file('payment_proof')->store('proofs', 'public');

        // Create the new downpayment
        $downpayment = DownPayment::create([
            'id' => Str::uuid(),
            'res_num' => $reservation->id,
            'bill_id' => $bill->id,
            'amount' => null,
            'ref_num' => $request->ref_number,
            'img_proof' => $imagePath,
            'date' => now(),
            'status' => 'pending',
            'verified_by' => null,
        ]);

        // Update or create the balance record
        $existingBalance = Balance::where('bill_id', $bill->id)->first();

        if ($existingBalance) {
            $existingBalance->update([
                'dp_id' => $downpayment->id,
            ]);
        }

        return redirect()->route('customer.reservation')->with('success', 'Downpayment submitted successfully!');
    }
}
