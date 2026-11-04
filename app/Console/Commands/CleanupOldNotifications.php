<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\Storage;

class CleanupOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xoá các thông báo hệ thống và file ảnh đính kèm đã cũ hơn 2 tháng';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        // 1. Tìm tất cả thông báo được tạo trước thời điểm 2 tháng cách đây
        $twoMonthsAgo = now()->subMonths(2);
        $oldNotifications = SystemNotification::where('created_at', '<', $twoMonthsAgo)->get();
        
        $count = 0;

        // 2. Lặp qua từng thông báo cũ để xoá ảnh và xoá bản ghi
        foreach ($oldNotifications as $noti) {
            
            // Tìm và xoá ảnh vật lý
            preg_match_all('/<img[^>]+src="([^">]+)"/', $noti->content, $matches);
            $imageUrls = $matches[1];

            foreach ($imageUrls as $url) {
                $relativePath = preg_replace('#^.*/storage/#', '', $url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            // Xoá bản ghi trong Database (các bản ghi ở bảng user_read_notifications sẽ tự động mất theo nếu bạn đã set onDelete('cascade'))
            $noti->delete();
            $count++;
        }

        // In ra màn hình console (nếu chạy tay)
        $this->info("Đã dọn dẹp thành công {$count} thông báo cũ rích!");
    }
}