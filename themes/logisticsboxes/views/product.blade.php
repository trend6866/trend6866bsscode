@extends('layouts.layouts')
@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection


@section('content')
    @foreach ($products as $product)
        @php

        @endphp
        {{-- @DD($product) --}}
        <section class="product-main-section padding-bottom padding-top">
            <div class="container">
                <a href="{{ route('page.product-list',$slug) }}" class="back-btn mobile-only">
                    <span class="svg-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                fill="white"></path>
                        </svg>
                    </span>
                    {{ __('Back to Categories') }}
                </a>
                <div class="row pdp-summery-row">

                    <div class="col-lg-6 col-md-6 col-12 pdp-left-side">

                        <div class="pdp-summery">
                            <div class="pdp-top d-flex align-items-center">
                                <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                                    <span class="svg-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5"
                                            viewBox="0 0 11 5" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                                fill="white"></path>
                                        </svg>
                                    </span>
                                    {{ __('Back to Categories') }}
                                </a>
                                <div class="subtitle">{{ $product->tag_api }}</div>
                                    <a href="javascript:void(0)" class="wish-btn wishbtn-globaly" tabindex="0"
                                        product_id="{{ $product->id }}"
                                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                        <span class="">
                                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                style='color:aliceblue;'></i>
                                        </span>
                                        &nbsp;{{ __(' Add to wishlist') }}
                                    </a>
                            </div>
                            <div class="section-title">
                                <h2>{{ $product->name }}</h2>
                            </div>
                            <p class="product-variant-description">{{ $product->description }} </p>
                            <div class="price product-price-amount">
                                <ins>
                                    <ins class="min_max_price" style="display: inline;">
                                        {{ $currency_icon }}{{ $mi_price }} -
                                        {{ $currency_icon }}{{ $ma_price }} </ins>
                                </ins>
                            </div>
                            @if ($product->variant_product == 1)
                                <h6 class="enable_option">
                                    @if ($product->product_stock > 0)
                                        <span
                                            class="stock">{{ $product->product_stock }}</span><small>{{ __(' in stock') }}</small>
                                    @endif
                                </h6>
                            @else
                                <h6>
                                    @if ($product->track_stock == 0)
                                        @if ($product->stock_status == 'out_of_stock')
                                            <span>{{ __('Out of Stock') }}</span>
                                        @elseif ($product->stock_status == 'on_backorder')
                                            <span>{{ __('Available on backorder') }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                    @else
                                        @if ($product->product_stock > 0)
                                            <span>{{ $product->product_stock }}
                                                {{ __('  in stock') }}</span>
                                        @endif
                                    @endif
                                </h6>
                            @endif
                            <span class="product-price-error"></span>
                            @php
                                date_default_timezone_set('Asia/Kolkata');
                                $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
                                $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                    ->where('store_id', getCurrentStore())
                                    ->where('is_active', 1)
                                    ->get();
                                $latestSales = [];

                                foreach ($sale_product as $flashsale) {
                                    $saleEnableArray = json_decode($flashsale->sale_product, true);
                                    $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                    $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

                                    if ($endDate < $startDate) {
                                        $endDate->addDay();
                                    }

                                    if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                        if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                            $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                            $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);
                                            $latestSales[$product->id] = [
                                                'start_date' => $flashsale['start_date'],
                                                'end_date' => $flashsale['end_date'],
                                                'start_time' => $flashsale['start_time'],
                                                'end_time' => $flashsale['end_time'],
                                            ];
                                        }
                                    }
                                }
                            @endphp
                            @if ($latestSales)
                                @foreach ($latestSales as $productId => $saleData)
                                    <input type="hidden" class="flash_sale_start_date"
                                    value={{ $saleData['start_date'] }}>
                                    <input type="hidden" class="flash_sale_end_date"
                                    value={{ $saleData['end_date'] }}>
                                    <input type="hidden" class="flash_sale_start_time"
                                    value={{ $saleData['start_time'] }}>
                                    <input type="hidden" class="flash_sale_end_time"
                                    value={{ $saleData['end_time'] }}>
                                    <div id="flipdown" class="flipdown"></div>
                                @endforeach
                            @endif
                            @if (!empty($product->custom_field))
                                @foreach (json_decode($product->custom_field, true) as $item)
                                    <div class="pdp-detail d-flex  align-items-center">
                                        <b>{{ $item['custom_field'] }} :</b>
                                        <span class="lbl">{{ $item['custom_value'] }}</span>
                                    </div>
                                @endforeach
                            @endif
                            <div class="stock_status"></div>
                            @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                            @else
                                <form class="variant_form ">
                                    <div class="cart-variable row">
                                        @if ($product->variant_product == 1)
                                            @php
                                                $variant = json_decode($product->product_attribute);
                                                $varint_name_array = [];
                                                if (!empty($product->DefaultVariantData->variant)) {
                                                    $varint_name_array = explode('-', $product->DefaultVariantData->variant);
                                                }
                                            @endphp
                                            @foreach ($variant as $key => $value)
                                                @php
                                                    $p_variant = App\Models\Utility::ProductAttribute($value->attribute_id);
                                                    $attribute = json_decode($p_variant);
                                                    $propertyKey = 'for_variation_' . $attribute->id;
                                                    $variation_option = $value->$propertyKey;
                                                @endphp
                                                @if ($variation_option == 1)
                                                    <div class="col-6">
                                                        <div class="size-variable">
                                                            <div class="swatch-lbl">{{ $attribute->name }} :</div>
                                                            <select class="product_variatin_option variant_loop"
                                                                name="varint[{{ $attribute->name }}]">
                                                                @php
                                                                    $optionValues = [];
                                                                @endphp

                                                                @foreach ($value->values as $variant1)
                                                                    @php
                                                                        $parts = explode('|', $variant1);
                                                                    @endphp
                                                                    @foreach ($parts as $p)
                                                                        @php
                                                                            $id = App\Models\ProductAttributeOption::where('id', $p)->first();
                                                                            $optionValues[] = $id->terms;
                                                                        @endphp
                                                                    @endforeach
                                                                @endforeach
                                                                <option value="">
                                                                    {{ __('Select an option') }}
                                                                </option>

                                                                @if (is_array($optionValues))
                                                                    @foreach ($optionValues as $optionValue)
                                                                        <option>{{ $optionValue }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    &nbsp;<div class="size-variant-swatch d-flex">
                                        <div class="color-lbl d-block">{{ __('quantity :') }}</div>&nbsp;
                                        <div class="qty qty-spinner">
                                            <button type="button" class="quantity-decrement change_price">
                                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3"></path>
                                                </svg>
                                            </button>
                                            <input type="text" class="quantity" data-cke-saved-name="quantity" name="qty"
                                                value="01" min="01" max="100">
                                            <button type="button" class="quantity-increment change_price">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                        fill="#61AFB3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            @endif
                            <div class="price product-price-amount price-value">
                                <ins class="product_final_price">{{ $product->final_price }}</ins><span
                                    class="currency-type">{{ $currency }}</span>
                            </div>
                            <div class="sku-cart-btn-wrp">
                                <div class="cart-btn-wrap d-flex align-items-center">
                                    @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                    @else
                                        <a href="javascript:void(0)"
                                            class="btn-secondary addcart-btn addtocart-btn-cart addcart-btn-globaly"
                                            product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                            qty="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10"
                                                viewBox="0 0 16 10" fill="none">
                                                <path
                                                    d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                                    fill="white"></path>
                                            </svg>{{ __('ADD TO CART') }}
                                        </a>
                                    @endif

                                        <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly"
                                            product_id="{{ $product->id }}"
                                            in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                            <span class="">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </a>
                                </div>
                                <div class="sku-variable">
                                    <ul class="sku-list d-flex justify-content-between">
                                        <li>
                                            @if ($product_stocks->isNotEmpty())
                                                <span><b>{{ __('SKU:') }}</b>
                                                    @foreach ($product_stocks as $product_stock)
                                                        {{ $product_stock->sku }},</b>
                                                    @endforeach
                                                </span>
                                            @endif
                                        </li>
                                        <li>
                                            <span><b>{{ __('Category:') }}</b> {{ $product->ProductData()->name }}</span>
                                        </li>
                                        @if ($product_stocks->isNotEmpty())
                                            <li>
                                                <span><b>{{ __('Size:') }}</b>
                                                    {{ $product->default_variant_name }}</span>
                                                {{-- <span><b>Weight:</b> 60 lbs</span> --}}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 pdp-right-side">
                        <div class="pdp-detail-wrapper">
                            <div class="pdp-detail-top">
                                <div class="size-location d-flex">
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            viewBox="0 0 21 21" fill="none">
                                            <path
                                                d="M18.2601 0H2.2322C1.64078 0.00192961 1.07413 0.237729 0.65593 0.655929C0.237729 1.07413 0.00192961 1.64078 0 2.2322V18.2967C0.00192961 18.8881 0.237729 19.4548 0.65593 19.873C1.07413 20.2912 1.64078 20.527 2.2322 20.5289H18.2601C18.8452 20.5174 19.4025 20.2774 19.8128 19.8602C20.2231 19.4431 20.4539 18.8819 20.4557 18.2967V2.2688C20.4636 1.67732 20.2371 1.10676 19.8257 0.681682C19.4143 0.256608 18.8515 0.0115466 18.2601 0ZM8.01395 1.46374H12.4052V7.31868H8.01395V1.46374ZM18.992 18.2967C18.992 18.4908 18.9149 18.677 18.7776 18.8142C18.6404 18.9515 18.4542 19.0286 18.2601 19.0286H2.2322C2.13012 19.0388 2.02702 19.0275 1.9296 18.9954C1.83217 18.9632 1.7426 18.9109 1.66669 18.8419C1.59078 18.7729 1.53022 18.6887 1.48895 18.5948C1.44768 18.5008 1.42663 18.3993 1.42714 18.2967V2.2688C1.42188 2.16649 1.43817 2.06422 1.47493 1.9686C1.51168 1.87299 1.5681 1.78615 1.64054 1.71372C1.71297 1.64128 1.7998 1.58486 1.89541 1.54811C1.99103 1.51135 2.0933 1.49507 2.1956 1.50033H6.55022V7.54556C6.55022 7.8833 6.68438 8.2072 6.9232 8.44602C7.16201 8.68484 7.48593 8.81901 7.82367 8.81901H12.5954C12.9332 8.81901 13.2571 8.68484 13.4959 8.44602C13.7347 8.2072 13.8689 7.8833 13.8689 7.54556V1.46374H18.2601C18.3624 1.45848 18.4647 1.47476 18.5603 1.51152C18.6559 1.54828 18.7427 1.6047 18.8152 1.67713C18.8876 1.74957 18.944 1.83639 18.9808 1.93201C19.0175 2.02762 19.0338 2.1299 19.0286 2.2322L18.992 18.2967Z"
                                                fill="#05103B" />
                                            <path
                                                d="M16.7936 13.1738H13.1342C12.9401 13.1738 12.754 13.2509 12.6167 13.3882C12.4795 13.5254 12.4023 13.7116 12.4023 13.9057C12.4023 14.0998 12.4795 14.286 12.6167 14.4232C12.754 14.5605 12.9401 14.6376 13.1342 14.6376H16.7936C16.9877 14.6376 17.1738 14.5605 17.3111 14.4232C17.4483 14.286 17.5254 14.0998 17.5254 13.9057C17.5254 13.7116 17.4483 13.5254 17.3111 13.3882C17.1738 13.2509 16.9877 13.1738 16.7936 13.1738Z"
                                                fill="#05103B" />
                                            <path
                                                d="M16.7977 16.0977H10.9428C10.7487 16.0977 10.5625 16.1748 10.4253 16.312C10.288 16.4493 10.2109 16.6354 10.2109 16.8295C10.2109 17.0236 10.288 17.2098 10.4253 17.347C10.5625 17.4843 10.7487 17.5614 10.9428 17.5614H16.7977C16.9919 17.5614 17.178 17.4843 17.3153 17.347C17.4525 17.2098 17.5296 17.0236 17.5296 16.8295C17.5296 16.6354 17.4525 16.4493 17.3153 16.312C17.178 16.1748 16.9919 16.0977 16.7977 16.0977Z"
                                                fill="#05103B" />
                                            <path
                                                d="M5.60229 12.6559C5.53269 12.5892 5.45061 12.537 5.36077 12.5022C5.18259 12.429 4.98273 12.429 4.80455 12.5022C4.71471 12.537 4.63263 12.5892 4.56303 12.6559L3.09929 14.1196C3.0307 14.1876 2.97625 14.2686 2.9391 14.3578C2.90194 14.4469 2.88281 14.5426 2.88281 14.6392C2.88281 14.7358 2.90194 14.8315 2.9391 14.9207C2.97625 15.0099 3.0307 15.0908 3.09929 15.1588C3.16733 15.2274 3.24828 15.2819 3.33746 15.319C3.42665 15.3562 3.52231 15.3753 3.61892 15.3753C3.71554 15.3753 3.8112 15.3562 3.90039 15.319C3.98957 15.2819 4.07052 15.2274 4.13856 15.1588L4.35079 14.9393V16.8348C4.35079 17.0289 4.4279 17.2151 4.56515 17.3523C4.7024 17.4896 4.88856 17.5667 5.08266 17.5667C5.27676 17.5667 5.46292 17.4896 5.60017 17.3523C5.73742 17.2151 5.81453 17.0289 5.81453 16.8348V14.9393L6.02676 15.1588C6.09515 15.2267 6.17625 15.2803 6.26542 15.3168C6.35459 15.3532 6.45008 15.3716 6.5464 15.3711C6.64271 15.3716 6.7382 15.3532 6.82737 15.3168C6.91654 15.2803 6.99764 15.2267 7.06603 15.1588C7.13462 15.0908 7.18907 15.0099 7.22622 14.9207C7.26338 14.8315 7.28251 14.7358 7.28251 14.6392C7.28251 14.5426 7.26338 14.4469 7.22622 14.3578C7.18907 14.2686 7.13462 14.1876 7.06603 14.1196L5.60229 12.6559Z"
                                                fill="#05103B" />
                                        </svg> {{ $product->default_variant_name }}</p>
                                    {{-- <p><svg xmlns="http://www.w3.org/2000/svg" width="9" height="11"
                                            viewBox="0 0 9 11" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.82077 7.62223C7.52115 6.65004 8 5.58153 8 4.5C8 2.567 6.433 1 4.5 1C2.567 1 1 2.567 1 4.5C1 5.58153 1.47885 6.65004 2.17923 7.62223C2.87434 8.5871 3.72907 9.37514 4.33844 9.87424C4.4384 9.95611 4.5616 9.95611 4.66156 9.87424C5.27093 9.37514 6.12566 8.5871 6.82077 7.62223ZM5.2952 10.6479C6.58731 9.58957 9 7.24584 9 4.5C9 2.01472 6.98528 0 4.5 0C2.01472 0 0 2.01472 0 4.5C0 7.24584 2.41269 9.58957 3.7048 10.6479C4.17328 11.0316 4.82672 11.0316 5.2952 10.6479Z"
                                                fill="#5EA5DF"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.5 3.5C3.94772 3.5 3.5 3.94772 3.5 4.5C3.5 5.05228 3.94772 5.5 4.5 5.5C5.05228 5.5 5.5 5.05228 5.5 4.5C5.5 3.94772 5.05228 3.5 4.5 3.5ZM2.5 4.5C2.5 3.39543 3.39543 2.5 4.5 2.5C5.60457 2.5 6.5 3.39543 6.5 4.5C6.5 5.60457 5.60457 6.5 4.5 6.5C3.39543 6.5 2.5 5.60457 2.5 4.5Z"
                                                fill="#5EA5DF"></path>
                                        </svg> Malesia</p> --}}
                                </div>
                                <p>{{ $product->description }} </p>
                                <div class="date-wrap">
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            viewBox="0 0 21 21" fill="none">
                                            <path
                                                d="M18.6375 2.25H18V1.5C17.9905 1.10517 17.8294 0.729145 17.5501 0.449877C17.2709 0.170609 16.8948 0.00951808 16.5 0H15.075C14.6738 0.00978914 14.2923 0.176087 14.012 0.46337C13.7317 0.750653 13.5749 1.13614 13.575 1.5375V2.25H7.575V1.5C7.56548 1.10517 7.40439 0.729145 7.12513 0.449877C6.84586 0.170609 6.46983 0.00951808 6.075 0H4.65C4.24877 0.00978914 3.86726 0.176087 3.58699 0.46337C3.30671 0.750653 3.14989 1.13614 3.15 1.5375V2.25H2.5125C2.18987 2.22947 1.86646 2.27538 1.56229 2.38488C1.25811 2.49438 0.979647 2.66515 0.744128 2.88661C0.508609 3.10806 0.321047 3.3755 0.193052 3.67237C0.0650574 3.96924 -0.000647509 4.28922 4.80991e-06 4.6125V17.8875C4.80991e-06 18.5141 0.248911 19.115 0.691966 19.558C1.13502 20.0011 1.73593 20.25 2.36251 20.25H18.6375C19.2641 20.25 19.865 20.0011 20.308 19.558C20.7511 19.115 21 18.5141 21 17.8875V4.6125C21 3.98593 20.7511 3.38501 20.308 2.94196C19.865 2.49891 19.2641 2.25 18.6375 2.25ZM16.5 1.5V3.75H15V1.5H16.5ZM6 1.5V3.75H4.5V1.5H6ZM2.36251 3.75H3C3 4.14782 3.15804 4.52935 3.43934 4.81066C3.72065 5.09196 4.10218 5.25 4.5 5.25H6C6.39783 5.25 6.77936 5.09196 7.06066 4.81066C7.34197 4.52935 7.5 4.14782 7.5 3.75H13.5C13.5 4.14782 13.658 4.52935 13.9393 4.81066C14.2206 5.09196 14.6022 5.25 15 5.25H16.5C16.8978 5.25 17.2794 5.09196 17.5607 4.81066C17.842 4.52935 18 4.14782 18 3.75H18.6375C18.8656 3.75196 19.0839 3.84346 19.2452 4.00478C19.4065 4.16611 19.498 4.38436 19.5 4.6125V6.75H1.5V4.6125C1.50196 4.38436 1.59346 4.16611 1.75479 4.00478C1.91612 3.84346 2.13436 3.75196 2.36251 3.75ZM18.6375 18.75H2.36251C2.13436 18.748 1.91612 18.6565 1.75479 18.4952C1.59346 18.3339 1.50196 18.1156 1.5 17.8875V8.25H19.5V17.8875C19.498 18.1156 19.4065 18.3339 19.2452 18.4952C19.0839 18.6565 18.8656 18.748 18.6375 18.75Z"
                                                fill="#05103B" />
                                            <path
                                                d="M9.43342 9.89077C9.33726 9.82108 9.22592 9.77521 9.10857 9.75696C8.99122 9.73871 8.87121 9.74858 8.75842 9.78577L6.50842 10.5358C6.41471 10.5671 6.32811 10.6166 6.2536 10.6815C6.17908 10.7464 6.11812 10.8253 6.07422 10.9138C6.03031 11.0023 6.00433 11.0986 5.99776 11.1972C5.99118 11.2958 6.00415 11.3947 6.03592 11.4883C6.06723 11.582 6.11675 11.6686 6.18162 11.7431C6.2465 11.8176 6.32546 11.8786 6.41397 11.9225C6.50248 11.9664 6.5988 11.9924 6.69738 11.9989C6.79596 12.0055 6.89487 11.9925 6.98842 11.9608L8.24842 11.5408V16.4983C8.24842 16.6972 8.32744 16.8879 8.46809 17.0286C8.60874 17.1693 8.79951 17.2483 8.99842 17.2483C9.19733 17.2483 9.3881 17.1693 9.52875 17.0286C9.6694 16.8879 9.74842 16.6972 9.74842 16.4983V10.4983C9.74787 10.3793 9.71902 10.2621 9.66424 10.1565C9.60947 10.0509 9.53035 9.95978 9.43342 9.89077Z"
                                                fill="#05103B" />
                                            <path
                                                d="M12.75 9.74805C12.1533 9.74805 11.581 9.9851 11.159 10.4071C10.7371 10.829 10.5 11.4013 10.5 11.998V14.998C10.5 15.5948 10.7371 16.1671 11.159 16.589C11.581 17.011 12.1533 17.248 12.75 17.248C13.3467 17.248 13.919 17.011 14.341 16.589C14.7629 16.1671 15 15.5948 15 14.998V11.998C15 11.4013 14.7629 10.829 14.341 10.4071C13.919 9.9851 13.3467 9.74805 12.75 9.74805ZM13.5 14.998C13.5 15.197 13.421 15.3877 13.2803 15.5284C13.1397 15.669 12.9489 15.748 12.75 15.748C12.5511 15.748 12.3603 15.669 12.2197 15.5284C12.079 15.3877 12 15.197 12 14.998V11.998C12 11.7991 12.079 11.6084 12.2197 11.4677C12.3603 11.3271 12.5511 11.248 12.75 11.248C12.9489 11.248 13.1397 11.3271 13.2803 11.4677C13.421 11.6084 13.5 11.7991 13.5 11.998V14.998Z"
                                                fill="#05103B" />
                                        </svg>{{ $product->created_at->format('d M,Y ') }}</p>
                                </div>
                            </div>
                            <div class="pdp-sliders-wrapper">
                                <div class="pdp-main-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-main-itm">
                                            <div class="pdp-main-media">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="">
                                                @php
                                                    $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
                                                    $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                        ->where('store_id', getCurrentStore())
                                                        ->where('is_active', 1)
                                                        ->get();
                                                    $latestSales = [];

                                                    foreach ($sale_product as $flashsale) {
                                                        $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                        $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                                        $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

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
                                                    <div class="custom-output sale-tag-product">
                                                        <div class="sale_tag_icon rounded col-1 onsale">
                                                            <div>{{ __('Sale!') }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="pdp-thumb-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-thumb-itm">
                                            <div class="pdp-thumb-media">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="">
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
        @if ($product_review->isNotEmpty())
            <section class="padding-top product-page-review  testimonial-section padding-bottom">
                <div class="container">
                    <div class="review-slider">
                        @foreach ($product_review as $review)
                            <div class="testimonials-card">
                                <div class="reviews-stars-wrap d-flex align-items-center">
                                    <div class="reviews-stars-outer">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i
                                                class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                        @endfor
                                    </div>
                                    <div class="point-wrap">
                                        <span class="review-point">{{ $review->rating_no }} / <span>5.0</span></span>
                                    </div>
                                </div>
                                <div class="reviews-words">
                                    <h2>{{ $review->title }}</h2>
                                    <p class="descriptions">{{ $review->description }}</p>
                                    <div class="review-bottom d-flex align-items-center">
                                        <div class="about-product">
                                            <p> {{ $review->ProductData->name }}<span>&nbsp;
                                                    {{ $product->default_variant_name }}</span></p>
                                        </div>
                                        <div class="about-user">
                                            <h6><span>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</span>
                                                {{ __('Client') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="product-page-products padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-6 col-12">
                        <div class="related-product-one product-row">
                            @foreach ($lat_product as $products)
                                @php
                                    $product_ids = hashidsencode($products->id);
                                @endphp
                                <div class="product-card">
                                    <div class="product-card-inner">
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
                                                        if (is_array($saleEnableArray) && in_array($products->id, $saleEnableArray)) {
                                                            $latestSales[$products->id] = [
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
                                        <div class="product-img">
                                            <a href="{{ route('page.product', [$slug,$product_ids]) }}">
                                                <img src="{{ get_file($products->cover_image_path, APP_THEME()) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <div
                                                    class="top-subtitle d-flex align-items-center justify-content-between">
                                                    <div class="subtitle">{{ $products->tag_api }}</div>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                            height="13" viewBox="0 0 13 13" fill="none">
                                                            <path
                                                                d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z"
                                                                fill="#5EA5DF" />
                                                        </svg>{{ $products->default_variant_name }}</p>
                                                </div>
                                                <h5><a href="{{ route('page.product', [$slug,$product_ids]) }}"><b>{{ $products->name }}</b>
                                                    </a>
                                                </h5>
                                            </div>
                                            {{-- <div class="cart-variable">
                                        <div class="swatch-lbl">
                                            <strong>Available:</strong>
                                        </div>
                                        <select class="theme-arrow">
                                            <option>Paper Material (15pcs available)</option>
                                            <option>Paper Material (14pcs available)</option>
                                            <option>Paper Material (13pcs available)</option>
                                        </select>
                                    </div> --}}
                                            <div class="product-content-bottom">
                                                @if ($products->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{$products->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="javascript:void(0)"
                                                        class="btn-secondary  addtocart-btn-cart addcart-btn-globaly"
                                                        product_id="{{ $products->id }}"
                                                        variant_id="0"
                                                        qty="1"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="10" viewBox="0 0 16 10"
                                                            fill="none">
                                                            <path
                                                                d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                                                fill="white"></path>
                                                        </svg>{{ __('ADD TO CART') }}</a>

                                                        <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly"
                                                            product_id="{{ $products->id }}"
                                                            in_wishlist="{{ $products->in_whishlist ? 'remove' : 'add' }}">
                                                            <span class="">
                                                                <i class="{{ $products->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                    style="color: white"></i>
                                                            </span>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-6 col-12">
                        <div class="newproduct-right">
                            @php
                                $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text = '';
                                $homepage_header_1_key = array_search('homepage-listpage-1', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-banner-offer-label') {
                                            $contact_us_header_worktime = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-offer-text') {
                                            $contact_us_header_calling = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-title-text') {
                                            $contact_us_header_call = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                            $contact_us_header_contact = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-blog-btn-text') {
                                            $contact_us_header_label_text = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}
                            <div class="offer-announcement second-style">
                                <span class="new-labl">{!! $contact_us_header_worktime !!}</span>
                                <p><b>{!! $contact_us_header_calling !!} <a href="#">{{ __('More') }}</a></b></p>
                            </div>
                            <div class="section-title">
                                <h2>{!! $contact_us_header_call !!}</h2>
                            </div>
                            <p>{!! $contact_us_header_contact !!}</p>
                            <a href="{{ route('page.product-list',$slug) }}" class="btn"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10"
                                    fill="none">
                                    <path
                                        d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                        fill="white"></path>
                                </svg>{!! $contact_us_header_label_text !!}</a>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="tab-vid-section padding-top">
            <div class="container">
                <div class="tabs-wrapper">
                    <div class="blog-head-row tab-nav d-flex justify-content-between">
                        <div class="blog-col-left ">
                            <ul class="d-flex tabs">
                                @if ($product->preview_content != '')
                                    <li class="tab-link on-tab-click " data-tab="1"><a
                                            href="javascript:;">{{ __('Video') }}</a>
                                    </li>
                                @endif
                                <li class="tab-link on-tab-click active" data-tab="2"><a
                                        href="javascript:;">{{ __('Question & Answer') }}</a>
                                </li>
                                @if ($product->product_attribute != '')
                                    <li class="tab-link on-tab-click" data-tab="3"><a
                                            href="javascript:;">{{ __('Additional Information') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="tabs-container">

                        @if ($product->preview_content != '')
                            <div id="1" class="tab-content">
                                <div class="video-wrapper">
                                    @if ($product->preview_type == 'Video Url')
                                        @if (str_contains($product->preview_content, 'youtube') || str_contains($product->preview_content, 'youtu.be'))
                                            @php
                                                if (strpos($product->preview_content, 'src') !== false) {
                                                    preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                    $url = $match[1];
                                                    $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                } elseif (strpos($product->preview_content, 'src') == false && strpos($product->preview_content, 'embed') !== false) {
                                                    $video_url = str_replace('https://www.youtube.com/embed/', '', $product->preview_content);
                                                } else {
                                                    $video_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $product->preview_content, $matches);
                                                    if (count($matches) > 0) {
                                                        $videoId = $matches[1];
                                                        $video_url = strtok($videoId, '&');
                                                    }
                                                }
                                            @endphp
                                            <iframe class="video-card-tag" width="100%" height="100%"
                                                src="{{ 'https://www.youtube.com/embed/' }}{{ $video_url }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @elseif(str_contains($product->preview_content, 'vimeo'))
                                            @php
                                                if (strpos($product->preview_content, 'src') !== false) {
                                                    preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                    $url = $match[1];
                                                    $video_url = str_replace('https://player.vimeo.com/video/', '', $url);
                                                } else {
                                                    $video_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                                                }
                                            @endphp
                                            <iframe class="video-card-tag" width="100%" height="350"
                                                src="{{ 'https://player.vimeo.com/video/' }}{{ $video_url }}"
                                                frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @else
                                            @php
                                                $video_url = $product->preview_content;
                                            @endphp
                                            <iframe class="video-card-tag" width="100%" height="100%"
                                                src="{{ $video_url }}" title="Video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @endif
                                    @elseif($product->preview_type == 'iFrame')
                                        @if (str_contains($product->preview_content, 'youtube') || str_contains($product->preview_content, 'youtu.be'))
                                            @php
                                                if (strpos($product->preview_content, 'src') !== false) {
                                                    preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                    $url = $match[1];
                                                    $iframe_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                } else {
                                                    $iframe_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                                                }
                                            @endphp
                                            <iframe width="100%" height="100%"
                                                src="https://www.youtube.com/embed/{{ $iframe_url }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @elseif(str_contains($product->preview_content, 'vimeo'))
                                            @php
                                                if (strpos($product->preview_content, 'src') !== false) {
                                                    preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                    $url = $match[1];
                                                    $iframe_url = str_replace('https://player.vimeo.com/video/', '', $url);
                                                } else {
                                                    $iframe_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                                                }
                                            @endphp
                                            <iframe class="video-card-tag" width="100%" height="350"
                                                src="{{ 'https://player.vimeo.com/video/' }}{{ $iframe_url }}"
                                                frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @else
                                            @php
                                                $iframe_url = $product->preview_content;
                                            @endphp
                                            <iframe class="video-card-tag" width="100%" height="100%"
                                                src="{{ $iframe_url }}" title="Video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @endif
                                    @else
                                        <video controls="">
                                            <source src="{{ get_file($product->preview_content, APP_THEME()) }}"
                                                type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div id="2" class="tab-content active">
                            <div class="queary-div">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ __('Have doubts regarding this product?') }}</h4>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary Question"
                                        @if (\Auth::check()) data-ajax-popup="true" @else data-ajax-popup="false" @endif
                                        data-size="xs" data-title="Post your question"
                                        data-url="{{ route('Question', [$slug, $product->id]) }} " data-toggle="tooltip">
                                        <i class="ti ti-plus"></i>
                                        <span class="lbl">{{ __('Post Your Question') }}</span>
                                    </a>
                                </div>
                                <div class="qna">
                                    <br>
                                    <ul>
                                        @foreach ($question->take(4) as $que)
                                            <li>
                                                <div class="quetion">
                                                    <span class="icon que">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="305"
                                                            height="266" viewBox="0 0 305 266" fill="none"
                                                            class="__web-inspector-hide-shortcut__">
                                                            <path
                                                                d="M152.4 256.4C222.8 256.4 283.6 216.2 300.1 158.6C303 148.8 304.4 138.6 304.4 128.4C304.4 57.7999 236.2 0.399902 152.4 0.399902C68.6004 0.399902 0.400391 57.7999 0.400391 128.4C0.600391 154.8 10.0004 180.3 27.0004 200.5C28.8004 202.7 29.3004 205.7 28.3004 208.4L6.70039 265.4L68.2004 238.4C70.4004 237.4 72.9004 237.5 75.0004 238.6C95.8004 248.9 118.4 254.9 141.5 256.1C145.2 256.3 148.8 256.4 152.4 256.4ZM104.4 120.4C104.4 85.0999 125.9 56.3999 152.4 56.3999C178.9 56.3999 200.4 85.0999 200.4 120.4C200.5 134.5 196.8 148.5 189.7 160.6L204.5 169.5C207 170.9 208.5 173.6 208.5 176.5C208.5 179.4 206.9 182 204.3 183.4C201.7 184.8 198.7 184.7 196.2 183.2L179.4 173.1C172.1 180.1 162.4 184.1 152.3 184.3C125.9 184.4 104.4 155.7 104.4 120.4Z"
                                                                fill="black" />
                                                            <path
                                                                d="M164.9 164.4L156.3 159.2C152.6 156.9 151.4 152 153.7 148.3C156 144.6 160.8 143.3 164.6 145.5L176 152.4C181.6 142.7 184.6 131.6 184.4 120.4C184.4 94.3999 169.7 72.3999 152.4 72.3999C135.1 72.3999 120.4 94.3999 120.4 120.4C120.4 146.4 135.1 168.4 152.4 168.4C156.8 168.3 161.2 166.9 164.9 164.4Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <div class="text">
                                                        <p>
                                                            {{ $que->question }}
                                                        </p>
                                                        <span class="user">{{ __($que->users->name) }}</span>
                                                    </div>
                                                </div>
                                                <div class="answer">
                                                    <span class="icon ans">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="304"
                                                            height="273" viewBox="0 0 304 273" fill="none">
                                                            <path
                                                                d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.4 55.5002 234.2 0.200195 152 0.200195C68.5 0.200195 0.6 57.1002 0 127.3C0 127.7 0 128 0 128.4C0.2 154.7 9.6 180.2 26.6 200.4C27.2 201.1 27.6 201.9 27.9 202.7C39.6 216.7 54.6 228.5 71.9 237.6C72.8 237.7 73.7 238 74.6 238.4C95.4 248.7 118 254.7 141.1 255.9C144.8 256.2 148.4 256.3 152 256.3C222.4 256.3 283.2 216.1 299.7 158.5C301.2 153.4 302.3 148.3 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM204 183.3C201.5 184.7 198.4 184.6 195.9 183.1L193.7 181.8L199.5 198.2C201 202.4 198.8 206.9 194.7 208.4C190.5 209.9 186 207.7 184.5 203.6L174.9 176.6C168.3 181.4 160.3 184.1 152.1 184.3C143.9 184.3 136.1 181.5 129.3 176.6L119.7 203.6C118.2 207.8 113.6 209.9 109.5 208.4C105.3 206.9 103.2 202.3 104.7 198.2L117 163.7C109.1 152.3 104.2 137 104.2 120.3C104.2 85.0002 125.7 56.3002 152.2 56.3002C178.7 56.3002 200.2 85.0002 200.2 120.3C200.4 134.4 196.6 148.3 189.5 160.5L204.3 169.4C206.8 170.9 208.3 173.5 208.3 176.4C208.1 179.3 206.5 181.9 204 183.3Z"
                                                                fill="black" />
                                                            <path
                                                                d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.2 61.1002 243.4 8.7002 169.1 1.7002C168.8 2.7002 168.3 3.60019 168 4.50019C167.3 6.40019 166.6 8.20019 165.8 10.1002C165 12.0002 164.1 13.9002 163.2 15.8002C162.3 17.7002 161.4 19.4002 160.5 21.2002C159.5 23.0002 158.5 24.8002 157.5 26.5002C156.5 28.3002 155.4 30.0002 154.3 31.7002C153.2 33.4002 152 35.1002 150.8 36.7002C149.6 38.3002 148.4 40.0002 147.1 41.7002C145.8 43.3002 144.5 44.8002 143.2 46.4002C141.9 47.9002 140.5 49.5002 139.1 51.1002C137.7 52.6002 136.2 54.0002 134.8 55.5002C133.3 56.9002 131.8 58.4002 130.3 59.8002C128.8 61.2002 127.2 62.6002 125.5 63.9002C123.9 65.2002 122.3 66.6002 120.6 67.9002C118.9 69.2002 117.2 70.4002 115.4 71.7002C113.7 72.9002 112 74.1002 110.2 75.3002C108.4 76.5002 106.5 77.6002 104.6 78.7002C102.7 79.8002 101 80.9002 99.2 81.9002C97.3 82.9002 95.2 84.0002 93.2 85.0002C91.3 85.9002 89.5 86.9002 87.6 87.8002C85.5 88.8002 83.3 89.6002 81.2 90.5002C79.3 91.3002 77.4 92.1002 75.5 92.9002C73.3 93.7002 70.9 94.5002 68.6 95.2002C66.7 95.8002 64.7 96.5002 62.8 97.1002C60.4 97.8002 57.9 98.4002 55.4 99.0002C53.5 99.5002 51.6 100 49.6 100.4C47 101 44.3 101.4 41.6 101.9C39.8 102.2 37.9 102.6 36.1 102.9C33.1 103.3 30 103.6 26.9 103.9C25.3 104.1 23.8 104.3 22.2 104.4C17.5 104.7 12.7 104.9 8 104.9C6.2 104.9 4.5 104.9 2.7 104.8C0.999997 112.2 0.1 119.8 0 127.3C0 127.7 0 128 0 128.4V128.8C0 156.3 10.3 181.7 27.9 202.6C39.6 216.6 54.6 228.4 71.9 237.5C95.2 249.7 122.6 256.8 152 256.8C176.6 256.9 201 251.8 223.5 241.8C225.6 240.8 228.1 240.8 230.2 241.8L296.4 272.7L271.6 214.8C270.4 211.9 270.9 208.6 273 206.3C289.5 188.8 299.9 166.7 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM119.5 203.5C118 207.7 113.4 209.8 109.3 208.3C105.1 206.8 103 202.2 104.5 198.1L116.8 163.6L144.5 86.1002C145.6 82.9002 148.7 80.8002 152 80.8002C155.3 80.8002 158.4 82.9002 159.5 86.1002L193.7 181.7L199.5 198.1C201 202.3 198.8 206.8 194.7 208.3C190.5 209.8 186 207.6 184.5 203.5L174.9 176.5L172.1 168.8H132L129.2 176.5L119.5 203.5Z"
                                                                fill="black" />
                                                            <path d="M152 112.6L137.6 152.8H166.3L152 112.6Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <div class="text">
                                                        <p>
                                                            {{ !empty($que->answers) ? $que->answers : 'We will provide the answer to your question shortly!' }}
                                                        </p>
                                                        <span
                                                            class="user">{{ !empty($que->admin->name) ? $que->admin->name : '' }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if ($question->count() >= '4')
                                        <div class="text-center">
                                            <a href="javascript:void(0)" class="load-more-btn btn" data-ajax-popup="true"
                                                data-size="xs" data-title="Questions And Answers"
                                                data-url="{{ route('more_question', [$slug, $product->id]) }} "
                                                data-toggle="tooltip" title="{{ __('Questions And Answers') }}">
                                                {{ __('Load More') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($product->product_attribute != '')
                            <div id="3" class="tab-content ">
                                <div class="queary-div">
                                    <div class="container">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>{{ __('Additional Information about that Product..') }}</h4>
                                        </div><br>

                                        @foreach (json_decode($product->product_attribute) as $key => $choice_option)
                                            @php
                                                $value = implode(',', $choice_option->values);
                                                $idsArray = explode('|', $value);
                                                $get_datas = \App\Models\ProductAttributeOption::whereIn('id', $idsArray)
                                                    ->get()
                                                    ->pluck('terms')
                                                    ->toArray();

                                                $attribute_id = $choice_option->attribute_id;
                                                $visible_attribute = isset($choice_option->{'visible_attribute_' . $attribute_id}) ? $choice_option->{'visible_attribute_' . $attribute_id} : 0;
                                            @endphp
                                            @if ($visible_attribute == 1)
                                                <div class="row row-gap">
                                                    <div class="col-md-6 col-12">
                                                        <div class="pro-descrip-contente-left">
                                                            <div class="section-title">
                                                                <h6>{{ \App\Models\ProductAttribute::find($choice_option->attribute_id)->name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="pro-descrip-contente-right">
                                                            <div class="">
                                                                @foreach ($get_datas as $f)
                                                                    <div class="badge">
                                                                        {{ $f }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="best-product-section padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-12">
                        <div class="best-product-left-inner">
                            @php
                                $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text = '';
                                $homepage_header_1_key = array_search('homepage-listpage-2', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-banner-offer-label') {
                                            $contact_us_header_worktime = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                                            $contact_us_header_calling = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-blog-btn-text') {
                                            $contact_us_header_call = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}
                            <div class="section-title">
                                <h2>{!! $contact_us_header_worktime !!}</h2>
                            </div>
                            <p>{!! $contact_us_header_calling !!}</p>
                            <a href="{{ route('page.product-list',$slug) }}" class="btn"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10"
                                    fill="none">
                                    <path
                                        d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                        fill="white" />
                                </svg>{!! $contact_us_header_call !!}</a>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 col-12">
                        <div class="best-product-slider product-row">
                            @foreach ($bestSeller as $data)
                                @php
                                    $bestSeller_ids = hashidsencode($data->id);
                                @endphp
                                <div class="product-card">
                                    <div class="product-card-inner">
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
                                                        if (is_array($saleEnableArray) && in_array($data->id, $saleEnableArray)) {
                                                            $latestSales[$data->id] = [
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
                                        <div class="product-img">
                                            <a href="{{ route('page.product', [$slug,$bestSeller_ids]) }}">
                                                <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-content-top">
                                                <div
                                                    class="top-subtitle d-flex align-items-center justify-content-between">
                                                    <div class="subtitle">{{ $data->tag_api }}</div>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                            height="13" viewBox="0 0 13 13" fill="none">
                                                            <path
                                                                d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z"
                                                                fill="#5EA5DF" />
                                                            <path
                                                                d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z"
                                                                fill="#5EA5DF" />
                                                        </svg>{{ $data->default_variant_name }}</p>
                                                </div>
                                                <h5><a
                                                        href="{{ route('page.product', [$slug,$bestSeller_ids]) }}"><b>{{ $data->name }}</b></a>
                                                </h5>
                                                <p class="descriptions">{{ $data->description }}</p>
                                            </div>
                                           
                                            <div class="product-content-bottom">
                                                @if ($data->variant_product == 0)
                                                    <div class="price">
                                                        <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="javascript:void(0)"
                                                        class="btn-secondary  addtocart-btn-cart addcart-btn-globaly"
                                                        product_id="{{ $data->id }}"
                                                        variant_id="0" qty="1"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="10" viewBox="0 0 16 10" fill="none">
                                                            <path
                                                                d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                                                fill="white"></path>
                                                        </svg>{{ __('ADD TO CART') }}</a>

                                                        <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly"
                                                            product_id="{{ $data->id }}"
                                                            in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">
                                                            <span class="">
                                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                    style='color:aliceblue;'></i>
                                                            </span>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="slides-numbers">
                            <span class="active">01</span> / <span class="total"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection

@push('page-script')
<script src="{{ asset('public/js/flipdown.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var variants = [];
            $(".product_variatin_option").each(function(index, element) {
                variants.push(element.value);
            });
            if (variants.length > 0) {
                $('.product_orignal_price').hide();
                $('.product_final_price').hide();
                $('.min_max_price').show();
                $(".enable_option").hide();
                $('.currency-type').hide();
            }
            if (variants.length == 0) {
                $('.product_orignal_price').show();
                $('.product_final_price').show();
                $('.min_max_price').hide();
            }
        });
        $(document).on('change', '.product_variatin_option', function(e) {
            product_price();
        });

        $(document).on('click', '.change_price', function(e) {
            product_price();
        });

        function product_price() {
            var data = $('.variant_form').serialize();
            var data = data + '&product_id={{ $product->id }}';

            $.ajax({
                url: '{{ route('product.price', $slug) }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                context: this,

                success: function(response) {
                    $('.addcart-btn.addcart-btn-globaly').attr('variant_id', '0');
                    if (response.status == 'error') {
                        show_toastr('Error', response.message, 'error');
                        $('.quantity').val(response.qty);
                        $('.product_var_option').attr('variant_id', response.variant_id);
                    } else {
                        $('.product_final_price').html(response.original_price);
                        $('.currency').html(response.currency);
                        $('.currency-type').html(response.currency_name);
                        $('.product_orignal_price').html(response.product_original_price);
                        $('.product_tax_price').html(response.total_tax_price + ' ' + response.currency_name);
                        $('.addcart-btn.addcart-btn-globaly').attr('variant_id', response.variant_id);
                        $('.addcart-btn.addcart-btn-globaly').attr('qty', response.qty);
                        $(".enable_option").hide();
                        $('.product-variant-description').html(response.description);
                        if (response.enable_option_data == true) {
                            if (response.stock <= 0) {
                                $('.stock').parent().hide(); // Hide the parent container of the .stock element
                            } else {
                                $('.stock').html(response.stock);
                                $('.enable_option').show();
                            }
                        }
                        if (response.stock_status != '') {
                            if (response.stock_status == 'out_of_stock') {
                                $('.price-value').hide();
                                $('.variant_form').hide();
                                $('.price-wise-btn').hide();
                                $('.stock_status').show();
                                var message = '<span class=" mb-0"> Out of Stock.</span>';
                                $('.stock_status').html(message);

                            } else if (response.stock_status == 'on_backorder') {
                                $('.stock_status').show();
                                var message = '<span class=" mb-0">Available on backorder.</span>';
                                $('.stock_status').html(message);

                            } else {
                                $('.stock_status').hide();
                            }
                        }
                        if (response.variant_product == 1 && response.variant_id == 0) {
                            $('.product_orignal_price').hide();
                            $('.product_final_price').hide();
                            $('.min_max_price').show();
                            $('.product-price-amount').hide();
                            $('.product-price-error').show();
                            var message =
                                '<span class=" mb-0 text-danger"> This product is not available.</span>';
                            $('.product-price-error').html(message);
                        } else {
                            $('.product-price-error').hide();
                            $('.product_orignal_price').show();
                            $('.currency-type').show();
                            $('.product_final_price').show();
                            $('.product-price-amount').show();
                        }
                        if (response.product_original_price == 0 && response.original_price == 0) {
                            $('.product-price-amount').hide();
                            $('.variant_form').hide();
                            $('.price-wise-btn').hide();
                        }
                    }
                }
            });
        }
    </script>
     <script>
        $(".Question").on("click", function() {
            var url = $(this).data('url');
            if (!{{ \Auth::check() ? 'true' : 'false' }}) {
                var loginUrl = "{{ route('login', $slug) }}";
                var message = "Please login to continue"; // Your desired message
                window.location.href = loginUrl;
                return;
            }
        });

        $(document).ready(function() {
            $('.flipdown').hide();
            var start_date = $('.flash_sale_start_date').val();
            var end_date = $('.flash_sale_end_date').val();
            var start_time = $('.flash_sale_start_time').val();
            var end_time = $('.flash_sale_end_time').val();

            var startDates = new Date(start_date + ' ' + start_time);
            var startTimestamps = startDates.getTime();

            var endDates = new Date(end_date + ' ' + end_time);
            var endTimestamps = endDates.getTime();

            var timeRemaining = startDates - new Date().getTime();
            var endTimestamp = endTimestamps / 1000;

            setTimeout(function() {
                $('.flipdown').show();
                var flipdown = new FlipDown(endTimestamp, {
                        theme: 'dark'
                    }).start()
                    .ifEnded(() => {
                        $('.flipdown').hide();
                    });
            }, timeRemaining);
            $('.flipdown').hide();
            var ver = document.getElementById('ver');
        });
    </script>
@endpush
