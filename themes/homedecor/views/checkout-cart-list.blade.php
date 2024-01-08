<div class="checkout-page-right">
    <div class="mini-cart-header">
        <h4>{{ __('My Cart') }}:<span class="checkout-cartcount">[{{ $response->data->cart_total_product }}]</span></h4>
    </div>
    <div id="cart-body" class="mini-cart-has-item">
        <div class="mini-cart-body">
            @if (!empty($response->data->cart_total_product))
                @foreach ($response->data->product_list as $item)
                    <div class="mini-cart-item">
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

                                <button type="button" class="quantity-decrement change-cart-globaly" cart-id="{{ $item->cart_id }}" quantity_type="decrease">
                                    <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                        </path>
                                    </svg>
                                </button>

                                <input type="hidden" name="product_id" value="45">
                                <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="{{ $item->qty }}" min="01" id="quantity" data-id="463">

                                <button type="button" class="quantity-increment change-cart-globaly"  cart-id="{{ $item->cart_id }}" quantity_type="increase">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                    </svg>
                                </button>

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
                <div class="mini-total-price">
                    {{ SetNumberFormat($response->data->sub_total) }}
                </div>
            </div>
            <div class="u-save d-flex justify-end">
                {{ __('Tax') }} : {{ SetNumberFormat($response->data->tax_price) }}
            </div>
            <div class="u-save d-flex justify-end">
                {{ __('Coupon') }} : <span class="discount_amount_currency"> - {{ SetNumberFormat(0) }} </span>
            </div>
            <div class="u-save d-flex justify-end" >
                {{ __('Total') }} : <span class="final_amount_currency" final_total="{{ $response->data->final_price  }}">{{ SetNumberFormat($response->data->final_price) }}</span>
            </div>
            <button class="btn checkout-btn">
                {{ __('checkout') }}
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14"
                    viewBox="0 0 35 14" fill="none">
                    <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>
