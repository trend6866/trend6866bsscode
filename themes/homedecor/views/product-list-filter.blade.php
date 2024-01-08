
<div class="row">
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-card">
            <div class="product-card-inner">
                <div class="product-card-image">
                    <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}" class="product-img">
                        <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                    </a>
                    @auth
                    <div class="new-labl">
                        <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" style="color:black;" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                            <span class="wish-ic">
                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                            </span>
                        </a>
                    </div>
                    @endauth
                </div>
                <div class="product-content">
                    <div class="product-content-top">
                        <div class="review-star">
                            <span>{{ $product->tag_api }}</span>
                            <div class="d-flex align-items-center">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star review-stars {{ $i < $product->average_rating ? 'text-warning' : '' }} "></i>
                                @endfor
                            </div>
                        </div>
                        <h3 class="product-title">
                            <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}"> {{ $product->name }}</a></h3>
                    </div>
                    <div class="product-content-bottom">
                        <div class="price">
                            <ins>{{ $product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                        </div>
                        <a href="javascript:void(0)" class="link-btn dark-link-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                            {{ __('Add to cart') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                    fill=""></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@php
    $page_no = !empty($page) ? $page : 1;
@endphp
{{ $products->onEachSide(0)->links() }}
