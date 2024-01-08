@extends('layouts.layouts')

@section('page-title')
    {{ __('Products') }}
@endsection

@php
    $theme_json = $homepage_json;
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

@section('content')
    <div class="wrapper">
        @php
            $collection_title = $collection_subtext = '';

                $collection_key = array_search('collection', array_column($theme_json, 'unique_section_slug'));
                if($collection_key != ''){
                    $collection = $theme_json[$collection_key];


                    foreach ($collection['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'collection-title'){
                            $collection_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'collection-sub-text'){
                            $collection_subtext = $value['field_default_text'];
                        }

                        //Dynamic
                        if(!empty($collection[$value['field_slug']]))
                        {
                            if($value['field_slug'] == 'collection-title'){
                                $collection_title = $collection[$value['field_slug']][$i];
                            }
                            if($value['field_slug'] == 'collection-sub-text'){
                                $collection_subtext = $collection[$value['field_slug']][$i];
                            }
                        }

                    }
                }
        @endphp
        <section class="product-list-page-section common-banner-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="common-banner-content">
                            <a href="{{ route('landing_page',$slug) }}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                        <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765"></circle>
                                        <g clip-path="url(#clip0_318_284)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="white"></path>
                                        </g>
                                    </svg>
                                </span>
                               {{__(' Back to category')}}
                            </a>
                            <div class="section-title">
                                <h2>{{$collection_title }}  <span>({{$product_count}})</span></h2>
                            </div>
                            <p>{{$collection_subtext}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section class="common-banner-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="common-banner-content">
                            <a href="{{route('landing_page')}}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                            fill="white"></path>
                                    </svg>
                                </span>
                                {{ __('Back to category') }}
                            </a>
                            <div class="section-title">
                                <h2>{{$collection_title}} <span>({{$product_count}})</span></h2>
                            </div>
                            <p>{{$collection_subtext}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="product-listing-section padding-bottom">
            <div class="container">
                <div class="product-heading-row row no-gutters">
                    <div class="product-heading-column col-lg-3 col-md-4 col-1">
                        <div class="filter-title">
                            <h4 class="desk-only">{{ __('Filters') }}</h4>
                            <div class="mobile-only">
                                <svg class="icon icon-filter" aria-hidden="true" focusable="false" role="presentation"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                                    <path fill-rule="evenodd"
                                        d="M4.833 6.5a1.667 1.667 0 1 1 3.334 0 1.667 1.667 0 0 1-3.334 0ZM4.05 7H2.5a.5.5 0 0 1 0-1h1.55a2.5 2.5 0 0 1 4.9 0h8.55a.5.5 0 0 1 0 1H8.95a2.5 2.5 0 0 1-4.9 0Zm11.117 6.5a1.667 1.667 0 1 0-3.334 0 1.667 1.667 0 0 0 3.334 0ZM13.5 11a2.5 2.5 0 0 1 2.45 2h1.55a.5.5 0 0 1 0 1h-1.55a2.5 2.5 0 0 1-4.9 0H2.5a.5.5 0 0 1 0-1h8.55a2.5 2.5 0 0 1 2.45-2Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="product-heading-right-column col-lg-9 col-md-8 col-11">
                        <div class="product-sorting-row d-flex align-items-center justify-content-between">
                            <ul class="produdt-filter-cat d-flex align-items-center">

                            </ul>
                            <div class="filter-select-box d-flex align-items-center justify-content-end">
                                <span class="sort-lbl">{{ __('Sort by:') }}</span>
                                <select class="filter_product">
                                    {{-- <option value="manual" {{ empty($filter_product) ? 'selected="selected"' : '' }}>
                                        {{ __('Featured') }}
                                    </option>
                                    <option value="best-selling" {{ !empty($filter_product) && $filter_product == 'best-selling' ? 'selected="selected"' : '' }}>
                                        {{ __('Best selling') }}
                                    </option> --}}

                                    <option value="manual" selected="selected">{{ __('Featured') }}</option>
                                    <option value="best-selling" >{{ __('Best selling') }}</option>
                                    <option value="title-ascending">{{ __('Alphabetically, A-Z') }}</option>
                                    <option value="title-descending">{{ __('Alphabetically, Z-A') }}</option>
                                    <option value="price-ascending">{{ __('Price, low to high') }}</option>
                                    <option value="price-descending">{{ __('Price, high to low') }}</option>
                                    <option value="created-ascending">{{ __('Date, old to new') }}</option>
                                    <option value="created-descending">{{ __('Date, new to old') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-list-row row no-gutters">
                    <div class="product-filter-column col-lg-3 col-md-4 col-12">
                        <div class="product-filter-body">
                            <div class="mobile-only close-filter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                                    fill="none">
                                    <path
                                        d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                                        fill="white"></path>
                                </svg>
                            </div>
                            <div class="product-widget product-tag-widget">
                                <div class="pro-itm has-children {{count($sub_category_select) > 0 ? 'is-open' : ''}}">
                                    <a href="javascript:;" class="acnav-label">
                                        {{ __('tags') }}
                                    </a>
                                    <div class="pro-itm-inner acnav-list"  style="{{count($sub_category_select) > 0 ? 'display: block;  ' : ''}}">
                                        <div class="d-flex flex-wrap text-checkbox">
                                            @foreach ($filter_tag as $sub_category)
                                                <div class="checkbox">
                                                    <input id="{{ $sub_category->id }}" class="product_tag" name="radio" type="checkbox" value="{{ $sub_category->id }}" {{ in_array($sub_category->id, $sub_category_select) ? 'checked' : ''}}>
                                                    <label for="{{ $sub_category->id }}" class="checkbox-label">{{ $sub_category->name }}</label>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="product-widget product-price-widget">
                                <div class="pro-itm has-children">
                                    <a href="javascript:;" class="acnav-label">
                                        {{ __('price') }}
                                    </a>
                                    @php $price_step = $max_price/5; @endphp

                                    <div class="pro-itm-inner acnav-list">
                                        <div class="price-select d-flex">
                                            @php $price_step = $max_price/5; @endphp
                                            <div class="select-col">
                                                <p>
                                                    {{ __('min price') }} : <span class="min_price_select" price="0">{{ $currency_icon }} {{ 0 }}</span>
                                                </p>
                                            </div>
                                            <div class="select-col">
                                                <p>{{ __('max price') }} : <span class="max_price_select" price="{{ $max_price }}">{{ $currency_icon }} {{ $max_price }}</span> </p>
                                            </div>
                                        </div>
                                        <div id="range-slider">
                                            <div id="slider-range" class="slider-range" min_price="{{ $min_price }}" max_price="{{ $max_price }}" price_step="1" currency="{{ $currency_icon }}" ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-widget product-colors-widget">
                                <div class="pro-itm has-children">
                                    <a href="javascript:;" class="acnav-label">
                                        {{ __('Rating') }}
                                    </a>
                                    <div class="pro-itm-inner acnav-list">
                                        <div class="radio-group">
                                            <input type="radio" id="star5" name="rating" class="rating" value="5">
                                            <label for="star5">
                                                <span>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" id="star4" name="rating" class="rating" value="4">
                                            <label for="star4">
                                                <span>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="ti ti-star"></i>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" id="star3" name="rating" class="rating" value="3">
                                            <label for="star3">
                                                <span>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class=" ti ti-star"></i>
                                                    <i class=" ti ti-star"></i>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" id="star2" name="rating" class="rating" value="2">
                                            <label for="star2">
                                                <span>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class=" ti ti-star"></i>
                                                    <i class=" ti ti-star"></i>
                                                    <i class=" ti ti-star"></i>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" id="star1" name="rating" class="rating" value="1">
                                            <label for="star1">
                                                <span>
                                                    <i class="text-warning ti ti-star"></i>
                                                    <i class="ti ti-star"></i>
                                                    <i class="ti ti-star"></i>
                                                    <i class="ti ti-star"></i>
                                                    <i class="ti ti-star"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="product-widget product-filter-widget text-center">
                                <button class="btn checkout-btn" id="product_filter_btn">
                                    {{ __('Filter') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M9.99991 11.2133C9.077 11.2145 8.18225 10.8948 7.46802 10.3089C6.75378 9.72305 6.26423 8.90709 6.08273 8.00001C6.06826 7.90447 6.07469 7.80691 6.10157 7.7141C6.12845 7.62129 6.17514 7.53544 6.2384 7.46252C6.30166 7.38959 6.37998 7.33132 6.46794 7.29175C6.55589 7.25218 6.65138 7.23225 6.74778 7.23335C6.90622 7.23104 7.06027 7.28551 7.1822 7.38696C7.30413 7.4884 7.38592 7.63015 7.41284 7.78668C7.53809 8.38596 7.86526 8.92378 8.33939 9.3098C8.81351 9.69582 9.40572 9.90653 10.0165 9.90653C10.6273 9.90653 11.2196 9.69582 11.6937 9.3098C12.1678 8.92378 12.495 8.38596 12.6202 7.78668C12.6472 7.63015 12.7289 7.4884 12.8509 7.38696C12.9728 7.28551 13.1268 7.23104 13.2853 7.23335C13.3817 7.23225 13.4772 7.25218 13.5651 7.29175C13.6531 7.33132 13.7314 7.38959 13.7947 7.46252C13.8579 7.53544 13.9046 7.62129 13.9315 7.7141C13.9584 7.80691 13.9648 7.90447 13.9503 8.00001C13.7678 8.91273 13.2733 9.73303 12.5522 10.3196C11.8311 10.9061 10.9285 11.2222 9.99991 11.2133Z" fill="#2C2C2C"></path>
                                        <path d="M15.9189 20H4.08092C3.8103 20.0003 3.54244 19.9455 3.29363 19.8388C3.04483 19.7321 2.82028 19.5758 2.63364 19.3793C2.44701 19.1829 2.30219 18.9504 2.208 18.6961C2.11381 18.4418 2.07222 18.1709 2.08575 17.9L2.62444 6.40663C2.64674 5.89136 2.86675 5.40464 3.23852 5.04811C3.6103 4.69158 4.10511 4.4928 4.61961 4.49329H15.3802C15.8947 4.4928 16.3895 4.69158 16.7613 5.04811C17.1331 5.40464 17.3531 5.89136 17.3754 6.40663L17.9141 17.9C17.9276 18.1709 17.886 18.4418 17.7918 18.6961C17.6976 18.9504 17.5528 19.1829 17.3662 19.3793C17.1796 19.5758 16.955 19.7321 16.7062 19.8388C16.4574 19.9455 16.1895 20.0003 15.9189 20ZM4.61961 5.83329C4.44323 5.83329 4.27407 5.90353 4.14935 6.02855C4.02462 6.15358 3.95456 6.32315 3.95456 6.49996L3.41586 17.9667C3.41135 18.057 3.42522 18.1473 3.45661 18.232C3.48801 18.3168 3.53628 18.3943 3.59849 18.4598C3.6607 18.5252 3.73555 18.5774 3.81849 18.6129C3.90142 18.6485 3.99071 18.6668 4.08092 18.6667H15.9189C16.0091 18.6668 16.0984 18.6485 16.1813 18.6129C16.2643 18.5774 16.3391 18.5252 16.4013 18.4598C16.4636 18.3943 16.5118 18.3168 16.5432 18.232C16.5746 18.1473 16.5885 18.057 16.584 17.9667L16.0453 6.47329C16.0453 6.29648 15.9752 6.12691 15.8505 6.00189C15.7258 5.87686 15.5566 5.80662 15.3802 5.80662L4.61961 5.83329Z" fill="#2C2C2C"></path>
                                        <path d="M13.9902 5.16668H12.6601V4.00001C12.6601 3.29276 12.3798 2.61449 11.8809 2.11439C11.382 1.61429 10.7054 1.33334 9.99986 1.33334C9.29432 1.33334 8.61768 1.61429 8.11879 2.11439C7.61991 2.61449 7.33963 3.29276 7.33963 4.00001V5.16668H6.00952V4.00001C6.00952 2.93914 6.42993 1.92172 7.17826 1.17158C7.9266 0.421428 8.94155 0 9.99986 0C11.0582 0 12.0731 0.421428 12.8215 1.17158C13.5698 1.92172 13.9902 2.93914 13.9902 4.00001V5.16668Z" fill="#2C2C2C"></path>
                                    </svg>
                                </button>
                                <div class="btn checkout-btn product_delete_filter_btn" onclick="window.location='{{ route("page.product-list",$slug) }}'">
                                    {{ __('Delete all') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.43285 1.01177C6.59919 0.845434 6.86887 0.845434 7.03521 1.01177C7.20154 1.1781 7.20154 1.44779 7.03521 1.61412L4.62579 4.02354L7.03521 6.43295C7.20154 6.59929 7.20154 6.86897 7.03521 7.03531C6.86887 7.20164 6.59919 7.20164 6.43285 7.03531L4.02344 4.62589L1.61402 7.03531C1.44769 7.20164 1.178 7.20164 1.01167 7.03531C0.845333 6.86897 0.845333 6.59929 1.01167 6.43295L3.42108 4.02354L1.01167 1.61412C0.845333 1.44779 0.845332 1.17811 1.01167 1.01177C1.178 0.845434 1.44769 0.845434 1.61402 1.01177L4.02344 3.42119L6.43285 1.01177Z" fill="#183A40"/>
                                    </svg>

                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="product-filter-right-column col-lg-9 col-md-8 col-12">
                        <div class="product_filter">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="online-store-section tabs-wrapper padding-bottom">
            <div class="container">
                @php
                    $homepage_store_title = '';

                    $homepage_store = array_search('online-store-section', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_store != '' ){
                        $homepage_store_value = $theme_json[$homepage_store];

                        foreach ($homepage_store_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'online-store-section-title') {
                                $homepage_store_title = $value['field_default_text'];
                            }

                            //Dynamic
                            if(!empty($homepage_store_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'online-store-section-title'){
                                    $homepage_store_title = $homepage_store_value[$value['field_slug']][$i];
                                }

                            }
                        }
                    }
                @endphp


<div class="container">
    <div class="section-title d-flex align-items-center justify-content-between">
        {!! $homepage_store_title !!}
        {!! \App\Models\Product::ProductPageBestseller($slug) !!}

</div>



                {{-- <div class="section-title d-flex align-items-center justify-content-between">

                       {!! $homepage_store_title !!}

                    <ul class="cat-tab tabs">
                        <li class="tab-link active" data-tab="tab-1"><a href="javascript:;">Documents</a></li>
                        <li class="tab-link" data-tab="tab-2"><a href="javascript:;">Artistic</a></li>
                        <li class="tab-link" data-tab="tab-3"><a href="javascript:;">Music</a></li>
                        <li class="tab-link" data-tab="tab-4"><a href="javascript:;">Litherature</a></li>
                    </ul>
                </div>
                <div class="tabs-container">
                    <div class="product-card-reverse">
                        <div class="online-store-itm product-card">
                            @foreach ($bestSeller as $best)
                                <div class="product-card-inner">
                                    <div class="product-image">
                                        <a href="product.html" tabindex="0">
                                            <img src="{{ get_file($best->cover_image_path , APP_THEME()) }}">
                                        </a>
                                        <span class="badge">{{ $best->tag_api }}</span>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-cont-top">
                                            <div class="subtitle">
                                                <a href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.36364C0 1.05824 1.09442 0 2.44444 0H7.54303C8.19134 0 8.8131 0.249025 9.27152 0.692293L10.284 1.67134C10.7425 2.11461 11 2.71581 11 3.34269V10.6364C11 11.9418 9.90558 13 8.55556 13H2.44444C1.09441 13 0 11.9418 0 10.6364V2.36364ZM9.77778 4.13636V10.6364C9.77778 11.2891 9.23057 11.8182 8.55556 11.8182H2.44444C1.76943 11.8182 1.22222 11.2891 1.22222 10.6364V2.36364C1.22222 1.71094 1.76943 1.18182 2.44444 1.18182H6.72222V2.36364C6.72222 3.34269 7.54303 4.13636 8.55556 4.13636H9.77778ZM9.70998 2.95455C9.64997 2.78767 9.55145 2.63432 9.4198 2.50702L8.40728 1.52796C8.27562 1.40066 8.11702 1.3054 7.94444 1.24737V2.36364C7.94444 2.68999 8.21805 2.95455 8.55556 2.95455H9.70998Z" fill="#E8BA96"/>
                                                        <path d="M3.625 7C3.27982 7 3 7.22386 3 7.5C3 7.77614 3.27982 8 3.625 8H7.375C7.72018 8 8 7.77614 8 7.5C8 7.22386 7.72018 7 7.375 7H3.625Z" fill="#E8BA96"/>
                                                        <path d="M3.625 9C3.27982 9 3 9.22386 3 9.5C3 9.77614 3.27982 10 3.625 10H5.5C5.84518 10 6.125 9.77614 6.125 9.5C6.125 9.22386 5.84518 9 5.5 9H3.625Z" fill="#E8BA96"/>
                                                    </svg>
                                                    Get Sample
                                                </a>
                                            </div>
                                            <div class="prouct-card-heading">
                                                <h5>
                                                    <a href="product.html" tabindex="0">{{ $best->name }}</a>
                                                </h5>
                                                <div class="play-time">
                                                    @auth
                                                        <a href="javascript:void(0)" class="wishbtn wishlist-btn wishbtn-globaly"  product_id="{{$best->id}}" in_wishlist="{{ $best->in_whishlist ? 'remove' : 'add'}}">
                                                            <span class="wish-ic">
                                                                <i class="{{ $best->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                                                <input type="hidden" class="wishlist_type" name="wishlist_type" id="wishlist_type" value="{{ $best->in_whishlist ? 'remove' : 'add'}}">
                                                            </span>
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                            <p>{{ $best->ProductData()->name }}</p>
                                        </div>
                                        <div class="product-cont-bottom">

                                            <div class="price-btn">
                                                <div class="price">
                                                    <span class="currency-type">{{ $currency_icon }}</span>
                                                    <ins> {{ $best->final_price }} </ins>
                                                </div>
                                                <button class="btn checkout-btn" type="submit" tabindex="0">
                                                    <svg width="20" height="20" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                        </path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                        </path>
                                                    </svg>
                                                    {{ __('Add to cart') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection


@push('page-script')
    <script>
        $(document).ready(function() {
            product_page_filter(1);
        });

        $(document).on('click', '#product_filter_btn', function() {
            var page = $('.page-item.active .page-link').text();
            product_page_filter(page);
        });

        $(document).on('click', '.page-item .page-link', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_page_filter(page);
        });

        $(".filter_product").change(function (){
            var page = $('.page-item.active .page-link').text();
            product_page_filter(page);
        });

        function product_page_filter(page) {
            var product_tag = [];
            $('.product_tag').each(function() {
                if ($(this).prop("checked") == true) {
                    product_tag.push($(this).val());
                }
            });

            var min_price = $('.min_price_select').attr('price');
            var max_price = $('.max_price_select').attr('price');
            var rating = $('input[name="rating"]:checked').val();
            var filter_product = $('.filter_product').val();

            var data = {
                product_tag       : product_tag,
                min_price         : min_price,
                max_price         : max_price,
                rating            : rating,
                filter_product    : filter_product,
            }

            $.ajax({
                url:  '{{ route('product.page.filter',$slug) }}?page='+ page,
                context: this,
                data: data,
                success: function(responce) {
                    $('.product_filter').html(responce);
                }
            });
        }
    </script>
@endpush
