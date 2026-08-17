<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức & Sự kiện - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/news.css'])
</head>

<body class="bg-light">

    <!-- HEADER -->
    @include('layouts.header')

    <!-- BREADCRUMB -->
    <div class="bg-white py-2 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tin tức & Sự kiện</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: DANH SÁCH BÀI VIẾT (9 CỘT) -->
                <div class="col-12 col-lg-9">

                    <h4 class="fw-bold text-uppercase mb-4" style="color: #0b3a68;">Tin tức mới nhất</h4>

                    <!-- BÀI VIẾT SỐ 1 -->
                    <div class="card mb-4 border-0 shadow-sm news-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <!-- Ảnh đại diện -->
                            <div class="col-md-4 overflow-hidden h-100">
                                <img src="https://img.baobacninhtv.vn/Medias/2021/12/29/14/20211229144159-kt2.jpg"
                                    class="img-fluid news-thumbnail object-fit-cover w-100 h-100" alt="Thông quan">
                            </div>
                            <!-- Nội dung tóm tắt -->
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <span class="badge bg-warning text-dark mb-2">Thị trường</span>
                                    <h5 class="card-title fw-bold">
                                        <a href="#" class="text-decoration-none text-dark news-title">Cập nhật tình hình
                                            thông quan cửa khẩu biên giới Việt - Trung tháng 8/2026</a>
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="bi bi-calendar3 me-1"></i> 17/08/2026 | <i class="bi bi-eye me-1"></i>
                                        1,245 lượt xem
                                    </p>
                                    <p class="card-text text-muted news-excerpt">
                                        Tình hình thông quan tại các cửa khẩu đường bộ đang có nhiều biến động do chính
                                        sách kiểm soát mới. HTKK Logistics cập nhật tiến độ chi tiết để quý khách hàng
                                        chủ động lên phương án kinh doanh kịp thời...
                                    </p>
                                    <a href="#"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold mt-2">Đọc
                                        tiếp <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BÀI VIẾT SỐ 2 -->
                    <div class="card mb-4 border-0 shadow-sm news-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 overflow-hidden h-100">
                                <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500&q=80"
                                    class="img-fluid news-thumbnail object-fit-cover w-100 h-100" alt="Sale 11/11">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <span class="badge text-white mb-2" style="background-color: #0b3a68;">Khuyến
                                        mãi</span>
                                    <h5 class="card-title fw-bold">
                                        <a href="#" class="text-decoration-none text-dark news-title">Bùng nổ siêu sale
                                            11/11 trên Taobao: Kinh nghiệm săn sale không thể bỏ lỡ</a>
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="bi bi-calendar3 me-1"></i> 10/08/2026 | <i class="bi bi-eye me-1"></i>
                                        3,890 lượt xem
                                    </p>
                                    <p class="card-text text-muted news-excerpt">
                                        Lễ hội mua sắm 11/11 (Ngày Độc thân) là đợt sale lớn nhất năm tại Trung Quốc. Bỏ
                                        túi ngay bí kíp tìm kiếm mã giảm giá, cách ghép đơn và lựa chọn shop uy tín để
                                        nhập hàng với giá vốn rẻ nhất...
                                    </p>
                                    <a href="#"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold mt-2">Đọc
                                        tiếp <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BÀI VIẾT SỐ 3 -->
                    <div class="card mb-5 border-0 shadow-sm news-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 overflow-hidden h-100">
                                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500&q=80"
                                    class="img-fluid news-thumbnail object-fit-cover w-100 h-100" alt="Kinh nghiệm">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <span class="badge bg-danger text-white mb-2">Kinh nghiệm</span>
                                    <h5 class="card-title fw-bold">
                                        <a href="#" class="text-decoration-none text-dark news-title">Hướng dẫn cách
                                            khiếu nại shop trên 1688 khi nhận hàng sai mẫu, thiếu số lượng</a>
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="bi bi-calendar3 me-1"></i> 05/08/2026 | <i class="bi bi-eye me-1"></i>
                                        856 lượt xem
                                    </p>
                                    <p class="card-text text-muted news-excerpt">
                                        Rủi ro khi mua hàng online xuyên biên giới là điều khó tránh khỏi. Bài viết này
                                        sẽ hướng dẫn bạn chi tiết từng bước bằng hình ảnh cách mở tranh chấp (Refund)
                                        trên hệ thống 1688 thành công 100%...
                                    </p>
                                    <a href="#"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold mt-2">Đọc
                                        tiếp <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PHÂN TRANG -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link border-0" href="#">« Trước</a></li>
                            <li class="page-item active"><a class="page-link border-0 rounded mx-1" href="#"
                                    style="background-color: #0b3a68;">1</a></li>
                            <li class="page-item"><a class="page-link border-0 text-dark rounded mx-1" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link border-0 text-dark rounded mx-1" href="#">3</a>
                            </li>
                            <li class="page-item"><a class="page-link border-0 text-dark" href="#">Sau »</a></li>
                        </ul>
                    </nav>

                </div>

                <!-- CỘT PHẢI: SIDEBAR (3 CỘT) -->
                <div class="col-12 col-lg-3">

                    <!-- Ô Tìm kiếm -->
                    <div class="bg-white p-4 border shadow-sm rounded mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #0b3a68;">Tìm kiếm</h6>
                        <div class="input-group">
                            <input type="text" class="form-control shadow-none" placeholder="Nhập từ khóa...">
                            <button class="btn btn-warning text-dark" type="button"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <!-- Danh mục tin tức -->
                    <div class="bg-white p-4 border shadow-sm rounded mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #0b3a68;">Danh mục</h6>
                        <ul class="list-group list-group-flush">
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom">
                                Thông báo <span class="badge bg-light text-dark rounded-pill">14</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom">
                                Tin thị trường <span class="badge bg-light text-dark rounded-pill">25</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom">
                                Kinh nghiệm nhập hàng <span class="badge bg-light text-dark rounded-pill">42</span>
                            </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                                Khuyến mãi <span class="badge bg-light text-dark rounded-pill">8</span>
                            </a>
                        </ul>
                    </div>

                    <!-- Bài viết nổi bật -->
                    <div class="bg-white p-4 border shadow-sm rounded">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #0b3a68;">Đọc nhiều nhất</h6>

                        <div class="d-flex align-items-center mb-3">
                            <img src="https://img.baobacninhtv.vn/Medias/2021/12/29/14/20211229144159-kt2.jpg"
                                class="rounded object-fit-cover me-3" width="70" height="70" alt="...">
                            <div>
                                <a href="#" class="text-decoration-none text-dark fw-semibold"
                                    style="font-size: 13px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Cập
                                    nhật tình hình thông quan cửa khẩu...</a>
                                <small class="text-muted font-12"><i class="bi bi-clock me-1"></i>17/08/2026</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=100&q=80"
                                class="rounded object-fit-cover me-3" width="70" height="70" alt="...">
                            <div>
                                <a href="#" class="text-decoration-none text-dark fw-semibold"
                                    style="font-size: 13px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Bùng
                                    nổ siêu sale 11/11 trên Taobao...</a>
                                <small class="text-muted font-12"><i class="bi bi-clock me-1"></i>10/08/2026</small>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>