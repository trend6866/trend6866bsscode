@extends('layouts.layouts')

@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection

@section('content')
<div class="wrapper">
    <section class="pro-home-section padding-bottom padding-top">
        <div class=" container">
            @foreach ($products as $product)
                <div class="row">
                    <div class="col-lg-5 col-12 left-col">
                        <div class="left-side-wrapper dark-p">
                            <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z" fill="white"></path>
                                    </svg>
                                </span>
                                {{ __('Back to category') }}
                            </a>
                            <div class="left-slide-content">
                                <span class="badge">{{ $product->tag_api }}</span>
                                <h3>{{ $product->name }}</h3>
                                <span>{{ $product->category_name }}</span>
                                <p>
                                    {{ $product->description }}
                                </p>
                                <div class="bottom-content">
                                    @if ($product->variant_id != 0)
                                        <b> {!! \App\Models\ProductStock::variantlist($product->variant_id) !!} </b>
                                    @endif
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
                                                    <div class="select-box">{{ $attribute->name }} :</div>
                                                        @if ($attribute->type != 'collection_horizontal')
                                                            <select class=" variont_option"
                                                                name="varint[{{ $attribute->name }}]">
                                                                @foreach ($value->values as $variant1)
                                                                    <option
                                                                        {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }}>
                                                                        {{ $variant1 }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br>
                                                        @else
                                                        <div class="boxed">
                                                            @foreach ($value->values as $variant2)
                                                                <input type="radio" id="{{ $variant2 }}"
                                                                    name="varint[{{ $attribute->name }}]"
                                                                    value="{{ $variant2 }}"
                                                                    class="custom-radio-btn variont_option"
                                                                    {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}>
                                                                <label
                                                                    for="{{ $variant2 }}">{{ $variant2 }}</label>
                                                            @endforeach
                                                        </div>&nbsp;
                                                        @endif
                                            @endforeach
                                        @endif

                                        <div class="size-variant-swatch d-flex">
                                            <div class="color-lbl d-block">{{__('quantity :')}}</div>
                                            <div class="qty-spinner">
                                                <button type="button" class="quantity-decrement change_price">
                                                    <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3"></path>
                                                    </svg>
                                                </button>
                                                <input type="text" class="quantity" data-cke-saved-name="quantity"
                                                    name="qty" value="01" min="01" max="100">
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
                                    <div class="price-btn">
                                        <div class="price">
                                            <ins>
                                                <span class="currency-type">{{ $currency }}</span>
                                                <span class="product_final_price"> {{ $product->final_price }} </span>
                                            </ins>

                                            {{-- <span class="currency-type">{{ $currency_icon }}</span>
                                            <span class="product_final_price"> <ins> {{ $product->final_price }} </ins> </span>
                                            <del class="product_orignal_price">{{ $product->original_price }}</del> --}}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0)" class="btn checkout-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                                {{ __('Add to cart') }}
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
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 slider-col">
                        <div class="product-main-div">
                            <div class="slider-wrapper">
                                <div class="product-main-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-main-item">
                                            <div class="product-item-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="product">
                                            </div>
                                        </div>
                                     @endforeach
                                </div>
                                <div class="product-thumb-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="product-thumb-item">
                                            <div class="thumb-img">
                                                <img src="{{ get_file($item->image_path, APP_THEME()) }}" alt="product">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12 right-col">
                        @foreach ($products->take(2) as $product)
                            @php
                                $p_id = hashidsencode($product->id);
                            @endphp
                            <div class="category-card-inner">
                                <div class="category-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                                        <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" alt="">
                                    </a>
                                </div>
                                <div class="category-card-content">
                                    <div class="category-cont-top">
                                        <span class="badge">{{ $product->tag_api }}</span>
                                        <div class="prouct-card-heading">
                                            <h6>
                                                <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">{{ $product->name }}</a>
                                            </h6>
                                            <p>{{ $product->ProductData()->name }}</p>
                                        </div>
                                    </div>
                                    <div class="category-cont-bottom">
                                        <div class="price-btn">
                                            <div class="price">
                                                <span class="currency-type">{{ $currency_icon }}</span>
                                                <ins>{{ $product->final_price }} </ins>
                                            </div>
                                            <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                                {{ __('Add to cart') }}
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
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="paroduct-page testimonials-section padding-bottom">
        <div class="container">
            <div class="testimonial-slider">
                @foreach ($product_review as $review)
                    <div class="testimonial-itm">
                        <div class="testimonial-itm-inner">
                            <div class="testimonial-itm-image">
                                <a href="#" tabindex="0">
                                    <img src="{{get_file($review->ProductData->cover_image_path , APP_THEME())}}" class="default-img" alt="review">
                                </a>
                            </div>
                            <div class="testimonial-itm-content">
                                <span>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</span>
                                <div class="testimonial-content-top">
                                    <h3 class="testimonial-title">
                                        {{ $review->title }}
                                    </h3>
                                </div>
                                <p>{{ $review->description }}</p>
                                <div class="testimonial-star">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                        @endfor
                                        <span><b>{{ $review->rating_no }}/</b> 5.0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- tab section  --}}
<section class="tab-vid-section padding-top">
    <div class="container">
        <div class="tabs-wrapper">
            <div class="blog-head-row tab-nav d-flex justify-content-between">
                <div class="blog-col-left ">
                    <ul class="d-flex tabs">
                        <li class="tab-link on-tab-click active" data-tab="0"><a
                                href="javascript:;">{{ __('Description') }}</a>
                        </li>
                        @if($product->preview_content != '')
                        <li class="tab-link on-tab-click" data-tab="1"><a
                                href="javascript:;">{{ __('Video') }}</a>
                        </li>
                        @endif
                        <li class="tab-link on-tab-click" data-tab="2"><a
                                href="javascript:;">{{ __('Question & Answer') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tabs-container">
                <div id="0" class="tab-content active">
                    {{-- <section class="product-description-section padding-bottom ">
                        <div class="container">
                            <div class="row row-gap">
                                <div class="col-md-6 col-12">
                                    <div class="pro-descrip-contente-left">
                                        <div class="section-title">
                                            <div class="badge">
                                                {{ __('About product') }}
                                            </div>
                                            <h2>{{ __('Description') }} </h2>
                                        </div>
                                        <p>{!! $description_value !!} </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="pro-descrip-contente-right">
                                        <div class="section-title">
                                            <div class="badge">
                                                {{ __('About product') }}
                                            </div>
                                            <h2>{{ __('About product') }} </h2>
                                        </div>
                                        <p>{!! $more_description_value !!} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> --}}

     <section class="description-section padding-bottom">
        <div class="container">
            <div class="row justify-content-between  ">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="left-side">
                        <div class="section-title">
                            <h4>{{ __('DESCRIPTION') }}:</h4>
                        </div>
                        <p>

                            {{ $product->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="left-side">
                        <div class="section-title">
                            <h4>{{ __('More infos:') }}</h4>
                        </div>
                        <p>
                           {{ $product->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="right-side">
                        <div class="right-side-inner">
                            <div class="section-title">
                                <h4>{{ __('MORE') }}:</h4>
                            </div>
                            <div class="d-flex">
                                <div class="code">
                                    @if ($product_stocks->isNotEmpty())
                                        <span><b>{{ __('SKU:') }}</b>
                                            @foreach ($product_stocks as $product_stock)
                                                {{ $product_stock->sku }},</b>
                                            @endforeach
                                        </span>
                                    @endif
                                    <div>Category: <span>{{ $product->ProductData()->name }}</span></div>
                                </div>
                                <div class="details">
                                    <span><b>{{ __('Size:') }}</b> {{ $product->default_variant_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                </div>
                @if($product->preview_content != '')
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

            </div>
        </div>
    </div>
</section>


    {{-- <section class="description-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-between  ">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="left-side">
                        <div class="section-title">
                            <h4>{{ __('DESCRIPTION') }}:</h4>
                        </div>
                        <p>

                            {{ $product->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="left-side">
                        <div class="section-title">
                            <h4>{{ __('More infos:') }}</h4>
                        </div>
                        <p>
                           {{ $product->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="right-side">
                        <div class="right-side-inner">
                            <div class="section-title">
                                <h4>{{ __('MORE') }}:</h4>
                            </div>
                            <div class="d-flex">
                                <div class="code">
                                    @if ($product_stocks->isNotEmpty())
                                        <span><b>{{ __('SKU:') }}</b>
                                            @foreach ($product_stocks as $product_stock)
                                                {{ $product_stock->sku }},</b>
                                            @endforeach
                                        </span>
                                    @endif
                                    <div>Category: <span>{{ $product->ProductData()->name }}</span></div>
                                </div>
                                <div class="details">
                                    <span><b>{{ __('Size:') }}</b> {{ $product->default_variant_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="paroduct-page category-section padding-bottom">
        <div class="container">
            @php
            $homepage_category_title = '';

                $homepage_category = array_search('category-section', array_column($theme_json, 'unique_section_slug'));
                if($homepage_category != '' ){
                    $homepage_category_value = $theme_json[$homepage_category];

                    foreach ($homepage_category_value['inner-list'] as $key => $value) {

                        if($value['field_slug'] == 'category-section-title') {
                            $homepage_category_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'category-section-sub-text') {
                            $homepage_category_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'category-section-image') {
                            $homepage_category_img = $value['field_default_text'];
                        }

                        //Dynamic
                        if(!empty($homepage_category_value[$value['field_slug']]))
                        {
                            if($value['field_slug'] == 'category-section-title'){
                                $homepage_category_title = $homepage_category_value[$value['field_slug']][$i];
                            }
                            if($value['field_slug'] == 'category-section-sub-text'){
                                $homepage_category_text = $homepage_category_value[$value['field_slug']][$i];
                            }
                            if($value['field_slug'] == 'category-section-image'){
                                $homepage_category_img = $homepage_category_value[$value['field_slug']][$i];
                            }

                        }
                    }
                }
            @endphp
            <div class="section-title">
                 {!! $homepage_category_title !!}
                 <p>{{$homepage_category_text}}
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="category-image-box">
                        <a href="{{route('page.product-list',$slug)}}">
                            <img src="{{ get_file($homepage_category_img , APP_THEME()) }}">
                            <div class="category-image-text">
                                <h4> {{ $latest_product->name }}</h4>
                                <div class="link-btn justify-content-start">
                                    {{ __('Show more') }}
                                    <svg width="6" height="5" viewBox="0 0 6 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="category-card-reverse">
                        <div class="category-itm product-card">
                            @foreach ($bestSeller as $productss)
                            <div class="category-card-inner">
                                <div class="category-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                                        <img src="{{ get_file($productss->cover_image_path)}}" alt="">
                                    </a>
                                </div>
                                <div class="category-card-content">
                                    <div class="category-cont-top">
                                        <span class="badge">{{ $productss->tag_api }}</span>
                                        <div class="prouct-card-heading long_sting_to_dot">
                                            <h5>
                                                <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">{{ $productss->name }}</a>
                                            </h5>
                                            <p>{{$productss->ProductData()->name}}</p>
                                        </div>
                                    </div>
                                    <div class="category-cont-bottom">
                                        <div class="price-btn">
                                            <div class="price">
                                                <span class="currency-type">{{ $currency_icon }}</span>
                                                <ins> {{ $productss->final_price }} </ins>
                                            </div>
                                            <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" product_id="{{ $productss->id }}" variant_id="{{ $productss->default_variant_id }}" qty="1">
                                                <svg width="20" height="20" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                    </path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                    </path>
                                                </svg>
                                                {{ __('Add to cart') }}
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
        </div>
    </section>
    <section class="blog-section padding-bottom">
        <div class="container">
            @php
                $homepage_blogs_title = '';

                $homepage_blogs = array_search('blog-section', array_column($theme_json, 'unique_section_slug'));
                if($homepage_blogs != '' ){
                    $homepage_blogs_value = $theme_json[$homepage_blogs];

                    foreach ($homepage_blogs_value['inner-list'] as $key => $value) {

                        if($value['field_slug'] == 'blog-section-title') {
                            $homepage_blogs_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'blog-section-button') {
                            $homepage_blogs_btn = $value['field_default_text'];
                        }

                        //Dynamic
                        if(!empty($homepage_blogs_value[$value['field_slug']]))
                        {
                            if($value['field_slug'] == 'blog-section-title'){
                                $homepage_blogs_title = $homepage_blogs_value[$value['field_slug']][$i];
                            }
                            if($value['field_slug'] == 'blog-section-button'){
                                $homepage_blogs_btn = $homepage_blogs_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp
            <div class="section-title d-flex align-items-center justify-content-between">
                {!! $homepage_blogs_title !!}
                <a href="product-list.html" class="btn" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.90909C0 1.30244 1.2934 0 2.88889 0H8.91449C9.68067 0 10.4155 0.306493 10.9572 0.852053L12.1539 2.05704C12.6956 2.6026 13 3.34254 13 4.11408V13.0909C13 14.6976 11.7066 16 10.1111 16H2.88889C1.2934 16 0 14.6976 0 13.0909V2.90909ZM11.5556 5.09091V13.0909C11.5556 13.8942 10.9089 14.5455 10.1111 14.5455H2.88889C2.09114 14.5455 1.44444 13.8942 1.44444 13.0909V2.90909C1.44444 2.10577 2.09114 1.45455 2.88889 1.45455H7.94444V2.90909C7.94444 4.11408 8.91449 5.09091 10.1111 5.09091H11.5556ZM11.4754 3.63636C11.4045 3.43098 11.2881 3.24224 11.1325 3.08556L9.93587 1.88057C9.78028 1.72389 9.59285 1.60665 9.38889 1.53523V2.90909C9.38889 3.31075 9.71224 3.63636 10.1111 3.63636H11.4754Z" fill="#E8BA96"></path>
                        <path d="M5.25003 7.1016L8.57902 8.83789C9.14033 9.13064 9.14033 9.86936 8.57902 10.1621L5.25003 11.8984C4.69303 12.1889 4 11.8218 4 11.2363L4 7.76372C4 7.17818 4.69303 6.8111 5.25003 7.1016Z" fill="#E8BA96"></path>
                    </svg>
                    {{$homepage_blogs_btn}}
                </a>
            </div>
            <div class="about-card-slider">
                {!! \App\Models\Blog::HomePageBlog($slug , $no=10) !!}
            </div>
        </div>
    </section>
</div>



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
                url: '{{ route('product.price',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    $('.addcart-btn.addcart-btn-globaly').attr('variant_id', '0');
                    if (response.status == 'error') {
                        show_toastr('Error', response.message, 'error');
                        $('.quantity').val(response.qty);
                    } else {
                        console.log(response.product_original_price, response.currency_name, response
                            .original_price);
                        $('.product_final_price').html(response.product_original_price);
                        $('.currency-type').html(response.currency_name);
                        $('.product_orignal_price').html(response.original_price);
                        $('.product_tax_price').html(response.total_tax_price + ' ' + response.currency_name);
                        $('.addcart-btn.addcart-btn-globaly').attr('variant_id', response.variant_id);
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
