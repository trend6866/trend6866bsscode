@extends('layouts.layouts')

@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection

@section('content')
    <div class="wrapper">
        <section class="product-page-section">
            <div class="container">
                <div class="top-row">
                    <a href="{{ route('page.product-list', $slug) }}" class="back-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"
                            fill="none">
                            <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765" />
                            <g clip-path="url(#clip0_318_284)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z"
                                    fill="white" />
                            </g>
                        </svg>
                        <span>{{ __(' Back to category') }}</span>
                    </a>
                        <a href="#" class="wishbtn wishbtn-globaly" product_id="{{ $p_name[0]->id }}"
                            in_wishlist="{{ $p_name[0]->in_whishlist ? 'remove' : 'add' }}">
                            {{ __('Add to wishlist') }}
                            <span class="wish-ic">
                                <i class="{{ $wishlist->isNotEmpty() ? 'fa fa-heart' : 'ti ti-heart' }}"></i>

                                <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type"
                                    value="{{ $wishlist->isNotEmpty() ? 'remove' : 'add' }}">
                            </span>
                        </a>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="slider-wrapper">
                                <div class="product-thumb-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-thumb-item">
                                            <div class="thumb-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="product">

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-main-slider lightbox">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-main-item">
                                            <div class="product-item-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="product">
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
                                <div class="border-with-custoim-arrow">
                                    <div class="customarrows">
                                        <div class="slick-prev1 fourth-left"><img
                                                src="{{ asset('themes/' . APP_THEME() . '/assets/images/arrow.png') }}">
                                        </div>
                                        <div class="slick-next1 fourth-right"><img
                                                src="{{ asset('themes/' . APP_THEME() . '/assets/images/right-arr.png') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="product-left-inner">
                                <div class="review-detail">

                                    <span>{{ $product->ProductData()->name }}</span>
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="ti ti-star {{ $i < $product->is_review ? 'text-warning' : '' }} "></i>
                                    @endfor
                                    <span><b>{{ $product->is_review }}/</b> 5.0</span>


                                </div>
                                <div class="section-title">
                                    <h2>
                                        {{ $product->name }} <br /> {{ $product->default_variant_name }}
                                    </h2>
                                    {{-- <div class="about-itm-datail">
                                        @if ($product->variant_id != 0)
                                            <b> {!! \App\Models\ProductStock::variantlist($product->variant_id) !!} </b>
                                        @endif
                                    </div> --}}
                                    <p class="product-variant-description">{{ $product->description }}
                                    </p>
                                </div>
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
                                <div class="count-price-wrp">
                                    <div class="count-left">
                                        <div class="price product-price-amount custom-output">
                                            <ins>
                                                <ins class="min_max_price" style="display: inline;">
                                                    {{ $currency_icon }}{{ $mi_price }} -
                                                    {{ $currency_icon }}{{ $ma_price }} </ins>
                                            </ins>
                                        </div>
                                        @if ($product->variant_product == 1)
                                            <h6 class="enable_option custom-output">
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
                                                <div class="prorow-lbl">
                                                    <div class="prorow-lbl-qntty">
                                                        <div class="product-page-section text-white">{{ __('quantity') }} :
                                                        </div>
                                                        <div class="qty-spinner">
                                                            <button type="button" class="quantity-decrement change_price">
                                                                <svg width="12" height="2" viewBox="0 0 12 2"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <input type="text" class="quantity"
                                                                data-cke-saved-name="quantity" name="qty" value="01"
                                                                min="01" max="100">

                                                            <button type="button" class="quantity-increment change_price">
                                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                                        fill="#61AFB3"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="prorow-lbl-color">
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
                                                                <div class="product-labl text-white">{{ $attribute->name }} :
                                                                </div>
                                                                @if ($variation_option == 1)
                                                                    <select
                                                                        class="light-select custom-select-btn product_variatin_option variant_loop"
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
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="count-right">
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
                                    </div>
                                </div>

                                <div class="price-div d-flex align-items-center">
                                    @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                    @else
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0)" class="btn theme-btn addcart-btn price-wise-btn product_var_option addcart-btn-globaly"
                                                product_id="{{ $product->id }}"
                                                variant_id="{{ $product->default_variant_id }}" qty="1">
                                                {{ __('Add to cart') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                    viewBox="0 0 14 16" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                        fill="#F2DFCE" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                        fill="#F2DFCE" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="price product-price-amount price-value d-flex align-items-center">
                                        <div>
                                            <span class="product_final_price text-white">{{ $currency_icon }}
                                                {{ $product->final_price }} </span>
                                            <span class="currency-type text-white">{{ $currency }}</span>

                                            <del class="product_orignal_price">{{ $product->original_price }}</del>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="client-logo-section product-page common-arrows padding-bottom">
            <div class="container">
                <div class="client-logo-slider">
                    @php
                        $homepage_logo = '';
                        $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_logo_key != '') {
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                        }
                    @endphp
                    @if (!empty($homepage_main_logo['homepage-logo-logo']))
                        @for ($i = 0; $i < count($homepage_main_logo['homepage-logo-logo']); $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                    if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                    if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                        if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                            $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#" tabindex="0">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                </a>
                            </div>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 6; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                    if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#" tabindex="0">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                                </a>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        @php
            $homepage_banner2 = '';
            $homepage_banner2_key = array_search('homepage-banner-2', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_banner2_key != '') {
                $homepage_main_banner2 = $theme_json[$homepage_banner2_key];
            }
            $homepage_banner1 = $homepage_banner2 = $homepage_banner3 = $homepage_banner4 = $homepage_banner5 = '';
        @endphp
        @for ($i = 0; $i < $homepage_main_banner2['loop_number']; $i++)
            @php
                foreach ($homepage_main_banner2['inner-list'] as $homepage_main_banner2_value) {
                    $homepage_banner_default_image = $homepage_main_banner2_value['field_default_text'];
                    if (!empty($homepage_main_banner2[$homepage_main_banner2_value['field_slug']])) {
                        if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 0) {
                            $homepage_banner1 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                        }
                        if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 1) {
                            $homepage_banner2 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                        }
                        if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 2) {
                            $homepage_banner3 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                        }
                        if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 3) {
                            $homepage_banner4 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                        }
                        if ($homepage_main_banner2_value['field_slug'] == 'homepage-banner-img' && $i == 4) {
                            $homepage_banner5 = $homepage_main_banner2[$homepage_main_banner2_value['field_slug']][$i]['field_prev_text'];
                        }
                    }
                }
            @endphp
        @endfor
        @php
            $homepage_banner1 = !empty($homepage_banner1) ? $homepage_banner1 : $homepage_banner_default_image;
            $homepage_banner2 = !empty($homepage_banner2) ? $homepage_banner2 : $homepage_banner_default_image;
            $homepage_banner3 = !empty($homepage_banner3) ? $homepage_banner3 : $homepage_banner_default_image;
            $homepage_banner4 = !empty($homepage_banner4) ? $homepage_banner4 : $homepage_banner_default_image;
            $homepage_banner5 = !empty($homepage_banner5) ? $homepage_banner5 : $homepage_banner_default_image;
        @endphp

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
                                <li class="tab-link on-tab-click active" data-tab="2"><a
                                        href="javascript:;">{{ __('Question & Answer') }}</a>
                                </li>
                                @if ($product->preview_content != '')
                                    <li class="tab-link on-tab-click" data-tab="1"><a
                                            href="javascript:;">{{ __('Video') }}</a>
                                    </li>
                                @endif
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


        <section class="pdp-place place-section product-page padding-bottom">
            <div class="row no-gutters justify-content-between align-items-center flex-dairection">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="place-left">
                        <img src="{{ get_file($homepage_banner1, APP_THEME()) }}" class="place-left-one" alt="">
                        <img src="{{ get_file($homepage_banner2, APP_THEME()) }}" class="place-left-two" alt="">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="place-section-center">
                        <div class="place-desc-titile">
                            <div class="section-title">
                                <span class="subtitle">{{ __('Description') }}:</span>
                            </div>
                            <p>{{ $product->description }}
                            </p>
                        </div>
                        @if ($product->variant_product == 1)
                            <div class="place-desc-titile">
                                <div class="section-title">
                                    <span class="subtitle">{{ __('MORE') }}:</span>
                                </div>
                                <div class="place-desc">
                                    <div class="place-desc-number">
                                        <span>{{ __('SKU') }}: @foreach ($product_stocks as $product_stock)
                                                <b>{{ $product_stock->sku }},</b>
                                            @endforeach
                                        </span>
                                        <span>{{ __('Category') }}: {{ $product->ProductData()->name }}</span>
                                    </div>
                                    <div class="place-desc-size">
                                        <span>{{ __('Size') }}:@foreach ($product_stocks as $product_stock)
                                                <b>{{ $product_stock->variant }},</b>
                                            @endforeach
                                        </span>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="place-right">
                        <div class="place-right-image">
                            <img src="{{ get_file($homepage_banner3, APP_THEME()) }}" class="" alt="">
                        </div>
                        <div class="place-right-image">
                            <img src="{{ get_file($homepage_banner4, APP_THEME()) }}" alt="">
                        </div>
                        <div class="place-right-image">
                            <img src="{{ get_file($homepage_banner5, APP_THEME()) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($product_review->isNotEmpty())
            <section class="testimonials-section product-page">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        @php
                            $homepage_testmonials_title = '';
                            $homepage_testmonials = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_testmonials != '') {
                                $homepage_testmonials_value = $theme_json[$homepage_testmonials];

                                foreach ($homepage_testmonials_value['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-testimonial-label-text') {
                                        $homepage_testmonials_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                        $homepage_testmonials_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                        $homepage_testmonials_sub = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                        $homepage_testmonials_btn = $value['field_default_text'];
                                    }

                                    //Dynamic
                                    if (!empty($homepage_testmonials_value[$value['field_slug']])) {
                                        if ($value['field_slug'] == 'homepage-testimonial-label-text') {
                                            $homepage_testmonials_title = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                            $homepage_testmonials_image = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                            $homepage_testmonials_sub = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                            $homepage_testmonials_btn = $homepage_testmonials_value[$value['field_slug']][$i];
                                        }
                                    }
                                }
                            }
                        @endphp
                        <div class="col-lg-4 col-md-5   col-12">
                            <div class="prodcut-card-heading">
                                <div class="section-title">
                                    <span class="subtitle">{{ $homepage_testmonials_title }}</span>
                                    <h2>
                                        {{ $homepage_testmonials_text }}
                                    </h2>
                                    <p>{{ $homepage_testmonials_sub }}
                                    </p>
                                    <a href="#" class="btn" tabindex="0">
                                        {{ $homepage_testmonials_btn }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="13"
                                            viewBox="0 0 17 13" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.50042 10.6026C11.6248 10.6026 13.8466 8.63934 15.1477 7.00428C15.599 6.43718 15.599 5.68012 15.1477 5.11301C13.8466 3.47795 11.6248 1.51466 8.50042 1.51466C5.37605 1.51466 3.15427 3.47795 1.85313 5.11301C1.40184 5.68012 1.40184 6.43718 1.85313 7.00428C3.15427 8.63934 5.37605 10.6026 8.50042 10.6026ZM16.3329 7.94743C17.2235 6.82829 17.2235 5.289 16.3329 4.16986C14.918 2.39185 12.3072 0 8.50042 0C4.69367 0 2.08284 2.39185 0.66794 4.16986C-0.222646 5.289 -0.222647 6.82829 0.66794 7.94743C2.08284 9.72545 4.69367 12.1173 8.50042 12.1173C12.3072 12.1173 14.918 9.72545 16.3329 7.94743Z"
                                                fill="#12131A"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.0127 6.05862C10.0127 6.89514 9.3346 7.57328 8.49807 7.57328C7.66155 7.57328 6.98341 6.89514 6.98341 6.05862C6.98341 6.03712 6.98386 6.01573 6.98475 5.99445C7.10281 6.03601 7.2298 6.05862 7.36208 6.05862C7.98947 6.05862 8.49807 5.55002 8.49807 4.92262C8.49807 4.79035 8.47546 4.66335 8.4339 4.54529C8.45518 4.54441 8.47658 4.54396 8.49807 4.54396C9.3346 4.54396 10.0127 5.2221 10.0127 6.05862ZM11.5274 6.05862C11.5274 7.73167 10.1711 9.08794 8.49807 9.08794C6.82502 9.08794 5.46875 7.73167 5.46875 6.05862C5.46875 4.38557 6.82502 3.0293 8.49807 3.0293C10.1711 3.0293 11.5274 4.38557 11.5274 6.05862Z"
                                                fill="#12131A"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7   col-12">
                            <div class="testimonials-card-slider">
                                @foreach ($product_review as $review)
                                    <div class="testimonials-itm">
                                        <div class="testimonials-inner">

                                            <div class="testimonials-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="31"
                                                    viewBox="0 0 50 31" fill="none">
                                                    <path
                                                        d="M0.367188 30.7175L10.7942 0H26.153L17.8395 30.7175H0.367188ZM23.8985 30.7175L34.3256 0H49.5434L41.3709 30.7175H23.8985Z"
                                                        fill="#CAD5D7" />
                                                </svg>
                                                <h3>
                                                    {{ $review->title }}
                                                </h3>
                                                <p>{{ $review->description }}
                                                </p>
                                                <div class="client-detail d-flex align-items-center">
                                                    <span
                                                        class="clienttitle">{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},
                                                        <b>Client</b></span>
                                                    <div class="clientstrs d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                        @endfor
                                                        <span><b>{{ $review->rating_no }}/</b> 5.0</span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-img-wrapper">
                                                <img src="{{ get_file($review->ProductData->cover_image_path, APP_THEME()) }}"
                                                    class="default-img">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <section class="bestseller-card product-page padding-top padding-bottom">
            <div class="container">
                @php
                    $homepage_bestseller_title = '';
                    $homepage_bestseller = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_bestseller != '') {
                        $homepage_bestseller_value = $theme_json[$homepage_bestseller];

                        foreach ($homepage_bestseller_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-label-text') {
                                $homepage_bestseller_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $homepage_bestseller_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                $homepage_bestseller_btn = $value['field_default_text'];
                            }

                            //Dynamic
                            if (!empty($homepage_bestseller_value[$value['field_slug']])) {
                                if ($value['field_slug'] == 'homepage-bestseller-label-text') {
                                    $homepage_bestseller_title = $homepage_bestseller_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                    $homepage_bestseller_text = $homepage_bestseller_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                    $homepage_bestseller_btn = $homepage_bestseller_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp
                <div class="home-card-slider-heading">
                    <div class="section-title">
                        <span class="subtitle">{{ $homepage_bestseller_title }}</span>
                        <h2>
                            {{ $homepage_bestseller_text }}
                        </h2>
                    </div>
                    <div class="section-title-btn">
                        <a href="product.html" class="btn" tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.9 4.2C11.0598 4.2 12 3.2598 12 2.1C12 0.940202 11.0598 0 9.9 0C8.7402 0 7.8 0.940202 7.8 2.1C7.8 3.2598 8.7402 4.2 9.9 4.2ZM9.9 3C9.40294 3 9 2.59706 9 2.1C9 1.60294 9.40294 1.2 9.9 1.2C10.3971 1.2 10.8 1.60294 10.8 2.1C10.8 2.59706 10.3971 3 9.9 3ZM2.57574 11.8241C2.81005 12.0584 3.18995 12.0584 3.42426 11.8241C3.65858 11.5898 3.65858 11.2099 3.42426 10.9756L2.64853 10.1999L3.42417 9.42421C3.65849 9.18989 3.65849 8.81 3.42417 8.57568C3.18986 8.34137 2.80996 8.34137 2.57564 8.57568L1.8 9.35133L1.02436 8.57568C0.790041 8.34137 0.410142 8.34137 0.175827 8.57568C-0.0584871 8.81 -0.0584871 9.18989 0.175827 9.42421L0.951472 10.1999L0.175736 10.9756C-0.0585786 11.2099 -0.0585786 11.5898 0.175736 11.8241C0.410051 12.0584 0.789949 12.0584 1.02426 11.8241L1.8 11.0484L2.57574 11.8241ZM3.22027 0.197928C3.10542 0.07071 2.94164 -0.00131571 2.77025 1.8239e-05C2.59886 0.00135223 2.43623 0.0759186 2.32337 0.204908L0.748444 2.00491C0.530241 2.2543 0.555521 2.63335 0.804908 2.85156C1.0543 3.06976 1.43335 3.04448 1.65156 2.79509L2.17492 2.19693V2.58746C2.17492 5.1349 4.24003 7.2 6.78746 7.2C8.67215 7.2 10.2 8.72785 10.2 10.6125V11.4C10.2 11.7314 10.4686 12 10.8 12C11.1314 12 11.4 11.7314 11.4 11.4V10.6125C11.4 8.0651 9.3349 6 6.78746 6C4.90277 6 3.37492 4.47215 3.37492 2.58746V2.15994L3.95465 2.80207C4.17671 3.04803 4.55611 3.06741 4.80207 2.84535C5.04803 2.62329 5.06741 2.24389 4.84535 1.99793L3.22027 0.197928Z"
                                    fill="black"></path>
                            </svg>
                            {{ $homepage_bestseller_btn }}
                        </a>
                    </div>
                </div>
                <div class="bestseller-card-slider">
                    @foreach ($bestSeller as $best)
                        <div class="seller-slider-inner">
                            <div class="bestseller-card-bg">
                                <div class="product-content">
                                    <div class="product-content-top long_sting_to_dot">
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
                                                        if (is_array($saleEnableArray) && in_array($best->id, $saleEnableArray)) {
                                                            $latestSales[$best->id] = [
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
                                        <h3 class="product-title">
                                            <a href="#">
                                                {{ $best->name }} {{ $best->default_variant_name }}
                                            </a>
                                        </h3>
                                        {{-- <div class="product-card-itm-datail">
                                            @if ($best->variant_id != 0)
                                            <b>  {!! \App\Models\ProductStock::variantlist($best->variant_id) !!} </b>
                                        @endif
                                        </div> --}}
                                    </div>
                                    <div class="product-content-bottom">
                                        @if ($best->variant_product == 0)
                                            <div class="price">
                                                <ins>{{ $currency_icon }} {{ $best->final_price }}</ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="javascript:void(0)" class="btn btn-secondary addcart-btn-globaly"
                                            product_id="{{ $best->id }}" variant_id="0" qty="1">
                                            {{ __('Add to cart') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="seller-product-card-image">
                                    <a href="#">
                                        <img src="{{ get_file($best->cover_image_path, APP_THEME()) }}"
                                            class="default-img">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="border-with-custoim-arrow">
                    <div class="customarrows">
                        <div class="slick-prev1 third-left"><img
                                src="{{ asset('themes/' . APP_THEME() . '/assets/img/arrow.png') }}"></div>
                        <div class="slick-next1 third-right"><img
                                src="{{ asset('themes/' . APP_THEME() . '/assets/img/right-arr.png') }}"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog-section product-page padding-top padding-bottom">
            <div class="container">
                @php
                    $homepage_blog_title = '';
                    $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_blog != '') {
                        $homepage_blog_value = $theme_json[$homepage_blog];

                        foreach ($homepage_blog_value['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $homepage_blog_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_blog_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_blog_sub_text = $value['field_default_text'];
                            }

                            //Dynamic
                            if (!empty($homepage_blog_value[$value['field_slug']])) {
                                if ($value['field_slug'] == 'homepage-blog-label-text') {
                                    $homepage_blog_title = $homepage_blog_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-blog-title-text') {
                                    $homepage_blog_text = $homepage_blog_value[$value['field_slug']][$i];
                                }
                                if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                    $homepage_blog_sub_text = $homepage_blog_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="prodcut-card-heading">
                            <div class="section-title">
                                <span class="subtitle">{{ $homepage_blog_title }}</span>
                                {{-- <h2> --}}
                                {!! $homepage_blog_text !!}
                                {{-- </h2> --}}
                                <p>{{ $homepage_blog_sub_text }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                        {!! \App\Models\Blog::HomePageBlog($slug, 10) !!}
                    </div>
                </div>
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
