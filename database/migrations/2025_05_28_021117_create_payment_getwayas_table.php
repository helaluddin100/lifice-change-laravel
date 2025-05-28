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
        Schema::create('payment_getwayas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // যার গেটওয়ে সেটিং এটি তার জন্য
            $table->string('name'); // bkash, nagad, rocket, sslcommerz
            $table->string('getwaya_id');
            $table->string('type')->comment('payment gateway type')->nullable(); // payment gateway type
            $table->string('account_number')->nullable(); // মোবাইল/পেমেন্ট নাম্বার
            $table->string('getwaya_instruction')->nullable(); // মোবাইল/পেমেন্ট নাম্বারের মালিকের নাম
            $table->string('qr_code_image')->nullable(); // QR কোড ইমেজ (পাথ)

            $table->string('api_mood')->nullable();
            $table->string('store_id')->nullable(); // Keep this one
            $table->string('store_password')->nullable();

            $table->string('api_key')->nullable(); // API integration এর জন্য
            $table->string('api_secret')->nullable(); // API integration এর জন্য
            $table->boolean('status')->default(true); // এই গেটওয়ে কি সক্রিয়?
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_getwayas');
    }
};
