<!--footer start here-->
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

    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp
<footer class="site-footer">
    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/footer-background.png') }}" class="footer-bg" alt="">
    <div class="container">
        @if($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif
        <div class="footer-row">
            @php
                $homepage_newsletter_title = '';

                $homepage_newsletter = array_search('homepage-newsletter-1', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_newsletter != '') {
                    $homepage_newsletter_value = $theme_json[$homepage_newsletter];

                    foreach ($homepage_newsletter_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-newsletter-label-text') {
                            $homepage_newsletter_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                            $homepage_newsletter_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                            $homepage_newsletter_sub = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-newsletter-description') {
                            $homepage_newsletter_description = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_newsletter_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'homepage-newsletter-label-text') {
                                $homepage_newsletter_title = $homepage_newsletter_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-title-text') {
                                $homepage_newsletter_text = $homepage_newsletter_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                $homepage_newsletter_sub = $homepage_newsletter_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'homepage-newsletter-description') {
                                $homepage_newsletter_description = $value['field_default_text'];
                            }
                        }
                    }
                }
            @endphp

            <div class="footer-col footer-subscribe-col">
                <div class="footer-widget">
                    <div class="footer-subscribe">
                        <div class="subtitle">{!! $homepage_newsletter_title !!}</div>
                        <h2>{!! $homepage_newsletter_text !!} </h2>
                    </div>
                    <p>{{ $homepage_newsletter_sub }}</p>
                    <form class="footer-subscribe-form" action="{{ route('newsletter.store',$slug) }}" method="post">
                        @csrf
                        <div class="input-wrapper">
                            <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                            <button type="submit" class="btn-subscibe"> {{ __('SUBSCRIBE') }}
                            </button>
                        </div>
                        <div class="">
                            {{-- <input type="checkbox" class="" id="PlaceCheckbox"> --}}
                            <label for="">{{ $homepage_newsletter_description }}</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-col footer-link footer-link-1">
                @php
                    $homepage_footer_section_title = '';

                    $homepage_footer_key = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_footer_key != '') {
                        $homepage_footer_section = $theme_json[$homepage_footer_key];
                        // dd($homepage_footer_section);
                        foreach ($homepage_footer_section['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-footer-title-text') {
                                $homepage_footer_section_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-footer-enable') {
                                $homepage_footer_section_enable = $value['field_default_text'];
                                // dd($homepage_footer_section_enable);
                            }
                        }
                    }
                @endphp
                <div class="footer-widget">
                    @if ($homepage_footer_section_enable == 'on')
                        <h2>{!! $homepage_footer_section_title !!}</h2>
                        @php
                            $homepage_footer_section1_sub_title = '';

                            $homepage_footer_key1 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key1 != '') {
                                $homepage_footer_section1 = $theme_json[$homepage_footer_key1];
                            }

                        @endphp
                        <ul>
                            @for ($i = 0; $i < $homepage_footer_section1['loop_number']; $i++)
                                @php
                                    foreach ($homepage_footer_section1['inner-list'] as $homepage_footer_section1_value) {
                                        if ($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-text') {
                                            $homepage_footer_section1_sub_title = $homepage_footer_section1_value['field_default_text'];
                                        }
                                        if ($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-link') {
                                            $homepage_footer_section1_link = $homepage_footer_section1_value['field_default_text'];
                                        }

                                        if (!empty($homepage_footer_section1[$homepage_footer_section1_value['field_slug']])) {
                                            if ($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-text') {
                                                $homepage_footer_section1_sub_title = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                            if ($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section1_link = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{{ $homepage_footer_section1_link }}">{!! $homepage_footer_section1_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    @endif
                </div>
            </div>
            <div class="footer-col footer-link footer-link-2">
                @php
                    $homepage_footer_section3_title = '';

                    $homepage_footer1_key = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_footer1_key != '') {
                        $homepage_footer_section3 = $theme_json[$homepage_footer1_key];
                        foreach ($homepage_footer_section3['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-footer-title-text') {
                                $homepage_footer_section3_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-footer-label-link') {
                                $homepage_footer_section3_enable = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="footer-widget">
                    @if ($homepage_footer_section3_enable == 'on')
                        <h2> {{ $homepage_footer_section3_title }} </h2>
                        @php
                            $homepage_footer_section4_sub_title = '';

                            $homepage_footer_key4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key4 != '') {
                                $homepage_footer_section4 = $theme_json[$homepage_footer_key4];
                            }

                        @endphp
                        <ul>
                            @for ($i = 0; $i < $homepage_footer_section4['loop_number']; $i++)
                                @php
                                    foreach ($homepage_footer_section4['inner-list'] as $homepage_footer_section4_value) {
                                        if ($homepage_footer_section4_value['field_slug'] == 'homepage-footer-label-text') {
                                            $homepage_footer_section4_sub_title = $homepage_footer_section4_value['field_default_text'];
                                        }
                                        if ($homepage_footer_section4_value['field_slug'] == 'homepage-footer-label-link') {
                                            $homepage_footer_section4_link = $homepage_footer_section4_value['field_default_text'];
                                        }

                                        if (!empty($homepage_footer_section4[$homepage_footer_section4_value['field_slug']])) {
                                            if ($homepage_footer_section4_value['field_slug'] == 'homepage-footer-label-text') {
                                                $homepage_footer_section4_sub_title = $homepage_footer_section4[$homepage_footer_section4_value['field_slug']][$i];
                                            }
                                            if ($homepage_footer_section4_value['field_slug'] == 'homepage-footer-label-link') {
                                                $homepage_footer_section4_link = $homepage_footer_section4[$homepage_footer_section4_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{{ $homepage_footer_section4_link }}">{!! $homepage_footer_section4_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    @endif
                </div>
            </div>
            <div class="footer-col footer-link footer-link-3">
                @php
                    $homepage_footer_section5_title = '';

                    $homepage_footer2_key = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));

                    if ($homepage_footer2_key != '') {
                        $homepage_footer_section5 = $theme_json[$homepage_footer2_key];
                        foreach ($homepage_footer_section5['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-footer-label-text') {
                                $homepage_footer_section5_title = $value['field_default_text'];
                            }
                            if ($value['field_slug'] == 'homepage-footer-enable') {
                                $homepage_footer_section5_enable = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="footer-widget">
                    @if ($homepage_footer_section5_enable == 'on')
                        <h2>{!! $homepage_footer_section5_title !!}</h2>
                        @php
                            $homepage_footer_section6_sub_title = '';

                            $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_footer_key6 != '') {
                                $homepage_footer_section6 = $theme_json[$homepage_footer_key6];
                            }

                        @endphp
                        <ul class="header-list-social">
                            @for ($i = 0; $i < $homepage_footer_section6['loop_number']; $i++)
                                @php
                                    foreach ($homepage_footer_section6['inner-list'] as $homepage_footer_section6_value) {
                                        if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon') {
                                            $homepage_footer_section6_sub_image = $homepage_footer_section6_value['field_default_text'];
                                        }
                                        if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                            $homepage_footer_section6_link = $homepage_footer_section6_value['field_default_text'];
                                        }

                                        if (!empty($homepage_footer_section6[$homepage_footer_section6_value['field_slug']])) {
                                            if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon') {
                                                $homepage_footer_section6_sub_image = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                $homepage_footer_section6_link = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{{ $homepage_footer_section6_link }}" target="_blank">
                                        <img src="{{ get_file($homepage_footer_section6_sub_image, APP_THEME()) }}"
                                            alt="">
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer end here-->
<div class="overlay "></div>
<!--cart popup start here-->

<!--cart popup ends here-->
<!-- Mobile menu start here -->
<div class="mobile-menu-wrapper">
    <div class="menu-close-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34" fill="none">
            <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white" stroke-width="2" />
            <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white" stroke-width="2" />
        </svg>
    </div>
    <div class="mobile-menu-bar">
        <div class="steps-theme-navigation header-desk-only">
            <h5 class="stp-head">{{ __('NAVIGATION') }}</h5>
            <div class="stp-nav d-flex align-items-center">

                @foreach ($MainCategoryList->take(3) as $category)
                    <div class="stp-navlink ">
                        <a
                            href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                    </div>
                @endforeach
            </div>
            <div class="stp-menu-widget featured-coll-widget">
                <h5> <b>{{ __('Featured') }} </b> {{ __('collections') }}</h5>
                <ul>
                    @foreach ($featured_products->data as $key => $featured)
                        <li class="d-flex">
                            <div class="fea-coll-img">
                                <a
                                    href="{{ route('page.product-list', [$slug,'main_category' => $category->id, 'sub_category' => $featured->id]) }}">
                                    <img src="{{ get_file($featured->image_path, APP_THEME()) }}">
                                </a>
                            </div>
                            <div class="fea-coll-contnt d-flex align-items-center">
                                <div class="fea-coll-contnt-left">
                                    <h6><a
                                            href="{{ route('page.product-list', [$slug,'main_category' => $category->id, 'sub_category' => $featured->id]) }}">
                                            {{ $featured->name }}</a></h6>
                                </div>
                                <a href="{{ route('page.product-list', [$slug,'main_category' => $category->id, 'sub_category' => $featured->id]) }}"
                                    class="btn white-btn">
                                    <span>{{ __('MORE') }}</span>
                                    <svg viewBox="0 0 10 5">
                                        <path
                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="stp-menu-widget featured-coll-widget">
                <h5> <b>{{ __('More') }} </b> {{ __('categories') }}:</h5>
                <ul class="pulse-arrow">
                    <li class="filter_products" data-value="best-selling">
                        <a
                            href="{{ route('page.product-list', [$slug,'filter_product' => 'best-selling']) }}">{{ __('Bestsellers') }}</a>
                    </li>
                    <li class="filter_products" data-value="best-selling">
                        <a
                            href="{{ route('page.product-list', [$slug,'filter_product' => 'trending']) }}">{{ __('Trending product') }}<span></span></a>
                    </li>
                </ul>
            </div>
            <div class="stp-menu-widget featured-coll-widget">
                <h5> <b>{{ __('Share us,') }} </b> {{ __('be us') }}</h5>
                @php
                    $homepage_footer_section6_sub_title = '';

                    $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_footer_key6 != '') {
                        $homepage_footer_section6 = $theme_json[$homepage_footer_key6];
                    }

                @endphp
                <ul class="header-list-social" role="list">
                    @for ($i = 0; $i < $homepage_footer_section6['loop_number']; $i++)
                        @php
                            foreach ($homepage_footer_section6['inner-list'] as $homepage_footer_section6_value) {
                                if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon') {
                                    $homepage_footer_section6_sub_image = $homepage_footer_section6_value['field_default_text'];
                                }
                                if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                    $homepage_footer_section6_link = $homepage_footer_section6_value['field_default_text'];
                                }

                                if (!empty($homepage_footer_section6[$homepage_footer_section6_value['field_slug']])) {
                                    if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_section6_sub_image = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i]['field_prev_text'];
                                    }
                                    if ($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                        $homepage_footer_section6_link = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                        <li>
                            <a href="{{ $homepage_footer_section6_link }}" target="_blank">
                                <img src="{{ get_file($homepage_footer_section6_sub_image, APP_THEME()) }}"
                                    alt="">

                            </a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
        <ul class="header-mobile-only">
            <li class="mobile-item has-children">
                <a href="#" class="acnav-label">
                    {{ __(' Shop All') }}
                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                        viewBox="0 0 20 11">
                        <path fill="#24272a"
                            d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z">
                        </path>
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                        viewBox="0 0 20 18">
                        <path fill="#24272a"
                            d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                        </path>
                    </svg>
                </a>


                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            @foreach ($MainCategoryList as $category)
                                <li><a
                                        href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a></li>

            <li class="mobile-item has-children">
                <a href="#" class="acnav-label">
                    {{ __('Pages') }}
                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                        viewBox="0 0 20 11">
                        <path fill="#24272a"
                            d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z">
                        </path>
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                        viewBox="0 0 20 18">
                        <path fill="#24272a"
                            d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                        </path>
                    </svg>
                </a>
                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            @foreach ($pages as $page)
                                <li><a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                            @endforeach
                            <li><a href="{{ route('page.faq',$slug) }}">{{ __('FAQs') }}</a></li>
                            <li><a href="{{ route('page.blog',$slug) }}">{{ __('Blog') }}</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            @foreach ($pages->take(1) as $page)
                <li><a href="{{ env('APP_URL') . 'page/' . $page->page_slug }}">{{ $page->name }}</a></li>
            @endforeach

        </ul>
    </div>
</div>
<div class="overlay cart-overlay"></div>
<div class="cartDrawer cartajaxDrawer">
</div>


<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
