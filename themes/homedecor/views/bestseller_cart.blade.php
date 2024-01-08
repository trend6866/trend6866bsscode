 @php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp
<div class="container">
    @php
        $homepage_product_title = $homepage_product_btn = '';
            $homepage_product_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
            if($homepage_product_key != ''){
                $homepage_product = $theme_json[$homepage_product_key];

                foreach ($homepage_product['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-products-title-text'){
                        $homepage_product_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-products-btn-text'){
                        $homepage_product_btn = $value['field_default_text'];
                    }
                }
            }
    @endphp
    <div class="section-title row   align-items-center justify-content-between">
        <div class="col-md-6">
            <h3>{!! $homepage_product_title !!}</h3>
            <ul class="cat-tab tabs">
                @foreach ($MainCategory as $cat_key =>  $category)
                    <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}" >
                        <a href="javascript:;">{{ $category }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color">
                {!! $homepage_product_btn !!}
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                        fill=""></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="tabs-container">
        @foreach ($MainCategory as $cat_k => $category)
            <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                <div class="shop-protab-slider">
                    @foreach($homeproducts as $product)
                        @php
                            $p_id = hashidsencode($product->id);
                        @endphp
                        @if($cat_k == '0' ||  $product->ProductData()->id == $cat_k)
                        <div class="shop-protab-itm product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="product-img">
                                        <img src="{{get_file($product->cover_image_path , APP_THEME())}}" class="default-img" alt="bestsell">
                                    </a>
                                    <div class="new-labl">
                                        @auth
                                            <a href="javascript:void(0)" class="wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}" >
                                                <span class="wish-ic">
                                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style="color:black;"></i>
                                                </span>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <div class="review-star">
                                            <span>{{ $product->ProductData()->name }}</span>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                                @endfor
                                                <span class="star-count">{{$product->average_rating}}.0 / <b> 5.0</b></span>
                                            </div>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{route('page.product',[$slug,$p_id])}}"> {{$product->name}}</a>
                                        </h3>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="price">
                                            <ins>{{$product->final_price}} <span class="currency-type">{{ $currency }}</span></ins>
                                        </div>
                                        <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                            {{ __('Add to cart') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                viewBox="0 0 4 6" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                    fill=""></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
