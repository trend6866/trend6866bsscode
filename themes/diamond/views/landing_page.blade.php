@extends('layouts.layouts')

@section('page-title')
{{ __('Diamond') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
<body class="home">
@php
    $homepage_banner_title = $homepage_banner_sub_text = $homepage_banner_img = $homepage_banner_heading1 = $homepage_banner_icon_img1 = $homepage_banner_heading2 = $homepage_banner_icon_img2 = $homepage_banner_promotion_title1 = $homepage_banner_promotion_icon1 = $homepage_banner_promotion_title2 = $homepage_banner_promotion_icon2 = '';

    @endphp
    <div>
        <section class="main-home-section">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/desing-circle.png') }}" class="desing-circle1" alt="desing-circle">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/desing-circle2.png')}}" class="desing-circle2" alt="desing-circle2">
            @php
                $homepage_banner_section = '';
                $homepage_banner_section = array_search('home-main-slider', array_column($theme_json, 'unique_section_slug'));
                if($homepage_banner_section != ''){
                    $homepage_banner = $theme_json[$homepage_banner_section];

                }
            @endphp
            <div class="home-main-slider">
                @for($i=0 ; $i < $homepage_banner['loop_number'];$i++)
                    @php
                        foreach ($homepage_banner['inner-list'] as $homepage_banner_value)
                        {
                            if($homepage_banner_value['field_slug'] == 'home-main-slider-title') {
                                $homepage_banner_title = $homepage_banner_value['field_default_text'];
                            }
                            if($homepage_banner_value['field_slug'] == 'home-main-slider-sub-text') {
                                $homepage_banner_sub_text = $homepage_banner_value['field_default_text'];
                            }
                            if($homepage_banner_value['field_slug'] == 'home-main-slider-button') {
                                $homepage_banner_btn = $homepage_banner_value['field_default_text'];
                            }
                            if($homepage_banner_value['field_slug'] == 'home-main-slider-image') {
                                $homepage_banner_img = $homepage_banner_value['field_default_text'];
                            }

                            if(!empty($homepage_banner[$homepage_banner_value['field_slug']]))
                            {
                                if($homepage_banner_value['field_slug'] == 'home-main-slider-image'){
                                    $homepage_banner_img = $homepage_banner[$homepage_banner_value['field_slug']][$i]['field_prev_text'];
                                }
                                if($homepage_banner_value['field_slug'] == 'home-main-slider-title'){
                                    $homepage_banner_title = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if($homepage_banner_value['field_slug'] == 'home-main-slider-sub-text'){
                                    $homepage_banner_sub_text = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                                    if($homepage_banner_value['field_slug'] == 'home-main-slider-button'){
                                        $homepage_banner_btn = $homepage_banner[$homepage_banner_value['field_slug']][$i];
                                    }
                            }
                        }
                    @endphp
                    <div class="home-slide slide1 slick-slide slick-current slick-active">
                        <div class=" container">
                            <div class="home-slider-wrapper">
                                <div class="home-main">
                                    <div class="home-title section-title">
                                        {!! $homepage_banner_title !!}
                                        {!! $homepage_banner_sub_text !!}
                                        <a href="{{route('page.product-list',$slug)}}" class="home-btn btn">
                                            {{ $homepage_banner_btn }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ring1" style="background-image: url('{{ get_file($homepage_banner_img, APP_THEME()) }}'); ">
                        </div>
                    </div>
                @endfor
            </div>
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">  </div>
        </section>
        <div class="main-top">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/top-main-desing.png') }}" class="half-ring-design" alt="top-main-desing">
            <section class="card-sec padding-bottom">
                <div class=" container">
                    <div class="row">
                        @foreach ($bestSeller->take(1) as $best)
                            @php
                                $p_id = hashidsencode($best->id);
                            @endphp
                            <div class="col-md-6 col-12 img-main-box">
                                <div class="img-box">
                                    <img src="{{ get_file($best->cover_image_path , APP_THEME()) }}" class="card-img" alt="img2">
                                    <div class="inner-text">
                                        <div class="top-title">
                                            {{ __('homepage') }}
                                            <span>{{ __('CATEGORIES') }}</span>
                                            <h3>
                                                <a href="#">
                                                    {{ __('Bestsellers') }}
                                                </a>
                                            </h3>
                                        </div>
                                        <a href="{{route('page.product-list',[$slug,'main_category' => $best->id ])}}" class="btn">
                                            {{ __('Check more products') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($trending_categories as $category)
                            @php
                                $p_id = hashidsencode($category->id);
                                $wishlist = App\Models\Wishlist::where('product_id',$category->id)->where('theme_id',APP_THEME())->first();
                            @endphp
                            <div class="col-lg-3 col-sm-6  col-12 img-main-box">
                                <div class="img-box">
                                    <img src=" {{ get_file($category->image_path , APP_THEME()) }}" class="card-img" alt="img2">
                                    <div class="inner-text">
                                        <div class="top-title">
                                            <span>{{ __('CATEGORIES') }}</span>
                                            <h3>
                                                <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">
                                                   {{ $category->name }}
                                                </a>
                                                </h3>
                                        </div>
                                        <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class=" btn">
                                           {{__('Check more products')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </section>
            <section class="service-tag-div padding-bottom">
                <div class=" container">
                    <div class="service-tag">
                        @php
                        $home_service_logo = '';

                        $home_service_logo = array_search('homepage-service-tag', array_column($theme_json, 'unique_section_slug'));
                        if($home_service_logo != '') {
                            $home_service_logo_title = $theme_json[$home_service_logo];
                        }
                        @endphp
                        @for($i=0 ; $i < $home_service_logo_title['loop_number'];$i++)
                            @php
                                foreach ($home_service_logo_title['inner-list'] as $homepage_logo_value)
                                {
                                    if($homepage_logo_value['field_slug'] == 'homepage-service-tag-service-tag') {
                                        $homepage_service_logo_image = $homepage_logo_value['field_default_text'];
                                    }

                                    if($homepage_logo_value['field_slug'] == 'homepage-service-tag-title') {
                                        $home_service_tag_sec_title_text = $homepage_logo_value['field_default_text'];
                                    }


                                    if($homepage_logo_value['field_slug'] == 'homepage-service-tag-sub-text') {
                                        $home_service_tag_sec_sub_text = $homepage_logo_value['field_default_text'];
                                    }

                                    if(!empty($home_service_logo_title[$homepage_logo_value['field_slug']]))
                                    {
                                        if($homepage_logo_value['field_slug'] == 'homepage-service-tag-service-tag'){
                                            $homepage_service_logo_image = $home_service_logo_title[$homepage_logo_value['field_slug']][$i]['field_prev_text'];

                                        }
                                        if($homepage_logo_value['field_slug'] == 'homepage-service-tag-title'){
                                            $home_service_tag_sec_title_text = $home_service_logo_title[$homepage_logo_value['field_slug']][$i];
                                        }
                                        if($homepage_logo_value['field_slug'] == 'homepage-service-tag-sub-text'){
                                        $home_service_tag_sec_sub_text = $home_service_logo_title[$homepage_logo_value['field_slug']][$i];

                                        }

                                    }
                                }
                            @endphp
                             <div class="d-flex align-items-center service-tag-inner">
                                <img src="{{get_file($homepage_service_logo_image,APP_theme())}}" width="32" height="33"  viewBox="0 0 32 33">
                                    <div class="service-text">
                                        <b>{{ $home_service_tag_sec_title_text }}</b>
                                        <span>{{ $home_service_tag_sec_sub_text }}</span>
                                    </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </section>
            <section class="best-product-sec padding-bottom">
                @php
                    $home_best_product_sec = '';

                    $home_best_product_sec = array_search('homepage-section-title', array_column($theme_json, 'unique_section_slug'));
                    if($home_best_product_sec != '' ){
                        $home_best_product_sec_value = $theme_json[$home_best_product_sec];

                        foreach ($home_best_product_sec_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'homepage-section-title-text') {
                                $home_best_product_sec_title_text = $value['field_default_text'];
                            }
                             if($value['field_slug'] == 'homepage-section-title-sub-text') {
                                $home_best_product_sec_sub_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-section-title-button') {
                                $home_best_product_sec_btn = $value['field_default_text'];
                            }
                            if(!empty($home_best_product_sec_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'homepage-section-title-text'){
                                    $home_best_product_sec_title_text = $home_best_product_sec_value[$value['field_slug']][$i]['field_prev_text'];

                                }
                                if($value['field_slug'] == 'homepage-section-title-sub-text'){
                                    $home_best_product_sec_sub_text = $home_best_product_sec_value[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'homepage-section-title-button'){
                                $home_best_product_sec_btn = $home_best_product_sec_value[$value['field_slug']][$i];

                                }

                            }

                        }

                    }
                @endphp
                <div class=" container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="section-title">
                                {!! $home_best_product_sec_title_text !!}
                                <p>
                                    {{ $home_best_product_sec_sub_text }}
                                </p>
                                <a href="{{route('page.product-list',$slug)}}" class="btn">
                                   {{ $home_best_product_sec_btn }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                            fill="#F2DFCE" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                            fill="#F2DFCE" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @foreach ($homepage_products as $home_product)
                            @php
                                $p_id = hashidsencode($home_product->id);
                                $wishlist = App\Models\Wishlist::where('product_id',$home_product->id)->where('theme_id',APP_THEME())->first();
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="product-card">
                                    <div class="card-top">
                                        <div class="card-title">
                                            <span>{{!empty($home_product->ProductData()) ? $home_product->ProductData()->name : ''}}</span>
                                            <h3>
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{ $home_product->name }}
                                                </a>
                                            </h3>
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
                                                            if (is_array($saleEnableArray) && in_array($home_product->id, $saleEnableArray)) {
                                                                $latestSales[$home_product->id] = [
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
                                        </div>
                                        <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"  product_id="{{$home_product->id}}" in_wishlist="{{ $home_product->in_whishlist ? 'remove' : 'add'}}">
                                            <span class="wish-ic">
                                               <i class="{{ $home_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                               <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $home_product->in_whishlist ? 'remove' : 'add'}}">
                                           </span>
                                         </a>
                                    </div>
                                    <div class="product-card-image">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                                            <img src="{{get_file($home_product->cover_image_path, APP_THEME())}}" class="default-img">
                                            @if ($home_product->Sub_image($home_product->id)['status'] == true)
                                                <img src="{{ get_file($home_product->Sub_image($home_product->id)['data'][0]->image_path , APP_THEME()) }}"
                                                    class="hover-img">
                                            @else
                                                <img src="{{ get_file($home_product->Sub_image($home_product->id) , APP_THEME()) }}" class="hover-img">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="card-bottom">
                                        @if ($home_product->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $home_product->final_price }} <span class="currency-type">{{ $currency_icon }}</span></ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif

                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $home_product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        <section class="card-slider-sec bg-style">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/top-main-desing.png') }}" class="half-ring-design2" alt="top-main-desing">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/dd.png') }}" class="desing-circle3" alt="desing-circle3">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/desing-circle2.png') }}" class="desing-circle4" alt="desing-circle4">
            <div class="container">
                @php
                    $home_product_title = '';

                    $homepage_sec_titile = array_search('home-product-list', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_sec_titile != '' ){
                        $homepage_sec_titile_value = $theme_json[$homepage_sec_titile];

                        foreach ($homepage_sec_titile_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'home-product-list-title') {
                                $home_product_title_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-product-list-button') {
                                $home_product_title_btn = $value['field_default_text'];
                            }
                            //Dynamic
                            if(!empty($homepage_sec_titile_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-product-list-title'){
                                    $home_product_title_text = $homepage_sec_titile_value[$value['field_slug']][$i]['field_prev_text'];

                                }
                                if($value['field_slug'] == 'home-product-list-button'){
                                    $home_product_title_btn = $homepage_sec_titile_value[$value['field_slug']][$i];
                                }

                            }

                        }
                    }

                    $homepage_product_info_titile = '';

                    $homepage_product_info_titile = array_search('home-product-info', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_product_info_titile != '' ){
                        $homepage_product_info_titile_value = $theme_json[$homepage_product_info_titile];
                        foreach ($homepage_product_info_titile_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'home-product-info-title') {
                                $homepage_product_info_titile_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-product-info-sub-text') {
                                $homepage_product_info_subtext = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-product-info-button') {
                                $homepage_product_info_btn = $value['field_default_text'];
                            }

                            if($value['field_slug'] == 'home-product-info-image') {
                                $homepage_product_info_image = $value['field_default_text'];
                            }

                            //Dynamic
                            if(!empty($homepage_product_info_titile_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-product-info-title'){
                                    $homepage_product_info_titile_text = $homepage_product_info_titile_value[$value['field_slug']][$i]['field_prev_text'];

                                }
                                if($value['field_slug'] == 'home-product-info-sub-text'){
                                    $homepage_product_info_subtext = $homepage_product_info_titile_value[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'home-product-info-button'){
                                    $homepage_product_info_btn = $homepage_product_info_titile_value[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'home-product-info-image'){
                                    $homepage_product_info_image = $homepage_product_info_titile_value[$value['field_slug']][$i];
                                }

                            }
                        }
                    }
                @endphp

                <div class="card-slider-title sec-head d-flex justify-content-between align-items-end">
                   {!! $home_product_title_text !!}
                    <a href="{{ route('page.product-list',$slug) }}" class=" btn">
                        {{  $home_product_title_btn }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                fill="#F2DFCE" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                fill="#F2DFCE" />
                        </svg>
                    </a>
                </div>
                <div class="card-slider-main padding-bottom">
                    @foreach ($all_products as $product)
                        @php
                            $p_id = hashidsencode($product->id);
                            $wishlist = App\Models\Wishlist::where('product_id',$product->id)->where('theme_id',APP_THEME())->first();
                        @endphp
                        <div class="card-slides">
                            <div class="product-card">
                                <div class="card-top">
                                    <div class="card-title">
                                        <span>{{!empty($product->ProductData()) ? $product->ProductData()->name : ''}}</span>
                                        <h3>
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                            {{ $product->name }}
                                            </a>
                                        </h3>
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
                                    </div>
                                        <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                            <span class="wish-ic">
                                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                        </span>
                                        </a>
                                </div>
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{get_file($product->cover_image_path, APP_THEME())}}" class="default-img">
                                        @if ($product->Sub_image($product->id)['status'] == true)

                                            <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}"
                                                class="hover-img">
                                        @else
                                            <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-bottom">
                                    @if ($product->variant_product == 0)
                                        <div class="price">
                                            <ins>{{ $product->final_price }} <span class="currency-type">{{ $currency_icon }}</span></ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif
                                    <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                                        {{ __('Add to cart') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                fill="#F2DFCE" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                fill="#F2DFCE" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="product-info">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6 col-sm-7 col-12">
                            <div class="section-title">
                               {!! $homepage_product_info_titile_text !!}
                                <p>
                                    {{ $homepage_product_info_subtext }}
                                </p>
                                <a href="{{route('page.product-list',$slug)}}" class=" btn">
                                    {{ $homepage_product_info_btn }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                            fill="#F2DFCE" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                            fill="#F2DFCE" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-5 col-12">
                            <div class="img-wrapper ">
                                <img src="{{get_file($homepage_product_info_image,APP_THEME())}}" alt="grp-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product-ring-slider padding-bottom">
            @php
                 $home_ring_slider = '';

                    $homepage_ring_slider = array_search('home-product-ring', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_ring_slider != '' ){
                        $homepage_ring_slider_value = $theme_json[$homepage_ring_slider];

                        foreach ($homepage_ring_slider_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'home-product-ring-title') {
                                $home_ring_title_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-product-ring-button') {
                                $home_ring_title_btn = $value['field_default_text'];
                            }

                             //Dynamic
                            if(!empty($homepage_ring_slider_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-product-ring-title'){
                                    $home_ring_title_text = $homepage_ring_slider_value[$value['field_slug']][$i];

                                }
                                if($value['field_slug'] == 'home-product-info-sub-text'){
                                    $home_ring_title_btn = $homepage_ring_slider_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
            @endphp
            <div class=" container">
                <div class=" sec-head d-flex justify-content-between align-items-end">
                   {!! $home_ring_title_text !!}
                    <a href="{{route('page.product-list',$slug)}}" class=" btn">
                       {{ $home_ring_title_btn }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                fill="#F2DFCE" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                fill="#F2DFCE" />
                        </svg>
                    </a>
                </div>
                <div class="pro-ring-main">
                    @foreach ($homepage_products as $homepage)
                        @php
                            $p_id = hashidsencode($homepage->id);
                            $wishlist = App\Models\Wishlist::where('product_id',$homepage->id)->where('theme_id',APP_THEME())->first();
                        @endphp
                        <div class="pro-ring-div">
                            <div class="product-card-image">
                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                    <img src="{{get_file($homepage->cover_image_path, APP_THEME())}}" class="default-img">
                                    @if ($homepage->Sub_image($homepage->id)['status'] == true)
                                        <img src="{{ get_file($homepage->Sub_image($homepage->id)['data'][0]->image_path , APP_THEME()) }}"
                                            class="hover-img">
                                    @else
                                        <img src="{{ get_file($homepage->Sub_image($homepage->id) , APP_THEME()) }}" class="hover-img">
                                    @endif
                                </a>
                            </div>
                            <div class="pro-ring-content">
                                <div class="product-card">
                                    <div class="card-top">
                                        <div class="card-title">
                                            <span>{{!empty($homepage->ProductData()) ? $homepage->ProductData()->name : ''}}</span>
                                            <h3>
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                {{ $homepage->name }}
                                                </a>
                                            </h3>
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
                                                            if (is_array($saleEnableArray) && in_array($homepage->id, $saleEnableArray)) {
                                                                $latestSales[$homepage->id] = [
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
                                        </div>
                                    </div>
                                    <div class="card-bottom">
                                        @if ($homepage->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $homepage->final_price }} <span class="currency-type">{{ $currency_icon }}</span></ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
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
        <div class="bg-style">
            <section class="pro-card-sec padding-bottom">
                <div class=" container">
                    @php
                        $home_pro_card_sec = '';

                        $home_pro_card_sec = array_search('home-pro-card-section', array_column($theme_json, 'unique_section_slug'));
                        if($home_pro_card_sec != '' ){
                            $home_pro_card_sec_value = $theme_json[$home_pro_card_sec];

                            foreach ($home_pro_card_sec_value['inner-list'] as $key => $value) {

                                if($value['field_slug'] == 'home-pro-card-section-title') {
                                    $home_pro_card_sec_text = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'home-pro-card-section-button') {
                                    $home_pro_card_sec_btn = $value['field_default_text'];
                                }

                                //Dynamic
                                if(!empty($home_pro_card_sec_value[$value['field_slug']]))
                                {
                                    if($value['field_slug'] == 'home-pro-card-section-title'){
                                        $home_pro_card_sec_text = $home_pro_card_sec_value[$value['field_slug']][$i];

                                    }
                                    if($value['field_slug'] == 'home-pro-card-section-button'){
                                        $home_pro_card_sec_btn = $home_pro_card_sec_value[$value['field_slug']][$i];
                                    }
                                }
                            }
                        }
                    @endphp

                    <div class=" sec-head d-flex justify-content-between align-items-end">
                        {!! $home_pro_card_sec_text !!}
                        <a href="{{route('page.product-list',$slug)}}" class=" btn">
                           {{ $home_pro_card_sec_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                    fill="#F2DFCE" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                    fill="#F2DFCE" />
                            </svg>
                        </a>
                    </div>
                    <div class="row">
                        @foreach ($home_products as $product)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="product-card">
                                    <div class="card-top">
                                        <div class="card-title">
                                            <span>{{!empty($product->ProductData()) ? $product->ProductData()->name : ''}}</span>
                                            <h3>
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>
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
                                        </div>
                                            <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                                <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                            </span>
                                            </a>
                                    </div>
                                    <div class="product-card-image">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                                            <img src="{{get_file($product->cover_image_path, APP_THEME())}}" class="default-img">
                                            @if ($product->Sub_image($product->id)['status'] == true)
                                                <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}"
                                                    class="hover-img">
                                            @else
                                                <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="card-bottom">
                                        @if ($product->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $product->final_price }} <span class="currency-type">{{ $currency_icon }}</span></ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="our-pro-shop-sec padding-bottom">
                <div class=" container">
                    @php
                        $home_pro_shop = '';

                            $home_pro_shop = array_search('home-our-pro-shop-section', array_column($theme_json, 'unique_section_slug'));
                            if($home_pro_shop != '' ){
                                $home_pro_shop_value = $theme_json[$home_pro_shop];
                                foreach ($home_pro_shop_value['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'home-our-pro-shop-section-title') {
                                        $home_pro_shop_text = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'home-our-pro-shop-section-sub-text') {
                                        $home_pro_shop_sub_text = $value['field_default_text'];
                                    }

                                    if($value['field_slug'] == 'home-our-pro-shop-section-button') {
                                        $home_pro_shop_btn = $value['field_default_text'];
                                    }

                                    if($value['field_slug'] == 'home-our-pro-shop-section-image') {
                                        $home_pro_shop_img = $value['field_default_text'];
                                    }

                                     //Dynamic
                                    if(!empty($home_pro_shop_value[$value['field_slug']]))
                                    {
                                        if($value['field_slug'] == 'home-our-pro-shop-section-title'){
                                            $home_pro_shop_text = $home_pro_shop_value[$value['field_slug']][$i];

                                        }
                                        if($value['field_slug'] == 'home-our-pro-shop-section-sub-text'){
                                            $home_pro_shop_sub_text = $home_pro_shop_value[$value['field_slug']][$i];
                                        }
                                        if($value['field_slug'] == 'home-our-pro-shop-section-button'){
                                            $home_pro_shop_btn = $home_pro_shop_value[$value['field_slug']][$i];
                                        }
                                        if($value['field_slug'] == 'home-our-pro-shop-section-image'){
                                            $home_pro_shop_img = $home_pro_shop_value[$value['field_slug']][$i];
                                        }
                                    }
                                }
                            }
                            
                    @endphp

                     <div class="our-pro-shop-main">
                        <div class="section-title">
                            {!! $home_pro_shop_text !!}
                            <p>
                               {{ $home_pro_shop_sub_text }}
                            </p>
                            <a href="{{route('page.product-list',$slug)}}" class="home-btn btn">
                                {{ $home_pro_shop_btn }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                        fill="#F2DFCE" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                        fill="#F2DFCE" />
                                </svg>
                            </a>
                        </div>
                        <div class="img-wrapper">
                            @if($latest_product)
                            <img src="{{get_file($latest_product->cover_image_path, APP_THEME())}}" alt="two-ring">
                            <div class="ring-label">
                                @php
                                    $p_id = hashidsencode($latest_product->id);
                                    $truncated = (strlen($latest_product->name) > 10) ? substr($latest_product->name, 0, 10) . '...' : $latest_product->name;
                                @endphp
                                <span>{{ $truncated }}</span>
                                <div>{{!empty($latest_product->ProductData()) ? $latest_product->ProductData()->name : ''}}</div>
                                <ins>{{ $latest_product->price }}{{ $currency_icon }}</ins>
                                <a href="{{route('page.product',[$slug,$p_id])}}">more</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <section class="logo-slider">
                @php
                    $home_logo_slider = '';

                    $home_logo_slider = array_search('home-logo-slider', array_column($theme_json, 'unique_section_slug'));
                    if($home_logo_slider != '' ){
                        $home_logo_slider_partner_value = $theme_json[$home_logo_slider];

                        foreach ($home_logo_slider_partner_value['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-logo-slider-label') {
                                $home_logo_slider_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-logo-slider-image') {
                                $home_logo_slider_img = $value['field_default_text'];
                            }

                                //Dynamic
                            if(!empty($home_logo_slider_partner_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-logo-slider-label'){
                                    $home_logo_slider_text = $home_logo_slider_partner_value[$value['field_slug']][$i];

                                }
                            }
                        }
                    }
                    // dd($home_logo_slider_partner_value);
                @endphp

                <div class=" container">
                    <div class="main-title">
                        <h2>{{ $home_logo_slider_text }}</h2>
                    </div>
                    <div class="logo-slider-main">
                        @php
                        $home_logo = '';

                        $home_logo = array_search('home-logo-slider', array_column($theme_json, 'unique_section_slug'));
                        if($home_logo != '') {
                            $home_logo_title = $theme_json[$home_logo];
                        }
                        @endphp
                        @php
                            $homepage_logo = '';
                            $homepage_logo_key = array_search('home-logo-slider', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_logo_key != ''){
                                $homepage_main_logo = $theme_json[$homepage_logo_key];
                            }
                        @endphp
                        @if(!empty($home_logo_title['home-logo-slider']))
                        @for($i=0 ; $i < $home_logo_slider_partner_value['loop_number'];$i++)
                            @php
                                foreach ($home_logo_title['inner-list'] as $homepage_logo_value)
                                {
                                    if($homepage_logo_value['field_slug'] == 'home-logo-slider-image') {
                                        $homepage_logo_image = $homepage_logo_value['field_default_text'];
                                    }

                                    if(!empty($home_logo_title[$homepage_logo_value['field_slug']]))
                                    {
                                        if($homepage_logo_value['field_slug'] == 'home-logo-slider-image'){
                                            $homepage_logo_image = $home_logo_title[$homepage_logo_value['field_slug']][$i]['field_prev_text'];

                                        }
                                    }
                                }
                            @endphp
                            <div class="logo-slide-wrapper">
                                <a href="#">
                                    <img src="{{ get_file($homepage_logo_image, APP_THEME()) }}" alt="logo">
                                </a>
                            </div>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 6; $i++)
                            @php
                                foreach ($home_logo_title['inner-list'] as $homepage_logo_value)
                                {
                                    if($homepage_logo_value['field_slug'] == 'home-logo-slider-image'){
                                        $homepage_logo_image = $homepage_logo_value['field_default_text'];

                                    }
                                }
                            @endphp
                            <div class="logo-slide-wrapper">
                                <a href="#">
                                    <img src="{{asset($homepage_logo_image)}}" alt="logo">
                                </a>
                            </div>
                        @endfor
                        @endif
                </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="main-bottom">
            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/ring5.png') }}" class="ring-img" alt="ring">
            @php
                $home_section_title = '';

                $homepage_sec_titile = array_search('home-section-title', array_column($theme_json, 'unique_section_slug'));
                if($homepage_sec_titile != '' ){
                    $homepage_sec_titile_value = $theme_json[$homepage_sec_titile];

                    foreach ($homepage_sec_titile_value['inner-list'] as $key => $value) {

                        if($value['field_slug'] == 'home-section-title-title') {
                            $home_section_title_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'home-section-title-sub-text') {
                            $home_section_title_sub_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'home-section-title-button') {
                            $home_section_title_btn = $value['field_default_text'];
                        }
                        //Dynamic
                        if(!empty($homepage_sec_titile_value[$value['field_slug']]))
                        {
                            if($value['field_slug'] == 'home-section-title-title'){
                                $home_section_title_text = $homepage_sec_titile_value[$value['field_slug']][$i];

                            }
                            if($value['field_slug'] == 'home-section-title-sub-text'){
                                $home_section_title_sub_text = $homepage_sec_titile_value[$value['field_slug']][$i];

                            }
                            if($value['field_slug'] == 'home-section-title-button'){
                                $home_section_title_btn = $homepage_sec_titile_value[$value['field_slug']][$i];

                            }

                        }


                    }
                }

            @endphp
            <section class=" card-sec padding-bottom">
                <div class=" container">
                    <div class="row">
                        <div class="col-lg-6 col-12 img-main-box">
                            @if ($homepage_sec_titile_value['section_enable'] == 'on')
                                <div class="section-title">
                                    {!! $home_section_title_text !!}
                                    <p>
                                        {{ $home_section_title_sub_text }}
                                    </p>
                                    <a href="{{route('page.product-list',$slug)}}" class="home-btn btn">
                                        {{ $home_section_title_btn }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                fill="#F2DFCE" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                fill="#F2DFCE" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                        @foreach ($trending_categories->take(2) as $m_pro)
                            <div class="col-lg-3 col-sm-6  col-12 img-main-box">
                                <div class="img-box">

                                    <img src="{{get_file($m_pro->image_path, APP_THEME())}}" class="card-img" alt="img2">
                                    <div class="inner-text">
                                        <div class="top-title">
                                            <span>{{ __('CATEGORIES') }}</span>
                                            <h3>
                                                <a href="{{route('page.product-list',[$slug,'main_category' => $m_pro->id ])}}">
                                               {{ $m_pro->name }}
                                                </a>
                                            </h3>

                                        </div>
                                        <a href="{{route('page.product-list',[$slug,'main_category' => $m_pro->id ])}}" class=" btn">
                                            {{ $home_section_title_btn }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="testimonials-sec padding-bottom">
                @php
                    $homepage_testmonials_title = '';

                    $homepage_testmonials = array_search('home-testimonials-section', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_testmonials != '' ){
                        $homepage_testmonials_value = $theme_json[$homepage_testmonials];

                        foreach ($homepage_testmonials_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'home-testimonials-section-title') {
                                $homepage_testmonials_title = $value['field_default_text'];
                            }

                            //Dynamic
                            if(!empty($homepage_testmonials_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-testimonials-section-title'){
                                    $homepage_testmonials_title = $homepage_testmonials_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp
                <div class="container">
                    @if($homepage_testmonials_value['section_enable'] == 'on')
                        <div class="main-title">
                            <h2>{{ $homepage_testmonials_title }}</h2>
                        </div>
                    @endif
                    <div class="testi-main">
                        @foreach ($reviews as $review)
                            <div class="testi-slide">
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}" class="default-img">

                                        <img src="{{ asset('themes/'.APP_THEME().'/assets/images/placholder.png') }}" class="hover-img">
                                    </a>
                                </div>
                                <div class="testi-content">
                                    <div class="title">
                                        <h3>{{$review->title}}</h3>
                                        <div class="star ratings d-flex align-items-center justify-content-end">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>

                                            @endfor
                                            <span>{{ $review->rating_no }}/ 5.0</span>
                                        </div>
                                    </div>
                                    <p>
                                        {{ $review->description }}
                                    </p>
                                    <h6>
                                        {{!empty($review->UserData()) ? $review->UserData->first_name : '' }},
                                        <span>client</span>
                                    </h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="blog-sec padding-bottom">
                <div class="container">
                    @php
                        $homepage_blogs_title = '';

                        $homepage_blogs = array_search('home-blog-section', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_blogs != '' ){
                            $homepage_blogs_value = $theme_json[$homepage_blogs];

                            foreach ($homepage_blogs_value['inner-list'] as $key => $value) {

                                if($value['field_slug'] == 'home-blog-section-title') {
                                    $homepage_blogs_title = $value['field_default_text'];
                                }
                                //Dynamic
                                if(!empty($homepage_blogs_value[$value['field_slug']]))
                                {
                                    if($value['field_slug'] == 'home-blog-section-title'){
                                        $homepage_blogs_title = $homepage_blogs_value[$value['field_slug']][$i];
                                    }
                                }

                            }
                        }
                    @endphp
                    <div class="main-title">
                        <h2> {{$homepage_blogs_title }} </h2>
                    </div>
                    {!! \App\Models\Blog::HomePageBlog($slug,10) !!}
                </div>
            </section>
            <section class="subscribe-our-sec">
                <div class=" container">
                    <div class="sec-head d-flex justify-content-between align-items-center ">
                        @php
                            $homepage_subscribe_title = '';

                            $homepage_subscribe = array_search('home-subscribe-our-section', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_subscribe != '' ){
                                $homepage_subscribe_value = $theme_json[$homepage_subscribe];

                                foreach ($homepage_subscribe_value['inner-list'] as $key => $value) {

                                    if($value['field_slug'] == 'home-subscribe-our-section-title') {
                                        $homepage_subscribe_title = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'home-subscribe-our-section-tag') {
                                        $homepage_subscribe_tag = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'home-subscribe-our-section-label') {
                                        $homepage_subscribe_label = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'home-subscribe-our-section-image') {
                                        $homepage_subscribe_image = $value['field_default_text'];
                                    }

                                     //Dynamic
                                    if(!empty($homepage_subscribe_value[$value['field_slug']]))
                                    {
                                        if($value['field_slug'] == 'home-subscribe-our-section-title'){
                                            $homepage_subscribe_title = $homepage_subscribe_value[$value['field_slug']][$i];
                                        }
                                        if($value['field_slug'] == 'home-subscribe-our-section-tag'){
                                            $homepage_subscribe_tag = $homepage_subscribe_value[$value['field_slug']][$i];
                                        }
                                        if($value['field_slug'] == 'home-subscribe-our-section-label'){
                                            $homepage_subscribe_label = $homepage_subscribe_value[$value['field_slug']][$i];
                                        }
                                        if($value['field_slug'] == 'home-subscribe-our-section-image'){
                                            $homepage_subscribe_image = $homepage_subscribe_value[$value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            }
                        @endphp
                        <h2>   {{ $homepage_subscribe_title }} </h2>
                        <div class="insta-pro">
                            <div class="insta-pro-info">
                                <span>{{ $homepage_subscribe_tag }}</span>
                                <a href="https://www.instagram.com/" target="_blank">
                                    {{ $homepage_subscribe_label }}
                                </a>
                            </div>
                            <div class="insta-pro-img">
                                <a href="https://www.instagram.com/">
                                    <img src="{{ get_file($homepage_subscribe_image, APP_THEME()) }}" alt="insta-pro">
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
                    <ul>
                        {{-- @for ($i = 0; $i <= 3; $i++)
                            @php
                                foreach ($homepage_subscribe_value['inner-list'] as $homepage_subscribe_value_value)
                                {
                                    if($homepage_subscribe_value_value['field_slug'] == 'home-subscribe-our-section-subscribe-user-image'){
                                        $homepage_logo = $homepage_subscribe_value_value['field_default_text'];
                                    }

                                     //Dynamic
                                    if(!empty($homepage_subscribe_value[$homepage_subscribe_value_value['field_slug']]))
                                    {
                                        if($homepage_subscribe_value_value['field_slug'] == 'home-subscribe-our-section-subscribe-user-image'){
                                            $homepage_logo = $homepage_subscribe_value[$homepage_subscribe_value_value['field_slug']][$i]['field_prev_text'];

                                        }
                                    }

                                }
                            @endphp
                            <li>
                                <a href="#" class="img-wrapper">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="pic">
                                </a>
                            </li>
                        @endfor --}}
                        @php
                            $homepage_image = '';
                            $homepage_image_key = array_search('home-subscribe-our-section', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_image_key != ''){
                                $homepage_main_image = $theme_json[$homepage_image_key];
                            }
                        @endphp
                        @if(!empty($homepage_main_image['home-subscribe-our-section-subscribe-user-image']))
                            @for ($i = 0; $i < count($homepage_main_image['home-subscribe-our-section-subscribe-user-image']); $i++)
                                @php
                                    foreach ($homepage_main_image['inner-list'] as $homepage_main_image_value)
                                    {
                                        if($homepage_main_image_value['field_slug'] == 'home-subscribe-our-section-subscribe-user-image'){
                                            $homepage_image = $homepage_main_image_value['field_default_text'];
                                        }
                                        if(!empty($homepage_main_image[$homepage_main_image_value['field_slug']]))
                                        {
                                            if($homepage_main_image_value['field_slug'] == 'home-subscribe-our-section-subscribe-user-image'){
                                                $homepage_image = $homepage_main_image[$homepage_main_image_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="https://www.instagram.com/" class="img-wrapper">
                                        <img src="{{ get_file($homepage_image , APP_THEME()) }}" alt="pic">
                                    </a>
                                </li>
                            @endfor
                        @else
                            @for ($i = 0; $i <= 5; $i++)
                                @php
                                    foreach ($homepage_main_image['inner-list'] as $homepage_main_image_value)
                                    {
                                        if($homepage_main_image_value['field_slug'] == 'home-subscribe-our-section-subscribe-user-image'){
                                            $homepage_image = $homepage_main_image_value['field_default_text'];

                                        }
                                    }
                                @endphp
                                    <li>
                                        <a href="https://www.instagram.com/" class="img-wrapper">
                                            <img src="{{ get_file($homepage_image , APP_THEME()) }}" alt="pic">
                                        </a>
                                    </li>
                            @endfor
                        @endif
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <div class="overlay "></div>
    <!--cart popup start here-->
@endsection
</body>
