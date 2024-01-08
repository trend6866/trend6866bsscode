<div class="row">
@foreach ($products as $product)
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 col-12 product-card">
        <div class="product-card-inner">

            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">
                    <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                    @if($product->Sub_image($product->id)['status'] == true)
                    <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                    @else

                    <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                    @endif
                </a>

                <div class="new-labl">
                    {{ $product->tag_api }}
                </div>
            </div>
            <div class="product-content">
                <div class="product-content-top">
                    <h3 class="product-title">

                        <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="product-type">
                        {{ $product->ProductData()->name }} / {{ $product->SubCategoryctData->name }}
                    </div>
                </div>
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    <div class="price">
                        <ins class="mr-5">
                            {{ $product->final_price }}
                            <span class="currency-type">{{ $currency }}</span>
                        </ins>
                        <del>{{ $product->original_price }}</del>
                    </div>
                    <button class="addtocart-btn  addtocart-btn-cart addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                        <span> {{ __('Add to cart') }} </span>
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@php
    $page_no = !empty($page) ? $page : 1;
@endphp

<div class="d-flex justify-content-center col-12" style="justify-content: flex-end;">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination">
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
