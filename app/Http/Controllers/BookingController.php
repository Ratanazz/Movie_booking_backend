<?php
namespace App\Http\Controllers;
use App\Models\Show;
use App\Models\Booking;
use App\Models\BookedSeat;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show($showId)
    {
        $show = Show::with(['movie', 'screen'])->findOrFail($showId);
        $availableSeats = $show->getAvailableSeats();
        
        return view('bookings.create', compact('show', 'availableSeats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        try {
            DB::beginTransaction();

            $show = Show::findOrFail($request->show_id);
            $totalPrice = count($request->seat_ids) * $show->price;

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
                ]);
            }

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method ?? 'credit_card',
                'transaction_id' => uniqid('TRX'),
            ]);

            DB::commit();

            return redirect()->route('bookings.success', $booking->id)
                           ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed. Please try again.');
        }
    }
}