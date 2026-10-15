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
        <table class="table table-hover align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Mã kho</th>
                    <th>Tên kho</th>
                    <th>Loại (Quốc gia)</th>
                    <th>Địa chỉ</th>
                    <th class="text-end pe-4">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $kho)
                <tr>
                    <td class="ps-4 fw-bold text-primary">{{ $kho->ma_kho }}</td>
                    <td class="fw-bold">{{ $kho->ten_kho }}</td>
                    <td>
                        <span class="badge  bg-success">{{ $kho->loai_kho }}</span>
                    </td>
                    <td>{{ $kho->dia_chi }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.warehouses.edit', $kho->id) }}" class="btn btn-sm btn-warning"><i
                                class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.warehouses.destroy', $kho->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Bạn có chắc muốn xóa kho này?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="m-3">{{ $warehouses->links() }}</div>

@endsection