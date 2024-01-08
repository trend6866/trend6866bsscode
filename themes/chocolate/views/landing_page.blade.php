@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;

@endphp
@section('page-title')
    {{ __('Chocolate') }}
@endsection
@section('content')
    <div class="main-top">
        <img src=" {{ asset('themes/' . APP_THEME() . '/assets/images/design-img-chocolate2.png') }}"
            class="design-img-chocolate2" alt="design-img-chocolate2">
        @php
            $Chocolaterie = $chocolat_right = $chocolate_left = '';
            $homepage_header_1_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_header_1_key != '') {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-banner-home-img') {
                        $Chocolaterie = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-banner-right-img') {
                        $chocolat_right = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-banner-left-img') {
                        $chocolate_left = $value['field_default_text'];
                    }
                }
            }
        @endphp
        <!-- home section start  -->
        {{-- @if ($homepage_header_1['section_enable'] == 'on')  --}}
        <section class="home-section padding-top padding-bottom"
            style="background-image:  url('{{ get_file($Chocolaterie, APP_THEME()) }}' );">
            <div class=" container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="home-main-left-side">
                            <div class="home-left-side dark-p">
                                <div class="section-title">
                                    @php
                                        $Chocolaterie = $chocolate_flavor = $chocolate_text = $products_btn = $baner_video = $Vedio_Label = $chocolate_description = $show_btn = '';
                                        $homepage_header_1_key = array_search('homepage-banner-1', array_column($theme_json, 'unique_section_slug'));
                                        if ($homepage_header_1_key != '') {
                                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                            // dd($homepage_header_1);
                                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                                if ($value['field_slug'] == 'homepage-banner-label') {
                                                    $Chocolaterie = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-title-text') {
                                                    $chocolate_flavor = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                                    $chocolate_text = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-btn-text') {
                                                    $products_btn = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-vedio-url') {
                                                    $baner_video = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-vedio-label') {
                                                    $Vedio_Label = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-description') {
                                                    $chocolate_description = $value['field_default_text'];
                                                }
                                                if ($value['field_slug'] == 'homepage-banner-btn-text-2') {
                                                    $show_btn = $value['field_default_text'];
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($homepage_header_1['section_enable'] == 'on')
                                        <span class="sub-title">{!! $Chocolaterie !!}</span>
                                        <h2>{!! $chocolate_flavor !!}</h2>
                                </div>
                                <p>{!! $chocolate_text !!}</p>
                                <div class="btn-wrapper">
                                    <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                        {!! $products_btn !!}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                            viewBox="0 0 14 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                fill="white"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:void()" class="play-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 45 44"
                                            width="45" height="44">
                                            <path fill-rule="evenodd" class="a"
                                                d="m26.9 19.9c1.5 1 1.5 3.2 0 4.2l-6.1 4.1c-1.6 1.1-3.9-0.1-3.9-2.1v-8.2c0-2 2.3-3.2 3.9-2.1zm-0.7 1.1l-6.1-4.1c-0.8-0.6-1.9 0-1.9 1v8.2c0 1 1.1 1.6 1.9 1l6.1-4c0.8-0.5 0.8-1.6 0-2.1z" />
                                            <rect class="b" x=".5" y=".5" width="44" height="43"
                                                rx="21.5" />
                                        </svg>
                                        {!! $Vedio_Label !!}
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="service-tag">
                                @php
                                    $homepage_promotions_icon = $homepage_promotions_txt = '';

                                    $homepage_promotions_key = array_search('homepage-promotions', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_promotions_key != '') {
                                        $homepage_promotions_section = $theme_json[$homepage_promotions_key];
                                    }
                                    // DD($homepage_promotions_section);
                                @endphp
                                @for ($i = 0; $i < $homepage_promotions_section['loop_number']; $i++)
                                    @php
                                        foreach ($homepage_promotions_section['inner-list'] as $homepage_promotions_section_value) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-promotions-icon') {
                                                $homepage_promotions_icon = $homepage_promotions_section_value['field_default_text'];
                                            }

                                            if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                                if ($homepage_promotions_section_value['field_slug'] == 'homepage-promotions-icon') {
                                                    $homepage_promotions_icon = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i]['field_prev_text'];
                                                }
                                            }

                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-promotions-label') {
                                                $homepage_promotions_txt = $homepage_promotions_section_value['field_default_text'];
                                            }

                                            if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                                if ($homepage_promotions_section_value['field_slug'] == 'homepage-promotions-label') {
                                                    $homepage_promotions_txt = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($homepage_promotions_section['section_enable'] == 'on')
                                        <div class="service-box d-flex align-items-center">
                                            <img src="{{ get_file($homepage_promotions_icon, APP_THEME()) }}">
                                            <div class="service-text">
                                                {!! $homepage_promotions_txt !!}
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-slider-main">
                            <div class="home-slider flex-slider">
                                @foreach ($home_products->take(3) as $product)
                                    @php
                                        $p_id = hashidsencode($product->id);
                                    @endphp
                                    {{-- @dd($product) --}}
                                    <div class="product-card card">
                                        {{-- @dd($all_products->take(3)) --}}
                                        <div class="product-card-inner card-inner">
                                            <div class="card-top">
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
                                                        <span class="badge">
                                                            @if ($saleData['discount_type'] == 'flat')
                                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                                -{{ $saleData['discount_amount'] }}%
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                                    <a href="javascript:void(0)" class=" add-wishlist wishbtn-globaly"
                                                        product_id="{{ $product->id }}"
                                                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                        {{ __('Add to wishlist') }}
                                                        <i
                                                            class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </a>
                                            </div>
                                            <div class="product-card-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                        class="default-img">
                                                </a>
                                            </div>
                                            <div class="card-bottom">
                                                <div class="card-title">
                                                    <h3>
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <p class="chocolate-description">{{ $product->description }}</p>
                                                <div class="card-btn-wrapper">
                                                    @if ($product->variant_product == 0)
                                                        <div class="price">
                                                            <ins>{{ $product->final_price }} <span
                                                                    class="currency-type">{{ $currency }}</span></ins>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
                                                    <a href="javascript:void(0)" class="btn addcart-btn-globaly"
                                                        product_id="{{ $product->id }}" variant_id="0" qty="1">
                                                        <span>{{ __('ADD TO CART') }}</span>
                                                        <span class="atc-ic">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="9"
                                                                height="8" viewBox="0 0 9 8" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </span>
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
        </section>
        {{-- @endif --}}
        <section class="second-sec padding-top padding-bottom">
            <img src="  {{ get_file($chocolat_right, APP_THEME()) }}" class="design-img-chocolate"
                alt="design-img-chocolate">
            <div class=" container">
                <div class="row justify-content-between align-items-center">
                    <div class=" col-md-6 col-sm-6 col-12">
                        <div class=" dark-p">
                            @php
                                $Chocolaterie = $chocolate_flavor = $chocolate_text = '';
                                $homepage_header_1_key = array_search('homepage-banner-section', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-banner-section-label') {
                                            $Chocolaterie = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-section-title-text') {
                                            $chocolate_flavor = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                            $chocolate_text = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_header_1['section_enable'] == 'on')
                                <div class="section-title">
                                    <span class="sub-title">{!! $Chocolaterie !!}</span>
                                    <h2>{!! $chocolate_flavor !!}</b></h2>
                                </div>
                            @endif
                            {!! $chocolate_text !!}
                            <div class="second-sec-btn">
                                @if ($has_subcategory)
                                    <div class="btn-wrapper">
                                        @foreach ($MainCategory as $cat_key => $category)
                                            <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                                class="btn-secondary">
                                                {{ $category->name }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                        fill="white"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                        fill="white"></path>
                                                </svg>
                                            </a><br>
                                        @endforeach
                                    </div>
                                @else
                                    @foreach ($MainCategoryList as $category)
                                        <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                            class="btn-secondary mt-2">{{ $category->name }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                    fill="white"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                    fill="white"></path>
                                            </svg>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-6  col-sm-6 col-12">
                        <div class="second-sec-right-side dark-p">
                            <div class="img-wrapper">
                                <img src="{{ get_file($chocolate_left, APP_THEME()) }}" alt="chocolate">
                            </div>
                            @if ($homepage_header_1['section_enable'] == 'on')
                                <p>{!! $chocolate_description !!}</p>
                                <a href="{{ route('page.product-list', $slug) }}"
                                    class="link-btn">{!! $show_btn !!}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="main-center">
        <section class="product-slider-sec">
            <div class="container">
                <div class="section-title">
                    @php
                        $chocolate_text = '';
                        $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-products-title-text') {
                                    $chocolate_text = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <h2>{!! $chocolate_text !!}
                    @endif
                    </h2>
                </div>
            </div>
            <div class="product-slider-main flex-slider">
                @foreach ($bestSeller as $data)
                    @php
                        $bestSeller_ids = hashidsencode($data->id);
                    @endphp
                    <div class="product-card card">
                        <div class="product-card-inner card-inner">
                            <div class="card-top">
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
                                        <span class="badge">
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </span>
                                    @endforeach
                                </div>

                                    <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly"
                                        product_id="{{ $data->id }}"
                                        in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">
                                        {{ __('Add to wishlist') }}
                                        <span class="wish-ic">
                                            <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                        </span>
                                    </a>
                            </div>
                            <div class="product-card-image">
                                <a href="{{ route('page.product', [$slug, $bestSeller_ids]) }}">
                                    <img src=" {{ get_file($data->cover_image_path, APP_THEME()) }}" class="default-img">
                                </a>
                            </div>
                            <div class="card-bottom">
                                <div class="card-title">
                                    <h3>
                                        <a href="{{ route('page.product', [$slug, $bestSeller_ids]) }}" class="names">
                                            {{ $data->name }}
                                        </a>
                                    </h3>
                                </div>
                                <p class="description">{{ $data->description }}</p>
                                <div class="card-btn-wrapper">
                                    @if ($data->variant_product == 0)
                                        <div class="price">
                                            <ins>{{ $data->final_price }} <span
                                                    class="currency-type">{{ $currency }}</span></ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif
                                    <a href="javascript:void(0)" class="btn  addtocart-btn-cart addcart-btn-globaly"
                                        product_id="{{ $data->id }}" variant_id="0" qty="1">
                                        {{ __('ADD TO CART') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                            viewBox="0 0 14 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                fill="#F2DFCE"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                fill="#F2DFCE"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @php
            $homepage_vedio_section_label = $homepage_vedio_section_title_text = $homepage_vedio_section_sub_text = $homepage_vedio_section_vedio_icon = $homepage_vedio_section_vedio_text = '';
            $homepage_header_1_key = array_search('homepage-vedio-section', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_header_1_key != '') {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-vedio-section-label') {
                        $homepage_vedio_section_label = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-vedio-section-title-text') {
                        $homepage_vedio_section_title_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-vedio-section-sub-text') {
                        $homepage_vedio_section_sub_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-vedio-section-vedio-icon') {
                        $homepage_vedio_section_vedio_icon = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-vedio-section-vedio-text') {
                        $homepage_vedio_section_vedio_text = $value['field_default_text'];
                    }
                }
            }
        @endphp
        <section class="video-sec"
            style="background-image: url('{{ asset('themes/' . APP_THEME() . '/assets/images/bg2.png') }}');">
            <div class="container">
                <div class="video-content">
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title">
                            <span class="sub-title">{!! $homepage_vedio_section_label !!}</span>
                            <h2>{!! $homepage_vedio_section_title_text !!} </h2>
                        </div>
                        <p>{!! $homepage_vedio_section_sub_text !!}</p>
                        <div class="btn-wrapper justify-content-center">
                            <a href="javascript:void()" class="play-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 45 44"
                                    width="45" height="44">
                                    <path fill-rule="evenodd" class="a"
                                        d="m26.9 19.9c1.5 1 1.5 3.2 0 4.2l-6.1 4.1c-1.6 1.1-3.9-0.1-3.9-2.1v-8.2c0-2 2.3-3.2 3.9-2.1zm-0.7 1.1l-6.1-4.1c-0.8-0.6-1.9 0-1.9 1v8.2c0 1 1.1 1.6 1.9 1l6.1-4c0.8-0.5 0.8-1.6 0-2.1z" />
                                    <rect class="b" x=".5" y=".5" width="44" height="43" rx="21.5" />
                                </svg>
                                {!! $homepage_vedio_section_vedio_text !!}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <section class="tab-sec padding-top tabs-wrapper padding-bottom">
        <div class="container">
            <div class="tab-title">
                <div class="tab-title-left dark-p">
                    <div class="section-title">
                        @php
                            $homepage_category_title_text = $homepage_category_sub_text = '';
                            $homepage_header_1_key = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-category-title-text') {
                                        $homepage_category_title_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-category-sub-text') {
                                        $homepage_category_sub_text = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <h2>{!! $homepage_category_title_text !!}
                            </h2>
                    </div>
                    <p>
                        {!! $homepage_category_sub_text !!}
                    </p>
                    @endif
                    <br>
                </div>
                <ul class="tabs d-flex">
                    @foreach ($MainCategory as $cat_key => $category)
                        <li class=" {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                            <a href="javascript:" class="btn-secondary">
                                {{ $category }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                    viewBox="0 0 14 16" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                        fill="white"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            @foreach ($MainCategory as $cat_k => $category)
                <div class="tabs-container">
                    <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                        <div class=" product-tab-slider flex-slider">
                            @foreach ($all_products as $data)
                                @if ($cat_k == '0' || $data->ProductData()->id == $cat_k)
                                    @php
                                        $data_ids = hashidsencode($data->id);
                                    @endphp
                                    <div class="product-card card">
                                        <div class="product-card-inner card-inner">
                                            <div class="card-top">
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
                                                        <span class="badge">
                                                            @if ($saleData['discount_type'] == 'flat')
                                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                                -{{ $saleData['discount_amount'] }}%
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>

                                                    <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly "
                                                        product_id="{{ $data->id }}"
                                                        in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">
                                                        {{ __('Add to wishlist') }}
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </a>
                                            </div>
                                            <div class="product-card-image">
                                                <a href="{{ route('page.product', [$slug, $data_ids]) }}">
                                                    <img src=" {{ get_file($data->cover_image_path, APP_THEME()) }}"
                                                        class="default-img">
                                                </a>
                                            </div>
                                            <div class="card-bottom">
                                                <div class="card-title">
                                                    <h3>
                                                        <a href="{{ route('page.product', [$slug, $data_ids]) }}"
                                                            class="names">
                                                            {{ $data->name }}

                                                        </a>
                                                    </h3>
                                                </div>
                                                {{ $data->ProductData()->name }}
                                                <p class="description">{{ $data->description }}</p>

                                                <div class="card-btn-wrapper">
                                                    @if ($data->variant_product == 0)
                                                        <div class="price">
                                                            <ins>{{ $data->final_price }} <span
                                                                    class="currency-type">{{ $currency }}</span></ins>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
                                                    <a href="javascript:void(0)"
                                                        class="btn  addtocart-btn-cart addcart-btn-globaly"
                                                        product_id="{{ $data->id }}" variant_id="0" qty="1">
                                                        {{ __('ADD TO CART') }}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="16" viewBox="0 0 14 16" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                                fill="#F2DFCE"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                                fill="#F2DFCE"></path>
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
    </section>
    <div class="gradient-bg">
        <section class="card-slider-sec padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12 d-flex">
                        <div class="left-side w-100">
                            <div class="img-box">
                                @php
                                    $homepage_category_title_img = $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_btn_text = '';
                                    $homepage_header_1_key = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_header_1_key != '') {
                                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                        // dd($homepage_header_1);
                                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                            if ($value['field_slug'] == 'homepage-card-bg-img') {
                                                $homepage_category_title_img = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-card-title-text') {
                                                $homepage_category_title_text = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-card-sub-text') {
                                                $homepage_category_sub_text = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-card-btn-text') {
                                                $homepage_category_btn_text = $value['field_default_text'];
                                            }
                                        }
                                    }

                                @endphp
                                @if ($homepage_header_1['section_enable'] == 'on')
                                    <img src="{{ get_file($homepage_category_title_img, APP_THEME()) }}" class="card-img"
                                        alt="img2">
                                    <div class="category-box">
                                        <div class="top-content">
                                            <div class="section-title">
                                                <h2>
                                                    <a href="{{ route('page.product-list', $slug) }}">
                                                        {!! $homepage_category_title_text !!}
                                                    </a>
                                                </h2>
                                            </div>
                                            <p>
                                                {!! $homepage_category_sub_text !!}
                                            </p>
                                        </div>
                                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                            {!! $homepage_category_btn_text !!}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                viewBox="0 0 8 8" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.18164 3.99989C0.181641 3.82416 0.324095 3.68171 0.499822 3.68171L6.73168 3.68171L4.72946 1.67942C4.60521 1.55516 4.60521 1.3537 4.72947 1.22944C4.85373 1.10519 5.05519 1.10519 5.17945 1.22945L7.72482 3.7749C7.84907 3.89916 7.84907 4.10062 7.72482 4.22487L5.17945 6.77033C5.05519 6.89459 4.85373 6.89459 4.72947 6.77034C4.60521 6.64608 4.60521 6.44462 4.72946 6.32036L6.73168 4.31807L0.499822 4.31807C0.324095 4.31807 0.181641 4.17562 0.18164 3.99989Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12  d-flex">
                        <div class="card-right-side w-100">
                            <div class="right-card-slider w-100">
                                {!! \App\Models\MainCategory::HomePageCategory($slug, 4) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="more-pro-sec padding-bottom">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6 col-12">
                        <div class="left-side">
                            @php
                                $homepage_category_title_img = $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_btn_text = '';
                                $homepage_header_1_key = array_search('homepage-slider', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];

                                    // dd($homepage_header_1);
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-slider-title-text') {
                                            $homepage_category_title_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-slider-sub-text') {
                                            $homepage_category_sub_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-slider-btn-text') {
                                            $homepage_category_btn_text = $value['field_default_text'];
                                        }
                                    }
                                }

                            @endphp
                            <div class="section-title">
                                <h2>{!! $homepage_category_title_text !!}</h2>
                            </div>
                            @if ($homepage_header_1['section_enable'] == 'on')
                                <p>{!! $homepage_category_sub_text !!}</p>
                                <div class="btn-wrapper">
                                    @if ($has_subcategory)
                                        <div class="btn-wrapper">
                                            @foreach ($MainCategory as $cat_key => $category)
                                                <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                                    class="btn-secondary">
                                                    {{ $category->name }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                        viewBox="0 0 14 16" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                            fill="white"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </a>
                                            @endforeach

                                        </div>
                                    @else
                                        @foreach ($MainCategoryList as $category)
                                            <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                                class="btn-secondary">{{ $category->name }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                        fill="white"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                        fill="white"></path>
                                                </svg>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                <a href="{{ route('page.product-list', $slug) }}" class="btn white-btn">
                                    {!! $homepage_category_btn_text !!}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                        viewBox="0 0 14 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                            fill="white"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="more-pro-slider">
                            @foreach ($all_products as $data)
                                @php
                                    $product_ids = hashidsencode($data->id);
                                @endphp
                                <div class="more-pro-itm product-card">
                                    <div class="product-card-inner">
                                        <div class="card-top">
                                            <div class="card-title">
                                                <h3>
                                                    <a href="{{ route('page.product-list', $slug) }}" class="names">
                                                        {{ $data->name }}
                                                    </a>
                                                </h3>
                                            </div>
                                            <p class="description">{{ $data->description }}</p>
                                        </div>
                                        <div class="product-card-image">
                                            <a href="">
                                                <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">

                                            </a>
                                        </div>
                                        <div class="card-bottom">
                                            <div class="card-btn-wrapper">
                                                @if ($data->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $data->final_price }} <span
                                                                class="currency-type">{{ $currency }}</span></ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)"
                                                    class="btn  addtocart-btn-cart addcart-btn-globaly"
                                                    product_id="{{ $data->id }}" variant_id="0" qty="1">
                                                    {{ __('ADD TO CART') }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                        viewBox="0 0 14 16" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                            fill="#F2DFCE"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                            fill="#F2DFCE"></path>
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
        </section>
        <section class="three-col-sec padding-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="left-col">
                            <div class="section-title">
                                @php
                                    $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_btn_text = $homepage_info_img = '';
                                    $homepage_header_1_key = array_search('homepage-info', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_header_1_key != '') {
                                        $homepage_header_1 = $theme_json[$homepage_header_1_key];

                                        // dd($homepage_header_1);
                                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                            if ($value['field_slug'] == 'homepage-info-title-text') {
                                                $homepage_category_title_text = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-info-sub-text') {
                                                $homepage_category_sub_text = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-info-btn-text') {
                                                $homepage_category_btn_text = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-info-img') {
                                                $homepage_info_img = $value['field_default_text'];
                                            }
                                        }
                                    }

                                @endphp
                                @if ($homepage_header_1['section_enable'] == 'on')
                                    <h2>{!! $homepage_category_title_text !!}</b></h2>
                            </div>
                            <p>{!! $homepage_category_sub_text !!}</p>
                            <div class="btn-wrapper">
                                <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                    {!! $homepage_category_btn_text !!}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                        viewBox="0 0 14 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                            fill="white"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="img-wrapper">
                            <img src=" {{ get_file($homepage_info_img, APP_THEME()) }}" alt="chocolate">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="right-col">
                            <div class="section-title">
                                <h2>{!! $homepage_category_title_text !!}</h2>
                            </div>
                            <p>{!! $homepage_category_sub_text !!}</p>
                            <div class="btn-wrapper">
                                <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                    {!! $homepage_category_btn_text !!}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                        viewBox="0 0 14 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                            fill="white"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <section class="news-letter-sec">
        <div class="container">
            <div class="news-letter-content padding-bottom">
                <div class="section-title">
                    @php
                        $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_description = '';
                        $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                    $homepage_category_title_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                    $homepage_category_sub_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-newsletter-description') {
                                    $homepage_category_description = $value['field_default_text'];
                                }
                            }
                        }

                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <h2>{!! $homepage_category_title_text !!}</h2>
                </div>
                <p>
                    {!! $homepage_category_sub_text !!}
                </p>
                <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}" method="post">
                    @csrf
                    <div class="input-wrapper">
                        <input type="email" class="input" placeholder="Type your address email..."name="email">
                        <button class="input-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.9595 9.00095C14.2361 8.72433 14.2361 8.27584 13.9595 7.99921L9.70953 3.74921C9.43291 3.47259 8.98441 3.47259 8.70779 3.74921C8.43117 4.02584 8.43117 4.47433 8.70779 4.75095L12.4569 8.50008L8.70779 12.2492C8.43117 12.5258 8.43117 12.9743 8.70779 13.2509C8.98441 13.5276 9.4329 13.5276 9.70953 13.2509L13.9595 9.00095ZM4.04286 13.2509L8.29286 9.00095C8.56948 8.72433 8.56948 8.27584 8.29286 7.99921L4.04286 3.74921C3.76624 3.47259 3.31775 3.47259 3.04113 3.74921C2.7645 4.02583 2.7645 4.47433 3.04113 4.75095L6.79026 8.50008L3.04112 12.2492C2.7645 12.5258 2.7645 12.9743 3.04112 13.2509C3.31775 13.5276 3.76624 13.5276 4.04286 13.2509Z"
                                    fill="#9E715D" />
                            </svg>
                        </button>
                    </div>
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <label>
                            {!! $homepage_category_description !!}
                        </label>
                    @endif
                </form>
                @endif
            </div>
        </div>
    </section>
    <section class="blog-sec padding-bottom">
        <div class="container">
            <div class="dark-p">
                @php
                    $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_description = '';
                    $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_category_title_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_category_sub_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title">
                        <h2>{!! $homepage_category_title_text !!} </h2>
                    </div>
                    <p>
                        {!! $homepage_category_sub_text !!}
                    </p>
                @endif
            </div>
            <div class="blog-main">
                <div class="blog-main-slider flex-slider">
                    {!! \App\Models\Blog::HomePageBlog($slug, $no = 6) !!}
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials-sec padding-bottom">
        <div class=" container">
            <div class="section-title-main d-flex justify-content-between align-items-center">
                <div class="left-side">
                    @php
                        $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_btn_text = '';
                        $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            // dd($homepage_header_1);
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                    $homepage_category_title_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                    $homepage_category_sub_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                    $homepage_category_btn_text = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title">
                            <h2>{!! $homepage_category_title_text !!}</h2>
                        </div>
                        <p>
                            {!! $homepage_category_sub_text !!}
                        </p>
                </div>
                <div class="right-side">
                    <a href="javascript:void(0)" class=" btn">
                        {!! $homepage_category_btn_text !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.18164 3.99989C0.181641 3.82416 0.324095 3.68171 0.499822 3.68171L6.73168 3.68171L4.72946 1.67942C4.60521 1.55516 4.60521 1.3537 4.72947 1.22944C4.85373 1.10519 5.05519 1.10519 5.17945 1.22945L7.72482 3.7749C7.84907 3.89916 7.84907 4.10062 7.72482 4.22487L5.17945 6.77033C5.05519 6.89459 4.85373 6.89459 4.72947 6.77034C4.60521 6.64608 4.60521 6.44462 4.72946 6.32036L6.73168 4.31807L0.499822 4.31807C0.324095 4.31807 0.181641 4.17562 0.18164 3.99989Z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
            <div class="testimonials-main">
                <div class="testi-slider flex-slider">
                    @foreach ($reviews as $review)
                        <div class="testi-card card">
                            <div class="testi-card-inner card-inner">
                                <div class="img-wrapper">
                                    <img src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}"
                                        alt="chocolate">
                                </div>
                                <div class="content">
                                    <div class="title">
                                        <h3>{{ $review->title }}</h3>
                                        <div class="ratings d-flex align-items-center justify-content-end">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="descriptions">
                                        {{ $review->description }}
                                    </p>
                                    <h6>
                                        {{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                        <span>{{ __('client') }}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--cart popup start-->

    <!-- video popup -->

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
                <iframe width="560" height="315" src="{{ asset($baner_video) }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
