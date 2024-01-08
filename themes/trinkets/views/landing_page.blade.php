
@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
{{ __('Jewellery') }}
@endsection

@section('content')
<body class="home">
<!--wrapper start here-->
    @php
        $homepage_logo_key = array_search('home-banner-image', array_column($theme_json,'unique_section_slug'));
        if($homepage_logo_key != ''){
            $homepage_main_logo = $theme_json[$homepage_logo_key];
            $section_enable = $homepage_main_logo['section_enable'];
        }
    @endphp

        @if($homepage_main_logo['section_enable'] == 'on')
            <section class="home-banner-section">
                <div class="container">
                    <div class="banner-main-content">
                        <div class="banner-left-side">
                            <div class="banner-img-slider">
                                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'home-banner-image-header-background-image')
                                        {
                                            $homepage_image = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <div class="banner-img">
                                    <img src="{{get_file($homepage_image, APP_THEME())}}" alt="banner image">
                                </div>
                            </div>
                            <div class="slides-numbers">
                                <span class="active">01</span> <span>/</span> <span class="total">04</span>
                            </div>
                            <div class="banner-slider">
                                @php
                                    $homepage_text = '';
                                    $homepage_logo_key = array_search('home-header-1', array_column($theme_json,'unique_section_slug'));
                                    if($homepage_logo_key != ''){
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        $section_enable = $homepage_main_logo['section_enable'];
                                    }
                                @endphp
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                        @php
                                            if($homepage_main_logo_value['field_slug'] == 'home-header-title-text')
                                            {
                                                $homepage_text = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                            if($homepage_main_logo_value['field_slug'] == 'home-header-sub-text') {
                                                $homepage_text1 = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $homepage_text1 = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                            if($homepage_main_logo_value['field_slug'] == 'home-header-button') {
                                                $homepage_text2 = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $homepage_text2 = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <div class="home-banner-content home-slider">
                                        <div class="home-banner-content-inner">
                                            <div class=" banner-content-inner">
                                                <div class="section-title">
                                                    <h2> {!! $homepage_text !!} </h2>
                                                </div>
                                                <p>{!! $homepage_text1 !!}
                                                </p>
                                                <a href="{{route('page.product-list',$slug)}}" class="btn"> {!! $homepage_text2 !!} <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                        viewBox="0 0 12 11" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11.4605 6.00095C11.7371 5.72433 11.7371 5.27584 11.4605 4.99921L7.2105 0.749214C6.93388 0.472592 6.48539 0.472592 6.20877 0.749214C5.93215 1.02584 5.93215 1.47433 6.20877 1.75095L9.9579 5.50008L6.20877 9.24921C5.93215 9.52584 5.93215 9.97433 6.20877 10.2509C6.48539 10.5276 6.93388 10.5276 7.2105 10.2509L11.4605 6.00095ZM1.54384 10.2509L5.79384 6.00095C6.07046 5.72433 6.07046 5.27584 5.79384 4.99921L1.54384 0.749214C1.26721 0.472592 0.818723 0.472592 0.542102 0.749214C0.26548 1.02583 0.26548 1.47433 0.542102 1.75095L4.29123 5.50008L0.542101 9.24921C0.26548 9.52584 0.26548 9.97433 0.542101 10.2509C0.818722 10.5276 1.26721 10.5276 1.54384 10.2509Z"
                                                            fill="white" />
                                                    </svg>
                                                </a>
                                                <div class="tooltip icon-top">
                                                    <a href="{{route('page.product-list',$slug)}}">
                                                        <span class="icon-circle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                viewBox="0 0 16 16" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.55749 7.802C8.55749 8.21958 8.21897 8.5581 7.80139 8.5581L1.38569 8.5581C0.968109 8.5581 0.629592 8.21958 0.629592 7.802C0.629592 7.38442 0.968109 7.0459 1.38569 7.0459L7.04529 7.0459L7.04529 1.3863C7.04529 0.96872 7.38381 0.630204 7.80139 0.630204C8.21897 0.630203 8.55749 0.96872 8.55749 1.3863L8.55749 7.802Z"
                                                                    fill="white"></path>
                                                                <path
                                                                    d="M14.3276 7.15641L7.9119 7.15641C7.49432 7.15641 7.1558 7.49493 7.1558 7.91251L7.1558 14.3282C7.1558 14.7458 7.49432 15.0843 7.9119 15.0843C8.32948 15.0843 8.668 14.7458 8.668 14.3282L8.668 8.66861L14.3276 8.66861C14.7452 8.66861 15.0837 8.33009 15.0837 7.91251C15.0837 7.49493 14.7452 7.15641 14.3276 7.15641Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <span>Stainless<br>Border</span>
                                                </div>
                                                <div class="tooltip icon-right">
                                                    <a href="{{route('page.product-list',$slug)}}">
                                                    <span class="icon-circle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            viewBox="0 0 16 16" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.55749 7.802C8.55749 8.21958 8.21897 8.5581 7.80139 8.5581L1.38569 8.5581C0.968109 8.5581 0.629592 8.21958 0.629592 7.802C0.629592 7.38442 0.968109 7.0459 1.38569 7.0459L7.04529 7.0459L7.04529 1.3863C7.04529 0.96872 7.38381 0.630204 7.80139 0.630204C8.21897 0.630203 8.55749 0.96872 8.55749 1.3863L8.55749 7.802Z"
                                                                fill="white"></path>
                                                            <path
                                                                d="M14.3276 7.15641L7.9119 7.15641C7.49432 7.15641 7.1558 7.49493 7.1558 7.91251L7.1558 14.3282C7.1558 14.7458 7.49432 15.0843 7.9119 15.0843C8.32948 15.0843 8.668 14.7458 8.668 14.3282L8.668 8.66861L14.3276 8.66861C14.7452 8.66861 15.0837 8.33009 15.0837 7.91251C15.0837 7.49493 14.7452 7.15641 14.3276 7.15641Z"
                                                                fill="white"></path>
                                                        </svg>
                                                    </span>
                                                    </a>
                                                    <span>Black solid<br>titanium</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="client-area-wrap">
                                @php
                                    $homepage_text = '';
                                    $homepage_logo_key = array_search('home-banner-image', array_column($theme_json,'unique_section_slug'));
                                    $section_enable = 'on';
                                    if($homepage_logo_key != ''){
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        $section_enable = $homepage_main_logo['section_enable'];
                                    }
                                @endphp
                                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'home-banner-image-text')
                                        {
                                            $homepage_text = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <span class="title">{{$homepage_text}}</span>
                                <div class="client-logo-slider">
                                    @php
                                        $homepage_logo = '';
                                        $homepage_logo_key = array_search('homepage-logo', array_column($theme_json,'unique_section_slug'));
                                        if($homepage_logo_key != ''){
                                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        }
                                    @endphp

                                    @if(!empty($homepage_main_logo['homepage-logos']))
                                        @for ($i = 0; $i < count($homepage_main_logo['homepage-logos']); $i++)
                                            @php
                                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                                {
                                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logos'){
                                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                    }
                                                    if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                                    {
                                                        if($homepage_main_logo_value['field_slug'] == 'homepage-logos'){
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
                                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logos'){
                                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                    }
                                                }
                                            @endphp
                                            <div class="client-logo-item">
                                                <a href="#">
                                                    <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="Client logo">
                                                </a>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="banner-right-side">
                            <div class="trending-products">
                                <div class="trending-slider flex-slider">
                                    @foreach ($modern_products->take(3) as $m_product)
                                    @php
                                        $p_id = hashidsencode($m_product->id);
                                    @endphp
                                        <div class="product-card card">
                                            <div class="product-card-inner card-inner">
                                                <div class="product-content-top ">
                                                    <span class="new-labl">
                                                        {{$m_product->tag_api}}
                                                    </span>
                                                    <h4>
                                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                                            {{$m_product->name}}
                                                        </a>
                                                    </h4>
                                                    {{-- <div class="product-type">{{ $m_product->name }}</div> --}}
                                                </div>
                                                <div class="product-card-image">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                                        <img src="{{ get_file($m_product->cover_image_path , APP_THEME() )}}" class="default-img">
                                                    </a>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="price">
                                                        <ins>{{$m_product->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                                    </div>
                                                    <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $m_product->id }}" variant_id="{{ $m_product->default_variant_id }}" qty="1">
                                                        <span> {{ __('Add to cart')}}</span>
                                                        <span class="roun-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                                viewBox="0 0 9 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                                    fill="white" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @php
                            $homepage_text = '';
                            $homepage_logo_key = array_search('home-social-links-1', array_column($theme_json,'unique_section_slug'));
                            $section_enable = 'on';
                            if($homepage_logo_key != ''){
                                $homepage_main_logo = $theme_json[$homepage_logo_key];
                                $section_enable = $homepage_main_logo['section_enable'];
                            }
                        @endphp
                        <div class="social-links">
                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            @php
                                if($homepage_main_logo_value['field_slug'] == 'home-social-links-1-title')
                                {
                                    $social_text = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $social_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            @endphp
                            @endforeach
                            <span>{{ $social_text }}</span>
                            <ul>
                                @php
                                    $homepage_text = '';
                                    $homepage_logo_key = array_search('home-social-links-2', array_column($theme_json,'unique_section_slug'));
                                    $section_enable = 'on';
                                    if($homepage_logo_key != ''){
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                        $section_enable = $homepage_main_logo['section_enable'];
                                    }
                                @endphp
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                        @php
                                            if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-contact-image')
                                            {
                                                $social_icon = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $social_icon = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                }
                                            }
                                            if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-url')
                                            {
                                                $social_link = $homepage_main_logo_value['field_default_text'];
                                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                    $social_link = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    <li>
                                        <a href="{{ $social_link }}" target="_blank">
                                            <img src="{{ get_file($social_icon, APP_THEME()) }}" alt="twitter">
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bac-shadow desk-only">
                    <img src="{{asset('themes/'.APP_THEME().'/assets/images/right-shadow.png')}}" alt="shadow">
                </div>
            </section>
        @endif

        @php
            $homepage_text = '';
            $homepage_logo_key = array_search('homepage-best-product',array_column($theme_json,'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_logo_key != '')
            {
                $homepage_main_logo = $theme_json[$homepage_logo_key];
                $section_enable = $homepage_main_logo['section_enable'];
            }
        @endphp
        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
            @php
                if($homepage_main_logo_value['field_slug'] == 'homepage-best-product-background-image')
                {
                    $homepage_image = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
                if($homepage_main_logo_value['field_slug'] == 'homepage-best-product-image')
                {
                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
                if($homepage_main_logo_value['field_slug'] == 'homepage-best-product-title')
                {
                    $homepage_title = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
                if($homepage_main_logo_value['field_slug'] == 'homepage-best-product-sub-text')
                {
                    $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
            @endphp
        @endforeach

        @if($homepage_main_logo['section_enable'] == 'on')
            <section class="product-prescription-section" style="background-image:url({!! get_file($homepage_image, APP_THEME()) !!}) ;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="prescription-card">
                                <div class="img-wrapper">
                                    <img src="{{get_file($homepage_logo, APP_THEME())}}" alt="Prescription glasses and sunglasses">
                                </div>
                                <div class="prescription-content">
                                    <h3>{!! $homepage_title !!}</h3>
                                    <p>{!! $homepage_sub_text !!}</p>
                                </div>
                            </div>
                        </div>
                        @if (!empty($latest_product))
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            @php
                                $p_id = hashidsencode($latest_product->id);
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-content-top ">
                                        <span class="new-labl">
                                            {{$latest_product->tag_api}}
                                        </span>
                                        <h4>
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                {{$latest_product->name}}
                                            </a>
                                        </h4>
                                        {{-- <div class="product-type">{{ $latest_product->name }}</div> --}}
                                    </div>
                                    <div class="product-card-image">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                            <img src="{{ get_file($latest_product->cover_image_path , APP_THEME())}}" class="default-img">
                                        </a>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="price">
                                            <ins>{{$latest_product->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                        <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $latest_product->id }}" variant_id="{{ $latest_product->default_variant_id }}" qty="1" tabindex="0">
                                            <span> {{ __('Add to cart')}}</span>
                                            <span class="roun-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                    viewBox="0 0 9 9" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                        fill="white" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="tooltip icon-top">
                        <a href="{{route('page.product-list',$slug)}}">
                        <span class="icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.55749 7.802C8.55749 8.21958 8.21897 8.5581 7.80139 8.5581L1.38569 8.5581C0.968109 8.5581 0.629592 8.21958 0.629592 7.802C0.629592 7.38442 0.968109 7.0459 1.38569 7.0459L7.04529 7.0459L7.04529 1.3863C7.04529 0.96872 7.38381 0.630204 7.80139 0.630204C8.21897 0.630203 8.55749 0.96872 8.55749 1.3863L8.55749 7.802Z"
                                    fill="white"></path>
                                <path
                                    d="M14.3276 7.15641L7.9119 7.15641C7.49432 7.15641 7.1558 7.49493 7.1558 7.91251L7.1558 14.3282C7.1558 14.7458 7.49432 15.0843 7.9119 15.0843C8.32948 15.0843 8.668 14.7458 8.668 14.3282L8.668 8.66861L14.3276 8.66861C14.7452 8.66861 15.0837 8.33009 15.0837 7.91251C15.0837 7.49493 14.7452 7.15641 14.3276 7.15641Z"
                                    fill="white"></path>
                            </svg>
                        </span>
                        </a>
                        <span>Stainless<br>Border</span>
                    </div>
                </div>
            </section>
        @endif

        @php
            $homepage_logo_key = array_search('categories-section', array_column($theme_json,'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_logo_key != ''){
                $homepage_main_logo = $theme_json[$homepage_logo_key];
                $section_enable = $homepage_main_logo['section_enable'];
            }
        @endphp

        <section class="categories-section padding-top padding-bottom">
            <div class="container">
                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                    @php
                        if($homepage_main_logo_value['field_slug'] == 'categories-section-title')
                        {
                            $categories_title = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $categories_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'categories-section-button')
                        {
                            $categories_button = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $categories_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                    @endphp
                @endforeach
                @if($homepage_main_logo['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <h2>{{ $categories_title }}</h2>
                        <a href="{{route('page.product-list',$slug)}}" class="btn">
                            {{ $categories_button }}
                        </a>
                    </div>
                    <div class="tabs-wrapper">
                        <div class="row ">
                            <div class="col-lg-2 col-md-2 col-12">
                                <ul class="cat-tab tabs">
                                    @foreach ($MainCategory as $cat_key =>  $category)
                                        <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                                            <a href="javascript:;">{{$category}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <a class="link-btn" href="{{route('page.product-list',$slug)}}">{{__('CHECK MORE')}}</a>
                            </div>
                            <div class="col-lg-10 col-md-10 col-12 tabs-container">
                                @foreach ($MainCategory as $cat_k => $category)
                                    <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                                        <div class="product-tab-slider flex-slider">
                                            @foreach ($homeproducts as $homeproduct)
                                            @php
                                                $p_id = hashidsencode($homeproduct->id);
                                            @endphp
                                                @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                                                    <div class="product-card card">
                                                        <div class="product-card-inner card-inner">
                                                            <div class="product-content-top ">
                                                                <span class="new-labl">
                                                                    {{$homeproduct->tag_api}}
                                                                </span>
                                                                <h4>
                                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                                                        {{$homeproduct->name}}
                                                                    </a>
                                                                </h4>
                                                                {{-- <div class="product-type">{{ $homeproduct->name }}</div> --}}
                                                            </div>
                                                            <div class="product-card-image">
                                                                <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                                                    <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME())}}" class="default-img">
                                                                </a>
                                                            </div>
                                                            <div class="product-content-bottom">
                                                                <div class="price">
                                                                    <ins>{{$homeproduct->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                                                </div>
                                                                <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                                                    <span> {{ __('Add to cart')}}</span>
                                                                    <span class="roun-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                                            viewBox="0 0 9 9" fill="none">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                                                fill="white" />
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
        </section>

        <section class="product-prescription-section-two">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-content',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-content-image')
                    {
                        $homepage_image = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-content-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-content-sub-text')
                    {
                        $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-content-button')
                    {
                        $homepage_button = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            @if($homepage_main_logo['section_enable'] == 'on')
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-lg-7 col-sm-6  col-12">
                        <div class="left-side-image">
                            <img src="{{get_file($homepage_image, APP_THEME())}}" alt="GlassesI0p1">
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-6 col-12 right-col">
                        <div class=" banner-content-inner">
                            <div class="section-title">
                                <h2>{!! $homepage_title !!}</h2>
                            </div>
                            <p>{!! $homepage_sub_text !!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn white-btn">
                                {!! $homepage_button !!}

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="bestseller-section tabs-wrapper">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-content-2',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-content-2-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-content-2-sub-text')
                    {
                        $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-content-2-image')
                    {
                        $homepage_image = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
                <img src="{{ get_file($homepage_image, APP_THEME()) }}" class="desing-img-1" alt="img">
                <div class="container">
                    <div class=" banner-content-inner">
                        <div class="section-title">
                            <h2>{!! $homepage_title !!}</h2>
                        </div>
                        <ul class="cat-tab d-flex justify-content-between tabs">
                            @foreach ($MainCategory as $cat_key =>  $category)
                                <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}_data">
                                    <a href="javascript:;">{{$category}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <p>{!! $homepage_sub_text !!}</p>
                    </div>
                    <div class="tabs-container">
                        @foreach ($MainCategory as $cat_k => $category)

                        <div id="{{ $cat_k }}_data" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                            <div class="cat-product-tab-slider flex-slider">
                                @foreach ($all_products as $homeproduct)
                                @php
                                    $p_id =  hashidsencode($homeproduct->id);
                                @endphp
                                    @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                                        <div class="product-card card">
                                            <div class="product-card-inner card-inner">
                                                <div class="product-content-top ">
                                                    <span class="new-labl">
                                                        {{$homeproduct->tag_api}}
                                                    </span>
                                                    <h4>
                                                        <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                                            {{$homeproduct->name}}
                                                        </a>
                                                    </h4>
                                                    {{-- <div class="product-type">{{ $homeproduct->name }}</div> --}}
                                                </div>
                                                <div class="product-card-image">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                                        <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}" class="default-img">
                                                    </a>
                                                </div>
                                                <div class="product-content-bottom">
                                                    <div class="price">
                                                        <ins>{{$homeproduct->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                                    </div>
                                                    <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                                        <span> {{ __('Add to cart')}}</span>
                                                        <span class="roun-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                                viewBox="0 0 9 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                                    fill="white" />
                                                            </svg>
                                                        </span>
                                                    </button>
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
            @endif
        </section>


        <section class="hot-selling-product">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-container',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-container-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-container-image')
                    {
                        $homepage_image = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-container-background-image')
                    {
                        $homepage_back_image = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_back_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-container-button')
                    {
                        $homepage_button = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            @if($homepage_main_logo['section_enable'] == 'on')
            <div class=" container">

                {!! \App\Models\Product::GetLatProduct($slug, 1) !!}

            </div>
            @endif
        </section>


        <section class="shop-products-section">
            <div class="container">
                @php
                    $homepage_logo_key = array_search('homepage-shop-products',array_column($theme_json,'unique_section_slug'));
                    $section_enable = 'on';
                    if($homepage_logo_key != '')
                    {
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @if($homepage_main_logo['section_enable'] == 'on')
                    <div class="section-title d-flex justify-content-between align-items-center">
                        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            @php
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-title')
                                {
                                    $products_title = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-button')
                                {
                                    $products_button = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                            @endphp
                        @endforeach
                        <h2>{{ $products_title }}</h2>
                        <a href="{{route('page.product-list',$slug)}}" class="btn">
                            {{$products_button}}
                        </a>
                    </div>
                @endif


                <div class="shop-products-slider flex-slider">
                    @foreach ($bestSeller as $data)
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="product-card card">
                            <div class="product-card-inner card-inner">
                                <div class="product-content-top ">
                                    <div class="new-labl">
                                        {{ $data->tag_api }}
                                    </div>
                                    <h4 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                            {{$data->name}}
                                        </a>
                                    </h4>
                                    {{-- <div class="product-type">{{ $data->name }}</div> --}}
                                </div>
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                        <img src="{{ get_file($data->cover_image_path , APP_THEME()) }}" class="default-img">
                                    </a>
                                </div>
                                <div class="product-content-bottom">
                                    <div class="price">
                                        <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                    </div>

                                    <button class="addtocart-btn btn addcart-btn-globaly" tabindex="0" product_id="{{ $data->id }}" variant_id="{{ $data->default_variant_id }}" qty="1">
                                        <span> {{ __('Add to cart')}}</span>
                                        <span class="roun-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                    fill="white" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- {!! \App\Models\Product::GetLatProduct(10) !!} --}}
                </div>
            </div>
        </section>


        @php
            $homepage_text = '';
            $homepage_logo_key = array_search('home-product-section',array_column($theme_json,'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_logo_key != '')
            {
                $homepage_main_logo = $theme_json[$homepage_logo_key];
                $section_enable = $homepage_main_logo['section_enable'];
            }
        @endphp
        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
            @php
                if($homepage_main_logo_value['field_slug'] == 'home-product-section-title')
                {
                    $homepage_title = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
                if($homepage_main_logo_value['field_slug'] == 'home-product-section-sub-text')
                {
                    $homepage_sub_title = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_sub_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
                if($homepage_main_logo_value['field_slug'] == 'home-product-section-background-image')
                {
                    $homepage_image = $homepage_main_logo_value['field_default_text'];
                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                        $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    }
                }
            @endphp
        @endforeach
        @if($homepage_main_logo['section_enable'] == 'on')
            <section class="product-second-section" style="background-image: url({{ get_file($homepage_image, APP_THEME()) }});">
                <div class="container">
                    <div class=" banner-content-inner">
                        <div class="section-title">
                            <h2>{!! $homepage_title !!}</h2>
                        </div>
                        <p>{!! $homepage_sub_title !!}</p>
                    </div>
                    <div class="row product-list-row">
                        {!! \App\Models\Product::GetLatestProduct($slug, 2) !!}
                    </div>
                </div>
            </section>
        @endif

        <section class="testimonials-section padding-top ">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-section',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-section-image')
                    {
                        $homepage_image = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-section-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            @if($homepage_main_logo['section_enable'] == 'on')
                <img src="{{ get_file($homepage_image, APP_THEME()) }}" class="test-design-img" alt="img">
                <div class="container">
                    <div class="section-title text-center">
                    <h2>{!! $homepage_title !!}</h2>
                    </div>
                    <div class="testi-slider flex-slider">
                        @foreach ($reviews as $review)
                        @php
                            $r_id = hashidsencode($review->ProductData->id);
                        @endphp
                            <div class="testi-card card">
                                <div class="testi-card-inner card-inner">
                                    <div class="top-content">
                                        {{-- <h4>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</h4> --}}
                                        <span>{{$review->title}}</span>
                                    </div>
                                    <div class="product-img">
                                        <a href="{{route('page.product',[$slug,$r_id])}}">
                                            <img src="{{ asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' ) }}" alt="testimonial-product">
                                        </a>
                                    </div>
                                    <div class="bottom-content">
                                        <div class="rating d-flex justify-content-center align-items-center">
                                            <div class="rating-start-outer">
                                                <div class="reviews-stars_inner" >
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="review-epoint">{{$review->rating_no}}.0<span>/ 5.0</span></span>
                                        </div>
                                        <p>{{$review->description}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <section class="newsletter-section padding-bottom padding-top ">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-newsletter-section',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-sub-text')
                    {
                        $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-text')
                    {
                        $homepage_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            @if($homepage_main_logo['section_enable'] == 'on')
            {{-- <img src="{{ get_file($homepage_image, APP_THEME()) }}" class="subs-design-img" alt="newsletter-right-glass"> --}}
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class=" banner-content-inner">
                        <div class="section-title">
                            <h2>{!! $homepage_title !!}</h2>
                        </div>
                        <p>{!! $homepage_sub_text !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                            @csrf
                            <div class="input-wrapper">
                                <input type="email" name="email" placeholder="Enter email address...">
                                <button type="submit" class="btn-subscibe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                            fill="white"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="checkbox">
                                {{-- <input type="checkbox" id="subscibecheck"> --}}
                                <label for="subscibecheck">
                                    {!! $homepage_text !!}
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </section>

        <section class="home-blog-section">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-banner-content',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            <div class="container">
                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                    @php
                        if($homepage_main_logo_value['field_slug'] == 'home-banner-content-title')
                        {
                            $homepage_title = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'home-banner-content-sub-text')
                        {
                            $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'home-banner-content-button')
                        {
                            $homepage_button = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                    @endphp
                @endforeach
                @if($homepage_main_logo['section_enable'] == 'on')
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class=" banner-content-inner">
                            <div class="section-title">
                                <h2>{!! $homepage_title !!}</h2>
                            </div>
                            <p>{!! $homepage_sub_text !!}</p>
                            <a href="" class="btn white-btn">
                            {{ $homepage_button }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="blog-slider-main flex-slider">
                            {!! \App\Models\Blog::HomePageBlog($slug, 6) !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>

<!---wrapper end here-->
</body>

@endsection
