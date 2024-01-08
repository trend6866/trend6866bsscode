@extends('layouts.layouts')

@section('page-title')
{{ __('Cart') }}
@endsection

@section('content')
@php
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
@endphp
<div class="wrapper wrapper-top">
    <section class="cart-page-section padding-bottom">

    </section>

    @php
        $home_pro_card_sec = '';

        $home_pro_card_sec = array_search('home-pro-card-section', array_column($theme_json, 'unique_section_slug'));
        if($home_pro_card_sec != '' ){
            $home_pro_card_sec_value = $theme_json[$home_pro_card_sec];

            foreach ($home_pro_card_sec_value['inner-list'] as $key => $value) {

                if($value['field_slug'] == 'home-pro-card-section-title') {
                    $home_pro_card_sec_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'home-pro-card-section-button') {
                    $home_pro_card_sec_btn = $value['field_default_text'];
                }
            }
        }

    @endphp
<section class="card-slider-sec">
    <div class="container">
        <div class="card-slider-title sec-head d-flex justify-content-between align-items-end">
           {!! $home_pro_card_sec_text !!}
            <a href="#" class=" btn">
              {{ $home_pro_card_sec_btn }}
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                        fill="#F2DFCE" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                        fill="#F2DFCE" />
                </svg>
            </a>
        </div>
        <div class="card-slider-main">
            @foreach ($bestSeller as $product)
                @php
                    $p_id = hashidsencode($product->id);
                    $wishlist = App\Models\Wishlist::where('product_id',$product->id)->where('theme_id',APP_THEME())->first();
                @endphp


                <div class="card-slides">
                    <div class="product-card">
                        <div class="card-top">
                            <div class="card-title">
                                <span>{{ $product->ProductData()->name }}</span>
                                <h3>
                                    <a href="{{ route('page.product' , [$slug,$p_id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                            </div>
                            @auth
                                <a href="#" class="heart">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.1335 2.95108C16.73 4.16664 16.9557 6.44579 15.6274 7.93897L8.99983 15.3894L2.37233 7.93977C1.04381 6.44646 1.26946 4.167 2.86616 2.95128C4.50032 1.70704 6.87275 2.10393 7.99225 3.80885L8.36782 4.38082C8.59267 4.72325 9.05847 4.82238 9.40821 4.60224C9.51777 4.53328 9.60294 4.44117 9.66134 4.33666L10.0076 3.80914C11.1268 2.10394 13.4993 1.70679 15.1335 2.95108ZM8.99998 2.653C7.31724 0.526225 4.15516 0.102335 1.94184 1.78754C-0.33726 3.52284 -0.659353 6.77651 1.23696 8.90805L8.4334 16.9972C8.7065 17.3041 9.18204 17.3362 9.49557 17.0688C9.53631 17.0341 9.57231 16.996 9.60351 16.9553L16.7628 8.90721C18.6589 6.77579 18.3367 3.52246 16.0579 1.78734C13.8446 0.102142 10.6825 0.526185 8.99998 2.653Z"
                                            fill="#173334" />
                                    </svg>
                                </a>
                            @endauth

                        </div>
                        <div class="product-card-image">
                            <a href="{{ route('page.product' , [$slug,$p_id]) }}" tabindex="0">
                                <img src="{{ get_file($product->cover_image_path) , APP_THEME() }}" class="default-img">
								@if ($product->Sub_image($product->id)['status'] == true)
                                     <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                    @else
                                        <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                                    @endif

                            </a>
                        </div>
                        <div class="card-bottom">
                            <div class="price">
                                <ins>{{ $product->final_price }}<span class="currency-type">{{ $currency }}</span></ins>
                            </div>
                            {{-- <div class="product-size-div">
                                <label>
                                    Size:
                                </label>
                                <ul class="product-size">
                                    <li class="size-list">
                                        <input type="radio" name="pro-size3" id="s3" checked>
                                        <label for="s3">s</label>
                                    </li>
                                    <li class="size-list">
                                        <input type="radio" name="pro-size3" id="m3">
                                        <label for="m3">m</label>
                                    </li>
                                    <li class="size-list">
                                        <input type="radio" name="pro-size3" id="x3">
                                        <label for="x3">x</label>
                                    </li>
                                    <li class="size-list">
                                        <input type="radio" name="pro-size3" id="xl3">
                                        <label for="xl3">xl</label>
                                    </li>
                                </ul>
                            </div> --}}
                            <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                Add to cart
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                        fill="#F2DFCE" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                        fill="#F2DFCE" />
                                </svg>
                            </a>
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
