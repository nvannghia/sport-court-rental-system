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

    public function getBookingBySportFieldID($sportField, $ownerID)
    {
        return $this->bookingRepositoryInterface->getBookingBySportFieldID($sportField, $ownerID);
    }

    public function getBookingBySportFieldIDWithFilter($sportFieldID, $ownerID, $filter)
    {
        return $this->bookingRepositoryInterface->getBookingBySportFieldIDWithFilter($sportFieldID, $ownerID, $filter);
    }
}
