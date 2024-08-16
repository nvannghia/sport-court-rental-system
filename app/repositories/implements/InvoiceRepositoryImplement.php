<?php

namespace App\Repositories\Implements;

use App\Models\Invoice;
use App\Repositories\InvoiceRepositoryInterface;

class InvoiceRepositoryImplement implements InvoiceRepositoryInterface
{
    public function createInvoice(array $data)
    {
        return Invoice::create($data);
    }

    public function getInvoiceByBookingID($bookingID)
    {
        return Invoice::where("BookingID",$bookingID)->first();
    }
}
