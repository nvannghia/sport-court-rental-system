<?php

namespace App\Services;

interface BookingServiceInterface
{
    public function createBooking(array $attributesCheck,array $data);

    public function updateBookingStatus($bookingID);

    public function getBookingByUserID($userID);

    public function getBookingBySportFieldID($sportField);
}
