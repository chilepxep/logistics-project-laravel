@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')
<!-- Khối Banner & Tìm kiếm -->
<!-- Khối Banner & Tìm kiếm (Mô phỏng) -->
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

<!-- Khối Lưới Icon Chức năng (Grid 5 cột) -->
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 px-2">
    <!-- Item 1 -->
    <div class="col">
        <a href="#" class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-primary-subtle text-primary mx-auto mb-3">
                <i class="bi bi-pencil-square fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">TẠO ĐƠN HÀNG</h6>
        </a>
    </div>

    <!-- Item 2 -->
    <div class="col">
        <a href="#" class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-warning-subtle text-warning mx-auto mb-3">
                <i class="bi bi-truck fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">TẠO ĐƠN KÝ GỬI</h6>
        </a>
    </div>

    <!-- Item 3 -->
    <div class="col">
        <a href="#" class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-info-subtle text-info mx-auto mb-3">
                <i class="bi bi-journal-text fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">QUẢN LÝ ĐƠN HÀNG</h6>
        </a>
    </div>

    <!-- Item 4 -->
    <div class="col">
        <a href="#" class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-success-subtle text-success mx-auto mb-3">
                <i class="bi bi-boxes fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">QUẢN LÝ KIỆN HÀNG</h6>
        </a>
    </div>

    <!-- Item 5 -->
    <div class="col">
        <a href="#" class="card h-100 border-0 shadow-sm text-center text-decoration-none feature-card py-4 rounded-4">
            <div class="icon-wrapper bg-danger-subtle text-danger mx-auto mb-3">
                <i class="bi bi-box-arrow-right fs-2"></i>
            </div>
            <h6 class="text-dark fw-bold font-14 mb-0">GIAO HÀNG</h6>
        </a>
    </div>
    @endsection

    @section('right_sidebar')
    <!-- SIDEBAR PHẢI (Thông tin cá nhân) -->
    <aside class="right-sidebar py-5 px-3 text-center text-white d-none d-xl-block">

        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->ho_ten ?? 'User') }}&background=ffc107&color=000&size=100"
            class="rounded-circle border border-4 border-warning shadow mb-3" alt="Avatar">

        <p class="mb-2 font-14">Cấp độ VIP</p>
        <div class="progress bg-secondary mb-4 mx-auto" style="height: 6px; width: 60%;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
        </div>

        <hr class="border-secondary opacity-50 mb-4">

        <p class="font-14 text-white-50 mb-1">Họ tên</p>
        <h6 class="fw-bold mb-3">{{ Auth::user()->ho_ten ?? 'Chưa cập nhật' }}</h6>

        <p class="font-14 text-white-50 mb-1">Email</p>
        <h6 class="fw-bold mb-3">{{ Auth::user()->email ?? 'Chưa cập nhật' }}</h6>

        <p class="font-14 text-white-50 mb-1">Điện thoại</p>
        <h6 class="fw-bold mb-4">{{ Auth::user()->sdt ?? 'Chưa cập nhật' }}</h6>

        <a href="{{ route('profile.edit') }}"
            class="btn btn-outline-light rounded-pill font-14 px-4 shadow-sm mb-5">Chỉnh sửa thông tin</a>

        <!-- Tranh minh họa giờ làm việc -->
        <div class="mt-4 p-3 rounded-4"
            style="background-color: rgba(0,0,0,0.15); border: 1px dashed rgba(255,255,255,0.2);">
            <i class="bi bi-clock-history fs-1 text-warning mb-2"></i>
            <h6 class="fw-bold text-warning">8h00 - 17h30</h6>
            <small class="text-light font-12">Hỗ trợ hàng ngày</small>
        </div>

    </aside>
    @endsection