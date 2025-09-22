<?php

namespace App\Repositories\Implements;

use App\Models\Notification;
use App\Repositories\NotificationRepositoryInterface;

class NotificationRepositoryImplement implements NotificationRepositoryInterface
{
    public function firstOrNew(array $arrayInsert)
    {
        return Notification::firstOrNew($arrayInsert);
    }

    public function getUserNotifications($userReceiverId)
    {
        return Notification::join('users', 'notification.user_trigger_id', '=', 'users.ID')
            ->select('notification.*', 'users.FullName as user_trigger_name')
            ->where('notification.user_receiver_id', $userReceiverId)
            ->orderBy('notification.status')
            ->take(10)
            ->get();
    }

    public function markNotificationAsRead($notiIds)
    {
        return Notification::whereIn('ID', $notiIds)->update(['status' => 1]);
    }
}
