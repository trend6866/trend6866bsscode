@php
    $theme_json = $homepage_json;
    if(Auth::user()){
        $carts = App\Models\Cart::where('user_id',Auth::user()->id)->where('theme_id', APP_THEME())->get();
        $cart_product_count = $carts->count();
    }
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');

    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp

<footer class="site-footer">
    @php
        $homepage_footer_section1_title = $homepage_footer_section1_subtext = $homepage_footer_section1_text = '';

        $homepage_footer_key1 = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
        if($homepage_footer_key1 != '') {
            $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

        foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-newsletter-title-text') {
                $homepage_footer_section1_title = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                $homepage_footer_section1_subtext = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-description') {
                $homepage_footer_section1_text = $value['field_default_text'];
            }
        }
        }
    @endphp
    @if($homepage_footer_section1['section_enable'] == 'on')
    <div class="container">
        @if($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif

        <div class="footer-top">
            <div class=" footer-subscribe-col">
                <div class="footer-top-row">
                    <div class="footer-subscribe">
                        <h3>{!! $homepage_footer_section1_title !!}</h3>
                    </div>
                    <p>{{$homepage_footer_section1_subtext}}</p>
                    <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                        @csrf
                        <div class="input-box">
                            <input type="email" name="email" placeholder="TYPE YOUR EMAIL ADDRESS...">
                            <button>
                               {{ __('SUBSCRIBE')}}
                            </button>
                         </div>
                        {{-- <div class="checkbox-custom"> --}}
                            {{-- <input type="checkbox" class="" id="FotterCheckbox"> --}}
                            <label for="FotterCheckbox">{{$homepage_footer_section1_text}}</label>
                        {{-- </div> --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-center footer-row">
            <div class="footer-col footer-link footer-link-1">
                @php
                    $homepage_footer = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer != '')
                    {
                        $home_footer = $theme_json[$homepage_footer];
                        $section_enable = $home_footer['section_enable'];
                        foreach ($home_footer['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                $footer_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer_checkbox = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer_checkbox == 'on')
                <div class="footer-widget">
                    <h4>{{$footer_text}}</h4>
                    @php
                        $homepage_footer_key3 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                        }
                    @endphp
                    <ul>
                        @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                            {

                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                }
                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                    $homepage_footer_section3_url = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text'){
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                    }
                                }
                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link'){
                                        $homepage_footer_section3_url = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                    }
                                }
                            }
                        @endphp
                        <li><a href="{{$homepage_footer_section3_url}}">{{$homepage_footer_section3_sub_title}}</a></li>
                        @endfor
                    </ul>
                </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-2">
                @php
                    $homepage_footer = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer != '')
                    {
                        $home_footer = $theme_json[$homepage_footer];
                        $section_enable = $home_footer['section_enable'];
                        foreach ($home_footer['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                $footer_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer_checkbox = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer_checkbox == 'on')
                <div class="footer-widget">
                    <h4>{{$footer_text}}</h4>
                    @php
                        $homepage_footer_key3 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                        }
                    @endphp
                    <ul>
                        @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                            {

                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text') {
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                }
                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link') {
                                    $homepage_footer_section3_url = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text'){
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                    }
                                }
                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link'){
                                        $homepage_footer_section3_url = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                    }
                                }
                            }
                        @endphp
                        <li><a href="{{$homepage_footer_section3_url}}">{{$homepage_footer_section3_sub_title}}</a></li>
                        @endfor
                    </ul>
                </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-3">
                <div class="footer-widget">
                    @php
                        $homepage_footer = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer != '')
                        {
                            $home_footer = $theme_json[$homepage_footer];
                            $section_enable = $home_footer['section_enable'];
                            foreach ($home_footer['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-footer-title-text') {
                                    $footer_text = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-footer-label') {
                                    $home_footer_checkbox= $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($home_footer_checkbox == 'on')
                    <h4>{{$footer_text}}</h4>
                    @php
                        $homepage_footer_key3 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                        }
                    @endphp
                    <ul class="footer-list-social" role="list">
                        @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                            {

                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                }
                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                    $homepage_footer_section3_url = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];

                                    }
                                }
                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                        $homepage_footer_section3_url = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                    }
                                }
                            }
                        @endphp
                        <li>
                            <a href="{{$homepage_footer_section3_url}}" target="_blank">
                                <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="" style="margin-bottom: inherit;">
                            </a>
                        </li>
                        @endfor
                    </ul>
                    @endif
                </div>
            </div>
            @php
                $homepage_header_1_key = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-label-text') {
                            $footer_title_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-contact') {
                            $footer_contact = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-copyright-text') {
                            $footer_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="footer-call">
                <span class="call-text">{{$footer_title_text}}</span>
                <a href="tel:+48 222-512-234" target="_blank" title="call">
                   <span class="call-text">{{$footer_contact}}</span>
                </a>
             </div>
        </div>
        <div class="footer-bottom ">
            <div class="footer-copyright">
                <p class="text-center">{{$footer_text}}</p>
                <div class="footer-menu">
                    <ul class="footer-links">
                        @foreach ($pages as $page)
                        @if($page->page_status == "custom_page")
                            <li class="menu-lnk"><a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                        @else

                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
</footer>
<!--footer end here-->
<div class="overlay"></div>

<!-- Mobile menu start here -->
<!-- Mobile menu start here -->
<div class="mobile-menu-wrapper">
    <div class="menu-close-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
            <path fill="#24272a"
                d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
        </svg>
    </div>
    <div class="mobile-menu-bar">
        <ul>
            <li class="mobile-item has-children">
                <a href="javascript:void()" class="acnav-label">
                    {{ __('ACCESSORIES')}}
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
                                <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="mobile-item has-children">
                <a href="{{route('page.product-list',$slug)}}" class="">
                    {{ __('Collection') }}
                </a>
            </li>

            <li class="mobile-item has-children">
                <a href="#" class="acnav-label">
                    {{ __('Pages') }}
                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                        viewBox="0 0 20 11">
                        <path fill="#24272a"
                            d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                        viewBox="0 0 20 18">
                        <path fill="#24272a"
                            d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                    </svg>
                </a>
                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            @foreach ($pages as $page)
                            <li>
                                <a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a>
                            </li>
                            @endforeach
                            <li><a href="{{route('page.faq',$slug)}}"> {{ __('FAQs')}} </a></li>
                            <li><a href="{{route('page.blog',$slug)}}"> {{ __('Blog')}} </a></li>
                            <li><a href="{{route('page.product-list',$slug)}}"> {{ __('Collection')}} </a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="mobile-item">
                <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact Us') }}</a>
            </li>
        </ul>
    </div>
</div>
<!-- Mobile menu end here -->
<!-- Mobile menu end here -->
<!--cart popup start here-->
<div class="cartDrawer cartajaxDrawer">

</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
