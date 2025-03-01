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
        Schema::create('contactus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('message');
            $table->boolean('status')->default(false);
            $table->text('reply')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactus');
    }
};
