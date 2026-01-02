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
    Schema::table('orders', function (Blueprint $table) {
        // Menambahkan kolom-kolom yang kurang
        $table->string('payment_method')->nullable()->after('status');
        $table->string('shipping_method')->nullable()->after('payment_method');
        $table->text('address')->nullable()->after('shipping_method');
        $table->string('phone')->nullable()->after('address');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['payment_method', 'shipping_method', 'address', 'phone']);
    });
}
};
