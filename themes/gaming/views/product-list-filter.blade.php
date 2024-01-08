
@foreach ($products as $product)

@php
    $p_id = hashidsencode($product->id);
@endphp

    <div class="col-lg-4 col-md-4 col-sm-6 col-12 product-card">
        <div class="product-card-inner">
        <div class="card-top">
            <span class="slide-label">{{ $product->tag_api }}</span>

                <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                    <span class="wish-ic">
                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style='color: black'></i>
                    </span>
                </a>
        </div>
        <h3 class="product-title">
            <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                {{$product->name}}
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
                <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" class="default-img">
                @if($product->Sub_image($product->id)['status'] == true)
                    <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                @else
                    <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                @endif
            </a>
        </div>
        <div class="product-content">
            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                @if ($product->variant_product == 0)
                    <div class="price">
                        <ins>{{ $product->final_price }}<span class="currency-type">{{$currency}}</span>
                        </ins>
                    </div>
                @else
                    <div class="price">
                        <ins>{{ __('In Variant') }}</ins>
                    </div>
                @endif
                <a href="javascript:void(0)" class="btn-primary add-cart-btn addcart-btn-globaly" type="submit" product_id="{{ $product->id }}" variant_id="0" qty="1">
                    {{ __('Add to cart')}}
                </a>
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
            <li class="pagination" style="color:black;" >
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
