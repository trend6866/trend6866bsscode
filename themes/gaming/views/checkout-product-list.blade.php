<div class="order-confirm-details">
    <h4> {{ __('Product informations') }} :</h4>
    <ul>
        @if (!empty($response->data->cart_total_product))
            @foreach ($response->data->product_list as $item)
                <li>{{ $item->qty }} {{ $item->name }} ({{ SetNumberFormat($item->final_price) }})</li>
            @endforeach
        @endif
    </ul>
</div>