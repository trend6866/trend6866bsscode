    <div class="mini-wish-header">
        <h4>{{ __('My wish') }}</h4>
        {{-- <div class="wish-tottl-itm">0{{ __('Items') }}</div> --}}
        <a href="#" class="closewish">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path
                    d="M20 1.17838L18.8216 0L10 8.82162L1.17838 0L0 1.17838L8.82162 10L0 18.8216L1.17838 20L10 11.1784L18.8216 20L20 18.8216L11.1784 10L20 1.17838Z"
                    fill="white"></path>
            </svg>
        </a>
    </div>
    <div id="wish-body" class="mini-wish-has-item">
        <div class="mini-wish-body">
            @if (!empty($response->data->data))
                @foreach ($response->data->data as $item)
                    <div class="mini-wish-item">
                        <div class="mini-wish-image">
                            <a href="{{ route('page.product', [$slug,hashidsencode($item->product_id)]) }}" title="SPACE BAG">
                                <img src="{{ get_file($item->product_image, APP_THEME()) }}" alt="plant1">
                            </a>
                        </div>
                        <div class="mini-wish-details" style="color: black;">
                            <p class="mini-wish-title ">
                                <a href="{{ route('page.product', [$slug,hashidsencode($item->product_id)]) }}">{{ $item->product_name }}
                                </a>
                            </p>
                            @if ($item->variant_id != 0)
                                {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                            @endif
                            <div class="pvarprice d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{ $item->final_price }}<span
                                            class="currency-type">{{ $currency_name }}</span></ins>
                                    <del>{{ SetNumberFormat($item->original_price) }}</del>
                                </div>
                            </div>
                            <a href="#" class="btn addcart-btn-globaly" product_id="{{ $item->product_id }}"
                                variant_id="{{ $item->variant_id }}" qty="1">
                                <span>{{ __('Add To Cart') }}</span>
                            </a>
                        </div>


                        <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $item->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true"
                                focusable="false" role="presentation" class="icon icon-remove ">
                                <path
                                    d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z"
                                    fill="currentColor"></path>
                                <path
                                    d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="emptywish text-center" style="color: black;">
                    {{ __('You have no items in your shopping wish.') }}</p>
            @endif
        </div>

    </div>
