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
            <h5 class="text-danger fw-bold mb-0">024.6680.3049</h5>
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

    <!-- Tỉ giá -->
    <div class="d-flex align-items-center text-end">
        <i class="bi bi-cash-coin text-warning fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">TỈ GIÁ</small>
            <h5 class="text-danger fw-bold mb-0">3,520 đ</h5>
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

        <!-- FORM NHẬP SẢN PHẨM -->
        <div class="table-responsive mb-2">
            <table class="table table-bordered align-middle form-table mb-0">
                <thead class="text-white text-center font-13" style="background-color: #0b3a68;">
                    <tr>
                        <th style="width: 4%;">STT</th>
                        <th style="width: 12%;">Hình ảnh</th>
                        <th style="width: 35%;">Thuộc tính</th>
                        <th style="width: 10%;">Đơn giá (¥)</th>
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

                            <!-- 1. BẮT BUỘC PHẢI CÓ DÒNG NÀY: Thẻ input file bị ẩn -->
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

                <!-- Box Thông tin mua hàng -->
                <div class="p-3 mb-3 border font-14" style="background-color: #f8f9fa;">
                    <div class="fw-bold mb-2">THÔNG TIN MUA HÀNG</div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dia_chi_mua" id="dc_khac">
                        <label class="form-check-label" for="dc_khac">Thêm địa chỉ khác</label>
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
                        <span class="text-muted">Tổng tiền đặt hàng:</span>
                        <span class="text-danger fw-bold">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom border-light pb-2">
                        <span class="text-muted">Phí đặt hàng <i class="bi bi-question-circle text-primary"></i>:</span>
                        <span class="text-danger fw-bold">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom border-light pb-2">
                        <span class="text-muted">Phí kiểm đếm <i class="bi bi-question-circle text-primary"></i>:</span>
                        <span class="text-danger fw-bold">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom border-light pb-2">
                        <span class="text-muted">Phí đóng kiện <i
                                class="bi bi-question-circle text-primary"></i>:</span>
                        <span class="text-danger fw-bold">0 đ</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                        <span class="text-dark fw-bold">Tổng tiền/chưa có phí ship TQ:</span>
                        <span class="text-danger fw-bold fs-6">0 đ</span>
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
});
</script>

@endsection