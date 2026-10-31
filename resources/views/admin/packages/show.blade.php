@extends('layouts.admin')
@section('title', 'Chi tiết Kiện Hàng')
@section('page_title', 'Chi tiết Kiện: ' . $package->ma_don_kien_hang)

@section('content')

<style>
/* Đường kẻ dọc nền */
.tracking-timeline {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 2rem;
    margin-top: 1rem;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 7px;
    width: 2px;
    background-color: #dee2e6;
    /* Màu xám nhạt */
}

/* Từng mốc thời gian */
.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

/* Dấu chấm tròn (Dot) */
.timeline-item::before {
    content: '';
    position: absolute;
    top: 5px;
    left: -2rem;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #0d6efd;
    /* Màu xanh lam */
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px #dee2e6;
    z-index: 2;
}

/* Highlight điểm mới nhất (Dòng đầu tiên) */
.timeline-item:first-child::before {
    background-color: #198754;
    /* Màu xanh lá (Success) */
    box-shadow: 0 0 0 2px #198754;
}

.timeline-item:first-child .tracking-title {
    color: #198754 !important;
}
</style>

@php
// 1. Khởi tạo cờ kiểm tra kiện hàng đã đến kho cuối chưa
$daDenKhoCuoi = false;

// 2. Chỉ tiếp tục kiểm tra vị trí kho NẾU kiện hàng đã ở trạng thái "hoan_thanh"
if ($package->tinh_trang === 'hoan_thanh') {

// --- XÉT ĐƠN MUA HỘ ---
if ($package->order_id && $package->order) {
// Đơn mua hộ: Đích luôn là Trụ sở nhận hàng (Kho VN)
if ($package->tru_so_id == $package->order->tru_so_nhan_hang_id) {
$daDenKhoCuoi = true;
}
}

// --- XÉT ĐƠN KÝ GỬI ---
elseif ($package->consignment_order_id && $package->consignmentOrder) {
$co = $package->consignmentOrder;

// Xác định kho đích linh hoạt theo chiều vận chuyển
$khoDichId = ($co->chieu_van_chuyen === 'di_qt')
? $co->supplier_id // Chiều đi QT: Đích là Kho Quốc Tế (mượn cột supplier_id)
: $co->kho_vn_id; // Chiều về VN: Đích là Kho VN

// So sánh kho hiện tại với kho đích vừa tìm được
if ($package->tru_so_id == $khoDichId) {
$daDenKhoCuoi = true;
}
}

}
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

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold">Thông tin chi tiết kiện hàng</h6>
        <div>

            @if($daDenKhoCuoi)
            @if($package->delivery)
            <!-- Đã có phiếu -->
            <a href="{{ route('admin.deliveries.index') }}" class="btn btn-sm btn-info text-white shadow-sm">
                <i class="bi bi-card-checklist"></i> Xem phiếu giao hàng
            </a>
            @else
            <!-- Chưa có phiếu: Hiện nút bấm và Modal -->
            <button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalDelivery{{ $package->id }}">
                <i class="bi bi-truck"></i> Điều phối Giao hàng nội địa
            </button>

            <!-- Modal Chọn Đơn vị vận chuyển (Chỉ render khi chưa có phiếu) -->
            <div class="modal fade" id="modalDelivery{{ $package->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content shadow bg-white">
                        <form action="{{ route('admin.deliveries.store') }}" method="POST" class="modal-content">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="bi bi-truck"></i> Tạo phiếu giao hàng -
                                    {{ $package->ma_don_kien_hang }}</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body bg-white">
                                <div
                                    class="form-check form-switch mb-4 bg-light p-3 rounded-3 border border-info shadow-sm d-flex align-items-center">
                                    <input class="form-check-input fs-4 ms-0 me-3 mt-0" type="checkbox"
                                        id="togglePickup{{ $package->id }}"
                                        onchange="handlePickupToggle('{{ $package->id }}')" style="cursor: pointer;">
                                    <label class="form-check-label fw-bold text-primary mb-0"
                                        for="togglePickup{{ $package->id }}" style="cursor: pointer;">
                                        <i class="bi bi-person-walking me-2"></i> Khách hàng đến tận kho nhận
                                    </label>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Hãng vận chuyển <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phuong_thuc_van_chuyen" id="provider{{ $package->id }}"
                                            class="form-control border-success fw-bold"
                                            placeholder="VD: GHTK, Viettel Post..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Mã vận đơn nội địa</label>
                                        <input type="text" name="ma_van_don" id="tracking{{ $package->id }}"
                                            class="form-control" placeholder="Nhập mã bill nếu có">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Mã vùng / Tuyến</label>
                                        <input type="text" name="ma_vung_noi_dia" id="zone{{ $package->id }}"
                                            class="form-control" placeholder="VD: SG-01">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Thanh toán cước</label>
                                        <select name="phuong_thuc_thanh_toan" id="payment{{ $package->id }}"
                                            class="form-select">
                                            <option value="nguoi_nhan_tra">Khách trả cước (FOB)</option>
                                            <option value="da_thanh_toan">Công ty trả cước</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-primary">Trạng thái ban đầu</label>
                                        <select name="trang_thai" id="status{{ $package->id }}"
                                            class="form-select border-primary fw-bold">
                                            <option value="dang_van_chuyen">Đang đi giao</option>
                                            <option value="den_kho_nhan_hang">Khách đến kho nhận hàng</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">Thông tin người nhận <span
                                            class="text-danger">*</span></label>
                                    <textarea name="thong_tin_giao_hang" id="receiverInfo{{ $package->id }}"
                                        class="form-control" rows="2" required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Tạo phiếu giao
                                    hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @else
            <!-- Chưa đến kho cuối -->
            <button type="button" class="btn btn-warning text-dark opacity-75" style="cursor: not-allowed;"
                title="Kiện hàng chưa về đến kho cuối cùng, chưa thể điều phối giao hàng." disabled>
                <i class="bi bi-info-circle me-1"></i> Chưa thể điều phối
            </button>
            @endif

            @if(auth()->user()->vai_tro === 'admin' || (auth()->user()->vai_tro === 'nhan_vien' &&
            $package->tru_so_id == auth()->user()->warehouse_id))


            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil-square"></i> Sửa
            </a>

            @else

            <!-- Khóa nút nếu là kiện hàng của kho khác -->
            <button class="btn btn-sm btn-secondary" disabled title="Kiện hàng này không nằm trong kho của bạn">
                <i class="bi bi-lock-fill"></i> Sửa
            </button>

            @endif
            <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
    <div class="card-body p-4">

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-truck"></i> 1. Hành trình & Trạng thái</h6>
        <div class="row g-3 mb-4 bg-light p-3 rounded">

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
            <div class="col-md-6">
                <p class="text-muted mb-1">Vị trí hiện tại (Kho)</p>
                <h5 class="fw-bold text-success"><i class="bi bi-geo-alt-fill"></i>
                    {{ $package->warehouse->ten_kho ?? 'Chưa xác định' }}</h5>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Trạng thái kiện hàng</p>
                <span
                    class="badge bg-info text-dark fs-6">{{ $package->trang_thai_hien_thi ?? $package->tinh_trang }}</span>
                @if($package->delivery && $package->delivery->trang_thai != 'thanh_cong' &&
                $package->delivery->so_ngay_tre > 0)
                <div class="mt-2">
                    <span
                        class="d-inline-flex align-items-center gap-1 bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill font-12 fw-semibold">
                        <i class="bi bi-clock-history"></i> Trễ {{ $package->delivery->so_ngay_tre }} ngày
                        (+{{ number_format($package->delivery->phu_phi_tre_han) }}đ)
                    </span>
                </div>
                @endif
            </div>
            <div class="col-md-12 mt-3">
                <p class="text-muted mb-1">Thuộc về Đơn hàng:</p>
                @if($package->order_id)
                <div class="p-2 border border-primary rounded d-inline-block">
                    <span class="badge bg-primary me-2">ĐƠN MUA HỘ</span>
                    <a href="{{ route('admin.orders.show', $package->order_id) }}" class="fw-bold text-decoration-none">
                        {{ $package->order->ma_don_hang ?? 'Xem chi tiết' }}
                    </a>
                    <span class="text-muted ms-2">(Khách: {{ $package->order->user->ho_ten ?? 'N/A' }})</span>
                </div>
                @elseif($package->consignment_order_id)
                <div class="p-2 border border-secondary rounded d-inline-block">
                    <span class="badge bg-secondary me-2">ĐƠN KÝ GỬI</span>
                    <a href="{{ route('admin.consignment_orders.show', $package->consignment_order_id) }}"
                        class="fw-bold text-decoration-none text-secondary">
                        {{ $package->consignmentOrder->ma_don_ky_gui ?? 'Xem chi tiết' }}
                    </a>
                    <span class="text-muted ms-2">(Khách:
                        {{ $package->consignmentOrder->user->ho_ten ?? 'N/A' }})</span>
                </div>
                @else
                <span class="text-danger">Kiện hàng mồ côi (Không thuộc đơn nào)</span>
                @endif
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-box-seam"></i> 2. Thông số Kiện hàng</h6>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <p class="text-muted mb-1">Mã vận đơn (Trung Quốc)</p>
                <h5 class="fw-bold">{{ $package->ma_van_don }}</h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-1">Trọng lượng</p>
                <h5 class="text-danger fw-bold">{{ $package->tong_kg ?? '0' }} <small class="text-muted">KG</small></h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-1">Thể tích</p>
                <h5 class="text-primary fw-bold">{{ $package->tong_m3 ?? '0' }} <small class="text-muted">M3</small>
                </h5>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Loại hàng hoá</p>
                <p class="fw-bold">{{ $package->loai_hang ?? '---' }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted mb-1">Ghi chú kho</p>
                <p class="fw-bold">{{ $package->ghi_chu ?? '---' }}</p>
            </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-cash-stack"></i> 3. Phí dịch vụ & Cước</h6>
        <div class="row g-3">
            <div class="col-md-3">
                <p class="text-muted mb-1">Phí nội địa TQ</p>
                <p class="fw-bold">{{ number_format($package->phi_van_chuyen_noi_dia) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Phí khác (Đóng gỗ...)</p>
                <p class="fw-bold">{{ number_format($package->phi_khac) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Chiết khấu giảm trừ</p>
                <p class="fw-bold text-success">- {{ number_format($package->chiet_khau) }} đ</p>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-1">Thành tiền Cước VC</p>
                <h4 class="text-danger fw-bold">{{ number_format($package->thanh_tien) }} đ</h4>
            </div>
        </div>

    </div>

    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-clock-history me-2 text-primary"></i> Lịch sử hành trình
            </h5>
        </div>

        <div class="card-body">
            <!-- Kiểm tra xem kiện hàng đã có lịch sử chưa -->
            @if($package->trackings && $package->trackings->count() > 0)
            <div class="tracking-timeline">

                <!-- Vòng lặp in danh sách Tracking (đã được sort mới nhất lên đầu trong Model) -->
                @foreach($package->trackings as $tracking)
                <div class="timeline-item">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 fw-bold tracking-title text-dark">
                            {{ $tracking->title }}
                        </h6>
                        <span class="text-muted font-13" style="font-size: 13px;">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $tracking->created_at->format('d/m/Y - H:i') }}
                        </span>
                    </div>

                    <p class="mb-2 text-muted" style="font-size: 14px;">
                        {{ $tracking->description }}
                    </p>

                    <!-- Hiển thị người cập nhật và vị trí kho -->
                    <div class="mt-1" style="font-size: 12px;">
                        @if($tracking->warehouse)
                        <span class="badge bg-light text-dark border me-2 py-1 px-2">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                            {{ $tracking->warehouse->ten_kho }}
                        </span>
                        @endif

                        @if($tracking->employee)
                        <span class="badge bg-light text-muted border py-1 px-2">
                            <i class="bi bi-person-fill me-1"></i>
                            {{ $tracking->employee->ho_ten }}
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
            @else
            <!-- Nếu chưa có dữ liệu -->
            <div class="alert alert-secondary text-center border-0 py-4">
                <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
                Chưa có dữ liệu lịch sử hành trình cho kiện hàng này.
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function handlePickupToggle(packageId) {
    const toggle = document.getElementById('togglePickup' + packageId);

    // Lấy các element dựa theo ID của từng kiện hàng
    const provider = document.getElementById('provider' + packageId);
    const tracking = document.getElementById('tracking' + packageId);
    const zone = document.getElementById('zone' + packageId);
    const status = document.getElementById('status' + packageId);
    const receiver = document.getElementById('receiverInfo' + packageId);

    if (toggle.checked) {
        // NẾU BẬT GẠT: Tự động điền dữ liệu và khóa ô (Dùng readOnly để Form vẫn gửi dữ liệu lên Backend)
        provider.value = "Khách nhận tại kho";
        provider.readOnly = true;
        provider.classList.replace('border-success', 'bg-light');
        provider.classList.add('text-muted');

        tracking.value = "";
        tracking.readOnly = true;
        tracking.classList.add('bg-light');
        tracking.placeholder = "Không yêu cầu mã vận đơn";

        zone.value = "Tại kho";
        zone.readOnly = true;
        zone.classList.add('bg-light', 'text-muted');

        status.value = "den_kho_nhan_hang";

        // Gợi ý luôn câu nhận hàng để nhân viên không cần gõ (Chỉ điền nếu ô đang trống)
        if (receiver.value.trim() === "") {
            receiver.value = "Khách hàng đến nhận trực tiếp tại kho.";
        }

    } else {
        // NẾU TẮT GẠT: Xóa dữ liệu tự động, mở khóa ô trở lại bình thường
        provider.value = "";
        provider.readOnly = false;
        provider.classList.replace('bg-light', 'border-success');
        provider.classList.remove('text-muted');

        tracking.readOnly = false;
        tracking.classList.remove('bg-light');
        tracking.placeholder = "Nhập mã bill nếu có";

        zone.value = "";
        zone.readOnly = false;
        zone.classList.remove('bg-light', 'text-muted');

        status.value = "dang_van_chuyen";

        // Xóa câu gợi ý nếu nhân viên chưa sửa gì
        if (receiver.value === "Khách hàng đến nhận trực tiếp tại kho.") {
            receiver.value = "";
        }
    }
}
</script>
@endsection