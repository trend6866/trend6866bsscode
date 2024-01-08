@extends('layouts.layouts')

@section('page-title')
    {{ __('Books') }}
@endsection
@section('content')
    @php
        $theme_json = $homepage_json;
        $homepage_banner_title = $homepage_banner_sub_text = $homepage_banner_img = $homepage_banner_heading1 = $homepage_banner_icon_img1 = $homepage_banner_heading2 = $homepage_banner_icon_img2 = $homepage_banner_promotion_title1 = $homepage_banner_promotion_icon1 = $homepage_banner_promotion_title2 = $homepage_banner_promotion_icon2 = '';
    @endphp
    <div class="wrapper">
        <section class="main-home-first-section padding-bottom">
            <div class="offset-container offset-left">
                <div class="hero-main-row d-flex w-100 ">
                    @php
                        $homepage_main_title = '';

                        $homepage_main = array_search('main-home-first-section', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_main != '') {
                            $homepage_main_value = $theme_json[$homepage_main];

                            foreach ($homepage_main_value['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'main-home-first-section-label') {
                                    $homepage_main_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'main-home-first-section-image') {
                                    $homepage_main_img = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'main-home-first-section-button-1') {
                                    $homepage_main_btn1 = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'main-home-first-section-button-2') {
                                    $homepage_main_btn2 = $value['field_default_text'];
                                }

                                //Dynamic
                                if (!empty($homepage_main_value[$value['field_slug']])) {
                                    if ($value['field_slug'] == 'main-home-first-section-label') {
                                        $homepage_main_title = $homepage_main_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'main-home-first-section-image') {
                                        $homepage_main_img = $homepage_main_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'main-home-first-section-button-1') {
                                        $homepage_main_btn1 = $homepage_main_value[$value['field_slug']][$i];
                                    }
                                    if ($value['field_slug'] == 'main-home-first-section-button-2') {
                                        $homepage_main_btn2 = $value['field_default_text'];
                                    }
                                }
                            }
                        }
                    @endphp
                    <div class="home-left-col">
                        <div class="home-left-inner">
                            <div class="section-title">
                                <h2 class="h1">
                                    {!! $homepage_main_title !!}
                                </h2>
                            </div>

                            <div class="home-search-bar-out">
                                <form class="home-search-bar">
                                    <form>

                                        <div class="form-row row">
                                            <div class="col-md-5 col-12">
                                                <div class="input-wrapper">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                        viewBox="0 0 15 14" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.2122 11.3214C9.14028 12.1539 7.79329 12.6497 6.33041 12.6497C2.83422 12.6497 0 9.81797 0 6.32485C0 2.83173 2.83422 0 6.33041 0C9.82659 0 12.6608 2.83173 12.6608 6.32485C12.6608 7.78645 12.1646 9.13226 11.3313 10.2033L13.78 12.6496C14.089 12.9583 14.089 13.4589 13.78 13.7677C13.4709 14.0764 12.9699 14.0764 12.6609 13.7677L10.2122 11.3214ZM11.0782 6.32485C11.0782 8.94469 8.95255 11.0685 6.33041 11.0685C3.70827 11.0685 1.5826 8.94469 1.5826 6.32485C1.5826 3.70501 3.70827 1.58121 6.33041 1.58121C8.95255 1.58121 11.0782 3.70501 11.0782 6.32485Z"
                                                            fill="black"></path>
                                                    </svg>
                                                    <input type="email" placeholder="Search audiobook..."
                                                        class="form-control ">

                                                </div>
                                            </div>
                                            <div class="col-md-7 col-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="nice-select form-control" tabindex="0">
                                                        <span class="current">{{ __('Category') }}</span>
                                                        <ul class="list">
                                                            {{-- @foreach ($MainCategoryList as $category)
                                                                <li class="option"><a
                                                                        href="{{ route('page.product-list', ['main_category' => $category->id]) }}">{{ $category->name }}</a>
                                                                </li>
                                                            @endforeach --}}
                                                            @foreach ($MainCategoryList as $category)
                                                                <li class="option">
                                                                    <a
                                                                        href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    </div>
                                                    <button class="btn-subscibe " type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="14" viewBox="0 0 15 14" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M10.2122 11.3214C9.14028 12.1539 7.79329 12.6497 6.33041 12.6497C2.83422 12.6497 0 9.81797 0 6.32485C0 2.83173 2.83422 0 6.33041 0C9.82659 0 12.6608 2.83173 12.6608 6.32485C12.6608 7.78645 12.1646 9.13226 11.3313 10.2033L13.78 12.6496C14.089 12.9583 14.089 13.4589 13.78 13.7677C13.4709 14.0764 12.9699 14.0764 12.6609 13.7677L10.2122 11.3214ZM11.0782 6.32485C11.0782 8.94469 8.95255 11.0685 6.33041 11.0685C3.70827 11.0685 1.5826 8.94469 1.5826 6.32485C1.5826 3.70501 3.70827 1.58121 6.33041 1.58121C8.95255 1.58121 11.0782 3.70501 11.0782 6.32485Z"
                                                                fill="black"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div class="hero-left-slider">
                                <div class="hero-slider-title">
                                    <h5>{{ __('Featured') }} <br /> {{ __('Audobiooks') }}:</h5>
                                </div>
                                <div class="home-slider flex-slider">
                                    @foreach ($products->take(5) as $product)
                                        @php
                                           $p_id = hashidsencode($product->id);
                                        @endphp
                                        <div class="hero-slider-itm card">
                                            <div class="hero-slider-itm-inner card-inner">
                                                <div class="home-slider-itm-image">
                                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}"
                                                        alt="">
                                                </div>
                                                <div class="hero-slider-itm-content">
                                                    <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                                        <h6>{{ $product->name }}</h6>
                                                    </a>
                                                    <p>2022 / John N. Doe</p>
                                                    <a href="#" class="book-link">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="5"
                                                            height="5" viewBox="0 0 5 5" fill="none">
                                                            <path
                                                                d="M3.7972 2.06097C4.37865 2.39667 4.37865 3.23593 3.7972 3.57163L1.83479 4.70463C1.25334 5.04033 0.526521 4.6207 0.526521 3.9493L0.526521 1.68331C0.526521 1.0119 1.25334 0.592275 1.83479 0.927977L3.7972 2.06097Z"
                                                                fill="#E8BA96" />
                                                        </svg>
                                                        {{ __('Get Sample') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hero-left-btns">
                                <a href="{{ route('page.product-list',$slug) }}" class="btn" tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16"
                                        viewBox="0 0 13 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 2.90909C0 1.30244 1.2934 0 2.88889 0H8.91449C9.68067 0 10.4155 0.306493 10.9572 0.852053L12.1539 2.05704C12.6956 2.6026 13 3.34254 13 4.11408V13.0909C13 14.6976 11.7066 16 10.1111 16H2.88889C1.2934 16 0 14.6976 0 13.0909V2.90909ZM11.5556 5.09091V13.0909C11.5556 13.8942 10.9089 14.5455 10.1111 14.5455H2.88889C2.09114 14.5455 1.44444 13.8942 1.44444 13.0909V2.90909C1.44444 2.10577 2.09114 1.45455 2.88889 1.45455H7.94444V2.90909C7.94444 4.11408 8.91449 5.09091 10.1111 5.09091H11.5556ZM11.4754 3.63636C11.4045 3.43098 11.2881 3.24224 11.1325 3.08556L9.93587 1.88057C9.78028 1.72389 9.59285 1.60665 9.38889 1.53523V2.90909C9.38889 3.31075 9.71224 3.63636 10.1111 3.63636H11.4754Z"
                                            fill="#E8BA96"></path>
                                        <path
                                            d="M5.25003 7.1016L8.57902 8.83789C9.14033 9.13064 9.14033 9.86936 8.57902 10.1621L5.25003 11.8984C4.69303 12.1889 4 11.8218 4 11.2363L4 7.76372C4 7.17818 4.69303 6.8111 5.25003 7.1016Z"
                                            fill="#E8BA96"></path>
                                    </svg>
                                    {{ $homepage_main_btn1 }}
                                </a>
                                <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary" tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 14 14" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.97487 11.0098C8.98031 11.7822 7.73058 12.2422 6.37332 12.2422C3.12957 12.2422 0.5 9.61492 0.5 6.37402C0.5 3.13313 3.12957 0.505859 6.37332 0.505859C9.61706 0.505859 12.2466 3.13313 12.2466 6.37402C12.2466 7.73009 11.7863 8.97872 11.0131 9.97241L13.285 12.2421C13.5717 12.5285 13.5717 12.993 13.285 13.2794C12.9983 13.5659 12.5334 13.5659 12.2467 13.2794L9.97487 11.0098ZM10.7783 6.37402C10.7783 8.8047 8.80612 10.7751 6.37332 10.7751C3.94051 10.7751 1.96833 8.8047 1.96833 6.37402C1.96833 3.94335 3.94051 1.9729 6.37332 1.9729C8.80612 1.9729 10.7783 3.94335 10.7783 6.37402Z"
                                            fill="#494949"></path>
                                    </svg>
                                    {{ $homepage_main_btn2 }}
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- @dd($homepage_main_img) --}}
                    <div class="home-right-col">
                        <div class="home-right-inner">
                            <img src="{{ get_file($homepage_main_img, APP_THEME()) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="subscribe-section">
            @php
                $homepage_subscribe_title = '';

                $homepage_subscribe = array_search('subscribe-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_subscribe != '') {
                    $homepage_subscribe_value = $theme_json[$homepage_subscribe];

                    foreach ($homepage_subscribe_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'subscribe-section-title') {
                            $homepage_subscribe_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-sub-text') {
                            $homepage_subscribe_subtext = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-button') {
                            $homepage_subscribe_btn1 = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-subscribe-text') {
                            $homepage_subscribe_subscribe_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-image1') {
                            $homepage_subscribe_img1 = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-image2') {
                            $homepage_subscribe_img2 = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'subscribe-section-image3') {
                            $homepage_subscribe_img3 = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_subscribe_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'subscribe-section-title') {
                                $homepage_subscribe_title = $homepage_subscribe_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-sub-text') {
                                $homepage_subscribe_subtext = $homepage_subscribe_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-button') {
                                $homepage_subscribe_btn1 = $homepage_subscribe_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-subscribe-text') {
                                $homepage_subscribe_subscribe_text = $value['field_default_text'][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-image1') {
                                $homepage_subscribe_img1 = $value['field_default_text'][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-image2') {
                                $homepage_subscribe_img2 = $value['field_default_text'][$i];
                            }
                            if ($value['field_slug'] == 'subscribe-section-image3') {
                                $homepage_subscribe_img3 = $value['field_default_text'][$i];
                            }
                        }
                    }
                }
            @endphp

            <div class="container ">
                <div class="row align-items-center subscribe-bg">
                    <div class="col-lg-4 col-12">
                        <div class="section-title">
                            <h4>
                                {!! $homepage_subscribe_title !!}
                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="subscribe-detail">
                            <p>{{ $homepage_subscribe_subtext }}</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">

                        <div class="footer-subscribe-form">
                            <form action="{{ route('newsletter.store',$slug) }}" method="post" class="subscribe-form">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                    <button class="btn-subscibe">{{ $homepage_subscribe_btn1 }}</button>
                                </div>
                                <div class="checkbox-custom">
                                    {!! $homepage_subscribe_subscribe_text !!}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="online-store-section tabs-wrapper padding-top padding-bottom">
            @php
                $homepage_store_title = '';

                $homepage_store = array_search('online-store-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_store != '') {
                    $homepage_store_value = $theme_json[$homepage_store];

                    foreach ($homepage_store_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'online-store-section-title') {
                            $homepage_store_title = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_store_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'online-store-section-title') {
                                $homepage_store_title = $homepage_store_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp

            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center">

                    {!! $homepage_store_title !!}

                    <ul class="cat-tab tabs">
                        @foreach ($MainCategory->take(3) as $cat_key => $category)
                            <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}"
                                data-tab="{{ $cat_key }}_data"><a href="javascript:;">{{ $category }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}_data" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="product-card-reverse">
                                <div class="online-store-itm flex-slider">
                                    @foreach ($all_products as $products)
                                        @php
                                            $p_id = hashidsencode($products->id);
                                        @endphp
                                        @if ($cat_k == '0' || $products->ProductData()->id == $cat_k)
                                            <div class="product-card card">
                                                <div class="product-card-inner card-inner">
                                                    <div class="product-image">
                                                        <a href="{{ route('page.product',[$slug,$p_id]) }}" tabindex="0">
                                                            <img
                                                                src="{{ get_file($products->cover_image_path, APP_THEME()) }}">
                                                        </a>
                                                        <span class="badge">{{ $products->tag_api }}</span>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-cont-top">
                                                            <div class="subtitle">
                                                                <a href="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11"
                                                                        height="13" viewBox="0 0 11 13"
                                                                        fill="none">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M0 2.36364C0 1.05824 1.09442 0 2.44444 0H7.54303C8.19134 0 8.8131 0.249025 9.27152 0.692293L10.284 1.67134C10.7425 2.11461 11 2.71581 11 3.34269V10.6364C11 11.9418 9.90558 13 8.55556 13H2.44444C1.09441 13 0 11.9418 0 10.6364V2.36364ZM9.77778 4.13636V10.6364C9.77778 11.2891 9.23057 11.8182 8.55556 11.8182H2.44444C1.76943 11.8182 1.22222 11.2891 1.22222 10.6364V2.36364C1.22222 1.71094 1.76943 1.18182 2.44444 1.18182H6.72222V2.36364C6.72222 3.34269 7.54303 4.13636 8.55556 4.13636H9.77778ZM9.70998 2.95455C9.64997 2.78767 9.55145 2.63432 9.4198 2.50702L8.40728 1.52796C8.27562 1.40066 8.11702 1.3054 7.94444 1.24737V2.36364C7.94444 2.68999 8.21805 2.95455 8.55556 2.95455H9.70998Z"
                                                                            fill="#E8BA96" />
                                                                        <path
                                                                            d="M3.625 7C3.27982 7 3 7.22386 3 7.5C3 7.77614 3.27982 8 3.625 8H7.375C7.72018 8 8 7.77614 8 7.5C8 7.22386 7.72018 7 7.375 7H3.625Z"
                                                                            fill="#E8BA96" />
                                                                        <path
                                                                            d="M3.625 9C3.27982 9 3 9.22386 3 9.5C3 9.77614 3.27982 10 3.625 10H5.5C5.84518 10 6.125 9.77614 6.125 9.5C6.125 9.22386 5.84518 9 5.5 9H3.625Z"
                                                                            fill="#E8BA96" />
                                                                    </svg>
                                                                    {{ __('Get Sample') }}
                                                                </a>
                                                            </div>
                                                            <div class="prouct-card-heading long_sting_to_dot">
                                                                <h5>
                                                                    <a href="{{ route('page.product',[$slug,$p_id]) }}"
                                                                        tabindex="0">{{ $products->name }}</a>
                                                                </h5>
                                                                <div class="play-time">
                                                                    @auth
                                                                        <a href="javascript:void(0)"
                                                                            class="wishbtn wishlist-btn wishbtn-globaly"
                                                                            product_id="{{ $products->id }}"
                                                                            in_wishlist="{{ $products->in_whishlist ? 'remove' : 'add' }}">
                                                                            <span class="wish-ic">
                                                                                <i
                                                                                    class="{{ $products->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                                <input type="hidden" class="wishlist_type"
                                                                                    name="wishlist_type" id="wishlist_type"
                                                                                    value="{{ $products->in_whishlist ? 'remove' : 'add' }}">
                                                                            </span>
                                                                        </a>
                                                                    @endauth
                                                                </div>
                                                            </div>
                                                            <p>{{ $products->ProductData()->name }}</p>
                                                        </div>
                                                        <div class="product-cont-bottom">

                                                            <div class="size-selectors align-items-center">

                                                            </div>
                                                            <div class="price-btn">
                                                                <div class="price">
                                                                    <span
                                                                        class="currency-type">{{ $currency_icon }}</span>
                                                                    <ins> {{ $products->final_price }} </ins>
                                                                </div>
                                                                <a href="javascript:void(0)"
                                                                    class="btn checkout-btn addcart-btn-globaly"
                                                                    product_id="{{ $products->id }}"
                                                                    variant_id="{{ $products->default_variant_id }}"
                                                                    qty="1">
                                                                    <svg width="20" height="20"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                                        </path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ __('Add to cart') }}
                                                                </a>
                                                            </div>
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
        <section class="category-section padding-bottom">
            @php
                $homepage_category_title = '';

                $homepage_category = array_search('category-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_category != '') {
                    $homepage_category_value = $theme_json[$homepage_category];

                    foreach ($homepage_category_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'category-section-title') {
                            $homepage_category_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'category-section-sub-text') {
                            $homepage_category_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'category-section-image') {
                            $homepage_category_img = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_category_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'category-section-title') {
                                $homepage_category_title = $homepage_category_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'category-section-sub-text') {
                                $homepage_category_text = $homepage_category_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'category-section-image') {
                                $homepage_category_img = $homepage_category_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp

            <div class="container">
                <div class="section-title">
                    {!! $homepage_category_title !!}
                    <p>{{ $homepage_category_text }}
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="category-image-box">
                            <a href="{{ route('page.product-list',$slug) }}">
                                <img src="{{ get_file($homepage_category_img, APP_THEME()) }}">
                                @if (!empty($latest_product))
                                <div class="category-image-text">
                                    <h4> {{ $latest_product->name }}</h4>
                                    <div class="link-btn justify-content-start">
                                        {{ __('Show more') }}
                                        <svg width="6" height="5" viewBox="0 0 6 5" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="category-card-reverse">
                            <div class="category-itm product-card">
                                @foreach ($homeproducts as $product)
                                    <div class="category-card-inner">
                                        <div class="category-card-image">
                                            <a href="{{ route('page.product',[$slug,$p_id]) }}" tabindex="0">
                                                <img src="{{ get_file($product->cover_image_path) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="category-card-content">
                                            <div class="category-cont-top">
                                                <span class="badge">{{ $product->tag_api }}</span>
                                                <div class="prouct-card-heading long_sting_to_dot">
                                                    <h5>
                                                        <a href="{{ route('page.product',[$slug,$p_id]) }}"
                                                            tabindex="0">{{ $product->name }}</a>
                                                    </h5>
                                                    <p>{{ $product->ProductData()->name }}</p>
                                                </div>
                                            </div>
                                            <div class="category-cont-bottom">
                                                <div class="price-btn">
                                                    <div class="price">
                                                        <span class="currency-type">{{ $currency_icon }}</span>
                                                        <ins> {{ $product->final_price }} </ins>
                                                    </div>
                                                    <a href="javascript:void(0)" class="link-btn addcart-btn-globaly"
                                                        product_id="{{ $product->id }}"
                                                        variant_id="{{ $product->default_variant_id }}" qty="1">
                                                        <svg width="20" height="20" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                            </path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                            </path>
                                                        </svg>
                                                        {{ __('Add to cart') }}
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
        <section class="banner-contant-section padding-bottom">
            @php
                $homepage_contact_title = '';

                $homepage_contact = array_search('banner-contant-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_contact != '') {
                    $homepage_contact_value = $theme_json[$homepage_contact];

                    foreach ($homepage_contact_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'banner-contant-section-title') {
                            $homepage_contact_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'banner-contant-section-btn') {
                            $homepage_contact_text = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_contact_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'banner-contant-section-title') {
                                $homepage_contact_title = $homepage_contact_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'banner-contant-section-btn') {
                                $homepage_contact_text = $homepage_contact_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    {!! $homepage_contact_title !!}
                    <a href="{{ route('page.product-list',$slug) }}" class="btn" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 2.90909C0 1.30244 1.2934 0 2.88889 0H8.91449C9.68067 0 10.4155 0.306493 10.9572 0.852053L12.1539 2.05704C12.6956 2.6026 13 3.34254 13 4.11408V13.0909C13 14.6976 11.7066 16 10.1111 16H2.88889C1.2934 16 0 14.6976 0 13.0909V2.90909ZM11.5556 5.09091V13.0909C11.5556 13.8942 10.9089 14.5455 10.1111 14.5455H2.88889C2.09114 14.5455 1.44444 13.8942 1.44444 13.0909V2.90909C1.44444 2.10577 2.09114 1.45455 2.88889 1.45455H7.94444V2.90909C7.94444 4.11408 8.91449 5.09091 10.1111 5.09091H11.5556ZM11.4754 3.63636C11.4045 3.43098 11.2881 3.24224 11.1325 3.08556L9.93587 1.88057C9.78028 1.72389 9.59285 1.60665 9.38889 1.53523V2.90909C9.38889 3.31075 9.71224 3.63636 10.1111 3.63636H11.4754Z"
                                fill="#E8BA96"></path>
                            <path
                                d="M5.25003 7.1016L8.57902 8.83789C9.14033 9.13064 9.14033 9.86936 8.57902 10.1621L5.25003 11.8984C4.69303 12.1889 4 11.8218 4 11.2363L4 7.76372C4 7.17818 4.69303 6.8111 5.25003 7.1016Z"
                                fill="#E8BA96"></path>
                        </svg>
                        {{ $homepage_contact_text }}
                    </a>
                </div>
                {{-- @dd($latest_product) --}}
                @if(!empty($latest_product))
                <div class="banner-content-main">
                    <div class="banner-content-image">
                        <img src="{{ get_file($latest_product->cover_image_path, APP_THEME()) }}" alt="">
                    </div>
                    <div class="banner-content-card-inner">
                        <div class="banner-card-image">
                            <a href="{{ route('page.product',[$slug,$p_id]) }}" tabindex="0">
                                <img src="{{ get_file($latest_product->cover_image_path, APP_THEME()) }}" alt=""
                                    class="responsive-img">
                            </a>
                        </div>
                        <div class="banner-card-content">
                            <div class="banner-cont-top">
                                <span class="badge">{{ $latest_product->tag_api }}</span>
                                <div class="prouct-card-heading">
                                    <h4>
                                        <a href="{{ route('page.product',[$slug,$p_id]) }}"
                                            tabindex="0">{{ $latest_product->name }}</a>
                                    </h4>
                                    <p>{{ $latest_product->ProductData()->name }}</p>
                                </div>
                            </div>
                            <div class="banner-cont-bottom">
                                <div class="price-btn">
                                    <div class="price">
                                        <span class="currency-type">{{ $currency_icon }}</span>
                                        <ins> {{ $latest_product->final_price }} </ins>
                                    </div>
                                    <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly"
                                        product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                        qty="1">
                                        <svg width="20" height="20" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                            </path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                            </path>
                                        </svg>
                                        {{ __('Add to cart') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
        <section class="testimonials-section padding-bottom">
            @php
                $homepage_testimonials_title = '';

                $homepage_testimonials = array_search('testimonials-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_testimonials != '') {
                    $homepage_testimonials_value = $theme_json[$homepage_testimonials];

                    foreach ($homepage_testimonials_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'testimonials-section') {
                            $homepage_testimonials_title = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_testimonials_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'testimonials-section') {
                                $homepage_testimonials_title = $homepage_testimonials_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp

            <div class="container">
                <div class="section-title text-center">
                    {!! $homepage_testimonials_title !!}
                </div>
                <div class="testimonial-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonial-itm">
                            <div class="testimonial-itm-inner">
                                <div class="testimonial-itm-image">
                                    <a href="#" tabindex="0">
                                        <img src="{{ get_file($review->ProductData->cover_image_path, APP_THEME()) }}"
                                            class="default-img" alt="review">
                                    </a>
                                </div>
                                <div class="testimonial-itm-content">
                                    <span>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</span>
                                    <div class="testimonial-content-top">
                                        <h3 class="testimonial-title">
                                            {{ $review->title }}
                                        </h3>
                                    </div>
                                    <p>{{ $review->description }}</p>
                                    <div class="testimonial-star">
                                        <div class="d-flex align-items-center">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                            @endfor
                                            <span><b>{{ $review->rating_no }}.0/</b> 5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="newslatter-section padding-bottom">
            <div class="container">
                <div class="newslatter-bg">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-12">
                            <div class="newslatter-content">
                                <div class="section-title">
                                    <h2 class="dark">
                                        {!! $homepage_subscribe_title !!}
                                    </h2>
                                </div>
                                <p>{{ $homepage_subscribe_subtext }}
                                </p>
                                <form class="footer-subscribe-form" action="{{ route('newsletter.store',$slug) }}"
                                    method="post" class="subscribe-form">
                                    @csrf
                                    <div class="input-wrapper">
                                        <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                        <button type="submit" class="btn-subscibe">{{ $homepage_subscribe_btn1 }}
                                        </button>
                                    </div>
                                    <div class="">
                                        <div class="checkbox-custom">
                                            {!! $homepage_subscribe_subscribe_text !!}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12">
                            <div class="newslatter-images">
                                <img src="{{ get_file($homepage_subscribe_img1, APP_THEME()) }}" class="newslattwer-1"
                                    alt="">
                                <img src="{{ get_file($homepage_subscribe_img2, APP_THEME()) }}" class="newslattwer-2"
                                    alt="">
                                <img src="{{ get_file($homepage_subscribe_img3, APP_THEME()) }}" class="newslattwer-3"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog-section padding-bottom">
            @php
                $homepage_blogs_title = '';

                $homepage_blogs = array_search('blog-section', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_blogs != '') {
                    $homepage_blogs_value = $theme_json[$homepage_blogs];

                    foreach ($homepage_blogs_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'blog-section-title') {
                            $homepage_blogs_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'blog-section-button') {
                            $homepage_blogs_btn = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_blogs_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'blog-section-title') {
                                $homepage_blogs_title = $homepage_blogs_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'blog-section-button') {
                                $homepage_blogs_btn = $homepage_blogs_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    {!! $homepage_blogs_title !!}
                    <a href="{{ route('page.blog',$slug) }}" class="btn" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 2.90909C0 1.30244 1.2934 0 2.88889 0H8.91449C9.68067 0 10.4155 0.306493 10.9572 0.852053L12.1539 2.05704C12.6956 2.6026 13 3.34254 13 4.11408V13.0909C13 14.6976 11.7066 16 10.1111 16H2.88889C1.2934 16 0 14.6976 0 13.0909V2.90909ZM11.5556 5.09091V13.0909C11.5556 13.8942 10.9089 14.5455 10.1111 14.5455H2.88889C2.09114 14.5455 1.44444 13.8942 1.44444 13.0909V2.90909C1.44444 2.10577 2.09114 1.45455 2.88889 1.45455H7.94444V2.90909C7.94444 4.11408 8.91449 5.09091 10.1111 5.09091H11.5556ZM11.4754 3.63636C11.4045 3.43098 11.2881 3.24224 11.1325 3.08556L9.93587 1.88057C9.78028 1.72389 9.59285 1.60665 9.38889 1.53523V2.90909C9.38889 3.31075 9.71224 3.63636 10.1111 3.63636H11.4754Z"
                                fill="#E8BA96"></path>
                            <path
                                d="M5.25003 7.1016L8.57902 8.83789C9.14033 9.13064 9.14033 9.86936 8.57902 10.1621L5.25003 11.8984C4.69303 12.1889 4 11.8218 4 11.2363L4 7.76372C4 7.17818 4.69303 6.8111 5.25003 7.1016Z"
                                fill="#E8BA96"></path>
                        </svg>
                        {{ $homepage_blogs_btn }}
                    </a>
                </div>
                <div class="about-card-slider">
                    {!! \App\Models\Blog::HomePageBlog($slug ,$no = 10) !!}
                </div>
            </div>
        </section>
    </div>
@endsection

@push('page-script')
    <script>
        $(document).ready(function() {
            $(".search_product_globaly").on('click', function(e) {
                e.preventDefault();
                var product = $('.').val();
                var data = {
                    product: product,
                }

                $.ajax({
                    url: '{{ route('search.product',$slug) }}',
                    context: this,
                    data: data,
                    success: function(responce) {
                        window.location.href = responce;
                    }
                });
            });
        });
    </script>
@endpush
