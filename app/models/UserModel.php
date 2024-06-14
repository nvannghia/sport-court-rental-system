<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserModel extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "users";
    protected $fillable = ["Role", "FullName", "Email", "Password", "PhoneNumber" , "Address"];

    public function fieldOwner ()
    {
        return $this->hasOne(FieldOwner::class, "OwnerID", "ID");
    }
}
