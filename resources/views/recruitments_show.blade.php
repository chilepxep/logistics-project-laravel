<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Tuyển dụng HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    @vite(['resources/css/recuitment.css'])
</head>

<body class="bg-light">
    @include('layouts.header')

    <div class="bg-white py-2 border-bottom mb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-dark">Trang
                            chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tuyen-dung') }}"
                            class="text-decoration-none text-dark">Tuyển dụng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $job->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="pb-5">
        <div class="container">
            <div class="row g-4">
                <!-- NỘI DUNG CHI TIẾT -->
                <div class="col-12 col-lg-8">
                    <div class="bg-white p-4 border shadow-sm rounded mb-4">
                        <h3 class="fw-bold mb-3" style="color: #0b3a68;">{{ $job->title }}</h3>
                        <div class="d-flex flex-wrap gap-4 text-muted mb-4 pb-4 border-bottom">
                            <span><i class="bi bi-geo-alt me-1 text-danger"></i>Khu vực:
                                <strong>{{ $job->location }}</strong></span>
                            <span><i class="bi bi-currency-dollar me-1 text-success"></i>Mức lương:
                                <strong>{{ $job->salary }}</strong></span>
                            <span><i class="bi bi-clock-history me-1 text-warning"></i>Hạn nộp:
                                <strong>{{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Không giới hạn' }}</strong></span>
                        </div>

                        @if($job->description)
                        <h5 class="fw-bold mb-3">Mô tả công việc</h5>
                        <div class="mb-4">{!! $job->description !!}</div>
                        @endif

                        @if($job->requirements)
                        <h5 class="fw-bold mb-3">Yêu cầu ứng viên</h5>
                        <div class="mb-4">{!! $job->requirements !!}</div>
                        @endif


                        <div class="text-center mt-5">
                            <button type="button" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold"
                                style="background-color: #0b3a68;" data-bs-toggle="modal" data-bs-target="#applyModal">
                                NỘP HỒ SƠ ỨNG TUYỂN NGAY
                            </button>
                        </div>



                    </div>
                </div>

                <!-- SIDEBAR LIÊN HỆ HR -->
                <div class="col-12 col-lg-4">
                    <div class="bg-white p-4 border shadow-sm rounded text-center position-sticky" style="top: 20px;">
                        <h6 class="fw-bold text-dark mb-3">Bộ phận Tuyển dụng HTKK</h6>
                        <p class="text-muted font-14 mb-4">Sẵn sàng hỗ trợ và giải đáp thắc mắc của bạn về vị trí này.
                        </p>
                        <div class="d-grid gap-3 text-start">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <i class="bi bi-telephone-fill text-success fs-4 me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Hotline/Zalo</small>
                                    <strong>0987.654.321</strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <i class="bi bi-envelope-fill text-danger fs-4 me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Email nhận CV</small>
                                    <strong>hr@htkk360.com</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('layouts.footer')
    <div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold text-dark">Hướng dẫn ứng tuyển</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-envelope-paper text-primary mb-3 d-block" style="font-size: 3rem;"></i>
                    <p class="mb-0 fs-6">Vui lòng gửi <strong>CV</strong> và <strong>thư giới
                            thiệu</strong> về địa chỉ email:</p>
                    <h5 class="text-danger fw-bold mt-2 mb-0">hr@htkk360.com</h5>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Đã
                        hiểu</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>