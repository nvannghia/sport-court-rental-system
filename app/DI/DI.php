<?php

use App\Repositories\FieldOwnerRepositoryInterface;
use App\Repositories\Implements\FieldOwnerRepositoryImplement;
use App\Repositories\Implements\SportTypeRepositoryImplement;
use DI\ContainerBuilder;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Implements\UserRepositoryImplement as UserRepositoryImplement;
use App\Repositories\SportTypeRepositoryInterface;
use App\Services\Implements\FieldOwnerServiceImplement;
use App\Services\Implements\SportTypeServiceImplement;
use App\Services\Implements\UserServiceImplement as UserServiceImplement;
use App\Utils\SendMessageViaSMS;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Khai báo UserRepository sẽ sử dụng UserRepositoryImplement
    UserRepositoryInterface::class => \DI\create(UserRepositoryImplement::class),
    // Khai báo UserServiceImplement và tự động wire các dependency
    UserServiceImplement::class => \DI\autowire(),

    SendMessageViaSMS::class => DI\create(SendMessageViaSMS::class),

    FieldOwnerRepositoryInterface::class => \DI\create(FieldOwnerRepositoryImplement::class),
    FieldOwnerServiceImplement::class => \DI\autowire(),

    SportTypeRepositoryInterface::class => \DI\create(SportTypeRepositoryImplement::class),
    SportTypeServiceImplement::class => \DI\autowire(),
]);

$container = $containerBuilder->build();