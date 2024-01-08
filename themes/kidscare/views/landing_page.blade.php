@extends('layouts.layouts')
@section('page-title')
    {{ __('Kidscare') }}
@endsection
@php
    $theme_json = $homepage_json;
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $wishlist = \App\Models\Wishlist::where('id', 'product_id')->get();
    $product_review = \App\Models\Review::where('id', 'product_id')->get();

    // dd($wishlist);

@endphp
@section('content')


    <!--wrapper start here-->
    @php
        $homepage_best_product_heading = $homepage_best_product_title = $homepage_Play_Icon_Image = $homepage_header_lable = $homepage_header_video_link = $homepage_header_ellipse_ring = '';
        $homepage_best_product_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_product_key != '') {
            $homepage_best_product = $theme_json[$homepage_best_product_key];
            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-header-title') {
                    $homepage_best_product_heading = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-header-sub-title') {
                    $homepage_best_product_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-header-video-title') {
                    $homepage_Play_Icon_Image = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-header-lable') {
                    $homepage_header_lable = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-header-video-link') {
                    $homepage_header_video_link = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-header-ellipse-ring') {
                    $homepage_header_ellipse_ring = $value['field_default_text'];
                }
            }
        }
    @endphp
    <section class="main-hiro-section">
        <div class="container">
            <div class="main-hiro-container">
                @if ($homepage_best_product['section_enable'] == 'on')
                    <div class="big-title-center">
                        {!! $homepage_best_product_heading !!}
                        <p>{!! $homepage_best_product_title !!}</p>
                    </div>
                    <a href="#" class="explor-link vertical-ex">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="10" viewBox="0 0 21 10"
                                fill="none">
                                <path d="M20 1.99967L13.6667 8.33301L7.33333 1.99968L1 8.33301" stroke="black"
                                    stroke-width="1.72727" />
                            </svg>
                        </span>
                        {!! $homepage_header_lable !!}
                    </a>
                @endif

                <div class="hiro-row">
                    <div class="hiro-column-left">
                        <div class="hiro-column-left-inner">
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <a href="#" class="explor-link horizontal-ex">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="10"
                                            viewBox="0 0 21 10" fill="none">
                                            <path d="M20 1.99967L13.6667 8.33301L7.33333 1.99968L1 8.33301" stroke="black"
                                                stroke-width="1.72727" />
                                        </svg>
                                    </span>
                                    {!! $homepage_header_lable !!}
                                </a>
                            @endif
                            <div class="hiro-image-slider">
                                {{-- @dd($products); --}}
                                @foreach ($all_products as $product)
                                    @php
                                        $p_id = hashidsencode($product->id);
                                    @endphp
                                    <div class="hiro-image-item">
                                        <div class="hiro-image-item-inner">
                                            <a href="{{ route('page.product', [$slug,$p_id]) }}" class="shoe-img">
                                                <img src=" {{ get_file($product->cover_image_path, APP_THEME()) }}">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <img class="ellipse-ring" src="{{ get_file($homepage_header_ellipse_ring, APP_THEME()) }}">
                        </div>
                        <div class="hiro-tab-bottom-inner d-flex">
                            <div class="video-play-colum">
                                <span class="playbutton-sec">
                                    @if ($homepage_best_product['section_enable'] == 'on')
                                        <span class="poster-button">
                                            <svg viewBox="0 0 10 21" fill="none">
                                                <path d="M8.00033 20L1.66699 13.6667L8.00033 7.33333L1.66699 1"
                                                    stroke="white" stroke-width="1.72727">
                                                </path>
                                            </svg>
                                        </span>
                                        <span> {!! $homepage_Play_Icon_Image !!}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="hiro-slider-thumb-column">
                                <div class="hiro-thumb-slider no-transform">
                                    @foreach ($all_products as $key => $product)
                                        <div class="hiro-thumb-itm">
                                            <div class="hiro-thumb-itm-inner">
                                                <div class="thumb-cntnt">
                                                    <p>
                                                        <span class="mnumber">{{ ++$key }}</span>
                                                        <span class="desk-only-text description"><b
                                                                class="description">{{ $product->name }}</b>
                                                            {{ $product->description }}
                                                        </span>
                                                    </p>
                                                    <svg viewBox="0 0 10 5">
                                                        <path
                                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hiro-column-right">
                        <div class="hiro-column-right-inner common-block commonblock-white">
                            <div class="hiro-side-slider">
                                {{-- @dd($products) --}}
                                @foreach ($all_products as $product)
                                    @php
                                        $p_id = hashidsencode($product->id);
                                    @endphp
                                    {{-- @dd($product->Sub_image($product->id)['data']) --}}
                                    {{-- @dd($product) --}}
                                    <div class="hiro-side-item">
                                        <div class="hiro-side-item-inner">
                                            <svg class="top-left-pulse" xmlns="http://www.w3.org/2000/svg" width="13"
                                                height="6" viewBox="0 0 13 6" fill="none">
                                                <path d="M1 4.66667L4.66667 1L8.33333 4.66667L12 1" stroke="white" />
                                            </svg>
                                            @auth
                                                <div class="wishlist">
                                                    <a href="javascript:void(0)" class="wsh-btn wishbtn-globaly "
                                                        product_id="{{ $product->id }}"
                                                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                        <span class="wish-ic">
                                                            <i
                                                                class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endauth

                                            <h3><a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                    class="name">{{ $product->name }}</a></h3>
                                            <div class="subtitle">
                                                {{ !empty($product->SubCategoryctData) ? $product->SubCategoryctData->name : '' }}
                                            </div>
                                            <p class="description">{{ $product->description }}</p>
                                            <div class="thumb-pro-list imgs">
                                                @if ($product->Sub_image($product->id)['status'] == true)
                                                    @foreach ($product->Sub_image($product->id)['data'] as $key => $value)
                                                        <div class="thumb-pro-li">
                                                            <div class="thumb-pro-inner">
                                                                <img src="{{ get_file($value->image_path, APP_THEME()) }}"
                                                                    class="hover-img">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                                        height="18" viewBox="0 0 19 18" fill="none">
                                                                        <circle r="8.61532"
                                                                            transform="matrix(-1 0 0 1 9.51847 9.18661)"
                                                                            fill="white" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M12.024 9.04785C12.024 8.79857 11.8219 8.59649 11.5726 8.59649L10.109 8.59649L10.109 7.13287C10.109 6.88359 9.90691 6.6815 9.65763 6.6815C9.40835 6.6815 9.20626 6.88359 9.20626 7.13287L9.20626 8.59649L7.74265 8.59649C7.49336 8.59649 7.29128 8.79857 7.29128 9.04785C7.29128 9.29713 7.49336 9.49922 7.74265 9.49922H9.20626L9.20626 10.9628C9.20626 11.2121 9.40835 11.4142 9.65763 11.4142C9.90691 11.4142 10.109 11.2121 10.109 10.9628L10.109 9.49922L11.5726 9.49922C11.8219 9.49922 12.024 9.29713 12.024 9.04785Z"
                                                                            fill="#F3734D" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>


                                            <div class="d-flex price-wrap-flex align-items-end justify-content-between">
                                                <div class="price">
                                                    <div class="price-lbl">{{ __('Price:') }}</div>
                                                    <ins>{{ $product->final_price }}<sub>{{ $currency }}</sub></ins>
                                                </div>
                                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                                    product_id="{{ $product->id }}"
                                                    variant_id="{{ $product->default_variant_id }}" qty="1">
                                                    <span>{{ __('ADD TO CART') }}</span>
                                                    <span class="atc-ic">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="9"
                                                            height="8" viewBox="0 0 9 8" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                                fill="white" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shoe-two-column-layput">
        <div class="offset-container offset-left">
            <div class="row no-gutters">
                <div class="col-md-4 col-12 d-flex align-items-center">
                    @if (!empty($landing_product))
                    <div class="two-coll-content">
                        <div class="common-block">
                            @php
                                $homepage_featured_one_button = '';
                                $homepage_best_product_key = array_search('homepage-featured-one', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-featured-one-button') {
                                            $homepage_featured_one_button = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                                @php
                                    $p_id = hashidsencode($landing_product->id);
                                @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="lable-btn btn">{!! $homepage_featured_one_button !!}</div>
                            @endif
                            <div class="thmb-pro-main">
                                <div class="thumb-pro-main-itm">
                                    <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                        <img src="{{ get_file($landing_product->cover_image_path, APP_THEME()) }}">
                                    </a>
                                </div>
                                @if ($landing_product->Sub_image($landing_product->id)['status'] == true)
                                    @foreach ($landing_product->Sub_image($landing_product->id)['data'] as $key => $value)
                                        <div class="thumb-pro-main-itm">
                                            <img src=" {{ get_file($value->image_path, APP_THEME()) }}"
                                                class="hover-img">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="section-title">
                                {{-- @dd($landing_product) --}}
                                <h2><a href="{{ route('page.product', [$slug,$p_id]) }}" class="name">{{ $landing_product->name }}
                                    </a>
                                </h2>
                                {{-- <div class="subtitle"> {{ $landing_product->SubCategoryctData->name }}</div> --}}
                            </div>
                            <p class="description">{{ $landing_product->description }}</p>
                            <div class="thumb-pro-list no-transform">
                                @if ($landing_product->Sub_image($landing_product->id)['status'] == true)
                                    @foreach ($landing_product->Sub_image($landing_product->id)['data'] as $key => $value)
                                        <div class="thumb-pro-li">
                                            <div class="thumb-pro-inner">
                                                <img src="{{ get_file($value->image_path, APP_THEME()) }}"
                                                    class="hover-img">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                        viewBox="0 0 19 18" fill="none">
                                                        <circle r="8.61532"
                                                            transform="matrix(-1 0 0 1 9.51847 9.18661)" fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12.024 9.04785C12.024 8.79857 11.8219 8.59649 11.5726 8.59649L10.109 8.59649L10.109 7.13287C10.109 6.88359 9.90691 6.6815 9.65763 6.6815C9.40835 6.6815 9.20626 6.88359 9.20626 7.13287L9.20626 8.59649L7.74265 8.59649C7.49336 8.59649 7.29128 8.79857 7.29128 9.04785C7.29128 9.29713 7.49336 9.49922 7.74265 9.49922H9.20626L9.20626 10.9628C9.20626 11.2121 9.40835 11.4142 9.65763 11.4142C9.90691 11.4142 10.109 11.2121 10.109 10.9628L10.109 9.49922L11.5726 9.49922C11.8219 9.49922 12.024 9.29713 12.024 9.04785Z"
                                                            fill="#F3734D" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex price-wrap-flex align-items-end justify-content-between">
                                <div class="price">
                                    <ins>{{ $landing_product->final_price }}<sub>{{ $currency }}</sub></ins>
                                </div>
                                <a href="javascript:void(0)" class="add-cart-btn  addcart-btn-globaly"
                                    product_id="{{ $landing_product->id }}" variant_id="{{ $landing_product->default_variant_id }}"
                                    qty="1">
                                    <span>{{ __('ADD TO CART') }}</span>
                                    <span class="atc-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                            viewBox="0 0 9 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-8 col-12 d-flex">
                    @php
                        $homepage_banner_image = '';
                        $homepage_best_product_key = array_search('homepage-feature-banner-one', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];
                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-banner-one-image') {
                                    $homepage_banner_image = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <div class="two-coll-media">
                            <img src=" {{ get_file($homepage_banner_image, APP_THEME()) }}">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="all-the-shoes">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/leftt.png') }}" class="left-shape">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_title = $homepage_heading = $homepage_button = '';
                    $homepage_all_product_key = array_search('homepage-all-product', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_all_product_key != '') {
                        $homepage_all_product = $theme_json[$homepage_all_product_key];

                        foreach ($homepage_all_product['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-all-product-title') {
                                $homepage_title = $value['field_default_text'];
                                // dd($homepage_title);
                            }
                            if ($value['field_slug'] == 'homepage-all-product-sub-title') {
                                $homepage_heading = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-all-product-button') {
                                $homepage_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_all_product['section_enable'] == 'on')
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_title !!}</div>
                        {!! $homepage_heading !!}
                    </div>
                    <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary">
                        <span class="btn-txt">{!! $homepage_button !!}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <div class="all-shoes-slider">
                @foreach ($all_products as $product)
                    @php
                        $p_id = hashidsencode($product->id);
                    @endphp
                    <div class="all-shoes-slide-itm card">
                        <div class="all-shoes-itm-inner card-inner d-flex ">
                            <div class="all-shoes-itm-content">
                                <h4><a href="{{ route('page.product', [$slug,$p_id]) }}" class="name">{{ $product->name }} <p
                                            class="description">
                                            {{ $product->description }}</p></a></h4>



                                {{-- <div class="size-select d-flex align-items-center">
                                    <label>SIZE:</label>
                                    <select>
                                        <option>24.5”</option>
                                        <option>24.5”</option>
                                        <option>24.5”</option>
                                        <option>24.5”</option>
                                    </select>
                                </div>  --}}



                                <div class="price">
                                    <ins>{{ $product->final_price }}<sub>{{ $currency }}</sub></ins>
                                </div>
                                <div class="d-flex price-wrap-flex align-items-center">
                                    <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                        product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                        qty="1" tabindex="0">
                                        <span>{{ __('ADD TO CART') }}</span>
                                        <span class="atc-ic">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                                viewBox="0 0 9 8" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                    fill="white"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    @auth
                                        <a href="javascript:void(0)" class="wishlink wishbtn-globaly" tabindex="0"
                                            product_id="{{ $product->id }}"
                                            in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                        </a>
                                    @endauth

                                </div>
                            </div>
                            <div class="all-shoes-itm-img">
                                <div class="review-img">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i
                                            class="fa fa-star {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                    @endfor
                                </div>
                                <a href="{{ route('page.product', [$slug,$p_id]) }}" class="all-shoe-img">
                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}">

                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach


            </div>
        </div>
    </section>




    <section class="bestseller-section padding-top padding-bottom">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/rightt.png') }}" class="right-shape">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_bestsellers_heading = $homepage_bestsellers_button = '';
                    $homepage_bestsellers_key = array_search('homepage-bestsellers', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_bestsellers_key != '') {
                        $homepage_bestsellers = $theme_json[$homepage_bestsellers_key];

                        foreach ($homepage_bestsellers['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestsellers-title') {
                                $homepage_bestsellers_heading = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-bestsellers-button') {
                                $homepage_bestsellers_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_bestsellers['section_enable'] == 'on')
                    <div class="section-title-left">
                        <h2 class="xl-text">{!! $homepage_bestsellers_heading !!}</h2>

                    </div>
                    <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary white-btn">
                        <span class="btn-txt">{!! $homepage_bestsellers_button !!}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <ul class="bstslr-tb tabs">
                @foreach ($MainCategory as $cat_key => $category)
                    <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}"
                        data-tab="{{ $cat_key }}"><a href="javascript:;">{{ $category }}</a></li>
                @endforeach
            </ul>
            @foreach ($MainCategory as $cat_k => $category)
                <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                    <div class="bestsell-slider common-arrow  dark-bg">
                        @foreach ($bestSeller as $data)
                            @if ($cat_k == '0' || $data->ProductData()->id == $cat_k)
                                @php
                                    $p_id = hashidsencode($data->id);
                                @endphp
                                <div class="bestsell-itm">
                                    <div class="bestsell-itm-inner">
                                        <div class="bestsell-img">
                                            <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                                <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}">
                                            </a>
                                        </div>
                                        <div class="bestsell-content">
                                            <div class="bestsell-content-row">
                                                <div class="bestsell-content-left">

                                                    <h3><a
                                                            href="{{ route('page.product', [$slug,$p_id]) }}">{{ $data->name }}</a>
                                                    </h3>
                                                    <h5><a
                                                            href="{{ route('page.product', [$slug,$p_id]) }}">{{ $data->ProductData()->name }}</a>
                                                    </h5>
                                                    <p class="description">{{ $data->description }}</p>
                                                    <div class="price">
                                                        <ins>{{ $data->final_price }}<sub>{{ $currency }}</sub></ins>
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                                    product_id="{{ $data->id }}"
                                                    variant_id="{{ $data->default_variant_id }}" qty="1">
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
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </section>




    <section class="shoe-two-column-layput twocol-dark">
        <div class="offset-container offset-right">
            <div class="row no-gutters row-reverse">
                <div class="col-md-4 col-12 d-flex align-items-center">
                    @if (!empty($landing_product))
                    <div class="two-coll-content">
                        <div class="common-block commonblock-white">
                            @php
                                $homepage_featured_two_button = '';
                                $homepage_best_product_key = array_search('homepage-featured-two', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-featured-two-button') {
                                            $homepage_featured_two_button = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @php
                                $p_id = hashidsencode($landing_product->id);
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="lable-btn btn">{!! $homepage_featured_two_button !!}</div>
                            @endif
                            <div class="thmb-pro-main">
                                <div class="thumb-pro-main-itm">
                                    <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                        <img src=" {{ get_file($landing_product->cover_image_path, APP_THEME()) }}"></a>
                                </div>
                            </div>
                            <div class="section-title">
                                <h2><a href="{{ route('page.product', [$slug,$p_id]) }}" class="name"
                                        style="">{{ $landing_product->name }}</a></h2>
                            </div>
                            <p class="description">{{ $landing_product->description }}</p>
                            <div class="thumb-pro-list no-transform">
                                @if ($landing_product->Sub_image($landing_product->id)['status'] == true)
                                    @foreach ($landing_product->Sub_image($landing_product->id)['data'] as $key => $value)
                                        <div class="thumb-pro-li">
                                            <div class="thumb-pro-inner">
                                                <img src=" {{ get_file($value->image_path, APP_THEME()) }}"
                                                    class="hover-img">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                        viewBox="0 0 19 18" fill="none">
                                                        <circle r="8.61532"
                                                            transform="matrix(-1 0 0 1 9.51847 9.18661)" fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12.024 9.04785C12.024 8.79857 11.8219 8.59649 11.5726 8.59649L10.109 8.59649L10.109 7.13287C10.109 6.88359 9.90691 6.6815 9.65763 6.6815C9.40835 6.6815 9.20626 6.88359 9.20626 7.13287L9.20626 8.59649L7.74265 8.59649C7.49336 8.59649 7.29128 8.79857 7.29128 9.04785C7.29128 9.29713 7.49336 9.49922 7.74265 9.49922H9.20626L9.20626 10.9628C9.20626 11.2121 9.40835 11.4142 9.65763 11.4142C9.90691 11.4142 10.109 11.2121 10.109 10.9628L10.109 9.49922L11.5726 9.49922C11.8219 9.49922 12.024 9.29713 12.024 9.04785Z"
                                                            fill="#F3734D" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="d-flex price-wrap-flex align-items-end justify-content-between">
                                <div class="price">
                                    <ins>{{ $landing_product->final_price }}<sub>{{ $currency }}</sub></ins>
                                </div>
                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                    product_id="{{ $landing_product->id }}" variant_id="{{ $landing_product->default_variant_id }}"
                                    qty="1">
                                    <span>{{ __('ADD TO CART') }}</span>
                                    <span class="atc-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                            viewBox="0 0 9 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-8 col-12 d-flex">
                    @php
                        $homepage_banner_image = '';
                        $homepage_best_product_key = array_search('homepage-feature-banner-two', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-banner-two-image') {
                                    $homepage_banner_image = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <div class="two-coll-media">
                            <img src=" {{ get_file($homepage_banner_image, APP_THEME()) }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="meet-category-section">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_categories_title = $homepage_categories_heading = '';
                    $homepage_categories_key = array_search('homepage-categories', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_categories_key != '') {
                        $homepage_categories = $theme_json[$homepage_categories_key];
                        foreach ($homepage_categories['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-categories-title') {
                                $homepage_categories_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-categories-sub-title') {
                                $homepage_categories_heading = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_categories['section_enable'] == 'on')
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_categories_title !!}</div>
                        {!! $homepage_categories_heading !!}
                    </div>
                    <a href="{{ route('page.product-list') }}" class="btn-secondary">
                        <span class="btn-txt">{{ __('SHOW MORE') }}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <div class="row">
                {!! \App\Models\MainCategory::HomePageCategory(3) !!}
            </div>

        </div>
    </section> --}}
    @php
        $homepage_shoes_testing_title = $homepage_shoes_testing_heading = $homepage_shoes_testing_sub_text = $homepage_shoes_testing_button = $homepage_shoes_testing_banner_image = $homepage_shoes_testing_play_title = $homepage_shoes_testing_play_video = $homepage_shoes_testing_play_button = '';
        $homepage_shoes_testing_key = array_search('homepage-shoes-testing', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_shoes_testing_key != '') {
            $homepage_shoes_testing = $theme_json[$homepage_shoes_testing_key];
            foreach ($homepage_shoes_testing['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-shoes-testing-title') {
                    $homepage_shoes_testing_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-sub-title') {
                    $homepage_shoes_testing_heading = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-description') {
                    $homepage_shoes_testing_sub_text = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-button') {
                    $homepage_shoes_testing_button = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-banner-image') {
                    $homepage_shoes_testing_banner_image = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-play-video') {
                    $homepage_shoes_testing_play_video = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-play-title') {
                    $homepage_shoes_testing_play_title = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-shoes-testing-play-button') {
                    $homepage_shoes_testing_play_button = $value['field_default_text'];
                }
            }
        }
    @endphp
    {{-- <section class="shoes-during-testing padding-top">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/tes-shpe.png') }}" class="left-shape">
        @if ($homepage_shoes_testing['section_enable'] == 'on')
            <div class="offset-container offset-left">
                <div class="d-flex offset-row">
                    <div class="offset-left-colum">
                        <div class="offset-left-colum-inner">
                            <div class="section-title">
                                <div class="subtitle">{!! $homepage_shoes_testing_title !!}</div>
                                {!! $homepage_shoes_testing_heading !!}
                            </div>
                            {!! $homepage_shoes_testing_sub_text !!}
                            <a href="#" class="btn-secondary white-btn">
                                <span>{!! $homepage_shoes_testing_button !!}</span>
                                <span class="btn-ic">
                                    <svg viewBox="0 0 10 5">
                                        <path
                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="offset-right-colum">
                        <div class="video-right-wrap">
                            <video class="video--tag" id="img-vid"
                                poster={{ get_file($homepage_shoes_testing_banner_image, APP_THEME()) }}>
                                <source src="{{ get_file($homepage_shoes_testing_play_video, APP_THEME()) }}"
                                    type="video/mp4">
                            </video>
                            <div class="play-vid" data-click="0">
                                <div class="d-flex align-items-center">
                                    <span>
                                        <svg viewBox="0 0 30 30">
                                            <path
                                                d="M15,2.5A12.5,12.5,0,1,0,27.5,15,12.51408,12.51408,0,0,0,15,2.5Zm4.96777,14.13965v.001L14.32129,20.582a2.0003,2.0003,0,0,1-3.14453-1.64062V11.05859A2.0003,2.0003,0,0,1,14.32129,9.418l5.64648,3.94141a2,2,0,0,1,0,3.28027Z"
                                                fill="none"></path>
                                            <path
                                                d="M15,0A15,15,0,1,0,30,15,15.01641,15.01641,0,0,0,15,0Zm0,27.5A12.5,12.5,0,1,1,27.5,15,12.51408,12.51408,0,0,1,15,27.5Z">
                                            </path>
                                            <path
                                                d="M19.96777,13.35938,14.32129,9.418a2.0003,2.0003,0,0,0-3.14453,1.64062v7.88282A1.99947,1.99947,0,0,0,14.32129,20.582l5.64648-3.94141v-.001a2,2,0,0,0,0-3.28027Z">
                                            </path>
                                        </svg>
                                    </span> {!! $homepage_shoes_testing_play_title !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section> --}}
    <section class="all-showes-second-grid padding-bottom padding-top">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/all-lefft-shape.png') }}" class="all-shes-left">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/all-right-shape.png') }}" class="all-shes-right">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_sneakers_title = $homepage_sneakers_heading = $homepage_sneakers_button = '';
                    $homepage_sneakers_key = array_search('homepage-sneakers', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_sneakers_key != '') {
                        $homepage_sneakers = $theme_json[$homepage_sneakers_key];
                        foreach ($homepage_sneakers['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-sneakers-title') {
                                $homepage_sneakers_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-sneakers-sub-title') {
                                $homepage_sneakers_heading = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-sneakers-button') {
                                $homepage_sneakers_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_sneakers['section_enable'] == 'on')
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_sneakers_title !!}</div>
                        {!! $homepage_sneakers_heading !!}
                    </div>
                    <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary">
                        <span class="btn-txt">{!! $homepage_sneakers_button !!}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <div class="all-shes-second-slider common-arrow">
                @foreach ($all_products as $product)
                    @php
                        $p_id = hashidsencode($product->id);
                    @endphp
                    <div class="all-shes-second-itm">
                        <div class="all-shes-second-itm-inner">
                            <div class="all-shes-second-img">
                                <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="all-shes-second-content ">
                                <h4><a href="{{ route('page.product', [$slug,$p_id]) }}" class="name">{{ $product->name }}
                                    </a>
                                </h4>
                                <p class="description">{{ $product->description }}</p>

                                <div class="price">

                                    <ins>{{ $product->final_price }}<sub>{{ $currency }}</sub></ins>
                                    <del>{{ $product->original_price }}</del>
                                </div>
                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                    product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                    qty="1" tabindex="0">
                                    <span>{{ __('ADD TO CART') }}</span>
                                    <span class="atc-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                            viewBox="0 0 9 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                fill="white"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    {{-- <section class="shoe-two-column-layput two-col-bottom">
        <div class="offset-container offset-left">
            <div class="row no-gutters">
                <div class="col-md-5 col-12 d-flex align-items-center">
                    <div class="two-coll-content">
                        <div class="common-block">
                            @php
                                $homepage_featured_three_button = '';
                                $homepage_best_product_key = array_search('homepage-featured-three', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];
                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-featured-three-button') {
                                            $homepage_featured_three_button = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_best_product['section_enable'] == 'on')
                                <div class="lable-btn btn">{!! $homepage_featured_three_button !!}</div>
                            @endif
                            <div class="thmb-pro-main">
                                <div class="thumb-pro-main-itm">
                                    <img src=" {{ get_file($product->cover_image_path, APP_THEME()) }}">
                                </div>
                                @if ($product->Sub_image($product->id)['status'] == true)
                                    @foreach ($product->Sub_image($product->id)['data'] as $key => $value)
                                        <div class="thumb-pro-main-itm">
                                            <img src=" {{ get_file($value->image_path, APP_THEME()) }}"
                                                class="hover-img">
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                            <div class="section-title">
                                <h2><a href="#" class="name">{{ $product->name }}</a></h2>
                            </div>
                            <p class="description">{{ $product->description }}</p>
                            <div class="thumb-pro-list no-transform">
                                @if ($product->Sub_image($product->id)['status'] == true)
                                    @foreach ($product->Sub_image($product->id)['data'] as $key => $value)
                                        <div class="thumb-pro-li">
                                            <div class="thumb-pro-inner">
                                                <img src="{{ get_file($value->image_path, APP_THEME()) }}"
                                                    class="hover-img">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                        viewBox="0 0 19 18" fill="none">
                                                        <circle r="8.61532"
                                                            transform="matrix(-1 0 0 1 9.51847 9.18661)" fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12.024 9.04785C12.024 8.79857 11.8219 8.59649 11.5726 8.59649L10.109 8.59649L10.109 7.13287C10.109 6.88359 9.90691 6.6815 9.65763 6.6815C9.40835 6.6815 9.20626 6.88359 9.20626 7.13287L9.20626 8.59649L7.74265 8.59649C7.49336 8.59649 7.29128 8.79857 7.29128 9.04785C7.29128 9.29713 7.49336 9.49922 7.74265 9.49922H9.20626L9.20626 10.9628C9.20626 11.2121 9.40835 11.4142 9.65763 11.4142C9.90691 11.4142 10.109 11.2121 10.109 10.9628L10.109 9.49922L11.5726 9.49922C11.8219 9.49922 12.024 9.29713 12.024 9.04785Z"
                                                            fill="#F3734D" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="d-flex price-wrap-flex align-items-end justify-content-between">
                                <div class="price">
                                    <ins>{{ $product->final_price }}<sub>{{ $currency }}</sub></ins>
                                </div>
                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                    product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                    qty="1">
                                    <span>{{ __('ADD TO CART') }}</span>
                                    <span class="atc-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                            viewBox="0 0 9 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-12 d-flex">
                    <div class="two-coll-media">
                        @php
                            $homepage_banner_image = '';

                            $homepage_best_product_key = array_search('homepage-feature-banner-three', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_best_product_key != '') {
                                $homepage_best_product = $theme_json[$homepage_best_product_key];
                                foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-feature-banner-three-image') {
                                        $homepage_banner_image = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_best_product['section_enable'] == 'on')
                            <div class="two-coll-media">
                                <img src=" {{ get_file($homepage_banner_image, APP_THEME()) }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </section> --}}
    <section class="testimonial-section padding-bottom padding-top">
        @php
            $homepage_about_shoes_title = $homepage_about_shoes_heading = '';
            $homepage_about_shoes_key = array_search('homepage-about-shoes', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_about_shoes_key != '') {
                $homepage_about_shoes = $theme_json[$homepage_about_shoes_key];
                foreach ($homepage_about_shoes['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-about-shoes-title') {
                        $homepage_about_shoes_title = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-about-shoes-sub-title') {
                        $homepage_about_shoes_heading = $value['field_default_text'];
                    }
                }
            }
        @endphp
        <div class="container">
            @if ($homepage_about_shoes['section_enable'] == 'on')
                <div class="section-title text-center">
                    <div class="subtitle">{!! $homepage_about_shoes_title !!} </div>
                    {!! $homepage_about_shoes_heading !!}
                </div>
            @endif

            <div class="testimonial-slider common-arrow  dark-bg">
                {{-- @dd($review->UserData()) --}}
                @foreach ($reviews as $review)
                    <div class="testimonial-itm">

                        <div class="testimonial-itm-inner">
                            <div class="test-head">
                                <img
                                    src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}">
                                <h3><span>{{ $review->title }}</span></h3>
                            </div>
                            <div class="testicontent">
                                <p class="rew-description">{{ $review->description }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="testi-auto d-flex align-items-center">
                                    <div class="testi-img">
                                        <img src=" {{ asset('themes/' . APP_THEME() . '/assets/images/john.png') }}">
                                    </div>
                                    <div class="test-auth-detail">
                                        <h6>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</h6>
                                        <span>{{ __('developer') }}</span>
                                    </div>
                                </div>
                                <div class="starimg">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- <section class="all-showes-bottom-grid padding-bottom padding-top">
        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/all-right-shape.png') }}" class="all-shes-right">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_the_sneakers_title = $homepage_the_sneakers_heading = $homepage_the_sneakers_button = '';
                    $homepage_the_sneakers_key = array_search('homepage-modern-sneakers', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_the_sneakers_key != '') {
                        $homepage_the_sneakers = $theme_json[$homepage_the_sneakers_key];
                        foreach ($homepage_the_sneakers['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-modern-sneakers-title') {
                                $homepage_the_sneakers_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-modern-sneakers-sub-title') {
                                $homepage_the_sneakers_heading = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-modern-sneakers-button') {
                                $homepage_the_sneakers_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_the_sneakers['section_enable'] == 'on')
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_the_sneakers_title !!}</div>
                        {!! $homepage_the_sneakers_heading !!}
                    </div>
                    <a href="{{ route('page.product-list') }}" class="btn-secondary">
                        <span class="btn-txt"> {!! $homepage_the_sneakers_button !!} </span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <div class="product-card-slider common-arrow">
                @foreach ($modern_products as $modern)
                    @php
                        $p_id = hashidsencode($modern->id);
                    @endphp
                    <div class="product-card-itm product-card">
                        <div class="product-card-inner">
                            <div class="product-card-img">
                                <a href="{{ route('page.product', $p_id) }}" class="pro-img">
                                    <img src="{{ get_file($modern->cover_image_path), APP_THEME() }}">
                                </a>

                                @auth
                                    <div class="favorite-icon">
                                        <a href="javascript:void(0)" class=" wishlist wishbtn-globaly"
                                            product_id="{{ $modern->id }}"
                                            in_wishlist="{{ $modern->in_whishlist ? 'remove' : 'add' }}">
                                            <i class="{{ $modern->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                style='color: white'></i>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                            <div class="product-card-content">
                                <h4><a href="{{ route('page.product', $p_id) }}" tabindex="0"
                                        class="name">{{ $modern->name }} </a></h4>
                                <p class="description">{{ $modern->description }}</p>
                                <div class="price">
                                    <ins>{{ $modern->final_price }}<sub>{{ $currency }}</sub></ins>
                                    <del>{{ $modern->original_price }}</del>
                                </div>
                                <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                    product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                    qty="1" tabindex="0">
                                    <span>{{ __('ADD TO CART') }}</span>
                                    <span class="atc-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8"
                                            viewBox="0 0 9 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                                fill="white"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}
    <section class="our-blog-section padding-top">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_blog_title = $homepage_blog_heading = $homepage_blog_button = '';
                    $homepage_blog_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_blog_key != '') {
                        $homepage_blog = $theme_json[$homepage_blog_key];
                        foreach ($homepage_blog['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-title') {
                                $homepage_blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-title') {
                                $homepage_blog_heading = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-button') {
                                $homepage_blog_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_blog['section_enable'] == 'on')
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_blog_title !!}</div>
                        {!! $homepage_blog_heading !!}
                    </div>
                    <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary white-btn">
                        <span class="btn-txt">{!! $homepage_blog_button !!}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
            <div class="our-blogs-slider common-arrow  dark-bg">
                {!! \App\Models\Blog::HomePageBlog($slug , $no=4) !!}
            </div>
        </div>
    </section>
    <section class="our-client-section padding-bottom padding-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 col-12">
                    <div class="our-client-left">
                        @php
                            $homepage_best_product_heading = $homepage_partners_heading = '';
                            $homepage_best_product_key = array_search('homepage-partners', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_best_product_key != '') {
                                $homepage_best_product = $theme_json[$homepage_best_product_key];

                                foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-partners-title') {
                                        $homepage_best_product_heading = $value['field_default_text'];
                                    }

                                    if ($value['field_slug'] == 'homepage-partners-sub-title') {
                                        $homepage_partners_heading = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_best_product['section_enable'] == 'on')
                            <div class="section-title">
                                <div class="subtitle"> {!! $homepage_best_product_heading !!}</div>
                                {!! $homepage_partners_heading !!}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-9 col-12">
                    @php
                        $homepage_logo = '';
                        $homepage_logo_key = array_search('homepage-partners', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_logo_key != '') {
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                        }
                    @endphp
                    @if ($homepage_main_logo['section_enable'] == 'on')
                        <div class="our-client-right">
                            <div class="client-logo-slider common-arrows">
                                @if (!empty($homepage_main_logo['homepage-partners-logo']))
                                    @for ($i = 0; $i < count($homepage_main_logo['homepage-partners-logo']); $i++)
                                        @php
                                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                                if ($homepage_main_logo_value['field_slug'] == 'hhomepage-partners-logo') {
                                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                }
                                                if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                    if ($homepage_main_logo_value['field_slug'] == 'homepage-partners-logo') {
                                                        $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                    }
                                                }
                                            }
                                        @endphp



                                        <div class="client-logo-item">
                                            <a href="#">
                                                <img src=" {{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                            </a>
                                        </div>
                                    @endfor
                                @else
                                    @for ($i = 0; $i <= 6; $i++)
                                        @php
                                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-partners-logo') {
                                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                }
                                            }
                                        @endphp
                                        <div class="client-logo-item">
                                            <a href="#">
                                                <img src=" {{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                            </a>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </section>

    <!---wrapper end here-->
    <!--footer start here-->

    <!--scripts start here-->

    <!--scripts end here-->
    </body>

    </html>
@endsection
