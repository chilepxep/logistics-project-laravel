@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div class="container-fluid mt-4 px-4">
    <form action="{{ route('package.store') }}" method="POST">
        @csrf
        <!-- Tiêu đề & Nút lưu -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-uppercase fw-bold m-0" style="color: #6f42c1;">
                <i class="bi bi-box-seam me-2"></i> Thêm Kiện Hàng Mới
            </h3>
            <div>
                <a href="{{ route('package.index') }}" class="btn btn-outline-secondary me-2">Hủy</a>
                <button type="submit" class="btn text-white fw-bold" style="background-color: #6f42c1;">
                    <i class="bi bi-save me-1"></i> Lưu kiện hàng
                </button>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            <!-- Cột Trái: Thông tin kiện hàng -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light fw-bold text-uppercase" style="color: #6f42c1;">
                        1. Thông tin kiện hàng
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mã vận đơn (Tracking) <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="ma_van_don" class="form-control"
                                placeholder="Nhập mã vận đơn từ nhà cung cấp" required value="{{ old('ma_van_don') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kho nhận hàng <span
                                    class="text-danger">*</span></label>
                            <select name="tru_so_id" class="form-select" required>
                                <option value="">-- Chọn kho nhận hàng --</option>
                                @foreach($warehouses as $kho)
                                <option value="{{ $kho->id }}">{{ $kho->ten_kho }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Loại hàng hóa</label>
                            <input type="text" name="loai_hang" class="form-control"
                                placeholder="VD: Quần áo, Đồ điện tử..." value="{{ old('loai_hang') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ghi chú</label>
                            <textarea name="ghi_chu" class="form-control" rows="3"
                                placeholder="Ghi chú thêm cho nhân viên kho...">{{ old('ghi_chu') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột Phải: Liên kết đơn hàng -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light fw-bold text-uppercase" style="color: #6f42c1;">
                        2. Liên kết đơn hàng
                    </div>
                    <div class="card-body">
                        <p class="text-muted font-13 mb-3">Vui lòng chọn loại đơn hàng mà kiện hàng này thuộc về.</p>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="loai_lien_ket" id="lk_muaho"
                                value="mua_ho" onchange="toggleLienKet()" checked>
                            <label class="form-check-label fw-semibold" for="lk_muaho">Thuộc Đơn Mua Hộ</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="loai_lien_ket" id="lk_kygui"
                                value="ky_gui" onchange="toggleLienKet()">
                            <label class="form-check-label fw-semibold" for="lk_kygui">Thuộc Đơn Ký Gửi</label>
                        </div>
                        <!-- Khối chọn Đơn Mua Hộ -->
                        <div id="boxMuaHo" class="mb-3">
                            <label class="form-label fw-bold text-info">Chọn Đơn Mua Hộ <span
                                    class="text-danger">*</span></label>
                            <select name="order_id" class="form-select border-info">
                                <option value="">-- Chọn Đơn Mua Hộ --</option>
                                @foreach($orders as $order)
                                <option value="{{ $order->id }}">#{{ $order->ma_don_hang }}
                                    ({{ $order->created_at->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Khối chọn Đơn Ký Gửi (Mặc định ẩn) -->
                        <div id="boxKyGui" class="d-none mb-3">
                            <label class="form-label fw-bold text-success">Chọn Đơn Ký Gửi <span
                                    class="text-danger">*</span></label>
                            <select name="consignment_order_id" class="form-select border-success">
                                <option value="">-- Chọn Đơn Ký Gửi --</option>
                                @foreach($consignmentOrders as $order)
                                <option value="{{ $order->id }}">#{{ $order->ma_don_ky_gui }}
                                    ({{ date('d/m/Y', strtotime($order->ngay_tao_yeu_cau)) }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
</form>
</div>

<!-- Script xử lý ẩn/hiện Select Box -->
<script>
function toggleLienKet() {
    var lkMuaHo = document.getElementById('lk_muaho').checked;
    var lkKyGui = document.getElementById('lk_kygui').checked;

    // Ẩn/Hiện khối mua hộ
    if (lkMuaHo) {
        document.getElementById('boxMuaHo').classList.remove('d-none');
    } else {
        document.getElementById('boxMuaHo').classList.add('d-none');
        document.querySelector('select[name="order_id"]').value = "";
    }

    // Ẩn/Hiện khối ký gửi
    if (lkKyGui) {
        document.getElementById('boxKyGui').classList.remove('d-none');
    } else {
        document.getElementById('boxKyGui').classList.add('d-none');
        document.querySelector('select[name="consignment_order_id"]').value = "";
    }
}
</script>

@endsection