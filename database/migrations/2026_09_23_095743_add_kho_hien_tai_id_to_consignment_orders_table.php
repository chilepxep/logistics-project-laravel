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
        Schema::table('consignment_orders', function (Blueprint $table) {
           $table->unsignedBigInteger('kho_hien_tai_id')->nullable()->after('kho_vn_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consignment_orders', function (Blueprint $table) {
            //
        });
    }
};