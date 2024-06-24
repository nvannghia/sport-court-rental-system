<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SportField extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "sportfield";
    protected $fillable = [
        "OwnerID", "SportTypeID", "FieldName", "Status", "PricePerHour", "NumberOfFields", "Address", "Description"
    ];

    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'SportTypeID', 'ID');
    }
}
