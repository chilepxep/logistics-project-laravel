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
Schema::create('consignment_extra_requirements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('consignment_order_id')->constrained('consignment_orders')->cascadeOnDelete();
    $table->enum('loai_yeu_cau', ['kiem_hang', 'dong_go', 'khai_thue_gtgt']);
    
    $table->unique(['consignment_order_id', 'loai_yeu_cau'], 'uq_cn_req');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_extra_requirements');
    }
};