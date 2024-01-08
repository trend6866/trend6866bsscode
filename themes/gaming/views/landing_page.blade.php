
@extends('layouts.layouts')

@section('page-title')
{{ __('Gaming') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

<div class="home-wrapper -bottom-3">

    <section class="home-banner-section">
        @php
            $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-header-label-text-1') {
                        $header_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-label-text-2') {
                        $header_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-label-text-3') {
                        $homepage_text3 = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-title-text') {
                        $homepage_title_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-sub-text') {
                        $homepage_sub_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-btn-text') {
                        $header_btn = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-img-1') {
                        $header_image = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-header-img-2') {
                        $header_image2 = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-2.png')}}" class="design-circle-2" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-1.png')}}" class="design-circle-1" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/main-conent-games.png')}}" class="main-content-games" alt="image">
        <img src="{{get_file($header_image, APP_THEME())}}" class="half-bluthooth-left" alt="image">
        <img src="{{get_file($header_image2, APP_THEME())}}" class="half-bluthooth-right" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/round-img-big.png')}}" class="round-img-big" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/round-img-small.png')}}" class="round-img-small" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/full-bluthooth.png')}}" class="full-bluthooth" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/top-star.png')}}" class="top-star" alt="image">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="home-banner-contain">

                        <div class="banner-tagline">
                            <div class="tagline-row d-flex align-items-center">
                                <span class="btn-label">{{$header_text}}</span>
                                <p>{{$header_title}} <a href="{{route('page.product-list',$slug)}}">\{{$homepage_text3}}</a></p>
                            </div>
                        </div>
                        <div class="section-title">
                            <h2 class="xl-text">{!! $homepage_title_text !!}</h2>
                            <p>{{$homepage_sub_text}}</p>
                        </div>


                        <div class="btn-flex d-flex">
                            <a href="{{route('page.product-list',$slug)}}" class="btn-primary">
                                {{$header_btn}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z"
                                        fill="white" />
                                    <path
                                        d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z"
                                        fill="white" />
                                    <path
                                        d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z"
                                        fill="white" />
                                    <path
                                        d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-transparent">
                                {{$header_btn}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                                    fill="rgba(131, 131, 131, 1)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z"
                                        fill="rgba(131, 131, 131, 1)" />
                                    <path
                                        d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z"
                                        fill="rgba(131, 131, 131, 1)" />
                                    <path
                                        d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z"
                                        fill="rgba(131, 131, 131, 1)" />
                                    <path
                                        d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z"
                                        fill="rgba(131, 131, 131, 1)" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>

    <section class="bestseller-section padding-bottom">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-3.png')}}" class="design-circle-3" alt="image">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-bestseller-title-text') {
                            $best_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-bestseller-btn-text') {
                            $best_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex align-items-center justify-content-between">
                <h2>{!! $best_title !!}</h2>
                <a href="{{route('page.product-list',$slug)}}" class="btn-transparent">
                    {{$best_btn}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                        fill="rgba(131, 131, 131, 1)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z"
                            fill="rgba(131, 131, 131, 1)"></path>
                        <path
                            d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z"
                            fill="rgba(131, 131, 131, 1)"></path>
                        <path
                            d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z"
                            fill="rgba(131, 131, 131, 1)"></path>
                        <path
                            d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z"
                            fill="rgba(131, 131, 131, 1)"></path>
                    </svg>
                </a>
            </div>
            @endif
        </div>
        <div class="product-center-slider">
            @foreach ($bestSeller as $bestSellers)
            @php
                $b_id = hashidsencode($bestSellers->id);
            @endphp
            <div class="product-center-item product-card">
                <div class="product-card-inner">
                    <div class="card-top">
                        <span class="slide-label">{{$bestSellers->tag_api}}</span>

                        <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$bestSellers->id}}" in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add'}}">
                            <span class="wish-ic">
                                <i class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: rgb(255, 254, 254)'></i>
                            </span>
                        </a>
                    </div>
                    <h3 class="product-title">
                        <a href="{{route('page.product',[$slug,$b_id])}}" class="description">
                            {{$bestSellers->name}}
                        </a>
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
                                <div class="slide-label">
                                    @if ($saleData['discount_type'] == 'flat')
                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                    @elseif ($saleData['discount_type'] == 'percentage')
                                        -{{ $saleData['discount_amount'] }}%
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </h3>
                    <div class="product-card-image">
                        <a href="{{route('page.product',[$slug,$b_id])}}">
                            <img src="{{ get_file($bestSellers->cover_image_path , APP_THEME()) }}" class="default-img">
                            @if($bestSellers->Sub_image($bestSellers->id)['status'] == true)
                                <img src="{{ get_file($bestSellers->Sub_image($bestSellers->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                            @else
                                <img src="{{ get_file($bestSellers->Sub_image($bestSellers->id) , APP_THEME()) }}" class="hover-img">
                            @endif

                        </a>
                    </div>
                    <div class="product-content">
                        <div class="product-content-bottom d-flex align-items-center justify-content-between">
                            @if ($bestSellers->variant_product == 0)
                                <div class="price">
                                    <ins>{{ $bestSellers->final_price }}<span class="currency-type">{{$currency}}</span>
                                    </ins>
                                </div>
                            @else
                                <div class="price">
                                    <ins>{{ __('In Variant') }}</ins>
                                </div>
                            @endif
                            <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $bestSellers->id }}" variant_id="0" qty="1">
                                {{ __('Add to cart')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="client-logo-section padding-bottom">
        <div class="container">
            <div class="client-logo-slider common-arrows">
            @php
                $homepage_logo = '';
                $homepage_logo_key = array_search('homepage-logo', array_column($theme_json,'unique_section_slug'));
                if($homepage_logo_key != ''){
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                }
            @endphp

            @if(!empty($homepage_main_logo['homepage-logo-logo-icon']))
                {{-- @dd($homepage_main_logo['homepage-logo-logo-icon']) --}}
                @for ($i = 0; $i < count($homepage_main_logo['homepage-logo-logo-icon']); $i++)
                    @php
                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                        {
                            if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-icon'){
                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                            }
                            if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                            {
                                if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-icon'){
                                    $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                }
                            }
                        }
                    @endphp
                    <div class="client-logo-item">
                        <a href="#">
                            <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="Client logo">
                        </a>
                    </div>
                @endfor
            @else
                @for ($i = 0; $i <= 6; $i++)
                    @php
                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                        {
                            if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-icon'){
                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                            }
                        }
                    @endphp
                    <div class="client-logo-item">
                        <a href="#">
                            <img src="{{$homepage_logo}}" alt="Client logo">
                        </a>
                    </div>
                @endfor
            @endif
            </div>
        </div>
    </section>

    <section class="gaming-categories-section tabs-wrapper">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-3.png')}}" class="design-circle-4" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/main-conent-games.png')}}" class="main-content-games-1" alt="image">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    @php
                        $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_header_1_key != '' ) {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-products-title-text') {
                                    $cate_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-products-btn-text') {
                                    $cate_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($homepage_header_1['section_enable'] == 'on')
                    <div class="gaming-leftbar">
                        <div class="section-title">
                            <h2>{!! $cate_title !!}</h2>
                        </div>
                        <ul class="cat-tab tabs">
                            @foreach ($MainCategory->take(5) as $cat_key =>  $category)
                            <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                                <a href="javascript:;">{{$category}}</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="more-categories">
                            <a href="{{route('page.product-list',$slug)}}">
                                {{$cate_btn}}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="tabs-container">
                        @foreach ($MainCategory as $cat_k => $category)
                            <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                                <div class="product-list shop-protab-slider product-card-row">
                                @foreach($all_products as $all_product)
                                @php
                                    $p_id = hashidsencode($all_product->id);
                                @endphp
                                @if($cat_k == '0' ||  $all_product->ProductData()->id == $cat_k)
                                    <div class="product-card">
                                        <div class="product-card-inner">
                                        <div class="card-top">
                                            <span class="slide-label">{{$all_product->tag_api}}</span>

                                                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$all_product->id}}" in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add'}}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: rgb(255, 254, 254)'></i>
                                                    </span>
                                                </a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                                                {{$all_product->name}}
                                            </a>
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
                                                    <div class="slide-label">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </h3>
                                        <div class="product-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                <img src="{{ get_file($all_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                            @if($all_product->Sub_image($all_product->id)['status'] == true)
                                                <img src="{{ get_file($all_product->Sub_image($all_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                            @else
                                                <img src="{{ get_file($all_product->Sub_image($all_product->id) , APP_THEME()) }}" class="hover-img">
                                            @endif
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                                @if ($all_product->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $all_product->final_price }}<span class="currency-type">{{$currency}}</span>
                                                        </ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $all_product->id }}" variant_id="0" qty="1">
                                                    {{ __('Add to cart')}}
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
            </div>
        </div>
    </section>

    <section class="subscribe-section padding-top padding-bottom">
        <div class="container">

            @php
                $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-newsletter-label-text') {
                            $news_label = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-title-text') {
                            $news_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                            $news_sub_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-description') {
                            $news_desc = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-bg-img') {
                            $news_image = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
                <div class="row fifth-sec align-items-center">
                    <div class="col-md-5 col-12">
                        <div class="subscribe-content">
                            <div class="section-title">
                                <span class="slide-label subsc-label">{{$news_label}}</span>
                                <h2>{!! $news_text !!}</h2>
                                <p>{{$news_sub_text}}</p>
                            </div>
                            <div class="search-form-wrapper banner-search-form">
                                <form class="subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                    @csrf
                                    <div class="form-inputs">
                                        <input type="email" placeholder="Type your address email..." class="form-control border-radius-50" name="email">
                                        <button type="submit" class="btn">
                                            {{ __('Subscribe')}}
                                        </button>
                                    </div>
                                    {{-- <div class="checkbox-custom"> --}}
                                        {{-- <input type="checkbox" id="subscribecheck"> --}}
                                        <label for="subscribecheck">
                                            {{$news_desc}}
                                        </label>
                                    {{-- </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="subscribe-part-img">
                            <img src="{{get_file($news_image, APP_THEME())}}" alt="image">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="full-width-section padding-top padding-bottom">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/gaming-products.png')}}" class="gaming-products-1" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/gaming-products-1.png')}}" class="gaming-products-2" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-4.png')}}" class="design-circle-4" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-5.png')}}" class="design-circle-5" alt="image">

        @php
            $homepage_header_1_key = array_search('homepage-feature-product', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-feature-product-title-text') {
                        $feature_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-sub-text') {
                        $feature_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-btn-text') {
                        $feature_btn = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-img-1') {
                        $feature_img1 = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-feature-product-img-2') {
                        $feature_img2 = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div class="section-title-left">
                        <h2>{!! $feature_title !!}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{$feature_text}} </p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                            {{$feature_btn}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="full-container">
                <div class="d-flex align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6  col-12">
                        <div class="left-column-img">
                            <img src="{{get_file($feature_img1, APP_THEME())}}" class="cpu-left" alt="image">
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        @if(!empty($latest_product))
                            <div class="full-width-card">
                                <div class="product-card-inner">
                                    <div class="card-top">
                                        <span class="slide-label">{{$latest_product->tag_api}}</span>

                                            <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$latest_product->id}}" in_wishlist="{{ $latest_product->in_whishlist ? 'remove' : 'add'}}">
                                                <span class="wish-ic">
                                                    <i class="{{ $latest_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                        style='color: rgb(255, 254, 254)'></i>
                                                </span>
                                            </a>
                                    </div>
                                    @php
                                        $p_id = hashidsencode($latest_product->id);
                                    @endphp
                                    <h3 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0" class="description">
                                            {{$latest_product->name}}
                                        </a>
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
                                                        if (is_array($saleEnableArray) && in_array($latest_product->id, $saleEnableArray)) {
                                                            $latestSales[$latest_product->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <div class="slide-label">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </h3>
                                    <div class="card-info">
                                        <p class="descriptions">{{$latest_product->description}}</p>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                            @if ($latest_product->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{ $latest_product->final_price }}<span class="currency-type">{{$currency}}</span>
                                                    </ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $latest_product->id }}" variant_id="0" qty="1">
                                                {{ __('Add to cart')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-5 col-lg-4 col-md-6 col-12">
                        <div class="right-column-img">
                            <img src="{{get_file($feature_img2, APP_THEME())}}" class="cpu-right" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>

    <section class="full-width-second-section">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/about-us.png')}}" class="about-img">
        <div class="full-container">

        @php
            $homepage_header_1_key = array_search('homepage-latest-product', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-latest-product-img') {
                        $latest_img1 = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-latest-product-img-2') {
                        $latest_img2 = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
            <div class="d-flex full-width-row align-items-center">
                <div class="col-xl-6 col-lg-4 col-sm-6 col-12">
                    <div class="second-right-img">
                        <img src="{{get_file($latest_img1, APP_THEME())}}" class="double-bluthoth" alt="image">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    @if (!empty($latest_product))
                    <div class="second-full-width-card">
                        <div class="product-card-inner">
                            <div class="card-top">
                                <span class="slide-label">{{$latest_product->tag_api}}</span>

                                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$latest_product->id}}" in_wishlist="{{ $latest_product->in_whishlist ? 'remove' : 'add'}}">
                                    <span class="wish-ic">
                                        <i class="{{ $latest_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: black'></i>
                                    </span>
                                </a>
                            </div>
                            @php
                                $p_id = hashidsencode($latest_product->id);
                            @endphp
                            <h3 class="product-title">
                                <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0" class="description">
                                    {{$latest_product->name}}
                                </a>
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
                                                if (is_array($saleEnableArray) && in_array($latest_product->id, $saleEnableArray)) {
                                                    $latestSales[$latest_product->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <div class="slide-label">
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </h3>
                            <div class="card-info">
                                <p class="descriptions">{{$latest_product->description}}</p>
                            </div>
                            <div class="product-content">
                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                    @if ($latest_product->variant_product == 0)
                                        <div class="price">
                                            <ins>{{ $latest_product->final_price }}<span class="currency-type">{{$currency}}</span>
                                            </ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif
                                    <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $latest_product->id }}" variant_id="0" qty="1">
                                        {{ __('Add to cart')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="second-left-img">
                        <img src="{{get_file($latest_img2, APP_THEME())}}" class="full-width-bluthooth" alt="image">
                    </div>
                </div>
            </div>
        @endif
        </div>
    </section>

    <section class="about-us-section padding-bottom">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/about-us.png')}}" class="about-img-1">
        <div class="container">
            <div class="section-title">
                    @php
                        $homepage_header_1_key = array_search('homepage-about-1', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_header_1_key != '' ) {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-about-title-text') {
                                    $about_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-about-sub-text') {
                                    $about_text = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($homepage_header_1['section_enable'] == 'on')
                        <h2>{{$about_title}}</h2>
                        <p>{{$about_text}}</p>
                    @endif
                </div>
                <div class="row">

                    @php
                        $homepage_text = '';
                        $homepage_logo_key = array_search('homepage-about-2', array_column($theme_json,'unique_section_slug'));
                        $section_enable = 'on';
                        if($homepage_logo_key != ''){
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                            $section_enable = $homepage_main_logo['section_enable'];
                        }
                    @endphp
                    @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            @php
                                if($homepage_main_logo_value['field_slug'] == 'homepage-about-label-text')
                                {
                                    $about_text = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $about_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if($homepage_main_logo_value['field_slug'] == 'homepage-about-title-text')
                                {
                                    $about_title = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $about_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if($homepage_main_logo_value['field_slug'] == 'homepage-about-sub-text')
                                {
                                    $about_sub_text = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $about_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                            @endphp
                        @endforeach
                        <div class="col-xl-3 col-md-3 col-sm-6 col-12">
                            <div class="about-us-box">
                                <h3 class="h2">{{$about_text}}</h3>
                                <h4 class="h3">{{$about_title}}</h4>
                                <p>{{$about_sub_text}}</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
    </section>

    <section class="home-blog-section padding-top">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/blog-ring-1.png')}}" class="blog-ring" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/full-bluthooth.png')}}" class="blog-blutooth" alt="image">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-blog-title-text') {
                            $blog_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-blog-sub-text') {
                            $blog_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-blog-btn-text') {
                            $blog_btn = $value['field_default_text'];
                        }
                    }
                }
                @endphp
            @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div class="section-title-left">
                        <h2>{!! $blog_title !!}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{$blog_text}}</p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                            {{$blog_btn}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
            <div class="blog-two-row-slider common-arrows">
                {!! \App\Models\Blog::HomePageBlog($slug,12) !!}
            </div>
        </div>
    </section>

    <section class="home-product-extra padding-top">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-best-product', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-best-product-title-text') {
                            $product_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-best-product-sub-text') {
                            $product_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-best-product-btn-text') {
                            $product_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div class="section-title-left">
                        <h2>{!! $product_title !!}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{$product_text}}</p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                            {{$product_btn}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
            <div class="product-extra-slider dark-contnt">
                @foreach ($all_products as $all_product)
                @php
                    $p_id = hashidsencode($all_product->id);
                @endphp
                    <div class="product-card">
                        <div class="product-card-inner">
                        <div class="card-top">
                            <span class="slide-label">{{$all_product->tag_api}}</span>

                                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$all_product->id}}" in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add'}}">
                                    <span class="wish-ic">
                                        <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: black;'></i>
                                    </span>
                                </a>
                        </div>
                        <h3 class="product-title">
                            <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                                {{$all_product->name}}
                            </a>
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
                                    <div class="slide-label">
                                        @if ($saleData['discount_type'] == 'flat')
                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                        @elseif ($saleData['discount_type'] == 'percentage')
                                            -{{ $saleData['discount_amount'] }}%
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </h3>
                        <div class="product-card-image">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($all_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                @if($all_product->Sub_image($all_product->id)['status'] == true)
                                    <img src="{{ get_file($all_product->Sub_image($all_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                @else
                                    <img src="{{ get_file($all_product->Sub_image($all_product->id) , APP_THEME()) }}" class="hover-img">
                                @endif
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                @if ($all_product->variant_product == 0)
                                    <div class="price">
                                        <ins>{{ $all_product->final_price }}<span class="currency-type">{{$currency}}</span>
                                        </ins>
                                    </div>
                                @else
                                    <div class="price">
                                        <ins>{{ __('In Variant') }}</ins>
                                    </div>
                                @endif
                                <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $all_product->id }}" variant_id="0" qty="1">
                                    {{ __('Add to cart')}}
                                </a>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="testimonials-section padding-top padding-bottom">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-testimonial-title-text') {
                            $test_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-testimonial-sub-text') {
                            $test_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-testimonial-btn-text') {
                            $test_btn = $value['field_default_text'];
                        }
                    }
                }
                @endphp
            @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div class="section-title-left">
                        <h2>{{$test_title}}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{$test_text}}</p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                            {{$test_btn}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                                <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
            <div class="testimonial-slider common-arrows">
                @foreach ($reviews as $review)
                <div class="testimonial-itm">
                    <div class="testimonial-itm-inner">
                        <div class="testimonial-itm-image">
                            <a href="{{route('page.product-list',$slug)}}" tabindex="0">
                                <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}" class="default-img" alt="review">
                            </a>
                        </div>
                        <div class="testimonial-itm-content">
                            <div class="testimonial-content-top">
                                <h3 class="testimonial-title" class="description">
                                    {{$review->title}}
                                </h3>
                            </div>
                            <p class="descriptions">{{$review->description}}</p>
                            <div class="testimonial-content-bottom">
                                <div class="testi-pro-info">
                                    <div class="pro-img">
                                        <img src="{{asset('themes/'.APP_THEME().'/assets/images/client-img.png')}}" class="client-img" alt="image">
                                    </div>
                                    <h4>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                        <span>Client</span>
                                    </h4>
                                </div>
                                <div class="testi-star d-flex align-items-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                    @endfor
                                    <span><b>{{$review->rating_no}}</b> / 5.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

@endsection
