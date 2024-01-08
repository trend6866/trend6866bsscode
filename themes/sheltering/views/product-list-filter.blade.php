
@foreach ($products as $product)

@php
    $p_id = hashidsencode($product->id);
@endphp

    <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-card">
        <div class="product-card-inner">
        <div class="card-top">
            <span class="slide-label">{{ $product->tag_api }}</span>
            @auth
                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                    <span class="wish-ic">
                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: black'></i>
                    </span>
                </a>
            @endauth
        </div>
        <h4 class="product-title">
            <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                {{$product->name}}
            </a>
        </h4>
        <div class="product-card-image">
            <a href="{{route('page.product',[$slug,$p_id])}}">
                <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                @if($product->Sub_image($product->id)['status'] == true)
                    <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                @else
                    <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                @endif
            </a>
        </div>
        <div class="product-content">
            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                <div class="price">
                    <ins>{{$product->final_price}}{{$currency}}</ins>
                </div>
                <a href="cart.html" class="btn-primary add-cart-btn addcart-btn-globaly" type="submit" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                    {{ __('Add to cart')}}
                </a>
            </div>
        </div>
        </div>
    </div>

@endforeach

@php
    $page_no = !empty($page) ? $page : 1;
@endphp

<div class="d-flex justify-content-center col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination" style="color:black; margin-left: 680px;" >
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
