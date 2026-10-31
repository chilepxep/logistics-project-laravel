@extends('layouts.user')

@section('title', 'Quản lý Giao hàng')

@section('content')

@if($errors->any())
<div class="alert alert-danger shadow-sm border-0 rounded-3">
    <ul class="mb-0">
        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
</div>
@endif

<div class="container-fluid mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-uppercase fw-bold m-0" style="color: #fd7e14;">
            <i class="bi bi-truck me-2"></i> Quản lý Giao hàng
        </h4>
    </div>

    <!-- KHỐI BỘ LỌC -->
    <div class="card shadow-sm border-0 mb-4 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('delivery.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label font-13 fw-semibold text-muted mb-2">Đơn vị vận chuyển</label>
                    <select name="phuong_thuc_van_chuyen" class="form-select form-select-sm shadow-none">
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
                        <option value="grab" {{ request('phuong_thuc_van_chuyen') == 'grab' ? 'selected' : '' }}>Grab
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-13 fw-semibold text-muted mb-2">Thanh toán</label>
                    <select name="phuong_thuc_thanh_toan" class="form-select form-select-sm shadow-none">
                        <option value="">-- Tất cả --</option>
                        <option value="vi_dien_tu"
                            {{ request('phuong_thuc_thanh_toan') == 'vi_dien_tu' ? 'selected' : '' }}>Ví điện tử
                        </option>
                        <option value="cod" {{ request('phuong_thuc_thanh_toan') == 'cod' ? 'selected' : '' }}>Thu hộ
                            (COD)</option>
                        <option value="chuyen_khoan"
                            {{ request('phuong_thuc_thanh_toan') == 'chuyen_khoan' ? 'selected' : '' }}>Chuyển khoản
                        </option>
                        <option value="nguoi_nhan_tra"
                            {{ request('phuong_thuc_thanh_toan') == 'nguoi_nhan_tra' ? 'selected' : '' }}>Tiền mặt
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-13 fw-semibold text-muted mb-2">Trạng thái</label>
                    <select name="trang_thai" class="form-select form-select-sm shadow-none">
                        <option value="">-- Tất cả --</option>
                        <option value="cho_xu_ly" {{ request('trang_thai') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="dang_van_chuyen"
                            {{ request('trang_thai') == 'dang_van_chuyen' ? 'selected' : '' }}>Đang đi giao</option>
                        <option value="den_kho_nhan_hang"
                            {{ request('trang_thai') == 'den_kho_nhan_hang' ? 'selected' : '' }}>Đến kho nhận</option>
                        <option value="thanh_cong" {{ request('trang_thai') == 'thanh_cong' ? 'selected' : '' }}>Đã giao
                            xong</option>
                        <option value="da_huy" {{ request('trang_thai') == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white w-100 fw-semibold shadow-sm"
                        style="background-color: #fd7e14; height: 31px;">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('delivery.index') }}"
                        class="btn btn-sm btn-light border w-100 fw-semibold text-muted shadow-sm d-flex align-items-center justify-content-center"
                        style="height: 31px;">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-3 align-items-stretch">

        <!-- Thẻ: Khách đến kho lấy -->
        <div class="col-12 col-md-6 col-lg-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded d-flex justify-content-center align-items-center me-3 flex-shrink-0"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-shop fs-4"></i>
                    </div>

                    <div class="d-flex flex-column">
                        <span class="text-muted font-12 text-uppercase fw-semibold mb-1">
                            Đến kho lấy
                        </span>
                        <div class="d-flex align-items-baseline">
                            <span class="fw-bold text-dark fs-5 me-1">
                                {{ $summary['nhan_tai_kho'] ?? 0 }}
                            </span>
                            <span class="text-muted font-13">kiện</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thẻ: Ship hàng tận nơi -->
        <div class="col-12 col-md-6 col-lg-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded d-flex justify-content-center align-items-center me-3 flex-shrink-0"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-truck fs-4"></i>
                    </div>

                    <div class="d-flex flex-column">
                        <span class="text-muted font-12 text-uppercase fw-semibold mb-1">
                            Ship tận nơi
                        </span>
                        <div class="d-flex align-items-baseline">
                            <span class="fw-bold text-dark fs-5 me-1">
                                {{ $summary['giao_tan_noi'] ?? 0 }}
                            </span>
                            <span class="text-muted font-13">kiện</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cảnh báo quy định lưu kho -->
        <div class="col-12 col-lg-8">
            <div class="alert alert-warning d-flex align-items-center h-100 mb-0 shadow-sm border-0 rounded-3"
                style="background-color: #fff3cd;" role="alert">

                <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning flex-shrink-0"></i>

                <div class="font-14 text-dark">
                    <h6 class="alert-heading fw-bold mb-1">
                        Quy định về thời gian nhận hàng!
                    </h6>

                    <span class="text-muted">
                        Đối với các đơn giao hàng không thành công hoặc chờ khách đến lấy,
                        nếu sau <strong>3 ngày</strong> kể từ khi có yêu cầu xuất kho mà quý khách
                        chưa nhận hàng, hệ thống sẽ tự động cộng thêm phụ phí lưu kho là
                        <strong class="text-danger">15.000 VNĐ/ngày</strong>.
                    </span>
                </div>
            </div>
        </div>

    </div>




    <!-- BẢNG DANH SÁCH -->
    <div class="bg-white shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle font-14 mb-0 border-top-0">
                <thead class="text-center text-white" style="background-color: #fd7e14;">
                    <tr>
                        <th class="py-3 fw-semibold border-0" style="width: 5%;">STT</th>
                        <th class="py-3 fw-semibold border-0" style="width: 18%;">Mã Kiện Hàng</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Ngày Yêu Cầu</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Hình thức</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Thanh Toán</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Mã VĐ (Nội Địa)</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Ngày Nhận Hàng</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Tổng Tiền</th>
                        <th class="py-3 fw-semibold border-0" style="width: 11%;">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($deliveries as $index => $delivery)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>

                        <!-- Mã kiện hàng & Cảnh báo phạt -->
                        <td class="text-center py-2">
                            <a href="{{ route('package.show', $delivery->package_id) }}"
                                class="text-decoration-none fw-bold" style="color: #fd7e14; font-size: 14.5px;">
                                {{ $delivery->package->ma_don_kien_hang ?? 'N/A' }}
                            </a>

                            <!-- UI Phạt tiền thanh lịch hơn -->
                            @if($delivery->trang_thai != 'thanh_cong' && $delivery->so_ngay_tre > 0)
                            <div class="mt-2 d-flex justify-content-center">
                                <span
                                    class="d-inline-flex align-items-center gap-1 bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill font-12 fw-semibold">
                                    <i class="bi bi-clock-history"></i> Trễ {{ $delivery->so_ngay_tre }} ngày
                                    (+{{ number_format($delivery->phu_phi_tre_han) }}đ)
                                </span>
                            </div>
                            @endif
                        </td>

                        <td class="text-center text-muted">
                            {{ \Carbon\Carbon::parse($delivery->ngay_tao)->format('d/m/Y H:i') }}</td>

                        <td class="text-center text-uppercase fw-semibold" style="color: #495057;">
                            @switch($delivery->phuong_thuc_van_chuyen)
                            @case('xe_tai') <i class="bi bi-truck-flatbed me-1"></i> Xe Tải @break
                            @case('viettel') <span class="text-danger">Viettel Post</span> @break
                            @case('giao_hang_nhanh') <span class="text-warning">Giao Hàng Nhanh</span> @break
                            @case('giao_hang_tiet_kiem') <span class="text-success">GHTK</span> @break
                            @default {{ $delivery->phuong_thuc_van_chuyen }}
                            @endswitch
                        </td>

                        <td class="text-center text-muted">
                            @switch($delivery->phuong_thuc_thanh_toan)
                            @case('vi_dien_tu') Ví Điện Tử @break
                            @case('cod') Thu hộ (COD) @break
                            @case('chuyen_khoan') Chuyển Khoản @break
                            @case('da_thanh_toan') Đã thanh toán @break
                            @case('nguoi_nhan_tra') Khách trả (FOB) @break
                            @default {{ $delivery->phuong_thuc_thanh_toan }}
                            @endswitch
                        </td>

                        <!-- Xử lý text "Chưa có" mềm mại hơn -->
                        <td class="text-center">
                            @if($delivery->ma_van_don)
                            <span class="fw-bold text-primary">{{ $delivery->ma_van_don }}</span>
                            @else
                            <span class="text-muted fst-italic font-13">Chưa có</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($delivery->ngay_giao_xong)
                            <span
                                class="fw-bold text-primary">{{ \Carbon\Carbon::parse($delivery->ngay_giao_xong)->format('d/m/Y H:i') }}</span>
                            @else
                            <span class="text-muted fst-italic font-13">Chưa có</span>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            @php
                            // 1. Tính toán tiền gốc và tiền phạt của riêng kiện hàng/giao hàng này
                            $pkg = $delivery->package;
                            $baseAmount = $pkg->thanh_tien ?? 0;
                            $penalty = 0;

                            if ($delivery->trang_thai != 'thanh_cong') {
                            $penalty = $delivery->phu_phi_tre_han ?? 0;
                            }

                            $totalAmount = $baseAmount + $penalty;
                            @endphp

                            <!-- 2. Hiển thị tổng tiền và Nút xem chi tiết -->
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="fw-bold text-success" style="font-size: 15px;">
                                    {{ number_format($totalAmount) }}đ
                                </span>

                                <!-- Nút mở Modal Info -->
                                <button type="button" class="btn btn-sm btn-link p-0 text-info ms-2"
                                    data-bs-toggle="modal" data-bs-target="#feeDetailsModal{{ $delivery->id }}"
                                    title="Xem chi tiết các loại phí">
                                    <i class="bi bi-info-circle-fill fs-5"></i>
                                </button>
                            </div>

                            <!-- 3. Ghi chú phạt (Nếu có) -->
                            @if($penalty > 0)
                            <div class="mt-1">
                                <span
                                    class="d-inline-block bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0 rounded font-11">
                                    Gồm: {{ number_format($penalty) }}đ phạt trễ
                                </span>
                            </div>
                            @endif

                            <!-- 4. MODAL CHI TIẾT CHI PHÍ -->
                            @php
                            // XÁC ĐỊNH ĐƠN CHA VÀ TỔNG TIỀN ĐƠN CHA (Logic mới chuẩn xác)
                            $tongTienDonCha = 0;
                            $tenLoaiDon = 'Chưa xác định';
                            $maDonCha = '';

                            if ($pkg && $pkg->order_id && $pkg->order) {
                            $tenLoaiDon = 'Đơn Mua Hộ';
                            $maDonCha = $pkg->order->ma_don_hang;
                            // Tổng tiền đơn cha = Tổng thanh_tien của TẤT CẢ kiện hàng thuộc đơn này
                            $tongTienDonCha = $pkg->order->packages ? $pkg->order->packages->sum('thanh_tien') : 0;
                            }
                            elseif ($pkg && $pkg->consignment_order_id && $pkg->consignmentOrder) {
                            $tenLoaiDon = 'Đơn Ký Gửi';
                            $maDonCha = $pkg->consignmentOrder->ma_don_ky_gui;
                            // Tổng tiền đơn cha = Tổng thanh_tien của TẤT CẢ kiện hàng thuộc đơn này
                            $tongTienDonCha = $pkg->consignmentOrder->packages ?
                            $pkg->consignmentOrder->packages->sum('thanh_tien') : 0;
                            }
                            @endphp

                            <div class="modal fade text-start" id="feeDetailsModal{{ $delivery->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow border-0">
                                        <div class="modal-header bg-light border-bottom-0">
                                            <h5 class="modal-title fw-bold text-dark font-15">
                                                <i class="bi bi-receipt text-primary me-2"></i> Chi tiết cước kiện hàng
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-0 font-14">
                                            <ul class="list-group list-group-flush">
                                                <!-- Phí của kiện hàng hiện tại -->
                                                <li
                                                    class="list-group-item bg-light text-muted fw-bold font-13 text-uppercase">
                                                    Mã kiện: {{ $pkg->ma_don_kien_hang ?? 'N/A' }}
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span class="text-muted">Phí vận chuyển nội địa:</span>
                                                    <span
                                                        class="fw-semibold text-dark">{{ number_format($pkg->phi_van_chuyen_noi_dia ?? 0) }}đ</span>
                                                </li>

                                                <!-- Ẩn dòng phí khác nếu bằng 0 (Giúp Đơn Mua Hộ gọn gàng hơn) -->
                                                @if(($pkg->phi_khac ?? 0) > 0)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span class="text-muted">Phí dịch vụ khác (Đóng gỗ, bốc
                                                        xếp...):</span>
                                                    <span
                                                        class="fw-semibold text-dark">{{ number_format($pkg->phi_khac) }}đ</span>
                                                </li>
                                                @endif

                                                <!-- Ẩn dòng chiết khấu nếu bằng 0 -->
                                                @if(($pkg->chiet_khau ?? 0) > 0)
                                                <li class="list-group-item d-flex justify-content-between text-success">
                                                    <span>Chiết khấu / Giảm giá:</span>
                                                    <span class="fw-bold">-
                                                        {{ number_format($pkg->chiet_khau) }}đ</span>
                                                </li>
                                                @endif

                                                <!-- Phụ phí lưu kho trễ hạn -->
                                                @if($penalty > 0)
                                                <li
                                                    class="list-group-item d-flex justify-content-between text-danger bg-danger bg-opacity-10 border-danger border-opacity-25">
                                                    <span class="fw-semibold"><i
                                                            class="bi bi-exclamation-circle-fill me-1"></i> Phụ phí lưu
                                                        kho trễ hạn:</span>
                                                    <span class="fw-bold">+ {{ number_format($penalty) }}đ</span>
                                                </li>
                                                @endif

                                                <!-- Tổng tiền kiện hàng này -->
                                                <li
                                                    class="list-group-item d-flex justify-content-between fw-bold border-bottom border-2 py-3 bg-white">
                                                    <span class="text-dark fs-6">Tổng khách trả cho kiện này:</span>
                                                    <span
                                                        class="text-success fs-5">{{ number_format($totalAmount) }}đ</span>
                                                </li>

                                                <!-- Thông tin tổng quan Đơn hàng cha -->
                                                <li
                                                    class="list-group-item bg-light text-muted fw-bold font-13 mt-2 text-uppercase">
                                                    Tổng quan {{ $tenLoaiDon }}: {{ $maDonCha }}
                                                </li>
                                                <li
                                                    class="list-group-item d-flex flex-column bg-warning bg-opacity-10 py-3 border-bottom-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-semibold text-dark">Tổng khách phải thanh
                                                            toán:</span>
                                                        <span
                                                            class="text-danger fw-bold fs-5">{{ number_format($tongTienDonCha) }}đ</span>
                                                    </div>
                                                    <small class="text-muted font-11 mt-1">
                                                        * Bao gồm tiền hàng và tất cả các kiện hàng thuộc đơn này.
                                                    </small>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer bg-light p-2 border-top-0">
                                            <button type="button" class="btn btn-secondary btn-sm px-4"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            @switch($delivery->trang_thai)
                            @case('cho_xu_ly') <span class="badge bg-secondary">Chờ xử lý</span> @break
                            @case('dang_giao') <span class="badge bg-warning text-dark">Đang giao</span> @break
                            @case('thanh_cong') <span class="badge bg-success">Đã giao</span> @break
                            @case('da_huy') <span class="badge bg-danger">Đã hủy</span> @break
                            @endswitch
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-3" style="color: #dee2e6;"></i>
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