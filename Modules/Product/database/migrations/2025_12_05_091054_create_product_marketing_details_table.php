<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Product\app\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_marketing_details', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();

            // Banner Section
            $table->boolean('banner_status')->default(true);
            $table->string('banner_title')->nullable();
            $table->string('banner_phone_title')->nullable();
            $table->string('banner_phone')->nullable();
            $table->string('banner_bg_image')->nullable();
            $table->string('banner_image')->nullable();

            // Section Two (Reason to Buy)
            $table->boolean('section_two_status')->default(true);
            $table->string('section_two_heading')->nullable();
            $table->longText('section_two_description')->nullable();
            $table->string('section_two_btn_text')->nullable();
            $table->string('section_two_btn_url')->nullable();
            $table->string('section_two_image')->nullable();

            // Section Three (Identification)
            $table->boolean('section_three_status')->default(true);
            $table->string('section_three_bg_image')->nullable();
            $table->string('section_three_heading')->nullable();
            $table->longText('section_three_description')->nullable();
            $table->string('section_three_btn_text')->nullable();
            $table->string('section_three_btn_url')->nullable();

            // Section Four (Why Buy From Us)
            $table->boolean('section_four_status')->default(true);
            $table->string('section_four_image')->nullable();
            $table->string('section_four_heading')->nullable();
            $table->longText('section_four_description')->nullable();
            $table->string('section_four_btn_text')->nullable();
            $table->string('section_four_btn_url')->nullable();

            // FAQ Section
            $table->boolean('faq_status')->default(true);
            $table->string('faq_heading')->nullable();
            $table->json('faqs')->nullable(); // Stores array of question/answer objects

            // Offer Section
            $table->boolean('offer_status')->default(true);
            $table->string('offer_bg_image')->nullable();
            $table->string('offer_text_1')->nullable();
            $table->string('offer_old_price')->nullable();
            $table->string('offer_text_2')->nullable();
            $table->string('offer_current_price')->nullable();
            $table->string('offer_text_3')->nullable();
            $table->string('offer_btn_text')->nullable();
            $table->string('offer_btn_url')->nullable();

            // Review Section
            $table->boolean('review_status')->default(true);
            $table->string('review_heading')->nullable();
            $table->json('review_images')->nullable(); // Stores array of image paths

            // Navbar Section
            $table->string('nav_home_text')->nullable()->default('Home');
            $table->string('nav_home_url')->nullable()->default('#');
            $table->string('nav_product_text')->nullable()->default('Product');
            $table->string('nav_product_url')->nullable()->default('#');
            $table->string('nav_contact_text')->nullable()->default('Contact');
            $table->string('nav_contact_url')->nullable()->default('#');
            $table->string('nav_hotline_number')->nullable();

            // SEO Section
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();

            // Footer / Checkout Misc
            $table->string('checkout_heading')->nullable();
            $table->string('copyright_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_marketing_details');
    }
};
