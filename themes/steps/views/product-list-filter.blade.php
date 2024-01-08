@foreach ($products as $product)
    @php
        $p_id = hashidsencode($product->id);
    @endphp
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 product-card ">
        <div class="product-card-inner ">
            <div class="product-card-img">
                <a href="{{ route('page.product', [$slug,$p_id]) }}" class="pro-img">
                    <img src="{{get_file($product->cover_image_path , APP_THEME())}}">
                </a>
                    <div class="favorite-icon">
                        <a href="javascript:void(0)" class=" wishlist wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: white'></i>
                        </a>
                    </div>

            </div>
            <div class="product-card-content ">
                <h3><a href="{{ route('page.product', [$slug,$p_id]) }}" tabindex="0" class="name">{{ $product->name }} </a>
                </h3>
                <div class="product-type">{{ $product->SubCategoryctData->name }}</div>
                <div class="custom-output">
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
                        <div class="badge ">
                            @if ($saleData['discount_type'] == 'flat')
                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                            @elseif ($saleData['discount_type'] == 'percentage')
                                -{{ $saleData['discount_amount'] }}%
                            @endif
                        </div>
                    @endforeach
                </div>
                <p class="description">{{ $product->description }}</p>
                @if ($product->variant_product == 0)
                    <div class="price">
                        <ins>{{ $product->final_price }}<sub>{{ $currency }}</sub></ins><br>
                        <del>{{ $product->original_price }} <span class="currency-type">{{ $currency }}</span></del>
                    </div>
                @else
                    <div class="price">
                        <ins>{{ __('In Variant') }}</ins>
                    </div>
                @endif
                <a href="#" class="add-cart-btn addtocart-btn-cart addcart-btn-globaly" tabindex="0"
                    product_id="{{ $product->id }}" variant_id="0" qty="1">
                    <span>{{__('ADD TO CART')}}</span>
                    <span class="atc-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="8" viewBox="0 0 9 8"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.35342 5.2252H3.43344C2.90305 5.22535 2.44792 4.84736 2.35068 4.32595L1.84049 1.56215C1.8082 1.38557 1.65294 1.25825 1.47345 1.26118H0.621922C0.419212 1.26118 0.254883 1.09685 0.254883 0.894139C0.254883 0.691429 0.419212 0.5271 0.621922 0.5271H1.48079C2.01119 0.52695 2.46632 0.904941 2.56356 1.42635L3.07374 4.19015C3.10603 4.36673 3.2613 4.49405 3.44078 4.49112H7.35709C7.53657 4.49405 7.69184 4.36673 7.72413 4.19015L8.1866 1.69428C8.20641 1.58612 8.17667 1.47476 8.10558 1.39087C8.03448 1.30698 7.92951 1.25938 7.81956 1.26118H3.55824C3.35553 1.26118 3.1912 1.09685 3.1912 0.894139C3.1912 0.691429 3.35553 0.5271 3.55824 0.5271H7.81589C8.14332 0.527007 8.45381 0.672642 8.66308 0.924473C8.87235 1.1763 8.95868 1.50821 8.89865 1.83009L8.43619 4.32595C8.33895 4.84736 7.88381 5.22535 7.35342 5.2252ZM5.02645 6.69462C5.02645 6.08649 4.53347 5.59351 3.92534 5.59351C3.72263 5.59351 3.5583 5.75783 3.5583 5.96055C3.5583 6.16326 3.72263 6.32758 3.92534 6.32758C4.12805 6.32758 4.29238 6.49191 4.29238 6.69462C4.29238 6.89733 4.12805 7.06166 3.92534 7.06166C3.72263 7.06166 3.5583 6.89733 3.5583 6.69462C3.5583 6.49191 3.39397 6.32758 3.19126 6.32758C2.98855 6.32758 2.82422 6.49191 2.82422 6.69462C2.82422 7.30275 3.31721 7.79574 3.92534 7.79574C4.53347 7.79574 5.02645 7.30275 5.02645 6.69462ZM7.22865 7.4287C7.22865 7.22599 7.06433 7.06166 6.86162 7.06166C6.65891 7.06166 6.49458 6.89733 6.49458 6.69462C6.49458 6.49191 6.65891 6.32758 6.86162 6.32758C7.06433 6.32758 7.22865 6.49191 7.22865 6.69462C7.22865 6.89733 7.39298 7.06166 7.59569 7.06166C7.7984 7.06166 7.96273 6.89733 7.96273 6.69462C7.96273 6.08649 7.46975 5.59351 6.86162 5.59351C6.25349 5.59351 5.7605 6.08649 5.7605 6.69462C5.7605 7.30275 6.25349 7.79574 6.86162 7.79574C7.06433 7.79574 7.22865 7.63141 7.22865 7.4287Z"
                                fill="white"></path>
                        </svg>
                    </span>
                </a>

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
                {{ $products->onEachSide(0)->links() }}
            </li>
        </ul>
    </nav>
</div>
