<?php

namespace App\Repositories;

interface InvoiceRepositoryInterface
{
    public function createInvoice(array $data);

    public function getInvoiceByBookingID($bookingID);

}
