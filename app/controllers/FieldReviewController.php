<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\FieldReviewServiceInterface;
use App\Utils\CloudinaryService;

class FieldReviewController extends Controller
{
    private $fieldReviewServiceInterface;

    private $cloudinaryService;

    public function __construct(FieldReviewServiceInterface $fieldReviewServiceInterface, CloudinaryService $cloudinaryService)
    {
        $this->fieldReviewServiceInterface = $fieldReviewServiceInterface;
        $this->cloudinaryService = $cloudinaryService;
    }

    public function test()
    {
     
    }

    public function addFieldReivew()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'addFieldReview') {
            $userID = isset($_SESSION['userInfo']['ID']) ? $_SESSION['userInfo']['ID']  : null;
            $sportFieldID = isset($_POST['sportFieldID']) ? $_POST['sportFieldID'] : null;
            $ratingStar = isset($_POST['ratingStar']) ? $_POST['ratingStar'] : null;
            $content = isset($_POST['content']) ? $_POST['content'] : null;

            $isValidData = !$userID || !$sportFieldID
                || !$ratingStar || !$content;

            if ($isValidData) {
                echo json_encode([
                    'statusCode' => 400,
                    'message' => 'Missing data'
                ]);
            } else {
                $imageReview = null;
                //Upload image of sport field to cloudinary
                if (isset($_FILES['imageReview'])) {
                    try {
                        $file = $_FILES['imageReview']['tmp_name'];

                        $result = $this->cloudinaryService->uploadFile(
                            $file,
                            ['folder' => 'sport-court-rental-system/sport-field/image-review',]
                        );

                        $imageReview = $result['secure_url'];
                    } catch (Exception $e) {
                        $imageReview = null;
                    }
                }

                $fieldReview = $this->fieldReviewServiceInterface->addFieldReview([
                    'SportFieldID' => $sportFieldID,
                    'UserID' => $userID,
                    "Rating" => $ratingStar,
                    "Content" => $content,
                    "ImageReview" => $imageReview
                ]);

                if ($fieldReview) {
                    echo json_encode([
                        'statusCode' => 200,
                        'message' => 'Field review added successfully',
                        'fieldReview' => $fieldReview
                    ]);
                } else {
                    echo json_encode([
                        'statusCode' => 500,
                        'message' => 'Server Internal Error!'
                    ]);
                }
            }
        }
    }
}
