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
        if ($request->has('cottages')) {
            foreach ($request->cottages as $cottageId) {
                if (!empty($cottageId)) {
                    ReservedAmenity::create([
                        'res_num' => $reservation->id,
                        'amenity_id' => $cottageId,
                    ]);
                }
            }
        }

        // Save selected table if present
        if ($request->has('tables')) {
            foreach ($request->input('tables') as $tableId) {
                if (!empty($cottageId)) {
                    ReservedAmenity::create([
                        'res_num' => $reservation->id,
                        'amenity_id' => $tableId,
                    ]);
                }
            }
        }


        $total = 0;

        // Sum selected cottages
        if ($request->filled('cottages')) {
            foreach ($request->cottages as $cottageId) {
                $amenity = Amenities::find($cottageId);
                if ($amenity) {
                    $total += $amenity->price;
                }
            }
        }

        // Sum selected tables
        if ($request->filled('tables')) {
            foreach ($request->tables as $tableId) {
                $amenity = Amenities::find($tableId);
                if ($amenity) {
                    $total += $amenity->price;
                }
            }
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
    
    public function view_reservations()
    {
        $customer = auth()->user();


        $allReservations = $customer->reservations()->with('reservedAmenities.amenity')->get();
        $pendingReservations = $customer->reservations()->where('status', 'pending')->with('reservedAmenities.amenity')->get();
        $cancelledReservations = $customer->reservations()->where('status', 'cancelled')->with('reservedAmenities.amenity')->get();
        $completedReservations = $customer->reservations()->where('status', 'completed')->with('reservedAmenities.amenity')->get();
        $verifiedReservations = $customer->reservations()->where('status', 'verified')->with('reservedAmenities.amenity')->get();
        $invalidReservations = $customer->reservations()->where('status', 'invalid')->with('reservedAmenities.amenity')->get();

        $currentReservations = $pendingReservations->merge($verifiedReservations);
    
        return view('customer.reservation_records', compact(
            'customer', 
            'pendingReservations', 
            'cancelledReservations', 
            'completedReservations',
            'invalidReservations',
            'currentReservations',
            'allReservations'
        ));
    }
}