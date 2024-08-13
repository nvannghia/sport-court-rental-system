<?php

namespace App\Services\Implements;

use App\Repositories\InvoiceRepositoryInterface;
use App\Services\InvoiceServiceInterface;

class InvoiceServiceImplement implements InvoiceServiceInterface
{

    private $invoiceRepositoryInterface;

    public function __construct(InvoiceRepositoryInterface $invoiceRepositoryInterface)
    {
        $this->invoiceRepositoryInterface =  $invoiceRepositoryInterface;
    }

    public function createInvoice(array $data)
    {
        return $this->invoiceRepositoryInterface->createInvoice($data);
    }
}
