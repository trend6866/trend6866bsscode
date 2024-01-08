@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

@foreach($homeproducts as $homeproduct)
    @php
        $p_id = hashidsencode($homeproduct->id);
    @endphp
    <div class="product-card">
        <div class="product-card-inner">
            <div class="card-top">
                <span class="slide-label">{{$homeproduct->tag_api}}</span>
                @auth
                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: #000000'></i>
                        </span>
                    </a>
                @endauth
            </div>
            <h4 class="product-title">
                <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                    {{$homeproduct->name}}
                </a>
            </h4>
            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}" class="default-img">
                    @if($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                        <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                    @else
                        <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id) , APP_THEME()) }}" class="hover-img">
                    @endif
                </a>
            </div>
            <div class="product-content">
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    <div class="price">
                        <ins>{{$homeproduct->final_price}}
                            <span class="currency-type">{{$currency}}</span>
                        </ins>
                    </div>
                    <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                        {{ __('Add to cart')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
