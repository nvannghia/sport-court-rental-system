<?php

namespace App\Services;

interface NotificationServiceInterface
{
    public function firstOrNew(array $arrayInsert);

    public function getUserNotifications($userReceiverId);

    public function markNotificationAsRead($notiIds);
}
