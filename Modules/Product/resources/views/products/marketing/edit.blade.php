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
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.product.index') }}">{{ __('Product List') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Edit Product Marketing Details') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Edit Marketing Details') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.product.marketing-details.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        {{-- Banner Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h4>{{ __('Banner Section') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Title') }}</label>
                                                                <input type="text" name="banner_title" class="form-control" value="{{ $marketing_detail->banner_title ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Phone Title') }}</label>
                                                                <input type="text" name="banner_phone_title" class="form-control" value="{{ $marketing_detail->banner_phone_title ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Phone') }}</label>
                                                                <input type="text" name="banner_phone" class="form-control" value="{{ $marketing_detail->banner_phone ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Background Image') }}</label>
                                                                <input type="file" name="banner_bg_image" class="form-control">
                                                                @if($marketing_detail->banner_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->banner_bg_image) }}" alt="Banner Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Banner Image') }}</label>
                                                                <input type="file" name="banner_image" class="form-control">
                                                                @if($marketing_detail->banner_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->banner_image) }}" alt="Banner Image" width="100">
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
                                                <div class="card-header bg-info text-white">
                                                    <h4>{{ __('Section Two (Features)') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input type="text" name="section_two_heading" class="form-control" value="{{ $marketing_detail->section_two_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="section_two_description" class="form-control summernote">{{ $marketing_detail->section_two_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input type="text" name="section_two_btn_text" class="form-control" value="{{ $marketing_detail->section_two_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input type="text" name="section_two_btn_url" class="form-control" value="{{ $marketing_detail->section_two_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Image') }}</label>
                                                                <input type="file" name="section_two_image" class="form-control">
                                                                @if($marketing_detail->section_two_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_two_image) }}" alt="Section Two Image" width="100">
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
                                                <div class="card-header bg-warning text-white">
                                                    <h4>{{ __('Section Three (Identification)') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Background Image') }}</label>
                                                                <input type="file" name="section_three_bg_image" class="form-control">
                                                                @if($marketing_detail->section_three_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_three_bg_image) }}" alt="Section Three Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input type="text" name="section_three_heading" class="form-control" value="{{ $marketing_detail->section_three_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="section_three_description" class="form-control summernote">{{ $marketing_detail->section_three_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input type="text" name="section_three_btn_text" class="form-control" value="{{ $marketing_detail->section_three_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input type="text" name="section_three_btn_url" class="form-control" value="{{ $marketing_detail->section_three_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Section Four --}}
                                        <div class="col-12 mb-4">
                                            <div class="card border-success">
                                                <div class="card-header bg-success text-white">
                                                    <h4>{{ __('Section Four (Why Choose Us)') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Image') }}</label>
                                                                <input type="file" name="section_four_image" class="form-control">
                                                                @if($marketing_detail->section_four_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->section_four_image) }}" alt="Section Four Image" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Heading') }}</label>
                                                                <input type="text" name="section_four_heading" class="form-control" value="{{ $marketing_detail->section_four_heading ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="section_four_description" class="form-control summernote">{{ $marketing_detail->section_four_description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input type="text" name="section_four_btn_text" class="form-control" value="{{ $marketing_detail->section_four_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input type="text" name="section_four_btn_url" class="form-control" value="{{ $marketing_detail->section_four_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- FAQ Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>{{ __('FAQ Section') }}</h4>
                                                    <div class="card-header-action">
                                                        <button type="button" class="btn btn-success" id="add_faq_row"><i class="fa fa-plus"></i> {{ __('Add FAQ') }}</button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('FAQ Heading') }}</label>
                                                        <input type="text" name="faq_heading" class="form-control" value="{{ $marketing_detail->faq_heading ?? '' }}">
                                                    </div>
                                                    <div id="faq_items_container">
                                                        @if(isset($marketing_detail->faqs) && is_array($marketing_detail->faqs))
                                                            @foreach($marketing_detail->faqs as $index => $faq)
                                                                <div class="row border p-3 mb-2" id="faq_row_{{ $index }}">
                                                                    <div class="col-md-5">
                                                                        <label>{{ __('Question') }}</label>
                                                                        <input type="text" name="faqs[{{ $index }}][question]" class="form-control" value="{{ $faq['question'] ?? '' }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label>{{ __('Answer') }}</label>
                                                                        <textarea name="faqs[{{ $index }}][answer]" class="form-control">{{ $faq['answer'] ?? '' }}</textarea>
                                                                    </div>
                                                                    <div class="col-md-2 d-flex align-items-center">
                                                                        <button type="button" class="btn btn-danger remove_faq_row" data-id="{{ $index }}"><i class="fa fa-trash"></i></button>
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
                                                <div class="card-header bg-primary text-white">
                                                    <h4>{{ __('Offer Section') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Background Image') }}</label>
                                                                <input type="file" name="offer_bg_image" class="form-control">
                                                                @if($marketing_detail->offer_bg_image)
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($marketing_detail->offer_bg_image) }}" alt="Offer Background" width="100">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                             <div class="form-group">
                                                                <label>{{ __('Offer Text 1 (Pre-Price)') }}</label>
                                                                <input type="text" name="offer_text_1" class="form-control" value="{{ $marketing_detail->offer_text_1 ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Old Price') }}</label>
                                                                <input type="text" name="offer_old_price" class="form-control" value="{{ $marketing_detail->offer_old_price ?? '' }}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Offer Text 2 (Price Label)') }}</label>
                                                                <input type="text" name="offer_text_2" class="form-control" value="{{ $marketing_detail->offer_text_2 ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Current Price') }}</label>
                                                                <input type="text" name="offer_current_price" class="form-control" value="{{ $marketing_detail->offer_current_price ?? '' }}">
                                                            </div>
                                                        </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Offer Text 3 (Post-Price)') }}</label>
                                                                <input type="text" name="offer_text_3" class="form-control" value="{{ $marketing_detail->offer_text_3 ?? '' }}">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button Text') }}</label>
                                                                <input type="text" name="offer_btn_text" class="form-control" value="{{ $marketing_detail->offer_btn_text ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ __('Button URL') }}</label>
                                                                <input type="text" name="offer_btn_url" class="form-control" value="{{ $marketing_detail->offer_btn_url ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Reviews Section --}}
                                        <div class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>{{ __('Reviews Section') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('Review Heading') }}</label>
                                                        <input type="text" name="review_heading" class="form-control" value="{{ $marketing_detail->review_heading ?? '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Review Images (Select Multiple)') }}</label>
                                                        <input type="file" name="review_images[]" class="form-control" multiple>
                                                        @if($marketing_detail->review_images)
                                                            <div class="mt-2 row">
                                                                @foreach(json_decode($marketing_detail->review_images) as $img)
                                                                    <div class="col-md-2">
                                                                        <img src="{{ asset($img) }}" class="img-fluid border" width="100">
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
                                                <div class="card-header">
                                                    <h4>{{ __('Checkout & Footer') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('Checkout Heading') }}</label>
                                                        <input type="text" name="checkout_heading" class="form-control" value="{{ $marketing_detail->checkout_heading ?? '' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Copyright Text') }}</label>
                                                        <input type="text" name="copyright_text" class="form-control" value="{{ $marketing_detail->copyright_text ?? '' }}">
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
            var faqIndex = {{ isset($marketing_detail->faqs) ? count($marketing_detail->faqs) : 0 }};

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
        });
    </script>
@endpush
