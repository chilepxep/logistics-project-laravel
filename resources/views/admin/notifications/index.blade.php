@extends('layouts.admin')
@section('title', 'Quản lý Thông báo')
@section('page_title', 'Danh sách Thông báo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Lịch Sử Thông Báo</h4>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Đăng
            thông báo mới</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Ngày đăng</th>
                        <th>Loại</th>
                        <th>Tiêu đề</th>
                        <th>Lượt xem</th>
                        <th class="text-center pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $noti)
                    <tr>
                        <td class="ps-4 text-muted">{{ $noti->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($noti->type == 'promotion') <span class="badge bg-primary">Khuyến mãi</span> @endif
                            @if($noti->type == 'price') <span class="badge bg-danger">Tỷ giá</span> @endif
                            @if($noti->type == 'system') <span class="badge bg-secondary">Hệ thống</span> @endif
                        </td>
                        <td class="fw-bold">{{ $noti->title }}</td>
                        <!-- Dùng withCount để đếm số user đã đọc -->
                        <td>{{ $noti->readers()->count() }} lượt</td>
                        <td class="text-center pe-4">
                            <!-- Nút Xem -->
                            <a href="{{ route('admin.notifications.show', $noti->id) }}"
                                class="btn btn-sm btn-outline-info" title="Xem chi tiết"><i class="bi bi-eye"></i></a>

                            <!-- Nút Sửa -->
                            <a href="{{ route('admin.notifications.edit', $noti->id) }}"
                                class="btn btn-sm btn-outline-warning mx-1" title="Chỉnh sửa"><i
                                    class="bi bi-pencil"></i></a>

                            <form action="{{ route('admin.notifications.destroy', $noti->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Xoá thông báo này khỏi hệ thống?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Xóa"><i
                                        class="bi bi-trash"></i></button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection