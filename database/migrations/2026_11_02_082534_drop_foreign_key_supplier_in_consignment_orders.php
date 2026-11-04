<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('consignment_orders', function (Blueprint $table) {
        $table->dropForeign('consignment_orders_supplier_id_foreign');
    });
}

    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('consignment_orders', function (Blueprint $table) {
        $table->foreign('supplier_id')->references('id')->on('suppliers');
    });
}
};