
@foreach ($products as $product)
@php
    $p_id = hashidsencode($product->id);
@endphp
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 col-12 product-list-widget">
        <div class="bestseller-card-itm">
            <div class="bestseller-card-inner">
                <div class="bestseller-img">
                    <a href="{{route('page.product',[$slug,$p_id])}}">
                        <img src="{{get_file($product->cover_image_path , APP_THEME())}}" alt="">
                    </a>
                </div>
                <div class="bestseller-content">
                    <div class="bestseller-top">
                        <div class="bestseller-card-heading">
                            <span>{{$product->tag_api}}</span>
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
                            <a href="javascript:void(0)" class="wishlist-btn wbwish  wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                {{ __('Add to wishlist')}}
                                <span class="wish-ic">
                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                </span>
                            </a>
                        </div>
                        <h3>
                            <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                {{$product->name}}
                              </a>
                        </h3>
                        </a>
                        <p class="descriptions">{{$product->description}}</p>
                    </div>
                    <div class="bestseller-bottom">
                        {{-- <div class="bestdeller-radio-btn">
                        </div> --}}
                        @if ($product->variant_product == 0)
                            <div class="price">
                                <ins>{{$product->final_price}}</ins>
                                <span>{{$currency}}</span>
                            </div>
                        @else
                            <div class="price">
                                <ins>{{ __('In Variant') }}</ins>
                            </div>
                        @endif
                        <a href="javascript:void(0)" class="btn addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="0" qty="1">
                            {{ __('Add to Cart')}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12587H2.87416C2.04526 5.12587 1.38823 5.82524 1.43994 6.65253L1.79919 12.4006C1.84653 13.158 2.47458 13.748 3.23342 13.748H10.7666C11.5254 13.748 12.1535 13.158 12.2008 12.4006L12.5601 6.65253C12.6118 5.82524 11.9547 5.12587 11.1258 5.12587ZM2.87416 3.68884C1.21635 3.68884 -0.0977 5.08759 0.00571155 6.74217L0.364968 12.4903C0.459638 14.005 1.71574 15.185 3.23342 15.185H10.7666C12.2843 15.185 13.5404 14.005 13.635 12.4903L13.9943 6.74217C14.0977 5.08759 12.7837 3.68884 11.1258 3.68884H2.87416Z" fill="#0A062D"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.40738C3.40723 2.42326 5.01567 0.814819 6.99979 0.814819C8.9839 0.814819 10.5923 2.42326 10.5923 4.40738V5.8444C10.5923 6.24123 10.2707 6.56292 9.87384 6.56292C9.47701 6.56292 9.15532 6.24123 9.15532 5.8444V4.40738C9.15532 3.21691 8.19026 2.25184 6.99979 2.25184C5.80932 2.25184 4.84425 3.21691 4.84425 4.40738V5.8444C4.84425 6.24123 4.52256 6.56292 4.12574 6.56292C3.72892 6.56292 3.40723 6.24123 3.40723 5.8444V4.40738Z" fill="#0A062D"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach



<div class="d-flex justify-content-center col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination" style="margin-left: 588px;">
                {!! $products->withQueryString()->links() !!}
            </li>
        </ul>
    </nav>
</div>
