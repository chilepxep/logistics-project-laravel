@extends('layouts.admin')
@section('title', 'Chi tiết Đơn Mua Hộ')
@section('page_title', 'Chi tiết mã đơn: ' . $order->ma_don_hang)

@section('content')
<div class="row g-4">
    <!-- Khối 1: Thông tin chung -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-uppercase" style="color: #0b3a68;"><i class="bi bi-info-circle"></i> Thông
                    tin chung</h6>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning fw-semibold">
                    <i class="bi bi-pencil-square"></i> Sửa
                </a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush font-14">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Khách hàng:</span>
                        <strong class="text-primary">{{ $order->user->ho_ten ?? 'N/A' }} (ID:
                            {{ $order->user_id }})</strong>
                    </li>

                    <!-- LỘ TRÌNH VẬN CHUYỂN -->
                    <li class="list-group-item flex-column px-0">
                        <span class="text-muted d-block mb-2">Lộ trình vận chuyển:</span>
                        <div class="d-flex flex-column gap-1 bg-light p-2 rounded border">
                            <div>
                                <span class="badge bg-warning text-dark me-1">TỪ</span>
                                <strong class="text-danger">{{ $order->supplier->ten_ncc ?? 'Kho Quốc Tế' }}
                                    ({{ $order->country->ten_quoc_gia ?? '' }})</strong>
                            </div>
                            <div class="ms-3"><i class="bi bi-arrow-down-short text-muted fs-5 lh-1"></i></div>
                            <div>
                                <span class="badge bg-success me-1">ĐẾN</span>
                                <strong class="text-success">{{ $order->khoNhan->ten_kho ?? 'Chưa chọn' }}</strong>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Tốc độ:</span>
                        <span class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-info text-dark' }}">
                            {{ strtoupper($order->yeu_cau_toc_do) }}
                        </span>
                    </li>

                    <!-- DỊCH VỤ GIA TĂNG -->
                    <li class="list-group-item px-0">
                        <span class="text-muted d-block mb-1">Dịch vụ yêu cầu:</span>
                        @if(isset($order->extraRequirements) && $order->extraRequirements->count() > 0)
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach($order->extraRequirements as $req)
                            @if($req->loai_yeu_cau == 'dong_go')
                            <span class="badge bg-secondary"><i class="bi bi-box-seam"></i> Đóng gỗ</span>
                            @elseif($req->loai_yeu_cau == 'kiem_hang')
                            <span class="badge bg-primary"><i class="bi bi-search"></i> Kiểm hàng</span>
                            @elseif($req->loai_yeu_cau == 'khai_thue_gtgt')
                            <span class="badge bg-dark"><i class="bi bi-receipt"></i> Khai thuế</span>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <span class="fst-italic text-muted font-13">Không có</span>
                        @endif
                    </li>

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Trạng thái:</span>
                        <span class="badge bg-secondary">{{ $order->trang_thai }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Tổng tiền:</span>
                        <strong class="text-danger fs-5">{{ number_format($order->tong_tien) }} đ</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Khối 2: Danh sách Sản phẩm -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-uppercase" style="color: #0b3a68;"><i class="bi bi-box2"></i> Danh sách sản
                    phẩm ({{ $order->items->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 font-14">
                        <thead class="table-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th style="min-width: 200px;">Tên sản phẩm & Link</th>
                                <th>Thuộc tính</th>
                                <th class="text-center">SL</th>
                                <!-- HIỂN THỊ TIỀN TỆ ĐỘNG -->
                                <th>Đơn giá ({{ $order->country->tien_te ?? '¥' }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->hinh_anh_url)
                                    <img src="{{ asset($item->hinh_anh_url) }}" alt="img" class="rounded border"
                                        style="width: 55px; height: 55px; object-fit: cover;">
                                    @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted"
                                        style="width: 55px; height: 55px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-truncate mb-1" style="max-width: 250px;"
                                        title="{{ $item->ten_san_pham }}">
                                        {{ $item->ten_san_pham }}
                                    </div>
                                    @if($item->link_san_pham)
                                    <a href="{{ $item->link_san_pham }}" target="_blank" class="text-decoration-none"
                                        style="font-size: 12px;">
                                        <i class="bi bi-link-45deg"></i> Link sản phẩm
                                    </a>
                                    @endif
                                    @if($item->ghi_chu_khac)
                                    <div class="text-muted font-12 mt-1 fst-italic">Ghi chú: {{ $item->ghi_chu_khac }}
                                    </div>
                                    @endif
                                </td>
                                <td>{{ $item->mau_sac_kich_thuoc ?? '--' }}</td>
                                <td class="fw-bold text-center">{{ $item->so_luong }}</td>
                                <!-- LẤY GIÁ TRỊ DON_GIA thay vì DON_GIA_TE -->
                                <td class="text-danger fw-bold">
                                    {{ number_format($item->don_gia, 2) }} {{ $order->country->tien_te ?? '¥' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection