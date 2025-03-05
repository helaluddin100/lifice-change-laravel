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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('brand_logo');

            // Contact Information
            $table->string('phone', 30)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('facebook_pixel')->nullable();
            $table->string('color')->default("#851dd7");

            // Delivery Charge
            $table->decimal('delivery_charge', 10, 2)->nullable();

            // Page Settings
            $table->json('settings')->nullable();
            $table->json('seo_settings')->nullable();

            // Page Sections
            $table->json('hero_setting')->nullable();
            $table->json('social_media')->nullable();
            $table->json('partners')->nullable();
            $table->json('testimonials')->nullable();
            $table->json('features')->nullable();
            $table->json('feature_details')->nullable();
            $table->json('additional_features')->nullable();
            $table->json('faq')->nullable();

            // Branding & Media
            $table->json('video_settings')->nullable();

            // Domain & Publish
            $table->string('domain')->unique()->nullable();
            $table->boolean('is_published')->default(false);

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
        Schema::dropIfExists('landing_pages');
    }
};
