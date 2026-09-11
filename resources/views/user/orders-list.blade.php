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

<div class="container-fluid mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
            <i class="bi bi-box-seam me-2"></i> Danh sách đơn mua hộ
        </h3>
        <a href="{{ route('order.create') }}" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tạo đơn mới
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-2 p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle font-14 mb-0">
                <thead class="text-center text-white" style="background-color: #0088cc;">
                    <tr>
                        <th style="width: 5%;">STT</th>
                        <th style="width: 15%;">Mã Đơn Hàng</th>
                        <th style="width: 12%;">Ngày Tạo</th>
                        <th style="width: 15%;">Kho Nhận (VN)</th>
                        <th style="width: 10%;">Tốc Độ</th>
                        <th style="width: 15%;">Tổng Tiền (VNĐ)</th>
                        <th style="width: 13%;">Trạng Thái</th>
                        <th style="width: 15%;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buyOrders as $index => $order)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center fw-bold text-primary">{{ $order->ma_don_hang }}</td>
                        <td class="text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>

                        <!-- Hiển thị tên kho, giả sử bạn đã cài đặt relation 'khoNhan' trong model Order -->
                        <td class="text-center">{{ $order->khoNhan->ten_kho ?? 'N/A' }}</td>

                        <td class="text-center">
                            @if($order->yeu_cau_toc_do == 'nhanh')
                            <span class="badge bg-danger">Nhanh</span>
                            @else
                            <span class="badge bg-secondary">Thường</span>
                            @endif
                        </td>

                        <td class="text-end fw-bold text-danger">
                            {{ number_format($order->tong_tien, 0, ',', '.') }} đ
                        </td>

                        <td class="text-center">
                            @if($order->trang_thai == 'cho_xu_ly')
                            <span class="badge bg-warning text-dark px-2 py-1">Chờ xử lý</span>
                            @elseif($order->trang_thai == 'dang_xu_ly')
                            <span class="badge bg-primary px-2 py-1">Đang xử lý</span>
                            @elseif($order->trang_thai == 'can_lien_he_lai')
                            <span class="badge bg-info text-dark px-2 py-1">Cần liên hệ lại</span>
                            @elseif($order->trang_thai == 'hoan_thanh')
                            <span class="badge bg-success px-2 py-1">Hoàn thành</span>
                            @elseif($order->trang_thai == 'da_huy')
                            <span class="badge bg-secondary px-2 py-1">Đã hủy</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Nút Xem chi tiết -->
                                <a href="{{ route('order.show', $order->id) }}" class=" btn btn-sm btn-info text-white"
                                    title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>


                                @if($order->trang_thai == 'cho_xu_ly')
                                <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-warning text-dark"
                                    title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endif

                                <!-- Nút Xóa -->
                                @if($order->trang_thai == 'cho_xu_ly')
                                <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn mua hộ mã #{{ $order->ma_don_hang }} này không? Hành động này không thể hoàn tác!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            Bạn chưa có đơn mua hộ nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection