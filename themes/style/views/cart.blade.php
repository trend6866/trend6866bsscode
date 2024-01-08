
@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection

@section('content')
    @php
        $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    @endphp

    <section class="cart-page-section padding-bottom">
    </section>

    @php
        $homepage_best_seller_heading = $homepage_best_seller_btn = '';

        $homepage_best_seller_key = array_search('homepage-bestsellers', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_seller_key != '') {
            $homepage_best_seller = $theme_json[$homepage_best_seller_key];
            foreach ($homepage_best_seller['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-bestsellers-heading') {
                    $homepage_best_seller_heading = $value['field_default_text'];
                }
                if ($value['field_slug'] == 'homepage-bestsellers-button') {
                    $homepage_best_seller_btn = $value['field_default_text'];
                }
            }
        }
    @endphp

    <section class="our-bestseller-section padding-bottom">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between">
                {!! $homepage_best_seller_heading !!}
                <a href="{{ route('page.product-list',$slug) }}" class="btn-secondary">
                    {!! $homepage_best_seller_btn !!}
                    <svg viewBox="0 0 10 5">
                        <path
                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="bestsell-cat-slider common-arrows">
                @foreach ($bestSeller as $data)
                    <div class="best-sell-cat-item product-card">
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="product-card-inner">
                            <div class="product-card-image">
                                <a href="{{ route('page.product',[$slug, $p_id]) }}">
                                    <img src="{{ get_file($data->cover_image_path , APP_THEME()) }}" class="default-img">
                                    @if ($data->Sub_image($data->id)['status'] == true)
                                        <img src="{{ get_file($data->Sub_image($data->id)['data'][0]->image_path , APP_THEME()) }}"
                                            class="hover-img">
                                    @else
                                        <img src="{{ get_file($data->Sub_image($data->id) , APP_THEME()) }}" class="hover-img">
                                    @endif
                                </a>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <h3 class="product-title">
                                        <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                            {{ $data->name }}
                                        </a>
                                    </h3>
                                    <div class="product-type">{{ $data->ProductData()->name }} /
                                        {{ $data->SubCategoryctData->name }}</div>
                                </div>
                                <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                    @if ($data->variant_product == 0)
                                        <div class="price">
                                            <ins>{{ $data->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                                            <del>{{ $data->original_price }}</del>
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
                                            <div class="badge">
                                                @if ($saleData['discount_type'] == 'flat')
                                                    -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                                @elseif ($saleData['discount_type'] == 'percentage')
                                                    -{{ $saleData['discount_amount'] }}%
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="JavaScript:void(0)" class="btn-secondary addcart-btn-globaly"
                                        product_id="{{ $data->id }}" variant_id="0"
                                        qty="1">
                                        {{ __('Add to cart') }}
                                        <svg viewBox="0 0 10 5">
                                            <path
                                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('page-script')
    <script>
        $(document).on('click', '.addcart-btn-globaly', function() {
            setTimeout(() => {
                get_cartlist();
            }, 200);
        });

        $(document).ready(function() {
            get_cartlist();
        });
    </script>
@endpush
