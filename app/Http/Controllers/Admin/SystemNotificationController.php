<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\Storage;

class SystemNotificationController extends Controller
{
   public function index()
    {
        $notifications = SystemNotification::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'content' => 'required'
        ]);

        SystemNotification::create($request->all());

        return redirect()->route('admin.notifications.index')->with('success', 'Đã đăng thông báo hệ thống mới!');
    }

    public function destroy($id)
        {
            $notification = SystemNotification::findOrFail($id);

            $htmlContent = $notification->content;

            preg_match_all('/<img[^>]+src="([^">]+)"/', $htmlContent, $matches);
            
            $imageUrls = $matches[1];

            foreach ($imageUrls as $url) {
                $relativePath = preg_replace('#^.*/storage/#', '', $url);

                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                }
            }
            
            $notification->delete();
            
            return back()->with('success', 'Đã xoá thông báo và dọn dẹp ảnh thành công!');
        }

    public function show($id)
    {
        $notification = SystemNotification::findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }

    // Hiển thị form Sửa thông báo
    public function edit($id)
    {
        $notification = SystemNotification::findOrFail($id);
        return view('admin.notifications.edit', compact('notification'));
    }

    // Xử lý lưu dữ liệu cập nhật
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'content' => 'required'
        ]);

        $notification = SystemNotification::findOrFail($id);

        // 1. Lấy nội dung HTML CŨ và MỚI
        $oldContent = $notification->content;
        $newContent = $request->input('content');

        // 2. Tìm tất cả các link ảnh trong nội dung CŨ
        preg_match_all('/<img[^>]+src="([^">]+)"/', $oldContent, $oldMatches);
        $oldImages = $oldMatches[1];

        // 3. Tìm tất cả các link ảnh trong nội dung MỚI
        preg_match_all('/<img[^>]+src="([^">]+)"/', $newContent, $newMatches);
        $newImages = $newMatches[1];

        // 4. So sánh: Lấy ra những ảnh CÓ TRONG CŨ nhưng ĐÃ BỊ XÓA KHỎI MỚI
        $deletedImages = array_diff($oldImages, $newImages);

        // 5. Xóa vật lý các ảnh đã bị loại bỏ khỏi server
        foreach ($deletedImages as $url) {
            // Dùng Regex cắt lấy đường dẫn tương đối giống hệt hàm destroy
            $relativePath = preg_replace('#^.*/storage/#', '', $url);

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
            }
        }

        // 6. Cập nhật dữ liệu mới vào Database
        $notification->update($request->all());
        return redirect()->route('admin.notifications.index')->with('success', 'Đã cập nhật thông báo và dọn dẹp ảnh thừa thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $path = $file->storeAs('uploads/notifications', $filename, 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Không tìm thấy file ảnh'], 400);
    }
}