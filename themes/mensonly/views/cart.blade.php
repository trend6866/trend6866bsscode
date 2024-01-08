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


    <section class="bestseller-section">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                @php
                    $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-feature-products-title-text') {
                                $feature_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-feature-products-btn-text') {
                                $feature_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title-left">
                        <h2>{!! $feature_title !!}</h2>
                    </div>
                    <a href="{{route('page.product-list',$slug)}}" class="btn" tabindex="0">
                        {{$feature_btn}}
                    </a>
                @endif
            </div>
            <div class="bestseller-slider flex-slider">
                @foreach($bestSeller as $bestSellers)
                @php
                    $p_id = hashidsencode($bestSellers->id);
                @endphp
                <div class="bestseller-card-itm product-card">
                    <div class="bestseller-card-inner">
                        <div class="bestseller-img">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{get_file($bestSellers->cover_image_path , APP_THEME())}}" alt="">
                            </a>
                        </div>
                        <div class="bestseller-content">
                            <div class="bestseller-top">
                                <div class="bestseller-card-heading">
                                    <span>{{$bestSellers->tag_api}}</span>
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
                                            <div class="badge">
                                                @if ($saleData['discount_type'] == 'flat')
                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                    -{{ $saleData['discount_amount'] }}%
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$bestSellers->id}}" in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add'}}">
                                        {{ __('Add to wishlist')}}
                                        <span class="wish-ic">
                                            <i class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                        </span>
                                    </a>
                                </div>
                                <h3>
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                        {!! $bestSellers->name !!}
                                    </a>
                                </h3>
                                <p class="descriptions">{{$bestSellers->description}}</p>
                            </div>
                            <div class="bestseller-bottom">
                                {{-- <div class="bestdeller-radio-btn">
                                    <span>Size:</span>
                                    <div class="bestseller-btn-group">
                                        <div class="bestseller-radio-btn">
                                            <input type="radio" name="radio1" id="radio1" class="radio" checked="">
                                            <label for="radio1">Small</label>
                                        </div>
                                        <div class="bestseller-radio-btn">
                                            <input type="radio" name="radio1" id="radio2" class="radio">
                                            <label for="radio2">Medium</label>
                                        </div>
                                        <div class="bestseller-radio-btn">
                                            <input type="radio" name="radio1" id="radio3" class="radio">
                                            <label for="radio3">Large</label>
                                        </div>
                                    </div>
                                </div> --}}
                                @if ($bestSellers->variant_product == 0)
                                    <div class="price">
                                        <ins>{{$bestSellers->final_price}}</ins>
                                        <span class="currency-type">{{$currency}}</span>
                                    </div>
                                @else
                                    <div class="price">
                                        <ins>{{ __('In Variant') }}</ins>
                                    </div>
                                @endif
                                <a href="#" class="btn addcart-btn-globaly" product_id="{{ $bestSellers->id }}" variant_id="0" qty="1">
                                    {{ __('Add to cart')}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z" fill="#0A062D"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z" fill="#0A062D"></path>
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
