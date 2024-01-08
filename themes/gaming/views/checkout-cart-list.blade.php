<div class="checkout-page-right">
    <div class="mini-cart-header">
        <h3>{{ __('My Cart') }}:<span class="checkout-cartcount">[{{ $response->data->cart_total_product }}]</span></h3>
    </div>
    <div id="cart-body" class="mini-cart-has-item">
        <div class="mini-cart-body">
            @if (!empty($response->data->cart_total_product))
                @foreach ($response->data->product_list as $item)
                    <div class="mini-cart-item">
                        <input type="hidden" id="product_id" value="{{ $item->product_id }}" >
                        <input type="hidden" id="product_qty" value="{{ $item->qty }}">
                        <input type="hidden" id="auth_user" value="{{ \Auth::user()->id ?? '' }}">
                        <div class="mini-cart-image">
                            <a href="{{ route('page.product',[$slug,hashidsencode($item->product_id)]) }}" title="SPACE BAG">
                                <img src="{{get_file($item->image , APP_THEME())}}"alt="img">
                            </a>
                        </div>
                        <div class="mini-cart-details">
                            <p class="mini-cart-title">
                                <a href="{{ route('page.product',[$slug,hashidsencode($item->product_id)]) }}">{{ $item->name }}</a>
                            </p>
                            <div class="qty-spinner">
                                <input type="hidden" name="product_id" value="45">
                                <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="{{ $item->qty }}" min="01" id="quantity" data-id="463" disabled>
                            </div>
                            <div class="pvarprice d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{ SetNumberFormat($item->final_price) }} </ins>
                                </div>
                                <button class="btn remove_item_from_cart" title="Remove item" data-id="{{ $item->cart_id }}">
                                    <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip" title="delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @php
            $user = App\Models\Admin::where('type', 'admin')->first();
            if ($user->type == 'admin') {
                $plan = App\Models\Plan::find($user->plan);
            }
        @endphp

        @if ($plan->shipping_method == 'on')
            @if (\Auth::user())
                <div class="chnage_address">
                    <a href="{{ route('my-account.index', $slug) }}">{{ __('Change Address') }}</a>
                </div>
            @endif

            <div class="shiping-type">
                <h5>{{ __('Select Shipping') }}</h5>
                <div class="radio-group change_shipping" id="shipping_location_content">

                </div>
            </div>
        @endif

        <div class="mini-cart-footer">
            <div class="u-save d-flex justify-end">
                <input class="form-control mb-10 coupon_code" placeholder="Enter coupon code" required="" name="coupon" type="text" value="">

                <button class="btn checkout-btn apply_coupon">
                    {{ __('Apply Coupon') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14"
                        viewBox="0 0 35 14" fill="none">
                        <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="mini-cart-footer-total-row d-flex align-items-center justify-content-between">
                <div class="mini-total-lbl">
                    {{ __('Subtotal') }} :
                </div>
                <input type="hidden" value="{{ $response->data->sub_total }}" id="subtotal">
                <div class="mini-total-price subtotal">
                    {{ SetNumberFormat($response->data->sub_total) }}
                </div>
            </div>
            @if ($plan->shipping_method == 'on')
                <div class="u-save d-flex justify-end">
                    {{ __('Shipping') }} : <span class="CURRENCY"></span> <span class="shipping_final_price"> -
                        {{ SetNumberFormat(0) }} </span>
                </div>
            @endif
            <div class="u-save d-flex justify-end">
                {{ __('Coupon') }} : <span class="discount_amount_currency"> {{ SetNumberFormat(0) }} </span>
            </div>
            <div class="u-save d-flex justify-end">
                {{ __('Tax') }} : <span
                    @if ($plan->shipping_method == 'on') class="CURRENCY" @else class="" @endif></span>
                <span class="final_tax_price"> {{ SetNumberFormat($response->data->tax_price) }} </span>
            </div>

            <div class="mini-cart-footer-total-row d-flex align-items-center justify-content-between">
                <div class="mini-total-lbl">
                    {{ __('Total') }} :
                </div>
                <div>
                    <span @if ($plan->shipping_method == 'on') class="CURRENCY" @else class="" @endif></span>
                    <span class="final_amount_currency shipping_total_price"
                        final_total="{{ $response->data->final_price }}">
                        {{ SetNumberFormat($response->data->final_price) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
