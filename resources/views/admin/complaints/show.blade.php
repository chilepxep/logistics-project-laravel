@extends('layouts.admin')
@section('title', 'Chi tiết Khiếu nại')
@section('page_title', 'Chi tiết Khiếu nại #' . $complaint->id)

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold">Thông tin Khiếu nại</h6>
            </div>
            <div class="card-body">
                @if($complaint->hinh_anh_url)
                <img src="{{ asset($complaint->hinh_anh_url) }}" class="img-fluid rounded mb-3 w-100"
                    style="max-height: 250px; object-fit: contain; background: #f8f9fa;">
                @endif
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted w-50">Loại khiếu nại:</td>
                        <td class="fw-bold">{{ $complaint->loai_khieu_nai }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Trạng thái:</td>
                        <td><span class="badge bg-primary">{{ $complaint->trang_thai }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Đơn hàng tham chiếu:</td>
                        <td>{{ $complaint->order->ma_don_hang ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kiện hàng tham chiếu:</td>
                        <td>{{ $complaint->package->ma_van_don ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">NV Đặt hàng:</td>
                        <td>{{ $complaint->nhanVienDatHang->ho_ten ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">NV Đang xử lý:</td>
                        <td class="text-danger fw-bold">{{ $complaint->nhanVienXuLy->ho_ten ?? 'Chưa phân công' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                <h6 class="m-0 fw-bold">Phương án & Xử lý</h6>
                <a href="{{ route('admin.complaints.edit', $complaint->id) }}" class="btn btn-sm btn-warning"><i
                        class="bi bi-pencil"></i> Cập nhật</a>
            </div>
            <div class="card-body">
                <h6 class="text-muted fw-bold mb-2">Kết quả / Phương án giải quyết:</h6>
                <div class="p-3 bg-light rounded border border-secondary border-opacity-25">
                    @if($complaint->phuong_an == 'boi_thuong')
                    <h5 class="text-danger fw-bold m-0"><i class="bi bi-cash-coin me-2"></i> Bồi thường cho khách hàng
                    </h5>
                    @elseif($complaint->phuong_an == 'doi_tra')
                    <h5 class="text-warning text-dark fw-bold m-0"><i class="bi bi-arrow-left-right me-2"></i> Hỗ trợ
                        Đổi/Trả hàng</h5>
                    @else
                    <span class="text-muted fst-italic"><i class="bi bi-hourglass-split me-1"></i> Chưa có phương án xử
                        lý...</span>
                    @endif
                </div>

                <hr>
                @if($complaint->order)
                <h6 class="text-muted fw-bold mb-2">Thông tin Khách hàng (Chủ đơn):</h6>
                <p class="mb-1"><strong>Họ tên:</strong> {{ $complaint->order->user->ho_ten ?? 'N/A' }}</p>
                <p class="mb-1"><strong>SĐT:</strong> {{ $complaint->order->user->sdt ?? 'N/A' }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection