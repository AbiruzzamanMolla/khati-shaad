<?php

namespace Modules\Product\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductMarketingDetails;

class ProductMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function marketingDetails($id)
    {
        $product = Product::findOrFail($id);

        $marketing_detail = ProductMarketingDetails::firstOrCreate(
            ['product_id' => $product->id]
        );

        return view('product::products.marketing.edit', compact('product', 'marketing_detail'));
    }

    public function marketingDetailsStore(Request $request, $id)
    {
        $request->validate([
            // Image Validation
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'section_two_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'section_three_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'section_four_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'offer_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'seo_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // URL Validation
            'section_two_btn_url' => 'nullable|url',
            'section_three_btn_url' => 'nullable|url',
            'section_four_btn_url' => 'nullable|url',
            'offer_btn_url' => 'nullable|url',
            'nav_home_url' => 'nullable|string',
            'nav_product_url' => 'nullable|string',
            'nav_contact_url' => 'nullable|string',

            // Text Validation
            'banner_title' => 'nullable|string|max:255',
            'banner_phone_title' => 'nullable|string|max:255',
            'banner_phone' => 'nullable|string|max:20',
            
            'section_two_heading' => 'nullable|string|max:255',
            'section_two_btn_text' => 'nullable|string|max:50',
            'section_two_description' => 'nullable|string',

            'section_three_heading' => 'nullable|string|max:255',
            'section_three_btn_text' => 'nullable|string|max:50',
            'section_three_description' => 'nullable|string',

            'section_four_heading' => 'nullable|string|max:255',
            'section_four_btn_text' => 'nullable|string|max:50',
            'section_four_description' => 'nullable|string',

            'faq_heading' => 'nullable|string|max:255',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:255',
            'faqs.*.answer' => 'nullable|string',

            'offer_text_1' => 'nullable|string|max:255',
            'offer_old_price' => 'nullable|string|max:20',
            'offer_text_2' => 'nullable|string|max:255',
            'offer_current_price' => 'nullable|string|max:20',
            'offer_text_3' => 'nullable|string|max:255',
            'offer_btn_text' => 'nullable|string|max:50',

            'review_heading' => 'nullable|string|max:255',
            'checkout_heading' => 'nullable|string|max:255',
            'copyright_text' => 'nullable|string|max:255',

            'nav_home_text' => 'nullable|string|max:50',
            'nav_product_text' => 'nullable|string|max:50',
            'nav_contact_text' => 'nullable|string|max:50',
            'nav_hotline_number' => 'nullable|string|max:20',

            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',

            // Payment Numbers
            'bkash_number' => 'nullable|string|max:20',
            'rocket_number' => 'nullable|string|max:20',
            'nagad_number' => 'nullable|string|max:20',
            
            // Checkout Products Validation
            'checkout_products' => 'nullable|array',
            'checkout_products.*.title' => 'nullable|string|max:255',
            'checkout_products.*.price' => 'nullable|string|max:20',
            'checkout_products.*.description' => 'nullable|string',
            'checkout_products.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'image' => __('The uploaded file must be an image.'),
            'mimes' => __('The image must be a file of type: jpeg, png, jpg, webp.'),
            'max' => __('The image size must not be greater than 2048 kilobytes.'),
            'url' => __('The URL format is invalid.'),
            'string' => __('This field must be a string.'),
            'array' => __('This field must be an array.'),
            'max.string' => __('The text may not be greater than :max characters.'),
            'banner_image.max' => __('The banner image must not exceed 2MB.'),
            'banner_bg_image.max' => __('The banner background image must not exceed 2MB.'),
            'seo_image.max' => __('The SEO image must not exceed 2MB.'),
        ]);

        $product = Product::findOrFail($id);
        $marketing_detail = ProductMarketingDetails::firstOrCreate(
            ['product_id' => $product->id]
        );

        // Handle File Uploads
        $fileFields = [
            'banner_image', 'banner_bg_image', 'section_two_image', 
            'section_three_bg_image', 'section_four_image', 'offer_bg_image', 'seo_image'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = file_upload($file, oldFile: $marketing_detail->$field);
                $marketing_detail->$field = $path;
            }
        }

        // Handle Review Images (Multiple)
        if ($request->hasFile('review_images')) {
             $reviewImages = [];
             
             $existingImages = json_decode($marketing_detail->review_images, true) ?? [];
             
             foreach ($request->file('review_images') as $file) {
                $path = file_upload($file, 'uploads/custom-images/');
                $existingImages[] = $path;
             }
             $marketing_detail->review_images = json_encode($existingImages);
        }

        // Handle Text Fields
        $fillableText = [
            'banner_title', 'banner_phone_title', 'banner_phone',
            'section_two_heading', 'section_two_description', 'section_two_btn_text', 'section_two_btn_url',
            'section_three_heading', 'section_three_description', 'section_three_btn_text', 'section_three_btn_url',
            'section_four_heading', 'section_four_description', 'section_four_btn_text', 'section_four_btn_url',
            'faq_heading', 'offer_text_1', 'offer_old_price', 'offer_text_2', 'offer_current_price', 
            'offer_text_3', 'offer_btn_text', 'offer_btn_url', 'review_heading', 'copyright_text',
            'nav_home_text', 'nav_home_url', 'nav_product_text', 'nav_product_url', 'nav_contact_text', 'nav_contact_url', 'nav_hotline_number',
            'seo_title', 'seo_description', 'seo_keywords'
        ];

        foreach ($fillableText as $field) {
             if($request->has($field)){
                 $marketing_detail->$field = $request->input($field);
             }
        }

        // Handle FAQs (JSON)
        if ($request->has('faqs')) {
            $faqs = $request->input('faqs');
            $faqs = array_filter($faqs, function($faq){
                return !empty($faq['question']) || !empty($faq['answer']);
            });
            $marketing_detail->faqs = json_encode(array_values($faqs));
        }

        $marketing_detail->save();

        $statusFields = [
            'banner_status', 'section_two_status', 'section_three_status', 
            'section_four_status', 'faq_status', 'offer_status', 'review_status'
        ];

        foreach($statusFields as $field){
            $marketing_detail->$field = $request->has($field) ? 1 : 0;
        }
        $marketing_detail->save();

        $notification = __('Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
