@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

<div class="container-fluid mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #198754;">
            <i class="bi bi-check2-circle me-2"></i> Lịch sử Đã Giao Hàng
        </h3>
    </div>

    <!-- KHỐI BỘ LỌC TÌM KIẾM (Đã bỏ cột Trạng thái) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('delivery.completed') }}" method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Đơn vị vận chuyển</label>
                    <select name="phuong_thuc_van_chuyen" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="xe_tai" {{ request('phuong_thuc_van_chuyen') == 'xe_tai' ? 'selected' : '' }}>Xe
                            Tải</option>
                        <option value="viettel" {{ request('phuong_thuc_van_chuyen') == 'viettel' ? 'selected' : '' }}>
                            Viettel Post</option>
                        <option value="giao_hang_nhanh"
                            {{ request('phuong_thuc_van_chuyen') == 'giao_hang_nhanh' ? 'selected' : '' }}>Giao Hàng
                            Nhanh</option>
                        <option value="giao_hang_tiet_kiem"
                            {{ request('phuong_thuc_van_chuyen') == 'giao_hang_tiet_kiem' ? 'selected' : '' }}>GHTK
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Thanh toán phí</label>
                    <select name="phuong_thuc_thanh_toan" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="vi_dien_tu"
                            {{ request('phuong_thuc_thanh_toan') == 'vi_dien_tu' ? 'selected' : '' }}>Ví điện tử
                        </option>
                        <option value="cod" {{ request('phuong_thuc_thanh_toan') == 'cod' ? 'selected' : '' }}>Thu hộ
                            (COD)</option>
                        <option value="chuyen_khoan"
                            {{ request('phuong_thuc_thanh_toan') == 'chuyen_khoan' ? 'selected' : '' }}>Chuyển khoản
                        </option>
                        <option value="tien_mat"
                            {{ request('phuong_thuc_thanh_toan') == 'tien_mat' ? 'selected' : '' }}>Tiền mặt</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold"
                        style="background-color: #198754;">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('delivery.completed') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH -->
    <div class="bg-white shadow-sm rounded-2 p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle font-14 mb-0">
                <thead class="text-center text-white" style="background-color: #198754;">
                    <tr>
                        <th style="width: 5%;">STT</th>
                        <th style="width: 15%;">Mã Kiện Hàng</th>
                        <th style="width: 15%;">Ngày Giao Xong</th>
                        <th style="width: 20%;">Đơn Vị Vận Chuyển</th>
                        <th style="width: 15%;">Thanh Toán</th>
                        <th style="width: 15%;">Mã VĐ (Nội Địa)</th>
                        <th style="width: 10%;">Xem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $index => $delivery)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <!-- Mã kiện hàng liên kết -->
                        <td class="text-center fw-bold">
                            <a href="{{ route('package.show', $delivery->package_id) }}" class="text-decoration-none"
                                style="color: #198754;">
                                {{ $delivery->package->ma_don_kien_hang ?? 'N/A' }}
                            </a>
                        </td>

                        <!-- Giả định dùng ngay_tao, nếu bảng có ngay_hoan_thanh thì bạn sửa lại nhé -->
                        <td class="text-center">{{ \Carbon\Carbon::parse($delivery->ngay_tao)->format('d/m/Y H:i') }}
                        </td>

                        <td class="text-center text-uppercase fw-semibold">
                            @switch($delivery->phuong_thuc_van_chuyen)
                            @case('xe_tai') <i class="bi bi-truck-flatbed"></i> Xe Tải @break
                            @case('viettel') <span class="text-danger">Viettel Post</span> @break
                            @case('giao_hang_nhanh') <span class="text-warning">Giao Hàng Nhanh</span> @break
                            @case('giao_hang_tiet_kiem') <span class="text-success">GHTK</span> @break
                            @default {{ $delivery->phuong_thuc_van_chuyen }}
                            @endswitch
                        </td>

                        <td class="text-center">
                            @switch($delivery->phuong_thuc_thanh_toan)
                            @case('vi_dien_tu') Ví Điện Tử @break
                            @case('cod') Thu hộ (COD) @break
                            @case('chuyen_khoan') Chuyển Khoản @break
                            @case('tien_mat') Tiền Mặt @break
                            @default {{ $delivery->phuong_thuc_thanh_toan }}
                            @endswitch
                        </td>

                        <td class="text-center fw-bold text-primary">
                            {{ $delivery->ma_van_don ?? 'Đang cập nhật' }}
                        </td>

                        <td class="text-center">
                            <a href="#" class="btn btn-sm text-white" style="background-color: #198754;"
                                title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box2-heart fs-1 d-block mb-2 text-success"></i>
                            Bạn chưa có đơn hàng nào hoàn tất giao nhận.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection