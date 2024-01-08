@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
    {{ __('Game') }}
@endsection

@section('content')

    <div class="wrapper">
        <section class="home-banner-section padding-top">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/main-banner.png') }}" class="main-banner"
                alt="image">
            <div class="container">
                <div class="row">
                    @if (!empty($latest_product))
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-card banner-card">
                        <div class="product-card-inner">
                            @php
                                $p_id = hashidsencode($latest_product->id);
                            @endphp
                            <div class="product-card-image image-inslide">
                                <div class="product-card-image-slider">
                                    @if ($latest_product->Sub_image($latest_product->id)['status'] == true)
                                        <img src="{{ get_file($latest_product->cover_image_path, APP_THEME()) }}">
                                        <div class="main-img">
                                            <a href="{{ route('page.product',[$slug, $p_id]) }}">
                                                <img src="{{ get_file($latest_product->Sub_image($latest_product->id)['data'][0]->image_path, APP_THEME()) }}">
                                            </a>
                                        </div>
                                    @else
                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id), APP_THEME()) }}">
                                    @endif
                                </div>
                                <div class="new-labl">
                                    {{ $latest_product->tag_api }}
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top d-flex align-items-end">
                                    <div class="product-content-left">
                                        <div class="product-subtitle">{{ $latest_product->ProductData()->name }}</div>
                                        <h3 class="product-title">
                                            <a href="{{ route('page.product',[$slug, $p_id]) }}" class="short_description">
                                                {{ $latest_product->name }}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="price">
                                        <ins>{{ $latest_product->final_price }} <span
                                                class="currency-type">{{ $currency }}</span></ins>
                                    </div>
                                </div>
                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                    <button class="btn red-btn addcart-btn-globaly" tabindex="0"
                                        product_id="{{ $latest_product->id }}"
                                        variant_id="{{ $latest_product->default_variant_id }}" qty="1">
                                        {{ __('Add to cart') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                            viewBox="0 0 4 6" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill="white" />
                                        </svg>
                                    </button>
                                    @auth
                                        <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                            product_id="{{ $latest_product->id }}"
                                            in_wishlist="{{ $latest_product->in_whishlist ? 'remove' : 'add' }}">
                                            <span class="wish-ic">
                                                <i
                                                    class="{{ $latest_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }} wishlist-icon"></i>
                                            </span>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 banner-card">
                        @foreach ($MainCategoryList->take(1) as $category)
                            <div class="pro-card">
                                <div class="pro-card-image">
                                    <img src="{{ $category->image_path }}" alt="images">
                                </div>
                                <div class="pro-card-content">
                                    <div class="title-wrap">
                                        {{-- <div class="product-subtitle">super Power</div> --}}
                                        <h3 class="title">
                                            <a
                                                href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{!! $category->name !!}</a>
                                        </h3>
                                    </div>
                                    <div class="price-wrap">
                                        {{-- <span>FROM</span>
                                <ins class="price">34,59 </ins>
                                <span class="currency-type">USD</span> --}}
                                    </div>
                                    <div class="btn-wrapper">
                                        <a href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}"
                                            class="btn red-btn">
                                            {{ __('Show more') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                                viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill="white"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            @foreach ($homepage_products as $homepage_product)
                                @php
                                    $p_id = hashidsencode($homepage_product->id);
                                @endphp
                                <div class="col-lg-12 col-xl-12 col-md-6 col-sm-6 col-12 product-right-first">
                                    <div class="product-card-right">
                                        <div class="product-img">
                                            <img src="{{ get_file($homepage_product->cover_image_path, APP_THEME()) }}"
                                                alt="Potato chips with onion">
                                        </div>
                                        <div class="product-card-body">
                                            <div class="card-head">
                                                <div class="badge-wrapper">
                                                    <div class="badge red-labl">
                                                        {{ $homepage_product->tag_api }}
                                                    </div>
                                                    <span class="discount-rate">{{ $homepage_product->discount_amount }}
                                                        @if ($homepage_product->discount_type == 'percentage')
                                                            %
                                                        @else
                                                            {{ $currency_icon }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="title-wrapper">
                                                <div class="product-subtitle">{{ $homepage_product->ProductData()->name }}
                                                </div>
                                                <h3 class="title">
                                                    <a
                                                        href="{{ route('page.product', [$slug,$p_id]) }}">{{ $homepage_product->name }}</a>
                                                </h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="price-wrap">
                                                    <span>{{ $currency }}</span>
                                                    <ins class="price">{{ $homepage_product->final_price }}
                                                        <del>{{ $homepage_product->price }}</del></ins>
                                                </div>
                                                <div class="btn-wrapper">
                                                    <button class="btn addcart-btn-globaly red-btn"
                                                        product_id="{{ $homepage_product->id }}"
                                                        variant_id="{{ $homepage_product->default_variant_id }}"
                                                        qty="1">
                                                        {{ __('Add to cart') }}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                            height="6" viewBox="0 0 4 6" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                fill="white"></path>
                                                        </svg>
                                                    </button>
                                                    @auth
                                                    <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{ $homepage_product->id }}" in_wishlist="{{ $homepage_product->in_whishlist ? 'remove' : 'add' }}">
                                                            <span class="wish-ic">
                                                                <i class="{{ $homepage_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style="color: red"></i>
                                                            </span>
                                                        </button>
                                                    @endauth
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

        <section class="category-section padding-bottom">
            <div class="container">
                {!! \App\Models\MainCategory::HomePageCategory($slug, 4) !!}
            </div>
        </section>

        <section class="today-discounts padding-bottom">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/discount-banner.png') }}"
                class="discount-banner" alt="image">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-banner-title') {
                                $product_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-button') {
                                $product_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="best-tabs">
                        <div class="section-title d-flex align-items-center justify-content-between">
                            <h2 class="title">{{ $product_title }}</h2>
                            <ul class="cat-tab tabs">
                                @foreach ($MainCategory as $cat_key => $category)
                                    <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}"
                                        data-tab="{{ $cat_key }}">
                                        <a href="javascript:;">{{ $category }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @foreach ($MainCategory as $cat_k => $category)
                            <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                                <div class="row product-list shop-protab-slider">
                                    @foreach ($homeproducts as $all_product)
                                        @php
                                            $p_id = hashidsencode($all_product->id);
                                        @endphp
                                        @if ($cat_k == '0' || $all_product->ProductData()->id == $cat_k)
                                            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 product-card col-12">
                                                <div class="product-card-inner">
                                                    <div class="product-card-image">
                                                        <a href="{{ route('page.product',[$slug, $p_id]) }}">
                                                            <img src="{{ get_file($all_product->cover_image_path, APP_THEME()) }}"
                                                                class="default-img">
                                                            {{-- @if ($all_product->Sub_image($all_product->id)['status'] == true)
                                                                <img src="{{ get_file($all_product->Sub_image($all_product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @else
                                                                <img src="{{ get_file($all_product->Sub_image($all_product->id), APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @endif --}}
                                                        </a>
                                                        <div class="new-labl  danger">
                                                            <span
                                                                class="discount-rate">{{ $all_product->discount_amount }}
                                                                @if ($all_product->discount_type == 'percentage')
                                                                    %
                                                                @else
                                                                    {{ $currency_icon }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-content-top d-flex align-items-end">
                                                            <div class="product-content-left">
                                                                <div class="product-type">{{ $all_product->tag_api }}
                                                                </div>
                                                                <h3 class="product-title">
                                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}" class="short_description">
                                                                        {!! $all_product->name !!}
                                                                    </a>
                                                                </h3>
                                                                <div class="reviews-stars-wrap d-flex align-items-center">
                                                                    @if (!empty($all_product->average_rating))
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            <i
                                                                                class="fa fa-star {{ $i < $all_product->average_rating ? '' : 'text-warning' }} "></i>
                                                                        @endfor
                                                                        <span><b>{{ $all_product->average_rating }}.0</b> / 5.0</span>
                                                                    @else
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            <i
                                                                                class="fa fa-star {{ $i < $all_product->average_rating ? '' : 'text-warning' }} "></i>
                                                                        @endfor
                                                                        <span><b>{{ $all_product->average_rating }}.0</b> / 5.0</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="product-content-center">
                                                            <div class="price">
                                                                <ins class="text-danger">{{ $all_product->final_price }}
                                                                    <span
                                                                        class="currency-type">{{ $currency }}</span></ins>
                                                                <del>{{ $all_product->price }} {{ $currency }}</del>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="product-content-bottom d-flex align-items-center justify-content-between">
                                                            <button class="addtocart-btn btn addcart-btn-globaly"
                                                                product_id="{{ $all_product->id }}"
                                                                variant_id="{{ $all_product->default_variant_id }}"
                                                                qty="1">
                                                                {{ __('Add to cart') }}
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                    height="6" viewBox="0 0 4 6" fill="none">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                            </button>
                                                            @auth
                                                                <button href="javascript:void(0)"
                                                                    class="wishlist-btn wbwish  wishbtn-globaly"
                                                                    product_id="{{ $all_product->id }}"
                                                                    in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add' }}">
                                                                    <span class="wish-ic">
                                                                        <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                            style='color: #000000'></i>
                                                                    </span>
                                                                </button>
                                                            @endauth
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
                    <div class="d-flex justify-content-center see-all-probtn">
                        <a href="{{ route('page.product-list',$slug) }}" class="btn">
                            {{ $product_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <section class="bestsellers-categories  padding-bottom padding-top">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/best-category.png') }}" alt="image">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-best-product', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-best-product-title') {
                                $best_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-best-product-button') {
                                $best_btn_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <h2>{{ $best_title }}</h2>
                        <a href="{{ route('page.product-list',$slug) }}" class="btn red-btn">
                            {{ $best_btn_text }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                @endif
                <div class="best-tabs">
                    <div class="tab-nav">
                        <ul class="cat-tab tabs">
                            @foreach ($MainCategory as $cat_key => $category)
                                <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">{{ $category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="cat-protab-slider light-arrows">
                                @foreach ($bestSeller as $bestSellers)
                                    @php
                                        $p_id = hashidsencode($bestSellers->id);
                                    @endphp
                                    @if ($cat_k == '0' || $bestSellers->ProductData()->id == $cat_k)
                                        <div class="category-widget">
                                            <div class="category-widget-inner">
                                                <div class="category-img">
                                                    <img
                                                        src="{{ get_file($bestSellers->cover_image_path, APP_THEME()) }}">
                                                </div>
                                                <div class="category-card-body">
                                                    <div class="title-wrapper">
                                                        <h4 class="title short_description">{{ $bestSellers->name }}</h4>
                                                    </div>
                                                    <div class="btn-wrapper">
                                                        <a href="{{ route('page.product-list',$slug) }}"
                                                            class="btn">{{ __('Show more') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                height="6" viewBox="0 0 4 6" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                    fill="white"></path>
                                                            </svg></a>
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
                <div class="mobile-only d-flex justify-content-center see-all-probtn">
                    <a href="{{ route('page.product-list',$slug) }}" class="btn btn-white">
                        {{ $best_btn_text }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill="white"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="our-client-section padding-bottom padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-logo-text') {
                                $logo_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title">
                        <h2>{{ $logo_title }}</h2>
                    </div>
                    <div class="client-logo-slider common-arrows">
                        @php
                            $homepage_logo = '';
                            $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_logo_key != '') {
                                $homepage_main_logo = $theme_json[$homepage_logo_key];
                            }
                        @endphp
                        @if (!empty($homepage_main_logo['homepage-logo-logo']))
                            @for ($i = 0; $i < count($homepage_main_logo['homepage-logo-logo']); $i++)
                                @php
                                    foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                            $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                        }
                                        if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                                $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <div class="client-logo-card">
                                    <div class="client-logo-item">
                                        <a href="#">
                                            <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
                                        </a>
                                    </div>
                                </div>
                            @endfor
                        @else
                            @for ($i = 0; $i <= 10; $i++)
                                @php
                                    foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                            $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                        }
                                    }
                                @endphp
                                <div class="client-logo-card">
                                    <div class="client-logo-item">
                                        <a href="#">
                                            <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
                                        </a>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <section class="best-product padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-discount-product', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-discount-product-title') {
                                $discount_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-discount-product-button') {
                                $discount_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2>{{ $discount_title }}</h2>
                    <a href="{{ route('page.product-list',$slug) }}" class="btn red-btn">
                        {{ $discount_btn }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill="white"></path>
                        </svg>
                    </a>
                </div>
                @endif
                <div class="row">
                    @foreach ($MainCategoryList->take(1) as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 category-widget">
                        <div class="category-widget-inner second-style">
                            <div class="category-img">
                                <img src="{{ get_file($category->image_path, APP_THEME()) }}" alt="Nuts">
                            </div>
                            <div class="category-card-body">
                                <div class="title-wrapper">
                                    <h3 class="title">
                                        <a href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{!! $category->name !!}</a>
                                    </h3>
                                </div>
                                <div class="btn-wrapper">
                                    <a href="{{ route('page.product-list',$slug) }}" class="btn red-btn">
                                        {{ __('Show more') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill="white"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-lg-9 col-md-8 col-sm-6 col-12">
                        <div class="best-product-slider">
                            @foreach ($home_products as $home_product)
                            @php
                                $p_id = hashidsencode($home_product->id)
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-card-image">
                                        <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                            <img src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}"
                                                class="default-img">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top d-flex align-items-end">
                                            <div class="product-content-left">
                                                <div class="product-subtitle">{{ $home_product->tag_api }}</div>
                                                <h3 class="product-title short_description">
                                                    <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                                        {{ $home_product->name }}
                                                    </a>
                                                </h3>
                                                <div class="reviews-stars-wrap d-flex align-items-center">
                                                    @if (!empty($home_product->average_rating))
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i class="fa fa-star {{ $i < $home_product->average_rating ? '' : 'text-warning' }} ">
                                                            </i>
                                                        @endfor
                                                    <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                                    @else
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i class="fa fa-star {{ $i < $home_product->average_rating ? '' : 'text-warning' }} ">
                                                            </i>
                                                        @endfor
                                                    <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                         <div class="product-content-center">
                                            <div class="price">
                                                <ins class="text-danger">{{ $home_product->final_price }} <span
                                                    class="currency-type">{{ $currency }}</span></ins>
                                            </div>
                                        </div>
                                        <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                            <button class="btn addcart-btn-globaly" product_id="{{ $home_product->id }}" variant_id="{{ $home_product->default_variant_id }}" qty="1">
                                                <span>{{ __('Add to cart') }} </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                                    viewBox="0 0 4 6" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                        fill="white"></path>
                                                </svg>
                                            </button>
                                            @auth
                                                <a href="javascript:void(0)"
                                                    class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{ $home_product->id }}" in_wishlist="{{ $home_product->in_whishlist ? 'remove' : 'add' }}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $home_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: #000000'></i>
                                                    </span>
                                                </a>
                                            @endauth
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

        <section class="testimonials padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-testimonial-title') {
                                $test_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-testimonial-button') {
                                $test_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <h2 class="title">{{ $test_title }}</h2>
                        <a href="{{ route('page.product-list',$slug) }}" class="btn desk-only">
                            {{ $test_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="review-slider">
                        @foreach ($reviews as $review)
                            <div class="testimonials-card">
                                <div class="testimonials-card-inner">
                                    <div class="reviews-stars-wrap d-flex align-items-center">
                                        <div class="point-wrap">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="fa fa-star {{ $i < $review->rating_no ? '' : 'text-warning' }} "></i>
                                            @endfor
                                            <span class="review-point"><b>{{ $review->rating_no }}.0</b> / 5.0</span>
                                        </div>
                                    </div>
                                    <div class="reviews-words">
                                        <h4 class="main-word">{!! $review->name !!}</h4>
                                        <p class="descriptions">{{ $review->description }}</p>
                                    </div>
                                    <div class="reviewer-profile">
                                        <div class="reviewer-img">
                                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/client.png') }}"
                                                alt="reviewer-img">
                                        </div>
                                        <div class="reviewer-desc">
                                            <span><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</b>
                                                Client</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mobile-only d-flex justify-content-center text-center">
                        <a href="{{ route('page.product-list',$slug) }}" class="btn">
                            {{ $test_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <section class="home-blog-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $blog_label = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $blog_sub_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-title">
                    <div class="tagline">{{ $blog_label }}</div>
                    <h2 class="title">{{ $blog_title }}</h2>
                    <div class="descripion">
                        <p>{!! $blog_sub_text !!}</p>
                    </div>
                </div>

                <div class="blog-slider">
                {!! \App\Models\Blog::HomePageBlog($slug, 6) !!}
                </div>
                @endif
            </div>
        </section>
    </div>

@endsection
