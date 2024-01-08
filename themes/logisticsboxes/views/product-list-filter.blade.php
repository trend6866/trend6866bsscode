@foreach ($products as $product)
{{-- @DD($products) --}}
    @php
        $p_id = hashidsencode($product->id);
    @endphp

    <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-card">
        <div class="product-card-inner">
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
            <div class="product-img">
                <a href="{{ route('page.product', [$slug,$p_id]) }}">
                    <img src="{{get_file($product->cover_image_path , APP_THEME())}}" alt="default-img">
                </a>
            </div>
            <div class="product-content">
                <div class="product-content-top">
                    <div class="top-subtitle d-flex align-items-center justify-content-between">
                            <div class="subtitle"> {{$product->tag_api}}  </div>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z" fill="#5EA5DF"/>
                            <path d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z" fill="#5EA5DF"/>
                            <path d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z" fill="#5EA5DF"/>
                            <path d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z" fill="#5EA5DF"/>
                            </svg> {{ $product->default_variant_name }}</p>
                    </div>
                    <h5><a href="{{ route('page.product', [$slug,$p_id]) }}"><b>{{$product->name}}</b></a></h5>
                        <p class="description">{{$product->description}} </p>
                </div>
                {{-- <div class="cart-variable">
                    <div class="swatch-lbl">
                        <strong>Available:</strong>
                    </div>
                    <select class="theme-arrow">
                        <option>Paper Material (15pcs available)</option>
                        <option>Paper Material (14pcs available)</option>
                        <option>Paper Material (13pcs available)</option>
                    </select>
                </div> --}}
                <div class="product-content-bottom">
                    @if ($product->variant_product == 0)
                        <div class="price">
                            <ins>{{$product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="javascript:void(0)" class="btn cart-btn  addtocart-btn-cart addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                            <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                            </svg>{{__('ADD TO CART')}}</a>

                                <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly" product_id="{{ $product->id }}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                    <span class="">
                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style = "color: #faf7f7;"></i>
                                    </span>
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



<div class="d-flex justify-content-center col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination" style="margin-left: 660px; " >
                {{ $products->onEachSide(0)->links() }}
            </li>
        </ul>
    </nav>
</div>
