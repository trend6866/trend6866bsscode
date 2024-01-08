
@extends('layouts.layouts')

@php
$p_name = json_decode($products);
@endphp

@section('page-title')
{{ __($p_name[0]->name) }}
@endsection

@section('content')


@foreach ($products as $product)
   @php
       $description = json_decode($product->other_description);
        foreach ($description as $k => $value)
        {
          $value =  json_decode(json_encode($value), true);

            foreach ($value['inner-list'] as $description_val)
            {
                if($description_val['field_slug'] == 'product-other-description-other-description'){
                    $description_value = $description_val['value'];
                }
                if($description_val['field_slug'] == 'product-other-description-other-description-image'){
                    $description_img = $description_val['image_path'];
                }
                if($description_val['field_slug'] == 'product-other-description-more-informations'){
                    $more_description_value = $description_val['value'];
                }
                if($description_val['field_slug'] == 'product-other-description-more-information-image'){
                    $more_description_img = $description_val['image_path'];
                }
            }
        }
   @endphp

    <section class="product-page-first-section">
            @php
                $product_ids = hashidsencode($product->id);
            @endphp
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 pdp-left-column">
                    <div class="pdp-left-inner-sliders">
                        <div class="main-slider-wrp">
                            <div class="pdp-main-slider lightbox">
                                @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="pdp-main-slider-itm">
                                        <div class="pdp-main-img">
                                            <img src="{{ get_file($item->image_path ,APP_THEME()) }}">
                                            <a href="{{ get_file($item->image_path , APP_THEME()) }}" data-caption="Caption 1"
                                                class="open-lightbox">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                    viewBox="0 0 25 25" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z"
                                                        fill="white" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pdp-thumb-slider common-arrows">
                            @foreach ($product->Sub_image($product->id)['data'] as $item)
                                <div class="pdp-thumb-slider-itm">
                                    <div class="pdp-thumb-img">
                                        <img src="{{ get_file($item->image_path , APP_THEME()) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 pdp-right-column">
                    <div class="pdp-right-column-inner">
                        <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                        fill="white" />
                                </svg>
                            </span>
                            {{ __('Back to category')}}
                        </a>
                        @auth
                            <div class="wishlist">
                                <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                    {{ __('Add to wishlist') }}
                                    <span class="wish-ic">
                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                    </span>
                                </a>
                            </div>
                        @endauth

                        @php
                            $homepage_footer_10_icon = $homepage_footer_10_link = '';

                            $homepage_footer_10 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_10 != '') {
                                $homepage_footer_section_10 = $theme_json[$homepage_footer_10];

                            }

                        @endphp
                        <ul class="social-sharing">
                            <li><span> {{ __('Share') }} :</span></li>
                            @for($i=0 ; $i < $homepage_footer_section_10['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section_10['inner-list'] as $homepage_footer_section_10_value)
                                    {
                                        if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_10_icon = $homepage_footer_section_10_value['field_default_text'];
                                        }
                                        if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link') {
                                        $homepage_footer_10_link = $homepage_footer_section_10_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                        {
                                            if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon'){
                                            $homepage_footer_10_icon = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i]['field_prev_text'];
                                        }
                                        }
                                        if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                        {
                                            if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link'){
                                            $homepage_footer_10_link = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i];
                                        }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{!! $homepage_footer_10_link !!}" target="_blank" class="share-facebook">
                                        <img src="{{asset('/' . $homepage_footer_10_icon)}}" alt="" class="svg pimage">

                                    </a>
                                </li>
                            @endfor
                        </ul>
                        <div class="product-description">
                            <div class="section-title">
                                <h2>{{$product->name}}</h2>
                            </div>
                            <p>{{$product->description}}</p>
                            <form class="variant_form w-100">
                                <div class="prorow-lbl d-flex">
                                    <div class="prorow-lbl-qntty">
                                        <div class="product-labl d-block">{{ __('quantity') }}</div>
                                        <div class="qty-spinner">
                                            <button type="button" class="quantity-decrement change_price">
                                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3"></path>
                                                </svg>
                                            </button>
                                            <input type="text" class="quantity" data-cke-saved-name="quantity"
                                                name="qty" value="01" min="01" max="100">

                                            <button type="button" class="quantity-increment change_price">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                        fill="#61AFB3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="prorow-lbl-color">
                                        @if ($product->variant_product == 1)
                                            @php
                                                $variant = json_decode($product->variant_attribute);
                                                $varint_name_array = [];
                                                if(!empty($product->DefaultVariantData->variant)) {
                                                    $varint_name_array = explode('-', $product->DefaultVariantData->variant);
                                                }
                                            @endphp
                                            @foreach ($variant as $key => $value)
                                                @php
                                                    $p_variant = App\Models\Utility::VariantAttribute($value->attribute_id);
                                                    $attribute = json_decode($p_variant);
                                                @endphp
                                                    <div class="product-labl w-100 mb-11">{{$attribute->name}}</div>
                                                    @if ($attribute->type != 'collection_horizontal')
                                                        <select class="custom-select-btn variont_option" name="varint[{{ $attribute->name }}]">
                                                            @foreach ($value->values as $variant1)
                                                                <option {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }} >{{$variant1}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <div class="boxed">
                                                            @foreach ($value->values as $variant2)
                                                                <input type="radio" id="{{$variant2}}" name="varint[{{ $attribute->name }}]" value="{{$variant2}}" class="custom-radio-btn variont_option"
                                                                {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}
                                                                >
                                                                <label for="{{$variant2}}">{{$variant2}}</label>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="product-detail-bttom-stuff">
                            <div class="price">
                                <ins>
                                    <span class="product_final_price"> {{ $product->final_price }} </span>
                                    <span class="currency-type">{{ $currency }}</span>
                                </ins>
                                <del class="product_orignal_price">{{ $product->original_price }}</del>
                                <div class="tax-price">{{ __('Tax') }}: <span class="product_tax_price">2.99 {{ $currency }}</span> </div>
                            </div>
                            <button class="btna addcart-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                {{ __('Add to cart')}}
                                <svg viewBox="0 0 10 5">
                                    <path
                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                            </button>
                            <button class="buy-now-btn">{{ __('Buy it now')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-description-gallery-section padding-bottom padding-top">
        <div class="container">
            <div class="row align-item-center">
                <div class="col-md-6 col-12">
                    <div class="pro-descrip-contente-left">
                        <h2>{{ __('DESCRIPTION') }}:</h2>
                        <p>{!! $description_value !!}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="pro-descrip-contente-right">
                        <h2>{{ __('GALLERY') }}:</h2>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($description_img , APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($description_img , APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($description_img , APP_THEME()) }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-description-gallery-section padding-bottom ">
        <div class="container">
            <div class="row row-reverse align-item-center">
                <div class="col-md-6 col-12">
                    <div class="pro-descrip-contente-left">
                        <h2>{{ __('MORE DESCRIPTION') }}:</h2>
                        <p>{!! $more_description_value !!}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="pro-descrip-contente-right">
                        <h2>{{ __('GALLERY') }}:</h2>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($more_description_img , APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($more_description_img , APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 pro-gallery">
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($more_description_img , APP_THEME()) }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@php
    $homepage_variant_section1_heading = $homepage_variant_section1_subtext = '';

    $homepage_variant_section_key1 = array_search('homepage-variant-section-1', array_column($theme_json, 'unique_section_slug'));
    if($homepage_variant_section_key1 != '') {
        $homepage_variant_section1 = $theme_json[$homepage_variant_section_key1];

    foreach ($homepage_variant_section1['inner-list'] as $key => $value) {
        if($value['field_slug'] == 'homepage-variant-section-heading') {
        $homepage_variant_section1_heading = $value['field_default_text'];
        }
        if($value['field_slug'] == 'homepage-variant-section-sub-text') {
        $homepage_variant_section1_subtext = $value['field_default_text'];
        }
    }
    }

    $homepage_variant_section2_icon_img = $homepage_variant_section2_title =  '';

    $homepage_variant_section_key2 = array_search('homepage-variant-section-2', array_column($theme_json, 'unique_section_slug'));
    if($homepage_variant_section_key2 != '') {
        $homepage_variant_section2 = $theme_json[$homepage_variant_section_key2];

    }
@endphp
<div class="wrapper home-bg">
    <section class="pro-two-column">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-sm-5 col-12">
                    <div class="two-column-variant-right">
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    @php
                                        $p_id = hashidsencode($latest_product->id);
                                    @endphp
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{get_file($latest_product->cover_image_path , APP_THEME())}}" class="default-img">
                                    @if ($latest_product->Sub_image($latest_product->id)['status'] == true)
                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id)['data'][0]->image_path , APP_THEME()) }}"
                                            class="hover-img">
                                    @else
                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id) , APP_THEME()) }}" class="hover-img">
                                    @endif
                                    </a>
                                </div>
                                <div class="product-content" >
                                    <div class="product-content-top">
                                        <h2 class="product-title">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                {{ $latest_product->name }}
                                            </a>
                                        </h2>
                                        <div class="product-type">{{ $latest_product->ProductData()->name }} / {{ $latest_product->SubCategoryctData->name }}</div>
                                    </div>
                                    <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                        <div class="price">
                                            <ins>{{ $latest_product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                            <del>{{ $latest_product->final_price }}</del>
                                        </div>
                                        <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $latest_product->id }}" variant_id="{{ $latest_product->default_variant_id }}" qty="1">
                                            <span> {{ __('Add to cart') }} </span>
                                            <svg viewBox="0 0 10 5">
                                                <path
                                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-12">
                    <div class="pro-two-column-content">
                        <div class="section-title">
                            {!! $homepage_variant_section1_heading !!}
                        </div>
                        <p>{!! $homepage_variant_section1_subtext !!}</p>
                        <ul class="stylelist">
                            @for($i=0 ; $i < $homepage_variant_section2['loop_number'];$i++)
                                @php
                                    foreach ($homepage_variant_section2['inner-list'] as $homepage_variant_section2_value)
                                    {
                                        if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-icon-image') {
                                        $homepage_variant_section2_icon_img = $homepage_variant_section2_value['field_default_text'];
                                        }
                                        if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-title') {
                                        $homepage_variant_section2_title = $homepage_variant_section2_value['field_default_text'];
                                        }

                                        if(!empty($homepage_variant_section2[$homepage_variant_section2_value['field_slug']])){
                                            if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-icon-image'){
                                            $homepage_variant_section2_icon_img = $homepage_variant_section2[$homepage_variant_section2_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-title'){
                                                $homepage_variant_section2_title = $homepage_variant_section2[$homepage_variant_section2_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li class="active">
                                    <div class="list-ic">
                                        <img src="{{asset($homepage_variant_section2_icon_img)}}" alt="">
                                    </div>
                                    {!! $homepage_variant_section2_title !!}
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="wrapper product-page">
    @if($product_review->isNotEmpty())
        <section class="testimonial-section padding-top">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('Testimonials')}}</h2>
                </div>
                <div class="testimonial-slider flex-slider">
                    @foreach ($product_review as $review)
                        <div class="testimonial-itm card">
                            <div class="review-itm-inner card-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25" fill="none">
                                    <path d="M3.80435 12.3188C4.45654 14.0814 5.84618 15.471 7.6087 16.1232C5.84618 16.7754 4.45654 18.165 3.80435 19.9275C3.15216 18.165 1.76252 16.7754 0 16.1232C1.76252 15.471 3.15216 14.0814 3.80435 12.3188Z" fill="#183A40"/>
                                    <path d="M14.3113 0C15.5225 3.27325 18.1033 5.85401 21.3765 7.06522C18.1033 8.27643 15.5225 10.8572 14.3113 14.1304C13.1001 10.8572 10.5193 8.27643 7.24609 7.06522C10.5193 5.85401 13.1001 3.27325 14.3113 0Z" fill="#183A40"/>
                                    <path d="M9.51396 20.8332C10.7728 20.1426 11.8091 19.1063 12.4997 17.8475C13.1902 19.1063 14.2266 20.1426 15.4854 20.8332C14.2266 21.5237 13.1902 22.5601 12.4997 23.8189C11.8091 22.5601 10.7728 21.5237 9.51396 20.8332Z" stroke="#183A40" stroke-width="0.983051"/>
                                </svg>
                                <p >{{$review->description}}</p>
                                <div class="review-botton d-flex align-items-center">
                                    <div class="about-user d-flex align-items-center">
                                        <div class="abt-user-img">
                                            <img src="{{asset('themes/'.APP_THEME().'/assets/images/john.png')}}">
                                        </div>
                                        <h6>
                                            <span>{{__('John Doe,')}}</span>
                                            {{__('company.com')}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
    @php
        $homepage_best_seller_heading = $homepage_best_seller_btn = '';

        $homepage_best_seller_key = array_search('homepage-bestsellers', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_seller_key != '') {
            $homepage_best_seller = $theme_json[$homepage_best_seller_key];
            foreach ($homepage_best_seller['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-bestsellers-heading') {
                    $homepage_best_seller_heading = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-bestsellers-button') {
                    $homepage_best_seller_btn = $value['field_default_text'];
                }
            }

        }
    @endphp

    <section class="our-bestseller-section padding-bottom padding-top">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                {!! $homepage_best_seller_heading !!}
                <a href="{{route('page.product-list',$slug)}}" class="btn-secondary">
                    {!! $homepage_best_seller_btn !!}
                    <svg viewBox="0 0 10 5">
                        <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="bestsell-cat-slider common-arrows">
                @foreach ($bestSeller as $bs_product)
                    <div class="best-sell-cat-item product-card">
                        @php
                            $p_id = hashidsencode($bs_product->id);
                        @endphp
                        <div class="product-card-inner">
                            <div class="product-card-image">
                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                    <img src="{{ get_file($bs_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                        @if ($bs_product->Sub_image($bs_product->id)['status'] == true)
                                            <img src="{{ get_file($bs_product->Sub_image($bs_product->id)['data'][0]->image_path , APP_THEME()) }}"
                                                class="hover-img">
                                        @else
                                            <img src="{{ get_file($bs_product->Sub_image($bs_product->id) , APP_THEME()) }}" class="hover-img">
                                        @endif
                                </a>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <h3 class="product-title">
                                        <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                            {{ $bs_product->name }}
                                        </a>
                                    </h3>
                                    <div class="product-type">{{ $bs_product->ProductData()->name }} /
                                        {{ $bs_product->SubCategoryctData->name }}</div>
                                </div>
                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                    <div class="price">
                                        <ins>{{ $bs_product->final_price }} <span
                                                class="currency-type">{{ $currency }}</span></ins>
                                        <del>{{ $bs_product->original_price }}</del>
                                    </div>
                                    <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $bs_product->id }}" variant_id="{{ $bs_product->default_variant_id }}" qty="1">
                                        {{ __('Add to cart') }}
                                        <svg viewBox="0 0 10 5">
                                            <path
                                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endforeach

@endsection

@push('page-script')

<script type="text/javascript">
    $(document).ready(function(){
        product_price();
    });

    $(document).on('change', '.variont_option', function(e){
        product_price();
    });

    $(document).on('click', '.change_price', function(e){
        product_price();
    });

    function product_price() {
        var data = $('.variant_form').serialize();
        var data = data+'&product_id={{$product->id}}';

        $.ajax({
            url: '{{ route('product.price',$slug) }}',
            method: 'POST',
            data: data,
            context:this,
            success: function (response)
            {
                $('.addcart-btn.addcart-btn-globaly').attr('variant_id', '0');
                if (response.status == 'error') {
                    show_toastr('Error', response.message, 'error');
                    $('.quantity').val(response.qty);
                } else {
                    console.log(response.product_original_price,response.currency_name,response.original_price);
                    $('.product_final_price').html(response.product_original_price);
                    $('.currency-type').html(response.currency_name);
                    $('.product_orignal_price').html(response.original_price);
                    $('.product_tax_price').html(response.total_tax_price + ' ' + response.currency_name);
                    $('.addcart-btn.addcart-btn-globaly').attr('variant_id', response.variant_id);
                    $('.addcart-btn.addcart-btn-globaly').attr('qty', response.qty);
                }
            }
        });
    }
</script>

@endpush

