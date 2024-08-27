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
            $table->decimal('balance', 8, 2)->nullable();
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->string('shop_url')->unique();
            $table->string('logo')->nullable();
            $table->string('color')->nullable();

            $table->boolean('stock_management')->default(false);
            $table->boolean('show_product_sold_count')->default(false);
            $table->string('vat_tax')->nullable();
            $table->text('payment_message')->nullable();


            $table->string('top_announcement')->nullable();
            $table->string('visitors')->default(0)->nullable();

            //location
            $table->string('country')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            //delivery charge policy
            $table->decimal('default_delivery_charge', 8, 2)->nullable();
            $table->json('specific_delivery_charges')->nullable();
            $table->text('delivery_charge_note')->nullable();

            // GTM and Facebook Pixel
            $table->string('gtm_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();
            $table->string('facebook_pixel_access_token')->nullable();
            $table->string('facebook_pixel_event')->nullable();

            // Chat Support
            $table->boolean('live_chat')->default(false);
            $table->boolean('whatsapp_chat')->default(false);
            $table->string('live_chat_whatsapp')->nullable();

            // shop domain
            $table->string('shop_domain')->nullable();
            $table->string('subdomain_id')->nullable();
            $table->string('shop_subdomain_name')->nullable();

            // shop domain
            $table->string('shop_domain_name')->nullable();

            //language    //
            $table->string('language')->nullable();

            //social media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('discord')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();

            //shop others setting
            $table->boolean('slider')->default(0);
            $table->boolean('today_sell')->default(0);
            $table->boolean('new_arrival')->default(0);
            $table->boolean('offer_product')->default(0);
            $table->boolean('hot_deal')->default(0);
            $table->boolean('flash_deal')->default(0);
            $table->boolean('top_rated')->default(0);
            $table->boolean('top_selling')->default(0);
            $table->boolean('related_product')->default(0);

            //status
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
