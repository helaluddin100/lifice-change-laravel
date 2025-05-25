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
        Schema::table('shops', function (Blueprint $table) {
            $table->string('delivery_option')->default(0);
            $table->decimal('inside_dhaka', 10, 2)->default(60.00);
            $table->decimal('outside_dhaka', 10, 2)->default(120.00);
            $table->decimal('free_delivery_amount', 10, 2)->nullable();

            $table->string('advance_type')->default(0);
            $table->string('advance_parcent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_option',
                'inside_dhaka',
                'outside_dhaka',
                'free_delivery_amount',
                'advance_type',
                'advance_parcent',
            ]);
        });
    }
};
