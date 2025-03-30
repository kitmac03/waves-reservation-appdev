<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DownPayment;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class ReservationRecordController extends Controller
{
    public function view_reservation()
    {
        $downPayments = DownPayment::with('reservation')->latest()->get();

        // Ensure the variable name matches in compact()
        return view('admin.vendor.reservation-records', compact('downPayments'));
    }
    public function getEvents()
    {
        try {
            $reservations = Reservation::with(['customer', 'reservedAmenities.amenity', 'bills'])->get();

            if ($reservations->isEmpty()) {
                return response()->json([], 200);
            }

            $events = $reservations->map(function ($reservation) {
                 // Define colors based on status
                    $statusColors = [
                        'verified' => ['bg' => '#16a34a', 'border' => '#15803d'],   // Green
                        'pending' => ['bg' => '#ca8a04', 'border' => '#a16207'],    // Yellow
                        'cancelled' => ['bg' => '#dc2626', 'border' => '#b91c1c'],  // Red
                        'completed' => ['bg' => '#64748b', 'border' => '#475569']   // Gray
                    ];

                    $status = strtolower($reservation->status);
                    $color = $statusColors[$status] ?? ['bg' => '#3b82f6', 'border' => '#1e40af']; // Default Blue
                    return [
                    'title' => $reservation->customer->name ?? 'No Name',
                    'start' => $reservation->date,
                    'end' => $reservation->date,
                    'backgroundColor' => $color['bg'],
                    'borderColor' => $color['border'],
                    'extendedProps' => [
                        'customer_name' => $reservation->customer->name ?? 'Unknown',
                        'date' => $reservation->date,
                        'start_time' => Carbon::parse($reservation->startTime ?? '00:00 AM')->format('g:i A'),
                        'end_time' => Carbon::parse($reservation->endTime ?? '00:00 PM') ->format('g:i A'),
                        'amenities' => $reservation->reservedAmenities->map(function ($reservedAmenity) {
                            return [
                                'name' => $reservedAmenity->amenity->name ?? 'Unknown',
                                'price' => $reservedAmenity->amenity->price ?? 0
                            ];
                        })->toArray(),
                        'total' => $reservation->bills->first()?->grand_total ?? 0, // Get the grand_total from bills
                        'downpayment' => ($reservation->bills->first()?->grand_total ?? 0) * 0.5, // 50% downpayment
                        'status' => $reservation->status,
                        'reservation_id' => $reservation->id
                    ]
                ];
            });

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
