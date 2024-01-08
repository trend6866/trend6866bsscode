<table class="order-history-tbl">
    <thead>
        <tr>
            <th scope="col">{{ __('Title') }}</th>
            <th scope="col">{{ __('Address') }}</th>
            <th scope="col">{{ __('Postcode') }}</th>
            <th scope="col">{{ __('Default Address') }}</th>
            <th scope="col"> {{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($DeliveryAddress))
            @foreach ($DeliveryAddress as $address)
                <tr>
                    <td> {{ $address->title }} </td>
                    <td> {{ $address->address }} </td>
                    <td> {{ $address->postcode }} </td>
                    <td> {{ $address->default_address }} </td>
                    <td data-label="Action">
                        <i class="ti ti-eye text-white py-1 edit_address" data-id="{{ $address->id }}" data-bs-toggle="tooltip" title="edit"></i>
                        {{-- <i class="ti ti-trash text-white py-1 delete_address" data-id="{{ $address->id }}" data-bs-toggle="tooltip" title="delete"></i> --}}
                        <a href="javascript:;" class="remove-btn py-1 delete_address" data-id="{{ $address->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false" role="presentation" class="icon icon-remove ">
                                <path d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z" fill="currentColor"></path>
                                <path d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td><h3>{{ __('No records found') }}</h3></td>
            </tr>
        @endif
    </tbody>
</table>
<div class="right-result-tbl text-right">
    <b>{{__('Showing')}} {{ $DeliveryAddress->firstItem() }}</b> {{__('to')}} {{ $DeliveryAddress->lastItem() }} {{__('of')}} {{                        $DeliveryAddress->currentPage() }} ({{ $DeliveryAddress->lastPage() }} {{__('Pages')}})
</div>
<div class="form-container">
    <div class="d-flex acc-back-btn-wrp align-items-center justify-content-end">
        @php
            $previousPageUrl = '';
            $nextPageUrl = '';
            if ($DeliveryAddress->currentPage() < 1) {
                $previousPageUrl = $DeliveryAddress->previousPageUrl();
            }
            if ($DeliveryAddress->lastPage() > 1 && $DeliveryAddress->currentPage() != $DeliveryAddress->lastPage()) {
                $nextPageUrl = $DeliveryAddress->nextPageUrl();
            }
        @endphp
        <button class="outline-btn back-btn-acc" onclick="get_address('{{ $previousPageUrl }}')">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
            </svg>
            {{__('Back')}}
        </button>
        <button class="common-btn2 btn continue-btn" onclick="get_address('{{ $nextPageUrl }}')">
            {{ __('Next') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
            </svg>
        </button>
    </div>
</div>
