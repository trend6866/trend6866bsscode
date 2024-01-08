@extends('layouts.layouts')
@section('page-title')
    {{ __('Kitchen') }}
@endsection
@php
    $theme_json = $homepage_json;
@endphp

@section('content')
    @php
        $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
        if($homepage_header_1_key != '' ) {
            $homepage_header_1 = $theme_json[$homepage_header_1_key];
            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-header-label-text') {
                    $home_header_label = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($homepage_header_1['section_enable'] == 'on')
        <section class="main-home-first-section">
            <div class="fixed-slider-left">
                @php
                    $homepage_banner1 = array_search('homepage-banner-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_banner1 != '' ) {
                        $homepage_banner = $theme_json[$homepage_banner1];

                        $prev_index = $homepage_banner1;
                        $homepage_banner1_enable = $homepage_banner['section_enable'];
                        if( !empty($theme_json[$prev_index-1]) && $homepage_banner['section_slug'] == $theme_json[$prev_index-1]['section_slug']) {
                            $homepage_banner['section_enable'] = $theme_json[$prev_index-1]['section_enable'];
                        }
                        foreach ($homepage_banner['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-banner-label-text') {
                                $home_banner = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="slider-inner-text">
                    <h5>
                        {!! $home_banner !!}
                    </h5>
                </div>
                <div class="line"></div>
                <div class="slides-numbers" style="display: block;">
                    <span class="active">01</span> / <span class="total"></span>
                </div>
            </div>
            @php
                $homepage_banner_text = $homepage_banner_sub_text = $homepage_banner_desc = $homepage_banner_btn = $homepage_banner_btn1 = '';
                $homepage_banner2_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
                if($homepage_banner2_key != '')
                {
                    $homepage_banner2 = $theme_json[$homepage_banner2_key];
                }
            @endphp
            <div class="offset-container offset-left">
                <div class="home-slider-left-col">
                    <div class="home-left-slider">
                        @for($i = 0 ; $i < $homepage_banner2['loop_number']; $i++)
                            @php
                                foreach ($homepage_banner2['inner-list'] as $homepage_banner2_value)
                                {
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-label-text'){
                                        $homepage_banner_label = $homepage_banner2_value['field_default_text'];
                                    }
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-title-text'){
                                        $homepage_banner_text = $homepage_banner2_value['field_default_text'];
                                    }
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-sub-text'){
                                        $homepage_banner_sub_text = $homepage_banner2_value['field_default_text'];
                                    }
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-btn-text-1'){
                                        $homepage_banner_btn1 = $homepage_banner2_value['field_default_text'];
                                    }
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-btn-text-2'){
                                        $homepage_banner_btn2 = $homepage_banner2_value['field_default_text'];
                                    }
                                    if($homepage_banner2_value['field_slug'] == 'homepage-banner-img'){
                                        $homepage_banner_img = $homepage_banner2_value['field_default_text'];
                                    }

                                    if(!empty($homepage_banner2[$homepage_banner2_value['field_slug']]))  {
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-label-text'){
                                            $homepage_banner_label = $homepage_banner2[$homepage_banner2_value['field_slug']][$i];
                                        }
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-title-text'){
                                            $homepage_banner_text = $homepage_banner2[$homepage_banner2_value['field_slug']][$i];
                                        }
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-sub-text'){
                                            $homepage_banner_sub_text = $homepage_banner2[$homepage_banner2_value['field_slug']][$i];
                                        }
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-btn-text-1'){
                                            $homepage_banner_btn1 = $homepage_banner2[$homepage_banner2_value['field_slug']][$i];
                                        }
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-btn-text-2'){
                                            $homepage_banner_btn2 = $homepage_banner2[$homepage_banner2_value['field_slug']][$i];
                                        }
                                        if($homepage_banner2_value['field_slug'] == 'homepage-banner-img'){
                                            $homepage_banner_img = $homepage_banner2[$homepage_banner2_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="left-slider-item">
                                <div class="d-flex w-100 align-items-center no-gutters">
                                    <div class="col-md-5 col-12">
                                        <div class="left-slide-itm-inner">
                                            <div class="section-title">
                                                <span class="subtitle">{!! $homepage_banner_label !!}</span>
                                                <h2>{!! $homepage_banner_text !!}</h2>
                                            </div>
                                            <p>{!! $homepage_banner_sub_text !!}</p>
                                            <div class="flex-btn d-flex align-items-center">
                                                <a href="{{route('page.product-list',$slug)}}" class="btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"/>
                                                    </svg>
                                                    {!! $homepage_banner_btn1 !!}
                                                </a>
                                                <a href="{{route('page.product-list',$slug)}}" class="btn-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.97487 11.0098C8.98031 11.7822 7.73058 12.2422 6.37332 12.2422C3.12957 12.2422 0.5 9.61492 0.5 6.37402C0.5 3.13313 3.12957 0.505859 6.37332 0.505859C9.61706 0.505859 12.2466 3.13313 12.2466 6.37402C12.2466 7.73009 11.7863 8.97872 11.0131 9.97241L13.285 12.2421C13.5717 12.5285 13.5717 12.993 13.285 13.2794C12.9983 13.5659 12.5334 13.5659 12.2467 13.2794L9.97487 11.0098ZM10.7783 6.37402C10.7783 8.8047 8.80612 10.7751 6.37332 10.7751C3.94051 10.7751 1.96833 8.8047 1.96833 6.37402C1.96833 3.94335 3.94051 1.9729 6.37332 1.9729C8.80612 1.9729 10.7783 3.94335 10.7783 6.37402Z" fill="#494949"/>
                                                    </svg>
                                                    {!! $homepage_banner_btn2 !!}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-12">
                                        <div class="banner-image">
                                            <img src="{{get_file($homepage_banner_img , APP_THEME())}}" alt="banner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    @endif
    @php
        $homepage_bestseller_product = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if($homepage_bestseller_product != '')
        {
            $homepage_bestseller = $theme_json[$homepage_bestseller_product];
            $section_enable = $homepage_bestseller['section_enable'];
            foreach ($homepage_bestseller['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-bestseller-title-text') {
                    $home_bestseller_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-bestseller-btn-text') {
                    $home_bestseller_btn = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($homepage_bestseller['section_enable'] == 'on')
        <section class="bestseller-section bst-1">
            <div class="best-seller-head">
                <div class="section-title">
                    <h4>{!! $home_bestseller_text !!}</h4>
                </div>
                <a href="{{route('page.product-list',$slug)}}" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                    </svg>
                    <span> {!! $home_bestseller_btn !!}</span>
                </a>
            </div>
            <div class="container">
                <div class="bessell-row row no-gutters">
                    @foreach ($bestSeller->take(3) as $bs_product)
                        <div class="col-md-4 col-sm-4 col-12 product-card">
                            @php
                                $p_id = hashidsencode($bs_product->id);
                            @endphp
                            <div class="product-card-inner">
                                <div class="pro-img">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{ get_file($bs_product->cover_image_path , APP_THEME()) }}">
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <div class="pro-content-inner">
                                        <div class="pro-content-top">
                                            <div class="content-title">
                                                <div class="subtitle">
                                                    <span>{{ $bs_product->ProductData()->name }}</span>
                                                    @auth
                                                        <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$bs_product->id}}" in_wishlist="{{ $bs_product->in_whishlist ? 'remove' : 'add'}}" >
                                                            <span class="wish-ic">
                                                                <i class="{{ $bs_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                            </span>
                                                        </a>
                                                    @endauth
                                                </div>
                                                <h4><a href="{{route('page.product',[$slug,$p_id])}}">{{ $bs_product->name }}</a></h4>
                                            </div>
                                            {{-- <div class="order-select">
                                                <div class="checkbox check-product">
                                                    <input id="checkbox-1" name="radio" type="checkbox" value=".blue" checked>
                                                    <label for="checkbox-1" class="checkbox-label">3x Set</label>
                                                </div>
                                                <div class="checkbox check-product">
                                                    <input id="checkbox-2" name="radio" type="checkbox" value=".blue">
                                                    <label for="checkbox-2" class="checkbox-label">7x Set</label>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="price">
                                            <ins>{{ $bs_product->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                        <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $bs_product->id }}" variant_id="{{ $bs_product->default_variant_id }}" qty="1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21665 8.50065C3.9978 8.50065 3.83133 8.69717 3.86731 8.91304L4.54572 12.9836C4.65957 13.6667 5.25059 14.1673 5.94311 14.1673H11.0594C11.7519 14.1673 12.3429 13.6667 12.4568 12.9836L13.1352 8.91304C13.1712 8.69717 13.0047 8.50065 12.7859 8.50065H4.21665ZM2.96241 7.08398C2.52471 7.08398 2.19176 7.47702 2.26372 7.90877L3.14833 13.2164C3.37603 14.5826 4.55807 15.584 5.94311 15.584H11.0594C12.4444 15.584 13.6265 14.5826 13.8542 13.2164L14.7388 7.90877C14.8107 7.47702 14.4778 7.08398 14.0401 7.08398H2.96241Z" fill="#12131A"/>
                                                <path d="M7.08333 9.91602C6.69213 9.91602 6.375 10.2331 6.375 10.6243V12.041C6.375 12.4322 6.69213 12.7493 7.08333 12.7493C7.47453 12.7493 7.79167 12.4322 7.79167 12.041V10.6243C7.79167 10.2331 7.47453 9.91602 7.08333 9.91602Z" fill="#12131A"/>
                                                <path d="M9.91667 9.91602C9.52547 9.91602 9.20833 10.2331 9.20833 10.6243V12.041C9.20833 12.4322 9.52547 12.7493 9.91667 12.7493C10.3079 12.7493 10.625 12.4322 10.625 12.041V10.6243C10.625 10.2331 10.3079 9.91602 9.91667 9.91602Z" fill="#12131A"/>
                                                <path d="M7.5855 2.62522C7.86212 2.34859 7.86212 1.9001 7.5855 1.62348C7.30888 1.34686 6.86039 1.34686 6.58377 1.62348L3.75043 4.45682C3.47381 4.73344 3.47381 5.18193 3.75043 5.45855C4.02706 5.73517 4.47555 5.73517 4.75217 5.45855L7.5855 2.62522Z" fill="#12131A"/>
                                                <path d="M9.4171 2.62522C9.14048 2.34859 9.14048 1.9001 9.4171 1.62348C9.69372 1.34686 10.1422 1.34686 10.4188 1.62348L13.2522 4.45682C13.5288 4.73344 13.5288 5.18193 13.2522 5.45855C12.9755 5.73517 12.5271 5.73517 12.2504 5.45855L9.4171 2.62522Z" fill="#12131A"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4596 5.66667H3.54297C3.15177 5.66667 2.83464 5.9838 2.83464 6.375C2.83464 6.7662 3.15177 7.08333 3.54297 7.08333H13.4596C13.8508 7.08333 14.168 6.7662 14.168 6.375C14.168 5.9838 13.8508 5.66667 13.4596 5.66667ZM3.54297 4.25C2.36936 4.25 1.41797 5.20139 1.41797 6.375C1.41797 7.5486 2.36936 8.5 3.54297 8.5H13.4596C14.6332 8.5 15.5846 7.5486 15.5846 6.375C15.5846 5.20139 14.6332 4.25 13.4596 4.25H3.54297Z" fill="#12131A"/>
                                            </svg>
                                            {{ __('Add to cart') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="client-logo-section padding-top padding-bottom">
        @php
            $homepage_logo = '';
            $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
            if($homepage_logo_key != ''){
                $homepage_main_logo = $theme_json[$homepage_logo_key];
            }
        @endphp
        @if($homepage_main_logo['section_enable'] == 'on')
            <div class="container">
                <div class="client-logo-slider">
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
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{get_file($homepage_logo , APP_THEME())}}" alt="logo">
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
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{$homepage_logo}}" alt="logo">
                                </a>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        @endif
    </section>

    @php
        $homepage_best_product_heading = $homepage_best_product_subtext = $homepage_best_product_btn = '';
            $homepage_best_product_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
            if($homepage_best_product_key != ''){
                $homepage_best_product = $theme_json[$homepage_best_product_key];

                foreach ($homepage_best_product['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-products-label-text'){
                        $homepage_best_product_label = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-products-title-text'){
                        $homepage_best_product_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-products-sub-text'){
                        $homepage_best_product_subtext = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-products-btn-text-1'){
                        $homepage_best_product_btn1 = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-products-btn-text-2'){
                        $homepage_best_product_btn2 = $value['field_default_text'];
                    }
                }
            }
    @endphp
    @if($homepage_best_product['section_enable'] == 'on')
        <section class="bestseller-section product-card-section padding-bottom">
            <div class="container">
                <div class="product-card-head d-flex align-items-center justify-content-between">
                    <div class="section-title">
                        <span class="subtitle">{!! $homepage_best_product_label !!}</span>
                        <h2>{!! $homepage_best_product_text !!}</h2>
                    </div>
                    <p>{!! $homepage_best_product_subtext !!}</p>
                    <a href="{{route('page.product-list',$slug)}}" class="btn" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                        </svg>
                        {!! $homepage_best_product_btn1 !!}
                    </a>
                </div>
                <div class="bg-black product-card-reverse product-two-row-slider">
                    @foreach ($products as $product)
                        @php
                            $p_id = hashidsencode($product->id);
                        @endphp
                        <div class="product-card-slider-main">
                            <div class="bestseller-itm product-card">
                                <div class="product-card-inner">
                                    <div class="pro-img">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}">
                                        </a>
                                    </div>
                                    <div class="pro-content">
                                        <div class="pro-content-inner">
                                            <div class="pro-content-top">
                                                <div class="content-title">
                                                    <div class="subtitle">
                                                        <span> {{$product->ProductData()->name}}</span>
                                                        @auth
                                                            <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}" >
                                                                <span class="wish-ic">
                                                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                </span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                    <h4><a href="{{route('page.product',[$slug,$p_id])}}">{{$product->name}}</a></h4>
                                                </div>
                                            </div>
                                            <div class="price">
                                                <ins>{{ $product->final_price }}  <span class="currency-type">{{$currency}}</span></ins>
                                            </div>
                                            <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
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
                        </div>
                    @endforeach
                </div>
                <div class="single-btn">
                    <a href="{{route('page.product-list',$slug)}}" class="btn" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                        </svg>
                        {!! $homepage_best_product_btn2 !!}
                    </a>
                </div>
            </div>
        </section>
    @endif
    @php
        $homepage_category_label = $homepage_category_text = $homepage_category_subtext = $homepage_category_btn = '';

        $homepage_category_key = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
        if($homepage_category_key != '') {
            $homepage_category = $theme_json[$homepage_category_key];

            foreach ($homepage_category['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-category-label-text') {
                $homepage_category_label = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-category-title-text') {
                $homepage_category_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-category-sub-text') {
                $homepage_category_subtext = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-category-btn-text') {
                $homepage_category_btn = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($homepage_category['section_enable'] == 'on')
        <section class="modern-accessories-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        @foreach ($MainCategoryList->take(1) as $category)
                            <div class="modern-accessories">
                                <div class="modern-accessories-inner">
                                    <div class="modern-accessories-image">
                                        <img src="{{get_file($category->image_path , APP_THEME())}}">
                                        <div class="modern-accessories-content">
                                            <div class="content-title">
                                                <div class="subtitle">
                                                    <span>{!! $homepage_category_label !!}</span>
                                                </div>
                                                <h4>
                                                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" tabindex="0">{{$category->name}}
                                                    </a>
                                                </h4>
                                                <a href="{{route('page.product-list',$slug)}}" class="btn-secondary" tabindex="0">{{__('Show More')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="right-slide-itm-inner">
                            <div class="section-title">
                                <span class="subtitle">{!! $homepage_category_label !!}</span>
                                <h2>{!! $homepage_category_text !!}</h2>
                            </div>
                            <p>{!! $homepage_category_subtext !!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                                </svg>
                                {!! $homepage_category_btn !!}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_testimonials_heading = '';

        $homepage_testimonials_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
        if($homepage_testimonials_key != '') {
            $homepage_testimonials = $theme_json[$homepage_testimonials_key];

        foreach ($homepage_testimonials['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-testimonial-title-text') {
            $homepage_testimonials_heading = $value['field_default_text'];
            }
        }
        }
    @endphp
    @if($homepage_testimonials['section_enable'] == 'on')
        <section class="testimonials-section padding-top padding-bottom">
            <div class="container">
                <div class="section-title padding-top">
                    <h2>
                        <b>{!! $homepage_testimonials_heading !!}</b>
                    </h2>
                </div>
                <div class="testimonial-slider flex-slider">
                    @foreach ($reviews as $review)
                    <div class="testimonial-itm">
                        <div class="testimonial-itm-inner">
                            <div class="testimonial-itm-content">
                                <span>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}, {{$review->UserData->type}}</span>
                                <div class="testimonial-content-top">
                                    <h3 class="testimonial-title">
                                        {{$review->title}}
                                    </h3>
                                </div>
                                <p class="descriptions">{{$review->description}}</p>
                                <div class="testimonial-star">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                        @endfor
                                        <span class="star-count">{{$review->rating_no}}.5 / <b> 5.0</b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-itm-image">
                                <a href="#" tabindex="0">
                                    <img src="{{asset('/'. !empty($review->ProductData()) ? $review->ProductData->cover_image_path : '' )}}" class="default-img" alt="review" >
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_feature_product = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if($homepage_feature_product != '')
        {
            $homepage_feature = $theme_json[$homepage_feature_product];
            $section_enable = $homepage_feature['section_enable'];
            foreach ($homepage_feature['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-feature-products-title-text') {
                    $home_feature_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-feature-products-btn-text') {
                    $home_feature_btn = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($homepage_feature['section_enable'] == 'on')
        <section class="bestseller-section bst-3">
            <div class="best-seller-head">
                <div class="section-title">
                    <h4>{!! $home_feature_text !!}</h4>
                </div>
                <a href="{{route('page.product-list',$slug)}}" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                    </svg>
                    <span> {!! $home_feature_btn !!}</span>
                </a>
            </div>
            <div class="container">
                <div class="bessell-row row no-gutters">
                    @foreach ($home_products->take(3) as $hp_product)
                        <div class="col-md-4 col-sm-4 col-12 product-card">
                            @php
                                $p_id = hashidsencode($hp_product->id);
                            @endphp
                            <div class="product-card-inner">
                                <div class="pro-img">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{ get_file($hp_product->cover_image_path , APP_THEME()) }}">
                                    </a>
                                </div>
                                <div class="pro-content">
                                    <div class="pro-content-inner">
                                        <div class="pro-content-top">
                                            <div class="content-title">
                                                <div class="subtitle">
                                                    <span> {{ $hp_product->ProductData()->name }}</span>
                                                    @auth
                                                        <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$hp_product->id}}" in_wishlist="{{ $hp_product->in_whishlist ? 'remove' : 'add'}}" >
                                                            <span class="wish-ic">
                                                                <i class="{{ $hp_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                            </span>
                                                        </a>
                                                    @endauth
                                                </div>
                                                <h4><a href="{{route('page.product',[$slug,$p_id])}}">{{ $hp_product->name }}</a></h4>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <ins>{{ $hp_product->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                        <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $hp_product->id }}" variant_id="{{ $hp_product->default_variant_id }}" qty="1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21665 8.50065C3.9978 8.50065 3.83133 8.69717 3.86731 8.91304L4.54572 12.9836C4.65957 13.6667 5.25059 14.1673 5.94311 14.1673H11.0594C11.7519 14.1673 12.3429 13.6667 12.4568 12.9836L13.1352 8.91304C13.1712 8.69717 13.0047 8.50065 12.7859 8.50065H4.21665ZM2.96241 7.08398C2.52471 7.08398 2.19176 7.47702 2.26372 7.90877L3.14833 13.2164C3.37603 14.5826 4.55807 15.584 5.94311 15.584H11.0594C12.4444 15.584 13.6265 14.5826 13.8542 13.2164L14.7388 7.90877C14.8107 7.47702 14.4778 7.08398 14.0401 7.08398H2.96241Z" fill="#12131A"/>
                                                <path d="M7.08333 9.91602C6.69213 9.91602 6.375 10.2331 6.375 10.6243V12.041C6.375 12.4322 6.69213 12.7493 7.08333 12.7493C7.47453 12.7493 7.79167 12.4322 7.79167 12.041V10.6243C7.79167 10.2331 7.47453 9.91602 7.08333 9.91602Z" fill="#12131A"/>
                                                <path d="M9.91667 9.91602C9.52547 9.91602 9.20833 10.2331 9.20833 10.6243V12.041C9.20833 12.4322 9.52547 12.7493 9.91667 12.7493C10.3079 12.7493 10.625 12.4322 10.625 12.041V10.6243C10.625 10.2331 10.3079 9.91602 9.91667 9.91602Z" fill="#12131A"/>
                                                <path d="M7.5855 2.62522C7.86212 2.34859 7.86212 1.9001 7.5855 1.62348C7.30888 1.34686 6.86039 1.34686 6.58377 1.62348L3.75043 4.45682C3.47381 4.73344 3.47381 5.18193 3.75043 5.45855C4.02706 5.73517 4.47555 5.73517 4.75217 5.45855L7.5855 2.62522Z" fill="#12131A"/>
                                                <path d="M9.4171 2.62522C9.14048 2.34859 9.14048 1.9001 9.4171 1.62348C9.69372 1.34686 10.1422 1.34686 10.4188 1.62348L13.2522 4.45682C13.5288 4.73344 13.5288 5.18193 13.2522 5.45855C12.9755 5.73517 12.5271 5.73517 12.2504 5.45855L9.4171 2.62522Z" fill="#12131A"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4596 5.66667H3.54297C3.15177 5.66667 2.83464 5.9838 2.83464 6.375C2.83464 6.7662 3.15177 7.08333 3.54297 7.08333H13.4596C13.8508 7.08333 14.168 6.7662 14.168 6.375C14.168 5.9838 13.8508 5.66667 13.4596 5.66667ZM3.54297 4.25C2.36936 4.25 1.41797 5.20139 1.41797 6.375C1.41797 7.5486 2.36936 8.5 3.54297 8.5H13.4596C14.6332 8.5 15.5846 7.5486 15.5846 6.375C15.5846 5.20139 14.6332 4.25 13.4596 4.25H3.54297Z" fill="#12131A"/>
                                            </svg>
                                            {{ __('Add to cart') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_subscribe = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if($homepage_subscribe != '')
        {
            $home_subscribe = $theme_json[$homepage_subscribe];
            $section_enable = $home_subscribe['section_enable'];
            foreach ($home_subscribe['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-newsletter-label-text') {
                    $home_subscribe_label= $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-newsletter-title-text') {
                    $home_subscribe_text= $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                    $home_subscribe_sub_text= $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-newsletter-description') {
                    $home_subscribe_description = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-newsletter-image') {
                    $home_subscribe_image= $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($home_subscribe['section_enable'] == 'on')
        <section class="form-section form-bg padding-top padding-bottom" style="background-image: url({{ get_file($home_subscribe_image , APP_THEME()) }});">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="left-slide-itm-inner">
                            <div class="section-title">
                                <span class="subtitle">{!! $home_subscribe_label !!}</span>
                                <h2>{!! $home_subscribe_text !!}</h2>
                            </div>
                            <p>{!! $home_subscribe_sub_text !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <form class="" action="{{ route("newsletter.store",$slug) }}" method="post">
                            @csrf
                            <div class="form-subscribe">
                                <span>{{__('Type your email:')}}</span>
                                <div class="input-wrapper">
                                    <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                    <button class="btn-subscibe">{{__('Subscribe')}}</button>
                                </div>
                                <label for="FotterCheckbox">{!! $home_subscribe_description !!}</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if($homepage_blog != '')
        {
            $home_blog = $theme_json[$homepage_blog];
            $section_enable = $home_blog['section_enable'];
            foreach ($home_blog['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-blog-title-text') {
                    $home_blog_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if($home_blog['section_enable'] == 'on')
        <section class="blog-section padding-top padding-bottom">
            <div class="container">
                <div class="section-title">
                    <h2>
                        <b>{!! $home_blog_text !!}</b>
                    </h2>
                </div>
                <div class="about-card-slider">
                    {!! \App\Models\Blog::HomePageBlog($slug , $no=10) !!}
                </div>
            </div>
        </section>
    @endif
@endsection
@push('page-script')
@endpush
