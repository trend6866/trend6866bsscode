@php
    $theme_json = $homepage_json;
    if (Auth::user()) {
        $carts = App\Models\Cart::where('user_id', Auth::user()->id)
            ->where('theme_id', APP_THEME())
            ->get();
        $cart_product_count = $carts->count();
    }
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
@endphp

<!-- footer start  -->
@php
    $homepage_footer_section1_title = $homepage_footer_section1_subtext = '';

    $homepage_footer_key1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
    if ($homepage_footer_key1 != '') {
        $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

        foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
            if ($value['field_slug'] == 'homepage-footer-title-text') {
                $homepage_footer_section1_title = $value['field_default_text'];
            }
            if ($value['field_slug'] == 'homepage-footer-sub-text') {
                $homepage_footer_section1_subtext = $value['field_default_text'];
            }
        }
    }

    $whatsapp_setting_enabled = \App\Models\Utility::GetValueByName('whatsapp_setting_enabled', $theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp
@if ($homepage_footer_section1['section_enable'] == 'on')
    <footer class="site-footer">
        @if ($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif
        @php
            $homepage_footer_section9_title = $homepage_footer_section9_img = '';

            $homepage_footer_key9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_footer_key9 != '') {
                $homepage_footer_section9 = $theme_json[$homepage_footer_key9];

                foreach ($homepage_footer_section9['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-footer-copyright-text') {
                        $homepage_footer_section9_title = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-footer-img') {
                        $homepage_footer_section9_img = $value['field_default_text'];
                    }
                }
            }
        @endphp
        <img src="{{ get_file($homepage_footer_section9_img, APP_THEME()) }}" alt="footer-leaf" id="footer-leaf">
        <div class="footer-top">
            <div class=" container">
                <div class="row main-footer">
                    <div class=" col-lg-7 col-12 col-12">
                        <div class=" row">
                            <div class=" col-md-6 col-12">
                                <div class="footer-col footer-description">
                                    <div class="footer-time">
                                        {!! $homepage_footer_section1_title !!}
                                    </div>
                                    <p>{!! $homepage_footer_section1_subtext !!}</p>
                                </div>
                            </div>
                            <div class=" col-md-3 col-12">
                                @php
                                    $homepage_footer_section2_title = '';

                                    $homepage_footer_key2 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_footer_key2 != '') {
                                        $homepage_footer_section2 = $theme_json[$homepage_footer_key2];
                                        foreach ($homepage_footer_section2['inner-list'] as $key => $value) {
                                            if ($value['field_slug'] == 'homepage-footer-title-text') {
                                                $homepage_footer_section2_title = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-footer-enable') {
                                                $homepage_footer_section2_enable = $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                @if ($homepage_footer_section2_enable == 'on')
                                    <div class="footer-col footer-shop">
                                        <h2 class="footer-title">{!! $homepage_footer_section2_title !!}</h2>
                                        @php
                                            $homepage_footer_section3_sub_title = '';
                                            $homepage_footer_key3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                                            if ($homepage_footer_key3 != '') {
                                                $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                            }
                                        @endphp
                                        <ul>
                                            @for ($i = 0; $i < $homepage_footer_section3['loop_number']; $i++)
                                                @php
                                                    foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value) {
                                                        if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label') {
                                                            $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                                        }
                                                        if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                            $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                                        }
                                                        if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label') {
                                                                $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                            }
                                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                                $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <li><a
                                                        href="{{ $homepage_footer_section3_link }}">{!! $homepage_footer_section3_sub_title !!}</a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class=" col-md-3 col-12">
                                @php
                                    $homepage_footer_section4_title = '';
                                    $homepage_footer_key4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_footer_key4 != '') {
                                        $homepage_footer_section4 = $theme_json[$homepage_footer_key4];
                                        foreach ($homepage_footer_section4['inner-list'] as $key => $value) {
                                            if ($value['field_slug'] == 'homepage-footer-title-text') {
                                                $homepage_footer_section4_title = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-footer-enable') {
                                                $homepage_footer_section4_enable = $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                @if ($homepage_footer_section4_enable == 'on')
                                    <div class="footer-col footer-about-us">
                                        <h2 class="footer-title">{!! $homepage_footer_section4_title !!}</h2>
                                        @php
                                            $homepage_footer_section5_sub_title = '';
                                            $homepage_footer_key5 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                            if ($homepage_footer_key5 != '') {
                                                $homepage_footer_section5 = $theme_json[$homepage_footer_key5];
                                            }
                                        @endphp
                                        <ul>
                                            @for ($i = 0; $i < $homepage_footer_section5['loop_number']; $i++)
                                                @php
                                                    foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value) {
                                                        if ($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label') {
                                                            $homepage_footer_section5_sub_title = $homepage_footer_section5_value['field_default_text'];
                                                        }
                                                        if ($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-link') {
                                                            $homepage_footer_section5_link = $homepage_footer_section5_value['field_default_text'];
                                                        }

                                                        if (!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']])) {
                                                            if ($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label') {
                                                                $homepage_footer_section5_sub_title = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                                            }
                                                            if ($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-link') {
                                                                $homepage_footer_section5_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <li><a
                                                        href="{{ $homepage_footer_section5_link }}">{!! $homepage_footer_section5_sub_title !!}</a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @php
                        $homepage_footer_section6_title = '';
                        $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key6 != '') {
                            $homepage_footer_section6 = $theme_json[$homepage_footer_key6];
                            foreach ($homepage_footer_section6['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-footer-label') {
                                    $homepage_footer_section6_label = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-footer-enable') {
                                    $homepage_footer_section6_enable = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    <div class=" col-lg-5 col-12">
                        <div class=" row">
                            <div class=" col-lg-7 col-12">
                                @php
                                    $homepage_logo = '';
                                    $homepage_logo_key = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_logo_key != '') {
                                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    }
                                    foreach ($homepage_main_logo['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-footer-label') {
                                            $homepage_footer_section6_label = $value['field_default_text'];
                                        }
                                        if ($value['field_slug'] == 'homepage-footer-enable') {
                                            $homepage_footer_section6_enable = $value['field_default_text'];
                                        }
                                    }

                                @endphp
                                @if ($homepage_footer_section6_enable == 'on')
                                    <div class="footer-col footer-insta-gallary">
                                        <h2 class="footer-title">{!! $homepage_footer_section6_label !!}</h2>
                                        <ul class=" d-flex align-items-center flex-wrap">
                                            @if (!empty($homepage_main_logo['homepage-footer-img']))
                                                @for ($i = 0; $i < count($homepage_main_logo['homepage-footer-img']); $i++)
                                                    @php
                                                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-footer-img') {
                                                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                            }
                                                            if (!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']])) {
                                                                if ($homepage_main_logo_value['field_slug'] == 'homepage-footer-img') {
                                                                    $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <li class="gallary-img">
                                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}"
                                                            alt="footer-img1">
                                                    </li>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i <= 6; $i++)
                                                    @php
                                                        foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value) {
                                                            if ($homepage_main_logo_value['field_slug'] == 'homepage-footer-img') {
                                                                $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                                            }
                                                        }
                                                    @endphp
                                                    <li class="gallary-img">
                                                        <img src="{{ get_file($homepage_logo, APP_THEME()) }}"
                                                            alt="footer-img1">
                                                    </li>
                                                @endfor
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-5 col-12">
                                @php
                                    $homepage_footer_section10_title = $homepage_footer_section10_enable = '';

                                    $homepage_footer_key10 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_footer_key10 != '') {
                                        $homepage_footer_section10 = $theme_json[$homepage_footer_key10];

                                        foreach ($homepage_footer_section10['inner-list'] as $key => $value) {
                                            if ($value['field_slug'] == 'homepage-footer-10-label') {
                                                $homepage_footer_section10_title = $value['field_default_text'];
                                            }
                                            if ($value['field_slug'] == 'homepage-footer-10-enable') {
                                                $homepage_footer_section10_enable = $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                @if ($homepage_footer_section10_enable == 'on')
                                    <div class="footer-icons social-media">
                                        <h6 class="footer-title">{!! $homepage_footer_section10_title !!}</h6>
                                        @php
                                            $homepage_footer_section7_icon = '';
                                            $homepage_footer_key7 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                                            if ($homepage_footer_key7 != '') {
                                                $homepage_footer_section7 = $theme_json[$homepage_footer_key7];
                                            }
                                        @endphp
                                        <ul class="d-flex align-items-center">
                                            @for ($i = 0; $i < $homepage_footer_section7['loop_number']; $i++)
                                                @php
                                                    foreach ($homepage_footer_section7['inner-list'] as $homepage_footer_section7_value) {
                                                        if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                                            $homepage_footer_section7_icon = $homepage_footer_section7_value['field_default_text'];
                                                        }
                                                        if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-label-link') {
                                                            $homepage_footer_section7_link = $homepage_footer_section7_value['field_default_text'];
                                                        }

                                                        if (!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']])) {
                                                            if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                                                $homepage_footer_section7_icon = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i]['field_prev_text'];
                                                            }
                                                            if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link') {
                                                                $homepage_footer_section7_link = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <li>
                                                    <a href="{{ $homepage_footer_section7_link }}" target="_blank">
                                                        {{-- <img src="{{asset('/' . $homepage_footer_section7_icon)}}" alt=""> --}}
                                                        <img src="{{ get_file($homepage_footer_section7_icon, APP_THEME()) }}"
                                                            alt="">
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class=" container">
                <div class="footer-copyright">
                    <p class="text-center">{!! $homepage_footer_section9_title !!}</p>
                    @php
                        $homepage_footer_section8_icon = '';
                        $homepage_footer_key8 = array_search('homepage-footer-8', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key8 != '') {
                            $homepage_footer_section8 = $theme_json[$homepage_footer_key8];
                        }
                    @endphp
                    <div class="footer-menu">
                        <ul class="footer-links">
                            {{-- @for ($i = 0; $i < $homepage_footer_section8['loop_number']; $i++) --}}
                            {{-- @php
                        foreach ($homepage_footer_section8['inner-list'] as $homepage_footer_section8_value)
                        {
                            if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-label') {
                            $homepage_footer_section8_label = $homepage_footer_section8_value['field_default_text'];
                            }
                            if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-label-link') {
                            $homepage_footer_section8_link = $homepage_footer_section8_value['field_default_text'];
                            }

                            if(!empty($homepage_footer_section8[$homepage_footer_section8_value['field_slug']]))
                            {
                                if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-social-icon'){
                                    $homepage_footer_section8_label = $homepage_footer_section8[$homepage_footer_section8_value['field_slug']][$i];
                                }
                                if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-link'){
                                    $homepage_footer_section8_link = $homepage_footer_section8[$homepage_footer_section8_value['field_slug']][$i];
                                }
                            }
                        }
                    @endphp --}}
                            @foreach ($pages as $page)
                                @if ($page->page_status == 'custom_page')
                                    <li class="menu-lnk"><a
                                            href="{{ route('custom.page', [$slug, $page->page_slug]) }}">{{ $page->name }}</a>
                                    </li>
                                @else
                                @endif
                            @endforeach
                            {{-- <li><a href="{{ $homepage_footer_section8_link }}" class="active">{!! $homepage_footer_section8_label !!}</a></li> --}}
                            {{-- @endfor --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
<!-- footer end  -->
<div class="overlay cart-overlay"></div>
<div class="cartDrawer cartajaxDrawer">
</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
</body>

</html>
