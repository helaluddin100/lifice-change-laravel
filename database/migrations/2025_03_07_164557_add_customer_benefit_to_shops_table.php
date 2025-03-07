<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerBenefitToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            // Add the 'customer_benefit' column with default value of 0
            $table->boolean('customer_benefit')->default(0)->after('top_category');
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
            // Drop the 'customer_benefit' column if the migration is rolled back
            $table->dropColumn('customer_benefit');
        });
    }
}