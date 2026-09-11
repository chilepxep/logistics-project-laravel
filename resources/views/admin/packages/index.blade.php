@extends('layouts.admin')
@section('title', 'Quản lý Kiện Hàng')
@section('page_title', 'Danh sách Kiện Hàng (Packages)')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('admin.packages.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control"
                    placeholder="Quét/Nhập Mã vận đơn hoặc Mã kiện..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="tinh_trang" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="cho_xu_ly" {{ request('tinh_trang') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                    </option>
                    <option value="da_nhap_kho" {{ request('tinh_trang') == 'da_nhap_kho' ? 'selected' : '' }}>Đã nhập
                        kho</option>
                    <option value="dang_van_chuyen" {{ request('tinh_trang') == 'dang_van_chuyen' ? 'selected' : '' }}>
                        Đang luân chuyển</option>
                    <option value="hoan_thanh" {{ request('tinh_trang') == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Lọc</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle font-14">
                <thead class="table-light">
                    <tr>
                        <th>Mã Kiện Nội Bộ</th>
                        <th>Mã Vận Đơn (TQ)</th>
                        <th>Thông số</th>
                        <th>Thuộc Đơn</th>
                        <th>Vị trí / Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $pkg)
                    <tr>
                        <td class="fw-bold text-primary">{{ $pkg->ma_don_kien_hang }}</td>
                        <td class="fw-bold">{{ $pkg->ma_van_don }}</td>
                        <td>
                            KG: <strong class="text-danger">{{ $pkg->tong_kg ?? '0' }}</strong> <br>
                            M3: <strong>{{ $pkg->tong_m3 ?? '0' }}</strong>
                        </td>
                        <td>
                            @if($pkg->order_id)
                            <span class="badge bg-primary">Mua hộ:
                                {{ $pkg->order->ma_don_hang ?? $pkg->order_id }}</span>
                            @elseif($pkg->consignment_order_id)
                            <span class="badge bg-secondary">Ký gửi:
                                {{ $pkg->consignmentOrder->ma_don_ky_gui ?? $pkg->consignment_order_id }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="mb-1 fw-bold text-success"><i class="bi bi-geo-alt-fill"></i>
                                {{ $pkg->warehouse->ten_kho ?? 'Chưa rõ' }}</div>
                            <span
                                class="badge bg-info text-dark">{{ $pkg->trang_thai_hien_thi ?? $pkg->tinh_trang }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.packages.edit', $pkg->id) }}"
                                class="btn btn-sm btn-warning fw-bold"><i class="bi bi-pencil-square"></i> Cập nhật</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Không tìm thấy kiện hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $packages->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection