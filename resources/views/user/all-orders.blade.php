@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
            <i class="bi bi-list-check me-2"></i> Tất cả đơn hàng
        </h3>
    </div>

    <!-- KHỐI BỘ LỌC -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center g-3">

                <!-- Phần 1: Bộ lọc (Bên trái) -->
                <div class="col-md-12 col-lg-6">
                    <form action="{{ route('order.all') }}" method="GET" class="row g-2 align-items-end">
                        <div class="col-sm-6 col-md-5">
                            <label class="form-label font-13 fw-semibold text-muted mb-1">Loại đơn hàng</label>
                            <select name="loai" class="form-select form-select-sm shadow-none">
                                <option value="">-- Tất cả loại đơn --</option>
                                <option value="mua_ho" {{ request('loai') == 'mua_ho' ? 'selected' : '' }}>Đơn mua hộ
                                </option>
                                <option value="ky_gui" {{ request('loai') == 'ky_gui' ? 'selected' : '' }}>Đơn ký gửi
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-7 d-flex gap-2">
                            <button type="submit" class="btn btn-sm text-white fw-semibold shadow-sm px-3"
                                style="background-color: #0b3a68;">
                                <i class="bi bi-funnel"></i> Lọc
                            </button>
                            <a href="{{ route('order.all') }}" class="btn btn-sm btn-outline-secondary shadow-sm px-3">
                                <i class="bi bi-x-circle me-1"></i> Bỏ lọc
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Phần 2: Khối thông báo giao hàng (Bên phải) -->
                <div class="col-md-12 col-lg-6">
                    @if($deliveryCount > 0)
                    <!-- Khi CÓ đơn hàng đang giao -->
                    <div class="alert alert-success d-flex align-items-center justify-content-between mb-0 py-2 px-3 border-success shadow-sm h-100"
                        role="alert">
                        <div class="font-14 text-dark">
                            <i class="bi bi-truck text-success me-1 fs-5 align-middle"></i>
                            Bạn có <strong>{{ $deliveryCount }}</strong> kiện hàng đang được giao đến!
                        </div>
                        <a href="{{ route('delivery.index') }}"
                            class="btn btn-sm btn-success fw-bold text-nowrap shadow-sm ms-2 rounded-pill px-3">
                            Nhấn vào đây để xem <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @else
                    <!-- Khi KHÔNG CÓ đơn hàng nào -->
                    <div class="alert d-flex align-items-center justify-content-center mb-0 py-3 px-3
                    h-100 font-14 text-secondary
                    bg-light border border-secondary-subtle rounded-3" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        Hiện tại 0 có đơn nào đang được giao đến bạn.
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>



    <!-- Bảng Thống Kê Kiện Hàng theo Tracking -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body bg-light">
            <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-box-seam"></i> Tổng quan trạng thái lộ trình</h6>

            <div class="row g-3">
                <!-- Chờ xử lý -->
                <div class="col-6 col-md-4 col-lg">
                    <div class="d-flex align-items-center h-100">
                        <span class="badge bg-success fs-6 me-2 flex-shrink-0" style="width: 40px;">
                            {{ $summary['cho_xu_ly'] }}
                        </span>
                        <span class="font-14 text-dark fw-semibold">
                            Chờ xử lý
                        </span>
                    </div>
                </div>

                <!-- Đã nhập kho -->
                <div class="col-6 col-md-4 col-lg">
                    <div class="d-flex align-items-center h-100">
                        <span class="badge bg-success fs-6 me-2 flex-shrink-0" style="width: 40px;">
                            {{ $summary['da_nhap_kho'] }}
                        </span>
                        <span class="font-14 text-dark fw-semibold">
                            Đã nhập kho
                        </span>
                    </div>
                </div>

                <!-- Đang luân chuyển -->
                <div class="col-6 col-md-4 col-lg">
                    <div class="d-flex align-items-center h-100">
                        <span class="badge bg-success fs-6 me-2 flex-shrink-0" style="width: 40px;">
                            {{ $summary['dang_luan_chuyen'] }}
                        </span>
                        <span class="font-14 text-dark fw-semibold">
                            Đang luân chuyển (Quốc tế)
                        </span>
                    </div>
                </div>

                <!-- Đến kho Việt Nam -->
                <div class="col-6 col-md-4 col-lg">
                    <div class="d-flex align-items-center h-100">
                        <span class="badge bg-success fs-6 me-2 flex-shrink-0" style="width: 40px;">
                            {{ $summary['dang_giao_hang'] }}
                        </span>
                        <span class="font-14 text-dark fw-semibold">
                            Đến kho Việt Nam
                        </span>
                    </div>
                </div>

                <!-- Khách đã nhận hàng -->
                <div class="col-6 col-md-4 col-lg">
                    <div class="d-flex align-items-center h-100">
                        <span class="badge bg-success fs-6 me-2 flex-shrink-0" style="width: 40px;">
                            {{ $summary['khach_da_nhan'] }}
                        </span>
                        <span class="font-14 text-dark fw-semibold">
                            Khách đã nhận hàng
                        </span>
                    </div>
                </div>


                <!-- <div class="col-6 col-md-4 col-lg-2 d-flex align-items-center">
                    <span class="badge bg-danger fs-6 me-2"
                        style="width: 40px;">{{ $summary['yeu_cau_tra_hang'] }}</span>
                    <span class="font-14 text-dark fw-semibold">Yêu cầu trả hàng</span>
                </div> -->
            </div>
        </div>
    </div>
    <!-- BẢNG DANH SÁCH GỘP -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center text-white" style="background-color: #0b3a68;">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 20%;">Mã Kiện / Đơn Gốc</th>
                            <th style="width: 15%;">Loại Đơn</th>
                            <th style="width: 15%;">Ngày Cập Nhật</th>
                            <th style="width: 25%;">Trạng Thái Lộ Trình</th>
                            <th style="width: 20%;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allOrders as $index => $item)
                        <tr>
                            <td class="text-center">
                                {{ ($allOrders->currentPage() - 1) * $allOrders->perPage() + $index + 1 }}
                            </td>

                            <!-- Mã Kiện Hàng và Đơn Gốc -->
                            <td class="text-center">
                                <span
                                    class="fw-bold text-primary">{{ $item->ma_don_kien_hang ?? $item->ma_van_don }}</span>
                                <div class="small text-muted mt-1">
                                    Thuộc:
                                    @if($item->order_id)
                                    {{ $item->order->ma_don_hang ?? 'DH-'.$item->order_id }}
                                    @else
                                    {{ $item->consignmentOrder->ma_don_ky_gui ?? 'KG-'.$item->consignment_order_id }}
                                    @endif
                                </div>
                            </td>

                            <td class="text-center">
                                @if($item->order_id)
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-cart-check"></i> Mua hộ</span>
                                @else
                                <span class="badge bg-success px-2 py-1"><i class="bi bi-truck"></i> Ký gửi</span>
                                @endif
                            </td>

                            <td class="text-center text-muted">
                                {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}
                            </td>

                            <!-- Màu sắc và Trạng Thái tương ứng -->
                            <td class="text-center">
                                @php
                                $badges = [
                                'cho_xu_ly' => ['text' => 'Chờ xử lý', 'class' => 'bg-secondary'],
                                'da_nhap_kho' => ['text' => 'Đã nhập kho', 'class' => 'bg-info text-dark'],
                                'dang_van_chuyen' => ['text' => 'Đang luân chuyển', 'class' => 'bg-primary'],
                                'dang_giao_hang' => ['text' => 'Đang giao hàng', 'class' => 'bg-warning text-dark'],
                                'hoan_thanh' => ['text' => 'Hoàn thành', 'class' => 'bg-success'],
                                'tra_hang' => ['text' => 'Trả hàng', 'class' => 'bg-danger'],
                                ];
                                $status = $badges[$item->tinh_trang] ?? ['text' => $item->tinh_trang, 'class' =>
                                'bg-dark'];
                                @endphp
                                <span class="badge {{ $status['class'] }} text-uppercase px-2 py-1 shadow-sm">
                                    {{ $status['text'] }}
                                </span>
                            </td>

                            <!-- Trỏ link đúng về Đơn Mua Hộ hoặc Ký Gửi tương ứng -->
                            <td class="text-center">
                                @if($item->order_id)
                                <a href="{{ route('order.show', $item->order_id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Xem chi tiết đơn">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                @else
                                <!-- Lưu ý đổi route chi tiết đơn ký gửi cho chuẩn với hệ thống của bạn -->
                                <a href="{{ route('consignment.show', $item->consignment_order_id ?? 1) }}"
                                    class="btn btn-sm btn-outline-success" title="Xem chi tiết đơn">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-2 text-primary"></i>
                                Hệ thống chưa ghi nhận kiện hàng nào của bạn.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang chuẩn Eloquent -->
        @if($allOrders->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3 border-0">
            {{ $allOrders->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection