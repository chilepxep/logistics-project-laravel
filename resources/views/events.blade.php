<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sự kiện - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
</head>

<body class="bg-light">

    <!-- HEADER -->
    @include('layouts.header')

    <!-- BREADCRUMB -->
    <div class="bg-white py-2 border-bottom mb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sự kiện</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH (SỰ KIỆN) -->
    <section class="pb-5">
        <div class="container">

            <!-- Tiêu đề trang -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-uppercase mb-0" style="color: #0b3a68;">
                    <i class="bi bi-calendar-star me-2 text-warning"></i> Sự kiện nổi bật
                </h4>

                <!-- Bộ lọc sự kiện (Tùy chọn) -->
                <select class="form-select w-auto shadow-none rounded-pill" style="font-size: 14px;">
                    <option value="all">Tất cả sự kiện</option>
                    <option value="upcoming">Sắp diễn ra</option>
                    <option value="past">Đã kết thúc</option>
                </select>
            </div>

            <!-- LƯỚI SỰ KIỆN (Hiển thị 3 cột trên PC, 2 trên Tablet, 1 trên Mobile) -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">

                <!-- SỰ KIỆN 1 (Sắp diễn ra) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm event-card overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <!-- Ảnh bìa -->
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80"
                                class="card-img-top event-img object-fit-cover" height="220" alt="Hội thảo">

                            <!-- Nhãn trạng thái -->
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">Sắp
                                diễn ra</span>

                            <!-- Lịch ngày tháng nổi -->
                            <div
                                class="date-badge position-absolute top-0 end-0 bg-white text-center rounded-bottom ms-3 shadow">
                                <div class="bg-warning text-dark fw-bold py-1"
                                    style="font-size: 12px; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                                    THÁNG 9</div>
                                <div class="fs-2 fw-bold text-dark px-3 pb-1" style="line-height: 1;">15</div>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="card-title fw-bold mb-3">
                                <a href="#" class="text-decoration-none text-dark event-title">Hội thảo: Tối ưu hóa
                                    chuỗi cung ứng Việt - Trung 2026</a>
                            </h5>
                            <ul class="list-unstyled text-muted font-14 mb-4 flex-grow-1">
                                <li class="mb-2"><i class="bi bi-clock text-warning me-2"></i> 08:30 - 11:30 AM</li>
                                <li class="mb-2"><i class="bi bi-geo-alt text-warning me-2"></i> Khách sạn JW Marriott,
                                    Hà Nội</li>
                            </ul>
                            <a href="#" class="btn btn-outline-primary rounded-pill w-100 fw-semibold">Đăng ký tham
                                gia</a>
                        </div>
                    </div>
                </div>

                <!-- SỰ KIỆN 2 (Sắp diễn ra - Livestream) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm event-card overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=600&q=80"
                                class="card-img-top event-img object-fit-cover" height="220" alt="Livestream">

                            <span
                                class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">Đang
                                Hot</span>

                            <div
                                class="date-badge position-absolute top-0 end-0 bg-white text-center rounded-bottom ms-3 shadow">
                                <div class="bg-warning text-dark fw-bold py-1"
                                    style="font-size: 12px; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                                    THÁNG 11</div>
                                <div class="fs-2 fw-bold text-dark px-3 pb-1" style="line-height: 1;">10</div>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="card-title fw-bold mb-3">
                                <a href="#" class="text-decoration-none text-dark event-title">Livestream: Săn sale
                                    11/11 Taobao - Nhập hàng giá vốn</a>
                            </h5>
                            <ul class="list-unstyled text-muted font-14 mb-4 flex-grow-1">
                                <li class="mb-2"><i class="bi bi-clock text-warning me-2"></i> 20:00 - 22:30 PM</li>
                                <li class="mb-2"><i class="bi bi-geo-alt text-warning me-2"></i> Trực tiếp trên Fanpage
                                    HTKK 360</li>
                            </ul>
                            <a href="#" class="btn btn-primary text-white rounded-pill w-100 fw-semibold">Nhận thông
                                báo</a>
                        </div>
                    </div>
                </div>

                <!-- SỰ KIỆN 3 (Đã kết thúc) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm event-card overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=600&q=80"
                                class="card-img-top event-img object-fit-cover" height="220" alt="Lễ khai trương"
                                style="filter: grayscale(40%);">

                            <span
                                class="badge bg-secondary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">Đã
                                kết thúc</span>

                            <div
                                class="date-badge position-absolute top-0 end-0 bg-light text-center rounded-bottom ms-3 shadow">
                                <div class="bg-secondary text-white fw-bold py-1"
                                    style="font-size: 12px; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                                    THÁNG 5</div>
                                <div class="fs-2 fw-bold text-muted px-3 pb-1" style="line-height: 1;">20</div>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column bg-light">
                            <h5 class="card-title fw-bold mb-3">
                                <a href="#" class="text-decoration-none text-muted event-title">Lễ khai trương Siêu Kho
                                    chứa hàng thông minh tại Quảng Châu</a>
                            </h5>
                            <ul class="list-unstyled text-muted font-14 mb-4 flex-grow-1">
                                <li class="mb-2"><i class="bi bi-clock me-2"></i> 09:00 - 12:00 AM</li>
                                <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Kho Quảng Châu, Trung Quốc</li>
                            </ul>
                            <a href="#" class="btn btn-light border rounded-pill w-100 fw-semibold text-muted">Xem lại
                                sự kiện</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link border-0" href="#">« Trước</a></li>
                    <li class="page-item active"><a class="page-link border-0 rounded mx-1" href="#"
                            style="background-color: #0b3a68;">1</a></li>
                    <li class="page-item"><a class="page-link border-0 text-dark rounded mx-1" href="#">2</a></li>
                    <li class="page-item"><a class="page-link border-0 text-dark" href="#">Sau »</a></li>
                </ul>
            </nav>

        </div>
    </section>

    <!-- FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>