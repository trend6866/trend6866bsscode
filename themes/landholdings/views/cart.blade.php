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
    <section class="cart-page-section">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </section>

    <section class="padding-top shop-product-first padding-bottom">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-bestseller-title') {
                            $bestseller_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-bestseller-sub-text') {
                            $bestseller_sub_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title text-center">
                <h2 class="title">{!! $bestseller_title !!}</h2>
                <div class="descripion">
                    <p>{{ $bestseller_sub_text }}</p>
                </div>
            </div>
            @endif
                <div class="product-card-slider">
                    @foreach($homeproducts->take(12) as $homeproduct)
                        @php
                            $p_id = hashidsencode($homeproduct->id);
                        @endphp
                        <div class="product-card">
                            <div class="product-card-inner no-back">
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}" class="default-img">
                                        @if($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                        @else
                                            <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id) , APP_THEME()) }}" class="hover-img">
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
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                {{$homeproduct->name}}
                                            </a>
                                        </h3>
                                        <div class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                                            @if(!empty($homeproduct->average_rating))
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star {{ $i < $homeproduct->average_rating ? '' : 'text-warning' }} "></i>
                                                @endfor
                                                <span><b>{{ $homeproduct->average_rating }}.0</b> / 5.0</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-content-center">
                                        @if ($homeproduct->variant_product == 0)
                                            <div class="price">
                                                <ins>{{$homeproduct->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                <del>{{$homeproduct->price}} {{$currency}}</del>
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
                                                <button class="btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="0" qty="1">
                                                    <span> {{ __('Add to cart')}}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
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
