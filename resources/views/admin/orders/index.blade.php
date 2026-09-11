@extends('layouts.admin')

@section('title', 'Quản lý Đơn mua hộ')
@section('page_title', 'Danh sách Đơn mua hộ')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <!-- Bộ lọc -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="trang_thai" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="can_xac_nhan_lai"
                        {{ request('trang_thai') == 'can_xac_nhan_lai' ? 'selected' : '' }}>Cần xác nhận lại
                    </option>
                    <option value="da_hoan_thanh" {{ request('trang_thai') == 'da_hoan_thanh' ? 'selected' : '' }}>Đã
                        hoàn thành</option>
                    <option value="da_huy" {{ request('trang_thai') == 'da_huy' ? 'selected' : '' }}>Đã huỷ
                    </option>
                </select>
            </div>
        </form>

        <!-- Bảng dữ liệu -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách Hàng (ID)</th>
                        <th>Tốc Độ</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold text-primary">{{ $order->ma_don_hang }}</td>
                        <td>{{ $order->user->ho_ten ?? 'ID: '.$order->user_id }}</td>
                        <td>
                            <span class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-info' }}">
                                {{ strtoupper($order->yeu_cau_toc_do) }}
                            </span>
                        </td>
                        <td class="text-warning fw-bold">{{ number_format($order->tong_tien) }}đ</td>
                        <td>
                            <span class="badge bg-secondary">{{ $order->trang_thai }}</span>
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info"
                                title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                                class="btn btn-sm btn-outline-warning" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Form xoá đơn hàng -->
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xoá đơn hàng này không? Dữ liệu sẽ không thể khôi phục!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Không có đơn mua hộ nào!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="mt-3">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection