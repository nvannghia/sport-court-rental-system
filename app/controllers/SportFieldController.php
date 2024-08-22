
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\FieldReview;
use App\Models\SportField;
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

    const ITEM_REVIEW_PER_PAGE = 2;

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
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $numberOfField = isset($_POST['numberOfField']) ? $_POST['numberOfField'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $priceDay = isset($_POST['priceDay']) ? $_POST['priceDay'] : '';
            $priceEvening = isset($_POST['priceEvening']) ? $_POST['priceEvening'] : '';
            $openingTime = isset($_POST['openingTime']) ? $_POST['openingTime'] : '';
            $closingTime = isset($_POST['closingTime']) ? $_POST['closingTime'] : '';
            $fieldSize = isset($_POST['fieldSize']) ? $_POST['fieldSize'] : null;
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
                && empty($description)
                && empty($priceDay)
                && empty($priceEvening)
                && empty($openingTime)
                && empty($closingTime);


            if (!$isValidInfo) {
                $ownerID = $_SESSION['userInfo']['field_owner']['OwnerID'];
                $sportField = $this->sportFieldServiceInterface->create(
                    ["FieldName" => $fieldName],
                    [
                        "OwnerID" => $ownerID,
                        "SportTypeID" => $sportTypeID,
                        "FieldName" => $fieldName,
                        "Status" => self::STATUS[0],
                        "NumberOfFields" => $numberOfField,
                        "Address" => $address,
                        "Description" => $description,
                        "PriceDay" => $priceDay,
                        "PriceEvening" => $priceEvening,
                        "OpeningTime" => $openingTime,
                        "ClosingTime" => $closingTime,
                        "FieldSize" => $fieldSize,
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

    public function test()
    {
        $orderByArray = ['created_at', 'Rating_desc', 'Rating_asc'];

        $orderBy = in_array($_GET['orderBy'], $orderByArray)
            ? $_GET['orderBy']
            : null;

        var_dump($orderBy);

        $sportField = $this->sportFieldServiceInterface->getSportFieldByIDWithReviews(null,$orderBy, 91)->toArray();
    }

    public function detail($sportFieldID)
    {
        if (isset($sportFieldID) && is_numeric($sportFieldID)) {

            //get sport field with pagination
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * self::ITEM_REVIEW_PER_PAGE;

            $orderByArray = ['created_at', 'Rating_desc', 'Rating_asc'];
            $orderBy = isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderByArray)
                ? $_GET['orderBy']
                : null;

            $results = $this->sportFieldServiceInterface->getSportFieldByIDWithReviews($offset ,$orderBy, $sportFieldID);
            $sportField = $results['sportField'];
            $totalPages = $results['totalPages'];


            //calculate percentage of each star and total star
            $stars = $this->fieldReviewServiceInterface->calculateStarCountsSportFieldByID($sportFieldID);
            //destructuring array 
            ['percents' => $percents, 'averagePoint' => $averagePoint, 'totalReviews' => $totalReviews] = $this->calculateStarPercentageTotal($stars);

            if ($sportField) {

                $ownerOfSportField = $sportField->owner;
                unset($ownerOfSportField->Password);

                //filter data 'users_liked_review' to flatten array and get all images review to display
                $sportField = $sportField->toArray();
                $fieldReviews =  $sportField['field_reviews'];
                $fieldReivewImagesUrl = [];

                foreach ($fieldReviews as $index => $fieldReview) {
                    //format created_at
                    $dateString = $fieldReview['created_at'];
                    $date = new DateTime($dateString);
                    $formattedCreatedAt = $date->format('d/m/Y');

                    //append image review to  $fieldReivewImagesUrl
                    $imageReview = $fieldReview['ImageReview'] ?? null;
                    if ($imageReview)
                        $fieldReivewImagesUrl[] = $imageReview;

                    //flatten array 'users_liked_review'
                    $usersLikeReviews = $fieldReview['users_liked_review'];
                    $usersLikeReviewID = [];
                    foreach ($usersLikeReviews as $usersLikeReview) {
                        $usersLikeReviewID[] = $usersLikeReview['ID'];
                    }

                    $sportField['field_reviews'][$index]['users_liked_review'] = $usersLikeReviewID;
                    $sportField['field_reviews'][$index]['created_at'] = $formattedCreatedAt;
                }

                return $this->view('sport_field/detail', [
                    'sportField' => $sportField,
                    'ownerOfSportField' => $ownerOfSportField->toArray(),
                    'averagePoint' => $averagePoint,
                    'percents' => $percents,
                    'totalReviews' => $totalReviews,
                    'fieldReivewImagesUrl' => $fieldReivewImagesUrl,
                    'totalPages' => $totalPages,
                    'currentPage' => $currentPage,
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
                $priceDay = isset($_POST['priceDay']) ? $_POST['priceDay'] : '';
                $priceEvening = isset($_POST['priceEvening']) ? $_POST['priceEvening'] : '';
                $openingTime = isset($_POST['openingTime']) ? $_POST['openingTime'] : '';
                $closingTime = isset($_POST['closingTime']) ? $_POST['closingTime'] : '';
                $fieldSize = isset($_POST['fieldSize']) ? $_POST['fieldSize'] : null;
                $image = null;

                //Upload new image of sport field to cloudinary, otherwise use old image
                if (isset($_FILES['fieldImage'])) {
                    $file = $_FILES['fieldImage']['tmp_name'];
                    $image = $this->uploadRepresentation($file);
                } else {
                    $image = isset($_POST['oldImage']) ? $_POST['oldImage'] : '';
                }

                // Kiểm tra empty và in ra thông báo nếu có trường nào rỗng
                $isValidInfo = !empty($fieldName)
                    && !empty($pricePerHour)
                    && !empty($sportTypeID)
                    && !empty($status)
                    && !empty($numberOfField)
                    && !empty($address)
                    && !empty($description)
                    && !empty($priceDay)
                    && !empty($priceEvening)
                    && !empty($openingTime)
                    && !empty($closingTime)
                    && !empty($fieldSize);

                if ($isValidInfo) {

                    $sportFieldUpdated = $this->sportFieldServiceInterface->update($sportFieldID, [
                        "SportTypeID" => $sportTypeID,
                        "FieldName" => $fieldName,
                        "Status" => $status,
                        "PricePerHour" => $pricePerHour,
                        "NumberOfFields" => $numberOfField,
                        "Address" => $address,
                        "Description" => $description,
                        "PriceDay" => $priceDay,
                        "PriceEvening" => $priceEvening,
                        "OpeningTime" => $openingTime,
                        "ClosingTime" => $closingTime,
                        "FieldSize" => $fieldSize,
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
}
?>