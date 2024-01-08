@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = \App\Models\Utility::GetValueByName('CURRENCY');
@endphp

<div class="container">
    @php
        $homepage_header_1_key = array_search('homepage-feature-product', array_column($theme_json, 'unique_section_slug'));
        if($homepage_header_1_key != '' ) {
            $homepage_header_1 = $theme_json[$homepage_header_1_key];
            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-feature-product-label-text') {
                    $category_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-feature-product-title-text') {
                    $category_text = $value['field_default_text'];
                }
            }
        }
    @endphp
    {{-- @if($homepage_header_1['section_enable'] == 'on') --}}
    <div class="section-title">
        <div class="subtitle">{{$category_title}}</div>
        <h2>{!! $category_text !!}</h2>
    </div>
    {{-- @endif --}}
    <div class="pro-categorie-slider dark-arrow">
        @foreach($homeproducts as $homeproduct)
        @php
            $p_id = hashidsencode($homeproduct->id);
        @endphp
        <div class="pro-cate-itm product-card">
            <div class="product-card-inner">
                <div class="product-img">
                    <a href="{{route('page.product',[$slug,$p_id])}}">
                        <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}">
                        <span class="offer-lbl">{{$homeproduct->discount_amount}}
                            @if($homeproduct->discount_type == 'percentage') %  @else {{$currency_icon}} @endif
                        </span>
                    </a>
                </div>
                <div class="product-content">
                    <div class="product-content-top">
                        <div class="d-flex justify-content-end wsh-wrp">
                            <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                                <span class="wish-ic">
                                    <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                        style='color: rgb(255, 254, 254)'></i>
                                </span>
                            </a>
                        </div>
                        <div class="subtitle">{{$homeproduct->tag_api}}</div>
                        <h3><a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">{{$homeproduct->name}}</a></h3>
                    </div>
                    <div class="product-content-bottom">
                        <div class="main-price d-flex align-items-center justify-content-between">
                            <div class="price">
                                <ins>{{$homeproduct->final_price}}{{$currency}}</ins>
                            </div>
                            <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                + {{ __('ADD TO CART')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
