<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(int $id)
    {
        $trip = Trip::where('id', $id)->where('is_active', true)->firstOrFail();
        return view('trips.booking', compact('trip'));
    }

    public function store(Request $request, int $id)
    {
        $trip = Trip::where('id', $id)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'phone'          => 'required|string|max:20',
            'adults'         => 'required|integer|min:1|max:10',
            'children'       => 'required|integer|min:0|max:10',
            'travel_date'    => 'required|date',
            'payment_method' => 'required|in:credit_card,visa,meeza,instapay,vodafone_cash',
            'notes'          => 'nullable|string|max:500',
        ]);

        $ref = strtoupper('BK-' . date('Ymd') . '-' . substr(md5(uniqid()), 0, 6));

        $totalPrice = $trip->price * ($validated['adults'] + ($validated['children'] * 0.5));

        $booking = Booking::create([
            'trip_id'        => $trip->id,
            'reference'      => $ref,
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'],
            'adults'         => $validated['adults'],
            'children'       => $validated['children'],
            'travel_date'    => $validated['travel_date'],
            'payment_method' => $validated['payment_method'],
            'total_price'    => $totalPrice,
            'notes'          => $validated['notes'] ?? null,
            'status'         => 'pending',
        ]);

        if ($trip->spots_left > 0) {
            $trip->decrement('spots_left');
        }

        session(['booking_ref' => $ref, 'booking_id' => $booking->id]);

        return redirect()->route('trips.book.confirmed', $id);
    }

    public function confirmed(Request $request, int $id)
    {
        $trip    = Trip::where('id', $id)->firstOrFail();
        $bookingId = session('booking_id');

        if (!$bookingId) {
            return redirect()->route('trips.book', $id);
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return redirect()->route('trips.book', $id);
        }

        return view('trips.confirmed', compact('trip', 'booking'));
    }
}
