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
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
    $table->integer('stt');
    $table->string('hinh_anh_url', 255)->nullable();
    $table->string('ten_san_pham', 255);
    $table->string('mau_sac_kich_thuoc', 150)->nullable();
    $table->string('link_san_pham', 500)->nullable();
    $table->decimal('don_gia', 15, 2);
    $table->integer('so_luong');
    $table->string('ghi_chu_khac', 255)->nullable();
    
    // Tạo cột ảo tính toán tự động trong MySQL
    $table->decimal('thanh_tien', 15, 2)->storedAs('don_gia * so_luong');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};