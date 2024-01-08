@php
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = \App\Models\Utility::GetValueByName('CURRENCY');
@endphp

@foreach($homeproducts as $homeproduct)
@php
    $p_id = hashidsencode($homeproduct->id);
@endphp
<div class="pro-cate-itm product-card">
    <div class="product-card-inner">
        <div class="product-img">
            <a href="{{route('page.product',[$slug,$p_id])}}">
                <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}">
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
                        <span class="offer-lbl">
                            @if ($saleData['discount_type'] == 'flat')
                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                            @elseif ($saleData['discount_type'] == 'percentage')
                                -{{ $saleData['discount_amount'] }}%
                            @endif
                        </span>
                    @endforeach
                </div>
            </a>
        </div>
        <div class="product-content">
            <div class="product-content-top">
                <div class="d-flex justify-content-end wsh-wrp">
                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: rgb(255, 254, 254)'></i>
                        </span>
                    </a>
                </div>
                <div class="subtitle">{{$homeproduct->tag_api}}</div>
                <h3><a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">{{$homeproduct->name}}</a></h3>

            </div>
            <div class="product-content-bottom">
                <div class="main-price d-flex align-items-center justify-content-between">
                    @if ($homeproduct->variant_product == 0)
                        <div class="price">
                            <ins>{{$homeproduct->final_price}}{{$currency}}</ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                        + {{ __('ADD TO CART')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
