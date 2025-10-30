<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserModel extends Eloquent
{
    protected $hidden     = ['pivot']; // exclude data of pivot table when fetch relationship
    protected $primaryKey = "ID";
    protected $table      = "users";
    protected $fillable   = [
                            "Role", 
                            "FullName", 
                            "Email", 
                            "Password",
                            "Avatar", 
                            "PhoneNumber" , 
                            "Address",
                            "quotes",
                            "www",
                            "twitter",
                            "instagram",
                            "fb",
                        ];

    public function fieldOwner ()
    {
        return $this->hasOne(FieldOwner::class, "OwnerID", "ID");
    }

    public function likedReviews()
    {
        return $this->belongsToMany(FieldReview::class, "liked", "UserID", "FieldReviewID" );
    }
}
