<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $marketing->seo_title ?? $product->name }}</title>

    <meta name="robots"
        content="{{ !getSettingStatus('search_engine_indexing') ? 'noindex, nofollow' : 'index, follow' }}">

    @if ($marketing->seo_description)
        <meta name="description" content="{{ $marketing->seo_description }}">
    @else
        <meta name="description" content="{{ Str::limit(strip_tags($product->description ?? $product->name), 160) }}">
    @endif

    @if ($marketing->seo_keywords)
        <meta name="keywords" content="{{ $marketing->seo_keywords }}">
    @endif

    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $marketing->seo_title ?? $product->name }}">

    @if ($marketing->seo_description)
        <meta property="og:description" content="{{ $marketing->seo_description }}">
    @else
        <meta property="og:description"
            content="{{ Str::limit(strip_tags($product->description ?? $product->name), 200) }}">
    @endif

    <meta property="og:url" content="{{ url()->current() }}">

    @if ($marketing->seo_image)
        <meta property="og:image" content="{{ asset($marketing->seo_image) }}">
    @elseif($product->thumbnail_image)
        <meta property="og:image" content="{{ asset($product->thumbnail_image) }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $marketing->seo_title ?? $product->name }}">

    @if ($marketing->seo_description)
        <meta name="twitter:description" content="{{ $marketing->seo_description }}">
    @else
        <meta name="twitter:description"
            content="{{ Str::limit(strip_tags($product->description ?? $product->name), 200) }}">
    @endif

    @if ($marketing->seo_image)
        <meta name="twitter:image" content="{{ asset($marketing->seo_image) }}">
    @elseif($product->thumbnail_image)
        <meta name="twitter:image" content="{{ asset($product->thumbnail_image) }}">
    @endif

    <link href="{{ url()->current() }}" rel="canonical">
    @if ($setting->favicon)
        <link type="image/png" href="{{ asset($setting->favicon) }}" rel="icon">
    @endif
    <link href="{{ asset('website/ks/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/ks/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('global/toastr/toastr.min.css') }}" rel="stylesheet">

    @if (getSettingStatus('googel_tag_status'))
        <script>
            window.dataLayer = window.dataLayer || [];

            @if (session('gtm_push'))
                @foreach ((array) session('gtm_push') as $event)
                    window.dataLayer.push({!! json_encode($event) !!});
                @endforeach
            @endif
        </script>
    @endif

    @if ($setting->google_analytic_status == 'active')
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $setting->google_analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $setting->google_analytic_id }}');
        </script>
    @endif

    @if (getSettingStatus('googel_tag_status'))
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $setting?->googel_tag_id }}');
        </script>
        <!-- End Google Tag Manager -->
    @endif

    @if (getSettingStatus('pixel_status'))
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $setting->pixel_app_id }}');
            fbq('track', 'PageView');
        </script>

        @if (session('pixel_payload') && getSettingStatus('marketing_status', 'int'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    if (typeof fbq === 'function') {
                        fbq('track', '{{ session('pixel_payload.event') }}',
                            {!! json_encode(session('pixel_payload.data')) !!});
                    }
                });
            </script>
        @endif
    @endif

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
                    @if ($marketing->nav_home_text)
                        <li class="nav-item">
                            <a class="nav-link active"
                                href="{{ $marketing->nav_home_url ? url($marketing->nav_home_url) : route('website.home') }}"
                                aria-current="page">{{ $marketing->nav_home_text }}</a>
                        </li>
                    @endif
                    @if ($marketing->nav_product_text)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ $marketing->nav_service_url ? url($marketing->nav_product_url) : route('website.products') }}">{{ $marketing->nav_product_text }}</a>
                        </li>
                    @endif
                    @if ($marketing->nav_contact_text)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ $marketing->nav_contact_url ? url($marketing->nav_contact_url) : route('website.contact.us') }}">{{ $marketing->nav_contact_text }}</a>
                        </li>
                    @endif
                </ul>
                <ul class="right_menu">
                    @if ($marketing->nav_hotline_numbe)
                        <li>
                            <span class="call_icon">
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 3.75 18 6m0 0 2.25 2.25M18 6l2.25-2.25M18 6l-2.25 2.25m1.5 13.5c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                                </svg>
                            </span>
                            <h5>{{ __('Hotline') }}</h5>
                            <a
                                href="callto:{{ $marketing->nav_hotline_number }}">{{ $marketing->nav_hotline_number }}</a>
                        </li>
                    @endif
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
                                    @php
                                        $faqs = is_array($marketing->faqs) ? $marketing->faqs : json_decode($marketing->faqs, true);
                                    @endphp
                                    @foreach ($faqs as $index => $faq)
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
                    <form class="billing_checkout_form" id="payment_form"
                        action="{{ route('website.place.marketing.order') }}" method="POST">
                        @csrf
                        @php
                            $defaultSku = $product->sku;
                            $name = $product->name;
                        @endphp
                        @if ($product->hasVariant)
                            <h3>প্রোডাক্ট সিলেক্ট করুন</h3>
                            <div class="row">
                                @foreach ($product->getVariantsPriceAndSkuAttribute() as $variant)
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="product_select">
                                            <div class="form-check">
                                                <input class="form-check-input product_variants"
                                                    id="variant_{{ $variant['sku'] }}" name="variant"
                                                    data-name="{{ $product->name }} ({{ $variant['name'] }})"
                                                    data-image="{{ get_valid_image_url($variant['image'], asset($product->thumbnail_image)) }}"
                                                    data-price="{{ $variant['price'] }}" type="radio"
                                                    value="{{ $variant['sku'] }}" @checked($variant['is_default'])>
                                                <label class="product_select_details"
                                                    for="variant_{{ $variant['sku'] }}">
                                                    <span class="img">
                                                        <img src="{{ get_valid_image_url($variant['image'], asset($product->thumbnail_image)) }}"
                                                            alt=" img-fluid w-100">
                                                    </span>
                                                    <span class="text">
                                                        <b>{{ $product->name }} ({{ $variant['name'] }})</b>
                                                        <b>{{ $variant['sku'] }}</b>
                                                        <b>{{ currency($variant['price']) }}</b>
                                                        @php
                                                            if ($variant['is_default']) {
                                                                $defaultSku = $variant['sku'];
                                                                $name = $product->name . '(' . $variant['name'] . ')';
                                                            }
                                                        @endphp
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
                                        <input name="name" type="text" placeholder="আপনার নাম">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>মোবাইল নাম্বার <span>*</span></label>
                                        <input name="phone" type="text" placeholder="মোবাইল নাম্বার">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>ইমেইল</label>
                                        <input name="email" type="text" placeholder="ইমেইল">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার ঠিকানা<span>*</span></label>
                                        <input name="address" type="text"
                                            placeholder="বাসা নং, রোড নং, গ্রাম/মহল্লা, থানা">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার দেশ<span>*</span></label>
                                        <select class="select_2" name="country_id" tabindex="-1">
                                            <option value="">দেশ নির্বাচন করুন
                                            </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার বিভাগ<span>*</span></label>
                                        <select class="select_2" name="state_id" tabindex="-1">
                                            <option data-select2-id="select2-data-6-pxju" value="">বিভাগ
                                                নির্বাচন করুন
                                            </option>
                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার জেলা<span>*</span></label>
                                        <select class="select_2" name="city_id" tabindex="-1">
                                            <option value="">জেলা নির্বাচন করুন</option>

                                        </select>
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার পোস্ট কোড<span>*</span></label>
                                        <input name="post_code" type="text" placeholder="আপনার পোস্ট কোড">
                                    </div>
                                    <div class="billing_single_input">
                                        <label>আপনার নোট</label>
                                        <textarea name="note" placeholder="আপনার নোট"></textarea>
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
                                                    <img src="{{ get_valid_image_url(asset($product->thumbnail_image), asset($setting->default_avatar)) }}"
                                                        alt="img-fluid w-100">
                                                </div>
                                                <div class="text">
                                                    <h5 id="product_name_title">{{ $name ?? $product->name }}</h5>
                                                    <div class="product_quantity">

                                                        <span class="minus" id="product_qty_minus">
                                                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5 12h14" />
                                                            </svg>
                                                        </span>
                                                        <input name="quantity" id="product_qty" type="text"
                                                            placeholder="1" value="{{ $data['qty'] ?? 1 }}">
                                                        <span class="plus" id="product_qty_plus">
                                                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <input type="hidden" name="product_id" id="product_id"
                                                        value="{{ $product->id }}">
                                                    <input type="hidden" name="sku" id="product_sku"
                                                        value="{{ $data['generatedData']['sku'] ?? $defaultSku }}">
                                                    <input type="hidden" name="price" id="product_price"
                                                        value="{{ $data['generatedData']['price'] ?? $product->price }}">
                                                </div>
                                            </div>
                                            <h6 id="product_price_subtotal">{{ currency($data['price']) }}
                                            </h6>
                                        </li>
                                    </ul>
                                    <div class="billing_orders_subtotal">
                                        <div class="subtotal">
                                            <h5>ট্যাক্স</h5>
                                            <h6 id="total_tax">{{ currency($data['total_tax']) }}</h6>
                                        </div>
                                        <div class="subtotal">
                                            <h5>মোট</h5>
                                            <h6 id="subtotal_price">{{ currency($data['subtotal_price']) }}</h6>
                                        </div>

                                        <div class="subtotal">
                                            <h5>শিপিং চার্জ</h5>
                                            <div class="charge">
                                                @forelse ($shippingRules as $shipping)
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                            id="shipping_{{ $shipping->id }}" name="shipping"
                                                            type="radio" value="{{ $shipping->id }}"
                                                            @checked($loop->first)>
                                                        <label class="form-check-label"
                                                            for="shipping_{{ $shipping->id }}">
                                                            {{ $shipping->name }}
                                                            -
                                                            {{ currency($shipping->price) }}
                                                        </label>
                                                    </div>
                                                @empty
                                                    <li>
                                                        {{ __('No shipping method available') }}
                                                    </li>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="billing_orders_total">
                                        <h5>সর্বমোট</h5>
                                        <h6 id="total_price">{{ currency($data['total_price']) }}</h6>
                                    </div>
                                    <div class="product_payment">
                                        <div class="accordion product_payment_accordion" id="accordionExample">
                                            @forelse (getPaymentMethodsDetails() as $key => $payment)
                                                @if ($payment->status && $key == 'hand_cash')
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse11" type="button"
                                                                aria-expanded="true" aria-controls="collapse11">
                                                                ক্যাশ অন ডেলিভারি
                                                                <input name="payment_method" type="hidden"
                                                                    value="{{ $key }}">
                                                            </button>
                                                        </h2>
                                                        <div class="accordion-collapse collapse show" id="collapse11"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>পণ্য হাতে পেয়ে টাকা পরিশোধ করুন।</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @empty
                                                <div class="col-md-12">
                                                    <div class="form-group payment_method">
                                                        <p>{{ __('No payment method available') }}</p>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="product_payment_btn">
                                        <p>আপনার ব্যক্তিগত তথ্য আপনার অর্ডার প্রক্রিয়া, আপনার অনুভূতি প্রতি সাহায্য
                                            করবে এবং আমাদের
                                            <a href="{{ route('website.privacy.policy') }}">প্রাইভেসি পলিসি</a> এ
                                            বর্ণিত অন্য উদ্দেশ্যে।
                                        </p>
                                        <button class="common_btn" type="submit">
                                            <span id="total_price_btn">অর্ডার করুন
                                                {{ currency($data['total_price']) }}</span>
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
                        <p>{{ $marketing->copyright_text ?? $setting->copyright_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (getSettingStatus('pixel_status'))
        <noscript>
            <img src="https://www.facebook.com/tr?id={{ $setting->pixel_app_id }}&ev=PageView&noscript=1"
                style="display:none" height="1" width="1" />
        </noscript>
    @endif
    <!--jquery library js-->
    <script src="{{ asset('website/ks/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/slick.min.js') }}"></script>
    <script src="{{ asset('website/ks/js/select2.min.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>


    <script>
        @session('message')
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info("{{ $value }}");
                break;
            case 'success':
                toastr.success("{{ $value }}");
                break;
            case 'warning':
                toastr.warning("{{ $value }}");
                break;
            case 'error':
                toastr.error("{{ $value }}");
                break;
        }
        @endsession
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

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
        $(document).ready(function() {
            $(document).on('change', '[name="country_id"]', function() {
                var country_id = $(this).val();
                var form = 'payment_form';

                $.ajax({
                    url: `{{ route('website.get.all.states.by.country', '') }}/${country_id}`,
                    beforeSend: function() {
                        $('.preloader_area').removeClass('d-none');
                        // disable the input
                        $(`#${form} [name="state_id"]`).html(
                            '<option value="" selected disabled>{{ __('Select State') }}</option>'
                        );

                        $(`#${form} [name="state_id"]`).prop('disabled', true);
                    },
                    success: function(response) {
                        $(`#${form} [name="state_id"]`).html('');
                        let options =
                            '<option value="" selected disabled>{{ __('Select State') }}</option>';

                        response.data.forEach(function(state) {
                            options += '<option value="' +
                                state.id +
                                '">' + state.name + '</option>';
                        })
                        $(`#${form} [name="state_id"]`).html(options);
                    },
                    error: function(error) {
                        handleError(error);
                    },
                    complete: function() {
                        $('.preloader_area').addClass('d-none');
                        $(`#${form} [name="state_id"]`).prop('disabled', false);
                    }
                });
            });

            $(document).on('change', '[name="state_id"]', function() {
                var state_id = $(this).val();
                var form = 'payment_form';
                $.ajax({
                    url: `{{ route('website.get.all.cities.by.state', '') }}/${state_id}`,
                    beforeSend: function() {
                        $('.preloader_area').removeClass('d-none');
                        $(`#${form} [name="city_id"]`).html(
                            '<option value="" selected disabled>{{ __('Select City') }}</option>'
                        );

                        $(`#${form} [name="city_id"]`).prop('disabled', true);
                    },
                    success: function(response) {
                        $(`#${form} [name="city_id"]`).html('');

                        let options =
                            '<option value="" selected disabled>{{ __('Select City') }}</option>';

                        response.data.forEach(function(city) {
                            options += '<option value="' +
                                city.id +
                                '">' + city.name + '</option>';
                        })
                        $(`#${form} [name="city_id"]`).html(options);
                    },
                    error: function(error) {
                        handleError(error);
                    },
                    complete: function() {
                        $('.preloader_area').addClass('d-none');
                        $(`#${form} [name="city_id"]`).prop('disabled', false);
                    }
                });
            });

            function getMarketingPrice(id, sku, qty, shipping) {
                $.ajax({
                    url: '{{ route('website.get.marketing.price') }}',
                    type: 'GET',
                    data: {
                        product_id: id,
                        sku: sku,
                        qty: qty,
                        shipping_id: shipping,
                    },
                    success: function(response) {
                        if (response.status) {
                            setData(response);
                        } else {
                            alert('Something went wrong');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Something went wrong');
                    }
                });
            }

            function getData() {
                var productId = $('#product_id').val();
                var sku = $('#product_sku').val();
                var qty = $('#product_qty').val();
                var shipping = $('[name="shipping"]').val();
                return {
                    productId,
                    sku,
                    qty,
                    shipping,
                }
            }

            function setData(data) {
                $('#product_qty').val(data.qty);
                $('#product_price_subtotal').text(data.price_with_currency);
                $('#total_tax').text(data.total_tax_with_currency);
                $('#subtotal_price').text(data.subtotal_price_with_currency);
                $('#total_price').text(data.total_price_with_currency);
                $('#total_price_btn').text(`অর্ডার করুন ` + data.total_price_with_currency);
            }

            $(document).on('change', '.product_variants', function() {
                var name = $(this).data('name');
                var price = $(this).data('price');
                var sku = $(this).val();

                $('#product_name_title').text(name);
                $('#product_sku').val(sku);
                $('#product_price').val(price);

                var data = getData();
                var qty = data.qty;
                var productId = data.productId;
                var sku = data.sku;
                var shipping = data.shipping;

                getMarketingPrice(productId, sku, qty, shipping);
            });

            $(document).on('change', '#product_qty', function() {
                var qty = parseInt($(this).val(), 10);

                if (isNaN(qty) || qty <= 0) {
                    qty = 1;
                    $(this).val(1).trigger('change');
                }

                var data = getData();
                var productId = data.productId;
                var sku = data.sku;
                var shipping = data.shipping;

                getMarketingPrice(productId, sku, qty, shipping);
            });

            $(document).on('change', '[name="shipping"]', function() {
                var data = getData();
                var productId = data.productId;
                var sku = data.sku;
                var shipping = $(this).val();
                var qty = data.qty;

                console.log('shipping', shipping);


                getMarketingPrice(productId, sku, qty, shipping);
            });

            $(document).on('click', '#product_qty_plus', function() {
                var qty = $('#product_qty').val();
                $('#product_qty').val(parseInt(qty) + 1).trigger('change');
            });

            $(document).on('click', '#product_qty_minus', function() {
                var qty = $('#product_qty').val();
                if (parseInt(qty) > 1) {
                    $('#product_qty').val(parseInt(qty) - 1).trigger('change');
                }
            });
        });
    </script>
</body>

</html>
