<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống - HTKK Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #f1f5f9;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .login-sidebar {
        background-color: #1e293b;
        color: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card login-card row flex-row">
                    <!-- Cột trái: Branding -->
                    <div class="col-md-5 login-sidebar d-none d-md-flex">
                        <h2 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i> HTKK ADMIN</h2>
                        <p class="text-white-50 font-14">Hệ thống quản trị nội bộ dành riêng cho nhân viên điều phối, kế
                            toán và CSKH.</p>
                    </div>

                    <!-- Cột phải: Form -->
                    <div class="col-md-7 p-5 bg-white">
                        <h4 class="fw-bold text-dark mb-1">Đăng nhập</h4>
                        <p class="text-muted mb-4 font-14">Vui lòng nhập thông tin tài khoản nhân viên</p>

                        @if($errors->any())
                        <div class="alert alert-danger py-2 font-14">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold font-14">Email nội bộ</label>
                                <input type="email" name="email" class="form-control" placeholder="nhanvien@htkk.com"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold font-14">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••"
                                    required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label font-14 text-muted" for="remember">Ghi nhớ
                                        tôi</label>
                                </div>
                            </div>
                            <button type="submit" class="btn w-100 fw-bold text-white py-2"
                                style="background-color: #1e293b;">
                                ĐĂNG NHẬP VÀO HỆ THỐNG
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>