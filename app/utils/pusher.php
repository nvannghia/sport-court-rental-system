<?php
require_once '../../vendor/autoload.php';
session_start();

if (empty($_SESSION['userInfo']))
    die('error user info');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo "Only POST allowed";
    exit;
}

$options = [
    'cluster' => 'ap1',
    'useTLS' => true
];

$pusher = new Pusher\Pusher(
    '104a8ee9340cb349a757', // key
    '4cf1c475b23ef79c1e14', // secret
    '2043761',              // app_id
    $options
);

$message        = $_POST['message'] ?? '';
$userReceiverId = $_POST['user_receiver_id'] ?? '';
$userTriggerId  = $_POST['user_trigger_id'] ?? '';
$action         = $_POST['action'] ?? '';

$data = [
    'userReceiverId' => $userReceiverId,
    'userTriggerId'  => $userTriggerId,
    'message'        => $message,
    'action'         => $action
];  

$pusher->trigger('new-noti-userId-'.$data['userReceiverId'], 'new-noti', $data);

echo "ok";
