@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);

    $homepage_json_Data = App\Models\AppSetting::where('theme_id', APP_THEME())->where('page_name', 'home_page_web')->first();
    if(!empty($homepage_json_Data)) {
        $homepage_json = json_decode($homepage_json_Data->theme_json, true);
    }

    $theme_json = $homepage_json;
    $homepage_banner_text = '';

    $homepage_header_1_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
    if($homepage_header_1_key != '' ) {
        $homepage_header_1 = $theme_json[$homepage_header_1_key];
        foreach ($homepage_header_1['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-header-banner-title') {
                $homepage_banner_text = $value['field_default_text'];
            }
        }
    }
@endphp


<div class="home-slider-wrapper d-flex">
    <div class="home-slider-left-col desk-only">
        <div class="vertical-title">
            <h2>
                {!! $homepage_banner_text !!}
            </h2>
        </div>
        <div class="home-left-slider">
            @foreach ($landing_products as $landing_product)
            @php
                $p_ids = hashidsencode($landing_product->id);
            @endphp
                <div class="left-slider-item product-card">
                    <div class="product-card-inner">
                        <div class="product-card-image">
                            <a href="{{route('page.product',[$slug,$p_ids])}}">
                                <img src="{{ get_file($landing_product->cover_image_path , APP_THEME()) }}" class="default-img">

                                @if($landing_product->Sub_image($landing_product->id)['status'] == true)
                                    <img src="{{ get_file($landing_product->Sub_image($landing_product->id)['data'][0]->image_path , APP_THEME()) }}" class="hover-img">
                                @else
                                    <img src="{{ get_file($landing_product->Sub_image($landing_product->id) , APP_THEME()) }}" class="hover-img">

                                @endif
                            </a>
                        </div>
                        <div class="product-content" >
                            <div class="product-content-top">
                                <h3 class="product-title">
                                    <a href="{{route('page.product',[$slug,$p_ids])}}">
                                        {{$landing_product->name}}
                                    </a>
                                </h3>
                                <div class="product-type">{{$landing_product->ProductData()->name}} / {{$landing_product->SubCategoryctData->name}}</div>
                            </div>
                            <div class="product-content-bottom d-flex align-items-center justify-content-between">
                                <div class="price">
                                    <ins>{{ $landing_product->final_price }}<span class="currency-type">{{$currency}}</span></ins>
                                    <del>{{ $landing_product->original_price }}</del>
                                </div>
                                <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly" product_id="{{ $landing_product->id }}" variant_id="{{ $landing_product->default_variant_id }}" qty="1">
                                    <span> {{ __('Add to cart') }}</span>
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

    <div class="home-slider-right-col">
        <div class="home-right-slider">
            @foreach ($landing_products as $landing_product)
            <div class="home-right-item">
                <div class="home-right-item-inner">
                    <div class="banner-image">
                        <img src="{{ get_file($landing_product->cover_image_path , APP_THEME()) }}" alt="banner">
                    </div>
                    <div class="home-banner-content">
                        <div class="home-banner-content-inner">
                            <div class="decorative-img">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="47"
                                    viewBox="0 0 40 47" fill="none">
                                    <path
                                        d="M7.11864 23.0508C8.33902 26.3488 10.9393 28.9491 14.2373 30.1694C10.9393 31.3898 8.33902 33.9901 7.11864 37.2881C5.89827 33.9901 3.298 31.3898 0 30.1694C3.298 28.9491 5.89827 26.3488 7.11864 23.0508Z"
                                        fill="white" />
                                    <path
                                        d="M26.7799 0C29.0463 6.12486 33.8754 10.9539 40.0002 13.2203C33.8754 15.4867 29.0463 20.3158 26.7799 26.4407C24.5135 20.3158 19.6844 15.4867 13.5596 13.2203C19.6844 10.9539 24.5135 6.12486 26.7799 0Z"
                                        fill="white" />
                                    <path
                                        d="M16.4936 38.9831C19.5686 37.6217 22.0279 35.1624 23.3894 32.0874C24.7508 35.1624 27.2101 37.6217 30.2852 38.9831C27.2101 40.3446 24.7508 42.8039 23.3894 45.8789C22.0279 42.8039 19.5686 40.3446 16.4936 38.9831Z"
                                        stroke="white" stroke-width="0.677966" />
                                </svg>
                            </div>
                            <h2 class="h1">
                                <a href="#" tabindex="0">
                                    {{$landing_product->name}}
                                </a>
                            </h2>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary white-btn">
                                {{ __('Go to Shop') }}
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
</div>
