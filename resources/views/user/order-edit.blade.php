@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


<div class="container-fluid mt-4 px-4">
    <form action="{{ route('order.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tiêu đề & Nút lưu -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-uppercase fw-bold m-0" style="color: #0b3a68;">
                <i class="bi bi-pencil-square me-2"></i> Sửa Đơn Mua Hộ: #{{ $order->ma_don_hang }}
            </h3>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary fw-bold">Cập nhật đơn hàng</button>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <!-- 1. THÔNG TIN CHUNG (KHO VÀ TỐC ĐỘ) -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-light fw-bold text-uppercase">Thông tin chung</div>
            <div class="card-body row">

                <!-- Khối Quốc gia và Nhà Cung Cấp -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Quốc gia mua hàng <span class="text-danger">*</span></label>
                    <select name="country_id" id="countrySelect" class="form-select border-primary" required>
                        <option value="">-- Chọn Quốc gia --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" data-currency="{{ $country->tien_te }}"
                            {{ (old('country_id') ?? $order->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->ten_quoc_gia }} ({{ $country->tien_te }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kho xuất phát / Nhà cung cấp <span
                            class="text-danger">*</span></label>
                    <select name="supplier_id" id="supplierSelect" class="form-select border-primary" required>
                        <option value="">-- Vui lòng chọn --</option>
                        <!-- Tải thẳng từ Backend ra thay vì chờ JS -->
                        @foreach($currentSuppliers as $sup)
                        <option value="{{ $sup->id }}" {{ $order->supplier_id == $sup->id ? 'selected' : '' }}>
                            {{ $sup->ten_ncc }} ({{ $sup->thanh_pho ?? 'Chưa rõ' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Khối Kho VN và Tốc độ cũ của bạn -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kho nhận hàng (VN)</label>
                    <select name="tru_so_nhan_hang_id" class="form-select">
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ $order->tru_so_nhan_hang_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Yêu cầu tốc độ</label>
                    <select name="yeu_cau_toc_do" class="form-select">
                        <option value="thuong" {{ $order->yeu_cau_toc_do == 'thuong' ? 'selected' : '' }}>Thường
                        </option>
                        <option value="nhanh" {{ $order->yeu_cau_toc_do == 'nhanh' ? 'selected' : '' }}>Nhanh</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 2. DANH SÁCH SẢN PHẨM -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold text-uppercase d-flex justify-content-between align-items-center">
                <span>Danh sách sản phẩm</span>
                <button type="button" id="btnAddItem" class="btn btn-sm btn-success"><i class="bi bi-plus"></i> Thêm sản
                    phẩm</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên SP & Thuộc tính</th>
                            <th>Số lượng & Đơn giá</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="itemTableBody">
                        @foreach($order->items as $index => $item)
                        <tr>
                            <!-- ẨN ID ĐỂ CẬP NHẬT -->
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="items[{{ $index }}][hinh_anh_cu]"
                                value="{{ $item->hinh_anh_url }}">

                            <td class="text-center">
                                <div class="mb-2">
                                    @if($item->hinh_anh_url)
                                    <img src="{{ $item->hinh_anh_url }}"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                </div>
                                <input type="file" name="items[{{ $index }}][hinh_anh_file]"
                                    class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $index }}][ten_san_pham]"
                                    value="{{ $item->ten_san_pham }}" class="form-control form-control-sm mb-2"
                                    placeholder="Tên SP" required>
                                <input type="text" name="items[{{ $index }}][thuoc_tinh]"
                                    value="{{ $item->thuoc_tinh }}" class="form-control form-control-sm mb-2"
                                    placeholder="Màu sắc, Size...">
                                <input type="text" name="items[{{ $index }}][link_san_pham]"
                                    value="{{ $item->link_san_pham }}" class="form-control form-control-sm"
                                    placeholder="Link SP">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $index }}][so_luong]" value="{{ $item->so_luong }}"
                                    class="form-control form-control-sm mb-2" placeholder="SL" required>
                                <input type="number" step="0.01" name="items[{{ $index }}][don_gia]"
                                    value="{{ $item->don_gia }}" class="form-control form-control-sm mb-2"
                                    placeholder="Giá tiền">
                                <textarea name="items[{{ $index }}][ghi_chu]" class="form-control form-control-sm"
                                    rows="1" placeholder="Ghi chú...">{{ $item->ghi_chu }}</textarea>
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<!-- SCRIPTS ĐỂ XỬ LÝ NÚT THÊM/XÓA DÒNG BẰNG JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddItem = document.getElementById('btnAddItem');
    const itemTableBody = document.getElementById('itemTableBody');

    // Đặt biến đếm bằng số lượng item đã có + 100 (để chắc chắn không trùng index với dòng cũ)
    let itemIndex = parseInt("{{ count($order->items) }}") + 100;

    // Thêm dòng mới
    btnAddItem.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center align-middle">
                <input type="file" name="items[${itemIndex}][hinh_anh_file]" class="form-control form-control-sm">
            </td>
            <td>
                <input type="text" name="items[${itemIndex}][ten_san_pham]" class="form-control form-control-sm mb-2" placeholder="Tên SP" required>
                <input type="text" name="items[${itemIndex}][thuoc_tinh]" class="form-control form-control-sm mb-2" placeholder="Màu sắc, Size...">
                <input type="text" name="items[${itemIndex}][link_san_pham]" class="form-control form-control-sm" placeholder="Link SP">
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][so_luong]" class="form-control form-control-sm mb-2" placeholder="SL" required>
               <input type="number" step="0.01" name="items[${itemIndex}][don_gia]" class="form-control form-control-sm mb-2" placeholder="Giá tiền"
                <textarea name="items[${itemIndex}][ghi_chu]" class="form-control form-control-sm" rows="1" placeholder="Ghi chú..."></textarea>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="bi bi-trash"></i></button>
            </td>
        `;
        itemTableBody.appendChild(newRow);
        itemIndex++;
    });

    // Xóa dòng
    itemTableBody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-row');
        if (deleteBtn) {
            deleteBtn.closest('tr').remove();
        }
    });

    // --- LOGIC LOAD NHÀ CUNG CẤP KHI EDIT ---
    const countrySelect = document.getElementById('countrySelect');
    const supplierSelect = document.getElementById('supplierSelect');

    // Lấy ID NCC cũ từ Database hoặc từ Old Input nếu Validate xịt
    const oldSupplierId = "{{ old('supplier_id', $order->supplier_id) }}";

    function fetchSuppliers(countryId, selectedSupplierId = null) {
        supplierSelect.innerHTML = '<option value="">-- Đang tải dữ liệu... --</option>';
        supplierSelect.disabled = true;

        fetch(`/api/suppliers-by-country/${countryId}`)
            .then(response => response.json())
            .then(data => {
                supplierSelect.innerHTML = '<option value="">-- Chọn Kho / Nhà cung cấp --</option>';
                if (data.length > 0) {
                    data.forEach(sup => {
                        let isSelected = (selectedSupplierId == sup.id) ? 'selected' : '';
                        let text = `${sup.ten_ncc} (${sup.thanh_pho || 'Chưa rõ'})`;
                        supplierSelect.insertAdjacentHTML('beforeend',
                            `<option value="${sup.id}" ${isSelected}>${text}</option>`);
                    });
                    supplierSelect.disabled = false;
                } else {
                    supplierSelect.innerHTML = '<option value="">Không có kho nào ở quốc gia này</option>';
                }
            });
    }

    // Khi người dùng đổi Quốc gia khác
    countrySelect.addEventListener('change', function() {
        if (this.value) fetchSuppliers(this.value);
        else {
            supplierSelect.innerHTML = '<option value="">-- Vui lòng chọn Quốc gia trước --</option>';
            supplierSelect.disabled = true;
        }
    });

});
</script>

@endsection