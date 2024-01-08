
@foreach ($products as $product)
@php
    $p_id = hashidsencode($product->id);
@endphp
<div class="col-lg-4 col-md-4 col-sm-6 col-12 product-card theme-colored-card">
    <div class="product-card-inner">
        <div class="product-img">
            <a href="{{route('page.product',[$slug,$p_id])}}">
                <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}">
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
                    <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: 00000'></i>
                        </span>
                    </a>
                </div>
                <div class="subtitle">{{$product->tag_api}}</div>
                <h3><a href="{{route('page.product',[$slug,$p_id])}}" class="description">{{$product->name}}</a></h3>
            </div>
            <div class="product-content-bottom">
                <div class="main-price d-flex align-items-center justify-content-between">
                    @if ($product->variant_product == 0)
                        <div class="price">
                            <ins>{{$product->final_price}}{{$currency}}</ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    <a href="javascript:void(0)" class="link-btn addcart-btn-globaly" type="submit" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                        + {{ __('ADD TO CART')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@php
    $page_no = !empty($page) ? $page : 1;
@endphp

<li class="pagination" style="margin-left: auto;">
    {{ $products->onEachSide(0)->links() }}
</li>
