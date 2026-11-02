@extends('layouts.admin')
@section('title', 'Quản lý Thông báo')
@section('page_title', 'Sửa Thông báo')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold">Chỉnh Sửa Thông Báo</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="fw-bold mb-1">Tiêu đề thông báo</label>
                        <input type="text" name="title" class="form-control" value="{{ $notification->title }}"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold mb-1">Loại thông báo</label>
                        <select name="type" class="form-select">
                            <option value="system" {{ $notification->type == 'system' ? 'selected' : '' }}>Thông báo hệ
                                thống</option>
                            <option value="promotion" {{ $notification->type == 'promotion' ? 'selected' : '' }}>Chương
                                trình khuyến mãi</option>
                            <option value="price" {{ $notification->type == 'price' ? 'selected' : '' }}>Cập nhật giá/Tỷ
                                giá</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold mb-1">Nội dung chi tiết</label>
                    <textarea name="content" id="editor" class="form-control">{{ $notification->content }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary me-2">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Copy nguyên đoạn Script TinyMCE (giống hệt bên file create.blade.php) và dán vào đây -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    tinymce.init({
        selector: '#editor',
        height: 600,
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking table emoticons template help',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | forecolor backcolor emoticons | fullscreen preview code',
        promotion: false,

        // Trỏ về Route của Thông báo
        images_upload_url: "{{ route('admin.notifications.upload_image') }}",
        automatic_uploads: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        content_css: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',

        images_upload_handler: function(blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "{{ route('admin.notifications.upload_image') }}");
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.onload = function() {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    resolve(json.location);
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