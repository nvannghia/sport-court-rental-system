<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Notification extends Eloquent
{
    protected $primaryKey = "ID";
    protected $table = "notification";
    protected $fillable = [
        'user_trigger_id',
        "user_receiver_id",
        "content",
        "action",
        "status"
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::instance($date)
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('Y-m-d H:i:s');
    }
}
