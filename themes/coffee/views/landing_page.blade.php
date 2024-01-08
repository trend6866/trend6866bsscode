
@extends('layouts.layouts')

@section('page-title')
{{ __('CoffeeStore') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

<div class="home-wrapper">
    <section class="first-video-section">
        @php
            $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-header-heading-text') {
                        $home_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-vedio-url') {
                        $home_video = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
        <video src="{!! get_file($home_video , APP_THEME()) !!}" loop="" autoplay="" muted="muted" playsinline="" controlslist="nodownload"></video>
        <div class="fixed-slider-left">
            <div class="slides-numbers" style="display: block;">
                <span class="active">01</span> / <span class="total"></span>
            </div>
            <div class="line"></div>
            <div class="slider-inner-text">
                <h5>{{$home_title}} </h5>
            </div>
        </div>
        @endif
        <div class="container">
            <div class="banner-slider">
                @php
                    $homepage_logo_key = array_search('homepage-banner', array_column($theme_json,'unique_section_slug'));
                    if($homepage_logo_key != ''){
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                        @php
                            if($homepage_main_logo_value['field_slug'] == 'homepage-banner-label-text')
                            {
                                $homepage_label = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_label = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-banner-title-text') {
                                $homepage_text = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-banner-sub-text') {
                                $homepage_text2 = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_text2 = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-banner-btn-text') {
                                $homepage_btn = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_btn = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                        @endphp
                    @endforeach
                    <div>
                        <div class="row align-items-start">
                            <div class="col-lg-3 col-md-6 col-sm-6  col-12"></div>
                            <div class="col-lg-6 col-md-12 col-12 banner-center-content">
                                <div class="banner-content-inner text-center">
                                    <div class="section-title">
                                        <div class="subtitle">{{$homepage_label}}</div>
                                        <h2>{!!  $homepage_text !!}</h2>
                                    </div>
                                    <p>{{$homepage_text2}}</p>
                                    <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{$homepage_btn}}</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6  col-12"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <section class="our-partner-section">
        <div class="container">

            <div class="row align-items-center">
                @php
                    $homepage_header_1_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-logo-heading-text') {
                                $home_logo = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-logo-title-text') {
                                $home_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-logo-label-text') {
                                $home_labl = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="col-md-4 col-12">
                    <div class="partner-left-column">
                        <div class="section-title">
                            <div class="subtitle">{{$home_logo}}</div>
                            <h2>{!! $home_text !!}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="partner-right-column">
                        <div class="parner-lbl">
                            {{$home_labl}}
                        </div>
                        <div class="partner-slider">
                            @php
                                $homepage_logo = '';
                                $homepage_logo_key = array_search('homepage-logo', array_column($theme_json,'unique_section_slug'));
                                if($homepage_logo_key != ''){
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                }
                            @endphp

                            @if(!empty($homepage_main_logo['homepage-logo-logo']))
                                @for ($i = 0; $i < count($homepage_main_logo['homepage-logo-logo']); $i++)
                                    @php
                                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                        {
                                            if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo'){
                                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                            }
                                            if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                            {
                                                if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo'){
                                                    $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="partner-itm">
                                        <a href="#">
                                            <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="Client logo">
                                        </a>
                                    </div>
                                @endfor
                            @else
                                @for ($i = 0; $i <= 6; $i++)
                                    @php
                                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                        {
                                            if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo'){
                                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                            }
                                        }
                                    @endphp
                                    <div class="partner-itm">
                                        <a href="#">
                                            <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="Client logo">
                                        </a>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    <section class="sections-wrapper padding-bottom">
        <div class="bestseller-section tabs-wrapper padding-top">
            @php
                $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-products-img') {
                            $best_img = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-btn-text') {
                            $best_btn_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <img src="{{get_file($best_img, APP_THEME()) }}" class="bst-leftimg">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <div class="section-title-left">
                        <ul class="cat-tab tabs">
                            @foreach ($MainCategory->take(6) as $cat_key =>  $category)
                                <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">{{$category}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{ $best_btn_text }}</a>
                </div>
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="bestpro-slider">
                            @foreach($all_products as $all_product)
                            {{-- @dd($all_product) --}}
                                @php
                                    $p_id = hashidsencode($all_product->id);
                                @endphp
                                @if($cat_k == '0' ||  $all_product->ProductData()->id == $cat_k)
                                    <div class="bestpro-itm product-card  card-direction-row">
                                        <div class="product-card-inner">
                                            <div class="product-img">
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    <img src="{{ get_file($all_product->cover_image_path , APP_THEME()) }}">
                                                    <div class="custom-output">
                                                        @php
                                                            date_default_timezone_set('Asia/Kolkata');
                                                            $currentDateTime = \Carbon\Carbon::now();
                                                            $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                                ->where('store_id', getCurrentStore())
                                                                ->where('is_active', 1)
                                                                ->get();
                                                            $latestSales = [];

                                                            foreach ($sale_product as $flashsale) {
                                                                $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                                $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                                $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                                if ($endDate < $startDate) {
                                                                    $endDate->addDay();
                                                                }
                                                                $currentDateTime->setTimezone($startDate->getTimezone());

                                                                if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                                    if (is_array($saleEnableArray) && in_array($all_product->id, $saleEnableArray)) {
                                                                        $latestSales[$all_product->id] = [
                                                                            'discount_type' => $flashsale->discount_type,
                                                                            'discount_amount' => $flashsale->discount_amount,
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        @foreach ($latestSales as $productId => $saleData)
                                                            <span class="offer-lbl">
                                                                @if ($saleData['discount_type'] == 'flat')
                                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                                    -{{ $saleData['discount_amount'] }}%
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <div class="d-flex justify-content-end wsh-wrp">
                                                        <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$all_product->id}}" in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add'}}">
                                                            <span class="wish-ic">
                                                                <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: rgb(255, 254, 254)'></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="subtitle">{{$all_product->tag_api}}</div>
                                                    <h3><a href="{{route('page.product',[$slug,$p_id])}}" class="description">{{$all_product->name}}</a></h3>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="main-price d-flex align-items-center justify-content-between">
                                                        @if ($all_product->variant_product == 0)
                                                            <div class="price">
                                                                <ins>{{$all_product->final_price}}{{$currency}}</ins>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $all_product->id }}" variant_id="{{ $all_product->default_variant_id }}" qty="1">
                                                            + {{ __('ADD TO CART')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="center-btn-view-all d-flex justify-content-center">
                    <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{ $best_btn_text }}</a>
                </div>
            </div>
            @endif
        </div>

        <div class="banner-with-products padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-banner-product', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-banner-product-label-text') {
                                $banner_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-product-title-text') {
                                $banner_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-product-sub-text') {
                                $banner_sub_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-product-btn-text') {
                                $banner_btn = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-product-video-url') {
                                $banner_video = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="beans-video-wrp">
                    <video src="{!! get_file($banner_video , APP_THEME()) !!}" loop="" autoplay="" muted="muted" playsinline="" controlslist="nodownload"></video>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="banner-product-details coffeethree-column-box">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{$banner_title}}
                                    </div>
                                    <h2>{!! $banner_text !!}</h2>
                                </div>
                                <p>{{$banner_sub_text}}</p>
                                <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{$banner_btn}}</a>
                            </div>
                        </div>
                        @foreach($homepage_products as $homepage_product)
                        @php
                            $p_id = hashidsencode($homepage_product->id);
                        @endphp
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="product-card  card-direction-row">
                                <div class="product-card-inner">
                                    <div class="product-img">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            <img src="{{ get_file($homepage_product->cover_image_path , APP_THEME()) }}">
                                            <div class="custom-output">
                                                @php
                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $currentDateTime = \Carbon\Carbon::now();
                                                    $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                        ->where('store_id', getCurrentStore())
                                                        ->where('is_active', 1)
                                                        ->get();
                                                    $latestSales = [];

                                                    foreach ($sale_product as $flashsale) {
                                                        $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                        $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                        $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                        if ($endDate < $startDate) {
                                                            $endDate->addDay();
                                                        }
                                                        $currentDateTime->setTimezone($startDate->getTimezone());

                                                        if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                            if (is_array($saleEnableArray) && in_array($homepage_product->id, $saleEnableArray)) {
                                                                $latestSales[$homepage_product->id] = [
                                                                    'discount_type' => $flashsale->discount_type,
                                                                    'discount_amount' => $flashsale->discount_amount,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach ($latestSales as $productId => $saleData)
                                                    <span class="offer-lbl">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top">
                                                <div class="d-flex justify-content-end wsh-wrp">
                                                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$homepage_product->id}}" in_wishlist="{{ $homepage_product->in_whishlist ? 'remove' : 'add'}}">
                                                        <span class="wish-ic">
                                                            <i class="{{ $homepage_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: rgb(255, 254, 254)'></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            <div class="subtitle">{{$homepage_product->tag_api}}</div>
                                            <h3><a href="{{route('page.product',[$slug,$p_id])}}">{{$homepage_product->name}}</a></h3>
                                        </div>
                                        <div class="product-content-bottom">
                                            <div class="main-price d-flex align-items-center justify-content-between">
                                                @if ($homepage_product->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{$homepage_product->final_price}}{{$currency}}</ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $homepage_product->id }}" variant_id="{{ $homepage_product->default_variant_id }}" qty="1">
                                                    + {{ __('ADD TO CART')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
               @endif

            </div>
        </div>

        <div class="vertical-tab-section tabs-wrapper">
            @php
                $homepage_header_1_key = array_search('homepage-card-1', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-card-label-text') {
                            $vertical_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-cardhomepage-card-title-text') {
                            $vertical_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-card-sub-text') {
                            $vertical_sub_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-card-btn-text') {
                            $vertical_btn_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-card-img') {
                            $vertical_image = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-card-heading-text') {
                            $vertical_heading = $value['field_default_text'];
                        }

                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
                <img src="{{get_file($vertical_image , APP_THEME())}}" alt="coffee image" class="bst-midimg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                            <div class="vertical-tab-left coffeethree-column-box">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{$vertical_title}}
                                    </div>
                                    <h2>{!! $vertical_text !!}</h2>
                                </div>
                                <p>{{$vertical_sub_text}}</p>
                                <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{$vertical_btn_text}}</a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-3 col-md-4 col-sm-5 col-12">
                            <div class="vertical-tab-center">
                                <div class="subtitle">{{$vertical_heading}} </div>
                                <ul class="cat-tab tabs">

                                @php
                                    $homepage_text = '';
                                    $homepage_logo_key = array_search('homepage-card-2', array_column($theme_json,'unique_section_slug'));
                                    $section_enable = 'on';
                                    if($homepage_logo_key != ''){
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        $section_enable = $homepage_main_logo['section_enable'];
                                    }
                                @endphp
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                        @php
                                            if($homepage_main_logo_value['field_slug'] == 'homepage-card-label-text')
                                            {
                                                $vertical_label = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $vertical_label = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                        @endphp
                                    @endforeach

                                    <li class="tab-link" data-tab="spain"><a href="javascript:;">{{$vertical_label}} </a></li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-8 col-sm-7 col-12">
                            <div class="tabs-container">
                                <div id="spain" class="tab-content active">
                                    <div class="testimonial-slider">
                                        @foreach ($reviews as $review)
                                        @php
                                            $r_id = hashidsencode($review->id);
                                        @endphp
                                        <div class="testimonial-itm">
                                            <div class="testimonial-itm-inner">
                                                <div class="testimonial-itm-image">
                                                    <a href="{{route('page.product',[$slug,$r_id])}}">
                                                        <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}" alt="review">
                                                    </a>
                                                </div>
                                                <div class="testimonial-itm-content">
                                                    <div class="testimonial-content-top">
                                                        {{-- <div class="subtitle">{{$review->MainCategory->name}}</div> --}}
                                                        <h4>
                                                            {{$review->title}}
                                                        </h4>
                                                        <p>{{$review->description}}</p>
                                                    </div>
                                                    <div class="testimonial-bottom d-flex align-items-center">
                                                        <span class="client-name">John Doe, Client</span>
                                                        <div class="testimonial-str d-flex align-items-center">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : 'text-white' }}"></i>
                                                            @endfor
                                                            <span><b>{{$review->rating_no}}</b> / 5.0</span>
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
                    </div>
                </div>
            @endif
        </div>
    </section>


    <section class="product-categories-section">
        @php
            $homepage_header_1_key = array_search('homepage-feature-product', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-feature-product-label-text') {
                        $category_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-title-text') {
                        $category_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-btn-text') {
                        $category_btn = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                <div class="section-title-left">
                    <div class="subtitle">{{$category_title}}</div>
                    <h2>{!! $category_text !!}</h2>
                </div>
                <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{$category_btn}}</a>
            </div>
            <div class="pro-categorie-slider bottom-arrow">
                @foreach($bestSeller as $bestSellers)
                @php
                    $p_id = hashidsencode($bestSellers->id);
                @endphp
                <div class="pro-cate-itm product-card">
                    <div class="product-card-inner">
                        <div class="product-img">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($bestSellers->cover_image_path , APP_THEME()) }}">
                                <div class="custom-output">
                                    @php
                                        date_default_timezone_set('Asia/Kolkata');
                                        $currentDateTime = \Carbon\Carbon::now();
                                        $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                            ->where('store_id', getCurrentStore())
                                            ->where('is_active', 1)
                                            ->get();
                                        $latestSales = [];

                                        foreach ($sale_product as $flashsale) {
                                            $saleEnableArray = json_decode($flashsale->sale_product, true);
                                            $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                            $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                            if ($endDate < $startDate) {
                                                $endDate->addDay();
                                            }
                                            $currentDateTime->setTimezone($startDate->getTimezone());

                                            if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                if (is_array($saleEnableArray) && in_array($bestSellers->id, $saleEnableArray)) {
                                                    $latestSales[$bestSellers->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <span class="offer-lbl">
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-content-top">
                                    <div class="d-flex justify-content-end wsh-wrp">
                                        <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$bestSellers->id}}" in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add'}}">
                                            <span class="wish-ic">
                                                <i class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: rgb(255, 254, 254)'></i>
                                            </span>
                                        </a>
                                    </div>
                                <div class="subtitle">{{$bestSellers->tag_api}}</div>
                                <h3><a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">{{$bestSellers->name}}</a></h3>
                            </div>
                            <div class="product-content-bottom">
                                <div class="main-price d-flex align-items-center justify-content-between">
                                    @if ($bestSellers->variant_product == 0)
                                        <div class="price">
                                            <ins>{{$bestSellers->final_price}}{{$currency}}</ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif
                                    <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $bestSellers->id }}" variant_id="{{ $bestSellers->default_variant_id }}" qty="1">
                                        + {{ __('ADD TO CART')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="center-btn-view-all d-flex justify-content-center">
                <a href="{{route('page.product-list',$slug)}}" class="link-btn">{{$category_btn}}</a>
            </div>
        </div>
        @endif
    </section>


    <section class="coffee-three-col-section">
        @php
            $homepage_header_1_key = array_search('homepage-section', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-section-label-text') {
                        $homepage_label = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-section-title-text') {
                        $homepage_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-section-sub-text') {
                        $homepage_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-section-btn-text') {
                        $homepage_btn = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-section-bg-img') {
                        $homepage_img = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-section-img') {
                        $homepage_image = $value['field_default_text'];
                    }

                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
            <img src="{{get_file($homepage_img, APP_THEME())}}" alt="coffee image" class="bst-midimg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="coffeethree-column-box">
                            <div class="section-title">
                                <div class="subtitle">
                                    {{$homepage_label}}
                                </div>
                                <h2>{!! $homepage_title !!}</h2>
                            </div>
                            <p>{{$homepage_text}}</p>
                            <a href="{{route('page.blog',$slug)}}" class="link-btn">{{$homepage_btn}}</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="coffee-mug-animation">
                            <svg width="80px" height="73px" viewBox="0 0 31 73">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g class="smokes" transform="translate(2.000000, 2.000000)" stroke="#BEBEBE" stroke-width="5">
                                    <g class="smoke-1">
                                    <path id="Shape1" d="M0.5,8.8817842e-16 C0.5,8.8817842e-16 3.5,5.875 3.5,11.75 C3.5,17.625 0.5,17.625 0.5,23.5 C0.5,29.375 3.5,29.375 3.5,35.25 C3.5,41.125 0.5,41.125 0.5,47"></path>
                                    </g>
                                    <g class="smoke-2">
                                    <path id="Shape2" d="M0.5,8.8817842e-16 C0.5,8.8817842e-16 3.5,5.875 3.5,11.75 C3.5,17.625 0.5,17.625 0.5,23.5 C0.5,29.375 3.5,29.375 3.5,35.25 C3.5,41.125 0.5,41.125 0.5,47"></path>
                                    </g>
                                    <g class="smoke-3">
                                    <path id="Shape3" d="M0.5,8.8817842e-16 C0.5,8.8817842e-16 3.5,5.875 3.5,11.75 C3.5,17.625 0.5,17.625 0.5,23.5 C0.5,29.375 3.5,29.375 3.5,35.25 C3.5,41.125 0.5,41.125 0.5,47"></path>
                                    </g>
                                </g>
                                </g>
                            </svg>
                            <img src="{{get_file($homepage_image, APP_THEME())}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        @if (!empty($latest_product))
                        <div class="product-card  card-direction-row">
                            <div class="product-card-inner">
                                <div class="product-img">
                                    @php
                                        $p_id = hashidsencode($latest_product->id);
                                    @endphp
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{ get_file($latest_product->cover_image_path , APP_THEME()) }}">
                                        <div class="custom-output">
                                            @php
                                                date_default_timezone_set('Asia/Kolkata');
                                                $currentDateTime = \Carbon\Carbon::now();
                                                $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                    ->where('store_id', getCurrentStore())
                                                    ->where('is_active', 1)
                                                    ->get();
                                                $latestSales = [];

                                                foreach ($sale_product as $flashsale) {
                                                    $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                    $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                    $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                    if ($endDate < $startDate) {
                                                        $endDate->addDay();
                                                    }
                                                    $currentDateTime->setTimezone($startDate->getTimezone());

                                                    if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                        if (is_array($saleEnableArray) && in_array($latest_product->id, $saleEnableArray)) {
                                                            $latestSales[$latest_product->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <span class="offer-lbl">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </a>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                            <div class="d-flex justify-content-end wsh-wrp">
                                                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$latest_product->id}}" in_wishlist="{{ $latest_product->in_whishlist ? 'remove' : 'add'}}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $latest_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: rgb(255, 254, 254)'></i>
                                                    </span>
                                                </a>
                                            </div>
                                        <div class="subtitle">{{$latest_product->tag_api}}</div>
                                        <h3><a href="{{route('page.product',[$slug,$p_id])}}">{{$latest_product->name}}</a></h3>

                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="main-price d-flex align-items-center justify-content-between">
                                            @if ($latest_product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{$latest_product->final_price}}{{$currency}}</ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $latest_product->id }}" variant_id="{{ $latest_product->default_variant_id }}" qty="1">
                                                + {{ __('ADD TO CART')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </section>


    <section class="subscribe-section">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-newsletter-label-text') {
                            $news_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-title-text') {
                            $news_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                            $news_sub_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-description') {
                            $news_desc = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-bg-img') {
                            $news_image = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="subscribe-banner">
                <img src="{{get_file($news_image, APP_THEME())}}" class="subscribe-bnr">
                <div class="subscribe-column">
                    <div class="section-title">
                        <div class="subtitle">{{$news_title}}</div>
                        <h2>{!! $news_text !!}</h2>
                    </div>
                    <p>{{$news_sub_text}}</p>
                    <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                        @csrf
                        <div class="input-wrapper">
                            <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                            <button class="btn-subscibe">{{ __('SUBSCRIBE')}}</button>
                        </div>
                        <label for="subsection">{{$news_desc}}</label>
                    </from>
                </div>
            </div>
            @endif
        </div>
    </section>


    <section class="blog-insta-wrapper padding-bottom">
        @php
            $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-blog-label-text') {
                        $blog_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-title-text') {
                        $blog_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-sub-text') {
                        $blog_sub_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-btn-text') {
                        $blog_button = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-img') {
                        $blog_image = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
            <div class="home-blog-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-12 relative">
                            <img src="{{get_file($blog_image, APP_THEME())}}" alt="coffee image" class="blog-left-img">
                            <div class="home-blog-left">
                                <div class="section-title">
                                    <div class="subtitle">
                                        {{$blog_title}}
                                    </div>
                                    <h2>{!!  $blog_text !!}</h2>
                                </div>
                                <p>{{$blog_sub_text}}</p>
                                <a href="{{route('page.blog',$slug)}}" class="link-btn">{{$blog_button}}</a>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="blog-slider">
                                {!! \App\Models\Blog::HomePageBlog($slug,10) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="our-insta-section  padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-image-section-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-image-section-label-text') {
                                $insta_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-image-section-title-text') {
                                $insta_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-image-section-tag') {
                                $insta_tag = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-image-section-tag-text') {
                                $home_tag_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-image-section-img') {
                                $home_image = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center ">
                    <div class="section-title-left">
                        <div class="subtitle">{{$insta_title}}</div>
                        <h2>
                            {{$insta_text}}
                        </h2>
                    </div>
                    <div class="insta-pro">
                        <div class="insta-pro-info">
                            <span>{{$insta_tag}}</span>
                            <a href="https://www.instagram.com/" target="_blank">
                                {{$home_tag_text}}
                            </a>
                        </div>
                        <div class="insta-pro-img">
                            <a href="https://www.instagram.com/">
                                <img src="{{get_file($home_image, APP_THEME())}}" alt="insta-pro">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 9 9" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.746338 3.26117C0.746338 1.90962 1.74238 0.813965 2.97107 0.813965H5.93738C7.16607 0.813965 8.16211 1.90962 8.16211 3.26117V6.52411C8.16211 7.87567 7.16607 8.97132 5.93738 8.97132H2.97107C1.74238 8.97132 0.746338 7.87567 0.746338 6.52411V3.26117ZM2.97107 1.6297C2.15195 1.6297 1.48792 2.36013 1.48792 3.26117V6.52411C1.48792 7.42515 2.15195 8.15558 2.97107 8.15558H5.93738C6.75651 8.15558 7.42054 7.42515 7.42054 6.52411V3.26117C7.42054 2.36013 6.75651 1.6297 5.93738 1.6297H2.97107ZM3.71265 4.89264C3.71265 5.34316 4.04466 5.70838 4.45423 5.70838C4.86379 5.70838 5.1958 5.34316 5.1958 4.89264C5.1958 4.44212 4.86379 4.07691 4.45423 4.07691C4.04466 4.07691 3.71265 4.44212 3.71265 4.89264ZM4.45423 3.26117C3.6351 3.26117 2.97107 3.99161 2.97107 4.89264C2.97107 5.79368 3.6351 6.52411 4.45423 6.52411C5.27335 6.52411 5.93738 5.79368 5.93738 4.89264C5.93738 3.99161 5.27335 3.26117 4.45423 3.26117ZM6.12278 2.44544C5.8156 2.44544 5.56659 2.71935 5.56659 3.05724C5.56659 3.39513 5.8156 3.66904 6.12278 3.66904C6.42995 3.66904 6.67896 3.39513 6.67896 3.05724C6.67896 2.71935 6.42995 2.44544 6.12278 2.44544Z" fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <ul>
                    @php
                        $homepage_logo = '';
                        $homepage_logo_key = array_search('homepage-image-section-2', array_column($theme_json,'unique_section_slug'));
                        if($homepage_logo_key != ''){
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                        }
                    @endphp

                    @if(!empty($homepage_main_logo['homepage-image-section-img']))
                        @for ($i = 0; $i < count($homepage_main_logo['homepage-image-section-img']); $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-image-section-img'){
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                    if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                    {
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-image-section-img'){
                                            $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp
                            <li>
                                <a href="https://www.instagram.com/" class="img-wrapper">
                                    <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="pic">
                                </a>
                            </li>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 6; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-image-section-img'){
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                }
                            @endphp
                            <li>
                                <a href="https://www.instagram.com/" class="img-wrapper">
                                    <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="pic">
                                </a>
                            </li>
                        @endfor
                    @endif
                </ul>
            </div>
        </div>
    </section>
</div>

@endsection
