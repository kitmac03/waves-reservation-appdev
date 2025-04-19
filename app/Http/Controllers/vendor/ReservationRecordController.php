<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Admin;
use App\Models\DownPayment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationRecordController extends Controller
{
    public function view_balance()
{
    $vendor = auth('admin')->user();

    $reservations = Reservation::with([
            'customer',
            'reservedAmenities.amenity',
            'bill.balance',
            'downPayment'
        ])
        ->whereIn('status', ['pending', 'verified'])
        ->whereHas('bill', function ($query) {
            $query->whereIn('status', ['partially paid', 'unpaid']);
        })
        ->get();

    $reservations->each(function ($reservation) {
        $bill = $reservation->bill;

        $grandTotal = optional($bill)->grand_total ?? 0;

        // Sum all verified down payments for this reservation
        $paidAmount = DownPayment::where('res_num', $reservation->id)
            ->whereIn('status', ['verified'])
            ->sum('amount');

        $reservation->paidAmount = $paidAmount;
        $reservation->grandTotal = $grandTotal;
        $reservation->balance = $grandTotal - $paidAmount;

        $reservation->downPaymentImageUrl = $reservation->downPayment?->img_proof
            ? asset('storage/' . $reservation->downPayment->img_proof)
            : null;

        $reservation->downpayment_status = $reservation->downPayment->status ?? null;
    });

        return view('admin.vendor.remainingbal', compact('reservations'));
    }
    
    public function view_history()
    {
        $vendor = auth('admin')->user();

        $reservations = Reservation::with([
                'customer',
                'reservedAmenities.amenity',
                'bill.balance',
                'downPayment'
            ])
            ->get();

        $reservations->each(function ($reservation) {
            $bill = $reservation->bill;

            $grandTotal = optional($bill)->grand_total ?? 0;

            // Sum only verified down payments
            $paidAmount = DownPayment::where('res_num', $reservation->id)
                            ->where('status', 'verified')
                            ->sum('amount');

            $reservation->paidAmount = $paidAmount;
            $reservation->grandTotal = $grandTotal;

            $reservation->balance = $grandTotal - $paidAmount;
        });

        // Group reservations
        $pendingReservations = $reservations->where('status', 'pending');
        $cancelledReservations = $reservations->where('status', 'cancelled');
        $completedReservations = $reservations->where('status', 'completed');
        $verifiedReservations = $reservations->where('status', 'verified');
        $invalidReservations = $reservations->where('status', 'invalid');

        $currentReservations = $pendingReservations->merge($verifiedReservations);

        return view('admin.vendor.reservations.reservation_records', compact(
            'pendingReservations',
            'cancelledReservations',
            'completedReservations',
            'verifiedReservations',
            'invalidReservations',
            'currentReservations',
            'reservations'
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
            $reservations = Reservation::with(['customer', 'reservedAmenities.amenity', 'bill', 'downPayment'])
                ->where(function ($query) {
                    $query->whereHas('bill', function ($q) {
                        $q->where('status', 'partially paid');
                    })
                    ->orWhereHas('downPayment');
                })
                ->get();
    
            $events = $reservations->map(function ($reservation) {
                $statusColors = [
                    'verified' => ['bg' => '#16a34a', 'border' => '#15803d'],
                    'pending' => ['bg' => '#ca8a04', 'border' => '#a16207'],
                    'cancelled' => ['bg' => '#dc2626', 'border' => '#b91c1c'],
                    'invalid' => ['bg' => '#dc2626', 'border' => '#b91c1c'],
                    'completed' => ['bg' => '#64748b', 'border' => '#475569']
                ];
    
                $status = strtolower($reservation->status);
                $color = $statusColors[$status] ?? ['bg' => '#3b82f6', 'border' => '#1e40af'];
    
                $paidAmount = DownPayment::where('res_num', $reservation->id)
                            ->whereIn('status', ['verified'])
                            ->sum('amount');
    
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
                        'bill_id' => $reservation->bill->id ?? null,
                        'bill_status' => $reservation->bill->status ?? null,
                        'total' => $reservation->bill->grand_total ?? 0,
                        'paid_amount' => $paidAmount,
                        'downpayment' => ($reservation->bill->grand_total ?? 0) * 0.5,
                        'downpayment_status' => $reservation->downPayment->status ?? null,
                        'downpayment_image' => $reservation->downPayment->img_proof ? asset('storage/' . $reservation->downPayment->img_proof) : null,
                        'ref_num' => $reservation->downPayment->ref_num ?? 'N/A',
                    ]
                ];
            });
    
            return response()->json($events);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing the request.', 'details' => $e->getMessage()], 500);
        }
    }
    

    
}
