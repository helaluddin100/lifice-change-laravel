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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->unsignedBigInteger('package_id');
            $table->string('payment_id', 8)->unique()->nullable(false);
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bKash', 'Nagad', 'CreditCard', 'BankTransfer', 'Paypal', 'Strip']); // Payment method options
            $table->string('transaction_id');
            $table->enum('status', ['pending', 'completed', 'failed']); // Payment status
            $table->date('payment_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
};
