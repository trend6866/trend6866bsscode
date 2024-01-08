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
        foreach ($description as $k => $value)
        {
          $value =  json_decode(json_encode($value), true);

            foreach ($value['inner-list'] as $description_val) {
                if ($description_val['field_slug'] == 'product-other-description-other-description') {
                    $description_value = !empty($description_val['value']) ? $description_val['value'] : $description_val['field_default_text'] ;
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
    <!--wrapper start here-->
    <div class="wrapper">
        @foreach ($products as $product)
        {{-- @dd($product) --}}
            <section class="product-page-first-section">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-sm-6 col-12 pdp-left-column">
                            <div class="pdp-left-column-inner">
                                <div class="product-description">
                                    <div class="section-title">
                                        <div class="d-flex justify-content-between">
                                            <span class="subtitle">{{ $product->tag_api}}</span>
                                            @auth
                                                <div class="wishlist favorite-icon" >
                                                    <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}" >
                                                        {{ __('Add to wishlist') }}
                                                        <span class="wish-ic">
                                                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: rgb(0, 0, 0)'></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endauth
                                        </div>
                                        <h2>{{$product->name}}</h2>
                                        <div class="product-type">{{$product->name}}</div>
                                    </div>
                                    <form class="variant_form w-100">
                                        @if ($product->variant_product == 1)
                                            <div class="size-select">
                                                @php
                                                    $variant = json_decode($product->variant_attribute);
                                                    $varint_name_array = [];
                                                    if(!empty($product->DefaultVariantData->variant)) {
                                                        $varint_name_array = explode('-', $product->DefaultVariantData->variant);
                                                    }
                                                @endphp
                                                @foreach ($variant as $key => $value)
                                                    @php
                                                        $p_variant = App\Models\Utility::VariantAttribute($value->attribute_id);
                                                        $attribute = json_decode($p_variant);
                                                    @endphp
                                                    <div class="product-labl w-100 mb-0">{{$attribute->name}}</div>
                                                    @if ($attribute->type != 'collection_horizontal')
                                                        <select class="custom-select-btn variont_option" name="varint[{{ $attribute->name }}]">
                                                            @foreach ($value->values as $variant1)
                                                                <option {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }} >{{$variant1}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                    <div class="boxed row">
                                                        @foreach ($value->values as $variant2)
                                                            <div class="col-3">
                                                                <input type="radio" id="{{$variant2}}" name="varint[{{ $attribute->name }}]" value="{{$variant2}}" class="custom-radio-btn variont_option" {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}>
                                                                <label for="{{$variant2}}">{{$variant2}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="size-variant-swatch d-flex">
                                            <div class="product-labl mb-0">{{ __('quantity :')}}</div>&nbsp;
                                            <div class="qty-spinners">
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
                                    <div class="price" style="margin-top: 10px;">
                                        <ins>
                                            <span class="product_final_price"> {{ $product->final_price }} </span>
                                            <span class="currency-type">{{ $currency }}</span>
                                        </ins>
                                        <del class="product_orignal_price">{{ $product->original_price }}</del>
                                        <del class="currency-type">{{ $currency }}</del>
                                        {{-- @dd($product->original_price); --}}
                                    </div>
                                    <div class="tax-price" style="margin-top: -10px;">{{ __('Tax') }}: <span class="product_tax_price">{{ $currency }}</span> </div>

                                    <a href="{{route('page.product-list',$slug)}}" class="btn white-btn" style="margin-bottom: 10px;margin-top: 10px;">
                                        {{ __('SHOP NOW')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4605 6.00095C11.7371 5.72433 11.7371 5.27584 11.4605 4.99921L7.2105 0.749214C6.93388 0.472592 6.48539 0.472592 6.20877 0.749214C5.93215 1.02584 5.93215 1.47433 6.20877 1.75095L9.9579 5.50008L6.20877 9.24921C5.93215 9.52584 5.93215 9.97433 6.20877 10.2509C6.48539 10.5276 6.93388 10.5276 7.2105 10.2509L11.4605 6.00095ZM1.54384 10.2509L5.79384 6.00095C6.07046 5.72433 6.07046 5.27584 5.79384 4.99921L1.54384 0.749214C1.26721 0.472592 0.818723 0.472592 0.542102 0.749214C0.26548 1.02583 0.26548 1.47433 0.542102 1.75095L4.29123 5.50008L0.542101 9.24921C0.26548 9.52584 0.26548 9.97433 0.542101 10.2509C0.818722 10.5276 1.26721 10.5276 1.54384 10.2509Z" fill="white"></path>
                                        </svg>
                                    </a>
                                    <button class="btn white-btn addcart-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                        {{ __('Add to cart')}}
                                        <svg viewBox="0 0 10 5"  width="12" height="11" viewBox="0 0 12 11" fill="none">
                                            <path
                                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12 pdp-center-column">
                            <div class="pdp-center-inner-sliders">
                                <div class="main-slider-wrp">
                                    <div class="pdp-main-slider">
                                        @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-main-slider-itm">
                                            <div class="pdp-main-img img-wrapper">
                                                <img src="{{  get_file($item->image_path , APP_THEME()) }}" alt="" />
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="view-lbl">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12"
                                                viewBox="0 0 13 12" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.49569 4.86808C1.49569 6.72102 2.9978 8.22312 4.85074 8.22312L10.4039 8.22312L9.30495 7.12416C9.11778 6.93698 9.11778 6.63351 9.30495 6.44634C9.49213 6.25916 9.7956 6.25916 9.98278 6.44634L11.8999 8.3635C11.9898 8.45339 12.0403 8.5753 12.0403 8.70242C12.0403 8.82953 11.9898 8.95144 11.8999 9.04133L9.98278 10.9585C9.7956 11.1457 9.49213 11.1457 9.30495 10.9585C9.11778 10.7713 9.11778 10.4678 9.30495 10.2807L10.4039 9.18171L4.85074 9.18171C2.46839 9.18171 0.537109 7.25043 0.537109 4.86808C0.53711 2.48572 2.46839 0.554444 4.85074 0.554444L9.64387 0.554445C9.90857 0.554445 10.1232 0.769032 10.1232 1.03374C10.1232 1.29844 9.90857 1.51303 9.64387 1.51303L4.85074 1.51303C2.9978 1.51303 1.49569 3.01514 1.49569 4.86808Z"
                                                    fill="white" />
                                            </svg>
                                        </span>
                                        <div>View 360*</div>
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="12"
                                                viewBox="0 0 13 12" fill="none">
                                                <g clip-path="url(#clip0_9_1927)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.3168 6.78524C11.3168 4.9323 9.8147 3.4302 7.96176 3.4302L2.40858 3.4302L3.50755 4.52916C3.69472 4.71634 3.69472 5.01981 3.50755 5.20699C3.32037 5.39416 3.0169 5.39416 2.82972 5.20699L0.912553 3.28982C0.822668 3.19993 0.772172 3.07802 0.772172 2.9509C0.772172 2.82379 0.822668 2.70188 0.912553 2.61199L2.82972 0.694825C3.0169 0.507649 3.32037 0.507649 3.50755 0.694825C3.69472 0.882 3.69472 1.18547 3.50755 1.37265L2.40858 2.47161L7.96176 2.47161C10.3441 2.47161 12.2754 4.40289 12.2754 6.78524C12.2754 9.1676 10.3441 11.0989 7.96176 11.0989L3.16863 11.0989C2.90393 11.0989 2.68934 10.8843 2.68934 10.6196C2.68934 10.3549 2.90393 10.1403 3.16863 10.1403L7.96176 10.1403C9.8147 10.1403 11.3168 8.63819 11.3168 6.78524Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_9_1927">
                                                        <rect width="11.503" height="11.503" fill="white"
                                                            transform="translate(0.771484 0.0751953)" />
                                                    </clipPath>
                                                </defs>
                                            </svg></span>
                                    </div>
                                </div>
                                <div class="pdp-thumb-wrap">
                                    <div class="pdp-thumb-slider common-arrows">
                                        @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-thumb-slider-itm">
                                            <div class="pdp-thumb-img img-wrapper">
                                                <img src="{{  get_file($item->image_path , APP_THEME()) }}" />
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12 pdp-right-column">
                            <div class="pdp-right-column-inner">

                                    {!! \App\Models\Review::ProductReview(1,$product->id) !!}

                                <div class="product-description-right">
                                    @if($product->variant_product == 1)
                                    <div class="pdp-block pdp-variable">
                                        <span><b>{{ __('SKU')}}:</b>@foreach($product_stocks as $product_stock){{$product_stock->sku}},@endforeach</span>
                                    </div>
                                    <div class="pdp-block pdp-variable" style="margin-top: -27px;">
                                        <span><b>{{ __('Category:')}}</b> @foreach($product_stocks as $product_stock){{$product_stock->variant}},@endforeach</span>
                                    </div>
                                    @endif

                                    <div class="pdp-block pdp-info-block">
                                        <p>
                                            {{$product->description}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    {{-- <li class="tab-link on-tab-click active" data-tab="0"><a
                                            href="javascript:;">{{ __('Description') }}</a>
                                    </li> --}}
                                    <li class="tab-link on-tab-click active" data-tab="2"><a
                                            href="javascript:;">{{ __('Question & Answer') }}</a>
                                    </li>
                                    @if($product->preview_content != '')
                                    <li class="tab-link on-tab-click" data-tab="1"><a
                                            href="javascript:;">{{ __('Video') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="tabs-container">
                            {{-- <div id="0" class="tab-content active">
                                
                            </div> --}}
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

            <section class="product-prescription-section-two pdp-page padding-top">
                @php
                    $homepage_text = '';
                    $homepage_logo_key = array_search('home-content',array_column($theme_json,'unique_section_slug'));
                    $section_enable = 'on';
                    if($homepage_logo_key != '')
                    {
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                    @php
                        if($homepage_main_logo_value['field_slug'] == 'home-content-image')
                        {
                            $homepage_image = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'home-content-title')
                        {
                            $homepage_title = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'home-content-sub-text')
                        {
                            $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'home-content-button')
                        {
                            $homepage_button = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $homepage_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                    @endphp
                @endforeach
                @if($homepage_main_logo['section_enable'] == 'on')
                <div class="container-offset offset-right">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-sm-6  col-12">
                            <div class="left-side-image">
                                <img src="{{get_file($homepage_image, APP_THEME())}}" alt="GlassesI0p1">
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-6 col-12 right-col">
                            <div class=" banner-content-inner">
                                <div class="section-title">
                                    <h2>{!! $homepage_title !!}</h2>
                                </div>
                                <p>{!! $homepage_sub_text !!}</p>
                                <a href="{{route('page.product-list',$slug)}}" class="btn white-btn">
                                    {!! $homepage_button !!}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </section>


            <section class="related-detail-images pdp-page padding-bottom padding-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-5 col-lg-4 col-12">
                            <div class=" banner-content-inner">
                                <div class="section-title">
                                    <h2 class="descriptions">{!! $description_value !!} </h2>
                                </div>
                                <p>
                                    {!! $more_description_value !!}
                                </p>
                                @php
                                    $p_id = hashidsencode($product->id);
                                @endphp
                                <a href="{{route('page.product',[$slug,$p_id])}}" class="btn">
                                    {{ __('SHOP NOW')}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.4605 6.00095C11.7371 5.72433 11.7371 5.27584 11.4605 4.99921L7.2105 0.749214C6.93388 0.472592 6.48539 0.472592 6.20877 0.749214C5.93215 1.02584 5.93215 1.47433 6.20877 1.75095L9.9579 5.50008L6.20877 9.24921C5.93215 9.52584 5.93215 9.97433 6.20877 10.2509C6.48539 10.5276 6.93388 10.5276 7.2105 10.2509L11.4605 6.00095ZM1.54384 10.2509L5.79384 6.00095C6.07046 5.72433 6.07046 5.27584 5.79384 4.99921L1.54384 0.749214C1.26721 0.472592 0.818723 0.472592 0.542102 0.749214C0.26548 1.02583 0.26548 1.47433 0.542102 1.75095L4.29123 5.50008L0.542101 9.24921C0.26548 9.52584 0.26548 9.97433 0.542101 10.2509C0.818722 10.5276 1.26721 10.5276 1.54384 10.2509Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8 col-12">
                            <div class="row image-gallery">
                                <div class="col-6">
                                    <div class="gallery-image img-wrapper">
                                        <img src="{{ get_file($description_img, APP_THEME()) }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="gallery-image img-wrapper">
                                        <img src="{{ get_file($more_description_img, APP_THEME()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="shop-products-section pdp-page padding-bottom padding-top" >
            <div class="container">
                @php
                    $homepage_logo_key = array_search('homepage-shop-products',array_column($theme_json,'unique_section_slug'));
                    $section_enable = 'on';
                    if($homepage_logo_key != '')
                    {
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @if($homepage_main_logo['section_enable'] == 'on')
                    <div class="section-title d-flex justify-content-between align-items-center">
                        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            @php
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-title')
                                {
                                    $products_title = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-button')
                                {
                                    $products_button = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                            @endphp
                        @endforeach
                        <h2>{{ $products_title }}</h2>
                        <a href="{{route('page.product-list',$slug)}}" class="btn">
                            {{$products_button}}
                        </a>
                    </div>
                @endif
                <div class="shop-products-slider flex-slider">
                    @foreach ($bestSeller as $data)
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="product-card card">
                            <div class="product-card-inner card-inner">
                                <div class="product-content-top ">
                                    <div class="new-labl">
                                        {{ $data->tag_api }}
                                    </div>
                                    <h4 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                            {{$data->name}}
                                        </a>
                                    </h4>
                                    <div class="product-type">{{ $data->name }}</div>
                                </div>
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                        <img src="{{get_file($data->cover_image_path , APP_THEME())}}" class="default-img">
                                    </a>
                                </div>
                                <div class="product-content-bottom">
                                    <div class="price" >
                                        <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                    </div>
                                    <button class="addtocart-btn btn addcart-btn-globaly" tabindex="0" product_id="{{ $data->id }}" variant_id="{{ $data->default_variant_id }}" qty="1" tabindex="0">
                                        <span>{{ __('Add to cart')}}</span>
                                        <span class="roun-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                    fill="white" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- {!! \App\Models\Product::GetLatProduct(10) !!} --}}
                </div>
            </div>
        </section>

        <section class="newsletter-section padding-bottom padding-top">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-newsletter-section',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-sub-text')
                    {
                        $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    // if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-background-image')
                    // {
                    //     $homepage_image = $homepage_main_logo_value['field_default_text'];
                    //     if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                    //         $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    //     }
                    // }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-text')
                    {
                        $homepage_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            @if($homepage_main_logo['section_enable'] == 'on')
                {{-- <img src="{{ get_file($homepage_image, APP_THEME()) }}" class="subs-design-img" alt="newsletter-right-glass"> --}}
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class=" banner-content-inner">
                            <div class="section-title">
                                <h2>{!! $homepage_title !!}</h2>
                            </div>
                            <p>{!! $homepage_sub_text !!}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" name="email" placeholder="Enter email address...">
                                    <button type="submit" class="btn-subscibe">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                fill="white"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="checkbox">
                                    {{-- <input type="checkbox" id="subscibecheck"> --}}
                                    <label for="subscibecheck">
                                        {!! $homepage_text !!}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
    <!---wrapper end here-->
@endforeach
@endsection

@push('page-script')

<script type="text/javascript">
    $(document).ready(function(){
        product_price();
    });

    $(document).on('change', '.variont_option', function(e){
        product_price();
    });

    $(document).on('click', '.change_price', function(e){
        product_price();
    });

    function product_price() {
        var data = $('.variant_form').serialize();
        var data = data+'&product_id={{$product->id}}';

        $.ajax({
            url: '{{ route('product.price',$slug) }}',
            method: 'POST',
            data: data,
            context:this,
            success: function (response)
            {
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
