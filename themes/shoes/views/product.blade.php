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
            $p_id = hashidsencode($product->id);
        @endphp
        @php
            $description = json_decode($product->other_description);
            foreach ($description as $k => $value) {
                $value = json_decode(json_encode($value), true);

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
        <section class="product-page-first-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-12 pdp-left-column">
                        <div class="pdp-left-column-inner">
                            <a href="{{route('page.product-list',$slug)}}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                            fill="white"></path>
                                    </svg>
                                </span>
                            {{__('Back to category')}}
                            </a>
                            <div class="product-description">
                                <div class="pdp-top-info d-flex align-items-center">
                                    <p>{{$product->tag_api}}</p>
                                    <div class="reviews-stars-wrap d-flex align-items-center">
                                        <div class="reviews-stars-outer">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="ti ti-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                            @endfor
                                        </div>
                                        <div class="point-wrap">
                                            <span class="review-point">{{$product->average_rating}} .0 / <span>{{__('5.0')}}</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-title">
                                    <h2>{{$product->name}}</h2>
                                    <span class="quality-per">{{__('100% beef')}}</span>
                                </div>
                                <form class="variant_form">

                                    <div class="quantity-select">
                                        <span class="lbl">{{__('quantity :')}}</span>
                                        <div class="qty-spinner">
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
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                        fill="#61AFB3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>&nbsp;
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
                                        <div class="product-selectors">
                                            <div class="size-select">
                                                <span class="lbl">{{ $attribute->name }} :</span>
                                                @if ($attribute->type != 'collection_horizontal')
                                                    <select class="custom-select-btn  variont_option " style="display: none;"
                                                        name="varint[{{ $attribute->name }}]">
                                                        @foreach ($value->values as $variant1)
                                                            <option
                                                                {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }}>
                                                                {{ $variant1 }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                <div class="boxed">
                                                    @foreach ($value->values as $variant2)
                                                        <input type="radio" id="{{$variant2}}" name="varint[{{ $attribute->name }}]" value="{{$variant2}}" class="custom-radio-btn variont_option"
                                                        {{ in_array($variant2, $varint_name_array) ? 'checked' : '' }}
                                                        >
                                                        <label for="{{$variant2}}">{{$variant2}}</label>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </form>
                                <div class="price">
                                    <ins class = "product_final_price">{{$product->final_price}}
                                        </ins>&nbsp;<span class="currency-type" style = "font-size: 15px;">{{$currency}}</span>
                                    <!-- <del>34,59 USD</del> -->
                                </div>
                                <button class="addtocart-btn btn addcart-btn  addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                    <span> {{ __('Add to cart') }} </span>
                                    <svg viewBox="0 0 10 5">
                                        <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12 pdp-center-column">
                        <div class="pdp-center-inner-sliders">
                            <div class="main-slider-wrp">
                                <div class="pdp-main-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="pdp-main-slider-itm">
                                        <div class="pdp-main-img">
                                            <img src="{{get_file($item->image_path , APP_THEME())}}">
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="pdp-thumb-wrap">
                                <div class="pdp-thumb-slider common-arrows">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                        <div class="pdp-thumb-slider-itm">
                                            <div class="pdp-thumb-img">
                                                <img src="{{get_file($item->image_path , APP_THEME())}}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="pdp-thumb-nav-wrap">
                                    <div class="pdp-thumb-nav">
                                    </div>
                                    <p>{{__('Slide slider')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 pdp-right-column">
                        <div class="pdp-right-column-inner">
                            <div class="product-description-right">
                                @auth
                                    <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly"
                                        product_id="{{ $product->id }}"
                                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                                        {{__('Add to wishlist')}}&nbsp;

                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                            ></i>
                                    </a>
                                @endauth
                                <div class="pdp-block pdp-info-block">
                                    <h5>{{__('Description:')}}</h5>
                                    <p>{{$product->description}}</p>
                                </div>
                                <div class="pdp-block pdp-variable">
                                    <h5>{{__('Abour Product:')}}</h5>
                                    @if ($product_stocks->isNotEmpty())
                                    <p><strong>{{__('SKU:')}}</strong> @foreach($product_stocks as $product_stock) {{$product_stock->sku}}, @endforeach</p>
                                    @endif
                                    <p><strong>{{__('Category:')}}</strong>{{$product->ProductData()->name}} Rings</p>
                                </div>
                                @foreach ($product_review->take(1) as $review)
                                    <div class="pdp-block">
                                        <h5>{{__('Ratings:')}}</h5>
                                        <div class="testimonials-card">
                                            <div class="testimonial-top d-flex align-items-center justify-content-between">
                                                <div class="reviews-stars-wrap d-flex align-items-center">
                                                    <div class="reviews-stars-outer">
                                                        @for ($i = 0; $i < 5; $i++)
                                                        <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                        @endfor
                                                    </div>
                                                    <div class="point-wrap">
                                                        <span class="review-point">{{$review->rating_no}} / <span>5.0</span></span>
                                                    </div>
                                                </div>
                                                <div class="customer-nam"><strong>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</strong> {{__('Client')}}</div>
                                            </div>
                                            <div class="reviews-words">
                                                <h4 class="main-word">{{$review->title}}</h4>
                                                <p class="description">{{$review->description}}</p>
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
        {{-- <section class="product-description-section padding-bottom padding-top">
            <div class="container">
                <div class="row row-gap">
                    <div class="col-md-6 col-12">
                        <div class="pro-descrip-contente-left">
                            <div class="section-title">
                                <div class="badge">
                                {{__('About product')}}
                                </div>
                                <h2>{{__('Description')}} </h2>
                            </div>
                            <p>{!! $description_value!!} </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="pro-descrip-contente-right">
                            <div class="section-title">
                                <div class="badge">
                                    {{__('About product')}}
                                </div>
                                <h2>{{__('About product')}} </h2>
                            </div>
                            <p>{!!$more_description_value!!} </p>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

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
                    <section class="product-description-section padding-bottom padding-top">
                        <div class="container">
                            <div class="row row-gap">
                                <div class="col-md-6 col-12">
                                    <div class="pro-descrip-contente-left">
                                        <div class="section-title">
                                            <div class="badge">
                                            {{__('About product')}}
                                            </div>
                                            <h2>{{__('Description')}} </h2>
                                        </div>
                                        <p>{!! $description_value!!} </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="pro-descrip-contente-right">
                                        <div class="section-title">
                                            <div class="badge">
                                                {{__('About product')}}
                                            </div>
                                            <h2>{{__('About product')}} </h2>
                                        </div>
                                        <p>{!!$more_description_value!!} </p>
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

        <section class="shop-reviews padding-bottom">
            <div class="section-left-shape">
                <img src="assets/images/section-left-img.png" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center row-gap">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="shop-reviews-left-inner">
                            @php
                                $homepage_best_product_text = $homepage_best_product_title = $homepage_best_product_sub = $homepage_best_product_btn = $homepage_best_product_img='';
                                $homepage_best_product_key = array_search('homepage-review', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-review-label-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-title-text') {
                                            $homepage_best_product_title = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-review-img') {
                                            $homepage_best_product_img = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="new-labl bg-second">
                            {!!$homepage_best_product_text!!}
                            </div>
                            <div class="section-title">
                                <h2 class="title">{!!$homepage_best_product_title!!}</h2>
                            </div>
                            <p>{!!$homepage_best_product_sub!!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn">
                                <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                            fill="white"></path>
                                    </svg>
                                </span>
                                {!!$homepage_best_product_btn!!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                    viewBox="0 0 4 6" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="shop-reviews-right-inner">
                            <div class="shop-reviews-image">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/green-mandarines.png') }}" alt="green-mandarines">
                            </div>
                            <div class="review-info-wrap">
                                <div class="review-box-wrapper">
                                    <div class="review-box-wrapper">
                                        <div class="">
                                            <div class="user-pro-list">
                                                <ul class="d-flex align-items-center">
                                                    <li>
                                                        <img src="{{get_file($homepage_best_product_img , APP_THEME())}}" alt="user1">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-bottom padding-top bestseller-section">
            <div class="container">
                @php
                    $homepage_best_product_text = $homepage_best_product_btn = '';
                    $homepage_best_product_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_best_product_key != '') {
                        $homepage_best_product = $theme_json[$homepage_best_product_key];

                        foreach ($homepage_best_product['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $homepage_best_product_text = $value['field_default_text'];
                            }

                            if ($value['field_slug'] == 'homepage-bestseller-btn-text') {
                                $homepage_best_product_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="section-title d-flex align-items-center justify-content-between">
                    <h2 class="title">{!! $homepage_best_product_text!!}</h2>
                    <a href="{{route('page.product-list',$slug)}}" class="btn">
                        {!! $homepage_best_product_btn!!}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill="white"></path>
                        </svg>
                    </a>
                </div>
                <div class="tabs-wrapper">
                    <div class="tab-nav">
                        <ul class="tabs">
                            @foreach ($MainCategory  as $cat_key =>  $category)
                            <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}"  data-tab="{{ $cat_key }}"><a href="javascript:;">{{$category}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                    @foreach ($MainCategory as $cat_k => $category)
                        <div   class="tabs-container ">
                            <div class="tab-content {{$cat_k == 0 ? 'active' : ''}}" id="{{ $cat_k }}">
                                <div class="product-row shop-protab-slider">
                                    @foreach ($bestSeller as  $data )
                                        @if($cat_k == '0' ||  $data->ProductData()->id == $cat_k)
                                        @php
                                            $p_id = hashidsencode($data->id);
                                        @endphp
                                        <div class="product-card">
                                            <div class="product-card-inner">
                                                <div class="product-card-image">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                                        <img src="{{get_file($data->cover_image_path , APP_THEME())}}" class="default-img">
                                                        @if ($data->Sub_image($data->id)['status'] == true)
                                                            <img src="{{ get_file($data->Sub_image($data->id)['data'][0]->image_path , APP_THEME()) }}"
                                                                class="hover-img">
                                                        @else
                                                            <img src="{{ get_file($data->Sub_image($data->id) , APP_THEME()) }}" class="hover-img">
                                                        @endif
                                                    </a>
                                                    @auth
                                                        <button class="wishlist-btn" tabindex="0" style="top: 1px;">
                                                            <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly" tabindex="0" product_id="{{$data->id}}" in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add'}}">
                                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" ></i>
                                                            </a>
                                                        </button>
                                                    @endauth
                                                </div>
                                                <div class="product-content">
                                                    <div class="product-content-top">
                                                        <div class="product-type">{{$data->tag_api}}</div>
                                                        <h3 class="product-title">
                                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                                {{ $data->name }}
                                                            </a>
                                                        </h3>
                                                        <div class="reviews-stars-wrap d-flex align-items-center">
                                                            <div class="reviews-stars-outer">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                <i class="ti ti-star review-stars {{ $i < $data->average_rating ? 'text-warning' : '' }} "></i>
                                                            @endfor
                                                            </div>
                                                            <div class="point-wrap">
                                                                <span class="review-point">{{$data->average_rating}} .0 / <span>5.0</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-bottom">
                                                        <div class="price">
                                                            <ins> {{ $data->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                                        </div>
                                                        <button class="addtocart-btn btn   addcart-btn-globaly" tabindex="0" product_id="{{ $data->id }}" variant_id="{{ $data->default_variant_id }}" qty="1">
                                                            <span> {{ __('Add to cart') }} </span>
                                                            <svg viewBox="0 0 10 5">
                                                                <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="testimonials padding-bottom padding-top">
            <div class="container">
                <div class="row align-items-center row-gap">
                    <div class="col-md-6 col-lg-4 col-12">
                        <div class="testimonials-left-inner">
                            @php
                                $homepage_best_product_text = $homepage_best_product_sub = $homepage_best_product_btn ='';
                                $homepage_best_product_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_best_product_key != '') {
                                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-testimonial-title-text') {
                                            $homepage_best_product_text = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-sub-text') {
                                            $homepage_best_product_sub = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-testimonial-btn-text') {
                                            $homepage_best_product_btn = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="section-title">
                                <h2 class="title">{!! $homepage_best_product_text!!}</h2>
                            </div>
                            <p>{!! $homepage_best_product_sub!!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn">
                                <span class="first-icon"><svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                            fill="white"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                            fill="white"></path>
                                    </svg></span>
                                {!! $homepage_best_product_btn!!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                                    viewBox="0 0 4 6" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                        fill="white"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-8 col-12">
                        <div class="review-slider">
                            @foreach ($product_review as $review)
                            <div class="testimonials-card">
                                <div class="testimonials-inner">
                                    <div class="top-card">
                                        <div class="reviews-stars-wrap d-flex align-items-center">
                                            <div class="reviews-stars-outer">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                @endfor
                                            </div>
                                            <div class="point-wrap">
                                                <span class="review-point">{{ $review->rating_no }} /
                                                    <span>5.0</span></span>
                                            </div>
                                        </div>
                                        <div class="reviews-words">
                                            <h1 class="main-word name">{{ $review->title }}</h1>
                                            <p class="descriptions">{{ $review->description }}</p>
                                        </div>
                                    </div>
                                    <div class="reviewer-profile">
                                        <div class="reviewer-img">
                                            <img src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}"
                                                alt="reviewer-img">
                                        </div>
                                        <div class="reviewer-desc">
                                            <span><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }},</b>
                                                {{ __('Client') }}</span>
                                            <p>{{ __('about') }} <a href="{{ route('page.product', [$slug,$p_id]) }}"
                                                    tabindex="0">{{ $product->name }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="home-blog-section padding-bottom">
            <div class="container">
                @php
                    $homepage_best_product_text = $homepage_best_product_title = $homepage_best_product_sub = '';
                    $homepage_best_product_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_best_product_key != '') {
                        $homepage_best_product = $theme_json[$homepage_best_product_key];

                        foreach ($homepage_best_product['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $homepage_best_product_text = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_best_product_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_best_product_sub = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="section-title">
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <div class="tagline">{!! $homepage_best_product_text !!}</div>
                        <h2 class="title">{!! $homepage_best_product_title !!}</h2>
                        <div class="descripion">
                            <p>{!! $homepage_best_product_sub !!} </p>
                        </div>
                    @endif
                </div>
                <div class="row justify-content-center">
                    {!! \App\Models\Blog::HomePageBlog(4) !!}
                </div>
            </div>
        </section>
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
                url: '{{ route('product.price',$slug) }}',
                method: 'POST',
                data: data,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
