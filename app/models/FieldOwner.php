<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FieldOwner extends Eloquent
{
    protected $table = "fieldowner";
    protected $fillable = ["OwnerID", "Active", "BusinessName", "BusinessAddress", "PhoneNumber"];
}
