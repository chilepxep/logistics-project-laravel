@extends('layouts.admin')
@section('title', 'Chi tiết Đơn Ký Gửi')
@section('page_title', 'Đơn ký gửi: ' . $order->ma_don_ky_gui)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-uppercase" style="color: #198754;">
            <i class="bi bi-file-earmark-text me-1"></i> Thông tin chi tiết Đơn Ký Gửi
        </h6>
        <div>
            <a href="{{ route('admin.consignment_orders.edit', $order->id) }}"
                class="btn btn-sm btn-warning fw-semibold">
                <i class="bi bi-pencil-square"></i> Sửa
            </a>
            <a href="{{ route('admin.consignment_orders.index') }}" class="btn btn-sm btn-secondary fw-semibold">
                Quay lại
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4 font-14">

            <!-- Khách hàng & Trạng thái -->
            <div class="col-md-6">
                <span class="text-muted d-block mb-1">Khách hàng:</span>
                <h6 class="fw-bold text-primary m-0">{{ $order->user->ho_ten ?? 'ID: '.$order->user_id }}</h6>
            </div>
            <div class="col-md-6">
                <span class="text-muted d-block mb-1">Trạng thái:</span>
                <span class="badge bg-secondary fs-6">{{ $order->trang_thai }}</span>
            </div>

            <!-- LỘ TRÌNH VẬN CHUYỂN (Chiếm trọn 1 hàng ngang) -->
            <div class="col-12">
                <span class="text-muted d-block mb-2">Lộ trình vận chuyển:</span>
                @if($order->chieu_van_chuyen == 've_vn')
                <div class="d-inline-flex align-items-center bg-light p-2 rounded border">
                    <span class="badge bg-warning text-dark me-2">TỪ</span>
                    <strong class="text-danger me-3">{{ $order->supplier->ten_ncc ?? 'Kho Quốc Tế' }}
                        ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                    <i class="bi bi-arrow-right text-muted fs-5 me-3"></i>
                    <span class="badge bg-success me-2">ĐẾN</span>
                    <strong class="text-success">{{ $order->khoVn->ten_kho ?? 'Kho Việt Nam' }}</strong>
                </div>
                @else
                <div class="d-inline-flex align-items-center bg-light p-2 rounded border">
                    <span class="badge bg-success me-2">TỪ</span>
                    <strong class="text-success me-3">{{ $order->khoVn->ten_kho ?? 'Kho Việt Nam' }}</strong>
                    <i class="bi bi-arrow-right text-muted fs-5 me-3"></i>
                    <span class="badge bg-warning text-dark me-2">ĐẾN</span>
                    <strong class="text-danger">{{ $order->supplier->ten_ncc ?? 'Kho Quốc Tế' }}
                        ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                </div>
                @endif
            </div>

            <!-- Tốc độ & Số kiện -->
            <div class="col-md-3">
                <span class="text-muted d-block mb-1">Tốc độ:</span>
                <span class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-info text-dark' }}">
                    {{ strtoupper($order->yeu_cau_toc_do) }}
                </span>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block mb-1">Số kiện hàng:</span>
                <span class="fw-bold fs-5">{{ $order->so_kien }}</span> kiện
            </div>
            <div class="col-md-6">
                <span class="text-muted d-block mb-1">Địa chỉ trả hàng:</span>
                <span class="fw-bold">{{ $order->dia_chi_tra_hang ?? 'Chưa cập nhật (Nhận tại kho)' }}</span>
            </div>

            <!-- Dịch vụ gia tăng -->
            <div class="col-12">
                <span class="text-muted d-block mb-1">Dịch vụ yêu cầu:</span>
                @if(isset($order->extraRequirements) && $order->extraRequirements->count() > 0)
                <div class="d-flex gap-2">
                    @foreach($order->extraRequirements as $req)
                    @if($req->loai_yeu_cau == 'dong_go')
                    <span class="badge bg-secondary"><i class="bi bi-box-seam"></i> Đóng gỗ</span>
                    @elseif($req->loai_yeu_cau == 'kiem_hang')
                    <span class="badge bg-primary"><i class="bi bi-search"></i> Kiểm hàng</span>
                    @endif
                    @endforeach
                </div>
                @else
                <span class="fst-italic text-muted font-13">Không có yêu cầu đặc biệt</span>
                @endif
            </div>

            <!-- Các mốc thời gian (Đã format chuẩn ngày tháng) -->
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày tạo yêu cầu:</span>
                <span
                    class="fw-bold">{{ $order->ngay_tao_yeu_cau ? date('d/m/Y', strtotime($order->ngay_tao_yeu_cau)) : '--' }}</span>
            </div>
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày vận chuyển:</span>
                <span
                    class="fw-bold">{{ $order->ngay_van_chuyen ? date('d/m/Y', strtotime($order->ngay_van_chuyen)) : 'Đang chờ...' }}</span>
            </div>
            <div class="col-md-4 pt-3 border-top mt-4">
                <span class="text-muted d-block mb-1">Ngày nhận hàng:</span>
                <span
                    class="fw-bold text-success">{{ $order->ngay_nhan_hang ? date('d/m/Y', strtotime($order->ngay_nhan_hang)) : 'Chưa nhận' }}</span>
            </div>

        </div>
    </div>
</div>
@endsection