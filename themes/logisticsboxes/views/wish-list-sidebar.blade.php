<style>
    wishDrawer .closewish {
        position: absolute;
        left: -38px;
        top: 20px;
        width: 20px;
        height: 20px;
        opacity: 0;
        visibility: hidden;

    }

    .wishOpen .wishDrawer .closewish {
        opacity: 1;
        visibility: visible;
    }
</style>

<div class="wishDrawer">
    <div class="mini-wish-header">
        <h4>{{ __('My wish') }}</h4>
        {{-- <div class="wish-tottl-itm">0{{ __('Items') }}</div> --}}
        <a href="#" class="closewish ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path
                    d="M20 1.17838L18.8216 0L10 8.82162L1.17838 0L0 1.17838L8.82162 10L0 18.8216L1.17838 20L10 11.1784L18.8216 20L20 18.8216L11.1784 10L20 1.17838Z"
                    fill="white"></path>
            </svg>
        </a>
    </div>
    <div id="wish-body" class="mini-wish-has-item">
        <div class="mini-wish-body">
            @if (!empty($response->data->data))
                @foreach ($response->data->data as $item)
                    {{-- @dd( $item->final_price) --}}
                    <div class="mini-wish-item">
                        <div class="mini-wish-image">
                            <a href="{{ route('page.product', [$slug,hashidsencode($item->product_id)]) }}" title="SPACE BAG">
                                <img src="{{ get_file($item->product_image, APP_THEME()) }}" alt="plant1">
                            </a>
                        </div>
                        <div class="mini-wish-details" style="color: black;">
                            <p class="mini-wish-title"><a
                                    href="{{ route('page.product', [$slug,hashidsencode($item->product_id)]) }}">
                                    {{ $item->product_name }}</a></p>
                            @if ($item->variant_id != 0)
                                {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                            @endif

                            <div class="pvarprice d-flex align-items-center justify-content-between">
                                <div class="price">

                                    <ins>{{ $item->final_price }}<span
                                            class="currency-type">{{ $currency_name }}</span></ins><del>{{ SetNumberFormat($item->original_price) }}</del>
                                </div>

                            </div>
                        </div>

                        <a href="JavaScript:void(0)" class="btn cart-btn  addtocart-btn-cart addcart-btn-globaly"
                            style="width: 63%;" product_id="{{ $item->product_id }}"
                            variant_id="{{ $item->variant_id }}" qty="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10"
                                fill="none">
                                <path
                                    d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z"
                                    fill="white"></path>
                            </svg>{{ __('ADD TO CART') }}
                        </a>

                        <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $item->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true"
                                focusable="false" role="presentation" class="icon icon-remove ">
                                <path
                                    d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z"
                                    fill="currentColor"></path>
                                <path
                                    d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="emptywish text-center">{{ __('You have no items in your shopping wish.') }}</p>
            @endif
        </div>

    </div>
</div>
