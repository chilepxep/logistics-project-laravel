@extends('layouts.admin')
@section('title', 'Quản lý Tuyển Dụng')
@section('page_title', 'Quản lý Tin Tuyển Dụng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold m-0">Danh sách Tin Tuyển Dụng</h5>
    <a href="{{ route('admin.recruitments.create') }}" class="btn btn-sm btn-success">
        <i class="bi bi-plus-circle me-1"></i> Thêm tin mới
    </a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Vị trí tuyển dụng</th>
                    <th>Mức lương</th>
                    <th>Khu vực</th>
                    <th>Hạn nộp</th>
                    <th>Trạng thái</th>
                    <th class="text-end pe-4">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recruitments as $job)
                <tr>
                    <td class="ps-4 fw-bold">{{ $job->title }}</td>
                    <td>{{ $job->salary }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->deadline ? $job->deadline->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($job->is_active)
                        <span class="badge bg-success">Đang tuyển</span>
                        @else
                        <span class="badge bg-secondary">Đã đóng</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.recruitments.edit', $job->id) }}" class="btn btn-sm btn-warning"><i
                                class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.recruitments.destroy', $job->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $recruitments->links() }}</div>

@endsection