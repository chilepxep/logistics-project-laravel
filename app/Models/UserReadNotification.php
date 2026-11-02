<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReadNotification extends Model
{
    public $timestamps = false; 
    protected $fillable = ['user_id', 'notification_id', 'read_at'];
}