<?php

namespace App\Repositories;

interface BookingRepositoryInterface
{
    public function createBooking(array $attributesCheck,array $data);

    public function updateBookingStatus($bookingID);

    public function getBookingByUserID($userID);

    public function getBookingBySportFieldID($sportFieldID);
}
