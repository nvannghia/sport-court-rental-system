<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\BookingServiceInterface;
use App\Services\InvoiceServiceInterface;

class InvoiceController extends Controller
{
    private $bookingServiceInterface;

    private $invoiceServiceInterface;

    function __construct(
        BookingServiceInterface $bookingServiceInterface,
        InvoiceServiceInterface $invoiceServiceInterface
    ) {
        $this->bookingServiceInterface = $bookingServiceInterface;
        $this->invoiceServiceInterface = $invoiceServiceInterface;
    }

    public function processPayment()
    {
        // Giả sử dữ liệu đã được nhận từ cổng thanh toán
        $bookingID = $_GET['bookingID'] ?? null;
        $amount = $_GET['amount'] ?? null;

        $isValidInfo = isset($bookingID) && isset($amount);
        if (!$isValidInfo) {
            die("Bad Request");
        }

        // URL của Controller muốn gửi dữ liệu đến
        $controllerUrl = "http://localhost/sport-court-rental-system/public/invoice/payInvoice";

        // Chuẩn bị dữ liệu cần gửi
        $postData = [
            'bookingID' => $bookingID,
            'amount' => $amount,
            'paymentOption' => 'momo'
        ];

        // Khởi tạo phiên cURL
        $ch = curl_init($controllerUrl);

        // Thiết lập các tùy chọn cho cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Thực hiện yêu cầu POST
        $response = curl_exec($ch);

        // Kiểm tra lỗi nếu có
        if ($response === false) {
            echo 'Lỗi: ' . curl_error($ch);
        } else {
            echo 'Yêu cầu POST thành công: ' . $response;
        }

        // Đóng kết nối cURL
        curl_close($ch);

        // // Tùy chọn: Chuyển hướng người dùng đến một trang khác sau khi xử lý xong
        header('Location: http://localhost/sport-court-rental-system/public/booking/showBooking');
        exit();
    }

    public function payInvoice()
    {
        if (!empty($_POST)) {
            $bookingID = $_POST['bookingID'] ?? null;
            $totalAmount = $_POST['amount'] ?? null;
            $paymentMethod = $_POST['paymentOption'] ?? null;
            $isValidInfo = isset($bookingID) && isset($totalAmount) &&  isset($paymentMethod);
            if ($isValidInfo) {
                $invoice = $this->invoiceServiceInterface->createInvoice([
                    'BookingID' => $bookingID,
                    'TotalAmount' => $totalAmount,
                    'PaymentMethod' => $paymentMethod
                ]);

                if ($invoice) {
                    $isUpdated = $this->bookingServiceInterface->updateBookingStatus($invoice->BookingID);
                    if ($isUpdated) {
                        echo json_encode(['status' => 'success']);
                    } else {
                        echo "Server Internal Error! 1";
                        return;
                    }
                } else {
                    echo "Server Internal Error! 2";
                    return;
                }
            } else {
                echo "Bad Request! 3 ";
                return;
            }
        } else {
            echo "Bad Request! 4";
            return;
        }
    }

    public function test()
    {
        $invoice = $this->invoiceServiceInterface->getInvoiceByBookingID(54);
        var_dump($invoice);
    }

    public function getInvoiceOfBooking($bookingID)
    {
        if ($bookingID) {
            $invoice = $this->invoiceServiceInterface->getInvoiceByBookingID($bookingID);
            if ($invoice) {
                //format payment date and total amount
                $date = new DateTime($invoice['PaymentDate']);
                $formattedPaymentDate = $date->format('d/m/Y');
                $invoice->PaymentDate = $formattedPaymentDate;
                $invoice->TotalAmount = number_format($invoice->TotalAmount, 0, '', '.'); 

                echo json_encode([
                    'statusCode' => 200,
                    'status' => 'success',
                    'invoice' => $invoice
                ]);
            } else {
                echo json_encode([
                    'statusCode' => 404,
                    'status' => 'error',
                    'message' => 'No invoice found for bookingID ' . $bookingID
                ]);
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                'status' => 'error',
                'message' => 'Bad Request'
            ]);
        }
    }
}
