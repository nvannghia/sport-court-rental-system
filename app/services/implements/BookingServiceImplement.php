<?php

namespace App\Services\Implements;

use App\Repositories\BookingRepositoryInterface;
use App\Services\BookingServiceInterface;

class BookingServiceImplement implements BookingServiceInterface
{
    private $bookingRepositoryInterface;

    function __construct(BookingRepositoryInterface $bookingRepositoryInterface)
    {
        $this->bookingRepositoryInterface = $bookingRepositoryInterface;
    }

    public function createBooking(array $attributesCheck,array $data)
    {
        return $this->bookingRepositoryInterface->createBooking($attributesCheck ,$data);
    }

    public function updateBookingStatus($bookingID)
    {
        return $this->bookingRepositoryInterface->updateBookingStatus($bookingID);
    }

    public function getBookingByUserID($userID)
    {
        return $this->bookingRepositoryInterface->getBookingByUserID($userID);
    }

    public function getBookingBySportFieldID($sportField)
    {
        return $this->bookingRepositoryInterface->getBookingBySportFieldID($sportField);
    }
}
