<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::table('product_images', function (Blueprint $table) {

            $table->foreignId('demo_product_id')->nullable()->constrained('demo_products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Drop 'demo_product_id' column
            $table->dropColumn('demo_product_id');

            // Revert 'product_id' back to non-nullable
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->change();
        });
    }
}
