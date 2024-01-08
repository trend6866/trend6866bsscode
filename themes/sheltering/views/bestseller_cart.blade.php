@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

<div class="container">
    @php
        $homepage_header_1_key = array_search('homepage-best-product', array_column($theme_json, 'unique_section_slug'));
        if($homepage_header_1_key != '' ) {
            $homepage_header_1 = $theme_json[$homepage_header_1_key];
            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-best-product-title-text') {
                    $product_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-best-product-sub-text') {
                    $product_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-best-product-btn-text') {
                    $product_btn = $value['field_default_text'];
                }
            }
        }
    @endphp
    {{-- @if($homepage_header_1['section_enable'] == 'on') --}}
    <div class="section-title d-flex justify-content-between align-items-center">
        <div class="section-title-left">
            <h2>{!! $product_title !!}</h2>
        </div>
        <div class="section-title-center">
            <p>{{$product_text}}</p>
        </div>
        <div class="section-title-right">
            <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                {{$product_btn}}
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                    <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                    <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                    <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                </svg>
            </a>
        </div>
    </div>
    {{-- @endif --}}
    <div class="product-extra-slider dark-contnt">
        @foreach ($homeproducts as $all_product)
        @php
            $p_id = hashidsencode($all_product->id);
        @endphp
        <div class="product-card">
            <div class="product-card-inner">
            <div class="card-top">
                <span class="slide-label">{{$all_product->tag_api}}</span>
                @auth
                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$all_product->id}}" in_wishlist="{{ $all_product->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $all_product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: #000000'></i>
                        </span>
                    </a>
                @endauth
            </div>
            <h4 class="product-title">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    {{$all_product->name}}
                </a>
            </h4>
            {{-- <ul class="product-number">
                <li>
                    CPU: i7-9700K
                </li>
                <li>
                    GPU: ASF 1190A
                </li>
            </ul> --}}
            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    <img src="{{ get_file($all_product->cover_image_path , APP_THEME()) }}" class="default-img">
                    @if($all_product->Sub_image($all_product->id)['status'] == true)
                        <img src="{{ get_file($all_product->Sub_image($all_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                    @else
                        <img src="{{ get_file($all_product->Sub_image($all_product->id) , APP_THEME()) }}" class="hover-img">
                    @endif
                </a>
            </div>
            <div class="product-content">
                {{-- <div class="product-content-top">
                    <div class="pro-labl">CPU:</div>
                    <div class="slide-select-box">
                        <div class="nice-select" tabindex="0"><span class="current">i7-9700K</span>
                            <ul class="list">
                                <li data-value="Gray Pot (20cm)" data-display="Gray Pot (20cm)"
                                    class="option selected">i7-9700K</li>
                                <li data-value="1" class="option">i2-700K</li>
                                <li data-value="2" class="option">Another option</li>
                                <li data-value="4" class="option">i4-7200K</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    <div class="price">
                        <ins>{{$all_product->final_price}}
                            <span class="currency-type">{{$currency}}</span>
                        </ins>
                    </div>
                    <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $all_product->id }}" variant_id="{{ $all_product->default_variant_id }}" qty="1">
                        {{ __('Add to cart')}}
                    </a>
                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
