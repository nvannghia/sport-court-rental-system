<?php

namespace App\Services;

interface BookingServiceInterface
{
    public function createBooking(array $attributesCheck,array $data);

    public function getBookingByUserID($userID);
}
