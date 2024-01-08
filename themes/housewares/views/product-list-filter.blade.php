
<div class="row">
    @foreach ($products as $product)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 product-card">
            <div class="product-card-inner">
                <div class="pro-img">
                    <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">
                        <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}">
                    </a>
                </div>
                <div class="pro-content">
                    <div class="pro-content-inner">
                        <div class="pro-content-top">
                            <div class="content-title">
                                <div class="subtitle">
                                    <span>{{ $product->ProductData()->name }}</span>
                                    @auth
                                        <a href="javascript:void(0)" class=" wishbtn wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}" >
                                            <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </a>
                                    @endauth
                                </div>
                                <h4><a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">{{ $product->name }}</a></h4>
                            </div>
                            {{-- <div class="order-select">
                                <div class="checkbox check-product">
                                    <input id="checkbox-9" name="radio" type="checkbox" value=".blue" checked>
                                    <label for="checkbox-9" class="checkbox-label">3x Set</label>
                                </div>
                                <div class="checkbox check-product">
                                    <input id="checkbox-10" name="radio" type="checkbox" value=".blue">
                                    <label for="checkbox-10" class="checkbox-label">7x Set</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="price">
                            <ins>{{ $product->final_price }} <span class="currency-type">{{ $currency }}</span></ins>
                        </div>
                        <a href="javascript:void(0)" class="btn-secondary addtocart-btn-cart addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.21665 8.50065C3.9978 8.50065 3.83133 8.69717 3.86731 8.91304L4.54572 12.9836C4.65957 13.6667 5.25059 14.1673 5.94311 14.1673H11.0594C11.7519 14.1673 12.3429 13.6667 12.4568 12.9836L13.1352 8.91304C13.1712 8.69717 13.0047 8.50065 12.7859 8.50065H4.21665ZM2.96241 7.08398C2.52471 7.08398 2.19176 7.47702 2.26372 7.90877L3.14833 13.2164C3.37603 14.5826 4.55807 15.584 5.94311 15.584H11.0594C12.4444 15.584 13.6265 14.5826 13.8542 13.2164L14.7388 7.90877C14.8107 7.47702 14.4778 7.08398 14.0401 7.08398H2.96241Z" fill="#12131A"/>
                                <path d="M7.08333 9.91602C6.69213 9.91602 6.375 10.2331 6.375 10.6243V12.041C6.375 12.4322 6.69213 12.7493 7.08333 12.7493C7.47453 12.7493 7.79167 12.4322 7.79167 12.041V10.6243C7.79167 10.2331 7.47453 9.91602 7.08333 9.91602Z" fill="#12131A"/>
                                <path d="M9.91667 9.91602C9.52547 9.91602 9.20833 10.2331 9.20833 10.6243V12.041C9.20833 12.4322 9.52547 12.7493 9.91667 12.7493C10.3079 12.7493 10.625 12.4322 10.625 12.041V10.6243C10.625 10.2331 10.3079 9.91602 9.91667 9.91602Z" fill="#12131A"/>
                                <path d="M7.5855 2.62522C7.86212 2.34859 7.86212 1.9001 7.5855 1.62348C7.30888 1.34686 6.86039 1.34686 6.58377 1.62348L3.75043 4.45682C3.47381 4.73344 3.47381 5.18193 3.75043 5.45855C4.02706 5.73517 4.47555 5.73517 4.75217 5.45855L7.5855 2.62522Z" fill="#12131A"/>
                                <path d="M9.4171 2.62522C9.14048 2.34859 9.14048 1.9001 9.4171 1.62348C9.69372 1.34686 10.1422 1.34686 10.4188 1.62348L13.2522 4.45682C13.5288 4.73344 13.5288 5.18193 13.2522 5.45855C12.9755 5.73517 12.5271 5.73517 12.2504 5.45855L9.4171 2.62522Z" fill="#12131A"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4596 5.66667H3.54297C3.15177 5.66667 2.83464 5.9838 2.83464 6.375C2.83464 6.7662 3.15177 7.08333 3.54297 7.08333H13.4596C13.8508 7.08333 14.168 6.7662 14.168 6.375C14.168 5.9838 13.8508 5.66667 13.4596 5.66667ZM3.54297 4.25C2.36936 4.25 1.41797 5.20139 1.41797 6.375C1.41797 7.5486 2.36936 8.5 3.54297 8.5H13.4596C14.6332 8.5 15.5846 7.5486 15.5846 6.375C15.5846 5.20139 14.6332 4.25 13.4596 4.25H3.54297Z" fill="#12131A"/>
                            </svg>
                            {{__('Add to cart')}}
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

<div class="d-flex justify-content-center col-12" style="justify-content: end;">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination">
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
