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

    public function getBookingBySportFieldID($sportFieldID, $ownerID)
    {
        return Booking::with(['sportField', 'invoice'])
            ->whereHas('sportField', function ($query) use ($ownerID) {
                $query->where('OwnerID', $ownerID);
            })
            ->where('SportFieldID', $sportFieldID)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBookingBySportFieldIDWithFilter($sportFieldID, $ownerID, $filter)
    {
        if ($filter == "PAID")
            return Booking::with(['sportField', 'invoice'])
                ->whereHas('sportField', function ($query) use ($ownerID) {
                    $query->where('OwnerID', $ownerID);
                })
                ->where('SportFieldID', $sportFieldID)
                ->where('PaymentStatus', 'PAID')
                ->orderBy('created_at', 'desc')
                ->get();
        else
            return Booking::with(['sportField', 'invoice'])
                ->whereHas('sportField', function ($query) use ($ownerID) {
                    $query->where('OwnerID', $ownerID);
                })
                ->where('SportFieldID', $sportFieldID)
                ->where('PaymentStatus', 'UNPAID')
                ->orderBy('created_at', 'desc')
                ->get();
    }
}
