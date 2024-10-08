<?php

namespace App\Services;

interface InvoiceServiceInterface
{
    public function createInvoice(array $data);

    public function getInvoiceByBookingID($bookingID);
}
