<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - HTKK Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #f4f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    /* SIDEBAR */
    .admin-sidebar {
        width: 260px;
        height: 100vh;
        background-color: #1e293b;
        position: fixed;
        top: 0;
        left: 0;
        color: #fff;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
    }

    .sidebar-brand {
        padding: 20px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        letter-spacing: 1px;
    }

    .sidebar-menu {
        flex-grow: 1;
        padding: 20px 0;
        overflow-y: auto;
    }

    .sidebar-menu .nav-link {
        color: #94a3b8;
        padding: 12px 25px;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }

    .sidebar-menu .nav-link i {
        font-size: 18px;
        margin-right: 12px;
    }

    .sidebar-menu .nav-link:hover,
    .sidebar-menu .nav-link.active {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.05);
        border-left: 4px solid #3b82f6;
    }

    /* MAIN CONTENT & TOPBAR */
    .main-wrapper {
        margin-left: 260px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .admin-topbar {
        height: 70px;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .content-area {
        padding: 30px;
        flex-grow: 1;
    }
    </style>
    @stack('styles')
</head>

<body>

    <!-- 1. SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand text-primary">
            <i class="bi bi-box-seam me-2"></i> HTKK ADMIN
        </div>

        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Tổng quan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt"></i> Đơn mua hộ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.consignment_orders.index') }}">
                        <i class="bi bi-box-seam-fill"></i> Đơn ký gửi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customers.index') }}">
                        <i class="bi bi-people-fill"></i> Khách hàng
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.complaints.index') }}">
                        <i class="bi bi-shield-exclamation"></i> Khiếu nại
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.packages.index') }}">
                        <i class="bi bi-box-seam"></i> Kiện hàng
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.suppliers.index') }}">
                        <i class="bi bi-person-workspace"></i> Nhà cung cấp
                    </a>
                </li>
                <!-- MENU CHỈ DÀNH CHO ADMIN -->
                @if(Auth::guard('employee')->user()->vai_tro === 'admin')
                <li class="nav-item mt-3">
                    <span class="nav-link  text-warning fw-bold"
                        style="font-size: 11px; text-transform: uppercase;">Quản
                        trị hệ thống</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
                        href="{{ route('admin.employees.index') }}">
                        <i class="bi bi-person-badge"></i> Quản lý Nhân sự
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <div class="mt-auto p-3 border-top border-secondary border-opacity-25">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 border-0 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <!-- 2. KHU VỰC BÊN PHẢI -->
    <div class="main-wrapper">

        <!-- TOPBAR -->
        <header class="admin-topbar">
            <div>
                <h5 class="m-0 fw-bold text-dark">@yield('page_title', 'Bảng điều khiển')</h5>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="text-muted font-14">
                    <i class="bi bi-calendar-event me-1"></i> {{ date('d/m/Y') }}
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                            style="width: 35px; height: 35px;">
                            <i class="bi bi-person"></i>
                        </div>
                        <span
                            class="fw-semibold font-14">{{ Auth::guard('employee')->user()->ho_ten ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item font-14" href="#"><i class="bi bi-person-gear me-2"></i>Hồ sơ cá
                                nhân</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item font-14 text-danger"><i
                                        class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- CONTENT AREA (Nơi hiển thị nội dung từng trang) -->
        <main class="content-area">

            <!-- HIỂN THỊ THÔNG BÁO THÀNH CÔNG -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <strong>Thành công!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- HIỂN THỊ THÔNG BÁO LỖI -->
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lỗi:</strong> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>