<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    @include('layouts.header')

    <section class="py-5 flex-grow-1 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="p-4 text-white text-center" style="background-color: #0b3a68;">
                            <h4 class="fw-bold mb-1">ĐĂNG NHẬP</h4>
                            <p class="font-12 text-warning mb-0">Hệ thống quản lý đơn hàng HTKK 360</p>
                        </div>
                        <div class="card-body p-4 p-md-5 bg-white">

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Địa chỉ Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control rounded-pill px-3 shadow-none @error('email') is-invalid @enderror"
                                        placeholder="name@example.com" required autofocus>
                                    @error('email') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Mật khẩu</label>
                                    <input type="password" name="password"
                                        class="form-control rounded-pill px-3 shadow-none @error('password') is-invalid @enderror"
                                        placeholder="Nhập mật khẩu" required>
                                    @error('password') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4 font-14">
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none" type="checkbox" name="remember"
                                            id="remember">
                                        <label class="form-check-label text-muted" for="remember">Ghi nhớ</label>
                                    </div>
                                    <a href="#" class="text-decoration-none text-muted">Quên mật khẩu?</a>
                                </div>

                                <button type="submit" class="btn w-100 rounded-pill text-white fw-bold py-2 hover-lift"
                                    style="background-color: #ff6a00;">
                                    ĐĂNG NHẬP
                                </button>
                            </form>

                            <div class="text-center mt-4 font-14">
                                <span>Chưa có tài khoản? </span>
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none"
                                    style="color: #0b3a68;">Đăng ký ngay</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>