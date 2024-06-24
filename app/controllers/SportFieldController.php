
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\SportField;
use App\Services\SportFieldServiceInterface;

class SportFieldController extends Controller
{
    private $sportFieldServiceInterface;

    private const STATUS = ["ACTIVE", "INACTIVE"];

    public function __construct(SportFieldServiceInterface $sportFieldServiceInterface)
    {
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
    }

    public function test()
    {
        var_dump($this->sportFieldServiceInterface);
    }

    public function storeSportField()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === "addSportField") {
            // Lấy giá trị từng trường và kiểm tra empty
            $sportTypeID = isset($_POST['sportTypeID']) ? $_POST['sportTypeID'] : '';
            $fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : '';
            $pricePerHour = isset($_POST['pricePerHour']) ? $_POST['pricePerHour'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $numberOfField = isset($_POST['numberOfField']) ? $_POST['numberOfField'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';

            // Kiểm tra empty và in ra thông báo nếu có trường nào rỗng
            $isValidInfo = empty($fieldName)
                && empty($pricePerHour)
                && empty($sportTypeID)
                && empty($status)
                && empty($numberOfField)
                && empty($address)
                && empty($description);

            if (!$isValidInfo) {
                $ownerID = $_SESSION['userInfo']['OwnerID'];
                $sportField = $this->sportFieldServiceInterface->create(
                    ["FieldName" => $fieldName],
                    [
                        "OwnerID" => $ownerID,
                        "SportTypeID" => $sportTypeID,
                        "FieldName" => $fieldName,
                        "Status" => self::STATUS[0],
                        "PricePerHour" => $pricePerHour,
                        "NumberOfFields" => $numberOfField,
                        "Address" => $address,
                        "Description" => $description
                    ]
                );

                if ($sportField) {
                    if ($sportField->wasRecentlyCreated)
                        echo json_encode([
                            'statusCode' => 201,
                            "message" => 'Sport Field Created Successfully',
                            "sportField" => [...$sportField->toArray(), ...$sportField->sportType->toArray()]
                        ]);
                    else
                        echo json_encode([
                            'statusCode' => 409,
                            "message" => "Sport Field already exist",
                            "sportField" => $sportField
                        ]);
                } else {
                    echo json_encode([
                        'statusCode' => 500,
                        "message" => 'Server Internal Error',
                    ]);
                }
            } else {
                echo json_encode([
                    'statusCode' => 400,
                    "message" => 'Bad Request',
                ]);
            }
        }
    }

    public function detail($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            $sportField = $this->sportFieldServiceInterface->getSportFieldByID($sportFieldID);

            if ($sportField) {
                return $this->view('sport_field/detail', ['sportField' => $sportField->toArray()]);
            } else {
                return $this->view('404');
            }
        }
    }
}
?>