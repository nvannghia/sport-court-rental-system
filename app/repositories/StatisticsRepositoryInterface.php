<?php

namespace App\Repositories;

interface StatisticsRepositoryInterface
{
    public function getPaidBookingsStatistics($ownerID);
    public function getUnpaidBookingsStatistics($ownerID);
}
