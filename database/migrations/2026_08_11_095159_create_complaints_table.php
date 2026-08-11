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
Schema::create('complaints', function (Blueprint $table) {
    $table->id();
    $table->string('hinh_anh_url', 255)->nullable();
    $table->foreignId('order_id')->nullable()->constrained('orders');
    $table->foreignId('package_id')->nullable()->constrained('packages');
    $table->enum('loai_khieu_nai', ['don_hang_cham', 'thai_do_khong_tot', 'sai_chi_phi', 'ship_cao', 'hang_thieu', 'hang_hu']);
    $table->enum('trang_thai', ['cho_xu_ly', 'da_xu_ly', 'da_hoan_thanh', 'da_huy'])->default('cho_xu_ly');
    $table->enum('phuong_an', ['boi_thuong', 'doi_tra'])->nullable();
    
    $table->foreignId('nhan_vien_dat_hang_id')->nullable()->constrained('employees');
    $table->foreignId('nhan_vien_xu_ly_id')->nullable()->constrained('employees');
    
    $table->timestamps();
    
    $table->index('trang_thai');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};