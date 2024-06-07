<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\FieldOwnerServiceInterface;

class FieldOwnerController extends Controller
{
    protected $fieldOwnerServiceInterface;

    const STATUS = ['ACTIVE', 'INACTIVE'];

    public function __construct(FieldOwnerServiceInterface $fieldOwnerServiceInterface)
    {
        $this->fieldOwnerServiceInterface = $fieldOwnerServiceInterface;
    }
    public function createBusiness()
    {

        if (!empty($_POST) && $_POST['action'] === 'checkOwnerRegisterd') {
            $this->isOwnerRegistered();
        }

        if (!empty($_POST) && $_POST['action'] === 'ownerRegister') {
            $businessName = $_POST['businessName'] ?? null;
            $businessAddress = $_POST['businessAddress'] ?? null;
            $businessPhone = $_POST['businessPhone'] ?? null;

            $isValidInfo = !empty($businessName) && !empty($businessAddress)
                && !empty($businessPhone);

            if (!$isValidInfo) {
                echo json_encode([
                    "errorMessage" => "Please enter all information in the form!",
                ]);
                return;
            }

            $fieldonwer = $this->fieldOwnerServiceInterface->createBusiness([
                'OwnerID' => $_SESSION['userInfo']['ID'],
                'Status' => self::STATUS[1],
                'BusinessName' => $businessName,
                'BusinessAddress'  => $businessAddress,
                'PhoneNumber' => $businessPhone
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
        //check if owner already registered
        $ownerID = $_POST['ownerID'] ?? null;

        if ($this->fieldOwnerServiceInterface->isOwnerRegistered($ownerID)) {
            echo json_encode([
                "statusCode" => 409,
                "message" => "You're already registered!"
            ]);
            return;
        }
    }
}
