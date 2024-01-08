
@extends('layouts.layouts')

@section('page-title')
{{ __('Glasses') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
<!--wrapper start here-->
    <section class="main-home-first-section">
            {!! \App\Models\Utility::HomePageProduct($slug ,$no = 2) !!}
    </section>

    <section class="our-client-section padding-top padding-bottom">
            @php
                $homepage_logo = '';
                $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                if($homepage_logo_key != ''){
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                }
            @endphp
        @if($homepage_main_logo['section_enable'] == 'on')
        <div class="container">
            <div class="client-logo-slider common-arrows">
                @if(!empty($homepage_main_logo['homepage-logo']))
                    @for ($i = 0; $i < count($homepage_main_logo['homepage-logo']); $i++)
                        @php
                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            {
                                if($homepage_main_logo_value['field_slug'] == 'homepage-logo'){
                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                }
                                if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logo'){
                                        $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            }
                        @endphp
                        <div class="client-logo-item">
                            <a href="#">
                                <img src="{{get_file($homepage_logo , APP_THEME())}}" alt="logo">
                            </a>
                        </div>
                    @endfor
                @else
                    @for ($i = 0; $i <= 6; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logo'){
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];

                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{$homepage_logo}}" alt="logo">
                                </a>
                            </div>
                    @endfor
                @endif
            </div>
        </div>
        @endif
    </section>

    {{-- latest product --}}
    <section class="best-product-section ">
        <div class="container">
            <div class="row">
                @php
                    $homepage_best_product_heading = $homepage_best_product_subtext = $homepage_best_product_btn = '';
                        $homepage_best_product_key = array_search('homepage-best-product', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_best_product_key != ''){
                            $homepage_best_product = $theme_json[$homepage_best_product_key];

                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-best-product-heading'){
                                    $homepage_best_product_heading = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-best-product-sub-text'){
                                    $homepage_best_product_subtext = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-best-product-button'){
                                    $homepage_best_product_btn = $value['field_default_text'];
                                }
                            }
                        }
                @endphp

                @if($homepage_best_product['section_enable'] == 'on')
                    <div class="col-md-6 col-12">
                        <div class="best-product-left-inner">
                            <div class="section-title">
                                {!! $homepage_best_product_heading !!}

                            </div>
                           <p> {!! $homepage_best_product_subtext !!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary ">
                                {!! $homepage_best_product_btn !!}
                                <svg viewBox="0 0 10 5">
                                    <path
                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

                <div class="col-md-6 col-12">
                    <div class="best-product-slider common-arrows">
                        @foreach ($products as $product)
                            @php
                                $p_id = hashidsencode($product->id);
                            @endphp
                            <div class="best-pro-item product-card">
                                <div class="product-card-inner">
                                    <div class="product-card-image">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                                            @if($product->Sub_image($product->id)['status'] == true)
                                                <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                            @else
                                                <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                                            @endif
                                        </a>
                                        <div class="new-labl">
                                            {{ __('new') }}
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top">
                                            <h3 class="product-title">
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{$product->name}}
                                                </a>
                                            </h3>
                                            <div class="product-type title">{{$product->ProductData()->name}} / {{$product->SubCategoryctData->name}}</div>
                                        </div>
                                        <div
                                            class="product-content-bottom d-flex align-items-center justify-content-between">
                                            <div class="price">
                                                <ins>{{ $product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                                <del>{{ $product->original_price }}</del>
                                            </div>
                                            <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                                {{ __('Add to cart') }}
                                                <svg viewBox="0 0 10 5">
                                                    <path
                                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                    </path>
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

    {{-- all product --}}
    <section class="product-center-mode-slider">
        <div class="product-center-slider common-arrows">
            @foreach ($all_products as $items)
                <div class="product-center-item product-card">
                    @php
                        $p_id = hashidsencode($items->id);
                    @endphp
                    <div class="product-card-inner">
                        <div class="product-card-image">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($items->cover_image_path , APP_THEME()) }}" class="default-img">
                                @if ($items->Sub_image($items->id)['status'] == true)
                                    <img src="{{ get_file($items->Sub_image($items->id)['data'][0]->image_path , APP_THEME()) }}"
                                        class="hover-img">
                                @else
                                    <img src="{{ get_file($items->Sub_image($items->id) , APP_THEME()) }}" class="hover-img">
                                @endif
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-content-top">
                                <h3 class="product-title">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        {{$items->name}}
                                    </a>
                                </h3>
                                <div class="product-type">{{ $items->ProductData()->name }} / {{ $items->SubCategoryctData->name }}</div>
                            </div>
                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{ $items->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                    <del>{{ $items->original_price }}</del>
                                </div>
                                <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $items->id }}" variant_id="{{ $items->default_variant_id }}" qty="1">
                                    {{ __('Add to cart') }}
                                    <svg viewBox="0 0 10 5">
                                        <path
                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="positive-about-us" style="background-image: url({{asset('themes/'.APP_THEME().'/assets/images/positive-banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    @php
                        $homepage_about_heading = $homepage_about_subtext = $homepage_about_btn = '';

                        $homepage_about_key = array_search('homepage-about', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_about_key != '') {
                            $homepage_about = $theme_json[$homepage_about_key];

                        foreach ($homepage_about['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-about-label') {
                            $homepage_about_label = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-about-heading') {
                            $homepage_about_heading = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-about-sub-text') {
                            $homepage_about_subtext = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-about-button') {
                            $homepage_about_btn = $value['field_default_text'];
                            }
                        }
                        }
                    @endphp

                    @if($homepage_about['section_enable'] == 'on')
                        <div class="column-positive-us-left">
                            <div class="vetical-text-2">
                                {!! $homepage_about_label !!}
                            </div>
                            <div class="section-title">
                                {!! $homepage_about_heading !!}
                            </div>
                            <p>{!! $homepage_about_subtext !!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                                {!! $homepage_about_btn !!}
                                <svg viewBox="0 0 10 5">
                                    <path
                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 col-12">
                    @php
                        $homepage_rating_box_count = $homepage_rating_box_heading = '';

                        $homepage_rating_key = array_search('homepage-rating-box', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_rating_key != '') {
                            $homepage_rating_box = $theme_json[$homepage_rating_key];

                        }

                    @endphp

                    @if($homepage_rating_box['section_enable'] == 'on')
                        <div class="column-positive-us-right">
                            <div class="award-logo">
                                <img src="{{asset('themes/'.APP_THEME().'/assets/images/award-logo.png')}}">
                            </div>
                            <div class="row">
                                @for($i=0 ; $i < $homepage_rating_box['loop_number'];$i++)
                                    @php
                                        foreach ($homepage_rating_box['inner-list'] as $homepage_rating_box_value)
                                        {
                                            if($homepage_rating_box_value['field_slug'] == 'homepage-rating-box-count') {
                                            $homepage_rating_box_count = $homepage_rating_box_value['field_default_text'];
                                            }
                                            if($homepage_rating_box_value['field_slug'] == 'homepage-rating-box-heading') {
                                            $homepage_rating_box_heading = $homepage_rating_box_value['field_default_text'];
                                            }

                                            if(!empty($homepage_rating_box[$homepage_rating_box_value['field_slug']]))  {
                                            if($homepage_rating_box_value['field_slug'] == 'homepage-rating-box-count'){
                                                $homepage_rating_box_count = $homepage_rating_box[$homepage_rating_box_value['field_slug']][$i];
                                            }
                                            if($homepage_rating_box_value['field_slug'] == 'homepage-rating-box-heading'){
                                                $homepage_rating_box_heading = $homepage_rating_box[$homepage_rating_box_value['field_slug']][$i];
                                            }

                                        }
                                        }
                                    @endphp

                                    <div class="col-sm-4 col-4">
                                        <div class="rating-box">
                                            <svg viewBox="0 0 18 22">
                                                <path
                                                    d="M3.20339 10.373C3.75256 11.8571 4.92268 13.0273 6.40678 13.5764C4.92268 14.1256 3.75256 15.2957 3.20339 16.7798C2.65422 15.2957 1.4841 14.1256 0 13.5764C1.4841 13.0273 2.65422 11.8571 3.20339 10.373Z"
                                                    fill="white"></path>
                                                <path
                                                    d="M12.0507 0C13.0706 2.75619 15.2437 4.92927 17.9999 5.94915C15.2437 6.96903 13.0706 9.14212 12.0507 11.8983C11.0308 9.14212 8.85775 6.96903 6.10156 5.94915C8.85775 4.92927 11.0308 2.75619 12.0507 0Z"
                                                    fill="white"></path>
                                                <path
                                                    d="M7.85205 17.5422C8.99627 16.9472 9.9301 16.0134 10.5251 14.8691C11.1201 16.0134 12.0539 16.9472 13.1981 17.5422C12.0539 18.1371 11.1201 19.071 10.5251 20.2152C9.93009 19.071 8.99627 18.1371 7.85205 17.5422Z"
                                                    stroke="white" stroke-width="0.677966"></path>
                                            </svg>
                                            {!! $homepage_rating_box_count !!}
                                            {!! $homepage_rating_box_heading !!}
                                        </div>
                                    </div>
                                @endfor

                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="modern-category-section padding-bottom padding-top">
        @php
            $homepage_category_heading = $homepage_category_btn = '';

            $homepage_modern_category_key = array_search('homepage-modern-category', array_column($theme_json, 'unique_section_slug'));
            if($homepage_modern_category_key != '') {
                $homepage_category = $theme_json[$homepage_modern_category_key];

            foreach ($homepage_category['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-modern-category-heading') {
                $homepage_category_heading = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-modern-category-button') {
                $homepage_category_btn = $value['field_default_text'];
                }
            }
            }
        @endphp

        <div class="container">
            @if($homepage_category['section_enable'] == 'on')
                <div class="section-title d-flex align-items-center justify-content-between">
                    {!! $homepage_category_heading !!}
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary">
                        {!! $homepage_category_btn !!}
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </a>
                </div>
            @endif
            <div class="row no-gutters">
                {!! \App\Models\MainCategory::HomePageCategory($slug, $no=5) !!}
            </div>
        </div>
    </section>

    <section class="our-bestseller-section padding-bottom">
        <div class="container">
            @php
                $homepage_best_seller_heading = $homepage_best_seller_btn =  '';

                $homepage_best_seller_key = array_search('homepage-bestsellers', array_column($theme_json, 'unique_section_slug'));
                if($homepage_best_seller_key != '') {
                    $homepage_best_seller = $theme_json[$homepage_best_seller_key];
                foreach ($homepage_best_seller['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-bestsellers-heading') {
                    $homepage_best_seller_heading = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-bestsellers-button') {
                    $homepage_best_seller_btn = $value['field_default_text'];
                    }

                }
                }
            @endphp

            @if($homepage_best_seller['section_enable'] == 'on')
                <div class="section-title d-flex align-items-center justify-content-between">
                    {!! $homepage_best_seller_heading !!}
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary">
                        {!! $homepage_best_seller_btn !!}
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </a>
                </div>
            @endif

            <div class="bestsell-cat-slider common-arrows">
                @foreach ($bestSeller as $data)
                    <div class="best-sell-cat-item product-card">
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="product-card-inner">
                            <div class="product-card-image">
                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                    <img src="{{ get_file($data->cover_image_path , APP_THEME()) }}" class="default-img">
                                    @if ($data->Sub_image($data->id)['status'] == true)
                                        <img src="{{ get_file($data->Sub_image($data->id)['data'][0]->image_path , APP_THEME()) }}"
                                            class="hover-img">
                                    @else
                                        <img src="{{ get_file($data->Sub_image($data->id) , APP_THEME()) }}" class="hover-img">
                                    @endif
                                </a>
                                <div class="new-labl">
                                    {{ $data->tag_api }}
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <h3 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            {{ $data->name }}
                                        </a>
                                    </h3>
                                    <div class="product-type title">{{ $data->ProductData()->name }} / {{ $data->SubCategoryctData->name }}</div>
                                </div>
                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                    <div class="price">
                                        <ins>{{ $data->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                        <del>{{ $data->original_price }}</del>
                                    </div>
                                    <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $data->id }}" variant_id="{{ $data->default_variant_id }}" qty="1">
                                        {{ __('Add to cart') }}
                                        <svg viewBox="0 0 10 5">
                                            <path
                                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
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

    <section class="home-conent-section padding-bottom">
        <div class="container">
            @php
                $homepage_content_heading =  '';

                $homepage_content_key1 = array_search('homepage-content-1', array_column($theme_json, 'unique_section_slug'));
                if($homepage_content_key1 != '') {
                    $homepage_content = $theme_json[$homepage_content_key1];
                foreach ($homepage_content['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-content-heading') {
                    $homepage_content_heading = $value['field_default_text'];
                    }
                }
                }

            @endphp

             @if($homepage_content['section_enable'] == 'on')
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2>
                    <span>
                        {!! $homepage_content_heading !!}
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.24674 1.24691C0.774855 1.7188 0.774855 2.48387 1.24674 2.95575L17.9813 19.6903L7.2279 19.6905C6.56056 19.6905 6.01958 20.2315 6.01959 20.8988C6.0196 21.5662 6.5606 22.1072 7.22794 22.1072L20.8984 22.1069C21.5658 22.1069 22.1067 21.5659 22.1067 20.8986L22.107 7.22812C22.107 6.56077 21.566 6.01977 20.8987 6.01976C20.2313 6.01975 19.6903 6.56073 19.6903 7.22808L19.6901 17.9815L2.95558 1.24691C2.4837 0.775029 1.71862 0.775029 1.24674 1.24691Z" fill="#183A40"/>
                            </svg>
                    </span>
                    </h2>
                    <div class="right-fix-img">
                        <svg viewBox="0 0 70 63">
                            <path d="M67.0377 35.0732C68.7705 39.6934 68.8408 44.1803 66.9593 48.6333C64.5586 54.3149 60.1073 57.6639 54.3378 59.3912C41.6472 63.1906 26.8527 56.5692 21.1773 44.5916C21.0278 44.2761 20.9167 43.9424 20.7952 43.6364C20.8713 43.5631 20.9027 43.5088 20.9458 43.4962C25.7755 42.0758 28.1159 38.4733 29.2519 33.8958C30.0133 30.8306 29.9595 27.6197 29.0959 24.5816C28.8308 23.6061 28.4328 22.6716 27.913 21.8043C26.7766 19.9468 24.9292 19.4532 23.0784 20.6203C22.0195 21.3045 21.0904 22.171 20.3344 23.1795C18.5274 25.5735 17.6313 28.3639 17.2473 31.3228C16.8514 34.3746 17.1102 37.3832 17.8466 40.3608C17.9433 40.751 18.0156 41.1475 18.092 41.5423C18.0993 41.5806 18.0553 41.6288 17.9772 41.7976C16.0591 41.5794 14.3626 40.7808 12.8538 39.5628C10.6141 37.7549 9.16717 35.3857 8.32197 32.6811C6.91488 28.1779 6.05369 23.5524 5.49256 18.8712C5.47734 18.7472 5.5466 18.6134 5.64632 18.1819C6.14869 18.9557 6.52166 19.5292 6.89463 20.1024C7.06026 20.3571 7.21097 20.6233 7.39578 20.8628C7.7208 21.285 8.11265 21.6676 8.66693 21.2791C9.24541 20.8741 8.94643 20.3745 8.66404 19.9474C7.71501 18.5115 6.79157 17.0553 5.77008 15.6714C4.8952 14.4852 4.24775 14.5249 3.46009 15.788C2.41547 17.4623 1.43813 19.1794 0.459724 20.8934C0.22068 21.2805 0.0647964 21.713 0.00196075 22.1634C-0.0233078 22.4408 0.199867 22.9059 0.425323 22.9938C0.644081 23.0789 1.1256 22.8721 1.28574 22.6469C1.63436 22.1592 1.83028 21.5659 2.1279 21.0377C2.61382 20.1751 3.13096 19.33 3.75375 18.2768C4.2243 21.1531 4.60808 23.7469 5.08381 26.3236C5.43273 28.2128 5.84848 30.0894 6.33106 31.9534C6.94241 34.4207 8.07961 36.727 9.66497 38.7149C11.7844 41.3405 14.4562 43.0514 17.8541 43.4773C18.5834 43.5686 18.9958 43.8728 19.321 44.5509C23.7123 53.6959 30.9116 59.3494 40.8163 61.4642C46.7111 62.723 52.5328 62.3189 58.0672 59.7805C64.4352 56.8606 68.4634 52.0027 69.711 45.0357C70.4176 41.0891 69.7926 37.2662 68.2288 33.6014C67.8788 32.8203 67.74 31.9611 67.8263 31.1097C68.1003 28.2821 67.6107 25.5393 66.5489 22.9326C61.8507 11.401 53.5263 3.85398 41.5053 0.482661C40.1154 0.0928783 38.6092 0.0458851 37.1515 0.000717158C36.5481 -0.0178367 35.8989 0.327082 35.3399 0.63322C35.1523 0.736027 35.0735 1.25934 35.1488 1.53475C35.1931 1.69596 35.6903 1.89579 35.8977 1.82553C38.5617 0.921717 41.0296 1.8491 43.4318 2.73604C53.4432 6.43235 60.7117 13.0812 64.8419 22.9942C65.8467 25.4062 66.2283 27.5382 66.1173 29.4514C65.6669 28.8615 65.3499 28.441 65.0273 28.0247C61.0512 22.8945 55.9031 19.6199 49.5228 18.3565C47.2167 17.9003 44.8612 17.8154 42.5962 18.5223C41.2625 18.9385 39.913 19.5069 38.7708 20.296C34.9931 22.9057 33.8635 27.232 35.7019 31.4338C36.5041 33.306 37.7379 34.9622 39.3027 36.2675C44.8135 40.8331 51.1434 42.5294 58.1823 41.2989C61.7796 40.6701 64.7022 38.8617 66.5704 35.5959C66.7102 35.4081 66.8666 35.2332 67.0377 35.0732ZM54.005 40.0835C49.4871 39.9162 45.0339 38.6308 41.1604 35.6485C39.364 34.2646 37.9516 32.5593 37.1023 30.4387C35.7966 27.1787 36.7158 23.9212 39.5179 21.7853C41.2252 20.484 43.1867 19.881 45.3016 19.7427C51.8433 19.3152 61.1294 23.5346 65.6078 31.9709C65.8115 32.3543 65.8168 32.9575 65.683 33.3862C64.9505 35.734 63.3634 37.382 61.2137 38.506C59.0574 39.6335 56.7274 40.0342 54.005 40.0835ZM20.0645 41.8282C18.858 38.5015 18.4665 34.9346 18.9227 31.4259C19.2334 28.987 19.9677 26.6624 21.3664 24.6297C22.0255 23.6777 22.8378 22.8412 23.7703 22.1541C24.8764 21.3445 25.9156 21.638 26.5763 22.8286C27.0137 23.6261 27.3472 24.4763 27.5687 25.3583C28.283 28.1698 28.2704 31.1164 27.5321 33.9217C26.9827 36.0617 26.0034 37.992 24.4455 39.5943C23.2844 40.7883 21.9179 41.5982 20.0645 41.8282Z" fill="#ffffff"></path>
                        </svg>
                    </div>
                </div>

            <div class="row">
                @php
                    $homepage_content2_btn = $homepage_content2_heading = $homepage_content2_bg_img = '';

                    $homepage_content_key2 = array_search('homepage-content-2', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_content_key2 != '') {
                        $homepage_content2 = $theme_json[$homepage_content_key2];
                    }
                @endphp

                @for($i=0 ;$i < $homepage_content2['loop_number'] ;$i++)
                @php
                    foreach ($homepage_content2['inner-list'] as $homepage_content2_value)
                    {
                        if($homepage_content2_value['field_slug'] == 'homepage-content-button') {
                        $homepage_content2_btn = $homepage_content2_value['field_default_text'];
                        }
                        if($homepage_content2_value['field_slug'] == 'homepage-content-heading') {
                        $homepage_content2_heading = $homepage_content2_value['field_default_text'];
                        }
                        if($homepage_content2_value['field_slug'] == 'homepage-content-bg-image') {
                        $homepage_content2_bg_img = $homepage_content2_value['field_default_text'];
                        }

                        if(!empty($homepage_content2[$homepage_content2_value['field_slug']])){
                            if($homepage_content2_value['field_slug'] == 'homepage-content-button'){
                                $homepage_content2_btn = $homepage_content2[$homepage_content2_value['field_slug']][$i];
                            }
                            if($homepage_content2_value['field_slug'] == 'homepage-content-heading'){
                                $homepage_content2_heading = $homepage_content2[$homepage_content2_value['field_slug']][$i];
                            }
                            if($homepage_content2_value['field_slug'] == 'homepage-content-bg-image'){
                                $homepage_content2_bg_img = $homepage_content2[$homepage_content2_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                    }
                @endphp

                    <div class="col-12 content-img-box {{$i== 0 ? 'col-md-4' :  'col-md-8'}}">
                        <div class="content-img-box-inner">
                            <div class="content-img-box-body">
                                <img src="{{get_file($homepage_content2_bg_img , APP_THEME())}}">
                                <div class="content-box-title">
                                    <div class="content-box-title-inner">
                                        <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                                            {!! $homepage_content2_btn !!}
                                            <svg viewBox="0 0 10 5">
                                                <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                </path>
                                            </svg>
                                        </a>
                                        {!! $homepage_content2_heading !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               @endfor
                @php
                    $homepage_content3_heading = $homepage_content3_btn = $homepage_content3_subtext = $homepage_content3_subtext_btn = '';

                    $homepage_content_key3 = array_search('homepage-content-3', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_content_key3 != '') {
                        $homepage_content3 = $theme_json[$homepage_content_key3];

                    foreach ($homepage_content3['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-content-heading') {
                        $homepage_content3_heading = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-content-button') {
                        $homepage_content3_btn = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-content-sub-text') {
                        $homepage_content3_subtext = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-content-button2') {
                        $homepage_content3_subtext_btn = $value['field_default_text'];
                        }

                    }
                    }
                @endphp

                <div class="col-md-4 col-12 content-img-box">
                    <div class="content-img-box-inner">
                        <div class="content-img-box-body">
                            <div class="content-box-title">
                                <svg viewBox="0 0 166 160" class="wavy-img">
                                    <path d="M158.065 89.6131C156.8 88.1803 155.803 87.0326 154.785 85.9041C154.154 85.2048 153.488 84.5378 152.847 83.8488C152.229 83.1852 151.683 82.4612 152.568 81.6526C153.314 80.9718 154.064 81.3743 154.598 81.9701C157.281 84.9638 159.944 87.9774 162.565 91.0265C163.23 91.8005 163.023 92.6429 162.235 93.2748C161.702 93.7013 161.127 94.0779 160.557 94.4567C158.065 96.1132 155.571 97.7665 153.075 99.4165C152.933 99.5107 152.814 99.6408 152.67 99.732C152.038 100.135 151.262 100.363 150.895 99.6014C150.667 99.1277 150.755 98.1585 151.102 97.817C152.129 96.8041 153.337 95.9689 154.507 95.1084C155.447 94.4175 156.434 93.7912 157.301 92.9016C153.169 92.5433 149.403 93.5127 146.277 96.2419C144.484 97.8065 142.914 99.6561 141.404 101.508C138.7 104.825 136.258 108.363 133.44 111.576C131.127 114.204 128.601 116.635 125.888 118.846C124.344 120.107 122.358 120.969 120.436 121.599C115.855 123.1 111.933 121.476 109.513 117.299C107.932 114.568 107.335 111.555 107.213 108.441C107.031 103.777 107.769 99.23 109.061 94.7597C109.215 94.2272 109.287 93.671 109.513 92.5475C108.519 93.5419 107.879 94.0843 107.354 94.7229C102.943 100.07 98.5434 105.427 94.156 110.794C91.5507 113.97 89.074 117.266 86.2952 120.281C84.339 122.403 82.0524 124.252 79.7571 126.02C78.0553 127.347 75.9991 128.142 73.8469 128.304C69.7247 128.613 66.7066 126.67 65.3404 122.769C64.136 119.329 64.4409 115.832 65.1259 112.369C66.1984 106.949 68.4385 101.951 70.939 97.0616C71.587 95.7946 72.2333 94.5268 72.5312 92.9059C71.7603 93.3537 70.9255 93.7195 70.2287 94.2623C65.5048 97.9416 60.7446 101.579 56.1279 105.389C52.6973 108.221 49.5051 111.341 46.1293 114.242C44.4443 115.694 42.6591 117.027 40.7869 118.229C39.5636 119.009 38.2218 119.585 36.8138 119.936C33.9112 120.645 31.6092 119.434 30.8567 116.539C30.3625 114.468 30.1952 112.332 30.3608 110.209C30.682 105.104 32.4863 100.358 34.4701 95.7062C36.1139 91.8512 38.0014 88.1005 39.6456 84.2458C40.5178 82.296 41.1836 80.2603 41.6319 78.1719C42.198 75.2618 40.8408 74.0929 37.9692 74.9322C36.3331 75.4282 34.765 76.1258 33.3011 77.0088C30.8017 78.4913 28.429 80.1893 25.9744 81.7529C24.6056 82.6245 23.2424 83.5487 21.7668 84.1999C18.3946 85.6882 15.655 84.5061 14.3728 81.0313C13.8933 79.7494 13.5985 78.4058 13.4971 77.0409C12.962 69.3915 14.6347 61.7493 18.3163 55.0228C18.9969 53.8381 19.8004 52.7284 20.7135 51.712C21.2363 51.0993 22.0418 50.8335 22.759 51.494C23.5435 52.2166 23.006 52.8182 22.5321 53.4852C17.3927 60.7186 15.5907 68.853 16.4646 77.5584C16.9464 82.3528 18.6347 83.0512 22.6817 80.5148C25.6542 78.652 28.4705 76.5275 31.5101 74.7883C33.5672 73.5754 35.7838 72.6563 38.0957 72.0577C42.2452 71.0575 45.0485 73.6301 44.5015 77.8842C44.1816 80.083 43.5746 82.2303 42.696 84.2712C40.9277 88.5363 38.774 92.6447 37.079 96.9361C35.6545 100.599 34.4526 104.344 33.48 108.152C32.9945 110.014 32.9565 112.073 33.1283 114.007C33.4162 117.248 34.9417 118.054 37.8313 116.627C39.2913 115.911 40.6633 115.028 41.9199 113.995C45.0157 111.428 47.9676 108.688 51.0507 106.105C56.1664 101.819 61.3086 97.564 66.5084 93.3816C67.9659 92.2093 69.6417 91.3 71.2632 90.3451C71.9988 89.9073 72.7938 89.5783 73.6237 89.3683C75.5603 88.8969 76.9484 90.2202 76.3379 92.1066C75.7634 93.8828 74.884 95.5729 74.0255 97.2422C71.7137 101.741 69.5403 106.294 68.2922 111.221C67.5543 114.134 67.0381 117.072 67.5775 120.108C68.437 124.953 71.7206 126.824 76.1843 124.726C78.0472 123.864 79.7558 122.701 81.2419 121.285C83.8625 118.705 86.3417 115.985 88.6687 113.137C93.5687 107.194 98.3176 101.126 103.183 95.1542C104.586 93.4316 106.158 91.844 107.687 90.2273C108.391 89.4828 109.164 88.8 109.934 88.1212C110.8 87.3575 111.797 86.6941 112.939 87.3818C114.143 88.1071 113.818 89.3169 113.491 90.3911C112.893 92.3544 112.143 94.2742 111.606 96.2526C110.368 100.819 109.434 105.455 110.255 110.196C110.574 112.216 111.198 114.175 112.106 116.007C113.645 118.967 116.268 119.854 119.503 118.957C121.917 118.309 124.125 117.055 125.918 115.313C128.414 112.863 130.782 110.264 133.031 107.584C135.781 104.308 138.354 100.883 141 97.5198C145.025 92.4051 150.298 89.8651 156.795 89.8186C157.221 89.7727 157.646 89.7041 158.065 89.6131Z"></path>
                                </svg>
                                <div class="content-box-title-inner">
                                   {!! $homepage_content3_heading !!}
                                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                                        {!! $homepage_content3_btn !!}
                                        <svg viewBox="0 0 10 5">
                                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bottom-content-only">
                <div class="col-md-6 col-12">
                   <p> {!! $homepage_content3_subtext !!}</p>
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                        {!! $homepage_content3_subtext_btn !!}
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <p>{!! $homepage_content3_subtext !!}</p>
                    <div class="award-img">
                        <img src="{{asset('themes/'.APP_THEME().'/assets/images/award-logo.png')}}">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <section class="our-products-shop-section padding-top">
        <div class="container">
            @php
                $homepage_our_product_heading = $homepage_our_product_btn =  '';

                $homepage_our_product_key = array_search('homepage-our-product', array_column($theme_json, 'unique_section_slug'));
                if($homepage_our_product_key != '') {
                    $homepage_our_product = $theme_json[$homepage_our_product_key];

                foreach ($homepage_our_product['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-our-product-heading') {
                    $homepage_our_product_heading = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-our-product-btn') {
                    $homepage_our_product_btn = $value['field_default_text'];
                    }
                }
                }
            @endphp

            @if($homepage_our_product['section_enable'] == 'on')
                <div class="section-title d-flex align-items-center justify-content-between">
                    {!! $homepage_our_product_heading !!}
                    <ul class="cat-tab tabs">
                        @foreach ($MainCategory as $cat_key =>  $category)
                        <li class="tab-link on-tab-click {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                            <a href="javascript:;">{{$category}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="shop-protab-slider f_blog">
                            @foreach ($homeproducts as $homeproduct)
                                @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                                @php
                                    $p_id = hashidsencode($homeproduct->id);
                                @endphp
                                    <div class="shop-protab-itm product-card">
                                        <div class="product-card-inner">
                                            <div class="product-card-image">
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}" class="default-img">
                                                    @if ($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                                                    <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path , APP_THEME()) }}"
                                                        class="hover-img">
                                                    @else
                                                    <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id) , APP_THEME()) }}" class="hover-img">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <h3 class="product-title">
                                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                                            {{$homeproduct->name}}
                                                        </a>
                                                    </h3>
                                                    <div class="product-type title">{{ $homeproduct->ProductData()->name }} / {{ $homeproduct->SubCategoryctData->name }}</div>

                                                </div>
                                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                                    <div class="price">
                                                        <ins>{{ $homeproduct->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                                        <del>{{ $homeproduct->original_price }}</del>
                                                    </div>
                                                    <button class="addtocart-btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                                        <span> {{ __('Add to cart') }}</span>
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
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center see-all-probtn">
                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                        {!! $homepage_our_product_btn !!}
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="two-col-layout-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                @php
                    $homepage_section_layout_bg_img = $homepage_section_layout_heading = $homepage_section_layout_btn = '';

                    $homepage_section_layout_key1 = array_search('homepage-section-layout-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_section_layout_key1 != '') {
                        $homepage_section_layout = $theme_json[$homepage_section_layout_key1];

                    foreach ($homepage_section_layout['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-section-layout-bg-image') {
                        $homepage_section_layout_bg_img = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-section-layout-heading') {
                        $homepage_section_layout_heading = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-section-layout-button') {
                        $homepage_section_layout_btn = $value['field_default_text'];
                        }
                    }
                    }
                @endphp

                @if($homepage_section_layout['section_enable'] == 'on')
                    <div class="col-md-6 col-12 column-left-media">
                        <div class="columnl-left-media-inner">
                            <div class="decorative-img">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="47" viewBox="0 0 40 47" fill="none">
                                    <path d="M7.11864 23.0508C8.33902 26.3488 10.9393 28.9491 14.2373 30.1694C10.9393 31.3898 8.33902 33.9901 7.11864 37.2881C5.89827 33.9901 3.298 31.3898 0 30.1694C3.298 28.9491 5.89827 26.3488 7.11864 23.0508Z" fill="white"></path>
                                    <path d="M26.7799 0C29.0463 6.12486 33.8754 10.9539 40.0002 13.2203C33.8754 15.4867 29.0463 20.3158 26.7799 26.4407C24.5135 20.3158 19.6844 15.4867 13.5596 13.2203C19.6844 10.9539 24.5135 6.12486 26.7799 0Z" fill="white"></path>
                                    <path d="M16.4936 38.9831C19.5686 37.6217 22.0279 35.1624 23.3894 32.0874C24.7508 35.1624 27.2101 37.6217 30.2852 38.9831C27.2101 40.3446 24.7508 42.8039 23.3894 45.8789C22.0279 42.8039 19.5686 40.3446 16.4936 38.9831Z" stroke="white" stroke-width="0.677966"></path>
                                </svg>
                            </div>
                            <img src="{{get_file($homepage_section_layout_bg_img , APP_THEME())}}">
                            <div class="column-left-media-content">
                                <div class="section-title">
                                    {!! $homepage_section_layout_heading !!}
                                </div>
                                {{-- <button class="addtocart-btn">
                                    {!! $homepage_section_layout_btn !!}
                                        <svg viewBox="0 0 10 5">
                                            <path
                                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
                                        </svg>
                                </button> --}}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-6 col-12 column-right-caption">
                    @php
                        $homepage_section_layout2_heading = $homepage_section_layout2_subtext =  '';

                        $homepage_section_layout_key2 = array_search('homepage-section-layout-2', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_section_layout_key2 != '') {
                            $homepage_section_layout2 = $theme_json[$homepage_section_layout_key2];

                        foreach ($homepage_section_layout2['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-section-layout-heading') {
                            $homepage_section_layout2_heading = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-section-layout-sub-text') {
                            $homepage_section_layout2_subtext = $value['field_default_text'];
                            }

                        }
                        }
                    @endphp

                    <div class="columnl-right-caption-inner">
                        <div class="section-title">
                           {!! $homepage_section_layout2_heading !!}
                        </div>
                       {!! $homepage_section_layout2_subtext !!}
                        <div class=" product-row common-arrows">
                            @foreach ($modern_products as $m_product)
                                @php
                                    $p_id = hashidsencode($m_product->id);
                                @endphp
                                <div class="product-card">
                                    <div class="product-card-inner">
                                        <div class="product-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                <img src="{{ get_file($m_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                                @if($product->Sub_image($m_product->id)['status'] == true)
                                                    <img src="{{ get_file($m_product->Sub_image($m_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                                @else
                                                    <img src="{{ get_file($m_product->Sub_image($m_product->id) , APP_THEME()) }}" class="hover-img">
                                                @endif
                                            </a>
                                            <div class="new-labl">
                                                new
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <h3 class="product-title">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                                        {{$m_product->name}}
                                                    </a>
                                                </h3>
                                                <div class="product-type">{{$m_product->ProductData()->name}} / {{$m_product->SubCategoryctData->name}}</div>
                                            </div>
                                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                                <div class="price">
                                                    <ins>{{ $m_product->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                                    <del>{{ $m_product->original_price }}</del>
                                                </div>
                                                <button class="addtocart-btn addcart-btn-globaly" product_id="{{ $m_product->id }}" variant_id="{{ $m_product->default_variant_id }}" qty="1">
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
            </div>
        </div>
    </section>

    <section class="two-col-variant-section padding-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="two-column-variant-left-content">
                        @php
                            $homepage_variant_section1_heading = $homepage_variant_section1_subtext = '';

                            $homepage_variant_section_key1 = array_search('homepage-variant-section-1', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_variant_section_key1 != '') {
                                $homepage_variant_section1 = $theme_json[$homepage_variant_section_key1];

                            foreach ($homepage_variant_section1['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-variant-section-heading') {
                                $homepage_variant_section1_heading = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-variant-section-sub-text') {
                                $homepage_variant_section1_subtext = $value['field_default_text'];
                                }
                            }
                            }
                        @endphp

                        @if($homepage_variant_section1['section_enable'] == 'on')
                            <div class="section-title">
                                {!! $homepage_variant_section1_heading !!}
                            </div>
                         {!! $homepage_variant_section1_subtext !!}


                        @php
                            $homepage_variant_section2_icon_img = $homepage_variant_section2_title =  '';

                            $homepage_variant_section_key2 = array_search('homepage-variant-section-2', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_variant_section_key2 != '') {
                                $homepage_variant_section2 = $theme_json[$homepage_variant_section_key2];

                            }
                        @endphp

                        <ul class="stylelist">
                            @for($i=0 ; $i < $homepage_variant_section2['loop_number'];$i++)
                                @php
                                    foreach ($homepage_variant_section2['inner-list'] as $homepage_variant_section2_value)
                                    {
                                        if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-icon-image') {
                                        $homepage_variant_section2_icon_img = $homepage_variant_section2_value['field_default_text'];
                                        }
                                        if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-title') {
                                        $homepage_variant_section2_title = $homepage_variant_section2_value['field_default_text'];
                                        }

                                        if(!empty($homepage_variant_section2[$homepage_variant_section2_value['field_slug']])){
                                            if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-icon-image'){
                                            $homepage_variant_section2_icon_img = $homepage_variant_section2[$homepage_variant_section2_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_variant_section2_value['field_slug'] == 'homepage-variant-section-title'){
                                                $homepage_variant_section2_title = $homepage_variant_section2[$homepage_variant_section2_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li class="active">
                                    <div class="list-ic">
                                        <img src="{{get_file($homepage_variant_section2_icon_img , APP_THEME())}}" alt="">
                                    </div>
                                    {!! $homepage_variant_section2_title !!}
                                </li>
                            @endfor
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="two-column-variant-right">
                        @if (!empty($latest_product))
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    @php
                                        $p_id = hashidsencode($latest_product->id);
                                    @endphp
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{get_file($latest_product->cover_image_path , APP_THEME())}}" class="default-img">
                                        @if ($latest_product->Sub_image($latest_product->id)['status'] == true)
                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id)['data'][0]->image_path , APP_THEME()) }}"
                                            class="hover-img">
                                    @else
                                        <img src="{{ get_file($latest_product->Sub_image($latest_product->id) , APP_THEME()) }}" class="hover-img">
                                    @endif
                                    </a>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <h2 class="product-title">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                {{ $latest_product->name }}
                                            </a>
                                        </h2>
                                        <div class="product-type">{{ $latest_product->ProductData()->name }} / {{ $latest_product->SubCategoryctData->name }}</div>
                                    </div>
                                    <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                        <div class="price">
                                            <ins>{{ $latest_product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                            <del>{{ $latest_product->final_price }}</del>
                                        </div>
                                        <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $latest_product->id }}" variant_id="{{ $latest_product->default_variant_id }}" qty="1">
                                            <span> {{ __('Add to cart') }} </span>
                                            <svg viewBox="0 0 10 5">
                                                <path
                                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                </path>
                                            </svg>
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

    <section class="review-section">
        <div class="container">
            @php
                $homepage_review_section_heading = '';

                $homepage_review_section_key = array_search('homepage-review-section', array_column($theme_json, 'unique_section_slug'));
                if($homepage_review_section_key != '') {
                    $homepage_review_section = $theme_json[$homepage_review_section_key];

                foreach ($homepage_review_section['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-review-section-heading') {
                    $homepage_review_section_heading = $value['field_default_text'];
                    }
                }
                }
            @endphp

            @if($homepage_review_section['section_enable'] == 'on')
                <div class="section-title">
                    <h2>
                        <svg viewBox="0 0 18 22">
                            <path d="M3.20339 10.373C3.75256 11.8571 4.92268 13.0273 6.40678 13.5764C4.92268 14.1256 3.75256 15.2957 3.20339 16.7798C2.65422 15.2957 1.4841 14.1256 0 13.5764C1.4841 13.0273 2.65422 11.8571 3.20339 10.373Z" fill="white"></path>
                            <path d="M12.0507 0C13.0706 2.75619 15.2437 4.92927 17.9999 5.94915C15.2437 6.96903 13.0706 9.14212 12.0507 11.8983C11.0308 9.14212 8.85775 6.96903 6.10156 5.94915C8.85775 4.92927 11.0308 2.75619 12.0507 0Z" fill="white"></path>
                            <path d="M7.85205 17.5422C8.99627 16.9472 9.9301 16.0134 10.5251 14.8691C11.1201 16.0134 12.0539 16.9472 13.1981 17.5422C12.0539 18.1371 11.1201 19.071 10.5251 20.2152C9.93009 19.071 8.99627 18.1371 7.85205 17.5422Z" stroke="white" stroke-width="0.677966"></path>
                        </svg>
                        {!! $homepage_review_section_heading !!}
                    </h2>
                </div>
            @endif
            <div class="review-slider flex-slider">
                @foreach ($reviews as $review)
                    <div class="review-itm card ">
                        <div class="review-itm-inner card-inner">
                            <p>{{$review->description}}</p>
                            <div class="review-botton d-flex align-items-center">
                                <div class="about-pro d-flex align-items-center">
                                    <div class="abt-pro-img">
                                        <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}">
                                    </div>
                                    <h6 class="review-title">
                                        {{$review->ProductData->name}}
                                    </h6>
                                </div>
                                <div class="about-user d-flex align-items-center">
                                    <div class="abt-user-img">
                                        <img src="{{asset('themes/'.APP_THEME().'/assets/images/john.png')}}">
                                    </div>
                                    <h6>
                                        <span>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</span>
                                        company.com
                                    </h6>
                                    <div class="review-stars">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- discount product --}}
    @php
        $homepage_offer_title =  '';

        $homepage_offer_section_key = array_search('homepage-offer-section', array_column($theme_json, 'unique_section_slug'));
        if($homepage_offer_section_key != '') {
            $homepage_offer_section = $theme_json[$homepage_offer_section_key];

        foreach ($homepage_offer_section['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-offer-section-title') {
            $homepage_offer_title = $value['field_default_text'];
            }

        }
        }
    @endphp
    <section class="offer-section padding-bottom padding-top">
        @if($homepage_offer_section['section_enable'] == 'on')
        <div class="container">
            <div class="section-title text-center">
                <h2>{!! $homepage_offer_title !!}</h2>
            </div>
        </div>
        @endif
        <div class="offer-pro-slider common-arrows">
            @foreach ($discount_products as $discount_product)
                <div class="offer-pro-itm product-card">
                    @php
                        $p_id = hashidsencode($discount_product->id);
                    @endphp
                    <div class="product-card-inner">
                        <div class="product-card-image">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($discount_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                @if ($discount_product->Sub_image($discount_product->id)['status'] == true)
                                    <img src="{{ get_file($discount_product->Sub_image($discount_product->id)['data'][0]->image_path , APP_THEME()) }}"
                                        class="hover-img">
                                @else
                                    <img src="{{ get_file($discount_product->Sub_image($discount_product->id) , APP_THEME()) }}" class="hover-img">
                                @endif
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-content-top">
                                <h3 class="product-title">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        {{$discount_product->name}}
                                    </a>
                                </h3>
                                <div class="product-type">{{ $discount_product->ProductData()->name }} / {{ $discount_product->SubCategoryctData->name }}</div>
                            </div>
                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{$discount_product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                    <del>{{$discount_product->original_price}}</del>
                                </div>
                                <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $discount_product->id }}" variant_id="{{ $discount_product->default_variant_id }}" qty="1">
                                    {{ __('Add to cart') }}
                                    <svg viewBox="0 0 10 5">
                                        <path
                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="about-us-section padding-bottom">
        @php
            $homepage_about_title =  '';

            $homepage_about_section_key = array_search('homepage-about-us-1', array_column($theme_json, 'unique_section_slug'));
            if($homepage_about_section_key != '') {
                $homepage_about_section = $theme_json[$homepage_about_section_key];

            foreach ($homepage_about_section['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-about-us-heading') {
                $homepage_about_title = $value['field_default_text'];
                }
            }
            }
        @endphp
        <div class="container">
            <div class="section-title text-center">
                <h2>{!! $homepage_about_title !!}</h2>
            </div>
            <div class="row">
                @php
                    $homepage_about_us_section_heading = $homepage_about_us_section_subtext = $homepage_about_us_section_icon_img = '';

                    $homepage_aboutus_section_key = array_search('homepage-about-us', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_aboutus_section_key != '') {
                        $homepage_about_us_section = $theme_json[$homepage_aboutus_section_key];

                    }
                @endphp

                @for($i=0 ; $i < $homepage_about_us_section['loop_number'];$i++)
                @php
                    foreach ($homepage_about_us_section['inner-list'] as $homepage_about_us_section_value)
                    {
                        if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-heading') {
                        $homepage_about_us_section_heading = $homepage_about_us_section_value['field_default_text'];
                        }
                        if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-sub-text') {
                        $homepage_about_us_section_subtext = $homepage_about_us_section_value['field_default_text'];
                        }
                        // if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-icon-image') {
                        // $homepage_about_us_section_icon_img = $homepage_about_us_section_value['field_default_text'];
                        // }

                        if(!empty($homepage_about_us_section[$homepage_about_us_section_value['field_slug']]))
                        {
                            if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-heading'){
                                $homepage_about_us_section_heading = $homepage_about_us_section[$homepage_about_us_section_value['field_slug']][$i];
                            }
                            if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-sub-text'){
                                $homepage_about_us_section_subtext = $homepage_about_us_section[$homepage_about_us_section_value['field_slug']][$i];
                            }
                            // if($homepage_about_us_section_value['field_slug'] == 'homepage-about-us-icon-image'){
                            //     $homepage_about_us_section_icon_img = $homepage_about_us_section[$homepage_about_us_section_value['field_slug']][$i]['field_prev_text'];
                            // }
                        }
                    }
                @endphp

                @if($homepage_about_us_section['section_enable'] == 'on')
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="about-us-box">
                            {{-- <img src="{{get_file($homepage_about_us_section_icon_img , APP_THEME())}}" alt="" class="about"> --}}
                            <svg viewBox="0 0 21 21" class="about">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.00628 11.6313C2.34799 11.2896 2.90201 11.2896 3.24372 11.6313L6.125 14.5126C6.46671 14.8543 6.46671 15.4083 6.125 15.75C5.78329 16.0917 5.22927 16.0917 4.88756 15.75L2.00628 12.8687C1.66457 12.527 1.66457 11.973 2.00628 11.6313Z"></path>
                                <path d="M19.0182 4.9685C19.346 4.61341 19.3238 4.05983 18.9687 3.73205C18.6137 3.40427 18.0601 3.42642 17.7323 3.78151L7.8258 14.5136C7.49802 14.8687 7.52017 15.4222 7.87526 15.75C8.23035 16.0778 8.78393 16.0556 9.11171 15.7005L15.1517 9.15725C15.3202 8.97466 15.6068 8.96894 15.7825 9.14464L16.8816 10.2437C17.2233 10.5854 17.7773 10.5854 18.119 10.2437C18.4607 9.90201 18.4607 9.34799 18.119 9.00628L16.9457 7.83296C16.7796 7.66691 16.7743 7.3994 16.9336 7.22685L19.0182 4.9685Z"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.14345 11.2684L3.60576 9.73076C2.58063 8.70563 2.58063 7.04357 3.60576 6.01845L6.89345 2.73076C7.91858 1.70563 9.58063 1.70563 10.6058 2.73076L12.1434 4.26845C13.1686 5.29357 13.1686 6.95563 12.1434 7.98076L8.85576 11.2685C7.83063 12.2936 6.16857 12.2936 5.14345 11.2684ZM4.8432 8.49332L6.38088 10.031C6.72259 10.3727 7.27661 10.3727 7.61832 10.031L10.906 6.74332C11.2477 6.40161 11.2477 5.84759 10.906 5.50588L9.36832 3.9682C9.02661 3.62649 8.47259 3.62649 8.13089 3.96819L4.84319 7.25589C4.50149 7.59759 4.50149 8.15161 4.8432 8.49332Z"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 17.5C7.48325 17.5 7.875 17.1082 7.875 16.625C7.875 16.1418 7.48325 15.75 7 15.75C6.51675 15.75 6.125 16.1418 6.125 16.625C6.125 17.1082 6.51675 17.5 7 17.5ZM7 19.25C8.44975 19.25 9.625 18.0747 9.625 16.625C9.625 15.1753 8.44975 14 7 14C5.55025 14 4.375 15.1753 4.375 16.625C4.375 18.0747 5.55025 19.25 7 19.25Z"></path>
                            </svg>
                            {!! $homepage_about_us_section_heading !!}
                          <p>  {!! $homepage_about_us_section_subtext !!} </p>
                        </div>
                    </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    <section class="home-blog-section">
        {{-- <img src="{{asset('themes/'.APP_THEME().'/assets/images/left-shape.png')}}" class="gliter-img left-glitter"> --}}
        <div class="container">
            <div class="row align-items-center">
                @php
                    $homepage_blog_section1_heading = $homepage_blog_section1_btn = '';

                    $homepage_blog_section_key1 = array_search('homepage-blog-section-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_blog_section_key1 != '') {
                        $homepage_blog_section1 = $theme_json[$homepage_blog_section_key1];

                    foreach ($homepage_blog_section1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-blog-section-heading') {
                        $homepage_blog_section1_heading = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-blog-section-button') {
                        $homepage_blog_section1_btn = $value['field_default_text'];
                        }
                    }
                    }
                @endphp
                @if($homepage_blog_section1['section_enable'] == 'on')
                    <div class="col-md-4 col-12">
                        <div class="blog-left-column-inner">
                            <div class="section-title">
                                {!! $homepage_blog_section1_heading !!}
                            </div>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                                {!! $homepage_blog_section1_btn !!}
                                <svg viewBox="0 0 10 5">
                                    <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="col-md-8 col-12">
                    <div class="blog-right-column-inner">
                        {!! \App\Models\Blog::HomePageBlog($slug,$no= 2) !!}
                    </div>
                </div>
            </div>
            {{-- <div class="bottom-wave-img">
                <svg  xmlns="http://www.w3.org/2000/svg" width="187" height="97" viewBox="0 0 187 97" fill="none">
                    <path d="M88.7111 63.0883C73.1875 63.5922 58.8594 61.5177 46.049 53.0972C34.5553 45.5405 26.2161 34.8257 16.5434 23.8419C18.8293 24.019 20.0143 24.0214 21.1654 24.2196C23.0509 24.545 24.9021 25.1903 26.792 25.3109C27.6891 25.3677 28.6434 24.5191 29.5713 24.0809C29.0426 23.0511 28.6666 21.8886 27.9294 21.0391C27.4803 20.5227 26.4905 20.4078 25.715 20.2539C21.1793 19.34 16.6285 18.4993 12.096 17.5675C9.83687 17.1027 8.7387 18.1501 8.46656 20.2188C7.57919 26.7083 7.66272 33.2938 8.71444 39.7587C8.97457 41.323 9.86231 42.7211 11.5615 42.0917C12.4174 41.7745 13.2345 40.248 13.3231 39.2042C13.482 37.3272 13.0187 35.4058 12.929 33.4972C12.8493 31.7949 12.9226 30.0844 12.931 27.5002C14.4394 29.0934 15.3259 29.961 16.1346 30.8961C19.2665 34.5171 22.4106 38.1281 25.4831 41.7988C41.4682 60.8939 62.0876 69.4636 86.7454 68.3986C90.6953 68.2281 93.1033 69.4115 95.7245 72.1743C104.119 81.0261 114.826 84.51 126.832 84.4917C139.416 84.4714 151.283 81.51 161.849 74.6839C168.109 70.6413 173.748 65.629 179.615 60.9877C180.596 60.2117 181.642 59.2152 182.042 58.0999C182.392 57.1231 181.877 55.8361 181.744 54.6861C180.729 54.8159 179.612 54.7269 178.728 55.1384C177.915 55.5169 177.366 56.4453 176.68 57.1127C167.857 65.678 157.906 72.5053 146.087 76.1947C134.736 79.7378 123.26 80.6871 111.777 76.6151C106.817 74.8663 102.437 71.7819 99.1188 67.702C100.382 67.2673 101.475 66.8006 102.614 66.5136C109.005 64.9035 115.09 62.568 120.611 58.9165C125.339 55.789 129.269 51.8819 131.955 46.8323C136.23 38.7977 133.756 30.47 125.488 26.8111C114.687 22.0297 104.346 23.9157 95.4127 31.1992C86.6259 38.3632 84.422 48.0105 87.3561 58.8679C87.6848 60.0814 88.1236 61.2684 88.7111 63.0883ZM95.0233 62.5352C91.0753 56.6904 90.399 50.5261 92.6101 44.2087C95.9673 34.6154 103.569 30.6338 113.151 29.7071C117.038 29.3308 120.763 29.9291 124.143 32.0921C128.641 34.9699 130.183 38.8515 127.56 43.4894C125.535 47.074 122.88 50.2632 119.721 52.9031C112.657 58.7058 104.105 61.1746 95.0233 62.5352Z" fill="#274D54"/>
                </svg>
            </div> --}}
        </div>
    </section>


<!---wrapper end here-->
{{-- <div class="subscribe-overlay open"></div> --}}
<!--subscribe popup start here-->

    {{-- <div class="subscribe-popup">
        <h2>Sign up our newsletter</h2>
        <button class="close-sub-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.20706 0.707107L6.49995 0L3.60354 2.89641L0.707134 0L2.67029e-05 0.707107L2.89644 3.60352L0 6.49995L0.707107 7.20706L3.60354 4.31062L6.49998 7.20706L7.20708 6.49995L4.31065 3.60352L7.20706 0.707107Z" fill="#30383D"></path>
            </svg>
        </button>
        <p>Subscribe our newsletters now and stay up-to-date with new collections</p>
        <form class="subscriber-form" action="{{ route("newsletter.store") }}" method="post">
            @csrf
            <div class="enter-mail form-row">
                <input type="email" placeholder="Enter Email" name="email">
                <button class="btn-svg arro-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                        <path d="M15.3536 4.35355C15.5488 4.15829 15.5488 3.84171 15.3536 3.64645L12.1716 0.464467C11.9763 0.269205 11.6597 0.269205 11.4645 0.464467C11.2692 0.659729 11.2692 0.976312 11.4645 1.17157L14.2929 4L11.4645 6.82843C11.2692 7.02369 11.2692 7.34027 11.4645 7.53553C11.6597 7.7308 11.9763 7.7308 12.1716 7.53553L15.3536 4.35355ZM-4.37114e-08 4.5L15 4.5L15 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="#30383D"></path>
                    </svg>
                </button>
            </div>
            <div class="thank-u-for" style="display: none;">
                <div class="thanku-note d-flex align-items-center justify-content-center">
                    Thank you for subscribing!
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 15 12" fill="none">
                        <path d="M14 1L5.0625 11L1 6.45455" stroke="#02c102" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>
        </form>
    </div> --}}

<!--subscribe popup ends here-->

<!--cookie popup start here-->
    @php
        $homepage_footer_section9_cookie = '';

        $homepage_footer_key9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
        if($homepage_footer_key9 != '') {
            $homepage_footer_section9 = $theme_json[$homepage_footer_key9];

        foreach ($homepage_footer_section9['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-footer-cookie') {
            $homepage_footer_section9_cookie = $value['field_default_text'];
            }
        }
        }
    @endphp

<div class="cookie">
    {!! $homepage_footer_section9_cookie !!}
    <button class="cookie-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.20706 0.707107L6.49995 0L3.60354 2.89641L0.707134 0L2.67029e-05 0.707107L2.89644 3.60352L0 6.49995L0.707107 7.20706L3.60354 4.31062L6.49998 7.20706L7.20708 6.49995L4.31065 3.60352L7.20706 0.707107Z" fill="#30383D"></path>
        </svg>
    </button>
</div>
    <!--cookie popup ends here-->
@endsection






