<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class SportField extends Eloquent
{
    use SoftDeletes;
    protected $primaryKey = "ID";
    protected $table = "sportfield";
    protected $fillable = [
        "OwnerID", "SportTypeID", "FieldName", "Status", "PricePerHour", "NumberOfFields", "Address", "Description"
    ];

    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'SportTypeID', 'ID');
    }

    public function owner()
    {
        return $this->belongsTo(UserModel::class, 'OwnerID', 'ID');
    }
}
