
@extends('layouts.layouts')

@php
$p_name = json_decode($products);
@endphp

@section('page-title')
{{ __($p_name[0]->name) }}
@endsection
<style>
.boxed label{
    border: 1px solid var(--black) !important;
    border-radius: 30px !important;
    padding: 10px 15px !important;
}
.custom-radio-btn:checked + label{
   background-color: black;
   color:white;
}
</style>

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
        <section class="main-product-first-section">
            @php
                $product_ids = hashidsencode($product->id);
            @endphp
            <div class="offset-container offset-left">
                <div class="row no-gutters order">
                    <div class="col-xl-5 col-lg-4 col-md-6 col-12">
                        <div class="product-summery-column">
                            <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z" fill="white"></path>
                                    </svg>
                                </span>
                                {{ __('Back to category')}}
                            </a>
                            @auth
                                <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}" style="margin-left:55%;">
                                    <span class="wish-ic">
                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                    </span>
                                    {{ __('Add to wishlist') }}
                                </a>
                            @endauth
                            <div class="section-title">
                                <span class="subtitle"> {{ $product->ProductData()->name }}</span>
                                <h2>
                                    {{ $product->name }}
                                </h2>
                            </div>
                            <p>{{$product->description}}</p><br>

                            <form class="variant_form w-100">
                                @csrf
                                <div class="prorow-lbl-qntty">
                                    <div class="product-labl d-block">{{__('quantity')}} :</div>
                                    <div class="qty-spinner" style="background: white;">
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
                                </div><br>
                                <div class="pro-swatch">
                                    @if ($product->variant_product == 1)
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
                                        <span class="swatch-lbl subtitle">
                                            {{$attribute->name }} :
                                        </span>
                                        @if ($attribute->type != 'collection_horizontal')
                                            <select class="custom-select-btn variont_option" name="varint[{{ $attribute->name }}]"  >
                                                @foreach ($value->values as $variant1)
                                                    <option {{ in_array($variant1, $varint_name_array) ? 'selected' : '' }} >{{$variant1}}</option>
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
                                    @endforeach
                                    @endif
                                </div>
                                <div class="cart-price">
                                    <a href="javascript:void(0)" class="btn-secondary addtocart-btn-cart addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21665 8.50065C3.9978 8.50065 3.83133 8.69717 3.86731 8.91304L4.54572 12.9836C4.65957 13.6667 5.25059 14.1673 5.94311 14.1673H11.0594C11.7519 14.1673 12.3429 13.6667 12.4568 12.9836L13.1352 8.91304C13.1712 8.69717 13.0047 8.50065 12.7859 8.50065H4.21665ZM2.96241 7.08398C2.52471 7.08398 2.19176 7.47702 2.26372 7.90877L3.14833 13.2164C3.37603 14.5826 4.55807 15.584 5.94311 15.584H11.0594C12.4444 15.584 13.6265 14.5826 13.8542 13.2164L14.7388 7.90877C14.8107 7.47702 14.4778 7.08398 14.0401 7.08398H2.96241Z" fill="#12131A"/>
                                            <path d="M7.08333 9.91602C6.69213 9.91602 6.375 10.2331 6.375 10.6243V12.041C6.375 12.4322 6.69213 12.7493 7.08333 12.7493C7.47453 12.7493 7.79167 12.4322 7.79167 12.041V10.6243C7.79167 10.2331 7.47453 9.91602 7.08333 9.91602Z" fill="#12131A"/>
                                            <path d="M9.91667 9.91602C9.52547 9.91602 9.20833 10.2331 9.20833 10.6243V12.041C9.20833 12.4322 9.52547 12.7493 9.91667 12.7493C10.3079 12.7493 10.625 12.4322 10.625 12.041V10.6243C10.625 10.2331 10.3079 9.91602 9.91667 9.91602Z" fill="#12131A"/>
                                            <path d="M7.5855 2.62522C7.86212 2.34859 7.86212 1.9001 7.5855 1.62348C7.30888 1.34686 6.86039 1.34686 6.58377 1.62348L3.75043 4.45682C3.47381 4.73344 3.47381 5.18193 3.75043 5.45855C4.02706 5.73517 4.47555 5.73517 4.75217 5.45855L7.5855 2.62522Z" fill="#12131A"/>
                                            <path d="M9.4171 2.62522C9.14048 2.34859 9.14048 1.9001 9.4171 1.62348C9.69372 1.34686 10.1422 1.34686 10.4188 1.62348L13.2522 4.45682C13.5288 4.73344 13.5288 5.18193 13.2522 5.45855C12.9755 5.73517 12.5271 5.73517 12.2504 5.45855L9.4171 2.62522Z" fill="#12131A"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4596 5.66667H3.54297C3.15177 5.66667 2.83464 5.9838 2.83464 6.375C2.83464 6.7662 3.15177 7.08333 3.54297 7.08333H13.4596C13.8508 7.08333 14.168 6.7662 14.168 6.375C14.168 5.9838 13.8508 5.66667 13.4596 5.66667ZM3.54297 4.25C2.36936 4.25 1.41797 5.20139 1.41797 6.375C1.41797 7.5486 2.36936 8.5 3.54297 8.5H13.4596C14.6332 8.5 15.5846 7.5486 15.5846 6.375C15.5846 5.20139 14.6332 4.25 13.4596 4.25H3.54297Z" fill="#12131A"/>
                                        </svg>
                                        {{__('Add to cart')}}
                                    </a>
                                    <div class="price">
                                    <ins><span class="product_final_price"> {{ $product->final_price }} </span>
                                            <span class="currency-type">{{ $currency }}</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 pdp-left-column">
                        <div class="pdp-left-inner-sliders">
                            <div class="pdp-main-slider">
                                @foreach ($product->Sub_image($product->id)['data'] as $item)
                                <div class="pdp-main-slider-itm">
                                    <div class="pdp-main-img">
                                        <img src="{{ get_file($item->image_path ,APP_THEME()) }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 pdp-left-column-2">
                        <div class="pdp-left-inner-sliderss">
                            <div class="pdp-thumb-slider">
                                @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="pdp-thumb-slider-itm">
                                        <div class="pdp-thumb-inner">
                                            <div class="pdp-thumb-img">
                                                <div class="thumb-img">
                                                    <img src="{{ get_file($item->image_path , APP_THEME()) }}">
                                                </div>
                                            </div>
                                            {{-- <div class="pdp-thumb-content">
                                                <div class="content-title">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6295 3.52275C10.2777 3.85668 9.7223 3.85668 9.37055 3.52275L8.74109 2.92517C8.00434 2.22574 7.00903 1.79867 5.90909 1.79867C3.64974 1.79867 1.81818 3.61057 1.81818 5.84567C1.81818 7.98845 2.99071 9.75782 4.68342 11.2116C6.37756 12.6666 8.40309 13.6316 9.61331 14.1241C9.86636 14.2271 10.1336 14.2271 10.3867 14.1241C11.5969 13.6316 13.6224 12.6666 15.3166 11.2116C17.0093 9.75782 18.1818 7.98845 18.1818 5.84567C18.1818 3.61057 16.3503 1.79867 14.0909 1.79867C12.991 1.79867 11.9957 2.22574 11.2589 2.92517L10.6295 3.52275ZM10 1.62741C8.93828 0.619465 7.49681 0 5.90909 0C2.64559 0 0 2.6172 0 5.84567C0 11.5729 6.33668 14.7356 8.92163 15.7875C9.61779 16.0708 10.3822 16.0708 11.0784 15.7875C13.6633 14.7356 20 11.5729 20 5.84567C20 2.6172 17.3544 0 14.0909 0C12.5032 0 11.0617 0.619465 10 1.62741Z" fill="#051512"></path>
                                                    </svg>
                                                    <div class="subtitle">
                                                        <span> Kitchen.</span>
                                                    </div>
                                                    <h4>Modern kitchen <br> <b>accessories</b></h4>
                                                    <div class="price">
                                                        <ins>2,490.00 <span class="currency-type">USD</span></ins>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

                        <div id="2" class="tab-content active ">
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

        @php
            $homepage_best_product_heading = $homepage_best_product_subtext = $homepage_best_product_btn = '';
                $homepage_best_product_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_best_product_key != ''){
                    $homepage_best_product = $theme_json[$homepage_best_product_key];

                    foreach ($homepage_best_product['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-products-label-text'){
                            $homepage_best_product_label = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-title-text'){
                            $homepage_best_product_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-sub-text'){
                            $homepage_best_product_subtext = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-btn-text-1'){
                            $homepage_best_product_btn1 = $value['field_default_text'];
                        }
                    }
                }
        @endphp
        @if($homepage_best_product['section_enable'] == 'on')
            <section class="image-accessories-section padding-top padding-bottom">
                <div class="container">
                    <div class="row align-items-center justify-content-between order">
                        <div class="col-lg-5 col-md-6 col-12">
                            <div class="accessories-image">
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/product-page-secong-section-image.png')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="accessories-right-side-inner">
                                <div class="accessories-right-side-content">
                                    <div class="section-title">
                                        <span class="subtitle">{!! $homepage_best_product_label !!}</span>
                                        <h2>{!! $homepage_best_product_text !!}</h2>
                                    </div>
                                    <p>{!! $homepage_best_product_subtext !!}</p>
                                    <a href="{{route('page.product-list',$slug)}}" class="btn-secondary" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                                        </svg>
                                        {!! $homepage_best_product_btn1 !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if($product_review->isNotEmpty())
            @php
                $homepage_testimonials_heading = '';

                $homepage_testimonials_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                if($homepage_testimonials_key != '') {
                    $homepage_testimonials = $theme_json[$homepage_testimonials_key];

                foreach ($homepage_testimonials['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-testimonial-title-text') {
                    $homepage_testimonials_heading = $value['field_default_text'];
                    }
                }
                }
            @endphp
            @if($homepage_testimonials['section_enable'] == 'on')
                <section class="testimonials-section padding-bottom">
                    <div class="container">
                        <div class="section-title padding-top">
                            <h2>
                                <b>{!! $homepage_testimonials_heading !!}</b>
                            </h2>
                        </div>
                        <div class="testimonial-slider">
                            @foreach ($product_review as $review)
                                <div class="testimonial-itm">
                                    <div class="testimonial-itm-inner">
                                        <div class="testimonial-itm-content">
                                            <span>{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}, {{$review->UserData->type}}</span>
                                            <div class="testimonial-content-top">
                                                <h3 class="testimonial-title">
                                                    {{$review->title}}
                                                </h3>
                                            </div>
                                            <p class="descriptions">{{$review->description}}</p>
                                            <div class="testimonial-star">
                                                <div class="d-flex align-items-center">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                    @endfor
                                                    <span class="star-count">{{$review->rating_no}}.5 / <b> 5.0</b></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial-itm-image">
                                            <a href="#" tabindex="0">
                                                <img src="{{asset('/'. !empty($review->ProductData()) ? $review->ProductData->cover_image_path : '' )}}" class="default-img" alt="review">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endif
        @php
            $homepage_bestseller_product = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_bestseller_product != '')
            {
                $homepage_bestseller = $theme_json[$homepage_bestseller_product];
                $section_enable = $homepage_bestseller['section_enable'];
                foreach ($homepage_bestseller['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-bestseller-title-text') {
                        $home_bestseller_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-bestseller-btn-text') {
                        $home_bestseller_btn = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_bestseller['section_enable'] == 'on')
            <section class="bestseller-section bst-3">
                <div class="best-seller-head">
                    <div class="section-title">
                        <h4>{!! $home_bestseller_text !!}</h4>
                    </div>
                    <a href="{{route('page.product-list',$slug)}}" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39025 12.636V11.06L14.2425 4.756C15.2525 3.668 15.2525 1.904 14.2425 0.816001C13.2324 -0.272 11.5949 -0.272 10.5848 0.816001L0.539316 11.637C-0.612777 12.878 0.203182 15 1.83249 15H6.19566C7.4077 15 8.39025 13.9416 8.39025 12.636ZM6.92719 11.0601L5.03558 9.02244L1.57385 12.7514C1.34343 12.9996 1.50663 13.424 1.83249 13.424H6.19566C6.59968 13.424 6.92719 13.0712 6.92719 12.636V11.0601ZM6.13287 7.84044L11.6194 1.9304C12.058 1.45787 12.7693 1.45787 13.2079 1.9304C13.6466 2.40294 13.6466 3.16907 13.2079 3.6416L7.72144 9.55164L6.13287 7.84044Z" fill="#CDC6BE"></path>
                        </svg>
                        <span> {!! $home_bestseller_btn !!}</span>
                    </a>
                </div>
                <div class="container">
                    <div class="bessell-row row no-gutters">
                        @foreach ($bestSeller->take(3) as $bs_product)
                            <div class="col-md-4 col-sm-4 col-12 product-card">
                                @php
                                    $p_id = hashidsencode($bs_product->id);
                                @endphp
                                <div class="product-card-inner">
                                    <div class="pro-img">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            <img src="{{ get_file($bs_product->cover_image_path , APP_THEME()) }}">
                                        </a>
                                    </div>
                                    <div class="pro-content">
                                        <div class="pro-content-inner">
                                            <div class="pro-content-top">
                                                <div class="content-title">
                                                    <div class="subtitle">
                                                        <span>{{ $bs_product->ProductData()->name }}</span>
                                                        @auth
                                                            <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$bs_product->id}}" in_wishlist="{{ $bs_product->in_whishlist ? 'remove' : 'add'}}" >
                                                                <span class="wish-ic">
                                                                    <i class="{{ $bs_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                </span>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                    <h4><a href="{{route('page.product',[$slug,$p_id])}}"> {{ $bs_product->name }}</a></h4>
                                                </div>
                                            </div>
                                            <div class="price">
                                                <ins>{{ $bs_product->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                            </div>
                                            <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $bs_product->id }}" variant_id="{{ $bs_product->default_variant_id }}" qty="1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21665 8.50065C3.9978 8.50065 3.83133 8.69717 3.86731 8.91304L4.54572 12.9836C4.65957 13.6667 5.25059 14.1673 5.94311 14.1673H11.0594C11.7519 14.1673 12.3429 13.6667 12.4568 12.9836L13.1352 8.91304C13.1712 8.69717 13.0047 8.50065 12.7859 8.50065H4.21665ZM2.96241 7.08398C2.52471 7.08398 2.19176 7.47702 2.26372 7.90877L3.14833 13.2164C3.37603 14.5826 4.55807 15.584 5.94311 15.584H11.0594C12.4444 15.584 13.6265 14.5826 13.8542 13.2164L14.7388 7.90877C14.8107 7.47702 14.4778 7.08398 14.0401 7.08398H2.96241Z" fill="#12131A"/>
                                                    <path d="M7.08333 9.91602C6.69213 9.91602 6.375 10.2331 6.375 10.6243V12.041C6.375 12.4322 6.69213 12.7493 7.08333 12.7493C7.47453 12.7493 7.79167 12.4322 7.79167 12.041V10.6243C7.79167 10.2331 7.47453 9.91602 7.08333 9.91602Z" fill="#12131A"/>
                                                    <path d="M9.91667 9.91602C9.52547 9.91602 9.20833 10.2331 9.20833 10.6243V12.041C9.20833 12.4322 9.52547 12.7493 9.91667 12.7493C10.3079 12.7493 10.625 12.4322 10.625 12.041V10.6243C10.625 10.2331 10.3079 9.91602 9.91667 9.91602Z" fill="#12131A"/>
                                                    <path d="M7.5855 2.62522C7.86212 2.34859 7.86212 1.9001 7.5855 1.62348C7.30888 1.34686 6.86039 1.34686 6.58377 1.62348L3.75043 4.45682C3.47381 4.73344 3.47381 5.18193 3.75043 5.45855C4.02706 5.73517 4.47555 5.73517 4.75217 5.45855L7.5855 2.62522Z" fill="#12131A"/>
                                                    <path d="M9.4171 2.62522C9.14048 2.34859 9.14048 1.9001 9.4171 1.62348C9.69372 1.34686 10.1422 1.34686 10.4188 1.62348L13.2522 4.45682C13.5288 4.73344 13.5288 5.18193 13.2522 5.45855C12.9755 5.73517 12.5271 5.73517 12.2504 5.45855L9.4171 2.62522Z" fill="#12131A"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4596 5.66667H3.54297C3.15177 5.66667 2.83464 5.9838 2.83464 6.375C2.83464 6.7662 3.15177 7.08333 3.54297 7.08333H13.4596C13.8508 7.08333 14.168 6.7662 14.168 6.375C14.168 5.9838 13.8508 5.66667 13.4596 5.66667ZM3.54297 4.25C2.36936 4.25 1.41797 5.20139 1.41797 6.375C1.41797 7.5486 2.36936 8.5 3.54297 8.5H13.4596C14.6332 8.5 15.5846 7.5486 15.5846 6.375C15.5846 5.20139 14.6332 4.25 13.4596 4.25H3.54297Z" fill="#12131A"/>
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
            </section>
        @endif

        @php
            $homepage_subscribe = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_subscribe != '')
            {
                $home_subscribe = $theme_json[$homepage_subscribe];
                $section_enable = $home_subscribe['section_enable'];
                foreach ($home_subscribe['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-newsletter-label-text') {
                        $home_subscribe_label= $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-newsletter-title-text') {
                        $home_subscribe_text= $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                        $home_subscribe_sub_text= $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-newsletter-description') {
                        $home_subscribe_description = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-newsletter-image') {
                        $home_subscribe_image= $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($home_subscribe['section_enable'] == 'on')
            <section class="form-section form-bg padding-top padding-bottom" style="background-image: url({{ get_file($home_subscribe_image , APP_THEME()) }});">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="left-slide-itm-inner">
                                <div class="section-title">
                                    <span class="subtitle">{!! $home_subscribe_label !!}</span>
                                    <h2>{!! $home_subscribe_text !!}</h2>
                                </div>
                                <p>{!! $home_subscribe_sub_text !!}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <form class="" action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                                <div class="form-subscribe">
                                    <span>{{__('Type your email:')}}</span>
                                    <div class="input-wrapper">
                                        <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                        <button class="btn-subscibe">{{__('Subscribe')}}</button>
                                    </div>
                                    <label for="FotterCheckbox">{!! $home_subscribe_description !!}</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @php
            $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
            $section_enable = 'on';
            if($homepage_blog != '')
            {
                $home_blog = $theme_json[$homepage_blog];
                $section_enable = $home_blog['section_enable'];
                foreach ($home_blog['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-blog-title-text') {
                        $home_blog_text = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($home_blog['section_enable'] == 'on')
            <section class="blog-section padding-top padding-bottom">
                <div class="container">
                    <div class="section-title">
                        <h2>
                            <b>{!! $home_blog_text !!}</b>
                        </h2>
                    </div>
                    <div class="about-card-slider">
                        {!! \App\Models\Blog::HomePageBlog(10) !!}
                    </div>
                </div>
            </section>
        @endif
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

