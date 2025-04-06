<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationRecordController extends Controller
{
    public function view_reservation()
    {
        $userId = Auth::id();
        $user = \App\Models\Admin::find($userId);
        
        if ($user && $user->role === 'vendor') {
            return view('admin.vendor.reservation_records');
        }
    
        // Redirect unauthorized users to dashboard or login
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    public function getEvents()
    {
        try {
            $reservations = Reservation::with(['customer', 'reservedAmenities.amenity', 'bills', 'downPayment'])
                ->whereHas('downPayment', function ($query) {
                    $query->whereNotNull('img_proof');
                })
                ->get();
    
            $events = $reservations->map(function ($reservation) {
                $statusColors = [
                    'verified' => ['bg' => '#16a34a', 'border' => '#15803d'],
                    'pending' => ['bg' => '#ca8a04', 'border' => '#a16207'],
                    'cancelled' => ['bg' => '#dc2626', 'border' => '#b91c1c'],
                    'completed' => ['bg' => '#64748b', 'border' => '#475569']
                ];
    
                $status = strtolower($reservation->status);
                $color = $statusColors[$status] ?? ['bg' => '#3b82f6', 'border' => '#1e40af'];
    
                // Retrieve the paid amount (balance) from the related bill or downPayment
                $paidAmount = 0;
    
                if ($reservation->bills->first() && $reservation->bills->first()->balance) {
                    $paidAmount = $reservation->bills->first()->balance->balance; // Get balance from bill
                } elseif ($reservation->downPayment && $reservation->downPayment->balance) {
                    $paidAmount = $reservation->downPayment->balance->balance; // Get balance from downPayment
                }
    
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->customer->name ?? 'No Name',
                    'start' => $reservation->date,
                    'end' => $reservation->date,
                    'backgroundColor' => $color['bg'],
                    'borderColor' => $color['border'],
                    'extendedProps' => [
                        'customer_name' => $reservation->customer->name ?? 'Unknown',
                        'phone_number' => $reservation->customer->number ?? 'Not Available',
                        'date' => $reservation->date,
                        'start_time' => Carbon::parse($reservation->startTime ?? '00:00 AM')->format('g:i A'),
                        'end_time' => Carbon::parse($reservation->endTime ?? '00:00 PM')->format('g:i A'),
                        'amenities' => $reservation->reservedAmenities->map(function ($reservedAmenity) {
                            return [
                                'name' => $reservedAmenity->amenity->name ?? 'Unknown',
                                'price' => $reservedAmenity->amenity->price ?? 0,
                            ];
                        })->toArray(),
                        'status' => $reservation->status,
                        'reservation_id' => $reservation->id,
                        'dp_id' => $reservation->downPayment->id ?? null,
                        'bill_id' => $reservation->bills->first()->id ?? null,
                        'bill_status' => $reservation->bills->first()->status,
                        'total' => $reservation->bills->first()?->grand_total ?? 0,
                        'paid_amount' => $paidAmount,  
                        'downpayment' => ($reservation->bills->first()?->grand_total ?? 0) * 0.5,
                        'downpayment_status' => $reservation->downPayment->status ?? null,
                        'downpayment_image' => $reservation->downPayment?->img_proof ? asset('storage/' . $reservation->downPayment->img_proof) : null,
                        'ref_num' => $reservation->downPayment?->ref_num ?? 'N/A',
                    ]
                ];
            });
    
            return response()->json($events);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}