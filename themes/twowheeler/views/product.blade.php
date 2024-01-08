@extends('layouts.layouts')

@php
    $p_name = json_decode($products);
@endphp

@section('page-title')
    {{ __($p_name[0]->name) }}
@endsection

@section('content')
@foreach ($products as $product)
    <div class="wrapper product-wrapper">
        <section class="pro-main-section">
            <div class="container">
                <div class="top-title d-flex justify-content-between align-items-center">
                    <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                        <span class="svg-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                    fill="white"></path>
                            </svg>
                        </span>
                        {{ __('Back to category')}}
                    </a>

                    @auth
                        <a href="javascript:void(0)" class="wishlist wbwish wishbtn-globaly" product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                            <span class="wish-ic">
                                <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                    style='color: #fff'></i>
                            </span>
                            {{ __('Add to wishlist')}}
                        </a>
                    @endauth

                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <div class="left-side">
                            <h2 class="h1">
                                {{$product->name}}
                            </h2>
                            <p class="product-variant-description">{!!$product->description!!}</p>
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
                            @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                            @else
                                <div class="size-selectors dark-doted d-flex align-items-center">
                                    <form class="variant_form w-100">
                                        <div class="radio-buttons">
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
                                                        <div class="product-labl  mb-0 inline_lable">{{$attribute->name}}</div>
                                                        <div class="inline_contant">
                                                            <select class="custom-select-btn product_variatin_option variant_loop radio-btn" name="varint[{{ $attribute->name }}]">
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
                                        </div>
                                        <div class="product-labl  mb-0 inline_lable">{{'Quantity'}}</div>
                                        <div class="inline_contant">
                                            <div class="qty-spinners " >
                                                <button type="button" class="quantity-decrement change_price ">
                                                    <svg width="12"  height="2" viewBox="0 0 12 2"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" class="btn_cust"></path>
                                                    </svg>
                                                </button>
                                                <input type="text" class="quantity qty_cust" data-cke-saved-name="quantity"
                                                name="qty" value="01" min="01" max="100">
                                                <button type="button" class="quantity-increment change_price ">
                                                    <svg width="12" height="12" viewBox="0 0 12 12"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                            class="btn_cust"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                @else
                                    <a href="javascript:void(0)" class="btn addcart-btn addcart-btn-globaly price-wise-btn product_var_option" type="submit" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                        {{ __('Add to cart')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                            viewBox="0 0 22 17" fill="none">
                                            <path
                                                d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                fill="#FF0A0A"></path>
                                        </svg>
                                    </a>
                                @endif
                                <div class="price product-price-amount price-value">
                                    <ins class="product_final_price">{{$product->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                </div>
                            </div>
                        </div>
                        {{-- @if ($product->product_option != NULL)
                            <ul class="bike-details">
                                @foreach($value['inner-list'] as $description_val)
                                    <li class="active">
                                        <span>{{$description_val['field_name']}}&nbsp;&nbsp;&nbsp;</span>
                                        {{$description_val['value']}}&nbsp;&nbsp;&nbsp;
                                    </li>
                                @endforeach
                            </ul>
                        @endif --}}
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="product-main-div">
                            <div class="slider-wrapper">
                                <div class="product-main-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="product-main-item">
                                        <div class="product-item-img">
                                            <img src="{{ get_file($item->image_path, APP_THEME()) }}">
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
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="product-thumb-slider">
                                    @foreach ($product->Sub_image($product->id)['data'] as $item)
                                    <div class="product-thumb-item">
                                        <div class="thumb-img">
                                            <img src="{{ get_file($item->image_path, APP_THEME()) }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- tab section  --}}
<section class="tab-vid-section padding-top">
    <div class="container">
        <div class="tabs-wrapper">
            <div class="blog-head-row tab-nav d-flex justify-content-between">
                <div class="blog-col-left ">
                    <ul class="d-flex tabs">
                        {{-- <li class="tab-link on-tab-click active" data-tab="0"><a
                                href="javascript:;">{{ __('Description') }}</a>
                        </li> --}}
                        <li class="tab-link on-tab-click active" data-tab="2"><a
                                href="javascript:;">{{ __('Question & Answer') }}</a>
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
                    </ul>
                </div>
            </div>
            <div class="tabs-container">
                {{-- <div id="0" class="tab-content active">

                </div> --}}
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

<section class="best-pro-section pdp-bst-pro padding-bottom">
    <div class="offset-container offset-right">
        <div class="row no-gutters">
            @php
                $homepage_header_1_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-banner-title-text') {
                            $home_title_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-banner-sub-text') {
                            $home_sub_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-banner-btn-text') {
                            $home_btn_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-banner-img') {
                            $home_image = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="col-md-6 left-side">
                <div class="img-wrapper">
                    <img src="{{get_file($home_image , APP_THEME())}}" alt="bike">
                </div>
            </div>
            <div class="col-md-6 right-side">
                <div class="right-content">
                    <div class="section-title">
                        <h2>{!!$home_title_text!!} </h2>
                    </div>
                    <p>{{$home_sub_text}} </p>
                    <a href="{{route('page.product-list',$slug)}}" class="btn">
                        {{$home_btn_text}}
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

        <section class="testimonials-section pdp-testimonial  padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-testimonial', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-testimonial-title-text') {
                                $testimonial_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title">
                    <h2>
                        {{$testimonial_title}}
                    </h2>
                </div>
                @endif
                <div class="testi-main-slider">
                    @foreach($reviews as $review)
                    @php
                        $r_id = hashidsencode($review->ProductData->id);
                    @endphp
                    <div class="testi-slides">
                        <div class="testi-inner">
                            <div class="img-wrapper">
                                <a href="{{route('page.product',[$slug,$r_id])}}">
                                    <img src="{{ asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' ) }}" alt="testimonial-product">
                                </a>
                            </div>
                            <div class="ratings d-flex align-items-center">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star {{ $i < $review->rating_no ? '' : 'text-warning' }} "></i>
                                @endfor
                             </div>
                             <h3>{!! $review->title !!}</h3>
                             <p>{{$review->description}}</p>
                             {{-- <h6>WSR-690 Superbike</h6> --}}
                             <span class="user-name"><a href="#">{{!empty($review->UserData()) ? $review->UserData->first_name : '' }},</a> Client </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="logo-slider-section padding-top padding-bottom">
            <div class="container">
                <div class="logo-slider-main">
                    @php
                        $homepage_logo = '';
                        $homepage_logo_key = array_search('homepage-logo', array_column($theme_json,'unique_section_slug'));
                        if($homepage_logo_key != ''){
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                        }
                    @endphp

                    @if(!empty($homepage_main_logo['homepage-logo-logo-text']))
                        @for ($i = 0; $i <= 10; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                    if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                    {
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                            $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                }
                            @endphp
                            <div class="logo-slides">
                                <h4>{{$homepage_logo}}</h4>
                            </div>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 10; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                    }
                                }
                            @endphp
                            <div class="logo-slides">
                                <h4>{{$homepage_logo}}</h4>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        <section class="bestseller-section bestseller-section-2 tabs-wrapper">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-bestseller-title-text') {
                                $home_label_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-bestseller-btn') {
                                $home_btn = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center">
                    <h2>
                        {{$home_label_text}}
                    </h2>

                    <ul class="tabs">
                        @foreach ($MainCategory as $cat_key =>  $category)
                            <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                                <a href="javascript:;">{{$category}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="bike-slider-main">
                            @foreach($bestSeller as $bestSellers)
                            @php
                                $p_id = hashidsencode($bestSellers->id);
                            @endphp
                            @if($cat_k == '0' ||  $bestSellers->ProductData()->id == $cat_k)
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="card-top">
                                        <div class="card-top-inner">
                                            <span>{{$bestSellers->tag_api}}</span>
                                            @auth
                                                <a href="javascript:void(0)" class="add-wishlist wbwish  wishbtn-globaly" product_id="{{$bestSellers->id}}" in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add'}}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: rgb(255, 254, 254)'></i>
                                                    </span>
                                                </a>
                                            @endauth
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
                                                            if (is_array($saleEnableArray) && in_array($bestSellers->id, $saleEnableArray)) {
                                                                $latestSales[$bestSellers->id] = [
                                                                    'discount_type' => $flashsale->discount_type,
                                                                    'discount_amount' => $flashsale->discount_amount,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach ($latestSales as $productId => $saleData)
                                                    <span class="badge">
                                                        @if ($saleData['discount_type'] == 'flat')
                                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                        @elseif ($saleData['discount_type'] == 'percentage')
                                                            -{{ $saleData['discount_amount'] }}%
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="product-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                <img src="{{get_file($bestSellers->cover_image_path ,APP_THEME())}}" class="default-img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-bottom">
                                        <div class="product-title">
                                            <h4>
                                                <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                                                    {{$bestSellers->name}}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="card-bottom-content">
                                            @if ($bestSellers->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{$bestSellers->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $bestSellers->id }}" variant_id="0" qty="1">
                                                {{ __('ADD TO CART')}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                                    viewBox="0 0 22 17" fill="none">
                                                    <path
                                                    d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                    fill="#FF0A0A"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="show-more-div text-right">
                    <a href="{{route('page.product-list',$slug)}}" class="btn show-more-btn">
                        {{$home_btn}}
                    </a>
                </div>
                @endif
            </div>
        </section>

        <section class="blog-section padding-bottom padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-blog-title-text') {
                                $home_label_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-blog-btn-text') {
                                $home_btn_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-center">
                    <h2>{!! $home_label_text !!}</h2>
                    <a href="#" class="btn show-more-btn">
                        {{$home_btn_text}}
                     </a>
                </div>
                @endif

                {!! \App\Models\Blog::HomePageBlog(12) !!}
            </div>
        </section>
    </div>
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
