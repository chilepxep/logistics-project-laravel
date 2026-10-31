@extends('layouts.admin')
@section('title', 'Chi tiết Đơn Mua Hộ')
@section('page_title', 'Chi tiết mã đơn: ' . $order->ma_don_hang)

@section('content')
<div class="row g-4">
    <!-- Khối 1: Thông tin chung -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100 rounded-3">

            <!-- Header -->
            <div
                class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0 pb-0">
                <h6 class="m-0 fw-bold text-uppercase text-primary" style="letter-spacing: 0.5px;">
                    <i class="bi bi-info-circle-fill me-1"></i> Thông tin chung
                </h6>
                <a href="{{ route('admin.orders.edit', $order->id) }}"
                    class="btn btn-sm btn-outline-warning fw-semibold shadow-sm px-3">
                    <i class="bi bi-pencil-square"></i> Sửa
                </a>
            </div>

            <div class="card-body pt-3">

                <!-- Highlight Box: Tiền bạc & Trạng thái -->
                <div class="bg-light rounded-3 p-3 mb-3 border border-light-subtle shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted font-13 fw-semibold">Tổng tiền:</span>
                        <strong class="text-danger fs-5">{{ number_format($order->tong_tien) }} <small
                                class="text-muted fs-6 fw-normal">đ</small></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted font-13 fw-semibold">Trạng thái:</span>
                        <span
                            class="badge bg-secondary text-uppercase px-2 py-1 shadow-sm">{{ $order->trang_thai }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted font-13 fw-semibold">Thanh toán:</span>
                        @if($order->trang_thai_thanh_toan == 'chua_thanh_toan')
                        <span class="badge bg-warning text-dark px-2 py-1 shadow-sm"><i
                                class="bi bi-clock-history me-1"></i>Chưa thanh toán</span>
                        @else
                        <span class="badge bg-success px-2 py-1 shadow-sm"><i
                                class="bi bi-check-circle-fill me-1"></i>Đã thanh toán</span>
                        @endif
                    </div>
                </div>

                <!-- List thông tin chi tiết -->
                <ul class="list-group list-group-flush font-14 mb-3">

                    <!-- Khách hàng -->
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-light">
                        <span class="text-muted">Khách hàng:</span>
                        <div class="text-end">
                            <strong class="text-dark">{{ $order->user->ho_ten ?? 'N/A' }}</strong><br>
                            <span class="text-muted font-12">(ID: {{ $order->user_id }})</span>
                        </div>
                    </li>

                    <!-- Tốc độ -->
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-light">
                        <span class="text-muted">Tốc độ yêu cầu:</span>
                        <span
                            class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-primary' }} px-2 py-1 shadow-sm">
                            <i
                                class="bi {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bi-lightning-charge-fill' : 'bi-truck' }} me-1"></i>
                            {{ $order->yeu_cau_toc_do == 'nhanh' ? 'HỎA TỐC' : 'TIÊU CHUẨN' }}
                        </span>
                    </li>

                    <!-- Vị trí -->
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-light">
                        <span class="text-muted">Vị trí hiện tại:</span>
                        @if($order->kho_hien_tai_id && $order->khoHienTai)
                        <span class="badge bg-success px-2 py-1 shadow-sm">
                            <i class="bi bi-geo-alt-fill me-1"></i> {{ $order->khoHienTai->ten_kho }}
                        </span>
                        @else
                        <span class="badge bg-secondary px-2 py-1 shadow-sm">
                            <i class="bi bi-hourglass-split me-1"></i> Chưa nhập kho
                        </span>
                        @endif
                    </li>
                </ul>

                <!-- Dịch vụ gia tăng -->
                <div class="mb-3">
                    <span class="text-muted font-13 d-block mb-2 fw-semibold">Dịch vụ đi kèm:</span>
                    @if(isset($order->extraRequirements) && $order->extraRequirements->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($order->extraRequirements as $req)
                        @if($req->loai_yeu_cau == 'dong_go')
                        <span class="badge bg-secondary fw-normal px-2 py-1"><i class="bi bi-box-seam me-1"></i> Đóng
                            gỗ</span>
                        @elseif($req->loai_yeu_cau == 'kiem_hang')
                        <span class="badge bg-info text-dark fw-normal px-2 py-1"><i class="bi bi-search me-1"></i> Kiểm
                            hàng</span>
                        @elseif($req->loai_yeu_cau == 'khai_thue_gtgt')
                        <span class="badge bg-dark fw-normal px-2 py-1"><i class="bi bi-receipt me-1"></i> Khai
                            thuế</span>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <span class="fst-italic text-muted font-13">Không có dịch vụ thêm</span>
                    @endif
                </div>

                <!-- Lộ trình vận chuyển -->
                <div class="p-3 bg-light rounded-3 border border-light-subtle mb-3">
                    <span class="text-muted font-13 d-block mb-3 fw-semibold">Lộ trình vận chuyển:</span>

                    <div class="d-flex align-items-start mb-0">
                        <span class="badge bg-warning text-dark me-2 mt-1" style="width: 45px;">TỪ</span>
                        <strong class="text-danger font-14 lh-sm">{{ $order->supplier->ten_ncc ?? 'Kho Quốc Tế' }}
                            <br><small class="text-muted">({{ $order->country->ten_quoc_gia ?? '' }})</small></strong>
                    </div>

                    <div class="ms-3 my-1" style="border-left: 2px dashed #dee2e6; height: 18px;"></div>

                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2" style="width: 45px;">ĐẾN</span>
                        <strong class="text-success font-14">{{ $order->khoNhan->ten_kho ?? 'Chưa chọn' }}</strong>
                    </div>
                </div>

                <!-- Nút Tra cứu kiện hàng -->
                <div>
                    @php
                    $firstPackage = $order->packages->first() ?? null;
                    @endphp

                    @if($firstPackage)
                    <a href="{{ route('admin.packages.show', $firstPackage->id) }}"
                        class="btn btn-primary fw-bold w-100 py-2 shadow-sm rounded-3">
                        <i class="bi bi-geo-alt-fill me-1"></i> Xem chi tiết kiện hàng
                    </a>
                    @else
                    <button class="btn btn-secondary disabled w-100 py-2 rounded-3 border-0"
                        style="opacity: 0.65; cursor: not-allowed;">
                        <i class="bi bi-hourglass-split me-1"></i> Chưa có kiện hàng
                    </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Khối 2: Danh sách Sản phẩm -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-uppercase" style="color: #0b3a68;"><i class="bi bi-box2"></i> Danh sách sản
                    phẩm ({{ $order->items->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 font-14">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th style="min-width: 200px;">Tên sản phẩm & Link</th>
                                <th>Thuộc tính</th>
                                <th class="text-center">SL</th>
                                <!-- HIỂN THỊ TIỀN TỆ ĐỘNG -->
                                <th>Đơn giá ({{ $order->country->tien_te ?? '¥' }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->hinh_anh_url)
                                    <img src="{{ asset($item->hinh_anh_url) }}" alt="img" class="rounded border"
                                        style="width: 55px; height: 55px; object-fit: cover;">
                                    @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted"
                                        style="width: 55px; height: 55px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-truncate mb-1" style="max-width: 250px;"
                                        title="{{ $item->ten_san_pham }}">
                                        {{ $item->ten_san_pham }}
                                    </div>
                                    @if($item->link_san_pham)
                                    <a href="{{ $item->link_san_pham }}" target="_blank" class="text-decoration-none"
                                        style="font-size: 12px;">
                                        <i class="bi bi-link-45deg"></i> Link sản phẩm
                                    </a>
                                    @endif
                                    @if($item->ghi_chu_khac)
                                    <div class="text-muted font-12 mt-1 fst-italic">Ghi chú: {{ $item->ghi_chu_khac }}
                                    </div>
                                    @endif
                                </td>
                                <td>{{ $item->mau_sac_kich_thuoc ?? '--' }}</td>
                                <td class="fw-bold text-center">{{ $item->so_luong }}</td>
                                <!-- LẤY GIÁ TRỊ DON_GIA thay vì DON_GIA_TE -->
                                <td class="text-danger fw-bold">
                                    {{ number_format($item->don_gia, 2) }} {{ $order->country->tien_te ?? '¥' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                $dichVuMuaHo[] = ['ten' => 'Kiểm hàng', 'phi' => config('fees.phi_kiem_dem_per_item', 5000) *
                $tongSoLuong];
                }
                if (in_array('dong_go', $cacYeuCauMuaHo)) {
                $dichVuMuaHo[] = ['ten' => 'Đóng gỗ', 'phi' => config('fees.phi_dong_go_per_item', 15000) *
                $tongSoLuong];
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
                    <div
                        class="card-header bg-secondary bg-opacity-10 fw-bold text-dark text-uppercase border-bottom-0">
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
                                            <span class="fw-semibold text-dark">{{ number_format($dv['phi']) }}
                                                VNĐ/SP</span>
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
                            <li
                                class="list-group-item d-flex justify-content-between bg-transparent px-0 border-light py-1">
                                <span class="text-success fw-semibold">Chiết khấu / Giảm giá:</span>
                                <strong class="text-success">-{{ number_format($tongChietKhau) }} VNĐ</strong>
                            </li>
                            @endif
                        </ul>

                        <!-- 3. Hộp Tổng thanh toán chốt hạ (Giao diện khung viền như thiết kế) -->
                        <div
                            class="border border-2 p-3 mt-3 bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <span class="fw-bold fs-5 text-dark mb-2 mb-md-0">TỔNG KHÁCH PHẢI THANH TOÁN:</span>
                            <strong class="text-danger fs-4">{{ number_format($tongThanhToanKienHang) }} VNĐ</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection