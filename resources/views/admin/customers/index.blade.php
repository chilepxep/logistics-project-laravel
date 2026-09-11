@extends('layouts.admin')
@section('title', 'Quản lý Khách Hàng')
@section('page_title', 'Danh sách Khách Hàng')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <!-- Form Tìm kiếm -->
        <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm tên, SĐT, Mã tài khoản..."
                        value="{{ request('keyword') }}">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Tìm</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle font-14">
                <thead class="table-light">
                    <tr>
                        <th>Mã TK</th>
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Số dư (VNĐ)</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $cus)
                    <tr>
                        <td class="fw-bold text-primary">{{ $cus->ma_tai_khoan }}</td>
                        <td class="fw-bold">{{ $cus->ho_ten }}</td>
                        <td>{{ $cus->sdt ?? '--' }}</td>
                        <td>{{ $cus->email }}</td>
                        <td class="text-danger fw-bold">{{ number_format($cus->so_du) }}đ</td>
                        <td>
                            <a href="{{ route('admin.customers.show', $cus->id) }}"
                                class="btn btn-sm btn-outline-info"><i class="bi bi-person-vcard"></i> Hồ sơ</a>
                            <a href="{{ route('admin.customers.edit', $cus->id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Không tìm thấy khách hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $customers->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection