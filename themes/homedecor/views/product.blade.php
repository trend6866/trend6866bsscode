
@extends('layouts.layouts')

@php
$p_name = json_decode($products);
@endphp

@section('page-title')
{{ __($p_name[0]->name) }}
@endsection

@section('content')
<style>
    .nice-select
    {
        color:black;
    }
</style>

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

    <div class="wrapper">
        <section class="product-page-first-section">
            @php
                $product_ids = hashidsencode($product->id);
            @endphp
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-lg-4 col-md-6 col-12 pdp-left-column">
                        <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                        fill="white"></path>
                                </svg>
                            </span>
                            {{ __('Back to category')}}
                        </a>
                        <div class="pdp-left-inner-sliders">
                            <div class="main-slider-wrp">
                                <div class="pdp-main-slider lightbox">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-main-slider-itm">
                                            <div class="pdp-main-img">
                                                <img src="{{ get_file($item->image_path ,APP_THEME()) }}" alt="lamp">
                                                <a href="{{ get_file($item->image_path , APP_THEME()) }}" data-caption="Caption 5"
                                                    class="open-lightbox" class="product-img">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                        viewBox="0 0 25 25" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="pdp-thumb-slider common-arrows">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-thumb-slider-itm">
                                            <div class="pdp-thumb-img">
                                                <img src="{{ get_file($item->image_path , APP_THEME()) }}" alt="product">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-12  pdp-right-column">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 pdp-right-inner">
                                <div class="pdp-right-column-inner">
                                    @auth
                                        <a href="javascript:void(0)" class="back-btn wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                            <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                            {{ __('Add to wishlist') }}
                                        </a>
                                    @endauth
                                    <div class="product-description">
                                        <div class="review-star">
                                            <span>{{$product->ProductData()->name}}</span>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="section-title">
                                            <h2>{{$product->name}}</h2>
                                        </div>
                                        <p>{{$product->description}}</p>
                                    </div>
                                    <form class="variant_form w-100">
                                        @csrf
                                        <div class="prorow-lbl-qntty">
                                            <div class="product-labl d-block">{{__('quantity')}} :</div>
                                            <div class="qty-spinner" style="background: white;">
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
                                        </div><br>

                                        <div class="product-detail-bttom-stuff">
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
                                                <div class="pro-labl">
                                                    {{$attribute->name}}
                                                </div>
                                                @if ($attribute->type != 'collection_horizontal')
                                                    <select class="custom-select-btn variont_option" name="varint[{{ $attribute->name }}]" >
                                                        @foreach ($value->values as $variant1)
                                                            <option {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }} >{{$variant1}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <div class="color-swatch-variants d-flex">
                                                        @foreach ($value->values as $variant2)
                                                        <div class="boxed">
                                                            <input type="radio" id="{{$variant2}}" name="varint[{{ $attribute->name }}]" value="{{$variant2}}" class="variont_option"
                                                            {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}>
                                                            <label for="{{$variant2}}">{{$variant2}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                            @endif
                                            <div class="price">
                                                <ins><span class="product_final_price"> {{ $product->final_price }} </span>
                                                    <span class="currency-type">{{ $currency }}</span>
                                            </div>
                                            <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                                {{ __('Add to cart') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                    viewBox="0 0 4 6" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                        fill=""></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 pdp-right-inner">
                                <div class="pdp-right-column-inner">
                                    <div class="product-description  position-relative">
                                        <img src="{{asset('themes/'.APP_THEME().'/assets/images/pdt-right.png')}}" alt="bed">
                                        <div class="home-banner-content">
                                            <div class="home-banner-content-inner">
                                                <p>{{__('Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry.')}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-detail-bttom-stuff">
                                        @if($product_stocks->isNotEmpty())
                                            <div class="about-product">
                                                <h5>{{__('About Product')}}:</h5>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <ul>
                                                        <li>{{__('SKU')}}:   @foreach($product_stocks as $product_stock)<b >{{$product_stock->sku}},</b>@endforeach</li>
                                                        <li>{{__('Category')}}:{{ $product->ProductData()->name }}</li>
                                                    </ul>
                                                    <ul>
                                                        <li>{{__('Size')}}:  @foreach($product_stocks as $product_stock)<b>{{$product_stock->variant}},</b>@endforeach</li>
                                                        {{-- <li>Weight: 60 lbs</li> --}}
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        <h5>{{ __('DESCRIPTION') }}:</h5>
                                        <p>{!! $description_value !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @php
        $homepage_banner_section_heading = $homepage_banner_section_subtext = $homepage_banner_section_btn = '';
            $homepage_banner_section_key = array_search('homepage-banner-section', array_column($theme_json, 'unique_section_slug'));
            if($homepage_banner_section_key != ''){
                $homepage_banner_section = $theme_json[$homepage_banner_section_key];

                foreach ($homepage_banner_section['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-banner-section-title-text'){
                        $homepage_banner_section_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-banner-section-sub-text'){
                        $homepage_banner_section_subtext = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-banner-section-btn-text'){
                        $homepage_banner_section_btn_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-banner-section-bg-img'){
                        $homepage_banner_section_img = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_banner_section['section_enable'] == 'on')
        <section class="two-col-variant-section two-col-variant-section-pdp-page">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12">
                        <div class="two-column-variant-left-content">
                            <div class="section-title">
                                <h2>{!! $homepage_banner_section_title !!}</h2>
                            </div>
                            <p>{!! $homepage_banner_section_subtext !!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-second-color">
                                {!! $homepage_banner_section_btn_text !!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                        fill=""></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="two-column-variant-right">
                            <img src="{{get_file($homepage_banner_section_img , APP_THEME())}}" alt="product">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <section class="best-product-section best-product-section-pdp-page">
            <div class="offset-container offset-left">
                <div class="best-product-slider">
                    @foreach ($homeproducts as $all_product)
                    @php
                        $p_id = hashidsencode($all_product->id);
                    @endphp
                    <div class="best-pro-item">
                        <div class="product-card-inner">
                            <div class="product-card-image">
                                <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                    <img src="{{get_file($all_product->cover_image_path , APP_THEME())}}" alt="bestproduct">
                                    <div class="new-labl">
                                        {{$all_product->ProductData()->name}}
                                    </div>
                                </a>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <h3 class="product-title">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                <b>{{$all_product->name}}</b>
                                            </a>
                                        </h3>
                                    </div>
                                    <a href="{{route('page.product-list',$slug)}}" class="link-btn"
                                        tabindex="0">
                                        {{__('Show more')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill=""></path>
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
        <section class="two-col-variant-section-two two-col-variant-section-two-pdp-page">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2>{{__('Show more')}}</h2>
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color m-0 w-100" tabindex="0">
                        {{__('Show more products')}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill=""></path>
                        </svg>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-4 col-12 d-flex">
                        <div class="columnl-left-media-inner">
                            <div class="decorative-text">
                                {{-- {{__('CHAIRS')}} --}}
                            </div>
                            <img src="{{asset('themes/'.APP_THEME().'/assets/images/sec-7-2.png')}}" alt="room">
                            <div class="column-left-media-content">
                                <div class="section-title">
                                    <h3>{{__('Living Room
                                        Accessories')}}</h3>
                                </div>
                                <a href="{{route('page.product-list',$slug)}}" class="link-btn" tabindex="0">
                                    {{__('Show More')}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="row h-100">
                            @foreach($homeproducts->take(2) as $h_product)
                                @php
                                    $p_id = hashidsencode($h_product->id);
                                @endphp
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex">
                                    <div class="columnl-right-caption-inner w-100">
                                        <div class="product-card-inner">
                                            <div class="product-card-image">
                                                <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                                    <img src="{{get_file($h_product->cover_image_path , APP_THEME())}}" class="default-img" alt="lamp">
                                                </a>
                                                @auth
                                                <div class="new-labl">
                                                    <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" style="color:black;" product_id="{{$h_product->id}}" in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add'}}">
                                                        <span class="wish-ic">
                                                            <i class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                @endauth
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <div class="review-star">
                                                        <span>{{ $h_product->ProductData()->name }}</span>
                                                        <div class="d-flex align-items-center">
                                                            {{-- @auth
                                                            <div class="new-labl">
                                                                <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" style="color:black;" product_id="{{$h_product->id}}" in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add'}}">
                                                                    <span class="wish-ic">
                                                                        <i class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            @endauth --}}
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <h3 class="product-title"><a href="{{route('page.product',[$slug,$p_id])}}">
                                                        {{$h_product->name}}</a></h3>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="price">
                                                        <ins>{{$h_product->final_price}} <span class="currency-type">{{ $currency }}</span></ins>
                                                    </div>
                                                    <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $h_product->id }}" variant_id="{{ $h_product->default_variant_id }}" qty="1">
                                                        <span> {{ __('Add to cart') }} </span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @php
            $homepage_review_section_title = $homepage_review_section_btn_text  = '';

            $homepage_review_section_key1 = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
            if($homepage_review_section_key1 != '') {
                $homepage_review_section = $theme_json[$homepage_review_section_key1];

            foreach ($homepage_review_section['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-testimonial-title-text') {
                $homepage_review_section_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-testimonial-btn-text') {
                $homepage_review_section_btn_text = $value['field_default_text'];
                }
            }
            }
        @endphp
        @if($product_review->isNotEmpty())
            @if($homepage_review_section['section_enable'] == 'on')
                <section class="review-section review-section-pdp-page">
                    <div class="container">
                        <div class="section-title d-flex align-items-center justify-content-between">
                            <h2>{!! $homepage_review_section_title !!}</h2>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary m-0 w-100" tabindex="0">
                                {!! $homepage_review_section_btn_text !!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                        fill=""></path>
                                </svg>
                            </a>
                        </div>
                        @foreach ($product_review as $review)
                        <div class="review-slider">
                            <div class="review-section-slider">
                                <div class="review-itm-inner">
                                    <div class="review-itm-image">
                                        <a href="#" tabindex="0">
                                            <img src="{{asset('/'. !empty($review->ProductData()) ? $review->ProductData->cover_image_path : '' )}}" class="default-img" alt="best review">
                                        </a>
                                    </div>
                                    <div class="review-itm-content">
                                        <div class="review-itm-content-top">
                                            <h3 class="review-title">
                                                {{$review->title}}
                                            </h3>
                                        </div>
                                        <p>{{$review->description}}</p>
                                        <div class="review-star">
                                            <div class="d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                @endfor
                                                <span class="star-count">{{$review->rating_no}}.5 / <b> 5.0</b></span>
                                            </div>
                                        </div>
                                        <p><b>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }},</b> Client about Metalic Wall Lamp</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endif
        @php
            $homepage_blog_section_title = $homepage_blog_section_btn_text  = '';

            $homepage_blog_section_key1 = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
            if($homepage_blog_section_key1 != '') {
                $homepage_blog_section = $theme_json[$homepage_blog_section_key1];

            foreach ($homepage_blog_section['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-blog-title-text') {
                $homepage_blog_section_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-blog-btn-text') {
                $homepage_blog_section_btn_text = $value['field_default_text'];
                }
            }
            }
        @endphp
        @if($homepage_blog_section['section_enable'] == 'on')
        <section class="blog-section">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2>{!! $homepage_blog_section_title !!}</h2>
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color m-0 w-100" tabindex="0">
                        {!! $homepage_blog_section_btn_text !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                        </svg>
                    </a>
                </div>
                <div class="row">
                    {!! \App\Models\Blog::HomePageBlog($slug ,$no=3) !!}
                </div>
            </div>
        </section>
        @endif
    </div>
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

