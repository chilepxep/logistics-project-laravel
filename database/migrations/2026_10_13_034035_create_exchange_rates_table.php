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
        Schema::create('exchange_rates', function (Blueprint $table) {
        $table->id();
        $table->string('currency_code', 10)->unique(); // VD: CNY, JPY, AUD, EUR
        $table->string('currency_name'); // VD: Nhân dân tệ (TQ), Yên Nhật (JP)
        $table->string('flag', 20)->nullable(); // Mã cờ quốc gia (VD: cn, jp, au, de, fr)
        $table->decimal('rate', 12, 2); // Tỷ giá so với VNĐ (VD: 3520)
        $table->boolean('is_default')->default(0); // Đánh dấu đồng tiền mặc định hiện ở Header
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};