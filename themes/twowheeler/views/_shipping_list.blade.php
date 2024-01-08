<h3 class="check-head">{{ __('Select Your Delivery') }}</h3>
    <p>{{ __('Please select the preferred shipping method to use on this order') }}.</p>
    <div class="payment-method-form">
        @if ($shipping_list->status == 1)
            @foreach ($shipping_list->data as $shipping_key => $shipping)
                <div class="radio-group">
                    <input type="radio" id="shippingid{{ $shipping->id }}" name="delivery_id" {{ $shipping_key == 0 ? 'checked' : ''}} class="shipping_change" value="{{ $shipping->id }}">
                    <label for="shippingid{{ $shipping->id }}">
                        <span>{{ $shipping->name }}</span>
                        <div class="center-descrp">
                            {{ $shipping->description }}
                        </div>
                        <div class="radio-right">
                            <p>{{ $shipping->charges_type }}/{{ __('Price') }}:</p>
                            <b>{{ $shipping->charges_type == 'flat' ? SetNumberFormat($shipping->amount) : $shipping->amount.'%' }}</b>
                            <img src="{{ !empty(get_file($shipping->image_path , APP_THEME())) ? get_file($shipping->image_path , APP_THEME()) : '' }}" class="shippingimag{{ $shipping->id }}"
                                alt="dhl" width="130px;">
                                
                        </div>
                    </label>
                </div>
            @endforeach
        @endif
        <div class="form-group">
            <label>{{ __('Add Comments About Your Order') }}:</label>
            <textarea class="form-control" name="delivery_comment" placeholder="Description" rows="8"></textarea>
        </div>
        <div class="form-container">
            <div class="d-flex acc-back-btn-wrp align-items-center justify-content-end">
                <button class="btn continue-btn shpping_done" type="button">
                    {{ __('Continue') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12"
                        viewBox="0 0 11 12" fill="none">
                        <g clip-path="url(#down)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.28956 0.546387C5.04611 0.546383 4.84876 0.743733 4.84875 0.987181L4.84862 9.59851L3.84237 8.56269C3.67274 8.38807 3.39367 8.38403 3.21905 8.55366C3.04443 8.72329 3.04039 9.00236 3.21002 9.17698L4.97323 10.992C5.05623 11.0774 5.17028 11.1257 5.2894 11.1257C5.40852 11.1257 5.52257 11.0774 5.60558 10.992L7.36878 9.17698C7.53841 9.00236 7.53437 8.72329 7.35975 8.55366C7.18514 8.38403 6.90606 8.38807 6.73643 8.56269L5.73022 9.59847L5.73035 0.987195C5.73036 0.743747 5.53301 0.54639 5.28956 0.546387Z"
                                fill="white"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </div>
