<?php

use App\Services\NotificationServiceInterface;

class Notification {
    private $notificationService;

    // DI Container sẽ tự động inject implement vào đây
    public function __construct(NotificationServiceInterface $service) {
        $this->notificationService = $service;
    }

    public function getUserNotificationData($userId) {
        $userNotifications = $this->notificationService->getUserNotifications($userId)->toArray();
        $unreadCount = array_reduce(
            $userNotifications,
            fn($count, $n) => $count + ($n['status'] == 0),
            0
        );
        $allNotiIds = array_column($userNotifications, 'ID');
        return [$userNotifications, $unreadCount, $allNotiIds];
    }
}

?>