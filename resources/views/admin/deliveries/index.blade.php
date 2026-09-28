@extends('layouts.admin')
@section('title', 'Quản lý Giao Hàng')
@section('page_title', 'Danh sách Giao Hàng (Delivery)')

@section('content')


<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-success"><i class="bi bi-truck"></i> Điều phối Giao hàng nội địa</h4>
    </div>

    <!-- KHU VỰC LỌC DỮ LIỆU -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.deliveries.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Trạng thái điều phối</label>
                    <select name="trang_thai_giao" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Tất cả kiện hàng tại kho đích --</option>
                        <option value="cho_giao" {{ request('trang_thai_giao') == 'cho_giao' ? 'selected' : '' }}>Chưa
                            tạo phiếu (Chờ điều phối)</option>
                        <option value="dang_van_chuyen"
                            {{ request('trang_thai_giao') == 'dang_van_chuyen' ? 'selected' : '' }}>Đang giao hàng
                        </option>
                        <option value="thanh_cong" {{ request('trang_thai_giao') == 'thanh_cong' ? 'selected' : '' }}>Đã
                            giao thành công</option>
                        <option value="that_bai" {{ request('trang_thai_giao') == 'that_bai' ? 'selected' : '' }}>Giao
                            thất bại / Hoàn hàng</option>
                    </select>
                </div>

                @if(auth()->user()->vai_tro === 'nhan_vien')
                <div class="col-md-4 mt-4 pt-2">
                    <span class="badge bg-info text-dark p-2 border border-info rounded-pill">
                        <i class="bi bi-geo-alt-fill"></i> Đang hiển thị hàng tại kho của bạn
                    </span>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH KIỆN HÀNG CHỜ GIAO -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã kiện hàng</th>
                            <th>Kho hiện tại</th>
                            <th>Thông tin khách nhận</th>
                            <th>Trạng thái Giao</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packagesReadyForDelivery as $package)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">{{ $package->ma_don_kien_hang }}</span><br>
                                <small class="text-muted">Đơn:
                                    {{ $package->order->ma_don_hang ?? ($package->consignmentOrder->ma_don_hang ?? 'N/A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $package->warehouse->ten_kho ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($package->delivery)
                                <!-- Nếu đã có phiếu giao hàng -->
                                <small class="d-block mb-1">
                                    <i class="bi bi-box-seam"></i> Hãng:
                                    <strong>{{ strtoupper($package->delivery->phuong_thuc_van_chuyen) }}</strong>
                                </small>
                                <small class="d-block text-truncate" style="max-width: 200px;">
                                    ĐC: {{ $package->delivery->thong_tin_giao_hang }}
                                </small>
                                @else
                                <span class="text-muted fst-italic">Chưa có thông tin</span>
                                @endif
                            </td>
                            <td>
                                @if(!$package->delivery)
                                <span class="badge bg-warning text-dark">Chờ điều phối</span>
                                @elseif($package->delivery->trang_thai === 'thanh_cong')
                                <span class="badge bg-success">Giao thành công</span>
                                @elseif($package->delivery->trang_thai === 'that_bai')
                                <span class="badge bg-danger">Giao thất bại</span>
                                @else
                                <span class="badge bg-info text-dark">Đang giao hàng</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!$package->delivery)
                                <!-- Nút Tạo Phiếu Giao -->
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalCreateDelivery{{ $package->id }}">
                                    <i class="bi bi-plus-circle"></i> Tạo phiếu
                                </button>
                                @else
                                <!-- Nút Cập Nhật Phiếu Giao -->
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalUpdateDelivery{{ $package->id }}">
                                    <i class="bi bi-pencil-square"></i> Cập nhật
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- ============================================== -->
                        <!-- MODAL TẠO PHIẾU GIAO HÀNG CHƯA CÓ -->
                        <!-- ============================================== -->
                        @if(!$package->delivery)
                        <div class="modal fade" id="modalCreateDelivery{{ $package->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">

                                <!-- TÁCH RIÊNG THẺ DIV VÀ THÊM BG-WHITE ĐỂ CHỐNG TRONG SUỐT -->
                                <div class="modal-content shadow bg-white">
                                    <form action="{{ route('admin.deliveries.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title"><i class="bi bi-truck"></i> Tạo phiếu giao hàng -
                                                {{ $package->ma_don_kien_hang }}</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body bg-white">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Hãng vận chuyển <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="phuong_thuc_van_chuyen"
                                                        class="form-control border-success"
                                                        placeholder="VD: GHTK, Viettel Post, Grab..." required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Mã vận đơn nội địa (Tra
                                                        cứu)</label>
                                                    <input type="text" name="ma_van_don" class="form-control"
                                                        placeholder="Nhập mã bill nếu có">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Mã vùng / Tuyến</label>
                                                    <input type="text" name="ma_vung_noi_dia" class="form-control"
                                                        placeholder="VD: SG-01">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Thanh toán cước</label>
                                                    <select name="phuong_thuc_thanh_toan" class="form-select">
                                                        <option value="nguoi_nhan_tra">Khách trả cước (FOB)</option>
                                                        <option value="da_thanh_toan">Công ty trả cước</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold">Thông tin người nhận (SĐT, Địa chỉ chi
                                                    tiết) <span class="text-danger">*</span></label>
                                                <textarea name="thong_tin_giao_hang" class="form-control" rows="3"
                                                    required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light border-top">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Tạo
                                                phiếu giao hàng</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        @else

                        <!-- ============================================== -->
                        <!-- MODAL CẬP NHẬT PHIẾU GIAO HÀNG ĐÃ CÓ -->
                        <!-- ============================================== -->
                        <div class="modal fade" id="modalUpdateDelivery{{ $package->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content shadow bg-white">
                                    <!-- Đổi màu header nếu đã giao thành công -->
                                    <div
                                        class="modal-header {{ $package->delivery->trang_thai == 'thanh_cong' ? 'bg-success' : 'bg-primary' }} text-white">
                                        <h5 class="modal-title">Cập nhật Giao hàng - {{ $package->ma_don_kien_hang }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body bg-white">
                                        <!-- KHU VỰC HIỂN THỊ NGÀY GIAO THÀNH CÔNG -->
                                        @if($package->delivery->trang_thai == 'thanh_cong')
                                        <div class="alert alert-success d-flex align-items-center mb-4">
                                            <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                                            <div>
                                                <h6 class="mb-1 fw-bold">Đã giao hàng thành công!</h6>
                                                <span class="small">
                                                    Thời gian xác nhận:
                                                    <strong>{{ $package->delivery->ngay_giao_xong ? \Carbon\Carbon::parse($package->delivery->ngay_giao_xong)->format('d/m/Y H:i') : 'Đang cập nhật...' }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Form Cập nhật trạng thái -->
                                        <form action="{{ route('admin.deliveries.update', $package->delivery->id) }}"
                                            method="POST" id="formUpdate{{ $package->id }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Mã vận đơn hãng</label>
                                                <input type="text" name="ma_van_don" class="form-control"
                                                    value="{{ $package->delivery->ma_van_don }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Trạng thái Giao hàng</label>
                                                <select name="trang_thai"
                                                    class="form-select fw-semibold {{ $package->delivery->trang_thai == 'thanh_cong' ? 'border-success text-success bg-light' : 'border-primary' }}">
                                                    <option value="dang_van_chuyen"
                                                        {{ $package->delivery->trang_thai == 'dang_van_chuyen' ? 'selected' : '' }}>
                                                        Đang đi giao</option>
                                                    <option value="thanh_cong"
                                                        {{ $package->delivery->trang_thai == 'thanh_cong' ? 'selected' : '' }}>
                                                        Giao thành công</option>
                                                    <option value="that_bai"
                                                        {{ $package->delivery->trang_thai == 'that_bai' ? 'selected' : '' }}>
                                                        Thất bại / Hoàn hàng</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Ghi chú sự cố (Nếu có)</label>
                                                <textarea name="ghi_chu" class="form-control" rows="2"
                                                    placeholder="Ghi lại lý do nếu giao thất bại...">{{ $package->delivery->ghi_chu }}</textarea>
                                            </div>
                                        </form>

                                        <hr class="text-muted border-1">

                                        <!-- Form Xóa / Hủy điều phối (Nút màu đỏ) - ĐÃ CẬP NHẬT GIAO DIỆN -->
                                        <div class="bg-light p-3 border rounded shadow-sm">
                                            <form
                                                action="{{ route('admin.deliveries.destroy', $package->delivery->id) }}"
                                                method="POST" class="d-flex justify-content-between align-items-center">
                                                @csrf
                                                @method('DELETE')
                                                <span class="text-danger small fw-bold"><i
                                                        class="bi bi-exclamation-triangle-fill me-1"></i> Hủy phiếu giao
                                                    hàng này?</span>
                                                <button type="submit" class="btn btn-danger btn-sm text-white"
                                                    onclick="return confirm('Bạn có chắc muốn hủy phiếu giao hàng này và thu hồi kiện hàng về kho không?')">
                                                    <i class="bi bi-trash"></i> Thu hồi hàng
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal-footer bg-light border-top">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" form="formUpdate{{ $package->id }}"
                                            class="btn {{ $package->delivery->trang_thai == 'thanh_cong' ? 'btn-success' : 'btn-primary' }}">
                                            <i class="bi bi-check-circle"></i> Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Không có kiện hàng nào đang ở kho đích của bạn.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        <div class="card-footer bg-white pt-3">
            {{ $packagesReadyForDelivery->links() }}
        </div>
    </div>
</div>
@endsection