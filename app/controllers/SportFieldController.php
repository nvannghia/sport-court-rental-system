
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\SportField;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;

class SportFieldController extends Controller
{
    private $sportFieldServiceInterface;

    private $sportTypeServiceInterface;

    private const STATUS = ["ACTIVE", "INACTIVE"];

    public function __construct(SportFieldServiceInterface $sportFieldServiceInterface, SportTypeServiceInterface $sportTypeServiceInterface)
    {
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
    }

    public function test()
    {
        var_dump($this->sportFieldServiceInterface->getSportFieldByID(69)->owner->toArray());
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
                $ownerID = $_SESSION['userInfo']['field_owner']['OwnerID'];
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
                    if ($sportField->wasRecentlyCreated) {
                        
                        $sportType = $sportField->sportType->toArray();
                        unset($sportType['ID']);

                        $sportField = $sportField->toArray();

                        echo json_encode([
                            'statusCode' => 201,
                            "message" => 'Sport Field Created Successfully',
                            "sportField" => [...$sportField, ...$sportType]
                        ]);
                    } else
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

                $ownerOfSportField = $sportField->owner;
                unset($ownerOfSportField->Password);

                return $this->view('sport_field/detail', [
                    'sportField' => $sportField->toArray(),
                    'ownerOfSportField' => $ownerOfSportField->toArray()
                ]);
            } else {
                return $this->view('404');
            }
        }
    }

    public function edit($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            $sportField = $this->sportFieldServiceInterface->getSportFieldByID($sportFieldID);

            $sportTypes = $this->sportTypeServiceInterface->getAllSportTypes() ?? null;

            if ($sportField) {

                echo json_encode([
                    'statusCode' => 200,
                    "sportField" => $sportField,
                    "sportTypes" => $sportTypes
                ]);
            } else {

                echo json_encode([
                    'statusCode' => 404,
                    "message" => 'Sport Field Not Found!',
                ]);
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                "message" => 'Bad Request',
            ]);
        }
    }

    public function update($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === "updateSportField") {
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

                    $sportFieldUpdated = $this->sportFieldServiceInterface->update($sportFieldID, [
                        "SportTypeID" => $sportTypeID,
                        "FieldName" => $fieldName,
                        "Status" => $status,
                        "PricePerHour" => $pricePerHour,
                        "NumberOfFields" => $numberOfField,
                        "Address" => $address,
                        "Description" => $description
                    ]);

                    if ($sportFieldUpdated)
                        echo json_encode([
                            'statusCode' => 200,
                            'sportFieldUpdated' => [...$sportFieldUpdated->toArray(), ...$sportFieldUpdated->sportType->toArray()]
                        ]);
                    else {
                        echo json_encode([
                            'statusCode' => 404,
                            'message' => 'Sport Field Not Found!'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'statusCode' => 400,
                        'message' => 'Bad Request!'
                    ]);
                }
            } else {
                echo json_encode([
                    'statusCode' => 400,
                    'message' => 'Bad Request!'
                ]);
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Bad Request!'
            ]);
        }
    }

    public function destroy($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $deletedCount = $this->sportFieldServiceInterface->destroy($sportFieldID);

                if ($deletedCount != null)
                    echo json_encode([
                        'statusCode' => 204,
                        'message' => 'Delete Sport Field Success!'
                    ]);
                else
                    echo json_encode([
                        'statusCode' => 500,
                        'message' => 'Server Internal Error!'
                    ]);
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Bad Request!'
            ]);
        }
    }
}
?>