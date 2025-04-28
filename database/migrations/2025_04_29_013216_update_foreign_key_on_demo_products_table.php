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
        Schema::table('demo_products', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['category_id']);

            // Add the new foreign key constraint to refer to demo_categories table
            $table->foreign('category_id')->references('id')->on('demo_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('demo_products', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['category_id']);

            // Re-add the old foreign key constraint if needed
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
