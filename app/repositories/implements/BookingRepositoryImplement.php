<?php

namespace App\Repositories\Implements;

use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;

class BookingRepositoryImplement implements BookingRepositoryInterface
{
    public function createBooking(array $attributesCheck,array $data)
    {
        return Booking::firstOrCreate($attributesCheck ,$data);
    }

    public function getBookingByUserID($userID)
    {
        return Booking::with('sportField')->where('CustomerID', $userID)->orderBy('created_at', 'desc')->get();
    }
}
