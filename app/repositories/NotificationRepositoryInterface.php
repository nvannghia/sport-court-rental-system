<?php

namespace App\Repositories;

interface NotificationRepositoryInterface
{
    public function firstOrNew(array $arrayInsert);

    public function getUserNotifications($userReceiverId, $offset);

    public function markNotificationAsRead($notiIds);
}
