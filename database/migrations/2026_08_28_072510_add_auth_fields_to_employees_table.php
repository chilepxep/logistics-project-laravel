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
       Schema::table('employees', function (Blueprint $table) {
            
            $table->string('email', 150)->unique()->after('ho_ten');
            $table->string('password', 255)->after('email');
            $table->rememberToken()->after('vai_tro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'remember_token', 'created_at', 'updated_at']);
        });
    }
};