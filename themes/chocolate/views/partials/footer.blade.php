@php
    $theme_json = $homepage_json;
    if (Auth::user()) {
        $carts = App\Models\Cart::where('user_id', Auth::user()->id)
            ->where('theme_id', env('APP_THEME'))
            ->get();
        $cart_product_count = $carts->count();
    }
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());

    $whatsapp_setting_enabled = \App\Models\Utility::GetValueByName('whatsapp_setting_enabled', $theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp

<!-- video popup -->


<footer class="site-footer">
    <div class="container">

        @if ($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif
        <div class="footer-row">
            <div class="footer-col footer-subscribe-col">
                <div class="footer-widget">
                    @php
                        $homepage_category_title_text = $homepage_category_sub_text = '';
                        $homepage_header_1_key = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-footer-sub-text') {
                                    $homepage_category_title_text = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-footer-text') {
                                    $homepage_category_sub_text = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    <h2>
                        <a href="{{ route('landing_page', $slug) }}">
                            <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                alt="Style theme"> </a>
                    </h2>
                    <p>{!! $homepage_category_title_text !!}
                    </p>
                    <span>{!! $homepage_category_sub_text !!}</span>
                </div>
            </div>
            <div class="footer-col footer-link footer-link-1">
                <div class="footer-widget footer-ween">
                    @php
                        $homepage_footer_section2_title = $homepage_footer_section2_checkbox = '';

                        $homepage_footer_key2 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key2 != '') {
                            $homepage_footer_section2 = $theme_json[$homepage_footer_key2];

                            foreach ($homepage_footer_section2['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-footer-title-text') {
                                    $homepage_footer_section2_title = $value['field_default_text'];
                                }

                                if ($value['field_slug'] == 'homepage-footer-enable') {
                                    $homepage_footer_section2_checkbox = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_footer_section2_checkbox == 'on')
                        <h2> {!! $homepage_footer_section2_title !!} </h2>

                        @php
                            $homepage_footer_section3_sub_title = $homepage_footer_section3_link = '';

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
                                        }
                                        if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{!! $homepage_footer_section3_link !!}">{!! $homepage_footer_section3_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    @endif
                </div>
            </div>
            <div class="footer-col footer-link footer-link-2">
                <div class="footer-widget footer-ween">
                    @php
                        $homepage_footer_section4_title = $homepage_footer_section4_checkbox = '';

                        $homepage_footer_key4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key4 != '') {
                            $homepage_footer_section4 = $theme_json[$homepage_footer_key4];
                            // DD($homepage_footer_section4);
                            foreach ($homepage_footer_section4['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-footer-title-text') {
                                    $homepage_footer_section4_title = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-footer-enable') {
                                    $homepage_footer_section4_checkbox = $value['field_default_text'];
                                }
                            }
                        }

                    @endphp
                    @if ($homepage_footer_section4_checkbox == 'on')

                        <h2> {!! $homepage_footer_section4_title !!}</h2>
                        @php
                            $homepage_footer_section5_sub_title = $homepage_footer_section5_link = '';

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
                                        }
                                        if (!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']])) {
                                            if ($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section5_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{!! $homepage_footer_section5_link !!}">{!! $homepage_footer_section5_sub_title !!}</a></li>
                            @endfor

                        </ul>
                    @endif
                </div>
            </div>

            <div class="footer-col footer-link footer-link-3">
                <div class="footer-widget">

                    @php
                        $homepage_footer_social_icon = $homepage_footer_social_link = '';

                        $homepage_footer_key3 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                        }

                    @endphp
                    <h2> Share: </h2>
                    <ul class="social-ul d-flex">
                        @for ($i = 0; $i < $homepage_footer_section3['loop_number']; $i++)
                            @php
                                foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value) {
                                    if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_social_icon = $homepage_footer_section3_value['field_default_text'];
                                    }

                                    if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                        if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                            $homepage_footer_social_icon = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                    if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                        $homepage_footer_social_link = $homepage_footer_section3_value['field_default_text'];
                                    }

                                    if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                        if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                            $homepage_footer_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                        }
                                        // dd($homepage_footer_social_link);
                                    }
                                }
                            @endphp
                            <li>
                                <a href ="{!! $homepage_footer_social_link !!}">
                                    <img src=" {{ get_file($homepage_footer_social_icon, APP_THEME()) }}">
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>

</footer>

<div class="overlay "></div>
<!--cart popup start here-->
<div class="cartDrawer cartajaxDrawer">

</div>
