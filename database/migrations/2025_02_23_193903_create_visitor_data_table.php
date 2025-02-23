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
        Schema::create('visitor_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User Foreign Key
            $table->foreignId('shop_id')->constrained()->onDelete('cascade'); // Shop Foreign Key
            $table->string('ip_address');
            $table->string('browser');
            $table->string('device_type');
            $table->integer('screen_width');
            $table->integer('screen_height');
            $table->string('country');
            $table->string('city');
            $table->string('referrer');
            $table->string('current_url');

            $table->string('region')->nullable();
            $table->string('loc')->nullable();
            $table->string('postal')->nullable();
            $table->string('timezone')->nullable();
            $table->string('isp_name')->nullable();
            $table->string('isp_domain')->nullable();
            $table->string('isp_type')->nullable();
            $table->string('abuse_address')->nullable();
            $table->boolean('vpn')->default(false);
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
        Schema::dropIfExists('visitor_data');
    }
};