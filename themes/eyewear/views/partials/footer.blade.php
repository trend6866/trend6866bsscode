@php
    $theme_json = $homepage_json;
    if(Auth::user())
    {
        $carts = App\Models\Cart::where('user_id',Auth::user()->id)->where('theme_id', APP_THEME())->get();

        $cart_product_count = $carts->count();
    }
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');

    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;
@endphp

@php
    $homepage_logo_key = array_search('homepage-footer-9', array_column($theme_json,'unique_section_slug'));
    if($homepage_logo_key != ''){
        $homepage_main_logo = $theme_json[$homepage_logo_key];
        $section_enable = $homepage_main_logo['section_enable'];
    }
@endphp
    @if($homepage_main_logo['section_enable'] == 'on')
        <footer class="site-footer">
            <div class="container">
                @if($whatsapp_setting_enabled)
                    <div class="floating-wpp"></div>
                @endif
                @php
                    $homepage_logo_key = array_search('homepage-footer-9', array_column($theme_json,'unique_section_slug'));
                    if($homepage_logo_key != ''){
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                    @php
                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-9-description')
                        {
                            $footer_description = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $footer_description = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-9-checkbox')
                        {
                            $footer_checkbox = $homepage_main_logo_value['field_default_text'];
                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                $footer_checkbox = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                            }
                        }
                    @endphp
                @endforeach
                <div class="footer-row">
                    @if($footer_checkbox == 'on')
                        <div class="footer-col footer-link footer-link-1">
                            <div class="footer-widget">
                                <p>{{ $footer_description }}</p>
                                <ul class="footer-list-social" role="list">
                                    @php
                                        $homepage_text = '';
                                        $homepage_logo_key = array_search('home-social-links-2', array_column($theme_json,'unique_section_slug'));
                                        $section_enable = 'on';
                                        if($homepage_logo_key != ''){
                                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                                            $section_enable = $homepage_main_logo['section_enable'];
                                        }
                                    @endphp
                                    @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                            @php
                                                if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-contact-image')
                                                {
                                                    $social_icon = $homepage_main_logo_value['field_default_text'];
                                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                        $social_icon = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                    }
                                                }
                                                if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-url')
                                                {
                                                    $social_link = $homepage_main_logo_value['field_default_text'];
                                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                        $social_link = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                        <li>
                                            <a href="{{ $social_link }}" target="_blank">
                                                <img src="{{ get_file($social_icon , APP_THEME()) }}" alt="twitter">
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    @endif

                    @php
                        $homepage_logo_key = array_search('homepage-footer-1', array_column($theme_json,'unique_section_slug'));
                        if($homepage_logo_key != ''){
                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                            $section_enable = $homepage_main_logo['section_enable'];
                        }
                    @endphp
                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                        @php
                            if($homepage_main_logo_value['field_slug'] == 'homepage-footer-title')
                            {
                                $footer_title = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $footer_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-footer-1-checkbox')
                            {
                                $footer_chechbox = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $footer_chechbox = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                        @endphp
                    @endforeach
                        @if($footer_chechbox == 'on')
                            <div class="footer-col footer-link footer-link-2">
                                <div class="footer-widget">
                                    <h2>{{ $footer_title }}</h2>
                                    @php
                                        $homepage_text = '';
                                        $homepage_logo_key = array_search('homepage-footer-2',array_column($theme_json,'unique_section_slug'));
                                        $section_enable = 'on';
                                        if($homepage_logo_key != '')
                                        {
                                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                                            $section_enable = $homepage_main_logo['section_enable'];
                                        }
                                        @endphp
                                    <ul>
                                        @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                                @php
                                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-2-sub-title')
                                                    {
                                                        $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                            $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                        }
                                                    }
                                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-2-link-url')
                                                    {
                                                        $footer_link_url = $homepage_main_logo_value['field_default_text'];
                                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                            $footer_link_url = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                        }
                                                    }
                                                @endphp
                                            @endforeach
                                            <li><a href="{{ $footer_link_url }}">{{ $footer_sub_text }}</a></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endif

                    <div class="footer-col footer-link footer-link-3">
                        <div class="footer-widget">
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-3',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                @php
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-3-sub-title')
                                    {
                                        $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-3-checkbox')
                                    {
                                        $footer_checkbox = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_checkbox = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                @endphp
                            @endforeach
                            @if($footer_checkbox == 'on')
                            <h2>{{ $footer_sub_text }}</h2>
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-5',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            <ul>
                            @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-5-sub-title')
                                        {
                                            $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-5-link-url')
                                        {
                                            $footer_link_url = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_link_url = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <li><a href="{{ $footer_link_url }}">{{ $footer_sub_text }}</a></li>
                                @endfor
                            </ul>
                            @endif
                        </div>
                    </div>


                    <div class="footer-col footer-link footer-link-4">
                        <div class="footer-widget">
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-4',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                @php
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-4-title')
                                    {
                                        $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-4-checkbox')
                                    {
                                        $footer_checkbox = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_checkbox = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                @endphp
                            @endforeach
                            @if($footer_checkbox == 'on')
                            <h2>{{$footer_sub_text}}</h2>
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-6',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            <ul>
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-6-sub-title')
                                        {
                                            $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-6-link-url')
                                        {
                                            $footer_link_url = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_link_url = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <li><a href="{{ $footer_link_url }}">{{ $footer_sub_text }}</a></li>
                                @endfor
                            </ul>
                            @endif
                        </div>
                    </div>

                    <div class="footer-col footer-link footer-link-4">
                        <div class="footer-widget">
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-7',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                @php
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-7-title')
                                    {
                                        $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-footer-7-checkbox')
                                    {
                                        $footer_checkbox = $homepage_main_logo_value['field_default_text'];
                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                            $footer_checkbox = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                        }
                                    }
                                @endphp
                            @endforeach
                            @if($footer_checkbox == 'on')
                            <h2>{{$footer_sub_text}}</h2>
                            @php
                                $homepage_text = '';
                                $homepage_logo_key = array_search('homepage-footer-8',array_column($theme_json,'unique_section_slug'));
                                $section_enable = 'on';
                                if($homepage_logo_key != '')
                                {
                                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                                    $section_enable = $homepage_main_logo['section_enable'];
                                }
                            @endphp
                            <ul>
                                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-8-sub-title')
                                        {
                                            $footer_sub_text = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                        if($homepage_main_logo_value['field_slug'] == 'homepage-footer-8-link-url')
                                        {
                                            $footer_link_url = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $footer_link_url = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <li><a href="{{ $footer_link_url }}">{{ $footer_sub_text }}</a></li>
                                @endfor
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    @endif

    <!--footer end here-->
    <div class="overlay"></div>
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
                    <a href="#" class="acnav-label">
                        {{ __('Sunglasses')}}
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
                                @foreach ($MainCategoryList as $category)
                                    <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="mobile-item has-children">
                    <a href="{{route('page.product-list',$slug)}}"> {{ __('Shop All') }} </a>
                </li>

                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        {{ __('Pages')}}
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
                                <li><a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                                @endforeach
                                <li><a href="{{route('page.faq',$slug)}}">{{ __('FAQs')}}</a></li>
                                <li><a href="{{route('page.blog',$slug)}}">{{ __('Blog')}}</a></li>
                                <li><a href="{{route('page.product-list',$slug)}}">{{ __('Collection')}}</a></li>
                            </ul>
                        </li>

                    </ul>

                </li>
                <li class="mobile-item">
                    <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Mobile menu end here -->
    <!--cart popup start here-->
    <div class="cartDrawer cartajaxDrawer">

    </div>

    <!--cart popup ends here-->
