
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\FieldReview;
use App\Services\FieldReviewServiceInterface;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;
use App\Utils\CloudinaryService;

class SportFieldController extends Controller
{
    private $sportFieldServiceInterface;

    private $sportTypeServiceInterface;

    private $cloudinaryService;

    private $fieldReviewServiceInterface;

    private const STATUS = ["ACTIVE", "INACTIVE"];

    public function __construct(
        SportFieldServiceInterface $sportFieldServiceInterface,
        SportTypeServiceInterface $sportTypeServiceInterface,
        CloudinaryService $cloudinaryService,
        FieldReviewServiceInterface $fieldReviewServiceInterface
    ) {
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
        $this->cloudinaryService = $cloudinaryService;
        $this->fieldReviewServiceInterface = $fieldReviewServiceInterface;
    }

    public function uploadRepresentation($file)
    {
        try {
            $result = $this->cloudinaryService->uploadFile($file, [
                'folder' => 'sport-court-rental-system/sport-field/representation' // folder wanna upload 
            ]);

            $urlUploaded = $result['secure_url'];

            if ($urlUploaded)
                return $urlUploaded;

            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function storeSportField()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] === "addSportField") {
            // Lấy giá trị từng trường và kiểm tra isset
            $sportTypeID = isset($_POST['sportTypeID']) ? $_POST['sportTypeID'] : '';
            $fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : '';
            $pricePerHour = isset($_POST['pricePerHour']) ? $_POST['pricePerHour'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $numberOfField = isset($_POST['numberOfField']) ? $_POST['numberOfField'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $image = null;

            //Upload image of sport field to cloudinary
            if (isset($_FILES['fieldImage'])) {
                $file = $_FILES['fieldImage']['tmp_name'];
                $image = $this->uploadRepresentation($file);
            }

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
                        "Description" => $description,
                        "Image" => $image
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

    public function test()
    {
        $sportField = $this->sportFieldServiceInterface->getSportFieldByIDWithReviews(91)->toArray();




        echo "<pre>";
        print_r($sportField);
        echo "</pre>";
    }

    public function calculateStarPercentageTotal(
        array $stars
    ) {
        $star1  = $stars[0];
        $star2  = $stars[1];
        $star3  = $stars[2];
        $star4  = $stars[3];
        $star5  = $stars[4];

        //percentage each star
        $totalStars = $star1 + $star2 + $star3 + $star4 + $star5;
        $percents = [];
        for ($i = 1; $i <= 5; ++$i) {
            $var = "star$i";
            $count = $$var;
            if ($count != 0)
                $percent = number_format($count * 100 / $totalStars, 2);
            else
                $percent = 0;
            $percents[] = $percent;
        }

        // average point
        $totalReviews = $totalStars; //$totalStars = total of reviews
        $totalPoints = ($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1);
        if ($totalPoints == 0)
            $number = 0;
        else
            $number = $totalPoints / $totalReviews;

        $decimalPlaces = 1;
        $factor = pow(10, $decimalPlaces);

        $roundedDown = floor($number * $factor) / $factor;

        return [
            'percents' => $percents,
            'averagePoint' => $roundedDown,
            'totalReviews' => $totalReviews
        ];
    }

    public function detail($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            //get sport field
            $sportField = $this->sportFieldServiceInterface->getSportFieldByIDWithReviews($sportFieldID);
            //calculate percentage of each star and total star
            $stars = $this->fieldReviewServiceInterface->calculateStarCountsSportFieldByID($sportFieldID);
            //destructuring array 
            ['percents' => $percents, 'averagePoint' => $averagePoint, 'totalReviews' => $totalReviews] = $this->calculateStarPercentageTotal($stars);

            if ($sportField) {

                $ownerOfSportField = $sportField->owner;
                unset($ownerOfSportField->Password);

                //filter data 'users_liked_review' to flatten array
                $sportField = $sportField->toArray();
                $fieldReviews =  $sportField['field_reviews'];
                foreach ($fieldReviews as $index => $fieldReview) {
                    $usersLikeReviews = $fieldReview['users_liked_review'];
                    $usersLikeReviewID = [];
                    foreach ($usersLikeReviews as $usersLikeReview) {
                        $usersLikeReviewID[] = $usersLikeReview['ID'];
                    }

                    $sportField['field_reviews'][$index]['users_liked_review'] = $usersLikeReviewID;
                }

                return $this->view('sport_field/detail', [
                    'sportField' => $sportField,
                    'ownerOfSportField' => $ownerOfSportField->toArray(),
                    'averagePoint' => $averagePoint,
                    'percents' => $percents,
                    'totalReviews' => $totalReviews
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
                $image = null;

                //Upload new image of sport field to cloudinary, otherwise use old image
                if (isset($_FILES['fieldImage'])) {
                    $file = $_FILES['fieldImage']['tmp_name'];
                    $image = $this->uploadRepresentation($file);
                } else {
                    $image = isset($_POST['oldImage']) ? $_POST['oldImage'] : '';
                }

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
                        "Description" => $description,
                        "Image" => $image
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

    public function bookafield()
    {
        return $this->view('sport_field/book_a_field');
    }
}
?>