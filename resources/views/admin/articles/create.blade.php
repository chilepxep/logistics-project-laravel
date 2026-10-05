@extends('layouts.admin')
@section('title', 'Quản Lý Bài Viết')
@section('page_title', 'Thêm Bài Viết Mới')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white fw-bold">
        THÊM BÀI VIẾT MỚI
    </div>
    <div class="card-body p-4">

        <form action="{{ route('admin.articles.store') }}" method="POST">
            @csrf

            <div class="row mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg" required
                        placeholder="Nhập tiêu đề...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Chuyên mục <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select form-select-lg" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung bài viết <span class="text-danger">*</span></label>
                <!-- Thẻ này sẽ được TinyMCE thay thế -->
                <textarea id="my-tinymce-editor" name="content"></textarea>
            </div>

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label fw-bold text-success">Kích hoạt (Hiển thị ngay)</label>
            </div>

            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save"></i> LƯU BÀI VIẾT</button>
        </form>
    </div>
</div>

<!-- Thư viện TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

<!-- Cấu hình TinyMCE -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    tinymce.init({
        selector: '#my-tinymce-editor',
        height: 600,
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table emoticons template help',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | forecolor backcolor emoticons | fullscreen preview code',

        // Tính năng Upload Ảnh
        images_upload_url: "{{ route('admin.articles.upload_image')}}",
        automatic_uploads: true,

        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,

        content_css: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',

        content_style: `
        body { font-family: Arial, sans-serif; font-size: 15px; }
        
        
        table { border-collapse: collapse !important; width: 100% !important; margin-bottom: 1.5rem !important; }
        table th, table td { border: 1px solid #adb5bd !important; padding: 10px !important; }
        
        
        table tr:first-child th, table tr:first-child td { background-color: #f8f9fa !important; font-weight: bold !important; }
    `,

        templates: [{
                title: 'Bảng so sánh Bảo hiểm',
                description: 'Tạo 2 cột so sánh chính sách có và không có bảo hiểm',
                content: `<div class="row g-4 mb-4"><div class="col-md-6"><div class="card h-100" style="border-color: #198754;"><div class="card-header text-white fw-bold" style="background-color: #198754;"> KHI CÓ BẢO HIỂM HÀNG HÓA</div><div class="card-body"><p>Bồi thường...</p></div></div></div><div class="col-md-6"><div class="card h-100" style="border-color: #6c757d;"><div class="card-header text-white fw-bold" style="background-color: #6c757d;"> KHI KHÔNG CÓ BẢO HIỂM</div><div class="card-body"><p>Bồi thường...</p></div></div></div></div><p>&nbsp;</p>`
            },
            {
                title: 'Khung cảnh báo (Màu vàng)',
                description: 'Khung lưu ý quan trọng',
                content: `<div class="alert alert-warning border-start border-warning border-5" role="alert"><strong>⚠️ QUY ĐỊNH BẮT BUỘC:</strong><br>Nhập nội dung lưu ý vào đây...</div><p>&nbsp;</p>`
            },
            {
                title: 'Khối Tin tức (Có ảnh bên trái)',
                description: 'Mẫu bài viết tin tức có ảnh, thẻ tag, tiêu đề và nút Đọc tiếp',
                content: `
            <div class="card border border-light shadow-sm mb-4 rounded-3 news-card" style="overflow: hidden;">
                <div class="row g-0 align-items-center">
                    <!-- Thêm overflow:hidden ở cột chứa ảnh để hiệu ứng zoom không bị tràn -->
                    <div class="col-md-4" style="overflow: hidden;">
                        <img src="https://via.placeholder.com/400x250" class="img-fluid news-thumbnail" alt="Ảnh tin tức" style="width: 100%; height: 100%; object-fit: cover; min-height: 250px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <span class="badge rounded-pill mb-3 px-3 py-2" style="background-color: #0b3a68;">Khuyến mãi</span>
                            <!-- Thêm class news-title -->
                            <h4 class="card-title fw-bold mb-3 news-title" style="color: #fd7e14;">Bùng nổ siêu sale 11/11 trên Taobao: Kinh nghiệm săn sale không thể bỏ lỡ</h4>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar3 me-1"></i> 10/08/2026 <span class="mx-2">|</span> <i class="bi bi-eye me-1"></i> 3,890 lượt xem
                            </p>
                            <!-- Thêm class news-excerpt để tự động cắt 3 dòng -->
                            <p class="card-text text-secondary mb-4 news-excerpt">Lễ hội mua sắm 11/11 (Ngày Độc thân) là đợt sale lớn nhất năm tại Trung Quốc. Bỏ túi ngay bí kíp tìm kiếm mã giảm giá, cách ghép đơn và lựa chọn shop uy tín để nhập hàng với giá vốn rẻ nhất...</p>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4" style="border-color: #0b3a68; color: #0b3a68;">Đọc tiếp &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>
            `
            },

            // TEMPLATE 4: DANH SÁCH VỊ TRÍ TUYỂN DỤNG
            {
                title: 'Danh sách Tuyển dụng',
                description: 'Mẫu danh sách các vị trí đang tuyển dụng kèm nút Ứng tuyển',
                content: `
            <div class="recruitment-section mb-5">
                
                
                <!-- Vị trí 1: Thêm class job-card -->
                <div class="card border mb-3 rounded-3 shadow-sm job-card">
                    <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <!-- Thêm class job-title -->
                            <h5 class="fw-bold mb-3 text-dark job-title">Nhân viên Kinh doanh Logistics (Sales)</h5>
                            <div class="d-flex flex-wrap gap-4 font-14">
                                <span style="color: #dc3545;"><i class="bi bi-geo-alt me-1"></i> Hà Nội</span>
                                <span style="color: #198754;"><i class="bi bi-currency-dollar me-1"></i> 10 - 20 Triệu</span>
                                <span style="color: #fd7e14;"><i class="bi bi-clock me-1"></i> Hạn nộp: 30/09/2026</span>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4 fw-semibold w-100">Ứng
                                    tuyển ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>
            `
            }
        ],

        images_upload_handler: function(blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "{{ route('admin.articles.upload_image')}}");

                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = function() {
                    if (xhr.status === 403) {
                        reject({
                            message: 'Lỗi bảo mật HTTP Error: ' + xhr.status,
                            remove: true
                        });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };

                xhr.onerror = function() {
                    reject('Image upload failed due to a XHR Transport error. Code: ' +
                        xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            });
        }
    });
});
</script>

@endsection