<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\FieldOwnerServiceInterface;
use App\Utils\CaptchaUtils;
use App\Utils\SendMessageViaSMS;

class FieldOwnerController extends Controller
{
    protected $fieldOwnerServiceInterface;

    protected $sendMessageViaSMS;

    const STATUS = ['ACTIVE', 'INACTIVE'];

    public function __construct(FieldOwnerServiceInterface $fieldOwnerServiceInterface, SendMessageViaSMS $sendMessageViaSMS)
    {
        $this->fieldOwnerServiceInterface = $fieldOwnerServiceInterface;
        $this->sendMessageViaSMS = $sendMessageViaSMS;
    }
    public function createBusiness()
    {
        if (!empty($_POST) && $_POST['action'] === 'ownerRegister') {
            $businessName    = $_POST['businessName'] ?? null;
            $businessAddress = $_POST['businessAddress'] ?? null;
            $businessPhone   = $_POST['businessPhone'] ?? null;
            $captcha         = $_POST['captcha'] ?? null;

            $isValidInfo = !empty($businessName)  && !empty($businessAddress)
                && !empty($businessPhone) && !empty($captcha);

            if (!$isValidInfo) {
                echo json_encode([
                    "statusCode" => 400,
                    "errorMessage" => "Please enter all information in the form!",
                ]);
                return;
            }

            if (!CaptchaUtils::validateCaptcha($captcha)) {
                echo json_encode([
                    "statusCode" => 422,
                    "errorMessage" => "Mã captcha không hợp lệ!",
                ]);
                return;
            }

            $fieldonwer = $this->fieldOwnerServiceInterface->createBusiness([
                'OwnerID'         => $_SESSION['userInfo']['ID'],
                'Status'          => self::STATUS[1],
                'BusinessName'    => $businessName,
                'BusinessAddress' => $businessAddress,
                'PhoneNumber'     => $businessPhone
            ]);

            if ($fieldonwer) {
                echo json_encode([
                    "statusCode" => 201,
                    "message" => "Field Owner Created Successfully"
                ]);
            } else {
                echo json_encode([
                    "statusCode" => 500,
                    "message" => "Server Internal Error"
                ]);
            }
        }
    }

    public function isOwnerRegistered()
    {

        if (!empty($_POST) && $_POST['action'] === 'checkOwnerRegisterd') {
            //check if owner already registered
            $ownerID = $_POST['ownerID'] ?? null;

            if ($this->fieldOwnerServiceInterface->isOwnerRegistered($ownerID)) {
                echo json_encode([
                    "statusCode" => 409,
                    "message" => "You're already registered!"
                ]);
            } else
                echo json_encode([
                    "statusCode" => 404,
                    "message" => "Unregistered business"
                ]);
        }
    }

    public function getAllOwners()
    {
        if (!empty($_POST) && $_POST['action'] === 'getAllOwners') {
            $owners = $this->fieldOwnerServiceInterface->getAllOwners();
            echo json_encode([
                'statusCode' => 200,
                'owners' => $owners
            ]);
        }
    }

    public function updateOwnerStatus()
    {
        if (!empty($_POST) && $_POST['action'] === 'updateOwnerStatus') {
            $ownerID = $_POST['ownerID'] ?? null;
            if ($ownerID) {
                $fieldOwner = $this->fieldOwnerServiceInterface->updateOwnerStatus($ownerID);
                if ($fieldOwner) {
                    // THIS OLD CODE LINES FOR SEND STATUS FIELD TO OWNER
                    // $isPending = $this->sendStatusUpdateMessage($fieldOwner);
                    // if ($isPending)
                    echo json_encode([
                        "statusCode" => 200,
                        "message" => "Owner Updated Successfully",
                        "fieldOwnerStatus" => $fieldOwner->Status,
                    ]);
                } else {
                    echo json_encode([
                        "statusCode" => 500,
                        "message" => "Owner Update Failed"
                    ]);
                }
            } else {
                echo json_encode([
                    "statusCode" => 404,
                    "message" => "Owner Not Found"
                ]);
            }
        }
    }

    public function sendStatusUpdateMessage($fieldOnwer)
    {
        $phoneNumber = substr_replace($fieldOnwer->PhoneNumber, '+84', 0, 1);

        if ($fieldOnwer->Status === "ACTIVE") {
            $message = "Xin chúc mừng! Doanh nghiệp {$fieldOnwer->BusinessName} (Địa chỉ: {$fieldOnwer->BusinessAddress}) đã được hệ thống xác nhận. Vui lòng đăng nhập vào trang web để xem lại thông tin chi tiết.";
            return $this->sendMessageViaSMS->sendSMS($phoneNumber, $message);
        } else {
            $message = "Doanh nghiệp {$fieldOnwer->BusinessName} (Địa chỉ: {$fieldOnwer->BusinessAddress}) đã bị hệ thống khóa do khiếu nại. Nếu bạn có bất cứ thắc mắc nào, vui lòng liên hệ Quản trị viên.";
            return $this->sendMessageViaSMS->sendSMS($phoneNumber, $message);
        }
    }
}
