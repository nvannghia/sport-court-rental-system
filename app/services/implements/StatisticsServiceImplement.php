<?php

namespace App\Services\Implements;

use App\Repositories\StatisticsRepositoryInterface;
use App\Services\StatisticsServiceInterface;

class StatisticsServiceImplement implements StatisticsServiceInterface
{
    private $statisticsRepositoryInterface;

    function __construct(StatisticsRepositoryInterface $statisticsRepositoryInterface)
    {
        $this->statisticsRepositoryInterface = $statisticsRepositoryInterface;
    }

    public function getPaidBookingsStatistics($ownerID)
    {
        return $this->statisticsRepositoryInterface->getPaidBookingsStatistics($ownerID);
    }

    public function getUnpaidBookingsStatistics($ownerID)
    {
        return $this->statisticsRepositoryInterface->getUnpaidBookingsStatistics($ownerID);
    }
}
