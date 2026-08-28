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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #dc3545;">
            <i class="bi bi-shield-exclamation me-2"></i> Trung tâm Khiếu nại
        </h3>

        <a href="{{ route('complaint.create') }}" class="btn btn-warning fw-semibold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tạo khiếu nại mới
        </a>

    </div>

    <!-- THANH THỐNG KÊ TRẠNG THÁI -->
    <div class="row mb-4 g-3">
        <div class="col">
            <div class="card bg-primary text-white border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-0">{{ $summary['tong'] }}</h4>
                    <span class="font-13 opacity-75 text-uppercase">Tổng cộng</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-secondary text-white border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-0">{{ $summary['cho_xu_ly'] }}</h4>
                    <span class="font-13 opacity-75 text-uppercase">Chờ xử lý</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info text-dark border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-0">{{ $summary['da_xu_ly'] }}</h4>
                    <span class="font-13 text-uppercase" style="opacity: 0.8">Đang xử lý</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success text-white border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-0">{{ $summary['da_hoan_thanh'] }}</h4>
                    <span class="font-13 opacity-75 text-uppercase">Hoàn thành</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-danger text-white border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <h4 class="fw-bold mb-0">{{ $summary['da_huy'] }}</h4>
                    <span class="font-13 opacity-75 text-uppercase">Đã hủy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- KHỐI LỌC DỮ LIỆU -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('complaint.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Từ ngày</label>
                    <input type="date" name="tu_ngay" class="form-control form-control-sm"
                        value="{{ request('tu_ngay') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label font-13 fw-semibold text-muted mb-1">Đến ngày</label>
                    <input type="date" name="den_ngay" class="form-control form-control-sm"
                        value="{{ request('den_ngay') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-danger text-white w-100 fw-semibold">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('complaint.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Bỏ lọc
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center text-white" style="background-color: #dc3545;">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 15%;">Mã Đơn / Kiện</th>
                            <th style="width: 15%;">Ngày Tạo</th>
                            <th style="width: 20%;">Loại Khiếu Nại</th>
                            <th style="width: 15%;">Phương Án Đề Xuất</th>
                            <th style="width: 15%;">Trạng Thái</th>
                            <th style="width: 15%;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $index => $cp)
                        <tr>
                            <td class="text-center">
                                {{ ($complaints->currentPage() - 1) * $complaints->perPage() + $index + 1 }}</td>

                            <td class="text-center fw-bold">
                                @if($cp->order_id)
                                <div class="text-primary">Đơn: #{{ $cp->order->ma_don_hang ?? $cp->order_id }}</div>
                                @endif
                                @if($cp->package_id)
                                <div class="text-success">Kiện: {{ $cp->package->ma_don_kien_hang ?? $cp->package_id }}
                                </div>
                                @endif
                            </td>

                            <td class="text-center">{{ \Carbon\Carbon::parse($cp->created_at)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                @switch($cp->loai_khieu_nai)
                                @case('don_hang_cham') Hàng về chậm @break
                                @case('thai_do_khong_tot') Thái độ phục vụ @break
                                @case('sai_chi_phi') Sai lệch chi phí @break
                                @case('ship_cao') Phí Ship nội địa cao @break
                                @case('hang_thieu') Thiếu hàng hóa @break
                                @case('hang_hu') Hàng hóa bị hỏng @break
                                @default {{ $cp->loai_khieu_nai }}
                                @endswitch
                            </td>

                            <td class="text-center">
                                @if($cp->phuong_an == 'boi_thuong')
                                <span class="badge bg-warning text-dark"><i class="bi bi-cash-coin"></i> Bồi
                                    thường</span>
                                @elseif($cp->phuong_an == 'doi_tra')
                                <span class="badge bg-info text-dark"><i class="bi bi-arrow-repeat"></i> Đổi trả
                                    hàng</span>
                                @else
                                <span class="text-muted">--</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @switch($cp->trang_thai)
                                @case('cho_xu_ly') <span class="badge bg-secondary">Chờ xử lý</span> @break
                                @case('da_xu_ly') <span class="badge bg-info text-dark">Đang xử lý</span> @break
                                @case('da_hoan_thanh') <span class="badge bg-success">Hoàn thành</span> @break
                                @case('da_huy') <span class="badge bg-danger">Đã hủy</span> @break
                                @endswitch
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-smile fs-1 d-block mb-2 text-success"></i>
                                Tuyệt vời! Bạn không có khiếu nại nào cần xử lý.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        @if($complaints->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $complaints->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>



@endsection