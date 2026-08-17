<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuyển dụng - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/recuitment.css'])
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
                    <li class="breadcrumb-item active" aria-current="page">Tuyển dụng</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH (TUYỂN DỤNG) -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: DANH SÁCH VIỆC LÀM (9 CỘT) -->
                <div class="col-12 col-lg-9">

                    <!-- Khối: Tại sao chọn HTKK -->
                    <div class="bg-white p-4 border shadow-sm rounded mb-5">
                        <h5 class="fw-bold text-uppercase mb-4 text-center" style="color: #0b3a68;">Gia nhập đội ngũ
                            HTKK Logistics</h5>

                        <div class="row g-4 text-center">
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-briefcase-fill text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Môi trường năng động</h6>
                                <p class="text-muted font-12 mb-0">Làm việc cùng những người trẻ nhiệt huyết, tự do sáng
                                    tạo và khẳng định bản thân.</p>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-cash-coin text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Đãi ngộ hấp dẫn</h6>
                                <p class="text-muted font-12 mb-0">Mức lương thưởng cạnh tranh, xét tăng lương định kỳ,
                                    thưởng tháng 13 và các dịp Lễ Tết.</p>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <i class="bi bi-graph-up-arrow text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Cơ hội thăng tiến</h6>
                                <p class="text-muted font-12 mb-0">Lộ trình thăng tiến rõ ràng, được đào tạo chuyên môn
                                    thường xuyên.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Khối: Danh sách Vị trí tuyển dụng -->
                    <h5 class="fw-bold text-uppercase mb-4" style="color: #0b3a68;">Vị trí đang tuyển dụng</h5>

                    <!-- Job 1 -->
                    <div class="card mb-3 border-0 shadow-sm job-card">
                        <div
                            class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h5 class="fw-bold mb-2">
                                    <a href="#" class="text-decoration-none text-dark job-title">Nhân viên Kinh doanh
                                        Logistics (Sales)</a>
                                </h5>
                                <div class="d-flex flex-wrap gap-3 text-muted font-14">
                                    <span><i class="bi bi-geo-alt me-1 text-danger"></i>Hà Nội</span>
                                    <span><i class="bi bi-currency-dollar me-1 text-success"></i>10 - 20 Triệu</span>
                                    <span><i class="bi bi-clock-history me-1 text-warning"></i>Hạn nộp:
                                        30/09/2026</span>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-semibold w-100">Ứng
                                    tuyển ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Job 2 -->
                    <div class="card mb-3 border-0 shadow-sm job-card">
                        <div
                            class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h5 class="fw-bold mb-2">
                                    <a href="#" class="text-decoration-none text-dark job-title">Nhân viên CSKH Tiếng
                                        Trung</a>
                                </h5>
                                <div class="d-flex flex-wrap gap-3 text-muted font-14">
                                    <span><i class="bi bi-geo-alt me-1 text-danger"></i>Hà Nội / TP.HCM</span>
                                    <span><i class="bi bi-currency-dollar me-1 text-success"></i>12 - 15 Triệu</span>
                                    <span><i class="bi bi-clock-history me-1 text-warning"></i>Hạn nộp:
                                        15/09/2026</span>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-semibold w-100">Ứng
                                    tuyển ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Job 3 -->
                    <div class="card mb-4 border-0 shadow-sm job-card">
                        <div
                            class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h5 class="fw-bold mb-2">
                                    <a href="#" class="text-decoration-none text-dark job-title">Nhân viên Kho bãi (Kiểm
                                        đếm)</a>
                                    <span class="badge bg-danger ms-2">Gấp</span>
                                </h5>
                                <div class="d-flex flex-wrap gap-3 text-muted font-14">
                                    <span><i class="bi bi-geo-alt me-1 text-danger"></i>Quảng Châu, TQ</span>
                                    <span><i class="bi bi-currency-dollar me-1 text-success"></i>Thỏa thuận</span>
                                    <span><i class="bi bi-clock-history me-1 text-warning"></i>Hạn nộp:
                                        10/09/2026</span>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-semibold w-100">Ứng
                                    tuyển ngay</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- CỘT PHẢI: SIDEBAR (3 CỘT) -->
                <div class="col-12 col-lg-3">

                    <!-- Liên hệ Bộ phận Nhân sự -->
                    <div class="bg-white p-4 border shadow-sm rounded mb-4 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('images/hr-avatar.png') }}" alt="HR"
                                class="rounded-circle border border-3 border-light shadow-sm" width="80" height="80"
                                onerror="this.src='https://ui-avatars.com/api/?name=HR&background=0b3a68&color=fff'">
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Bộ phận Tuyển dụng</h6>
                        <p class="text-muted font-12 mb-3">Sẵn sàng giải đáp thắc mắc</p>

                        <div class="d-grid gap-2 font-14 text-start">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-telephone-fill text-success me-2"></i> 0987.654.321 (Zalo)
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope-fill text-danger me-2"></i> hr@htkk360.com
                            </div>
                        </div>
                    </div>

                    <!-- Quy trình ứng tuyển -->
                    <div class="bg-white p-4 border shadow-sm rounded">
                        <h6 class="fw-bold text-uppercase mb-4" style="color: #0b3a68;">Quy trình ứng tuyển</h6>

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 30px; height: 30px; flex-shrink: 0;">1</div>
                            <div>
                                <p class="mb-1 fw-semibold font-14 text-dark">Nộp hồ sơ (CV)</p>
                                <p class="text-muted font-12 mb-0">Qua Email hoặc Form trực tuyến</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-light text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 30px; height: 30px; flex-shrink: 0;">2</div>
                            <div>
                                <p class="mb-1 fw-semibold font-14 text-dark">Phỏng vấn</p>
                                <p class="text-muted font-12 mb-0">Trao đổi trực tiếp với Trưởng bộ phận</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="bg-light text-success fw-bold rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 30px; height: 30px; flex-shrink: 0;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-semibold font-14 text-dark">Nhận việc</p>
                                <p class="text-muted font-12 mb-0">Thỏa thuận lương và ký hợp đồng</p>
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