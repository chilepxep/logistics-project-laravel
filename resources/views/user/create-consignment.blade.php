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

<!-- Khối hiển thị thông báo -->
@if ($errors->any())
<div class="alert alert-danger mb-4 rounded-0 font-14">
    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Có lỗi xảy ra:</div>
    <ul class="mb-0 ps-3">
        @foreach (array_unique($errors->all()) as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success mb-4 rounded-0 font-14 fw-bold">
    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
</div>
@endif

<form action="{{ route('consignment.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="bg-white shadow-sm p-4 mb-4">

        <!-- Thanh quy trình (Trạng thái đơn hàng) -->
        <div class="d-flex gap-4 border-bottom pb-3 mb-4 font-14 fw-semibold text-muted">
            <div class="d-flex align-items-center gap-2 text-white px-3 py-2" style="background-color: #0b3a68;">
                <i class="bi bi-house-door fs-5"></i>
                <div class="lh-1">
                    <div>Tạo yêu cầu</div>
                    <div class="font-12 fw-normal">--/--/--</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-truck fs-5"></i>
                <div class="lh-1">
                    <div>Vận chuyển hàng</div>
                    <div class="font-12 fw-normal">--/--/--</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-file-earmark-text fs-5"></i>
                <div class="lh-1">
                    <div>Nhận hàng</div>
                    <div class="font-12 fw-normal">--/--/--</div>
                </div>
            </div>
        </div>

        <!-- KHỐI CHỌN TUYẾN VẬN CHUYỂN -->
        <div class="row bg-white shadow-sm p-3 rounded border mb-4">
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-airplane-engines"></i> 1. Tuyến Vận Chuyển</h6>

            <div class="col-12 mb-3">
                <div class="btn-group w-100 shadow-sm" role="group" id="btnGroupDirection">
                    <input type="radio" class="btn-check" name="chieu_van_chuyen" id="chieu_ve_vn" value="ve_vn" checked
                        autocomplete="off">
                    <label class="btn btn-outline-primary fw-bold" for="chieu_ve_vn">Quốc Tế <i
                            class="bi bi-arrow-right px-2"></i> Việt Nam</label>

                    <input type="radio" class="btn-check" name="chieu_van_chuyen" id="chieu_di_qt" value="di_qt"
                        autocomplete="off">
                    <label class="btn btn-outline-primary fw-bold" for="chieu_di_qt">Việt Nam <i
                            class="bi bi-arrow-right px-2"></i> Quốc Tế</label>
                </div>
            </div>

            <!-- KHU VỰC 1: KHO NƯỚC NGOÀI -->
            <div class="col-md-6 mb-3" id="boxQuocTe">
                <label class="form-label fw-bold"><span class="badge bg-warning text-dark me-1" id="lblQuocTe">TỪ</span>
                    Kho Quốc Tế <span class="text-danger">*</span></label>
                <div class="row g-2">
                    <div class="col-6">
                        <select name="country_id" id="countrySelect" class="form-select border-warning" required>
                            <option value="">-- Chọn Quốc gia --</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->ten_quoc_gia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="supplier_id" id="supplierSelect" class="form-select border-warning" required
                            disabled>
                            <option value="">-- Chọn Kho --</option>
                        </select>
                    </div>
                    <div id="warehouseDetails" class="mt-3 p-3 border rounded bg-light border-warning"
                        style="display: none;">
                        <h6 class="fw-bold mb-2 text-warning" id="detailTenKho">Tên kho</h6>
                        <p class="mb-1"><strong>Địa chỉ:</strong> <span id="detailDiaChi">...</span></p>
                        <p class="mb-1"><strong>SĐT:</strong> <span id="detailSDT">...</span></p>
                        <p class="mb-1"><strong>Mã bưu điện:</strong> <span id="detailZip">...</span></p>
                        <p class="mb-0"><strong>Quản kho:</strong> <span id="detailGhiChu">...</span></p>
                    </div>
                </div>
            </div>

            <!-- KHU VỰC 2: KHO VIỆT NAM -->
            <div class="col-md-6 mb-3" id="boxVietNam">
                <label class="form-label fw-bold"><span class="badge bg-success me-1" id="lblVietNam">ĐẾN</span> Kho
                    Việt Nam <span class="text-danger">*</span></label>
                <select name="tru_so_nhan_hang_id" id="vnWarehouseSelect" class="form-select border-success" required>
                    <option value="">-- Chọn Kho Nội Địa --</option>
                    @foreach($warehouses as $kho)
                    @if(str_starts_with($kho->ma_kho, 'VN-'))
                    <option value="{{ $kho->id }}" data-tenkho="{{ $kho->ten_kho }}" data-diachi="{{ $kho->dia_chi }}"
                        data-sdt="{{ $kho->so_dien_thoai }}" data-zip="{{ $kho->ma_buu_dien }}"
                        data-ghichu="{{ $kho->ghi_chu }}">
                        {{ $kho->ten_kho }}
                    </option>
                    @endif
                    @endforeach
                </select>
                <div id="vnWarehouseDetails" class="mt-3 p-3 border border-success rounded bg-light"
                    style="display: none;">
                    <h6 class="fw-bold mb-2 text-success" id="vnDetailTenKho">Tên kho</h6> <!-- Dòng mới thêm -->
                    <p class="mb-1"><strong>Địa chỉ:</strong> <span id="vnDetailDiaChi">...</span></p>
                    <p class="mb-1"><strong>SĐT:</strong> <span id="vnDetailSDT">...</span></p>
                    <p class="mb-1"><strong>Mã bưu điện:</strong> <span id="vnDetailZip">...</span></p>
                    <p class="mb-0"><strong>Quản kho:</strong> <span id="vnDetailGhiChu">...</span></p>
                </div>
            </div>
        </div>
        <!-- FORM NHẬP KIỆN HÀNG -->
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle form-table mb-0">
                <thead class="text-white text-center font-13" style="background-color: #0088cc;">
                    <tr>
                        <th style="width: 4%;">STT</th>
                        <th style="width: 10%;">Ảnh</th>
                        <th style="width: 25%;">Thông tin hàng hóa</th>
                        <th style="width: 25%;">Thông tin số hàng hóa</th>
                        <th style="width: 26%;">Ghi chú</th>
                        <th style="width: 10%;"></th>
                    </tr>
                </thead>
                <tbody id="packageTableBody">
                    <!-- Dòng kiện hàng số 1 -->
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-circle px-2 py-1 mb-1">1</span>
                            <button type="button" class="btn btn-sm btn-danger py-0 px-1 font-12 btn-delete-row"><i
                                    class="bi bi-x"></i></button>
                        </td>
                        <td class="text-center">
                            <div class="border bg-light d-flex align-items-center justify-content-center mb-1"
                                style="height: 80px; background-color: #f89406 !important;">
                                <i class="bi bi-truck text-white fs-1"></i>
                            </div>
                            <input type="file" name="packages[0][hinh_anh_file]" class="d-none" accept="image/*">
                            <button type="button" class="btn btn-outline-secondary btn-sm font-12 py-0 w-100"
                                onclick="this.previousElementSibling.click()">Tải ảnh</button>
                        </td>
                        <td>
                            <input type="text" name="packages[0][ma_van_don]"
                                class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Mã vận đơn (*)"
                                required>
                            <input type="text" name="packages[0][ten_san_pham]"
                                class="form-control form-control-sm mb-2 rounded-0 font-13"
                                placeholder="Tên sản phẩm (*)" required>
                            <input type="number" name="packages[0][so_kien_hang]"
                                class="form-control form-control-sm mb-2 rounded-0 font-13"
                                placeholder="Số kiện hàng (*)" required>
                            <input type="text" name="packages[0][hang_van_chuyen]"
                                class="form-control form-control-sm rounded-0 font-13" placeholder="Hãng vận chuyển (*)"
                                required>
                        </td>
                        <td>
                            <select name="packages[0][loai_danh_muc]"
                                class="form-select form-select-sm mb-2 rounded-0 font-13">
                                <option value="">- Chọn loại danh mục -</option>
                                <option value="Quần áo">Quần áo</option>
                                <option value="Dày dép">Dày dép</option>
                                <option value="Điện tử/ Điện máy">Điện tử/ Điện máy</option>
                                <option value="Nội thất/ Xây dựng">Nội thất/ Xây dựng</option>
                                <option value="Máy móc/ Nông nghiệp">Máy móc/ Nông nghiệp</option>
                                <option value="Mỹ phẩm">Mỹ phẩm</option>
                                <option value="Phụ kiện/ thời trang">Phụ kiện/ thời trang</option>
                                <option value="Đồ chơi/ Thể thao">Thịt/ Sữa</option>
                                <option value="Đồ chơi/ Thể thao">Thực phẩm chức năng</option>
                                <option value="Đồ chơi/ Thể thao">Thuỷ sản</option>
                            </select>
                            <input type="number" name="packages[0][so_luong]"
                                class="form-control form-control-sm mb-2 rounded-0 font-13"
                                placeholder="Số lượng sản phẩm (*)" required>
                            <input type="number" name="packages[0][gia_tri_hang_hoa]"
                                class="form-control form-control-sm rounded-0 font-13"
                                placeholder="Giá trị hàng hóa * (VNĐ)" required>
                        </td>
                        <td>
                            <input type="text" name="packages[0][link_san_pham]"
                                class="form-control form-control-sm mb-2 rounded-0 font-13"
                                placeholder="Link sản phẩm hoặc mô tả chi tiết Model, chất liệu...">
                            <textarea name="packages[0][ghi_chu]" class="form-control form-control-sm rounded-0 font-13"
                                rows="3" placeholder="Ghi chú..."></textarea>
                        </td>
                        <td class="font-13 bg-light">
                            <div class="fw-bold mb-1">Vận chuyển:</div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="packages[0][yeu_cau_toc_do]"
                                    value="nhanh" id="vc_nhanh_0" checked>
                                <label class="form-check-label" for="vc_nhanh_0">Nhanh</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="packages[0][yeu_cau_toc_do]"
                                    value="thuong" id="vc_thuong_0">
                                <label class="form-check-label" for="vc_thuong_0">Thường</label>
                            </div>
                            <hr class="my-2">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="packages[0][kiem_hang]" value="1"
                                    id="kh_0">
                                <label class="form-check-label" for="bh_0">Kiểm hàng</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="packages[0][dong_go]" value="1"
                                    id="dg_0">
                                <label class="form-check-label" for="dg_0">Đóng gỗ</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Nút Thêm kiện hàng -->
            <button type="button" id="btnAddPackage"
                class="btn btn-light border btn-sm px-3 mb-4 mt-2 font-13 fw-semibold text-primary">
                <i class="bi bi-plus-lg fs-5 align-middle"></i> Thêm kiện hàng
            </button>


            <div class="form-check m-3">
                <input type="hidden" name="co_bao_hiem" value="0">
                <input type="checkbox" name="co_bao_hiem" value="1" class="form-check-input" id="checkBaoHiem">
                <label class="form-check-label fw-bold text-primary" for="checkBaoHiem">
                    Đóng bảo hiểm hàng hóa
                </label>
                <div class="form-text text-muted mt-1" style="font-size: 0.85rem;">
                    <i class="bi bi-info-circle"></i> Đền bù 100% giá trị khai báo nếu xảy ra thất lạc, mất mát hoặc hư
                    hỏng nặng do lỗi vận chuyển. Phí bảo hiểm áp dụng theo quy định hiện hành.
                </div>
            </div>

            <!-- Checkbox Khai thuế -->
            <div class="form-check m-3">
                <input type="hidden" name="co_khai_thue" value="0">
                <input type="checkbox" name="co_khai_thue" value="1" class="form-check-input" id="checkKhaiThue">
                <label class="form-check-label fw-bold text-success" for="checkKhaiThue">
                    Khai báo thuế hải quan
                </label>
                <div class="form-text text-muted mt-1" style="font-size: 0.85rem;">
                    <i class="bi bi-info-circle"></i> Đảm bảo hàng hóa thông quan hợp pháp, không lo tắc biên. HTKK sẽ
                    hỗ trợ làm thủ tục và xuất trả hóa đơn VAT đầy đủ cho doanh nghiệp.
                </div>
            </div>
        </div>




        <button type="submit" class="btn text-white px-4 py-2 fw-bold rounded-1" style="background-color: #0b3a68;">Tạo
            đơn ký gửi</button>

    </div>

    <!-- Lưu ý -->
    <div class="alert alert-light border mb-4 font-13 text-danger position-relative">
        <strong class="text-primary">Lưu ý</strong><br>
        Khách hàng cần điền đầy đủ thông tin để thuận lợi cho quá trình thông quan và phân loại hàng hóa. Thông tin
        thiếu hoặc không chính xác, công ty sẽ lưu tại khu vực hàng hóa chưa phân loại của công ty và tính phí lưu kho.
        Quý khách có thể tham khảo thêm về chính sách và điều kiện về hàng ký gửi tại <a href="#"
            class="fw-bold text-dark">đây</a>.
    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddPackage = document.getElementById('btnAddPackage');
    const packageTableBody = document.getElementById('packageTableBody');

    // Biến đếm index cho mảng packages (bắt đầu từ 1 vì dòng HTML mặc định là 0)
    let packageIndex = 1;

    // Hàm 1: Đánh lại Số thứ tự (STT)
    function updateRowNumbers() {
        const rows = packageTableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const badge = row.querySelector('.badge');
            if (badge) badge.textContent = index + 1;
        });
    }

    // Hàm 2: Xử lý nút "Thêm kiện hàng"
    btnAddPackage.addEventListener('click', function() {
        const newRow = document.createElement('tr');

        // Bơm HTML vào dòng mới, sử dụng ${packageIndex} để gán name chuẩn xác
        newRow.innerHTML = `
            <td class="text-center">
                <span class="badge bg-primary rounded-circle px-2 py-1 mb-1"></span>
                <button type="button" class="btn btn-sm btn-danger py-0 px-1 font-12 btn-delete-row"><i class="bi bi-x"></i></button>
            </td>
            <td class="text-center">
                <div class="border bg-light d-flex align-items-center justify-content-center mb-1" style="height: 80px; background-color: #f89406 !important;">
                    <i class="bi bi-truck text-white fs-1"></i>
                </div>
                <input type="file" name="packages[${packageIndex}][hinh_anh_file]" class="d-none" accept="image/*">
                <button type="button" class="btn btn-outline-secondary btn-sm font-12 py-0 w-100" onclick="this.previousElementSibling.click()">Tải ảnh</button>
            </td>
            <td>
                <input type="text" name="packages[${packageIndex}][ma_van_don]" class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Mã vận đơn (*)" required>
                <input type="text" name="packages[${packageIndex}][ten_san_pham]" class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Tên sản phẩm (*)" required>
                <input type="number" name="packages[${packageIndex}][so_kien_hang]" class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Số kiện hàng (*)" required>
                <input type="text" name="packages[${packageIndex}][hang_van_chuyen]" class="form-control form-control-sm rounded-0 font-13" placeholder="Hãng vận chuyển (*)" required>
            </td>
            <td>
                <select name="packages[${packageIndex}][loai_danh_muc]" class="form-select form-select-sm mb-2 rounded-0 font-13">
                    <option value="">- Chọn loại danh mục -</option>
                    <option value="Quần áo">Quần áo</option>
                    <option value="Dày dép">Dày dép</option>
                    <option value="Điện tử/ Điện máy">Điện tử/ Điện máy</option>
                    <option value="Nội thất/ Xây dựng">Nội thất/ Xây dựng</option>
                    <option value="Máy móc/ Nông nghiệp">Máy móc/ Nông nghiệp</option>
                    <option value="Mỹ phẩm">Mỹ phẩm</option>
                    <option value="Phụ kiện/ thời trang">Phụ kiện/ thời trang</option>
                    <option value="Đồ chơi/ Thể thao">Đồ chơi/ Thể thao</option>
                </select>
                <input type="number" name="packages[${packageIndex}][so_luong]" class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Số lượng sản phẩm (*)" required>
                <input type="number" name="packages[${packageIndex}][gia_tri_hang_hoa]" class="form-control form-control-sm rounded-0 font-13" placeholder="Giá trị hàng hóa * (VNĐ)" required>
            </td>
            <td>
                <input type="text" name="packages[${packageIndex}][link_san_pham]" class="form-control form-control-sm mb-2 rounded-0 font-13" placeholder="Link sản phẩm hoặc mô tả chi tiết Model, chất liệu...">
                <textarea name="packages[${packageIndex}][ghi_chu]" class="form-control form-control-sm rounded-0 font-13" rows="3" placeholder="Ghi chú..."></textarea>
            </td>
            <td class="font-13 bg-light">
                <div class="fw-bold mb-1">Vận chuyển:</div>
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" name="packages[${packageIndex}][yeu_cau_toc_do]" value="nhanh" id="vc_nhanh_${packageIndex}" checked>
                    <label class="form-check-label" for="vc_nhanh_${packageIndex}">Nhanh</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="packages[${packageIndex}][yeu_cau_toc_do]" value="thuong" id="vc_thuong_${packageIndex}">
                    <label class="form-check-label" for="vc_thuong_${packageIndex}">Thường</label>
                </div>
                <hr class="my-2">
                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="packages[${packageIndex}][kiem_hang]" value="1" id="kh_${packageIndex}">
                    <label class="form-check-label" for="kh_${packageIndex}">Kiểm hàng</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="packages[${packageIndex}][dong_go]" value="1" id="dg_${packageIndex}">
                    <label class="form-check-label" for="dg_${packageIndex}">Đóng gỗ</label>
                </div>
            </td>
        `;

        packageTableBody.appendChild(newRow);
        packageIndex++; // Tăng index cho dòng tiếp theo
        updateRowNumbers();
    });

    // Hàm 3: Xử lý sự kiện Xóa dòng
    packageTableBody.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete-row');
        if (deleteBtn) {
            const row = deleteBtn.closest('tr');
            // Bắt buộc giữ lại ít nhất 1 dòng
            if (packageTableBody.querySelectorAll('tr').length > 1) {
                row.remove();
                updateRowNumbers();
            } else {
                alert('Đơn ký gửi phải có ít nhất 1 kiện hàng!');
            }
        }
    });

    // Hàm 4: Hiển thị ảnh Preview ngay khi chọn file
    packageTableBody.addEventListener('change', function(e) {
        if (e.target.type === 'file') {
            const file = e.target.files[0];
            if (file) {
                const imageUrl = URL.createObjectURL(file);
                // Tìm ô vuông chứa icon xe tải
                const previewBox = e.target.closest('td').querySelector('.border.bg-light');
                // Thay icon bằng ảnh thật
                previewBox.innerHTML =
                    `<img src="${imageUrl}" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
                previewBox.style.backgroundColor = '#fff'; // Xóa nền cam/xám đi cho đẹp
            }
        }
    });

    // Chạy hàm đánh số ngay khi load trang
    updateRowNumbers();


    // 1. LOGIC HOÁN ĐỔI CHIỀU VẬN CHUYỂN
    const radioVeVn = document.getElementById('chieu_ve_vn');
    const radioDiQt = document.getElementById('chieu_di_qt');
    const lblQuocTe = document.getElementById('lblQuocTe');
    const lblVietNam = document.getElementById('lblVietNam');

    function updateDirectionLabels() {
        if (radioVeVn.checked) {
            // Nước ngoài gửi về VN
            lblQuocTe.textContent = "TỪ";
            lblQuocTe.className = "badge bg-warning text-dark me-1";
            lblVietNam.textContent = "ĐẾN";
            lblVietNam.className = "badge bg-success me-1";
        } else {
            // VN gửi đi nước ngoài
            lblVietNam.textContent = "TỪ";
            lblVietNam.className = "badge bg-warning text-dark me-1";
            lblQuocTe.textContent = "ĐẾN";
            lblQuocTe.className = "badge bg-success me-1";
        }
    }

    radioVeVn.addEventListener('change', updateDirectionLabels);
    radioDiQt.addEventListener('change', updateDirectionLabels);


    // 2. LOGIC TẢI DANH SÁCH KHO QUỐC TẾ (AJAX)
    const countrySelect = document.getElementById('countrySelect');
    const supplierSelect = document.getElementById('supplierSelect');

    // Các DOM element để hiển thị chi tiết
    const warehouseDetails = document.getElementById('warehouseDetails');
    const detailTenKho = document.getElementById('detailTenKho');
    const detailDiaChi = document.getElementById('detailDiaChi');
    const detailSDT = document.getElementById('detailSDT');
    const detailZip = document.getElementById('detailZip');
    const detailGhiChu = document.getElementById('detailGhiChu');

    // Biến lưu trữ tạm dữ liệu kho vừa tải về
    let currentWarehousesList = [];

    countrySelect.addEventListener('change', function() {
        const countryId = this.value;
        supplierSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
        supplierSelect.disabled = true;
        warehouseDetails.style.display = 'none'; // Ẩn bảng chi tiết khi đổi quốc gia

        if (countryId) {
            fetch(`/api/suppliers-by-country/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    supplierSelect.innerHTML = '<option value="">-- Chọn Kho --</option>';
                    currentWarehousesList = data;
                    if (data.length > 0) {
                        data.forEach(sup => {
                            supplierSelect.insertAdjacentHTML('beforeend',
                                `<option value="${sup.id}">${sup.ten_kho || sup.ten_ncc}</option>`
                            );
                        });
                        supplierSelect.disabled = false;
                    } else {
                        supplierSelect.innerHTML = '<option value="">Hết kho</option>';
                    }
                });
        } else {
            supplierSelect.innerHTML = '<option value="">-- Chọn Kho --</option>';
        }
    });

    // 3. LOGIC HIỂN THỊ CHI TIẾT KHI CHỌN KHO
    supplierSelect.addEventListener('change', function() {
        const selectedId = this.value;

        if (selectedId) {
            // Tìm kho được chọn trong mảng currentWarehousesList
            const selectedWarehouse = currentWarehousesList.find(w => w.id == selectedId);

            if (selectedWarehouse) {
                // Đổ dữ liệu vào các thẻ HTML
                detailTenKho.textContent = selectedWarehouse.ten_kho || selectedWarehouse.ten_ncc ||
                    'Không có tên';
                detailDiaChi.textContent = selectedWarehouse.dia_chi || selectedWarehouse.thanh_pho ||
                    'Chưa cập nhật';
                detailSDT.textContent = selectedWarehouse.so_dien_thoai || 'Chưa cập nhật';
                detailZip.textContent = selectedWarehouse.ma_buu_dien || 'Chưa cập nhật';
                detailGhiChu.textContent = selectedWarehouse.ghi_chu || 'Không có ghi chú';

                // Hiển thị khung thông tin lên
                warehouseDetails.style.display = 'block';
            }
        } else {
            // Nếu chọn lại "-- Chọn Kho --", ẩn khung thông tin
            warehouseDetails.style.display = 'none';
        }
    });


    // LOGIC HIỂN THỊ CHI TIẾT KHO VIỆT NAM (Dữ liệu có sẵn trong data-*)
    const vnWarehouseSelect = document.getElementById('vnWarehouseSelect');
    const vnWarehouseDetails = document.getElementById('vnWarehouseDetails');
    const vnDetailTenKho = document.getElementById('vnDetailTenKho');
    const vnDetailDiaChi = document.getElementById('vnDetailDiaChi');
    const vnDetailSDT = document.getElementById('vnDetailSDT');
    const vnDetailZip = document.getElementById('vnDetailZip');
    const vnDetailGhiChu = document.getElementById('vnDetailGhiChu');

    vnWarehouseSelect.addEventListener('change', function() {
        // Lấy thẻ <option> đang được chọn
        const selectedOption = this.options[this.selectedIndex];

        // Kiểm tra xem người dùng có chọn một kho hợp lệ không (value != rỗng)
        if (this.value) {
            // Lấy dữ liệu từ các thuộc tính data-*
            vnDetailTenKho.textContent = selectedOption.getAttribute('data-tenkho') || 'Chưa cập nhật';
            vnDetailDiaChi.textContent = selectedOption.getAttribute('data-diachi') || 'Chưa cập nhật';
            vnDetailSDT.textContent = selectedOption.getAttribute('data-sdt') || 'Chưa cập nhật';
            vnDetailZip.textContent = selectedOption.getAttribute('data-zip') || 'Chưa cập nhật';
            vnDetailGhiChu.textContent = selectedOption.getAttribute('data-ghichu') ||
                'Không có ghi chú';

            // Hiển thị khung thông tin
            vnWarehouseDetails.style.display = 'block';
        } else {
            // Nếu người dùng chọn lại "-- Chọn Kho Nội Địa --", thì ẩn khung đi
            vnWarehouseDetails.style.display = 'none';
        }
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