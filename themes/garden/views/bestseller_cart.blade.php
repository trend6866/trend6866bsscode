 @php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp
@php
    $homepage_products = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
    $section_enable = 'on';
    if($homepage_products != '')
    {
        $home_products = $theme_json[$homepage_products];
        $section_enable = $home_products['section_enable'];
        foreach ($home_products['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-products-title-text') {
                $home_products1= $value['field_default_text'];
            }
        }
    }
@endphp
@if($home_products['section_enable'] == 'on')
    <div class=" container">
        <div class="title d-flex justify-content-between align-items-center flex-wrap">
            <div class="common-heading">
                <h2> {!! $home_products1 !!} </b> </h2>
            </div>
            <ul class="category-buttons d-flex tabs">
                @foreach ($MainCategory as $cat_key =>  $category)
                    <li class="tab-link  {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}"><a href="javascript:;">{{$category}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="filter-content">
            @foreach ($MainCategory as $cat_k => $category)
                <div class="tab-content {{$cat_k == 0 ? 'active' : ''}}" id="{{ $cat_k }}">
                    <div class="shop-protab-slider flex-slider f_blog">
                        @foreach ($homeproducts as $homeproduct)
                            @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                            @php
                                $p_id = hashidsencode($homeproduct->id);
                            @endphp
                            <div class="main-card card">
                                <div class="pro-card-inner">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                        <img src="{{get_file($homeproduct->cover_image_path , APP_THEME())}}" class="plant-img img-fluid" alt="plant1">
                                    </a>
                                    <div class="inner-card">
                                        <div class="wishlist-wrapper">
                                                <a href="JavaScript:void(0)" class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist" tabindex="0"  product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">{{__('Add to wishlist')}}
                                                    <span class="wish-ic">
                                                        <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                    </span>
                                                </a>
                                        </div>
                                        <div class="card-heading">
                                            <h3>
                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="heading-wrapper product-title1">
                                                {{$homeproduct->name}}
                                            </a>
                                            </h3>
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
                                            <p>{{ $homeproduct->ProductData()->name }}</p>
                                        </div>
                                        @if ($homeproduct->variant_product == 0)
                                            <div class="price">
                                                <span> {{$currency}}</span>
                                                <ins>{{ $homeproduct->final_price }}</ins>
                                            </div>
                                        @else
                                            <div class="price">
                                                <ins>{{ __('In Variant') }}</ins>
                                            </div>
                                        @endif
                                        <a href="JavaScript:void(0)" class="common-btn addtocart-btn addcart-btn-globaly" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
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
@endif
