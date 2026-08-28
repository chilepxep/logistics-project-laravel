@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')



<div class="container-fluid mt-4 px-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- HEADER -->
            <div class="text-center mb-4">
                <i class="bi bi-envelope-paper-heart" style="font-size: 3rem; color: #4f46e5;"></i>
                <h2 class="text-uppercase fw-bold mt-2" style="color: #4f46e5;">Hòm Thư Góp Ý</h2>
                <p class="text-muted font-15 px-md-5 mt-2">
                    Tại <strong>HTKK LOGISTICS</strong>, chúng tôi đánh giá sự hài lòng của khách hàng là ưu tiên hàng
                    đầu. Chúng tôi cam kết đảm bảo bạn hài lòng với dịch vụ của chúng tôi. Bạn vui lòng dành chút thời
                    gian để giúp chúng tôi cải thiện trải nghiệm của bạn.
                </p>
            </div>

            <!-- FORM GÓP Ý -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form id="feedbackForm">

                        <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">
                            <i class="bi bi-star-fill text-warning me-2"></i> Đánh giá chất lượng dịch vụ
                        </h5>

                        <div class="d-flex justify-content-between mb-2 text-muted font-12 fw-semibold px-2">
                            <span>1: Rất tệ</span>
                            <span>5: Tuyệt vời</span>
                        </div>

                        <!-- 1. Dịch vụ đặt hàng -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Mức độ hài lòng về dịch vụ đặt hàng <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between px-2 gap-2">
                                @for($i = 1; $i <= 5; $i++) <input type="radio" class="btn-check" name="rating_dat_hang"
                                    id="dat_hang_{{$i}}" value="{{$i}}" required>
                                    <label
                                        class="btn btn-outline-primary rounded-circle fw-bold d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;" for="dat_hang_{{$i}}">{{$i}}</label>
                                    @endfor
                            </div>
                        </div>

                        <!-- 2. Dịch vụ chăm sóc khách hàng -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Mức độ hài lòng về dịch vụ chăm sóc khách hàng
                                <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between px-2 gap-2">
                                @for($i = 1; $i <= 5; $i++) <input type="radio" class="btn-check" name="rating_cskh"
                                    id="cskh_{{$i}}" value="{{$i}}" required>
                                    <label
                                        class="btn btn-outline-primary rounded-circle fw-bold d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;" for="cskh_{{$i}}">{{$i}}</label>
                                    @endfor
                            </div>
                        </div>

                        <!-- 3. Dịch vụ lễ tân -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Mức độ hài lòng về dịch vụ lễ tân <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between px-2 gap-2">
                                @for($i = 1; $i <= 5; $i++) <input type="radio" class="btn-check" name="rating_le_tan"
                                    id="le_tan_{{$i}}" value="{{$i}}" required>
                                    <label
                                        class="btn btn-outline-primary rounded-circle fw-bold d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;" for="le_tan_{{$i}}">{{$i}}</label>
                                    @endfor
                            </div>
                        </div>

                        <!-- 4. Dịch vụ giao hàng -->
                        <div class="mb-5">
                            <label class="form-label fw-semibold mb-3">Mức độ hài lòng về dịch vụ giao hàng <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between px-2 gap-2">
                                @for($i = 1; $i <= 5; $i++) <input type="radio" class="btn-check"
                                    name="rating_giao_hang" id="giao_hang_{{$i}}" value="{{$i}}" required>
                                    <label
                                        class="btn btn-outline-primary rounded-circle fw-bold d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;" for="giao_hang_{{$i}}">{{$i}}</label>
                                    @endfor
                            </div>
                        </div>

                        <!-- THÔNG TIN KHÁCH HÀNG -->
                        <h5 class="fw-bold text-dark mt-5 mb-4 border-bottom pb-2">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i> Về Bạn
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-14 text-muted">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Nhập tên của bạn...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-14 text-muted">Số điện thoại</label>
                                <input type="text" class="form-control"
                                    placeholder="Để chúng tôi có thể liên hệ lại...">
                            </div>
                            <div class="col-12">
                                <label class="form-label font-14 text-muted">Đóng góp ý kiến chi tiết</label>
                                <textarea class="form-control" rows="4"
                                    placeholder="Hãy cho chúng tôi biết chúng tôi có thể làm tốt hơn ở điểm nào..."></textarea>
                            </div>
                        </div>

                        <!-- NÚT GỬI -->
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-lg text-white fw-bold px-5 py-3 shadow"
                                style="background-color: #4f46e5; border-radius: 50px;">
                                <i class="bi bi-send me-2"></i> GỬI Ý KIẾN ĐÁNH GIÁ
                            </button>
                            <div class="text-success mt-3 font-15 fw-semibold d-none" id="thankYouText">
                                <i class="bi bi-heart-fill text-danger"></i> Cảm ơn bạn đã dành thời gian !
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 cho hiệu ứng gửi thành công (Web tĩnh) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    // Ngăn chặn form submit thật (vì web không lưu Database)
    e.preventDefault();

    // Hiện popup cảm ơn mượt mà
    Swal.fire({
        title: 'Gửi góp ý thành công!',
        text: 'Cảm ơn bạn đã dành thời gian. HTKK Logistics vô cùng trân trọng đóng góp của bạn!',
        icon: 'success',
        confirmButtonText: 'Đóng',
        confirmButtonColor: '#4f46e5'
    }).then((result) => {
        if (result.isConfirmed) {
            // Reset form và hiện dòng chữ Cảm ơn nhỏ ở dưới nút
            document.getElementById('feedbackForm').reset();
            document.getElementById('thankYouText').classList.remove('d-none');
        }
    });
});
</script>

<style>
/* CSS Tùy chỉnh màu sắc khi chọn Radio Button */
.btn-outline-primary {
    border-color: #cbd5e1;
    color: #64748b;
}

.btn-check:checked+.btn-outline-primary {
    background-color: #4f46e5 !important;
    border-color: #4f46e5 !important;
    color: white !important;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.4);
}

.btn-outline-primary:hover {
    background-color: #e0e7ff;
    color: #4f46e5;
    border-color: #4f46e5;
}
</style>


@endsection