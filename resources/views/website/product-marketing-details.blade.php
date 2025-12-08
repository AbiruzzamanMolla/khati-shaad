<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $product->name }}</title>
    <link type="image/png" href="{{ asset('website/ks/images/favicon.png') }}" rel="icon">
    <link href="{{ asset('website/ks/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/responsive.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <a class="navbar-brand" href="{{ route('website.home') }}">
                <img class="img-fluid" src="{{ asset($setting->logo) }}" alt="{{ $setting->app_name }}">
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" type="button"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                </svg>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('website.home') }}"
                            aria-current="page">{{ $marketing->nav_home_text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('website.products') }}">{{ $marketing->nav_product_text }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('website.contact.us') }}">{{ $marketing->nav_contact_text }}</a>
                    </li>
                </ul>
                <ul class="right_menu">
                    <li>
                        <span class="call_icon">
                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 3.75 18 6m0 0 2.25 2.25M18 6l2.25-2.25M18 6l-2.25 2.25m1.5 13.5c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                            </svg>
                        </span>
                        <h5>{{ $marketing->nav_hotline_title }}</h5>
                        <a href="callto:{{ $marketing->nav_hotline_number }}">{{ $marketing->nav_hotline_number }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @if ($marketing->banner_status)
        <section class="grocery_banner" style="background: url({{ asset($marketing->banner_bg_image) }});">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="grocery_banner_text">
                            <h1>{{ $marketing->banner_title ?? '' }}
                            </h1>
                            <div class="border_text">
                                <p>{{ $marketing->banner_phone_title ?? '' }}</p>
                                <a
                                    href="callto:{{ $marketing->banner_phone }}">{{ $marketing->banner_phone ?? '' }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="grocery_banner_img">
                            <div class="img">
                                <img class="img-fluid w-100"
                                    src="{{ $marketing->banner_image ? asset($marketing->banner_image) : asset('website/ks/images/banner_img.png') }}"
                                    alt="grocery-banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->section_two_status)
        <section class="grocery_details_tow">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6 col-xl-6">
                        <div class="grocery_details_text">
                            <div class="grocery_heading">
                                <h2>{{ $marketing->section_two_heading }}</h2>
                            </div>
                            {!! $marketing->section_two_description !!}
                            <a class="common_btn" href="{{ $marketing->section_two_btn_url }}">
                                <span>{{ $marketing->section_two_btn_text }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-5">
                        <div class="grocery_details_img">
                            <img src="{{ $marketing->section_two_image ? asset($marketing->section_two_image) : asset('images/shoes.png') }}"
                                alt="img-fluid w-100">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->section_three_status)
        <section class="grocery_details" style="background: url({{ asset($marketing->section_three_bg_image) }});">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="grocery_details_text">
                            <div class="grocery_heading">
                                <h2>{{ $marketing->section_three_heading }}</h2>
                            </div>
                            {!! $marketing->section_three_description !!}
                            <a class="common_btn" href="{{ $marketing->section_three_btn_url }}">
                                <span>{{ $marketing->section_three_btn_text }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->section_four_status)
        <section class="grocery_details_three">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6 col-xl-5">
                        <div class="grocery_details_img">
                            <img src="{{ $marketing->section_four_image ? asset($marketing->section_four_image) : asset('website/ks/images/shoes2.png') }}"
                                alt="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <div class="grocery_details_text">
                            <div class="grocery_heading">
                                <h2>{{ $marketing->section_four_heading }}
                                </h2>
                            </div>
                            {!! $marketing->section_four_description !!}
                            <a class="common_btn" href="{{ $marketing->section_four_btn_url }}">
                                <span>{{ $marketing->section_four_btn_text }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->faq_status)
        <section class="grocery_faq">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="grocery_heading">
                            <h2>{{ $marketing->faq_heading }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-11">
                        <div class="grocery_faq_area">
                            <div class="accordion accordion-flush grocery_faq_text" id="accordionFlushExample">
                                @if (isset($marketing->faqs) && !empty($marketing->faqs))

                                    @foreach ($marketing->faqs as $index => $faq)
                                        @if ($faq['question'] ?? false)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button
                                                        class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse{{ $index }}"
                                                        type="button"
                                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                        aria-controls="flush-collapse{{ $index }}">
                                                        {{ $faq['question'] ?? '' }}
                                                    </button>
                                                </h2>
                                                <div class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                                    id="flush-collapse{{ $index }}"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">{{ $faq['answer'] ?? '' }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->offer_status)
        <section class="grocery_offer"
            style="background: url({{ $marketing->offer_bg_image ? asset($marketing->offer_bg_image) : asset('website/ks/images/bg_2.jpg') }});">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="grocery_offer_text">
                            <p>{{ $marketing->offer_text_1 }}
                                <del>{{ $marketing->offer_old_price }}</del> টাকা
                            </p>
                            <h3>{{ $marketing->offer_text_2 }}
                                <span>{{ $marketing->offer_current_price }}</span> টাকা
                            </h3>
                            <p>{{ $marketing->offer_text_3 }}
                                <span>“{{ $marketing->offer_btn_text }}”</span> বাটনে ক্লিক করুন
                            </p>
                            <a class="common_btn" href="{{ $marketing->offer_btn_url }}">
                                <span>{{ $marketing->offer_btn_text }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($marketing->review_status)
        <section class="grocery_review">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <div class="grocery_heading center_heading">
                            <h2>{{ $marketing->review_heading }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-11">
                        <div class="row grocery_review_slide">
                            @if (isset($marketing->review_images) && !empty($marketing->review_images))
                                @foreach ($marketing->review_images as $img)
                                    <div class="col-xl-3">
                                        <div class="grocery_single_review">
                                            <img class="img-fluid w-100" src="{{ asset($img) }}"
                                                alt="{{ __('Review Image') }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="billing_form mt_130 xs_mt_90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="grocery_heading center_heading">
                        <h2>{{ $marketing->checkout_heading }}</h2>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                
                <div class="col-xl-11">
                    <form class="billing_checkout_form" action="{{ route('website.place.marketing.order') }}"
                        method="POST">
                        @csrf
                        @if ($product->hasVariant)
                        <h3>প্রোডাক্ট সিলেক্ট করুন</h3>
                        <div class="row">
                            @foreach ($product->getVariantsPriceAndSkuAttribute() as $variant)
                            <div class="col-lg-6 col-xl-6">
                                <div class="product_select">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="variant"
                                            id="variant_{{ $variant['sku'] }}" value="{{ $variant['sku'] }}" data-name="{{ $product->name }} ({{ $variant['name'] }})" data-image="{{ get_valid_image_url($variant['image'], asset($product->thumbnail_image)) }}">
                                        <label class="product_select_details" for="variant_{{ $variant['sku'] }}">
                                            <span class="img">
                                                <img src="{{ get_valid_image_url($variant['image'], asset($product->thumbnail_image)) }}" alt=" img-fluid w-100">
                                            </span>
                                            <span class="text">
                                                <b>{{ $product->name }} ({{ $variant['name'] }})</b>
                                                <b>{{ $variant['sku'] }}</b>
                                                <b>{{ currency($variant['price']) }}</b>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="billing_details">
                                    <h4>আপনার বিলিং তথ্য দিন</h4>
                                    <div class="billing_single_input">
                                        <label>আপনার নাম<span>*</span></label>
                                        <input type="text" placeholder="আপনার নাম" name="name">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>মোবাইল নাম্বার <span>*</span></label>
                                        <input type="text" placeholder="মোবাইল নাম্বার" name="phone">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>ইমেইল</label>
                                        <input type="text" placeholder="ইমেইল" name="email">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার ঠিকানা<span>*</span></label>
                                        <input type="text" placeholder="বাসা নং, রোড নং, গ্রাম/মহল্লা, থানা"
                                            name="address">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার দেশ<span>*</span></label>
                                        <select class="select_2 select2-hidden-accessible" name="country"
                                            data-select2-id="select2-data-7-ev74" aria-hidden="true" tabindex="-1">
                                            <option data-select2-id="select2-data-9-aowr" value="">দেশ
                                                নির্বাচন করুন
                                            </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার বিভাগ<span>*</span></label>
                                        <select class="select_2 select2-hidden-accessible" name="state"
                                            data-select2-id="select2-data-4-vgk0" aria-hidden="true" tabindex="-1">
                                            <option data-select2-id="select2-data-6-pxju" value="">বিভাগ
                                                নির্বাচন করুন
                                            </option>
                                            <option value="">ঢাকা</option>
                                            <option value="">বরিশাল</option>
                                            <option value="">চট্টগ্রাম</option>
                                            <option value="">সিলেট</option>
                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার জেলা<span>*</span></label>
                                        <select class="select_2 select2-hidden-accessible" name="city"
                                            data-select2-id="select2-data-1-56cl" aria-hidden="true" tabindex="-1">
                                            <option data-select2-id="select2-data-3-ju9n" value="">জেলা
                                                নির্বাচন করুন
                                            </option>
                                            <option value="">ভোলা</option>
                                            <option value="">বরগুনা</option>
                                            <option value="">কুমিল্লা</option>
                                            <option value="">যশোর</option>
                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার পোস্ট কোড<span>*</span></label>
                                        <input type="text" placeholder="আপনার পোস্ট কোড" name="post_code">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার নোট</label>
                                        <textarea placeholder="আপনার নোট" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6">
                                <div class="billing_orders">
                                    <h4>আপনার অর্ডার সমূহ</h4>
                                    <div class="billing_orders_top">
                                        <h5>{{ __('Product') }}</h5>
                                        <h6>{{ __('Subtotal') }}</h6>
                                    </div>
                                    <ul class="billing_orders_product">
                                        <li>
                                            <div class="product">
                                                <div class="img">
                                                    <img src="{{ get_valid_image_url(asset($product->thumbnail_image), asset($setting->default_avatar)) }}" alt="img-fluid w-100">
                                                </div>
                                                <div class="text">
                                                    <h5>{{ $product->name }}</h5>
                                                    <div class="product_quantity">
                                                        <span class="minus">
                                                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                            </svg>
                                                        </span>
                                                        <input type="text" placeholder="1">
                                                        <span class="plus">
                                                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5 12h14" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6>1,190.00৳</h6>
                                        </li>
                                    </ul>
                                    <div class="billing_orders_subtotal">
                                        <div class="subtotal">
                                            <h5>Subtotal</h5>
                                            <h6>2,380.00৳ </h6>
                                        </div>
                                        <div class="subtotal">
                                            <h5>Shipping</h5>
                                            <div class="charge">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="flexRadioDefaultt5"
                                                        name="flexRadioDefaultt" type="radio" checked="">
                                                    <label class="form-check-label" for="flexRadioDefaultt5">
                                                        ঢাকার ভিতরে ডেলিভারি চার্জ: 60.00৳
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="flexRadioDefaultt6"
                                                        name="flexRadioDefaultt" type="radio">
                                                    <label class="form-check-label" for="flexRadioDefaultt6">
                                                        ঢাকার বাইরে ডেলিভারি চার্জ: 120.00৳
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="billing_orders_total">
                                        <h5>Total</h5>
                                        <h6>2,440.00৳</h6>
                                    </div>
                                    <div class="product_payment">
                                        <div class="accordion product_payment_accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse11" type="button"
                                                        aria-expanded="true" aria-controls="collapse11">
                                                        ক্যাশ অন ডেলিভারি
                                                        <input type="hidden" name="payment_method"
                                                            value="hand_cash">
                                                    </button>
                                                </h2>
                                                <div class="accordion-collapse collapse show" id="collapse11"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <p>পণ্য হাতে পেয়ে টাকা পরিশোধ করুন।</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_payment_btn">
                                        <p>আপনার ব্যক্তিগত তথ্য আপনার অর্ডার প্রক্রিয়া, আপনার অনুভূতি প্রতি সাহায্য
                                            করবে এবং আমাদের
                                            <a href="{{ route('website.privacy.policy') }}">প্রাইভেসি পলিসি</a> এ
                                            বর্ণিত অন্য উদ্দেশ্যে।
                                        </p>
                                        <button class="common_btn" type="submit">
                                            <span>অর্ডার করুন 2,440.00</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="grocery_copy_right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="grocery_copy_right_text">
                        <p>{{ $marketing->copyright_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--jquery library js-->
    <script src="{{ asset('website/ks/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/slick.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const collapseElement = document.getElementById('collapse11');

            if (collapseElement) {
                collapseElement.addEventListener('hide.bs.collapse', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            }
        });

        $(document).ready(function() {
            $('.select_2').select2();
        });

        $('.grocery_review_slide').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            dots: true,
            arrows: false,

            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                    }
                }
            ]
        });
    </script>
</body>

</html>
