<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{


    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }
    public function create() {
        //lay danh muc
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|integer',
            'content'     => 'required',
        ]);

        Article::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'content'     => $request->content,
            'is_active'   => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'Đăng bài viết thành công!');
    }

    
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    
// Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|integer',
            'content'     => 'required',
        ]);

        $article = Article::findOrFail($id);

        $oldContent = stripslashes($article->content);
        $newContent = stripslashes($request->input('content'));

        // 1. Quét lấy mảng link thô
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $oldContent, $oldMatches);
        $oldImagesRaw = $oldMatches[1];

        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $newContent, $newMatches);
        $newImagesRaw = $newMatches[1];

        // 2. CHUẨN HÓA MẢNG CŨ (Chỉ lấy lõi đuôi, vd: 'uploads/articles/anh.png')
        $oldImagesClean = [];
        foreach ($oldImagesRaw as $url) {
            $parts = explode('/storage/', $url);
            $relativePath = end($parts); // Lấy phần sau chữ /storage/
            $oldImagesClean[] = urldecode(ltrim($relativePath, '/'));
        }

        // 3. CHUẨN HÓA MẢNG MỚI
        $newImagesClean = [];
        foreach ($newImagesRaw as $url) {
            $parts = explode('/storage/', $url);
            $relativePath = end($parts);
            $newImagesClean[] = urldecode(ltrim($relativePath, '/'));
        }

        // 4. SO SÁNH 2 MẢNG ĐÃ CHUẨN HÓA (Đảm bảo độ chính xác tuyệt đối)
        $deletedImages = array_diff($oldImagesClean, $newImagesClean);

        // 5. Xóa file vật lý
        foreach ($deletedImages as $relativePath) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
            }
        }

        // 6. Lưu Database
        $article->update([
            'title'       => $request->title,
            'category_id' => $request->category_id,
            'content'     => $request->content,
            'is_active'   => $request->has('is_active')
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Cập nhật bài viết và dọn dẹp ảnh thừa thành công!');
    }

    
    // Xóa bài viết
public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $htmlContent = stripslashes($article->content);

        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $htmlContent, $matches);
        $imageUrls = $matches[1];

        // Xóa vật lý toàn bộ ảnh đính kèm
        foreach ($imageUrls as $url) {
            // Tách chuỗi bằng chữ /storage/ và lấy phần đuôi cuối cùng
            $parts = explode('/storage/', $url);
            $relativePath = end($parts);
            
            $relativePath = urldecode(ltrim($relativePath, '/'));

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
            }
        }

        // Xóa khỏi DB
        $article->delete();
        
        return redirect()->route('admin.articles.index')->with('success', 'Đã xóa bài viết và dọn sạch file vật lý!');
    }

    
    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['is_active' => !$article->is_active]); // Đảo ngược trạng thái hiện tại
        return redirect()->back()->with('success', 'Đã thay đổi trạng thái bài viết!');
    }

// Xử lý upload ảnh từ TinyMCE cho Bài viết
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Lưu vào đúng thư mục articles
            $path = $file->storeAs('uploads/articles', $filename, 'public');

            // Trả về link tương đối để không bị lỗi 403
            return response()->json([
                'location' => '/storage/' . $path
            ]);
        }

        return response()->json(['error' => 'Không tìm thấy file ảnh'], 400);
    }
}