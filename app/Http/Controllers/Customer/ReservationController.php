<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservedAmenity;
use App\Models\Amenities;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        // Fetch only active cottages and tables
        $cottages = Amenities::where('type', 'cottage')->where('is_active', 1)->get();
        $tables = Amenities::where('type', 'table')->where('is_active', 1)->get();

        return view('customer.reservation', compact('cottages', 'tables'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to make a reservation.');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
            'cottage' => 'nullable|exists:amenities,id',
            'tables' => 'nullable|exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $startTime = Carbon::parse($request->startTime)->format('H:i:s');
        $endTime = Carbon::parse($request->endTime)->format('H:i:s');

        $reservation = Reservation::create([
            'id' => Str::uuid(),
            'customer_id' => Auth::id(),
            'date' => $request->date,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'status' => 'pending',
        ]);

        // Save selected cottage if present
        if ($request->filled('cottage')) {
            ReservedAmenity::create([
                'res_num' => $reservation->id,
                'amenity_id' => $request->cottage,
            ]);
        }

        // Save selected table if present
        if ($request->filled('tables')) {
            ReservedAmenity::create([
                'res_num' => $reservation->id,
                'amenity_id' => $request->tables,
            ]);
        }

        // Calculate total price of reserved items
        $total = 0;
        
        if ($request->filled('cottage')) {
            $amenity = Amenities::find($request->cottage);
            $total += $amenity->price;
        }
        if ($request->filled('tables')) {
            $amenity = Amenities::find($request->tables);
            $total += $amenity->price;
        }

        // Create the bill
        Bill::create([
            'id' => Str::uuid(),
            'res_num' => $reservation->id,
            'grand_total' => $total,
            'date' => Carbon::now(),
            'status' => 'unpaid',
        ]);

        return redirect()->route('customer.downpayment.show', $reservation);
    }
}
