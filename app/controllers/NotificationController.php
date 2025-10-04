<?php
session_start();
use App\Services\NotificationServiceInterface;

use function Symfony\Component\Clock\now;

class NotificationController extends Controller
{
    private $notificationServiceInterface;

    private const NOTIFY_STATUS = ["UNREAD" => 0, "READ" => 1];

    private const ITEM_NOTIFY_PER_LOAD = 10;

    public function __construct(NotificationServiceInterface $notificationServiceInterface)
    {
        $this->notificationServiceInterface = $notificationServiceInterface;
    }

    public function firstOrNewNotification()
    {
        $userReceiverId = $_POST['user_receiver_id'] ?? null;
        $userTriggerId  = $_POST['user_trigger_id'] ?? null;
        $content        = $_POST['content'] ?? null;
        $action         = $_POST['action'] ?? null;

        $notification = $this->notificationServiceInterface->firstOrNew(
            [
                'user_receiver_id' => $userReceiverId,
                'user_trigger_id'  => $userTriggerId,
                'action'           => $action,
                'content'          => $content
            ]
        );

        if ($notification->exists) {
            $notification->updated_at = now();
        }
        // gán status chung cho cả 2 trường hợp
        $notification->status = self::NOTIFY_STATUS["UNREAD"];
        $isSuccess = $notification->save();

        $jsonData = $isSuccess
            ? ['statusCode' => 201, 'message' => 'Notification Created Successfully']
            : ['statusCode' => 500, 'message' => 'Server Internal Error'];

        echo json_encode($jsonData);
    }

    public function markNotificationAsRead()
    {
        $notiIds   = $_POST['noti_ids'] ?? null;
        $notiIds   = explode(',', $notiIds);
        $isUpdated = $this->notificationServiceInterface->markNotificationAsRead($notiIds);

        $jsonData = $isUpdated
            ? ['statusCode' => 200, 'message' => 'Notification Updated Successfully']
            : ['statusCode' => 500, 'message' => 'Server Internal Error'];

        echo json_encode($jsonData);
    }

    public function getLatestNotificationsByUser()
    {
        $userId = $_GET['user_receiver_id'] ?? null;
        if (!$userId) {
            echo "Login first!";
            return;
        }

        $userNotifications = $this->notificationServiceInterface->getUserNotifications($userId)->toArray();
        $unreadNotificationCount = array_reduce($userNotifications, function ($numberUnreadNotification, $noti) {
            if ($noti['status'] == 0)
                ++$numberUnreadNotification;
            return $numberUnreadNotification;
        }, 0);
        echo json_encode([
            'statusCode'              => 200,
            'data'                    => $userNotifications,
            'unreadNotificationCount' => $unreadNotificationCount
        ]);
    }

    public function loadMoreNotification()
    {
        $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * self::ITEM_NOTIFY_PER_LOAD;
        $userId = $_SESSION['userInfo']['ID'];
        
        if (empty($userId) || !is_numeric($page)) {
            echo json_encode([
                'statusCode' => 500,
                'message' => 'Invalid data request!'
            ]); 
            return;

        }
            
        $data = $this->notificationServiceInterface->getUserNotifications($userId, $offset)->toArray();
        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }
}
