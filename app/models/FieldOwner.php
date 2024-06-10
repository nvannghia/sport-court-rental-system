<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FieldOwner extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "fieldowner";
    protected $fillable = ["OwnerID", "Status", "BusinessName", "BusinessAddress", "PhoneNumber"];
}
