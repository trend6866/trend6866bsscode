@php
    $user = App\Models\Admin::where('type','admin')->first();
    if ($user->type == 'admin') {
        $plan = App\Models\Plan::find($user->plan);
    }
@endphp
<div class="order-paycol-inner">
    <div class="d-flex align-items-center justify-content-between payment-ttl-row">
        <div class="payment-ttl-left">
            @if($plan->shipping_method == 'on')
                <span>
                {{ __('Shipping') }} :
                    <span class="payment-shipping">
                        <span class="CURRENCY"></span>
                        <span class="shipping_final_price"> - <b>{{ SetNumberFormat(0) }}</b>
                        </span>
                    </span>
                </span>
            @endif
            <span>
                {{ __('Sub-total') }}:
                <b> {{ SetNumberFormat($response->data->sub_total) }}</b>
            </span>
            <span>
                {{ __('Tax') }} :
                <b>
                    <span class="payment-shipping">
                        @if($plan->shipping_method == 'on')
                        <span class="CURRENCY"></span>
                        @endif
                        <span class="final_tax_price"> - {{ SetNumberFormat($response->data->tax_price) }} </span>
                    </span>
                </b>
            </span>

            <span>
                {{ __('Coupon') }}:
                <b class="discount_amount_currency">- {{ SetNumberFormat(0) }}</b>
            </span>
        </div>
        <div class="payment-ttl-left">
            <h5> {{ __('Total') }} :</h5>
            <div class="ttl-amount">
                <span @if($plan->shipping_method == 'on') class="CURRENCY" @else class="" @endif></span>
                <div class="ttl-pric final_amount_currency1 shipping_total_price">
                    {{ SetNumberFormat($response->data->final_price) }}
                </div>
            </div>
        </div>
    </div>
</div>
