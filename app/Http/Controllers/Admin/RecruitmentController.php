<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Recruitment;

class RecruitmentController extends Controller
{
    public function index()
    {
        $recruitments = Recruitment::latest()->paginate(10);
        return view('admin.recruitments.index', compact('recruitments'));
    }

    public function create()
    {
        return view('admin.recruitments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'salary' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . Str::random(6); // Tạo slug tự động, chống trùng
        $data['is_active'] = $request->has('is_active');

        Recruitment::create($data);

        return redirect()->route('admin.recruitments.index')->with('success', 'Đã thêm tin tuyển dụng mới!');
    }

    public function edit(Recruitment $recruitment)
    {
        return view('admin.recruitments.edit', compact('recruitment'));
    }

    public function update(Request $request, Recruitment $recruitment)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'salary' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        $data['is_active'] = $request->has('is_active');
        $recruitment->update($data);

        return redirect()->route('admin.recruitments.index')->with('success', 'Đã cập nhật tin tuyển dụng!');
    }

    public function destroy(Recruitment $recruitment)
    {
        $recruitment->delete();
        return redirect()->route('admin.recruitments.index')->with('success', 'Đã xóa tin tuyển dụng!');
    }
}