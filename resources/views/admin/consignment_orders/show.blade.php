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

            <div class="col-md-3">
                <span class="text-muted d-block mb-1">Vị trí hiện tại:</span>

                @if($order->kho_hien_tai_id && $order->khoHienTai)
                <!-- NẾU ĐANG Ở TRONG KHO: Hiển thị màu xanh lá kèm icon định vị -->
                <span class="badge bg-success text-white px-2 py-1">
                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $order->khoHienTai->ten_kho }}
                </span>
                @else
                <!-- NẾU CHƯA NHẬP KHO: Hiển thị màu xám -->
                <span class="badge bg-secondary text-white px-2 py-1">
                    <i class="bi bi-truck me-1"></i> Chưa nhập kho
                </span>
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

            <!-- 2. CHI TIẾT CÁC KIỆN HÀNG -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-uppercase"><i class="bi bi-box-seam"></i> Danh sách kiện hàng</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="table-light font-14">
                                <tr>
                                    <th>Mã vận đơn / Ảnh</th>
                                    <th>Tên SP & Thông tin</th>
                                    <th>Phân loại / SL</th>
                                    <th>Dịch vụ thêm</th>
                                </tr>
                            </thead>
                            <tbody id="packagesContainer">
                                @php
                                $extraReqs = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id',
                                $order->id)->pluck('loai_yeu_cau')->toArray();
                                $hasDongGo = in_array('dong_go', $extraReqs);
                                $hasKiemHang = in_array('kiem_hang', $extraReqs);
                                @endphp

                                @if($order->items && $order->items->count() > 0)
                                @foreach($order->items as $index => $item)
                                <tr class="package-row">
                                    <!-- Mã vận đơn / Ảnh -->
                                    <td>
                                        <div class="fw-bold text-primary mb-2">{{ $item->ma_van_don ?: 'Chưa có mã' }}
                                        </div>
                                        @if($item->hinh_anh_url)
                                        <img src="{{ asset($item->hinh_anh_url) }}" class="rounded shadow-sm"
                                            style="width:50px;height:50px;object-fit:cover; border: 1px solid #ddd;">
                                        @else
                                        <span class="badge bg-secondary font-12">Không có ảnh</span>
                                        @endif
                                    </td>

                                    <!-- Tên SP & Thông tin -->
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $item->ten_san_pham }}</div>
                                        <div class="font-13 text-muted mb-1">
                                            <i class="bi bi-truck"></i> Hãng VC:
                                            <strong>{{ $item->hang_van_chuyen ?: 'N/A' }}</strong>
                                        </div>
                                        @if($item->link_san_pham)
                                        <a href="{{ $item->link_san_pham }}" target="_blank"
                                            class="font-13 text-info text-decoration-none">
                                            <i class="bi bi-link-45deg"></i> Link sản phẩm
                                        </a>
                                        @endif
                                    </td>

                                    <!-- Phân loại / Số lượng -->
                                    <td>
                                        <div class="font-13 mb-1">Danh mục: <span
                                                class="fw-semibold">{{ $item->loai_danh_muc ?: 'Không phân loại' }}</span>
                                        </div>
                                        <div class="font-13 mb-1">
                                            Số lượng: <span class="badge bg-info text-dark">{{ $item->so_luong }}</span>
                                            |
                                            Số kiện: <span class="badge bg-secondary">{{ $item->so_kien_hang }}</span>
                                        </div>
                                        <div class="text-danger fw-bold font-14 mt-2">
                                            <i class="bi bi-tag-fill"></i>
                                            {{ number_format($item->gia_tri_hang_hoa, 0, ',', '.') }} VNĐ
                                        </div>
                                    </td>

                                    <!-- Dịch vụ thêm & Ghi chú -->
                                    <td>
                                        <div class="form-check font-14 mb-1">
                                            <input class="form-check-input" type="checkbox" disabled
                                                {{ $hasKiemHang ? 'checked' : '' }}>
                                            <label
                                                class="form-check-label {{ $hasKiemHang ? 'fw-bold text-dark' : 'text-muted' }}">Kiểm
                                                hàng</label>
                                        </div>
                                        <div class="form-check font-14 mb-2">
                                            <input class="form-check-input" type="checkbox" disabled
                                                {{ $hasDongGo ? 'checked' : '' }}>
                                            <label
                                                class="form-check-label {{ $hasDongGo ? 'fw-bold text-dark' : 'text-muted' }}">Đóng
                                                gỗ</label>
                                        </div>

                                        @if($item->ghi_chu)
                                        <div class="font-13 text-muted fst-italic p-2 bg-light rounded border">
                                            <strong>Ghi chú:</strong> {{ $item->ghi_chu }}
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i> Đơn hàng này chưa có kiện hàng chi
                                        tiết nào.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection