<?php

use App\Repositories\Implements\NotificationRepositoryImplement;
use App\Services\Implements\NotificationServiceImplement;
use App\Services\NotificationServiceInterface;

class Controller
{
    protected $notiServiceInterface;

    public function __construct()
    {
        $notiRepoImpl               = new NotificationRepositoryImplement();
        $notiServiceImpl            = new NotificationServiceImplement($notiRepoImpl);
        $this->notiServiceInterface = $notiServiceImpl;
    }
    protected function model($model)
    {
        if (file_exists("../app/models/" . $model . ".php")) {
            require_once '../app/models/' . $model . '.php';

            return new $model();
        }
    }


    protected function view($view, $data = [])
    {
        if (file_exists("../app/views/" . $view . ".php")) {
            $dataNoti = $this->getUserNotification();
            extract([...$dataNoti ?? [], ...$data]);
            require_once "../app/views/" . $view . ".php";
        }
    }

    protected function getUserNotification()
    {
        if ($this->notiServiceInterface === null) {
            $notiRepoImpl               = new NotificationRepositoryImplement();
            $notiServiceImpl            = new NotificationServiceImplement($notiRepoImpl);
            $this->notiServiceInterface = $notiServiceImpl;
        }
        // SUY NGHĨ TIẾP LÀM SAO ĐỂ TÁCH PHẦN NÀY RA RIÊNG VÀ CHỈ TRUYỀN XUỐNG VIEW 1 LẦN Ở MỌI CONTROLLER!
        $userId = $_SESSION['userInfo']['ID'] ?? null;
        // get user notifications
        if ($userId) {
            $userNotifications       = $this->notiServiceInterface->getUserNotifications($userId)->toArray();
            $unreadNotificationCount = array_reduce($userNotifications, function ($numberUnreadNotification, $noti) {
                if ($noti['status'] == 0)
                    ++$numberUnreadNotification;
                return $numberUnreadNotification;
            }, 0);
            $allNotiIds = array_column($userNotifications, 'ID');
            return [
                'userNotifications'       => $userNotifications ?? [],
                'unreadNotificationCount' => $unreadNotificationCount ?? [],
                'allNotiIds'              => $allNotiIds ?? []
            ];
        }
    }
}
