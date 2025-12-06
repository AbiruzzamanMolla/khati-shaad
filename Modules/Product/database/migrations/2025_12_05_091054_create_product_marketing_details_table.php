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
            $table->string('banner_title')->nullable();
            $table->string('banner_phone_title')->nullable();
            $table->string('banner_phone')->nullable();
            $table->string('banner_bg_image')->nullable();
            $table->string('banner_image')->nullable();

            // Section Two (Reason to Buy)
            $table->string('section_two_heading')->nullable();
            $table->longText('section_two_description')->nullable();
            $table->string('section_two_btn_text')->nullable();
            $table->string('section_two_btn_url')->nullable();
            $table->string('section_two_image')->nullable();

            // Section Three (Identification)
            $table->string('section_three_bg_image')->nullable();
            $table->string('section_three_heading')->nullable();
            $table->longText('section_three_description')->nullable();
            $table->string('section_three_btn_text')->nullable();
            $table->string('section_three_btn_url')->nullable();

            // Section Four (Why Buy From Us)
            $table->string('section_four_image')->nullable();
            $table->string('section_four_heading')->nullable();
            $table->longText('section_four_description')->nullable();
            $table->string('section_four_btn_text')->nullable();
            $table->string('section_four_btn_url')->nullable();

            // FAQ Section
            $table->string('faq_heading')->nullable();
            $table->json('faqs')->nullable(); // Stores array of question/answer objects

            // Offer Section
            $table->string('offer_bg_image')->nullable();
            $table->string('offer_text_1')->nullable();
            $table->string('offer_old_price')->nullable();
            $table->string('offer_text_2')->nullable();
            $table->string('offer_current_price')->nullable();
            $table->string('offer_text_3')->nullable();
            $table->string('offer_btn_text')->nullable();
            $table->string('offer_btn_url')->nullable();

            // Review Section
            $table->string('review_heading')->nullable();
            $table->json('review_images')->nullable(); // Stores array of image paths

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
