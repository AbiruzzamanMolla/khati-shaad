<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Product\Database\factories\ProductMarketingDetailsFactory;

class ProductMarketingDetails extends Model
{
    // use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'banner_title',
        'banner_phone_title',
        'banner_phone',
        'banner_bg_image',
        'banner_image',
        'section_two_heading',
        'section_two_description',
        'section_two_btn_text',
        'section_two_btn_url',
        'section_two_image',
        'section_three_bg_image',
        'section_three_heading',
        'section_three_description',
        'section_three_btn_text',
        'section_three_btn_url',
        'section_four_image',
        'section_four_heading',
        'section_four_description',
        'section_four_btn_text',
        'section_four_btn_url',
        'faq_heading',
        'faqs',
        'offer_bg_image',
        'offer_text_1',
        'offer_old_price',
        'offer_text_2',
        'offer_current_price',
        'offer_text_3',
        'offer_btn_text',
        'offer_btn_url',
        'review_heading',
        'review_images',
        'nav_home_text',
        'nav_home_url',
        'nav_product_text',
        'nav_product_url',
        'nav_contact_text',
        'nav_contact_url',
        'nav_hotline_number',
        'checkout_products',
        'bkash_number',
        'rocket_number',
        'nagad_number',
        'checkout_heading',
        'copyright_text',
        'banner_status',
        'section_two_status',
        'section_three_status',
        'section_four_status',
        'faq_status',
        'offer_status',
        'review_status'
    ];

    protected $casts = [
        'faqs' => 'array',
        'review_images' => 'array',
        'checkout_products' => 'array',
    ];
    
    /*protected static function newFactory(): ProductMarketingDetailsFactory
    {
        //return ProductMarketingDetailsFactory::new();
    }*/
}
