<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cước vận chuyển - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
</head>

<body class="bg-light">

    <!-- 1. HEADER -->
    @include('layouts.header')

    <!-- 2. BREADCRUMB -->
    <div class="bg-white py-2 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tra cước</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- 3. NỘI DUNG CHÍNH (FORM TRA CƯỚC) -->
    <section class="pb-5">
        <div class="container">
            <!-- Khối bọc toàn bộ nội dung (chiếm 12 cột trên mobile, 10 cột trên PC và căn giữa) -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">

                    <!-- Tiêu đề màu xanh -->
                    <div class="p-3 mb-3 text-white fs-5 text-uppercase" style="background-color: #0b3a68;">
                        Tra cước vận chuyển ước tính
                    </div>

                    <!-- Khối chứa Form và Bảng (Nền xanh) -->
                    <div class="p-3 p-md-4" style="background-color: #0b3a68;">

                        <!-- Khu vực Form nhập liệu -->
                        <div class="row g-2 mb-3">
                            <!-- Nơi gửi hàng -->
                            <div class="col-12 col-md-2">
                                <select class="form-select rounded-pill shadow-none form-control-sm">
                                    <option selected>Nơi gửi hàng</option>
                                    <option value="1">Hà Nội</option>
                                    <option value="2">Quảng Châu</option>
                                </select>
                            </div>

                            <!-- Nơi nhận hàng -->
                            <div class="col-12 col-md-2">
                                <select class="form-select rounded-pill shadow-none form-control-sm">
                                    <option selected>Nơi nhận hàng</option>
                                    <option value="1">TP. HCM</option>
                                    <option value="2">Hà Nội</option>
                                </select>
                            </div>

                            <!-- Chiều dài -->
                            <div class="col-12 col-md-2">
                                <div class="input-group input-group-sm rounded-pill overflow-hidden bg-white">
                                    <input type="number" class="form-control border-0 shadow-none"
                                        placeholder="Chiều dài">
                                    <span class="input-group-text border-0 bg-white text-muted">cm</span>
                                </div>
                            </div>

                            <!-- Chiều rộng -->
                            <div class="col-12 col-md-3">
                                <div class="input-group input-group-sm rounded-pill overflow-hidden bg-white">
                                    <input type="number" class="form-control border-0 shadow-none"
                                        placeholder="Chiều rộng">
                                    <span class="input-group-text border-0 bg-white text-muted">cm</span>
                                </div>
                            </div>

                            <!-- Chiều cao -->
                            <div class="col-12 col-md-3">
                                <div class="input-group input-group-sm rounded-pill overflow-hidden bg-white">
                                    <input type="number" class="form-control border-0 shadow-none"
                                        placeholder="Chiều cao">
                                    <span class="input-group-text border-0 bg-white text-muted">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- Trọng lượng thực tế (Nằm ở dòng 2) -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="input-group input-group-sm rounded-pill overflow-hidden bg-white">
                                    <input type="number" class="form-control border-0 shadow-none text-center"
                                        placeholder="Trọng lượng thực tế">
                                    <span class="input-group-text border-0 bg-white text-muted">kg</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bảng Kết Quả -->
                        <div class="table-responsive bg-white">
                            <table class="table table-bordered mb-0 align-middle">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-muted fw-normal" style="width: 30%;">Loại dịch vụ</th>
                                        <th class="text-muted fw-normal" style="width: 35%;">Phí vận chuyển</th>
                                        <th class="text-muted fw-normal">Thời gian nhận hàng dự kiến</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Vận chuyển đường bộ</td>
                                        <td></td>
                                        <td>3-5 ngày</td>
                                    </tr>
                                    <tr>
                                        <td>Vận chuyển đường sắt</td>
                                        <td></td>
                                        <td>4-7 ngày</td>
                                    </tr>
                                    <tr>
                                        <td>Vận chuyển đường không</td>
                                        <td></td>
                                        <td>3 ngày</td>
                                    </tr>
                                    <tr>
                                        <td>Vận chuyển đường thủy</td>
                                        <td></td>
                                        <td>15 ngày</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- Kết thúc khối nền xanh -->

                </div>
            </div>
        </div>
    </section>

    <!-- 4. FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>