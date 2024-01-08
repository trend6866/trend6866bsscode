@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection

@section('content')

@php
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
@endphp

<div class="wrapper">
    <section class="cart-page-section padding-bottom">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </section>


    <section class="best-product padding-bottom">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-discount-product', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-discount-product-title') {
                            $discount_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-discount-product-button') {
                            $discount_btn = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex align-items-center justify-content-between">
                <h2 class="title">{{ $discount_title }}</h2>
                <a href="{{route('page.product-list',$slug)}}" class="btn desk-only">
                    {{ $discount_btn }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                            fill="white"></path>
                    </svg>
                </a>
            </div>

            <div class="row product-list">
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12">
                    @foreach($MainCategoryList->take(1) as $category)
                    <div class="category-card second-style">
                        <div class="category-img">
                            <img src="{{get_file($category->image_path,APP_THEME())}}" alt="Nuts">
                        </div>
                        <div class="category-card-body">
                            <div class="title-wrapper">
                                <h3 class="title">
                                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{!! $category->name !!}</a>
                                </h3>
                            </div>
                            <div class="btn-wrapper">
                                <a href="{{route('page.product-list',$slug)}}" class="btn">{{ __('Show more')}} <svg
                                        xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @foreach($homeproducts->take(3) as $home_product)
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 product-card col-12">
                    @php
                        $p_id = hashidsencode($home_product->id);
                    @endphp
                    <div class="product-card-inner">
                        <div class="product-card-image">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($home_product->cover_image_path , APP_THEME()) }}" class="default-img">
                                {{-- @if($home_product->Sub_image($home_product->id)['status'] == true)
                                    <img src="{{ get_file($home_product->Sub_image($home_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                @else
                                    <img src="{{ get_file($home_product->Sub_image($home_product->id) , APP_THEME()) }}" class="hover-img">
                                @endif --}}
                            </a>
                            <div class="new-labl  danger">
                                <span class="discount-rate">{{$home_product->discount_amount}}
                                    @if($home_product->discount_type == 'percentage') %  @else  {{$currency_icon}} @endif
                                </span>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-content-top d-flex align-items-end">
                                <div class="product-content-left">
                                    <div class="product-type">{{$home_product->tag_api}}</div>
                                    <h3 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            {{$home_product->name}}
                                        </a>
                                    </h3>
                                    <div class="reviews-stars-wrap d-flex align-items-center">
                                        @if (!empty($home_product->average_rating))
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fa fa-star {{ $i < $home_product->average_rating ? '' : 'text-warning' }} "></i>
                                            @endfor
                                            <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                        @else
                                            @for ($i = 0; $i < 5; $i++)
                                                <i lass="fa fa-star {{ $i < $home_product->average_rating ? '' : 'text-warning' }} "></i>
                                            @endfor
                                            <span><b>{{ $home_product->average_rating }}.0</b> / 5.0</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product-content-center">
                                <div class="price">
                                    <ins class="text-danger">{{$home_product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                    <del>{{$home_product->price}} {{$currency}}</del>
                                </div>
                            </div>
                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                <button class="btn addcart-btn-globaly" product_id="{{ $home_product->id }}" variant_id="{{ $home_product->default_variant_id }}" qty="1">
                                    <span>{{ __('Add to cart')}} </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                            fill="white"></path>
                                    </svg>
                                </button>
                                @auth
                                    <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$home_product->id}}" in_wishlist="{{ $home_product->in_whishlist ? 'remove' : 'add'}}">
                                        <span class="wish-ic">
                                            <i class="{{ $home_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                style='color: #fff'></i>
                                        </span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mobile-only d-flex justify-content-center text-center">
                <a href="{{route('page.product-list',$slug)}}" class="btn">
                    {{ $discount_btn }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                            fill="white"></path>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </section>
</div>

@endsection

@push('page-script')
    <script>
        $(document).on('click', '.addcart-btn-globaly', function() {
            setTimeout(() => {
                get_cartlist();
            }, 200);
        });

        $(document).ready(function() {
            get_cartlist();
        });
    </script>
@endpush
