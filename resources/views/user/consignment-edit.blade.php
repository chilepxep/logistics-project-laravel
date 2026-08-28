@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div class="container-fluid mt-4 px-4">
    <form action="{{ route('consignment.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tiêu đề & Nút lưu -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-uppercase fw-bold m-0" style="color: #198754;">
                <i class="bi bi-pencil-square me-2"></i> Sửa Ký Gửi: #{{ $order->ma_don_ky_gui }}
            </h3>
            <div>
                <a href="{{ route('consignment.index') }}" class="btn btn-outline-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-success fw-bold">Cập nhật đơn hàng</button>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <!-- THÔNG TIN KHO -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header fw-bold text-uppercase text-white" style="background-color: #198754;">
                Kho nhận hàng Trung Quốc
            </div>
            <div class="card-body">
                <select name="tru_so_nhan_hang_id" class="form-select w-50">
                    @foreach($warehouses as $kho)
                    <option value="{{ $kho->id }}" {{ $order->kho_nhan_tq_id == $kho->id ? 'selected' : '' }}>
                        {{ $kho->ten_kho }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- DANH SÁCH KIỆN HÀNG -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold text-uppercase d-flex justify-content-between align-items-center"
                style="color: #198754;">
                <span>Danh sách kiện hàng</span>
                <button type="button" id="btnAddPackage" class="btn btn-sm btn-success"><i class="bi bi-plus"></i> Thêm
                    kiện hàng</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Ảnh</th>
                                <th>Mã VĐ / Hãng VC</th>
                                <th>Sản phẩm / Phân loại</th>
                                <th>SL / Giá trị</th>
                                <th>Dịch vụ</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody id="packageTableBody">
                            @foreach($order->items as $index => $item)
                            <!-- Biến kiểm tra Dịch vụ để tự động tick lại -->
                            @php
                            $isDongGo = $order->extraRequirements->where('loai_yeu_cau', 'dong_go')->count() > 0;
                            $isKiemHang = $order->extraRequirements->where('loai_yeu_cau', 'kiem_hang')->count() > 0;
                            @endphp

                            <tr>
                                <!-- ẨN ID -->
                                <input type="hidden" name="packages[{{ $index }}][id]" value="{{ $item->id }}">
                                <input type="hidden" name="packages[{{ $index }}][hinh_anh_cu]"
                                    value="{{ $item->hinh_anh_url }}">

                                <td class="text-center align-middle" style="width: 150px;">
                                    <div class="d-flex flex-column align-items-center gap-2">

                                        @if($item->hinh_anh_url)
                                        <img src="{{ $item->hinh_anh_url }}" alt="Ảnh sản phẩm" class="border rounded"
                                            style="width: 55px; height: 55px; object-fit: cover;">
                                        @else
                                        <div class="border rounded d-flex align-items-center justify-content-center text-muted"
                                            style="width: 55px; height: 55px; background: #f8f9fa;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                        @endif

                                        <input type="file" name="packages[{{ $index }}][hinh_anh_file]"
                                            class="form-control form-control-sm" style="width: 130px;">

                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="packages[{{ $index }}][ma_van_don]"
                                        value="{{ $item->ma_van_don }}" class="form-control form-control-sm mb-2"
                                        placeholder="Mã vận đơn (*)" required>
                                    <input type="text" name="packages[{{ $index }}][hang_van_chuyen]"
                                        value="{{ $item->hang_van_chuyen }}" class="form-control form-control-sm"
                                        placeholder="Hãng VC (*)" required>
                                </td>
                                <td>
                                    <input type="text" name="packages[{{ $index }}][ten_san_pham]"
                                        value="{{ $item->ten_san_pham }}" class="form-control form-control-sm mb-2"
                                        placeholder="Tên SP (*)" required>
                                    <div class="d-flex gap-2 mb-2">
                                        <select name="packages[{{ $index }}][tq_vn]" class="form-select form-select-sm">
                                            <option value="TQ-VN" {{ $item->tq_vn == 'TQ-VN' ? 'selected' : '' }}>TQ -
                                                VN</option>
                                        </select>
                                        <select name="packages[{{ $index }}][loai_danh_muc]"
                                            class="form-select form-select-sm">
                                            <option value="">- Danh mục -</option>
                                            <option value="Quần áo"
                                                {{ $item->loai_danh_muc == 'Quần áo' ? 'selected' : '' }}>Quần áo
                                            </option>
                                            <option value="Điện tử"
                                                {{ $item->loai_danh_muc == 'Điện tử' ? 'selected' : '' }}>Điện tử
                                            </option>
                                        </select>
                                    </div>
                                    <input type="text" name="packages[{{ $index }}][link_san_pham]"
                                        value="{{ $item->link_san_pham }}" class="form-control form-control-sm"
                                        placeholder="Link SP">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text">SL</span>
                                        <input type="number" name="packages[{{ $index }}][so_luong]"
                                            value="{{ $item->so_luong }}" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text">Kiện</span>
                                        <input type="number" name="packages[{{ $index }}][so_kien_hang]"
                                            value="{{ $item->so_kien_hang }}" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="packages[{{ $index }}][gia_tri_hang_hoa]"
                                            value="{{ $item->gia_tri_hang_hoa }}" class="form-control"
                                            placeholder="Giá trị VNĐ" required>
                                    </div>
                                </td>
                                <td class="font-13 bg-light">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio"
                                            name="packages[{{ $index }}][yeu_cau_toc_do]" value="nhanh"
                                            id="vc_nhanh_{{ $index }}"
                                            {{ $order->yeu_cau_toc_do == 'nhanh' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vc_nhanh_{{ $index }}">Nhanh</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="packages[{{ $index }}][yeu_cau_toc_do]" value="thuong"
                                            id="vc_thuong_{{ $index }}"
                                            {{ $order->yeu_cau_toc_do == 'thuong' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vc_thuong_{{ $index }}">Thường</label>
                                    </div>
                                    <hr class="my-1">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox"
                                            name="packages[{{ $index }}][kiem_hang]" value="1" id="kh_{{ $index }}"
                                            {{ $isKiemHang ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kh_{{ $index }}">Kiểm hàng</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="packages[{{ $index }}][dong_go]" value="1" id="dg_{{ $index }}"
                                            {{ $isDongGo ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dg_{{ $index }}">Đóng gỗ</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i
                                            class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddPackage = document.getElementById('btnAddPackage');
    const packageTableBody = document.getElementById('packageTableBody');

    // Khắc phục lỗi của VS Code bằng cách bọc nháy kép
    let pIndex = parseInt("{{ count($order->items) }}") + 100;

    // Thêm dòng mới
    btnAddPackage.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center align-middle">
                <input type="file" name="packages[${pIndex}][hinh_anh_file]" class="form-control form-control-sm font-12" style="width: 90px;">
            </td>
            <td>
                <input type="text" name="packages[${pIndex}][ma_van_don]" class="form-control form-control-sm mb-2" placeholder="Mã vận đơn (*)" required>
                <input type="text" name="packages[${pIndex}][hang_van_chuyen]" class="form-control form-control-sm" placeholder="Hãng VC (*)" required>
            </td>
            <td>
                <input type="text" name="packages[${pIndex}][ten_san_pham]" class="form-control form-control-sm mb-2" placeholder="Tên SP (*)" required>
                <div class="d-flex gap-2 mb-2">
                    <select name="packages[${pIndex}][tq_vn]" class="form-select form-select-sm">
                        <option value="TQ-VN">TQ - VN</option>
                    </select>
                    <select name="packages[${pIndex}][loai_danh_muc]" class="form-select form-select-sm">
                        <option value="">- Danh mục -</option>
                        <option value="Quần áo">Quần áo</option>
                        <option value="Điện tử">Điện tử</option>
                    </select>
                </div>
                <input type="text" name="packages[${pIndex}][link_san_pham]" class="form-control form-control-sm" placeholder="Link SP">
            </td>
            <td>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text">SL</span>
                    <input type="number" name="packages[${pIndex}][so_luong]" class="form-control" required>
                </div>
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text">Kiện</span>
                    <input type="number" name="packages[${pIndex}][so_kien_hang]" class="form-control" required>
                </div>
                <div class="input-group input-group-sm">
                    <input type="number" name="packages[${pIndex}][gia_tri_hang_hoa]" class="form-control" placeholder="Giá trị VNĐ" required>
                </div>
            </td>
            <td class="font-13 bg-light">
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="packages[${pIndex}][yeu_cau_toc_do]" value="nhanh" id="vc_nhanh_${pIndex}" checked>
                    <label class="form-check-label" for="vc_nhanh_${pIndex}">Nhanh</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="packages[${pIndex}][yeu_cau_toc_do]" value="thuong" id="vc_thuong_${pIndex}">
                    <label class="form-check-label" for="vc_thuong_${pIndex}">Thường</label>
                </div>
                <hr class="my-1">
                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="packages[${pIndex}][kiem_hang]" value="1" id="kh_${pIndex}">
                    <label class="form-check-label" for="kh_${pIndex}">Kiểm hàng</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="packages[${pIndex}][dong_go]" value="1" id="dg_${pIndex}">
                    <label class="form-check-label" for="dg_${pIndex}">Đóng gỗ</label>
                </div>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="bi bi-trash"></i></button>
            </td>
        `;
        packageTableBody.appendChild(newRow);
        pIndex++;
    });

    // Xóa dòng
    packageTableBody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-row');
        if (deleteBtn) {
            deleteBtn.closest('tr').remove();
        }
    });
});
</script>

@endsection