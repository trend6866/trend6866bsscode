@extends('layouts.layouts')

@section('page-title')
    {{ __('Menswear') }}
@endsection

@php
    $theme_json = $homepage_json;
    if (Auth::user()) {
        $carts = App\Models\Cart::where('user_id', Auth::user()->id)
            ->where('theme_id', env('APP_THEME'))
            ->get();
        $cart_product_count = $carts->count();
    }
@endphp

@section('content')
    <!--wrapper start here-->

    <section class="main-hiro-section">
        <div class="banner-labl">
            <span>Men's<br> Fashion</span>
        </div>
        <div class="banner-labl bottom-bnr-lbl">
            <span>Men's<br> Fashion</span>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 main-hiro-col">
                    <div class="main-hiro-left">
                        @php
                            $homepage_header_1_key = array_search('homepage-header-3', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-header-title-text') {
                                        $home_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-sub-text') {
                                        $home_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-btn-text') {
                                        $home_button = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <div class="main-hiro-left-top">
                                <h2 class="h1">{{ $home_title }}</h2>
                                <p>{{ $home_text }}
                                </p>
                                <a href="#" class="btn">{{ $home_button }}</a>
                            </div>
                        @endif

                        <div class="main-hiro-left-bottom">
                            @foreach ($homepage_products->take(1) as $home_product)
                                <div class="subtitle">{{ $home_product->tag_api }}</div>
                                <h2> {{ $home_product->name }}</h2>
                                {{-- <div class="size-selectors d-flex align-items-center">
                                    </div> --}}
                                <div class="price-btn">
                                    <span class="price">
                                        <ins>{{ $home_product->final_price }}{{ $currency }}</ins>
                                    </span>
                                    <button class="cart-button bg-grey addcart-btn-globaly" type="submit" tabindex="-1"
                                        product_id="{{ $home_product->id }}"
                                        variant_id="{{ $home_product->default_variant_id }}" qty="1">
                                        <svg width="20" height="20" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                            </path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 main-hiro-col">
                    <div class="main-hiro-center">
                        <img src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                        <div class="tooltip" style="top: 18%;right: 19%;">
                            <span class="round"></span>
                            <span
                                class="tooltip-txt">{{ __('100% Woll
                                                                    Material') }}</span>
                        </div>
                        <div class="tooltip" style="bottom: 32%;right: 8%;">
                            <span class="round"></span>
                            <span class="tooltip-txt">{{ __('Elastic Material') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-lg-4 col-md-6 col-12 main-hiro-col">
                    <div class="main-hiro-right">
                        <div class="main-hiro-pro-box bg-light">
                            <div class="main-hiro-pro-slider">
                                @foreach ($home_products as $home_product)
                                    @php
                                        $p_id = hashidsencode($home_product->id);
                                    @endphp
                                    <div class="hiro-pro-itm product-card ">
                                        <div class="product-card-inner">
                                            <div class="product-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img
                                                        src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-cont-top">
                                                    <div class="subtitle">{{ $home_product->tag_api }}</div>
                                                    <h3><a
                                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $home_product->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-cont-bottom">
                                                    <div class="price-btn">
                                                        <span class="price">
                                                            <ins>{{ $home_product->final_price }}{{ $currency }}</ins>
                                                        </span>
                                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                                            product_id="{{ $home_product->id }}"
                                                            variant_id="{{ $home_product->default_variant_id }}"
                                                            qty="1">
                                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}" class="link-btn">
                                                        {{ __('Read More') }}
                                                        <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
                        <div class="main-hiro-pro-box bg-black">
                            <div class="main-hiro-pro-slider product-card-reverse">
                                @foreach ($home_products as $home_product)
                                    @php
                                        $p_id = hashidsencode($home_product->id);
                                    @endphp
                                    <div class="hiro-pro-itm product-card ">
                                        <div class="product-card-inner">
                                            <div class="product-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img
                                                        src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-cont-top">
                                                    <div class="subtitle">{{ $home_product->tag_api }}</div>
                                                    <h3><a
                                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $home_product->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-cont-bottom">
                                                    <div class="price-btn">
                                                        <span class="price">
                                                            <ins>{{ $home_product->final_price }}{{ $currency }}</ins>
                                                        </span>
                                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                                            product_id="{{ $home_product->id }}"
                                                            variant_id="{{ $home_product->default_variant_id }}"
                                                            qty="1">
                                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <a href="product.html" class="link-btn">
                                                        Read More
                                                        <svg width="6" height="5" viewBox="0 0 6 5"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
                        <div class="main-hiro-pro-box bg-light">
                            <div class="main-hiro-pro-slider">
                                @foreach ($home_products as $home_product)
                                    @php
                                        $p_id = hashidsencode($home_product->id);
                                    @endphp
                                    <div class="hiro-pro-itm product-card ">
                                        <div class="product-card-inner">
                                            <div class="product-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img
                                                        src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-cont-top">
                                                    <div class="subtitle">{{ $home_product->tag_api }}</div>
                                                    <h3><a
                                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $home_product->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-cont-bottom">
                                                    <div class="price-btn">
                                                        <span class="price">
                                                            <ins>{{ $home_product->final_price }}{{ $currency }}</ins>
                                                        </span>
                                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                                            product_id="{{ $home_product->id }}"
                                                            variant_id="{{ $home_product->default_variant_id }}"
                                                            qty="1">
                                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <a href="product.html" class="link-btn">
                                                        Read More
                                                        <svg width="6" height="5" viewBox="0 0 6 5"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-cat-section padding-top  padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 home-cat-left">
                    <div class="home-cat-left-inner">
                        @foreach ($homepage_products as $home_product)
                            <div class="home-cat-box">
                                <a href="{{ route('page.product-list', $slug) }}">
                                    <img src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                                    <div class="home-cat-text">
                                        <div class="subtitle">{{ $home_product->tag_api }}</div>
                                        <h3> {{ $home_product->name }}</h3>
                                        <div class="link-btn justify-content-start">
                                            {{ __('See More') }}
                                            <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8 col-12 home-cat-right">
                    @php
                        $homepage_header_1_key = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-category-title-text') {
                                    $home_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-sub-text') {
                                    $home_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-btn-text') {
                                    $home_button = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="home-cat-right-inner">
                            <div class="section-title">
                                <h3>{{ $home_title }}</h3>
                            </div>
                            <p>{!! $home_text !!}</p>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn">{{ $home_button }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="new-featured-section padding-bottom">
        @php
            $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
            // dd($homepage_header_1_key);
            if ($homepage_header_1_key != '') {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-feature-products-label') {
                        $home_label = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-feature-products-title-text') {
                        $home_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-feature-products-img') {
                        $home_image = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-feature-products-btn-text') {
                        $home_button = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if ($homepage_header_1['section_enable'] == 'on')
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-12 feature-title">
                        <div class="feature-verticle">
                            <strong class="subheading">{{ $home_label }}</strong>
                            <h2>{!! $home_text !!}</h2>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-10 col-12 feature-img">
                        <a href="#" class="featured-img-wrp">
                            <img src="{{ get_file($home_image, APP_THEME()) }}">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 feature-pro">
                        @foreach ($homepage_products as $home_product)
                            @php
                                $p_id = hashidsencode($home_product->id);
                            @endphp
                            <div class="feature-pro-itm product-card bg-light">
                                <div class="product-card-inner">
                                    <div class="product-image">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-cont-top">
                                            <div class="subtitle">{{ $home_product->tag_api }}</div>
                                            <h3><a
                                                    href="{{ route('page.product', [$slug, $p_id]) }}">{{ $home_product->name }}</a>
                                            </h3>
                                        </div>
                                        <div class="product-cont-bottom">
                                            <div class="price-btn">
                                                <span class="price">
                                                    <ins>{{ $home_product->final_price }}{{ $currency }}</ins>
                                                </span>
                                                <button class="cart-button addcart-btn-globaly" type="submit"
                                                    product_id="{{ $home_product->id }}"
                                                    variant_id="{{ $home_product->default_variant_id }}" qty="1">
                                                    <svg width="20" height="20" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                        </path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}" class="link-btn">
                                                {{ __('Read More') }}
                                                <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
            </div>
            <div class="border-left-btn">
                <a href="{{ route('page.product-list', $slug) }}" class="btn">{{ $home_button }}</a>
            </div>
        @endif
    </section>

    <section class="bestseller-section tabs-wrapper">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));

                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $home_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <h2>{{ $home_title }}</h2>
                @endif
                <ul class="cat-tab tabs">
                    @foreach ($MainCategory as $cat_key => $category)
                        <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                            <a href="javascript:;">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                        <div class="bg-black product-card-reverse product-two-row-slider">
                            @foreach ($homeproducts as $homeproduct)
                                @php
                                    $p_id = hashidsencode($homeproduct->id);
                                @endphp
                                @if ($cat_k == '0' || $homeproduct->ProductData()->id == $cat_k)
                                    <div class="bestseller-itm product-card">
                                        <div class="product-card-inner">
                                            <div class="product-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img
                                                        src="{{ get_file($homeproduct->cover_image_path, APP_THEME()) }}">
                                                </a>
                                                <div class="d-flex justify-content-end wsh-wrp">
                                                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly"
                                                        product_id="{{ $homeproduct->id }}"
                                                        in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add' }}">
                                                        <span class="wish-ic">
                                                            <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                style='color: rgb(255, 254, 254)'></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-cont-top">
                                                    <div class="subtitle">{{ $homeproduct->tag_api }}</div>
                                                    <h3>
                                                        <a
                                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $homeproduct->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-cont-bottom">
                                                    <div class="price-btn">
                                                        <span class="price">
                                                            <ins>{{ $homeproduct->final_price }}{{ $currency }}</ins>
                                                        </span>
                                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                                            product_id="{{ $homeproduct->id }}"
                                                            variant_id="{{ $homeproduct->default_variant_id }}"
                                                            qty="1">
                                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                </path>
                                                            </svg>
                                                        </button>
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
        </div>
    </section>

    <section class="men-skincare-section padding-top padding-bottom">
        <div class="offset-container offset-left">
            @php
                $homepage_header_1_key = array_search('homepage-trending-products', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-trending-products-label') {
                            $home_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-trending-products-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-trending-products-img') {
                            $home_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                <div class="row no-gutters">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-12 skincare-left-box">
                        <div class="skincare-left">

                            <div class="section-title">
                                <div class="subtitle">{{ $home_title }}</div>
                                <h2>{!! $home_text !!}</h2>
                            </div>
                            <div class="skincare-pro ">
                                <div class="skincare-pro-full">
                                    <div class="main-hiro-pro-slider bg-light">
                                        @foreach ($home_products as $homepage_product)
                                            @php
                                                $p_id = hashidsencode($homepage_product->id);
                                            @endphp
                                            <div class="hiro-pro-itm product-card ">
                                                <div class="product-card-inner">

                                                    <div class="product-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img
                                                                src="{{ get_file($homepage_product->cover_image_path, APP_THEME()) }}">
                                                        </a>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-cont-top">
                                                            <div class="subtitle">{{ $homepage_product->tag_api }}</div>
                                                            <h3><a
                                                                    href="{{ route('page.product', [$slug, $p_id]) }}">{{ $homepage_product->name }}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="product-cont-bottom">
                                                            <div class="price-btn">
                                                                <span class="price">
                                                                    <ins>{{ $homepage_product->final_price }}{{ $currency }}</ins>
                                                                </span>
                                                                <button class="cart-button addcart-btn-globaly"
                                                                    type="submit"
                                                                    product_id="{{ $homepage_product->id }}"
                                                                    variant_id="{{ $homepage_product->default_variant_id }}"
                                                                    qty="1">
                                                                    <svg width="20" height="20"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                        </path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                                class="link-btn">
                                                                {{ __('Read More') }}
                                                                <svg width="6" height="5" viewBox="0 0 6 5"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
                                <div class="skincare-pro-full">
                                    <div class="main-hiro-pro-slider bg-light">
                                        @foreach ($home_products as $homepage_product)
                                            @php
                                                $p_id = hashidsencode($homepage_product->id);
                                            @endphp
                                            <div class="hiro-pro-itm product-card ">
                                                <div class="product-card-inner">
                                                    <div class="product-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img
                                                                src="{{ get_file($homepage_product->cover_image_path, APP_THEME()) }}">
                                                        </a>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-cont-top">
                                                            <div class="subtitle">{{ $homepage_product->tag_api }}</div>
                                                            <h3><a href="product.html">{{ $homepage_product->name }}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="product-cont-bottom">
                                                            <div class="price-btn">
                                                                <span class="price">
                                                                    <ins>{{ $homepage_product->final_price }}{{ $currency }}</ins>
                                                                </span>
                                                                <button class="cart-button addcart-btn-globaly"
                                                                    type="submit"
                                                                    product_id="{{ $homepage_product->id }}"
                                                                    variant_id="{{ $homepage_product->default_variant_id }}"
                                                                    qty="1">
                                                                    <svg width="20" height="20"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                        </path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                                class="link-btn">
                                                                {{ __('Read More') }}
                                                                <svg width="6" height="5" viewBox="0 0 6 5"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-6 col-12">
                        <div class="skincare-right">
                            <img src="{{ get_file($home_img, APP_THEME()) }}">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="bestseller-section padding-bottom tabs-wrapper">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));

                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $home_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <h2>{{ $home_title }}</h2>
                @endif
                <ul class="cat-tab tabs">
                    @foreach ($MainCategory as $cat_key => $category)
                        <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}_data">
                            <a href="javascript:;">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}_data" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                        <div class="bg-black product-card-reverse bestsell-slider">
                            @foreach ($homeproducts as $homeproduct)
                                @php
                                    $p_id = hashidsencode($homeproduct->id);
                                @endphp
                                @if ($cat_k == '0' || $homeproduct->ProductData()->id == $cat_k)
                                    <div class="bestseller-itm product-card">
                                        <div class="product-card-inner">
                                            <div class="product-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img
                                                        src="{{ get_file($homeproduct->cover_image_path, APP_THEME()) }}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-cont-top">
                                                    <div class="subtitle">{{ $homeproduct->tag_api }}</div>
                                                    <h3>
                                                        <a
                                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $homeproduct->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="product-cont-bottom">
                                                    <div class="price-btn">
                                                        <span class="price">
                                                            <ins>{{ $homeproduct->final_price }}{{ $currency }}</ins>
                                                        </span>
                                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                                            product_id="{{ $homeproduct->id }}"
                                                            variant_id="{{ $homeproduct->default_variant_id }}"
                                                            qty="1">
                                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                </path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                </path>
                                                            </svg>
                                                        </button>
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
        </div>
    </section>

    <section class="vedio-top-section">
        <div class="container">
            <div class="row">
                @php
                    $homepage_header_1_key = array_search('homepage-trending-category', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-trending-category-label') {
                                $home_label = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-trending-category-title-text') {
                                $home_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-trending-category-sub-text') {
                                $home_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="col-md-8 col-12">
                        <div class="vedio-top-left">
                            <div class="vedio-top-left-inner">
                                <div class="section-title">
                                    <div class="subtitle">{{ $home_label }}</div>
                                    <h2>{!! $home_title !!}</h2>
                                </div>
                                <div class="vedio-top-left-contnt">
                                    <p>{{ $home_text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!empty($latest_product))
                        <div class="col-md-4 col-12">
                            <div class="vedio-top-right">
                                <a href="{{ route('page.product-list', $slug) }}">
                                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/vd-top.jpg') }}">
                                    <div class="vedio-tp-right-contn">
                                        <div class="section-title">
                                            <div class="subtitle">{{ $latest_product->tag_api }}</div>
                                            <h3>{!! $latest_product->name !!}</b>
                                            </h3>
                                        </div>
                                        <div class="link-btn">
                                            {{ __('See More') }}
                                            <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <section class="vedio-center-section">
        @php
            $homepage_header_1_key = array_search('homepage-trending-category', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_header_1_key != '') {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-trending-category-vedio-link') {
                        $home_video = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if ($homepage_header_1['section_enable'] == 'on')
            <div class="video-right-wrap">
                <video class="video--tag" id="img-vid"
                    poster="{{ asset('themes/' . APP_THEME() . '/assets/images/video-bnr.jpg') }}">
                    <source src="{!! get_file($home_video, APP_THEME()) !!}" type="video/mp4">
                </video>

                <div class="play-vid" data-click="0">
                    <div class="d-flex align-items-center">
                        <svg width="76" height="76" viewBox="0 0 76 76">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.33333 38C6.33333 20.511 20.511 6.33333 38 6.33333C55.489 6.33333 69.6667 20.511 69.6667 38C69.6667 55.489 55.489 69.6667 38 69.6667C20.511 69.6667 6.33333 55.489 6.33333 38ZM38 0C17.0132 0 0 17.0132 0 38C0 58.9868 17.0132 76 38 76C58.9868 76 76 58.9868 76 38C76 17.0132 58.9868 0 38 0ZM33.4232 22.6985C32.4515 22.0507 31.2021 21.9903 30.1725 22.5414C29.1428 23.0924 28.5 24.1655 28.5 25.3333V50.6667C28.5 51.8345 29.1428 52.9076 30.1725 53.4586C31.2021 54.0097 32.4515 53.9493 33.4232 53.3015L52.4232 40.6348C53.3042 40.0475 53.8333 39.0588 53.8333 38C53.8333 36.9412 53.3042 35.9525 52.4232 35.3652L33.4232 22.6985ZM44.9579 38L34.8333 44.7497V31.2503L44.9579 38Z">
                            </path>
                        </svg>
                        <span><b>{{ __('CLICK HERE') }} </b> {{ __('TO WATCH') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <section class="video-bottom-section">
        <div class="container">
            <div class="bg-black product-card-reverse bestsell-slider">
                @foreach ($bestSeller as $bestSellers)
                    @php
                        $p_id = hashidsencode($bestSellers->id);
                    @endphp
                    <div class="bestseller-itm product-card">
                        <div class="product-card-inner">
                            <div class="product-image">
                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                    <img src="{{ get_file($bestSellers->cover_image_path, APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <div class="product-cont-top">
                                    <div class="subtitle">{{ $bestSellers->tag_api }}</div>
                                    <h3>
                                        <a
                                            href="{{ route('page.product', [$slug, $p_id]) }}">{{ $bestSellers->name }}</a>
                                    </h3>
                                </div>
                                <div class="product-cont-bottom">
                                    {{-- <div class="size-selectors d-flex align-items-center"> --}}
                                    {{-- <select class="color-select">
                                            <option>Black</option>
                                            <option>Grey</option>
                                            <option>Red</option>
                                        </select>
                                        <select class="size-select">
                                            <option>M</option>
                                            <option>XL</option>
                                            <option>X</option>
                                        </select>
                                        <select class="material-select">
                                            <option>Cotton</option>
                                            <option>Fabric</option>
                                            <option>Leather</option>
                                        </select> --}}
                                    {{-- </div> --}}
                                    <div class="price-btn">
                                        <span class="price">
                                            <ins>{{ $bestSellers->final_price }}{{ $currency }}</ins>
                                        </span>
                                        <button class="cart-button addcart-btn-globaly" type="submit"
                                            product_id="{{ $bestSellers->id }}"
                                            variant_id="{{ $bestSellers->default_variant_id }}" qty="1">
                                            <svg width="20" height="20" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                </path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="new-featured-section new-featured-reverse padding-top padding-bottom">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-bannner', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-bannner-label') {
                            $home_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-bannner-title-text') {
                            $home_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-bannner-img') {
                            $home_image = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12 feature-pro">
                        {{-- @dd($homepage_products); --}}
                        @foreach ($homepage_products as $homepage_product)
                            @php
                                $p_id = hashidsencode($homepage_product->id);
                            @endphp
                            <div class="feature-pro-itm product-card bg-light">
                                <div class="product-card-inner">
                                    <div class="product-image">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($homepage_product->cover_image_path, APP_THEME()) }}">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-cont-top">
                                            <div class="subtitle">{{ $homepage_product->tag_api }}</div>
                                            <h3><a
                                                    href="{{ route('page.product', [$slug, $p_id]) }}">{{ $homepage_product->name }}</a>
                                            </h3>
                                        </div>
                                        <div class="product-cont-bottom">
                                            {{-- <div class="size-selectors d-flex align-items-center">
                                            </div> --}}
                                            <div class="price-btn">
                                                <span class="price">
                                                    <ins>{{ $homepage_product->final_price }}{{ $currency }}</ins>
                                                </span>
                                                <button class="cart-button addcart-btn-globaly" type="submit"
                                                    product_id="{{ $homepage_product->id }}"
                                                    variant_id="{{ $homepage_product->default_variant_id }}"
                                                    qty="1">
                                                    <svg width="20" height="20" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                        </path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}" class="link-btn">
                                                {{ __('Read More') }}
                                                <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-10 col-12 feature-img">
                        <a href="{{ route('page.product-list', $slug) }}" class="featured-img-wrp">
                            <img src="{{ get_file($home_image, APP_THEME()) }}">
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-12 feature-title">
                        <div class="feature-verticle">
                            <strong class="subheading">{{ $home_label }}</strong>
                            <h2>{!! $home_title !!}</h2>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="testimonial-section">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-testimonial-label') {
                            $home_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-title">
                    <div class="subtitle">{{ $home_title }}</div>
                    <h2>{{ $home_text }}</h2>
                </div>
                <div class="testimonial-slider white-dots">
                    @foreach ($reviews as $review)
                        <div class="testimonial-itm">
                            <div class="testimonial-itm-inner">
                                <div class="testm-top">
                                    <div class="review-title-wrp d-flex align-items-center justify-content-between">
                                        <h3 class="description">{{ $review->title }}</h3>
                                        <div class="review-stars d-flex align-items-center">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="ti ti-star {{ $i < $review->rating_no ? '' : 'text-warning' }} "></i>
                                            @endfor
                                            <span><b>{{ $review->rating_no }}.0</b> / 5.0</span>
                                        </div>
                                    </div>
                                    <p class="descriptions">{{ $review->description }}</p>
                                </div>
                                <div class="testim-bottom">
                                    <div class="testi-auto d-flex align-items-center">
                                        <div class="testi-img">
                                            {{-- <img src="{{asset('themes/'.APP_THEME().'/assets/images/auth.png')}}"> --}}
                                            <img src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}"
                                                alt="reviewer-img">
                                        </div>
                                        <div class="test-auth-detail">
                                            <h4>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                            </h4>
                                            <span>Client</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="home-blog-section padding-top">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-label') {
                            $home_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-title">
                    <div class="subtitle">{{ $home_label }}</div>
                    <h2>{{ $home_text }}</h2>
                </div>
                {!! \App\Models\Blog::HomePageBlog($slug, 6) !!}
            @endif
        </div>
    </section>

    <!---wrapper end here-->

@endsection
