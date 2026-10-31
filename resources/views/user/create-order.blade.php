@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div
    class="top-banner mb-4 p-4 rounded-4 shadow-sm bg-white d-flex flex-wrap align-items-center justify-content-between">
    <!-- Hotline -->
    <div class="d-flex align-items-center me-3 mb-3 mb-md-0">
        <i class="bi bi-headset text-primary fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">HOTLINE</small>
            <h5 class="text-danger fw-bold mb-0">{{ $globalSetting->hotline ?? 'Đang cập nhật...' }}</h5>
        </div>
    </div>

    <!-- Thanh tìm kiếm Taobao -->
    <div class="flex-grow-1 mx-md-4 mb-3 mb-md-0" style="max-width: 500px;">
        <div class="input-group shadow-sm rounded-pill overflow-hidden border">
            <span class="input-group-text bg-white border-0 text-danger fw-bold">Taobao</span>
            <input type="text" class="form-control border-0 shadow-none font-14"
                placeholder="Nhập từ khóa tìm kiếm (Tiếng Việt)...">
            <button class="btn text-white px-4" type="button" style="background-color: #ff6a00;"><i
                    class="bi bi-search"></i></button>
        </div>
    </div>


    <div class="d-flex align-items-center cursor-pointer" style="cursor: pointer;" data-bs-toggle="modal"
        data-bs-target="#wiseCurrencyModal" title="Nhấn để mở công cụ quy đổi tiền tệ">
        <div class="me-2 text-warning">
            <i class="bi bi-cash-coin" style="font-size: 2.2rem;"></i>
        </div>
        <div>
            <div class="text-muted fw-bold" style="font-size: 12px;">
                TỈ GIÁ ({{ $defaultExchangeRate->currency_code ?? 'CNY' }}) <i
                    class="bi bi-caret-down-fill text-dark"></i>
            </div>
            <div class="text-danger fw-bold" style="font-size: 18px;">
                {{ isset($defaultExchangeRate) ? number_format($defaultExchangeRate->rate, 0, ',', '.') : '3,520' }} đ
            </div>
        </div>
    </div>
</div>


<!-- Khối Nội dung Tạo đơn -->
<form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white shadow-sm p-4">

        <!-- Thanh quy trình (Trạng thái đơn hàng) -->
        <div class="d-flex justify-content-center gap-4 border-bottom pb-3 mb-3 font-14 fw-semibold text-muted">
            <span class="text-dark fw-bold border-bottom border-danger border-2 pb-3 mb-n3">01 Tạo đơn</span>
            <span>02 Chờ báo giá</span>
            <span>03 Đặt cọc</span>
            <span>04 Đặt hàng</span>
            <span>05 Vận chuyển</span>
            <span>06 Nhận hàng</span>
        </div>

        <!-- THÊM ĐOẠN NÀY ĐỂ BẮT LỖI TỪ BACKEND -->
        @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-0 font-14">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Có lỗi xảy ra:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- THÊM ĐOẠN NÀY ĐỂ BÁO THÀNH CÔNG -->
        @if(session('success'))
        <div class="alert alert-success mb-4 rounded-0 font-14 fw-bold">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
        @endif
        <!-- KẾT THÚC THÊM -->


        <div class="row bg-white shadow-sm p-3 rounded border mb-4">
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-globe-asia-australia"></i> 1. Vị trí Nguồn hàng</h6>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Quốc gia mua hàng <span class="text-danger">*</span></label>
                <select name="country_id" id="countrySelect" class="form-select border-primary" required>
                    <option value="" data-currency="¥">-- Chọn Quốc gia --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" data-currency="{{ $country->tien_te }}"
                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->ten_quoc_gia }} ({{ $country->tien_te }})
                    </option>
                    @endforeach
                </select>
                @error('country_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Kho xuất phát / Nhà cung cấp <span
                        class="text-danger">*</span></label>
                <select name="supplier_id" id="supplierSelect" class="form-select border-primary" required disabled>
                    <option value="">-- Vui lòng chọn Quốc gia trước --</option>
                </select>
                @error('supplier_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- FORM NHẬP SẢN PHẨM -->
        <div class="table-responsive mb-2">
            <table class="table table-bordered align-middle form-table mb-0">
                <thead class="text-white text-center font-13" style="background-color: #0b3a68;">
                    <tr>
                        <th style="width: 4%;">STT</th>
                        <th style="width: 12%;">Hình ảnh</th>
                        <th style="width: 35%;">Thuộc tính</th>
                        <th style="width: 10%;">Đơn giá (<span class="currency-symbol">¥</span>)</th>
                        <th style="width: 10%;">Số lượng</th>
                        <th style="width: 20%;">Ghi chú khác</th>
                        <th style="width: 9%;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- Dòng sản phẩm 1 (Màu nền xanh nhạt) -->
                    <tr style="background-color: #f0f7ff;">
                        <td class="text-center"><span class="badge bg-primary rounded-circle px-2 py-1">1</span></td>
                        <td class="text-center">
                            <div class="border bg-white d-flex align-items-center justify-content-center mb-1"
                                style="height: 60px;">
                                <i class="bi bi-image text-muted fs-4"></i>
                            </div>


                            <input type="file" name="products[0][hinh_anh_file]" class="d-none" accept="image/*">

                            <!-- 2. Thẻ nhập link ảnh -->
                            <!-- <input type="text" name="products[][hinh_anh_url]"
                                class="form-control form-control-sm mb-1 rounded-0 font-12"
                                placeholder="Dán link ảnh..."> -->

                            <div class="d-flex gap-1 justify-content-center">
                                <!-- 3. Nút bấm đã được cập nhật onclick mới nhất -->
                                <button type="button" class="btn btn-info btn-sm text-white font-12 py-0 px-2"
                                    onclick="this.closest('td').querySelector('input[type=file]').click()">Tải
                                    ảnh</button>
                            </div>
                        </td>
                        <td>
                            <input name="products[0][ten_san_pham]" type="text"
                                class="form-control form-control-sm mb-1 rounded-0 shadow-none font-13"
                                placeholder="Tên sản phẩm - Ghi Tiếng Việt" require>
                            <input type="text" name="products[0][thuoc_tinh]"
                                class="form-control form-control-sm mb-1 rounded-0 shadow-none font-13"
                                placeholder="VD: Màu sắc, size, kích thước,..." require>
                            <input name="products[0][link_san_pham]" type="text"
                                class="form-control form-control-sm rounded-0 shadow-none font-13"
                                placeholder="Link sản phẩm" require>
                        </td>
                        <td><input name="products[0][don_gia]" type="number"
                                class="form-control form-control-sm rounded-0 shadow-none text-center font-13"
                                placeholder="Đơn giá"></td>
                        <td><input name="products[0][so_luong]" type="number"
                                class="form-control form-control-sm rounded-0 shadow-none text-center font-13"
                                placeholder="Số lượng"></td>
                        <td><textarea name="products[0][ghi_chu]"
                                class="form-control form-control-sm rounded-0 shadow-none font-13" rows="3"
                                placeholder="Ghi chú sản phẩm..."></textarea></td>
                        <td class="text-center position-relative">
                            <span class="text-danger fw-bold">0 ¥</span>
                            <!-- Nút xóa dòng -->
                            <button type="button"
                                class="btn btn-sm btn-light position-absolute top-0 end-0 p-1 lh-1 btn-delete-row"><i
                                    class="bi bi-x-square-fill text-secondary"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Nút Thêm sản phẩm -->
        <button type="button" id="btnAddProduct" class="btn text-white btn-sm px-3 mb-4 font-13"
            style="background-color: #ff6a00;"><i class="bi bi-plus"></i> Thêm sản phẩm</button>

        <!-- KHỐI TÙY CHỌN & TỔNG TIỀN -->
        <div class="row">
            <!-- Cột trái: Tùy chọn -->
            <div class="col-12 col-lg-8">

                <!-- Box Vận chuyển (Xám) -->
                <div class="p-3 mb-3 border font-14" style="background-color: #e9ecef;">
                    <div class="row mb-2">
                        <div class="col-3 text-muted">Vận chuyển</div>
                        <div class="col-9">
                            <div class="form-check form-check-inline">

                                <input class="form-check-input" type="radio" name="yeu_cau_toc_do" id="vc_nhanh"
                                    value="nhanh" checked>
                                <label class="form-check-label text-primary fw-semibold" for="vc_nhanh">Nhanh</label>
                            </div>
                            <div class="form-check form-check-inline">

                                <input class="form-check-input" type="radio" name="yeu_cau_toc_do" id="vc_thuong"
                                    value="thuong">
                                <label class="form-check-label" for="vc_thuong">Thường</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 text-muted">Yêu cầu khác</div>
                        <div class="col-9">
                            <div class="form-check form-check-inline">
                                <!-- Đã thêm value="kiem_hang" -->
                                <input name="extra_reqs[]" class="form-check-input" type="checkbox" id="yc_kiem_hang"
                                    value="kiem_hang">
                                <label class="form-check-label" for="yc_kiem_hang">Kiểm hàng</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <!-- Đã thêm value="dong_go" -->
                                <input name="extra_reqs[]" class="form-check-input" type="checkbox" id="yc_dong_go"
                                    value="dong_go">
                                <label class="form-check-label" for="yc_dong_go">Đóng gỗ</label>
                            </div>

                            <div class="form-check mt-2">
                                <!-- Đã thêm value="khai_thue_gtgt" -->
                                <input name="extra_reqs[]" class="form-check-input" type="checkbox" id="yc_khai_thue"
                                    value="khai_thue_gtgt">
                                <label class="form-check-label" for="yc_khai_thue">Khai thuế 100% hàng có hóa đơn
                                    GTGT</label>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Box Trụ sở nhận hàng -->
                <div class="p-3 mb-4 border font-14" style="background-color: #f8f9fa;">
                    <div class="fw-bold mb-2">TRỤ SỞ NHẬN HÀNG (*)</div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tru_so_nhan_hang_id" value="1" checked>
                        <label class="form-check-label">Hà Nội - Kho Hà Nội 1 : Xuân Đỉnh - Bắc Từ Liêm - <span
                                class="badge bg-primary font-10">Đặt mặc định</span></label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tru_so_nhan_hang_id" value="2">
                        <label class="form-check-label">Hà Nội - Kho Hà Nội 2 : Đường đê san - Đông Anh - <span
                                class="badge bg-primary font-10">Đặt mặc định</span></label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tru_so_nhan_hang_id" value="3">
                        <label class="form-check-label">Hải Phòng - Kho Hải Phòng : Đường Lê Hồng Phong - Hải An - <span
                                class="badge bg-primary font-10">Đặt mặc định</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tru_so_nhan_hang_id" value="4">
                        <label class="form-check-label">Hồ Chí Minh - Kho Hồ Chí Minh : Phạm Văn Đồng - Quận Thủ Đức -
                            <span class="badge bg-primary font-10">Đặt mặc định</span></label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success px-4 py-2 fw-bold rounded-1">ĐẶT HÀNG</button>

            </div>

            <!-- Cột phải: Summary Box (Bảng giá) -->
            <div class="col-12 col-lg-4">
                <div class="border bg-white shadow-sm font-14 p-3 summary-box">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tổng tiền đặt hàng (<span class="currency-symbol">¥</span>):</span>
                        <span class="text-danger fw-bold" id="sumOrderAmountFc">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom border-light pb-2">
                        <span class="text-muted">Tỉ giá quy đổi:</span>
                        <span class="text-primary fw-bold" id="exchangeRate">1 = 0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tiền hàng (VNĐ):</span>
                        <span class="text-danger fw-bold" id="sumOrderAmountVnd">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Phí đặt hàng (VD: 1%):</span>
                        <span class="text-danger fw-bold" id="sumOrderFee">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom border-light pb-2">
                        <span class="text-muted">Phí dịch vụ (Kiểm/Đóng):</span>
                        <span class="text-danger fw-bold" id="sumExtraFee">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                        <span class="text-dark fw-bold">Tổng tiền (Chưa ship TQ-VN):</span>
                        <span class="text-danger fw-bold fs-6" id="sumGrandTotal">0 đ</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddProduct = document.getElementById('btnAddProduct');
    const tbody = document.getElementById('productTableBody');

    // Hàm 1: Đánh lại Số thứ tự (STT) và màu nền sau khi Thêm/Xóa
    function updateRowNumbers() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const badge = row.querySelector('.badge');
            if (badge) badge.textContent = index + 1;
            row.style.backgroundColor = (index % 2 === 0) ? '#f0f7ff' : '#ffffff';
            if (badge) badge.className = (index % 2 === 0) ?
                'badge bg-primary rounded-circle px-2 py-1' :
                'badge bg-secondary rounded-circle px-2 py-1';
        });
    }

    // Hàm 2: Sự kiện khi bấm "Thêm sản phẩm" (Bao gồm File ảnh và mảng Name chuẩn)
    btnAddProduct.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        let productIndex = 1;
        newRow.innerHTML = `
            <td class="text-center"><span class="badge rounded-circle px-2 py-1"></span></td>
            <td class="text-center">
                <div class="border bg-white d-flex align-items-center justify-content-center mb-1" style="height: 60px;">
                    <i class="bi bi-image text-muted fs-4"></i>
                </div>
                
                 <input type="file" name="products[${productIndex}][hinh_anh_file]" class="d-none" accept="image/*"> 
                
                
                <div class="d-flex gap-1 justify-content-center">
                    <button type="button" class="btn btn-info btn-sm text-white font-12 py-0 px-2" onclick="this.closest('td').querySelector('input[type=file]').click()">Tải ảnh</button>
                </div>
            </td>
            <td>
                <input type="text" name="products[${productIndex}][ten_san_pham]" class="form-control form-control-sm mb-1 rounded-0 shadow-none font-13" placeholder="Tên sản phẩm - Ghi Tiếng Việt" required>
                <input type="text" name="products[${productIndex}][thuoc_tinh]" class="form-control form-control-sm mb-1 rounded-0 shadow-none font-13" placeholder="VD: Màu sắc, size, kích thước,..." required>
                <input type="text" name="products[${productIndex}][link_san_pham]" class="form-control form-control-sm rounded-0 shadow-none font-13" placeholder="Link sản phẩm" required>
            </td>
            <td><input type="number" name="products[${productIndex}][don_gia]" class="form-control form-control-sm rounded-0 shadow-none text-center font-13" placeholder="Đơn giá"></td>
            <td><input type="number" name="products[${productIndex}][so_luong]" class="form-control form-control-sm rounded-0 shadow-none text-center font-13" placeholder="Số lượng"></td>
            <td><textarea name="products[${productIndex}][ghi_chu]" class="form-control form-control-sm rounded-0 shadow-none font-13" rows="3" placeholder="Ghi chú..."></textarea></td>
            <td class="text-center position-relative">
                <span class="text-danger fw-bold">0 ¥</span>
                <button type="button" class="btn btn-sm btn-light position-absolute top-0 end-0 p-1 lh-1 btn-delete-row"><i class="bi bi-x-square-fill text-secondary"></i></button>
            </td>
        `;

        tbody.appendChild(newRow);
        updateRowNumbers();

        productIndex++;
    });

    // Hàm 3: Sự kiện khi bấm "Xóa" một dòng
    tbody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-row');
        if (deleteBtn) {
            const row = deleteBtn.closest('tr');
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                updateRowNumbers();
            } else {
                alert('Đơn hàng phải có ít nhất 1 sản phẩm!');
            }
        }
    });

    // Hàm 4: Hiển thị ảnh Preview ngay khi chọn file
    tbody.addEventListener('change', function(e) {
        // Kiểm tra xem phần tử vừa có sự thay đổi có phải là ô input file không
        if (e.target.type === 'file') {
            const file = e.target.files[0]; // Lấy file ảnh người dùng vừa chọn

            if (file) {
                // Tạo một đường dẫn ảo tạm thời cho bức ảnh
                const imageUrl = URL.createObjectURL(file);

                // Tìm cái khung chứa icon ảnh (thẻ div có class 'border')
                const previewBox = e.target.closest('td').querySelector('.border');

                // Thay thế cái icon bên trong bằng một thẻ <img> chứa ảnh thật
                previewBox.innerHTML =
                    `<img src="${imageUrl}" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
            }
        }
    });

    updateRowNumbers();

    //======XỬ LÝ QUỐC GIA VÀ CÁC KHO =======
    const countrySelect = document.getElementById('countrySelect');
    const supplierSelect = document.getElementById('supplierSelect');

    // Lấy ID nhà cung cấp cũ (nếu có lỗi validation xảy ra)
    const oldSupplierId = "{{ old('supplier_id') }}";

    // Hàm gọi API lấy danh sách Nhà cung cấp
    function fetchSuppliers(countryId, selectedSupplierId = null) {
        supplierSelect.innerHTML = '<option value="">-- Đang tải dữ liệu... --</option>';
        supplierSelect.disabled = true;

        // ĐÃ SỬA: Gọi vào API mới tạo
        fetch(`/api/get-suppliers-mua-ho/${countryId}`)
            .then(response => response.json())
            .then(data => {
                supplierSelect.innerHTML = '<option value="">-- Chọn Kho / Nhà cung cấp --</option>';

                if (data.length > 0) {
                    data.forEach(sup => {
                        let isSelected = (selectedSupplierId == sup.id) ? 'selected' : '';
                        let text = `${sup.ten_ncc} (${sup.thanh_pho || 'Chưa rõ vị trí'})`;

                        supplierSelect.insertAdjacentHTML('beforeend',
                            `<option value="${sup.id}" ${isSelected}>${text}</option>`);
                    });
                    supplierSelect.disabled = false;
                } else {
                    supplierSelect.innerHTML =
                        '<option value="">Không có nhà cung cấp ở quốc gia này</option>';
                }
            })
            .catch(error => {
                console.error("Lỗi tải dữ liệu:", error);
                supplierSelect.innerHTML = '<option value="">Lỗi kết nối máy chủ</option>';
            });
    }

    // 1. CHẠY KHI VỪA VÀO TRANG (Xử lý trường hợp Form bị lỗi và Load lại)
    if (countrySelect.value) {
        fetchSuppliers(countrySelect.value, oldSupplierId);
    }

    // 2. CHẠY KHI NGƯỜI DÙNG THAY ĐỔI QUỐC GIA
    countrySelect.addEventListener('change', function() {
        if (this.value) {
            fetchSuppliers(this.value);
        } else {
            supplierSelect.innerHTML = '<option value="">-- Vui lòng chọn Quốc gia trước --</option>';
            supplierSelect.disabled = true;
        }
    });


    //====XỬ LÝ TÍNH TIỀN
    // 1. Lấy toàn bộ Tỉ giá từ Database 
    const TIGIA_JSON = '{!! json_encode(\App\Models\ExchangeRate::pluck("rate", "currency_code")) !!}';

    // 2. Ép kiểu chuỗi đó thành Object JS
    const TIGIA = JSON.parse(TIGIA_JSON);
    const FEES = JSON.parse('{!! json_encode(config("fees")) !!}');

    // Gán thêm ký hiệu '¥' trỏ về Tỉ giá của CNY
    if (TIGIA['CNY']) {
        TIGIA['¥'] = TIGIA['CNY'];
    }


    function calculateTotal() {
        let totalQty = 0;
        let totalAmountFC = 0; // FC = Foreign Currency (Tiền ngoại tệ)

        // 1. Tính tổng số lượng và tổng tiền hàng ngoại tệ từ bảng
        const rows = document.getElementById('productTableBody').querySelectorAll('tr');
        rows.forEach(row => {
            const price = parseFloat(row.querySelector('input[name*="[don_gia]"]').value) || 0;
            const qty = parseInt(row.querySelector('input[name*="[so_luong]"]').value) || 0;

            const rowTotal = price * qty;
            totalQty += qty;
            totalAmountFC += rowTotal;

            // Cập nhật số tiền ở từng dòng
            const currentCurrency = document.querySelector('.currency-symbol').textContent;
            row.querySelector('.text-danger.fw-bold').innerHTML =
                `${rowTotal.toLocaleString()} <span class="currency-symbol">${currentCurrency}</span>`;
        });

        // 2. Lấy đơn vị tiền tệ và Tỉ giá hiện tại
        // Giả sử thẻ select chọn quốc gia của bạn có id là countrySelect
        const countrySelect = document.getElementById('countrySelect');
        const selectedOption = countrySelect ? countrySelect.options[countrySelect.selectedIndex] : null;
        const currencyCode = selectedOption ? selectedOption.getAttribute('data-currency') : 'CNY';

        // SỬA LỖI ĐỘN GIÁ: Ép kiểu parseFloat và đổi fallback từ 35000 thành 3520
        const currentExchangeRate = parseFloat(TIGIA[currencyCode]) || 3520;

        // 3. Quy đổi tiền hàng ra VNĐ
        const totalAmountVND = totalAmountFC * currentExchangeRate;

        // 4. Tính phí dịch vụ (Dựa vào Checkbox)
        // Dùng optional chaining (?.) để tránh báo lỗi JS nếu không tìm thấy ID
        const isKiemHang = document.getElementById('yc_kiem_hang')?.checked || false;
        const isDongGo = document.getElementById('yc_dong_go')?.checked || false;

        let extraFeeVND = 0;
        if (isKiemHang) extraFeeVND += totalQty * FEES.phi_kiem_dem_per_item;
        if (isDongGo) extraFeeVND += totalQty * FEES.phi_dong_go_per_item;

        // 5. Tính phí mua hộ
        const orderFeeVND = totalAmountVND * FEES.phi_dat_hang_percent;

        // 6. Tính Tổng thanh toán
        const grandTotal = totalAmountVND + extraFeeVND + orderFeeVND;

        // 7. Hiển thị ra giao diện
        document.getElementById('sumOrderAmountFc').textContent = totalAmountFC.toLocaleString();
        document.getElementById('exchangeRate').textContent = `1 = ${currentExchangeRate.toLocaleString()} đ`;
        document.getElementById('sumOrderAmountVnd').textContent = `${totalAmountVND.toLocaleString()} đ`;
        document.getElementById('sumOrderFee').textContent = `${orderFeeVND.toLocaleString()} đ`;
        document.getElementById('sumExtraFee').textContent = `${extraFeeVND.toLocaleString()} đ`;
        document.getElementById('sumGrandTotal').textContent = `${grandTotal.toLocaleString()} đ`;
    }

    // --- LẮNG NGHE SỰ KIỆN ĐỂ TÍNH TOÁN NGAY LẬP TỨC ---

    // Lắng nghe khi gõ giá và số lượng trong bảng
    tbody.addEventListener('input', function(e) {
        if (e.target.name.includes('[don_gia]') || e.target.name.includes('[so_luong]')) {
            calculateTotal();
        }
    });

    // Lắng nghe khi xóa hoặc thêm dòng
    tbody.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-row')) {
            setTimeout(calculateTotal, 50); // Chờ xoá xong mới tính
        }
    });
    btnAddProduct.addEventListener('click', function() {
        setTimeout(calculateTotal, 50);
    });

    // Lắng nghe khi tick chọn dịch vụ gia tăng
    document.getElementById('yc_kiem_hang').addEventListener('change', calculateTotal);
    document.getElementById('yc_dong_go').addEventListener('change', calculateTotal);

    // Lắng nghe khi đổi quốc gia (Đổi kí hiệu tiền tệ và Tỉ giá)
    countrySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const currencyCode = selectedOption ? selectedOption.getAttribute('data-currency') : '¥';

        // Đổi toàn bộ kí hiệu tiền trên màn hình
        document.querySelectorAll('.currency-symbol').forEach(el => el.textContent = currencyCode);
        calculateTotal(); // Tính lại theo tỉ giá mới
    });
});
</script>

<!-- MODAL CÔNG CỤ ĐỔI TỶ GIÁ PHONG CÁCH WISE.COM -->
<div class="modal fade" id="wiseCurrencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #0b3a68;">
                    <i class="bi bi-currency-exchange me-2"></i>Công cụ quy đổi tỷ giá HTKK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Ô 1: Số tiền ngoại tệ cần đổi -->
                <label class="form-label text-muted fw-semibold font-14">Số tiền ngoại tệ</label>
                <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm mb-2">
                    <input type="number" id="wiseAmountInput" class="form-control border-0 fw-bold fs-4" value="100"
                        min="0" step="any">

                    <!-- Dropdown chọn Quốc Gia / Tiền tệ -->
                    <select id="wiseCurrencySelect" class="form-select border-0 bg-light fw-bold text-dark"
                        style="max-width: 140px; cursor: pointer;">
                        @if(isset($globalExchangeRates) && count($globalExchangeRates) > 0)
                        @foreach($globalExchangeRates as $rateItem)
                        <option value="{{ $rateItem->rate }}" data-code="{{ $rateItem->currency_code }}"
                            data-name="{{ $rateItem->currency_name }}" {{ $rateItem->is_default ? 'selected' : '' }}>
                            {{ $rateItem->currency_code }} ({{$rateItem->currency_name }})
                        </option>
                        @endforeach
                        @else
                        <option value="3520" data-code="CNY" data-name="Nhân dân tệ">CNY (Tệ)</option>
                        @endif
                    </select>
                </div>

                <!-- Đường timeline hiển thị tỷ giá kiểu Wise -->
                <div class="position-relative my-3 ps-4 py-2"
                    style="border-left: 2px solid #dee2e6; margin-left: 15px;">
                    <span
                        class="position-absolute top-50 start-0 translate-middle bg-white border rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 24px; height: 24px;">
                        <i class="bi bi-arrow-down-up text-primary" style="font-size: 12px;"></i>
                    </span>
                    <div class="font-14 text-muted">
                        Tỷ giá áp dụng: <strong class="text-dark" id="wiseRateDisplay">1 CNY = 3,520 VNĐ</strong>
                    </div>
                </div>

                <!-- Ô 2: Thành tiền VNĐ -->
                <label class="form-label text-muted fw-semibold font-14">Thành tiền Việt Nam (VNĐ)</label>
                <div class="input-group input-group-lg border rounded-3 overflow-hidden bg-light shadow-sm">
                    <input type="text" id="wiseResultOutput"
                        class="form-control border-0 bg-light fw-bold fs-4 text-danger" readonly>
                    <span class="input-group-text border-0 bg-light fw-bold text-dark px-4">
                        🇻🇳 VNĐ
                    </span>
                </div>

                <div class="mt-3 text-muted" style="font-size: 12px;">
                    <i class="bi bi-info-circle me-1"></i> Tỷ giá trên được áp dụng để tính phí mua hàng và vận chuyển
                    hộ tại hệ thống HTKK 360.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT TÍNH TOÁN THỜI GIAN THỰC -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const amountInput = document.getElementById('wiseAmountInput');
    const currencySelect = document.getElementById('wiseCurrencySelect');
    const rateDisplay = document.getElementById('wiseRateDisplay');
    const resultOutput = document.getElementById('wiseResultOutput');

    function calculateWiseExchange() {
        if (!amountInput || !currencySelect) return;

        const amount = parseFloat(amountInput.value) || 0;
        const selectedOption = currencySelect.options[currencySelect.selectedIndex];
        const rate = parseFloat(selectedOption.value) || 0;
        const code = selectedOption.getAttribute('data-code') || '';

        // Tính tổng tiền VNĐ
        const totalVND = amount * rate;

        // Định dạng số đẹp mắt (VD: 352,000)
        const formattedRate = new Intl.NumberFormat('vi-VN').format(rate);
        const formattedTotal = new Intl.NumberFormat('vi-VN').format(Math.round(totalVND));

        // Cập nhật giao diện
        rateDisplay.innerHTML = `1 ${code} = <span class="text-danger">${formattedRate} VNĐ</span>`;
        resultOutput.value = formattedTotal;
    }

    // Lắng nghe sự kiện khi gõ phím hoặc đổi quốc gia
    if (amountInput && currencySelect) {
        amountInput.addEventListener('input', calculateWiseExchange);
        currencySelect.addEventListener('change', calculateWiseExchange);

        // Chạy lần đầu khi tải trang
        calculateWiseExchange();
    }
});
</script>

@endsection