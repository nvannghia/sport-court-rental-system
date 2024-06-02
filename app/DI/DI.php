<?php
use DI\ContainerBuilder;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Implements\UserRepositoryImplement as UserRepositoryImplement;
use App\Services\Implements\UserServiceImplement as UserServiceImplement;
use App\Utils\sendOTPViaSMS;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Khai báo UserRepository sẽ sử dụng UserRepositoryImplement
    UserRepositoryInterface::class => \DI\create(UserRepositoryImplement::class),
    // Khai báo UserServiceImplement và tự động wire các dependency
    UserServiceImplement::class => \DI\autowire(),

    SendOTPViaSMS::class => DI\create(SendOTPViaSMS::class)
]);

$container = $containerBuilder->build();