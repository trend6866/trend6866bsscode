@extends('layouts.layouts')

@section('page-title')
    {{ __('Home page') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

    @php
        $homepage_banner_title = $homepage_banner_sub_text = $homepage_banner_img = $homepage_banner_heading1 = $homepage_banner_icon_img1 = $homepage_banner_heading2 = $homepage_banner_icon_img2 = $homepage_banner_promotion_title1 = $homepage_banner_promotion_icon1 = $homepage_banner_promotion_title2 = $homepage_banner_promotion_icon2 = '';

        $homepage_banner_section = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_banner_section != '') {
            $homepage_banner = $theme_json[$homepage_banner_section];
        }
    @endphp

    <div class="wrapper home-wrapper">
        <section class="home-banner-section">
            <div class="home-main-slider">
                <div class="hero-slider-item">
                    @for ($i = 0; $i < $homepage_banner['loop_number']; $i++)
                        @php
                            foreach ($homepage_banner['inner-list'] as $homepage_banner_value) {
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-title') {
                                    $homepage_banner_title = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-sub-text') {
                                    $homepage_banner_sub_text = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-bg-image') {
                                    $homepage_banner_img = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-heading1') {
                                    $homepage_banner_heading1 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-icon-image1') {
                                    $homepage_banner_icon_img1 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-heading2') {
                                    $homepage_banner_heading2 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-icon-image2') {
                                    $homepage_banner_icon_img2 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-title1') {
                                    $homepage_banner_promotion_title1 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-icon1') {
                                    $homepage_banner_promotion_icon1 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-title2') {
                                    $homepage_banner_promotion_title2 = $homepage_banner_value['field_default_text'];
                                }
                                if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-icon2') {
                                    $homepage_banner_promotion_icon2 = $homepage_banner_value['field_default_text'];
                                }

                                if (!empty($homepage_banner[$homepage_banner_value['field_slug']])) {
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-title') {
                                        $homepage_banner_title = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-sub-text') {
                                        $homepage_banner_sub_text = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-bg-image') {
                                        $homepage_banner_img = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-heading1') {
                                        $homepage_banner_heading1 = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-icon-image1') {
                                        $homepage_banner_icon_img1 = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-heading2') {
                                        $homepage_banner_heading2 = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-icon-image2') {
                                        $homepage_banner_icon_img2 = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-title1') {
                                        $homepage_banner_promotion_title1 = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-icon1') {
                                        $homepage_banner_promotion_icon1 = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-title2') {
                                        $homepage_banner_promotion_title2 = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if ($homepage_banner_value['field_slug'] == 'homepage-banner-promotion-icon2') {
                                        $homepage_banner_promotion_icon2 = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            }
                        @endphp

                        <div class="hero-item-inner">
                            <img src="{{ get_file($homepage_banner_img, APP_THEME()) }}" class="banner" alt="banner">
                            <div class="banner-content">
                                <div class="container">
                                    <div class="banner-content-inner comman-title-white">
                                        <h2 class="banner-heading">{!! $homepage_banner_title !!}</h2>
                                        <p>{!! $homepage_banner_sub_text !!}</p>
                                        <div class="banner-links">
                                            <a href="{{ route('page.product-list', $slug) }}" class="categories-link">
                                                {!! $homepage_banner_heading1 !!}
                                                <img src="{{ get_file($homepage_banner_icon_img1, APP_THEME()) }}"
                                                    alt="icon" class="banner_icon">
                                            </a>
                                            <a href="{{ route('page.product-list', $slug) }}" class="sellers-link">
                                                {!! $homepage_banner_heading2 !!}
                                                <img src="{{ get_file($homepage_banner_icon_img2, APP_THEME()) }}"
                                                    alt="icon" class="banner_icon">
                                            </a>
                                        </div>
                                        <div class="offer-btn d-flex align-items-center">
                                            <div class="offer-btn-left d-flex align-items-center">
                                                <div class="offer-img">
                                                    <img src="{{ get_file($homepage_banner_promotion_icon1, APP_THEME()) }}"
                                                        alt="icon">
                                                </div>
                                                <p>{!! $homepage_banner_promotion_title1 !!}</p>
                                            </div>
                                            <div class="offer-btn-left d-flex align-items-center">
                                                <div class="offer-img">
                                                    <img src="{{ get_file($homepage_banner_promotion_icon2, APP_THEME()) }}"
                                                        alt="icon">
                                                </div>
                                                <p>{!! $homepage_banner_promotion_title2 !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <section class="best-selling-section padding-top">
            <div class="container">
                <div class="row">
                    @foreach ($trending_categories as $cat)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="best-selling-card">
                                <div class="best-selling-card-inner">
                                    <div class="best-card-image">
                                        <a href="{{ route('page.product-list', [$slug, 'main_category' => $cat->id]) }}"
                                            class="best-img">
                                            <img src="{{ get_file($cat->image_path, APP_THEME()) }}" alt="bestproduct">
                                        </a>
                                        <div class="best-content">
                                            <div class="product-content-top">
                                                <div class="sub-title"> {{ __('CATEGORIES') }} </div>
                                                <h4 class="product-title">
                                                    <a
                                                        href="{{ route('page.product-list', [$slug, 'main_category' => $cat->id]) }}">
                                                        {{ $cat->name }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="best-card-btn">
                                            <a href="{{ route('page.product-list', [$slug, 'main_category' => $cat->id]) }}"
                                                class="btn-secondary white-btn">
                                                {{ __('Go to categories') }}
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M1.77886 1.38444C2.62144 2.10579 3.18966 3.13838 3.3054 4.30408H4.21204V0.344353C4.35754 0.329906 4.50512 0.32251 4.65443 0.32251C4.80374 0.32251 4.95132 0.329906 5.09683 0.344353V4.30408H6.00346C6.1192 3.13838 6.68742 2.10579 7.53001 1.38444C7.7549 1.57698 7.96024 1.79168 8.14265 2.02517C7.4696 2.58546 7.00769 3.39073 6.89379 4.30408H9.05655C9.071 4.44958 9.07839 4.59716 9.07839 4.74647C9.07839 4.89578 9.071 5.04336 9.05655 5.18887H6.89379C7.00769 6.10222 7.4696 6.90748 8.14265 7.46778C7.96024 7.70127 7.7549 7.91597 7.53001 8.1085C6.68742 7.38715 6.1192 6.35457 6.00346 5.18887H5.09683V9.14859C4.95132 9.16304 4.80374 9.17044 4.65443 9.17044C4.50512 9.17044 4.35754 9.16304 4.21204 9.14859V5.18887H3.3054C3.18966 6.35457 2.62144 7.38715 1.77886 8.1085C1.55397 7.91597 1.34862 7.70127 1.16621 7.46778C1.83926 6.90748 2.30118 6.10222 2.41507 5.18887H0.252312C0.237865 5.04336 0.230469 4.89578 0.230469 4.74647C0.230469 4.59716 0.237865 4.44958 0.252312 4.30408H2.41507C2.30118 3.39073 1.83926 2.58546 1.16621 2.02517C1.34862 1.79168 1.55397 1.57698 1.77886 1.38444Z"
                                                        fill="#12131A"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4.65443 8.28564C6.60906 8.28564 8.1936 6.7011 8.1936 4.74647C8.1936 2.79184 6.60906 1.2073 4.65443 1.2073C2.6998 1.2073 1.11526 2.79184 1.11526 4.74647C1.11526 6.7011 2.6998 8.28564 4.65443 8.28564ZM4.65443 9.17044C7.09772 9.17044 9.07839 7.18976 9.07839 4.74647C9.07839 2.30319 7.09772 0.32251 4.65443 0.32251C2.21114 0.32251 0.230469 2.30319 0.230469 4.74647C0.230469 7.18976 2.21114 9.17044 4.65443 9.17044Z"
                                                        fill="#12131A"></path>
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
        </section>

        <section class="our-client-section padding-top padding-bottom">
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
                                <div class="client-logo-item">
                                    <a href="{{ route('landing_page', $slug) }}">
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
                                            // dd($homepage_logo);
                                        }
                                    }
                                @endphp
                                <div class="client-logo-item">
                                    <a href="{{ route('landing_page', $slug) }}">
                                        <img src="{{ asset($homepage_logo) }}" alt="logo">
                                    </a>
                                </div>
                            @endfor
                        @endif

                    </div>
                </div>
            @endif
        </section>

        @php
            $homepage_bestseller_title = $homepage_bestseller_btn = '';

            $homepage_bestseller = array_search('homepage-bestsellers', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_bestseller != '') {
                $homepage_bestseller_value = $theme_json[$homepage_bestseller];

                foreach ($homepage_bestseller_value['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-bestsellers-title') {
                        $homepage_bestseller_title = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-bestsellers-button') {
                        $homepage_bestseller_btn = $value['field_default_text'];
                    }
                }
            }
        @endphp

        <section class="best-seller-section padding-bottom">
            <div class="container">
                @if ($homepage_bestseller_value['section_enable'] == 'on')
                    <div class="common-title d-flex align-items-center justify-content-between">
                        <div class="section-title">
                            <h2>{!! $homepage_bestseller_title !!}</h2>
                        </div>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn theme-btn">
                            {!! $homepage_bestseller_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.22466 5.62411C8.87997 5.64249 8.58565 5.37796 8.56728 5.03327C8.5422 4.56284 8.51152 4.19025 8.48081 3.89909C8.43958 3.50807 8.19939 3.27049 7.85391 3.23099C7.35787 3.17429 6.60723 3.125 5.49957 3.125C4.39192 3.125 3.64128 3.17429 3.14524 3.23099C2.79917 3.27055 2.55966 3.50754 2.51845 3.89797C2.44629 4.58174 2.37457 5.71203 2.37457 7.5C2.37457 9.28797 2.44629 10.4183 2.51845 11.102C2.55966 11.4925 2.79917 11.7294 3.14524 11.769C3.64128 11.8257 4.39192 11.875 5.49957 11.875C6.60723 11.875 7.35787 11.8257 7.85391 11.769C8.19939 11.7295 8.43958 11.4919 8.48081 11.1009C8.51152 10.8098 8.5422 10.4372 8.56728 9.96673C8.58565 9.62204 8.87997 9.35751 9.22466 9.37589C9.56935 9.39426 9.83388 9.68858 9.8155 10.0333C9.78942 10.5225 9.75716 10.9168 9.72392 11.232C9.62607 12.1598 8.96789 12.8998 7.99588 13.0109C7.4419 13.0742 6.64237 13.125 5.49957 13.125C4.35677 13.125 3.55725 13.0742 3.00327 13.0109C2.03184 12.8999 1.37333 12.1616 1.27536 11.2332C1.19744 10.495 1.12457 9.31924 1.12457 7.5C1.12457 5.68076 1.19744 4.50504 1.27536 3.76677C1.37333 2.83844 2.03184 2.10013 3.00327 1.98908C3.55725 1.92575 4.35677 1.875 5.49957 1.875C6.64237 1.875 7.4419 1.92575 7.99588 1.98908C8.96789 2.1002 9.62607 2.84023 9.72392 3.76798C9.75716 4.08316 9.78942 4.47745 9.8155 4.96673C9.83388 5.31142 9.56935 5.60574 9.22466 5.62411Z"
                                    fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.6206 5.75444C11.3765 5.51036 11.3765 5.11464 11.6206 4.87056C11.8646 4.62648 12.2604 4.62648 12.5044 4.87056L14.6919 7.05806C14.936 7.30214 14.936 7.69786 14.6919 7.94194L12.5044 10.1294C12.2604 10.3735 11.8646 10.3735 11.6206 10.1294C11.3765 9.88536 11.3765 9.48964 11.6206 9.24556L12.7411 8.125L6.75 8.125C6.40482 8.125 6.125 7.84518 6.125 7.5C6.125 7.15482 6.40482 6.875 6.75 6.875L12.7411 6.875L11.6206 5.75444Z"
                                    fill="black" />
                            </svg>
                        </a>
                    </div>
                @endif
                <div class="best-seller-slider">
                    @foreach ($bestSeller as $data)
                        <div class="product-card">
                            @php
                                $p_id = hashidsencode($data->id);
                            @endphp
                            <div class="product-card-inner">
                                <div class="product-content-top text-center">
                                    <h4><a href="{{ route('page.product', [$slug, $p_id]) }}">{{ $data->name }}</a>
                                    </h4>
                                        <div class="favorite-icon">
                                            <a href="javascript:void(0)" class="wishbtn-globaly"
                                                product_id="{{ $data->id }}"
                                                in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: white'></i>
                                            </a>
                                        </div>
                                </div>
                                <div class="product-img">
                                    <div class="new-labl">
                                        {{ $data->tag_api }}
                                    </div>

                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}"
                                            alt="product-img">
                                    </a>
                                </div>
                                <div class="product-content-bottom text-center">
                                    <div class="price-label2">
                                        @if ($data->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $data->final_price }} <span
                                                        class="currency-type">{{ $currency_icon }}</span></ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif

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
                                                    if (is_array($saleEnableArray) && in_array($data->id, $saleEnableArray)) {
                                                        $latestSales[$data->id] = [
                                                            'discount_type' => $flashsale->discount_type,
                                                            'discount_amount' => $flashsale->discount_amount,
                                                        ];
                                                    }
                                                }
                                            }
                                        @endphp
                                        @foreach ($latestSales as $productId => $saleData)
                                            <div class="custom-output">
                                                <div class="option">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly"
                                        product_id="{{ $data->id }}" variant_id="0" qty="1">
                                        {{ __('Add to cart') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                            viewBox="0 0 16 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.22012 7.5C4.02701 7.5 3.88012 7.6734 3.91187 7.86387L4.51047 11.4555C4.61093 12.0582 5.13242 12.5 5.74347 12.5H10.2578C10.8689 12.5 11.3904 12.0582 11.4908 11.4555L12.0894 7.86387C12.1212 7.6734 11.9743 7.5 11.7812 7.5H4.22012ZM3.11344 6.25C2.72722 6.25 2.43345 6.59679 2.49694 6.97775L3.27748 11.661C3.47839 12.8665 4.52137 13.75 5.74347 13.75H10.2578C11.4799 13.75 12.5229 12.8665 12.7238 11.661L13.5044 6.97775C13.5678 6.59679 13.2741 6.25 12.8879 6.25H3.11344Z"
                                                fill="#12131A" />
                                            <path
                                                d="M6.75 8.75C6.40482 8.75 6.125 9.02982 6.125 9.375V10.625C6.125 10.9702 6.40482 11.25 6.75 11.25C7.09518 11.25 7.375 10.9702 7.375 10.625V9.375C7.375 9.02982 7.09518 8.75 6.75 8.75Z"
                                                fill="#12131A" />
                                            <path
                                                d="M9.25 8.75C8.90482 8.75 8.625 9.02982 8.625 9.375V10.625C8.625 10.9702 8.90482 11.25 9.25 11.25C9.59518 11.25 9.875 10.9702 9.875 10.625V9.375C9.875 9.02982 9.59518 8.75 9.25 8.75Z"
                                                fill="#12131A" />
                                            <path
                                                d="M7.19194 2.31694C7.43602 2.07286 7.43602 1.67714 7.19194 1.43306C6.94786 1.18898 6.55214 1.18898 6.30806 1.43306L3.80806 3.93306C3.56398 4.17714 3.56398 4.57286 3.80806 4.81694C4.05214 5.06102 4.44786 5.06102 4.69194 4.81694L7.19194 2.31694Z"
                                                fill="#12131A" />
                                            <path
                                                d="M8.80806 2.31694C8.56398 2.07286 8.56398 1.67714 8.80806 1.43306C9.05214 1.18898 9.44786 1.18898 9.69194 1.43306L12.1919 3.93306C12.436 4.17714 12.436 4.57286 12.1919 4.81694C11.9479 5.06102 11.5521 5.06102 11.3081 4.81694L8.80806 2.31694Z"
                                                fill="#12131A" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12.375 5H3.625C3.27982 5 3 5.27982 3 5.625C3 5.97018 3.27982 6.25 3.625 6.25H12.375C12.7202 6.25 13 5.97018 13 5.625C13 5.27982 12.7202 5 12.375 5ZM3.625 3.75C2.58947 3.75 1.75 4.58947 1.75 5.625C1.75 6.66053 2.58947 7.5 3.625 7.5H12.375C13.4105 7.5 14.25 6.66053 14.25 5.625C14.25 4.58947 13.4105 3.75 12.375 3.75H3.625Z"
                                                fill="#12131A" />
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
            $homepage_category_title = $homepage_category_btn = '';

            $homepage_category = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_category != '') {
                $homepage_category_value = $theme_json[$homepage_category];

                foreach ($homepage_category_value['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-best-toy-title') {
                        $homepage_category_title = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-best-toy-button') {
                        $homepage_category_btn = $value['field_default_text'];
                    }
                }
            }
        @endphp

        <section class="best-toy-section padding-bottom">
            <div class="container">
                @if ($homepage_category_value['section_enable'] == 'on')
                    <div class="common-title d-flex align-items-center justify-content-between">
                        <div class="section-title">
                            <h2>{!! $homepage_category_title !!}</h2>
                        </div>
                    </div>
                @endif
                <div class="row">
                    {!! \App\Models\MainCategory::HomePageBestCategory($slug, 4) !!}
                </div>
            </div>
        </section>


        <section class="two-col-slider-section padding-bottom">
            <div class="container">
                @php
                    $homepage_slider_title = $homepage_slider_btn = '';

                    $homepage_slider = array_search('homepage-slider-1', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_slider != '') {
                        $homepage_slider_value = $theme_json[$homepage_slider];

                        foreach ($homepage_slider_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-slider-title') {
                                $homepage_slider_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-slider-button') {
                                $homepage_slider_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_slider_value['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <h2>{!! $homepage_slider_title !!}</h2>
                    </div>

                    <div class="row">
                        @php
                            $homepage_slider_banner_img = $homepage_slider_banner_label = $homepage_slider_banner_title = $homepage_slider_banner_sub_text = $homepage_slider_banner_btn = '';

                            $homepage_slider_banner = array_search('homepage-slider-2', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_slider_banner != '') {
                                $homepage_slider_banner_value = $theme_json[$homepage_slider_banner];

                                foreach ($homepage_slider_banner_value['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-slider-bg-image') {
                                        $homepage_slider_banner_img = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-slider-label') {
                                        $homepage_slider_banner_label = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-slider-title') {
                                        $homepage_slider_banner_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-slider-sub-text') {
                                        $homepage_slider_banner_sub_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-slider-button') {
                                        $homepage_slider_banner_btn = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        <div class="col-md-12 col-sm-12 col-lg-6  col-12">
                            <div class="two-colum-img-card">
                                <img src="{{ get_file($homepage_slider_banner_img, APP_THEME()) }}" class="products-card"
                                    alt="image">
                                <div class="label">{!! $homepage_slider_banner_label !!}</div>
                                <div class="two-colum-img-content">
                                    <div class="card-title">
                                        <h3>{!! $homepage_slider_banner_title !!}</h3>
                                        <p>{!! $homepage_slider_banner_sub_text !!}</p>
                                        <a href="{{ route('page.product-list', $slug) }}"
                                            class="btn-secondary white-btn">
                                            {!! $homepage_slider_banner_btn !!}
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.77886 1.38444C2.62144 2.10579 3.18966 3.13838 3.3054 4.30408H4.21204V0.344353C4.35754 0.329906 4.50512 0.32251 4.65443 0.32251C4.80374 0.32251 4.95132 0.329906 5.09683 0.344353V4.30408H6.00346C6.1192 3.13838 6.68742 2.10579 7.53001 1.38444C7.7549 1.57698 7.96024 1.79168 8.14265 2.02517C7.4696 2.58546 7.00769 3.39073 6.89379 4.30408H9.05655C9.071 4.44958 9.07839 4.59716 9.07839 4.74647C9.07839 4.89578 9.071 5.04336 9.05655 5.18887H6.89379C7.00769 6.10222 7.4696 6.90748 8.14265 7.46778C7.96024 7.70127 7.7549 7.91597 7.53001 8.1085C6.68742 7.38715 6.1192 6.35457 6.00346 5.18887H5.09683V9.14859C4.95132 9.16304 4.80374 9.17044 4.65443 9.17044C4.50512 9.17044 4.35754 9.16304 4.21204 9.14859V5.18887H3.3054C3.18966 6.35457 2.62144 7.38715 1.77886 8.1085C1.55397 7.91597 1.34862 7.70127 1.16621 7.46778C1.83926 6.90748 2.30118 6.10222 2.41507 5.18887H0.252312C0.237865 5.04336 0.230469 4.89578 0.230469 4.74647C0.230469 4.59716 0.237865 4.44958 0.252312 4.30408H2.41507C2.30118 3.39073 1.83926 2.58546 1.16621 2.02517C1.34862 1.79168 1.55397 1.57698 1.77886 1.38444Z"
                                                    fill="#12131A"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.65443 8.28564C6.60906 8.28564 8.1936 6.7011 8.1936 4.74647C8.1936 2.79184 6.60906 1.2073 4.65443 1.2073C2.6998 1.2073 1.11526 2.79184 1.11526 4.74647C1.11526 6.7011 2.6998 8.28564 4.65443 8.28564ZM4.65443 9.17044C7.09772 9.17044 9.07839 7.18976 9.07839 4.74647C9.07839 2.30319 7.09772 0.32251 4.65443 0.32251C2.21114 0.32251 0.230469 2.30319 0.230469 4.74647C0.230469 7.18976 2.21114 9.17044 4.65443 9.17044Z"
                                                    fill="#12131A"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
                <div class="col-md-12 col-sm-12 col-lg-6 col-12">
                    <div class="two-colum-slider">
                        @foreach ($products as $product)
                            @php
                                $p_id = hashidsencode($product->id);
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-content-top text-center">
                                        <div class="label">
                                            {{ !empty($product->ProductData()) ? $product->ProductData()->name : '' }}
                                        </div>

                                        <h4><a
                                                href="{{ route('page.product', [$slug, $p_id]) }}">{{ $product->name }}</a>
                                        </h4>
                                    </div>

                                        <div class="favorite-icon">
                                            <a href="javascript:void(0)" class="wishbtn-globaly"
                                                product_id="{{ $product->id }}"
                                                in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: white'></i>
                                            </a>
                                        </div>
                                    <div class="product-img">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                alt="product-img">
                                        </a>
                                    </div>
                                    <div class="product-content-bottom text-center">
                                        <div class="price-label2">
                                            @if ($product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $product->final_price }} <span
                                                            class="currency-type">{{ $currency_icon }}</span></ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif

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
                                                <div class="custom-output">
                                                    <div class="option">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly"
                                            product_id="{{ $product->id }}" variant_id="0" qty="1">
                                            {{ _('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                                viewBox="0 0 16 15" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.22012 7.5C4.02701 7.5 3.88012 7.6734 3.91187 7.86387L4.51047 11.4555C4.61093 12.0582 5.13242 12.5 5.74347 12.5H10.2578C10.8689 12.5 11.3904 12.0582 11.4908 11.4555L12.0894 7.86387C12.1212 7.6734 11.9743 7.5 11.7812 7.5H4.22012ZM3.11344 6.25C2.72722 6.25 2.43345 6.59679 2.49694 6.97775L3.27748 11.661C3.47839 12.8665 4.52137 13.75 5.74347 13.75H10.2578C11.4799 13.75 12.5229 12.8665 12.7238 11.661L13.5044 6.97775C13.5678 6.59679 13.2741 6.25 12.8879 6.25H3.11344Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M6.75 8.75C6.40482 8.75 6.125 9.02982 6.125 9.375V10.625C6.125 10.9702 6.40482 11.25 6.75 11.25C7.09518 11.25 7.375 10.9702 7.375 10.625V9.375C7.375 9.02982 7.09518 8.75 6.75 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M9.25 8.75C8.90482 8.75 8.625 9.02982 8.625 9.375V10.625C8.625 10.9702 8.90482 11.25 9.25 11.25C9.59518 11.25 9.875 10.9702 9.875 10.625V9.375C9.875 9.02982 9.59518 8.75 9.25 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M7.19194 2.31694C7.43602 2.07286 7.43602 1.67714 7.19194 1.43306C6.94786 1.18898 6.55214 1.18898 6.30806 1.43306L3.80806 3.93306C3.56398 4.17714 3.56398 4.57286 3.80806 4.81694C4.05214 5.06102 4.44786 5.06102 4.69194 4.81694L7.19194 2.31694Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M8.80806 2.31694C8.56398 2.07286 8.56398 1.67714 8.80806 1.43306C9.05214 1.18898 9.44786 1.18898 9.69194 1.43306L12.1919 3.93306C12.436 4.17714 12.436 4.57286 12.1919 4.81694C11.9479 5.06102 11.5521 5.06102 11.3081 4.81694L8.80806 2.31694Z"
                                                    fill="#12131A" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.375 5H3.625C3.27982 5 3 5.27982 3 5.625C3 5.97018 3.27982 6.25 3.625 6.25H12.375C12.7202 6.25 13 5.97018 13 5.625C13 5.27982 12.7202 5 12.375 5ZM3.625 3.75C2.58947 3.75 1.75 4.58947 1.75 5.625C1.75 6.66053 2.58947 7.5 3.625 7.5H12.375C13.4105 7.5 14.25 6.66053 14.25 5.625C14.25 4.58947 13.4105 3.75 12.375 3.75H3.625Z"
                                                    fill="#12131A" />
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
    </section>

    @php
        $homepage_customer_banner_img = $homepage_customer_banner_title = $homepage_customer_banner_sub_text = $homepage_customer_banner_btn = '';

        $homepage_customer_banner = array_search('homepage-customer-banner', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_customer_banner != '') {
            $homepage_customer_banner_value = $theme_json[$homepage_customer_banner];

            foreach ($homepage_customer_banner_value['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-customer-banner-bg-image') {
                    $homepage_customer_banner_img = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-customer-banner-title') {
                    $homepage_customer_banner_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-customer-banner-sub-text') {
                    $homepage_customer_banner_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-customer-banner-button') {
                    $homepage_customer_banner_btn = $value['field_default_text'];
                }
            }
        }
    @endphp

    @if ($homepage_customer_banner_value['section_enable'] == 'on')
        <section class="custom-banner-section"
            style="background-image:url('{{ get_file($homepage_customer_banner_img, APP_THEME()) }}');">
            <div class="container">
                <div class="common-title">
                    <div class="section-title">
                        <h2>{!! $homepage_customer_banner_title !!}</h2>
                    </div>
                    <p>{!! $homepage_customer_banner_sub_text !!}</p>
                    <a href="{{ route('page.product-list', $slug) }}" class="btn-secondary white-btn">
                        {!! $homepage_customer_banner_btn !!}
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.77886 1.38444C2.62144 2.10579 3.18966 3.13838 3.3054 4.30408H4.21204V0.344353C4.35754 0.329906 4.50512 0.32251 4.65443 0.32251C4.80374 0.32251 4.95132 0.329906 5.09683 0.344353V4.30408H6.00346C6.1192 3.13838 6.68742 2.10579 7.53001 1.38444C7.7549 1.57698 7.96024 1.79168 8.14265 2.02517C7.4696 2.58546 7.00769 3.39073 6.89379 4.30408H9.05655C9.071 4.44958 9.07839 4.59716 9.07839 4.74647C9.07839 4.89578 9.071 5.04336 9.05655 5.18887H6.89379C7.00769 6.10222 7.4696 6.90748 8.14265 7.46778C7.96024 7.70127 7.7549 7.91597 7.53001 8.1085C6.68742 7.38715 6.1192 6.35457 6.00346 5.18887H5.09683V9.14859C4.95132 9.16304 4.80374 9.17044 4.65443 9.17044C4.50512 9.17044 4.35754 9.16304 4.21204 9.14859V5.18887H3.3054C3.18966 6.35457 2.62144 7.38715 1.77886 8.1085C1.55397 7.91597 1.34862 7.70127 1.16621 7.46778C1.83926 6.90748 2.30118 6.10222 2.41507 5.18887H0.252312C0.237865 5.04336 0.230469 4.89578 0.230469 4.74647C0.230469 4.59716 0.237865 4.44958 0.252312 4.30408H2.41507C2.30118 3.39073 1.83926 2.58546 1.16621 2.02517C1.34862 1.79168 1.55397 1.57698 1.77886 1.38444Z"
                                fill="#12131A"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.65443 8.28564C6.60906 8.28564 8.1936 6.7011 8.1936 4.74647C8.1936 2.79184 6.60906 1.2073 4.65443 1.2073C2.6998 1.2073 1.11526 2.79184 1.11526 4.74647C1.11526 6.7011 2.6998 8.28564 4.65443 8.28564ZM4.65443 9.17044C7.09772 9.17044 9.07839 7.18976 9.07839 4.74647C9.07839 2.30319 7.09772 0.32251 4.65443 0.32251C2.21114 0.32251 0.230469 2.30319 0.230469 4.74647C0.230469 7.18976 2.21114 9.17044 4.65443 9.17044Z"
                                fill="#12131A"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @php
        $homepage_best_toy_title = $homepage_best_toy_btn = '';

        $homepage_best_toy = array_search('homepage-best-toy', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_toy != '') {
            $homepage_best_toy_value = $theme_json[$homepage_best_toy];

            foreach ($homepage_best_toy_value['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-best-toy-title') {
                    $homepage_best_toy_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-best-toy-button') {
                    $homepage_best_toy_btn = $value['field_default_text'];
                }
            }
        }
    @endphp

    <section class="best-seller-section bestseller-second padding-top padding-bottom">
        <div class="container">
            @if ($homepage_best_toy_value['section_enable'] == 'on')
                <div class="common-title d-flex align-items-center justify-content-between">
                    <div class="section-title">
                        <h2>{!! $homepage_best_toy_title !!}</h2>
                    </div>
                </div>
            @endif
            <div class="best-seller-slider">
                @foreach ($all_products as $items)
                    <div class="product-card ">
                        @php
                            $p_id = hashidsencode($items->id);
                            // $wishlist = App\Models\Wishlist::where('product_id',$items->id)->where('theme_id',APP_THEME())->first();
                        @endphp
                        <div class="product-card-inner">
                            <div class="product-content-top text-center">
                                <div class="label">{{ !empty($items->ProductData()) ? $items->ProductData()->name : '' }}
                                </div>
                                <h4><a href="{{ route('page.product', [$slug, $p_id]) }}">{{ $items->name }}</a> </h4>
                                    <div class="favorite-icon">
                                        <a href="javascript:void(0)" class="wishbtn-globaly "
                                            product_id="{{ $items->id }}"
                                            in_wishlist="{{ $items->in_whishlist ? 'remove' : 'add' }}">
                                            <i class="{{ $items->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                style='color: white'></i>

                                        </a>
                                    </div>
                            </div>
                            <div class="product-img">
                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                    <img src="{{ get_file($items->cover_image_path, APP_THEME()) }}" alt="product-img">
                                </a>
                            </div>
                            <div class="product-content-bottom text-center">
                                <div class="price-label2">
                                    @if ($items->variant_product == 0)
                                        <div class="price">
                                            <ins>{{ $items->final_price }} <span
                                                    class="currency-type">{{ $currency_icon }}</span></ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif

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
                                                if (is_array($saleEnableArray) && in_array($items->id, $saleEnableArray)) {
                                                    $latestSales[$items->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <div class="custom-output">
                                            <div class="option">
                                                @if ($saleData['discount_type'] == 'flat')
                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                    -{{ $saleData['discount_amount'] }}%
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly"
                                    product_id="{{ $items->id }}" variant_id="0" qty="1">
                                    {{ __('Add to cart') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                        viewBox="0 0 16 15" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.22012 7.5C4.02701 7.5 3.88012 7.6734 3.91187 7.86387L4.51047 11.4555C4.61093 12.0582 5.13242 12.5 5.74347 12.5H10.2578C10.8689 12.5 11.3904 12.0582 11.4908 11.4555L12.0894 7.86387C12.1212 7.6734 11.9743 7.5 11.7812 7.5H4.22012ZM3.11344 6.25C2.72722 6.25 2.43345 6.59679 2.49694 6.97775L3.27748 11.661C3.47839 12.8665 4.52137 13.75 5.74347 13.75H10.2578C11.4799 13.75 12.5229 12.8665 12.7238 11.661L13.5044 6.97775C13.5678 6.59679 13.2741 6.25 12.8879 6.25H3.11344Z"
                                            fill="#12131A" />
                                        <path
                                            d="M6.75 8.75C6.40482 8.75 6.125 9.02982 6.125 9.375V10.625C6.125 10.9702 6.40482 11.25 6.75 11.25C7.09518 11.25 7.375 10.9702 7.375 10.625V9.375C7.375 9.02982 7.09518 8.75 6.75 8.75Z"
                                            fill="#12131A" />
                                        <path
                                            d="M9.25 8.75C8.90482 8.75 8.625 9.02982 8.625 9.375V10.625C8.625 10.9702 8.90482 11.25 9.25 11.25C9.59518 11.25 9.875 10.9702 9.875 10.625V9.375C9.875 9.02982 9.59518 8.75 9.25 8.75Z"
                                            fill="#12131A" />
                                        <path
                                            d="M7.19194 2.31694C7.43602 2.07286 7.43602 1.67714 7.19194 1.43306C6.94786 1.18898 6.55214 1.18898 6.30806 1.43306L3.80806 3.93306C3.56398 4.17714 3.56398 4.57286 3.80806 4.81694C4.05214 5.06102 4.44786 5.06102 4.69194 4.81694L7.19194 2.31694Z"
                                            fill="#12131A" />
                                        <path
                                            d="M8.80806 2.31694C8.56398 2.07286 8.56398 1.67714 8.80806 1.43306C9.05214 1.18898 9.44786 1.18898 9.69194 1.43306L12.1919 3.93306C12.436 4.17714 12.436 4.57286 12.1919 4.81694C11.9479 5.06102 11.5521 5.06102 11.3081 4.81694L8.80806 2.31694Z"
                                            fill="#12131A" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.375 5H3.625C3.27982 5 3 5.27982 3 5.625C3 5.97018 3.27982 6.25 3.625 6.25H12.375C12.7202 6.25 13 5.97018 13 5.625C13 5.27982 12.7202 5 12.375 5ZM3.625 3.75C2.58947 3.75 1.75 4.58947 1.75 5.625C1.75 6.66053 2.58947 7.5 3.625 7.5H12.375C13.4105 7.5 14.25 6.66053 14.25 5.625C14.25 4.58947 13.4105 3.75 12.375 3.75H3.625Z"
                                            fill="#12131A" />
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
        $homepage_custom_banner_img = $homepage_custom_banner_label = $homepage_custom_banner_title = $homepage_custom_banner_sub_text = $homepage_custom_banner_text = '';

        $homepage_custom_banner = array_search('homepage-custom-banner', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_custom_banner != '') {
            $homepage_custom_banner_value = $theme_json[$homepage_custom_banner];

            foreach ($homepage_custom_banner_value['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-custom-banner-bg-image') {
                    $homepage_custom_banner_img = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-custom-banner-label') {
                    $homepage_custom_banner_label = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-custom-banner-title') {
                    $homepage_custom_banner_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-custom-banner-sub-text') {
                    $homepage_custom_banner_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-custom-banner-text') {
                    $homepage_custom_banner_text = $value['field_default_text'];
                }
            }
        }
    @endphp

    <section class="custom-banner-section-two padding-bottom">
        @if ($homepage_custom_banner_value['section_enable'] == 'on')
            <div class="container">
                <div class="custom-banner-two"
                    style="background-image:url('{{ get_file($homepage_custom_banner_img, APP_THEME()) }}');">
                    <div class="custom-banner-inner">
                        <div class="label">{!! $homepage_custom_banner_label !!}</div>
                        <h2>{!! $homepage_custom_banner_title !!}</h2>
                        <p>{!! $homepage_custom_banner_sub_text !!}</p>
                        <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}"
                            method="post">
                            @csrf
                            <div class="input-box">
                                <input type="email" placeholder="Type your address email......" name="email">
                                <button class="btn-subscibe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                        viewBox="0 0 17 17" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.6883 2.12059C14.0686 1.54545 15.4534 2.93023 14.8782 4.31056L10.9102 13.8338C10.1342 15.6962 7.40464 15.3814 7.07295 13.3912L6.5779 10.4209L3.60764 9.92589C1.61746 9.5942 1.30266 6.8646 3.16509 6.08859L12.6883 2.12059ZM13.6416 3.79527C13.7566 3.51921 13.4796 3.24225 13.2036 3.35728L3.68037 7.32528C3.05956 7.58395 3.1645 8.49381 3.82789 8.60438L6.79816 9.09942C7.36282 9.19353 7.80531 9.63602 7.89942 10.2007L8.39446 13.171C8.50503 13.8343 9.41489 13.9393 9.67356 13.3185L13.6416 3.79527Z"
                                            fill="#12131A" />
                                    </svg>
                                </button>
                            </div>
                            <div class="checkbox">
                                {{-- <input type="checkbox" id="footercheck" name="footercheck"> --}}
                                <label for="footercheck">
                                    {!! $homepage_custom_banner_text !!}
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </section>


    <section class="two-colum-banner-section padding-top padding-bottom">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/left-img.png') }}" class="left-img">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/center.png') }}" class="center-img">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/left-img.png') }}" class="right-img">
        <div class="container">
            <div class="row align-items-center">
                @php
                    $homepage_banner_section2_label = $homepage_banner_section2_title = $homepage_banner_section2_sub_text = $homepage_banner_section2_btn = '';

                    $homepage_banner_section2 = array_search('homepage-banner-section', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_banner_section2 != '') {
                        $homepage_banner_section2_value = $theme_json[$homepage_banner_section2];

                        foreach ($homepage_banner_section2_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-banner-section-label') {
                                $homepage_banner_section2_label = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-section-title') {
                                $homepage_banner_section2_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-section-sub-text') {
                                $homepage_banner_section2_sub_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-section-button') {
                                $homepage_banner_section2_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp

                <div class="col-lg-6 col-md-4 col-12">
                    @if ($homepage_banner_section2_value['section_enable'] == 'on')
                        <div class="two-colum-inner">
                            <div class="label">{!! $homepage_banner_section2_label !!}</div>
                            <h2>{!! $homepage_banner_section2_title !!}</h2>
                            <p>{!! $homepage_banner_section2_sub_text !!}</p>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                {!! $homepage_banner_section2_btn !!}
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.77886 1.38444C2.62144 2.10579 3.18966 3.13838 3.3054 4.30408H4.21204V0.344353C4.35754 0.329906 4.50512 0.32251 4.65443 0.32251C4.80374 0.32251 4.95132 0.329906 5.09683 0.344353V4.30408H6.00346C6.1192 3.13838 6.68742 2.10579 7.53001 1.38444C7.7549 1.57698 7.96024 1.79168 8.14265 2.02517C7.4696 2.58546 7.00769 3.39073 6.89379 4.30408H9.05655C9.071 4.44958 9.07839 4.59716 9.07839 4.74647C9.07839 4.89578 9.071 5.04336 9.05655 5.18887H6.89379C7.00769 6.10222 7.4696 6.90748 8.14265 7.46778C7.96024 7.70127 7.7549 7.91597 7.53001 8.1085C6.68742 7.38715 6.1192 6.35457 6.00346 5.18887H5.09683V9.14859C4.95132 9.16304 4.80374 9.17044 4.65443 9.17044C4.50512 9.17044 4.35754 9.16304 4.21204 9.14859V5.18887H3.3054C3.18966 6.35457 2.62144 7.38715 1.77886 8.1085C1.55397 7.91597 1.34862 7.70127 1.16621 7.46778C1.83926 6.90748 2.30118 6.10222 2.41507 5.18887H0.252312C0.237865 5.04336 0.230469 4.89578 0.230469 4.74647C0.230469 4.59716 0.237865 4.44958 0.252312 4.30408H2.41507C2.30118 3.39073 1.83926 2.58546 1.16621 2.02517C1.34862 1.79168 1.55397 1.57698 1.77886 1.38444Z"
                                        fill="#12131A"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.65443 8.28564C6.60906 8.28564 8.1936 6.7011 8.1936 4.74647C8.1936 2.79184 6.60906 1.2073 4.65443 1.2073C2.6998 1.2073 1.11526 2.79184 1.11526 4.74647C1.11526 6.7011 2.6998 8.28564 4.65443 8.28564ZM4.65443 9.17044C7.09772 9.17044 9.07839 7.18976 9.07839 4.74647C9.07839 2.30319 7.09772 0.32251 4.65443 0.32251C2.21114 0.32251 0.230469 2.30319 0.230469 4.74647C0.230469 7.18976 2.21114 9.17044 4.65443 9.17044Z"
                                        fill="#12131A"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="two-colum-slider">
                        @foreach ($modern_products as $m_product)
                            @php
                                $p_id = hashidsencode($m_product->id);
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-content-top text-center">
                                        <div class="label">
                                            {{ !empty($m_product->ProductData()) ? $m_product->ProductData()->name : '' }}
                                        </div>
                                        <h4><a
                                                href="{{ route('page.product', [$slug, $p_id]) }}">{{ $m_product->name }}</a>
                                        </h4>
                                    </div>
                                        <div class="favorite-icon">
                                            <a href="javascript:void(0)" class="wishbtn-globaly"
                                                product_id="{{ $m_product->id }}"
                                                in_wishlist="{{ $m_product->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $m_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: white'></i>
                                            </a>
                                        </div>

                                    <div class="product-img">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($m_product->cover_image_path, APP_THEME()) }}"
                                                alt="product-img">
                                        </a>
                                    </div>
                                    <div class="product-content-bottom text-center">
                                        <div class="price-label2">
                                            @if ($m_product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $m_product->final_price }} <span
                                                            class="currency-type">{{ $currency_icon }}</span></ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
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
                                                            if (is_array($saleEnableArray) && in_array($m_product->id, $saleEnableArray)) {
                                                                $latestSales[$m_product->id] = [
                                                                    'discount_type' => $flashsale->discount_type,
                                                                    'discount_amount' => $flashsale->discount_amount,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach ($latestSales as $productId => $saleData)
                                                <div class="custom-output">
                                                    <div class="option">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                        </div>
                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly"
                                            product_id="{{ $m_product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                                viewBox="0 0 16 15" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.22012 7.5C4.02701 7.5 3.88012 7.6734 3.91187 7.86387L4.51047 11.4555C4.61093 12.0582 5.13242 12.5 5.74347 12.5H10.2578C10.8689 12.5 11.3904 12.0582 11.4908 11.4555L12.0894 7.86387C12.1212 7.6734 11.9743 7.5 11.7812 7.5H4.22012ZM3.11344 6.25C2.72722 6.25 2.43345 6.59679 2.49694 6.97775L3.27748 11.661C3.47839 12.8665 4.52137 13.75 5.74347 13.75H10.2578C11.4799 13.75 12.5229 12.8665 12.7238 11.661L13.5044 6.97775C13.5678 6.59679 13.2741 6.25 12.8879 6.25H3.11344Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M6.75 8.75C6.40482 8.75 6.125 9.02982 6.125 9.375V10.625C6.125 10.9702 6.40482 11.25 6.75 11.25C7.09518 11.25 7.375 10.9702 7.375 10.625V9.375C7.375 9.02982 7.09518 8.75 6.75 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M9.25 8.75C8.90482 8.75 8.625 9.02982 8.625 9.375V10.625C8.625 10.9702 8.90482 11.25 9.25 11.25C9.59518 11.25 9.875 10.9702 9.875 10.625V9.375C9.875 9.02982 9.59518 8.75 9.25 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M7.19194 2.31694C7.43602 2.07286 7.43602 1.67714 7.19194 1.43306C6.94786 1.18898 6.55214 1.18898 6.30806 1.43306L3.80806 3.93306C3.56398 4.17714 3.56398 4.57286 3.80806 4.81694C4.05214 5.06102 4.44786 5.06102 4.69194 4.81694L7.19194 2.31694Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M8.80806 2.31694C8.56398 2.07286 8.56398 1.67714 8.80806 1.43306C9.05214 1.18898 9.44786 1.18898 9.69194 1.43306L12.1919 3.93306C12.436 4.17714 12.436 4.57286 12.1919 4.81694C11.9479 5.06102 11.5521 5.06102 11.3081 4.81694L8.80806 2.31694Z"
                                                    fill="#12131A" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.375 5H3.625C3.27982 5 3 5.27982 3 5.625C3 5.97018 3.27982 6.25 3.625 6.25H12.375C12.7202 6.25 13 5.97018 13 5.625C13 5.27982 12.7202 5 12.375 5ZM3.625 3.75C2.58947 3.75 1.75 4.58947 1.75 5.625C1.75 6.66053 2.58947 7.5 3.625 7.5H12.375C13.4105 7.5 14.25 6.66053 14.25 5.625C14.25 4.58947 13.4105 3.75 12.375 3.75H3.625Z"
                                                    fill="#12131A" />
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
    </section>
    <section class="two-col-slider-two-section padding-top">
        <div class="container">
            @php
                $homepage_best_slider_title = $homepage_best_slider_btn = '';
                $homepage_best_slider = array_search('homepage-banner-slider-1', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_best_slider != '') {
                    $homepage_best_slider_value = $theme_json[$homepage_best_slider];

                    foreach ($homepage_best_slider_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-banner-slider-title') {
                            $homepage_best_slider_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-slider-button') {
                            $homepage_best_slider_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_best_slider_value['section_enable'] == 'on')
                <div class="common-title d-flex align-items-center justify-content-between">
                    <div class="section-title">
                        <h2>{!! $homepage_best_slider_title !!}</h2>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-6 col-12 order">
                    <div class="two-colum-slider">
                        @foreach ($home_products as $new_product)
                            @php
                                $p_id = hashidsencode($new_product->id);
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-content-top text-center">
                                        <div class="label">
                                            {{ !empty($new_product->ProductData()) ? $new_product->ProductData()->name : '' }}
                                        </div>
                                        <h4><a
                                                href="{{ route('page.product', [$slug, $p_id]) }}">{{ $new_product->name }}</a>
                                        </h4>
                                    </div>
                                        <div class="favorite-icon">
                                            <a href="javascript:void(0)" class="wishbtn-globaly"
                                                product_id="{{ $new_product->id }}"
                                                in_wishlist="{{ $new_product->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $new_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: white'></i>
                                            </a>
                                        </div>
                                    <div class="product-img">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($new_product->cover_image_path, APP_THEME()) }}"
                                                alt="product-img">
                                        </a>
                                    </div>
                                    <div class="product-content-bottom text-center">
                                        <div class="price-label2">
                                            @if ($new_product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $new_product->final_price }} <span
                                                            class="currency-type">{{ $currency_icon }}</span></ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif

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
                                                        if (is_array($saleEnableArray) && in_array($new_product->id, $saleEnableArray)) {
                                                            $latestSales[$new_product->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <div class="custom-output">
                                                    <div class="option">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly"
                                            product_id="{{ $new_product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                                viewBox="0 0 16 15" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.22012 7.5C4.02701 7.5 3.88012 7.6734 3.91187 7.86387L4.51047 11.4555C4.61093 12.0582 5.13242 12.5 5.74347 12.5H10.2578C10.8689 12.5 11.3904 12.0582 11.4908 11.4555L12.0894 7.86387C12.1212 7.6734 11.9743 7.5 11.7812 7.5H4.22012ZM3.11344 6.25C2.72722 6.25 2.43345 6.59679 2.49694 6.97775L3.27748 11.661C3.47839 12.8665 4.52137 13.75 5.74347 13.75H10.2578C11.4799 13.75 12.5229 12.8665 12.7238 11.661L13.5044 6.97775C13.5678 6.59679 13.2741 6.25 12.8879 6.25H3.11344Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M6.75 8.75C6.40482 8.75 6.125 9.02982 6.125 9.375V10.625C6.125 10.9702 6.40482 11.25 6.75 11.25C7.09518 11.25 7.375 10.9702 7.375 10.625V9.375C7.375 9.02982 7.09518 8.75 6.75 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M9.25 8.75C8.90482 8.75 8.625 9.02982 8.625 9.375V10.625C8.625 10.9702 8.90482 11.25 9.25 11.25C9.59518 11.25 9.875 10.9702 9.875 10.625V9.375C9.875 9.02982 9.59518 8.75 9.25 8.75Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M7.19194 2.31694C7.43602 2.07286 7.43602 1.67714 7.19194 1.43306C6.94786 1.18898 6.55214 1.18898 6.30806 1.43306L3.80806 3.93306C3.56398 4.17714 3.56398 4.57286 3.80806 4.81694C4.05214 5.06102 4.44786 5.06102 4.69194 4.81694L7.19194 2.31694Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M8.80806 2.31694C8.56398 2.07286 8.56398 1.67714 8.80806 1.43306C9.05214 1.18898 9.44786 1.18898 9.69194 1.43306L12.1919 3.93306C12.436 4.17714 12.436 4.57286 12.1919 4.81694C11.9479 5.06102 11.5521 5.06102 11.3081 4.81694L8.80806 2.31694Z"
                                                    fill="#12131A" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.375 5H3.625C3.27982 5 3 5.27982 3 5.625C3 5.97018 3.27982 6.25 3.625 6.25H12.375C12.7202 6.25 13 5.97018 13 5.625C13 5.27982 12.7202 5 12.375 5ZM3.625 3.75C2.58947 3.75 1.75 4.58947 1.75 5.625C1.75 6.66053 2.58947 7.5 3.625 7.5H12.375C13.4105 7.5 14.25 6.66053 14.25 5.625C14.25 4.58947 13.4105 3.75 12.375 3.75H3.625Z"
                                                    fill="#12131A" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @php
                    $homepage_best_slider2_img = $homepage_best_slider2_label = $homepage_best_slider2_title = $homepage_best_slider2_sub_text = $homepage_best_slider2_btn = '';

                    $homepage_best_slider2 = array_search('homepage-banner-slider-2', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_best_slider2 != '') {
                        $homepage_best_slider2_value = $theme_json[$homepage_best_slider2];

                        foreach ($homepage_best_slider2_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-banner-slider-bg-image') {
                                $homepage_best_slider2_img = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-slider-label') {
                                $homepage_best_slider2_label = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-slider-title') {
                                $homepage_best_slider2_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-slider-sub-text') {
                                $homepage_best_slider2_sub_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-slider-button') {
                                $homepage_best_slider2_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp

                <div class="col-md-12 col-sm-12 col-lg-6 col-12">
                    @if ($homepage_best_slider_value['section_enable'] == 'on')
                        <div class="two-colum-img-card">
                            <img src="{{ get_file($homepage_best_slider2_img, APP_THEME()) }}" class="products-card"
                                alt="image">
                            <div class="label">{!! $homepage_best_slider2_label !!}</div>
                            <div class="two-colum-img-content">
                                <div class="card-title">
                                    <h3>{!! $homepage_best_slider2_title !!}</h3>
                                    <p>{!! $homepage_best_slider2_sub_text !!}</p>
                                    <a href="{{ route('page.product-list', $slug) }}" class="btn theme-btn">
                                        {!! $homepage_best_slider2_btn !!}
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.77886 1.38444C2.62144 2.10579 3.18966 3.13838 3.3054 4.30408H4.21204V0.344353C4.35754 0.329906 4.50512 0.32251 4.65443 0.32251C4.80374 0.32251 4.95132 0.329906 5.09683 0.344353V4.30408H6.00346C6.1192 3.13838 6.68742 2.10579 7.53001 1.38444C7.7549 1.57698 7.96024 1.79168 8.14265 2.02517C7.4696 2.58546 7.00769 3.39073 6.89379 4.30408H9.05655C9.071 4.44958 9.07839 4.59716 9.07839 4.74647C9.07839 4.89578 9.071 5.04336 9.05655 5.18887H6.89379C7.00769 6.10222 7.4696 6.90748 8.14265 7.46778C7.96024 7.70127 7.7549 7.91597 7.53001 8.1085C6.68742 7.38715 6.1192 6.35457 6.00346 5.18887H5.09683V9.14859C4.95132 9.16304 4.80374 9.17044 4.65443 9.17044C4.50512 9.17044 4.35754 9.16304 4.21204 9.14859V5.18887H3.3054C3.18966 6.35457 2.62144 7.38715 1.77886 8.1085C1.55397 7.91597 1.34862 7.70127 1.16621 7.46778C1.83926 6.90748 2.30118 6.10222 2.41507 5.18887H0.252312C0.237865 5.04336 0.230469 4.89578 0.230469 4.74647C0.230469 4.59716 0.237865 4.44958 0.252312 4.30408H2.41507C2.30118 3.39073 1.83926 2.58546 1.16621 2.02517C1.34862 1.79168 1.55397 1.57698 1.77886 1.38444Z"
                                                fill="#12131A"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.65443 8.28564C6.60906 8.28564 8.1936 6.7011 8.1936 4.74647C8.1936 2.79184 6.60906 1.2073 4.65443 1.2073C2.6998 1.2073 1.11526 2.79184 1.11526 4.74647C1.11526 6.7011 2.6998 8.28564 4.65443 8.28564ZM4.65443 9.17044C7.09772 9.17044 9.07839 7.18976 9.07839 4.74647C9.07839 2.30319 7.09772 0.32251 4.65443 0.32251C2.21114 0.32251 0.230469 2.30319 0.230469 4.74647C0.230469 7.18976 2.21114 9.17044 4.65443 9.17044Z"
                                                fill="#12131A"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="testimonial-section padding-top ">
        <div class="container">
            @php
                $homepage_testimonial_title = $homepage_testimonial_btn = '';

                $homepage_testimonial = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_testimonial != '') {
                    $homepage_testimonial_value = $theme_json[$homepage_testimonial];

                    foreach ($homepage_testimonial_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-testimonial-title') {
                            $homepage_testimonial_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-testimonial-button') {
                            $homepage_testimonial_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_testimonial_value['section_enable'] == 'on')
                <div class="common-title d-flex align-items-center justify-content-between">
                    <div class="section-title">
                        <h2>{!! $homepage_testimonial_title !!}</h2>
                    </div>
                </div>
            @endif
            <div class="testimonial-slider flex-slider">
                @foreach ($reviews as $review)
                    <div class="testimonial-itm">
                        <div class="testimonial-inner card-inner">
                            <div class="testimonial-img">
                                <a href="#">
                                    <img
                                        src="{{ asset('/' . !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path, APP_THEME()) : '') }}">
                                </a>
                            </div>
                            <div class="testimonial-right">
                                <div class="star">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                    @endfor
                                </div>
                                <div class="bottom-content">
                                    <h5>{{ $review->title }}</h5>
                                    <p>{{ $review->description }}</p>
                                    <p>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>

    <section class="blog-section-home padding-top">
        <div class="container">
            @php
                $homepage_blog_title = $homepage_blog_btn = '';

                $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_blog != '') {
                    $homepage_blog_value = $theme_json[$homepage_blog];

                    foreach ($homepage_blog_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-title') {
                            $homepage_blog_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-button') {
                            $homepage_blog_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_blog_value['section_enable'] == 'on')
                <div class="common-title d-flex align-items-center justify-content-between">
                    <div class="section-title">
                        <h2>{!! $homepage_blog_title !!}</h2>
                    </div>
                </div>
            @endif
            {!! \App\Models\Blog::HomePageBlog($slug, 10) !!}

        </div>
    </section>

    </div>
@endsection

