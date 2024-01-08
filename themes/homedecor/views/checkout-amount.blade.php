<div class="order-paycol-inner">
    <div class="d-flex align-items-center justify-content-between payment-ttl-row">
        <div class="payment-ttl-left">
            <span>
                {{ __('Sub-total') }}:
                <b> {{ SetNumberFormat($response->data->sub_total) }}</b>
            </span>
            <span>
                {{ __('Tax') }}:
                <b>{{ SetNumberFormat($response->data->tax_price) }}</b>
            </span>
            <span>
                {{ __('Coupon') }}:
                <b class="discount_amount_currency">- {{ SetNumberFormat(0) }}</b>
            </span>
        </div>
        <div class="payment-ttl-left">
            <h5> {{ __('Total') }} :</h5>
            <div class="ttl-pric final_amount_currency1">
                {{ SetNumberFormat($response->data->final_price) }}
            </div>
        </div>
    </div>
</div>