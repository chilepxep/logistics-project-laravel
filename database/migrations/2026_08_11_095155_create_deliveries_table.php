<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('deliveries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
    $table->dateTime('ngay_tao')->useCurrent();
    $table->string('thong_tin_giao_hang', 255)->nullable();
    $table->string('ma_buu_dien', 50)->nullable();
    $table->string('ma_van_don', 50)->nullable();
    $table->string('ghi_chu', 255)->nullable();
    $table->enum('trang_thai', ['cho_xu_ly', 'dang_xu_ly', 'da_hoan_thanh', 'da_huy'])->default('cho_xu_ly');
    $table->enum('phuong_thuc_van_chuyen', ['xe_tai', 'viettel', 'giao_hang_nhanh', 'giao_hang_tiet_kiem']);
    $table->enum('phuong_thuc_thanh_toan', ['vi_dien_tu', 'cod', 'chuyen_khoan', 'tien_mat']);
    
    $table->index('trang_thai');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};