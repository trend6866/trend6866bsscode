
<div class="banner-right-side">
    <div class="trending-products">
        <div class="trending-slider flex-slider">
            @foreach($landing_products as $product)
            @php
                $p_id = hashidsencode($product->id);
            @endphp
            <div class="product-card card">
                <div class="product-card-inner card-inner">
                    <div class="product-content-top ">
                        <span class="new-labl">
                            {{ $product->tag_api }}
                        </span>
                        <h4>
                            <a href="{{route('page.product',[$slug,$p_id])}}">{{$product->name}}</a>
                        </h4>
                        <div class="product-type">{{$product->SubCategoryctData->name}}</div>
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
                                <div class="badge">
                                    @if ($saleData['discount_type'] == 'flat')
                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                    @elseif ($saleData['discount_type'] == 'percentage')
                                        -{{ $saleData['discount_amount'] }}%
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="product-card-image">
                        <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                            <img src="{{get_file($product->cover_image_path , APP_THEME())}}" class="default-img">
                        </a>
                    </div>
                    <div class="product-content-bottom">
                        @if ($product->variant_product == 0)
                            <div class="price">
                                <ins>{{$product->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                            </div>
                        @else
                            <div class="price">
                                <ins>{{ __('In Variant') }}</ins>
                            </div>
                        @endif
                        {{-- <div class="product-info">
                            <span><b>FRAME SIZE:</b> 16-66-145 mm</span>
                            <span><b>FRAME WIDTH:</b> 75 MM</span>
                        </div> --}}
                        <button class="addtocart-btn btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                            <span>{{ __('Add to cart')}}</span>
                            <span class="roun-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                    viewBox="0 0 9 9" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                        fill="white" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
