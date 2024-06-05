<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserModel extends Eloquent
{
    protected $table = "users";
    protected $fillable = ["Role", "FullName", "Username", "Password", "PhoneNumber" , "Address"];
}
