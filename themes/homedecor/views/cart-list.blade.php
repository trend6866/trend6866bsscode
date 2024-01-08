<div class="container">
    <div class="section-title">
        <a href="{{route('page.product-list',$slug)}}" class="back-btn">
            <span class="svg-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                        fill="white"></path>
                </svg>
            </span>
            {{ __('Back to category') }}
        </a>
        <h2> {{ __('Fashion') }} <b> {{ __('category') }} </b> <span>({{ $response->data->cart_total_product }})</span></h2>
    </div>

    <div class="row">
        <div class="col-lg-9 col-12">
            <div class="order-historycontent">
                <table class="cart-tble">
                    <thead>
                        <tr>
                            <th scope="col"> {{ __('Product') }} </th>
                            <th scope="col"> {{ __('Name') }} </th>
                            <th scope="col"> {{ __('date') }} </th>
                            <th scope="col"> {{ __('quantity') }} </th>
                            <th scope="col"> {{ __('Price') }} </th>
                            <th scope="col"> {{ __('Total') }} </th>
                            <th scope="col"> {{ __('Delete') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($response->data->cart_total_product))
                            @foreach ($response->data->product_list as $item)
                            <tr>
                                <td data-label="Product">
                                    <a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}">
                                        <img src="{{get_file($item->image , APP_THEME())}}" alt="img">
                                    </a>
                                </td>

                                <td data-label="Name">
                                    <a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}">{{ $item->name }}</a>
                                    @if ($item->variant_id != 0)
                                        <div class="mt-5">
                                            {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                                        </div>
                                    @endif
                                </td>
                                <td data-label="date"> {{ SetDateFormat($item->cart_created) }} </td>

                                <td data-label="quantity">
                                    <div class="qty-spinner">
                                        <button type="button" class="quantity-decrement change-cart-globaly" cart-id="{{ $item->cart_id }}" quantity_type="decrease">
                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                </path>
                                            </svg>
                                        </button>

                                        <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="{{ $item->qty }}" min="01" id="quantity">

                                        <button type="button" class="quantity-increment change-cart-globaly"  cart-id="{{ $item->cart_id }}" quantity_type="increase">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td data-label="Price">
                                    {{ SetNumberFormat($item->final_price/$item->qty) }}
                                </td>
                                <td data-label="Total">
                                    {{ SetNumberFormat($item->final_price) }}
                                </td>
                                <td>
                                    {{-- <button class="btn remove_item_from_cart" title="Remove item" href="JavaScript:void(0)" data-id="{{ $item->cart_id }}">
                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip" title="delete"></i>
                                    </button> --}}


                                    <a class="remove_item remove_item_from_cart" title="Remove item" href="JavaScript:void(0)" data-id="{{ $item->cart_id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M12.7589 7.24609C12.5002 7.24609 12.2905 7.45577 12.2905 7.71448V16.5669C12.2905 16.8255 12.5002 17.0353 12.7589 17.0353C13.0176 17.0353 13.2273 16.8255 13.2273 16.5669V7.71448C13.2273 7.45577 13.0176 7.24609 12.7589 7.24609Z"
                                                fill="#FF0000"></path>
                                            <path
                                                d="M7.23157 7.24609C6.97286 7.24609 6.76318 7.45577 6.76318 7.71448V16.5669C6.76318 16.8255 6.97286 17.0353 7.23157 17.0353C7.49028 17.0353 7.69995 16.8255 7.69995 16.5669V7.71448C7.69995 7.45577 7.49028 7.24609 7.23157 7.24609Z"
                                                fill="#FF0000"></path>
                                            <path
                                                d="M3.20333 5.95419V17.4942C3.20333 18.1762 3.45344 18.8168 3.89035 19.2764C4.32525 19.7373 4.93049 19.9989 5.56391 20H14.4259C15.0594 19.9989 15.6647 19.7373 16.0994 19.2764C16.5363 18.8168 16.7864 18.1762 16.7864 17.4942V5.95419C17.6549 5.72366 18.2177 4.8846 18.1016 3.99339C17.9852 3.10236 17.2261 2.43583 16.3274 2.43565H13.9293V1.85017C13.932 1.35782 13.7374 0.885049 13.3888 0.537238C13.0403 0.18961 12.5668 -0.00396362 12.0744 6.15416e-05H7.91533C7.42298 -0.00396362 6.94948 0.18961 6.60093 0.537238C6.25239 0.885049 6.05772 1.35782 6.06046 1.85017V2.43565H3.66238C2.76367 2.43583 2.00456 3.10236 1.8882 3.99339C1.77202 4.8846 2.33481 5.72366 3.20333 5.95419ZM14.4259 19.0632H5.56391C4.76308 19.0632 4.14009 18.3753 4.14009 17.4942V5.99536H15.8497V17.4942C15.8497 18.3753 15.2267 19.0632 14.4259 19.0632ZM6.99723 1.85017C6.99412 1.60628 7.08999 1.37154 7.26307 1.19938C7.43597 1.02721 7.67126 0.932619 7.91533 0.936827H12.0744C12.3185 0.932619 12.5538 1.02721 12.7267 1.19938C12.8998 1.37136 12.9956 1.60628 12.9925 1.85017V2.43565H6.99723V1.85017ZM3.66238 3.37242H16.3274C16.793 3.37242 17.1705 3.74987 17.1705 4.21551C17.1705 4.68114 16.793 5.05859 16.3274 5.05859H3.66238C3.19674 5.05859 2.81929 4.68114 2.81929 4.21551C2.81929 3.74987 3.19674 3.37242 3.66238 3.37242Z"
                                                fill="#FF0000"></path>
                                            <path
                                                d="M9.99523 7.24609C9.73653 7.24609 9.52686 7.45577 9.52686 7.71448V16.5669C9.52686 16.8255 9.73653 17.0353 9.99523 17.0353C10.2539 17.0353 10.4636 16.8255 10.4636 16.5669V7.71448C10.4636 7.45577 10.2539 7.24609 9.99523 7.24609Z"
                                                fill="#FF0000"></path>
                                            <defs>
                                                <clipPath>
                                                    <rect width="20" height="20" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <h3 class="text-center"> {{ __('You have no items in your shopping cart.') }} </h3>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>

        </div>

        <div class="col-lg-3 col-12">
            <div class="cart-summery">
                <ul>
                    <li>
                        <span class="cart-sum-left">{{ $response->data->cart_total_product }} {{ __('item') }}</span>
                        <span class="cart-sum-right">{{ SetNumberFormat($response->data->sub_total) }}</span>
                    </li>
                    <li>
                        <span class="cart-sum-left">{{ __('Taxes') }}: </span>
                        <span class="cart-sum-right">{{ SetNumberFormat($response->data->tax_price) }}</span>
                    </li>
                    <li>
                        <span class="cart-sum-left">{{ __('Discount') }}: </span>
                        <span class="cart-sum-right coupon_discount_amount">{{ SetNumberFormat() }}</span>
                    </li>
                    <li>
                        <span class="cart-sum-left">{{ __('Total') }} ({{ __('tax incl.') }})</span>
                        <span class="cart-sum-right discount_final_price">{{ SetNumberFormat($response->data->final_price) }}</span>
                    </li>
                </ul>

                <a class="btn checkout-btn" href="{{ route('checkout',$slug) }}">
                    {{ __('Proceed to checkout') }}
                </a>
            </div>
        </div>
    </div>
</div>


