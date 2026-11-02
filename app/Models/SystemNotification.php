<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
   protected $fillable = ['type', 'title', 'content'];

    // 1 thông báo có thể được đọc bởi nhiều user
    public function readers()
    {
        return $this->belongsToMany(User::class, 'user_read_notifications', 'notification_id', 'user_id')
                    ->withPivot('read_at');
    }
}