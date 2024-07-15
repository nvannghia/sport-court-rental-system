<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FieldReview extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "fieldreview";
    protected $fillable = [
        "SportFieldID",
        "UserID",
        "Rating",
        "Content",
        "ImageReview"
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, "UserID", "ID");
    }
}
