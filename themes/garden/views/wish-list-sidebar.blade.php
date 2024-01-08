<div class="wishDrawer">
    <div class="mini-wish-header">
       <h4>{{ __('My wish') }}<span class="wishcount">[{!! \App\Models\Wishlist::WishCount() !!}]</span></h4>
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
        {{-- @dd( $item->final_price) --}}
          <div class="mini-wish-item">
             <div class="mini-wish-image">
                <a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}" title="SPACE BAG">
                   <img src="{{ get_file($item->product_image ,APP_THEME()) }}" alt="plant1">
                </a>
             </div>
             <div class="mini-wish-details" style="color: black;">
                <p class="mini-wish-title"><a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}"> {{$item->product_name}}</a></p>
                @if ($item->variant_id != 0)
                    {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                @endif

                <div class="pvarprice d-flex align-items-center justify-content-between">
                   <div class="price">

                      <ins>{{ $item->final_price }}<span class="currency-type">{{ $currency_name }}</span></ins><del>{{ SetNumberFormat($item->original_price) }}</del>
                   </div>

                </div>
             </div>

             <a href="JavaScript:void(0)" class="common-btn addtocart-btn addcart-btn-globaly" product_id="{{ $item->product_id }}" variant_id="{{ $item->variant_id}}" qty="1">
                <span>{{__('Add To Cart')}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                    fill="white" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                    fill="white" />
                </svg>
            </a>

            <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $item->product_id }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false" role="presentation" class="icon icon-remove ">
                    <path d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z" fill="currentColor"></path>
                    <path d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z" fill="currentColor"></path>
                </svg>
            </a>


          </div>
          @endforeach
        @else
            <p class="emptywish text-center">{{ __('You have no items in your shopping wish.') }}</p>
        @endif
       </div>

    </div>
 </div>
