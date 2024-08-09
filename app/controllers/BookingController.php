<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\BookingServiceInterface;
use App\Services\SportFieldServiceInterface;

class BookingController extends Controller
{
    private $bookingServiceInterface;

    private $sportFieldServiceInterface;

    function __construct(
        BookingServiceInterface $bookingServiceInterface,
        SportFieldServiceInterface $sportFieldServiceInterface
    ) {
        $this->bookingServiceInterface = $bookingServiceInterface;
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
    }

    public function test()
    {
        $userID = isset($_SESSION['userInfo']['ID']) ? $_SESSION['userInfo']['ID'] : false;
        echo "<pre>";
        print_r($this->bookingServiceInterface->getBookingByUserID($userID)->toArray());
        echo "</pre>";
    }

    public function showBooking()
    {
        $userID = isset($_SESSION['userInfo']['ID']) ? $_SESSION['userInfo']['ID'] : false;
        if ($userID) {
            $bookings = $this->bookingServiceInterface->getBookingByUserID($userID)->toArray();
            return $this->view('booking/show_booking', ['bookings' => $bookings]);
        } else {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Bad Request!'
            ]);
        }
    }

    public function fieldSchedule($sportFieldID)
    {
        $sportField = $this->sportFieldServiceInterface->getSportFieldByID($sportFieldID);
        return $this->view('booking/field_schedule', ['sportField' => $sportField]);
    }

    public function bookingDetail($sportFieldID)
    {
        $sportField = $this->sportFieldServiceInterface->getSportFieldByID($sportFieldID);
        $bookingDate = isset($_GET['bookingDate']) ? $_GET['bookingDate'] : null;
        $fieldNumber = isset($_GET['fieldNumber']) ? $_GET['fieldNumber'] : null;
        $startTime = isset($_GET['startTime']) ? $_GET['startTime'] : null;


        $isValidInfo = isset($bookingDate) && isset($fieldNumber) && isset($startTime);

        if ($isValidInfo) {
            return $this->view('booking/booking_detail', [
                'sportField' => $sportField,
                'bookingDate' => $bookingDate,
                'fieldNumber' => $fieldNumber,
                'startTime' => $startTime,
            ]);
        }

        return $this->view('404');
    }

    public function createBooking()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === "createBooking") {
            $sportFieldID = isset($_POST['sportFieldID']) ? $_POST['sportFieldID'] : '';
            $fieldNumber = isset($_POST['fieldNumber']) ? $_POST['fieldNumber'] : '';
            $customerName = isset($_POST['customerName']) ? $_POST['customerName'] : '';
            $customerPhone = isset($_POST['customerPhone']) ? $_POST['customerPhone'] : '';
            $customerEmail = isset($_POST['customerEmail']) ? $_POST['customerEmail'] : '';
            $startTime = isset($_POST['startTime']) ? $_POST['startTime'] : '';
            $endTime = isset($_POST['endTime']) ? $_POST['endTime'] : '';
            $bookingDate = isset($_POST['bookingDate']) ? $_POST['bookingDate'] : '';
            $userID = $_SESSION['userInfo']['ID'];

            // Kiểm tra empty và in ra thông báo nếu có trường nào rỗng
            $isValidInfo = !empty($sportFieldID)
                && !empty($fieldNumber)
                && !empty($customerName)
                && !empty($customerPhone)
                && !empty($customerEmail)
                && is_numeric($startTime) && (int)$startTime >= 0
                && !empty($endTime)
                && !empty($bookingDate)
                && !empty($userID);

            if ($isValidInfo) {
                $booking = $this->bookingServiceInterface->createBooking(
                    [
                        'FieldNumber' => $fieldNumber,
                        'StartTime' => $startTime,
                        'BookingDate' => $bookingDate,
                    ],
                    [
                        'SportFieldID' => $sportFieldID,
                        'FieldNumber' => $fieldNumber,
                        'CustomerID' => $userID,
                        'CustomerName' => $customerName,
                        'CustomerPhone' => $customerPhone,
                        'CustomerEmail' => $customerEmail,
                        'StartTime' => $startTime,
                        'EndTime' => $endTime,
                        'BookingDate' => $bookingDate,
                    ]
                );

                if ($booking->wasRecentlyCreated) {
                    echo json_encode([
                        'statusCode' => 200,
                        'message' => 'Booking created successfully!'
                    ]);
                } else {
                    echo json_encode([
                        'statusCode' => 409,
                        'message' => 'Booking Conflict!'
                    ]);
                }
                return;
            } else {
                echo json_encode([
                    'statusCode' => 400,
                    'message' => 'Bad Request!'
                ]);
                return;
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Bad Request!'
            ]);
        }
    }
}
