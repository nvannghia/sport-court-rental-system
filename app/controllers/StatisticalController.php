<?php

use App\Services\BookingServiceInterface;
use App\Services\FieldOwnerServiceInterface;
use App\Services\SportFieldServiceInterface;
use App\Services\StatisticsServiceInterface;

require_once realpath(dirname(__FILE__) . '/../utils/RemoveVietnameseAccents.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class StatisticalController extends Controller
{
    private $sportFieldServiceInterface;

    private $bookingServiceInterface;

    private $statisticsServiceInterface;

    private $fieldOwnerServiceInterface;

    public function __construct(
        SportFieldServiceInterface $sportFieldServiceInterface,
        BookingServiceInterface $bookingServiceInterface,
        StatisticsServiceInterface $statisticsServiceInterface,
        FieldOwnerServiceInterface $fieldOwnerServiceInterface
    ) {
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
        $this->bookingServiceInterface = $bookingServiceInterface;
        $this->statisticsServiceInterface = $statisticsServiceInterface;
        $this->fieldOwnerServiceInterface = $fieldOwnerServiceInterface;
    }

    public function fetchOwnerWithSportFields()
    {
        $ownerID = $_SESSION['userInfo']['ID'] ?? null;
        $userRole = $_SESSION['userInfo']['Role'] ?? null;
        if ($userRole == 'OWNER' && $ownerID) {
            $filter = $_GET['status'] ?? null;
            $filter = strtoupper($filter);
            if (!$filter || $filter == 'ALL')
                $sportFields = $this->sportFieldServiceInterface->getSportFieldByOwnerID('none' ,$ownerID)->toArray();
            else if ($filter == 'UNPAID') 
                $sportFields = $this->sportFieldServiceInterface->getSportFieldByOwnerIDWithFilter($ownerID, $filter)->toArray();
            else if ($filter == 'PAID')
                $sportFields = $this->sportFieldServiceInterface->getSportFieldByOwnerIDWithFilter($ownerID, $filter)->toArray();
            else
                die("Invalid Request!");

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
        $ownerID = $_SESSION['userInfo']['ID'] ?? null;
        if ($ownerID) {
            $fieldOwner = $this->fieldOwnerServiceInterface->getFieldOwnerByOwnerID($ownerID)->toArray();
            //remove Vietnamese Accents
            $fieldOwner['BusinessName'] = removeVietnameseAccents($fieldOwner['BusinessName']);
            $fieldOwner['BusinessAddress'] = removeVietnameseAccents($fieldOwner['BusinessAddress']);

            if ($sportFieldID && is_numeric($sportFieldID)) {

                $filter = $_GET['status'] ??  null;
                $filter = strtoupper($filter);
                
                if (!$filter || $filter == 'ALL') {
                    $bookings = $this->bookingServiceInterface->getBookingBySportFieldID($sportFieldID, $ownerID)->toArray();
                } else if ($filter == 'PAID')
                    $bookings = $this->bookingServiceInterface->getBookingBySportFieldIDWithFilter($sportFieldID, $ownerID, $filter)->toArray();
                else if ($filter == 'UNPAID')
                    $bookings = $this->bookingServiceInterface->getBookingBySportFieldIDWithFilter($sportFieldID, $ownerID, $filter)->toArray();
                else
                    die("Invalid Request!");

                //total amount revenue of each sport field
                $totalRevenue = 0;

                // format booking: date booking, date rental/ format invoice: payment date, totalAmount
                foreach ($bookings as $bookingKey => $bookingValue) {
                    // format date booking, date rental
                    $date = new DateTime($bookingValue['created_at']);
                    $formattedDateCreatedAt = $date->format('d/m/Y');

                    //format invoice payment date, total amount
                    if (isset($bookingValue['invoice'])) {
                        $date = new DateTime($bookingValue['invoice']['PaymentDate']);
                        $formattedInvoicePaymentDate = $date->format('d/m/Y');
                        $bookings[$bookingKey]['invoice']['PaymentDate'] = $formattedInvoicePaymentDate;
                        $bookings[$bookingKey]['invoice']['TotalAmount'] = number_format($bookingValue['invoice']['TotalAmount'], 0, '', '.');
                        $totalRevenue += (float)$bookingValue['invoice']['TotalAmount'];
                    }

                    $startTime = $bookingValue['StartTime'];
                    $rentalDuration = $bookingValue['EndTime']; //rental: 1,1.5,2 hours
                    $priceDay = $bookingValue['sport_field']['PriceDay'];
                    $priceEvening = $bookingValue['sport_field']['PriceEvening'];
                    $pricePerHour = $startTime < 17 ? $priceDay : $priceEvening;
                    $totalAmount = $rentalDuration * $pricePerHour;

                    $endTime = '';
                    switch ($bookingValue['EndTime']):
                        case 1:
                            $endTime = $bookingValue['StartTime'] + 1 . ':00';
                            break;
                        case 1.5:
                            $endTime = $bookingValue['StartTime'] + 1 . ':30';
                            break;
                        case 2:
                            $endTime = $bookingValue['StartTime'] + 2 . ':00';
                            break;
                        default:
                    endswitch;

                    $rentalHours = "$startTime - $endTime";
                    //replace date booking, date rental, rental hours, paymentdate for each booking
                    $bookings[$bookingKey]['created_at'] = $formattedDateCreatedAt;
                    $bookings[$bookingKey]['TotalAmount'] = $totalAmount;
                    $bookings[$bookingKey]['RentalHours'] = $rentalHours;
                }

                return $this->view('statistical/show_sport_field_booking', [
                    'bookings' => $bookings,
                    'totalRevenue' => number_format($totalRevenue, 0, '', '.'),
                    'businessInfo' => $fieldOwner
                ]);
            }
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
}
