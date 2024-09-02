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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('current_price');
            $table->string('old_price')->nullable(); // Changed to nullable
            $table->string('buy_price')->nullable();
            $table->string('product_code');
            $table->string('quantity');
            $table->string('warranty')->nullable();
            $table->integer('sold_count')->default(0); // Changed to integer
            $table->json('product_details')->nullable(); // Made nullable

            //product list details
            $table->json('product_info_list')->nullable();

            //product variant
            $table->boolean('has_variant')->default(false);
            $table->json('product_variant')->nullable();

            //default delivery charge
            $table->boolean('has_delivery_charge')->default(false);
            $table->string('delivery_charge')->nullable();

            //product images
            $table->json('images')->nullable(); // Made nullable

            //product video
            $table->string('video')->nullable();

            //seo data
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->boolean('status')->default(true); // Default true
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
