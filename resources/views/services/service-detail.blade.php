<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ kiểm đếm - HTKK 360</title>
    <!-- Nhúng CSS của Bootstrap và Vite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
</head>

<body>

    <!-- GỌI HEADER TỰ ĐỘNG -->
    @include('layouts.header')

    <!-- THANH BREADCRUMB (Điều hướng) -->
    <div class="bg-light py-2 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 14px;">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dịch vụ kiểm đếm</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH CỦA TRANG -->
    <section class="article-section py-4">
        <div class="container">
            <div class="row g-4">

                <!-- =======================================
                     CỘT TRÁI: NỘI DUNG BÀI VIẾT (Chiếm 9/12 cột) 
                     ======================================= -->
                <div class="col-12 col-lg-9">

                    <!-- Tiêu đề khối màu xanh -->
                    <div class="p-2 mb-3 text-white fw-bold text-uppercase" style="background-color: #0b3a68;">
                        DỊCH VỤ KIỂM ĐẾM
                    </div>

                    <div class="article-content bg-white p-3 border">

                        <!-- Mục lục (Table of Contents) -->
                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2">Mục lục</p>
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                <li class="mb-1"><a href="#muc-1" class="text-decoration-none"
                                        style="color: #0b3a68;">1. Dịch vụ kiểm đếm hàng hóa Trung Quốc</a></li>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none"
                                        style="color: #0b3a68;">2. Phí dịch vụ</a></li>
                                <li><a href="#muc-3" class="text-decoration-none" style="color: #0b3a68;">3. Một số lưu
                                        ý khi sử dụng dịch vụ kiểm đếm</a></li>
                            </ul>
                        </div>

                        <!-- Đoạn văn bản mẫu -->
                        <p id="muc-1" class="fw-bold">1. Dịch vụ kiểm đếm hàng hóa Trung Quốc là gì?</p>
                        <p style="font-size: 15px; text-align: justify; line-height: 1.7;">
                            Kiểm đếm là dịch vụ ghi nhận lại số lượng, kích thước, màu sắc... của hàng hóa thực tế nhận
                            được tại kho Trung Quốc so với thông tin trên đơn hàng mà quý khách đã đặt mua.
                        </p>

                        <!-- Ảnh minh họa trong bài -->
                        <div class="text-center my-4">
                            <img src="{{ asset('images/kiemdemhanghoa.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                        </div>

                        <!-- Bảng giá (Sử dụng class của Bootstrap) -->
                        <p id="muc-2" class="fw-bold text-danger">Bảng giá dịch vụ:</p>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-striped text-center align-middle"
                                style="font-size: 14px;">
                                <thead class="text-white" style="background-color: #0b3a68;">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá (VNĐ/sản phẩm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dưới 100 sản phẩm</td>
                                        <td>5,000đ</td>
                                    </tr>
                                    <tr>
                                        <td>Từ 100 - 500 sản phẩm</td>
                                        <td>3,000đ</td>
                                    </tr>
                                    <tr>
                                        <td>Trên 500 sản phẩm</td>
                                        <td>2,000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Lưu ý bằng chữ đỏ -->
                        <p id="muc-3" class="fw-bold text-danger">Lưu ý:</p>
                        <ul class="text-danger" style="font-size: 14px; line-height: 1.7;">
                            <li>HTKK 360 chỉ kiểm tra số lượng, màu sắc, kích thước. Không cam kết kiểm tra chất liệu,
                                thông số kỹ thuật chi tiết của sản phẩm.</li>
                            <li>Trường hợp hàng hóa bị lỗi do nhà sản xuất (sai màu, sai size...), chúng tôi sẽ hỗ trợ
                                khiếu nại đổi trả.</li>
                        </ul>

                        <!-- Block Tin liên quan ở cuối bài -->
                        <div class="related-posts mt-5 border-top pt-3">
                            <div class="fw-bold mb-3 border-start border-4 border-primary ps-2"
                                style="font-size: 18px; color: #0b3a68;">
                                Tin liên quan
                            </div>
                            <!-- Bạn có thể thêm danh sách tin ở đây -->
                        </div>

                    </div>
                </div>

                <!-- =======================================
                     CỘT PHẢI: SIDEBAR (Chiếm 3/12 cột) 
                     ======================================= -->
                <div class="col-12 col-lg-3">

                    <!-- Chúng ta sẽ code phần Bài viết mới nhất ở đây -->
                    <div class="p-2 text-white fw-bold text-uppercase" style="background-color: #0b3a68;">
                        BÀI VIẾT MỚI NHẤT
                    </div>
                    <!-- Nội dung sidebar (tạm để trống) -->
                    <div class="text-black fw-normal p-2" style="background-color: #dee2e682;">

                        <div class="d-flex align-items-center">
                            <i class="bi bi-caret-right-fill me-2"></i>
                            <span>Thông tin luật hải quan</span>
                        </div>

                    </div>
                    <div class="text-black fw-normal p-2" style="background-color: #dee2e682;">

                        <div class="d-flex align-items-center">
                            <i class="bi bi-caret-right-fill me-2"></i>
                            <span>Thông tin luật hải quan</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- GỌI FOOTER TỰ ĐỘNG -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>