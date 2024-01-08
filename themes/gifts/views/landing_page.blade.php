@extends('layouts.layouts')

@section('page-title')
    {{ __('Gifty') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

    <!-- -------- WRAPPER-SECTION-START --------- -->
    <div class="wrapper">

        <section class="home-banner-section padding-top padding-bottom">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/img/home-banner-ptrn.png') }}" class="home-banner-bg"
                alt="">

            <div class="offset-container offset-left">
                <div class="home-banner-slider">
                    @php
                        $homepage_text = '';
                        $homepage_banner_key3 = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                        $section_enable = 'on';
                        if ($homepage_banner_key3 != '') {
                            $homepage_main_logo = $theme_json[$homepage_banner_key3];
                            $section_enable = $homepage_main_logo['section_enable'];
                        }
                    @endphp
                    @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                        @php
                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-label') {
                                    $homepage_banner_text = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-title') {
                                    $homepage_banner_title = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-sub-text') {
                                    $homepage_banner_sub_text = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-btn-text') {
                                    $homepage_banner_btn = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_btn = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-vedio-icon') {
                                    $homepage_banner_vid_btn = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_vid_btn = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-vedio-label') {
                                    $homepage_banner_vid_label = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_vid_label = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-banner-img') {
                                    $homepage_banner_img = $homepage_main_logo_value['field_default_text'];
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        $homepage_banner_img = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            }
                        @endphp
                        <div class="banner-itm">
                            <div class="banner-itm-inner">
                                <div class="row col-reverse no-gutters align-items-center">
                                    <div class="col-md-6 col-12">
                                        <div class="banner-left-col">
                                            <div class="section-title">
                                                <div class="subtitle">{{ $homepage_banner_text }}</div>
                                                <h2>
                                                    {!! $homepage_banner_title !!}
                                                </h2>
                                            </div>
                                            <p>{{ $homepage_banner_sub_text }}</p>
                                            <div class="button-wrappper d-flex">
                                                <a href="{{ route('page.product-list', $slug) }}" class="btn"
                                                    tabindex="0">
                                                    {{ $homepage_banner_btn }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14"
                                                        viewBox="0 0 17 14" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13.4504 8.90368H6.43855C5.48981 8.90395 4.67569 8.22782 4.50176 7.29517L3.58917 2.35144C3.53142 2.03558 3.25368 1.80784 2.93263 1.81308H1.40947C1.04687 1.81308 0.75293 1.51913 0.75293 1.15654C0.75293 0.793942 1.04687 0.5 1.40947 0.5H2.94577C3.8945 0.499732 4.70862 1.17586 4.88255 2.10852L5.79514 7.05225C5.85289 7.3681 6.13063 7.59584 6.45168 7.59061H13.4569C13.778 7.59584 14.0557 7.3681 14.1135 7.05225L14.9407 2.58779C14.9761 2.3943 14.923 2.19512 14.7958 2.04506C14.6686 1.89499 14.4808 1.80986 14.2842 1.81308H6.66177C6.29917 1.81308 6.00523 1.51913 6.00523 1.15654C6.00523 0.793942 6.29917 0.5 6.66177 0.5H14.2776C14.8633 0.499835 15.4187 0.760337 15.793 1.2108C16.1673 1.66126 16.3218 2.25494 16.2144 2.83071L15.3872 7.29517C15.2132 8.22782 14.3991 8.90395 13.4504 8.90368ZM9.28827 11.5304C9.28827 10.4426 8.40644 9.56081 7.31866 9.56081C6.95606 9.56081 6.66212 9.85475 6.66212 10.2173C6.66212 10.5799 6.95606 10.8739 7.31866 10.8739C7.68125 10.8739 7.97519 11.1678 7.97519 11.5304C7.97519 11.893 7.68125 12.187 7.31866 12.187C6.95606 12.187 6.66212 11.893 6.66212 11.5304C6.66212 11.1678 6.36818 10.8739 6.00558 10.8739C5.64299 10.8739 5.34904 11.1678 5.34904 11.5304C5.34904 12.6182 6.23087 13.5 7.31866 13.5C8.40644 13.5 9.28827 12.6182 9.28827 11.5304ZM13.2277 12.8432C13.2277 12.4806 12.9338 12.1867 12.5712 12.1867C12.2086 12.1867 11.9146 11.8928 11.9146 11.5302C11.9146 11.1676 12.2086 10.8736 12.5712 10.8736C12.9338 10.8736 13.2277 11.1676 13.2277 11.5302C13.2277 11.8928 13.5217 12.1867 13.8843 12.1867C14.2468 12.1867 14.5408 11.8928 14.5408 11.5302C14.5408 10.4424 13.659 9.56055 12.5712 9.56055C11.4834 9.56055 10.6016 10.4424 10.6016 11.5302C10.6016 12.6179 11.4834 13.4998 12.5712 13.4998C12.9338 13.4998 13.2277 13.2058 13.2277 12.8432Z"
                                                            fill="#0A062D"></path>
                                                    </svg>
                                                </a>
                                                <a href="javascript:void()" class="play-btn">
                                                    <img src="{{ get_file($homepage_banner_vid_btn, APP_THEME()) }}"
                                                        alt="">
                                                    {{ $homepage_banner_vid_label }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="banner-right-col">
                                            <div class="hero-main-img">
                                                <img src="{{ get_file($homepage_banner_img, APP_THEME()) }}"
                                                    class="img-fluid" alt="HeroImage-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="slider-navgation">
                    <div class="slider-nav"></div>
                    <span class="pagingInfo"></span>
                    <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50">
                        <span class="slider__label sr-only">50% completed</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="category-section padding-bottom">
            <div class="container">
                <div class="category-bg">
                    @php
                        $homepage_header_1_key = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-category-title-text') {
                                    $cat_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-btn-text') {
                                    $cat_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <div class="section-title-left">
                                <h2>{!! $cat_title !!}</h2>
                            </div>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                                {{ $cat_btn }}
                            </a>
                        </div>
                    @endif
                    <div class="row">
                        {!! \App\Models\MainCategory::HomePageCategory($slug, 4) !!}

                    </div>
                </div>
            </div>
        </section>


        <section class="partner-logo-section padding-bottom">
            <div class="container">
                <div class="partner-itm-inner">
                    <div class="partner-slider">
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
                                <div class="partner-itm">
                                    <a href="#">
                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
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
                                <div class="partner-itm">
                                    <a href="#">
                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
                                    </a>
                                </div>
                            @endfor
                        @endif

                    </div>
                </div>
            </div>
        </section>


        <section class="bestseller-section padding-bottom">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-products-title-text') {
                                    $feature_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-feature-products-btn-text') {
                                    $feature_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title-left">
                            <h2>{!! $feature_title !!}</h2>
                        </div>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                            {{ $feature_btn }}
                        </a>
                    @endif
                </div>
                <div class="bestseller-slider flex-slider">
                    @foreach ($bestSeller as $bestSellers)
                        @php
                            $p_id = hashidsencode($bestSellers->id);
                        @endphp
                        <div class="bestseller-card-itm product-card">
                            <div class="bestseller-card-inner">
                                <div class="bestseller-img">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($bestSellers->cover_image_path, APP_THEME()) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="bestseller-content">
                                    <div class="bestseller-top">
                                        <div class="bestseller-card-heading">
                                            <span>{{ $bestSellers->tag_api }}</span>
                                                <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                                    product_id="{{ $bestSellers->id }}"
                                                    in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add' }}">
                                                    {{ __('Add to wishlist') }}
                                                    <span class="wish-ic">
                                                        <i
                                                            class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </span>
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
                                                <div class="badge">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <h3>
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}" class="description">
                                                {!! $bestSellers->name !!}
                                            </a>
                                        </h3>
                                        </a>
                                        <p class="descriptions">{{ $bestSellers->description }}</p>
                                    </div>
                                    <div class="bestseller-bottom">
                                        @if ($bestSellers->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $bestSellers->final_price }}</ins>
                                                <span>{{ $currency }}</span>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif

                                        <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit"
                                            product_id="{{ $bestSellers->id }}" variant_id="0" qty="1">
                                            {{ __('Add to Cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                height="16" viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                    fill="#0A062D"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                    fill="#0A062D"></path>
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


        <section class="review-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-review', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-review-title-text') {
                                $review_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-review-sub-text') {
                                $review_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-review-img') {
                                $cat_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="row align-items-center">
                        <div class="col-md-6 col-12">
                            <div class="left-review-wrapper">
                                <div class="section-title">
                                    <h2>{!! $review_title !!}</h2>
                                </div>
                                <p>{{ $review_text }}</p>
                                <div class="reiview-slider flex-slider">
                                    @foreach ($random_review as $review)
                                        {{-- @dd($reviews) --}}
                                        <div class="review-itm">
                                            <div class="review-inner">
                                                <div class="review-img">
                                                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/img/review2.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="review-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="cauma" width="13"
                                                        height="10" viewBox="0 0 13 10" fill="none">
                                                        <path
                                                            d="M6.01356 1.12356L3.97535 4.8505L2.691 5.20675C2.83991 4.93271 3.00743 4.71348 3.19357 4.54906C3.37971 4.36636 3.59377 4.27502 3.83575 4.27502C4.37555 4.27502 4.85951 4.49425 5.28763 4.93271C5.73436 5.35291 5.95772 5.90099 5.95772 6.57695C5.95772 7.28945 5.70644 7.90148 5.20386 8.41302C4.7199 8.92456 4.11496 9.18033 3.38902 9.18033C2.70031 9.18033 2.09536 8.93369 1.57417 8.44042C1.0716 7.92888 0.820312 7.30772 0.820312 6.57695C0.820312 6.28464 0.876154 5.94666 0.987837 5.563C1.11813 5.17935 1.35081 4.67694 1.68585 4.05579L3.91951 0L6.01356 1.12356ZM12.2957 1.12356L10.2575 4.8505L9.00108 5.20675C9.13138 4.93271 9.28959 4.71348 9.47573 4.54906C9.68048 4.36636 9.89454 4.27502 10.1179 4.27502C10.6577 4.27502 11.151 4.49425 11.5977 4.93271C12.0444 5.35291 12.2678 5.90099 12.2678 6.57695C12.2678 7.28945 12.0165 7.90148 11.5139 8.41302C11.03 8.92456 10.425 9.18033 9.6991 9.18033C9.01039 9.18033 8.40544 8.93369 7.88425 8.44042C7.38168 7.92888 7.13039 7.30772 7.13039 6.57695C7.13039 6.28464 7.18623 5.94666 7.29792 5.563C7.4096 5.17935 7.63296 4.67694 7.96801 4.05579L10.2296 0L12.2957 1.12356Z"
                                                            fill="#5FFFCA"></path>
                                                    </svg>
                                                    <h3 class="description">{{ $review->description }}</h3>
                                                    <span><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</b>
                                                        Client</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="right-review-wrapper">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/img/review-main.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>


        <section class="offer-bestseller-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $best_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                $best_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <div class="section-title-left">
                            <h2>
                                {{ $best_title }}
                            </h2>
                        </div>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                            {{ $best_btn }}
                        </a>
                    </div>
                @endif
                <div class="row">
                    @foreach ($homepage_products as $homepage_product)
                        <div class="col-md-6 col-12 offer-bestseller-card">
                            @php
                                $p_id = hashidsencode($homepage_product->id);
                            @endphp
                            <div class="bestseller-card-itm ">
                                <div class="bestseller-card-inner">
                                    <div class="bestseller-content">
                                        <div class="bestseller-top">
                                            <div class="bestseller-card-heading">
                                                <span>{{ $homepage_product->tag_api }}</span>
                                                    <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                                        product_id="{{ $homepage_product->id }}"
                                                        in_wishlist="{{ $homepage_product->in_whishlist ? 'remove' : 'add' }}">
                                                        {{ __('Add to wishlist') }}
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $homepage_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
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
                                                    <div class="badge">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <h3 class="description">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    {!! $homepage_product->name !!}
                                                </a>
                                            </h3>
                                            </a>
                                            <p class="descriptions">{!! $homepage_product->description !!}</p>
                                        </div>
                                        <div class="bestseller-bottom">
                                            @if ($homepage_product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $homepage_product->final_price }}</ins>
                                                    <span>{{ $currency }}</span>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="btn addcart-btn-globaly"
                                                product_id="{{ $homepage_product->id }}" variant_id="0" qty="1">
                                                {{ __('Add to cart') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                    height="16" viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                        fill="#0A062D"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                        fill="#0A062D"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="bestseller-img">
                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                            <img src="{{ get_file($homepage_product->cover_image_path, APP_THEME()) }}"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <section class="add-banner-section padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @php
                            $homepage_header_1_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-banner-2-label') {
                                        $banner_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-2-title-text') {
                                        $banner_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-2-sub-text') {
                                        $banner_sub_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-2-btn-text') {
                                        $banner_btn = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-banner-2-bg-img') {
                                        $banner_img = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <div class="add-banner">
                                <img src="{{ get_file($banner_img, APP_THEME()) }}" class="add-bnr">
                                <div class="add-banner-column">
                                    <div class="section-title">
                                        <div class="subtitle">{{ $banner_title }}</div>
                                        <h3>{!! $banner_text !!}</h3>
                                    </div>
                                    <p>{{ $banner_sub_text }}</p>
                                    <div class="add-banner-section-btn">
                                        <a href="#" class="btn-secondary" tabindex="0">
                                            {{ $banner_btn }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                height="16" viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                    fill="#0A062D"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                    fill="#0A062D"></path>
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


        <section class="three-col-category-section padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12 add-banner-card">
                        @php
                            $homepage_header_1_key = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-card-title-text') {
                                        $cart_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-card-sub-text') {
                                        $cart_sub_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-card-btn-text') {
                                        $cart_btn_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-card-bg-img') {
                                        $cart_img = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <div class="add-banner">
                                <img src="{{ get_file($cart_img, APP_THEME()) }}" class="add-bnr">
                                <div class="add-banner-column">
                                    <div class="section-title">
                                        <h3>{!! $cart_title !!}</h3>
                                    </div>
                                    <p>{{ $cart_sub_text }}</p>
                                    <div class="add-banner-section-btn">
                                        <a href="#" class="btn-secondary" tabindex="0">
                                            {{ $cart_btn_text }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                height="16" viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                    fill="#0A062D"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                    fill="#0A062D"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @foreach ($MainCategoryList->take(2) as $category)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 add-banner-card">
                            <div class="add-banner">
                                <img src="{{ get_file($category->image_path, APP_THEME()) }}" alt=""
                                    class="add-bnr">
                                <div class="add-banner-column">
                                    <div class="section-title">
                                        <h3> {!! $category->name !!} </h3>
                                    </div>
                                    <div class="add-banner-section-btn">
                                        <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                            class="btn-secondary" tabindex="0">
                                            {{ __('Show more') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                height="16" viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                    fill="#0A062D"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                    fill="#0A062D"></path>
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


        <section class="testimonials-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                $testimonial_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title">
                        <h2>
                            {{ $testimonial_title }}
                        </h2>
                    </div>
                @endif
                <div class="testimonials-slider flex-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonials-itm">
                            <div class="testimonials-itm-inner">
                                <div class="testimonials-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="42"
                                        viewBox="0 0 52 42" fill="none">
                                        <path
                                            d="M23.5328 5.1403L14.2968 22.191L8.47689 23.8209C9.15166 22.5672 9.91079 21.5642 10.7543 20.8119C11.5977 19.9761 12.5677 19.5582 13.6642 19.5582C16.1103 19.5582 18.3033 20.5612 20.2433 22.5672C22.2676 24.4896 23.2798 26.997 23.2798 30.0896C23.2798 33.3493 22.1411 36.1493 19.8637 38.4896C17.6707 40.8299 14.9294 42 11.6399 42C8.51906 42 5.77778 40.8716 3.41606 38.6149C1.13869 36.2746 0 33.4328 0 30.0896C0 28.7522 0.253041 27.206 0.759124 25.4507C1.34955 23.6955 2.40389 21.397 3.92214 18.5552L14.0438 0L23.5328 5.1403ZM52 5.1403L42.764 22.191L37.0706 23.8209C37.661 22.5672 38.3779 21.5642 39.2214 20.8119C40.1492 19.9761 41.1192 19.5582 42.1314 19.5582C44.5775 19.5582 46.8127 20.5612 48.837 22.5672C50.8613 24.4896 51.8735 26.997 51.8735 30.0896C51.8735 33.3493 50.7348 36.1493 48.4574 38.4896C46.2644 40.8299 43.5231 42 40.2336 42C37.1127 42 34.3715 40.8716 32.0097 38.6149C29.7324 36.2746 28.5937 33.4328 28.5937 30.0896C28.5937 28.7522 28.8467 27.206 29.3528 25.4507C29.8589 23.6955 30.871 21.397 32.3893 18.5552L42.6375 0L52 5.1403Z"
                                            fill="#EE9FB4" />
                                    </svg>
                                </div>
                                <div class="testimonials-content">
                                    <div class="testimonials-content-top">
                                        <h3>{{ $review->title }}</h3>
                                        <p>{{ $review->description }}</p>
                                    </div>
                                    <div class="testimonials-content-bottom">
                                        <div class="testimonials-user">
                                            <div class="testimonials-user-img">
                                                <img
                                                    src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}">
                                            </div>
                                            <div class="testimonials-user-content">
                                                <div class="testimonilas-star">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i
                                                            class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                    @endfor
                                                    <span><b>{{ $review->rating_no }}</b> / 5.0</span>
                                                </div>
                                                <div class="testimonials-user-name">
                                                    <span>
                                                        <h4>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},
                                                        </h4>Client
                                                    </span>
                                                </div>
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


        <section class="bestseller-tab-section tabs-wrapper padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-products-title-text') {
                                $product_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-products-btn-text') {
                                $product_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <div class="section-title-left">
                            <h2>{!! $product_title !!}</h2>
                        </div>

                        <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                            {{ $product_btn }}
                        </a>
                    </div>
                @endif
                <ul class="cat-tab tabs">
                    @foreach ($MainCategory as $cat_key => $category)
                        <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                            <a href="javascript:;">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="bestseller-slider flex-slider">
                                @foreach ($all_products as $all_product)
                                    @php
                                        $p_id = hashidsencode($all_product->id);
                                    @endphp
                                    @if ($cat_k == '0' || $all_product->ProductData()->id == $cat_k)
                                        <div class="bestseller-card-itm product-card">
                                            <div class="bestseller-card-inner">
                                                <div class="bestseller-img">
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                        <img
                                                            src="{{ get_file($all_product->cover_image_path, APP_THEME()) }}">
                                                    </a>
                                                </div>
                                                <div class="bestseller-content">
                                                    <div class="bestseller-top">
                                                        <div class="bestseller-card-heading">
                                                            <span>{{ $all_product->tag_api }}</span>
                                                                <a href="javascript:void(0)"
                                                                    class="wishlist-btn wbwish  wishbtn-globaly"
                                                                    product_id="{{ $bestSellers->id }}"
                                                                    in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add' }}">
                                                                    {{ __('Add to wishlist') }}
                                                                    <span class="wish-ic">
                                                                        <i
                                                                            class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    </span>
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
                                                                <div class="badge">
                                                                    @if ($saleData['discount_type'] == 'flat')
                                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                                        -{{ $saleData['discount_amount'] }}%
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <h3 class="description">
                                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                                {!! $all_product->name !!}
                                                            </a>
                                                        </h3>
                                                        </a>
                                                        <p class="descriptions">{{ $all_product->description }}</p>
                                                    </div>
                                                    <div class="bestseller-bottom">
                                                        @if ($all_product->variant_product == 0)
                                                            <div class="price">
                                                                <ins>{{ $all_product->final_price }}</ins>
                                                                <span>{{ $currency }}</span>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <a href="#" class="btn addcart-btn-globaly" type="submit"
                                                            product_id="{{ $all_product->id }}" variant_id="0"
                                                            qty="1">
                                                            {{ __('Add to Cart') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2"
                                                                width="14" height="16" viewBox="0 0 14 16"
                                                                fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                                    fill="#0A062D"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                                    fill="#0A062D"></path>
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


        <section class="subscribe-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                $news_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                $news_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-description') {
                                $news_desc = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="row align-items-center">
                        <div class="col-md-6 col-12">
                            <div class="subscribe-column">
                                <div class="section-title">
                                    <h2>{!! $news_title !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="subscribe-section-form">
                                <p>{{ $news_text }}</p>
                                <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}"
                                    method="post">
                                    @csrf
                                    <div class="input-wrapper">
                                        <input type="email" placeholder="Type your address email..." name="email">
                                        <button type="submit" class="btn-subscibe">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                viewBox="0 0 17 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.9595 9.00095C14.2361 8.72433 14.2361 8.27584 13.9595 7.99921L9.70953 3.74921C9.43291 3.47259 8.98441 3.47259 8.70779 3.74921C8.43117 4.02584 8.43117 4.47433 8.70779 4.75095L12.4569 8.50008L8.70779 12.2492C8.43117 12.5258 8.43117 12.9743 8.70779 13.2509C8.98441 13.5276 9.4329 13.5276 9.70953 13.2509L13.9595 9.00095ZM4.04286 13.2509L8.29286 9.00095C8.56948 8.72433 8.56948 8.27584 8.29286 7.99921L4.04286 3.74921C3.76624 3.47259 3.31775 3.47259 3.04113 3.74921C2.7645 4.02583 2.7645 4.47433 3.04113 4.75095L6.79026 8.50008L3.04112 12.2492C2.7645 12.5258 2.7645 12.9743 3.04112 13.2509C3.31775 13.5276 3.76624 13.5276 4.04286 13.2509Z"
                                                    fill="#0A062D"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                {{-- <div class="checkbox-custom"> --}}
                                {{-- <input type="checkbox" class="" id="subsection"> --}}
                                <label for="subsection">{{ $news_desc }}</label>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="blog-section">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-btn-text') {
                                $blog_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <div class="section-title-left">
                            <h2>{!! $blog_title !!}</h2>
                        </div>
                        <a href="{{ route('page.blog', $slug) }}" class="btn">
                            {{ $blog_text }}
                        </a>
                    </div>
                @endif
                <div class="blog-slider">
                    {!! \App\Models\Blog::HomePageBlog($slug, 6) !!}
                </div>
            </div>
        </section>
    </div>
    <!-- --------- WRAPPER-SECTION-END ---------- -->
@endsection
