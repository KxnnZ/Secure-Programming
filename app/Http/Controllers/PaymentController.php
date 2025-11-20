<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function select(Booking $booking)
    {
        // Ensure the booking belongs to the current user (or admin)
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('payments.select', compact('booking'));
    }

    public function process(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'method' => 'required|in:qris,debit',
        ]);

        // Placeholder: mark booking as paid and store chosen method
        $booking->update([
            'status' => 'paid',
            'payment_method' => $data['method'],
        ]);

        // In a real integration we'd verify payment with the gateway.
        return redirect()->route('bookings.index')->with('success', 'Payment completed using: ' . strtoupper($data['method']));
    }
}
