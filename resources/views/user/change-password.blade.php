@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0 text-primary">
            <i class="bi bi-shield-lock-fill me-2"></i> Thay đổi mật khẩu
        </h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger shadow-sm border-0">
                <ul class="mb-0">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            @endif

            <div class="card shadow-sm border-0 rounded-3 mt-2">
                <div class="card-header bg-white border-bottom pt-3 pb-2 text-center">
                    <h5 class="fw-bold text-dark mb-0">Cập nhật mã bảo mật</h5>
                    <p class="text-muted font-13 mt-1 mb-1">Vui lòng không chia sẻ mật khẩu cho bất kỳ ai</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Mật khẩu hiện tại <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-unlock"></i></span>
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Nhập mật khẩu đang sử dụng..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">Mật khẩu mới <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-primary"><i class="bi bi-key"></i></span>
                                <input type="password" name="new_password" class="form-control border-primary"
                                    placeholder="Tối thiểu 6 ký tự" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-primary">Xác nhận mật khẩu mới <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-primary"><i
                                        class="bi bi-check-circle"></i></span>
                                <!-- Tên field bắt buộc phải là tên_trường_mới + _confirmation -->
                                <input type="password" name="new_password_confirmation"
                                    class="form-control border-primary" placeholder="Nhập lại mật khẩu mới" required>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-5 py-2 shadow-sm w-100">
                                <i class="bi bi-shield-check me-2"></i> XÁC NHẬN ĐỔI MẬT KHẨU
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-muted font-13">
                <i class="bi bi-info-circle me-1"></i> Mật khẩu nên bao gồm chữ cái, số và ký tự đặc biệt để đảm bảo an
                toàn.
            </div>

        </div>
    </div>
</div>

@endsection