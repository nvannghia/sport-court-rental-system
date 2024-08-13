<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Invoice extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "invoice";
    protected $fillable = [
        "BookingID",
        "TotalAmount",
        "PaymentDate",
        "PaymentMethod",
    ];
}
