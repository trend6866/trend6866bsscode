@php
        $theme_json = $homepage_json;
        if(Auth::user()){
            $carts = App\Models\Cart::where('user_id',Auth::user()->id)->where('theme_id', env('APP_THEME'))->get();
            $cart_product_count = $carts->count();
        }
        $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');

        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $profile = asset(Storage::url('uploads/logo/'));
        $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
        $theme_logo = get_file($theme_logo , APP_THEME());

    @endphp

<section class="subscription-section padding-top padding-bottom">
    @php
        $homepage_banner_image_left = $homepage_banner_image_right = '';
        $homepage_best_product_key = array_search('homepage-banner-sub', array_column($theme_json, 'unique_section_slug'));
        if ($homepage_best_product_key != '') {
            $homepage_best_product = $theme_json[$homepage_best_product_key];
            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-banner-sub-left') {
                    $homepage_banner_image_left = $value['field_default_text'];
                }
            }
            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-banner-sub-right') {
                    $homepage_banner_image_right = $value['field_default_text'];
                }
            }
        }
        $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
        $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;
    @endphp
    @if ($homepage_best_product['section_enable'] == 'on')
        <img src=" {{ get_file($homepage_banner_image_left, APP_THEME()) }}" alt="" class="sub-left">
        <img src=" {{ get_file($homepage_banner_image_right, APP_THEME()) }}" alt="" class="sub-right">
    @endif
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-12">
                <div class="subscription-left-column">
                    @php
                        $homepage_subscription_title = $homepage_subscription_heading = $homepage_subscripti_sub_text = $homepage_subscription_link_text = '';
                        $homepage_best_product_key = array_search('homepage-subscription', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_best_product_key != '') {
                            $homepage_best_product = $theme_json[$homepage_best_product_key];
                            foreach ($homepage_best_product['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-subscription-title') {
                                    $homepage_subscription_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-subscription-sub-title') {
                                    $homepage_subscription_heading = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-subscription-sub-text') {
                                    $homepage_subscripti_sub_text = $value['field_default_text'];
                                }

                            }
                        }
                    @endphp
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <div class="section-title">
                            <div class="subtitle">{!! $homepage_subscription_title !!}</div>
                            {!! $homepage_subscription_heading !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7 col-12">
                <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                    @csrf
                    <div class="input-wrapper">
                        <input type="email" placeholder="Email address.." name="email">
                        <button type="submit" class="btn-subscibe">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.97863e-08 9.99986C-7.09728e-06 10.4601 0.373083 10.8332 0.83332 10.8332L17.113 10.8335L15.1548 12.7358C14.8247 13.0565 14.817 13.584 15.1377 13.9142C15.4584 14.2443 15.986 14.2519 16.3161 13.9312L19.7474 10.5979C19.9089 10.441 20.0001 10.2254 20.0001 10.0002C20.0001 9.77496 19.9089 9.55935 19.7474 9.40244L16.3161 6.0691C15.986 5.74841 15.4584 5.75605 15.1377 6.08617C14.817 6.41628 14.8247 6.94387 15.1548 7.26456L17.1129 9.1668L0.833346 9.16654C0.373109 9.16653 7.24653e-06 9.53962 4.97863e-08 9.99986Z"
                                    fill="#183A40" />
                            </svg>
                        </button>
                    </div>
                    @if ($homepage_best_product['section_enable'] == 'on')
                        <div class="checkbox-custom">
                            {{-- <input type="checkbox" id="subscibecheck"> --}}
                            {{-- <label for="subscibecheck"> --}}
                                {!! $homepage_subscripti_sub_text !!}
                            {{-- </label> --}}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>
<footer class="site-footer">
        @php
            $homepage_footer_logo = $homepage_footer_text = $homepage_footer_sub_text = '';

            $homepage_footer_key1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
            if($homepage_footer_key1 != '') {
                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

            foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-footer-logo') {
                $homepage_footer_logo = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-footer-text') {
                $homepage_footer_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-footer-sub-text') {
                $homepage_footer_sub_text = $value['field_default_text'];
                }
            }
            }
        @endphp
    <img src="{{ asset('themes/'.APP_THEME().'/assets/images/left-wave.png')}}" class="left-gliter gliter-img">
    <div class="container">
        @if($whatsapp_setting_enabled)
        <div class="floating-wpp"></div>
        @endif
        <div class="footer-row">
            <div class="footer-col footer-subscribe-col">
                <div class="footer-widget">
                    @if($homepage_footer_section1['section_enable'] == 'on')
                        <div class="footer-logo">
                            <a href="{{route('landing_page',$slug)}}">
                                <img src="{{ get_file($homepage_footer_logo, APP_THEME()) }}" >
                            </a>
                        </div>
                        <span class="copyright">{!! $homepage_footer_text !!}</span>
                        {!! $homepage_footer_sub_text!!}
                    @endif
                    <ul class="footer-list-social" role="list">
                            @php
                                $homepage_footer_social_icon = $homepage_footer_social_link='';

                                $homepage_footer_key3 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key3 != '') {
                                    $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                }

                            @endphp
                            @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                            @php
                                    foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                    {

                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                            $homepage_footer_social_icon = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                                $homepage_footer_social_icon = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link') {
                                            $homepage_footer_social_link = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link'){
                                                $homepage_footer_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                            }
                                            // dd($homepage_footer_social_link);
                                        }
                                    }
                                @endphp
                                @if($homepage_footer_section3['section_enable'] == 'on')
                                    <li>
                                        <a href="{!! $homepage_footer_social_link !!}" >
                                            <img src=" {{ get_file($homepage_footer_social_icon, APP_THEME()) }}">
                                        </a>
                                    </li>
                                @endif
                            @endfor

                    </ul>
                </div>
            </div>
                <div class="footer-col footer-link footer-link-1">
                    @php
                        $homepage_footer_section2_title = $homepage_footer_section2_checkbox = '';

                        $homepage_footer_key2 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key2 != '') {
                            $homepage_footer_section2 = $theme_json[$homepage_footer_key2];

                        foreach ($homepage_footer_section2['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section2_title = $value['field_default_text'];
                            }

                        if($value['field_slug'] == 'homepage-footer-enable') {
                            $homepage_footer_section2_checkbox = $value['field_default_text'];
                            }
                        }
                        }
                    @endphp

                    <div class="footer-widget">
                        @if($homepage_footer_section2_checkbox == 'on')
                        {!! $homepage_footer_section2_title!!}

                        @php
                            $homepage_footer_section3_sub_title = $homepage_footer_section3_link= '' ;

                            $homepage_footer_key3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_key3 != '') {
                                $homepage_footer_section3 = $theme_json[$homepage_footer_key3];

                            }

                        @endphp
                        <ul>
                            @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                            @php
                                foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                {

                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-sub-title') {
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                    }
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link') {
                                    $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                    }


                                    if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                    {
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-sub-title'){
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                    }
                                    }
                                }
                            @endphp
                            <li><a href="{!! $homepage_footer_section3_link!!}">{!! $homepage_footer_section3_sub_title !!}</a></li>
                            @endfor
                        </ul>
                        @endif

                    </div>
                </div>
                <div class="footer-col footer-link footer-link-2">
                    @php
                        $homepage_footer_section4_title =$homepage_footer_section4_checkbox = '';

                        $homepage_footer_key4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key4 != '') {
                            $homepage_footer_section4 = $theme_json[$homepage_footer_key4];

                        foreach ($homepage_footer_section4['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section4_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                            $homepage_footer_section4_checkbox = $value['field_default_text'];
                            }
                        }
                        }

                    @endphp
                    @if($homepage_footer_section4_checkbox == 'on')
                        <div class="footer-widget">
                            {!! $homepage_footer_section4_title!!}

                            @php
                                $homepage_footer_section5_sub_title = $homepage_footer_section5_link='';

                                $homepage_footer_key5 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key5 != '') {
                                    $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                                }

                            @endphp
                            <ul>
                                @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                                    {

                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-sub-title') {
                                        $homepage_footer_section5_sub_title = $homepage_footer_section5_value['field_default_text'];
                                        }

                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-link') {
                                        $homepage_footer_section5_link = $homepage_footer_section5_value['field_default_text'];
                                        }
                                        if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                        {
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-sub-title'){
                                            $homepage_footer_section5_sub_title = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                        }
                                        }
                                        if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                        {
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-link'){
                                            $homepage_footer_section5_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                        }
                                    }
                                    }
                                @endphp

                                <li><a href="{!! $homepage_footer_section5_link!!}">{!! $homepage_footer_section5_sub_title !!}</a></li>
                                @endfor
                            </ul>


                        </div>
                    @endif
                </div>
                <div class="footer-col footer-link footer-link-3">
                    @php
                        $homepage_footer_section6_title = $homepage_footer_section6_checkbox='';

                        $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key6 != '') {
                            $homepage_footer_section6 = $theme_json[$homepage_footer_key6];

                        foreach ($homepage_footer_section6['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section6_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                            $homepage_footer_section6_checkbox = $value['field_default_text'];
                            }
                          }
                        }
                    @endphp
                    @if($homepage_footer_section6_checkbox == 'on')
                        <div class="footer-widget">
                            {!! $homepage_footer_section6_title!!}

                            @php
                                $homepage_footer_section7_sub_title = $homepage_footer_section7_link='';

                                $homepage_footer_key7 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key7 != '') {
                                    $homepage_footer_section7 = $theme_json[$homepage_footer_key7];

                                }

                            @endphp
                            <ul>
                                @for($i=0 ; $i < $homepage_footer_section7['loop_number'];$i++)
                                    @php
                                        foreach ($homepage_footer_section7['inner-list'] as $homepage_footer_section7_value)
                                        {

                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-sub-title') {
                                            $homepage_footer_section7_sub_title = $homepage_footer_section7_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']]))
                                            {
                                                if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-sub-title'){
                                                $homepage_footer_section7_sub_title = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                            }
                                            }
                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link') {
                                            $homepage_footer_section7_link = $homepage_footer_section7_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']]))
                                            {
                                                if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link'){
                                                    $homepage_footer_section7_link = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                            }
                                            }
                                        }
                                    @endphp

                                    <li><a href="{!! $homepage_footer_section7_link!!}">{!! $homepage_footer_section7_sub_title!!}</a></li>
                                @endfor
                            </ul>

                        </div>
                    @endif
                </div>
                <div class="footer-col footer-link footer-link-4">
                    @php
                        $homepage_footer_section8_title = $homepage_footer_section8_checkbox='';

                        $homepage_footer_key8 = array_search('homepage-footer-8', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key8 != '') {
                            $homepage_footer_section8 = $theme_json[$homepage_footer_key8];

                        foreach ($homepage_footer_section8['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section8_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                            $homepage_footer_section8_checkbox = $value['field_default_text'];
                            }
                          }
                        }
                    @endphp
                    @if($homepage_footer_section8_checkbox == 'on')
                        <div class="footer-widget">
                            {!!$homepage_footer_section8_title!!}

                                @php
                                    $homepage_footer_section9_sub_title = $homepage_footer_section9_link='';

                                    $homepage_footer_key9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key9 != '') {
                                        $homepage_footer_section9 = $theme_json[$homepage_footer_key9];

                                    }

                                @endphp
                            <ul>
                                @for($i=0 ; $i < $homepage_footer_section9['loop_number'];$i++)
                                    @php
                                        foreach ($homepage_footer_section9['inner-list'] as $homepage_footer_section9_value)
                                        {

                                            if($homepage_footer_section9_value['field_slug'] == 'homepage-footer-sub-title') {
                                            $homepage_footer_section9_sub_title = $homepage_footer_section9_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section9[$homepage_footer_section9_value['field_slug']]))
                                            {
                                                if($homepage_footer_section9_value['field_slug'] == 'homepage-footer-sub-title'){
                                                $homepage_footer_section9_sub_title = $homepage_footer_section9[$homepage_footer_section9_value['field_slug']][$i];
                                            }
                                            }
                                            if($homepage_footer_section9_value['field_slug'] == 'homepage-footer-link') {
                                            $homepage_footer_section9_link = $homepage_footer_section9_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section9[$homepage_footer_section9_value['field_slug']]))
                                            {
                                                if($homepage_footer_section9_value['field_slug'] == 'homepage-footer-link'){
                                                $homepage_footer_section9_link = $homepage_footer_section9[$homepage_footer_section9_value['field_slug']][$i];
                                            }
                                            }
                                        }
                                    @endphp

                                    <li><a href="{!! $homepage_footer_section9_link !!}">{!! $homepage_footer_section9_sub_title!!}</a></li>
                                @endfor
                            </ul>
                        </div>
                    @endif
                </div>
        </div>
    </div>
</footer>
<!--footer end here-->
<div class="overlay "></div>
<!--cart popup start here-->
<div class="cartDrawer cartajaxDrawer">

</div>
<!--cart popup ends here-->
<!-- Mobile menu start here -->
<div class="mobile-menu-wrapper">
    <div class="menu-close-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34" fill="none">
            <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white" stroke-width="2"/>
            <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white" stroke-width="2"/>
        </svg>
    </div>
    <div class="mobile-menu-bar">
        <div class="steps-theme-navigation desk-only">
            <h5 class="stp-head">{{ __('NAVIGATION') }}</h5>
            <div class="stp-nav d-flex align-items-center">
                @if ($has_subcategory)
                @foreach ($MainCategoryList as $category)
                <div class="stp-navlink ">
                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a>
                </div>
                @endforeach
                @endif
            </div>
            <div class="stp-menu-widget featured-coll-widget">
                <h5> <b>{{__('Featured')}} </b>{{__('collections')}} </h5>
                <ul>
                    @foreach ($featured_products->data as $key => $featured)
                    <li class="d-flex">
                        <div class="fea-coll-img">
                            <a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $featured->id ])}}">
                                <img src="{{ get_file($featured->image_path, APP_THEME()) }}">
                            </a>
                        </div>
                        <div class="fea-coll-contnt d-flex align-items-center">
                            <div class="fea-coll-contnt-left">
                                <h6><a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $featured->id ])}}">  {{$featured->name}}</a></h6>
                                {{-- <p> {{ __('SNEAKERS 2022 EDITION') }}</p> --}}
                            </div>
                            <a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $featured->id ])}}" class="btn white-btn">
                                <span>{{ __('MORE') }}</span>
                                <svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg>
                            </a>
                        </div>
                    </li>
                    @endforeach

                </ul>
            </div>

            <div class="stp-menu-widget featured-coll-widget ">
                <h5> <b>{{__('More')}}  </b>{{__('categories:')}} </h5>
                <ul class="pulse-arrow ">
                    <li  class="filter_products" data-value="best-selling">
                        <a href="{{route('page.product-list',[$slug,'filter_product' => 'best-selling' ])}}" >{{__('Bestsellers')}}</a>
                    </li>
                    <li  class="filter_products" data-value="best-selling">
                        <a href="{{route('page.product-list',[$slug,'filter_product' => 'trending' ])}}" >{{__('Trending product')}}<span></span></a>
                    </li>

                </ul>
            </div>

            <div class="stp-menu-widget featured-coll-widget">
                <h5> <b> {{ __('Share us,')}}  </b> {{ __('be us')}} </h5>
                <ul class="header-list-social" role="list">
                    @php
                    $homepage_footer_social_icon = $homepage_footer_social_link='';

                    $homepage_footer_key3 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key3 != '') {
                        $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                    }

                    @endphp
                    @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                    @php
                            foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                            {

                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                    $homepage_footer_social_icon = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                        $homepage_footer_social_icon = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link') {
                                    $homepage_footer_social_link = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link'){
                                        $homepage_footer_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                    }
                                    // dd($homepage_footer_social_link);
                                }
                            }
                        @endphp
                        @if($homepage_footer_section3['section_enable'] == 'on')
                            <li>
                                <a href="{!! $homepage_footer_social_link !!}" >
                                    <img src="{{asset($homepage_footer_social_icon)}}">
                                </a>
                            </li>
                        @endif
                    @endfor

                </ul>
            </div>
        </div>
        <ul class="mobile-only">
            <li class="mobile-item has-children">
                <a href="#" class="acnav-label">
                    {{__('Shop All')}}
                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11" viewBox="0 0 20 11">
                        <path fill="#24272a" d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z"></path>
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                        <path fill="#24272a" d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z"></path>
                    </svg>
                </a>
                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            @foreach ($MainCategoryList as $category)
                                <li class="menu-h-link menu-h-drop has-children">
                                    <a href="#" class="acnav-label">
                                        <span>{{$category->name}}</span>
                                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="11" viewBox="0 0 20 11">
                                            <path fill="#24272a"
                                                d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                                        </svg>
                                        <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="18" viewBox="0 0 20 18">
                                            <path fill="#24272a"
                                                d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                                        </svg>
                                    </a>
                                    <ul class="acnav-list">
                                        @foreach ($SubCategoryList as $cat)
                                            @if ($cat->maincategory_id == $category->id)
                                                <li>
                                                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $cat->id ])}}">{{$cat->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                    <li class="menu-h-link menu-h-drop has-children">
                        <a href="{{route('page.product-list',$slug)}}" class="acnav-label">
                            <span>{{__('Collection')}}</span>
                        </a>
                    </li>
                    <li class="menu-h-link menu-h-drop has-children">
                        <a href="#" class="acnav-label">
                            <span>{{__('Pages')}}</span>
                            <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11" viewBox="0 0 20 11">
                                <path fill="#24272a" d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z"></path>
                            </svg>
                            <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                                <path fill="#24272a" d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z"></path>
                            </svg>
                        </a>
                        <ul class="acnav-list">
                            @foreach ($pages as $page)
                                <li>
                                    <a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a>
                                </li>
                             @endforeach
                             <li><a href="{{route('page.faq',$slug)}}">{{__('FAQs')}}</a></li>
                             <li><a href="{{route('page.blog',$slug)}}">{{__('Blog')}}</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact Us') }}</a>
                    </li>

                </ul>
            </li>



        </ul>
    </div>
</div>

<!--cookie popup ends here-->
@php
$homepage_header_video_link='';
$homepage_best_product_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
if ($homepage_best_product_key != '') {
    $homepage_best_product = $theme_json[$homepage_best_product_key];
    foreach ($homepage_best_product['inner-list'] as $key => $value) {

        if ($value['field_slug'] == 'homepage-header-video-link') {
            $homepage_header_video_link = $value['field_default_text'];
        }
    }
}
@endphp
<div id="popup-box" class="overlay-popup">
    <div class="popup-inner">
        <div class="content">
            <a class=" close-popup" href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34" fill="none">
                    <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white" stroke-width="2"></line>
                    <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white" stroke-width="2"></line>
                </svg>
            </a>

            <iframe class="videoFrame1" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player" width="1920" height="680"
                src="{{asset($homepage_header_video_link)}}">
            </iframe>
        </div>
    </div>
</div>

