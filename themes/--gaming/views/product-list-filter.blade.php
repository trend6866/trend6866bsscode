
@foreach ($products as $product)
@php
    $p_id = hashidsencode($product->id);
@endphp

    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 product-card">
        <div class="product-card-inner">
            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                </a>
                <div class="new-labl  danger">
                    <span class="discount-rate">{{$product->discount_amount}}
                        @if($product->discount_type == 'percentage') %  @else  {{$currency_icon}} @endif
                    </span>
                </div>
            </div>
            <div class="product-content">
                <div class="product-content-top d-flex align-items-end">
                    <div class="product-content-left">
                        <div class="product-type">{{$product->tag_api}}</div>
                        <h3 class="product-title">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                {{$product->name}}
                            </a>
                        </h3>
                        <div class="reviews-stars-wrap d-flex align-items-center">
                            @if (!empty($product->average_rating))
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star {{ $i < $product->average_rating ? '' : 'text-warning' }} "></i>
                                @endfor
                                <span><b>{{ $product->average_rating }}.0</b> / 5.0</span>
                            @else
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star {{ $i < $product->average_rating ? '' : 'text-warning' }} "></i>
                                @endfor
                                <span><b>{{ $product->average_rating }}.0</b> / 5.0</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="product-content-center">
                    <div class="price">
                        <ins class="text-danger">{{$product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                        <del>{{$product->price}} {{$currency}}</del>
                    </div>
                </div>
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    <button class="btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                        <span> {{ __('Add to cart')}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6"
                            viewBox="0 0 4 6" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                fill="white"></path>
                        </svg>
                    </button>
                    @auth
                        <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                            <span class="wish-ic">
                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                    style='color: #000000'></i>
                            </span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

@endforeach


@php
    $page_no = !empty($page) ? $page : 1;
@endphp

<div class="d-flex justify-content-end col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination">
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
