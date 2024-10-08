<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SportType extends Eloquent
{
    protected $primaryKey = 'ID';
    protected $table = "sporttype";
    protected $fillable = ["TypeName"];

    public function sportFields()
    {
        return $this->hasMany(SportField::class, 'SportTypeID', 'ID');
    }
}
