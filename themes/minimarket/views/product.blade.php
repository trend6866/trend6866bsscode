    @extends('layouts.layouts')
    @php
        $p_name = json_decode($products);
    @endphp

    @section('page-title')
        {{ __($p_name[0]->name) }}
    @endsection
    @section('content')

        @foreach ($products as $product)
            @php
                $description = json_decode($product->other_description);
                    foreach ($description as $k => $value)
                    {
                        $value =  json_decode(json_encode($value), true);

                        foreach ($value['inner-list'] as $description_val) {
                            if ($description_val['field_slug'] == 'product-other-description-other-description') {
                                $description_value = !empty($description_val['value']) ? $description_val['value'] : $description_val['field_default_text'] ;
                            }
                            if ($description_val['field_slug'] == 'product-other-description-other-description-image') {
                                $description_img = !empty($description_val['image_path']) ? $description_val['image_path'] : '';
                            }
                            if ($description_val['field_slug'] == 'product-other-description-more-informations') {
                                $more_description_value = !empty($description_val['value']) ? $description_val['value'] : $description_val['field_default_text'];
                            }
                            if ($description_val['field_slug'] == 'product-other-description-more-information-image') {
                                $more_description_img = !empty($description_val['image_path']) ? $description_val['image_path'] : '';
                            }
                        }
                    }
            @endphp
            <!--wrapper start here-->
            <div class="wrapper" style="margin-top: 156px;">
                <div class="main-parent-top">
                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/circle-design.png') }}" class="desk-only" id="circle-design7" alt="circle-design">
                    <!-- product slider sec start  -->
                    <section class="product-sec padding-bottom padding-top">
                        @php
                            $product_ids = hashidsencode($product->id);
                        @endphp
                       <div class=" container">
                          <div class=" row">
                             <div class=" col-md-6 col-12">
                                <div class="product-left-inner">
                                   <div class="top-row">
                                      <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                            <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765" />
                                            <g clip-path="url(#clip0_318_284)">
                                               <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="white" />
                                            </g>
                                         </svg>
                                         <span> {{__('Back to category')}}</span>
                                      </a>
                                      @auth
                                        <a href="javascript:void(0)" class="wishbtn variant_form wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                            <span>{{__('Add to wishlist')}}</span>
                                            <span class="wish-ic">
                                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </span>
                                        </a>
                                      @endauth
                                   </div>
                                    @php
                                        date_default_timezone_set('Asia/Kolkata');
                                        $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
                                        $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                            ->where('store_id', getCurrentStore())
                                            ->where('is_active', 1)
                                            ->get();
                                        $latestSales = [];

                                        foreach ($sale_product as $flashsale) {
                                            $saleEnableArray = json_decode($flashsale->sale_product, true);
                                            $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                            $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

                                            if ($endDate < $startDate) {
                                                $endDate->addDay();
                                            }

                                            if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                    $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                                    $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);
                                                    $latestSales[$product->id] = [
                                                        'start_date' => $flashsale['start_date'],
                                                        'end_date' => $flashsale['end_date'],
                                                        'start_time' => $flashsale['start_time'],
                                                        'end_time' => $flashsale['end_time'],
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="common-heading">
                                        <span class="sub-heading "> {{$product->name}}</span>
                                        <h2>{{ $product->ProductData()->name }} </h2>
                                        <p class="product-variant-description">{{ $product->description }}</p>
                                    </div>

                                    <div class="count-right">
                                        @if ($latestSales)
                                            @foreach ($latestSales as $productId => $saleData)
                                                <input type="hidden" class="flash_sale_start_date"
                                                    value={{ $saleData['start_date'] }}>
                                                <input type="hidden" class="flash_sale_end_date"
                                                    value={{ $saleData['end_date'] }}>
                                                <input type="hidden" class="flash_sale_start_time"
                                                    value={{ $saleData['start_time'] }}>
                                                <input type="hidden" class="flash_sale_end_time"
                                                    value={{ $saleData['end_time'] }}>
                                                <div id="flipdown" class="flipdown"></div>
                                            @endforeach
                                        @endif
                                        @if (!empty($product->custom_field))
                                            @foreach (json_decode($product->custom_field, true) as $item)
                                                <div class="pdp-detail d-flex  align-items-center">
                                                    <b>{{ $item['custom_field'] }} :</b>
                                                    <span class="lbl">{{ $item['custom_value'] }}</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="price product-price-amount">
                                        <ins>
                                            <ins class="min_max_price" style="display: inline;">
                                                {{ $currency_icon }}{{ $mi_price }} -
                                                {{ $currency_icon }}{{ $ma_price }} </ins>
                                        </ins>
                                    </div>
                                    @if ($product->variant_product == 1)
                                        <h6 class="enable_option">
                                            @if ($product->product_stock > 0)
                                                <span
                                                    class="stock">{{ $product->product_stock }}</span><small>{{ __(' in stock') }}</small>
                                            @endif
                                        </h6>
                                    @else
                                        <h6>
                                            @if ($product->track_stock == 0)
                                                @if ($product->stock_status == 'out_of_stock')
                                                    <span>{{ __('Out of Stock') }}</span>
                                                @elseif ($product->stock_status == 'on_backorder')
                                                    <span>{{ __('Available on backorder') }}</span>
                                                @else
                                                    <span></span>
                                                @endif
                                            @else
                                                @if ($product->product_stock > 0)
                                                    <span>{{ $product->product_stock }}
                                                        {{ __('  in stock') }}</span>
                                                @endif
                                            @endif
                                        </h6>
                                    @endif
                                    <span class="product-price-error"></span>
                                    <form class="variant_form w-100">
                                        @csrf
                                        @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                        @else
                                            <div class="top-content">
                                                <div class="prorow-lbl-qntty">
                                                    <div class="product-labl ">{{__('quantity')}}</div>
                                                    <div class="qty-spinner">
                                                        <button type="button" class="quantity-decrement change_price">
                                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3"></path>
                                                            </svg>
                                                        </button>
                                                        <input type="text" class="quantity" data-cke-saved-name="quantity"
                                                            name="qty" value="01" min="01" max="100">
                                                        <button type="button" class="quantity-increment change_price">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                                    fill="#61AFB3"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div><br>

                                                <div class="select-container">
                                                    @if ($product->variant_product == 1)
                                                        @php
                                                            $variant = json_decode($product->product_attribute);
                                                            $varint_name_array = [];
                                                            if(!empty($product->DefaultVariantData->variant)) {

                                                                $varint_name_array = explode('-', $product->DefaultVariantData->variant);

                                                            }
                                                        @endphp
                                                        @foreach ($variant as $key => $value)
                                                            @php
                                                                $p_variant = App\Models\Utility::ProductAttribute($value->attribute_id);
                                                                $attribute = json_decode($p_variant);
                                                                $propertyKey = 'for_variation_' . $attribute->id;
                                                                $variation_option = $value->$propertyKey;
                                                            @endphp
                                                            @if ($variation_option == 1)
                                                                <p><b>{{$attribute->name}}:</b></p>
                                                                <div class="text-checkbox checkbox-radio d-flex align-items-center" >
                                                                    <select class="custom-select-btn product_variatin_option variant_loop"
                                                                        name="varint[{{ $attribute->name }}]">
                                                                        @php
                                                                            $optionValues = [];
                                                                        @endphp

                                                                        @foreach ($value->values as $variant1)
                                                                            @php
                                                                                $parts = explode('|', $variant1);
                                                                            @endphp
                                                                            @foreach ($parts as $p)
                                                                                @php
                                                                                    $id = App\Models\ProductAttributeOption::where('id', $p)->first();
                                                                                    $optionValues[] = $id->terms;
                                                                                @endphp
                                                                            @endforeach
                                                                        @endforeach
                                                                        <option value="">
                                                                            {{ __('Select an option') }}
                                                                        </option>

                                                                        @if (is_array($optionValues))
                                                                            @foreach ($optionValues as $optionValue)
                                                                                <option>{{ $optionValue }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    {{-- <div class="details">Height: 78cm </div> --}}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="price-div d-flex align-items-end">
                                            <div class="price d-flex align-items-end product-price-amount price-value">
                                                <ins class="product_final_price">{{ $product->final_price }}</ins>
                                                <span class="currency-type">{{$currency}}</span>
                                            </div>
                                            @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                            @else
                                                <a href="javascript:void(0)" class="addtocart-btn addcart-btn variant_form addcart-btn-globaly common-btn price-wise-btn product_var_option" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                                    <span> {{__('Add to cart')}}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z" fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z" fill="white" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                    <div class="stock_status"></div>
                                </div>
                             </div>
                             <div class="col-md-6 col-12">
                                <div class="slider-wrapper">
                                    <div class="product-thumb-slider">
                                        @foreach ($product->Sub_image($product->id)['data'] as $item)
                                            <div class="product-thumb-item">
                                                <div class="thumb-img">
                                                    <img src="{{ get_file($item->image_path , APP_THEME()) }}" class="product-img">

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                   <div class="product-main-slider lightbox">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                      <div class="product-main-item">
                                         <div class="product-item-img">
                                            <img src="{{ get_file($item->image_path , APP_THEME()) }}" class="product-img">
                                            @php
                                                $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
                                                $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                    ->where('store_id', getCurrentStore())
                                                    ->where('is_active', 1)
                                                    ->get();
                                                $latestSales = [];

                                                foreach ($sale_product as $flashsale) {
                                                    $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                    $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                                                    $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

                                                    if ($endDate < $startDate) {
                                                        $endDate->addDay();
                                                    }

                                                    if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                        if (is_array($saleEnableArray) && in_array($product->id, $saleEnableArray)) {
                                                            $latestSales[$product->id] = [
                                                                'discount_type' => $flashsale->discount_type,
                                                                'discount_amount' => $flashsale->discount_amount,
                                                            ];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach ($latestSales as $productId => $saleData)
                                                <div class="custom-output sale-tag-product">
                                                    <div class="sale_tag_icon rounded col-1 onsale">
                                                        <div>{{ __('Sale!') }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <a href="{{ get_file($item->image_path , APP_THEME()) }}" data-caption="{{$product->name}}" class="open-lightbox ">
                                               <div class="img-prew-icon">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 25 25" fill="none">
                                                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z" fill="white" />
                                                  </svg>
                                               </div>
                                               <span class="img-prew-text">{{__('click to preview')}}</span>
                                            </a>
                                         </div>
                                      </div>
                                      @endforeach
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </section>

                    {{-- <section class="description-sec padding-bottom">
                        <div class=" container">
                           <div class=" row align-items-center">
                              <div class=" col-md-6 col-12">
                                 <div class="description-box common-heading">
                                    <span class="sub-heading">Dry Fruits</span>
                                    <h2>Description</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                       industry's standard dummy.Lorem Ipsum is simply dummy text of the printing and typesetting
                                       industry. Lorem Ipsum has been the industry's standard dummy.Lorem Ipsum is simply dummy text of
                                       the printing and typesetting industry. </p>
                                 </div>
                              </div>
                              <div class=" col-md-6 col-12">
                                 <div class="methods common-heading">
                                    <span class="sub-heading">Fruit & Vegetables</span>
                                    <h2>The method of care </h2>
                                    <div class="methods-desc">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="13" height="20" viewBox="0 0 13 20" fill="none">
                                          <g clip-path="url(#clip0_8_1077)">
                                             <path d="M13.0024 6.66748V4.99998H11.3765C11.3756 4.62894 11.2923 4.263 11.1328 3.92998L12.5953 2.42998L11.4472 1.24998L9.98462 2.74998C9.65849 2.58796 9.30124 2.50256 8.93887 2.49998C8.63823 2.50128 8.34052 2.56064 8.06132 2.67498C7.93283 2.02962 7.62076 1.43779 7.16451 0.974228C6.70825 0.510663 6.12829 0.196157 5.49786 0.0704306C4.86743 -0.0552961 4.2148 0.0133955 3.62242 0.26783C3.03003 0.522265 2.52444 0.951031 2.16951 1.49998L0.624039 0.842476L0 2.38248L1.65029 3.07498C1.65029 3.16248 1.62591 3.24498 1.62591 3.32498V4.99998H0V6.66748H1.62591V8.33248H0V9.99998H1.62591V11.6675H0V13.3325H1.62591V15H0V18.3325C0.00128605 18.7743 0.173 19.1977 0.47764 19.5101C0.782279 19.8226 1.19509 19.9987 1.62591 20H11.3765C11.8073 19.9987 12.2202 19.8226 12.5248 19.5101C12.8294 19.1977 13.0011 18.7743 13.0024 18.3325V15H11.3765V13.3325H13.0024V11.6675H11.3765V9.99998H13.0024V8.33248H11.3765V6.66748H13.0024ZM8.12713 4.99998C8.12713 4.77918 8.21266 4.56743 8.36489 4.41131C8.51712 4.25519 8.72358 4.16748 8.93887 4.16748C9.15416 4.16748 9.36063 4.25519 9.51286 4.41131C9.66509 4.56743 9.75061 4.77918 9.75061 4.99998V15H8.12713V4.99998ZM3.25183 11.6675V9.99998H4.8753V8.33248H3.25183V6.66748H4.8753V4.99998H3.25183V3.33248C3.2681 2.90173 3.44639 2.49418 3.7493 2.19532C4.05221 1.89647 4.4562 1.72953 4.87652 1.72953C5.29684 1.72953 5.70083 1.89647 6.00374 2.19532C6.30665 2.49418 6.48495 2.90173 6.50122 3.33248V15H3.25183V13.3325H4.8753V11.6675H3.25183ZM11.3765 18.3325H1.62591V16.6675H11.3765V18.3325Z" fill="#B5C547" />
                                          </g>
                                          <defs>
                                             <clipPath id="clip0_8_1077">
                                                <rect width="13" height="20" fill="white" />
                                             </clipPath>
                                          </defs>
                                       </svg>
                                       <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                          the industry's.</p>
                                    </div>
                                    <div class="methods-desc">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                          <path d="M15.7142 9.00004C16.3349 8.61128 16.86 8.08756 17.2503 7.46783C17.6407 6.84811 17.8863 6.14834 17.9688 5.42059C18.0513 4.69284 17.9687 3.95584 17.7271 3.26444C17.4854 2.57303 17.091 1.94502 16.5731 1.42712C16.0552 0.909226 15.4272 0.51478 14.7358 0.273133C14.0443 0.0314857 13.3074 -0.0511414 12.5796 0.0313995C11.8519 0.11394 11.1521 0.359524 10.5324 0.749879C9.91264 1.14023 9.38891 1.66531 9.00016 2.28604C8.6114 1.66531 8.08768 1.14023 7.46796 0.749879C6.84823 0.359524 6.14846 0.11394 5.42071 0.0313995C4.69296 -0.0511414 3.95597 0.0314857 3.26456 0.273133C2.57316 0.51478 1.94514 0.909226 1.42724 1.42712C0.909348 1.94502 0.514902 2.57303 0.273255 3.26444C0.0316078 3.95584 -0.0510194 4.69284 0.0315216 5.42059C0.114062 6.14834 0.359646 6.84811 0.750001 7.46783C1.14035 8.08756 1.66543 8.61128 2.28616 9.00004C1.66543 9.38879 1.14035 9.91251 0.750001 10.5322C0.359646 11.152 0.114062 11.8517 0.0315216 12.5795C-0.0510194 13.3072 0.0316078 14.0442 0.273255 14.7356C0.514902 15.427 0.909348 16.0551 1.42724 16.5729C1.94514 17.0908 2.57316 17.4853 3.26456 17.7269C3.95597 17.9686 4.69296 18.0512 5.42071 17.9687C6.14846 17.8861 6.84823 17.6405 7.46796 17.2502C8.08768 16.8598 8.6114 16.3348 9.00016 15.714C9.38891 16.3348 9.91264 16.8598 10.5324 17.2502C11.1521 17.6405 11.8519 17.8861 12.5796 17.9687C13.3074 18.0512 14.0443 17.9686 14.7358 17.7269C15.4272 17.4853 16.0552 17.0908 16.5731 16.5729C17.091 16.0551 17.4854 15.427 17.7271 14.7356C17.9687 14.0442 18.0513 13.3072 17.9688 12.5795C17.8863 11.8517 17.6407 11.152 17.2503 10.5322C16.86 9.91251 16.3349 9.38879 15.7142 9.00004ZM13.1244 1.50079C13.969 1.53483 14.77 1.88452 15.3691 2.48073C15.9682 3.07693 16.3219 3.87625 16.36 4.72062C16.3982 5.56499 16.1182 6.39295 15.5753 7.04078C15.0324 7.68862 14.2662 8.10917 13.4282 8.21929C13.2674 7.31078 12.8313 6.47363 12.1789 5.82125C11.5266 5.16886 10.6894 4.73276 9.78091 4.57204C9.85645 3.73598 10.2408 2.95809 10.8591 2.39021C11.4773 1.82232 12.285 1.50522 13.1244 1.50079ZM1.50091 4.87579C1.53495 4.03124 1.88465 3.23021 2.48085 2.63108C3.07706 2.03194 3.87637 1.67833 4.72074 1.64016C5.56511 1.60198 6.39307 1.88202 7.04091 2.42491C7.68874 2.9678 8.1093 3.73401 8.21941 4.57204C7.3109 4.73276 6.47375 5.16886 5.82137 5.82125C5.16898 6.47363 4.73289 7.31078 4.57216 8.21929C3.73611 8.14375 2.95821 7.75935 2.39033 7.14112C1.82245 6.5229 1.50534 5.71523 1.50091 4.87579ZM4.87591 16.4993C4.03136 16.4652 3.23033 16.1155 2.6312 15.5193C2.03207 14.9231 1.67845 14.1238 1.64028 13.2795C1.6021 12.4351 1.88215 11.6071 2.42503 10.9593C2.96792 10.3115 3.73413 9.8909 4.57216 9.78079C4.73289 10.6893 5.16898 11.5264 5.82137 12.1788C6.47375 12.8312 7.3109 13.2673 8.21941 13.428C8.14387 14.2641 7.75947 15.042 7.14124 15.6099C6.52302 16.1777 5.71535 16.4949 4.87591 16.4993ZM9.00016 11.9993C8.40696 11.9993 7.82709 11.8234 7.33386 11.4938C6.84064 11.1643 6.45622 10.6958 6.22921 10.1478C6.00221 9.59976 5.94281 8.99671 6.05854 8.41491C6.17426 7.83311 6.45992 7.2987 6.87937 6.87925C7.29882 6.45979 7.83324 6.17414 8.41503 6.05842C8.99683 5.94269 9.59988 6.00208 10.1479 6.22909C10.696 6.4561 11.1644 6.84052 11.4939 7.33374C11.8235 7.82697 11.9994 8.40684 11.9994 9.00004C11.9994 9.79549 11.6834 10.5584 11.1209 11.1208C10.5585 11.6833 9.79561 11.9993 9.00016 11.9993ZM13.1244 16.4993C12.285 16.4949 11.4773 16.1777 10.8591 15.6099C10.2408 15.042 9.85645 14.2641 9.78091 13.428C10.6894 13.2673 11.5266 12.8312 12.1789 12.1788C12.8313 11.5264 13.2674 10.6893 13.4282 9.78079C14.2662 9.8909 15.0324 10.3115 15.5753 10.9593C16.1182 11.6071 16.3982 12.4351 16.36 13.2795C16.3219 14.1238 15.9682 14.9231 15.3691 15.5193C14.77 16.1155 13.969 16.4652 13.1244 16.4993Z" fill="#B5C547" />
                                       </svg>
                                       <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                          the industry's.</p>
                                    </div>
                                    <div class="methods-desc">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="19" height="21" viewBox="0 0 19 21" fill="none">
                                          <g clip-path="url(#clip0_8_1087)">
                                             <path d="M9.28624 11.2297C10.3565 11.9891 11.6565 12.3421 12.9582 12.2269C14.2598 12.1117 15.4798 11.5356 16.4038 10.5997C18.8186 8.15584 19.513 4.41785 18.6528 0.36222C14.6419 -0.496154 10.9523 0.196845 8.5478 2.64072C7.59806 3.60334 7.02444 4.88178 6.93299 6.23967C6.84154 7.59756 7.23844 8.94308 8.05032 10.0275L8.03477 10.0432C6.97765 11.1093 6.29964 12.5006 6.10705 13.9991H0V15.75H1.21001L1.55721 19.2596C1.61337 19.733 1.83652 20.1698 2.18553 20.4896C2.53455 20.8095 2.98591 20.9907 3.45643 21H10.3641C10.8348 20.9902 11.2862 20.8089 11.6355 20.4892C11.9848 20.1695 12.2087 19.733 12.2659 19.2596L12.6105 15.75H13.8205V13.9991H7.86117C8.03247 12.9665 8.51486 12.0129 9.24219 11.2691L9.28624 11.2297ZM10.8745 15.75L10.5377 19.2491H3.28283L2.946 15.75H10.8745ZM9.02455 4.9481C9.49554 5.75331 10.0639 6.4958 10.7165 7.15835L11.9369 5.92197C11.2328 5.20889 10.6443 4.38765 10.1931 3.4886C10.6391 3.11081 11.1322 2.79398 11.6596 2.54622C12.0362 3.33898 12.5426 4.06143 13.1572 4.68297L14.3802 3.4466C13.9575 3.01406 13.6004 2.52045 13.3205 1.98185C14.5841 1.71802 15.8835 1.67893 17.1604 1.86635C17.3453 3.15998 17.3067 4.47635 17.0464 5.7566C16.5134 5.47524 16.0258 5.11321 15.6006 4.68297L14.3802 5.92197C14.9964 6.545 15.7121 7.05798 16.4971 7.43922C16.2494 7.97363 15.9341 8.47308 15.5591 8.92497C14.6721 8.466 13.8617 7.869 13.1572 7.15572L11.9369 8.39997C12.5905 9.05968 13.3224 9.63458 14.1159 10.1115C13.4029 10.4621 12.5997 10.5788 11.8181 10.4453C11.0365 10.3118 10.3155 9.93472 9.75531 9.36663C9.19514 8.79854 8.82372 8.06766 8.69275 7.27571C8.56177 6.48376 8.67775 5.67014 9.02455 4.9481Z" fill="#B5C547" />
                                          </g>
                                          <defs>
                                             <clipPath id="clip0_8_1087">
                                                <rect width="19" height="21" fill="white" />
                                             </clipPath>
                                          </defs>
                                       </svg>
                                       <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                          the industry's.</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </section> --}}

                    <section class="tab-vid-section padding-top">
                        <div class="container">
                            <div class="tabs-wrapper">
                                <div class="blog-head-row tab-nav d-flex justify-content-between">
                                    <div class="blog-col-left ">
                                        <ul class="d-flex tabs">
                                            <li class="tab-link on-tab-click active" data-tab="0"><a
                                                    href="javascript:;">{{ __('Description') }}</a>
                                            </li>
                                            @if($product->preview_content != '')
                                            <li class="tab-link on-tab-click" data-tab="1"><a
                                                    href="javascript:;">{{ __('Video') }}</a>
                                            </li>
                                            @endif
                                            @if ($product->product_attribute != '')
                                                <li class="tab-link on-tab-click" data-tab="3"><a
                                                        href="javascript:;">{{ __('Additional Information') }}</a>
                                                </li>
                                            @endif
                                            <li class="tab-link on-tab-click" data-tab="2"><a
                                                    href="javascript:;">{{ __('Question & Answer') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tabs-container">
                                    <div id="0" class="tab-content active">
                                        <section class="description-sec">
                                            <div class=" container">
                                                <div class=" row align-items-center">
                                                    <div class=" col-md-6 col-12">
                                                        <div class="description-box common-heading">
                                                        <span class="sub-heading">{{__('Fruit & Vegetables')}}</span>
                                                        <h2>{{__('Description')}}</h2>
                                                        <p>{!! $description_value !!} </p>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-6 col-12">
                                                        <div class="methods common-heading">
                                                        {!! $more_description_value !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    @if($product->preview_content != '')
                                        <div id="1" class="tab-content">
                                            <div class="video-wrapper">
                                                @if ($product->preview_type == 'Video Url')
                                                    @if (str_contains($product->preview_content, 'youtube') || str_contains($product->preview_content, 'youtu.be'))
                                                        @php
                                                            if (strpos($product->preview_content, 'src') !== false) {
                                                                preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                                $url = $match[1];
                                                                $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                            } elseif (strpos($product->preview_content, 'src') == false && strpos($product->preview_content, 'embed') !== false) {
                                                                $video_url = str_replace('https://www.youtube.com/embed/', '', $product->preview_content);
                                                            } else {
                                                                $video_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                                                                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $product->preview_content, $matches);
                                                                if (count($matches) > 0) {
                                                                    $videoId = $matches[1];
                                                                    $video_url = strtok($videoId, '&');
                                                                }
                                                            }
                                                        @endphp
                                                        <iframe class="video-card-tag" width="100%" height="100%"
                                                            src="{{ 'https://www.youtube.com/embed/' }}{{ $video_url }}"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @elseif(str_contains($product->preview_content, 'vimeo'))
                                                        @php
                                                            if (strpos($product->preview_content, 'src') !== false) {
                                                                preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                                $url = $match[1];
                                                                $video_url = str_replace('https://player.vimeo.com/video/', '', $url);
                                                            } else {
                                                                $video_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                                                            }
                                                        @endphp
                                                        <iframe class="video-card-tag" width="100%" height="350"
                                                            src="{{ 'https://player.vimeo.com/video/' }}{{ $video_url }}"
                                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        @php
                                                            $video_url = $product->preview_content;
                                                        @endphp
                                                        <iframe class="video-card-tag" width="100%" height="100%"
                                                            src="{{ $video_url }}" title="Video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @endif
                                                @elseif($product->preview_type == 'iFrame')
                                                    @if (str_contains($product->preview_content, 'youtube') || str_contains($product->preview_content, 'youtu.be'))
                                                        @php
                                                            if (strpos($product->preview_content, 'src') !== false) {
                                                                preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                                $url = $match[1];
                                                                $iframe_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                            } else {
                                                                $iframe_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                                                            }
                                                        @endphp
                                                        <iframe width="100%" height="100%"
                                                            src="https://www.youtube.com/embed/{{ $iframe_url }}"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @elseif(str_contains($product->preview_content, 'vimeo'))
                                                        @php
                                                            if (strpos($product->preview_content, 'src') !== false) {
                                                                preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                                                                $url = $match[1];
                                                                $iframe_url = str_replace('https://player.vimeo.com/video/', '', $url);
                                                            } else {
                                                                $iframe_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                                                            }
                                                        @endphp
                                                        <iframe class="video-card-tag" width="100%" height="350"
                                                            src="{{ 'https://player.vimeo.com/video/' }}{{ $iframe_url }}"
                                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        @php
                                                            $iframe_url = $product->preview_content;
                                                        @endphp
                                                        <iframe class="video-card-tag" width="100%" height="100%"
                                                            src="{{ $iframe_url }}" title="Video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    @endif
                                                @else
                                                    <video controls="">
                                                        <source src="{{ get_file($product->preview_content, APP_THEME()) }}"
                                                            type="video/mp4">
                                                    </video>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div id="2" class="tab-content ">
                                        <div class="queary-div">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>{{ __('Have doubts regarding this product?') }}</h4>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary Question"
                                                    @if (\Auth::check()) data-ajax-popup="true" @else data-ajax-popup="false" @endif
                                                    data-size="xs" data-title="Post your question"
                                                    data-url="{{ route('Question', [$slug, $product->id]) }} " data-toggle="tooltip">
                                                    <i class="ti ti-plus"></i>
                                                    <span class="lbl">{{ __('Post Your Question') }}</span>
                                                </a>
                                            </div>
                                            <div class="qna">
                                                <br>
                                                <ul>
                                                    @foreach ($question->take(4) as $que)
                                                        <li>
                                                            <div class="quetion">
                                                                <span class="icon que">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="305"
                                                                        height="266" viewBox="0 0 305 266" fill="none"
                                                                        class="__web-inspector-hide-shortcut__">
                                                                        <path
                                                                            d="M152.4 256.4C222.8 256.4 283.6 216.2 300.1 158.6C303 148.8 304.4 138.6 304.4 128.4C304.4 57.7999 236.2 0.399902 152.4 0.399902C68.6004 0.399902 0.400391 57.7999 0.400391 128.4C0.600391 154.8 10.0004 180.3 27.0004 200.5C28.8004 202.7 29.3004 205.7 28.3004 208.4L6.70039 265.4L68.2004 238.4C70.4004 237.4 72.9004 237.5 75.0004 238.6C95.8004 248.9 118.4 254.9 141.5 256.1C145.2 256.3 148.8 256.4 152.4 256.4ZM104.4 120.4C104.4 85.0999 125.9 56.3999 152.4 56.3999C178.9 56.3999 200.4 85.0999 200.4 120.4C200.5 134.5 196.8 148.5 189.7 160.6L204.5 169.5C207 170.9 208.5 173.6 208.5 176.5C208.5 179.4 206.9 182 204.3 183.4C201.7 184.8 198.7 184.7 196.2 183.2L179.4 173.1C172.1 180.1 162.4 184.1 152.3 184.3C125.9 184.4 104.4 155.7 104.4 120.4Z"
                                                                            fill="black" />
                                                                        <path
                                                                            d="M164.9 164.4L156.3 159.2C152.6 156.9 151.4 152 153.7 148.3C156 144.6 160.8 143.3 164.6 145.5L176 152.4C181.6 142.7 184.6 131.6 184.4 120.4C184.4 94.3999 169.7 72.3999 152.4 72.3999C135.1 72.3999 120.4 94.3999 120.4 120.4C120.4 146.4 135.1 168.4 152.4 168.4C156.8 168.3 161.2 166.9 164.9 164.4Z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <div class="text">
                                                                    <p>
                                                                        {{ $que->question }}
                                                                    </p>
                                                                    <span class="user">{{ __($que->users->name) }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="answer">
                                                                <span class="icon ans">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="304"
                                                                        height="273" viewBox="0 0 304 273" fill="none">
                                                                        <path
                                                                            d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.4 55.5002 234.2 0.200195 152 0.200195C68.5 0.200195 0.6 57.1002 0 127.3C0 127.7 0 128 0 128.4C0.2 154.7 9.6 180.2 26.6 200.4C27.2 201.1 27.6 201.9 27.9 202.7C39.6 216.7 54.6 228.5 71.9 237.6C72.8 237.7 73.7 238 74.6 238.4C95.4 248.7 118 254.7 141.1 255.9C144.8 256.2 148.4 256.3 152 256.3C222.4 256.3 283.2 216.1 299.7 158.5C301.2 153.4 302.3 148.3 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM204 183.3C201.5 184.7 198.4 184.6 195.9 183.1L193.7 181.8L199.5 198.2C201 202.4 198.8 206.9 194.7 208.4C190.5 209.9 186 207.7 184.5 203.6L174.9 176.6C168.3 181.4 160.3 184.1 152.1 184.3C143.9 184.3 136.1 181.5 129.3 176.6L119.7 203.6C118.2 207.8 113.6 209.9 109.5 208.4C105.3 206.9 103.2 202.3 104.7 198.2L117 163.7C109.1 152.3 104.2 137 104.2 120.3C104.2 85.0002 125.7 56.3002 152.2 56.3002C178.7 56.3002 200.2 85.0002 200.2 120.3C200.4 134.4 196.6 148.3 189.5 160.5L204.3 169.4C206.8 170.9 208.3 173.5 208.3 176.4C208.1 179.3 206.5 181.9 204 183.3Z"
                                                                            fill="black" />
                                                                        <path
                                                                            d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.2 61.1002 243.4 8.7002 169.1 1.7002C168.8 2.7002 168.3 3.60019 168 4.50019C167.3 6.40019 166.6 8.20019 165.8 10.1002C165 12.0002 164.1 13.9002 163.2 15.8002C162.3 17.7002 161.4 19.4002 160.5 21.2002C159.5 23.0002 158.5 24.8002 157.5 26.5002C156.5 28.3002 155.4 30.0002 154.3 31.7002C153.2 33.4002 152 35.1002 150.8 36.7002C149.6 38.3002 148.4 40.0002 147.1 41.7002C145.8 43.3002 144.5 44.8002 143.2 46.4002C141.9 47.9002 140.5 49.5002 139.1 51.1002C137.7 52.6002 136.2 54.0002 134.8 55.5002C133.3 56.9002 131.8 58.4002 130.3 59.8002C128.8 61.2002 127.2 62.6002 125.5 63.9002C123.9 65.2002 122.3 66.6002 120.6 67.9002C118.9 69.2002 117.2 70.4002 115.4 71.7002C113.7 72.9002 112 74.1002 110.2 75.3002C108.4 76.5002 106.5 77.6002 104.6 78.7002C102.7 79.8002 101 80.9002 99.2 81.9002C97.3 82.9002 95.2 84.0002 93.2 85.0002C91.3 85.9002 89.5 86.9002 87.6 87.8002C85.5 88.8002 83.3 89.6002 81.2 90.5002C79.3 91.3002 77.4 92.1002 75.5 92.9002C73.3 93.7002 70.9 94.5002 68.6 95.2002C66.7 95.8002 64.7 96.5002 62.8 97.1002C60.4 97.8002 57.9 98.4002 55.4 99.0002C53.5 99.5002 51.6 100 49.6 100.4C47 101 44.3 101.4 41.6 101.9C39.8 102.2 37.9 102.6 36.1 102.9C33.1 103.3 30 103.6 26.9 103.9C25.3 104.1 23.8 104.3 22.2 104.4C17.5 104.7 12.7 104.9 8 104.9C6.2 104.9 4.5 104.9 2.7 104.8C0.999997 112.2 0.1 119.8 0 127.3C0 127.7 0 128 0 128.4V128.8C0 156.3 10.3 181.7 27.9 202.6C39.6 216.6 54.6 228.4 71.9 237.5C95.2 249.7 122.6 256.8 152 256.8C176.6 256.9 201 251.8 223.5 241.8C225.6 240.8 228.1 240.8 230.2 241.8L296.4 272.7L271.6 214.8C270.4 211.9 270.9 208.6 273 206.3C289.5 188.8 299.9 166.7 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM119.5 203.5C118 207.7 113.4 209.8 109.3 208.3C105.1 206.8 103 202.2 104.5 198.1L116.8 163.6L144.5 86.1002C145.6 82.9002 148.7 80.8002 152 80.8002C155.3 80.8002 158.4 82.9002 159.5 86.1002L193.7 181.7L199.5 198.1C201 202.3 198.8 206.8 194.7 208.3C190.5 209.8 186 207.6 184.5 203.5L174.9 176.5L172.1 168.8H132L129.2 176.5L119.5 203.5Z"
                                                                            fill="black" />
                                                                        <path d="M152 112.6L137.6 152.8H166.3L152 112.6Z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <div class="text">
                                                                    <p>
                                                                        {{ !empty($que->answers) ? $que->answers : 'We will provide the answer to your question shortly!' }}
                                                                    </p>
                                                                    <span
                                                                        class="user">{{ !empty($que->admin->name) ? $que->admin->name : '' }}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @if ($question->count() >= '4')
                                                    <div class="text-center">
                                                        <a href="javascript:void(0)" class="load-more-btn btn" data-ajax-popup="true"
                                                            data-size="xs" data-title="Questions And Answers"
                                                            data-url="{{ route('more_question', [$slug, $product->id]) }} "
                                                            data-toggle="tooltip" title="{{ __('Questions And Answers') }}">
                                                            {{ __('Load More') }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if ($product->product_attribute != '')
                                        <div id="3" class="tab-content ">
                                            <div class="queary-div">
                                                <div class="container">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h4>{{ __('Additional Information about that Product..') }}</h4>
                                                    </div><br>

                                                    @foreach (json_decode($product->product_attribute) as $key => $choice_option)
                                                        @php
                                                            $value = implode(',', $choice_option->values);
                                                            $idsArray = explode('|', $value);
                                                            $get_datas = \App\Models\ProductAttributeOption::whereIn('id', $idsArray)
                                                                ->get()
                                                                ->pluck('terms')
                                                                ->toArray();

                                                            $attribute_id = $choice_option->attribute_id;
                                                            $visible_attribute = isset($choice_option->{'visible_attribute_' . $attribute_id}) ? $choice_option->{'visible_attribute_' . $attribute_id} : 0;
                                                        @endphp
                                                        @if ($visible_attribute == 1)
                                                            <div class="row row-gap">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="pro-descrip-contente-left">
                                                                        <div class="section-title">
                                                                            <h6>{{ \App\Models\ProductAttribute::find($choice_option->attribute_id)->name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="pro-descrip-contente-right">
                                                                        <div class="">
                                                                            @foreach ($get_datas as $f)
                                                                                <div class="badge">
                                                                                    {{ $f }}
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- description sec end  -->
                 </div>
                 <div class="main-parent-bottom">

                    <img src="{{asset('themes/'.APP_THEME().'/assets/images/right.png')}}" class="d-right" style="top: -15%;">

                    <!-- testimonials slider start  -->
                    @if($random_review->isNotEmpty())
                        <section class="testimonials-sec position-relative padding-top padding-bottom">
                        <div class="container">
                            <div class="common-heading">
                                <span class="sub-heading"> {{__(' Fruit & Vegetables')}}</span>
                                <h2>{{__('Testimonials')}}</h2>
                            </div>
                            <div class="row align-items-end">
                                <div class=" col-lg-9 col-12">
                                <div class="testi-slider-container">
                                    <div class="testi-slider">
                                        @foreach ($random_review as $review)
                                            <div class="testi-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="29" viewBox="0 0 32 29"
                                                fill="none">
                                                <path
                                                    d="M32 0V3.76895H31.0526C29.0175 3.76895 27.3333 4.15283 26 4.92058C24.7368 5.61853 23.7895 6.90975 23.1579 8.79422C22.5965 10.6089 22.3158 13.1215 22.3158 16.3321V22.4043L20.9474 20.1011C21.2982 19.8219 21.7895 19.5776 22.4211 19.3682C23.0526 19.1588 23.7544 19.0541 24.5263 19.0541C26 19.0541 27.193 19.5078 28.1053 20.4152C29.0175 21.3225 29.4737 22.5439 29.4737 24.0794C29.4737 25.5451 29.0526 26.7316 28.2105 27.639C27.3684 28.5463 26.1404 29 24.5263 29C23.3333 29 22.2807 28.7208 21.3684 28.1625C20.4561 27.6041 19.7193 26.6619 19.1579 25.3357C18.5965 23.9398 18.3158 22.0554 18.3158 19.6823V17.6931C18.3158 12.8773 18.807 9.213 19.7895 6.70036C20.8421 4.11793 22.3158 2.37305 24.2105 1.4657C26.1754 0.488568 28.4561 0 31.0526 0H32ZM13.6842 0V3.76895H12.7368C10.7018 3.76895 9.01754 4.15283 7.68421 4.92058C6.42105 5.61853 5.47368 6.90975 4.84211 8.79422C4.2807 10.6089 4 13.1215 4 16.3321V22.4043L2.63158 20.1011C2.98246 19.8219 3.47368 19.5776 4.10526 19.3682C4.73684 19.1588 5.4386 19.0541 6.21053 19.0541C7.68421 19.0541 8.87719 19.5078 9.78947 20.4152C10.7018 21.3225 11.1579 22.5439 11.1579 24.0794C11.1579 25.5451 10.7368 26.7316 9.89474 27.639C9.05263 28.5463 7.82456 29 6.21053 29C5.01754 29 3.96491 28.7208 3.05263 28.1625C2.14035 27.6041 1.40351 26.6619 0.842105 25.3357C0.280702 23.9398 0 22.0554 0 19.6823V17.6931C0 12.8773 0.491228 9.213 1.47368 6.70036C2.52632 4.11793 4 2.37305 5.89474 1.4657C7.85965 0.488568 10.1404 0 12.7368 0H13.6842Z"
                                                    fill="#B5C547" />
                                                </svg>
                                                <p class="description"> {{$review->description}}</p>
                                                <div class=" d-flex align-items-center">
                                                <div class="client-name">
                                                    <a href="#">{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</a>
                                                    <span>Client</span>
                                                </div>
                                                <div class="rating d-flex align-items-center">
                                                    <div class="review-stars">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                                        @endfor
                                                    </div>
                                                    <div class="rating-number">{{ $review->rating_no }}.0 / 5.0</div>
                                                </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                </div>
                                <div class=" col-lg-3 col-12">
                                <div class="right-slide-slider">
                                    {{-- @php
                                        $pdata = App\Models\Review::ReviewProductData($review->product_id);
                                    @endphp --}}
                                    @foreach ($random_review as $review)
                                    @php
                                            $p_id = hashidsencode($review->ProductData->id);
                                        @endphp
                                        <div class="main-card">
                                            <div class="card-inner">
                                                <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                                    <img src="{{asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' )}}">
                                                </a>
                                                <div class="inner-card">
                                                <div class="wishlist-wrapper">
                                                    @auth
                                                        <a href="javascript:void(0)" class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist" tabindex="0"  product_id="{{$review->ProductData->id}}" in_wishlist="{{$review->ProductData->in_whishlist ? 'remove' : 'add'}}">{{__('Add to wishlist')}}
                                                            <span class="wish-ic">
                                                                <i class="{{ $review->ProductData->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                            </span>
                                                        </a>
                                                    @endauth
                                                </div>
                                                <div class="card-heading">
                                                    <h3>
                                                        <a href="{{route('page.product-list',$slug)}}" class="heading-wrapper product-title1">
                                                            {{$review->ProductData->name}}
                                                        </a>
                                                    </h3>
                                                    {{-- <p>Height: 78cm</p> --}}
                                                </div>
                                                @if ($review->ProductData->variant_product == 0)
                                                    <div class="price">
                                                        <span> {{ $currency }}</span>
                                                        <ins>{{ $review->ProductData->final_price }}</ins>
                                                    </div>
                                                @else
                                                    <div class="price">
                                                        <ins>{{ __('In Variant') }}</ins>
                                                    </div>
                                                @endif
                                                <div class="custom-output">
                                                    @php
                                                        date_default_timezone_set('Asia/Kolkata');
                                                        $currentDateTime = \Carbon\Carbon::now();
                                                        $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                            ->where('store_id', getCurrentStore())
                                                            ->where('is_active', 1)
                                                            ->get();
                                                        $latestSales = [];

                                                        foreach ($sale_product as $flashsale) {
                                                            $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                            $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                            $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                            if ($endDate < $startDate) {
                                                                $endDate->addDay();
                                                            }
                                                            $currentDateTime->setTimezone($startDate->getTimezone());

                                                            if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                                if (is_array($saleEnableArray) && in_array($review->ProductData->id, $saleEnableArray)) {
                                                                    $latestSales[$review->ProductData->id] = [
                                                                        'discount_type' => $flashsale->discount_type,
                                                                        'discount_amount' => $flashsale->discount_amount,
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($latestSales as $productId => $saleData)
                                                        <div class="badge">
                                                            @if ($saleData['discount_type'] == 'flat')
                                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                                -{{ $saleData['discount_amount'] }}%
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly common-btn" product_id="{{ $review->ProductData->id }}" variant_id="0" qty="1">
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
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                </div>
                                </div>
                            </div>
                        </div>
                        </section>
                    @endif
                    <!-- testimonials slider end  -->
                    <!-- filter gallary start -->
                    <section class="filter-sec position-relative padding-top padding-bottom">
                        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/right.png') }}" class="d-right" style="top: -15%;">
                       <div class=" container">
                          <div class="title d-flex justify-content-between align-items-center flex-wrap">
                             <div class="common-heading">
                                <h2> {{__('Create a tropical interior')}} <b>{{__('in your home.')}}</b> </h2>
                             </div>
                             <ul class="category-buttons d-flex tabs">
                                @foreach ($MainCategory as $cat_key =>  $category)
                                    <li class="tab-link  {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}_data">
                                        <a href="javascript:;">{{$category}}</a>
                                    </li>
                                @endforeach
                             </ul>
                          </div>
                          <div class="filter-content">
                            @foreach ($MainCategory as $cat_k => $category)
                                <div class="tab-content {{$cat_k == 0 ? 'active' : ''}}" id="{{ $cat_k }}_data">
                                    <div class="shop-protab-slider flex-slider f_blog">
                                        @foreach ($homeproducts as $homeproduct)
                                            @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                                            @php
                                                $p_id = hashidsencode($homeproduct->id);
                                            @endphp
                                            <div class="main-card card">
                                                <div class="pro-card-inner">
                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                                        <img src="{{ get_file($homeproduct->cover_image_path ,APP_THEME()) }}" class="plant-img img-fluid" alt="plant1">
                                                    </a>
                                                    <div class="inner-card">
                                                        <div class="wishlist-wrapper">
                                                            @auth
                                                                <a href="javascript:void(0)" class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist" tabindex="0"  product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">{{__('Add to wishlist')}}
                                                                    <span class="wish-ic">
                                                                        <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                    </span>
                                                                </a>
                                                            @endauth
                                                        </div>
                                                        <div class="card-heading">
                                                            <h3>
                                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="heading-wrapper product-title1">
                                                                {{$homeproduct->name}}
                                                            </a>
                                                            </h3>
                                                            <p>{{ $homeproduct->ProductData()->name }}</p>
                                                        </div>
                                                        @if ($homeproduct->variant_product == 0)
                                                            <div class="price">
                                                                <span> {{ $currency }}</span>
                                                                <ins>{{ $homeproduct->final_price }}</ins>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins>{{ __('In Variant') }}</ins>
                                                            </div>
                                                        @endif
                                                        <div class="custom-output">
                                                            @php
                                                                date_default_timezone_set('Asia/Kolkata');
                                                                $currentDateTime = \Carbon\Carbon::now();
                                                                $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
                                                                    ->where('store_id', getCurrentStore())
                                                                    ->where('is_active', 1)
                                                                    ->get();
                                                                $latestSales = [];

                                                                foreach ($sale_product as $flashsale) {
                                                                    $saleEnableArray = json_decode($flashsale->sale_product, true);
                                                                    $startDate = \Carbon\Carbon::parse($flashsale->start_date . ' ' . $flashsale->start_time);
                                                                    $endDate = \Carbon\Carbon::parse($flashsale->end_date . ' ' . $flashsale->end_time);

                                                                    if ($endDate < $startDate) {
                                                                        $endDate->addDay();
                                                                    }
                                                                    $currentDateTime->setTimezone($startDate->getTimezone());

                                                                    if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                                                                        if (is_array($saleEnableArray) && in_array($homeproduct->id, $saleEnableArray)) {
                                                                            $latestSales[$homeproduct->id] = [
                                                                                'discount_type' => $flashsale->discount_type,
                                                                                'discount_amount' => $flashsale->discount_amount,
                                                                            ];
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            @foreach ($latestSales as $productId => $saleData)
                                                                <div class="badge">
                                                                    @if ($saleData['discount_type'] == 'flat')
                                                                        -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                                    @elseif ($saleData['discount_type'] == 'percentage')
                                                                        -{{ $saleData['discount_amount'] }}%
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <a href="JavaScript:void(0)" class="common-btn addtocart-btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="0" qty="1">
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
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                          </div>
                       </div>
                    </section>
                    <!-- filter gallary end -->
                    @php
                        $homepage_newsletter = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                        $section_enable = 'on';
                        if($homepage_newsletter != '')
                        {
                            $home_newsletter = $theme_json[$homepage_newsletter];
                            $section_enable = $home_newsletter['section_enable'];
                            foreach ($home_newsletter['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-newsletter-label') {
                                    $home_newsletter_label= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-title-text') {
                                    $home_newsletter_text= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                    $home_newsletter_sub_text= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-description') {
                                    $home_newsletter_description= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-bg-img') {
                                    $home_newsletter_image= $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    <!-- subcscribe banner start  -->
                    <section class=" subscribe-sec padding-bottom">
                        <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/d7.png ') }}" class="d-right"
                        style="top: 28%;">
                        <div class="container">
                            <div class="bg-sec">
                                <img src="{{ get_file($home_newsletter_image, APP_THEME()) }}" class="banner-img"
                                    alt="plant1">
                                <div class="contnent">
                                    <div class="common-heading">
                                        <span class="sub-heading">{!! $home_newsletter_label !!}</span>
                                        <h2>{!! $home_newsletter_text !!}</h2>
                                        <p>{!! $home_newsletter_sub_text !!}</p>
                                    </div>
                                    <form action="{{ route('newsletter.store',$slug) }}" class="form-subscribe-form"
                                        method="post">
                                        @csrf
                                        <div class="input-box">
                                            <input type="email" placeholder="Type your address email..." name="email">
                                            <button>
                                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/icons/right-arrow.svg') }}"
                                                    alt="right-arrow">
                                            </button>
                                        </div>
                                        <div class="form-check">
                                                <p>{!! $home_newsletter_description !!}
                                                </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- subcscribe banner end  -->
                 </div>
            </div>

            <!---wrapper end here-->
        @endforeach
    @endsection
    @push('page-script')
    <script src="{{ asset('public/js/flipdown.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var variants = [];
            $(".product_variatin_option").each(function(index, element) {
                variants.push(element.value);
            });
            if (variants.length > 0) {
                $('.product_orignal_price').hide();
                $('.product_final_price').hide();
                $('.min_max_price').show();
                $(".enable_option").hide();
                $('.currency-type').hide();
            }
            if (variants.length == 0) {
                $('.product_orignal_price').show();
                $('.product_final_price').show();
                $('.min_max_price').hide();
            }
        });
        $(document).on('change', '.product_variatin_option', function(e) {
            product_price();
        });

        $(document).on('click', '.change_price', function(e){
            product_price();
        });

        function product_price() {
            var data = $('.variant_form').serialize();
            var data = data + '&product_id={{ $product->id }}';

            $.ajax({
                url: '{{ route('product.price', $slug) }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                context: this,

                success: function(response) {
                    $('.addcart-btn.addcart-btn-globaly').attr('variant_id', '0');
                    if (response.status == 'error') {
                        show_toastr('Error', response.message, 'error');
                        $('.quantity').val(response.qty);
                        $('.product_var_option').attr('variant_id', response.variant_id);
                    } else {
                        $('.product_final_price').html(response.original_price);
                        $('.currency').html(response.currency);
                        $('.currency-type').html(response.currency_name);
                        $('.product_orignal_price').html(response.product_original_price);
                        $('.product_tax_price').html(response.total_tax_price + ' ' + response.currency_name);
                        $('.addcart-btn.addcart-btn-globaly').attr('variant_id', response.variant_id);
                        $('.addcart-btn.addcart-btn-globaly').attr('qty', response.qty);
                        $(".enable_option").hide();
                        $('.product-variant-description').html(response.description);
                        if (response.enable_option_data == true) {
                            if (response.stock <= 0) {
                                $('.stock').parent().hide(); // Hide the parent container of the .stock element
                            } else {
                                $('.stock').html(response.stock);
                                $('.enable_option').show();
                            }
                        }
                        if (response.stock_status != '') {
                            if (response.stock_status == 'out_of_stock') {
                                $('.price-value').hide();
                                $('.variant_form').hide();
                                $('.price-wise-btn').hide();
                                $('.stock_status').show();
                                var message = '<span class=" mb-0"> Out of Stock.</span>';
                                $('.stock_status').html(message);

                            } else if (response.stock_status == 'on_backorder') {
                                $('.stock_status').show();
                                var message = '<span class=" mb-0">Available on backorder.</span>';
                                $('.stock_status').html(message);

                            } else {
                                $('.stock_status').hide();
                            }
                        }
                        if (response.variant_product == 1 && response.variant_id == 0) {
                            $('.product_orignal_price').hide();
                            $('.product_final_price').hide();
                            $('.min_max_price').show();
                            $('.product-price-amount').hide();
                            $('.product-price-error').show();
                            var message =
                                '<span class=" mb-0 text-danger"> This product is not available.</span>';
                            $('.product-price-error').html(message);
                        } else {
                            $('.product-price-error').hide();
                            $('.product_orignal_price').show();
                            $('.currency-type').show();
                            $('.product_final_price').show();
                            $('.product-price-amount').show();
                        }
                        if (response.product_original_price == 0 && response.original_price == 0) {
                            $('.product-price-amount').hide();
                            $('.variant_form').hide();
                            $('.price-wise-btn').hide();
                        }
                    }
                }
            });
        }
    </script>

    <script>
        $(".Question").on("click", function() {
            var url = $(this).data('url');
            if (!{{ \Auth::check() ? 'true' : 'false' }}) {
            var loginUrl = "{{ route('login', $slug) }}";
            var message = "Please login to continue"; // Your desired message
            window.location.href = loginUrl;
            return;
            }
        });

        $(document).ready(function() {

            $('.flipdown').hide();
            var start_date = $('.flash_sale_start_date').val();
            var end_date = $('.flash_sale_end_date').val();
            var start_time = $('.flash_sale_start_time').val();
            var end_time = $('.flash_sale_end_time').val();

            var startDates = new Date(start_date + ' ' + start_time);
            var startTimestamps = startDates.getTime();

            var endDates = new Date(end_date + ' ' + end_time);
            var endTimestamps = endDates.getTime();

            var timeRemaining = startDates - new Date().getTime();
            var endTimestamp = endTimestamps / 1000;

            setTimeout(function() {
                $('.flipdown').show();
                var flipdown = new FlipDown(endTimestamp, {
                        theme: 'dark'
                    }).start()
                    .ifEnded(() => {
                        $('.flipdown').hide();
                    });
            }, timeRemaining);
            $('.flipdown').hide();
            var ver = document.getElementById('ver');
        });

    </script>


    @endpush
