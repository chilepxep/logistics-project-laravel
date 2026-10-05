<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chính sách khiếu nại - HTKK 360</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Nhúng CSS qua Vite -->
    @vite(['resources/css/app.css'])
    @vite(['resources/css/order-china.css'])
    @vite(['resources/css/recuitment.css'])
    @vite(['resources/css/news.css'])

    <style>
    .service-content table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
        /* Reset border */
    }

    .service-content table th,
    .service-content table td {
        padding: 0.75rem;
        /* Padding cơ bản */
        border: none;
        /* Bỏ viền mặc định */
    }

    /* ÁP DỤNG CSS LÀM ĐẸP CHỈ CHO BẢNG CÓ NHIỀU HƠN 1 THẺ <tr> */
    .service-content table:has(tr:nth-child(2)) {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 8px !important;
        overflow: hidden;
        background-color: #fff;
        margin: 1.5rem 0;
    }

    /* Định dạng các ô (Cell) cho bảng nhiều dòng */
    .service-content table:has(tr:nth-child(2)) th,
    .service-content table:has(tr:nth-child(2)) td {
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        padding: 14px 16px;
        text-align: center !important;
        vertical-align: middle !important;
    }

    /* Ép màu xanh cho dòng Tiêu đề (dòng đầu tiên) của bảng nhiều dòng */
    .service-content table:has(tr:nth-child(2)) thead th,
    .service-content table:has(tr:nth-child(2)) tr:first-child th,
    .service-content table:has(tr:nth-child(2)) tr:first-child td {
        background-color: #0b3a68 !important;
        color: #ffffff !important;
        font-weight: bold;
    }

    /* Hiệu ứng hover màu cam cho bảng nhiều dòng */
    .service-content table:has(tr:nth-child(2)) tbody tr {
        transition: background-color 0.2s ease;
    }

    .service-content table:has(tr:nth-child(2)) tbody tr:hover td {
        background-color: #ff6a00 !important;
        color: #fff !important;
    }

    /* Bỏ hover màu cam ở Tiêu đề */
    .service-content table:has(tr:nth-child(2)) thead tr:hover th,
    .service-content table:has(tr:nth-child(2)) tr:first-child:hover td,
    .service-content table:has(tr:nth-child(2)) tr:first-child:hover th {
        background-color: #0b3a68 !important;
        color: #ffffff !important;
    }

    /* Bỏ viền thừa ở góc */
    .service-content table:has(tr:nth-child(2)) th:last-child,
    .service-content table:has(tr:nth-child(2)) td:last-child {
        border-right: none;
    }

    .service-content table:has(tr:nth-child(2)) tbody tr:last-child td,
    .service-content table:has(tr:nth-child(2)) tr:last-child td {
        border-bottom: none;
    }

    .service-content table:not(:has(tr:nth-child(2))) {
        border-radius: 4px;
        margin: 1.5rem 0;
        border-collapse: collapse;
    }

    /* Cấu trúc các ô bên trong bảng 1 dòng */
    .service-content table:not(:has(tr:nth-child(2))) td {
        padding: 1rem;
    }

    /* =========================================
   GIAO DIỆN MỤC LỤC 
========================================= */


    .toc-box {
        background-color: #f8f9fa !important;
        border: 1px solid #e3e6f0 !important;
        border-radius: 4px !important;
    }


    .toc-box p.fw-bold {
        font-size: 18px !important;
        color: #212529 !important;
        text-transform: none !important;
        border-bottom: none !important;
        margin-bottom: 12px !important;
    }


    .toc-box a {
        display: block;
        padding: 4px 0;
        line-height: 1.6;
        text-decoration: none !important;
        transition: opacity 0.2s;
    }

    .toc-box a:hover {
        opacity: 0.7;
    }

    /* =========================================
   PHÂN CẤP TIÊU ĐỀ
========================================= */


    .toc-box>ul>li>a {
        font-weight: normal !important;
        font-size: 15px !important;
        color: #0b3a68 !important;
    }


    .toc-box ul ul {
        margin-left: 20px !important;
        border-left: none !important;
        padding-left: 0 !important;
        margin-top: 4px !important;
        margin-bottom: 8px !important;
    }


    .toc-box ul ul a {
        font-weight: normal !important;
        font-size: 15px !important;
        color: #555555 !important;
    }
    </style>
</head>

<body>
    <!-- 1. HEADER -->
    @include('layouts.header')

    <!-- BREADCRUMB -->
    <div class="bg-light py-2 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <!-- Tên danh mục tự động khớp với bài viết -->
                    <li class="breadcrumb-item">
                        <a href="/{{ $category->slug }}"
                            class="text-decoration-none text-dark">{{ $category->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-4 bg-white">
        <div class="container">
            <div class="row g-4">
                <!-- CỘT TRÁI: NỘI DUNG BÀI VIẾT -->
                <div class="col-12 col-lg-9">
                    <div class="p-3 mb-4 text-white fw-bold text-uppercase rounded-top"
                        style="background-color: #0b3a68;">
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>{{ $article->title }}</h4>
                    </div>

                    <div class="article-body position-relative">
                        <!-- KHUNG MỤC LỤC TỰ ĐỘNG BẰNG TOCBOT -->
                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2 text-uppercase">Mục lục</p>
                            <div class="toc"></div> <!-- Tocbot sẽ tự vẽ 1.1, 1.2 vào đây -->
                        </div>


                        <div class="service-content mb-5 js-toc-content">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>



                <div class="col-12 col-lg-3">
                    <div class="p-2 mb-3 text-white fw-bold text-uppercase rounded-top"
                        style="background-color: #0b3a68;">
                        <i class="bi bi-star-fill me-1 text-warning"></i> Dịch vụ hot
                    </div>

                    <div class="list-group list-group-flush border rounded overflow-hidden">
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Nạp tiền Alipay giá rẻ
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Ký gửi hàng hóa Trung - Việt
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Bảng giá mua hộ Taobao
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.21.0/tocbot.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.21.0/tocbot.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {



        const contentArea = document.querySelector('.js-toc-content');
        const tocBox = document.querySelector('.toc-box');
        if (contentArea) {
            const headings = contentArea.querySelectorAll('h2, h3, h4');

            if (headings.length === 0) {
                if (tocBox) {
                    tocBox.style.display = 'none';
                }
                return;
            }

            headings.forEach(function(heading, index) {
                if (!heading.id) {
                    heading.id = 'muc-luc-' + index;
                }
            });
        }

        if (typeof tocbot !== 'undefined') {
            tocbot.init({
                tocSelector: '.toc',
                contentSelector: '.js-toc-content',
                headingSelector: 'h2, h3, h4',
                hasInnerContainers: true,
                scrollSmooth: true,
                scrollSmoothOffset: -100,
            });
        }
    });
    </script>
</body>