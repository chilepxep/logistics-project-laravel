@extends('layouts.admin')
@section('title', 'Hồ sơ Khách Hàng')
@section('page_title', 'Hồ sơ: ' . $customer->ho_ten)

@section('content')
<div class="row g-4">
    <!-- CỘT TRÁI: THÔNG TIN CÁ NHÂN -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center border-bottom">
                <div class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                    style="width: 80px; height: 80px; font-size: 32px;">
                    <i class="bi bi-person"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $customer->ho_ten }}</h5>
                <p class="text-muted mb-2">{{ $customer->ma_tai_khoan }}</p>
                <h4 class="text-danger fw-bold">{{ number_format($customer->so_du) }} <small
                        class="text-muted fs-6">VNĐ</small></h4>

                <!-- Hiển thị badge trạng thái -->
                @if($customer->is_locked)
                <span class="badge bg-danger mb-3 px-3 py-2"><i class="bi bi-lock-fill"></i> TÀI KHOẢN ĐANG BỊ
                    KHOÁ</span>
                @else
                <span class="badge bg-success mb-3 px-3 py-2"><i class="bi bi-check-circle"></i> ĐANG HOẠT ĐỘNG</span>
                @endif

                <div class="d-flex gap-2 mt-2">
                    <!-- Nút Sửa -->
                    <a href="{{ route('admin.customers.edit', $customer->id) }}"
                        class="btn btn-sm btn-warning flex-grow-1 fw-bold">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>

                    <!-- Nút Khoá / Mở Khoá -->
                    <form action="{{ route('admin.customers.lock', $customer->id) }}" method="POST" class="flex-grow-1"
                        onsubmit="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái tài khoản này?');">
                        @csrf
                        @if($customer->is_locked)
                        <button type="submit" class="btn btn-sm btn-success w-100 fw-bold">
                            <i class="bi bi-unlock"></i> Mở khoá
                        </button>
                        @else
                        <button type="submit" class="btn btn-sm btn-danger w-100 fw-bold">
                            <i class="bi bi-lock"></i> Khoá TK
                        </button>
                        @endif
                    </form>
                </div>

            </div>
            <div class="card-body">
                <ul class="list-unstyled font-14 m-0">
                    <li class="mb-2"><i class="bi bi-envelope text-muted me-2"></i> {{ $customer->email }}</li>
                    <li class="mb-2"><i class="bi bi-telephone text-muted me-2"></i>
                        {{ $customer->sdt ?? 'Chưa cập nhật' }}</li>
                    <li class="mb-2"><i class="bi bi-calendar text-muted me-2"></i> Ngày sinh:
                        {{ $customer->ngay_sinh ?? '--' }}</li>
                    <li class="mb-2"><i class="bi bi-gender-ambiguous text-muted me-2"></i> Giới tính:
                        {{ $customer->gioi_tinh ?? '--' }}</li>
                    <li class="mb-2"><i class="bi bi-geo-alt text-muted me-2"></i> Đ/C:
                        {{ $customer->dia_chi ?? '--' }}, {{ $customer->tinh_thanh ?? '' }}</li>
                    <li><i class="bi bi-truck text-muted me-2"></i> Vận chuyển MĐ: <span
                            class="badge bg-secondary">{{ $customer->loai_van_chuyen_mac_dinh ?? 'N/A' }}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CỘT PHẢI: LỊCH SỬ HOẠT ĐỘNG (DÙNG TABS) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                <ul class="nav nav-tabs font-14" id="customerTabs">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#tab-orders">Đơn
                            mua hộ ({{ $customer->orders->count() }})</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-consignments">Đơn ký
                            gửi ({{ $customer->consignmentOrders->count() }})</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-transactions">Giao
                            dịch ({{ $customer->transactions->count() }})</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-withdrawals">Rút tiền
                            ({{ $customer->withdrawals->count() }})</button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">

                    <!-- TAB ĐƠN MUA HỘ -->
                    <div class="tab-pane fade show active" id="tab-orders">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle font-14">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Tốc độ</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->orders as $ord)
                                    <tr>
                                        <td class="fw-bold">{{ $ord->ma_don_hang }}</td>
                                        <td>{{ strtoupper($ord->yeu_cau_toc_do) }}</td>
                                        <td class="text-danger">{{ number_format($ord->tong_tien) }}đ</td>
                                        <td><span class="badge bg-secondary">{{ $ord->trang_thai }}</span></td>
                                        <td><a href="{{ route('admin.orders.show', $ord->id) }}"
                                                class="btn btn-sm btn-light">Xem</a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-muted text-center py-3">Chưa có đơn mua hộ</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB ĐƠN KÝ GỬI -->
                    <div class="tab-pane fade" id="tab-consignments">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle font-14">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Số kiện</th>
                                        <th>Ngày yêu cầu</th>
                                        <th>Trạng thái</th>
                                        <th>Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->consignmentOrders as $cons)
                                    <tr>
                                        <td class="fw-bold">{{ $cons->ma_don_ky_gui }}</td>
                                        <td>{{ $cons->so_kien }}</td>
                                        <td>{{ $cons->ngay_tao_yeu_cau }}</td>
                                        <td><span class="badge bg-secondary">{{ $cons->trang_thai }}</span></td>
                                        <td><a href="{{ route('admin.consignment_orders.show', $cons->id) }}"
                                                class="btn btn-sm btn-light">Xem</a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-muted text-center py-3">Chưa có đơn ký gửi</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB GIAO DỊCH -->
                    <div class="tab-pane fade" id="tab-transactions">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle font-14">
                                <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Loại</th>
                                        <th>Giá trị</th>
                                        <th>Số dư hiện tại</th>
                                        <th>Thông tin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->transactions as $trx)
                                    <tr>
                                        <td>{{ $trx->thoi_gian }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $trx->loai_giao_dich == 'nap_tien' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $trx->loai_giao_dich }}
                                            </span>
                                        </td>
                                        <td
                                            class="fw-bold {{ $trx->loai_giao_dich == 'nap_tien' ? 'text-success' : 'text-danger' }}">
                                            {{ $trx->loai_giao_dich == 'nap_tien' ? '+' : '-' }}{{ number_format($trx->gia_tri_giao_dich) }}đ
                                        </td>
                                        <td>{{ number_format($trx->so_du_hien_tai) }}đ</td>
                                        <td>{{ $trx->thong_tin }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-muted text-center py-3">Chưa có giao dịch</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB RÚT TIỀN -->
                    <div class="tab-pane fade" id="tab-withdrawals">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle font-14">
                                <thead>
                                    <tr>
                                        <th>Ngày YC</th>
                                        <th>Số tiền</th>
                                        <th>Ngân hàng</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->withdrawals as $wd)
                                    <tr>
                                        <td>{{ $wd->ngay_yeu_cau }}</td>
                                        <td class="text-danger fw-bold">{{ number_format($wd->so_tien) }}đ</td>
                                        <td>{{ $wd->ngan_hang }}<br><small
                                                class="text-muted">{{ $wd->thong_tin_chuyen_khoan }}</small></td>
                                        <td><span class="badge bg-secondary">{{ $wd->tinh_trang }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted text-center py-3">Chưa có yêu cầu rút tiền
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection