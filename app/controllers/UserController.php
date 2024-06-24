<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\SportField;
use App\Models\UserModel;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;
use App\Services\UserServiceInterface;
use App\Utils\SendMessageViaSMS;

class UserController extends Controller
{
    private const ROLES = ["CUSTOMER", "OWNER", "SYSTEMADMIN"];

    protected $userServiceInterface;

    protected $sendMessageViaSMS;

    protected $sportTypeServiceInterface;

    protected $sportFieldServiceInterface;

    public function __construct(
        UserServiceInterface $userServiceInterface,
        SendMessageViaSMS $sendMessageViaSMS,
        SportTypeServiceInterface $sportTypeServiceInterface,
        SportFieldServiceInterface $sportFieldServiceInterface
    ) {
        $this->userServiceInterface = $userServiceInterface;
        $this->sendMessageViaSMS = $sendMessageViaSMS;
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
    }

    public function fetch()
    {

        echo "<pre>";
        print_r($this->sportFieldServiceInterface->getSportFieldByOwnerID(13)->toArray());
        echo "</pre>";
       
        // var_dump(SportField::find(13)->sportType->TypeName);

    }

    function verifyOTPandSaveData()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'getOTP') {

            // if email already exits, prevent create
            if (isset($_POST['email'])) {
                $user = $this->userServiceInterface->findByEmail($_POST['email']);
                if ($user) {
                    echo json_encode([
                        "statusCode" => 409,
                        "emailExisted" => $_POST['email'],
                        "message" => "Email already exists"
                    ]);
                    return;
                }
            }

            $otp = $this->sendMessageViaSMS->generateOTP();
            $this->sendMessageViaSMS->saveOTP($_POST['phoneNumber'], $otp); // tương ứng mỗi sdt sẽ có otp, được lưu trong session

            //save data for next request
            $_SESSION['fullname'] = $_POST['fullname'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
            $_SESSION['address'] = $_POST['address'];

            $receiveNumber = $_POST['phoneNumber'];
            $message = "Your OTP code is: " .  $otp;
            $isPending = $this->sendMessageViaSMS->sendSMS($receiveNumber, $message);

            if ($isPending)
                echo json_encode([
                    "status" => 'success',
                ]);
            else
                echo json_encode([
                    "status" => 'failed',
                ]);
            return;
        }

        if (isset($_POST['action']) && $_POST['action'] == 'verifyOTP') {

            $otp = $_POST['otp'] ?? null;

            if ($this->sendMessageViaSMS->verifyOTP($_SESSION['phoneNumber'], $otp)) {

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
                        "message" => "Resource with email:" . $_SESSION['email'] .  " already exists"
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
        $email = $_SESSION['email'] ?? null;
        $password = $_SESSION['password'] ?? null;
        $phoneNumber = $_SESSION['phoneNumber'] ?? null;
        $address = $_SESSION['address'] ?? null;

        $isInvalidInfo = !empty($fullname) && !empty($email)
            && !empty($password) && !empty($phoneNumber)
            && !empty($address);

        if (!$isInvalidInfo) {
            echo json_encode([
                "errorMessage" => "Please enter all information in the form!",
            ]);
            return;
        }

        return $this->userServiceInterface->create(
            ["Email" => $email], //if exits Email throw exception
            [
                'Role' => self::ROLES[0],
                'FullName' => $fullname,
                'Email' => $email,
                'Password' => password_hash($password, PASSWORD_BCRYPT),
                'PhoneNumber' => $phoneNumber,
                'Address' => $address,
            ]
        );
    }

    public function login()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'login') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            $isValidCredentials =  !empty($email) && !empty($password);

            if (!$isValidCredentials) {
                echo json_encode([
                    "errorMessage" => "Please enter all information in the form!",
                ]);
                return;
            }

            $user = $this->userServiceInterface->findByEmail($email);

            if ($user) {
                if (password_verify($password, $user['Password'])) {

                    unset($user['Password']); // no return password

                    if ($user->fieldOwner)
                        $_SESSION['userInfo'] = array_merge($user->toArray(), $user->fieldOwner->toArray()); //save user logged to session
                    else
                        $_SESSION['userInfo'] = $user->toArray(); //save user logged to session

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
        if (isset($_SESSION['userInfo'])) {

            session_destroy();

            echo json_encode([
                "statusCode" => 200,
                "message" => "Logout Success"
            ]);
        }
    }

    public function getProfile()
    {
        if ($_SESSION['userInfo']['Role'] === "CUSTOMER")
            return $this->view('user/profile', []);

        $sportTypes = $this->sportTypeServiceInterface->getAllSportTypes()->toArray();
        $ownerID = $_SESSION['userInfo']['OwnerID'];
        $sportFields = $this->sportFieldServiceInterface->getSportFieldByOwnerID($ownerID)->toArray();
        if (isset($_SESSION['userInfo']))
            return $this->view('user/profile', [
                'sportTypes' => $sportTypes,
                'sportFields' => $sportFields
            ]);

        echo "<h1 style='color:red'> Vui lòng đăng nhập </h1>";
    }
}
