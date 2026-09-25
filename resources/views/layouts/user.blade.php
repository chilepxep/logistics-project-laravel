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

    <style>
    .zalo-floating-button {
        position: fixed;
        bottom: 20px;
        /* Cách mép dưới 20px */
        right: 50px;
        /* Cách mép phải 20px */
        width: 60px;
        height: 60px;
        z-index: 9999;
        /* Đảm bảo nút luôn nổi lên trên cùng */
        transition: transform 0.3s ease;
    }

    .zalo-floating-button img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .zalo-floating-button:hover {
        transform: scale(1.1);
        /* Phóng to nhẹ khi di chuột */
    }

    .fb-floating-button {
        position: fixed;
        bottom: 90px;
        /* Nằm cao hơn nút Zalo 70px để không bị đè */
        right: 50px;
        width: 60px;
        height: 60px;
        z-index: 9999;
        transition: transform 0.3s ease;
    }

    .fb-floating-button img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .fb-floating-button:hover {
        transform: scale(1.1);
    }
    </style>
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


    <a href="zalo://conversation?phone=0333661149" class="zalo-floating-button">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg?utm_source=vi.wikipedia.org&utm_campaign=index&utm_content=original"
            alt="Chat Zalo">
    </a>

    <a href="https://m.me/61560371098779" target="_blank" class="fb-floating-button">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png?utm_source=vi.wikipedia.org&utm_campaign=index&utm_content=original"
            alt="Chat Facebook">
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>