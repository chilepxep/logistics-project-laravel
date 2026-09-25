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
        Schema::create('package_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('warehouse_id')->nullable(); // Ghi nhận kho xảy ra sự kiện
            $table->unsignedBigInteger('employee_id')->nullable();  // Người cập nhật
            $table->string('title');                                // Ví dụ:"Nhập kho", "Xuất kho", "Hàng đang về"
            $table->text('description')->nullable();                // Ví dụ:"Gói hàng đã đến kho Thâm Quyến..."
            $table->timestamps();


            //ràng buộc
        $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
        $table->foreign('employee_id')->references('id')->on('users')->onDelete('set null');
        });


      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_trackings');
    }
};