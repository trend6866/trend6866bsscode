@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;
@endphp
@section('page-title')
    {{ __('minimarket') }}
@endsection

@section('content')
    <!-- wrapper start  -->
    <div class="wrapper-home">
        @php
            $homepage_header_section4 = '';
            $homepage_header4_key = array_search('homepage-header-4', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_header4_key != '') {
                $homepage_header_section4 = $theme_json[$homepage_header4_key];
            }
        @endphp
        @for ($i = 0; $i < $homepage_header_section4['loop_number']; $i++)
            @php
                foreach ($homepage_header_section4['inner-list'] as $homepage_header_section4_value) {
                    if ($homepage_header_section4_value['field_slug'] == 'homepage-header-banner-img') {
                        $homepage_header_section4_img = $homepage_header_section4_value['field_default_text'];
                    }

                    if (!empty($homepage_header_section4[$homepage_header_section4_value['field_slug']])) {
                        if ($homepage_header_section4_value['field_slug'] == 'homepage-header-banner-img') {
                            $homepage_header_section4_img = $homepage_header_section4[$homepage_header_section4_value['field_slug']][$i]['field_prev_text'];
                        }
                    }
                }
            @endphp
        @endfor
        <div class="main-top">

            <!-- hero section start  -->
            @php
                $homepage_header_section3 = '';
                $homepage_header3_key = array_search('homepage-header-3', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header3_key != '') {
                    $homepage_header_section3 = $theme_json[$homepage_header3_key];
                }
            @endphp
            @if ($homepage_header_section3['section_enable'] == 'on')
                <section class="hero-sec"
                    style="background-image: url({{ get_file($homepage_header_section4_img, APP_THEME()) }});">
                    <div class=" container">
                        <div class="hero-main-slider">
                            @for ($i = 0; $i < $homepage_header_section3['loop_number']; $i++)
                                @php
                                    foreach ($homepage_header_section3['inner-list'] as $homepage_header_section_value) {
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-btn-text') {
                                            $homepage_header_section3_btn_text = $homepage_header_section_value['field_default_text'];
                                        }
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-vedio-icon') {
                                            $homepage_header_section3_video_icon = $homepage_header_section_value['field_default_text'];
                                        }
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-vedio-text') {
                                            $homepage_header_section3_video_text = $homepage_header_section_value['field_default_text'];
                                        }
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-title-text') {
                                            $homepage_header_section3_title_text = $homepage_header_section_value['field_default_text'];
                                        }
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-sub-text') {
                                            $homepage_header_section3_sub_text = $homepage_header_section_value['field_default_text'];
                                        }
                                        if ($homepage_header_section_value['field_slug'] == 'homepage-header-description') {
                                            $homepage_header_section3_description = $homepage_header_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_header_section3[$homepage_header_section_value['field_slug']])) {
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-btn-text') {
                                                $homepage_header_section3_btn_text = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i];
                                            }
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-vedio-icon') {
                                                $homepage_header_section3_video_icon = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-vedio-text') {
                                                $homepage_header_section3_video_text = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i];
                                            }
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-title-text') {
                                                $homepage_header_section3_title_text = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i];
                                            }
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-sub-text') {
                                                $homepage_header_section3_sub_text = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i];
                                            }
                                            if ($homepage_header_section_value['field_slug'] == 'homepage-header-description') {
                                                $homepage_header_section3_description = $homepage_header_section3[$homepage_header_section_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <div class="hero-slides common-heading">
                                    <span class="sub-heading"> {!! $homepage_header_section3_title_text !!}</span>
                                    <h2 class="h1">{!! $homepage_header_section3_sub_text !!} </h2>
                                    <p>{!! $homepage_header_section3_description !!}</p>
                                    <div class="hero-btn">
                                        <a href="{{ route('page.product-list',$slug) }}" class="common-btn">
                                            <span>{!! $homepage_header_section3_btn_text !!}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="play-btn">
                                            {{-- <img src="{{asset('/' . $homepage_header_section3_video_icon)}}" class="img-fluid" alt="play-btn"> --}}
                                            <img src="{{ get_file($homepage_header_section3_video_icon, APP_THEME()) }}"
                                                class="img-fluid" alt="play-btn">
                                            <span>{!! $homepage_header_section3_video_text !!}</span>
                                        </a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </section>
            @endif
            <!-- hero section end  -->
            <!-- best seller  start -->
            @php
                $homepage_bestseller_heading = '';
                $homepage_bestseller_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_bestseller_key != '') {
                    $homepage_bestseller = $theme_json[$homepage_bestseller_key];

                    foreach ($homepage_bestseller['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                            $homepage_bestseller_heading = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_bestseller['section_enable'] == 'on')
                <section class="best-seller-sec padding-bottom padding-top">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d1.png') }}" class="d-right"
                        style="top: 0;">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d2.png') }}" class="d-left"
                        style="bottom: 0;">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/left.png') }}" class="d-left"
                        style="top: 0;">
                    <div class=" container">
                        <div class="seller-heading text-center">
                            <h2>{{ __('Bestsellers') }}</h2>
                        </div>
                        <div class="best-seller-slider flex-slider">
                            @foreach ($bestSeller as $data)
                                <div class="main-card card">
                                    @php
                                        $p_id = hashidsencode($data->id);
                                    @endphp
                                    <div class="pro-card-inner">
                                        <a href="{{ route('page.product', [$slug,$p_id]) }}" class="img-wrapper">
                                            <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}"
                                                class="plant-img img-fluid" alt="plant1">
                                        </a>
                                        <div class="inner-card">
                                            <div class="wishlist-wrapper">
                                                @auth
                                                    <a href="JavaScript:void(0)"
                                                        class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist"
                                                        tabindex="0" product_id="{{ $data->id }}"
                                                        in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                            </div class= "pro-card-head">
                                            <div class="card-heading ">
                                                <h3>
                                                    <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                        class="heading-wrapper product-title1">
                                                        {{ $data->name }}
                                                    </a>
                                                </h3>
                                                <p>{{ $data->ProductData()->name }}</p>
                                            </div>
                                            @if ($data->variant_product == 0)
                                                <div class="price">
                                                    <span> {{ $currency }}</span>
                                                    <ins>{{ $data->final_price }}</ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
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
                                                    <div class="badge">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a href="javascript:void(0)"
                                                class="btn-secondary addcart-btn-globaly common-btn"
                                                product_id="{{ $data->id }}"
                                                variant_id="0" qty="1">
                                                <span>{{ __('Add To Cart') }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
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
            @endif
            <!-- best seller end -->
        </div>
        <div class="main-center">
            <!-- design img  -->
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/circle-design.png') }}" id="circle-design2"
                alt="circle-design">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/circle-design.png') }}" id="circle-design3"
                alt="circle-design">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf2.png') }}" class="desk-only"
                id="main-center-design2" alt="leaf2">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf-design.png') }}" id="main-center-leaf"
                alt="leaf-design">
            <!-- third section start  -->
            @php
                $homepage_banner_heading_label = $homepage_banner_heading_text = $homepage_banner_heading_sub_text = $homepage_banner_heading_btn_text = $homepage_banner_heading_img = '';
                $homepage_banner_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_banner_key != '') {
                    $homepage_banner = $theme_json[$homepage_banner_key];

                    foreach ($homepage_banner['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-banner-label') {
                            $homepage_banner_heading_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-title-text') {
                            $homepage_banner_heading_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                            $homepage_banner_heading_sub_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-btn-text') {
                            $homepage_banner_heading_btn_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-img') {
                            $homepage_banner_heading_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_banner['section_enable'] == 'on')
                <section class="third-sec padding-bottom position-relative">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d3.png') }}  " class="d-right"
                        style="bottom: 0;">
                    <div class=" container">
                        <div class="third-sec-row row align-items-center justify-content-between">
                            <div class=" col-md-7 col-12">
                                <div class="common-heading">
                                    <span class="sub-heading"> {!! $homepage_banner_heading_label !!}</span>
                                    <h2>{!! $homepage_banner_heading_text !!}</h2>
                                    <p>{!! $homepage_banner_heading_sub_text !!}</p>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('page.product-list',$slug) }}" class="common-btn">
                                            <span>{!! $homepage_banner_heading_btn_text !!}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-5 col-12">
                                <div class=" third-sec-img-div">
                                    <img src="{{ get_file($homepage_banner_heading_img, APP_THEME()) }}" alt="img1">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            <!-- third section end  -->
            <!-- couner-number-sec -->
            @php
                $homepage_counting3 = '';
                $homepage_counting3_key = array_search('homepage-counting-1', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_counting3_key != '') {
                    $homepage_counting3 = $theme_json[$homepage_counting3_key];
                }
            @endphp
            @if ($homepage_counting3['section_enable'] == 'on')
                <section class="couner-number-sec padding-bottom">
                    <div class=" container">
                        <div class="row numbers-row">
                            @for ($i = 0; $i < $homepage_counting3['loop_number']; $i++)
                                @php
                                    foreach ($homepage_counting3['inner-list'] as $homepage_counting3_value) {
                                        if ($homepage_counting3_value['field_slug'] == 'homepage-counting-digit') {
                                            $homepage_counting3_text = $homepage_counting3_value['field_default_text'];
                                        }
                                        if ($homepage_counting3_value['field_slug'] == 'homepage-counting-title') {
                                            $homepage_counting3_title_text = $homepage_counting3_value['field_default_text'];
                                        }

                                        if (!empty($homepage_counting3[$homepage_counting3_value['field_slug']])) {
                                            if ($homepage_counting3_value['field_slug'] == 'homepage-counting-digit') {
                                                $homepage_counting3_text = $homepage_counting3[$homepage_counting3_value['field_slug']][$i];
                                            }
                                            if ($homepage_counting3_value['field_slug'] == 'homepage-counting-title') {
                                                $homepage_counting3_title_text = $homepage_counting3[$homepage_counting3_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <div class="col-lg-3 col-sm-3 col-12">
                                    <div class="number-box">
                                        <h2 data-max="3000">{!! $homepage_counting3_text !!}</h2>
                                        <p>{!! $homepage_counting3_title_text !!}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </section>
            @endif
            <!-- couner-number-sec end  -->
            @php
                $homepage_card_label = $homepage_card_text = $homepage_card_sub_text = $homepage_card_btn_text = $homepage_card_img = '';
                $homepage_card_key = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_card_key != '') {
                    $homepage_card = $theme_json[$homepage_card_key];

                    foreach ($homepage_card['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-card-label') {
                            $homepage_card_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-card-title-text') {
                            $homepage_card_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-card-sub-text') {
                            $homepage_card_sub_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-card-btn-text') {
                            $homepage_card_btn_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-card-bg-img') {
                            $homepage_card_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp

            <!-- card section start  -->
            @if ($homepage_card['section_enable'] == 'on')
                <section class="card-sec padding-bottom">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d4.png') }} "class="d-left"
                        style="top: 25%;">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/right.png') }}" class="d-right"
                        style="bottom: 0">
                    <div class=" container">
                        <div class="row">
                            <div class="col-lg-6 col-12 img-main-box">
                                <div class="img-box">
                                    <img src="{{ get_file($homepage_card_img, APP_THEME()) }}" class="card-img"
                                        alt="img1">
                                    <div class="inner-text">
                                        <div class="common-heading">
                                            <span class="sub-heading"> {!! $homepage_card_label !!}</span>
                                            <h3><a
                                                    href="{{ route('page.product-list',$slug) }}">{!! $homepage_card_text !!}</b></a>
                                            </h3>
                                            <p>{!! $homepage_card_sub_text !!}</p>
                                            <div class=" d-flex justify-content-center align-items-center">
                                                <a href="{{ route('page.product-list',$slug) }}"
                                                    class="common-btn">{!! $homepage_card_btn_text !!}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach ($homepage_products as $h_product)
                                <div class="main-card card col-lg-3 col-sm-6 col-12">
                                    @php
                                        $p_id = hashidsencode($h_product->id);
                                    @endphp
                                    <div class="pro-card-inner">
                                        <a href="{{ route('page.product', [$slug,$p_id]) }}" class="img-wrapper">
                                            <img src="{{ get_file($h_product->cover_image_path, APP_THEME()) }}"
                                                class="plant-img img-fluid" alt="plant1">
                                        </a>
                                        <div class="inner-card">
                                            <div class="wishlist-wrapper">
                                                @auth
                                                    <a href="JavaScript:void(0)"
                                                        class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist"
                                                        tabindex="0" product_id="{{ $h_product->id }}"
                                                        in_wishlist="{{ $h_product->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $h_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                            </div>
                                            <div class="card-heading">
                                                <h3>
                                                    <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                        class="heading-wrapper product-title1">
                                                        {{ $h_product->name }}
                                                    </a>
                                                </h3>
                                                <p>{{ $h_product->ProductData()->name }}</p>
                                            </div>
                                            @if ($h_product->variant_product == 0)
                                                <div class="price">
                                                    <span> {{ $currency }}</span>
                                                    <ins>{{ $h_product->final_price }}</ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
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
                                                    <div class="badge">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a href="JavaScript:void(0)"
                                                class="common-btn addtocart-btn addcart-btn-globaly"
                                                product_id="{{ $h_product->id }}"
                                                variant_id="0" qty="1">
                                                <span>{{ __('Add To Cart') }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
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
            @endif
            <!-- card section end  -->
            <!-- card section end  -->
            @php
                $homepage_feature_product_heading_label = $homepage_feature_product_heading_text = $homepage_feature_product_heading_sub_text = $homepage_feature_product_heading_btn_text = '';
                $homepage_feature_product_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_feature_product_key != '') {
                    $homepage_feature_product = $theme_json[$homepage_feature_product_key];

                    foreach ($homepage_feature_product['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-feature-products-label') {
                            $homepage_feature_product_heading_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-feature-products-title-text') {
                            $homepage_feature_product_heading_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-feature-products-sub-text') {
                            $homepage_feature_product_heading_sub_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-feature-products-btn-text') {
                            $homepage_feature_product_heading_btn_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_feature_product['section_enable'] == 'on')
                <section class="fifth-sec">
                    <img src=" {{ asset('themes/' . APP_THEME() . '/assets/images/d5.png') }}" class="d-right"
                        style="top: 60%;">
                    <div class=" container">
                        <div class="row align-items-end">
                            <div class=" col-lg-6 col-12">
                                <div class=" common-heading">
                                    <span class="sub-heading"> {!! $homepage_feature_product_heading_label !!}</span>
                                    <h2>{!! $homepage_feature_product_heading_text !!} </h2>
                                    <p>{!! $homepage_feature_product_heading_sub_text !!}</p>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('page.product-list',$slug) }}" class="common-btn">
                                            <span>{!! $homepage_feature_product_heading_btn_text !!}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="fifth-sec-right-slider flex-slider">
                                    @foreach ($modern_products as $m_product)
                                        <div class="main-card card">
                                            @php
                                                $p_id = hashidsencode($m_product->id);
                                            @endphp
                                            <div class="pro-card-inner">
                                                <a href="{{ route('page.product', [$slug,$p_id]) }}" class="img-wrapper">
                                                    <img src="{{ get_file($m_product->cover_image_path, APP_THEME()) }}"
                                                        class="plant-img img-fluid" alt="plant1">
                                                </a>
                                                <div class="inner-card">
                                                    <div class="wishlist-wrapper">
                                                        @auth
                                                            <a href="JavaScript:void(0)"
                                                                class="add-wishlist wishlist wishbtn wishbtn-globaly"
                                                                title="Wishlist" tabindex="0"
                                                                product_id="{{ $m_product->id }}"
                                                                in_wishlist="{{ $m_product->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                                                <span class="wish-ic">
                                                                    <i
                                                                        class="{{ $m_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                </span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                    <div class="card-heading">
                                                        <h3>
                                                            <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                                class="heading-wrapper product-title1">
                                                                {{ $m_product->name }}
                                                            </a>
                                                        </h3>
                                                        <p>{{ $m_product->ProductData()->name }}</p>
                                                    </div>
                                                    @if ($m_product->variant_product == 0)
                                                        <div class="price">
                                                            <span> {{ $currency }}</span>
                                                            <ins>{{ $m_product->final_price }}</ins>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
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
                                                            <div class="badge">
                                                                @if ($saleData['discount_type'] == 'flat')
                                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                                    -{{ $saleData['discount_amount'] }}%
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <a href="JavaScript:void(0)"
                                                        class="common-btn addtocart-btn addcart-btn-globaly"
                                                        product_id="{{ $m_product->id }}"
                                                        variant_id="0" qty="1">
                                                        <span>{{ __('Add To Cart') }}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="16" viewBox="0 0 14 16" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                                fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
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
                </section>
            @endif
            @php
                $homepage_video_heading_label = $homepage_video_heading_text =$homepage_video_heading_img = $homepage_video_heading_sub_text = $homepage_video_heading_icon = $homepage_video_heading_icon_text = '';
                $homepage_video_key = array_search('homepage-vedio-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_video_key != '') {
                    $homepage_video = $theme_json[$homepage_video_key];
                    foreach ($homepage_video['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-vedio-section-label') {
                            $homepage_video_heading_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-vedio-section-title-text') {
                            $homepage_video_heading_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-vedio-section-sub-text') {
                            $homepage_video_heading_sub_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-vedio-section-banner-img') {
                            $homepage_video_heading_img = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-vedio-section-vedio-icon') {
                            $homepage_video_heading_icon = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-vedio-section-vedio-text') {
                            $homepage_video_heading_icon_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <!-- sixth-sec start  -->
            @if ($homepage_video['section_enable'] == 'on')
                <section class="sixth-sec padding-bottom"
                    style="background-image: url({{ get_file($homepage_video_heading_img, APP_THEME()) }});">
                    <div class=" container">
                        <div class="common-heading">
                            <span class="sub-heading"> {!! $homepage_video_heading_label !!}</span>
                            <h2>{!! $homepage_video_heading_text !!} </h2>
                            <p>{!! $homepage_video_heading_sub_text !!}</p>
                            <div class=" d-flex justify-content-center align-items-center">
                                <a href="javascript:void(0)" class="play-btn">
                                    <img src="{{ get_file($homepage_video_heading_icon, APP_THEME()) }}"
                                        class=" img-fluid" alt="plant1">
                                    {!! $homepage_video_heading_icon_text !!}
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            <!-- sixth-sec end  -->
        </div>
        <div class="main-bottom">
            <!-- design img  -->
            {{-- <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/circle-design.png') }}" class="desk-only"
                id="circle-design4" alt="circle-design"> --}}
            {{-- <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf-design.png') }}" class="desk-only"
                id="main-bottom-leaf2" alt="leaf"> --}}
            {{-- <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/circle-design.png') }}" class="desk-only"
                id="circle-design5" alt="circle-design"> --}}
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf-design.png') }}" class="desk-only"
                id="main-bottom-leaf3" alt="leaf">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf2.png') }}" class="desk-only"
                id="leaf3" alt="leaf">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leaf2.png') }}" class="desk-only"
                id="leaf4" alt="leaf">
            @php
                $homepage_products = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                $section_enable = 'on';
                if ($homepage_products != '') {
                    $home_products = $theme_json[$homepage_products];
                    $section_enable = $home_products['section_enable'];
                    foreach ($home_products['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-products-title-text') {
                            $home_products1 = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <!-- filter gallary start -->
            @if ($home_products['section_enable'] == 'on')
                <section class="filter-sec position-relative padding-top padding-bottom">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d6.png') }}" class="d-left"
                        style="top: 35%;">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/right.png') }}" class="d-right"
                        style="top: 0;">
                    <div class=" container">
                        <div class="title d-flex justify-content-between align-items-center flex-wrap">
                            <div class="common-heading">
                                <h2> {!! $home_products1 !!} </h2>
                            </div>
                            <ul class="category-buttons d-flex tabs">
                                @foreach ($MainCategory as $cat_key => $category)
                                    <li class="tab-link  {{ $cat_key == 0 ? 'active' : '' }}"
                                        data-tab="{{ $cat_key }}"><a href="javascript:;">{{ $category }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="filter-content">
                            @foreach ($MainCategory as $cat_k => $category)
                                <div class="tab-content {{ $cat_k == 0 ? 'active' : '' }}" id="{{ $cat_k }}">
                                    <div class="shop-protab-slider flex-slider f_blog">
                                        @foreach ($homeproducts as $homeproduct)
                                            @if ($cat_k == '0' || $homeproduct->ProductData()->id == $cat_k)
                                                @php
                                                    $p_id = hashidsencode($homeproduct->id);
                                                @endphp
                                                <div class="main-card card">
                                                    <div class="pro-card-inner">
                                                        <a href="{{ route('page.product', [$slug,$p_id]) }}" class="img-wrapper">
                                                            <img src="{{ get_file($homeproduct->cover_image_path, APP_THEME()) }}"
                                                                class="plant-img img-fluid" alt="plant1">
                                                        </a>
                                                        <div class="inner-card">
                                                            <div class="wishlist-wrapper">
                                                                @auth
                                                                    <a href="JavaScript:void(0)"
                                                                        class="add-wishlist wishlist wishbtn wishbtn-globaly"
                                                                        title="Wishlist" tabindex="0"
                                                                        product_id="{{ $homeproduct->id }}"
                                                                        in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                                                        <span class="wish-ic">
                                                                            <i
                                                                                class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                        </span>
                                                                    </a>
                                                                @endauth
                                                            </div>
                                                            <div class="card-heading">
                                                                <h3>
                                                                    <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                                        class="heading-wrapper product-title1">
                                                                        {{ $homeproduct->name }}
                                                                    </a>
                                                                </h3>
                                                                <p>{{ $homeproduct->ProductData()->name }}</p>
                                                            </div>
                                                            @if ($homeproduct->variant_product == 0)
                                                                <div class="price">
                                                                    <span> {{ $currency }}</span>
                                                                    <ins>{{ $homeproduct->final_price }}</ins>
                                                                </div>
                                                            @else
                                                                <div class="price">
                                                                    <ins>{{ __('In Variant') }}</ins>
                                                                </div>
                                                            @endif
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
                                                                            if (is_array($saleEnableArray) && in_array($homeproduct->id, $saleEnableArray)) {
                                                                                $latestSales[$homeproduct->id] = [
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
                                                            <a href="JavaScript:void(0)"
                                                                class="common-btn addtocart-btn addcart-btn-globaly"
                                                                product_id="{{ $homeproduct->id }}"
                                                                variant_id="0"
                                                                qty="1">
                                                                <span>{{ __('Add To Cart') }}</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="16" viewBox="0 0 14 16" fill="none">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                                        fill="white" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                                        fill="white" />
                                                                </svg>
                                                            </a>
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
            <!-- filter gallary end -->
            @php
                $homepage_newsletter = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                $section_enable = 'on';
                if ($homepage_newsletter != '') {
                    $home_newsletter = $theme_json[$homepage_newsletter];
                    $section_enable = $home_newsletter['section_enable'];
                    foreach ($home_newsletter['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-newsletter-label') {
                            $home_newsletter_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                            $home_newsletter_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                            $home_newsletter_sub_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-description') {
                            $home_newsletter_description = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-bg-img') {
                            $home_newsletter_image = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <!-- subcscribe banner start  -->
            @if ($home_newsletter['section_enable'] == 'on')
                <section class=" subscribe-sec position-relative padding-bottom">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d7.png ') }}" class="d-right"
                        style="top: 28%;">
                    <div class="container">
                        <div class="bg-sec">
                            <img src="{{ get_file($home_newsletter_image, APP_THEME()) }}" class="banner-img"
                                alt="plant1">
                            <div class="contnent">
                                <div class="common-heading">
                                    <span class="sub-heading">{!! $home_newsletter_label !!}</span>
                                    <h2>{!! $home_newsletter_text !!}</h2>
                                    <p>{!! $home_newsletter_sub_text !!}</p>
                                </div>
                                <form action="{{ route('newsletter.store',$slug) }}" class="form-subscribe-form"
                                    method="post">
                                    @csrf
                                    <div class="input-box">
                                        <input type="email" placeholder="Type your address email..." name="email">
                                        <button>
                                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/icons/right-arrow.svg') }}"
                                                alt="right-arrow">
                                        </button>
                                    </div>
                                    <div class="form-check">
                                            <p>{!! $home_newsletter_description !!}
                                            </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            <!-- subcscribe banner end  -->
            @php
                $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                $section_enable = 'on';
                if ($homepage_blog != '') {
                    $home_blog = $theme_json[$homepage_blog];
                    $section_enable = $home_blog['section_enable'];
                    foreach ($home_blog['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-label') {
                            $home_blog_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-title-text') {
                            $home_blog_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <!-- articles slider start -->
            @if ($home_blog['section_enable'] == 'on')
                <section class="article-sec position-relative padding-bottom">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d8.png ') }}" class="d-left"
                        style="top: 25%;">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/left.png') }}" class="d-left"
                        style="top: -35%;">
                    <div class=" container">
                        <div class="common-heading">
                            <span class="sub-heading">{!! $home_blog_label !!}</span>
                            <h2>{!! $home_blog_text !!}</h2>
                        </div>
                        <div class="article-slider flex-slider">
                            {!! \App\Models\Blog::HomePageBlog($slug,10) !!}
                        </div>
                    </div>
                </section>
            @endif
            <!-- articles slider end -->
            @php
                $homepage_testimonial = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                $section_enable = 'on';
                if ($homepage_testimonial != '') {
                    $home_testimonial = $theme_json[$homepage_testimonial];
                    $section_testimonial = $home_testimonial['section_enable'];
                    foreach ($home_testimonial['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-testimonial-label') {
                            $home_testimonial_label = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                            $home_testimonial_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <!-- testimonials slider start  -->
            @if ($home_testimonial['section_enable'] == 'on')
                <section class="testimonials-sec position-relative padding-bottom">
                    <img src=" {{ asset('themes/' . APP_THEME() . '/assets/images/right.png ') }}" class="d-right"
                        style="top: -15%;">
                    <div class="container">
                        <div class="common-heading">
                            <span class="sub-heading"> {!! $home_testimonial_label !!}</span>
                            <h2>{!! $home_testimonial_text !!}</h2>
                        </div>
                        <div class="row align-items-end">
                            <div class=" col-lg-9 col-12">
                                <div class="testi-slider-container">
                                    <div class="testi-slider">
                                        @foreach ($reviews as $review)
                                            <div class="testi-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="29"
                                                    viewBox="0 0 32 29" fill="none">
                                                    <path
                                                        d="M32 0V3.76895H31.0526C29.0175 3.76895 27.3333 4.15283 26 4.92058C24.7368 5.61853 23.7895 6.90975 23.1579 8.79422C22.5965 10.6089 22.3158 13.1215 22.3158 16.3321V22.4043L20.9474 20.1011C21.2982 19.8219 21.7895 19.5776 22.4211 19.3682C23.0526 19.1588 23.7544 19.0541 24.5263 19.0541C26 19.0541 27.193 19.5078 28.1053 20.4152C29.0175 21.3225 29.4737 22.5439 29.4737 24.0794C29.4737 25.5451 29.0526 26.7316 28.2105 27.639C27.3684 28.5463 26.1404 29 24.5263 29C23.3333 29 22.2807 28.7208 21.3684 28.1625C20.4561 27.6041 19.7193 26.6619 19.1579 25.3357C18.5965 23.9398 18.3158 22.0554 18.3158 19.6823V17.6931C18.3158 12.8773 18.807 9.213 19.7895 6.70036C20.8421 4.11793 22.3158 2.37305 24.2105 1.4657C26.1754 0.488568 28.4561 0 31.0526 0H32ZM13.6842 0V3.76895H12.7368C10.7018 3.76895 9.01754 4.15283 7.68421 4.92058C6.42105 5.61853 5.47368 6.90975 4.84211 8.79422C4.2807 10.6089 4 13.1215 4 16.3321V22.4043L2.63158 20.1011C2.98246 19.8219 3.47368 19.5776 4.10526 19.3682C4.73684 19.1588 5.4386 19.0541 6.21053 19.0541C7.68421 19.0541 8.87719 19.5078 9.78947 20.4152C10.7018 21.3225 11.1579 22.5439 11.1579 24.0794C11.1579 25.5451 10.7368 26.7316 9.89474 27.639C9.05263 28.5463 7.82456 29 6.21053 29C5.01754 29 3.96491 28.7208 3.05263 28.1625C2.14035 27.6041 1.40351 26.6619 0.842105 25.3357C0.280702 23.9398 0 22.0554 0 19.6823V17.6931C0 12.8773 0.491228 9.213 1.47368 6.70036C2.52632 4.11793 4 2.37305 5.89474 1.4657C7.85965 0.488568 10.1404 0 12.7368 0H13.6842Z"
                                                        fill="#B5C547" />
                                                </svg>
                                                <p class="descriptions">{{ $review->description }}</p>
                                                <div class=" d-flex align-items-center">
                                                    <div class="client-name">
                                                        <a
                                                            href="#">{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</a>
                                                        <span>{{ __('Client') }}</span>
                                                    </div>
                                                    <div class="rating d-flex align-items-center">
                                                        <div class="review-stars">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i
                                                                    class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                            @endfor
                                                        </div>
                                                        <div class="rating-number">{{ $review->rating_no }}.0 / 5.0</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class=" col-lg-3 col-12">
                                <div class="right-slide-slider">
                                    @foreach ($reviews as $review)
                                        @php
                                            $p_id = hashidsencode($review->ProductData->id);
                                        @endphp
                                        <div class="main-card">
                                            <div class="card-inner">
                                                <a href="{{ route('page.product', [$slug,$p_id]) }}" class="img-wrapper">
                                                    <img src="{{ asset('/' . !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path, APP_THEME()) : '') }}"
                                                        class="plant-img img-fluid" alt="plant1">
                                                </a>
                                                <div class="inner-card">
                                                    <div class="wishlist-wrapper">
                                                        @auth
                                                            <a href="JavaScript:void(0)"
                                                                class="add-wishlist wishlist wishbtn wishbtn-globaly"
                                                                title="Wishlist" tabindex="0"
                                                                product_id="{{ $review->ProductData->id }}"
                                                                in_wishlist="{{ $review->ProductData->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                                                <span class="wish-ic">
                                                                    <i
                                                                        class="{{ $review->ProductData->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                </span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                    <div class="card-heading">
                                                        <h3>
                                                            <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                                class="heading-wrapper product-title1">
                                                                {{ $review->ProductData->name }}
                                                            </a>
                                                        </h3>
                                                        {{-- <p>Height: 78cm</p> --}}
                                                    </div>
                                                    @if ($review->ProductData->variant_product == 0)
                                                        <div class="price">
                                                            <span> {{ $currency }}</span>
                                                            <ins>{{ $review->ProductData->final_price }}</ins>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
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
                                                                    if (is_array($saleEnableArray) && in_array($review->ProductData->id, $saleEnableArray)) {
                                                                        $latestSales[$review->ProductData->id] = [
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
                                                    <a href="javascript:void(0)"
                                                        class="btn-secondary addcart-btn-globaly common-btn"
                                                        product_id="{{ $review->ProductData->id }}"
                                                        variant_id="0"
                                                        qty="1">
                                                        <span>{{ __('Add To Cart') }}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="16" viewBox="0 0 14 16" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                                fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
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
                </section>
            @endif
            <!-- testimonials slider end  -->
        </div>
        <!--video popup start-->
        <div id="popup-box" class="overlay-popup">
            <div class="popup-inner">
                <div class="content">
                    <a class=" close-popup" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34"
                            fill="none">
                            <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white"
                                stroke-width="2">
                            </line>
                            <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white"
                                stroke-width="2">
                            </line>
                        </svg>
                    </a>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/9xwazD5SyVg"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
        <!--video popup end -->
        <!-- Back to Top btn start -->
        <div class="back-to-top" title="go to top">
            <a href="#">
                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/icons/down-arrow.svg') }}"
                    alt="down-arrow">
            </a>
        </div>
        <!-- Back to Top btn end-->

        <!-- subcribe newslater end -->
    </div>
    <!-- wrapper end  -->

@endsection
