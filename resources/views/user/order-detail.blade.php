@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> <strong>Thành công!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lỗi!</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="container-fluid mt-4 px-4">
    <!-- Nút quay lại và Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('list.order') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
                Chi tiết đơn mua hộ: <span class="text-primary">#{{ $order->ma_don_hang }}</span>
            </h3>
        </div>
        <div>
            @if($order->trang_thai == 'cho_xu_ly')
            <span class="badge bg-warning text-dark px-2 py-1">Chờ xử lý</span>
            @elseif($order->trang_thai == 'dang_xu_ly')
            <span class="badge bg-primary px-2 py-1">Đang xử lý</span>
            @elseif($order->trang_thai == 'dang_giao_hang')
            <span class="badge bg-primary px-2 py-1">Đang giao hàng</span>
            @elseif($order->trang_thai == 'can_lien_he_lai')
            <span class="badge bg-info text-dark px-2 py-1">Cần liên hệ lại</span>
            @elseif($order->trang_thai == 'hoan_thanh')
            <span class="badge bg-success px-2 py-1">Hoàn thành</span>
            @elseif($order->trang_thai == 'da_huy')
            <span class="badge bg-secondary px-2 py-1">Đã hủy</span>
            @endif
        </div>
    </div>


    <!-- Thông tin chung của đơn hàng -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <!-- Header -->
        <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
            <h6 class="fw-bold text-primary mb-0 text-uppercase" style="letter-spacing: 0.5px;">
                <i class="bi bi-info-circle-fill me-2"></i>Thông tin chung
            </h6>
        </div>

        <div class="card-body pt-2">
            <div class="row g-4">

                <!-- Cột trái -->
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Ngày tạo:</span>
                            <span class="fw-bold text-dark fs-6"><i
                                    class="bi bi-calendar-event text-secondary me-2"></i>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Yêu cầu tốc độ:</span>
                            <span
                                class="fw-bold fs-6 {{ $order->yeu_cau_toc_do == 'nhanh' ? 'text-danger' : 'text-primary' }}">
                                <i class="bi bi-lightning-charge-fill me-1"></i>
                                {{ $order->yeu_cau_toc_do == 'nhanh' ? 'Giao Hỏa Tốc' : 'Tiêu Chuẩn' }}
                            </span>
                        </div>
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Tổng tiền hàng:</span>
                            <span class="fw-bold text-danger fs-5">{{ number_format($order->tong_tien, 0, ',', '.') }}
                                <small class="text-muted fs-6 fw-normal">VNĐ</small></span>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Kho nhận hàng (VN):</span>
                            <span class="fw-bold text-dark fs-6"><i
                                    class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $order->khoNhan->ten_kho ?? 'N/A' }}</span>
                        </div>
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Tình trạng thanh toán:</span>
                            @if($order->trang_thai_thanh_toan == 'chua_thanh_toan')
                            <span
                                class="badge bg-warning text-dark px-3 py-2 rounded-2 fw-semibold border border-warning">
                                <i class="bi bi-clock-history me-1"></i> Chưa thanh toán
                            </span>
                            @elseif($order->trang_thai_thanh_toan == 'da_thanh_toan')
                            <span class="badge bg-success px-3 py-2 rounded-2 fw-semibold">
                                <i class="bi bi-check-circle-fill me-1"></i> Đã thanh toán
                            </span>
                            @endif
                        </div>
                        <!-- Item -->
                        <div>
                            <span class="text-muted font-13 d-block mb-1">Dịch vụ yêu cầu:</span>
                            @if(isset($order->extraRequirements) && $order->extraRequirements->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($order->extraRequirements as $req)
                                @if($req->loai_yeu_cau == 'dong_go')
                                <span class="badge bg-secondary rounded-2 py-2 px-3 fw-normal shadow-sm"><i
                                        class="bi bi-box-seam me-1"></i> Đóng gỗ</span>
                                @elseif($req->loai_yeu_cau == 'kiem_hang')
                                <span class="badge bg-info text-dark rounded-2 py-2 px-3 fw-normal shadow-sm"><i
                                        class="bi bi-search me-1"></i> Kiểm hàng</span>
                                @elseif($req->loai_yeu_cau == 'khai_thue_gtgt')
                                <span class="badge bg-dark rounded-2 py-2 px-3 fw-normal shadow-sm"><i
                                        class="bi bi-receipt me-1"></i> Khai thuế</span>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <span class="fst-italic text-muted font-13">Không sử dụng dịch vụ thêm</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Khối Lộ trình & Nút theo dõi bọc trong 1 khung riêng biệt -->
                <div class="col-12 mt-4">
                    <div class="p-3 bg-light rounded-3 border border-light-subtle">
                        <div class="row align-items-center g-3">

                            <!-- Lộ trình -->
                            <div class="col-md-8">
                                <span class="text-muted font-13 d-block mb-2">Lộ trình vận chuyển:</span>
                                <div class="d-flex align-items-center flex-wrap gap-2 font-14">
                                    <div
                                        class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                        <span class="badge bg-warning text-dark me-2">TỪ</span>
                                        <strong class="text-dark">{{ $order->supplier->ten_ncc ?? 'Kho Quốc Tế' }}
                                            ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                                    </div>

                                    <i class="bi bi-arrow-right text-muted mx-1 fs-5 d-none d-md-block"></i>
                                    <i class="bi bi-arrow-down text-muted my-1 fs-5 d-block d-md-none"></i>

                                    <div
                                        class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                        <span class="badge bg-success me-2">ĐẾN</span>
                                        <strong
                                            class="text-success">{{ $order->khoNhan->ten_kho ?? 'Chưa chọn' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Nút bấm -->
                            <div class="col-md-4 text-md-end border-md-start ps-md-4">
                                <span class="text-muted font-13 d-block mb-2 text-md-center">Tra cứu lộ trình:</span>
                                @php
                                $firstPackage = $order->packages->first() ?? null;
                                @endphp

                                @if($firstPackage)
                                <a href="{{ route('package.show', $firstPackage->id) }}"
                                    class="btn btn-primary fw-bold px-4 py-2 w-100 shadow-sm rounded-3">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Xem chi tiết kiện hàng
                                </a>
                                @else
                                <button class="btn btn-secondary disabled px-4 py-2 w-100 rounded-3 border-0"
                                    style="opacity: 0.65; cursor: not-allowed;">
                                    <i class="bi bi-hourglass-split me-1"></i> Chưa có kiện hàng
                                </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm (Items) -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-bold text-uppercase">
            <i class="bi bi-box me-1"></i> Danh sách sản phẩm
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 10%;">Hình ảnh</th>
                            <th style="width: 25%;">Tên sản phẩm</th>
                            <th style="width: 15%;">Thuộc tính (Màu, Size)</th>
                            <th style="width: 10%;">Số lượng</th>
                            <th style="width: 15%;">Đơn giá ({{ $order->country->tien_te ?? '¥' }})</th>
                            <th style="width: 20%;">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                @if($item->hinh_anh_url)
                                <img src="{{ $item->hinh_anh_url }}" alt="sp"
                                    style="width: 60px; height: 60px; object-fit: cover;" class="border rounded">
                                @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded mx-auto"
                                    style="width: 60px; height: 60px;">No IMG</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $item->link_san_pham ?? '#' }}" target="_blank"
                                    class="text-decoration-none fw-semibold">
                                    {{ $item->ten_san_pham ?? 'Chưa cập nhật' }}
                                </a>
                            </td>
                            <td class="text-center">{{ $item->mau_sac_kich_thuoc ?? '--' }}</td>
                            <td class="text-center fw-bold">{{ $item->so_luong }}</td>

                            <!-- Hiển thị giá và ký hiệu tiền tệ động -->
                            <td class="text-center text-danger fw-semibold">
                                {{ number_format($item->don_gia, 2) }} {{ $order->country->tien_te ?? '¥' }}
                            </td>

                            <td>{{ $item->ghi_chu_khac ?? '' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Không có sản phẩm nào trong đơn hàng
                                này.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        @php
        $dichVuMuaHo = [];
        $cacYeuCauMuaHo = \App\Models\OrderExtraRequirement::where('order_id',
        $order->id)->pluck('loai_yeu_cau')->toArray();

        // Đếm tổng số lượng sản phẩm để nhân với đơn giá phí dịch vụ
        $tongSoLuong = \App\Models\OrderItem::where('order_id', $order->id)->sum('so_luong') ?? 1;

        if (in_array('kiem_hang', $cacYeuCauMuaHo)) {
        $dichVuMuaHo[] = ['ten' => 'Kiểm hàng', 'phi' => config('fees.phi_kiem_dem_per_item', 5000) * $tongSoLuong];
        }
        if (in_array('dong_go', $cacYeuCauMuaHo)) {
        $dichVuMuaHo[] = ['ten' => 'Đóng gỗ', 'phi' => config('fees.phi_dong_go_per_item', 15000) * $tongSoLuong];
        }
        if (in_array('khai_thue_gtgt', $cacYeuCauMuaHo)) {
        $dichVuMuaHo[] = ['ten' => 'Khai thuế', 'phi' => config('fees.phi_khai_thue', 55000)];
        }

        // TÍNH TOÁN LẠI TỪ BẢNG PACKAGE
        // Lấy tổng phí nội địa từ tất cả các kiện hàng thuộc đơn này
        $tongPhiNoiDia = $order->packages ? $order->packages->sum('phi_van_chuyen_noi_dia') : 0;

        // Lấy tổng chiết khấu từ các kiện hàng
        $tongChietKhau = $order->packages ? $order->packages->sum('chiet_khau') : 0;

        // Lấy tổng số tiền cuối cùng khách phải trả (đã được Admin chốt ở kiện hàng)
        $tongThanhToanKienHang = $order->packages ? $order->packages->sum('thanh_tien') : 0;
        @endphp

        <div class="card bg-light border-0 shadow-sm">
            <div class="card-header bg-secondary bg-opacity-10 fw-bold text-dark text-uppercase border-bottom-0">
                TỔNG HỢP CHI PHÍ (ĐƠN MUA HỘ)
            </div>
            <div class="card-body p-2">
                <ul class="list-group list-group-flush bg-transparent">

                    <!-- 1. Tiền hàng và Phí dịch vụ (Thông tin gốc của đơn) -->
                    <li class="list-group-item bg-transparent px-0 border-light">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tổng tiền hàng (Gồm Sản phẩm & Phí dịch vụ):</span>
                            <strong class="text-dark">{{ number_format($order->tong_tien) }} VNĐ/SP</strong>
                        </div>

                        @if(count($dichVuMuaHo) > 0)
                        <div
                            class="p-3 mt-1 bg-info bg-opacity-10 border border-info border-opacity-25 rounded font-13">
                            <span class="d-block fw-bold text-dark mb-2">Chi tiết phí dịch vụ đã tính:</span>
                            <ul class="list-unstyled mb-0">
                                @foreach($dichVuMuaHo as $dv)
                                <li class="d-flex justify-content-between text-muted mb-2">
                                    <span>- Phí {{ $dv['ten'] }}:</span>
                                    <span class="fw-semibold text-dark">{{ number_format($dv['phi']) }} VNĐ/SP</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>

                    <!-- 2. Cước vận chuyển từ bảng Package -->
                    <li
                        class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light py-1 mt-2">
                        <span class="text-muted">Tổng cước vận chuyển (Từ các kiện hàng):</span>
                        <strong class="text-dark">{{ number_format($tongPhiNoiDia) }} VNĐ</strong>
                    </li>

                    <!-- Hiển thị Chiết khấu nếu có -->
                    @if($tongChietKhau > 0)
                    <li class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light py-1">
                        <span class="text-success fw-semibold">Chiết khấu / Giảm giá:</span>
                        <strong class="text-success">-{{ number_format($tongChietKhau) }} VNĐ</strong>
                    </li>
                    @endif
                </ul>

                <!-- 3. Hộp Tổng thanh toán chốt hạ -->
                <div
                    class="border border-2 p-3 mt-3 bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <span class="fw-bold fs-5 text-dark mb-2 mb-md-0">TỔNG KHÁCH PHẢI THANH TOÁN:</span>
                    <strong class="text-danger fs-4">{{ number_format($tongThanhToanKienHang) }} VNĐ</strong>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection