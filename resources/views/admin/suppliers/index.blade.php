@extends('layouts.admin')
@section('title', 'Quản lý Nhà cung cấp')
@section('page_title', 'Danh sách Nhà cung cấp (Suppliers)')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold">Danh sách Đối tác / Nhà cung cấp</h6>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-sm btn-primary fw-bold">
            <i class="bi bi-plus-lg"></i> Thêm Nhà cung cấp
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle font-14">
                <thead class="table-light">
                    <tr>
                        <th>Mã NCC</th>
                        <th>Tên Nhà cung cấp</th>
                        <th>Vị trí (Kho/Nguồn)</th>
                        <th>Hình thức</th>
                        <th>Tổng tiền Đặt hàng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $sup)
                    <tr>
                        <td class="fw-bold text-primary">{{ $sup->ma_ncc }}</td>
                        <td class="fw-bold">
                            {{ $sup->ten_ncc }}<br>
                            <span class="text-muted fw-normal" style="font-size: 12px;">{{ $sup->nganh_hang }}</span>
                        </td>
                        <td>
                            @if($sup->country)
                            <div class="mb-1"><i class="bi bi-globe-asia-australia text-primary"></i>
                                <strong>{{ $sup->country->ten_quoc_gia }}</strong></div>
                            @endif
                            @if($sup->thanh_pho)
                            <span class="text-muted"><i class="bi bi-geo-alt"></i> {{ $sup->thanh_pho }}</span>
                            @endif
                        </td>
                        <td>
                            @if($sup->hinh_thuc == 'online')
                            <span class="badge bg-info text-dark"><i class="bi bi-globe"></i> Online</span>
                            @else
                            <span class="badge bg-secondary"><i class="bi bi-shop"></i> Offline</span>
                            @endif
                        </td>
                        <td class="text-danger fw-bold">{{ number_format($sup->tong_tien_dat_hang) }} đ</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.suppliers.show', $sup->id) }}" class="btn btn-sm btn-outline-info"
                                title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.suppliers.edit', $sup->id) }}"
                                class="btn btn-sm btn-outline-warning" title="Sửa"><i class="bi bi-pencil"></i></a>

                            <form action="{{ route('admin.suppliers.destroy', $sup->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa"><i
                                        class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Chưa có nhà cung cấp nào trong hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $suppliers->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection