<?php
$config = [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database_name' => 'sportdb',
    ],
];

//set varible config to global for access anywhere
$GLOBALS['config'] = $config;
