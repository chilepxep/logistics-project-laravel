<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không tìm thấy trang - HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div class="text-center p-5 bg-white shadow-sm rounded-4" style="max-width: 500px;">
        <h1 class="display-1 fw-bold mb-0" style="color: #6c757d;">404</h1>
        <h3 class="mb-3 text-dark fw-bold">Không tìm thấy nội dung!</h3>
        <p class="text-muted mb-4" style="line-height: 1.6;">
            Trang bạn đang cố truy cập không tồn tại, đường dẫn bị sai hoặc nội dung đã được gỡ bỏ khỏi hệ thống.<br>
            <strong>Vui lòng kiểm tra lại đường dẫn.</strong>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <button onclick="window.history.back()"
                class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold text-white">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </button>
            <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold border-0"
                style="background-color: #0b3a68;">
                <i class="bi bi-house me-1"></i> Về trang chủ
            </a>
        </div>
    </div>
</body>

</html>