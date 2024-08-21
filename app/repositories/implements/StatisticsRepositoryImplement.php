<?php

namespace App\Repositories\Implements;

use App\Repositories\StatisticsRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;

class StatisticsRepositoryImplement implements StatisticsRepositoryInterface
{
    public function getPaidBookingsStatistics($ownerID)
    {
        $results = DB::table('sportfield')
            ->join('booking', 'booking.SportFieldID', '=', 'sportfield.ID')
            ->join('invoice', 'invoice.BookingID', '=', 'booking.ID')
            ->select(
                DB::raw('SUM(invoice.TotalAmount) as TotalRevenue'),
                DB::raw('COUNT(booking.PaymentStatus) as CountPaidBookings')
            )
            ->where('sportfield.OwnerID', $ownerID)
            ->where('booking.PaymentStatus', 'PAID')
            ->first();
        return $results;
    }

    public function getUnpaidBookingsStatistics($ownerID)
    {
        $results = DB::table('sportfield')
            ->join('booking', 'booking.SportFieldID', '=', 'sportfield.ID')
            ->select(DB::raw('COUNT(booking.PaymentStatus) as CountUnpaidBookings'))
            ->where('sportfield.OwnerID', $ownerID)
            ->where('booking.PaymentStatus', 'UNPAID')
            ->first();
        return $results;
    }
}
