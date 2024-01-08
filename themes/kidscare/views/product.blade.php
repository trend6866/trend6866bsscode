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
        <section class="product-page-main-section">
            @php
                $product_ids = hashidsencode($product->id);
            @endphp
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 col-12">
                        <div class="product-main-left">
                            <div class="pro-main-slider">


                                @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="pro-main-itm">
                                        <div class="pro-main-itm-inner">
                                            <div class="pro-main-img">
                                                <img src={{ get_file($item->image_path, APP_THEME()) }}>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

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
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="product-main-right">
                            <div class="pro-reivew-row">
                                <svg class="top-left-pulse" xmlns="http://www.w3.org/2000/svg" width="13" height="6"
                                    viewBox="0 0 13 6" fill="none">
                                    <path d="M1 4.66667L4.66667 1L8.33333 4.66667L12 1" stroke="#000"></path>
                                </svg>

                                {!! \App\Models\Review::ProductReview(1, $product->id) !!}

                                @auth
                                    <div class="wishlist">
                                        <a href="#" class="wsh-btn wishbtn-globaly " product_id="{{ $product->id }}"
                                            in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                            {{ __('Add to wishlist') }}
                                            <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                            <h2>{{ $product->name }}</h2>
                            <h4 class="description">{{ $product->SubCategoryctData->name }}</h4>
                            <div class="d-flex align-items-center sku-varialble">
                                @if ($product_stocks->isNotEmpty())
                                    <span><b>{{ __('SKU:') }}</b>
                                        @foreach ($product_stocks as $product_stock)
                                            {{ $product_stock->sku }},
                                        @endforeach
                                    </span>
                                @endif
                                <span><b>{{ __('CATEGORY:') }}</b> {{ $product->SubCategoryctData->name }}</span>
                            </div>
                            <p>{{ $product->description }}</p>
                            <form class="variant_form ">
                                @if ($product->variant_product == 1)
                                    @php
                                        $variant = json_decode($product->variant_attribute);
                                        $varint_name_array = [];
                                        if (!empty($product->DefaultVariantData->variant)) {
                                            $varint_name_array = explode('-', $product->DefaultVariantData->variant);
                                        }
                                    @endphp
                                    @foreach ($variant as $key => $value)
                                        @php
                                            $p_variant = App\Models\Utility::VariantAttribute($value->attribute_id);
                                            $attribute = json_decode($p_variant);
                                        @endphp
                                        <div class="size-variant-swatch ">
                                            <div class="color-lbl">{{ $attribute->name }} :</div>&nbsp;
                                            <div class="color-list d-flex text-end">
                                                @if ($attribute->type != 'collection_horizontal')
                                                    <select class="custom-select-btn  variont_option"
                                                        name="varint[{{ $attribute->name }}]">
                                                        @foreach ($value->values as $variant1)
                                                            <option
                                                                {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }}>
                                                                {{ $variant1 }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <div class="text-checkbox checkbox-radio d-flex align-items-center">
                                                        <div class="boxed">
                                                            @foreach ($value->values as $variant2)
                                                                <input id="{{ $variant2 }}"
                                                                    name="varint[{{ $attribute->name }}]" type="radio"
                                                                    value="{{ $variant2 }}"
                                                                    class="custom-radio-btn variont_option"
                                                                    {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}>
                                                                <label for="{{ $variant2 }}" class="checkbox-label">
                                                                    <h6> <b>{{ $variant2 }}</b> </h6>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="size-variant-swatch d-flex">
                                    <div class="color-lbl d-block">{{ __('quantity :') }}</div>&nbsp;
                                    <div class="qty-spinner">
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




                                <div class="d-flex price-wrap-flex align-items-center">
                                    <div class="price">
                                        <ins>
                                            <span class="product_final_price"> {{ $product->final_price }} </span>
                                            <span class="currency-type">{{ $currency }}</span>
                                        </ins>
                                        {{-- <del class="product_orignal_price">{{ $product->original_price }}</del>
                                    <div class="tax-price">{{ __('Tax') }}: <span class="product_tax_price">
                                            {{ $currency }}</span> </div> --}}
                                    </div>
                                    <div class="btn-wrapper">
                                        <a href="javascript:void(0)"
                                            class="btn  addcart-btn addcart-btn addcart-btn-globaly"
                                            product_id="{{ $product->id }}"
                                            variant_id="{{ $product->default_variant_id }}" qty="1">
                                            {{ __('ADD TO CART') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 14 16" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                                    fill="#F2DFCE"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                                    fill="#F2DFCE"></path>
                                            </svg>
                                        </a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product-two-col-layout">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 col-12 product-two-col-contnt">
                        <div class="product-two-col-left">
                            <div class="section-title">
                                <h2>{{ $product->name }}</h2>
                                <h3>{{ $product->SubCategoryctData->name }}</b></h3>
                            </div>
                            <p>{!! $description_value !!}</p>
                            <a href="javascript:void(0)" class="add-cart-btn addcart-btn addcart-btn-globaly"
                                product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}"
                                qty="1">
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
                    <div class="col-md-6 col-12 product-two-col-img">
                        <div class="product-two-col-right">
                            <img src=" {{ get_file($description_img, APP_THEME()) }}">
                        </div>
                    </div>
                </div>
                <div class="row no-gutters row-reverse">
                    <div class="col-md-6 col-12 product-two-col-contnt">
                        <div class="product-two-col-left">
                            <div class="section-title">
                                <h3>{{ __('Description:') }}</h3>
                            </div>
                            <p>{!! $more_description_value !!}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 product-two-col-img">
                        <div class="product-two-col-right">
                            <img src=" {{ get_file($more_description_img, APP_THEME()) }}">
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

                    </div>
                </div>
            </div>
        </section>
        <section class="related-product-section padding-bottom padding-top">
            @php
                $homepage_bestsellers_heading = $homepage_bestsellers_sub_heading = $homepage_bestsellers_button = '';
                $homepage_bestsellers_key = array_search('homepage-product-bestsellers', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_bestsellers_key != '') {
                    $homepage_bestsellers = $theme_json[$homepage_bestsellers_key];
                    // dd($homepage_bestsellers);
                    foreach ($homepage_bestsellers['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-product-bestsellers-title') {
                            $homepage_bestsellers_heading = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-product-bestsellers-sub-title') {
                            $homepage_bestsellers_sub_heading = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-product-bestsellers-sub-button-text') {
                            $homepage_bestsellers_button = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <img src="assets/images/all-right-shape.png" class="all-shes-right">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <div class="section-title-left">
                        <div class="subtitle">{!! $homepage_bestsellers_heading !!}</div>
                        <h2>{!! $homepage_bestsellers_sub_heading !!}</h2>
                    </div>
                    <a href="{{ route('page.product-list', $slug) }}" class="btn-secondary">
                        <span class="btn-txt">{!! $homepage_bestsellers_button !!}</span>
                        <span class="btn-ic">
                            <svg viewBox="0 0 10 5">
                                <path
                                    d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="all-shoes-slider">
                    @foreach ($bestSeller as $data)
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="all-shoes-slide-itm card">
                            <div class="all-shoes-itm-inner card-inner d-flex ">
                                <div class="all-shoes-itm-content">
                                    <h4><a href="{{ route('page.product', [$slug, $p_id]) }}"
                                            class="name">{{ $data->name }}
                                            <p class="description">
                                                {{ $data->description }}</p>
                                        </a></h4>



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
                                        <ins>{{ $data->final_price }}<sub>{{ $currency }}</sub></ins>
                                    </div>
                                    <div class="d-flex price-wrap-flex align-items-center">
                                        <a href="javascript:void(0)" class="add-cart-btn addcart-btn-globaly"
                                            product_id="{{ $data->id }}"
                                            variant_id="{{ $data->default_variant_id }}" qty="1" tabindex="0">
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
                                                product_id="{{ $data->id }}"
                                                in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">
                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
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
                                    <a href="{{ route('page.product', [$slug, $p_id]) }}" class="all-shoe-img">
                                        <img src="{{ get_file($data->cover_image_path, APP_THEME()) }}">

                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach


                </div>
            </div>
        </section>
        @if ($product_review->isNotEmpty())
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
                    {{-- @if ($homepage_about_shoes['section_enable'] == 'on') --}}
                    <div class="section-title text-center">
                        <div class="subtitle">{!! $homepage_about_shoes_title !!} </div>
                        {!! $homepage_about_shoes_heading !!}
                    </div>
                    {{-- @endif --}}

                    <div class="testimonial-slider common-arrow  dark-bg">
                        @foreach ($product_review as $review)
                            <div class="testimonial-itm">
                                <div class="testimonial-itm-inner">
                                    <div class="test-head">
                                        <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}">
                                        <h3><span>{{ $review->title }}</span></h3>
                                    </div>
                                    <div class="testicontent">
                                        <p class="description">{{ $review->description }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="testi-auto d-flex align-items-center">
                                            <div class="testi-img">
                                                <img
                                                    src=" {{ asset('themes/' . APP_THEME() . '/assets/images/john.png') }}">
                                            </div>
                                            <div class="test-auth-detail">
                                                <h6>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}
                                                </h6>
                                                <span>{{ __('developer') }}</span>
                                            </div>
                                        </div>
                                        <div class="starimg">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i
                                                    class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection

@push('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            product_price();
        });

        $(document).on('change', '.variont_option', function(e) {
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
                    } else {
                        $('.product_final_price').html(response.product_original_price);
                        $('.currency-type').html(response.currency_name);
                        $('.product_orignal_price').html(response.original_price);
                        $('.product_tax_price').html(response.total_tax_price + ' ' + response.currency_name);
                        $('.addcart-btn.addcart-btn-globaly').attr('variant_id', response.variant_id);
                        //alert(response.variant_id);
                        $('.addcart-btn.addcart-btn-globaly').attr('qty', response.qty);
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
    </script>
@endpush
