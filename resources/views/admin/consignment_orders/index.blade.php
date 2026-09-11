@extends('layouts.admin')
@section('title', 'Quản lý Đơn ký gửi')
@section('page_title', 'Danh sách Đơn ký gửi')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.consignment_orders.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="trang_thai" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="cho_xu_ly" {{ request('trang_thai') == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                    </option>
                    <option value="da_xu_ly" {{ request('trang_thai') == 'da_xu_ly' ? 'selected' : '' }}>Đã xử lý
                    </option>
                    <option value="hoan_thanh" {{ request('trang_thai') == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                    </option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã Ký Gửi</th>
                        <th>Khách Hàng</th>
                        <th>Tốc Độ</th>
                        <th>Số Kiện</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold text-primary">{{ $order->ma_don_ky_gui }}</td>
                        <td>{{ $order->user->ho_ten ?? 'ID: '.$order->user_id }}</td>
                        <td>
                            <span class="badge {{ $order->yeu_cau_toc_do == 'nhanh' ? 'bg-danger' : 'bg-info' }}">
                                {{ strtoupper($order->yeu_cau_toc_do) }}
                            </span>
                        </td>
                        <td class="fw-bold">{{ $order->so_kien }}</td>
                        <td><span class="badge bg-secondary">{{ $order->trang_thai }}</span></td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.consignment_orders.show', $order->id) }}"
                                class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.consignment_orders.edit', $order->id) }}"
                                class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.consignment_orders.destroy', $order->id) }}" method="POST"
                                onsubmit="return confirm('Bạn chắc chắn muốn xoá đơn ký gửi này?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                        class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Không có dữ liệu!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection