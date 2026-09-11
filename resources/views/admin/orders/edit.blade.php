@extends('layouts.admin')
@section('title', 'Sửa Đơn Mua Hộ')
@section('page_title', 'Sửa mã đơn: ' . $order->ma_don_hang)

@section('content')
<form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- 1. THÔNG TIN CHUNG (Nâng cấp đa quốc gia) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-uppercase text-primary"><i class="bi bi-airplane-engines"></i> Lộ trình & Thông
                tin chung</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- KHỐI QUỐC GIA & NHÀ CUNG CẤP -->
                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Quốc gia mua hàng <span
                            class="text-danger">*</span></label>
                    <select name="country_id" id="countrySelect" class="form-select border-primary" required>
                        <option value="">-- Chọn Quốc gia --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" data-currency="{{ $country->tien_te }}"
                            {{ $order->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->ten_quoc_gia }} ({{ $country->tien_te }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Kho xuất phát (Quốc tế) <span
                            class="text-danger">*</span></label>
                    <select name="supplier_id" id="supplierSelect" class="form-select border-primary" required>
                        <option value="">-- Chọn Kho --</option>
                        @foreach($currentSuppliers as $sup)
                        <option value="{{ $sup->id }}" {{ $order->supplier_id == $sup->id ? 'selected' : '' }}>
                            {{ $sup->ten_ncc }} ({{ $sup->thanh_pho ?? 'Chưa rõ' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Kho nhận (Việt Nam) <span
                            class="text-danger">*</span></label>
                    <select name="tru_so_nhan_hang_id" class="form-select border-success" required>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ $order->tru_so_nhan_hang_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Tốc độ vận chuyển</label>
                    <select name="yeu_cau_toc_do" class="form-select">
                        <option value="thuong" {{ $order->yeu_cau_toc_do == 'thuong' ? 'selected' : '' }}>Thường
                        </option>
                        <option value="nhanh" {{ $order->yeu_cau_toc_do == 'nhanh' ? 'selected' : '' }}>Nhanh</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Trạng thái đơn hàng</label>
                    <select name="trang_thai" class="form-select border-warning">
                        <option value="cho_xu_ly" {{ $order->trang_thai == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="dang_xu_ly" {{ $order->trang_thai == 'dang_xu_ly' ? 'selected' : '' }}>Đang xử lý
                            (Sẽ tự tạo Kiện hàng)</option>
                        <option value="can_lien_he_lai" {{ $order->trang_thai == 'can_lien_he_lai' ? 'selected' : '' }}>
                            Cần liên hệ lại</option>
                        <option value="hoan_thanh" {{ $order->trang_thai == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                        </option>
                        <option value="da_huy" {{ $order->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã huỷ</option>
                    </select>
                </div>

                <!-- ADMIN ĐƯỢC QUYỀN GHI ĐÈ TỔNG TIỀN VNĐ CUỐI CÙNG -->
                <div class="col-md-3">
                    <label class="form-label font-14 fw-semibold">Tổng tiền thanh toán (VNĐ)</label>
                    <input type="number" name="tong_tien" class="form-control text-danger fw-bold"
                        value="{{ $order->tong_tien }}">
                    <small class="text-muted font-12">Lưu ý: Nếu sửa SP, hệ thống sẽ tự động tính lại số này.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DANH SÁCH SẢN PHẨM -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold">Chi tiết sản phẩm</h6>
            <button type="button" class="btn btn-sm btn-success" id="btnAddPackage"
                data-count="{{ $order->items->count() }}">
                <i class="bi bi-plus-lg"></i> Thêm sản phẩm
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light font-14">
                        <tr>
                            <th>Hình ảnh</th>
                            <th style="min-width: 250px;">Tên SP & Link</th>
                            <th>Thuộc tính</th>
                            <th style="width: 100px;">SL</th>
                            <!-- Ký hiệu tiền tệ động thay vì ¥ -->
                            <th style="width: 150px;">Giá (<span
                                    id="currencySymbol">{{ $order->country->tien_te ?? '¥' }}</span>)</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer">
                        @foreach($order->items as $index => $item)
                        <tr class="item-row">
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="items[{{ $index }}][hinh_anh_cu]"
                                value="{{ $item->hinh_anh_url }}">

                            <td>
                                @if($item->hinh_anh_url)
                                <img src="{{ asset($item->hinh_anh_url) }}" class="mb-1 rounded"
                                    style="width:40px;height:40px;object-fit:cover;">
                                @endif
                                <input type="file" name="items[{{ $index }}][hinh_anh_file]"
                                    class="form-control form-control-sm font-12" accept="image/*">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $index }}][ten_san_pham]"
                                    class="form-control form-control-sm mb-1" value="{{ $item->ten_san_pham }}"
                                    placeholder="Tên SP..." required>
                                <input type="text" name="items[{{ $index }}][link_san_pham]"
                                    class="form-control form-control-sm" value="{{ $item->link_san_pham }}"
                                    placeholder="Link Taobao, 1688...">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $index }}][mau_sac_kich_thuoc]"
                                    class="form-control form-control-sm" value="{{ $item->mau_sac_kich_thuoc }}"
                                    placeholder="Màu, Size...">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $index }}][so_luong]"
                                    class="form-control form-control-sm" value="{{ $item->so_luong }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="items[{{ $index }}][don_gia]"
                                    class="form-control form-control-sm text-danger fw-bold"
                                    value="{{ $item->don_gia }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nút Submit -->
    <div class="d-flex gap-2 mb-5">
        <button type="submit" class="btn btn-primary fw-bold px-5"><i class="bi bi-save me-2"></i> LƯU THAY ĐỔI</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Hủy</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. TẢI NHÀ CUNG CẤP VÀ ĐỔI KÝ HIỆU TIỀN TỆ KHI CHỌN QUỐC GIA
    const countrySelect = document.getElementById('countrySelect');
    const supplierSelect = document.getElementById('supplierSelect');
    const currencySymbol = document.getElementById('currencySymbol'); // Dành cho bảng Mua hộ

    if (countrySelect && supplierSelect) {
        countrySelect.addEventListener('change', function() {
            const countryId = this.value;

            // Đổi ký hiệu tiền tệ trên tiêu đề bảng
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.getAttribute('data-currency')) {
                currencySymbol.textContent = selectedOption.getAttribute('data-currency');
            }

            supplierSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            supplierSelect.disabled = true;

            if (countryId) {
                fetch(`/api/suppliers-by-country/${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        supplierSelect.innerHTML = '<option value="">-- Chọn Kho --</option>';
                        if (data.length > 0) {
                            data.forEach(sup => {
                                supplierSelect.insertAdjacentHTML('beforeend',
                                    `<option value="${sup.id}">${sup.ten_ncc} (${sup.thanh_pho || 'Chưa rõ'})</option>`
                                );
                            });
                            supplierSelect.disabled = false;
                        } else {
                            supplierSelect.innerHTML = '<option value="">Hết kho</option>';
                        }
                    });
            }
        });
    }

    // 2. LOGIC THÊM DÒNG SẢN PHẨM (Dành riêng cho Đơn Mua Hộ)
    const btnAddItem = document.getElementById('btnAddPackage'); // ID đúng của nút Thêm
    const itemsContainer = document.getElementById('itemsContainer'); // ID đúng của bảng

    if (btnAddItem && itemsContainer) {
        let pIndex = parseInt(btnAddItem.getAttribute('data-count')) + 100;

        btnAddItem.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td>
                    <input type="file" name="items[${pIndex}][hinh_anh_file]" class="form-control form-control-sm font-12" accept="image/*">
                </td>
                <td>
                    <input type="text" name="items[${pIndex}][ten_san_pham]" class="form-control form-control-sm mb-1" placeholder="Tên SP..." required>
                    <input type="text" name="items[${pIndex}][link_san_pham]" class="form-control form-control-sm" placeholder="Link Taobao, 1688...">
                </td>
                <td>
                    <input type="text" name="items[${pIndex}][mau_sac_kich_thuoc]" class="form-control form-control-sm" placeholder="Màu, Size...">
                </td>
                <td>
                    <input type="number" name="items[${pIndex}][so_luong]" class="form-control form-control-sm" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${pIndex}][don_gia]" class="form-control form-control-sm text-danger fw-bold" value="0" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item"><i class="bi bi-trash"></i></button>
                </td>
            `;
            itemsContainer.appendChild(tr);
            pIndex++;
        });

        // 3. LOGIC XÓA DÒNG SẢN PHẨM (Có cảnh báo)
        itemsContainer.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.btn-remove-item');

            if (removeBtn) {
                const rowCount = document.querySelectorAll('.item-row').length;

                if (rowCount > 1) {
                    if (confirm('Bạn có chắc chắn muốn xoá sản phẩm này khỏi đơn hàng?')) {
                        removeBtn.closest('tr').remove();
                        // Thông báo (có thể bỏ comment nếu muốn hiện)
                        // alert('Đã xoá tạm thời khỏi giao diện! Vui lòng bấm "Lưu thay đổi" để hệ thống cập nhật.');
                    }
                } else {
                    alert('Đơn hàng phải có ít nhất 1 sản phẩm! Không thể xoá thêm.');
                }
            }
        });
    }
});
</script>
@endpush