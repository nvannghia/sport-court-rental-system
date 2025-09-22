<?php

use App\Repositories\BookingRepositoryInterface;
use App\Repositories\FieldOwnerRepositoryInterface;
use App\Repositories\FieldReviewRepositoryInterface;
use App\Repositories\Implements\BookingRepositoryImplement;
use App\Repositories\Implements\FieldOwnerRepositoryImplement;
use App\Repositories\Implements\FieldReviewRepositoryImplement;
use App\Repositories\Implements\InvoiceRepositoryImplement;
use App\Repositories\Implements\NotificationRepositoryImplement;
use App\Repositories\Implements\SportFieldRepositoryImplement;
use App\Repositories\Implements\SportTypeRepositoryImplement;
use App\Repositories\Implements\StatisticsRepositoryImplement;
use DI\ContainerBuilder;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Implements\UserRepositoryImplement as UserRepositoryImplement;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\NotificationRepositoryInterface;
use App\Repositories\SportFieldRepositoryInterface;
use App\Repositories\SportTypeRepositoryInterface;
use App\Repositories\StatisticsRepositoryInterface;
use App\Services\Implements\BookingServiceImplement;
use App\Services\Implements\FieldOwnerServiceImplement;
use App\Services\Implements\FieldReviewServiceImplement;
use App\Services\Implements\NotificationServiceImplement;
use App\Services\Implements\SportFieldServiceImplement;
use App\Services\Implements\SportTypeServiceImplement;
use App\Services\Implements\StatisticsServiceImplement;
use App\Services\Implements\UserServiceImplement as UserServiceImplement;
use App\Services\StatisticsServiceInterface;
use App\Utils\CloudinaryService;
use App\Utils\SendMessageViaSMS;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Khai báo UserRepository sẽ sử dụng UserRepositoryImplement
    UserRepositoryInterface::class => \DI\create(UserRepositoryImplement::class),
    // Khai báo UserServiceImplement và tự động wire các dependency
    UserServiceImplement::class => \DI\autowire(),

    SendMessageViaSMS::class => DI\create(SendMessageViaSMS::class),
    CloudinaryService::class => DI\create(CloudinaryService::class),

    FieldOwnerRepositoryInterface::class => \DI\create(FieldOwnerRepositoryImplement::class),
    FieldOwnerServiceImplement::class    => \DI\autowire(),

    SportTypeRepositoryInterface::class => \DI\create(SportTypeRepositoryImplement::class),
    SportTypeServiceImplement::class    => \DI\autowire(),

    SportFieldRepositoryInterface::class => \DI\create(SportFieldRepositoryImplement::class),
    SportFieldServiceImplement::class    => \DI\autowire(),

    FieldReviewRepositoryInterface::class => \DI\create(FieldReviewRepositoryImplement::class),
    FieldReviewServiceImplement::class    => \DI\autowire(),

    BookingRepositoryInterface::class => \DI\create(BookingRepositoryImplement::class),
    BookingServiceImplement::class    => \DI\autowire(),

    InvoiceRepositoryInterface::class => \DI\create(InvoiceRepositoryImplement::class),
    BookingServiceImplement::class    => \DI\autowire(),

    StatisticsRepositoryInterface::class => \DI\create(StatisticsRepositoryImplement::class),
    StatisticsServiceImplement::class    => \DI\autowire(),

    NotificationRepositoryInterface::class => \DI\create(NotificationRepositoryImplement::class),
    NotificationServiceImplement::class    => \DI\autowire(),
]);

$container = $containerBuilder->build();