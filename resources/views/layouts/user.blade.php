<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý cá nhân') - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    @vite(['resources/css/dashboard.css'])
</head>

<body class="dashboard-body">

    <!-- Gọi Topbar vào đây -->
    @include('user.partials.topbar')

    <!-- MAIN LAYOUT -->
    <div class="d-flex main-wrapper">

        <!-- Gọi Sidebar vào đây -->
        @include('user.partials.sidebar')

        <!-- NỘI DUNG CHÍNH (Thay đổi theo từng trang) -->
        <main class="flex-grow-1 bg-light center-content">
            @yield('content')
        </main>

        <!-- SIDEBAR PHẢI (Nếu trang nào cần thì gọi yield, không thì thôi) -->
        @yield('right_sidebar')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>