@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
    {{ __('Landholdings') }}
@endsection

@section('content')
    <div class="wrapper">
        <section class="main-home-first-section">
            <div class="main-banner-image-wrap">
                @foreach ($modern_products as $products)
                    <div class="img-wrapper">
                        <img src="{{ get_file($products->cover_image_path, APP_THEME()) }}" alt="Banner main image">
                        <div class="container">
                            <div class="home-banner-content">
                                <div class="decorative-img">
                                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/decorative.png') }}"
                                        alt="">
                                </div>
                                <div class="home-banner-content-inner">
                                    <span class="lbl">{{ $products->tag_api }} </span>
                                    <h2 class="h1">{!! $products->name !!}</h2>
                                    <div class="banner-desk">
                                        <p class="description">{{ $products->description }}</p>
                                    </div>
                                    <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                        <span class="home-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="17" viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.575 13.15V6.95H1.025V13.15C1.025 14.8621 2.41292 16.25 4.125 16.25H11.875C13.5871 16.25 14.975 14.8621 14.975 13.15V6.95H13.425V13.15C13.425 14.006 12.731 14.7 11.875 14.7H10.325V12.375C10.325 11.0909 9.28406 10.05 8 10.05C6.71594 10.05 5.675 11.0909 5.675 12.375V14.7H4.125C3.26896 14.7 2.575 14.006 2.575 13.15ZM7.225 14.7H8.775V12.375C8.775 11.947 8.42802 11.6 8 11.6C7.57198 11.6 7.225 11.947 7.225 12.375V14.7Z"
                                                    fill="#3A1C36" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.5943 0.75C3.31305 0.75 2.05032 1.38849 1.35605 2.57142C1.13367 2.95033 0.882254 3.40328 0.68167 3.83608C0.581565 4.05208 0.48285 4.28705 0.406519 4.52103C0.338036 4.73096 0.25 5.05007 0.25 5.4C0.25 6.01779 0.401441 6.80166 0.94832 7.45791C1.53664 8.16389 2.396 8.5 3.35 8.5C4.25567 8.5 4.95751 8.07767 5.40794 7.70064C5.56154 7.57208 5.78846 7.57208 5.94206 7.70064C6.39249 8.07767 7.09433 8.5 8 8.5C8.90567 8.5 9.60751 8.07768 10.0579 7.70064C10.2115 7.57208 10.4385 7.57208 10.5921 7.70064C11.0425 8.07768 11.7443 8.5 12.65 8.5C13.604 8.5 14.4634 8.16389 15.0517 7.45791C15.5986 6.80166 15.75 6.01779 15.75 5.4C15.75 5.05007 15.662 4.73096 15.5935 4.52103C15.5171 4.28705 15.4184 4.05208 15.3183 3.83608C15.1177 3.40328 14.8663 2.95033 14.6439 2.57142C13.9497 1.38849 12.6869 0.75 11.4057 0.75H4.5943ZM4.5943 2.3C3.81693 2.3 3.08631 2.68555 2.69283 3.35598C2.27033 4.07585 1.8 4.97309 1.8 5.4C1.8 6.175 2.1875 6.95 3.35 6.95C4.16508 6.95 4.78967 6.18801 5.09019 5.73256C5.22098 5.53434 5.43751 5.4 5.675 5.4C5.91249 5.4 6.12901 5.53434 6.25981 5.73256C6.56033 6.18801 7.18492 6.95 8 6.95C8.81508 6.95 9.43967 6.18801 9.74019 5.73256C9.87099 5.53434 10.0875 5.4 10.325 5.4C10.5625 5.4 10.779 5.53434 10.9098 5.73256C11.2103 6.18801 11.8349 6.95 12.65 6.95C13.8125 6.95 14.2 6.175 14.2 5.4C14.2 4.97309 13.7297 4.07585 13.3072 3.35598C12.9137 2.68555 12.1831 2.3 11.4057 2.3H4.5943Z"
                                                    fill="#3A1C36" />
                                            </svg></span>
                                        {{ __('Show products') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="5"
                                            viewBox="0 0 12 5" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.75 2.49986C0.749996 2.72077 0.955195 2.89986 1.20832 2.89986L10.1621 2.89998L9.0851 3.81309C8.90354 3.96702 8.89934 4.22026 9.07572 4.37872C9.25209 4.53717 9.54226 4.54084 9.72383 4.38691L11.611 2.78691C11.6999 2.71159 11.75 2.60809 11.75 2.5C11.75 2.3919 11.6999 2.28841 11.611 2.21309L9.72383 0.613092C9.54226 0.45916 9.25209 0.462827 9.07572 0.621283C8.89934 0.779738 8.90354 1.03298 9.0851 1.18691L10.1621 2.09998L1.20834 2.09986C0.955209 2.09986 0.750004 2.27894 0.75 2.49986Z"
                                                fill="#3A1C36" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="home-category-section">
                <div class="slides-numbers">
                    <div class="category-slide-nav"></div>
                    <span class="active">01</span> / <span class="total"></span>
                </div>
                <div class="home-category-slider">
                    @foreach ($modern_products as $m_product)
                        <div class="modern-cat-col">
                            <div class="modern-cat-inner d-flex">
                                <div class="cat-img">
                                    <img src="{{ $m_product->cover_image_path }}" alt="default cat img">
                                </div>
                                <div class="modern-cat-info">
                                    <div class="info-top">
                                        <span class="lbl">{{ $m_product->tag_api }}</span>
                                        <a href="{{ route('page.product-list', $slug) }}" class="h4 cat-link">
                                            {!! $m_product->name !!}
                                        </a>
                                    </div>
                                    <a href="{{ route('page.product-list', $slug) }}"
                                        class="btn-link">{{ __('MORE PRODUCT') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="7"
                                            viewBox="0 0 17 7" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.18215e-08 3.49975C-6.03322e-06 3.88635 0.317119 4.19975 0.70832 4.19976L14.546 4.19997L12.8815 5.79791C12.6009 6.06729 12.5944 6.51046 12.867 6.78776C13.1396 7.06505 13.588 7.07147 13.8686 6.80209L16.7852 4.00209C16.9225 3.87028 17 3.68917 17 3.5C17 3.31083 16.9225 3.12972 16.7852 2.99791L13.8686 0.19791C13.588 -0.0714698 13.1396 -0.065052 12.867 0.212245C12.5944 0.489541 12.6009 0.93271 12.8815 1.20209L14.5459 2.79997L0.708342 2.79976C0.317142 2.79975 6.15908e-06 3.11315 4.18215e-08 3.49975Z"
                                                fill="white" />
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="padding-top shop-review-section padding-bottom">
            <div class="container">
                <div class="row">
                    @php
                        $homepage_header_1_key = array_search('homepage-information-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-information-title') {
                                    $info_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-information-sub-title') {
                                    $info_sub_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-information-description') {
                                    $info_desc = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-information-button') {
                                    $info_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="col-xl-3 col-lg-4">
                            <div class="shop-reviews-left-inner">
                                <div class="disc-labl">
                                    {{ $info_title }}
                                </div>
                                <div class="section-title">
                                    <h2 class="title">{!! $info_sub_text !!}</h2>
                                </div>
                                <p>{{ $info_desc }}</p>
                                <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                    <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                                fill="white"></path>
                                        </svg></span>
                                    {{ $info_btn }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="col-xl-9 col-lg-8">
                        <div class="row itro-list">
                            @php
                                $homepage_logo_key = array_search('homepage-information-2', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_logo_key != '') {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                @foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-information-title') {
                                            $infor_title = $homepage_main_logo_value['field_default_text'];
                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                $infor_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-information-sub-title') {
                                            $infor_sub_text = $homepage_main_logo_value['field_default_text'];
                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                $infor_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-information-image') {
                                            $infor_image = $homepage_main_logo_value['field_default_text'];
                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                $infor_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    @endphp
                                @endforeach

                                <div class="col-lg-4 col-md-4 col-12 intro-card">
                                    <div class="intro-card-inner">
                                        <div class="intro-icon">
                                            <div class="back-shape">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="95"
                                                    viewBox="0 0 60 95" fill="none">
                                                    <path
                                                        d="M47.5 52.5C47.5 78.7335 73.7335 95 47.5 95C21.2665 95 0 73.7335 0 47.5C0 21.2665 21.2665 0 47.5 0C73.7335 0 47.5 26.2665 47.5 52.5Z"
                                                        fill="#3A1C36" />
                                                </svg>
                                            </div>
                                            <span class="icon-circle">
                                                <img src="{{ get_file($infor_image, APP_THEME()) }}" alt="">
                                            </span>
                                        </div>
                                        <div class="caption">
                                            <h3 class="title">{!! $infor_title !!}</h3>
                                            <p>{{ $infor_sub_text }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="padding-top shop-product-first padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('home-feature-products', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'home-feature-products-title') {
                                $bestseller_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'home-feature-products-sub-title') {
                                $bestseller_sub_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title text-center">
                        <h2 class="title">{!! $bestseller_title !!}</h2>
                        <div class="descripion">
                            <p>{{ $bestseller_sub_text }}</p>
                        </div>
                    </div>
                @endif
                <div class="row row-gap">
                    @foreach ($home_products as $homeproduct)
                        @php
                            $p_id = hashidsencode($homeproduct->id);
                        @endphp
                        <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 product-card col-12">
                            <div class="product-card-inner no-back">
                                <div class="product-card-image">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($homeproduct->cover_image_path, APP_THEME()) }}"
                                            class="default-img">
                                        @if ($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path, APP_THEME()) }}"
                                                class="hover-img">
                                        @else
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id), APP_THEME()) }}"
                                                class="hover-img">
                                        @endif
                                    </a>
                                    <div class="new-labl">
                                        {{ $homeproduct->tag_api }}
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top ">
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
                                                <div class="disc-badge">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                {{ $homeproduct->name }}
                                            </a>
                                        </h3>
                                        <div class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                            @if (!empty($homeproduct->average_rating))
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star review-stars {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-content-center">
                                        @if ($homeproduct->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $homeproduct->final_price }} <span
                                                        class="currency-type">{{ $currency }}</span></ins>
                                                <del>{{ $homeproduct->price }} {{ $currency }}</del>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                        <div class="bottom-select  d-flex align-items-center justify-content-between">
                                            <div class="cart-btn-wrap">
                                                <button class="btn addcart-btn-globaly"
                                                    product_id="{{ $homeproduct->id }}" variant_id="0" qty="1">
                                                    <span> {{ __('Add to cart') }}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                                        viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                            product_id="{{ $homeproduct->id }}"
                                            in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add' }}">
                                            <span class="wish-ic">
                                                <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                    style='color: #000000'></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="top-products-section padding-top padding-bottom">
            @php
                $homepage_header_1_key = array_search('home-category-product', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'home-category-product-title') {
                            $category_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'home-category-product-sub-text') {
                            $category_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'home-category-product-description') {
                            $category_desc = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'home-category-product-button') {
                            $category_btn = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'home-category-product-image') {
                            $category_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-bg">
                    <img src="{{ get_file($category_img, APP_THEME()) }}" alt="">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 col-12">
                            <div class="top-product-inner-left">
                                <div class="disc-labl">
                                    {{ $category_title }}
                                </div>
                                <div class="section-title">
                                    <h2 class="title">{!! $category_text !!}</h2>
                                </div>
                                <p>{{ $category_desc }}</p>
                                <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                    <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                                fill="white"></path>
                                        </svg></span>
                                    {{ $category_btn }} <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                        height="6" viewBox="0 0 4 6" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg></a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                            <div class="row inner-right-row align-items-center trending-slider">
                                @foreach ($bestSeller as $home_product)
                                    @php
                                        $p_id = hashidsencode($home_product->id);
                                    @endphp
                                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12 product-card">
                                        <div class="product-card-inner">
                                            <div class="product-card-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img src="{{ get_file($home_product->cover_image_path, APP_THEME()) }}"
                                                        class="default-img">
                                                    @if ($home_product->Sub_image($home_product->id)['status'] == true)
                                                        <img src="{{ get_file($home_product->Sub_image($home_product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                            class="hover-img">
                                                    @else
                                                        <img src="{{ get_file($home_product->Sub_image($home_product->id), APP_THEME()) }}"
                                                            class="hover-img">
                                                    @endif
                                                </a>
                                                <div class="new-labl">
                                                    {{ $home_product->tag_api }}
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top ">
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
                                                            <div class="disc-badge">
                                                                @if ($saleData['discount_type'] == 'flat')
                                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                                    -{{ $saleData['discount_amount'] }}%
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <h3 class="product-title short_description">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            {!! $home_product->name !!}
                                                        </a>
                                                    </h3>
                                                    <div
                                                        class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                                        @if (!empty($home_product->average_rating))
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i
                                                                    class="fa fa-star {{ $i < $home_product->average_rating ? '' : 'text-warning' }} "></i>
                                                            @endfor
                                                            <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                                        @else
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i
                                                                    class="fa fa-star review-stars {{ $i < $home_product->average_rating ? '' : 'text-warning' }} "></i>
                                                            @endfor
                                                            <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-content-center">
                                                    @if ($home_product->variant_product == 0)
                                                        <div class="price">
                                                            <ins>{{ $home_product->final_price }} <span
                                                                    class="currency-type">{{ $currency }}</span></ins>
                                                            <del>{{ $home_product->price }} {{ $currency }}</del>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div
                                                    class="product-content-bottom d-flex align-items-center justify-content-between">
                                                    <div
                                                        class="bottom-select  d-flex align-items-center justify-content-between">
                                                        <div class="cart-btn-wrap">
                                                            <button class="btn addcart-btn-globaly"
                                                                product_id="{{ $home_product->id }}" variant_id="0"
                                                                qty="1">
                                                                {{ __('Add to cart') }}
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                    height="6" viewBox="0 0 4 6" fill="none">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button href="javascript:void(0)"
                                                        class="wishlist-btn wbwish  wishbtn-globaly"
                                                        product_id="{{ $home_product->id }}"
                                                        in_wishlist="{{ $home_product->in_whishlist ? 'remove' : 'add' }}">
                                                        <span class="wish-ic">
                                                            <i class="{{ $home_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                style='color: #000000'></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section class="padding-top  bestsellers-categories">
            @php
                $homepage_header_1_keyss = array_search('home-bestsellers-category', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_keyss != '') {
                    $homepage_header = $theme_json[$homepage_header_1_keyss];
                    foreach ($homepage_header['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'home-bestsellers-category-title') {
                            $category_title = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header['section_enable'] == 'on')
                <div class="container">
                    <div class="tabs-wrapper">
                        <div class="section-title d-flex align-items-center justify-content-between">
                            <h2 class="title title-white">{!! $category_title !!}</h2>
                            <ul class="tabs d-flex">
                                @foreach ($MainCategory->take(5) as $cat_key => $category)
                                    <li class="tab-link  {{ $cat_key == 0 ? 'active' : '' }}"
                                        data-tab="{{ $cat_key }}">
                                        <a href="javascript:;">
                                            <span class="tab-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                    viewBox="0 0 19 19" fill="none">
                                                    <g clip-path="url(#clip0_1_8022)">
                                                        <path
                                                            d="M18.6561 7.66276L9.71775 1.11831C9.54539 0.992137 9.31123 0.992137 9.13894 1.11831L0.200557 7.66276C-0.0177672 7.82264 -0.0652033 8.1292 0.0946725 8.34753C0.254548 8.56585 0.561152 8.61321 0.779439 8.45341L9.42831 2.12084L18.0772 8.45337C18.1644 8.51727 18.2657 8.54803 18.3662 8.54803C18.5171 8.54803 18.6659 8.4786 18.7619 8.34749C18.9218 8.1292 18.8744 7.82264 18.6561 7.66276Z"
                                                            fill="white"></path>
                                                        <path
                                                            d="M16.2876 8.56421C16.0171 8.56421 15.7977 8.78356 15.7977 9.05415V16.8527H11.8782V12.5958C11.8782 11.2449 10.7792 10.1459 9.42834 10.1459C8.07752 10.1459 6.97846 11.2449 6.97846 12.5958V16.8527H3.05898V9.05419C3.05898 8.7836 2.83959 8.56425 2.56904 8.56425C2.29849 8.56425 2.0791 8.7836 2.0791 9.05419V17.3427C2.0791 17.6133 2.29849 17.8327 2.56904 17.8327H7.4684C7.72606 17.8327 7.9369 17.6336 7.95642 17.3809C7.9576 17.3694 7.95834 17.3569 7.95834 17.3427V12.5958C7.95834 11.7852 8.61777 11.1258 9.42834 11.1258C10.2389 11.1258 10.8983 11.7853 10.8983 12.5958V17.3427C10.8983 17.3568 10.8991 17.3691 10.9003 17.3804C10.9196 17.6333 11.1305 17.8327 11.3883 17.8327H16.2876C16.5582 17.8327 16.7776 17.6133 16.7776 17.3427V9.05419C16.7775 8.78356 16.5582 8.56421 16.2876 8.56421Z"
                                                            fill="white"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1_8022">
                                                            <rect width="18.8566" height="18.8566" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                            {{ $category }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @foreach ($MainCategory as $cat_k => $category)
                            <div class="tabs-container">
                                <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                                    <div class="row cat-protab-slider">
                                        @foreach ($homeproducts as $all_product)
                                            @php
                                                $p_id = hashidsencode($all_product->id);
                                            @endphp
                                            @if ($cat_k == '0' || $all_product->ProductData()->id == $cat_k)
                                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12 col-12">
                                                    <div class="category-card">
                                                        <div class="category-img">
                                                            <img src="{{ get_file($all_product->cover_image_path, APP_THEME()) }}"
                                                                alt="Sea Food">
                                                        </div>
                                                        <div class="category-card-body">
                                                            <div class="title-wrapper">
                                                                <h3 class="title">{{ $all_product->name }}</h3>
                                                            </div>
                                                            <div class="btn-wrapper">
                                                                <a href="{{ route('page.product-list', $slug) }}"
                                                                    class="btn">{{ __('Show more') }}
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                        height="6" viewBox="0 0 4 6" fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                            fill="white"></path>
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
                </div>
            @endif
        </section>

        <section class="padding-top padding-bottom categories-details">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-banner-1', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-banner-1-label-text') {
                                $banner_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-1-title') {
                                $banner_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-1-sub-title') {
                                $banner_sub_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-1-button') {
                                $banner_btn = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-banner-1-image') {
                                $banner_image = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header['section_enable'] == 'on')
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-xl-3 col-12">
                            <div class="shop-reviews-left-inner">
                                <div class="disc-labl">
                                    {{ $banner_text }}
                                </div>
                                <div class="section-title">
                                    <h2 class="title"> {!! $banner_title !!} </h2>
                                </div>
                                <p>{{ $banner_sub_title }}</p>
                                <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                    <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                                fill="white"></path>
                                        </svg></span>
                                    {{ $banner_btn }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                        viewBox="0 0 4 6" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xl-9 col-12">
                            <div class="row row-gap">
                                <div class="col-lg-7 col-xl-8 col-12 col-md-7 col-sm-6 col-12">
                                    <div class="fresh-product-image">
                                        <img src="{{ get_file($banner_image, APP_THEME()) }}" alt="">
                                    </div>
                                </div>
                                @if (!empty($latest_product))
                                    <div class="col-lg-5 col-xl-4 col-md-5 col-sm-6 col-12 product-card">
                                        @php
                                            $p_id = hashidsencode($latest_product->id);
                                        @endphp
                                        <div class="product-card-inner no-back">
                                            <div class="product-card-image">
                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                    <img src="{{ get_file($latest_product->cover_image_path, APP_THEME()) }}"
                                                        class="default-img">
                                                    @if ($latest_product->Sub_image($latest_product->id)['status'] == true)
                                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                            class="hover-img">
                                                    @else
                                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id), APP_THEME()) }}"
                                                            class="hover-img">
                                                    @endif
                                                </a>
                                                <div class="new-labl">
                                                    {{ $latest_product->tag_api }}
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top ">
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
                                                            <div class="disc-badge">
                                                                @if ($saleData['discount_type'] == 'flat')
                                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                                    -{{ $saleData['discount_amount'] }}%
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <h3 class="product-title">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            {!! $latest_product->name !!}
                                                        </a>
                                                    </h3>
                                                    <div
                                                        class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                                        @if (!empty($latest_product->average_rating))
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i
                                                                    class="fa fa-star {{ $i < $latest_product->average_rating ? '' : 'text-warning' }} "></i>
                                                            @endfor
                                                            <span><b>{{ $latest_product->average_rating }}.0</b> /
                                                                5.0</span>
                                                        @else
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i
                                                                    class="fa fa-star review-stars {{ $i < $latest_product->average_rating ? '' : 'text-warning' }} "></i>
                                                            @endfor
                                                            <span><b>{{ $latest_product->average_rating }}.0</b> /
                                                                5.0</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-content-center">
                                                    @if ($latest_product->variant_product == 0)
                                                        <div class="price">
                                                            <ins>{{ $latest_product->final_price }} <span
                                                                    class="currency-type">{{ $currency }}</span></ins>
                                                            <del>{{ $latest_product->price }} {{ $currency }}</del>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div
                                                    class="product-content-bottom d-flex align-items-center justify-content-between">
                                                    <div
                                                        class="bottom-select  d-flex align-items-center justify-content-between">
                                                        <div class="cart-btn-wrap">
                                                            <button class="btn addcart-btn-globaly"
                                                                product_id="{{ $latest_product->id }}" variant_id="0"
                                                                qty="1">
                                                                {{ __('Add to cart') }}
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                    height="6" viewBox="0 0 4 6" fill="none">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                        fill="white"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button href="javascript:void(0)"
                                                        class="wishlist-btn wbwish  wishbtn-globaly"
                                                        product_id="{{ $homeproduct->id }}"
                                                        in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add' }}">
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row align-items-center row-reverse">
                    @php
                        $homepage_header_1_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-banner-2-label-text') {
                                    $banner_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-2-title') {
                                    $banner_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-2-sub-title') {
                                    $banner_sub_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-2-button') {
                                    $banner_btn = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-banner-2-image') {
                                    $banner_image = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    <div class="col-lg-4 col-xl-3 col-12">
                        <div class="shop-reviews-left-inner">
                            <div class="disc-labl">
                                {{ $banner_text }}
                            </div>
                            <div class="section-title">
                                <h2 class="title"> {!! $banner_title !!} </h2>
                            </div>
                            <p>{{ $banner_sub_title }}</p>
                            <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                            fill="white"></path>
                                    </svg></span>
                                {{ $banner_btn }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9 col-12 col-12">
                        <div class="row row-gap">
                            <div class="col-lg-7 col-xl-8 col-12 col-md-7 col-sm-6 col-12">
                                <div class="fresh-product-image">
                                    <img src="{{ get_file($banner_image, APP_THEME()) }}" alt="">
                                </div>
                            </div>
                            @if (!empty($random_product))
                                <div class="col-lg-5 col-xl-4 col-md-5 col-sm-6 col-12 product-card">
                                    @php
                                        $p_id = hashidsencode($random_product->id);
                                    @endphp
                                    <div class="product-card-inner no-back">
                                        <div class="product-card-image">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                <img src="{{ get_file($random_product->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">
                                                @if ($random_product->Sub_image($random_product->id)['status'] == true)
                                                    <img src="{{ get_file($random_product->Sub_image($random_product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                        class="hover-img">
                                                @else
                                                    <img src="{{ get_file($random_product->Sub_image($random_product->id), APP_THEME()) }}"
                                                        class="hover-img">
                                                @endif
                                            </a>
                                            <div class="new-labl">
                                                {{ $random_product->tag_api }}
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top ">
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
                                                                if (is_array($saleEnableArray) && in_array($random_product->id, $saleEnableArray)) {
                                                                    $latestSales[$random_product->id] = [
                                                                        'discount_type' => $flashsale->discount_type,
                                                                        'discount_amount' => $flashsale->discount_amount,
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($latestSales as $productId => $saleData)
                                                        <div class="disc-badge">
                                                            @if ($saleData['discount_type'] == 'flat')
                                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                                -{{ $saleData['discount_amount'] }}%
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <h3 class="product-title">
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                        {!! $random_product->name !!}
                                                    </a>
                                                </h3>
                                                <div
                                                    class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                                    @if (!empty($random_product->average_rating))
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="fa fa-star {{ $i < $random_product->average_rating ? '' : 'text-warning' }} "></i>
                                                        @endfor
                                                        <span><b>{{ $random_product->average_rating }}.0</b> / 5.0</span>
                                                    @else
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="fa fa-star review-stars {{ $i < $random_product->average_rating ? '' : 'text-warning' }} "></i>
                                                        @endfor
                                                        <span><b>{{ $random_product->average_rating }}.0</b> / 5.0</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-content-center">
                                                @if ($random_product->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{ $random_product->final_price }} <span
                                                                class="currency-type">{{ $currency }}</span></ins>
                                                        <del>{{ $random_product->price }} {{ $currency }}</del>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                            </div>
                                            <div
                                                class="product-content-bottom d-flex align-items-center justify-content-between">
                                                <div
                                                    class="bottom-select  d-flex align-items-center justify-content-between">
                                                    <div class="cart-btn-wrap">
                                                        <button class="btn addcart-btn-globaly"
                                                            product_id="{{ $random_product->id }}" variant_id="0"
                                                            qty="1">
                                                            {{ __('Add to cart') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                height="6" viewBox="0 0 4 6" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                                    product_id="{{ $random_product->id }}"
                                                    in_wishlist="{{ $random_product->in_whishlist ? 'remove' : 'add' }}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $random_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: #000000'></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="padding-top home-blog-section padding-bottom">
            <div class="section-bg">
                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/home-blog-back.jpg') }}" alt="">
            </div>
            <div class="container">
                @php
                    $homepage_header_1_keyss = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_keyss != '') {
                        $homepage_header = $theme_json[$homepage_header_1_keyss];
                        foreach ($homepage_header['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $blog_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title') {
                                $blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $blog_sub_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header['section_enable'] == 'on')
                    <div class="section-title">
                        <div class="tagline">{{ $blog_text }}</div>
                        <h2 class="title">{{ $blog_title }}</h2>
                        <div class="descripion">
                            <p>{{ $blog_sub_text }}</p>
                        </div>
                    </div>
                @endif
                <div class="row blog-list-home">
                    {!! \App\Models\Blog::HomePageBlog($slug, 6) !!}
                </div>
            </div>
        </section>

        <section class="padding-top shop-product-second padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-title') {
                                $bestseller_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-bestseller-sub-text') {
                                $bestseller_sub_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title text-center">
                        <h2 class="title">{!! $bestseller_title !!}</h2>
                        <div class="descripion">
                            <p>{{ $bestseller_sub_text }}</p>
                        </div>
                    </div>
                @endif
                <div class="row row-gap">
                    @foreach ($discount_products->take(8) as $homeproduct)
                        @php
                            $p_id = hashidsencode($homeproduct->id);
                        @endphp
                        <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 product-card col-12">
                            <div class="product-card-inner no-back">
                                <div class="product-card-image">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($homeproduct->cover_image_path, APP_THEME()) }}"
                                            class="default-img">
                                        @if ($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path, APP_THEME()) }}"
                                                class="hover-img">
                                        @else
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id), APP_THEME()) }}"
                                                class="hover-img">
                                        @endif
                                    </a>
                                    <div class="new-labl">
                                        {{ $homeproduct->tag_api }}
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top ">
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
                                                <div class="disc-badge">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <h3 class="product-title short_description">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                {{ $homeproduct->name }}
                                            </a>
                                        </h3>
                                        <div class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                            @if (!empty($homeproduct->average_rating))
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star review-stars {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-content-center">
                                        @if ($homeproduct->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $homeproduct->final_price }} <span
                                                        class="currency-type">{{ $currency }}</span></ins>
                                                <del>{{ $homeproduct->price }} {{ $currency }}</del>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                        <div class="bottom-select  d-flex align-items-center justify-content-between">
                                            <div class="cart-btn-wrap">
                                                <button class="btn addcart-btn-globaly"
                                                    product_id="{{ $homeproduct->id }}" variant_id="0" qty="1">
                                                    <span> {{ __('Add to cart') }}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                                        viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                            product_id="{{ $homeproduct->id }}"
                                            in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add' }}">
                                            <span class="wish-ic">
                                                <i
                                                    class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="today-discounts padding-bottom">
            <div class="container">
                <div class="tabs-wrapper">
                    <div class="section-title d-flex align-items-center justify-content-between">
                        @php
                            $homepage_header_1_keyss = array_search('homepage-collection', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_keyss != '') {
                                $homepage_header = $theme_json[$homepage_header_1_keyss];
                                foreach ($homepage_header['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-collection-title') {
                                        $collection_title = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header['section_enable'] == 'on')
                            <h2 class="title title-white">{!! $collection_title !!}</h2>
                        @endif
                        <ul class="tabs d-flex">
                            @foreach ($MainCategory as $cat_key => $category)
                                <li class="tab-link  {{ $cat_key == 0 ? 'active' : '' }}"
                                    data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">
                                        <span class="tab-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                viewBox="0 0 19 19" fill="none">
                                                <g clip-path="url(#clip0_1_8022)">
                                                    <path
                                                        d="M18.6561 7.66276L9.71775 1.11831C9.54539 0.992137 9.31123 0.992137 9.13894 1.11831L0.200557 7.66276C-0.0177672 7.82264 -0.0652033 8.1292 0.0946725 8.34753C0.254548 8.56585 0.561152 8.61321 0.779439 8.45341L9.42831 2.12084L18.0772 8.45337C18.1644 8.51727 18.2657 8.54803 18.3662 8.54803C18.5171 8.54803 18.6659 8.4786 18.7619 8.34749C18.9218 8.1292 18.8744 7.82264 18.6561 7.66276Z"
                                                        fill="white"></path>
                                                    <path
                                                        d="M16.2876 8.56421C16.0171 8.56421 15.7977 8.78356 15.7977 9.05415V16.8527H11.8782V12.5958C11.8782 11.2449 10.7792 10.1459 9.42834 10.1459C8.07752 10.1459 6.97846 11.2449 6.97846 12.5958V16.8527H3.05898V9.05419C3.05898 8.7836 2.83959 8.56425 2.56904 8.56425C2.29849 8.56425 2.0791 8.7836 2.0791 9.05419V17.3427C2.0791 17.6133 2.29849 17.8327 2.56904 17.8327H7.4684C7.72606 17.8327 7.9369 17.6336 7.95642 17.3809C7.9576 17.3694 7.95834 17.3569 7.95834 17.3427V12.5958C7.95834 11.7852 8.61777 11.1258 9.42834 11.1258C10.2389 11.1258 10.8983 11.7853 10.8983 12.5958V17.3427C10.8983 17.3568 10.8991 17.3691 10.9003 17.3804C10.9196 17.6333 11.1305 17.8327 11.3883 17.8327H16.2876C16.5582 17.8327 16.7776 17.6133 16.7776 17.3427V9.05419C16.7775 8.78356 16.5582 8.56421 16.2876 8.56421Z"
                                                        fill="white"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_1_8022">
                                                        <rect width="18.8566" height="18.8566" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        {{ $category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @foreach ($MainCategory as $cat_k => $category)
                        <div class="tabs-container">
                            <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                                <div class="shop-protab-slider row">
                                    @foreach ($MainCategoryList->take(1) as $category)
                                        <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12">
                                            <div class="category-card second-style">
                                                <div class="category-img">
                                                    <img src="{{ $category->image_path }}" alt="">
                                                </div>
                                                <div class="category-card-body">
                                                    <div class="title-wrapper">
                                                        <h3 class="title">{{ $category->name }}</h3>
                                                    </div>
                                                    <div class="btn-wrapper">
                                                        <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                                            class="btn">
                                                            {{ __('Show more') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                height="6" viewBox="0 0 4 6" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach ($homeproducts as $modern_product)
                                        @php
                                            $p_id = hashidsencode($modern_product->id);
                                        @endphp
                                        @if ($cat_k == '0' || $modern_product->ProductData()->id == $cat_k)
                                            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12 product-card">
                                                <div class="product-card-inner no-back">
                                                    <div class="product-card-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img src="{{ get_file($modern_product->cover_image_path, APP_THEME()) }}"
                                                                class="default-img">
                                                            @if ($modern_product->Sub_image($modern_product->id)['status'] == true)
                                                                <img src="{{ get_file($modern_product->Sub_image($modern_product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @else
                                                                <img src="{{ get_file($modern_product->Sub_image($modern_product->id), APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @endif
                                                        </a>
                                                        <div class="new-labl">
                                                            {{ $modern_product->tag_api }}
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-content-top ">
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
                                                                            if (is_array($saleEnableArray) && in_array($modern_product->id, $saleEnableArray)) {
                                                                                $latestSales[$modern_product->id] = [
                                                                                    'discount_type' => $flashsale->discount_type,
                                                                                    'discount_amount' => $flashsale->discount_amount,
                                                                                ];
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                @foreach ($latestSales as $productId => $saleData)
                                                                    <div class="disc-badge">
                                                                        @if ($saleData['discount_type'] == 'flat')
                                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                                            -{{ $saleData['discount_amount'] }}%
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <h3 class="product-title">
                                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                                    {{ $modern_product->name }}
                                                                </a>
                                                            </h3>
                                                            <div
                                                                class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                                                @if (!empty($modern_product->average_rating))
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i
                                                                            class="fa fa-star {{ $i < $modern_product->average_rating ? '' : 'text-warning' }} "></i>
                                                                    @endfor
                                                                    <span><b>{{ $modern_product->average_rating }}.0</b> /
                                                                        5.0</span>
                                                                @else
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i
                                                                            class="fa fa-star review-stars {{ $i < $modern_product->average_rating ? '' : 'text-warning' }} "></i>
                                                                    @endfor
                                                                    <span><b>{{ $modern_product->average_rating }}.0</b> /
                                                                        5.0</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="product-content-center">
                                                            @if ($modern_product->variant_product == 0)
                                                                <div class="price">
                                                                    <ins class="text-danger">{{ $modern_product->final_price }}
                                                                        <span
                                                                            class="currency-type">{{ $currency }}</span></ins>
                                                                    <del>{{ $modern_product->price }}
                                                                        {{ $currency }}</del>
                                                                </div>
                                                            @else
                                                                <div class="price">
                                                                    <ins>{{ __('In Variant') }}</ins>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="product-content-bottom d-flex align-items-center justify-content-between">
                                                            <div
                                                                class="bottom-select  d-flex align-items-center justify-content-between">
                                                                <div class="cart-btn-wrap">
                                                                    <button class="btn addcart-btn-globaly"
                                                                        product_id="{{ $modern_product->id }}"
                                                                        variant_id="0" qty="1">
                                                                        {{ __('Add to cart') }}
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="4" height="6"
                                                                            viewBox="0 0 4 6" fill="none">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                                fill="white"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <button href="javascript:void(0)"
                                                                class="wishlist-btn wbwish  wishbtn-globaly"
                                                                product_id="{{ $modern_product->id }}"
                                                                in_wishlist="{{ $modern_product->in_whishlist ? 'remove' : 'add' }}">
                                                                <span class="wish-ic">
                                                                    <i class="{{ $modern_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                        style='color: #000000'></i>
                                                                </span>
                                                            </button>
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
            </div>
        </section>

        <section class="padding-top shop-partners padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('home-logo', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'home-logo-text') {
                                $logo_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title">
                        <h2 class="title">{{ $logo_title }}</h2>
                    </div>
                @endif
                <div class="client-logo-slider common-arrows">
                    @php
                        $homepage_logo = '';
                        $homepage_logo_key = array_search('home-logo', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_logo_key != '') {
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                        }
                    @endphp
                    @if (!empty($homepage_main_logo['home-logo-logo']))
                        @for ($i = 0; $i < count($homepage_main_logo['home-logo-logo']); $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                    if ($homepage_main_logo_value['field_slug'] == 'home-logo-logo') {
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        if ($homepage_main_logo_value['field_slug'] == 'home-logo-logo') {
                                            $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
                                </a>
                            </div>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 10; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                    if ($homepage_main_logo_value['field_slug'] == 'home-logo-logo') {
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="Client logo">
                                </a>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        <section class="testimonials padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('home-testimonials', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'home-testimonials-title') {
                                $test_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'home-testimonials-button') {
                                $test_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title d-flex align-items-center justify-content-between">
                        <h2 class="title">{{ $test_title }}</h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                            {{ $test_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </div>
                @endif
                <div class="review-slider flex-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonials-card">
                            <div class="card-inner">
                                <div class="reviews-stars-wrap d-flex align-items-center">
                                    <div class="point-wrap">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i
                                                class="fa fa-star {{ $i < $review->rating_no ? '' : 'text-warning' }} "></i>
                                        @endfor
                                        <span><b>{{ $review->rating_no }}.0</b> / 5.0</span>
                                    </div>
                                </div>
                                <div class="reviews-words">
                                    <h3 class="main-word">{!! $review->title !!}</h3>
                                    <p class="description">{{ $review->description }}</p>
                                </div>
                                <div class="reviewer-profile">
                                    <div class="reviewer-img">
                                        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/reviewer-img.png') }}"
                                            alt="reviewer-img">
                                    </div>
                                    <div class="reviewer-desc">
                                        <span><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</b>
                                            Client</span>
                                        {{-- <p>about <a href="#">Basil Leaves</a></p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="slider-nav"></div>
            </div>
        </section>

    </div>
@endsection
