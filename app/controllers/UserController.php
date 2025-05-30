<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;
use App\Services\UserServiceInterface;
use App\Utils\CaptchaUtils;
use App\Utils\SendMessageViaSMS;
use App\Utils\CloudinaryService;

class UserController extends Controller
{
    private const ROLES = ["CUSTOMER", "OWNER", "SYSTEMADMIN"];

    private $userServiceInterface;

    private $sendMessageViaSMS;

    private $sportTypeServiceInterface;

    private $sportFieldServiceInterface;

    private $cloudinaryService;

    private const ITEM_PER_PAGE_OWNER = 3;

    public function __construct(
        UserServiceInterface $userServiceInterface,
        SendMessageViaSMS $sendMessageViaSMS,
        SportTypeServiceInterface $sportTypeServiceInterface,
        SportFieldServiceInterface $sportFieldServiceInterface,
        CloudinaryService $cloudinaryService
    ) {
        $this->userServiceInterface = $userServiceInterface;
        $this->sendMessageViaSMS = $sendMessageViaSMS;
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
        $this->cloudinaryService = $cloudinaryService;
    }

    // old function for register by OTP    
    // function verifyOTPandSaveData()
    // {
    //     if (isset($_POST['action']) && $_POST['action'] == 'getOTP') {

    //         // if email already exits, prevent create
    //         if (isset($_POST['email'])) {
    //             $user = $this->userServiceInterface->findByEmail($_POST['email']);
    //             if ($user) {
    //                 echo json_encode([
    //                     "statusCode" => 409,
    //                     "emailExisted" => $_POST['email'],
    //                     "message" => "Email already exists"
    //                 ]);
    //                 return;
    //             }
    //         }

    //         $otp = $this->sendMessageViaSMS->generateOTP();
    //         $this->sendMessageViaSMS->saveOTP($_POST['phoneNumber'], $otp); // tương ứng mỗi sdt sẽ có otp, được lưu trong session

    //         //save data for next request
    //         $_SESSION['fullname'] = $_POST['fullname'];
    //         $_SESSION['email'] = $_POST['email'];
    //         $_SESSION['password'] = $_POST['password'];
    //         $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
    //         $_SESSION['address'] = $_POST['address'];

    //         $receiveNumber = $_POST['phoneNumber'];
    //         $message = "Your OTP code is: " .  $otp;
    //         $isPending = $this->sendMessageViaSMS->sendSMS($receiveNumber, $message);

    //         if ($isPending)
    //             echo json_encode([
    //                 "status" => 'success',
    //             ]);
    //         else
    //             echo json_encode([
    //                 "status" => 'failed',
    //             ]);
    //         return;
    //     }

    //     if (isset($_POST['action']) && $_POST['action'] == 'verifyOTP') {

    //         $otp = $_POST['otp'] ?? null;

    //         if ($this->sendMessageViaSMS->verifyOTP($_SESSION['phoneNumber'], $otp)) {

    //             $user = $this->create();
    //             if ($user->wasRecentlyCreated) {

    //                 echo json_encode([
    //                     "statusCode" => 201,
    //                     "message" => "User Created Successfully"
    //                 ]);
    //                 //clear sesssion
    //                 $_SESSION = array();
    //                 return;
    //             } else {
    //                 echo json_encode([
    //                     "statusCode" => 409,
    //                     "message" => "Resource with email:" . $_SESSION['email'] .  " already exists"
    //                 ]);
    //                 return;
    //             }
    //         }

    //         echo json_encode([
    //             "statusCode" => 500,
    //             "message" => "Server Internal Error"
    //         ]);
    //     }
    // }

    // old create user funtion (with OTP code)
    // public function create()
    // {
    //     $fullname = $_SESSION['fullname'] ?? null;
    //     $email = $_SESSION['email'] ?? null;
    //     $password = $_SESSION['password'] ?? null;
    //     $phoneNumber = $_SESSION['phoneNumber'] ?? null;
    //     $address = $_SESSION['address'] ?? null;

    //     $isInvalidInfo = !empty($fullname) && !empty($email)
    //         && !empty($password) && !empty($phoneNumber)
    //         && !empty($address);

    //     if (!$isInvalidInfo) {
    //         echo json_encode([
    //             "errorMessage" => "Please enter all information in the form!",
    //         ]);
    //         return;
    //     }

    //     return $this->userServiceInterface->create(
    //         ["Email" => $email], //if exits Email throw exception
    //         [
    //             'Role' => self::ROLES[0],
    //             'FullName' => $fullname,
    //             'Email' => $email,
    //             'Password' => password_hash($password, PASSWORD_BCRYPT),
    //             'PhoneNumber' => $phoneNumber,
    //             'Address' => $address,
    //         ]
    //     );
    // }

    // new create user function
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? null;
            $email    = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $address  = $_POST['address'] ?? null;
            $captcha  = $_POST['captcha'] ?? null;

            // BEGIN - Validate data

            $isInvalidInfo = !empty($fullname)
                && !empty($email)
                && !empty($password)
                && !empty($address)
                && !empty($captcha);

            if (!$isInvalidInfo) {
                echo json_encode([
                    "errorMessage" => "Vui lòng điền đầy đủ thông tin mẫu!",
                ]);
                return;
            }

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

            if (!CaptchaUtils::validateCaptcha($captcha)) {
                echo json_encode([
                    "errorMessage" => "Mã CAPTCHA không hợp lệ!"
                ]);
                return;
            }

            // END - Validate data

            $user = $this->userServiceInterface->create(
                ["Email" => $email], //if exits Email throw exception
                [
                    'Role'     => self::ROLES[0],
                    'FullName' => $fullname,
                    'Email'    => $email,
                    'Password' => password_hash($password, PASSWORD_BCRYPT),
                    'Address'  => $address,
                ]
            );
            if ($user->wasRecentlyCreated) {
                echo json_encode([
                    "statusCode" => 201,
                    "message" => "User Created Successfully"
                ]);
                //clear session
                $_SESSION = [];
            } else {
                echo json_encode([
                    "statusCode" => 500,
                    "message" => "500 - SERVER INTERNAL ERROR!"
                ]);
            }
            return;
        }
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

                    if ($user->fieldOwner) { // laravel auto fetch eager loading if true
                        $user = $user->toArray();
                        $_SESSION['userInfo'] = $user; //save user logged to session
                    } else
                        $_SESSION['userInfo'] = $user->toArray(); //save user logged to session

                    echo json_encode([
                        "statusCode" => 200,
                        "user" => $user,
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
        $userInfo = $_SESSION['userInfo'] ?? null;
        if ($userInfo) {
            $role = $userInfo['Role'];
            if ($role === "CUSTOMER")
                return $this->view('user/profile', []);

            //==== ROLE OWNER
            $sportTypes  = $this->sportTypeServiceInterface->getAllSportTypes()->toArray();
            return $this->view('user/profile', [
                'sportTypes'     => $sportTypes
            ]);
        }
        echo "<h1 style='color:red'> Vui lòng đăng nhập </h1>";
    }

    public function uploadUserAvatar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {

            $file = $_FILES['file']['tmp_name'];

            try {
                $result = $this->cloudinaryService->uploadFile($file, [
                    'folder' => 'sport-court-rental-system/user-avatar/' // folder wanna upload 
                ]);

                $urlUploaded = $result['secure_url'];

                //updated Avatar field
                $userID = $_SESSION['userInfo']['ID'];

                $userUpdated = $this->userServiceInterface->updateAvatar($userID, $urlUploaded);

                if ($userUpdated) {
                    // update session user avatar link
                    $_SESSION['userInfo']['Avatar'] = $urlUploaded;

                    echo json_encode([
                        "statusCode" => 200,
                        "url" => $urlUploaded,
                    ]);
                    return;
                }


                echo json_encode([
                    "statusCode" => 500,
                    "message" => "Update Failed",
                ]);
            } catch (Exception $e) {
                echo "Upload failed: " . $e->getMessage();
            }
        } else {
            echo "No file uploaded.";
        }
    }

    public function changeProfileLink ()
    {
        $userID = $_SESSION['userInfo']['ID'];
        if (empty($userID)) {
            return "<h5>VUI LÒNG ĐĂNG NHẬP TRƯỚC!</h5>";
            exit();
        }

        $linkName  = $_POST['linkName'] ?? null;
        $linkValue = $_POST['linkValue'] ?? null;

        if (empty($linkName) || empty($linkValue)) {
            echo json_encode([
                'statusCode' => 400,
                'message'    => 'Thiếu dữ liệu cần thiết để cập nhật!'
            ]);
            exit();
        }

        $isChange = $this->userServiceInterface->changeProfileLink($userID, $linkName, $linkValue);
        if ($isChange) {
            //SAVE SESSION LINK FOR USER
            $_SESSION['userInfo'][$linkName] = $linkValue;
            http_response_code(200);
            echo json_encode([
                "statusCode" => 200,
                "message"    => "Profile link change successfully!"
            ]);
            exit();
        }

        http_response_code(500);
        echo json_encode([
            "statusCode" => 500,
            "message"    => "500 - SERVER INTERNAL ERROR!"
        ]);
    }
}
