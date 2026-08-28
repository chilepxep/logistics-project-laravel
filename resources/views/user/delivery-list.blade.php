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
        <h3 class="text-uppercase fw-bold m-0" style="color: #fd7e14;">
            <i class="bi bi-truck me-2"></i> Quản lý Giao hàng
        </h3>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('delivery.index') }}" method="GET" class="row g-3 align-items-end">

                <!-- Lọc theo Đơn vị vận chuyển -->
                <div class="col-md-3">
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

                <!-- Lọc theo Phương thức thanh toán -->
                <div class="col-md-3">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Thanh toán</label>
                    <select name="phuong_thuc_thanh_toan" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="vi_dien_tu"
                            {{ request('phuong_thuc_thanh_toan') == 'vidien__tu' ? 'selected' : '' }}>Ví điện tử
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

                <!-- Lọc theo Trạng thái -->
                <div class="col-md-3">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Trạng thái</label>
                    <select name="trang_thai" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="cho_xu_ly" {{ request('trang_thai') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="dang_xu_ly" {{ request('trang_thai') == 'dang_xu_ly' ? 'selected' : '' }}>Đang
                            giao hàng</option>
                        <option value="da_hoan_thanh" {{ request('trang_thai') == 'da_hoan_thanh' ? 'selected' : '' }}>
                            Đã giao xong</option>
                        <option value="da_huy" {{ request('trang_thai') == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <!-- Nút Lọc và Hủy lọc -->
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold"
                        style="background-color: #fd7e14;">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <!-- Nút Bỏ lọc (reset về trang không có tham số) -->
                    <a href="{{ route('delivery.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-2 p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle font-14 mb-0">
                <thead class="text-center text-white" style="background-color: #fd7e14;">
                    <tr>
                        <th style="width: 5%;">STT</th>
                        <th style="width: 15%;">Mã Kiện Hàng</th>
                        <th style="width: 15%;">Ngày Yêu Cầu</th>
                        <th style="width: 18%;">Đơn Vị Vận Chuyển</th>
                        <th style="width: 15%;">Thanh Toán</th>
                        <th style="width: 15%;">Mã VĐ (Nội Địa)</th>
                        <th style="width: 12%;">Trạng Thái</th>
                        <th style="width: 5%;">Xem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $index => $delivery)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <!-- Mã kiện hàng liên kết -->
                        <td class="text-center fw-bold">
                            <a href="{{ route('package.show', $delivery->package_id) }}" class="text-decoration-none"
                                style="color: #fd7e14;">
                                {{ $delivery->package->ma_don_kien_hang ?? 'N/A' }}
                            </a>
                        </td>

                        <!-- Ngày tạo -->
                        <td class="text-center">{{ \Carbon\Carbon::parse($delivery->ngay_tao)->format('d/m/Y H:i') }}
                        </td>

                        <!-- Phương thức vận chuyển -->
                        <td class="text-center text-uppercase fw-semibold">
                            @switch($delivery->phuong_thuc_van_chuyen)
                            @case('xe_tai') <i class="bi bi-truck-flatbed"></i> Xe Tải @break
                            @case('viettel') <span class="text-danger">Viettel Post</span> @break
                            @case('giao_hang_nhanh') <span class="text-warning">Giao Hàng Nhanh</span> @break
                            @case('giao_hang_tiet_kiem') <span class="text-success">GHTK</span> @break
                            @default {{ $delivery->phuong_thuc_van_chuyen }}
                            @endswitch
                        </td>

                        <!-- Thanh toán -->
                        <td class="text-center">
                            @switch($delivery->phuong_thuc_thanh_toan)
                            @case('vi_dien_tu') Ví Điện Tử @break
                            @case('cod') Thu hộ (COD) @break
                            @case('chuyen_khoan') Chuyển Khoản @break
                            @case('tien_mat') Tiền Mặt @break
                            @default {{ $delivery->phuong_thuc_thanh_toan }}
                            @endswitch
                        </td>

                        <!-- Mã vận đơn trả về từ bên giao hàng -->
                        <td class="text-center fw-bold text-primary">
                            {{ $delivery->ma_van_don ?? 'Đang cập nhật' }}
                        </td>

                        <!-- Trạng thái -->
                        <td class="text-center">
                            @switch($delivery->trang_thai)
                            @case('cho_xu_ly') <span class="badge bg-secondary">Chờ xử lý</span> @break
                            @case('dang_xu_ly') <span class="badge bg-warning text-dark">Đang giao</span> @break
                            @case('da_hoan_thanh') <span class="badge bg-success">Đã giao</span> @break
                            @case('da_huy') <span class="badge bg-danger">Đã hủy</span> @break
                            @endswitch
                        </td>

                        <td class="text-center">
                            <a href="#" class="btn btn-sm text-white" style="background-color: #fd7e14;"
                                title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-scooter fs-1 d-block mb-2" style="color: #fd7e14;"></i>
                            Bạn chưa có yêu cầu giao hàng nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection