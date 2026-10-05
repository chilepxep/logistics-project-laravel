<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function showArticle($category_slug, $article_slug)
    {
        // 1. Tìm danh mục trên Topbar trước
        $category = Category::where('slug', $category_slug)->firstOrFail();

        // 2. Tìm bài viết dựa trên slug VÀ phải thuộc đúng ID của danh mục vừa tìm được
        $article = Article::where('slug', $article_slug)
                        ->where('category_id', $category->id)
                        ->where('is_active', 1)
                        ->firstOrFail();

        // Truyền cả 2 biến ra View để làm Breadcrumb
        return view('frontend.articles.show', compact('article', 'category'));
    }
}