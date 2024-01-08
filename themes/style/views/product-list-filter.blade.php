<div class="row">
@foreach ($products as $product)
    <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-12 product-card">
        <div class="product-card-inner">

            <div class="product-card-image">
                <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">
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
                <div class="product-content-top">
                    <h3 class="product-title">

                        <a href="{{route('page.product',[$slug,hashidsencode($product->id)])}}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="product-type">
                        {{ $product->ProductData()->name }} / {{ $product->SubCategoryctData->name }}
                    </div>
                </div>
                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                    @if ($product->variant_product == 0)
                        <div class="price">
                            <ins>{{ $product->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                            <del>{{ $product->original_price }}</del>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
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
                    <button class="addtocart-btn  addtocart-btn-cart addcart-btn-globaly" tabindex="0" product_id="{{ $product->id }}" variant_id="0" qty="1">
                        <span> {{ __('Add to cart') }} </span>
                        <svg viewBox="0 0 10 5">
                            <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@php
    $page_no = !empty($page) ? $page : 1;
@endphp
{{ $products->onEachSide(0)->links() }}
