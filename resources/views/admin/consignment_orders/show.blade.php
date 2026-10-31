@extends('layouts.admin')
@section('title', 'Chi tiết Đơn Ký Gửi')
@section('page_title', 'Đơn ký gửi: ' . $order->ma_don_ky_gui)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-uppercase" style="color: #198754;">
            <i class="bi bi-file-earmark-text me-1"></i> Thông tin chi tiết Đơn Ký Gửi
        </h6>
        <div>
            <a href="{{ route('admin.consignment_orders.edit', $order->id) }}"
                class="btn btn-sm btn-warning fw-semibold">
                <i class="bi bi-pencil-square"></i> Sửa
            </a>
            <a href="{{ route('admin.consignment_orders.index') }}" class="btn btn-sm btn-secondary fw-semibold">
                Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4 font-14">

            <!-- ==========================================
         NHÓM 1: KHÁCH HÀNG & TRẠNG THÁI CƠ BẢN
         ========================================== -->
            <div class="col-md-4">
                <span class="text-muted font-13 d-block mb-1">Khách hàng:</span>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark m-0">{{ $order->user->ho_ten ?? 'Chưa cập nhật' }}</h6>
                        <small class="text-muted">ID: {{ $order->user_id }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <span class="text-muted font-13 d-block mb-1">Trạng thái đơn:</span>
                <span class="badge bg-secondary text-uppercase px-3 py-2 rounded-2 shadow-sm fs-6">
                    {{ $order->trang_thai }}
                </span>
            </div>

            <div class="col-md-4">
                <span class="text-muted font-13 d-block mb-1">Tình trạng thanh toán:</span>
                @if($order->trang_thai_thanh_toan == 'chua_thanh_toan')
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fs-6 border border-warning">
                    <i class="bi bi-clock-history me-1"></i> Chưa thanh toán
                </span>
                @elseif($order->trang_thai_thanh_toan == 'da_thanh_toan')
                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Đã thanh toán
                </span>
                @endif
            </div>

            <div class="col-12">
                <hr class="text-muted opacity-25 my-0">
            </div>

            <!-- ==========================================
         NHÓM 2: THÔNG SỐ VẬN HÀNH & DỊCH VỤ
         ========================================== -->
            <div class="col-md-3">
                <span class="text-muted font-13 d-block mb-1">Tốc độ:</span>
                <span
                    class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-primary' }} px-2 py-1 shadow-sm">
                    <i
                        class="bi {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bi-lightning-charge-fill' : 'bi-truck' }} me-1"></i>
                    {{ strtoupper($order->yeu_cau_toc_do) }}
                </span>
            </div>

            <div class="col-md-2">
                <span class="text-muted font-13 d-block mb-1">Số kiện hàng:</span>
                <span class="fw-bold fs-5 text-dark">{{ $order->so_kien }}</span> <span class="text-muted">kiện</span>
            </div>

            <div class="col-md-3">
                <span class="text-muted font-13 d-block mb-1">Vị trí hiện tại:</span>
                @if($order->kho_hien_tai_id && $order->khoHienTai)
                <span class="badge bg-success px-2 py-1 shadow-sm">
                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $order->khoHienTai->ten_kho }}
                </span>
                @else
                <span class="badge bg-secondary px-2 py-1 shadow-sm">
                    <i class="bi bi-hourglass-split me-1"></i> Chưa nhập kho
                </span>
                @endif
            </div>

            <div class="col-md-4">
                <span class="text-muted font-13 d-block mb-1">Dịch vụ yêu cầu:</span>
                @if(isset($order->extraRequirements) && $order->extraRequirements->count() > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($order->extraRequirements as $req)
                    @if($req->loai_yeu_cau == 'dong_go')
                    <span class="badge bg-secondary fw-normal px-2 py-1"><i class="bi bi-box-seam me-1"></i> Đóng
                        gỗ</span>
                    @elseif($req->loai_yeu_cau == 'kiem_hang')
                    <span class="badge bg-info text-dark fw-normal px-2 py-1"><i class="bi bi-search me-1"></i> Kiểm
                        hàng</span>
                    @endif
                    @endforeach
                </div>
                @else
                <span class="fst-italic text-muted font-13">Không có yêu cầu đặc biệt</span>
                @endif
            </div>

            <div class="col-12">
                <span class="text-muted font-13 d-block mb-1">Địa chỉ trả hàng:</span>
                <span class="fw-bold text-dark"><i
                        class="bi bi-house-door text-secondary me-2"></i>{{ $order->dia_chi_tra_hang ?? 'Chưa cập nhật (Nhận tại kho)' }}</span>
            </div>

            <!-- ==========================================
         NHÓM 3: LỘ TRÌNH VÀ NÚT TRA CỨU KIỆN HÀNG
         ========================================== -->
            <div class="col-12 mt-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle">
                    <div class="row align-items-center g-3">

                        <!-- Hiển thị lộ trình -->
                        <div class="col-md-8">
                            <span class="text-muted font-13 d-block mb-2 fw-semibold">Lộ trình vận chuyển:</span>
                            <div class="d-flex align-items-center flex-wrap gap-2 font-14">
                                @if($order->chieu_van_chuyen == 've_vn')
                                <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                                    <span class="badge bg-warning text-dark me-2">TỪ</span>
                                    <strong class="text-danger">{{ $order->khoQuocTe->ten_kho ?? 'Kho Quốc Tế' }}
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

                        <!-- Nút Tra cứu -->
                        <div class="col-md-4 text-md-end border-md-start ps-md-4">
                            <span class="text-muted font-13 d-block mb-2 text-md-center fw-semibold">Tra cứu chi
                                tiết:</span>
                            @php
                            $firstPackage = $order->packages->first() ?? null;
                            @endphp

                            @if($firstPackage)
                            <a href="{{ route('admin.packages.show', $firstPackage->id) }}"
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
            <!-- Các mốc thời gian (Đã format chuẩn ngày tháng) -->
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày tạo yêu cầu:</span>
                <span
                    class="fw-bold">{{ $order->ngay_tao_yeu_cau ? date('d/m/Y', strtotime($order->ngay_tao_yeu_cau)) : '--' }}</span>
            </div>
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày vận chuyển:</span>
                <span
                    class="fw-bold">{{ $order->ngay_van_chuyen ? date('d/m/Y', strtotime($order->ngay_van_chuyen)) : 'Đang chờ...' }}</span>
            </div>
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày nhận hàng:</span>
                <span
                    class="fw-bold text-success">{{ $order->ngay_nhan_hang ? date('d/m/Y', strtotime($order->ngay_nhan_hang)) : 'Chưa nhận' }}</span>
            </div>
        </div>



        <!-- 2. CHI TIẾT CÁC KIỆN HÀNG -->
        <div class="card shadow-sm border-0 mb-4 pt-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-uppercase"><i class="bi bi-box-seam"></i> Danh sách kiện hàng</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light font-14">
                            <tr>
                                <th>Mã vận đơn / Ảnh</th>
                                <th>Tên SP & Thông tin</th>
                                <th>Phân loại / SL</th>
                                <th>Dịch vụ thêm</th>
                            </tr>
                        </thead>
                        <tbody id="packagesContainer">
                            @php
                            $extraReqs = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id',
                            $order->id)->pluck('loai_yeu_cau')->toArray();
                            $hasDongGo = in_array('dong_go', $extraReqs);
                            $hasKiemHang = in_array('kiem_hang', $extraReqs);
                            @endphp

                            @if($order->items && $order->items->count() > 0)
                            @foreach($order->items as $index => $item)
                            <tr class="package-row">
                                <!-- Mã vận đơn / Ảnh -->
                                <td>
                                    <div class="fw-bold text-primary mb-2">{{ $item->ma_van_don ?: 'Chưa có mã' }}
                                    </div>
                                    @if($item->hinh_anh_url)
                                    <img src="{{ asset($item->hinh_anh_url) }}" class="rounded shadow-sm"
                                        style="width:50px;height:50px;object-fit:cover; border: 1px solid #ddd;">
                                    @else
                                    <span class="badge bg-secondary font-12">Không có ảnh</span>
                                    @endif
                                </td>

                                <!-- Tên SP & Thông tin -->
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $item->ten_san_pham }}</div>
                                    <div class="font-13 text-muted mb-1">
                                        <i class="bi bi-truck"></i> Hãng VC:
                                        <strong>{{ $item->hang_van_chuyen ?: 'N/A' }}</strong>
                                    </div>
                                    @if($item->link_san_pham)
                                    <a href="{{ $item->link_san_pham }}" target="_blank"
                                        class="font-13 text-info text-decoration-none">
                                        <i class="bi bi-link-45deg"></i> Link sản phẩm
                                    </a>
                                    @endif
                                </td>

                                <!-- Phân loại / Số lượng -->
                                <td>
                                    <div class="font-13 mb-1">Danh mục: <span
                                            class="fw-semibold">{{ $item->loai_danh_muc ?: 'Không phân loại' }}</span>
                                    </div>
                                    <div class="font-13 mb-1">
                                        Số lượng: <span class="badge bg-info text-dark">{{ $item->so_luong }}</span>
                                        |
                                        Số kiện: <span class="badge bg-secondary">{{ $item->so_kien_hang }}</span>
                                    </div>
                                    <div class="text-danger fw-bold font-14 mt-2">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ number_format($item->gia_tri_hang_hoa, 0, ',', '.') }} VNĐ
                                    </div>
                                </td>

                                <!-- Dịch vụ thêm & Ghi chú -->
                                <td>
                                    <div class="form-check font-14 mb-1">
                                        <input class="form-check-input" type="checkbox" disabled
                                            {{ $hasKiemHang ? 'checked' : '' }}>
                                        <label
                                            class="form-check-label {{ $hasKiemHang ? 'fw-bold text-dark' : 'text-muted' }}">Kiểm
                                            hàng</label>
                                    </div>
                                    <div class="form-check font-14 mb-2">
                                        <input class="form-check-input" type="checkbox" disabled
                                            {{ $hasDongGo ? 'checked' : '' }}>
                                        <label
                                            class="form-check-label {{ $hasDongGo ? 'fw-bold text-dark' : 'text-muted' }}">Đóng
                                            gỗ</label>
                                    </div>

                                    @if($item->ghi_chu)
                                    <div class="font-13 text-muted fst-italic p-2 bg-light rounded border">
                                        <strong>Ghi chú:</strong> {{ $item->ghi_chu }}
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i> Đơn hàng này chưa có kiện hàng chi
                                    tiết nào.
                                </td>
                            </tr>
                            @endif
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
</div>
</div>
@endsection