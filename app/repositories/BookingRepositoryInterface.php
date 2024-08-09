<?php

namespace App\Repositories;

interface BookingRepositoryInterface
{
    public function createBooking(array $attributesCheck,array $data);

    public function getBookingByUserID($userID);
}
