@extends('layouts.layouts')


@section('page-title')
    {{ __('Home Page') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
    <div class="wrapper">
        <section class="home-banner-section">
            <div class="mian-banner-image">
                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/banner-image.png') }}" alt="">
            </div>
            <div class="container">
                <div class="banner-main-content d-flex align-items-center">

                    <div class="banner-right-side">
                        @php
                            $homepage_promotions_text = $homepage_promotions_txt = $homepage_promotions_sub_txt = $homepage_promotions_btn_txt = $homepage_promotions_offer = '';

                            $homepage_promotions_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_promotions_key != '') {
                                $homepage_promotions_section = $theme_json[$homepage_promotions_key];
                            }
                        @endphp

                        <div class="banner-slider">
                            @for ($i = 0; $i < $homepage_promotions_section['loop_number']; $i++)
                                @php
                                    foreach ($homepage_promotions_section['inner-list'] as $homepage_promotions_section_value) {
                                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-label-text') {
                                            $homepage_promotions_text = $homepage_promotions_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-label-text') {
                                                $homepage_promotions_text = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                                            }
                                        }

                                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-title-text') {
                                            $homepage_promotions_txt = $homepage_promotions_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-title-text') {
                                                $homepage_promotions_txt = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                                            }
                                        }
                                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-sub-text') {
                                            $homepage_promotions_sub_txt = $homepage_promotions_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-sub-text') {
                                                $homepage_promotions_sub_txt = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                                            }
                                        }
                                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-btn-text') {
                                            $homepage_promotions_btn_txt = $homepage_promotions_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-btn-text') {
                                                $homepage_promotions_btn_txt = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                                            }
                                        }
                                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-offer-icon') {
                                            $homepage_promotions_offer = $homepage_promotions_section_value['field_default_text'];
                                        }

                                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-banner-offer-icon') {
                                                $homepage_promotions_offer = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <div class="home-banner-content">
                                    <div class="home-banner-content-inner">
                                        <div class="new-labl">
                                            {!! $homepage_promotions_text !!}
                                        </div>
                                        <h2 class="h1">{!! $homepage_promotions_txt !!}</h2>
                                        <div class="discount-rate">
                                            <div class="">
                                                <img src="{{ get_file($homepage_promotions_offer, APP_THEME()) }}">
                                            </div>
                                        </div>
                                        <div class="desk-wrapper">
                                            <p>{!! $homepage_promotions_sub_txt !!}</p>
                                        </div>
                                        <a href="{{ route('page.product-list', $slug) }}" class="btn btn-white"
                                            tabindex="0">
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
                                            {!! $homepage_promotions_btn_txt !!} <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                height="6" viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill="white"></path>
                                            </svg></a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="home-banner-nav"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="shop-categories">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_best_product_heading = $homepage_best_product_btn = '';
                        $homepage_best_product_key = array_search('homepage-category', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-category-title-text') {
                                    $homepage_best_product_heading = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-category-btn-text') {
                                    $homepage_best_product_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <h2 class="title">{!! $homepage_best_product_heading !!}</h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn desk-only">
                            {!! $homepage_best_product_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    @endif
                </div>
                <div class="row row-gap">
                    @foreach ($trending_categories as $category)
                        {{-- @dd($category) --}}
                        <div class="col-lg-3 col-xl-3 col-md-6 col-sm-6 col-12">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="{{ get_file($category->image_path, APP_THEME()) }}" alt="bakers">
                                </div>
                                <div class="category-card-body">
                                    <div class="title-wrapper">
                                        <h3 class="title">{{ $category->name }}</h3>
                                    </div>
                                    <p>
                                        {{-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. --}}
                                    </p>
                                    <div class="btn-wrapper">
                                        <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}"
                                            class="btn">
                                            {{ __('Go to Category') }} <svg xmlns="http://www.w3.org/2000/svg"
                                                width="4" height="6" viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill="white"></path>
                                            </svg></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="section-left-shape">
                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/section-left-img.png') }}" alt="">
            </div>
        </section>
        <section class="shop-reviews padding-top padding-bottom">
            <div class="container">
                <div class="row align-items-center row-gap">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="shop-reviews-left-inner">
                            @php
                                $homepage_best_product_text = $homepage_best_product_title = $homepage_best_product_sub = $homepage_best_product_btn = $homepage_best_product_img = '';
                                $homepage_best_product_key = array_search('homepage-review', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-review-label-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-title-text') {
                                            $homepage_best_product_title = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-img') {
                                            $homepage_best_product_img = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="new-labl bg-second">
                                    {!! $homepage_best_product_text !!}
                                </div>
                                <div class="section-title">
                                    <h2 class="title">{!! $homepage_best_product_title !!}</h2>
                                </div>
                                <p>{!! $homepage_best_product_sub !!} </p>
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
                                    {!! $homepage_best_product_btn !!} <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                        height="6" viewBox="0 0 4 6" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg></a>
                            @endif

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="shop-reviews-right-inner">
                            <div class="shop-reviews-image">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/green-mandarines.png') }}"
                                    alt="green-mandarines">
                            </div>
                            <div class="review-info-wrap">
                                <div class="review-box-wrapper">
                                    <div class="review-box-wrapper">
                                        <div class="">
                                            <div class="user-pro-list">
                                                <ul class="">
                                                    <li>
                                                        <img src="{{ get_file($homepage_best_product_img, APP_THEME()) }}"
                                                            alt="user1">
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-bottom today-discounts">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_best_product_text = $homepage_best_product_btn = '';
                        $homepage_best_product_key = array_search('homepage-discount-section', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-discount-section-title-text') {
                                    $homepage_best_product_text = $value['field_default_text'];
                                }

                                if ($value['field_slug'] == 'homepage-discount-section-btn-text') {
                                    $homepage_best_product_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <h2 class="title">{!! $homepage_best_product_text !!} <span
                                class="new-labl bg-danger">{{ __('OFF') }}</span></h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                            {!! $homepage_best_product_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    @endif
                </div>
                <div class="product-row today-discounts-slider">
                    @foreach ($discount_products as $item)
                        @php
                            $d_id = hashidsencode($item->id);
                        @endphp
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{ route('page.product', [$slug, $d_id]) }}">
                                        <img src="{{ get_file($item->cover_image_path, APP_THEME()) }}"
                                            class="default-img">
                                        @if ($item->Sub_image($item->id)['status'] == true)
                                            <img src="{{ get_file($item->Sub_image($item->id)['data'][0]->image_path, APP_THEME()) }}"
                                                class="hover-img">
                                        @else
                                            <img src="{{ get_file($item->Sub_image($item->id), APP_THEME()) }}"
                                                class="hover-img">
                                        @endif
                                        <button class="wishlist-btn" tabindex="0" style="top: 1px;">
                                            <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly"
                                                tabindex="0" product_id="{{ $item->id }}"
                                                in_wishlist="{{ $item->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $item->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </a>
                                        </button>
                                    </a>
                                </div>
                                <div class="custom-output">
                                    @php
                                        $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                            ->where('store_id', getCurrentStore())
                                            ->where('is_active', 1)
                                            ->get();
                                        $latestSales = [];
                                        date_default_timezone_set('Asia/Kolkata');
                                        $currentDateTime = \Carbon\Carbon::now();

                                        foreach ($sale_product as $flashsale) {
                                            $saleEnableArray = json_decode($flashsale->sale_product, true);
                                            $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                            $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                            if ($endDate < $startDate) {
                                                $endDate->addDay();
                                            }
                                            $currentDateTime->setTimezone($startDate->getTimezone());

                                            if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                if (is_array($saleEnableArray) && in_array($item->id, $saleEnableArray)) {
                                                    $latestSales[$item->id] = [
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
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <div class="product-type">{{ ucfirst($item->tag_api) }}</div>
                                        <h3 class="product-title">
                                            <a href="{{ route('page.product', [$slug, $d_id]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </h3>
                                        <div class="reviews-stars-wrap">
                                            <div class="reviews-stars-outer">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="ti ti-star review-stars {{ $i < $item->average_rating ? 'text-warning' : '' }} "></i>
                                                @endfor
                                            </div>
                                            <div class="point-wrap">
                                                <span class="review-point">{{ $item->average_rating }}.0 /
                                                    <span>5.0</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content-bottom">
                                        @if ($item->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $item->final_price }} <span
                                                        class="currency-type">{{ $currency }}</span></ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <button class="addtocart-btn btn   addcart-btn-globaly" tabindex="0"
                                            product_id="{{ $item->id }}" variant_id="0" qty="1">
                                            <span> {{ __('Add to cart') }} </span>
                                            <svg viewBox="0 0 10 5">
                                                <path
                                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="right-side-image">
                <img src=" {{ asset('themes/' . APP_THEME() . '/assets/images/right-Warstwa.png') }}" alt="">
            </div>
        </section>
        <section class="padding-bottom padding-top bestseller-section">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_best_product_text = $homepage_best_product_btn = '';
                        $homepage_best_product_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                    $homepage_best_product_text = $value['field_default_text'];
                                }

                                if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                    $homepage_best_product_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <h2 class="title">{!! $homepage_best_product_text !!}</h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                            {!! $homepage_best_product_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    @endif
                </div>
                <div class="tabs-wrapper">
                    <div class="tab-nav">
                        <ul class="tabs">
                            @foreach ($MainCategory as $cat_key => $category)
                                <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">{{ $category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @foreach ($MainCategory as $cat_k => $category)
                        <div class="tabs-container">
                            <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                                <div class="product-row shop-protab-slider">
                                    @foreach ($all_products as $product)
                                        @if ($cat_k == '0' || $product->ProductData()->id == $cat_k)
                                            @php
                                                $p_id = hashidsencode($product->id);
                                            @endphp
                                            <div class="product-card">
                                                <div class="product-card-inner">
                                                    <div class="product-card-image">
                                                        <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                            <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                                class="default-img">
                                                            @if ($product->Sub_image($product->id)['status'] == true)
                                                                <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @else
                                                                <img src="{{ get_file($product->Sub_image($product->id), APP_THEME()) }}"
                                                                    class="hover-img">
                                                            @endif
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
                                                                $currentDateTime->setTimezone($startDate->getTimezone());
                                                                if ($endDate < $startDate) {
                                                                    $endDate->addDay();
                                                                }

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
                                                    <div class="product-content">
                                                        <div class="product-content-top">
                                                            <h3 class="product-title">
                                                                <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </h3>
                                                            <div class="reviews-stars-wrap d-flex align-items-center">
                                                                <div class="reviews-stars-outer">
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i
                                                                            class="ti ti-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                                    @endfor
                                                                </div>
                                                                <div class="point-wrap">
                                                                    <span
                                                                        class="review-point">{{ $product->average_rating }}.0/
                                                                        <span>5.0</span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="product-content-bottom">
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
                                                            {{-- <div class="product-selectors">
                                                            <div class="size-select">
                                                                <span class="lbl">Size:</span>
                                                                <select>
                                                                    <option>1 kilogram / bag</option>
                                                                    <option>2 kilogram / bag</option>
                                                                    <option>3 kilogram / bag</option>
                                                                </select>
                                                            </div>
                                                            <div class="quantity-select">
                                                                <span class="lbl">Quantity:</span>
                                                                <div class="qty-spinner">
                                                                    <button type="button" class="quantity-decrement ">
                                                                        <svg width="12" height="2" viewBox="0 0 12 2"
                                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0 0.251343V1.74871H12V0.251343H0Z"
                                                                                fill="#61AFB3">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                    <input type="text" class="quantity"
                                                                        data-cke-saved-name="quantity" name="quantity"
                                                                        value="01" min="01" max="100">
                                                                    <button type="button" class="quantity-increment ">
                                                                        <svg width="12" height="12" viewBox="0 0 12 12"
                                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                                                fill="#61AFB3"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                            <button class="addtocart-btn btn   addcart-btn-globaly"
                                                                tabindex="0" product_id="{{ $product->id }}"
                                                                variant_id="0" qty="1">
                                                                <span> {{ __('Add to cart') }} </span>
                                                                <svg viewBox="0 0 10 5">
                                                                    <path
                                                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <button class="wishlist-btn" tabindex="0"
                                                                style="top: 1px;">
                                                                <a href="javascript:void(0)"
                                                                    class="wishlist-btn wishbtn-globaly" tabindex="0"
                                                                    product_id="{{ $product->id }}"
                                                                    in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                                    <i
                                                                        class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                </a>
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
        <section class="padding-bottom padding-top loved-category">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_best_product_text = $homepage_best_product_btn = '';
                        $homepage_best_product_key = array_search('homepage-feature-product-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-product-title-text') {
                                    $homepage_best_product_text = $value['field_default_text'];
                                }

                                if ($value['field_slug'] == 'homepage-feature-product-btn-text') {
                                    $homepage_best_product_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <h2 class="title">{!! $homepage_best_product_text !!}</h2>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                            {!! $homepage_best_product_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    @endif
                </div>
                <div class="row row-gap">
                    <div class="col-xl-6 col-lg-5 col-md-4 col-12">
                        <div class="category-card">
                            @php
                                $homepage_best_product_text = $homepage_best_product_sub = $homepage_best_product_btn = $homepage_best_product_img = '';
                                $homepage_best_product_key = array_search('homepage-feature-product-2', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-feature-product-title-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-feature-product-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-feature-product-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-feature-product-bg-img') {
                                            $homepage_best_product_img = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="category-img">
                                    <img src="{{ get_file($homepage_best_product_img, APP_THEME()) }}"
                                        alt="vegetables-2">
                                </div>
                                <div class="category-card-body">

                                    <div class="title-wrapper">
                                        <h4 class="title">{!! $homepage_best_product_text !!}</h4>
                                    </div>
                                    <p>
                                        {!! $homepage_best_product_sub !!}
                                    </p>
                                    <div class="btn-wrapper">
                                        <a href="{{ route('page.product-list', $slug) }}" class="btn">
                                            {!! $homepage_best_product_btn !!} <svg xmlns="http://www.w3.org/2000/svg"
                                                width="4" height="6" viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill="white"></path>
                                            </svg></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7 col-md-8 col-12">
                        <div class="product-row loved-category-slider">
                            @foreach ($modern_products as $product)
                                @php
                                    $p_id = hashidsencode($product->id);
                                @endphp
                                <div class="product-card">
                                    <div class="product-card-inner">
                                        <div class="product-card-image">
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">
                                                @if ($product->Sub_image($product->id)['status'] == true)
                                                    <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path, APP_THEME()) }}"
                                                        class="hover-img">
                                                @else
                                                    <img src="{{ get_file($product->Sub_image($product->id), APP_THEME()) }}"
                                                        class="hover-img">
                                                @endif
                                                <button class="wishlist-btn" tabindex="0" style="top: 1px;">
                                                    <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly"
                                                        tabindex="0" product_id="{{ $product->id }}"
                                                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </a>
                                                </button>
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
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <div class="product-type">{{ ucfirst($product->tag_api) }}</div>
                                                <h3 class="product-title">
                                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h3>
                                                <div class="reviews-stars-wrap d-flex align-items-center">
                                                    <div class="reviews-stars-outer">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="ti ti-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                        @endfor
                                                    </div>
                                                    <div class="point-wrap">
                                                        <span class="review-point">{{ $product->average_rating }}.0/
                                                            <span>5.0</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content-bottom">
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
                                                <button class="addtocart-btn btn   addcart-btn-globaly" tabindex="0"
                                                    product_id="{{ $product->id }}" variant_id="0" qty="1">
                                                    <span> {{ __('Add to cart') }} </span>
                                                    <svg viewBox="0 0 10 5">
                                                        <path
                                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                        </path>
                                                    </svg>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="loved-product padding-top">
                    <div class="section-title d-flex align-items-start justify-content-between">
                        <div class="left-side">
                            @php
                                $homepage_best_product_text = $homepage_best_product_sub = $homepage_best_product_btn = '';
                                $homepage_best_product_key = array_search('homepage-feature-category', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-feature-category-title-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-feature-category-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-feature-category-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <h2 class="title">{!! $homepage_best_product_text !!}</h2>
                                <div class="section-desc">
                                    <p>{!! $homepage_best_product_sub !!} </p>
                                </div>
                        </div>
                        <a href="{{ route('page.product-list',$slug) }}" class="btn">
                            {!! $homepage_best_product_btn !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                    <div class="row row-gap">
                        {!! \App\Models\MainCategory::HomePageBestCategory($slug,4) !!}
                    </div>
                </div> --}}
            </div>
        </section>
        <section class="loved-product padding-top">
            <div class="container">
                <div class="section-title d-flex align-items-start justify-content-between">
                    <div class="left-side">
                        @php
                            $homepage_best_product_text = $homepage_best_product_sub = $homepage_best_product_btn = '';
                            $homepage_best_product_key = array_search('homepage-feature-category', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_best_product_key != '') {
                                $homepage_best_product = $theme_json[$homepage_best_product_key];

                                foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-feature-category-title-text') {
                                        $homepage_best_product_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-feature-category-sub-text') {
                                        $homepage_best_product_sub = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-feature-category-btn-text') {
                                        $homepage_best_product_btn = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_best_product['section_enable'] == 'on')
                            <h2 class="title">{!! $homepage_best_product_text !!}</h2>
                            <div class="section-desc">
                                <p>{!! $homepage_best_product_sub !!} </p>
                            </div>
                    </div>
                    <a href="{{ route('page.product-list', $slug) }}" class="btn">
                        {!! $homepage_best_product_btn !!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill="white"></path>
                        </svg>
                    </a>
                    @endif
                </div>
                <div class="row row-gap">
                    {!! \App\Models\MainCategory::HomePageBestCategory($slug, 4) !!}
                </div>
            </div>
        </section>
        <section class="categories-new">
            <div class="row no-gutters ">
                @foreach ($homepage_products as $key => $product)
                    @php
                        $p_id = hashidsencode($product->id);
                    @endphp
                    <div class="col-md-6 col-12">
                        <div class="category-card second-look">
                            @if ($key == '0')
                                <div class="category-img">
                                    <img src="{{ asset('themes/grocery/assets/images/menu-product.png') }}">
                                </div>
                            @else
                                <div class="category-img">
                                    <img src="{{ asset('themes/grocery/assets/images/donuts.png') }}">
                                </div>
                            @endif
                            <div class="category-card-body">
                                <div class="title-wrapper">
                                    <div class="new-labl bg-second">
                                        {{ ucfirst($product->tag_api) }}
                                    </div>
                                    <h2>{{ $product->name }}</h2>
                                </div>
                                <p>
                                    {{ $product->description }}
                                </p>
                                <div class="btn-wrapper">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}" class="btn">
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
                                        {{ __('Show Products') }} <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                            height="6" viewBox="0 0 4 6" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill="white"></path>
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </section>
        <section class="testimonials padding-bottom padding-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-4 col-12">
                        <div class="testimonials-left-inner">
                            @php
                                $homepage_best_product_text = $homepage_best_product_sub = $homepage_best_product_btn = '';
                                $homepage_best_product_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="section-title">
                                    <h2 class="title">{!! $homepage_best_product_text !!}</h2>
                                </div>
                                <p>{!! $homepage_best_product_sub !!} </p>
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
                                    {!! $homepage_best_product_btn !!} <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                        height="6" viewBox="0 0 4 6" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 col-12">
                        <div class="review-slider">
                            @foreach ($reviews as $review)
                                <div class="testimonials-card">
                                    <div class="testimonials-inner">
                                        <div class="top-card">
                                            <div class="reviews-stars-wrap d-flex align-items-center">
                                                <div class="reviews-stars-outer">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i
                                                            class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                    @endfor
                                                </div>
                                                <div class="point-wrap">
                                                    <span class="review-point">{{ $review->rating_no }}.0 /
                                                        <span>5.0</span></span>
                                                </div>
                                            </div>
                                            <div class="reviews-words">
                                                <h3 class="main-word name">{{ $review->title }}</h3>
                                                <p class="descriptions">{{ $review->description }}</p>
                                            </div>
                                        </div>
                                        <div class="reviewer-profile">
                                            <div class="reviewer-img">
                                                <img src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}"
                                                    alt="reviewer-img">

                                            </div>
                                            <div class="reviewer-desc">
                                                <span><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</b>
                                                    {{-- {{ __('Client') }}</span> --}}
                                                    <p><a href="{{ route('page.product', [$slug, $p_id]) }}"
                                                            tabindex="0">{{ $review->ProductData->name }}</a></p>
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
        <section class="home-blog-section padding-bottom">
            <div class="container">
                @php
                    $homepage_best_product_text = $homepage_best_product_title = $homepage_best_product_sub = '';
                    $homepage_best_product_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_best_product_key != '') {
                        $homepage_best_product = $theme_json[$homepage_best_product_key];

                        foreach ($homepage_best_product['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $homepage_best_product_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_best_product_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_best_product_sub = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="section-title">

                    @if ($homepage_best_product['section_enable'] == 'on')
                        {{-- <div class="tagline">{!! $homepage_best_product_text !!}</div> --}}
                        <h2 class="title">{!! $homepage_best_product_title !!}</h2>
                        <div class="descripion">
                            <p>{!! $homepage_best_product_sub !!} </p>
                        </div>
                    @endif
                </div>
                <div class="blog-slider-home">
                    {!! \App\Models\Blog::HomePageBlog($slug, 4) !!}
                </div>
            </div>
        </section>

    </div>
@endsection
