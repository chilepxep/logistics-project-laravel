@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div
    class="top-banner mb-4 p-4 rounded-4 shadow-sm bg-white d-flex flex-wrap align-items-center justify-content-between">
    <!-- Hotline -->
    <div class="d-flex align-items-center me-3 mb-3 mb-md-0">
        <i class="bi bi-headset text-primary fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">HOTLINE</small>
            <h5 class="text-danger fw-bold mb-0">024.6680.3049</h5>
        </div>
    </div>

    <!-- Thanh tìm kiếm Taobao -->
    <div class="flex-grow-1 mx-md-4 mb-3 mb-md-0" style="max-width: 500px;">
        <div class="input-group shadow-sm rounded-pill overflow-hidden border">
            <span class="input-group-text bg-white border-0 text-danger fw-bold">Taobao</span>
            <input type="text" class="form-control border-0 shadow-none font-14"
                placeholder="Nhập từ khóa tìm kiếm (Tiếng Việt)...">
            <button class="btn text-white px-4" type="button" style="background-color: #ff6a00;"><i
                    class="bi bi-search"></i></button>
        </div>
    </div>

    <!-- Tỉ giá -->
    <div class="d-flex align-items-center text-end">
        <i class="bi bi-cash-coin text-warning fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">TỈ GIÁ</small>
            <h5 class="text-danger fw-bold mb-0">3,520 đ</h5>
        </div>
    </div>
</div>



<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0 text-primary">
            <i class="bi bi-person-badge me-2"></i> Thông tin cá nhân
        </h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger shadow-sm border-0">
        <ul class="mb-0">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <!-- Cột Trái: Thẻ thông tin tài khoản (Chỉ đọc) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-primary text-white h-100 rounded-3">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->ho_ten }}</h4>
                    <p class="text-white-50 mb-4">{{ $user->email }}</p>

                    <div class="bg-white text-dark rounded-3 p-3 text-start shadow-sm">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted font-13">Mã tài khoản:</span>
                            <span class="fw-bold text-primary">{{ $user->ma_tai_khoan ?? 'Chưa cấp' }}</span>
                        </div>
                        <div class="mb-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted font-13">Số dư khả dụng:</span>
                            <span class="fw-bold text-danger fs-5">{{ number_format($user->so_du, 0, ',', '.') }}
                                đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Form cập nhật thông tin -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom pt-3 pb-2">
                    <h5 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i> Cập nhật hồ sơ
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ và tên <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="ho_ten" class="form-control"
                                    value="{{ old('ho_ten', $user->ho_ten) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="sdt" class="form-control" value="{{ old('sdt', $user->sdt) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" class="form-control"
                                    value="{{ old('ngay_sinh', $user->ngay_sinh ? $user->ngay_sinh->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Giới tính</label>
                                <select name="gioi_tinh" class="form-select">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="nam"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="nu"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                    <option value="khac"
                                        {{ old('gioi_tinh', $user->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tỉnh / Thành phố</label>
                                <input type="text" name="tinh_thanh" class="form-control"
                                    value="{{ old('tinh_thanh', $user->tinh_thanh) }}" placeholder="VD: Hà Nội, TP.HCM">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Địa chỉ chi tiết</label>
                                <input type="text" name="dia_chi" class="form-control"
                                    value="{{ old('dia_chi', $user->dia_chi) }}"
                                    placeholder="Số nhà, đường, phường/xã...">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Loại vận chuyển mặc định (Gợi ý cho đơn hàng
                                    sau)</label>
                                <select name="loai_van_chuyen_mac_dinh" class="form-select border-primary">
                                    <option value="">-- Chọn phương thức mặc định --</option>
                                    <option value="thuong"
                                        {{ old('loai_van_chuyen_mac_dinh', $user->loai_van_chuyen_mac_dinh) == 'thuong' ? 'selected' : '' }}>
                                        Vận chuyển Thường (Tiết kiệm)</option>
                                    <option value="nhanh"
                                        {{ old('loai_van_chuyen_mac_dinh', $user->loai_van_chuyen_mac_dinh) == 'nhanh' ? 'selected' : '' }}>
                                        Vận chuyển Nhanh</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm">
                                    <i class="bi bi-save me-1"></i> Lưu Thay Đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script xử lý thêm/xóa dòng liên hệ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddContact = document.getElementById('btnAddContact');
    const contactTableBody = document.getElementById('contactTableBody');
    let contactIndex = 1; // Bắt đầu từ 1 vì 0 đã dùng ở dòng mặc định

    // Thêm dòng mới
    btnAddContact.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
                <td class="p-1">
                    <select name="contacts[${contactIndex}][loai]" class="form-select form-select-sm border-secondary">
                        <option value="wechat">WeChat</option>
                        <option value="sdt">Số điện thoại</option>
                        <option value="qq">QQ</option>
                        <option value="email">Email</option>
                    </select>
                </td>
                <td class="p-1">
                    <input type="text" name="contacts[${contactIndex}][gia_tri]" class="form-control form-control-sm" placeholder="Nhập thông tin..." required>
                </td>
                <td class="text-center p-1">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-contact"><i class="bi bi-trash"></i></button>
                </td>
            `;
        contactTableBody.appendChild(newRow);
        contactIndex++;
    });

    // Xóa dòng
    contactTableBody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-contact');
        if (deleteBtn) {
            deleteBtn.closest('tr').remove();
        }
    });
});
</script>

@endsection