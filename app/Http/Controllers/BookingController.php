<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Booking;
use App\Models\Seat;
use App\Models\BookedSeat;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to book seats.',
            ], 401);
        }

        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        try {
            DB::beginTransaction();

            $show = Show::findOrFail($request->show_id);
            $totalPrice = count($request->seat_ids) * $show->price;

            // Check seat availability
            foreach ($request->seat_ids as $seatId) {
                $seat = Seat::find($seatId);
                if (!$seat || !$seat->is_available) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'One or more seats are already booked.',
                    ], 400);
                }
            }

            // Create booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'show_id' => $show->id,
                'total_price' => $totalPrice,
                'booking_date' => now(),
            ]);

            // Create booked seats
            foreach ($request->seat_ids as $seatId) {
                BookedSeat::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seatId,
                    'show_id' => $show->id,  // Add the show_id here
                ]);

                // Update seat availability
                Seat::where('id', $seatId)
                    ->update(['is_available' => false]);
            }

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method ?? 'credit_card',
                'transaction_id' => uniqid('TRX'),
                'amount' => $totalPrice,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully!',
                'booking' => $booking,
                'payment' => $payment,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Booking failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Booking failed. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function myBookings()
        {
            $bookings = Booking::with(['show.movie', 'bookedSeats.seat'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($bookings);
            
        }
}