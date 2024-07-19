<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FieldReview extends Eloquent
{
    protected $hidden = ['pivot']; // exclude data of pivot table when fetch relationship
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

    public function usersLikedReview()
    {
        return $this->belongsToMany(UserModel::class, "liked", "FieldReviewID", "UserID")->select('users.ID');
    }
}
