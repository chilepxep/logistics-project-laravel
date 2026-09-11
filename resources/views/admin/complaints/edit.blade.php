@extends('layouts.admin')
@section('title', 'Xử lý Khiếu nại')
@section('page_title', 'Xử lý Khiếu nại #' . $complaint->id)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">


                <div class="col-md-6">
                    <label class="form-label fw-bold">Loại khiếu nại <span class="text-danger">*</span></label>
                    <select name="loai_khieu_nai" class="form-select" required>
                        <option value="don_hang_cham"
                            {{ $complaint->loai_khieu_nai == 'don_hang_cham' ? 'selected' : '' }}>Đơn hàng chậm</option>
                        <option value="thai_do_khong_tot"
                            {{ $complaint->loai_khieu_nai == 'thai_do_khong_tot' ? 'selected' : '' }}>Thái độ không tốt
                        </option>
                        <option value="sai_chi_phi" {{ $complaint->loai_khieu_nai == 'sai_chi_phi' ? 'selected' : '' }}>
                            Sai chi phí</option>
                        <option value="ship_cao" {{ $complaint->loai_khieu_nai == 'ship_cao' ? 'selected' : '' }}>Phí
                            ship cao</option>
                        <option value="hang_thieu" {{ $complaint->loai_khieu_nai == 'hang_thieu' ? 'selected' : '' }}>
                            Hàng thiếu</option>
                        <option value="hang_hu" {{ $complaint->loai_khieu_nai == 'hang_hu' ? 'selected' : '' }}>Hàng hư
                        </option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label fw-bold">Phân công Người xử lý</label>
                    <select name="nhan_vien_xu_ly_id" class="form-select">
                        <option value="">-- Chọn nhân viên --</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}"
                            {{ $complaint->nhan_vien_xu_ly_id == $emp->id ? 'selected' : '' }}>
                            {{ $emp->ho_ten }} ({{ $emp->ma_nv }})
                        </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label fw-bold">Trạng thái xử lý <span class="text-danger">*</span></label>
                    <select name="trang_thai" class="form-select" required>
                        <option value="cho_xu_ly" {{ $complaint->trang_thai == 'cho_xu_ly' ? 'selected' : '' }}>Chờ xử
                            lý</option>
                        <option value="da_xu_ly" {{ $complaint->trang_thai == 'da_xu_ly' ? 'selected' : '' }}>Đã xử lý
                        </option>
                        <option value="da_hoan_thanh" {{ $complaint->trang_thai == 'da_hoan_thanh' ? 'selected' : '' }}>
                            Đã hoàn thành</option>
                        <option value="da_huy" {{ $complaint->trang_thai == 'da_huy' ? 'selected' : '' }}>Đã huỷ
                        </option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label fw-bold">Phương án giải quyết</label>
                    <select name="phuong_an" class="form-select">
                        <option value="">-- Chưa có phương án --</option>
                        <option value="boi_thuong" {{ $complaint->phuong_an == 'boi_thuong' ? 'selected' : '' }}>Bồi
                            thường</option>
                        <option value="doi_tra" {{ $complaint->phuong_an == 'doi_tra' ? 'selected' : '' }}>Đổi trả
                        </option>
                    </select>
                </div>

            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-save me-2"></i> LƯU XỬ
                LÝ</button>
            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn btn-light ms-2">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection