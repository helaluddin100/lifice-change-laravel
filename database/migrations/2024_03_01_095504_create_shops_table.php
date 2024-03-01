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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('shop_type');
            $table->string('email');
            $table->string('number');
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->string('shop_url')->unique();
            $table->string('stock_management')->nullable();
            $table->string('vat_tax')->nullable();
            $table->string('default_delivery_charge')->nullable();
            $table->text('payment_message')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('discord')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('logo')->nullable();
            $table->string('color')->nullable();
            $table->string('district')->nullable();
            $table->string('division')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('shops');
    }
};
