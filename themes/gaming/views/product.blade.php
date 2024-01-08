@extends('layouts.layouts')

@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection

@section('content')

    <div class="home-wrapper">
        <section class="product-main-section pro-main-sec">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/design-circle-2.png') }}" class="design-circle-2"
                alt="image">
            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/design-circle-1.png') }}" class="design-circle-1"
                alt="image">
            <div class="container">
                <div class="section-title-inner">
                    <a href="{{ route('page.product-list', $slug) }}" class="back-btn">
                        <span class="svg-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                fill="white">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                    fill="white"></path>
                            </svg>
                        </span>
                        {{ __('Back to category') }}
                    </a>
                </div>
                @foreach ($products as $product)
                    @php
                        $description = json_decode($product->other_description);
                        foreach ($description as $k => $value) {
                            $value = json_decode(json_encode($value), true);

                            foreach ($value['inner-list'] as $description_val) {
                                if ($description_val['field_slug'] == 'product-other-description-other-description') {
                                    $description_value = !empty($description_val['value']) ? $description_val['value'] : $description_val['field_default_text'];
                                }
                                if ($description_val['field_slug'] == 'product-other-description-other-description-image') {
                                    $description_img = !empty($description_val['image_path']) ? $description_val['image_path'] : '';
                                }
                                if ($description_val['field_slug'] == 'product-other-description-more-informations') {
                                    $more_description_value = !empty($description_val['value']) ? $description_val['value'] : $description_val['field_default_text'];
                                }
                                if ($description_val['field_slug'] == 'product-other-description-more-information-image') {
                                    $more_description_img = !empty($description_val['image_path']) ? $description_val['image_path'] : '';
                                }
                            }
                        }
                    @endphp

                    {{-- @dD($product) --}}
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="product-left-inner">
                                <div class="pro-top-row">
                                    <span class="slide-label">{{ $product->tag_api }}</span>

                                        <a href="javascript:void(0)" class="wishbtn wishbtn-globaly"
                                            product_id="{{ $product->id }}"
                                            in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                            <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                            <span>Add to wishlist</span>
                                        </a>
                                    <div class="pro-star d-flex align-items-center">
                                        {!! \App\Models\Review::ProductReview(1, $product->id) !!}
                                    </div>
                                </div>
                                <div class="common-heading">
                                    <h2>{{ $product->name }}
                                    </h2>
                                    <p class="product-variant-description">{{ $product->description }}</p>
                                    <div class="price product-price-amount">
                                        <ins>
                                            <ins class="min_max_price" style="display: inline;">
                                                {{ $currency_icon }}{{ $mi_price }} -
                                                {{ $currency_icon }}{{ $ma_price }} </ins>
                                        </ins>
                                    </div>
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
                                    <div class="size-selectors dark-doted d-flex align-items-center">
                                        <form class="variant_form w-100">
                                            @csrf
                                            @if ($product->variant_product == 1)
                                                <div class="size-select d-flex mb-5">
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
                                                            <div class="product-labl mb-0 inline_lable">{{ $attribute->name }}:
                                                            </div>

                                                            <div class="inline_contant">
                                                                <select class="col custom-select-btn product_variatin_option variant_loop"
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
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="size-variant-swatch d-flex" style="margin-top: 20px;">
                                                <p class="product-labl inline_lable">{{ __('Quantity') }} : &nbsp;</p>
                                                <div class="inline_contant">
                                                    <div class="qty-spinners">
                                                        <button type="button" class="quantity-decrement change_price">
                                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <input type="text" class="quantity" data-cke-saved-name="quantity"
                                                            name="qty" value="01" min="01" max="100">
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
                                            </div>
                                        </form>
                                    </div>
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
                                <div class="product-content-bottom d-flex align-items-center justify-content-between"
                                    style="margin-top: 15px;">
                                    <div class="price product-price-amount price-value">
                                        <ins
                                            class="product_final_price">{{ $product->final_price }}{{ $currency }}</ins>&nbsp;
                                        <span class=" currency-type">{{ $currency }}</span>
                                    </div>
                                    @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                    @else
                                        <a href="javascript:void(0)" class="btn-primary addcart-btn add-cart-btn addcart-btn-globaly"
                                            product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                            qty="1">
                                            {{ __('Add to cart') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
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
                        <div class="col-md-6 col-12">
                            <div class="slider-wrapper">
                                <div class="product-thumb-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-thumb-item">
                                            <div class="thumb-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}"
                                                    alt="product-img">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-main-slider lightbox">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-main-item">
                                            <div class="product-item-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="">
                                                @foreach ($latestSales as $productId => $saleData)
                                                    <div class="custom-output sale-tag-product">
                                                        <div class="sale_tag_icon rounded col-1 onsale">
                                                            <div>{{ __('Sale!') }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <a href="{{ get_file($item->image_path, APP_THEME()) }}"
                                                    data-caption="Caption 1" class="open-lightbox ">
                                                    <div class="img-prew-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="20" viewBox="0 0 25 25" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z"
                                                                fill="white" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="tab-vid-section padding-top">
            <div class="container">
                <div class="tabs-wrapper">
                    <div class="blog-head-row tab-nav d-flex justify-content-between">
                        <div class="blog-col-left ">
                            <ul class="d-flex tabs">
                                <li class="tab-link on-tab-click active" data-tab="0"><a
                                        href="javascript:;">{{ __('Description') }}</a>
                                </li>
                                @if ($product->preview_content != '')
                                    <li class="tab-link on-tab-click" data-tab="1"><a
                                            href="javascript:;">{{ __('Video') }}</a>
                                    </li>
                                @endif
                                <li class="tab-link on-tab-click" data-tab="2"><a
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
                        <div id="0" class="tab-content active">

                            <section class="product-description-section padding-top padding-bottom">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5 col-12">
                                            <div class="pro-descrip-left">
                                                <h2>{{ __('Description:') }}</h2>
                                                <p>{!! $more_description_value !!}</p>
                                            </div>
                                        </div>
                                        @if ($product->variant_product == 1)
                                            <div class="col-md-7 col-12">
                                                <div class="pro-descrip-right">
                                                    <h2>{{ 'More informations' }}</h2>
                                                    <ul class="">
                                                        @if ($product->variant_product == 1)
                                                            <li class="">
                                                                <span>{{ __('SKU:') }} @foreach ($product_stocks as $product_stock)
                                                                        <b>{{ $product_stock->sku }},</b>
                                                                    @endforeach
                                                                </span>
                                                                <span>{{ __('Category:') }}@foreach ($product_stocks as $product_stock)
                                                                        <b>{{ $product_stock->variant }},</b>
                                                                    @endforeach
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </section>
                        </div>
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
                                                            <div class="badge-wrapper">
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


        <section class="product-tab-section padding-bottom tabs-wrapper">
            <div class="full-container">
                <div class="d-flex align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 pro-tab-left">
                        <div class="left-column-img">
                            <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/product-cpu.png') }}"
                                class="cpu-left" alt="image">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 pro-tab-center">
                        <ul class="cat-tab tabs product-tab">
                            @foreach ($MainCategoryList as $cat_key => $category)
                                <li class="tab-link {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 pro-tab-right">
                        <div class="tabs-container">
                            @foreach ($MainCategoryList as $cat_k => $category)
                                <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                                    <div class="product-img-list">
                                        @foreach ($MainCategoryList as $CategoryList)
                                            @if ($CategoryList->id == $category->id)
                                                <div class="product-tab-img">
                                                    <img src="{{ get_file($CategoryList->image_path, APP_THEME()) }}"
                                                        class="product-img" alt="image">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- {!! \App\Models\Product::ProductPageCategory() !!} --}}

        </section>

        <section class="testimonials-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                $test_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                $test_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                $test_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div class="section-title-left">
                        <h2>{{ $test_title }}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{ $test_text }}</p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{ route('page.product-list', $slug) }}" class="btn-primary btn-transparent">
                            {{ $test_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                                fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                {{-- @endif --}}
                <div class="testimonial-slider common-arrows">
                    @foreach ($reviews as $review)
                        <div class="testimonial-itm">
                            <div class="testimonial-itm-inner">
                                <div class="testimonial-itm-image">
                                    <a href="#" tabindex="0">
                                        <img src="{{ asset('/' . !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path, APP_THEME()) : '') }}"
                                            class="default-img" alt="review">
                                    </a>
                                </div>
                                <div class="testimonial-itm-content">
                                    <div class="testimonial-content-top">
                                        <h3 class="testimonial-title" class="description">
                                            {{ $review->title }}
                                        </h3>
                                    </div>
                                    <p class="descriptions">{{ $review->description }}</p>
                                    <div class="testimonial-content-bottom">
                                        <div class="testi-pro-info">
                                            <div class="pro-img">
                                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/client-img.png') }}"
                                                    class="client-img" alt="image">
                                            </div>
                                            <h6>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                                <span>Client</span>
                                            </h6>
                                        </div>
                                        <div class="testi-star d-flex align-items-center">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                            @endfor
                                            <span><b>{{ $review->rating_no }}</b> / 5.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="home-product-extra  padding-bottom">
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-center">
                    @php
                        $homepage_header_1_key = array_search('homepage-feature-product', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-feature-product-title-text') {
                                    $feature_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-feature-product-sub-text') {
                                    $feature_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-feature-product-btn-text') {
                                    $feature_btn = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}
                    <div class="section-title-left">
                        <h2>{!! $feature_title !!}</h2>
                    </div>
                    <div class="section-title-center">
                        <p>{{ $feature_text }} </p>
                    </div>
                    <div class="section-title-right">
                        <a href="{{ route('page.product-list', $slug) }}" class="btn-primary btn-transparent">
                            {{ $feature_btn }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
                                fill="rgba(131, 131, 131, 1)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                                <path
                                    d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z"
                                    fill="rgba(131, 131, 131, 1)"></path>
                            </svg>
                        </a>
                    </div>
                    {{-- @endif --}}
                </div>
                <div class="product-extra-slider dark-contnt">

                    {!! \App\Models\Product::ProductPageBestseller($slug) !!}

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
                                $('.stock').parent().hide();
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
