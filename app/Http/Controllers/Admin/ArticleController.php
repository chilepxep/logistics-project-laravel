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

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required|integer',
            'content'     => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'title'       => $request->title,
            'category_id' => $request->category_id,
            'content'     => $request->content,
            'is_active'   => $request->has('is_active')
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Đã xóa bài viết!');
    }

    
    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['is_active' => !$article->is_active]); // Đảo ngược trạng thái hiện tại
        return redirect()->back()->with('success', 'Đã thay đổi trạng thái bài viết!');
    }

    // Hàm xử lý khi TinyMCE tải ảnh lên
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Lưu trực tiếp vào public_html/uploads/articles
            $file->move(public_path('storage/uploads/articles'), $filename);
            
            return response()->json([
                'location' => asset('storage/uploads/articles/' . $filename)
            ]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}