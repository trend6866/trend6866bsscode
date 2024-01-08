<div class="row">
    @foreach ($products as $product)
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 product-page-card">
        @php
            $p_id = hashidsencode($product->id);
        @endphp
         <div class="product-card-inner">
            <div class="product-image">
                <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                    <img src="{{get_file($product->cover_image_path),APP_THEME()}}">
                </a>
                <span class="badge">{{ $product->tag_api }}</span>
            </div>
            <div class="product-content">
                <div class="product-cont-top">
                    <div class="subtitle">
                        <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.36364C0 1.05824 1.09442 0 2.44444 0H7.54303C8.19134 0 8.8131 0.249025 9.27152 0.692293L10.284 1.67134C10.7425 2.11461 11 2.71581 11 3.34269V10.6364C11 11.9418 9.90558 13 8.55556 13H2.44444C1.09441 13 0 11.9418 0 10.6364V2.36364ZM9.77778 4.13636V10.6364C9.77778 11.2891 9.23057 11.8182 8.55556 11.8182H2.44444C1.76943 11.8182 1.22222 11.2891 1.22222 10.6364V2.36364C1.22222 1.71094 1.76943 1.18182 2.44444 1.18182H6.72222V2.36364C6.72222 3.34269 7.54303 4.13636 8.55556 4.13636H9.77778ZM9.70998 2.95455C9.64997 2.78767 9.55145 2.63432 9.4198 2.50702L8.40728 1.52796C8.27562 1.40066 8.11702 1.3054 7.94444 1.24737V2.36364C7.94444 2.68999 8.21805 2.95455 8.55556 2.95455H9.70998Z" fill="#E8BA96"/>
                                <path d="M3.625 7C3.27982 7 3 7.22386 3 7.5C3 7.77614 3.27982 8 3.625 8H7.375C7.72018 8 8 7.77614 8 7.5C8 7.22386 7.72018 7 7.375 7H3.625Z" fill="#E8BA96"/>
                                <path d="M3.625 9C3.27982 9 3 9.22386 3 9.5C3 9.77614 3.27982 10 3.625 10H5.5C5.84518 10 6.125 9.77614 6.125 9.5C6.125 9.22386 5.84518 9 5.5 9H3.625Z" fill="#E8BA96"/>
                            </svg>
                            Get Sample
                        </a>
                    </div>
                    <div class="prouct-card-heading long_sting_to_dot">
                        <h5>
                            <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">{{ $product->name }}</a>
                        </h5>
                        <div class="play-time">
                            @auth
                                <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                    <span class="wish-ic">
                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                    <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                </span>
                                </a>
                            @endauth

                        </div>
                    </div>
                    <p>{{ $product->ProductData()->name }}</p>
                </div>
                <div class="product-cont-bottom">

                    <div class="price-btn">
                        <div class="price">
                            <span class="currency-type">{{ $currency_icon }}</span>
                            <ins>{{ $product->final_price }}</ins>
                        </div>
                        <a href="javascript:void(0)" class="btn checkout-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                    fill="#F2DFCE" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                    fill="#F2DFCE" />
                            </svg>
                            {{ __('Add to cart') }}

                        </a>


                    </div>
                </div>
            </div>
        </div>


    </div>
    @endforeach
</div>
@php
    $page_no = !empty($page) ? $page : 1;
@endphp
<!-- a Tag for previous page -->
{{ $products->onEachSide(0)->links() }}
