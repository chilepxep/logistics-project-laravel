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
 Schema::create('suppliers', function (Blueprint $table) {
    $table->id();
    $table->string('ma_ncc', 20)->unique();
    $table->string('ten_ncc', 150);
    $table->string('nganh_hang', 100)->nullable();
    $table->enum('hinh_thuc', ['online', 'offline']);
    $table->string('logo_url', 255)->nullable();
    $table->string('ten_nguoi_dai_dien', 150)->nullable();
    $table->string('chuc_vu', 100)->nullable();
    $table->text('chi_tiet')->nullable();
    $table->string('ten_ngan_hang', 100)->nullable();
    $table->string('so_tai_khoan', 50)->nullable();
    $table->string('chu_tai_khoan', 150)->nullable();
    $table->string('chi_nhanh', 150)->nullable();
    $table->decimal('tong_tien_dat_hang', 15, 2)->default(0);
    $table->integer('tong_khieu_nai')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};