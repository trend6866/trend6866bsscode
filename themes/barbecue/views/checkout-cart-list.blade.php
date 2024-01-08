<div class="checkout-page-right">
    <div class="mini-cart-header">
        <h4>{{ __('My Cart') }}:<span class="checkout-cartcount">[{{ $response->data->cart_total_product }}]</span></h4>
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
                                <img src="{{ get_file($item->image , APP_THEME()) }}" alt="img">
                            </a>
                        </div>
                        <div class="mini-cart-details">
                            <p class="mini-cart-title">
                                <a href="{{ route('page.product',[$slug,hashidsencode($item->product_id)]) }}">{{ $item->name }}</a>
                            </p>
                            <div class="qty-spinner">

                                {{-- <button type="button" class="quantity-decrement change-cart-globaly" cart-id="{{ $item->cart_id }}" quantity_type="decrease">
                                    <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                        </path>
                                    </svg>
                                </button> --}}

                                <input type="hidden" name="product_id" value="45">
                                <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="{{ $item->qty }}" min="01" id="quantity" data-id="463" disabled>

                                {{-- <button type="button" class="quantity-increment change-cart-globaly"  cart-id="{{ $item->cart_id }}" quantity_type="increase">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                    </svg>
                                </button> --}}

                            </div>
                            <div class="pvarprice d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{ SetNumberFormat($item->final_price) }} </ins>
                                </div>
                                <a href="javascript:;" class="remove-btn py-1 remove_item_from_cart" title="Remove item" data-id="{{ $item->cart_id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false" role="presentation" class="icon icon-remove ">
                                        <path d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z" fill="currentColor"></path>
                                        <path d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z" fill="currentColor"></path>
                                    </svg>
                                </a>
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
                <input class="form-control mb-10 coupon_code" placeholder="Enter coupon code" required="" name="coupon" type="text" value="" theme_id = {{ APP_THEME() }}>

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
