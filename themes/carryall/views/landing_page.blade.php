@extends('layouts.layouts')
@section('page-title')
    {{ __('Bags') }}
@endsection
@php
    $theme_json = $homepage_json;
@endphp

@section('content')
    <section class="main-home-section padding-top"
        style="background-image: url({{ asset('themes/' . APP_THEME() . '/assets/images/home-banner.png') }});">
        <div class="container">
            <div class="row align-items-center">
                @php
                    $homepage_main_section_text = $homepage_main_section_sub_text = $homepage_main_section_btn = '';
                    $homepage_main_section_key = array_search('homepage-main-section', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_main_section_key != '') {
                        $homepage_main_section = $theme_json[$homepage_main_section_key];
                    }
                @endphp
                <div class=" col-lg-6 col-12">
                    <div class="home-left-side home-left-slider">
                        @for ($i = 0; $i < $homepage_main_section['loop_number']; $i++)
                            @php
                                foreach ($homepage_main_section['inner-list'] as $homepage_main_section_value) {
                                    if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-title-text') {
                                        $homepage_main_section_text = $homepage_main_section_value['field_default_text'];
                                    }
                                    if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-sub-text') {
                                        $homepage_main_section_sub_text = $homepage_main_section_value['field_default_text'];
                                    }
                                    if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-btn-text') {
                                        $homepage_main_section_btn = $homepage_main_section_value['field_default_text'];
                                    }

                                    if (!empty($homepage_main_section[$homepage_main_section_value['field_slug']])) {
                                        if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-title-text') {
                                            $homepage_main_section_text = $homepage_main_section[$homepage_main_section_value['field_slug']][$i];
                                        }
                                        if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-sub-text') {
                                            $homepage_main_section_sub_text = $homepage_main_section[$homepage_main_section_value['field_slug']][$i];
                                        }
                                        if ($homepage_main_section_value['field_slug'] == 'homepage-main-section-btn-text') {
                                            $homepage_main_section_btn = $homepage_main_section[$homepage_main_section_value['field_slug']][$i];
                                        }
                                    }
                                }
                            @endphp
                            <div class="home-left-item">
                                <div class="left-content dark-p">
                                    <div class="section-title">
                                        <h2>{!! $homepage_main_section_text !!} </h2>
                                    </div>
                                    <p>
                                        {!! $homepage_main_section_sub_text !!}
                                    </p>
                                    <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                        {!! $homepage_main_section_btn !!}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8"
                                            viewBox="0 0 11 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class=" col-lg-6 col-12">
                    <div class="home-right-side home-right-slider">
                        @foreach ($home_products as $h_product)
                            @php
                                $p_id = hashidsencode($h_product->id);
                            @endphp
                            <div class="home-right-item product-card">
                                <div class="product-card-inner">
                                    <div class="card-top">
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
                                                    if (is_array($saleEnableArray) && in_array($h_product->id, $saleEnableArray)) {
                                                        $latestSales[$h_product->id] = [
                                                            'discount_type' => $flashsale->discount_type,
                                                            'discount_amount' => $flashsale->discount_amount,
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp
                                        @foreach ($latestSales as $productId => $saleData)
                                            <span class="">
                                                @if ($saleData['discount_type'] == 'flat')
                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                    -{{ $saleData['discount_amount'] }}%
                                                @endif
                                            </span>
                                        @endforeach
                                            <div class="like-items-icon">
                                                <a class="add-wishlist wishbtn wishbtn-globaly" href="javascript:void(0)"
                                                    title="Wishlist" tabindex="0" product_id="{{ $h_product->id }}"
                                                    in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add' }}">
                                                    <div class="wish-ic">
                                                        <i
                                                            class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </div>
                                                </a>
                                            </div>
                                    </div>
                                    <div class="product-card-image">
                                        <a href="{{ route('page.product', [$slug, hashidsencode($h_product->id)]) }}">
                                            <img src="{{ get_file($h_product->cover_image_path, APP_THEME()) }}"
                                                class="default-img">
                                        </a>
                                    </div>
                                    <div class="card-bottom">
                                        <div class="product-title">
                                            <span class="sub-title">{{ $h_product->ProductData()->name }}</span>
                                            <h3>
                                                <a class="product-title1"
                                                    href="{{ route('page.product', [$slug, hashidsencode($h_product->id)]) }}">
                                                    {{ $h_product->name }}
                                                </a>
                                            </h3>
                                        </div>
                                        @if ($h_product->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $h_product->final_price }}
                                                    <span class="currency-type">{{ $currency }}</span>
                                                </ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="JavaScript:void(0)" class="btn addtocart-btn addcart-btn-globaly"
                                            product_id="{{ $h_product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8"
                                                viewBox="0 0 11 8" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="client-logo-slider-section padding-top padding-bottom">
            @php
                $homepage_logo = '';
                $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_logo_key != '') {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                }
            @endphp
            @if ($homepage_main_logo['section_enable'] == 'on')
                <div class="container">
                    <div class="client-logo-slider">
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
                                <div class="logo-slide">
                                    <h4>
                                        <a href="#"><img src="{{ get_file($homepage_logo, APP_THEME()) }}">
                                        </a>
                                    </h4>
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
                                <div class="logo-slide">
                                    <h4>
                                        <a href="#">
                                            <img src="{{ asset($homepage_logo) }}">
                                        </a>
                                    </h4>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
    <section class="best-product-section padding-top padding-bottom">
        <div class="container">
            @php
                $homepage_best_product_label = $homepage_best_product_text = $homepage_best_product_subtext = $homepage_best_product_btn = $homepage_best_product_img = '';
                $homepage_best_product_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_best_product_key != '') {
                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-banner-label-text') {
                            $homepage_best_product_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-title-text') {
                            $homepage_best_product_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                            $homepage_best_product_subtext = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-btn-text') {
                            $homepage_best_product_btn = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-img') {
                            $homepage_best_product_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_best_product['section_enable'] == 'on')
                <div class="row align-items-center">
                    <div class="col-md-6 col-12 ">
                        <div class="left-side-content dark-p">
                            <div class="section-title">
                                <span class="sub-title">{!! $homepage_best_product_label !!}</span>
                                <h2>{!! $homepage_best_product_text !!} </h2>
                            </div>
                            <p>{!! $homepage_best_product_subtext !!}</p>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                {!! $homepage_best_product_btn !!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="img-wrapper">
                            <img src="{{ get_file($homepage_best_product_img, APP_THEME()) }}" alt="product banner right">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @php
        $homepage_best_product = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_product != '') {
            $homepage_best = $theme_json[$homepage_best_product];
            foreach ($homepage_best['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-products-title-text') {
                    $home_best_title_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-products-btn-text') {
                    $home_best_btn_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($homepage_best['section_enable'] == 'on')
        <section class="tabs-section tabs-wrapper padding-bottom">
            <div class="container">
                <div class="section-title">
                    <div class="section-title-left">
                        <h2>{!! $home_best_title_text !!}</h2>
                    </div>
                    <div class="secttion-title-right">
                        <ul class="tabs ">
                            @foreach ($MainCategory as $cat_key => $category)
                                <li class="{{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:" class="btn-secondary">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M19.4324 0.980437L19.4089 0.949187C19.0222 0.468706 18.4792 0.148385 17.8737 0.0390077C17.2722 -0.0664637 16.651 0.0429141 16.1198 0.355422C12.3423 2.58204 7.65082 2.58204 3.87338 0.355422C3.34602 0.0429141 2.72491 -0.0664637 2.12334 0.0390077C1.51785 0.148385 0.974869 0.468706 0.588141 0.949187L0.564703 0.976531C0.0998473 1.55467 -0.0915638 2.30469 0.0412521 3.03518C0.174068 3.76566 0.615485 4.39849 1.25222 4.7735C3.13117 5.8829 5.17029 6.60558 7.26018 6.94152V8.58609C7.26018 9.47284 7.98286 10.1955 8.8696 10.1955H9.41258V14.4769C8.72897 14.7191 8.24068 15.3714 8.24068 16.1332V19.4145C8.24068 19.7387 8.5024 20.0004 8.82663 20.0004H11.1704C11.4947 20.0004 11.7564 19.7387 11.7564 19.4145V16.1332C11.7564 15.3675 11.2681 14.7191 10.5845 14.4769V10.1955H11.1275C12.0142 10.1955 12.7369 9.47284 12.7369 8.58609V6.94152C14.8229 6.60558 16.862 5.8829 18.7448 4.7735C19.3816 4.39849 19.823 3.76566 19.9558 3.03518C20.0886 2.30469 19.8972 1.55467 19.4324 0.980437ZM10.5845 18.8285H9.41258V16.1332C9.41258 15.8089 9.6743 15.5472 9.99853 15.5472C10.3228 15.5472 10.5845 15.8089 10.5845 16.1332V18.8285ZM8.8696 9.02361C8.6274 9.02361 8.43209 8.82829 8.43209 8.58609V7.08996C8.76022 7.12121 9.08835 7.14075 9.41649 7.15247V9.02751H8.8696V9.02361ZM11.5689 8.58609C11.5689 8.82829 11.3736 9.02361 11.1314 9.02361H10.5845V7.14856C10.9126 7.13684 11.2408 7.11731 11.5689 7.08606V8.58609ZM18.8034 2.82423C18.7331 3.21877 18.4948 3.55863 18.1511 3.76176C13.1236 6.73058 6.87345 6.73058 1.84598 3.76566C1.50223 3.56253 1.26394 3.22268 1.19362 2.82814C1.12331 2.4336 1.22488 2.02734 1.47488 1.71483L1.49832 1.68358C1.76786 1.34763 2.1624 1.17185 2.56475 1.17185C2.80695 1.17185 3.05305 1.23435 3.27571 1.36717C3.95151 1.76561 4.66246 2.10156 5.38904 2.375L4.88122 2.88283C4.65074 3.1133 4.65074 3.48441 4.88122 3.71097C4.9945 3.82426 5.14685 3.88285 5.29529 3.88285C5.44373 3.88285 5.59608 3.82426 5.70936 3.71097L6.64689 2.77345C7.18206 2.91408 7.72894 3.02346 8.27974 3.09377L8.10395 3.26956C7.87348 3.50003 7.87348 3.87113 8.10395 4.0977C8.21724 4.21099 8.36959 4.26958 8.51803 4.26958C8.66647 4.26958 8.81882 4.21099 8.9321 4.0977L9.83056 3.20315C9.88525 3.20315 9.94384 3.20315 9.99853 3.20315C10.5571 3.20315 11.1157 3.16799 11.6704 3.09377L11.5025 3.26174C11.272 3.48831 11.2681 3.85942 11.4947 4.08989C11.6079 4.20708 11.7603 4.26568 11.9126 4.26568C12.0611 4.26568 12.2095 4.21099 12.3228 4.0977L13.7799 2.66407C13.7877 2.65626 13.7955 2.64845 13.8033 2.64064C14.8151 2.33594 15.7956 1.90624 16.7174 1.36326C17.3151 1.01169 18.0651 1.1445 18.4948 1.67967L18.5183 1.71092C18.7722 2.02734 18.8777 2.42969 18.8034 2.82423Z"
                                                fill="#729454" />
                                        </svg> --}}
                                        {{ $category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="product-tab-slider f_blog">
                                @foreach ($homeproducts as $product)
                                    @php
                                        $p_id = hashidsencode($product->id);
                                    @endphp
                                    @if ($cat_k == '0' || $product->ProductData()->id == $cat_k)
                                        <div class="shop-protab-item">
                                            <div class="product-card">
                                                <div class="product-card-inner">
                                                    <div class="card-top">
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
                                                            <span class="">
                                                                @if ($saleData['discount_type'] == 'flat')
                                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                                    -{{ $saleData['discount_amount'] }}%
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                            <div class="like-items-icon">
                                                                <a class="add-wishlist wishbtn wishbtn-globaly"
                                                                    href="javascript:void(0)" title="Wishlist" tabindex="0"
                                                                    product_id="{{ $product->id }}"
                                                                    in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                                    <div class="wish-ic">
                                                                        <i
                                                                            class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                    </div>
                                                    <div class="product-card-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                                class="default-img">
                                                        </a>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <div class="product-title">
                                                            <span
                                                                class="sub-title">{{ $product->ProductData()->name }}</span>
                                                            <h3>
                                                                <a class="product-title1"
                                                                    href="{{ route('page.product', [$slug, $p_id]) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </h3>
                                                        </div>

                                                        @if ($product->variant_product == 0)
                                                            <div class="price">
                                                                <ins>{{ $product->final_price }}
                                                                    <span class="currency-type">{{ $currency }}</span>
                                                                </ins>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <a href="JavaScript:void(0)"
                                                            class="btn addtocart-btn addcart-btn-globaly"
                                                            product_id="{{ $product->id }}" variant_id="0"
                                                            qty="1">
                                                            {{ __('Add to cart') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11"
                                                                height="8" viewBox="0 0 11 8" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                                    fill="white" />
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
            </div>
        </section>
    @endif
    @php
        $homepage_subscribe = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if ($homepage_subscribe != '') {
            $home_subscribe = $theme_json[$homepage_subscribe];
            $section_enable = $home_subscribe['section_enable'];
            foreach ($home_subscribe['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                    $home_subscribe_title_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                    $home_subscribe_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-newsletter-description') {
                    $home_subscribe_description = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-newsletter-bg-img') {
                    $home_subscribe_image = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($home_subscribe['section_enable'] == 'on')
        <section class="newsletter-section">
            <div class=" container">
                <div class="bg-sec">
                    <img src="{{ get_file($home_subscribe_image, APP_THEME()) }}" class="banner-img"
                        alt="newsletter img">
                    <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}" method="post">
                        @csrf
                        <div class="contnent">
                            <h2>{!! $home_subscribe_title_text !!}</h2>
                            <p>{!! $home_subscribe_sub_text !!}</p>
                            <div class="input-box">
                                <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                <button>
                                    {{ __('SUBSCRIBE') }}
                                </button>
                            </div>
                            <label for="subscibecheck">
                                {!! $home_subscribe_description !!}
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_card_label = $homepage_card_text = $homepage_card_sub_text = $homepage_card_img = '';
        $homepagepage_card = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
        if ($homepagepage_card != '') {
            $homepage_card = $theme_json[$homepagepage_card];
            foreach ($homepage_card['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-card-label-text') {
                    $homepage_card_label = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-card-title-text') {
                    $homepage_card_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-card-sub-text') {
                    $homepage_card_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-card-bg-img') {
                    $homepage_card_img = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($homepage_card['section_enable'] == 'on')
        <section class="more-pro-banner-section "
            style="background-image: url('{{ get_file($homepage_card_img, APP_THEME()) }}');">
            <div class="container">
                <div class="inner-content dark-p">
                    <div class="section-title">
                        <span class="sub-title">{!! $homepage_card_label !!}</span>
                        <h2>{!! $homepage_card_text !!}</h2>
                    </div>
                    <p>{!! $homepage_card_sub_text !!}</p>
                </div>
            </div>
        </section>
    @endif
    <section class="category-card-section padding-bottom">
        <div class="container">
            <div class="row">
                @foreach ($MainCategoryList as $category)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="img-box">
                            <img src="{{ get_file($category->image_path, APP_THEME()) }}" alt="category-card">
                            <div class="card-innner-content">
                                <div class="card-title">
                                    <span class="sub-title">CATEGORY</span>
                                    <h4>
                                        <a class="product-title1"
                                            href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </h4>
                                </div>
                                <a href="{{ route('page.product-list', $slug) }}" class="link-btn">
                                    {{ __('SHOW MORE PRODUCTS') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8"
                                        viewBox="0 0 11 8" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @php
        $homepage_feature_product = array_search('homepage-feature-product', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_feature_product != '') {
            $homepage_feature_product = $theme_json[$homepage_feature_product];
            foreach ($homepage_feature_product['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-feature-product-title-text') {
                    $home_feature_product_title = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($homepage_feature_product['section_enable'] == 'on')
        <section class="tabs-section tabs-section-second tabs-wrapper">
            <div class="container">
                <div class="section-title">
                    <div class="section-title-left">
                        <h2>{!! $home_feature_product_title !!}</h2>
                    </div>
                    <div class="secttion-title-right">
                        <ul class="tabs ">
                            @foreach ($MainCategory as $cat_key => $category)
                                <li class="{{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}_data">
                                    <a href="javascript:" class="btn-secondary">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M19.4324 0.980437L19.4089 0.949187C19.0222 0.468706 18.4792 0.148385 17.8737 0.0390077C17.2722 -0.0664637 16.651 0.0429141 16.1198 0.355422C12.3423 2.58204 7.65082 2.58204 3.87338 0.355422C3.34602 0.0429141 2.72491 -0.0664637 2.12334 0.0390077C1.51785 0.148385 0.974869 0.468706 0.588141 0.949187L0.564703 0.976531C0.0998473 1.55467 -0.0915638 2.30469 0.0412521 3.03518C0.174068 3.76566 0.615485 4.39849 1.25222 4.7735C3.13117 5.8829 5.17029 6.60558 7.26018 6.94152V8.58609C7.26018 9.47284 7.98286 10.1955 8.8696 10.1955H9.41258V14.4769C8.72897 14.7191 8.24068 15.3714 8.24068 16.1332V19.4145C8.24068 19.7387 8.5024 20.0004 8.82663 20.0004H11.1704C11.4947 20.0004 11.7564 19.7387 11.7564 19.4145V16.1332C11.7564 15.3675 11.2681 14.7191 10.5845 14.4769V10.1955H11.1275C12.0142 10.1955 12.7369 9.47284 12.7369 8.58609V6.94152C14.8229 6.60558 16.862 5.8829 18.7448 4.7735C19.3816 4.39849 19.823 3.76566 19.9558 3.03518C20.0886 2.30469 19.8972 1.55467 19.4324 0.980437ZM10.5845 18.8285H9.41258V16.1332C9.41258 15.8089 9.6743 15.5472 9.99853 15.5472C10.3228 15.5472 10.5845 15.8089 10.5845 16.1332V18.8285ZM8.8696 9.02361C8.6274 9.02361 8.43209 8.82829 8.43209 8.58609V7.08996C8.76022 7.12121 9.08835 7.14075 9.41649 7.15247V9.02751H8.8696V9.02361ZM11.5689 8.58609C11.5689 8.82829 11.3736 9.02361 11.1314 9.02361H10.5845V7.14856C10.9126 7.13684 11.2408 7.11731 11.5689 7.08606V8.58609ZM18.8034 2.82423C18.7331 3.21877 18.4948 3.55863 18.1511 3.76176C13.1236 6.73058 6.87345 6.73058 1.84598 3.76566C1.50223 3.56253 1.26394 3.22268 1.19362 2.82814C1.12331 2.4336 1.22488 2.02734 1.47488 1.71483L1.49832 1.68358C1.76786 1.34763 2.1624 1.17185 2.56475 1.17185C2.80695 1.17185 3.05305 1.23435 3.27571 1.36717C3.95151 1.76561 4.66246 2.10156 5.38904 2.375L4.88122 2.88283C4.65074 3.1133 4.65074 3.48441 4.88122 3.71097C4.9945 3.82426 5.14685 3.88285 5.29529 3.88285C5.44373 3.88285 5.59608 3.82426 5.70936 3.71097L6.64689 2.77345C7.18206 2.91408 7.72894 3.02346 8.27974 3.09377L8.10395 3.26956C7.87348 3.50003 7.87348 3.87113 8.10395 4.0977C8.21724 4.21099 8.36959 4.26958 8.51803 4.26958C8.66647 4.26958 8.81882 4.21099 8.9321 4.0977L9.83056 3.20315C9.88525 3.20315 9.94384 3.20315 9.99853 3.20315C10.5571 3.20315 11.1157 3.16799 11.6704 3.09377L11.5025 3.26174C11.272 3.48831 11.2681 3.85942 11.4947 4.08989C11.6079 4.20708 11.7603 4.26568 11.9126 4.26568C12.0611 4.26568 12.2095 4.21099 12.3228 4.0977L13.7799 2.66407C13.7877 2.65626 13.7955 2.64845 13.8033 2.64064C14.8151 2.33594 15.7956 1.90624 16.7174 1.36326C17.3151 1.01169 18.0651 1.1445 18.4948 1.67967L18.5183 1.71092C18.7722 2.02734 18.8777 2.42969 18.8034 2.82423Z"
                                            fill="#729454" />
                                    </svg> --}}
                                        {{ $category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}_data"
                            class="tab-content tab-cat-id {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="product-tab-slider f_blog">
                                @foreach ($homeproducts as $product)
                                    @php
                                        $p_id = hashidsencode($product->id);
                                    @endphp
                                    @if ($cat_k == '0' || $product->ProductData()->id == $cat_k)
                                        <div class="shop-protab-item">
                                            <div class="product-card">
                                                <div class="product-card-inner">
                                                    <div class="card-top">
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
                                                <span class="">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </span>
                                            @endforeach
                                                            <div class="like-items-icon">
                                                                <a class="add-wishlist wishbtn wishbtn-globaly"
                                                                    href="javascript:void(0)" title="Wishlist" tabindex="0"
                                                                    product_id="{{ $product->id }}"
                                                                    in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                                    <div class="wish-ic">
                                                                        <i
                                                                            class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                    </div>
                                                    <div class="product-card-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                                class="default-img">
                                                        </a>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <div class="product-title">
                                                            <span
                                                                class="sub-title">{{ $product->ProductData()->name }}</span>
                                                            <h3>
                                                                <a class="product-title1"
                                                                    href="{{ route('page.product', [$slug, $p_id]) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </h3>
                                                            {{-- <p>STAINLESS METAL</p> --}}
                                                        </div>
                                                        @if ($product->variant_product == 0)
                                                            <div class="price">
                                                                <ins>{{ $product->final_price }}
                                                                    <span class="currency-type">{{ $currency }}</span>
                                                                </ins>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <a href="JavaScript:void(0)"
                                                            class="btn addtocart-btn addcart-btn-globaly"
                                                            product_id="{{ $product->id }}" variant_id="0"
                                                            qty="1">
                                                            {{ __('Add to cart') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11"
                                                                height="8" viewBox="0 0 11 8" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                                    fill="white" />
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
        </section>
    @endif
    @php
        $homepage_category = array_search('homepage-category-1', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_category != '') {
            $homepage_modern = $theme_json[$homepage_category];
            foreach ($homepage_modern['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-category-title-text') {
                    $home_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-category-sub-text') {
                    $home_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-category-btn-text') {
                    $home_button = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($homepage_modern['section_enable'] == 'on')
        <section class="more-cat-item-section"
            style="background-image:url({{ asset('themes/' . APP_THEME() . '/assets/images/more-pro-banner.png') }});">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/more-cat-img2.png') }}" class="more-cat-img"
                alt="more-cat-img">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 col-12 img-col">
                        <div class="img-wrapper">
                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/more-cat-img1.png') }}"
                                alt="cat-img">
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="right-content">
                            <div class=" dark-p">
                                <div class="section-title">
                                    <h2>{!! $home_title !!}</h2>
                                </div>
                                <p>{!! $home_sub_text !!}</p>
                            </div>
                            <div class="cat-btn-wrapper">
                                @foreach ($MainCategoryList as $key => $MainCategory)
                                    <a href="{{ route('page.product-list', [$slug, 'main_category' => $MainCategory->id]) }}"
                                        class="btn-secondary">
                                        {{ $MainCategory->name }}
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                {!! $home_button !!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @php
        $home_testimonial = $home_testimonial_text = $home_testimonial_image = '';
        $homepage_testimonial = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
        $section_enable = 'on';
        if ($homepage_testimonial != '') {
            $home_testimonial = $theme_json[$homepage_testimonial];
            $section_enable = $home_testimonial['section_enable'];
            foreach ($home_testimonial['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                    $home_testimonial_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                    $home_testimonial_btn_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($reviews->isNotEmpty())
        @if ($home_testimonial['section_enable'] == 'on')
            <section class="testimonials-section padding-top padding-bottom">
                <div class="container">
                    <div class="section-title d-flex justify-content-between align-items-center ">
                        <h2>{!! $home_testimonial_text !!} </h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn-secondary show-more-btn">
                            {!! $home_testimonial_btn_text !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="testimonials-main">
                        <div class="testimonials-slider flex-slider">
                            @foreach ($reviews as $review)
                                <div class="testimonials-slides">
                                    <div class="testi-inner">
                                        <div class="left-content blog-card-content">
                                            <div class="ratings d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                @endfor
                                                <span>{{ $review->rating_no }}.0 / 5.0</span>
                                            </div>
                                            <h3>{{ $review->title }}</h3>
                                            <p>{{ $review->description }}</p>
                                            <span class="user-name"><a
                                                    href="#">{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</a>
                                                {{ $review->UserData->type }} </span>
                                        </div>
                                        {{-- @dd($review->UserData) --}}
                                        <div class="img-wrapper">
                                            <img
                                                src="{{ asset('/' . !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path, APP_THEME()) : '') }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @php
        $home_blog = $home_content_text = '';
        $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_blog != '') {
            $home_blog = $theme_json[$homepage_blog];

            $prev_index = $homepage_blog;
            $homepage_blog_image_enable = $home_blog['section_enable'];
            if (!empty($theme_json[$prev_index - 1]) && $home_blog['section_slug'] == $theme_json[$prev_index - 1]['section_slug']) {
                $home_blog['section_enable'] = $theme_json[$prev_index - 1]['section_enable'];
            }
            foreach ($home_blog['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-blog-label-text') {
                    $home_blog_label = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-blog-title-text') {
                    $home_blog_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-blog-sub-text') {
                    $home_blog_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-blog-btn-text') {
                    $home_blog_btn_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($home_blog['section_enable'] == 'on')
        <section class="blog-section"
            style="background-image: url({{ asset('themes/' . APP_THEME() . '/assets/images/blog-sec-banner.png') }});">
            <div class="container">
                <div class="main-title dark-p">
                    <div class="section-title">
                        <span class="sub-title">{!! $home_blog_label !!}</span>
                        <h2>{!! $home_blog_text !!}</h2>
                    </div>
                    <p>{!! $home_blog_sub_text !!}</p>
                </div>
                <div class="blog-slider-main">
                    {!! \App\Models\Blog::HomePageBlog($slug, 10) !!}
                </div>
                <div class="blog-more-btn ">
                    <a href="{{ route('page.product-list', $slug) }}" class="btn-secondary show-more-btn">
                        {!! $home_blog_btn_text !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                fill="white"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif
    @php
        $home_image_section1 = $home_image_section_text = $home_image_section_button = '';
        $homepage_image_section = array_search('homepage-image-section-1', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_image_section != '') {
            $home_image_section = $theme_json[$homepage_image_section];
            foreach ($home_image_section['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-image-section-title-text') {
                    $home_image_section_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($home_image_section['section_enable'] == 'on')
        <section class="our-insta-section padding-bottom  padding-top">
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center ">
                    <h2>{!! $home_image_section_text !!}</h2>
                    <div class="insta-pro">
                        <div class="insta-pro-info">
                            <span>{{ __('INSTAGRAM') }}</span>
                            <a href="https://www.instagram.com/" target="_blank">
                                @bags
                            </a>
                        </div>
                        <div class="insta-pro-img">
                            <a href="https://www.instagram.com/">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/insta-pro.png') }}"
                                    alt="insta-pro">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 9 9"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.746338 3.26117C0.746338 1.90962 1.74238 0.813965 2.97107 0.813965H5.93738C7.16607 0.813965 8.16211 1.90962 8.16211 3.26117V6.52411C8.16211 7.87567 7.16607 8.97132 5.93738 8.97132H2.97107C1.74238 8.97132 0.746338 7.87567 0.746338 6.52411V3.26117ZM2.97107 1.6297C2.15195 1.6297 1.48792 2.36013 1.48792 3.26117V6.52411C1.48792 7.42515 2.15195 8.15558 2.97107 8.15558H5.93738C6.75651 8.15558 7.42054 7.42515 7.42054 6.52411V3.26117C7.42054 2.36013 6.75651 1.6297 5.93738 1.6297H2.97107ZM3.71265 4.89264C3.71265 5.34316 4.04466 5.70838 4.45423 5.70838C4.86379 5.70838 5.1958 5.34316 5.1958 4.89264C5.1958 4.44212 4.86379 4.07691 4.45423 4.07691C4.04466 4.07691 3.71265 4.44212 3.71265 4.89264ZM4.45423 3.26117C3.6351 3.26117 2.97107 3.99161 2.97107 4.89264C2.97107 5.79368 3.6351 6.52411 4.45423 6.52411C5.27335 6.52411 5.93738 5.79368 5.93738 4.89264C5.93738 3.99161 5.27335 3.26117 4.45423 3.26117ZM6.12278 2.44544C5.8156 2.44544 5.56659 2.71935 5.56659 3.05724C5.56659 3.39513 5.8156 3.66904 6.12278 3.66904C6.42995 3.66904 6.67896 3.39513 6.67896 3.05724C6.67896 2.71935 6.42995 2.44544 6.12278 2.44544Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @php
                    $homepage_image = '';
                    $homepage_image_key = array_search('homepage-image-section-2', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_image_key != '') {
                        $homepage_main_image = $theme_json[$homepage_image_key];
                    }
                @endphp
                @if ($homepage_main_image['section_enable'] == 'on')
                    <ul class="insta-imgs">
                        @if (!empty($homepage_main_image['homepage-image-section-img']))
                            @for ($i = 0; $i < count($homepage_main_image['homepage-image-section-img']); $i++)
                                @php
                                    foreach ($homepage_main_image['inner-list'] as $homepage_main_image_value) {
                                        if ($homepage_main_image_value['field_slug'] == 'homepage-image-section-img') {
                                            $homepage_image = $homepage_main_image_value['field_default_text'];
                                        }
                                        if (!empty($homepage_main_image[$homepage_main_image_value['field_slug']])) {
                                            if ($homepage_main_image_value['field_slug'] == 'homepage-image-section-img') {
                                                $homepage_image = $homepage_main_image[$homepage_main_image_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="https://www.instagram.com/" class="img-wrapper">
                                        <img src="{{ get_file($homepage_image, APP_THEME()) }}" alt="pic">
                                    </a>
                                </li>
                            @endfor
                        @else
                            @for ($i = 0; $i <= 5; $i++)
                                @php
                                    foreach ($homepage_main_image['inner-list'] as $homepage_main_image_value) {
                                        if ($homepage_main_image_value['field_slug'] == 'homepage-image-section-img') {
                                            $homepage_image = $homepage_main_image_value['field_default_text'];
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="https://www.instagram.com/" class="img-wrapper">
                                        <img src="{{ get_file($homepage_image, APP_THEME()) }}" alt="pic">
                                    </a>
                                </li>
                            @endfor
                        @endif
                    </ul>
                @endif
            </div>
        </section>
    @endif

    @php
        $homepage_footer_section9_cookie = '';

        $homepage_footer_key9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_footer_key9 != '') {
            $homepage_footer_section9 = $theme_json[$homepage_footer_key9];

            foreach ($homepage_footer_section9['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-footer-cookie') {
                    $homepage_footer_section9_cookie = $value['field_default_text'];
                }
            }
        }
    @endphp
    <div class="cookie">
        {!! $homepage_footer_section9_cookie !!}
        <button class="cookie-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.20706 0.707107L6.49995 0L3.60354 2.89641L0.707134 0L2.67029e-05 0.707107L2.89644 3.60352L0 6.49995L0.707107 7.20706L3.60354 4.31062L6.49998 7.20706L7.20708 6.49995L4.31065 3.60352L7.20706 0.707107Z"
                    fill="#30383D"></path>
            </svg>
        </button>
    </div>
@endsection
@push('page-script')
@endpush
