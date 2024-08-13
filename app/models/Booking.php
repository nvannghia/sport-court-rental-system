<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Booking extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "booking";
    protected $fillable = [
        "SportFieldID", 
        "FieldNumber", 
        "CustomerID", 
        "CustomerName",  
        "CustomerPhone",
        "CustomerEmail",
        "StartTime",
        "EndTime",
        "PaymentStatus",
        "BookingDate",
    ];

    public function sportField()
    {
        return $this->belongsTo(SportField::class, 'SportFieldID', 'ID');
    }
}
