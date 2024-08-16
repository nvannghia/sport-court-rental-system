<?php

namespace App\Repositories\Implements;

use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;

class BookingRepositoryImplement implements BookingRepositoryInterface
{
    public function createBooking(array $attributesCheck, array $data)
    {
        return Booking::firstOrCreate($attributesCheck, $data);
    }

    public function updateBookingStatus($bookingID)
    {
        $booking = Booking::find($bookingID);
        if ($booking) {
            $booking->PaymentStatus = 'PAID';
            $booking->save();
            return $booking->refresh();
        }

        return false;
    }

    public function getBookingByUserID($userID)
    {
        return Booking::with('sportField')->where('CustomerID', $userID)->orderBy('created_at', 'desc')->get();
    }

    public function getBookingBySportFieldID($sportFieldID)
    {
        return Booking::with('sportField')
                        ->where('SportFieldID', $sportFieldID)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }
}
