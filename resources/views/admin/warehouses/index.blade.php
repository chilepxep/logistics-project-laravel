@extends('layouts.admin')
@section('title', 'Quản lý Kho')
@section('page_title', 'Danh sách Kho')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div class="d-flex align-items-center gap-2">

            <form action="{{ route('admin.warehouses.index') }}" method="GET" class="m-0">
                <select name="loai_kho" id="loai_kho" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả các kho --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->ma_quoc_gia }}"
                        {{ request('loai_kho') == $country->ma_quoc_gia ? 'selected' : '' }}>
                        {{ $country->ten_quoc_gia }} ({{ $country->ma_quoc_gia }})
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <a href="{{ route('admin.warehouses.create') }}" class="btn btn-sm btn-success">
        <i class="bi bi-plus-circle me-1"></i> Thêm kho mới
    </a>

</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="  table table-hover align-middle m-0 warehouse-table">
                <thead class="table-light text-center">
                    <tr>
                        <th class="ps-4 col-code">Mã kho</th>
                        <th class="col-name">Tên kho</th>
                        <th class="col-type">Quốc gia</th>
                        <th class="col-address">Địa chỉ</th>
                        <th class="text-end pe-4 col-actions">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($warehouses as $kho)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">
                            {{ $kho->ma_kho }}
                        </td>

                        <td class="fw-bold warehouse-name" title="{{ $kho->ten_kho }}">
                            {{ $kho->ten_kho }}
                        </td>

                        <td>
                            <span class="badge bg-success">
                                {{ $kho->loai_kho }}
                            </span>
                        </td>

                        <td>
                            <div class="address-cell" title="{{ $kho->dia_chi }}">
                                {{ $kho->dia_chi }}
                            </div>
                        </td>

                        <td class="text-end pe-4 text-nowrap">
                            <a href="{{ route('admin.warehouses.edit', $kho->id) }}" class="btn btn-sm btn-warning"
                                title="Sửa kho">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.warehouses.destroy', $kho->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa kho này?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa kho">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Chưa có dữ liệu kho hàng.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="m-3">{{ $warehouses->links() }}</div>

@endsection