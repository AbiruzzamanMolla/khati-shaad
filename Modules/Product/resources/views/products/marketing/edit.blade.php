@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Product Marketing Details') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Edit Product Marketing Details') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.product.index') }}">{{ __('Product List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Edit Product Marketing Details') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Edit Marketing Details') }}</h4>
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <input type="text" id="" class="form-control"
                                            value="{{ route('website.product.marketing-details', $product->slug) }}">
                                        <a class="btn btn-primary m-1"
                                            href="{{ route('website.product.marketing-details', $product->slug) }}">{{ __('Visit') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.product.marketing-details.store', $product->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        {{-- Navbar Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>{{ __('Navbar Settings') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Home Text') }}</label>
                                                                <input class="form-control" name="nav_home_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->nav_home_text ?? 'Home' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Home URL') }}</label>
                                                                <input class="form-control" name="nav_home_url"
                                                                    type="text"
                                                                    value="{{ filled($marketing_detail->nav_home_url) ? $marketing_detail->nav_home_url : route('website.home') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Product Text') }}</label>
                                                                <input class="form-control" name="nav_product_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->nav_product_text ?? 'Product' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Product URL') }}</label>
                                                                <input class="form-control" name="nav_product_url"
                                                                    type="text"
                                                                    value="{{ filled($marketing_detail->nav_product_url) ? $marketing_detail->nav_product_url : route('website.products') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Contact Text') }}</label>
                                                                <input class="form-control" name="nav_contact_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->nav_contact_text ?? 'Contact' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Contact URL') }}</label>
                                                                <input class="form-control" name="nav_contact_url"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->nav_contact_url ?? '#' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Hotline Number') }}</label>
                                                                <input class="form-control" name="nav_hotline_number"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->nav_hotline_number ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- SEO Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary">
                                                    <h4 class="text-white">{{ __('SEO Settings') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('SEO Title') }}</label>
                                                                <input class="form-control" name="seo_title" type="text"
                                                                    value="{{ $marketing_detail->seo_title ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('SEO Keywords') }}</label>
                                                                <input class="form-control" name="seo_keywords"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->seo_keywords ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('SEO Description') }}</label>
                                                                <textarea class="form-control" name="seo_description" rows="3">{{ $marketing_detail->seo_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('SEO Image') }}</label>
                                                                <input class="form-control" name="seo_image"
                                                                    type="file">
                                                                @if ($marketing_detail->seo_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->seo_image) }}"
                                                                            alt="SEO Image" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Banner Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary d-flex justify-content-between">
                                                    <h4 class="text-white">{{ __('Banner Section') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="banner_status" name="banner_status"
                                                            data-toggle="toggle" data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="success"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->banner_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Title') }}</label>
                                                                <input class="form-control" name="banner_title"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->banner_title ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Phone Title') }}</label>
                                                                <input class="form-control" name="banner_phone_title"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->banner_phone_title ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Phone') }}</label>
                                                                <input class="form-control" name="banner_phone"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->banner_phone ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Background Image') }}</label>
                                                                <input class="form-control" name="banner_bg_image"
                                                                    type="file">
                                                                @if ($marketing_detail->banner_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->banner_bg_image) }}"
                                                                            alt="Banner Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Image') }}</label>
                                                                <input class="form-control" name="banner_image"
                                                                    type="file">
                                                                @if ($marketing_detail->banner_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->banner_image) }}"
                                                                            alt="Banner Image" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Section Two --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-info">
                                                <div class="card-header bg-info">
                                                    <h4 class="text-white">{{ __('Section Two (Features)') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="section_two_status" name="section_two_status"
                                                            data-toggle="toggle" data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="success"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->section_two_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input class="form-control" name="section_two_heading"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_two_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea class="form-control summernote" name="section_two_description">{{ $marketing_detail->section_two_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input class="form-control" name="section_two_btn_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_two_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input class="form-control" name="section_two_btn_url"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_two_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Image') }}</label>
                                                                <input class="form-control" name="section_two_image"
                                                                    type="file">
                                                                @if ($marketing_detail->section_two_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_two_image) }}"
                                                                            alt="Section Two Image" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Section Three --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-warning">
                                                <div class="card-header bg-warning">
                                                    <h4 class="text-white">{{ __('Section Three (Identification)') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="section_three_status" name="section_three_status"
                                                            data-toggle="toggle" data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="success"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->section_three_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Background Image') }}</label>
                                                                <input class="form-control" name="section_three_bg_image"
                                                                    type="file">
                                                                @if ($marketing_detail->section_three_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_three_bg_image) }}"
                                                                            alt="Section Three Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input class="form-control" name="section_three_heading"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_three_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea class="form-control summernote" name="section_three_description">{{ $marketing_detail->section_three_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input class="form-control" name="section_three_btn_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_three_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input class="form-control" name="section_three_btn_url"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_three_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Section Four --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-success">
                                                <div class="card-header bg-success">
                                                    <h4 class="text-white">{{ __('Section Four (Why Choose Us)') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="section_four_status" name="section_four_status"
                                                            data-toggle="toggle" data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="primary"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->section_four_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Image') }}</label>
                                                                <input class="form-control" name="section_four_image"
                                                                    type="file">
                                                                @if ($marketing_detail->section_four_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_four_image) }}"
                                                                            alt="Section Four Image" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input class="form-control" name="section_four_heading"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_four_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea class="form-control summernote" name="section_four_description">{{ $marketing_detail->section_four_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input class="form-control" name="section_four_btn_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_four_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input class="form-control" name="section_four_btn_url"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->section_four_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- FAQ Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary">
                                                    <h4 class="text-white">{{ __('FAQ Section') }}</h4>
                                                    <div class="card-header-action">
                                                        <button class="btn btn-success ml-2" id="add_faq_row"
                                                            type="button"><i class="fa fa-plus"></i>
                                                            {{ __('Add FAQ') }}</button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>{{ __('FAQ Heading') }}</label>
                                                                <input class="form-control" name="faq_heading"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->faq_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>{{ __('Status') }}</label>
                                                                <div>
                                                                    <input id="faq_status" name="faq_status"
                                                                        data-toggle="toggle"
                                                                        data-onlabel="{{ __('Show') }}"
                                                                        data-offlabel="{{ __('Hide') }}"
                                                                        data-onstyle="primary" data-offstyle="danger"
                                                                        type="checkbox"
                                                                        {{ $marketing_detail->faq_status ? 'checked' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="faq_items_container">
                                                        @if (isset($marketing_detail->faqs))
                                                            @php
                                                                $faqs = is_array($marketing_detail->faqs)
                                                                    ? $marketing_detail->faqs
                                                                    : json_decode($marketing_detail->faqs, true);
                                                            @endphp
                                                            @foreach ($faqs ?? [] as $index => $faq)
                                                                <div class="row border p-3 mb-2"
                                                                    id="faq_row_{{ $index }}">
                                                                    <div class="col-md-5">
                                                                        <label>{{ __('Question') }}</label>
                                                                        <input class="form-control"
                                                                            name="faqs[{{ $index }}][question]"
                                                                            type="text"
                                                                            value="{{ $faq['question'] ?? '' }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label>{{ __('Answer') }}</label>
                                                                        <textarea class="form-control" name="faqs[{{ $index }}][answer]">{{ $faq['answer'] ?? '' }}</textarea>
                                                                    </div>
                                                                    <div class="col-md-2 d-flex align-items-center">
                                                                        <button class="btn btn-danger remove_faq_row"
                                                                            data-id="{{ $index }}"
                                                                            type="button"><i
                                                                                class="fa fa-trash"></i></button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Offer Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary ">
                                                    <h4 class="text-white">{{ __('Offer Section') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="offer_status" name="offer_status" data-toggle="toggle"
                                                            data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="success"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->offer_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Background Image') }}</label>
                                                                <input class="form-control" name="offer_bg_image"
                                                                    type="file">
                                                                @if ($marketing_detail->offer_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->offer_bg_image) }}"
                                                                            alt="Offer Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Offer Text 1 (Pre-Price)') }}</label>
                                                                <input class="form-control" name="offer_text_1"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_text_1 ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Old Price') }}</label>
                                                                <input class="form-control" name="offer_old_price"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_old_price ?? '' }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Offer Text 2 (Price Label)') }}</label>
                                                                <input class="form-control" name="offer_text_2"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_text_2 ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Current Price') }}</label>
                                                                <input class="form-control" name="offer_current_price"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_current_price ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Offer Text 3 (Post-Price)') }}</label>
                                                                <input class="form-control" name="offer_text_3"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_text_3 ?? '' }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input class="form-control" name="offer_btn_text"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input class="form-control" name="offer_btn_url"
                                                                    type="text"
                                                                    value="{{ $marketing_detail->offer_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Reviews Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary">
                                                    <h4 class="text-white">{{ __('Reviews Section') }}</h4>
                                                    <div class="card-header-action">
                                                        <input id="review_status" name="review_status"
                                                            data-toggle="toggle" data-onlabel="{{ __('Show') }}"
                                                            data-offlabel="{{ __('Hide') }}" data-onstyle="success"
                                                            data-offstyle="danger" type="checkbox"
                                                            {{ $marketing_detail->review_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('Review Heading') }}</label>
                                                        <input class="form-control" name="review_heading" type="text"
                                                            value="{{ $marketing_detail->review_heading ?? '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Review Images (Select Multiple)') }}</label>
                                                        <input class="form-control" name="review_images[]" type="file"
                                                            multiple>
                                                        @if ($marketing_detail->review_images)
                                                            <div class="mt-2 row">
                                                                @foreach ($marketing_detail->review_images as $img)
                                                                    <div class="col-md-2">
                                                                        <img class="img-fluid border"
                                                                            src="{{ asset($img) }}" width="100">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Checkout/Footer Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary">
                                                    <h4 class="text-white">{{ __('Checkout & Footer') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('Checkout Heading') }}</label>
                                                        <input class="form-control" name="checkout_heading"
                                                            type="text"
                                                            value="{{ $marketing_detail->checkout_heading ?? '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Copyright Text') }}</label>
                                                        <input class="form-control" name="copyright_text" type="text"
                                                            value="{{ $marketing_detail->copyright_text ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('Update Details') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var faqIndex =
                {{ isset($marketing_detail->faqs) && is_array($marketing_detail->faqs) ? count($marketing_detail->faqs) : 0 }};
            var productIndex =
                {{ isset($marketing_detail->checkout_products) && is_array($marketing_detail->checkout_products) ? count($marketing_detail->checkout_products) : 0 }};

            $('#add_faq_row').on('click', function() {
                var html = `
                    <div class="row border p-3 mb-2" id="faq_row_${faqIndex}">
                        <div class="col-md-5">
                            <label>{{ __('Question') }}</label>
                            <input type="text" name="faqs[${faqIndex}][question]" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label>{{ __('Answer') }}</label>
                            <textarea name="faqs[${faqIndex}][answer]" class="form-control"></textarea>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                             <button type="button" class="btn btn-danger remove_faq_row" data-id="${faqIndex}"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                `;
                $('#faq_items_container').append(html);
                faqIndex++;
            });

            $(document).on('click', '.remove_faq_row', function() {
                var id = $(this).data('id');
                $('#faq_row_' + id).remove();
            });

            // Product Row Script
            $('#add_product_row').on('click', function() {
                var html = `
                    <div class="row border p-3 mb-2" id="product_row_${productIndex}">
                        <div class="col-md-3">
                            <label>{{ __('Product Title') }}</label>
                            <input type="text" name="checkout_products[${productIndex}][title]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>{{ __('Price') }}</label>
                            <input type="text" name="checkout_products[${productIndex}][price]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>{{ __('Description') }}</label>
                            <input type="text" name="checkout_products[${productIndex}][description]" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="checkout_products[${productIndex}][image]" class="form-control">
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                             <button type="button" class="btn btn-danger remove_product_row" data-id="${productIndex}"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                `;
                $('#product_items_container').append(html);
                productIndex++;
            });

            $(document).on('click', '.remove_product_row', function() {
                var id = $(this).data('id');
                $('#product_row_' + id).remove();
            });
        });
    </script>
@endpush
