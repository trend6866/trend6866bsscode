<table class="order-history-tbl">
    <thead>
        <tr>
            <th scope="col">{{ __('Product') }}</th>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('date') }}</th>
            <th scope="col">{{ __('Price') }}</th>
            <th scope="col">{{ __('Total') }}</th>
            <th scope="col">{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($wishlists) > 0)
            @foreach ($wishlists as $wishlist)
                @php
                    $p_id = hashidsencode($wishlist->ProductData->id);
                @endphp
                <tr>
                    <td data-label="Product">
                        <div class="table-img-wrapper">
                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                <img src="{{ get_file($wishlist->ProductData->cover_image_path ,APP_THEME()) }}" >

                            </a>
                        </div>
                    </td>
                    <td data-label="Name">
                        <a href="{{route('page.product',[$slug,$p_id])}}">{{ !empty($wishlist->ProductData) ? $wishlist->ProductData->name : '' }}</a>
                        <div class="product-option">
                            <dt>{{ !empty($wishlist->GetVariant) ? $wishlist->GetVariant->variant : ''}}</dt>
                        </div>
                    </td>
                    <td data-label="date">{{$wishlist->created_at->format('d M, Y ')}}</td>
                    <td data-label="Price">
                        {{$currency_icon.$wishlist->ProductData->original_price}}
                    </td>
                    <td data-label="Total">
                        {{$currency_icon.$wishlist->ProductData->final_price}}
                    </td>
                    <td data-label="Action">
                        <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $wishlist->id }}">
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
                <td><h3>{{ __('No records found')}}</h3></td>
            </tr>
        @endif
    </tbody>
</table>

<div class="right-result-tbl text-right">
    <b>{{__('Showing')}} {{ $wishlists->firstItem() }}</b> {{__('to')}} {{ $wishlists->lastItem() }} {{__('of')}} {{ $wishlists->currentPage() }} ({{ $wishlists->lastPage() }} {{__('Pages')}})
</div>
<div class="form-container">
    <div class="d-flex acc-back-btn-wrp align-items-center justify-content-end">
        @php
            $previousPageUrl = '';
            $nextPageUrl = '';
            if ($wishlists->currentPage() < 1) {
                $previousPageUrl = $wishlists->previousPageUrl();
            }
            if ($wishlists->lastPage() > 1 && $wishlists->currentPage() != $wishlists->lastPage()) {
                $nextPageUrl = $wishlists->nextPageUrl();
            }
        @endphp
         <div class="d-flex acc-back-btn-wrp align-items-center justify-content-end">
            <button class="outline-btn back-btn-acc" onclick="get_wishlists('{{ $previousPageUrl }}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                    <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                </svg>
                {{__('Back')}}
            </button>
            <button class="common-btn2 btn continue-btn" onclick="get_wishlists('{{ $nextPageUrl }}')">
                {{__('Continue')}}
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                    <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
