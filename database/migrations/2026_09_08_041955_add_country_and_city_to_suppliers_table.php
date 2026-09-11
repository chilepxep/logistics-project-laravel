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
        Schema::table('suppliers', function (Blueprint $table) {
        $table->foreignId('country_id')->nullable()->after('ten_ncc')->constrained('countries')->nullOnDelete();
        $table->string('thanh_pho', 100)->nullable()->after('country_id'); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
        $table->dropForeign(['country_id']);
        $table->dropColumn(['country_id', 'thanh_pho']);
    });
    }
};