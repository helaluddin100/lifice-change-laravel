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
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null'); // Optional

            $table->string('title');
            $table->string('slug')->unique();

            // Contact Information
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('country', 3)->nullable(); // ISO 3-letter country code (e.g., BGD, USA)

            // Page Settings
            $table->json('settings')->nullable();
            $table->json('seo_settings')->nullable();

            // Page Sections
            $table->json('hero_setting')->nullable();
            $table->json('social_media')->nullable();
            $table->json('partner')->nullable();
            $table->json('testimonial')->nullable();
            $table->json('feature')->nullable();
            $table->json('feature_details')->nullable();
            $table->json('feature_details_b')->nullable();
            $table->json('faq')->nullable();

            // Brand & Media
            $table->string('brand_logo')->nullable();
            $table->json('video_settings')->nullable(); // Video + Poster + Links

            // Domain & Publish
            $table->string('domain')->nullable();
            $table->boolean('published')->default(false);

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
