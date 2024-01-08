@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

@foreach($homeproducts as $homeproduct)
    @php
        $p_id = hashidsencode($homeproduct->id);
    @endphp
    <div class="product-card">
        <div class="product-card-inner">
            <div class="card-top">
                <span class="slide-label">{{$homeproduct->tag_api}}</span>

                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: #000000'></i>
                        </span>
                    </a>
            </div>
            <h3 class="product-title">
                <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                    {{$homeproduct->name}}
                </a>
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
                                if (is_array($saleEnableArray) && in_array($homeproduct->id, $saleEnableArray)) {
                                    $latestSales[$homeproduct->id] = [
                                        'discount_type' => $flashsale->discount_type,
                                        'discount_amount' => $flashsale->discount_amount,
                                    ];
                                }
                            }
                        }
                    @endphp
                    @foreach ($latestSales as $productId => $saleData)
                        <div class="slide-label">
                            @if ($saleData['discount_type'] == 'flat')
                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                            @elseif ($saleData['discount_type'] == 'percentage')
                                -{{ $saleData['discount_amount'] }}%
                            @endif
                        </div>
                    @endforeach
                </div>
            </h3>
            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,$p_id])}}">
                    <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}" class="default-img">
                    @if($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                        <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                    @else
                        <img src="{{ get_file($homeproduct->Sub_image($homeproduct->id) , APP_THEME()) }}" class="hover-img">
                    @endif
                </a>
            </div>
            <div class="product-content">
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    @if ($homeproduct->variant_product == 0)
                        <div class="price">
                            <ins>{{ $homeproduct->final_price }}<span class="currency-type">{{$currency}}</span>
                            </ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="0" qty="1">
                        {{ __('Add to cart')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
