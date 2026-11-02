<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markRead($id)
    {

        DB::table('user_read_notifications')->insertOrIgnore([
            'user_id' => Auth::id(),
            'notification_id' => $id,
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Lấy ID của tất cả thông báo hệ thống đang có
        $allNotificationIds = \App\Models\SystemNotification::pluck('id');
        
        $insertData = [];
        $now = now();
        
        foreach ($allNotificationIds as $id) {
            $insertData[] = [
                'user_id' => $userId,
                'notification_id' => $id,
                'read_at' => $now
            ];
        }

        \Illuminate\Support\Facades\DB::table('user_read_notifications')->insertOrIgnore($insertData);

        return response()->json(['success' => true]);
    }
}