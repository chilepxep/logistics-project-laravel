@extends('layouts.admin')
@section('title', 'Quản lý Khiếu Nại')
@section('page_title', 'Danh sách Khiếu Nại')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('admin.complaints.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="trang_thai" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="cho_xu_ly" {{ request('trang_thai') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                    </option>
                    <option value="dang_xu_ly" {{ request('trang_thai') == 'dang_xu_ly' ? 'selected' : '' }}>Đang xử lý
                    </option>
                    <option value="hoan_thanh" {{ request('trang_thai') == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                    </option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle font-14">
                <thead class="table-light">
                    <tr>
                        <th>ID / Ảnh</th>
                        <th>Loại Khiếu Nại</th>
                        <th>Tham chiếu</th>
                        <th>NV Xử lý</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $cp)
                    <tr>
                        <td>
                            @if($cp->hinh_anh_url)
                            <img src="{{ asset($cp->hinh_anh_url) }}" style="width: 40px; height:40px; object-fit:cover"
                                class="rounded">
                            @else
                            <strong>#{{ $cp->id }}</strong>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $cp->loai_khieu_nai }}</td>
                        <td>
                            @if($cp->order_id)
                            <span class="badge bg-primary">Đơn: {{ $cp->order->ma_don_hang ?? $cp->order_id }}</span>
                            @endif
                            @if($cp->package_id)
                            <span class="badge bg-info">Kiện: {{ $cp->package->ma_van_don ?? $cp->package_id }}</span>
                            @endif
                        </td>
                        <td>{{ $cp->nhanVienXuLy->ho_ten ?? 'Chưa phân công' }}</td>
                        <td>
                            @if($cp->trang_thai == 'cho_xu_ly') <span class="badge bg-danger">Chờ xử lý</span>
                            @elseif($cp->trang_thai == 'dang_xu_ly') <span class="badge bg-warning text-dark">Đang xử
                                lý</span>
                            @else <span class="badge bg-success">Hoàn thành</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.complaints.show', $cp->id) }}"
                                class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.complaints.edit', $cp->id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Không có khiếu nại nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $complaints->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection