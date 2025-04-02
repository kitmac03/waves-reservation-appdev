<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\DownPayment;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DownpaymentController extends Controller
{
    public function show(Reservation $reservation)
    {
        // Eager load relationships and fetch bill
        $reservation->load('reservedAmenities.amenity', 'bills');

        // Fetch the bill using the res_num (foreign key)
        $bill = Bill::where('res_num', $reservation->id)->first();

        return view('customer.downpayment', compact('reservation'));
    }

    public function store(Request $request, $reservationId)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'ref_number' => 'required|string|max:20',
            'payment_proof' => 'required|image|max:2048',
        ]);

        // Get the reservation with amenities
        $reservation = Reservation::with('reservedAmenities.amenity')->findOrFail($reservationId);

        // Get the bill for the reservation
        $bill = Bill::where('res_num', $reservation->id)->first();

        if (!$bill) {
            return back()->withErrors(['bill' => 'No billing information found. Please contact support.']);
        }

        // Calculate 50% downpayment
        $downpaymentAmount = $bill->grand_total * 0.5;

        // Store the uploaded image proof
        $imagePath = $request->file('payment_proof')->store('proofs', 'public');

        // Save the downpayment
        DownPayment::create([
            'id' => Str::uuid(),
            'res_num' => $reservation->id,
            'amount' => $downpaymentAmount,
            'ref_num' => $request->ref_number,
            'img_proof' => $imagePath,
            'date' => now(),
            'status' => 'pending',
            'verified_by' => null,
        ]);

        return redirect()->route('customer.reservation')->with('success', 'Downpayment submitted successfully!');
    }
}
