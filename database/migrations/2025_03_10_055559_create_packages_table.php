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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries');
            $table->string('name');
            $table->string('product_limit')->nullable();
            $table->string('page_limit')->nullable();
            $table->string('email_marketing')->nullable(); // Fixed typo
            $table->string('card')->nullable();
            $table->string('package_time')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('offer_price', 8, 2)->nullable();
            $table->json('features');
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('packages');
    }
};
