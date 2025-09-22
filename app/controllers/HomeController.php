<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use App\Services\NotificationServiceInterface;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;
use App\Utils\CaptchaUtils;

class HomeController extends Controller
{
    private $sportTypeServiceInterface;

    private $sportFieldServiceInterface;

    private $notificationServiceInterface;

    private const ITEM_PER_PAGE = 6;

    public function __construct(
        SportTypeServiceInterface $sportTypeServiceInterface,
        SportFieldServiceInterface $sportFieldServiceInterface,
        NotificationServiceInterface $notificationServiceInterface
    ) {
        $this->sportTypeServiceInterface    = $sportTypeServiceInterface;
        $this->sportFieldServiceInterface   = $sportFieldServiceInterface;
        $this->notificationServiceInterface = $notificationServiceInterface;
    }

    public function index()
    {
        $userId = $_SESSION['userInfo']['ID'] ?? null;
        // get user notifications
        if ($userId) {
            $userNotifications       = $this->notificationServiceInterface->getUserNotifications($userId)->toArray();
            $unreadNotificationCount = array_reduce($userNotifications, function ($numberUnreadNotification, $noti) {
                if ($noti['status'] == 0) 
                    ++$numberUnreadNotification;
                return $numberUnreadNotification;
            }, 0);
            $allNotiIds = array_column($userNotifications, 'ID');
        }
        
        // get sportType and quantity of each type.
        $sportTypes        = $this->sportTypeServiceInterface->getAllSportTypesWithCount()->toArray();
        return $this->view('home/index', [
            'sportTypes'              => $sportTypes,
            'userNotifications'       => $userNotifications ?? [],
            'unreadNotificationCount' => $unreadNotificationCount ?? [],
            'allNotiIds'              => $allNotiIds ?? []
        ]);
    }

    public function getPaginatedSportFieldsForHomepage()
    {
        header('Content-Type: application/json');

        $fieldName   = $_GET['fieldName'] ?? null;
        $area        = $_GET['area'] ?? null;
        $sportTypeId = $_GET['sportTypeId'] ?? null;
        if (!$sportTypeId || !is_numeric($sportTypeId)) {
            http_response_code(400);
            echo json_encode([
                'statusCode' => 400,
                'message'    => "Missing required field: 'sportTypeId'"
            ]);
            exit();
        }

        $page        = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset      = ($page - 1) * self::ITEM_PER_PAGE;
        $rs          = $this->sportFieldServiceInterface->getSportFieldByTypePagination($offset, $sportTypeId, $fieldName, $area);
        $totalPages  = !empty($rs) ? $rs['totalPages'] : [];
        $sportFields = !empty($rs) ? $rs['items'] : [];

        echo json_encode([
            'items' => $sportFields,
            'pagination' => [
                'current'    => $page,
                'totalPages' => $totalPages
            ]
        ]);
    }
}
