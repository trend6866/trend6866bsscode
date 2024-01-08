<div class="row">
    @foreach($products as $product)
        @php
            $p_id = hashidsencode($product->id);
        @endphp
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 col-12 product-col">
            <div class="product-card">
                <div class="product-card-inner">
                    <div class="card-top">
                        @php
                                                date_default_timezone_set('Asia/Kolkata');
                                                $currentDateTime = \Carbon\Carbon::now();
                                                $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                    ->where('store_id', getCurrentStore())
                                                    ->where('is_active', 1)
                                                    ->get();
                                                $latestSales = [];

                                                foreach ($sale_product as $flashsale) {
                                                    $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                    $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                    $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                    if ($endDate < $startDate) {
                                                        $endDate->addDay();
                                                    }
                                                    $currentDateTime->setTimezone($startDate->getTimezone());

                                                    if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                        if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                            $latestSales[$product->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <span class="">
                                                    @if ($saleData['discount_type'] == 'flat')
                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                        -{{ $saleData['discount_amount'] }}%
                                                    @endif
                                                </span>
                                            @endforeach
                            <div class="like-items-icon">
                                <a class="add-wishlist wishbtn wishbtn-globaly" href="javascript:void(0)" title="Wishlist" tabindex="0"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                    <div class="wish-ic">
                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                    </div>
                                </a>
                            </div>
                    </div>
                    <div class="product-card-image">
                        <a href="{{route('page.product',[$slug,$p_id])}}">
                            <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                        </a>
                    </div>
                    <div class="card-bottom">
                        <div class="product-title">
                        <span class="sub-title">Accesories</span>
                        <h3>
                            <a href="{{route('page.product',[$slug,$p_id])}}" class="product-title1">
                                {{$product->name}}
                            </a>
                        </h3>
                        <p>{{ $product->ProductData()->name }}</p>
                        </div>
                        @if ($product->variant_product == 0)
                            <div class="price">
                                <ins>{{$product->final_price}}
                                    <span class="currency-type">{{ $currency }}</span>
                                </ins>
                            </div>
                        @else
                            <div class="price">
                                <ins>{{ __('In Variant') }}</ins>
                            </div>
                        @endif
                        <a href="javascript:void(0)" class="btn addtocart-btn variant_form addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                            {{__('Add to cart')}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                    fill="white" />
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

<div class="d-flex justify-content-center col-12 " style="justify-content: flex-end;">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination">
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>

