<?php

namespace App\Repositories\Implements;

use App\Models\Notification;
use App\Repositories\NotificationRepositoryInterface;

class NotificationRepositoryImplement implements NotificationRepositoryInterface
{

    private const LIMIT = 10;
    public function firstOrNew(array $arrayInsert)
    {
        return Notification::firstOrNew($arrayInsert);
    }

    public function getUserNotifications($userReceiverId, $offset = null)
    {
        $query = Notification::join('users', 'notification.user_trigger_id', '=', 'users.ID')
            ->select('notification.*', 'users.FullName as user_trigger_name')
            ->where('notification.user_receiver_id', $userReceiverId)
            ->orderBy('notification.status')
            ->orderBy('notification.created_at', 'desc');

        if (!is_null($offset) && is_numeric($offset)) {
            $query->skip($offset);
        }

        return $query->take(self::LIMIT)->get();
    }

    public function markNotificationAsRead($notiIds)
    {
        return Notification::whereIn('ID', $notiIds)->update(['status' => 1]);
    }
}
