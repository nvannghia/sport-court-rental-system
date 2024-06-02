<?php
session_start();
use App\Services\UserServiceInterface;
use App\Utils\sendOTPViaSMS;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;

class UserController extends Controller
{
    private const ROLES = ['CUSTOMER', 'VenueOwner', "SystemAdmin"];

    protected $userServiceInterface;

    protected $sendOTPViaSMS;

    public function __construct(UserServiceInterface $userServiceInterface, sendOTPViaSMS $sendOTPViaSMS)
    {
        $this->userServiceInterface = $userServiceInterface;
        $this->sendOTPViaSMS = $sendOTPViaSMS;
    }


    public function index()
    {
        $data = $this->userServiceInterface->getAllUser();
        $this->view('user/index', $data);
    }

    public function userDetail($id)
    {
        $user = $this->userServiceInterface->getUserById($id);
        if ($user) {
            $this->view('user/index', $user->toArray());
        } else
            echo "Not found user with id: $id";
    }


    // function sendSMS($number, $message)
    // {
    //     $baseUrl = "https://qyxygw.api.infobip.com";
    //     $apiKey = "bef7a48e44e9c8eb23e0a27ebd211784-3175224a-3d8d-42c5-bd4b-bf4fc4b02d64";

    //     $configuration = new Configuration(host: $baseUrl, apiKey: $apiKey);

    //     $api = new SmsApi(config: $configuration);

    //     $destination = new SmsDestination(to: $number);

    //     $message = new SmsTextualMessage(
    //         destinations: [$destination],
    //         text: $message
    //     );

    //     $request = new SmsAdvancedTextualRequest(
    //         messages: [$message]
    //     );

    //     $response = $api->sendSmsMessage($request);
    // }

    // Hàm lưu mã OTP vào cơ sở dữ liệu
    // function saveOTP($phoneNumber, $otp)
    // {
    //     $_SESSION[$phoneNumber] = $otp;
    // }

    // function getOTP($phoneNumber)
    // {
    //     return $_SESSION[$phoneNumber];
    // }

    // function verifyOTP($phoneNumber, $otp)
    // {
    //     $otpSaved = $this->getOTP($phoneNumber);
    //     return $otpSaved == $otp;
    // }

    function verifyOTPandSaveData()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'getOTP') {

            $otp = $this->sendOTPViaSMS->generateOTP();
            $this->sendOTPViaSMS->saveOTP($_POST['phoneNumber'], $otp); // tương ứng mỗi sdt sẽ có otp, được lưu trong session

            //save data for next request
            $_SESSION['username'] = $_POST['username'] ?? null;
            $_SESSION['password'] = $_POST['password'] ?? null;
            $_SESSION['fullname'] = $_POST['fullname'] ?? null;
            $_SESSION['phoneNumber'] = $_POST['phoneNumber'] ?? null;

            

            $receiveNumber = $_POST['phoneNumber'];
            $message = "Your OTP code is: " .  $otp;
            $this->sendOTPViaSMS->sendSMS($receiveNumber, $message);

            echo json_encode([
                "status" => 'success',
            ]);

            return;
        }

        if (isset($_POST['action']) && $_POST['action'] == 'verifyOTP') {

            $otp = $_POST['otp'] ?? null;
            
            if ($this->sendOTPViaSMS->verifyOTP($_SESSION['phoneNumber'], $otp)) {

                $this->create();

                echo json_encode([
                    "statusCode" => 201,
                    "message" => "User Created Successfully"
                ]);
    
                return;
            }

            echo json_encode([
                "statusCode" => 500,
                "message" => "User failed"
            ]);
        }
    }

    // function generateOTP($length = 6)
    // {
    //     $otp = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $otp .= mt_rand(0, 9); // Tạo ngẫu nhiên một chữ số từ 0 đến 9 và thêm vào chuỗi OTP
    //     }
    //     return $otp;
    // }

    public function create()
    {
        $fullname = $_SESSION['fullname'] ?? null;
        $username = $_SESSION['username'] ?? null;
        $password = $_SESSION['password'] ?? null;

        $isInvalidInfo = !empty($fullname) && !empty($username)  && !empty($password);
        if (!$isInvalidInfo) {
            echo json_encode([
                "errorMessage" => "Please enter all information in the form!",
            ]);
            return;
        }

        return $this->userServiceInterface->create([
            'fullname' => $fullname,
            'username' => $username,
            'password' =>  password_hash($password, PASSWORD_BCRYPT),
            'role' => self::ROLES[0],
        ]);
    }
}
