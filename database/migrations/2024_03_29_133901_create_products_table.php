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
            $table->string('old_price')->nullable();
            $table->string('buy_price')->nullable();
            $table->string('product_code');
            $table->string('quantity');
            $table->string('warranty')->nullable();
            $table->integer('sold_count')->default(0);

            $table->boolean('has_details')->default(false);
            $table->json('product_details')->nullable();
            $table->json('product_colors')->nullable();
            $table->json('product_sizes')->nullable();


            //product list details
            $table->json('product_info_list')->nullable();

            //product variant
            $table->boolean('has_variant')->default(false);

            $table->string('variant_name')->nullable();
            $table->json('product_variant')->nullable();

            //default delivery charge
            $table->boolean('has_delivery_charge')->default(false);
            $table->string('delivery_charge')->nullable();

            //product images
            $table->json('images')->nullable();

            //product video
            $table->string('video')->nullable();

            // product description
            $table->longText('description')->nullable();
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
