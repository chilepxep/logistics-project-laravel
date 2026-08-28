    <nav class="navbar navbar-expand-lg top-navbar px-3 shadow-sm" style="background-color: #0b3a68;">
        <div class="container-fluid">

            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="navbar-brand">
                <img src="{{ asset('images/logo_3.png') }}" class="img-fluid logo" alt="HTKK 360">
            </a>

            <!-- Button mobile -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-list text-white fs-2"></i>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="userNavbar">

                <div class="d-flex align-items-center text-white font-14 ms-auto user-menu">

                    <!-- Số dư -->
                    <span class="me-4 balance">
                        Số dư:
                        <strong class="text-warning fs-6">
                            {{ number_format(Auth::user()->so_du ?? 0, 0, ',', '.') }}đ
                        </strong>
                        <i class="bi bi-wallet2 text-warning ms-1"></i>
                    </span>

                    <!-- Giỏ hàng -->
                    <a href="{{ route('order.all') }}"
                        class="text-white text-decoration-none me-3 position-relative nav-icon">
                        <i class="bi bi-cart3 fs-5"></i>

                        <!-- Chỉ hiển thị số lượng khi người dùng đã đăng nhập -->
                        @auth
                        @php
                        // Đếm tổng số đơn mua hộ và đơn ký gửi của user hiện tại
                        $userId = Auth::id();
                        $tongDon = \App\Models\Order::where('user_id', $userId)->count()
                        + \App\Models\ConsignmentOrder::where('user_id', $userId)->count();
                        @endphp

                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $tongDon > 99 ? '99+' : $tongDon }}
                        </span>
                        @else
                        <!-- Nếu chưa đăng nhập thì hiện 0 -->
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                        @endauth
                    </a>
                    <!-- Email -->
                    <a href="{{ route('feedback.index') }}" class="text-white text-decoration-none me-3 nav-icon">
                        <i class="bi bi-envelope fs-5"></i>
                    </a>

                    <!-- Nút chuông thông báo -->
                    <div class="dropdown">
                        <a href="#" class="text-white text-decoration-none me-3 position-relative nav-icon"
                            id="bellDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <i class="bi bi-bell fs-5"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                7
                            </span>
                        </a>

                        <!-- Khối Dropdown Menu -->
                        <div class="dropdown-menu dropdown-menu-end border-0 notif-dropdown"
                            aria-labelledby="bellDropdown">

                            <!-- Header -->
                            <div class="bg-white text-center fw-bold py-2 border-bottom font-14"
                                style="color: #0b3a68;">
                                THÔNG BÁO MỚI
                            </div>

                            <!-- Body: Chia 2 cột -->
                            <div class="d-flex">

                                <!-- Cột trái: Sidebar Tabs -->
                                <div class="nav flex-column notif-sidebar" id="notif-tabs" role="tablist"
                                    aria-orientation="vertical">
                                    <!-- Tab 1: Hệ thống (Ngôi sao) -->
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#notif-star"
                                        type="button" role="tab">
                                        <i class="bi bi-star"></i>
                                        <span class="badge bg-danger rounded-pill badge-count text-white">8</span>
                                    </button>
                                    <!-- Tab 2: Tài chính ($) -->
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notif-money"
                                        type="button" role="tab">
                                        <i class="bi bi-currency-dollar"></i>
                                        <span class="badge bg-danger rounded-pill badge-count text-white">2</span>
                                    </button>
                                    <!-- Tab 3: Kiện hàng (Hộp) -->
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notif-box"
                                        type="button" role="tab">
                                        <i class="bi bi-box-seam"></i>
                                    </button>
                                    <!-- Tab 4: Khiếu nại (Mặt buồn) -->
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notif-sad"
                                        type="button" role="tab">
                                        <i class="bi bi-emoji-frown"></i>
                                    </button>
                                    <!-- Tab 5: Tin nhắn (Chat) -->
                                    <button class="nav-link border-bottom-0" data-bs-toggle="pill"
                                        data-bs-target="#notif-chat" type="button" role="tab">
                                        <i class="bi bi-chat-dots"></i>
                                    </button>
                                </div>

                                <!-- Cột phải: Nội dung Thông báo -->
                                <div class="tab-content flex-grow-1 notif-content" id="notif-tabContent">

                                    <!-- Nội dung Tab 1 (Ngôi sao) -->
                                    <div class="tab-pane fade show active" id="notif-star" role="tabpanel">
                                        <a href="#" class="text-decoration-none d-block notif-item unread">
                                            <div class="notif-text">Chương trình tri ân khách hàng HTKK tháng 10.2023
                                            </div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> 2 giờ trước</div>
                                        </a>
                                        <a href="#" class="text-decoration-none d-block notif-item unread">
                                            <div class="notif-text">Cập nhật bảng giá dịch vụ mới nhất tại HTKK áp dụng
                                                từ ngày 27/10/2023</div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> Hôm qua, 14:30
                                            </div>
                                        </a>
                                        <a href="#" class="text-decoration-none d-block notif-item">
                                            <div class="notif-text">Ưu đãi đặc biệt chào đón ngày lễ mua sắm lớn nhất
                                                năm 11.11.2023</div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> 10/10/2023</div>
                                        </a>
                                        <a href="#" class="text-decoration-none d-block notif-item">
                                            <div class="notif-text">Điều chỉnh tỷ giá tệ từ 8:00 PM ngày 23.11.2023
                                            </div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> 09/10/2023</div>
                                        </a>
                                        <a href="#" class="text-decoration-none d-block notif-item">
                                            <div class="notif-text">Hướng dẫn sử dụng hệ thống phiên bản mới</div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> 05/10/2023</div>
                                        </a>
                                    </div>

                                    <!-- Nội dung Tab 2 (Tài chính) -->
                                    <div class="tab-pane fade" id="notif-money" role="tabpanel">
                                        <a href="#" class="text-decoration-none d-block notif-item unread">
                                            <div class="notif-text">Tài khoản của bạn vừa được cộng +1.000.000đ từ lệnh
                                                nạp tiền.</div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> Vài giây trước
                                            </div>
                                        </a>
                                        <a href="#" class="text-decoration-none d-block notif-item">
                                            <div class="notif-text">Thanh toán thành công đơn hàng #DH123456. Số dư bị
                                                trừ: -500.000đ.</div>
                                            <div class="notif-time"><i class="bi bi-clock me-1"></i> 2 ngày trước</div>
                                        </a>
                                    </div>

                                    <!-- Các Tab khác (Trống) -->
                                    <div class="tab-pane fade" id="notif-box" role="tabpanel">
                                        <div class="text-center p-4 text-muted mt-5">
                                            <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-50"></i>
                                            Chưa có thông báo về kiện hàng.
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="notif-sad" role="tabpanel">
                                        <div class="text-center p-4 text-muted mt-5">
                                            <i class="bi bi-check-circle fs-1 d-block mb-2 text-success opacity-50"></i>
                                            Không có khiếu nại nào cần xử lý.
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="notif-chat" role="tabpanel">
                                        <div class="text-center p-4 text-muted mt-5">
                                            <i class="bi bi-chat-dots fs-1 d-block mb-2 opacity-50"></i>
                                            Chưa có tin nhắn mới.
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="bg-light text-center border-top p-2">
                                <a href="#" class="text-decoration-none fw-bold"
                                    style="color: #0b3a68; font-size: 14px;">Xem tất cả</a>
                            </div>

                        </div>
                    </div>

                    <!-- Avatar -->
                    <div class="dropdown">

                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->ho_ten ?? 'User') }}&background=ff6a00&color=fff"
                                alt="Avatar" width="36" height="36" class="rounded-circle">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow">

                            <li>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i>
                                    Hồ sơ
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Đăng xuất
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>
    </nav>