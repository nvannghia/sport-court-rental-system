<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Models\FieldReview;
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
        $fieldReview = FieldReview::find(64);

        echo "<pre>";
        print_r($fieldReview->usersLikedReview()->get()->toArray());
        echo "</pre>";
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

    public function updateLike()
    {
        //user logged current
        $userID = $_SESSION['userInfo']['ID'];
        $fieldReviewID = isset($_POST['fieldReviewID']) ? $_POST['fieldReviewID'] : null;
        if (!$fieldReviewID) {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Missing data'
            ]);
            return;
        }

        if (isset($_POST['action']) && $_POST['action'] == 'increaseReviewLike') {
            try {
                $this->fieldReviewServiceInterface->updateLikeReview('increase', $fieldReviewID, $userID);
                echo json_encode([
                    'statusCode' => 200,
                    'message' => 'Successfully Increased Like of Review!'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Server Internal Error!',
                    'errorMessage' => $e->getMessage()
                ]);
            }
        } else {
            try {
                $this->fieldReviewServiceInterface->updateLikeReview('descrease', $fieldReviewID, $userID);
                echo json_encode([
                    'statusCode' => 200,
                    'message' => 'Successfully Descreased Like of Review!'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Server Internal Error!',
                    'errorMessage' => $e->getMessage()
                ]);
            }
        }
    }

    public function deleteFieldReview($fieldReviewID)
    {
        if (isset($_POST) && $_POST['action'] === 'deleteFieldReview') {
            $isDeleted = $this->fieldReviewServiceInterface->deleteFieldReview($fieldReviewID);
            if ($isDeleted)
                echo json_encode([
                    'statusCode' => 204,
                    'message' => 'Field Review Deleted Successfully'
                ]);
            else
                echo json_encode([
                    'statusCode' => 500,
                    'message' => 'Failed To Delete Field Review!'
                ]);
        }
    }

    public function getFieldReviewByID($fieldReviewID)
    {
        if (isset($fieldReviewID) && is_numeric($fieldReviewID)) {
            $fieldReview = $this->fieldReviewServiceInterface->getFieldReviewByID($fieldReviewID);
            if ($fieldReview) {
                echo json_encode([
                    'statusCode' => 200,
                    'message' => 'Field Review Retrieved Successfully',
                    'fieldReview' => $fieldReview
                ]);
            } else {
                echo json_encode([
                    'statusCode' => 404,
                    'message' => 'Field Review Not Found!'
                ]);
            }
        } else {
            echo json_encode([
                'statusCode' => 400,
                'message' => 'Bad Request!'
            ]);
        }
    }

    public function updateFieldReview($fieldReviewID)
    {
        if (isset($fieldReviewID) && is_numeric($fieldReviewID)) {

            if (isset($_POST) && $_POST['action'] === 'updateFieldReview') {
                $ratingStar = isset($_POST['ratingStar']) ? $_POST['ratingStar'] : null;
                $content = isset($_POST['content']) ? $_POST['content'] : null;

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

                $fieldReviewUpdated = $this->fieldReviewServiceInterface->updateFieldReview($fieldReviewID, [
                    "rating" => $ratingStar,
                    "content" => $content,
                    "imageReview" => $imageReview
                ]);

                if ($fieldReviewUpdated)
                    echo json_encode([
                        'statusCode' => 200,
                        'message' => 'Field Review Updated Successfully',
                        'fieldReview' => $fieldReviewUpdated
                    ]);
                else
                    echo json_encode([
                        'statusCode' => 500,
                        'message' => 'Server Internal Error!',
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
