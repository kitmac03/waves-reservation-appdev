<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservedAmenity;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        // Fetch only active cottages and tables
        $cottages = Amenities::where('type', 'cottage')->where('is_active', 1)->get();
        $tables = Amenities::where('type', 'table')->where('is_active', 1)->get();

        return view('customer.dashboard', compact('cottages', 'tables'));
    }

    public function store(Request $request)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to make a reservation.');
        }

        // Validate request
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

        // Ensure only one type is selected
        if ($request->filled('cottage') && $request->filled('tables')) {
            return back()->with('error', 'You can only select either a Cottage or a Table.')->withInput();
        }

        // Extract only time (H:i:s) from input
        $startTime = Carbon::parse($request->startTime)->format('H:i:s');
        $endTime = Carbon::parse($request->endTime)->format('H:i:s');

        // Create reservation
        $reservation = Reservation::create([
            'id' => Str::uuid(),
            'customer_id' => Auth::id(), // Use Auth::id() instead of auth()->id()
            'date' => $request->date,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'status' => 'pending',
        ]);

        // Save the selected amenity (either cottage or table)
        if ($request->filled('cottage') || $request->filled('tables')) {
            ReservedAmenity::create([
                'res_num' => $reservation->id, // Use reservation ID
                'amenity_id' => $request->cottage ?? $request->tables,
            ]);
        }

        return redirect()->route('customer.dashboard')->with('success', 'Reservation created successfully!');
    }
}
