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

<div class="container-fluid mt-4 px-4 pb-5">
    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #dc3545;">
            <i class="bi bi-pencil-square me-2"></i> Tạo Khiếu Nại Mới
        </h3>
        <a href="{{ route('complaint.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- KHỐI BÁO LỖI -->
    @if($errors->any())
    <div class="alert alert-danger mb-4 shadow-sm border-0">
        <ul class="mb-0">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <!-- FORM TẠO KHIẾU NẠI -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header text-white fw-bold text-uppercase" style="background-color: #dc3545;">
            Thông tin khiếu nại
        </div>
        <div class="card-body p-4">
            <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <!-- Cột Trái: Chọn Đơn/Kiện Hàng -->
                    <div class="col-md-6 mb-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <h5 class="fw-bold mb-3 text-dark">1. Đối tượng khiếu nại</h5>

                            <div class="d-flex gap-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="loai_lien_ket" id="lk_donhang"
                                        value="don_hang" onchange="toggleLienKet()" checked>
                                    <label class="form-check-label fw-semibold" for="lk_donhang">Theo Đơn mua hộ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="loai_lien_ket" id="lk_kienhang"
                                        value="kien_hang" onchange="toggleLienKet()">
                                    <label class="form-check-label fw-semibold" for="lk_kienhang">Theo Kiện hàng</label>
                                </div>
                            </div>

                            <!-- Khối chọn Đơn hàng -->
                            <div id="boxDonHang">
                                <label class="form-label fw-semibold text-primary">Chọn Đơn mua hộ bị sự cố <span
                                        class="text-danger">*</span></label>
                                <select name="order_id" class="form-select border-primary">
                                    <option value="">-- Chọn đơn hàng --</option>
                                    @foreach($orders as $order)
                                    <option value="{{ $order->id }}">Mã: #{{ $order->ma_don_hang }} (Tạo ngày
                                        {{ $order->created_at->format('d/m/Y') }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Khối chọn Kiện hàng -->
                            <div id="boxKienHang" class="d-none">
                                <label class="form-label fw-semibold text-success">Chọn Kiện hàng bị sự cố <span
                                        class="text-danger">*</span></label>
                                <select name="package_id" class="form-select border-success">
                                    <option value="">-- Chọn kiện hàng --</option>
                                    @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}">Mã kiện: {{ $pkg->ma_don_kien_hang }} (Vận đơn:
                                        {{ $pkg->ma_van_don }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Cột Phải: Nội dung & Bằng chứng -->
                    <div class="col-md-6 mb-4">
                        <div class="p-3 border rounded h-100">
                            <h5 class="fw-bold mb-3 text-dark">2. Chi tiết sự cố</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Loại khiếu nại <span
                                        class="text-danger">*</span></label>
                                <select name="loai_khieu_nai" class="form-select" required>
                                    <option value="">-- Chọn vấn đề bạn gặp phải --</option>
                                    <option value="hang_thieu">Thiếu hàng hóa</option>
                                    <option value="hang_hu">Hàng hóa bị hư hỏng / Vỡ</option>
                                    <option value="don_hang_cham">Đơn hàng về quá chậm</option>
                                    <option value="sai_chi_phi">Sai lệch chi phí báo giá</option>
                                    <option value="ship_cao">Phí Ship nội địa quá cao</option>
                                    <option value="thai_do_khong_tot">Thái độ phục vụ của nhân viên</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mong muốn xử lý (Tùy chọn)</label>
                                <select name="phuong_an" class="form-select">
                                    <option value="">-- Không yêu cầu --</option>
                                    <option value="boi_thuong">Yêu cầu bồi thường tiền</option>
                                    <option value="doi_tra">Yêu cầu đổi / Trả hàng về TQ</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tải ảnh bằng chứng (Nếu có)</label>
                                <input class="form-control" type="file" name="hinh_anh_file" accept="image/*">
                                <small class="text-muted d-block mt-1"><i class="bi bi-info-circle"></i> Vui lòng chụp
                                    rõ mã vận đơn, tình trạng hàng hóa... (Tối đa 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-lg btn-danger fw-bold px-5 py-2 shadow">
                            <i class="bi bi-send-check me-2"></i> GỬI KHIẾU NẠI
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script ẩn/hiện Select Box -->
<script>
function toggleLienKet() {
    var lkDonHang = document.getElementById('lk_donhang').checked;

    if (lkDonHang) {
        document.getElementById('boxDonHang').classList.remove('d-none');
        document.getElementById('boxKienHang').classList.add('d-none');
        // Xóa giá trị cũ để validate không báo lỗi sai
        document.querySelector('select[name="package_id"]').value = "";
    } else {
        document.getElementById('boxKienHang').classList.remove('d-none');
        document.getElementById('boxDonHang').classList.add('d-none');
        document.querySelector('select[name="order_id"]').value = "";
    }
}
</script>


@endsection