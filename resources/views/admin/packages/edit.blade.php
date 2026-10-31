@extends('layouts.admin')
@section('title', 'Cập nhật Kiện Hàng')
@section('page_title', 'Cập nhật Kiện: ' . $package->ma_don_kien_hang)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        @php
        $user = Auth::user();

        // Truy vấn lấy mảng tất cả các ID kho thuộc Việt Nam
        $danhSachKhoVN = \App\Models\Warehouse::where('loai_kho', 'VN')->pluck('id')->toArray();

        // Cấp quyền nếu là Admin HOẶC là nhân viên đang làm việc tại BẤT KỲ kho VN nào
        $canEditMetrics = ($user->vai_tro === 'admin' || ($user->vai_tro === 'nhan_vien' &&
        in_array($user->warehouse_id, $danhSachKhoVN)));

        $readonlyAttr = $canEditMetrics ? '' : 'readonly';
        $lockedClass = $canEditMetrics ? '' : 'bg-light text-muted';
        @endphp

        @php
        // 1. Khởi tạo các biến dùng chung mặc định
        $chieuVanChuyen = 've_vn';
        $tenKhoQuocTe = 'Kho Quốc Tế';
        $tenKhoVn = 'Kho Việt Nam';
        $tenQuocGia = '';

        // 2. Lấy dữ liệu nếu kiện hàng thuộc ĐƠN KÝ GỬI
        if ($package->consignment_order_id && $package->consignmentOrder) {
        $co = $package->consignmentOrder;
        $chieuVanChuyen = $co->chieu_van_chuyen;
        $tenKhoQuocTe = $co->khoQuocTe->ten_kho ?? 'Kho Quốc Tế';
        $tenKhoVn = $co->khoVn->ten_kho ?? 'Kho Việt Nam';
        $tenQuocGia = $co->country->ten_quoc_gia ?? '';
        }
        // 3. Lấy dữ liệu nếu kiện hàng thuộc ĐƠN MUA HỘ
        elseif ($package->order_id && $package->order) {
        $od = $package->order;
        // Đơn mua hộ thường mặc định là từ Quốc Tế về VN
        $chieuVanChuyen = $od->chieu_van_chuyen ?? 've_vn';

        // Mua hộ thì gốc xuất phát thường là từ Nhà cung cấp
        $tenKhoQuocTe = $od->supplier->ten_ncc ?? 'Kho Quốc Tế';

        // Đích đến là trụ sở nhận hàng ở VN (Sử dụng hàm quan hệ khoNhan)
        $tenKhoVn = $od->khoNhan->ten_kho ?? 'Kho Việt Nam';
        $tenQuocGia = $od->country->ten_quoc_gia ?? '';
        }

        // Gộp tên kho quốc tế và quốc gia cho gọn
        $hienThiKhoQuocTe = $tenKhoQuocTe . ($tenQuocGia ? " ($tenQuocGia)" : '');
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
                @endphp

                <div class="col-md-6">
                    <label class="form-label fw-bold">Vị trí kho hiện tại</label>
                    <select name="tru_so_id" class="form-select border-primary" required>
                        @foreach($warehouses as $kho)
                        <!-- Phân quyền hiển thị danh sách Kho -->
                        @if($isAdmin || ($isNhanVienVN && $kho->loai_kho === 'VN') || ($isNhanVienQT && $kho->loai_kho
                        !== 'VN'))
                        <option value="{{ $kho->id }}" {{ $package->tru_so_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endif
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
                            Đang về kho Việt Nam
                        </option>
                        @endif

                        <!-- Các trạng thái chung ai cũng thấy -->
                        <option value="hoan_thanh" {{ $package->tinh_trang == 'hoan_thanh' ? 'selected' : '' }}>Hoàn
                            thành</option>
                        <option value="tra_hang" {{ $package->tinh_trang == 'tra_hang' ? 'selected' : '' }}>Trả hàng
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-primary mb-0">2. Thông số Kiện hàng</h6>
                @if(!$canEditMetrics)
                <span class="badge bg-warning text-dark"><i class="bi bi-lock-fill"></i> Chỉ kho VN được sửa thông
                    số</span>
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

            @php
            // --- BƯỚC 1: XÁC ĐỊNH LOẠI ĐƠN VÀ CHUẨN BỊ LOGIC ---
            $isMuaHo = $package->order_id && $package->order ? true : false;
            $isKyGui = $package->consignment_order_id && $package->consignmentOrder ? true : false;

            $tongTienDonMuaHo = 0;
            $dichVuKyGui = []; // Sẽ lưu dạng: [['ten' => 'Bảo hiểm', 'phi' => 50000], ...]
            $goiYPhiKhac = 0;

            if ($isMuaHo) {
            $tongTienDonMuaHo = $package->order->tong_tien;
            }
            elseif ($isKyGui) {
            $co = $package->consignmentOrder;

            // 1. Phí Bảo hiểm & Khai thuế
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

            // 2. Phí Kiểm hàng & Đóng gỗ
            $cacYeuCauThem = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id', $co->id)
            ->pluck('loai_yeu_cau')
            ->toArray();

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
            @endphp

            <h6 class="fw-bold text-primary mt-4 mb-3">3. Phí dịch vụ (VNĐ)</h6>
            <div class="row g-3">
                <!-- Phí nội địa TQ -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí nội địa TQ</label>
                    <input type="number" id="input_phi_noi_dia" name="phi_van_chuyen_noi_dia"
                        class="form-control price-calc {{ $lockedClass }}"
                        value="{{ $package->phi_van_chuyen_noi_dia ?? 0 }}" {{ $readonlyAttr }}>
                </div>

                <!-- Phí khác (Đóng gỗ, Kiểm đếm...) -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Phí khác</label>
                    @if($isMuaHo)
                    <!-- Đơn MUA HỘ: Khóa hoàn toàn ô này vì đã thu tiền từ lúc tạo đơn -->
                    <input type="number" id="input_phi_khac" name="phi_khac" class="form-control bg-light price-calc"
                        value="0" readonly title="Phí dịch vụ đã được tính trong tổng đơn hàng">
                    <small class="text-success font-11"><i class="bi bi-check-circle"></i> Đã tính trong Tổng Đơn Mua
                        Hộ</small>
                    @else
                    <!-- Đơn KÝ GỬI: Mở cho nhập, kèm theo cảnh báo/gợi ý nếu có dịch vụ -->
                    <input type="number" id="input_phi_khac" name="phi_khac"
                        class="form-control price-calc {{ $lockedClass }}" value="{{ $package->phi_khac ?? 0 }}"
                        {{ $readonlyAttr }}>

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
                    <input type="number" id="input_chiet_khau" name="chiet_khau"
                        class="form-control price-calc text-success {{ $lockedClass }}"
                        value="{{ $package->chiet_khau ?? 0 }}" {{ $readonlyAttr }}>
                </div>

                <!-- Thành tiền Cước VC -->
                <div class="col-md-3">
                    <label class="form-label fw-bold text-danger">Thành tiền Cước VC</label>
                    <input type="number" id="input_thanh_tien" name="thanh_tien"
                        class="form-control fw-bold bg-white {{ $canEditMetrics ? 'text-danger' : $lockedClass }}"
                        value="{{ $package->thanh_tien ?? 0 }}" readonly> <!-- Readonly vì sẽ dùng JS tự động tính -->

                    @if($isMuaHo)
                    <small class="text-muted font-11">Tối thiểu: {{ number_format($tongTienDonMuaHo) }}đ (Tổng đơn mua
                        hộ)</small>
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
    // Nhận diện loại đơn và giá trị tối thiểu từ PHP
    const isMuaHo = '{{ $isMuaHo ? "true" : "false" }}' === 'true';
    const tongTienDonMuaHo = parseFloat('{{ $tongTienDonMuaHo ?? 0 }}') || 0;

    // Bắt các ô input
    const inputNoiDia = document.getElementById('input_phi_noi_dia');
    const inputPhiKhac = document.getElementById('input_phi_khac');
    const inputChietKhau = document.getElementById('input_chiet_khau');
    const inputThanhTien = document.getElementById('input_thanh_tien');
    const calcInputs = document.querySelectorAll('.price-calc');

    // Hàm tính toán tổng tiền
    function calculateThanhTien() {
        let phiNoiDia = parseFloat(inputNoiDia.value) || 0;
        let phiKhac = parseFloat(inputPhiKhac.value) || 0;
        let chietKhau = parseFloat(inputChietKhau.value) || 0;

        let thanhTien = 0;

        if (isMuaHo) {
            // QUY TẮC MUA HỘ: Tổng đơn hàng + Phí nội địa - Chiết khấu. 
            // Không được thấp hơn Tổng tiền đơn hàng.
            thanhTien = tongTienDonMuaHo + phiNoiDia - chietKhau;
            if (thanhTien < tongTienDonMuaHo) {
                thanhTien = tongTienDonMuaHo;
            }
        } else {
            // QUY TẮC KÝ GỬI: Phí nội địa + Phí khác - Chiết khấu
            // Không được thấp hơn (Phí nội địa + Phí khác - Chiết khấu) => Chặn nhập số âm
            thanhTien = phiNoiDia + phiKhac - chietKhau;
            if (thanhTien < 0) thanhTien = 0;
        }

        // Đổ dữ liệu vào ô Thành tiền
        inputThanhTien.value = thanhTien;
    }

    // Gắn sự kiện: Bất cứ khi nào nhân viên gõ phím vào 3 ô phí/chiết khấu thì hàm sẽ tự chạy
    calcInputs.forEach(input => {
        input.addEventListener('input', calculateThanhTien);
    });

    // Chạy lần đầu lúc vừa load trang để đảm bảo dữ liệu chuẩn
    calculateThanhTien();
});
</script>
@endsection