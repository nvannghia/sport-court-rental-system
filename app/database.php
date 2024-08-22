<?php 
use Illuminate\Database\Capsule\Manager as Capsule;

$config = $GLOBALS['config'];

$dbDriver = $config['database']['driver'];
$dbHost = $config['database']['host'];
$dbName = $config['database']['database_name'];
$username = $config['database']['username'];
$password = $config['database']['password'];

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => $dbDriver,
    'host'      => $dbHost,
    'username'  => $username,
    'password' => $password,
    'database'  => $dbName,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
?>