<table class="order-history-tbl my-acc-rightbar">
    <thead>
        <tr>
            <th scope="col">{{ __('Order ID') }}</th>
            <th scope="col">{{ __('Order Date') }}</th>
            <th scope="col">{{ __('Product') }}</th>
            <th scope="col">{{ __('Price') }}</th>
            <th scope="col"> {{ __('Payment Type') }}</th>
            <th scope="col"> {{ __('Delivered Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($orders) > 0)
            @foreach ($orders as $Order)
                @php $order_data = $Order->order_detail($Order->id); @endphp
                <tr>
                    <td> {{ $order_data['order_id'] }} </td>
                    <td> {{ $order_data['delivery_date'] }} </td>
                    <td> {{ implode(', ',array_column($order_data['product'], 'name')) }} </td>
                    <td> {{ $order_data['final_price'] }} </td>
                    <td> {{ $order_data['paymnet_type'] }} </td>
                    <td> {{ $order_data['order_status_text'] }} </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td><h4>{{ __('No records found') }}</h4></td>
            </tr>
        @endif
    </tbody>
</table>
<div class="right-result-tbl text-right">
    <b>{{__('Showing')}} {{ $orders->firstItem() }}</b> {{__('to')}} {{ $orders->lastItem() }} {{__('of')}} {{ $orders->currentPage() }} ({{ $orders->lastPage() }} {{__('Pages')}})
</div>
<div class="form-container">
    <div class="">
        @php
            $previousPageUrl = '';
            $nextPageUrl = '';
            if ($orders->currentPage() < 1) {
                $previousPageUrl = $orders->previousPageUrl();
            }
            if ($orders->lastPage() > 1 && $orders->currentPage() != $orders->lastPage()) {
                $nextPageUrl = $orders->nextPageUrl();
            }
        @endphp
        <div class="d-flex acc-back-btn-wrp align-items-center justify-content-end">
            <button class="outline-btn back-btn-acc" onclick="get_order('{{ $previousPageUrl }}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                    <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                </svg>
                {{__('Back')}}
            </button>
            <button class="btn continue-btn common-btn2" onclick="get_order('{{ $nextPageUrl }}')">
                {{__('Continue')}}
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                    <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>