<div class="wishDrawer">
    <div class="mini-wish-header">
       <h4>{{ __('My wish') }}</h4>
       <div class="wish-tottl-itm"> {{ __('Items') }}</div>
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
        {{-- @foreach ($response->data->data as $item)

          <div class="mini-wish-item">
             <div class="mini-wish-image">
                <a href="{{route('page.product', hashidsencode($item->product_id))}}" title="SPACE BAG">
                   <img src="{{asset('/'.$item->product_image)}}" alt="img">
                </a>
             </div>
             <div class="mini-wish-details" style="color: black;">
                <p class="mini-wish-title"><a href="{{route('page.product', hashidsencode($item->product_id))}}"> {{$item->product_name}}</a></p>
                @if ($item->variant_id != 0)
                    {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                @endif

                <div class="pvarprice d-flex align-items-center justify-content-between">
                   <div class="price">

                      <ins>{{ $item->final_price }}<span class="currency-type">{{ $currency_name }}</span></ins><del>{{ SetNumberFormat($item->original_price) }}</del>
                   </div>

                </div>
             </div>

             <a href="#" class="common-btn addtocart-btn addcart-btn-globaly" product_id="{{ $item->product_id }}" variant_id="{{ $item->variant_id}}" qty="1">
                <span>Check more products</span>
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

            <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $item->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false" role="presentation" class="icon icon-remove ">
                    <path d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z" fill="currentColor"></path>
                    <path d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z" fill="currentColor"></path>
                </svg>
            </a>


          </div>
          @endforeach --}}
          @foreach ($response->data->data as $item)
          <div class="mini-cart-item">
              <div class="mini-cart-image">
                  <a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}">
                      <img src="{{asset(get_file($item->product_image) , APP_THEME())}}" alt="img">
                  </a>
              </div>
              <div class="mini-cart-details">
                  <p class="mini-cart-title"><a href="{{route('page.product', [$slug,hashidsencode($item->product_id)])}}">{{ $item->product_name }}</a></p>
                  @if ($item->variant_id != 0)
                      {!! \App\Models\ProductStock::variantlist($item->variant_id) !!}
                  @endif
                  <div class="pvarprice d-flex align-items-center justify-content-between">
                      <div class="price">
                          <ins>{{ $item->final_price }} <span class="currency-type">{{ $currency_name }}</span></ins><del>{{ SetNumberFormat($item->original_price) }}</del>
                      </div>

                      <a href="javascript:;" class="remove-btn py-1 delete_wishlist" data-id="{{ $item->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                              fill="none">
                              <path
                                  d="M12.7589 7.24609C12.5002 7.24609 12.2905 7.45577 12.2905 7.71448V16.5669C12.2905 16.8255 12.5002 17.0353 12.7589 17.0353C13.0176 17.0353 13.2273 16.8255 13.2273 16.5669V7.71448C13.2273 7.45577 13.0176 7.24609 12.7589 7.24609Z"
                                  fill="#61AFB3"></path>
                              <path
                                  d="M7.23157 7.24609C6.97286 7.24609 6.76318 7.45577 6.76318 7.71448V16.5669C6.76318 16.8255 6.97286 17.0353 7.23157 17.0353C7.49028 17.0353 7.69995 16.8255 7.69995 16.5669V7.71448C7.69995 7.45577 7.49028 7.24609 7.23157 7.24609Z"
                                  fill="#61AFB3"></path>
                              <path
                                  d="M3.20333 5.95419V17.4942C3.20333 18.1762 3.45344 18.8168 3.89035 19.2764C4.32525 19.7373 4.93049 19.9989 5.56391 20H14.4259C15.0594 19.9989 15.6647 19.7373 16.0994 19.2764C16.5363 18.8168 16.7864 18.1762 16.7864 17.4942V5.95419C17.6549 5.72366 18.2177 4.8846 18.1016 3.99339C17.9852 3.10236 17.2261 2.43583 16.3274 2.43565H13.9293V1.85017C13.932 1.35782 13.7374 0.885049 13.3888 0.537238C13.0403 0.18961 12.5668 -0.00396362 12.0744 6.15416e-05H7.91533C7.42298 -0.00396362 6.94948 0.18961 6.60093 0.537238C6.25239 0.885049 6.05772 1.35782 6.06046 1.85017V2.43565H3.66238C2.76367 2.43583 2.00456 3.10236 1.8882 3.99339C1.77202 4.8846 2.33481 5.72366 3.20333 5.95419ZM14.4259 19.0632H5.56391C4.76308 19.0632 4.14009 18.3753 4.14009 17.4942V5.99536H15.8497V17.4942C15.8497 18.3753 15.2267 19.0632 14.4259 19.0632ZM6.99723 1.85017C6.99412 1.60628 7.08999 1.37154 7.26307 1.19938C7.43597 1.02721 7.67126 0.932619 7.91533 0.936827H12.0744C12.3185 0.932619 12.5538 1.02721 12.7267 1.19938C12.8998 1.37136 12.9956 1.60628 12.9925 1.85017V2.43565H6.99723V1.85017ZM3.66238 3.37242H16.3274C16.793 3.37242 17.1705 3.74987 17.1705 4.21551C17.1705 4.68114 16.793 5.05859 16.3274 5.05859H3.66238C3.19674 5.05859 2.81929 4.68114 2.81929 4.21551C2.81929 3.74987 3.19674 3.37242 3.66238 3.37242Z"
                                  fill="#61AFB3"></path>
                              <path
                                  d="M9.99523 7.24609C9.73653 7.24609 9.52686 7.45577 9.52686 7.71448V16.5669C9.52686 16.8255 9.73653 17.0353 9.99523 17.0353C10.2539 17.0353 10.4636 16.8255 10.4636 16.5669V7.71448C10.4636 7.45577 10.2539 7.24609 9.99523 7.24609Z"
                                  fill="#61AFB3"></path>
                              <defs>
                                  <clipPath>
                                      <rect width="20" height="20" fill="white"></rect>
                                  </clipPath>
                              </defs>
                          </svg>
                    </a>
                  </div>
              </div>
          </div>
          @endforeach

        @else
            <p class="emptywish text-center">{{ __('You have no items in your shopping wish.') }}</p>
        @endif
       </div>

    </div>
 </div>
