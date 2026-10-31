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
            <a href="{{ route('consignment.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <h3 class="text-uppercase fw-bold m-0" style="color: #198754;">
                Chi tiết đơn ký gửi: <span class="text-success">#{{ $order->ma_don_ky_gui }}</span>
            </h3>
        </div>
        <div>
            @if($order->trang_thai == 'cho_xu_ly')
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">Chờ xử lý</span>
            @elseif($order->trang_thai == 'da_xu_ly')
            <span class="badge bg-info text-dark px-3 py-2 fs-6">Đã xử lý</span>
            @else
            <span class="badge bg-success px-3 py-2 fs-6">Hoàn thành</span>
            @endif
        </div>
    </div>

    <!-- Thông tin chung -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header fw-bold text-uppercase text-white" style="background-color: #198754;">
            <i class="bi bi-info-circle me-1"></i> Thông tin chung
        </div>
        <div class="card-body font-14 pt-3 pb-4">
            <!-- Nhóm 1 & 2: Thông tin cơ bản và Dịch vụ (Dàn đều 3 cột) -->
            <div class="row g-4 mb-4">

                <!-- Cột 1: Thông tin đơn -->
                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-1">Ngày tạo yêu cầu:</span>
                    <span class="fw-bold text-dark fs-6">
                        <i
                            class="bi bi-calendar-event text-secondary me-2"></i>{{ date('d/m/Y', strtotime($order->ngay_tao_yeu_cau)) }}
                    </span>
                </div>

                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-1">Yêu cầu tốc độ:</span>
                    <span class="fw-bold fs-6 {{ $order->yeu_cau_toc_do == 'nhanh' ? 'text-danger' : 'text-primary' }}">
                        <i class="bi bi-lightning-charge-fill me-1"></i>
                        {{ $order->yeu_cau_toc_do == 'nhanh' ? 'Giao Hỏa Tốc' : 'Tiêu Chuẩn' }}
                    </span>
                </div>

                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-1">Tổng số kiện hàng:</span>
                    <span class="fw-bold text-dark fs-5">{{ $order->so_kien }}</span> <span
                        class="text-muted">kiện</span>
                </div>

                <!-- Cột 2: Các dịch vụ đi kèm -->
                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-2">Dịch vụ gia tăng:</span>
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
                    <span class="fst-italic text-muted font-13">Không có</span>
                    @endif
                </div>

                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-2">Bảo hiểm hàng hóa:</span>
                    @if($order->co_bao_hiem)
                    <span class="badge bg-primary px-3 py-2 rounded-2 fw-normal shadow-sm">
                        <i class="bi bi-shield-check me-1"></i> Đã mua bảo hiểm
                    </span>
                    @else
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-2 fw-normal">
                        <i class="bi bi-shield-x me-1"></i> Không bảo hiểm
                    </span>
                    @endif
                </div>

                <div class="col-md-4">
                    <span class="text-muted font-13 d-block mb-2">Khai báo hải quan:</span>
                    @if($order->co_khai_thue)
                    <span class="badge bg-success px-3 py-2 rounded-2 fw-normal shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Đã khai thuế
                    </span>
                    @else
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-2 fw-normal">
                        <i class="bi bi-x-circle me-1"></i> Không khai thuế
                    </span>
                    @endif
                </div>

                <div>
                    <span class="text-muted font-13 d-block mb-1">Tình trạng thanh toán:</span>
                    @if($order->trang_thai_thanh_toan == 'chua_thanh_toan')
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-2 fw-semibold border border-warning">
                        <i class="bi bi-clock-history me-1"></i> Chưa thanh toán
                    </span>
                    @elseif($order->trang_thai_thanh_toan == 'da_thanh_toan')
                    <span class="badge bg-success px-3 py-2 rounded-2 fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Đã thanh toán
                    </span>
                    @endif
                </div>
            </div>

            <!-- Nhóm 3: Khối Lộ trình & Nút theo dõi bọc  -->
            <div class="p-3 bg-light rounded-3 border border-light-subtle">
                <div class="row align-items-center g-3">

                    <!-- Hiển thị lộ trình -->
                    <div class="col-md-8">
                        <span class="text-muted font-13 d-block mb-2">Lộ trình vận chuyển:</span>
                        <div class="d-flex align-items-center flex-wrap gap-2 font-14">

                            @if($order->chieu_van_chuyen == 've_vn')
                            <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                <span class="badge bg-warning text-dark me-2">TỪ</span>
                                <strong class="text-danger"> {{ $order->khoQuocTe->ten_kho ?? 'Kho Quốc Tế' }}
                                    ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                            </div>
                            <i class="bi bi-arrow-right text-muted mx-1 fs-5 d-none d-md-block"></i>
                            <i class="bi bi-arrow-down text-muted my-1 fs-5 d-block d-md-none"></i>
                            <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                <span class="badge bg-success me-2">ĐẾN</span>
                                <strong class="text-success">{{ $order->khoVn->ten_kho ?? 'Kho Việt Nam' }}</strong>
                            </div>
                            @else
                            <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                <span class="badge bg-warning text-dark me-2">TỪ</span>
                                <strong class="text-success">{{ $order->khoVn->ten_kho ?? 'Kho Việt Nam' }}</strong>
                            </div>
                            <i class="bi bi-arrow-right text-muted mx-1 fs-5 d-none d-md-block"></i>
                            <i class="bi bi-arrow-down text-muted my-1 fs-5 d-block d-md-none"></i>
                            <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                <span class="badge bg-success me-2">ĐẾN</span>
                                <strong class="text-danger">{{ $order->khoQuocTe->ten_kho ?? 'Kho Quốc Tế' }}
                                    ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- Nút bấm tra cứu -->
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
                            style="opacity: 0.65; cursor: not-allowed;" disabled>
                            <i class="bi bi-hourglass-split me-1"></i> Chưa có kiện hàng
                        </button>
                        @endif
                    </div>

                </div>
            </div>


        </div>

        <!-- Danh sách chi tiết kiện hàng -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold text-uppercase" style="color: #198754;">
                <i class="bi bi-boxes me-1"></i> Danh sách kiện hàng
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 font-14">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 5%;">STT</th>
                                <th style="width: 10%;">Hình ảnh</th>
                                <th style="width: 15%;">Mã vận đơn / Hãng VC</th>
                                <th style="width: 25%;">Tên sản phẩm</th>
                                <th style="width: 10%;">Danh mục</th>
                                <th style="width: 10%;">SL / Kiện</th>
                                <th style="width: 10%;">Giá trị (VNĐ)</th>
                                <th style="width: 15%;">Ghi chú</th>
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
                                    <div class="fw-bold text-primary mb-1">{{ $item->ma_van_don ?? 'Chưa có' }}</div>
                                    <div class="text-muted font-12">{{ $item->hang_van_chuyen ?? '' }}</div>
                                </td>
                                <td>
                                    @if($item->link_san_pham)
                                    <a href="{{ $item->link_san_pham }}" target="_blank"
                                        class="text-decoration-none fw-semibold text-dark">
                                        {{ $item->ten_san_pham }}
                                    </a>
                                    @else
                                    <span class="fw-semibold">{{ $item->ten_san_pham }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-light text-dark border">{{ $item->loai_danh_muc ?? '--' }}</span>
                                </td>
                                <td class="text-center">
                                    <div>SL: <span class="fw-bold">{{ $item->so_luong }}</span></div>
                                    <div class="text-muted font-12">{{ $item->so_kien_hang }} kiện</div>
                                </td>
                                <td class="text-center text-danger fw-semibold">
                                    {{ number_format($item->gia_tri_hang_hoa, 0, ',', '.') }} đ
                                </td>
                                <td>
                                    <div class="font-12">{{ $item->ghi_chu ?? '' }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Không có kiện hàng nào trong đơn
                                    này.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            @php
            $dichVuKyGui = [];

            // Quét phí bảo hiểm & khai thuế
            if ($order->co_bao_hiem) {
            $dichVuKyGui[] = ['ten' => 'Bảo hiểm', 'phi_text' => number_format(config('fees.phi_bao_hiem', 50000)) . '
            VNĐ/Đơn'];
            }
            if ($order->co_khai_thue) {
            $dichVuKyGui[] = ['ten' => 'Khai thuế', 'phi_text' => number_format(config('fees.phi_khai_thue', 55000)) . '
            VNĐ/Đơn'];
            }

            // Quét phí đóng gỗ & kiểm hàng
            $cacYeuCauKyGui = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id',
            $order->id)->pluck('loai_yeu_cau')->toArray();

            if (in_array('kiem_hang', $cacYeuCauKyGui)) {
            $dichVuKyGui[] = ['ten' => 'Kiểm hàng', 'phi_text' => number_format(config('fees.phi_kiem_dem_per_item',
            5000)) . ' VNĐ/SP'];
            }
            if (in_array('dong_go', $cacYeuCauKyGui)) {
            $dichVuKyGui[] = ['ten' => 'Đóng gỗ', 'phi_text' => number_format(config('fees.phi_dong_go_per_item',
            15000)) . ' VNĐ/SP'];
            }

            // TÍNH TOÁN LẠI TỪ BẢNG PACKAGE CHO ĐƠN KÝ GỬI
            $tongPhiNoiDia = $order->packages ? $order->packages->sum('phi_van_chuyen_noi_dia') : 0;
            $tongChietKhau = $order->packages ? $order->packages->sum('chiet_khau') : 0;
            $tongThanhToanKienHang = $order->packages ? $order->packages->sum('thanh_tien') : 0;
            @endphp

            <div class="card bg-light border-0 shadow-sm">
                <div class="card-header bg-secondary bg-opacity-10 fw-bold text-dark text-uppercase border-bottom-0">
                    THÔNG TIN TÀI CHÍNH (ĐƠN KÝ GỬI)
                </div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush bg-transparent">

                        <!-- Giá trị hàng hóa -->
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light">
                            <span class="text-muted">Tổng giá trị hàng hóa (Khách khai báo):</span>
                            <strong class="text-dark">{{ number_format($order->tong_gia_tri_khai_bao) }} VNĐ</strong>
                        </li>

                        <!-- Mức đền bù tối đa (Đã chuyển thành 1 dòng chữ đỏ bình thường) -->
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light">
                            <span class="text-danger fw-semibold"><i class="bi bi-shield-exclamation"></i> Mức đền bù
                                tối đa (nếu thất lạc):</span>
                            <strong class="text-danger">{{ number_format($order->muc_boi_thuong) }} VNĐ</strong>
                        </li>

                        <!-- Khối hiển thị chi tiết các dịch vụ gia tăng -->
                        <li class="list-group-item bg-transparent px-0 border-light pt-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold text-dark">Các dịch vụ gia tăng đã đăng ký:</span>
                            </div>

                            @if(count($dichVuKyGui) > 0)
                            <ul class="list-unstyled mb-0 ps-3 mt-2 border-start border-2 border-warning font-13">
                                @foreach($dichVuKyGui as $dv)
                                <li class="d-flex justify-content-between text-muted mb-2">
                                    <span>- Dịch vụ {{ $dv['ten'] }}:</span>
                                    <span class="text-dark fw-semibold">{{ $dv['phi_text'] }}</span>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <span class="text-muted font-13 ms-2">- Không phát sinh yêu cầu đặc biệt.</span>
                            @endif
                        </li>

                        <!-- Phí vận chuyển nội địa (Từ các kiện hàng) -->
                        <li
                            class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light mt-2 pt-1 border-top">
                            <span class="text-muted">Tổng phí nội địa TQ (Từ các kiện hàng):</span>
                            <strong class="text-dark">{{ number_format($tongPhiNoiDia) }} VNĐ</strong>
                        </li>

                        <!-- Hiển thị Chiết khấu nếu có -->
                        @if($tongChietKhau > 0)
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light">
                            <span class="text-success fw-semibold">Chiết khấu / Giảm giá:</span>
                            <strong class="text-success">-{{ number_format($tongChietKhau) }} VNĐ</strong>
                        </li>
                        @endif

                    </ul>

                    <!-- Khung Tổng khách phải thanh toán nổi bật (Đã thay thế cho Mức đền bù) -->
                    <div
                        class="border border-2 p-3 mt-2 bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <span class="fw-bold fs-5 text-dark mb-2 mb-md-0">TỔNG KHÁCH CẦN THANH TOÁN:</span>
                        <strong class="text-danger fs-4">{{ number_format($tongThanhToanKienHang) }} VNĐ</strong>
                    </div>
                </div>
            </div>
        </div>


    </div>

    @endsection