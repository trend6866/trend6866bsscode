@foreach ($products as $product)
    {{-- @DD($products) --}}
    @php
        $p_id = hashidsencode($product->id);
    @endphp

    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6  col-12 product-card card">
        <div class="product-card-inner card-inner">
            <div class="card-top">
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
                        <span class="badge">
                            @if ($saleData['discount_type'] == 'flat')
                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                            @elseif ($saleData['discount_type'] == 'percentage')
                                -{{ $saleData['discount_amount'] }}%
                            @endif
                        </span>
                    @endforeach
                </div>
                    <a href="javascript:void(0)" class="wishlist-btn wishbtn-globaly " product_id="{{ $product->id }}"
                        in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add' }}">
                        {{ __('Add to wishlist') }}
                        <span class="wish-ic">
                            <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                        </span>
                    </a>
            </div>
            <div class="product-card-image">
                <a href="{{ route('page.product', [$slug,$p_id]) }}">
                    <img src=" {{ get_file($product->cover_image_path, APP_THEME()) }}" class="default-img">
                </a>
            </div>
            <div class="card-bottom">
                <div class="card-title">
                    <h3>
                        <a href="{{ route('page.product', [$slug,$p_id]) }}" class="names">
                            {{ $product->name }}
                        </a>
                    </h3>
                </div>
                <p class="description">{{ $product->description }}</p>

                <div class="card-btn-wrapper">
                    @if ($product->variant_product == 0)
                        <div class="price">
                            <ins>{{ $product->final_price }} <span
                                class="currency-type">{{ $currency }}</span></ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    <a href="javascript:void(0)" class="btn  addtocart-btn-cart addcart-btn-globaly"
                        product_id="{{ $product->id }}" variant_id="0"
                        qty="1">
                        {{ __('ADD TO CART') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"
                                fill="#F2DFCE"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"
                                fill="#F2DFCE"></path>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endforeach
@php
    $page_no = !empty($page) ? $page : 1;
@endphp



<div class="d-flex justify-content-center col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination" style="margin-left: 660px; ">
                {{ $products->onEachSide(0)->links() }}
            </li>
        </ul>
    </nav>
</div>
