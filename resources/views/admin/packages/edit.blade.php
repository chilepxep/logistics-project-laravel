@extends('layouts.admin')
@section('title', 'Cập nhật Kiện Hàng')
@section('page_title', 'Cập nhật Kiện: ' . $package->ma_don_kien_hang)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        @php
        $user = Auth::user();

        // --- KHỞI TẠO CÁC BIẾN DÙNG CHUNG ---
        $isMuaHo = $package->order_id && $package->order ? true : false;
        $isKyGui = $package->consignment_order_id && $package->consignmentOrder ? true : false;

        $chieuVanChuyen = 've_vn';
        $tenKhoQuocTe = 'Kho Quốc Tế';
        $tenKhoVn = 'Kho Việt Nam';
        $tenQuocGia = '';

        // BIẾN QUAN TRỌNG: Lưu ID của Kho Xuất Phát
        $khoXuatPhatId = null;

        // --- LẤY DỮ LIỆU ĐƠN KÝ GỬI ---
        if ($isKyGui) {
        $co = $package->consignmentOrder;
        $chieuVanChuyen = $co->chieu_van_chuyen;
        $tenKhoQuocTe = $co->khoQuocTe->ten_kho ?? 'Kho Quốc Tế';
        $tenKhoVn = $co->khoVn->ten_kho ?? 'Kho Việt Nam';
        $tenQuocGia = $co->country->ten_quoc_gia ?? '';

        // Xác định Kho Xuất Phát theo chiều vận chuyển
        if ($chieuVanChuyen === 've_vn') {
        // Chiều Về VN: Xuất phát từ Kho Quốc Tế
        $khoXuatPhatId = $co->supplier_id;
        } else {
        // Chiều Đi QT: Xuất phát từ Kho Việt Nam
        $khoXuatPhatId = $co->kho_vn_id;
        }
        }

        // --- LẤY DỮ LIỆU ĐƠN MUA HỘ ---
        elseif ($isMuaHo) {
        $od = $package->order;
        $chieuVanChuyen = $od->chieu_van_chuyen ?? 've_vn';
        $tenKhoQuocTe = $od->supplier->ten_ncc ?? 'Kho Quốc Tế';
        $tenKhoVn = $od->khoNhan->ten_kho ?? 'Kho Việt Nam';
        $tenQuocGia = $od->country->ten_quoc_gia ?? '';

        // Đơn mua hộ: Admin đã gán kho xuất phát vào `kho_hien_tai_id` của Order lúc xác nhận
        // VÀ nó cũng chính là `tru_so_id` hiện tại của Package này ở thời điểm mới tạo.
        // Lấy ID kho đầu tiên trong lịch sử Tracking, hoặc lấy chính tru_so_id hiện tại nếu chưa có lịch sử đổi kho.
        $trackingDauTien = \App\Models\PackageTracking::where('package_id', $package->id)->orderBy('created_at',
        'asc')->first();

        if ($trackingDauTien && $trackingDauTien->warehouse_id) {
        $khoXuatPhatId = $package->warehouse_id;
        } else {
        $khoXuatPhatId = $package->tru_so_id;
        }
        }

        $hienThiKhoQuocTe = $tenKhoQuocTe . ($tenQuocGia ? " ($tenQuocGia)" : '');

        // --- LOGIC TÍNH PHÍ DỊCH VỤ BỔ SUNG (Giữ nguyên của bạn) ---
        $tongTienDonMuaHo = 0;
        $dichVuKyGui = [];
        $goiYPhiKhac = 0;

        if ($isMuaHo) {
        $tongTienDonMuaHo = $package->order->tong_tien;
        } elseif ($isKyGui) {
        // ... (Đoạn tính phí bảo hiểm, khai thuế, đóng gỗ, kiểm hàng giữ nguyên) ...
        $co = $package->consignmentOrder;
        if ($co->co_bao_hiem) {
        $phiBaoHiem = config('fees.phi_bao_hiem', 50000);
        $dichVuKyGui[] = ['ten' => 'Bảo hiểm', 'phi' => $phiBaoHiem];
        $goiYPhiKhac += $phiBaoHiem;
        }
        if ($co->co_khai_thue) {
        $phiKhaiThue = config('fees.phi_khai_thue', 55000);
        $dichVuKyGui[] = ['ten' => 'Khai thuế', 'phi' => $phiKhaiThue];
        $goiYPhiKhac += $phiKhaiThue;
        }
        $cacYeuCauThem = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id', $co->id)
        ->pluck('loai_yeu_cau')->toArray();
        $soLuongNhanVoiPhi = $package->tong_kg ?? 1;

        if (in_array('kiem_hang', $cacYeuCauThem)) {
        $phiKiemHang = config('fees.phi_kiem_dem_per_item', 5000) * $soLuongNhanVoiPhi;
        $dichVuKyGui[] = ['ten' => 'Kiểm hàng', 'phi' => $phiKiemHang];
        $goiYPhiKhac += $phiKiemHang;
        }
        if (in_array('dong_go', $cacYeuCauThem)) {
        $phiDongGo = config('fees.phi_dong_go_per_item', 15000) * $soLuongNhanVoiPhi;
        $dichVuKyGui[] = ['ten' => 'Đóng gỗ', 'phi' => $phiDongGo];
        $goiYPhiKhac += $phiDongGo;
        }
        }

        // --- BƯỚC 2: LOGIC PHÂN QUYỀN SỬA CHỮA ($canEditMetrics) ---
        // Kiểm tra xem dữ liệu (KG, M3, Phí nội địa,...) ĐÃ CÓ HAY CHƯA?
        // Giả định: Nếu tổng KG lớn hơn 0 HOẶC Phí nội địa lớn hơn 0, nghĩa là đã được nhập.
        $daNhapDuLieu = ($package->tong_kg > 0 || $package->phi_van_chuyen_noi_dia > 0);

        // Mặc định không được sửa
        $canEditMetrics = false;

        if ($user->vai_tro === 'admin') {
        // Admin: Luôn được sửa tự do
        $canEditMetrics = true;
        } elseif ($user->vai_tro === 'nhan_vien') {
        // Nhân viên: Kiểm tra điều kiện
        // 1. Phải đang làm việc tại KHO XUẤT PHÁT
        $isTaiKhoXuatPhat = ($user->warehouse_id == $khoXuatPhatId);

        // 2. CHƯA NHẬP DỮ LIỆU (nếu đã nhập thì bị khóa)
        if ($isTaiKhoXuatPhat && !$daNhapDuLieu) {
        $canEditMetrics = true;
        }
        }

        // --- CẤU HÌNH CLASS VÀ ATTRIBUTE HTML ---
        $readonlyAttr = $canEditMetrics ? '' : 'readonly';
        $lockedClass = $canEditMetrics ? '' : 'bg-light text-muted pointer-events-none';
        // Mẹo: Thêm 'pointer-events-none' vào $lockedClass sẽ ngăn luôn việc click/tab vào ô
        @endphp

        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h6 class="fw-bold text-primary mb-3">1. Cập nhật Hành trình</h6>
            <!-- Hiển thị lộ trình -->
            <div class="col-md-8 mb-3">
                <span class="text-muted font-13 d-block mb-2 fw-semibold">Lộ trình vận chuyển:</span>
                <div class="d-flex align-items-center flex-wrap gap-2 font-14">

                    @if($chieuVanChuyen == 've_vn')
                    <!-- Chiều Về Việt Nam -->
                    <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                        <span class="badge bg-warning text-dark me-2">TỪ</span>
                        <strong class="text-danger">{{ $hienThiKhoQuocTe }}</strong>
                    </div>
                    <i class="bi bi-arrow-right text-muted mx-1 fs-5 d-none d-md-block"></i>
                    <i class="bi bi-arrow-down text-muted my-1 fs-5 d-block d-md-none"></i>
                    <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                        <span class="badge bg-success me-2">ĐẾN</span>
                        <strong class="text-success">{{ $tenKhoVn }}</strong>
                    </div>
                    @else
                    <!-- Chiều Đi Quốc Tế -->
                    <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                        <span class="badge bg-warning text-dark me-2">TỪ</span>
                        <strong class="text-success">{{ $tenKhoVn }}</strong>
                    </div>
                    <i class="bi bi-arrow-right text-muted mx-1 fs-5 d-none d-md-block"></i>
                    <i class="bi bi-arrow-down text-muted my-1 fs-5 d-block d-md-none"></i>
                    <div class="bg-white px-3 py-2 rounded-2 border shadow-sm d-flex align-items-center">
                        <span class="badge bg-success me-2">ĐẾN</span>
                        <strong class="text-danger">{{ $hienThiKhoQuocTe }}</strong>
                    </div>
                    @endif

                </div>
            </div>
            <div class="row g-3 mb-4 bg-light p-3 rounded">
                @php
                // Lấy thông tin nhân viên đang đăng nhập
                $user = Auth::guard('employee')->user();

                // Xác định quyền và loại kho
                $isAdmin = $user && $user->vai_tro === 'admin';
                $isNhanVienVN = $user && $user->vai_tro === 'nhan_vien' && $user->warehouse &&
                $user->warehouse->loai_kho === 'VN';
                $isNhanVienQT = $user && $user->vai_tro === 'nhan_vien' && $user->warehouse &&
                $user->warehouse->loai_kho !== 'VN';

                // TÌM ID KHO ĐÍCH
                $khoDichId = null;

                // NẾU LÀ ĐƠN MUA HỘ
                if ($package->order_id) {
                $order = \App\Models\Order::find($package->order_id);
                if ($order) {
                $khoDichId = $order->tru_so_nhan_hang_id;
                }
                }
                // NẾU LÀ ĐƠN KÝ GỬI
                elseif ($package->consignment_order_id) {
                $consignmentOrder = \App\Models\ConsignmentOrder::find($package->consignment_order_id);
                if ($consignmentOrder) {
                // Xác định đích đến dựa vào chiều vận chuyển
                if ($consignmentOrder->chieu_van_chuyen === 'di_qt') {
                // Nếu gửi từ VN đi Quốc Tế -> Đích là Kho Quốc Tế (cột supplier_id)
                $khoDichId = $consignmentOrder->supplier_id;
                } else {
                // Nếu gửi từ Quốc Tế về VN ('ve_vn') -> Đích là Kho VN
                $khoDichId = $consignmentOrder->kho_vn_id;
                }
                }
                }

                // KIỂM TRA ĐÃ ĐẾN KHO ĐÍCH CHƯA
                $daDenKhoDich = ($khoDichId && $package->tru_so_id == $khoDichId);
                @endphp

                <div class="col-md-6">
                    <label class="form-label fw-bold">Vị trí kho hiện tại</label>
                    <select name="tru_so_id" class="form-select border-primary" required>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ $package->tru_so_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Trạng thái kiện hàng</label>
                    <select name="tinh_trang" class="form-select border-primary" required>
                        <!-- Các trạng thái chung ai cũng thấy -->
                        <option value="cho_xu_ly" {{ $package->tinh_trang == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="da_nhap_kho" {{ $package->tinh_trang == 'da_nhap_kho' ? 'selected' : '' }}>Đã
                            nhập kho</option>

                        <!-- Trạng thái dành riêng cho Kho Quốc Tế và Admin -->
                        @if($isAdmin || $isNhanVienQT)
                        <option value="dang_van_chuyen"
                            {{ $package->tinh_trang == 'dang_van_chuyen' ? 'selected' : '' }}>
                            Đang luân chuyển (Quốc tế)
                        </option>
                        @endif

                        <!-- Trạng thái dành riêng cho Kho VN và Admin -->
                        @if($isAdmin || $isNhanVienVN)
                        <option value="dang_giao_hang" {{ $package->tinh_trang == 'dang_giao_hang' ? 'selected' : '' }}>
                            Đến kho Việt Nam
                        </option>
                        @endif

                        <!-- Các trạng thái chung ai cũng thấy -->
                        <option value="hoan_thanh" {{ $package->tinh_trang == 'hoan_thanh' ? 'selected' : '' }}
                            {{ !$daDenKhoDich && $package->tinh_trang != 'hoan_thanh' ? 'disabled' : '' }}
                            class="{{ !$daDenKhoDich && $package->tinh_trang != 'hoan_thanh' ? 'text-muted bg-light' : '' }}">
                            Hoàn thành
                            {{ !$daDenKhoDich && $package->tinh_trang != 'hoan_thanh' ? '🔒 (Chỉ mở khi đến kho đích)' : '' }}
                        </option>
                        <!-- <option value="tra_hang" {{ $package->tinh_trang == 'tra_hang' ? 'selected' : '' }}>Trả hàng
                        </option> -->
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h6 class="fw-bold text-primary mb-0">2. Thông số Kiện hàng</h6>

                @if(!$canEditMetrics)
                <div
                    class="d-flex align-items-center bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-pill px-3 py-1 shadow-sm">
                    <i class="bi bi-shield-lock-fill text-danger me-2"></i>
                    <span class="text-danger fw-semibold" style="font-size: 0.85rem;">
                        Chỉ nhân viên kho xuất phát được nhập thông số (1 lần duy nhất)
                    </span>
                </div>
                @endif
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Mã vận đơn (TQ) <span class="text-danger">*</span></label>
                    <input type="text" name="ma_van_don" class="form-control fw-bold" value="{{ $package->ma_van_don }}"
                        required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Trọng lượng (KG)</label>
                    <input type="number" step="0.01" name="tong_kg"
                        class="form-control fw-bold {{ $canEditMetrics ? 'text-danger' : $lockedClass }}"
                        value="{{ $package->tong_kg }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Thể tích (M3)</label>
                    <input type="number" step="0.001" name="tong_m3"
                        class="form-control fw-bold {{ $canEditMetrics ? 'text-primary' : $lockedClass }}"
                        value="{{ $package->tong_m3 }}" {{ $readonlyAttr }}>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Loại hàng hoá</label>
                    <input type="text" name="loai_hang" class="form-control" value="{{ $package->loai_hang }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Ghi chú kho</label>
                    <input type="text" name="ghi_chu" class="form-control" value="{{ $package->ghi_chu }}">
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3">3. Phí dịch vụ (VNĐ)</h6>
            <div class="row g-3">
                <!-- Phí nội địa TQ -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí nội địa TQ</label>
                    <!-- Đổi type="text", thêm class format-currency -->
                    <input type="text" id="input_phi_noi_dia" name="phi_van_chuyen_noi_dia"
                        class="form-control price-calc format-currency {{ $lockedClass }}"
                        value="{{ number_format($package->phi_van_chuyen_noi_dia ?? 0, 0, ',', '.') }}"
                        {{ $readonlyAttr }}>
                </div>

                <!-- Phí khác (Đóng gỗ, Kiểm đếm...) -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí khác</label>
                    @if($isMuaHo)
                    <input type="text" id="input_phi_khac" name="phi_khac" class="form-control bg-light price-calc"
                        value="0" readonly title="Phí dịch vụ đã được tính trong tổng đơn hàng">
                    <small class="text-success font-11"><i class="bi bi-check-circle"></i> Đã tính trong Tổng Đơn
                        Mua Hộ</small>
                    @else
                    <!-- Đơn KÝ GỬI: Mở cho nhập, kèm theo cảnh báo/gợi ý nếu có dịch vụ -->
                    <input type="text" id="input_phi_khac" name="phi_khac"
                        class="form-control price-calc format-currency {{ $lockedClass }}"
                        value="{{ number_format($package->phi_khac ?? 0, 0, ',', '.') }}" {{ $readonlyAttr }}>

                    @if(count($dichVuKyGui) > 0)
                    <div
                        class="mt-2 p-2 rounded bg-warning bg-opacity-10 border border-warning border-opacity-50 shadow-sm">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill text-warning mt-1 me-2 fs-6"></i>
                            <div class="w-100">
                                <span
                                    class="d-block font-12 text-dark fw-bold border-bottom border-warning border-opacity-50 pb-1 mb-1">
                                    Chi tiết dịch vụ khách yêu cầu:
                                </span>

                                <ul class="list-unstyled mb-1 font-11">
                                    @foreach($dichVuKyGui as $dichVu)
                                    <li class="d-flex justify-content-between text-muted mb-1">
                                        <span>- {{ $dichVu['ten'] }}:</span>
                                        <span class="text-dark fw-semibold">{{ number_format($dichVu['phi']) }}đ</span>
                                    </li>
                                    @endforeach
                                </ul>

                                <div
                                    class="d-flex justify-content-between font-11 text-muted border-top border-warning border-opacity-50 pt-1 mt-1">
                                    <strong class="text-danger">Tổng gợi ý thu thêm:</strong>
                                    <strong class="text-primary fs-6">+{{ number_format($goiYPhiKhac) }}đ</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Chiết khấu -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Chiết khấu</label>
                    <input type="text" id="input_chiet_khau" name="chiet_khau"
                        class="form-control price-calc text-success format-currency {{ $lockedClass }}"
                        value="{{ number_format($package->chiet_khau ?? 0, 0, ',', '.') }}" {{ $readonlyAttr }}>
                </div>

                <!-- Thành tiền Cước VC -->
                <div class="col-md-3">
                    <label class="form-label fw-bold text-danger">Thành tiền Cước VC</label>
                    <input type="text" id="input_thanh_tien" name="thanh_tien"
                        class="form-control fw-bold bg-white format-currency {{ $canEditMetrics ? 'text-danger' : $lockedClass }}"
                        value="{{ number_format($package->thanh_tien ?? 0, 0, ',', '.') }}" readonly>

                    @if($isMuaHo)
                    <small class="text-muted font-11">Tối thiểu: {{ number_format($tongTienDonMuaHo, 0, ',', '.') }}đ
                        (Tổng đơn mua hộ)</small>
                    @endif
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU CẬP
                NHẬT</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const isMuaHo = '{{ $isMuaHo ? "true" : "false" }}' === 'true';
    const tongTienDonMuaHo = parseFloat('{{ $tongTienDonMuaHo ?? 0 }}') || 0;

    // Bắt các ô input
    const inputNoiDia = document.getElementById('input_phi_noi_dia');
    const inputPhiKhac = document.getElementById('input_phi_khac');
    const inputChietKhau = document.getElementById('input_chiet_khau');
    const inputThanhTien = document.getElementById('input_thanh_tien');
    const calcInputs = document.querySelectorAll('.price-calc');
    const currencyInputs = document.querySelectorAll('.format-currency');


    function parseVNCurrency(val) {
        if (!val) return 0;

        let cleaned = val.toString().replace(/\./g, '');
        return parseInt(cleaned, 10) || 0;
    }

    // Hàm tính toán tổng tiền
    function calculateThanhTien() {
        // ĐỔI SANG DÙNG HÀM parseVNCurrency THAY VÌ parseFloat
        let phiNoiDia = parseVNCurrency(inputNoiDia.value);
        let phiKhac = parseVNCurrency(inputPhiKhac.value);
        let chietKhau = parseVNCurrency(inputChietKhau.value);

        let thanhTien = 0;

        if (isMuaHo) {
            thanhTien = tongTienDonMuaHo + phiNoiDia - chietKhau;
            if (thanhTien < tongTienDonMuaHo) {
                thanhTien = tongTienDonMuaHo;
            }
        } else {
            thanhTien = phiNoiDia + phiKhac - chietKhau;
            if (thanhTien < 0) thanhTien = 0;
        }

        // MỚI: Định dạng lại kết quả có dấu chấm trước khi gán vào ô Thành tiền
        inputThanhTien.value = new Intl.NumberFormat('vi-VN').format(thanhTien);
    }

    // Gắn sự kiện: Tính toán khi gõ phím
    calcInputs.forEach(input => {
        input.addEventListener('input', calculateThanhTien);
    });

    // Chạy lần đầu lúc load trang
    calculateThanhTien();

    // Logic định dạng số tiền khi nhập liệu
    currencyInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;

            let value = this.value.replace(/[^0-9]/g, '');

            if (value !== '') {
                this.value = new Intl.NumberFormat('vi-VN').format(parseInt(value, 10));
            } else {
                this.value = '';
            }

            let newLength = this.value.length;
            cursorPosition = cursorPosition + (newLength - originalLength);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });
    });
});
</script>
@endsection