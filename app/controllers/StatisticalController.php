<?php

use App\Services\BookingServiceInterface;
use App\Services\SportFieldServiceInterface;
use App\Services\StatisticsServiceInterface;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class StatisticalController extends Controller
{
    private $sportFieldServiceInterface;

    private $bookingServiceInterface;

    private $statisticsServiceInterface;

    public function __construct(
        SportFieldServiceInterface $sportFieldServiceInterface,
        BookingServiceInterface $bookingServiceInterface,
        StatisticsServiceInterface $statisticsServiceInterface
    ) {
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
        $this->bookingServiceInterface = $bookingServiceInterface;
        $this->statisticsServiceInterface = $statisticsServiceInterface;
    }

    public function getOwnerOfSportField()
    {
        $ownerID = $_SESSION['userInfo']['ID'] ?? null;
        $userRole = $_SESSION['userInfo']['Role'] ?? null;
        if ($userRole == 'OWNER' && $ownerID) {
            $sportFields = $this->sportFieldServiceInterface->getSportFieldByOwnerID($ownerID)->toArray();
            //get statistics
            $statistics = $this->getStatistics();
            return $this->view('statistical/show_sport_field', [
                'sportFields' => $sportFields,
                ...$statistics
            ]);
        }
        return "401 Unauthorized!";
    }

    public function getBookingOfSportField($sportFieldID)
    {
        if ($sportFieldID && is_numeric($sportFieldID)) {
            $bookings = $this->bookingServiceInterface->getBookingBySportFieldID($sportFieldID)->toArray();

            // format date booking, date rental, total amount
            foreach ($bookings as $bookingKey => $bookingValue) {
                // format date booking, date rental, total amount
                $date = new DateTime($bookingValue['created_at']);
                $formattedDateCreatedAt = $date->format('d/m/Y');

                $date = new DateTime($bookingValue['BookingDate']);
                $formattedBookingDate = $date->format('d/m/Y');

                $startTime = $bookingValue['StartTime'];
                $rentalDuration = $bookingValue['EndTime']; //rental: 1,1.5,2 hours
                $priceDay = $bookingValue['sport_field']['PriceDay'];
                $priceEvening = $bookingValue['sport_field']['PriceEvening'];
                $pricePerHour = $startTime < 17 ? $priceDay : $priceEvening;
                $totalAmount = $rentalDuration * $pricePerHour;
                //replace date booking, date rental, total amount for each booking
                $bookings[$bookingKey]['BookingDate'] = $formattedBookingDate;
                $bookings[$bookingKey]['created_at'] = $formattedDateCreatedAt;
                $bookings[$bookingKey]['TotalAmount'] = $totalAmount;
            }

            return $this->view('statistical/show_sport_field_booking', [
                'bookings' => $bookings
            ]);
        }

        return "400 Bad Request!";
    }

    public function getStatistics()
    {
        $ownerID = $_SESSION['userInfo']['ID'] ?? null;
        if ($ownerID) {
            $results = $this->statisticsServiceInterface->getPaidBookingsStatistics($ownerID);
            $bookingUnpaidCount = $this->statisticsServiceInterface->getUnpaidBookingsStatistics($ownerID)->CountUnpaidBookings;

            $totalRevenue = $results->TotalRevenue;
            $bookingPaidCount = $results->CountPaidBookings;

            return [
                'totalRevenue' => $totalRevenue,
                'bookingPaidCount' => $bookingPaidCount,
                'bookingUnpaidCount' => $bookingUnpaidCount,
            ];
        }
        return "400 Bad Request!";
    }

    function test ()
    {
        $ownerID = $_SESSION['userInfo']['ID'] ?? null;
        var_dump($this->statisticsServiceInterface->getUnpaidBookingsStatistics($ownerID));
    }
}
