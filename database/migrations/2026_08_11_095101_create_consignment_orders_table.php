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
Schema::create('consignment_orders', function (Blueprint $table) {
    $table->id();
    $table->string('ma_don_ky_gui', 30)->unique();
    $table->foreignId('user_id')->constrained('users');
    $table->date('ngay_tao_yeu_cau');
    $table->date('ngay_van_chuyen')->nullable();
    $table->date('ngay_nhan_hang')->nullable();
    $table->enum('yeu_cau_toc_do', ['nhanh', 'thuong'])->default('thuong');
    $table->foreignId('kho_nhan_tq_id')->constrained('warehouses');
    $table->string('dia_chi_tra_hang', 255)->nullable();
    $table->integer('so_kien')->default(0);
    $table->enum('trang_thai', ['cho_xu_ly', 'da_xu_ly', 'hoan_thanh'])->default('cho_xu_ly');
    $table->timestamps();
    
    $table->index('trang_thai');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_orders');
    }
};