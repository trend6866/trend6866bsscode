
@foreach ($products as $product)

@php
    $p_id = hashidsencode($product->id);
@endphp

    <div class="col-lg-6 col-md-12 col-sm-6 col-12 product-card product-card-reverse bordered-card">
        <div class="product-card-inner">
            <div class="product-image">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}">
                </a>
            </div>
            <div class="product-content">
                <div class="product-cont-top">
                    <div class="subtitle">{{ $product->tag_api }}</div>
                    <h3> <a href="{{route('page.product',[$slug,$p_id])}}" class="description"> {{$product->name}} </a></h3>
                </div>
                <div class="product-cont-bottom">
                    <div class="price-btn">
                        <span class="price">
                            <ins>{{$product->final_price}}{{$currency}}</ins>
                        </span>
                        <button class="cart-button addcart-btn-globaly" type="submit" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                            <svg width="20" height="20" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                </path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                </path>
                            </svg>
                        </button>
                    </div>
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
            <li class="pagination" style="color:black; margin-left: 562px;" >
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
