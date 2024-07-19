<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Liked extends Eloquent
{
    protected $primaryKey = 'ID';
    protected $table = "liked";
    protected $fillable = ["UserID", "FieldReviewID"];
}
