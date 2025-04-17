<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->unsignedBigInteger('demo_product_id')->nullable()->after('product_id');
        });
    }

    public function down()
    {
        Schema::table('product_images', function (Blueprint $table) {

            $table->dropColumn('demo_product_id');
        });
    }
}
