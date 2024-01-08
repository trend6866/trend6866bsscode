
@php
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

@foreach($lat_products as $product)
    @php
        $p_id = hashidsencode($product->id);
    @endphp
    <div class="col-md-4 col-sm-6 col-12 product-list-col">
        <div class="product-card card">
            <div class="product-card-inner card-inner">
                <div class="product-content-top ">
                    <div class="new-labl">
                        {{$product->tag_api}}
                    </div>
                    <h4 class="product-title">
                        <a href="{{route('page.product',[$slug,$p_id])}}">
                            {{$product->name}}
                        </a>
                    </h4>
                    {{-- <div class="product-type">{{ $product->name }}</div> --}}
                </div>
                <div class="product-card-image">
                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                        <img src="{{get_file($product->cover_image_path , APP_THEME())}}" class="default-img">
                    </a>
                </div>
                <div class="product-content-bottom">
                    <div class="price">
                        <ins>{{$product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                    </div>
                    <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1" tabindex="0">
                        <span> {{__('Add to cart')}}</span>
                        <span class="roun-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                viewBox="0 0 9 9" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                    fill="white" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
