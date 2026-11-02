@extends('layouts.admin')
@section('title', 'Quản lý Thông báo')
@section('page_title', 'Chi tiết Thông báo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Chi tiết thông báo</h4>
        <div>
            <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning me-2"><i
                    class="bi bi-pencil"></i> Sửa</a>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary"><i
                    class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white p-4 border-bottom">
            <h3 class="fw-bold text-primary">{{ $notification->title }}</h3>
            <div class="text-muted mt-2">
                <i class="bi bi-clock"></i> Đăng lúc: {{ $notification->created_at->format('H:i d/m/Y') }}
                <span class="mx-2">|</span>
                <i class="bi bi-tags"></i> Loại:
                <span class="badge bg-info text-dark">{{ strtoupper($notification->type) }}</span>
            </div>
        </div>
        <div class="card-body p-4 bg-light">
            <div class="bg-white p-4 rounded border">
                {!! $notification->content !!}
            </div>
        </div>
    </div>
</div>

@endsection