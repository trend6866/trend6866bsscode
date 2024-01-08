
@extends('layouts.layouts')

@section('page-title')
{{ __('Gifts') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
<section class="main-home-first-section" style="background-image: url({{asset('themes/'.APP_THEME().'/assets/images/banner-main.png') }});">
    <div class="home-slider-wrapper offset-left">
        <div class="row align-items-center no-gutters">
            <div class="col-lg-4 col-12 padding-top">
                <div class="home-slider-left-column-inner">
                    <div class="home-slider-left-col">
                        @foreach ($home_products->take(3) as $product)
                            @php
                                $p_id = hashidsencode($product->id);
                            @endphp
                            <div class="home-slider-left">
                                <div class="home-left-slider-inner">
                                    <div class="review-star">
                                        <span>{{$product->ProductData()->name}}</span>
                                        @if(!empty($product->average_rating))
                                            <div class="d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                    <div class="section-title">
                                        <h2 class="title">{{$product->name}}</h2>
                                    </div>
                                    <p class="descriptions">{{$product->description}}
                                    </p>
                                    <div class="d-flex align-items-center margin-top-btn">
                                        <a href="JavaScript:void(0)" class="btn-secondary m-0 w-100 addtocart-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                            {{__('Add to cart')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill=""></path>
                                            </svg>
                                        </a>
                                        <div class="price">
                                            <ins>{{ $product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slides-numbers" style="display: block;">
                        <span class="active">01</span> / <span class="total"></span>
                    </div>
                </div>
            </div>
            @php
                $homepage_banner_image_1 = $homepage_banner_image_2 = '';
                    $homepage_banner_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_banner_key != ''){
                        $homepage_banner = $theme_json[$homepage_banner_key];

                        foreach ($homepage_banner['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-banner-img-1'){
                                $homepage_banner_image_1 = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-img-2'){
                                $homepage_banner_image_2 = $value['field_default_text'];
                            }
                        }
                    }
            @endphp

            <div class="col-lg-5 col-12 padding-top">
                <div class="home-banner-image">
                    <img src="{{get_file($homepage_banner_image_1 , APP_THEME())}}" class="margin-left-banner-image" alt="lifestyle">
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="banner-right-col">
                    <div class="home-banner-image">
                        <img src="{{get_file($homepage_banner_image_2 , APP_THEME())}}" alt="home-decor">
                    </div>
                </div>
            </div>
        </div>
        <div class="home-slider-right-col desk-only"></div>
    </div>
</section>
 <section class="best-product-section">
    <div class="left-side-image" style="z-index: unset; top: 46%;">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/left-banner.png')}}" alt="Gifts.">
    </div>
    <div class="offset-container offset-left">
        <div class="best-product-slider">
            @foreach ($all_products as $all_product)
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
                                        <b class="title">{{$all_product->name}}</b>
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
<section class="our-bestseller-section tabs-wrapper">
    {{-- <div class="left-side-image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/left-2.png')}}" alt="bestseller">
    </div>--}}
    <div class="right-side-image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/right1.png')}}" alt="bestseller">
    </div>
    <div class="container">
        @php
            $homepage_product_title = $homepage_product_btn = '';
                $homepage_product_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_product_key != ''){
                    $homepage_product = $theme_json[$homepage_product_key];

                    foreach ($homepage_product['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-products-title-text'){
                            $homepage_product_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-btn-text'){
                            $homepage_product_btn = $value['field_default_text'];
                        }
                    }
                }
        @endphp
        @if($homepage_product['section_enable'] == 'on')
            <div class="section-title row   align-items-center justify-content-between">
                <div class="col-md-6">
                    <h3>{!! $homepage_product_title !!}</h3>
                    <ul class="cat-tab tabs">
                        @foreach ($MainCategory as $cat_key =>  $category)
                            <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}" >
                                <a href="javascript:;">{{ $category }}</a>
                                @php
                                    $landing_categories_products_count = App\Models\product::where('category_id', $cat_key)->where('theme_id', APP_THEME())->count();
                                    $product_count = App\Models\product::where('theme_id', APP_THEME())->count();
                                @endphp
                                @if($category == 'All Products')
                                    <span>[{{$product_count}}]</span>
                                @else
                                    <span>[{{$landing_categories_products_count}}]</span>
                                @endif
                            </li>

                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color">
                        {!! $homepage_product_btn !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill=""></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="shop-protab-slider">
                            @foreach($homeproducts as $product)
                                @php
                                    $p_id = hashidsencode($product->id);
                                @endphp
                                @if($cat_k == '0' ||  $product->ProductData()->id == $cat_k)
                                    <div class="shop-protab-itm product-card">
                                        <div class="product-card-inner">
                                            <div class="product-card-image">
                                                <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                                    <img src="{{get_file($product->cover_image_path , APP_THEME())}}" class="default-img">
                                                </a>
                                                <div class="new-labl">
                                                    @auth
                                                        <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                                            <span class="wish-ic">
                                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                            </span>
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <div class="review-star">
                                                        <span>{{ $product->ProductData()->name }}</span>
                                                        <div class="d-flex align-items-center">
                                                            @if(!empty($product->average_rating))
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                                @endfor
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <h3 class="product-title">
                                                        <a class="title" href="{{route('page.product',[$slug,$p_id])}}"> {{$product->name}}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="price">
                                                        <ins>{{$product->final_price}} <span class="currency-type">{{ $currency }}</span></ins>
                                                    </div>
                                                    <a href="JavaScript:void(0)" class="link-btn addtocart-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1"
                                                        tabindex="0">
                                                        {{__('Add to cart')}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                            viewBox="0 0 4 6" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                fill=""></path>
                                                        </svg>
                                                    </a>
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
        @endif

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
    <section class="two-col-variant-section">
        <div class="left-side-image" style="top: 0%;">
            <img src="{{asset('themes/'.APP_THEME().'/assets/images/d1.png') }}" alt="Gifts.">
        </div>
        <div class="right-side-image" style="top: -18%; right: 18%; z-index: 2;">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/d2.png') }}" alt="Gifts.">
        </div>
        <div class="right-side-image" style="top: 80%;">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/d3.png') }}" alt="Gifts.">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="two-column-variant-left-content">
                        <div class="section-title">
                            <h2>{!! $homepage_banner_section_title !!}</h2>
                        </div>
                        <p>{!! $homepage_banner_section_subtext !!}</p>
                        <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color">
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
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="two-column-variant-right">
                        <img src="{{get_file($homepage_banner_section_img , APP_THEME())}}" alt="product">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@php
    $homepage_bestseller_btn_text =   '';

    $homepage_bestseller_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
    if($homepage_bestseller_key != '') {
        $homepage_bestseller = $theme_json[$homepage_bestseller_key];

    foreach ($homepage_bestseller['inner-list'] as $key => $value) {
        if($value['field_slug'] == 'homepage-bestseller-btn-text') {
            $homepage_bestseller_btn_text = $value['field_default_text'];
        }
    }
    }
@endphp
@if($homepage_bestseller['section_enable'] == 'on')
    <section class="our-bestseller-section-two">
        <div class="container">
            <div class="shop-protab-slider">
                @foreach($all_products as $all_product)
                @php
                    $p_id = hashidsencode($all_product->id);
                @endphp
                    <div class="shop-protab-itm product-card">
                        <div class="product-card-inner">
                            <div class="product-card-image">
                                <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                    <img src="{{ get_file($all_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                </a>
                                <div class="new-labl">
                                    @auth
                                        <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$all_product->id}}" in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add'}}">
                                            <span class="wish-ic">
                                                <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <div class="review-star">
                                        <span>{{ $all_product->ProductData()->name }}</span>
                                        <div class="d-flex align-items-center">
                                            @if(!empty($all_product->average_rating))
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star review-stars {{ $i < $all_product->average_rating ? 'text-warning' : '' }} "></i>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <h3 class="product-title"><a class="title" href="{{route('page.product',[$slug,$p_id])}}">{{$all_product->name}}</a></h3>
                                </div>
                                <div class="product-content-bottom">
                                    <div class="price">
                                        <ins>{{$all_product->final_price}} <span class="currency-type">{{ $currency }}</span></ins>
                                    </div>
                                    <a href="JavaScript:void(0)" class="link-btn addtocart-btn addcart-btn-globaly" product_id="{{ $all_product->id }}" variant_id="{{ $all_product->default_variant_id }}" qty="1">
                                        {{__('Add to cart')}}
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
            <div class="d-flex justify-content-center">
                <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color">
                    {!! $homepage_bestseller_btn_text !!}
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                            fill=""></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endif
@php
    $homepage_newsletter = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
    $section_enable = 'on';
    if($homepage_newsletter != '')
    {
        $home_newsletter = $theme_json[$homepage_newsletter];
        $section_enable = $home_newsletter['section_enable'];
        foreach ($home_newsletter['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-newsletter-title-text') {
                $home_newsletter_text = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                $home_newsletter_sub_text = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-description') {
                $home_newsletter_decription = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-bg-img') {
                $home_newsletter_image= $value['field_default_text'];
            }
        }
    }
@endphp
@if($home_newsletter['section_enable'] == 'on')
    <section class="home-custom-banner-section">
        <div class="left-side-image" style="top: 0%; z-index: 1;">
            <img src="{{asset('themes/'.APP_THEME().'/assets/images/d4.png') }}" alt="Gifts.">
        </div>
        <div class="container">
            <div class="custom-banner">
                <div class="custom-banner-image">
                    <img src="{{ get_file($home_newsletter_image , APP_THEME()) }}" class="card_banner1.png">
                    <div class="custom-banner-image-main">
                        <h3> {!! $home_newsletter_text !!} </h3>
                        <p>{!! $home_newsletter_sub_text !!}</p>
                        <div class="search-form-wrapper banner-search-form">
                            <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="Type your address email..." name="email">
                                    <button type="submit" class="btn-subscibe">
                                        {{__('Subscribe')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12"
                                            viewBox="0 0 4 6" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill="white"></path>
                                        </svg>
                                    </button>
                                </div><br>
                                    <label for="subscibecheck1">
                                        {!! $home_newsletter_decription !!}
                                    </label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endif
@php
    $homepage_card_section_text = $homepage_card_section_sub_text = $homepage_card_section_desc = $homepage_card_section_btn = $homepage_card_section_btn1 = '';
    $homepage_card_section_key = array_search('homepage-card-section', array_column($theme_json, 'unique_section_slug'));
    if($homepage_card_section_key != '')
    {
        $homepage_card_section = $theme_json[$homepage_card_section_key];
    }
@endphp
@if($homepage_card_section['section_enable'] == 'on')
    <section class="two-col-variant-section-two">
        <div class="container">
            @for($i = 0 ; $i < $homepage_card_section['loop_number']; $i++)
                @php
                    foreach ($homepage_card_section['inner-list'] as $homepage_card_section_value)
                    {
                        if($homepage_card_section_value['field_slug'] == 'homepage-card-section-label-text'){
                            $homepage_card_text = $homepage_card_section_value['field_default_text'];
                        }
                        if($homepage_card_section_value['field_slug'] == 'homepage-card-section-title-text'){
                            $homepage_card_sub_text = $homepage_card_section_value['field_default_text'];
                        }
                        if($homepage_card_section_value['field_slug'] == 'homepage-card-section-btn-text'){
                            $homepage_card_btn_text = $homepage_card_section_value['field_default_text'];
                        }
                        if($homepage_card_section_value['field_slug'] == 'homepage-card-section-bg-img'){
                            $homepage_card_img = $homepage_card_section_value['field_default_text'];
                        }

                        if(!empty($homepage_card_section[$homepage_card_section_value['field_slug']]))  {
                            if($homepage_card_section_value['field_slug'] == 'homepage-card-section-label-text'){
                                $homepage_card_text = $homepage_card_section[$homepage_card_section_value['field_slug']][$i];
                            }
                            if($homepage_card_section_value['field_slug'] == 'homepage-card-section-title-text'){
                                $homepage_card_sub_text = $homepage_card_section[$homepage_card_section_value['field_slug']][$i];
                            }
                            if($homepage_card_section_value['field_slug'] == 'homepage-card-section-btn-text'){
                                $homepage_card_btn_text = $homepage_card_section[$homepage_card_section_value['field_slug']][$i];
                            }
                            if($homepage_card_section_value['field_slug'] == 'homepage-card-section-bg-img'){
                                $homepage_card_img = $homepage_card_section[$homepage_card_section_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                    }
                @endphp

                <div class="row">
                    <div class="col-lg-6 col-md-4 col-12 d-flex">
                        <div class="columnl-left-media-inner">
                            <div class="decorative-text">
                                {!! $homepage_card_text !!}
                            </div>
                            <img src="{{ get_file($homepage_card_img , APP_THEME()) }}" alt="room">
                            <div class="column-left-media-content">
                                <div class="section-title">
                                    <h3>{!! $homepage_card_sub_text !!}</h3>
                                </div>
                                <a href="{{route('page.product-list',$slug)}}" class="link-btn" tabindex="0">
                                    {!! $homepage_card_btn_text !!}
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
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="row h-100">
                            @foreach($home_products->take(2) as $h_product)
                            @php
                                $p_id = hashidsencode($h_product->id);
                            @endphp
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex">
                                <div class="columnl-right-caption-inner w-100">
                                    <div class="product-card-inner">
                                        <div class="product-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                                <img src="{{get_file($h_product->cover_image_path , APP_THEME())}}" class="default-img">
                                            </a>
                                            <div class="new-labl" >
                                                @auth
                                                    <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$h_product->id}}" in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add'}}" >
                                                        <span class="wish-ic">
                                                            <i class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" ></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <div class="review-star">
                                                    <span>{{ $h_product->ProductData()->name }}</span>
                                                    <div class="d-flex align-items-center">
                                                        @if(!empty($h_product->average_rating))
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="fa fa-star review-stars {{ $i < $h_product->average_rating ? 'text-warning' : '' }} "></i>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                </div>
                                                <h3 class="product-title"><a class="title" href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{$h_product->name}}</a></h3>
                                            </div>
                                            <div class="product-content-bottom">
                                                <div class="price">
                                                    <ins>{{$h_product->final_price}}<span class="currency-type">{{ $currency }}</span></ins>
                                                </div>
                                                <a href="javascript:void(0)" class="link-btn addtocart-btn addcart-btn-globaly" product_id="{{ $h_product->id }}" variant_id="{{ $h_product->default_variant_id }}" qty="1">
                                                    {{ __('Add to cart') }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                        viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                            fill=""></path>
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
                <div class="row row-reverse">
                    <div class="col-lg-6 col-md-4 col-12 d-flex">
                        <div class="columnl-left-media-inner">
                            <div class="decorative-text">
                                {!! $homepage_card_text !!}
                            </div>
                            <img src="{{ get_file($homepage_card_img , APP_THEME()) }}" alt="room">
                            <div class="column-left-media-content">
                                <div class="section-title">
                                    <h3>{!! $homepage_card_sub_text !!}</h3>
                                </div>
                                <a href="{{route('page.product-list',$slug)}}" class="link-btn" tabindex="0">
                                    {!! $homepage_card_btn_text !!}
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
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="row h-100">
                            @foreach($home_products->take(2) as $h_product)
                            @php
                                $p_id = hashidsencode($h_product->id);
                            @endphp
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex">
                                <div class="columnl-right-caption-inner w-100">
                                    <div class="product-card-inner">
                                        <div class="product-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                                <img src="{{get_file($h_product->cover_image_path , APP_THEME())}}" class="default-img">
                                            </a>
                                            <div class="new-labl" >
                                                @auth
                                                    <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$h_product->id}}" in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add'}}" >
                                                        <span class="wish-ic">
                                                            <i class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" ></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <div class="review-star">
                                                    <span>{{ $h_product->ProductData()->name }}</span>
                                                    <div class="d-flex align-items-center">
                                                        @if(!empty($h_product->average_rating))
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="fa fa-star review-stars {{ $i < $h_product->average_rating ? 'text-warning' : '' }} "></i>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                </div>
                                                <h3 class="product-title"><a class="title" href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{$h_product->name}}</a></h3>
                                            </div>
                                            <div class="product-content-bottom">
                                                <div class="price">
                                                    <ins>{{$h_product->final_price}}<span class="currency-type">{{ $currency }}</span></ins>
                                                </div>
                                                <a href="javascript:void(0)" class="link-btn addtocart-btn addcart-btn-globaly" product_id="{{ $h_product->id }}" variant_id="{{ $h_product->default_variant_id }}" qty="1">
                                                    {{ __('Add to cart') }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                        viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                            fill=""></path>
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
            @endfor
        </div>
    </section>
@endif
@php
    $homepage_section_title = $homepage_section_sub_text = $homepage_section_btn_text = '';

    $homepage_section_key1 = array_search('homepage-section', array_column($theme_json, 'unique_section_slug'));
    if($homepage_section_key1 != '') {
        $homepage_section = $theme_json[$homepage_section_key1];

    foreach ($homepage_section['inner-list'] as $key => $value) {
        if($value['field_slug'] == 'homepage-section-title-text') {
        $homepage_section_title = $value['field_default_text'];
        }
        if($value['field_slug'] == 'homepage-section-sub-text') {
        $homepage_section_sub_text = $value['field_default_text'];
        }
        if($value['field_slug'] == 'homepage-section-btn-text') {
        $homepage_section_btn_text = $value['field_default_text'];
        }
    }
    }
@endphp
@if($homepage_section['section_enable'] == 'on')
    <section class="interiors-design-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 col-12">
                    <div class="section-title">
                        <h2>{!! $homepage_section_title !!}</h2>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                <div class=interiors-title-center>
                    <p>{!! $homepage_section_sub_text !!}</p>
                </div>
                </div>
                <div class="col-md-4 col-12">
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color">
                        {!! $homepage_section_btn_text !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row padding-top">
                @foreach($MainCategoryList->take(2) as $key=>$MainCategory)
                <div class="col-md-6 col-sm-6 col-12 position-relative">
                    <div class="interiors-design-wrapper" style="background-image: url({{get_file($MainCategory->image_path , APP_THEME())}});">
                        <div class="row align-items-flex-end">
                            <div class="col-lg-5 col-12">
                                <div class="columnl-left-media-inner">
                                    <div class="column-left-media-content">
                                        <div class="section-title">
                                            <h3>{{$MainCategory->name}}</h3>
                                        </div>
                                        <a href="{{route('page.product-list',[$slug,'main_category' => $MainCategory->id ])}}" class="link-btn" tabindex="0">
                                           {{__('Show More')}}
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
                            @php
                                $prod = App\Models\Product::where('category_id' , $MainCategory->id)->where('theme_id'  , APP_THEME())->limit(1)->get();
                            @endphp
                            @foreach($prod as $pro)
                                @if ($pro->category_id == $MainCategory->id)
                                    @php
                                        $p_id = hashidsencode($pro->id);
                                    @endphp
                                    <div class="col-lg-7 col-12">
                                        <div class="columnl-right-caption-inner">
                                            <div class="product-card-inner">
                                                <div class="product-card-image">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                                        <img src="{{get_file($pro->cover_image_path , APP_THEME())}}" class="default-img" alt="fan">
                                                    </a>
                                                    <div class="new-labl">
                                                        @auth
                                                            <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$pro->id}}" in_wishlist="{{ $pro->in_whishlist ? 'remove' : 'add'}}">
                                                                <span class="wish-ic">
                                                                    <i class="{{ $pro->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" ></i>
                                                                </span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <div class="product-content-top">
                                                        <div class="review-star">
                                                            <span>{{ $pro->ProductData()->name }}</span>
                                                            <div class="d-flex align-items-center">
                                                                @if(!empty($pro->average_rating))
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="fa fa-star review-stars {{ $i < $pro->average_rating ? 'text-warning' : '' }} "></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <h3 class="product-title"><a href="{{route('page.product',[$slug,$p_id])}}">
                                                            {{$pro->name}}</h3>
                                                    </div>
                                                    <div class="product-content-bottom">
                                                        <div class="price">
                                                            <ins>{{$pro->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                        </div><br>
                                                    </div>
                                                    <a href="javascript:void(0)" class="link-btn addtocart-btn addcart-btn-globaly" product_id="{{ $pro->id }}" variant_id="{{ $pro->default_variant_id }}" qty="1">
                                                        {{ __('Add to cart') }}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
@endif
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
@if($reviews->isNotEmpty())
    @if($homepage_review_section['section_enable'] == 'on')
        <section class="review-section">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2>{!! $homepage_review_section_title !!}</h2>
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary m-0 w-100" tabindex="0">
                        {!! $homepage_review_section_btn_text !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                        </svg>
                    </a>
                </div>
                <div class="review-slider">
                    @foreach ($reviews as $review)
                        <div class="review-section-slider">
                            <div class="review-itm-inner">
                                <div class="review-itm-image">
                                    <a href="#" tabindex="0">
                                        <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}" class="default-img" alt="best review">
                                    </a>
                                </div>
                                <div class="review-itm-content">
                                    <div class="review-itm-content-top">
                                        <h3 class="review-title">
                                            {{$review->title}}
                                        </h3>
                                        <p class="description">{{$review->description}}</p>
                                    </div>
                                    <div class="review-card-bottom">
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
@endsection






