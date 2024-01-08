@extends('layouts.layouts')

@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection

@section('content')

    <div class="wrapper">
        @foreach ($products as $product)
            <section class="pdp-section padding-top padding-bottom">
                <div class="container">
                    <div class="common-banner-content">
                        <a href="{{ route('page.product-list', $slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                        fill="white"></path>
                                </svg>
                            </span>
                            {{ __('Back to Categories') }}
                        </a>
                    </div>
                    <div class="row col-reverse">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="review-star">
                                <div class="subtitle">{{ $product->tag_api }}</div>
                                {!! \App\Models\Review::ProductReview(1, $product->id) !!}
                            </div>
                            <div class="section-title">
                                <h2>{!! $product->name !!}</h2>
                            </div>
                            <p class="product-variant-description">{{ $product->description }}
                                <p class="price product-price-amount">
                                    <ins>
                                        <ins class="min_max_price" style="display: inline;">
                                            {{ $currency_icon }}{{ $mi_price }} -
                                            {{ $currency_icon }}{{ $ma_price }} </ins>
                                    </ins>
                                </p>
                            </p><br>
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
                            @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                            @else
                                <form class="variant_form w-100">
                                    @if ($product->variant_product == 1)
                                        <div class="radio-buttons">
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

                                                <div class="product-labl  mb-0 inline_lable">{{ $attribute->name }}</div>
                                                <div class="inline_contant">
                                                    @if ($variation_option == 1)
                                                        <select class="custom-select-btn product_variatin_option variant_loop radio-btn"
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
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="product-labl  mb-0 inline_lable">{{ 'Quantity' }}</div>
                                    <div class="inline_contant">
                                        <div class="qty-spinners ">
                                            <button type="button" class="quantity-decrement change_price ">
                                                <svg width="12" height="2" viewBox="0 0 12 2"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 0.251343V1.74871H12V0.251343H0Z" class="btn_cust"></path>
                                                </svg>
                                            </button>
                                            <input type="text" class="quantity qty_cust" data-cke-saved-name="quantity"
                                                name="qty" value="01" min="01" max="100">
                                            <button type="button" class="quantity-increment change_price ">
                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                        class="btn_cust"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <div class="pdp-cart-btn-wrp">
                                <div class="price">
                                    <ins>
                                        <span class="product_final_price"> {{ $product->final_price }} </span>
                                        <span class="currency-type">{{ $currency }}</span>
                                    </ins>
                                </div>

                                <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly"
                                    product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                    qty="1">
                                    {{ __('Add to cart') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14" height="16"
                                        viewBox="0 0 14 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                            fill="#0A062D"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                            fill="#0A062D"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 pdp-left-col">
                            <div class="pdp-left-inner-sliders">
                                <div class="main-slider-wrp">
                                    <div class="pdp-main-slider lightbox">
                                        @foreach ($product->Sub_image($product->id)['data'] as $item)
                                            <div class="pdp-main-slider-itm">
                                                <div class="pdp-main-img">
                                                    <a href="#" class="pdp-slider-img">
                                                        {{-- <img src="assets/images/Gift-Mockup-slider.png"> --}}
                                                        <img src="{{ get_file($item->image_path, APP_THEME()) }}"> </a>
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
                                                        <a href="{{ get_file($item->image_path, APP_THEME()) }}"
                                                            data-caption="Caption 1" class="open-lightbox">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                height="25" viewBox="0 0 25 25" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z"
                                                                    fill="white" />
                                                            </svg>
                                                        </a>
                                                    <div class="pdp-wishlist">
                                                        <div class="wishlist favorite-icon">
                                                            <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly"
                                                                product_id="{{ $product->id }}"
                                                                in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                                                {{ __('Add to wishlist') }}
                                                                <span class="wish-ic">
                                                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                                        style='color: white'></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="pdp-thumb-slider">
                                @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="pdp-thumb-slider-itm">
                                        <div class="pdp-thumb-img">
                                            <img src="{{ get_file($item->image_path, APP_THEME()) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider-navgation">
                                <div class="slider-nav"></div>
                                <span class="pagingInfo-pdp"></span>
                                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <span class="slider__label sr-only">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        @if ($random_review->isNotEmpty())
            <section class="pdp-client-review-section padding-bottom padding-top">
                <div class="container">
                    <div class="pdp-reiview-slider flex-slider">
                        @foreach ($random_review as $review)
                            <div class="review-itm">
                                {{-- @dd($review) --}}
                                <div class="review-inner">
                                    <div class="review-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="cauma" width="13"
                                            height="10" viewBox="0 0 13 10" fill="none">
                                            <path
                                                d="M6.01356 1.12356L3.97535 4.8505L2.691 5.20675C2.83991 4.93271 3.00743 4.71348 3.19357 4.54906C3.37971 4.36636 3.59377 4.27502 3.83575 4.27502C4.37555 4.27502 4.85951 4.49425 5.28763 4.93271C5.73436 5.35291 5.95772 5.90099 5.95772 6.57695C5.95772 7.28945 5.70644 7.90148 5.20386 8.41302C4.7199 8.92456 4.11496 9.18033 3.38902 9.18033C2.70031 9.18033 2.09536 8.93369 1.57417 8.44042C1.0716 7.92888 0.820312 7.30772 0.820312 6.57695C0.820312 6.28464 0.876154 5.94666 0.987837 5.563C1.11813 5.17935 1.35081 4.67694 1.68585 4.05579L3.91951 0L6.01356 1.12356ZM12.2957 1.12356L10.2575 4.8505L9.00108 5.20675C9.13138 4.93271 9.28959 4.71348 9.47573 4.54906C9.68048 4.36636 9.89454 4.27502 10.1179 4.27502C10.6577 4.27502 11.151 4.49425 11.5977 4.93271C12.0444 5.35291 12.2678 5.90099 12.2678 6.57695C12.2678 7.28945 12.0165 7.90148 11.5139 8.41302C11.03 8.92456 10.425 9.18033 9.6991 9.18033C9.01039 9.18033 8.40544 8.93369 7.88425 8.44042C7.38168 7.92888 7.13039 7.30772 7.13039 6.57695C7.13039 6.28464 7.18623 5.94666 7.29792 5.563C7.4096 5.17935 7.63296 4.67694 7.96801 4.05579L10.2296 0L12.2957 1.12356Z"
                                                fill="#5FFFCA"></path>
                                        </svg>
                                        <h6>{{ $review->title }}</h6>
                                        <span><b>John Doe,</b> Client</span>
                                    </div>
                                    <div class="review-img">
                                        <img
                                            src="{{ asset('themes/' . APP_THEME() . '/assets/images/testimonials-user.png') }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- tab section  --}}
        <section class="tab-vid-section padding-top">
            <div class="container">
                <div class="tabs-wrapper">
                    <div class="blog-head-row tab-nav d-flex justify-content-between">
                        <div class="blog-col-left ">
                            <ul class="d-flex tabs">
                                {{-- <li class="tab-link on-tab-click active" data-tab="0"><a
                                        href="javascript:;">{{ __('Description') }}</a>
                                </li> --}}
                                @if ($product->preview_content != '')
                                    <li class="tab-link on-tab-click" data-tab="1"><a
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

                        <div id="2" class="tab-content ">
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

        <section class="pdp-page review-section padding-bottom padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-review', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-review-title-text') {
                                $review_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-review-sub-text') {
                                $review_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-review-img') {
                                $cat_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
            {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}
            <div class="row align-items-center col-reverse">
                    <div class="col-md-6 col-12">
                        <div class="left-review-wrapper">
                            <div class="section-title">
                                <h2>{!! $review_title !!}</h2>
                            </div>
                            <p>{{$review_text}}</p>
                            <div class="reiview-slider flex-slider">
                                @foreach ($random_review as $review)
                                <div class="review-itm">
                                    <div class="review-inner">
                                        <div class="review-img">
                                            <img src="{{asset('themes/'.APP_THEME().'/assets/images/review1.png')}}" alt="">
                                        </div>
                                        <div class="review-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="cauma" width="13" height="10" viewBox="0 0 13 10" fill="none">
                                                <path d="M6.01356 1.12356L3.97535 4.8505L2.691 5.20675C2.83991 4.93271 3.00743 4.71348 3.19357 4.54906C3.37971 4.36636 3.59377 4.27502 3.83575 4.27502C4.37555 4.27502 4.85951 4.49425 5.28763 4.93271C5.73436 5.35291 5.95772 5.90099 5.95772 6.57695C5.95772 7.28945 5.70644 7.90148 5.20386 8.41302C4.7199 8.92456 4.11496 9.18033 3.38902 9.18033C2.70031 9.18033 2.09536 8.93369 1.57417 8.44042C1.0716 7.92888 0.820312 7.30772 0.820312 6.57695C0.820312 6.28464 0.876154 5.94666 0.987837 5.563C1.11813 5.17935 1.35081 4.67694 1.68585 4.05579L3.91951 0L6.01356 1.12356ZM12.2957 1.12356L10.2575 4.8505L9.00108 5.20675C9.13138 4.93271 9.28959 4.71348 9.47573 4.54906C9.68048 4.36636 9.89454 4.27502 10.1179 4.27502C10.6577 4.27502 11.151 4.49425 11.5977 4.93271C12.0444 5.35291 12.2678 5.90099 12.2678 6.57695C12.2678 7.28945 12.0165 7.90148 11.5139 8.41302C11.03 8.92456 10.425 9.18033 9.6991 9.18033C9.01039 9.18033 8.40544 8.93369 7.88425 8.44042C7.38168 7.92888 7.13039 7.30772 7.13039 6.57695C7.13039 6.28464 7.18623 5.94666 7.29792 5.563C7.4096 5.17935 7.63296 4.67694 7.96801 4.05579L10.2296 0L12.2957 1.12356Z" fill="#5FFFCA"></path>
                                            </svg>
                                            <h6>{{$review->title}}</h6>
                                            <span><b>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }},</b> Client</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="right-review-wrapper">
                            <img src="{{asset('themes/'.APP_THEME().'/assets/img/review-main.png')}}" alt="">
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
            </div>
            </section>

        <section class="bestseller-section padding-bottom">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                        $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-products-title-text') {
                                    $feature_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-feature-products-btn-text') {
                                    $feature_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title-left">
                            <h2>{!! $feature_title !!}</h2>
                        </div>
                        <a href="{{ route('page.product-list', $slug) }}" class="btn" tabindex="0">
                            {{ $feature_btn }}
                        </a>
                    @endif
                </div>
                <div class="bestseller-slider flex-slider">
                    @foreach ($bestSeller as $bestSellers)
                        @php
                            $p_id = hashidsencode($bestSellers->id);
                        @endphp
                        <div class="bestseller-card-itm product-card">
                            <div class="bestseller-card-inner">
                                <div class="bestseller-img">
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}">
                                        <img src="{{ get_file($bestSellers->cover_image_path, APP_THEME()) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="bestseller-content">
                                    <div class="bestseller-top">
                                        <div class="bestseller-card-heading">
                                            <span>{{ $bestSellers->tag_api }}</span>
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
                                                <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly"
                                                    product_id="{{ $bestSellers->id }}"
                                                    in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add' }}">
                                                    {{ __('Add to wishlist') }}
                                                    <span class="wish-ic">
                                                        <i
                                                            class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </span>
                                                </a>
                                        </div>
                                        <h3>
                                            <a href="{{ route('page.product', [$slug, $p_id]) }}" class="description">
                                                {!! $bestSellers->name !!}
                                            </a>
                                        </h3>
                                        </a>
                                        <p class="descriptions">{{ $bestSellers->description }}</p>
                                    </div>
                                    <div class="bestseller-bottom">

                                        @if ($bestSellers->variant_product == 0)
                                            <div class="price">
                                                <ins>{{$bestSellers->final_price}}</ins>
                                                <span>{{$currency}}</span>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="#" class="btn addcart-btn-globaly" type="submit"
                                            product_id="{{ $bestSellers->id }}"
                                            variant_id="0" qty="1">
                                            {{ __('Add to Cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14"
                                                height="16" viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z"
                                                    fill="#0A062D"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z"
                                                    fill="#0A062D"></path>
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

        <section class="pdp-page testimonials-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                $testimonial_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="section-title">
                        <h2>
                            {{ $testimonial_title }}
                        </h2>
                    </div>
                @endif
                <div class="testimonials-slider flex-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonials-itm">
                            <div class="testimonials-itm-inner">
                                <div class="testimonials-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="42"
                                        viewBox="0 0 52 42" fill="none">
                                        <path
                                            d="M23.5328 5.1403L14.2968 22.191L8.47689 23.8209C9.15166 22.5672 9.91079 21.5642 10.7543 20.8119C11.5977 19.9761 12.5677 19.5582 13.6642 19.5582C16.1103 19.5582 18.3033 20.5612 20.2433 22.5672C22.2676 24.4896 23.2798 26.997 23.2798 30.0896C23.2798 33.3493 22.1411 36.1493 19.8637 38.4896C17.6707 40.8299 14.9294 42 11.6399 42C8.51906 42 5.77778 40.8716 3.41606 38.6149C1.13869 36.2746 0 33.4328 0 30.0896C0 28.7522 0.253041 27.206 0.759124 25.4507C1.34955 23.6955 2.40389 21.397 3.92214 18.5552L14.0438 0L23.5328 5.1403ZM52 5.1403L42.764 22.191L37.0706 23.8209C37.661 22.5672 38.3779 21.5642 39.2214 20.8119C40.1492 19.9761 41.1192 19.5582 42.1314 19.5582C44.5775 19.5582 46.8127 20.5612 48.837 22.5672C50.8613 24.4896 51.8735 26.997 51.8735 30.0896C51.8735 33.3493 50.7348 36.1493 48.4574 38.4896C46.2644 40.8299 43.5231 42 40.2336 42C37.1127 42 34.3715 40.8716 32.0097 38.6149C29.7324 36.2746 28.5937 33.4328 28.5937 30.0896C28.5937 28.7522 28.8467 27.206 29.3528 25.4507C29.8589 23.6955 30.871 21.397 32.3893 18.5552L42.6375 0L52 5.1403Z"
                                            fill="#EE9FB4" />
                                    </svg>
                                </div>
                                <div class="testimonials-content">
                                    <div class="testimonials-content-top">
                                        <h3>{{ $review->title }}</h3>
                                        <p>{{ $review->description }}</p>
                                    </div>
                                    <div class="testimonials-content-bottom">
                                        <div class="testimonials-user">
                                            <div class="testimonials-user-img">
                                                <img
                                                    src="{{ asset('themes/' . APP_THEME() . '/assets/images/testimonials-user.png') }}">
                                            </div>
                                            <div class="testimonials-user-content">
                                                <div class="testimonilas-star">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i
                                                            class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                    @endfor
                                                    <span><b>{{ $review->rating_no }}</b> / 5.0</span>
                                                </div>
                                                <div class="testimonials-user-name">
                                                    <h6>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="subscribe-section">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                $news_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                $news_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-description') {
                                $news_desc = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                    <div class="row align-items-center">
                        <div class="col-md-6 col-12">
                            <div class="subscribe-column">
                                <div class="section-title">
                                    <h2>{!! $news_title !!}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="subscribe-section-form">
                                <p>{{ $news_text }}</p>
                                <form class="footer-subscribe-form" action="{{ route('newsletter.store', $slug) }}"
                                    method="post">
                                    @csrf
                                    <div class="input-wrapper">
                                        <input type="email" placeholder="Type your address email..." name="email">
                                        <button type="submit" class="btn-subscibe">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                viewBox="0 0 17 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.9595 9.00095C14.2361 8.72433 14.2361 8.27584 13.9595 7.99921L9.70953 3.74921C9.43291 3.47259 8.98441 3.47259 8.70779 3.74921C8.43117 4.02584 8.43117 4.47433 8.70779 4.75095L12.4569 8.50008L8.70779 12.2492C8.43117 12.5258 8.43117 12.9743 8.70779 13.2509C8.98441 13.5276 9.4329 13.5276 9.70953 13.2509L13.9595 9.00095ZM4.04286 13.2509L8.29286 9.00095C8.56948 8.72433 8.56948 8.27584 8.29286 7.99921L4.04286 3.74921C3.76624 3.47259 3.31775 3.47259 3.04113 3.74921C2.7645 4.02583 2.7645 4.47433 3.04113 4.75095L6.79026 8.50008L3.04112 12.2492C2.7645 12.5258 2.7645 12.9743 3.04112 13.2509C3.31775 13.5276 3.76624 13.5276 4.04286 13.2509Z"
                                                    fill="#0A062D"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                {{-- <div class="checkbox-custom"> --}}
                                {{-- <input type="checkbox" class="" id="subsection"> --}}
                                <label for="subsection">{{ $news_desc }}</label>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

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
