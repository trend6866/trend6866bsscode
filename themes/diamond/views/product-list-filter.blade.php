<div class="row">
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 product-col">
            @php
                $p_id = hashidsencode($product->id);
            @endphp
            <div class="product-card">
                <div class="card-top">
                    <div class="card-title">
                        <span>{{$product->ProductData()->name}}</span>
                        <h3>
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                {{$product->name}}
                            </a>
                        </h3>
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
                    <a href="JavaScript:void(0)" class="wishbtn wishbtn-globaly"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                        <span class="wish-ic">
                           <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                           <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                       </span>
                     </a>

                </div>
                <div class="product-card-image">
                    <a href="{{route('page.product',[$slug,$p_id])}}" tabindex="0">
                        <img src="{{get_file($product->cover_image_path),APP_THEME()}}" class="default-img">
                        @if ($product->Sub_image($product->id)['status'] == true)
                            <img src="{{ get_file($product->Sub_image($product->id)['data'][0]->image_path , APP_THEME()) }}"
                                class="hover-img">
                        @else
                            <img src="{{ get_file($product->Sub_image($product->id) , APP_THEME()) }}" class="hover-img">
                        @endif
                    </a>
                </div>
                <div class="card-bottom">
                    @if ($product->variant_product == 0)
                        <div class="price">
                            <ins>{{ $product->final_price }} <span class="currency-type">{{ $currency_icon }}</span></ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    {{-- <div class="product-size-div">
                        <label>
                            Size:
                        </label>
                        <ul class="product-size">
                            <li class="size-list">
                                <input type="radio" name="pro-size3" id="s3" checked>
                                <label for="s3">s</label>
                            </li>
                            <li class="size-list">
                                <input type="radio" name="pro-size3" id="m3">
                                <label for="m3">m</label>
                            </li>
                            <li class="size-list">
                                <input type="radio" name="pro-size3" id="x3">
                                <label for="x3">x</label>
                            </li>
                            <li class="size-list">
                                <input type="radio" name="pro-size3" id="xl3">
                                <label for="xl3">xl</label>
                            </li>
                        </ul>
                    </div> --}}
                    <a href="javascript:void(0)" class="btn theme-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                        {{ __('Add to cart') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                fill="#F2DFCE" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                fill="#F2DFCE" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@php
    $page_no = !empty($page) ? $page : 1;
@endphp
<!-- a Tag for previous page -->
{{ $products->onEachSide(0)->links() }}
