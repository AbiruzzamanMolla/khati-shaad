<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductMarketingDetails;

class ProductMarketingDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ProductMarketingDetails::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'banner_title' => 'মদিনার রসালো স্বাদ ও পুষ্টিতে ভরপুর ন্যাচারালস সুপার প্রিমিয়াম খেজুর।',
                    'banner_phone_title' => 'সরাসরি কিনতে ফোন করুন',
                    'banner_phone' => '+8801711112222',
                    'banner_bg_image' => 'website/ks/images/banner_bg.jpg',
                    'banner_image' => 'website/ks/images/banner_img.png',

                    'section_two_heading' => 'লোফার জুতা কেন পড়বেন?',
                    'section_two_description' => '<ul><li>পাঞ্জাবি ও পায়জামার সাথে মানানসই।</li><li>ফরমাল ইউজে জিন্সের সাথে প্রিমিয়াম লুক।</li><li>রাফ ইউজেও কম্ফোর্টেবল।</li><li>ব্যবহারে পাবেন যথেষ্ট আরামদায়ক অনুভূতি।</li><li>আকর্ষণীয় ডিজাইনে তৈরি করা হয়েছে।</li></ul>',
                    'section_two_btn_text' => 'অর্ডার করতে চাই',
                    'section_two_btn_url' => '#',
                    'section_two_image' => 'website/ks/images/shoes.png',

                    'section_three_bg_image' => 'website/ks/website/ks/images/bg_1.jpg',
                    'section_three_heading' => 'অরজিনাল চামড়া চেনার উপায় কি?',
                    'section_three_description' => '<ul><li>ম্যাচের কাঠি বা লাইটার জ্বালিয়ে হালকাভাবে চামড়া জিনিসটার নিচে ধরুন। যদি কুঁচকে যায় বা পুড়ে যায় তবে চামড়া নয়।</li><li>চামড়ার জিনিসটি একটি ভাজ দিয়ে দেখুন আবার পূর্বের অবস্থায় ফিরে যায় কিনা যদি না আসে তবে বুঝবেন চামড়া।সিন্থেটিক জিনিস বারবার ভাজ করলেও একই রকম থাকবে।</li><li>দুই ফোঁটা পানি নিন চামড়ার জিনিসটির উপর পানি দিয়ে ঘষা দিন খেয়াল রাখুন, চামড়ার জিনিস হলে পানি দেওয়া জায়গাটি একটু হলেও ফুলে উঠবে।</li><li>চামড়ার জিনিসের ফিনিশিং কখনোই সিন্থেটিক লেদার বা রেকসিন এর মত খুব স্মুথ হবে না। প্রকৃত চামড়া সিন্থেটিক লেদার বা রেকসিনের মত এত বেশি স্মুথ হবেনা। প্রকৃত চামড়া একটু হলেও ১৯-২০ হবে।</li></ul>',
                    'section_three_btn_text' => 'অর্ডার করতে চাই',
                    'section_three_btn_url' => '#',

                    'section_four_image' => 'website/ks/images/shoes2.png',
                    'section_four_heading' => 'Fortune Leather BD থেকে কেন কিনবেন?',
                    'section_four_description' => '<ul><li>অর্ডার করতে একটি টাকাও অগ্রিম পেমেন্ট করতে হবে না।</li><li>প্রোডাক্ট হাতে পেয়ে চেক করে মূল্য পরিশোধ করতে পারবেন।</li><li>শতভাগ গরুর চামড়া ও নরম সোল দিয়ে বানানো।</li><li>পাচ্ছেন ছয় মাসের রিপ্লেসমেন্ট গ্যারান্টি।</li><li>জুতার সাইজ ছোট বড় হয়ে গেলে এক্সচেঞ্জ সুবিধা।</li><li>চামড়া না! প্রমাণ করতে পারলে 20 হাজার টাকা পুরস্কার।</li></ul>',
                    'section_four_btn_text' => 'অর্ডার করতে চাই',
                    'section_four_btn_url' => '#',

                    'faq_heading' => 'কোনো আমাদের থ্রি পিস কম্বো কিনবেন!',
                    'faqs' => [
                        [
                            'question' => 'আতরটির ঘ্রাণ সাধারণত কতক্ষণ থাকে?',
                            'answer' => 'সুঘ্রাণ দীর্ঘ সময় ধরে রেখে, শরীরের দুর্গন্ধ বিষয়ে দুশ্চিন্তামুক্ত রাখে।',
                        ],
                        [
                            'question' => 'আতর টি কি সরাসরি শরীরে ব্যবহার করতে পারবো?',
                            'answer' => 'সুঘ্রাণ দীর্ঘ সময় ধরে রেখে, শরীরের দুর্গন্ধ বিষয়ে দুশ্চিন্তামুক্ত রাখে।',
                        ],
                        [
                            'question' => 'আপনাদের কি কোনো শো-রুম আছে ?',
                            'answer' => 'সুঘ্রাণ দীর্ঘ সময় ধরে রেখে, শরীরের দুর্গন্ধ বিষয়ে দুশ্চিন্তামুক্ত রাখে।',
                        ],
                        [
                            'question' => 'আমি কি পণ্যটি দেখে শুঁকে নিতে পারবো?',
                            'answer' => 'সুঘ্রাণ দীর্ঘ সময় ধরে রেখে, শরীরের দুর্গন্ধ বিষয়ে দুশ্চিন্তামুক্ত রাখে।',
                        ],
                        [
                            'question' => 'ভাই দাম টা একটু বেশী মনে হচ্ছে.',
                            'answer' => 'সুঘ্রাণ দীর্ঘ সময় ধরে রেখে, শরীরের দুর্গন্ধ বিষয়ে দুশ্চিন্তামুক্ত রাখে।',
                        ],
                    ],

                    'offer_bg_image' => 'website/ks/images/bg_2.jpg',
                    'offer_text_1' => 'জনপ্রিয় এই লোফারের পূর্বের মূল্য',
                    'offer_old_price' => '১৪০০/-',
                    'offer_text_2' => 'আজকের অফার মূল্য মাত্র',
                    'offer_current_price' => '১১০০/-',
                    'offer_text_3' => 'টাকা অফারটি লুফে নিতে এখনি',
                    'offer_btn_text' => 'অর্ডার করতে চাই',
                    'offer_btn_url' => '#',

                    'review_heading' => 'কাস্টমার রিভিউ',
                    'review_images' => [
                        'website/ks/images/tshirt_review_1.jpg',
                        'website/ks/images/tshirt_review_2.jpg',
                        'website/ks/images/tshirt_review_3.jpg',
                        'website/ks/images/tshirt_review_4.jpg',
                    ],

                    'checkout_heading' => 'অর্ডার করতে নিচের ফর্মটি পূরন করুন',
                    'copyright_text' => 'Copyright © 2025 | All rights reserved | Landing page made by company',
                ]
            );
        }
    }
}
