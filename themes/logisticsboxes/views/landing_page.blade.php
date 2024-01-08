@extends('layouts.layouts')
@section('page-title')
    {{ __('logisticsboxes') }}
@endsection
@php
    $theme_json = $homepage_json;
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $wishlist = \App\Models\Wishlist::where('id', 'product_id')->get();
    $product_review = \App\Models\Review::where('id', 'product_id')->get();
@endphp
@section('content')
    <!--wrapper start here-->
    <section class="main-home-first-section">
            @php
                $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text = $contact_us_header_description = $contact_us_header_img ='';
                $homepage_header_1_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-banner-offer-label') {
                            $contact_us_header_worktime = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-offer-text') {
                            $contact_us_header_calling = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-title-text') {
                            $contact_us_header_call = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-sub-text') {
                            $contact_us_header_contact = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-search-label-text') {
                            $contact_us_header_label_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-description') {
                            $contact_us_header_description = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-banner-bg-img') {
                            $contact_us_header_img = $value['field_default_text'];
                        }
                    }
                }
            @endphp
        @if ($homepage_header_1['section_enable'] == 'on')
        <div class="banner-image">
           <img src="{{get_file($contact_us_header_img , APP_THEME())}}" alt="">
        </div>
        <div class="container">
            <div class="home-banner-content">
                <div class="home-banner-content-inner">

                    <div class="offer-announcement">
                        <span class="new-labl">{!! $contact_us_header_worktime!!}</span>
                        <p>{!! $contact_us_header_calling!!}  <a href="#">More</a></p>
                    </div>
                    <h2 class="h1">
                         {!! $contact_us_header_call!!}
                    </h2>
                    <p>{!! $contact_us_header_contact!!}
                    </p>
                    <div class="search-package">
                       <form>
                         <label>{!! $contact_us_header_label_text!!}</label>
                           <div class="form-inputs">
                               <input type="search"  placeholder="Shipping number"  class="form-control">
                               <button type="submit" class="btn">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
                                     <path fill-rule="evenodd" clip-rule="evenodd" d="M9.47487 11.0098C8.48031 11.7822 7.23058 12.2422 5.87332 12.2422C2.62957 12.2422 0 9.61492 0 6.37402C0 3.13313 2.62957 0.505859 5.87332 0.505859C9.11706 0.505859 11.7466 3.13313 11.7466 6.37402C11.7466 7.73009 11.2863 8.97872 10.5131 9.97241L12.785 12.2421C13.0717 12.5285 13.0717 12.993 12.785 13.2794C12.4983 13.5659 12.0334 13.5659 11.7467 13.2794L9.47487 11.0098ZM10.2783 6.37402C10.2783 8.8047 8.30612 10.7751 5.87332 10.7751C3.44051 10.7751 1.46833 8.8047 1.46833 6.37402C1.46833 3.94335 3.44051 1.9729 5.87332 1.9729C8.30612 1.9729 10.2783 3.94335 10.2783 6.37402Z" fill="white"/>
                                     </svg>
                                {{__('Find Package')}}
                             </button>
                           </div>
                           <p>{!! $contact_us_header_description !!} </p>

                       </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
     </section>
     <section class="our-client-section">
        @php
            $homepage_logo = '';
            $homepage_logo_key = array_search('homepage-logo', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_logo_key != '') {
                $homepage_main_logo = $theme_json[$homepage_logo_key];
            }
        @endphp
         <div class="container">
             <div class="client-logo-wrap">
                 <div class="client-logo-slider common-arrows">
                    @if (!empty($homepage_main_logo['homepage-logo-logo']))
                    @for ($i = 0; $i < count($homepage_main_logo['homepage-logo-logo']); $i++)
                        @php
                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                }
                                if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                    if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                        $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];

                                    }
                                }
                            }
                        @endphp

                        <div class="client-logo-item">
                            <a href="#">
                                <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">
                            </a>
                        </div>
                    @endfor
                    @else
                            @for ($i = 0; $i <= 7; $i++)
                            @php
                                foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                    if ($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo') {
                                        $homepage_logo = $homepage_main_logo_value['field_default_text'];

                                    }
                                }
                            @endphp
                            <div class="client-logo-item">
                                <a href="#">
                                    <img src="{{ get_file($homepage_logo, APP_THEME()) }}" alt="logo">

                                </a>
                            </div>
                        @endfor
                    @endif
                 </div>
             </div>
         </div>
     </section>
    <section class="store-detail-section padding-top padding-bottom">
         <div class="container">
            @php
                $homepage_promotions_icon = $homepage_promotions_txt = $homepage_promotions_title ='';

                $homepage_promotions_key = array_search('homepage-store-detail', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_promotions_key != '') {
                    $homepage_promotions_section = $theme_json[$homepage_promotions_key];
                }
            @endphp

             <div class="row">
                @for ($i = 0; $i < $homepage_promotions_section['loop_number']; $i++)
                @php
                    foreach ($homepage_promotions_section['inner-list'] as $homepage_promotions_section_value) {
                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-title-text') {
                            $homepage_promotions_title = $homepage_promotions_section_value['field_default_text'];
                        }

                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-title-text') {
                                $homepage_promotions_title = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                            }
                        }

                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-sub-text') {
                            $homepage_promotions_txt = $homepage_promotions_section_value['field_default_text'];
                        }

                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-sub-text') {
                                $homepage_promotions_txt = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i];
                            }
                        }
                        if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-icon') {
                            $homepage_promotions_icon = $homepage_promotions_section_value['field_default_text'];
                        }
                        if (!empty($homepage_promotions_section[$homepage_promotions_section_value['field_slug']])) {
                            if ($homepage_promotions_section_value['field_slug'] == 'homepage-store-detail-icon') {
                                $homepage_promotions_icon = $homepage_promotions_section[$homepage_promotions_section_value['field_slug']][$i]['field_prev_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_promotions_section['section_enable'] == 'on')
                 <div class="col-12 col-lg-4 col-md-4 col-12">
                     <div class="store-detail-inner">
                         @if($i == 0)
                         <div class="top-air-arrow" >
                             <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/dir-arrow.png') }}" alt="">
                         </div>
                         @elseif ($i == 1)
                         <div class="bottom-air-arrow" >
                             <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/dir-arrow-bottom.png') }}" alt="">
                         </div>
                         @else
                         @endif
                         <div class="icon-wrap">
                             <img src="{{ get_file($homepage_promotions_icon, APP_THEME()) }}" alt ="">
                         </div>
                         <div class="section-title">
                             <h3>
                                 {!! $homepage_promotions_title!!}
                             </h3>
                         </div>
                         <p>{!!$homepage_promotions_txt!!} </p>
                     </div>
                 </div>
                @endif
                @endfor
             </div>
            </div>
     </section>
     <section class="best-product-section padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 col-12">
                    <div class="best-product-left-inner">
                        @php
                        $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text = $contact_us_header_description = $contact_us_header_img ='';
                        $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-products-title-text') {
                                    $contact_us_header_worktime = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-products-sub-text') {
                                    $contact_us_header_calling = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-products-btn-text') {
                                    $contact_us_header_call = $value['field_default_text'];
                                }

                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <div class="section-title">
                            <h2>{!! $contact_us_header_worktime!!}</h2>
                        </div>
                        <p>{!! $contact_us_header_calling!!}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"/>
                                </svg>{!! $contact_us_header_call!!}</a>
                    @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 col-12">
                    <div class="best-product-slider product-row">
                        @foreach ($bestSeller as $data)
                            @php
                                $bestSeller_ids = hashidsencode($data->id);
                            @endphp
                            <div class="product-card">
                                <div class="product-card-inner">
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
                                    <div class="product-img">
                                        <a href="{{route('page.product',[$slug,$bestSeller_ids])}}">
                                            <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-content-top">
                                            <div class="top-subtitle d-flex align-items-center justify-content-between">
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                <path d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z" fill="#5EA5DF"/>
                                                <path d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z" fill="#5EA5DF"/>
                                                <path d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z" fill="#5EA5DF"/>
                                                <path d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z" fill="#5EA5DF"/>
                                                </svg> {{ $data->default_variant_name }}</p>
                                            </div>
                                            <h5><a href="{{route('page.product',[$slug,$bestSeller_ids])}}"><b>{{$data->name}}</b></a></h5>
                                                <P class ="description">{{$data->description}}</P>

                                        </div>
                                        {{-- <div class="cart-variable">
                                            <div class="swatch-lbl">
                                                <strong>Available:</strong>
                                            </div>
                                            <select class="theme-arrow">
                                                <option>Paper Material (15pcs available)</option>
                                                <option>Paper Material (14pcs available)</option>
                                                <option>Paper Material (13pcs available)</option>
                                            </select>
                                        </div> --}}
                                        <div class="product-content-bottom">
                                            @if ($data->variant_product == 0)
                                                <div class="price">
                                                    <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                </div>
                                            @else
                                                <div class="price">
                                                    <ins>{{ __('In Variant') }}</ins>
                                                </div>
                                            @endif
                                            <div class="d-flex align-items-center justify-content-between">
                                                <a href="javascript:void(0)" class="btn cart-btn  addtocart-btn-cart addcart-btn-globaly" product_id="{{ $data->id }}" variant_id="0" qty="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                                    <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                                                    </svg>{{__('ADD TO CART')}}</a>

                                                        <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly " product_id="{{ $data->id }}" in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add'}}" >
                                                            <span class="">
                                                                <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style ='color:aliceblue;' ></i>
                                                            </span>
                                                        </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slides-numbers">
                        <span class="active">01</span> / <span class="total"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="travel-info-section">
        @php
                $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text  = $contact_us_header_img ='';
                $homepage_header_1_key = array_search('homepage-info', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-info-offer-label') {
                            $contact_us_header_worktime = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-info-offer-text') {
                            $contact_us_header_calling = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-info-title-text') {
                            $contact_us_header_call = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-info-sub-text') {
                            $contact_us_header_contact = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-info-btn-text') {
                            $contact_us_header_label_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-info-img') {
                            $contact_us_header_description = $value['field_default_text'];
                        }

                    }
                }
            @endphp
        @if ($homepage_header_1['section_enable'] == 'on')
         <div class="container">
             <div class="row">
                 <div class="col-md-6 col-lg-6 col-xl-5 col-12">
                     <div class="travel-image-left">
                         <img src="{{get_file($contact_us_header_description , APP_THEME())}}" alt="">
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-6 col-xl-4 col-12">
                     <div class="travel-info-right">
                         <div class="offer-announcement second-style">
                             <span class="new-labl">{!! $contact_us_header_worktime!!}</span>
                             <p><b>{!! $contact_us_header_calling !!}  <a href="#">More</a></b></p>
                         </div>
                         <div class="section-title">
                             <h2>{!! $contact_us_header_call!!}</h2>
                         </div>
                         <p>{!! $contact_us_header_contact!!}</p>
                             <a href="{{route('page.product-list',$slug)}}" class="btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                 <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                                 </svg>{!! $contact_us_header_label_text!!}</a>
                     </div>
                 </div>
             </div>
         </div>
        @endif
    </section>
    <section class="padding-top padding-bottom product-categories-section">
         <div class="container">
             <div class="tabs-wrapper">
                 <div class="section-title d-flex align-items-center justify-content-between">
                    @php
                    $contact_us_header_worktime = '';
                    $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-feature-products-title-text') {
                                $contact_us_header_worktime = $value['field_default_text'];
                            }

                        }
                    }
                @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <div class="section-title-left">
                                <h2>{!! $contact_us_header_worktime!!}</h2>
                            </div>
                        @endif
                     <div class="tab-nav">

                         <ul class="tabs d-flex">
                             @foreach ($MainCategory->take(3) as $cat_key => $category)
                             <li class="tab-link-btn {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}"><a href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                 <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                                 </svg> {{ $category }}</a></li>

                                 @endforeach
                         </ul>
                     </div>
                 </div>
                 @foreach ($MainCategory as $cat_k => $category)
                    <div class="tabs-container">
                        <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="shop-protab-slider product-row white-arrow">
                                @foreach ($all_products as $data)
                                    @if ($cat_k == '0' || $data->ProductData()->id == $cat_k)
                                        @php
                                            $data_ids = hashidsencode($data->id);
                                        @endphp
                                    <div class="product-card">
                                        <div class="product-card-inner">
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
                                            <div class="product-img">
                                                <a href="{{route('page.product',[$slug,$data_ids])}}">
                                                    <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-content-top">
                                                    <div class="top-subtitle d-flex align-items-center justify-content-between">
                                                        <div class="subtitle">{{$data->tag_api}}</div>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                        <path d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z" fill="#5EA5DF"/>
                                                        <path d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z" fill="#5EA5DF"/>
                                                        <path d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z" fill="#5EA5DF"/>
                                                        <path d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z" fill="#5EA5DF"/>
                                                        </svg>{{ $data->default_variant_name }}</p>
                                                    </div>
                                                    <h5><a href="{{route('page.product',[$slug,$data_ids])}}"><b>{{$data->name}}</b> </a></h5>
                                                    <P class ="description">{{$data->description}}</P>
                                                </div>
                                                {{-- <div class="cart-variable">
                                                    <div class="swatch-lbl">
                                                        <strong>Available:</strong>
                                                    </div>
                                                    <select class="theme-arrow">
                                                        <option>Paper Material (15pcs available)</option>
                                                        <option>Paper Material (14pcs available)</option>
                                                        <option>Paper Material (13pcs available)</option>
                                                    </select>
                                                </div> --}}
                                                <div class="product-content-bottom">
                                                    @if ($data->variant_product == 0)
                                                        <div class="price">
                                                            <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                                        </div>
                                                    @else
                                                        <div class="price">
                                                            <ins>{{ __('In Variant') }}</ins>
                                                        </div>
                                                    @endif
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a href="javascript:void(0)" class="btn cart-btn  addtocart-btn-cart addcart-btn-globaly" product_id="{{ $data->id }}" variant_id="0" qty="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                                            <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                                                            </svg>{{__('ADD TO CART')}}</a>
                                                                <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly" product_id="{{ $data->id }}" in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add'}}">
                                                                    <span class="">
                                                                        <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style ='color:black;' ></i>
                                                                    </span>
                                                                </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                 @endforeach
             </div>

         </div>
     </section>
    <section class="newsletter-section">
         <div class="container">
             <div class="row align-items-center">
                 <div class="col-md-6 col-12">
                     <div class="newsletter-left-inner">
                            @php
                                $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text  = $contact_us_header_img ='';
                                $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                            $contact_us_header_worktime = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                            $contact_us_header_calling = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-newsletter-description') {
                                            $contact_us_header_call = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-newsletter-img') {
                                            $contact_us_header_contact = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                         <div class="section-title">
                             <h2>{!! $contact_us_header_worktime!!}</h2>
                         </div>
                         <p>{!! $contact_us_header_calling!!} </p>
                        <div class="subscribe-form">
                            <form action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                             <div class="input-wrapper">
                                 <input type="email" placeholder="Type your address email..." name="email">
                                 <button class="btn-subscibe">{{__('Subscribe')}}</button>
                             </div>
                             <br>
                                 <label for="FotterCheckbox">{!! $contact_us_header_call!!}</label>
                            </form>
                        </div>
                     </div>
                 </div>
                 <div class="col-md-6 col-12">
                     <div class="newsletter-image-left">
                         <img src="{{get_file($contact_us_header_contact , APP_THEME())}} " alt="">
                     </div>
                 </div>
                 @endif
             </div>
         </div>
     </section>
    <section class="padding-top new-product-section">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-xl-6 col-lg-7 col-md-6 col-12">
                  <div class="new-product-slider product-row">
                    @foreach ($modern_products as $product)
                    @php
                        $p_id = hashidsencode($product->id);
                    @endphp
                     <div class="product-card">

                         <div class="product-card-inner">
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
                                    <div class="badge">
                                        @if ($saleData['discount_type'] == 'flat')
                                            -{{ $saleData['discount_amount'] }}{{ $currency_icon }}
                                        @elseif ($saleData['discount_type'] == 'percentage')
                                            -{{ $saleData['discount_amount'] }}%
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="product-img">
                                <a href="{{ route('page.product', [$slug,$p_id]) }}">
                                    <img src="{{ get_file($product->cover_image_path, APP_THEME()) }}" alt="">
                                </a>
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <div class="top-subtitle d-flex align-items-center justify-content-between">
                                        <div class="subtitle">{{$product->tag_api}}</div>
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path d="M11.5592 0H1.41305C1.03866 0.0012215 0.679958 0.15049 0.415224 0.415224C0.15049 0.679958 0.0012215 1.03866 0 1.41305V11.5824C0.0012215 11.9568 0.15049 12.3155 0.415224 12.5802C0.679958 12.8449 1.03866 12.9942 1.41305 12.9954H11.5592C11.9296 12.9882 12.2824 12.8362 12.5421 12.5722C12.8019 12.3081 12.948 11.9528 12.9491 11.5824V1.43622C12.9541 1.06179 12.8107 0.70061 12.5503 0.431525C12.2899 0.162441 11.9336 0.00730934 11.5592 0ZM5.07308 0.92659H7.85285V4.63295H5.07308V0.92659ZM12.0225 11.5824C12.0225 11.7052 11.9737 11.8231 11.8868 11.91C11.7999 11.9969 11.6821 12.0457 11.5592 12.0457H1.41305C1.34843 12.0522 1.28317 12.045 1.22149 12.0246C1.15982 12.0043 1.10312 11.9712 1.05507 11.9275C1.00701 11.8838 0.968677 11.8305 0.942553 11.7711C0.916428 11.7116 0.903098 11.6473 0.903424 11.5824V1.43622C0.900096 1.37146 0.910404 1.30671 0.933674 1.24619C0.956943 1.18566 0.992658 1.13069 1.03851 1.08484C1.08436 1.03898 1.13933 1.00327 1.19985 0.979999C1.26038 0.956729 1.32512 0.946428 1.38989 0.949756H4.14649V4.77657C4.14649 4.99037 4.23142 5.19541 4.3826 5.34659C4.53378 5.49777 4.73882 5.58271 4.95262 5.58271H7.9733C8.1871 5.58271 8.39215 5.49777 8.54333 5.34659C8.69451 5.19541 8.77944 4.99037 8.77944 4.77657V0.92659H11.5592C11.624 0.923262 11.6887 0.93357 11.7492 0.95684C11.8098 0.980109 11.8647 1.01582 11.9106 1.06168C11.9564 1.10753 11.9922 1.16249 12.0154 1.22302C12.0387 1.28355 12.049 1.34829 12.0457 1.41305L12.0225 11.5824Z" fill="#5EA5DF"/>
                                        <path d="M10.6313 8.33984H8.31486C8.19198 8.33984 8.07414 8.38865 7.98726 8.47554C7.90037 8.56242 7.85156 8.68027 7.85156 8.80314C7.85156 8.92601 7.90037 9.04385 7.98726 9.13074C8.07414 9.21762 8.19198 9.26643 8.31486 9.26643H10.6313C10.7542 9.26643 10.872 9.21762 10.9589 9.13074C11.0458 9.04385 11.0946 8.92601 11.0946 8.80314C11.0946 8.68027 11.0458 8.56242 10.9589 8.47554C10.872 8.38865 10.7542 8.33984 10.6313 8.33984Z" fill="#5EA5DF"/>
                                        <path d="M10.6306 10.1914H6.92423C6.80136 10.1914 6.68352 10.2402 6.59663 10.3271C6.50975 10.414 6.46094 10.5318 6.46094 10.6547C6.46094 10.7776 6.50975 10.8954 6.59663 10.9823C6.68352 11.0692 6.80136 11.118 6.92423 11.118H10.6306C10.7535 11.118 10.8713 11.0692 10.9582 10.9823C11.0451 10.8954 11.0939 10.7776 11.0939 10.6547C11.0939 10.5318 11.0451 10.414 10.9582 10.3271C10.8713 10.2402 10.7535 10.1914 10.6306 10.1914Z" fill="#5EA5DF"/>
                                        <path d="M3.54964 8.01095C3.50558 7.96877 3.45362 7.93571 3.39675 7.91366C3.28396 7.86732 3.15744 7.86732 3.04464 7.91366C2.98777 7.93571 2.93581 7.96877 2.89175 8.01095L1.96516 8.93754C1.92174 8.98061 1.88728 9.03185 1.86375 9.0883C1.84023 9.14476 1.82812 9.20532 1.82812 9.26648C1.82812 9.32764 1.84023 9.3882 1.86375 9.44466C1.88728 9.50111 1.92174 9.55235 1.96516 9.59542C2.00823 9.63885 2.05947 9.67331 2.11593 9.69683C2.17239 9.72035 2.23295 9.73246 2.29411 9.73246C2.35527 9.73246 2.41582 9.72035 2.47228 9.69683C2.52874 9.67331 2.57998 9.63885 2.62305 9.59542L2.7574 9.45643V10.6564C2.7574 10.7792 2.80621 10.8971 2.8931 10.984C2.97998 11.0708 3.09782 11.1197 3.2207 11.1197C3.34357 11.1197 3.46141 11.0708 3.5483 10.984C3.63518 10.8971 3.68399 10.7792 3.68399 10.6564V9.45643L3.81834 9.59542C3.86163 9.63836 3.91298 9.67233 3.96942 9.69538C4.02587 9.71844 4.08631 9.73013 4.14729 9.72978C4.20826 9.73013 4.2687 9.71844 4.32515 9.69538C4.3816 9.67233 4.43294 9.63836 4.47623 9.59542C4.51965 9.55235 4.55412 9.50111 4.57764 9.44466C4.60116 9.3882 4.61327 9.32764 4.61327 9.26648C4.61327 9.20532 4.60116 9.14476 4.57764 9.0883C4.55412 9.03185 4.51965 8.98061 4.47623 8.93754L3.54964 8.01095Z" fill="#5EA5DF"/>
                                        </svg>{{ $product->default_variant_name }}</p>
                                    </div>
                                    <h5><a href="{{ route('page.product', [$slug,$p_id]) }}l"><b> {{ $product->name }}</b> </a></h5>
                                    <P class ="description">{{$product->description}}</P>

                                </div>
                                {{-- <div class="cart-variable">
                                    <div class="swatch-lbl">
                                        <strong>Available:</strong>
                                    </div>
                                    <select class="theme-arrow">
                                        <option>Paper Material (15pcs available)</option>
                                        <option>Paper Material (14pcs available)</option>
                                        <option>Paper Material (13pcs available)</option>
                                    </select>
                                </div> --}}
                                <div class="product-content-bottom">
                                    @if ($product->variant_product == 0)
                                        <div class="price">
                                            <ins>{{$product->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                    @else
                                        <div class="price">
                                            <ins>{{ __('In Variant') }}</ins>
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0)" class="btn cart-btn  addtocart-btn-cart addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                                            <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                                            </svg>{{__('ADD TO CART')}}</a>

                                                <a href="javascript:void(0)" class="wish-btn  wishbtn-globaly" product_id="{{ $product->id }}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                                    <span class="">
                                                        <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}" style ='color:aliceblue;' ></i>
                                                    </span>
                                                </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                  </div>
              </div>
              <div class="col-xl-6 col-lg-5 col-md-6 col-12">
                 <div class="newproduct-right">
                     <div class="offer-announcement second-style">
                        @php
                        $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = $contact_us_header_label_text  = $contact_us_header_img ='';
                        $homepage_header_1_key = array_search('homepage-new-products', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-new-products-offer-label') {
                                    $contact_us_header_worktime = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-new-products-offer-text') {
                                    $contact_us_header_calling = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-new-products-title-text') {
                                    $contact_us_header_call = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-new-products-sub-text') {
                                    $contact_us_header_contact = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-new-products-btn-text') {
                                    $contact_us_header_label_text = $value['field_default_text'];
                                }


                            }
                        }
                    @endphp
                   @if ($homepage_header_1['section_enable'] == 'on')
                         <span class="new-labl">{!! $contact_us_header_worktime!!}</span>
                         <p><b>{!! $contact_us_header_calling!!}  <a href="#">More</a></b></p>
                     </div>
                     <div class="section-title">
                         <h2>{!! $contact_us_header_call!!}</h2>
                     </div>
                     <p>{!! $contact_us_header_contact!!}</p>
                         <a href="{{route('page.product-list',$slug)}}" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                             <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                             </svg>{!! $contact_us_header_label_text!!}</a>
                    @endif
                 </div>
              </div>
          </div>
      </div>
     </section>
      <section class="padding-top testimonial-section padding-bottom">
         <div class="review-slider">
             @foreach ($reviews as $review )
             @php
                 $r_id = hashidsencode($review->id);
             @endphp
             <div class="testimonials-card">
                <div class="reviews-stars-wrap d-flex align-items-center justify-content-center">
                    <div class="reviews-stars-outer">
                        @for ($i = 0; $i < 5; $i++)
                            <i
                                class="fa fa-star review-stars {{ $i < $review->rating_no ? 'texts-warning' : '' }} "></i>
                        @endfor
                    </div>
                    <div class="point-wrap">
                        <span class="review-point">{{$review->rating_no}}.0/ <span>5.0</span></span>
                    </div>
                </div>
                <div class="reviews-words">
                    <h2>{{ $review->title }}</h2>
                    <p class="descriptions"> {{ $review->description }}</p>
                    <div class="review-product">
                        <div class="product-image">
                            <a href="{{route('page.product',[$slug,$r_id])}}">
                                <img src="{{ get_file(!empty($review->ProductData) ? $review->ProductData->cover_image_path : '', APP_THEME()) }}">
                            </a>
                        </div>
                        <div class="product-content-right">
                            <h5><a href="{{route('page.product',[$slug,$r_id])}}" tabindex="0"><b> {{$review->ProductData->name}}</b></a></h5>
                            <p><b>{{ !empty($review->UserData()) ? $review->UserData->first_name : '' }}</b> {{__('Client')}}</p>
                        </div>
                    </div>
                </div>
            </div>
             @endforeach
         </div>
     </section>
      <section class="home-blog-section">
         <div class="container">
             <div class="section-title d-flex align-items-center justify-content-between">
                @php
                $contact_us_header_worktime = $contact_us_header_calling ='';
                $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-title-text') {
                            $contact_us_header_worktime = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-btn-text') {
                            $contact_us_header_calling = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if ($homepage_header_1['section_enable'] == 'on')
                 <h2>{!! $contact_us_header_worktime!!}</h2>
                 <a href="{{route('page.blog',$slug)}}" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
                     <path d="M15.9364 2.84781L14.6014 0.344242C14.5459 0.241023 14.4611 0.154221 14.3562 0.0934596C14.2514 0.0326985 14.1306 0.000350315 14.0073 0H1.99235C1.86909 0.000350315 1.74834 0.0326985 1.64348 0.0934596C1.53862 0.154221 1.45375 0.241023 1.39828 0.344242L0.0632809 2.84781C0.0216041 2.93104 0 3.02186 0 3.11381C0 3.20576 0.0216041 3.29658 0.0632809 3.37981C0.103334 3.46476 0.163045 3.54028 0.23809 3.60091C0.313135 3.66153 0.401627 3.70573 0.497151 3.73031L1.34488 3.96189V7.6609C1.34877 7.93557 1.44889 8.20141 1.62983 8.41745C1.81077 8.63348 2.06247 8.78771 2.34613 8.85636L7.19217 9.99548C7.24538 10.0015 7.29917 10.0015 7.35237 9.99548H7.48587L13.6335 8.84384C13.9268 8.78184 14.1892 8.62883 14.3782 8.4096C14.5672 8.19037 14.6717 7.91774 14.6748 7.63587V3.88052L15.4892 3.71153C15.5877 3.69014 15.6798 3.64804 15.7584 3.58841C15.837 3.52878 15.9002 3.45316 15.9431 3.36729C15.9817 3.2853 16.0011 3.19649 16 3.10687C15.9988 3.01724 15.9771 2.9289 15.9364 2.84781ZM13.5935 1.25178L14.3611 2.69133L9.68862 3.66146L8.40035 1.25178H13.5935ZM2.4062 1.25178H6.251L4.98275 3.63642L1.64525 2.73514L2.4062 1.25178ZM2.65985 4.31865L5.14962 4.98209C5.20931 4.9912 5.27017 4.9912 5.32985 4.98209C5.45312 4.98174 5.57387 4.94939 5.67873 4.88863C5.78358 4.82787 5.86846 4.74107 5.92392 4.63785L6.66485 3.25463V8.56219L2.65985 7.63587V4.31865ZM13.3398 7.62335L7.99985 8.62477V3.27967L8.74077 4.66288C8.79624 4.7661 8.88111 4.85291 8.98597 4.91367C9.09083 4.97443 9.21158 5.00678 9.33485 5.00713H9.4817L13.3398 4.19973V7.62335Z" fill="white"></path>
                     </svg>{!! $contact_us_header_calling !!}</a>
             </div>
             @endif
             <div class="blog-list-slider post-slider">
                {!! \App\Models\Blog::HomePageBlog($slug, $no = 6) !!}
             </div>
         </div>
     </section>

    <!---wrapper end here-->
    <!--footer start here-->

    <!--scripts start here-->

    <!--scripts end here-->
    </body>

    </html>
@endsection
