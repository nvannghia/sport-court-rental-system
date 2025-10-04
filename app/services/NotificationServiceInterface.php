<?php

namespace App\Services;

interface NotificationServiceInterface
{
    public function firstOrNew(array $arrayInsert);

    public function getUserNotifications($userReceiverId, $offset = null);

    public function markNotificationAsRead($notiIds);
}
