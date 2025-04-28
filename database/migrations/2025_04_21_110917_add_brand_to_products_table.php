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
        Schema::table('products', function (Blueprint $table) {
            // First, ensure the brand_id field is set correctly
            $table->unsignedBigInteger('brand_id')->nullable()->after('product_code'); // Change column order if needed

            // Now add the foreign key constraint
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
