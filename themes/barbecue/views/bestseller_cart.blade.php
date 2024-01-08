@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp
@php
$homepage_best_product = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
if($homepage_best_product != '')
{
    $homepage_best = $theme_json[$homepage_best_product];
    foreach ($homepage_best['inner-list'] as $key => $value) {
        if($value['field_slug'] == 'homepage-products-title-text') {
            $home_best_title_text= $value['field_default_text'];
        }
        if($value['field_slug'] == 'homepage-products-btn-text') {
            $home_best_btn_text= $value['field_default_text'];
        }
    }
}
@endphp

<div class="container">
    <div class="section-title d-flex justify-content-between align-items-center ">
        <h3>{!! $home_best_title_text !!}</h3>
        <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary show-more-btn">
            {!! $home_best_btn_text !!}
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z" fill="white"></path>
            </svg>
        </a>
    </div>
        <div class="pro-card-slider-main">
            <div class="pro-card-slider">
                @foreach($homeproducts as $data)
                @php
                    $p_id = hashidsencode($data->id);
                @endphp
                    <div class="product-card">
                        <div class="product-card-inner">
                            <div class="card-top">
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
                                                if (is_array($saleEnableArray) && in_array($data->id, $saleEnableArray)) {
                                                    $latestSales[$data->id] = [
                                                        'discount_type' => $flashsale->discount_type,
                                                        'discount_amount' => $flashsale->discount_amount,
                                                    ];
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($latestSales as $productId => $saleData)
                                        <span>
                                            @if ($saleData['discount_type'] == 'flat')
                                                -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                            @elseif ($saleData['discount_type'] == 'percentage')
                                                -{{ $saleData['discount_amount'] }}%
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                                    <div class="like-items-icon">
                                        <a class="add-wishlist wishbtn wishbtn-globaly" href="javascript:void(0)" title="Wishlist" tabindex="0"  product_id="{{$data->id}}" in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add'}}">
                                            <div class="wish-ic">
                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                            </div>
                                        </a>
                                    </div>
                            </div>
                            <div class="product-card-image">
                                <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                    <img src="{{ get_file($data->cover_image_path , APP_THEME()) }}" class="default-img">
                                </a>
                            </div>
                            <div class="card-bottom">
                                <div class="product-title">
                                    <span class="sub-title">{{ $data->ProductData()->name }}</span>
                                    <h3>
                                        <a class="product-title1" href="{{ route('page.product', [$slug,$p_id]) }}">
                                            {{ $data->name }}
                                        </a>
                                    </h3>
                                </div>
                                @if ($data->variant_product == 0)
                                    <div class="price">
                                        <ins>{{$data->final_price}}<span class="currency-type">{{ $currency }}</span></ins>
                                    </div>
                                @else
                                    <div class="price">
                                        <ins>{{ __('In Variant') }}</ins>
                                    </div>
                                @endif
                                <a href="JavaScript:void(0)" class="btn addtocart-btn addcart-btn-globaly" product_id="{{ $data->id }}" variant_id="0" qty="1" >
                                    {{__('Add to cart')}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
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
