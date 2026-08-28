@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
            <i class="bi bi-list-check me-2"></i> Tất cả đơn hàng
        </h3>
    </div>

    <!-- KHỐI BỘ LỌC -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('order.all') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Loại đơn hàng</label>
                    <select name="loai" class="form-select form-select-sm">
                        <option value="">-- Tất cả loại đơn --</option>
                        <option value="mua_ho" {{ request('loai') == 'mua_ho' ? 'selected' : '' }}>Đơn mua hộ</option>
                        <option value="ky_gui" {{ request('loai') == 'ky_gui' ? 'selected' : '' }}>Đơn ký gửi</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold"
                        style="background-color: #0b3a68;">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('order.all') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH GỘP -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center text-white" style="background-color: #0b3a68;">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 15%;">Mã Đơn Hàng</th>
                            <th style="width: 15%;">Loại Đơn</th>
                            <th style="width: 20%;">Ngày Tạo</th>
                            <th style="width: 25%;">Trạng Thái</th>
                            <th style="width: 20%;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allOrders as $index => $item)
                        <tr>
                            <td class="text-center">
                                {{ ($allOrders->currentPage() - 1) * $allOrders->perPage() + $index + 1 }}</td>

                            <td class="text-center fw-bold text-primary">
                                {{ $item->ma_hien_thi }}
                            </td>

                            <td class="text-center">
                                @if($item->loai_don == 'mua_ho')
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-cart-check"></i> Mua hộ</span>
                                @else
                                <span class="badge bg-success px-2 py-1"><i class="bi bi-truck"></i> Ký gửi</span>
                                @endif
                            </td>

                            <td class="text-center text-muted">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-center">
                                <!-- Hiển thị trạng thái tương ứng -->
                                <span class="badge bg-secondary text-uppercase px-2 py-1">
                                    {{ $item->trang_thai_hien_thi ?? 'Đang xử lý' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($item->loai_don == 'mua_ho')
                                <a href="{{ route('order.show', $item->id ?? 1) }}"
                                    class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                @else
                                <a href="{{ route('consignment.index') }}" class="btn btn-sm btn-outline-success"
                                    title="Xem chi tiết">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-primary"></i>
                                Bạn chưa có đơn hàng nào trên hệ thống.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        @if($allOrders->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $allOrders->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection