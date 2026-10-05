@extends('layouts.admin')
@section('title', 'Quản lý Bài Viết')
@section('page_title', 'Quản lý Bài Viết')

@section('content')
<div class="card shadow-sm border-0 ">
    <div class="card-header text-black d-flex justify-content-between align-items-center fw-bold ">
        <span>Danh sách bài viết</span>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-sm fw-bold">
            <i class="bi bi-plus-circle"></i> Thêm bài viết mới
        </a>
    </div>

    <div class="card-body p-0 pt-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">ID</th>
                        <th width="35%">Tiêu đề bài viết</th>
                        <th width="15%">Chuyên mục</th>
                        <th width="15%" class="text-center">Trạng thái</th>
                        <th width="15%">Ngày tạo</th>
                        <th width="15%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td class="text-center">{{ $article->id }}</td>
                        <td class="fw-bold text-primary">{{ $article->title }}</td>
                        <td><span class="badge bg-secondary">{{ $article->category->name ?? 'Không có' }}</span></td>

                        <!-- Cột Trạng thái (Nút gạt Ẩn/Hiện) -->
                        <td class="text-center">
                            <form action="{{ route('admin.articles.toggle', $article->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $article->is_active ? 'checked' : '' }}>
                                </div>
                            </form>
                        </td>

                        <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>

                        <!-- Cột Thao tác -->
                        <td class="text-center">
                            <!-- Nút Xem trước ngoài Frontend -->
                            @if($article->category)
                            <a href="{{ url($article->category->slug . '/' . $article->slug) }}" target="_blank"
                                class="btn btn-sm btn-info text-white" title="Xem bài">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif

                            <!-- Nút Sửa -->
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-warning"
                                title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Nút Xóa -->
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $articles->links() }}
    </div>
</div>

@endsection