<?php

use App\Models\Notification;
use App\Models\SportType;
use App\Services\NotificationServiceInterface;
use App\Services\SportTypeServiceInterface;

class NotificationController extends Controller
{
    private $notificationServiceInterface;

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

        $isSuccess = false;
        if ($notification->exists) {
            $isSuccess = $notification->touch();
        } else {
            $isSuccess = $notification->save();
        }

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
}
