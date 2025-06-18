<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_number')->nullable()->after('payment_method');
            $table->string('payment_transation_id')->nullable()->after('payment_number');
            $table->decimal('pay_amount', 10, 2)->nullable()->after('payment_transation_id');
            $table->string('payment_status')->default('pending')->after('pay_amount');
            $table->string('order_type')->nullable()->after('payment_status');
            $table->string('payment_gateway')->nullable()->after('payment_status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_number', 'payment_transation_id', 'pay_amount']);
        });
    }
};
