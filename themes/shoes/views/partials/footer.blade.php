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
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());

    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp
    <footer class="site-footer">
        <div class="container">
            @if($whatsapp_setting_enabled)
                <div class="floating-wpp"></div>
            @endif

            <div class="footer-row">
                <div class="footer-col footer-store-detail">
                    @php
                        $homepage_footer_section1_title = '';

                        $homepage_footer_key1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_footer_key1 != '') {
                            $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                            foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-footer-sub-text') {
                                    $homepage_footer_section1_title = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="{{route('landing_page',$slug)}}">
                                <img src="{{isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/'.APP_THEME().'/assets/images/logo.png'}} " alt="footer logo">
                            </a>
                        </div>
                        @if ($homepage_footer_section1['section_enable'] == 'on')
                            <div class="store-detail">
                                <p>{!! $homepage_footer_section1_title !!}</p>
                            </div>
                        @endif
                        <div class="social-media">
                            @php
                                $homepage_footer_9_icon = $homepage_footer_9_link = '';

                                $homepage_footer_9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_footer_9 != '') {
                                    $homepage_footer_section_9 = $theme_json[$homepage_footer_9];
                                }

                            @endphp
                            <ul class="social-links">
                                @for ($i = 0; $i < $homepage_footer_section_9['loop_number']; $i++)
                                    @php
                                        foreach ($homepage_footer_section_9['inner-list'] as $homepage_footer_section_9_value) {
                                            if ($homepage_footer_section_9_value['field_slug'] == 'homepage-footer-social-icon') {
                                                $homepage_footer_9_icon = $homepage_footer_section_9_value['field_default_text'];
                                            }
                                            if ($homepage_footer_section_9_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                $homepage_footer_9_link = $homepage_footer_section_9_value['field_default_text'];
                                            }

                                            if (!empty($homepage_footer_section_9[$homepage_footer_section_9_value['field_slug']])) {
                                                if ($homepage_footer_section_9_value['field_slug'] == 'homepage-footer-social-icon') {
                                                    $homepage_footer_9_icon = $homepage_footer_section_9[$homepage_footer_section_9_value['field_slug']][$i]['field_prev_text'];
                                                }
                                            }
                                            if (!empty($homepage_footer_section_9[$homepage_footer_section_9_value['field_slug']])) {
                                                if ($homepage_footer_section_9_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                    $homepage_footer_9_link = $homepage_footer_section_9[$homepage_footer_section_9_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    <li>
                                        <a href="{!! $homepage_footer_9_link !!}" target="_blank">
                                            <img src="{{ get_file($homepage_footer_9_icon, APP_THEME()) }}">
                                        </a>
                                    </li>
                                @endfor

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-col footer-link footer-link-1">
                    <div class="footer-widget">
                        @php
                            $homepage_footer_section1_title = '';

                            $homepage_footer_key1 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key1 != '') {
                                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-footer-title-text') {
                                        $homepage_footer_section1_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer_section1_checkbox = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_footer_section1_checkbox == 'on')

                            <h4> {!! $homepage_footer_section1_title !!} </h4>
                            @php
                                $homepage_footer_section3_sub_title = '';

                                $homepage_footer_key3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_footer_key3 != '') {
                                    $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                }

                            @endphp
                            <ul class="social-ul">
                                @for ($i = 0; $i < $homepage_footer_section3['loop_number']; $i++)
                                    @php
                                        foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value) {
                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                            }
                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                            }

                                            if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                                if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                                    $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                }
                                                if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                    $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    <li><a
                                            href="{{ asset($homepage_footer_section3_link) }}">{!! $homepage_footer_section3_sub_title !!}</a>
                                    </li>
                                @endfor
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="footer-col footer-link footer-link-2">
                    <div class="footer-widget">
                        @php
                            $homepage_footer_section1_title = '';

                            $homepage_footer_key1 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key1 != '') {
                                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-footer-title-text') {
                                        $homepage_footer_section1_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer_section1_checkbox = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_footer_section1_checkbox == 'on')

                            <h4> {{ $homepage_footer_section1_title }} </h4>
                            <ul>
                                @php
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_link = '';

                                    $homepage_footer_key3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                                    if ($homepage_footer_key3 != '') {
                                        $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                    }

                                @endphp
                                @for ($i = 0; $i < $homepage_footer_section3['loop_number']; $i++)
                                    @php
                                        foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value) {
                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                            }
                                            if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                            }

                                            if (!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']])) {
                                                if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                                    $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                }
                                                if ($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                                    $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    <li><a href="{!! $homepage_footer_section3_link !!}">{{ $homepage_footer_section3_sub_title }}</a>
                                    </li>
                                @endfor
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="footer-col footer-subscribe-col">
                    <div class="footer-widget">
                        @php
                            $homepage_footer_section1_title = $homepage_footer_section1_text = $homepage_footer_section1_description = '';

                            $homepage_footer_key1 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key1 != '') {
                                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-footer-title-text') {
                                        $homepage_footer_section1_title = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-footer-sub-text') {
                                        $homepage_footer_section1_text = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-footer-description') {
                                        $homepage_footer_section1_description = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_footer_section1['section_enable'] == 'on')
                            <h4>{!! $homepage_footer_section1_title !!}</h4>
                            <p>{!! $homepage_footer_section1_text !!} </p>
                            <form class="footer-subscribe-form" action="{{ route('newsletter.store',$slug) }}" method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="Enter email address..." name="email">
                                    <button type="submit" class="btn-subscibe">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.97863e-08 9.99986C-7.09728e-06 10.4601 0.373083 10.8332 0.83332 10.8332L17.113 10.8335L15.1548 12.7358C14.8247 13.0565 14.817 13.584 15.1377 13.9142C15.4584 14.2443 15.986 14.2519 16.3161 13.9312L19.7474 10.5979C19.9089 10.441 20.0001 10.2254 20.0001 10.0002C20.0001 9.77496 19.9089 9.55935 19.7474 9.40244L16.3161 6.0691C15.986 5.74841 15.4584 5.75605 15.1377 6.08617C14.817 6.41628 14.8247 6.94387 15.1548 7.26456L17.1129 9.1668L0.833346 9.16654C0.373109 9.16653 7.24653e-06 9.53962 4.97863e-08 9.99986Z"
                                                fill="#183A40"></path>
                                        </svg>
                                    </button>
                                </div><br>
                                <div>
                                {!! $homepage_footer_section1_description !!}
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        @php
                            $homepage_footer_section1_title = '';

                            $homepage_footer_key1 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key1 != '') {
                                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-footer-copyrgt-text') {
                                        $homepage_footer_section1_title = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_footer_section1['section_enable'] == 'on')
                            <p>{!! $homepage_footer_section1_title !!}</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6">
                        <ul class="policy-links d-flex align-items-center justify-content-end">
                            @foreach ($pages as $page)
                                @if ($page->page_status == 'custom_page')
                                    <li class="menu-lnk"><a
                                            href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a></li>
                                @else
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<div class="overlay"></div>
<!--cart drawer start here-->
<div class="cartDrawer cartajaxDrawer">

</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
