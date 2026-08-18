<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    @include('layouts.header')

    <section class="py-5 flex-grow-1 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="p-4 text-white text-center" style="background-color: #0b3a68;">
                            <h4 class="fw-bold mb-1">ĐĂNG KÝ TÀI KHOẢN</h4>
                            <p class="font-12 text-warning mb-0">Trở thành thành viên của HTKK 360 Logistics</p>
                        </div>
                        <div class="card-body p-4 p-md-5 bg-white">

                            <form action="{{ route('register') }}" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ho_ten" value="{{ old('ho_ten') }}"
                                        class="form-control rounded-pill px-3 shadow-none @error('ho_ten') is-invalid @enderror"
                                        placeholder="Nguyễn Văn A" required>
                                    @error('ho_ten') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Địa chỉ Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control rounded-pill px-3 shadow-none @error('email') is-invalid @enderror"
                                        placeholder="name@example.com" required>
                                    @error('email') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sdt" value="{{ old('sdt') }}"
                                        class="form-control rounded-pill px-3 shadow-none @error('sdt') is-invalid @enderror"
                                        required>
                                    @error('sdt') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold font-14">Mật khẩu <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control rounded-pill px-3 shadow-none @error('password') is-invalid @enderror"
                                        placeholder="Tối thiểu 6 ký tự" required>
                                    @error('password') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold font-14">Xác nhận mật khẩu <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control rounded-pill px-3 shadow-none"
                                        placeholder="Nhập lại mật khẩu" required>
                                </div>

                                <button type="submit" class="btn w-100 rounded-pill text-white fw-bold py-2 hover-lift"
                                    style="background-color: #ff6a00;">
                                    ĐĂNG KÝ NGAY
                                </button>
                            </form>

                            <div class="text-center mt-4 font-14">
                                <span>Đã có tài khoản? </span>
                                <a href="{{ route('login') }}" class="fw-bold text-decoration-none"
                                    style="color: #0b3a68;">Đăng nhập</a>
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