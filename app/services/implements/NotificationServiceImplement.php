<?php

namespace App\Services\Implements;

use App\Repositories\NotificationRepositoryInterface;
use App\Services\NotificationServiceInterface;

class NotificationServiceImplement implements NotificationServiceInterface
{


    private $notificationRepositoryInterface;

    public function __construct(NotificationRepositoryInterface $notificationRepositoryInterface)
    {
        $this->notificationRepositoryInterface =  $notificationRepositoryInterface;
    }

    public function firstOrNew(array $arrayInsert)
    {
        return $this->notificationRepositoryInterface->firstOrNew($arrayInsert);
    }

    public function getUserNotifications($userReceiverId)
    {
        return $this->notificationRepositoryInterface->getUserNotifications($userReceiverId);
    }

    public function markNotificationAsRead($notiIds)
    {
        if (!is_array($notiIds))
            return null;
        return $this->notificationRepositoryInterface->markNotificationAsRead($notiIds);
    }
}
