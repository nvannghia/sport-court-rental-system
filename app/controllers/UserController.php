<?php
session_start();

use App\Services\UserServiceInterface;
use App\Utils\sendOTPViaSMS;


class UserController extends Controller
{
    private const ROLES = ["CUSTOMER", "OWNER" ,"SYSTEMADMIN"];

    protected $userServiceInterface;

    protected $sendOTPViaSMS;

    public function __construct(UserServiceInterface $userServiceInterface, sendOTPViaSMS $sendOTPViaSMS)
    {
        $this->userServiceInterface = $userServiceInterface;
        $this->sendOTPViaSMS = $sendOTPViaSMS;
    }

    function verifyOTPandSaveData()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'getOTP') {

            // if username already exits, prevent create
            if (isset($_POST['username'])) {
                $user = $this->userServiceInterface->findByUsername($_POST['username']);
                if ($user) {
                    echo json_encode([
                        "statusCode" => 409,
                        "usernameExisted" => $_POST['username'],
                        "message" => "Username already exists"
                    ]);
                    return;
                }
            }

            $otp = $this->sendOTPViaSMS->generateOTP();
            $this->sendOTPViaSMS->saveOTP($_POST['phoneNumber'], $otp); // tương ứng mỗi sdt sẽ có otp, được lưu trong session

            //save data for next request
            $_SESSION['fullname'] = $_POST['fullname'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
            $_SESSION['address'] = $_POST['address'];

            $receiveNumber = $_POST['phoneNumber'];
            $message = "Your OTP code is: " .  $otp;
            $isPending = $this->sendOTPViaSMS->sendSMS($receiveNumber, $message);

            if ($isPending)
                echo json_encode([
                    "status" => 'success',
                    "session" => $_SESSION
                ]);
            else
                echo json_encode([
                    "status" => 'failed',
                ]);
            return;
        }

        if (isset($_POST['action']) && $_POST['action'] == 'verifyOTP') {

            $otp = $_POST['otp'] ?? null;

            if ($this->sendOTPViaSMS->verifyOTP($_SESSION['phoneNumber'], $otp)) {

                $user = $this->create();
                if ($user->wasRecentlyCreated) {

                    echo json_encode([
                        "statusCode" => 201,
                        "message" => "User Created Successfully"
                    ]);
                    //clear sesssion
                    $_SESSION = array();
                    return;
                } else {
                    echo json_encode([
                        "statusCode" => 409,
                        "message" => "Resource with username:" . $_SESSION['username'] .  " already exists"
                    ]);
                    return;
                }
            }

            echo json_encode([
                "statusCode" => 500,
                "message" => "Server Internal Error"
            ]);
        }
    }

    public function create()
    {
        $fullname = $_SESSION['fullname'] ?? null;
        $username = $_SESSION['username'] ?? null;
        $password = $_SESSION['password'] ?? null;
        $phoneNumber = $_SESSION['phoneNumber'] ?? null;
        $address = $_SESSION['address'] ?? null;

        $isInvalidInfo = !empty($fullname) && !empty($username)
            && !empty($password) && !empty($phoneNumber)
            && !empty($address);

        if (!$isInvalidInfo) {
            echo json_encode([
                "errorMessage" => "Please enter all information in the form!",
            ]);
            return;
        }

        return $this->userServiceInterface->create(
            ["Username" => $username], //if exits username throw exception
            [
                'Role' => self::ROLES[0],
                'FullName' => $fullname,
                'Username' => $username,
                'Password' => password_hash($password, PASSWORD_BCRYPT),
                'PhoneNumber' => $phoneNumber,
                'Address' => $address,
            ]
        );
    }

    public function login()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'login') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            
            $isValidCredentials =  !empty($username) && !empty($password);

            if (!$isValidCredentials) {
                echo json_encode([
                    "errorMessage" => "Please enter all information in the form!",
                ]);
                return;
            }

            $user = $this->userServiceInterface->findByUsername($username);

            if ($user) {
                if (password_verify($password, $user['Password'])) {

                    unset($user['Password']); // no return password

                    $_SESSION['userInfo'] = $user; //save user logged to session

                    echo json_encode([
                        "statusCode" => 200,
                        "user" => $user
                    ]);

                    return;
                } else {

                    echo json_encode([
                        "statusCode" => 401,
                        "message" => "Invalid credentials"
                    ]);

                    return;
                }
            } else {
                echo json_encode([
                    "statusCode" => 401,
                    "message" => "Invalid credentials"
                ]);
                return;
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['userInfo'])){

            session_destroy();

            echo json_encode([
                "statusCode" => 200,
                "message" => "Logout Success"
            ]);
        }
    }

    public function getProfile()
    {
        return $this->view('profile/profile', $_SESSION['userInfo']);
    }
}
