@extends('layouts.admin')
@section('title', 'Sửa Đơn Ký Gửi')
@section('page_title', 'Sửa Đơn ký gửi: ' . $order->ma_don_ky_gui)

@section('content')
<form action="{{ route('admin.consignment_orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- 1. THÔNG TIN CHUNG VÀ LỘ TRÌNH VẬN CHUYỂN -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-uppercase text-success"><i class="bi bi-airplane-engines"></i> Lộ trình & Trạng
                thái</h6>
        </div>
        <div class="card-body">

            <!-- KHỐI CHỌN TUYẾN VẬN CHUYỂN (Tương tự User nhưng ngang hàng) -->
            <div class="row g-3 mb-4 border-bottom pb-4">
                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold text-primary">Hướng vận chuyển</label>
                    <div class="btn-group w-100 shadow-sm" role="group">
                        <input type="radio" class="btn-check" name="chieu_van_chuyen" id="chieu_ve_vn" value="ve_vn"
                            {{ $order->chieu_van_chuyen == 've_vn' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary btn-sm fw-bold" for="chieu_ve_vn">Quốc Tế <i
                                class="bi bi-arrow-right px-1"></i> VN</label>

                        <input type="radio" class="btn-check" name="chieu_van_chuyen" id="chieu_di_qt" value="di_qt"
                            {{ $order->chieu_van_chuyen == 'di_qt' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary btn-sm fw-bold" for="chieu_di_qt">VN <i
                                class="bi bi-arrow-right px-1"></i> Quốc Tế</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Quốc gia <span class="text-danger">*</span></label>
                    <select name="country_id" id="countrySelect" class="form-select border-warning" required>
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
                    <label class="form-label font-14 fw-bold">Kho Quốc Tế <span class="text-danger">*</span></label>
                    <select name="supplier_id" id="supplierSelect" class="form-select border-warning" required>
                        <option value="">-- Chọn Kho --</option>
                        @foreach($currentSuppliers as $sup)
                        <option value="{{ $sup->id }}" {{ $order->supplier_id == $sup->id ? 'selected' : '' }}>
                            {{ $sup->ten_ncc }} ({{ $sup->thanh_pho ?? 'Chưa rõ' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Kho Việt Nam <span class="text-danger">*</span></label>
                    <select name="tru_so_nhan_hang_id" class="form-select border-success" required>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ $order->kho_vn_id == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- KHỐI TRẠNG THÁI VÀ NGÀY THÁNG CỦA ADMIN -->
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Trạng thái xử lý</label>
                    <select name="trang_thai" class="form-select border-secondary">
                        <option value="cho_xu_ly" {{ $order->trang_thai == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="dang_xu_ly" {{ $order->trang_thai == 'dang_xu_ly' ? 'selected' : '' }}>Đang xử lý
                        </option>
                        <option value="can_lien_he_lai" {{ $order->trang_thai == 'can_lien_he_lai' ? 'selected' : '' }}>
                            Cần liên hệ lại</option>
                        <option value="hoan_thanh" {{ $order->trang_thai == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành
                        </option>
                        <option value="da_huy" {{ $order->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã huỷ</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Tốc độ vận chuyển</label>
                    <!-- Lưu ý: Nếu muốn sửa được tốc độ, hãy lấy từ kiện đầu tiên hoặc bảng cha -->
                    <select name="packages[0][yeu_cau_toc_do]" class="form-select">
                        <option value="thuong" {{ $order->yeu_cau_toc_do == 'thuong' ? 'selected' : '' }}>Thường
                        </option>
                        <option value="nhanh" {{ $order->yeu_cau_toc_do == 'nhanh' ? 'selected' : '' }}>Nhanh</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Ngày gửi đi (Vận chuyển)</label>
                    <input type="date" name="ngay_van_chuyen" class="form-control"
                        value="{{ $order->ngay_van_chuyen }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label font-14 fw-bold">Ngày nhận hàng</label>
                    <input type="date" name="ngay_nhan_hang" class="form-control" value="{{ $order->ngay_nhan_hang }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label font-14 fw-bold">Địa chỉ trả hàng (Giao tận nơi)</label>
                    <input type="text" name="dia_chi_tra_hang" class="form-control"
                        value="{{ $order->dia_chi_tra_hang }}" placeholder="Để trống nếu khách nhận tại kho...">
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CHI TIẾT CÁC KIỆN HÀNG -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-uppercase"><i class="bi bi-box-seam"></i> Danh sách kiện hàng</h6>
            <button type="button" class="btn btn-sm btn-success" id="btnAddPackage"
                data-count="{{ $order->items ? $order->items->count() : 0 }}">
                <i class="bi bi-plus-lg"></i> Thêm kiện hàng
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light font-14">
                        <tr>
                            <th>Mã vận đơn / Ảnh</th>
                            <th>Tên SP & Thông tin</th>
                            <th>Phân loại / SL</th>
                            <th>Dịch vụ thêm</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody id="packagesContainer">
                        @php
                        $extraReqs = \App\Models\ConsignmentExtraRequirement::where('consignment_order_id',
                        $order->id)->pluck('loai_yeu_cau')->toArray();
                        $hasDongGo = in_array('dong_go', $extraReqs);
                        $hasKiemHang = in_array('kiem_hang', $extraReqs);
                        @endphp

                        @if($order->items)
                        @foreach($order->items as $index => $item)
                        <tr class="package-row">
                            <input type="hidden" name="packages[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="packages[{{ $index }}][hinh_anh_cu]"
                                value="{{ $item->hinh_anh_url }}">

                            <td>
                                <input type="text" name="packages[{{ $index }}][ma_van_don]"
                                    class="form-control form-control-sm mb-1 fw-bold text-primary"
                                    value="{{ $item->ma_van_don }}" placeholder="Mã vận đơn..." required>
                                @if($item->hinh_anh_url)
                                <img src="{{ asset($item->hinh_anh_url) }}" class="mb-1 rounded"
                                    style="width:40px;height:40px;object-fit:cover;">
                                @endif
                                <input type="file" name="packages[{{ $index }}][hinh_anh_file]"
                                    class="form-control form-control-sm font-12" accept="image/*">
                            </td>
                            <td>
                                <input type="text" name="packages[{{ $index }}][ten_san_pham]"
                                    class="form-control form-control-sm mb-1" value="{{ $item->ten_san_pham }}"
                                    placeholder="Tên sản phẩm..." required>
                                <input type="text" name="packages[{{ $index }}][hang_van_chuyen]"
                                    class="form-control form-control-sm mb-1" value="{{ $item->hang_van_chuyen }}"
                                    placeholder="Hãng vận chuyển..." required>
                                <input type="text" name="packages[{{ $index }}][link_san_pham]"
                                    class="form-control form-control-sm" value="{{ $item->link_san_pham }}"
                                    placeholder="Link web...">
                            </td>
                            <td>
                                <input type="text" name="packages[{{ $index }}][loai_danh_muc]"
                                    class="form-control form-control-sm mb-1" value="{{ $item->loai_danh_muc }}"
                                    placeholder="Danh mục (VD: Quần áo)...">

                                <div class="d-flex gap-2">
                                    <input type="number" name="packages[{{ $index }}][so_luong]"
                                        class="form-control form-control-sm" value="{{ $item->so_luong }}"
                                        placeholder="SL SP" min="1" required>
                                    <input type="number" name="packages[{{ $index }}][so_kien_hang]"
                                        class="form-control form-control-sm" value="{{ $item->so_kien_hang }}"
                                        placeholder="Số kiện" min="1" required>
                                </div>
                                <input type="number" step="0.01" name="packages[{{ $index }}][gia_tri_hang_hoa]"
                                    class="form-control form-control-sm mt-1 text-danger fw-bold"
                                    value="{{ $item->gia_tri_hang_hoa }}" placeholder="Giá trị (VNĐ)" required>
                            </td>
                            <td>
                                <div class="form-check font-14">
                                    <input class="form-check-input" type="checkbox"
                                        name="packages[{{ $index }}][kiem_hang]" value="1" id="chkKiemHang_{{$index}}"
                                        {{ $hasKiemHang ? 'checked' : '' }}>
                                    <label class="form-check-label" for="chkKiemHang_{{$index}}">Kiểm hàng</label>
                                </div>
                                <div class="form-check font-14">
                                    <input class="form-check-input" type="checkbox"
                                        name="packages[{{ $index }}][dong_go]" value="1" id="chkDongGo_{{$index}}"
                                        {{ $hasDongGo ? 'checked' : '' }}>
                                    <label class="form-check-label" for="chkDongGo_{{$index}}">Đóng gỗ</label>
                                </div>
                                <input type="text" name="packages[{{ $index }}][ghi_chu]"
                                    class="form-control form-control-sm mt-1" value="{{ $item->ghi_chu }}"
                                    placeholder="Ghi chú...">
                            </td>
                            <td class="align-middle text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-package"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mb-5">
        <button type="submit" class="btn btn-primary fw-bold px-5"><i class="bi bi-save me-2"></i> LƯU THAY ĐỔI</button>
        <a href="{{ route('admin.consignment_orders.index') }}" class="btn btn-secondary">Hủy</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. TẢI NHÀ CUNG CẤP KHI ĐỔI QUỐC GIA
    const countrySelect = document.getElementById('countrySelect');
    const supplierSelect = document.getElementById('supplierSelect');

    countrySelect.addEventListener('change', function() {
        const countryId = this.value;
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

    // 2. LOGIC THÊM/XÓA KIỆN HÀNG (ĐÃ BỎ tq_vn)
    const btnAddPackage = document.getElementById('btnAddPackage');
    const packagesContainer = document.getElementById('packagesContainer');
    let pIndex = parseInt(btnAddPackage.getAttribute('data-count')) + 100;

    btnAddPackage.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.className = 'package-row';
        tr.innerHTML = `
            <td>
                <input type="text" name="packages[${pIndex}][ma_van_don]" class="form-control form-control-sm mb-1 fw-bold text-primary" placeholder="Mã vận đơn..." required>
                <input type="file" name="packages[${pIndex}][hinh_anh_file]" class="form-control form-control-sm font-12" accept="image/*">
            </td>
            <td>
                <input type="text" name="packages[${pIndex}][ten_san_pham]" class="form-control form-control-sm mb-1" placeholder="Tên sản phẩm..." required>
                <input type="text" name="packages[${pIndex}][hang_van_chuyen]" class="form-control form-control-sm mb-1" placeholder="Hãng vận chuyển..." required>
                <input type="text" name="packages[${pIndex}][link_san_pham]" class="form-control form-control-sm" placeholder="Link web...">
            </td>
            <td>
                <input type="text" name="packages[${pIndex}][loai_danh_muc]" class="form-control form-control-sm mb-1" placeholder="Danh mục...">
                <div class="d-flex gap-2">
                    <input type="number" name="packages[${pIndex}][so_luong]" class="form-control form-control-sm" placeholder="SL SP" min="1" required>
                    <input type="number" name="packages[${pIndex}][so_kien_hang]" class="form-control form-control-sm" placeholder="Số kiện" min="1" required>
                </div>
                <input type="number" step="0.01" name="packages[${pIndex}][gia_tri_hang_hoa]" class="form-control form-control-sm mt-1 text-danger fw-bold" placeholder="Giá trị (VNĐ)" required>
            </td>
            <td>
                <div class="form-check font-14">
                    <input class="form-check-input" type="checkbox" name="packages[${pIndex}][kiem_hang]" value="1" id="chkKiemHang_${pIndex}">
                    <label class="form-check-label" for="chkKiemHang_${pIndex}">Kiểm hàng</label>
                </div>
                <div class="form-check font-14">
                    <input class="form-check-input" type="checkbox" name="packages[${pIndex}][dong_go]" value="1" id="chkDongGo_${pIndex}">
                    <label class="form-check-label" for="chkDongGo_${pIndex}">Đóng gỗ</label>
                </div>
                <input type="text" name="packages[${pIndex}][ghi_chu]" class="form-control form-control-sm mt-1" placeholder="Ghi chú...">
            </td>
            <td class="align-middle text-center">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-package"><i class="bi bi-trash"></i></button>
            </td>
        `;
        packagesContainer.appendChild(tr);
        pIndex++;
    });

    packagesContainer.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-package')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@endpush