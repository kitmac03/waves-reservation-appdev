<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationRecordController extends Controller
{
    public function view_history()
    {
        $vendor = auth('admin')->user();
        // this will show all the reservation
        $reservations = Reservation::with(['customer', 'reservedAmenities.amenity', 'bills', 'downPayment'])
            ->get();
    
        $reservations->each(function ($reservation) {
            $bill = $reservation->bills->firstWhere('res_num', $reservation->id);
            
            $grandTotal = optional($bill)->grand_total ?? 0;
    
            $paidAmount = 0;
    
            if ($bill && $bill->balance) {
                $paidAmount = $bill->balance->balance;
            }
    
            $balance = $grandTotal - $paidAmount;
    
            $reservation->paidAmount = $paidAmount;
            $reservation->grandTotal = $grandTotal;
            $reservation->balance = $balance;
        });
    
        // Filter reservations by status
        $pendingReservations = $reservations->where('status', 'pending');
        $cancelledReservations = $reservations->where('status', 'cancelled');
        $completedReservations = $reservations->where('status', 'completed');
        $verifiedReservations = $reservations->where('status', 'verified');
        $invalidReservations = $reservations->where('status', 'invalid');
    
        // Combine pending and verified reservations for current
        $currentReservations  = $pendingReservations->merge($verifiedReservations);
    
        return view('admin.vendor.reservation_records', compact(
            'pendingReservations', 'cancelledReservations', 'completedReservations',
            'verifiedReservations', 'invalidReservations', 'currentReservations'
        ));
    }

    public function view_reservation()
    {
        $userId = Auth::id();
        $vendor = Admin::find($userId);
        
        if ($vendor && $vendor->role === 'vendor') {
            return view('admin.vendor.reservation_calendar');
        }
    
       
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    public function getEvents()
    {
        try {
             // will only show reservation in calendar that has downpayment
            $reservations = Reservation::with(['customer', 'reservedAmenities.amenity', 'bills', 'downPayment'])
                ->has('downPayment')
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
    
                
                $paidAmount = 0;
    
                if ($reservation->bills->first() && $reservation->bills->first()->balance) {
                    $paidAmount = $reservation->bills->first()->balance->balance;
                }
    
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->customer->name ?? 'No Name',
                    'start' => $reservation->date,
                    'end' => $reservation->date,
                    'status' => $reservation->status,
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