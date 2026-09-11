@extends('layouts.admin')
@section('title', 'Quản lý Nhân sự')
@section('page_title', 'Danh sách Nhân sự')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold">Danh sách Nhân viên hệ thống</h6>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-sm btn-primary fw-bold">
            <i class="bi bi-plus-lg"></i> Thêm Nhân viên
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle font-14">
                <thead class="table-light">
                    <tr>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                    <tr>
                        <td class="fw-bold text-primary">{{ $emp->ma_nv }}</td>
                        <td class="fw-bold">{{ $emp->ho_ten }}</td>
                        <td>{{ $emp->email }}</td>
                        <td>
                            @if($emp->vai_tro == 'admin')
                            <span class="badge bg-danger"><i class="bi bi-shield-lock"></i> Quản trị viên</span>
                            @else
                            <span class="badge bg-info"><i class="bi bi-person"></i> Nhân viên</span>
                            @endif
                        </td>
                        <td>{{ $emp->created_at->format('d/m/Y') }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.employees.edit', $emp->id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>

                            @if(Auth::guard('employee')->id() != $emp->id)
                            <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xoá nhân viên này?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                        class="bi bi-trash"></i></button>
                            </form>
                            @else
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                title="Không thể tự xoá chính mình" disabled><i class="bi bi-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Chưa có nhân viên nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $employees->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection