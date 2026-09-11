<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE supplier_contacts MODIFY COLUMN loai ENUM('email', 'qq', 'sdt', 'wechat', 'line', 'whatsapp', 'telegram', 'khac') DEFAULT 'sdt'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::statement("ALTER TABLE supplier_contacts MODIFY COLUMN loai ENUM('email', 'qq', 'sdt', 'wechat')");
    }
};