@extends('layouts.layouts')

@section('page-title')
    {{ __('Mountains') }}
@endsection
@section('content')
    @php
        $homepage_banner_title = $homepage_banner_sub_text = $homepage_banner_img = $homepage_banner_heading1 = $homepage_banner_icon_img1 = $homepage_banner_heading2 = $homepage_banner_icon_img2 = $homepage_banner_promotion_title1 = $homepage_banner_promotion_icon1 = $homepage_banner_promotion_title2 = $homepage_banner_promotion_icon2 = '';
        $theme_json = $homepage_json;
    @endphp
    <div class="home-wrapper">

        <section class="main-home-first-section">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/banner-pattern.png') }}" class="bner-ptrn">
            <div class="offset-container offset-left">
                <div class="row no-gutters">
                    <div class="home-slider-left-col col-md-5 col-12">
                        <div class="home-lfet-contennt-wrp">
                            <div class="home-left-slider">
                                @php
                                    $homepage_logo_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_logo_key != '') {
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        $section_enable = $homepage_main_logo['section_enable'];
                                    }
                                @endphp
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                    @php
                                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-header-label-text') {
                                                $homepage_titile = $homepage_main_logo_value['field_default_text'];
                                            }
                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-header-title-text') {
                                                $homepage_titile_text = $homepage_main_logo_value['field_default_text'];
                                            }
                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-header-sub-text') {
                                                $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                                            }
                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-header-btn-text') {
                                                $homepage_btn = $homepage_main_logo_value['field_default_text'];
                                            }

                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-header-label-text') {
                                                    $homepage_titile = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-header-title-text') {
                                                    $homepage_titile_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-header-sub-text') {
                                                    $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-header-btn-text') {
                                                    $homepage_btn = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp

                                    <div class="left-slider-item">
                                        <div class="left-slide-itm-inner">
                                            <div class="section-title">
                                                <span class="subtitle">{{ $homepage_titile }}</span>
                                                <h2>
                                                    {!! $homepage_titile_text !!}
                                                </h2>
                                            </div>
                                            <p>{{ $homepage_sub_text }}</p>
                                            <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.9 4.2C11.0598 4.2 12 3.2598 12 2.1C12 0.940202 11.0598 0 9.9 0C8.7402 0 7.8 0.940202 7.8 2.1C7.8 3.2598 8.7402 4.2 9.9 4.2ZM9.9 3C9.40294 3 9 2.59706 9 2.1C9 1.60294 9.40294 1.2 9.9 1.2C10.3971 1.2 10.8 1.60294 10.8 2.1C10.8 2.59706 10.3971 3 9.9 3ZM2.57574 11.8241C2.81005 12.0584 3.18995 12.0584 3.42426 11.8241C3.65858 11.5898 3.65858 11.2099 3.42426 10.9756L2.64853 10.1999L3.42417 9.42421C3.65849 9.18989 3.65849 8.81 3.42417 8.57568C3.18986 8.34137 2.80996 8.34137 2.57564 8.57568L1.8 9.35133L1.02436 8.57568C0.790041 8.34137 0.410142 8.34137 0.175827 8.57568C-0.0584871 8.81 -0.0584871 9.18989 0.175827 9.42421L0.951472 10.1999L0.175736 10.9756C-0.0585786 11.2099 -0.0585786 11.5898 0.175736 11.8241C0.410051 12.0584 0.789949 12.0584 1.02426 11.8241L1.8 11.0484L2.57574 11.8241ZM3.22027 0.197928C3.10542 0.07071 2.94164 -0.00131571 2.77025 1.8239e-05C2.59886 0.00135223 2.43623 0.0759186 2.32337 0.204908L0.748444 2.00491C0.530241 2.2543 0.555521 2.63335 0.804908 2.85156C1.0543 3.06976 1.43335 3.04448 1.65156 2.79509L2.17492 2.19693V2.58746C2.17492 5.1349 4.24003 7.2 6.78746 7.2C8.67215 7.2 10.2 8.72785 10.2 10.6125V11.4C10.2 11.7314 10.4686 12 10.8 12C11.1314 12 11.4 11.7314 11.4 11.4V10.6125C11.4 8.0651 9.3349 6 6.78746 6C4.90277 6 3.37492 4.47215 3.37492 2.58746V2.15994L3.95465 2.80207C4.17671 3.04803 4.55611 3.06741 4.80207 2.84535C5.04803 2.62329 5.06741 2.24389 4.84535 1.99793L3.22027 0.197928Z"
                                                        fill="black" />
                                                </svg>
                                                {{ $homepage_btn }}
                                            </a>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="home-slider-right-col col-md-7 col-12">
                        <div class="customarrows">
                            <div class="slick-prev left"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/arrow.png') }}"></div>
                            <div class="slick-next right"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/right-arr.png') }}"></div>
                        </div>
                        <div class="home-right-slider">
                            @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                @foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php

                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-header-img') {
                                            $homepage_img = $homepage_main_logo_value['field_default_text'];
                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                $homepage_img = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <div class="home-right-item">
                                    <div class="banner-image">
                                        <img src="{{ get_file($homepage_img, APP_THEME()) }}" alt="banner">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-product padding-top">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-12">
                    <div class="about card">
                        @foreach ($home_products->take(1) as $product)
                            @php
                                $p_id = hashidsencode($product->id);
                                $wishlist = App\Models\Wishlist::where('product_id', $product->id)
                                    ->where('theme_id', APP_THEME())
                                    ->first();
                            @endphp
                            <div class="about-product-main">
                                <div class="about-product-img">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}" alt="">
                                    </a>
                                </div>
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
                                                if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                    $latestSales[$product->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <div class="badge">
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="about-product-content">
                                    <div class="about-subtitle">
                                        <div class="subtitle-pointer">
                                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/slider-inner-line-right.png') }}"
                                                alt="">
                                            <span>{{ __('FEATURED PRODUCT') }}</span>
                                        </div>
                                        <div class="about-title">
                                            <h3>
                                                <a
                                                    href="{{ route('page.product', [$slug, $p_id]) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="about-itm-datail">
                                                @if ($product->variant_id != 0)
                                                    <b> {!! \App\Models\ProductStock::variantlist($product->variant_id) !!} </b>
                                                @endif
                                                @if ($product->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $currency_icon }} {{ $product->final_price }}</ins>
                                                        <del>{{ $currency_icon }} {{ $product->price }}</del>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="btn addcart-btn-globaly"
                                                    product_id="{{ $product->id }}" variant_id="0" qty="1">
                                                    {{ __('Add to cart') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($homepage_products->take(1) as $product)
                            <div class="about-product-main about-product-bg">
                                <div class="about-product-img">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src={{ get_file($product->cover_image_path, APP_THEME()) }} alt="">
                                    </a>
                                </div>
                                <div class="about-title">
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
                                                if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                    $latestSales[$product->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <div class="badge">
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="about-product-content">
                                    <div class="about-subtitle">
                                        <div class="subtitle-pointer">
                                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/about-product-line.png') }}"
                                                alt="">

                                            <span>{{ __('FEATURED PRODUCT') }}</span>
                                        </div>
                                        <div class="about-title">
                                            <h3>
                                                <a
                                                    href="{{ route('page.product', [$slug, $p_id]) }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="about-itm-datail">
                                                @if ($product->variant_id != 0)
                                                    <b> {!! \App\Models\ProductStock::variantlist($product->variant_id) !!} </b>
                                                @endif
                                                @if ($product->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $currency_icon }} {{ $product->final_price }}</ins>
                                                        <del>{{ $currency_icon }} {{ $product->price }}</del>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="btn btn-secondary addcart-btn-globaly"
                                                    product_id="{{ $product->id }}" variant_id="0" qty="1">
                                                    {{ __('Add to cart') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach ($all_products->take(1) as $product)
                    <div class="col-lg-6 col-12">
                        <div class="about-product-main-wrp">
                            <div class="about-product-content">
                                <div class="about-subtitle">
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
                                                    if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                        $latestSales[$product->id] = [
                                                            'discount_type' => $flashsale->discount_type,
                                                            'discount_amount' => $flashsale->discount_amount,
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp
                                        @foreach ($latestSales as $productId => $saleData)
                                            <div class="badge">
                                                @if ($saleData['discount_type'] == 'flat')
                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                    -{{ $saleData['discount_amount'] }}%
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="subtitle-pointer">

                                        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/slider-inner-line-right.png') }}"
                                            alt="">
                                        <span>{{ __('FEATURED PRODUCT') }}</span><br>

                                    </div>
                                    <div class="about-title">
                                        <h3>
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="about-itm-datail">
                                            @if ($product->variant_id != 0)
                                                {{-- <b>  {!! \App\Models\ProductStock::-variantlist($product->variant_id) !!} </b> --}}
                                            @endif
                                            @if ($product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $currency_icon }} {{ $product->final_price }}</ins>
                                                    <del>{{ $currency_icon }} {{ $product->price }}</del>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="btn addcart-btn-globaly"
                                                product_id="{{ $product->id }}" variant_id="0" qty="1">
                                                {{ __('Add to cart') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="about-product-img-wrp">
                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="merge-client-section padding-top padding-bottom">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/img/Client-logo-pattern.png') }}" class="client-ptrn"
                alt="">
            <div class="client-logo-section common-arrows padding-bottom">
                <div class="container">
                    <div class="client-logo-slider">
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
                                <div class="client-logo-item">
                                    <a href="#" tabindex="0">
                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                    </a>
                                </div>
                            @endfor
                        @else
                            @for ($i = 0; $i <= 6; $i++)
                                @php
                                    foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                            $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                        }
                                    }
                                @endphp
                                <div class="client-logo-item">
                                    <a href="#" tabindex="0">
                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                    </a>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>


            @php
                $homepage_banner2 = '';
                $homepage_banner2_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_banner2_key != '') {
                    $homepage_main_banner2 = $theme_json[$homepage_banner2_key];
                }
                $homepage_banner1 = $homepage_banner2 = $homepage_banner3 = $homepage_banner4 = $homepage_banner5 = '';
            @endphp
            @for ($i = 0; $i < $homepage_main_banner2['loop_number']; $i++)
                @php
                    foreach ($homepage_main_banner2['inner-list'] as $homepage_main_banner2_value) {
                        $homepage_banner_default_image = $homepage_main_banner2_value['field_default_text'];
                        if (!empty($homepage_main_banner2[$homepage_main_banner2_value['field_slug']])) {
                            if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 0) {
                                $homepage_banner1 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                            }
                            if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 1) {
                                $homepage_banner2 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                            }
                            if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 2) {
                                $homepage_banner3 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                            }
                            if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 3) {
                                $homepage_banner4 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                            }
                            if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 4) {
                                $homepage_banner5 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                    }
                @endphp
            @endfor
            @php
                $homepage_banner1 = !empty($homepage_banner1) ? $homepage_banner1 : $homepage_banner_default_image;
                $homepage_banner2 = !empty($homepage_banner2) ? $homepage_banner2 : $homepage_banner_default_image;
                $homepage_banner3 = !empty($homepage_banner3) ? $homepage_banner3 : $homepage_banner_default_image;
                $homepage_banner4 = !empty($homepage_banner4) ? $homepage_banner4 : $homepage_banner_default_image;
                $homepage_banner5 = !empty($homepage_banner5) ? $homepage_banner5 : $homepage_banner_default_image;
            @endphp
            <div class="place-section padding-bottom">
                <div class="row no-gutters justify-content-between align-items-center flex-dairection">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="place-left">
                            <img src="{{ get_file($homepage_banner1, APP_THEME()) }}" class="place-left-one"
                                alt="">
                            <img src="{{ get_file($homepage_banner2, APP_THEME()) }}" class="place-left-two"
                                alt="">
                        </div>
                    </div>
                    @php
                        $homepage_banner_title = '';

                        $homepage_banner = array_search('homepage-banner-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_banner != '') {
                            $homepage_banner_value = $theme_json[$homepage_banner];

                            foreach ($homepage_banner_value['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-banner-label-text') {
                                    $homepage_banner_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-title-text') {
                                    $homepage_banner_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                    $homepage_banner_sub = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-btn-text') {
                                    $homepage_banner_btn = $value['field_default_text'];
                                }

                                //Dynamic
                                if (!empty($homepage_banner_value[$value['field_slug']])) {
                                    if ($value['field_slug'] == 'homepage-banner-label-text') {
                                        $homepage_banner_title = $homepage_banner_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-title-text') {
                                        $homepage_banner_text = $homepage_banner_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                        $homepage_banner_sub = $homepage_banner_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-btn-text') {
                                        $homepage_banner_btn = $homepage_banner_value[$value['field_slug']][$i];
                                    }
                                }
                            }
                        }
                    @endphp
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="place-section-center">
                            <div class="section-title">
                                <span class="subtitle">{{ $homepage_banner_title }}</span>
                                <h2>
                                    {!! $homepage_banner_text !!}
                                </h2>
                            </div>
                            <p>{{ $homepage_banner_sub }}
                            </p>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    viewBox="0 0 12 12" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.9 4.2C11.0598 4.2 12 3.2598 12 2.1C12 0.940202 11.0598 0 9.9 0C8.7402 0 7.8 0.940202 7.8 2.1C7.8 3.2598 8.7402 4.2 9.9 4.2ZM9.9 3C9.40294 3 9 2.59706 9 2.1C9 1.60294 9.40294 1.2 9.9 1.2C10.3971 1.2 10.8 1.60294 10.8 2.1C10.8 2.59706 10.3971 3 9.9 3ZM2.57574 11.8241C2.81005 12.0584 3.18995 12.0584 3.42426 11.8241C3.65858 11.5898 3.65858 11.2099 3.42426 10.9756L2.64853 10.1999L3.42417 9.42421C3.65849 9.18989 3.65849 8.81 3.42417 8.57568C3.18986 8.34137 2.80996 8.34137 2.57564 8.57568L1.8 9.35133L1.02436 8.57568C0.790041 8.34137 0.410142 8.34137 0.175827 8.57568C-0.0584871 8.81 -0.0584871 9.18989 0.175827 9.42421L0.951472 10.1999L0.175736 10.9756C-0.0585786 11.2099 -0.0585786 11.5898 0.175736 11.8241C0.410051 12.0584 0.789949 12.0584 1.02426 11.8241L1.8 11.0484L2.57574 11.8241ZM3.22027 0.197928C3.10542 0.07071 2.94164 -0.00131571 2.77025 1.8239e-05C2.59886 0.00135223 2.43623 0.0759186 2.32337 0.204908L0.748444 2.00491C0.530241 2.2543 0.555521 2.63335 0.804908 2.85156C1.0543 3.06976 1.43335 3.04448 1.65156 2.79509L2.17492 2.19693V2.58746C2.17492 5.1349 4.24003 7.2 6.78746 7.2C8.67215 7.2 10.2 8.72785 10.2 10.6125V11.4C10.2 11.7314 10.4686 12 10.8 12C11.1314 12 11.4 11.7314 11.4 11.4V10.6125C11.4 8.0651 9.3349 6 6.78746 6C4.90277 6 3.37492 4.47215 3.37492 2.58746V2.15994L3.95465 2.80207C4.17671 3.04803 4.55611 3.06741 4.80207 2.84535C5.04803 2.62329 5.06741 2.24389 4.84535 1.99793L3.22027 0.197928Z"
                                        fill="black"></path>
                                </svg>
                                {{ $homepage_banner_btn }}
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="place-right">
                            <div class="place-right-image">
                                <img src="{{ get_file($homepage_banner3, APP_THEME()) }}" class=""
                                    alt="Place-right-img">
                            </div>
                            <div class="place-right-image">
                                <img src="{{ get_file($homepage_banner4, APP_THEME()) }}" alt="Place-right-img">
                            </div>
                            <div class="place-right-image">
                                <img src="{{ get_file($homepage_banner5, APP_THEME()) }}" alt="Place-right-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding-top category-slider-section">
                <div class="container">
                    @php
                        $homepage_category_title = '';

                        $homepage_category = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_category != '') {
                            $homepage_category_value = $theme_json[$homepage_category];

                            foreach ($homepage_category_value['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-category-label-text') {
                                    $homepage_category_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-title-text') {
                                    $homepage_category_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-btn-text') {
                                    $homepage_category_btn = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-heading') {
                                    $homepage_category_heading = $value['field_default_text'];
                                }

                                //Dynamic
                                if (!empty($homepage_category_value[$value['field_slug']])) {
                                    if ($value['field_slug'] == 'homepage-category-label-text') {
                                        $homepage_category_title = $homepage_category_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-category-title-text') {
                                        $homepage_category_text = $homepage_category_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-category-btn-text') {
                                        $homepage_category_btn = $homepage_category_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-category-heading') {
                                        $homepage_category_heading = $homepage_category_value[$value['field_slug']][$i];
                                    }
                                }
                            }
                        }
                    @endphp

                    <div class="home-card-slider-heading">
                        <div class="section-title">
                            <span class="subtitle">{{ $homepage_category_title }}</span>
                            <h2>
                                {!! $homepage_category_text !!}
                            </h2>
                            <div class="subtitle-pointer">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/slider-inner-line-right.png') }}"
                                    alt="">
                                <span>{{ $homepage_category_heading }}</span>
                            </div>
                        </div>
                        <div class="section-title-btn">
                            <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    viewBox="0 0 12 12" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.9 4.2C11.0598 4.2 12 3.2598 12 2.1C12 0.940202 11.0598 0 9.9 0C8.7402 0 7.8 0.940202 7.8 2.1C7.8 3.2598 8.7402 4.2 9.9 4.2ZM9.9 3C9.40294 3 9 2.59706 9 2.1C9 1.60294 9.40294 1.2 9.9 1.2C10.3971 1.2 10.8 1.60294 10.8 2.1C10.8 2.59706 10.3971 3 9.9 3ZM2.57574 11.8241C2.81005 12.0584 3.18995 12.0584 3.42426 11.8241C3.65858 11.5898 3.65858 11.2099 3.42426 10.9756L2.64853 10.1999L3.42417 9.42421C3.65849 9.18989 3.65849 8.81 3.42417 8.57568C3.18986 8.34137 2.80996 8.34137 2.57564 8.57568L1.8 9.35133L1.02436 8.57568C0.790041 8.34137 0.410142 8.34137 0.175827 8.57568C-0.0584871 8.81 -0.0584871 9.18989 0.175827 9.42421L0.951472 10.1999L0.175736 10.9756C-0.0585786 11.2099 -0.0585786 11.5898 0.175736 11.8241C0.410051 12.0584 0.789949 12.0584 1.02426 11.8241L1.8 11.0484L2.57574 11.8241ZM3.22027 0.197928C3.10542 0.07071 2.94164 -0.00131571 2.77025 1.8239e-05C2.59886 0.00135223 2.43623 0.0759186 2.32337 0.204908L0.748444 2.00491C0.530241 2.2543 0.555521 2.63335 0.804908 2.85156C1.0543 3.06976 1.43335 3.04448 1.65156 2.79509L2.17492 2.19693V2.58746C2.17492 5.1349 4.24003 7.2 6.78746 7.2C8.67215 7.2 10.2 8.72785 10.2 10.6125V11.4C10.2 11.7314 10.4686 12 10.8 12C11.1314 12 11.4 11.7314 11.4 11.4V10.6125C11.4 8.0651 9.3349 6 6.78746 6C4.90277 6 3.37492 4.47215 3.37492 2.58746V2.15994L3.95465 2.80207C4.17671 3.04803 4.55611 3.06741 4.80207 2.84535C5.04803 2.62329 5.06741 2.24389 4.84535 1.99793L3.22027 0.197928Z"
                                        fill="black"></path>
                                </svg>
                                {{ $homepage_category_btn }}
                            </a>
                        </div>
                    </div>
                    <div class="home-categorey-slider">

                        @foreach ($MainCategoryList as $category)
                            <div class="categorey-itm">
                                <div class="category-itm-inner">
                                    <a href="{{ route('page.product-list', $slug) }}" tabindex="0">
                                        <img src="{{ get_file($category->image_path, APP_THEME()) }}">
                                        <div class="new-labl">
                                            {{ __('CATEGORY') }}
                                        </div>
                                        <h4>
                                            {{ $category->name }}
                                        </h4>
                                        <div class="btn">
                                            {{ __('Show more') }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-with-custoim-arrow">
                        <div class="customarrows">
                            <div class="slick-prev1 second-left"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/arrow.png') }}"></div>
                            <div class="slick-next1 second-right"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/right-arr.png') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="prodcut-card-section padding-top">
            <div class="container">
                @php
                    $homepage_card_title = '';

                    $homepage_card = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_card != '') {
                        $homepage_card_value = $theme_json[$homepage_card];

                        foreach ($homepage_card_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-card-label-text') {
                                $homepage_card_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-card-title-text') {
                                $homepage_card_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-card-sub-text') {
                                $homepage_card_sub_text = $value['field_default_text'];
                            }

                            //Dynamic
                            if (!empty($homepage_card_value[$value['field_slug']])) {
                                if ($value['field_slug'] == 'homepage-card-label-text') {
                                    $homepage_card_title = $homepage_card_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-card-title-text') {
                                    $homepage_card_text = $homepage_card_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-card-sub-text') {
                                    $homepage_card_sub_text = $homepage_card_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp

                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                        <div class="prodcut-card-heading">
                            <div class="section-title">
                                <span class="subtitle">{{ $homepage_card_title }}</span>
                                <h2>
                                    {!! $homepage_card_text !!}
                                </h2>
                                <p>{{ $homepage_card_sub_text }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 col-md-8 col-12">
                        <div class="product-card-slider">

                            @foreach ($modern_products->take(6) as $m_pro)
                                @php
                                    $p_id = hashidsencode($m_pro->id);
                                    $wishlist = App\Models\Wishlist::where('product_id', $m_pro->id)
                                        ->where('theme_id', APP_THEME())
                                        ->first();
                                @endphp
                                <div class="product-card-main">
                                    <div class="product-card-inner product-card-bg">
                                        <div class="product-card-img">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                <img src="{{ get_file($m_pro->cover_image_path, APP_THEME()) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="product-card-content">
                                            <div class="about-subtitle">
                                                <div class="about-title">
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
                                                                if (is_array($saleEnableArray) && in_array($m_pro->id, $saleEnableArray)) {
                                                                    $latestSales[$m_pro->id] = [
                                                                        'discount_type' => $flashsale->discount_type,
                                                                        'discount_amount' => $flashsale->discount_amount,
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($latestSales as $productId => $saleData)
                                                        <div class="badge">
                                                            @if ($saleData['discount_type'] == 'flat')
                                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                                -{{ $saleData['discount_amount'] }}%
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="subtitle-pointer">
                                                    <span>{{ $m_pro->ProductData()->name }}</span>
                                                </div>
                                                <div class="card-title">
                                                    <div class="card-add-to-list long_sting_to_dot" class="wishlist">
                                                        <h3>
                                                            <a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                                class="short-description">{{ $m_pro->name }}
                                                                <br /> {{ $m_pro->default_variant_name }} </a>
                                                        </h3>
                                                            <a href="javascript:void(0)" class="wishbtn wishbtn-globaly"
                                                                product_id="{{ $m_pro->id }}"
                                                                in_wishlist="{{ $m_pro->in_whishlist ? 'remove' : 'add' }}">
                                                                <span class="wish-ic">
                                                                    <i
                                                                        class="{{ $m_pro->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    <input type="hidden" class="wishlist_type"
                                                                        name="wishlist_type" id="wishlist_type"
                                                                        value="{{ $m_pro->in_whishlist ? 'remove' : 'add' }}">
                                                                </span>
                                                            </a>

                                                    </div>
                                                    <div class="product-card-itm-datail">
                                                        @if ($m_pro->variant_product == 0)
                                                            <div class="price">
                                                                <ins>{{ $currency_icon }} {{ $m_pro->final_price }}</ins>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-secondary addcart-btn-globaly"
                                                            product_id="{{ $m_pro->id }}" variant_id="0"
                                                            qty="1">
                                                            {{ __('Add to cart') }}
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
                </div>
            </div>
        </section>
        @php
            $homepage_product_title = '';

            $homepage_product = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_product != '') {
                $homepage_product_value = $theme_json[$homepage_product];

                foreach ($homepage_product_value['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-products-title-text') {
                        $homepage_product_title = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-products-sub-text') {
                        $homepage_product_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-products-btn-text') {
                        $homepage_product_btn = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-products-bg-img') {
                        $homepage_product_img = $value['field_default_text'];
                    }

                    //Dynamic
                    if (!empty($homepage_product_value[$value['field_slug']])) {
                        if ($value['field_slug'] == 'homepage-products-title-text') {
                            $homepage_product_title = $homepage_product_value[$value['field_slug']][$i];
                        }
                        if ($value['field_slug'] == 'homepage-products-sub-text') {
                            $homepage_product_text = $homepage_product_value[$value['field_slug']][$i];
                        }
                        if ($value['field_slug'] == 'homepage-products-btn-text') {
                            $homepage_product_btn = $homepage_product_value[$value['field_slug']][$i];
                        }
                        if ($value['field_slug'] == 'homepage-products-bg-img') {
                            $homepage_product_img = $homepage_product_value[$value['field_slug']][$i];
                        }
                    }
                }
            }
        @endphp
        <section class="img-product-card padding-top"
            style="background-image: url('{{ get_file($homepage_product_img, APP_THEME()) }}'); no-repeat center; background-size: cover;">
            <div class="container">
                <div class="img-product-card-heading">
                    <div class="section-title">
                        <h2>
                            {!! $homepage_product_title !!}
                        </h2>
                        <p>{{ $homepage_product_text }}
                        </p>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                            {{ $homepage_product_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="13" viewBox="0 0 17 13"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.50042 10.6026C11.6248 10.6026 13.8466 8.63934 15.1477 7.00428C15.599 6.43718 15.599 5.68012 15.1477 5.11301C13.8466 3.47795 11.6248 1.51466 8.50042 1.51466C5.37605 1.51466 3.15427 3.47795 1.85313 5.11301C1.40184 5.68012 1.40184 6.43718 1.85313 7.00428C3.15427 8.63934 5.37605 10.6026 8.50042 10.6026ZM16.3329 7.94743C17.2235 6.82829 17.2235 5.289 16.3329 4.16986C14.918 2.39185 12.3072 0 8.50042 0C4.69367 0 2.08284 2.39185 0.66794 4.16986C-0.222646 5.289 -0.222647 6.82829 0.66794 7.94743C2.08284 9.72545 4.69367 12.1173 8.50042 12.1173C12.3072 12.1173 14.918 9.72545 16.3329 7.94743Z"
                                    fill="#12131A" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.0127 6.05862C10.0127 6.89514 9.3346 7.57328 8.49807 7.57328C7.66155 7.57328 6.98341 6.89514 6.98341 6.05862C6.98341 6.03712 6.98386 6.01573 6.98475 5.99445C7.10281 6.03601 7.2298 6.05862 7.36208 6.05862C7.98947 6.05862 8.49807 5.55002 8.49807 4.92262C8.49807 4.79035 8.47546 4.66335 8.4339 4.54529C8.45518 4.54441 8.47658 4.54396 8.49807 4.54396C9.3346 4.54396 10.0127 5.2221 10.0127 6.05862ZM11.5274 6.05862C11.5274 7.73167 10.1711 9.08794 8.49807 9.08794C6.82502 9.08794 5.46875 7.73167 5.46875 6.05862C5.46875 4.38557 6.82502 3.0293 8.49807 3.0293C10.1711 3.0293 11.5274 4.38557 11.5274 6.05862Z"
                                    fill="#12131A" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="img-product-card-slider">
                    @foreach ($all_products as $products)
                        @php
                            $p_id = hashidsencode($products->id);
                            $wishlist = App\Models\Wishlist::where('product_id', $products->id)
                                ->where('theme_id', APP_THEME())
                                ->first();
                        @endphp
                        <div class="product-card-main">
                            <div class="product-card-inner product-card-bg">
                                <div class="product-card-img">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($products->cover_image_path, APP_THEME()) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="product-card-content">
                                    <div class="about-subtitle">
                                        <div class="about-title">
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
                                                        if (is_array($saleEnableArray) && in_array($products->id, $saleEnableArray)) {
                                                            $latestSales[$products->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <div class="badge">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="subtitle-pointer">
                                            <span>{{ $products->ProductData()->name }}</span>
                                        </div>
                                        <div class="card-title">
                                            <div class="card-add-to-list long_sting_to_dot"
                                                title="{{ $products->name }} {{ $products->default_variant_name }} ">
                                                <h3>
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                        class="short-description">{{ $products->name }} <br>
                                                        {{ $products->default_variant_name }} </a>
                                                </h3>
                                                <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"
                                                    product_id="{{ $products->id }}"
                                                    in_wishlist="{{ $products->in_whishlist ? 'remove' : 'add' }}">
                                                    <span class="wish-ic">
                                                        <i
                                                            class="{{ $products->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        <input type="hidden" class="wishlist_type" name="wishlist_type"
                                                            id="wishlist_type"
                                                            value="{{ $products->in_whishlist ? 'remove' : 'add' }}">
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="product-card-itm-datail">
                                                @if ($products->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $currency_icon }} {{ $products->final_price }}</ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="btn btn-secondary addcart-btn-globaly"
                                                    product_id="{{ $products->id }}" variant_id="0" qty="1">
                                                    {{ __('Add to cart') }}
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
        </section>
        <section class="combine-section ">
            <img src="{{ 'themes/' . APP_THEME() . '/assets/img/testimoinals-ptrn.png' }}" class="cimbine-img-ptrn"
                alt="">
            <div class="testimonials-section padding-top">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        @php
                            $homepage_testmonials_title = '';

                            $homepage_testmonials = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_testmonials != '') {
                                $homepage_testmonials_value = $theme_json[$homepage_testmonials];

                                foreach ($homepage_testmonials_value['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-testimonial-label-text') {
                                        $homepage_testmonials_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                        $homepage_testmonials_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                        $homepage_testmonials_sub = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                        $homepage_testmonials_btn = $value['field_default_text'];
                                    }

                                    //Dynamic
                                    if (!empty($homepage_testmonials_value[$value['field_slug']])) {
                                        if ($value['field_slug'] == 'homepage-testimonial-label-text') {
                                            $homepage_testmonials_title = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                            $homepage_testmonials_image = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                            $homepage_testmonials_sub = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                            $homepage_testmonials_btn = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                    }
                                }
                            }
                        @endphp

                        <div class="col-lg-4 col-md-5   col-12">
                            <div class="prodcut-card-heading">
                                <div class="section-title">
                                    <span class="subtitle">{{ $homepage_testmonials_title }}</span>
                                    <h2>
                                        {{ $homepage_testmonials_text }}
                                    </h2>
                                    <p>{{ $homepage_testmonials_sub }}
                                    </p>
                                    <a href="#" class="btn" tabindex="0">
                                        {{ $homepage_testmonials_btn }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="13"
                                            viewBox="0 0 17 13" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.50042 10.6026C11.6248 10.6026 13.8466 8.63934 15.1477 7.00428C15.599 6.43718 15.599 5.68012 15.1477 5.11301C13.8466 3.47795 11.6248 1.51466 8.50042 1.51466C5.37605 1.51466 3.15427 3.47795 1.85313 5.11301C1.40184 5.68012 1.40184 6.43718 1.85313 7.00428C3.15427 8.63934 5.37605 10.6026 8.50042 10.6026ZM16.3329 7.94743C17.2235 6.82829 17.2235 5.289 16.3329 4.16986C14.918 2.39185 12.3072 0 8.50042 0C4.69367 0 2.08284 2.39185 0.66794 4.16986C-0.222646 5.289 -0.222647 6.82829 0.66794 7.94743C2.08284 9.72545 4.69367 12.1173 8.50042 12.1173C12.3072 12.1173 14.918 9.72545 16.3329 7.94743Z"
                                                fill="#12131A"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.0127 6.05862C10.0127 6.89514 9.3346 7.57328 8.49807 7.57328C7.66155 7.57328 6.98341 6.89514 6.98341 6.05862C6.98341 6.03712 6.98386 6.01573 6.98475 5.99445C7.10281 6.03601 7.2298 6.05862 7.36208 6.05862C7.98947 6.05862 8.49807 5.55002 8.49807 4.92262C8.49807 4.79035 8.47546 4.66335 8.4339 4.54529C8.45518 4.54441 8.47658 4.54396 8.49807 4.54396C9.3346 4.54396 10.0127 5.2221 10.0127 6.05862ZM11.5274 6.05862C11.5274 7.73167 10.1711 9.08794 8.49807 9.08794C6.82502 9.08794 5.46875 7.73167 5.46875 6.05862C5.46875 4.38557 6.82502 3.0293 8.49807 3.0293C10.1711 3.0293 11.5274 4.38557 11.5274 6.05862Z"
                                                fill="#12131A"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7   col-12">
                            <div class="testimonials-card-slider">
                                @foreach ($reviews as $review)
                                    <div class="testimonials-itm">
                                        <div class="testimonials-inner">
                                            <div class="testimonials-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="31"
                                                    viewBox="0 0 50 31" fill="none">
                                                    <path
                                                        d="M0.367188 30.7175L10.7942 0H26.153L17.8395 30.7175H0.367188ZM23.8985 30.7175L34.3256 0H49.5434L41.3709 30.7175H23.8985Z"
                                                        fill="#CAD5D7" />
                                                </svg>
                                                <h3>
                                                    {{ $review->title }}
                                                </h3>
                                                <p>{{ $review->description }}
                                                </p>
                                                <div class="client-detail d-flex align-items-center">
                                                    <span
                                                        class="clienttitle">{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},
                                                        <b>Client</b></span>
                                                    <div class="clientstrs d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                        @endfor
                                                        <span><b>{{ $review->rating_no }}/</b> 5.0</span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-img-wrapper">
                                                <img src="{{ get_file($review->ProductData->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bestseller-card padding-top padding-bottom">
                <div class="container">
                    @php
                        $homepage_bestseller_title = '';

                        $homepage_bestseller = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_bestseller != '') {
                            $homepage_bestseller_value = $theme_json[$homepage_bestseller];

                            foreach ($homepage_bestseller_value['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-bestseller-label-text') {
                                    $homepage_bestseller_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                    $homepage_bestseller_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                    $homepage_bestseller_btn = $value['field_default_text'];
                                }

                                //Dynamic
                                if (!empty($homepage_bestseller_value[$value['field_slug']])) {
                                    if ($value['field_slug'] == 'homepage-bestseller-label-text') {
                                        $homepage_bestseller_title = $homepage_bestseller_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                        $homepage_bestseller_text = $homepage_bestseller_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                        $homepage_bestseller_btn = $homepage_bestseller_value[$value['field_slug']][$i];
                                    }
                                }
                            }
                        }
                    @endphp

                    <div class="home-card-slider-heading">
                        <div class="section-title">
                            <span class="subtitle">{{ $homepage_bestseller_title }}</span>
                            <h2>
                                {{ $homepage_bestseller_text }}
                            </h2>
                        </div>
                        <div class="section-title-btn">
                            <a href="" class="btn" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    viewBox="0 0 12 12" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.9 4.2C11.0598 4.2 12 3.2598 12 2.1C12 0.940202 11.0598 0 9.9 0C8.7402 0 7.8 0.940202 7.8 2.1C7.8 3.2598 8.7402 4.2 9.9 4.2ZM9.9 3C9.40294 3 9 2.59706 9 2.1C9 1.60294 9.40294 1.2 9.9 1.2C10.3971 1.2 10.8 1.60294 10.8 2.1C10.8 2.59706 10.3971 3 9.9 3ZM2.57574 11.8241C2.81005 12.0584 3.18995 12.0584 3.42426 11.8241C3.65858 11.5898 3.65858 11.2099 3.42426 10.9756L2.64853 10.1999L3.42417 9.42421C3.65849 9.18989 3.65849 8.81 3.42417 8.57568C3.18986 8.34137 2.80996 8.34137 2.57564 8.57568L1.8 9.35133L1.02436 8.57568C0.790041 8.34137 0.410142 8.34137 0.175827 8.57568C-0.0584871 8.81 -0.0584871 9.18989 0.175827 9.42421L0.951472 10.1999L0.175736 10.9756C-0.0585786 11.2099 -0.0585786 11.5898 0.175736 11.8241C0.410051 12.0584 0.789949 12.0584 1.02426 11.8241L1.8 11.0484L2.57574 11.8241ZM3.22027 0.197928C3.10542 0.07071 2.94164 -0.00131571 2.77025 1.8239e-05C2.59886 0.00135223 2.43623 0.0759186 2.32337 0.204908L0.748444 2.00491C0.530241 2.2543 0.555521 2.63335 0.804908 2.85156C1.0543 3.06976 1.43335 3.04448 1.65156 2.79509L2.17492 2.19693V2.58746C2.17492 5.1349 4.24003 7.2 6.78746 7.2C8.67215 7.2 10.2 8.72785 10.2 10.6125V11.4C10.2 11.7314 10.4686 12 10.8 12C11.1314 12 11.4 11.7314 11.4 11.4V10.6125C11.4 8.0651 9.3349 6 6.78746 6C4.90277 6 3.37492 4.47215 3.37492 2.58746V2.15994L3.95465 2.80207C4.17671 3.04803 4.55611 3.06741 4.80207 2.84535C5.04803 2.62329 5.06741 2.24389 4.84535 1.99793L3.22027 0.197928Z"
                                        fill="black"></path>
                                </svg>
                                {{ $homepage_bestseller_btn }}
                            </a>
                        </div>
                    </div>
                    <div class="bestseller-card-slider flex-slider">
                        @foreach ($bestSeller as $best)
                            @php
                                $p_id = hashidsencode($best->id);
                            @endphp
                            <div class="card">
                                <div class="seller-slider-inner card-inner">
                                    <div class="bestseller-card-bg">
                                        <div class="product-content">
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
                                                            if (is_array($saleEnableArray) && in_array($best->id, $saleEnableArray)) {
                                                                $latestSales[$best->id] = [
                                                                    'discount_type' => $flashsale->discount_type,
                                                                    'discount_amount' => $flashsale->discount_amount,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach ($latestSales as $productId => $saleData)
                                                    <div class="badge">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="product-content-top long_sting_to_dot">
                                                <h3 class="product-title">
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                        class="short-description">
                                                        {{ $best->name }} {{ $best->default_variant_name }}
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="product-content-bottom">
                                                @if ($best->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $currency_icon }} {{ $best->final_price }}</ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="btn btn-secondary addcart-btn-globaly"
                                                    product_id="{{ $best->id }}" variant_id="0" qty="1">
                                                    {{ __('Add to cart') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="seller-product-card-image">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                <img src="{{ get_file($best->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-with-custoim-arrow">
                        <div class="customarrows">
                            <div class="slick-prev1 third-left"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/arrow.png') }}"></div>
                            <div class="slick-next1 third-right"><img
                                    src="{{ asset('themes/' . APP_THEME() . '/assets/img/right-arr.png') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="place-section place-section-second padding-top padding-bottom">
                @php
                    $homepage_news = '';
                    $homepage_news_key = array_search('homepage-newsletter-2', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_news_key != '') {
                        $homepage_main_news = $theme_json[$homepage_news_key];
                    }
                    $homepage_news1 = $homepage_news2 = $homepage_news3 = $homepage_news4 = '';
                @endphp

                @for ($i = 0; $i < $homepage_main_news['loop_number']; $i++)
                    @php
                        foreach ($homepage_main_news['inner-list'] as $homepage_main_news_value) {
                            $homepage_news_default_image = $homepage_main_news_value['field_default_text'];
                            if (!empty($homepage_main_news[$homepage_main_news_value['field_slug']])) {
                                if ($homepage_main_news_value['field_slug'] == 'homepage-newsletter-img' && $i == 0) {
                                    $homepage_news1 = $homepage_main_news[$homepage_main_news_value['field_slug']][$i]['field_prev_text'];
                                }
                                if ($homepage_main_news_value['field_slug'] == 'homepage-newsletter-img' && $i == 1) {
                                    $homepage_news2 = $homepage_main_news[$homepage_main_news_value['field_slug']][$i]['field_prev_text'];
                                }
                                if ($homepage_main_news_value['field_slug'] == 'homepage-newsletter-img' && $i == 2) {
                                    $homepage_news3 = $homepage_main_news[$homepage_main_news_value['field_slug']][$i]['field_prev_text'];
                                }
                                if ($homepage_main_news_value['field_slug'] == 'homepage-newsletter-img' && $i == 3) {
                                    $homepage_news4 = $homepage_main_news[$homepage_main_news_value['field_slug']][$i]['field_prev_text'];
                                }
                            }
                        }
                    @endphp
                @endfor
                @php
                    $homepage_news1 = !empty($homepage_news1) ? $homepage_news1 : $homepage_news_default_image;
                    $homepage_news2 = !empty($homepage_news2) ? $homepage_news2 : $homepage_news_default_image;
                    $homepage_news3 = !empty($homepage_news3) ? $homepage_news3 : $homepage_news_default_image;
                    $homepage_news4 = !empty($homepage_news4) ? $homepage_news4 : $homepage_news_default_image;

                @endphp
                <div class="row no-gutters justify-content-between align-items-center flex-dairection">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="place-left">
                            <img src="{{ get_file($homepage_news1, APP_THEME()) }}" class="place-left-one"
                                alt="">
                            <img src="{{ get_file($homepage_news2, APP_THEME()) }}" class="place-left-two"
                                alt="">
                        </div>
                    </div>
                    @php
                        $homepage_newsletter_title = '';

                        $homepage_newsletter = array_search('homepage-newsletter-1', array_column($theme_json, 'unique_section_slug'));

                        if ($homepage_newsletter != '') {
                            $homepage_newsletter_value = $theme_json[$homepage_newsletter];

                            foreach ($homepage_newsletter_value['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-newsletter-label-text') {
                                    $homepage_newsletter_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                    $homepage_newsletter_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                    $homepage_newsletter_sub_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-newsletter-description') {
                                    $homepage_newsletter_description = $value['field_default_text'];
                                }

                                //Dynamic
                                if (!empty($homepage_newsletter_value[$value['field_slug']])) {
                                    if ($value['field_slug'] == 'homepage-newsletter-label-text') {
                                        $homepage_newsletter_title = $homepage_newsletter_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                        $homepage_newsletter_text = $homepage_newsletter_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                        $homepage_newsletter_sub_text = $homepage_newsletter_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'homepage-newsletter-description') {
                                        $homepage_newsletter_description = $value['field_default_text'];
                                    }
                                }
                            }
                        }
                    @endphp
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="footer-widget">
                            <div class="footer-subscribe">
                                <div class="subtitle">{{ $homepage_newsletter_title }}</div>
                                <h2>{!! $homepage_newsletter_text !!}</h2>
                            </div>
                            <p>{{ $homepage_newsletter_sub_text }}</p>
                            <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}"
                                method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                    <button type="submit" class="btn-subscibe"> {{ __('SUBSCRIBE') }}
                                    </button>
                                </div>
                                <div class="">
                                    {{-- <input type="checkbox" class="" id="PlaceCheckbox"> --}}
                                    <label for="">{{ $homepage_newsletter_description }}</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="place-right">
                            <div class="place-right-image">
                                <img src="{{ get_file($homepage_news3, APP_THEME()) }}" class="" alt="">
                            </div>
                            <div class="place-right-image">
                                <img src="{{ get_file($homepage_news4, APP_THEME()) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog-section padding-top padding-bottom">
            <div class="container">
                @php
                    $homepage_blog_title = '';

                    $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_blog != '') {
                        $homepage_blog_value = $theme_json[$homepage_blog];

                        foreach ($homepage_blog_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $homepage_blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_blog_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_blog_sub_text = $value['field_default_text'];
                            }

                            //Dynamic
                            if (!empty($homepage_blog_value[$value['field_slug']])) {
                                if ($value['field_slug'] == 'homepage-blog-label-text') {
                                    $homepage_blog_title = $homepage_blog_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-blog-title-text') {
                                    $homepage_blog_text = $homepage_blog_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                    $homepage_blog_sub_text = $homepage_blog_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp

                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="prodcut-card-heading">
                            <div class="section-title">
                                <span class="subtitle">{{ $homepage_blog_title }}</span>

                                {!! $homepage_blog_text !!}

                                <p>{{ $homepage_blog_sub_text }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                        {!! \App\Models\Blog::HomePageBlog($slug, $no = 10) !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
