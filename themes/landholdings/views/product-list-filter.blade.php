
@foreach ($products as $product)
@php
    $p_id = hashidsencode($product->id);
@endphp

<div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 col-12 product-card">
    <div class="product-card-inner no-back">
        <div class="product-card-image">
            <a href="{{route('page.product',[$slug,$p_id])}}">
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
            <div class="product-content-top ">
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
                        <div class="disc-badge">
                            @if ($saleData['discount_type'] == 'flat')
                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                            @elseif ($saleData['discount_type'] == 'percentage')
                                -{{ $saleData['discount_amount'] }}%
                            @endif
                        </div>
                    @endforeach
                </div>
                <h3 class="product-title">
                    <a href="{{route('page.product',[$slug,$p_id])}}">
                        {{$product->name}}
                    </a>
                </h3>
                <div class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                    @if(!empty($product->average_rating))
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fa fa-star {{ $i < $product->average_rating ? '' : 'text-warning' }} "></i>
                        @endfor
                        <span class="review-gap"><b>{{ $product->average_rating }}.0</b> / 5.0</span>
                    @else
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fa fa-star {{ $i < $product->average_rating ? '' : 'text-warning' }} "></i>
                        @endfor
                        <span class="review-gap"><b>{{ $product->average_rating }}.0</b> / 5.0</span>
                    @endif
                </div>
            </div>
            <div class="product-content-center">
                @if ($product->variant_product == 0)
                    <div class="price">
                        <ins>{{$product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                        <del>{{$product->price}} {{$currency}}</del>
                    </div>
                @else
                    <div class="price">
                        <ins>{{ __('In Variant') }}</ins>
                    </div>
                @endif
            </div>
            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                <div class="bottom-select  d-flex align-items-center justify-content-between">
                    <div class="cart-btn-wrap">
                        <button class="btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                            <span> {{ __('Add to cart')}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="6" viewBox="0 0 4 6" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill="white"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                    <button href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                style='color: #000000'></i>
                        </span>
                    </button>
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
