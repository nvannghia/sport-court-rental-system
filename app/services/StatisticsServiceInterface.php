<?php

namespace App\Services;

interface StatisticsServiceInterface
{
    public function getPaidBookingsStatistics($ownerID);

    public function getUnpaidBookingsStatistics($ownerID);
}
