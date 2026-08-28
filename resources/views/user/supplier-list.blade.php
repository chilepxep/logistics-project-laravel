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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #6f42c1;">
            <i class="bi bi-shop me-2"></i> Danh sách Nhà Cung Cấp
        </h3>
        <a href="{{ route('supplier.create') }}" class="btn text-white fw-semibold shadow-sm"
            style="background-color: #6f42c1;">
            <i class="bi bi-plus-lg me-1"></i> Thêm NCC mới
        </a>
    </div>

    <!-- KHỐI TÌM KIẾM -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('supplier.index') }}" method="GET" class="d-flex gap-2 w-50">
                <input type="text" name="keyword" class="form-control"
                    placeholder="Tìm theo Tên hoặc Mã nhà cung cấp..." value="{{ request('keyword') }}">
                <button type="submit" class="btn text-white fw-semibold px-4" style="background-color: #6f42c1;">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('keyword'))
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Xóa</a>
                @endif
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center text-white" style="background-color: #6f42c1;">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 25%;">Thông tin NCC</th>
                            <th style="width: 20%;">Liên hệ</th>
                            <th style="width: 20%;">Tài khoản ngân hàng</th>
                            <th style="width: 20%;">Thống kê giao dịch</th>
                            <th style="width: 10%;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td class="text-center">
                                {{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $index + 1 }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Logo -->
                                    @if($supplier->logo_url)
                                    <img src="{{ $supplier->logo_url }}" class="rounded border"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="rounded border bg-light d-flex justify-content-center align-items-center text-muted"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-shop fs-4"></i>
                                    </div>
                                    @endif

                                    <!-- Tên & Phân loại -->
                                    <div>
                                        <div class="fw-bold fs-6 text-dark">{{ $supplier->ten_ncc }}</div>
                                        <div class="font-12 text-muted mb-1">Mã: <span
                                                class="fw-semibold">{{ $supplier->ma_ncc }}</span></div>
                                        <div class="d-flex gap-1">
                                            @if($supplier->hinh_thuc == 'online')
                                            <span class="badge bg-info text-dark font-11">Online</span>
                                            @else
                                            <span class="badge bg-secondary font-11">Offline</span>
                                            @endif
                                            @if($supplier->nganh_hang)
                                            <span
                                                class="badge border text-dark font-11">{{ $supplier->nganh_hang }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Hiển thị động các liên hệ -->
                            <td>
                                @if($supplier->ten_nguoi_dai_dien)
                                <div class="fw-bold mb-1"><i class="bi bi-person me-1"></i>
                                    {{ $supplier->ten_nguoi_dai_dien }} <span
                                        class="fw-normal text-muted font-12">({{ $supplier->chuc_vu ?? 'N/A' }})</span>
                                </div>
                                @endif

                                <div class="d-flex flex-column gap-1 mt-2">
                                    @forelse($supplier->contacts as $contact)
                                    <div class="font-13">
                                        @switch($contact->loai)
                                        @case('sdt') <i class="bi bi-telephone-fill text-success me-1"></i> @break
                                        @case('email') <i class="bi bi-envelope-fill text-danger me-1"></i> @break
                                        @case('wechat') <i class="bi bi-chat-fill text-success me-1"></i> @break
                                        @case('qq') <i class="bi bi-chat-square-dots-fill text-primary me-1"></i> @break
                                        @endswitch
                                        {{ $contact->gia_tri }}
                                    </div>
                                    @empty
                                    <span class="text-muted font-12 fst-italic">Chưa có liên hệ</span>
                                    @endforelse
                                </div>
                            </td>

                            <!-- Tài khoản thanh toán -->
                            <td>
                                @if($supplier->ten_ngan_hang && $supplier->so_tai_khoan)
                                <div class="fw-semibold text-primary">{{ $supplier->ten_ngan_hang }}</div>
                                <div class="fw-bold">{{ $supplier->so_tai_khoan }}</div>
                                <div class="text-uppercase font-12 text-muted">{{ $supplier->chu_tai_khoan }}</div>
                                <div class="font-12 text-muted">{{ $supplier->chi_nhanh }}</div>
                                @else
                                <span class="text-muted fst-italic">Chưa cập nhật</span>
                                @endif
                            </td>

                            <!-- Thống kê (Tổng tiền & Khiếu nại) -->
                            <td>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Tổng nhập:</span>
                                    <span
                                        class="fw-bold text-danger">{{ number_format($supplier->tong_tien_dat_hang, 0, ',', '.') }}
                                        đ</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Khiếu nại:</span>
                                    @if($supplier->tong_khieu_nai > 0)
                                    <span class="fw-bold text-danger">{{ $supplier->tong_khieu_nai }} lần</span>
                                    @else
                                    <span class="fw-bold text-success">0 lần</span>
                                    @endif
                                </div>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-info text-white mb-1 w-100" title="Xem / Sửa">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-shop-window fs-1 d-block mb-2"></i>
                                Chưa có dữ liệu nhà cung cấp nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        @if($suppliers->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection