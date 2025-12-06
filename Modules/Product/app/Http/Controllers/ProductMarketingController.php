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
            'banner_image' => 'nullable|image',
            'banner_bg_image' => 'nullable|image',
            'section_two_image' => 'nullable|image',
            'section_three_bg_image' => 'nullable|image',
            'section_four_image' => 'nullable|image',
            'offer_bg_image' => 'nullable|image',
            'review_images.*' => 'nullable|image'
        ]);

        $product = Product::findOrFail($id);
        $marketing_detail = ProductMarketingDetails::firstOrCreate(
            ['product_id' => $product->id]
        );

        // Handle File Uploads
        $fileFields = [
            'banner_image', 'banner_bg_image', 'section_two_image', 
            'section_three_bg_image', 'section_four_image', 'offer_bg_image'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = file_upload($file, 'uploads/custom-images/', $marketing_detail->$field);
                $marketing_detail->$field = $path;
            }
        }

        // Handle Review Images (Multiple)
        if ($request->hasFile('review_images')) {
             $reviewImages = [];
             // Keep existing images if any (optional, depending on requirement. Here we might just append or replace. 
             // Usually for simple implementation we might just append to existing or replace. 
             // Let's assume we append to existing or if null create new. 
             // For this specific 'edit' form which allows selecting multiple, usually it parses what is sent.
             // But standard file input multiple just sends new files.
             // Let's grab existing first.
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
            'offer_text_3', 'offer_btn_text', 'offer_btn_url', 'review_heading', 'checkout_heading', 'copyright_text',
            'nav_home_text', 'nav_product_text', 'nav_contact_text', 'nav_hotline_number',
            'bkash_number', 'rocket_number', 'nagad_number'
        ];

        foreach ($fillableText as $field) {
             if($request->has($field)){
                 $marketing_detail->$field = $request->input($field);
             }
        }

        // Handle FAQs (JSON)
        // Request faqs should be an array of ['question' => '...', 'answer' => '...']
        if ($request->has('faqs')) {
            $faqs = $request->input('faqs');
            // Filter empty ones
            $faqs = array_filter($faqs, function($faq){
                return !empty($faq['question']) || !empty($faq['answer']);
            });
            $marketing_detail->faqs = json_encode(array_values($faqs));
        }

        // Handle Checkout Products (JSON with Images)
        if ($request->has('checkout_products')) {
            $checkoutProducts = $request->input('checkout_products');
            $processedProducts = [];

            foreach ($checkoutProducts as $index => $prodData) {
                // Skip empty rows if needed, but let's assume valid rows if title/price exists
                if (empty($prodData['title']) && empty($prodData['price'])) continue;

                // Handle Image Upload
                if ($request->hasFile("checkout_products.{$index}.image")) {
                    $file = $request->file("checkout_products.{$index}.image");
                    $path = file_upload($file, 'uploads/custom-images/');
                    $prodData['image'] = $path;
                } else {
                    // Retain existing image
                    $prodData['image'] = $prodData['existing_image'] ?? null;
                }
                unset($prodData['existing_image']); // Clean up auxiliary field

                $processedProducts[] = $prodData;
            }
            $marketing_detail->checkout_products = json_encode($processedProducts);
        }

        $marketing_detail->save();

        $notification = trans('Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
}
