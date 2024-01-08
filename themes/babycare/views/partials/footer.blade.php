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

<!--footer start here-->
    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
                @if($whatsapp_setting_enabled)
                    <div class="floating-wpp"></div>
                @endif
                <div class="footer-row">
                    @php
                        $homepage_footer1_img = $homepage_footer1_text = '';

                        $homepage_footer1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer1 != '' ){
                            $homepage_footer1_value = $theme_json[$homepage_footer1];
                            // dd($homepage_footer1_value);

                            foreach ($homepage_footer1_value['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-footer-footer-image') {
                                    $homepage_footer1_img = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-footer-footer-text') {
                                    $homepage_footer1_text = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($homepage_footer1_value['section_enable'] == 'on')
                        <div class="footer-col footer-link footer-link-1">
                            <div class="footer-widget">
                                <div class="logo-col">
                                    <img src="{{get_file($homepage_footer1_img)}}">
                                </div>
                                <p>{!! $homepage_footer1_text !!}</p>
                                @php
                                    $homepage_footer_10_icon = $homepage_footer_10_link = '';

                                    $homepage_footer_10 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_10 != '') {
                                        $homepage_footer_section_10 = $theme_json[$homepage_footer_10];
                                    }
                                @endphp
                                <ul class="footer-list-social" role="list">
                                    @for($i=0 ; $i < $homepage_footer_section_10['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer_section_10['inner-list'] as $homepage_footer_section_10_value)
                                            {
                                                if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon') {
                                                $homepage_footer_10_icon = $homepage_footer_section_10_value['field_default_text'];
                                                }
                                                if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link') {
                                                $homepage_footer_10_link = $homepage_footer_section_10_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                                {
                                                    if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon'){
                                                    $homepage_footer_10_icon = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i]['field_prev_text'];
                                                }
                                                }
                                                if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                                {
                                                    if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link'){
                                                    $homepage_footer_10_link = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i];
                                                }
                                                }
                                            }
                                        @endphp
                                        <li>
                                            <a href="{!! $homepage_footer_10_link !!}" target="_blank">
                                                <img src="{{get_file('/' . $homepage_footer_10_icon)}}" alt="">
                                                {{-- <svg width="8" height="7" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.50015 1.19968C1.99665 1.11278 2.76171 1.03252 3.89246 1.03252C5.02321 1.03252 5.78827 1.11278 6.28476 1.19968C6.62039 1.25842 6.85877 1.58973 6.85877 2.06374V5.00695C6.85877 5.48095 6.62039 5.81226 6.28476 5.871C5.78827 5.9579 5.02321 6.03817 3.89246 6.03817C2.76171 6.03817 1.99665 5.9579 1.50015 5.871C1.16453 5.81226 0.926148 5.48095 0.926148 5.00695V2.06374C0.926148 1.58973 1.16453 1.25842 1.50015 1.19968ZM3.89246 0.198242C2.73147 0.198242 1.92747 0.280581 1.38616 0.37532C0.61158 0.510886 0.18457 1.27374 0.18457 2.06374V5.00695C0.18457 5.79694 0.611581 6.5598 1.38616 6.69536C1.92747 6.7901 2.73147 6.87244 3.89246 6.87244C5.05345 6.87244 5.85745 6.7901 6.39876 6.69536C7.17334 6.5598 7.60035 5.79694 7.60035 5.00695V2.06374C7.60035 1.27374 7.17334 0.510886 6.39876 0.37532C5.85745 0.280581 5.05345 0.198242 3.89246 0.198242ZM3.34671 2.33329C3.46727 2.2607 3.61357 2.26865 3.72735 2.35399L4.83971 3.18826C4.94287 3.26563 5.00482 3.39587 5.00482 3.53534C5.00482 3.67481 4.94287 3.80506 4.83971 3.88242L3.72735 4.7167C3.61357 4.80203 3.46727 4.80999 3.34671 4.7374C3.22615 4.66481 3.15088 4.52346 3.15088 4.36962V2.70107C3.15088 2.54723 3.22615 2.40588 3.34671 2.33329Z">
                                                    </path>
                                                </svg>  --}}
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>

                        @php
                            $homepage_footer2_title = '';

                            $homepage_footer2 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer2 != '' ){
                                $homepage_footer2_value = $theme_json[$homepage_footer2];

                                foreach ($homepage_footer2_value['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'homepage-footer-title') {
                                        $homepage_footer2_title = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer2_enable = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp

                        @if($homepage_footer2_enable == 'on')
                            <div class="footer-col footer-link footer-link-2">
                                <div class="footer-widget">
                                    <h6>{!! $homepage_footer2_title !!}</h6>
                                    @php
                                        $homepage_footer3_title_label = '';

                                        $homepage_footer3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer3 != '') {
                                            $homepage_footer3_title = $theme_json[$homepage_footer3];
                                        }
                                    @endphp
                                    <ul>
                                        @for($i=0 ; $i < $homepage_footer3_title['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer3_title['inner-list'] as $homepage_footer3_title_value)
                                            {
                                                if($homepage_footer3_title_value['field_slug'] == 'homepage-footer-label') {
                                                $homepage_footer3_title_label = $homepage_footer3_title_value['field_default_text'];
                                                }
                                                if($homepage_footer3_title_value['field_slug'] == 'homepage-footer-footer-link') {
                                                $homepage_footer3_title_link = $homepage_footer3_title_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer3_title[$homepage_footer3_title_value['field_slug']]))
                                                {
                                                    if($homepage_footer3_title_value['field_slug'] == 'homepage-footer-label'){
                                                    $homepage_footer3_title_label = $homepage_footer3_title[$homepage_footer3_title_value['field_slug']][$i];
                                                    }
                                                    if($homepage_footer3_title_value['field_slug'] == 'homepage-footer-footer-link'){
                                                    $homepage_footer3_title_link = $homepage_footer3_title[$homepage_footer3_title_value['field_slug']][$i];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li><a href="{!! $homepage_footer3_title_link !!}">{!! $homepage_footer3_title_label !!}</a></li>

                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @php
                            $homepage_footer4_title = '';

                            $homepage_footer4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer4 != '' ){
                                $homepage_footer4_value = $theme_json[$homepage_footer4];
                                // dd($homepage_footer4_value);
                                foreach ($homepage_footer4_value['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'homepage-footer-title') {
                                        $homepage_footer4_title = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer4_enable = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp

                        @if($homepage_footer4_enable == 'on')
                            <div class="footer-col footer-link footer-link-3">
                                <div class="footer-widget">
                                    <h6>{!! $homepage_footer4_title !!}</h6>

                                    @php
                                        $homepage_footer5_title_label = '';

                                        $homepage_footer5 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer5 != '') {
                                            $homepage_footer5_title = $theme_json[$homepage_footer5];
                                        }
                                    @endphp

                                    <ul>
                                        @for($i=0 ; $i < $homepage_footer5_title['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer5_title['inner-list'] as $homepage_footer5_title_value)
                                            {
                                                if($homepage_footer5_title_value['field_slug'] == 'homepage-footer-label') {
                                                $homepage_footer5_title_label = $homepage_footer5_title_value['field_default_text'];
                                                }
                                                if($homepage_footer5_title_value['field_slug'] == 'homepage-footer-footer-link') {
                                                $homepage_footer5_title_link = $homepage_footer5_title_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer5_title[$homepage_footer5_title_value['field_slug']]))
                                                {
                                                    if($homepage_footer5_title_value['field_slug'] == 'homepage-footer-label'){
                                                    $homepage_footer5_title_label = $homepage_footer5_title[$homepage_footer5_title_value['field_slug']][$i];
                                                    }
                                                    if($homepage_footer5_title_value['field_slug'] == 'homepage-footer-footer-link'){
                                                    $homepage_footer5_title_link = $homepage_footer5_title[$homepage_footer5_title_value['field_slug']][$i];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li><a href="{!! $homepage_footer5_title_link !!}">{!! $homepage_footer5_title_label !!}</a></li>
                                        {{-- <li><a href="product-list.html">Categories</a></li>  --}}

                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @php
                            $homepage_footer6_title = '';

                            $homepage_footer6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer6 != '' ){
                                $homepage_footer6_value = $theme_json[$homepage_footer6];

                                foreach ($homepage_footer6_value['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'homepage-footer-title') {
                                        $homepage_footer6_title = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer6_enable = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp

                        @if($homepage_footer6_enable == 'on')
                            {{-- <div class="footer-col footer-link footer-link-4">
                                <div class="footer-widget">
                                    <h6>{!! $homepage_footer6_title !!}</h6>
                                    @php
                                        $homepage_footer7_title_label = '';

                                        $homepage_footer7 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer7 != '') {
                                            $homepage_footer7_title = $theme_json[$homepage_footer7];
                                        }
                                    @endphp
                                    <ul>
                                        @for($i=0 ; $i < $homepage_footer7_title['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer7_title['inner-list'] as $homepage_footer7_title_value)
                                            {
                                                if($homepage_footer7_title_value['field_slug'] == 'homepage-footer-label') {
                                                $homepage_footer7_title_label = $homepage_footer7_title_value['field_default_text'];
                                                }
                                                if($homepage_footer7_title_value['field_slug'] == 'homepage-footer-footer-link') {
                                                $homepage_footer7_title_link = $homepage_footer7_title_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer7_title[$homepage_footer7_title_value['field_slug']]))
                                                {
                                                    if($homepage_footer7_title_value['field_slug'] == 'homepage-footer-label'){
                                                    $homepage_footer7_title_label = $homepage_footer7_title[$homepage_footer7_title_value['field_slug']][$i];
                                                    }
                                                    if($homepage_footer7_title_value['field_slug'] == 'homepage-footer-footer-link'){
                                                    $homepage_footer7_title_link = $homepage_footer7_title[$homepage_footer7_title_value['field_slug']][$i];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li><a href="{!! $homepage_footer7_title_link !!}">{!! $homepage_footer7_title_label !!}</a></li>
                                        @endfor
                                    </ul>

                                </div>
                            </div> --}}
                        @endif

                        @php
                            $homepage_footer8_title = '';

                            $homepage_footer8 = array_search('homepage-footer-8', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer8 != '' ){
                                $homepage_footer8_value = $theme_json[$homepage_footer8];

                                foreach ($homepage_footer8_value['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'homepage-footer-title') {
                                        $homepage_footer8_title = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'homepage-footer-enable') {
                                        $homepage_footer8_enable = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp

                        @if($homepage_footer8_enable == 'on')
                            {{-- <div class="footer-col footer-link footer-link-5">
                                <div class="footer-widget">
                                    <h6>{!! $homepage_footer8_title !!}</h6>
                                    @php
                                        $homepage_footer9_title_label = '';

                                        $homepage_footer9 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer9 != '') {
                                            $homepage_footer9_title = $theme_json[$homepage_footer9];

                                        }
                                    @endphp
                                    <ul>
                                        @for($i=0 ; $i < $homepage_footer9_title['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer9_title['inner-list'] as $homepage_footer9_title_value)
                                            {
                                                if($homepage_footer9_title_value['field_slug'] == 'homepage-footer-label') {
                                                $homepage_footer9_title_label = $homepage_footer9_title_value['field_default_text'];
                                                }
                                                if($homepage_footer9_title_value['field_slug'] == 'homepage-footer-footer-link') {
                                                $homepage_footer9_title_link = $homepage_footer9_title_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer9_title[$homepage_footer9_title_value['field_slug']]))
                                                {
                                                    if($homepage_footer9_title_value['field_slug'] == 'homepage-footer-label'){
                                                    $homepage_footer9_title_label = $homepage_footer9_title[$homepage_footer9_title_value['field_slug']][$i];
                                                    }
                                                    if($homepage_footer9_title_value['field_slug'] == 'homepage-footer-footer-link'){
                                                    $homepage_footer9_title_link = $homepage_footer9_title[$homepage_footer9_title_value['field_slug']][$i];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li><a href="{!! $homepage_footer9_title_link !!}">{!! $homepage_footer9_title_label !!}</a></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div> --}}
                        @endif
                        <div class="footer-col footer-subscribe-col">
                            <div class="footer-widget">
                                <h4>Subscribe newsletter and get -20% off</h4>
                                <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                    @csrf
                                    <div class="input-box">
                                    <input type="email" placeholder="Type your address email......" name="email">
                                    <button class="btn-subscibe">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6883 2.12059C14.0686 1.54545 15.4534 2.93023 14.8782 4.31056L10.9102 13.8338C10.1342 15.6962 7.40464 15.3814 7.07295 13.3912L6.5779 10.4209L3.60764 9.92589C1.61746 9.5942 1.30266 6.8646 3.16509 6.08859L12.6883 2.12059ZM13.6416 3.79527C13.7566 3.51921 13.4796 3.24225 13.2036 3.35728L3.68037 7.32528C3.05956 7.58395 3.1645 8.49381 3.82789 8.60438L6.79816 9.09942C7.36282 9.19353 7.80531 9.63602 7.89942 10.2007L8.39446 13.171C8.50503 13.8343 9.41489 13.9393 9.67356 13.3185L13.6416 3.79527Z" fill="#12131A"></path>
                                        </svg>
                                    </button>
                                </div>
                           
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @endif
                   
            </div>

        </div>
    </footer>
<!--footer end here-->
<!-- Mobile menu start here -->
    <div class="mobile-menu-wrapper">
        <div class="menu-close-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                <path fill="#24272a" d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z"></path>
            </svg>
        </div>
        <div class="mobile-menu-bar">
            <ul>
                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        {{ __('Shop All') }}
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
                                <li>
                                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="mobile-item has-children">
                    <a href="{{route('page.product-list',$slug)}}" class="acnav-label">
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
<!--serch popup ends here-->
    <div class="search-popup">
        <div class="close-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                <path d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z" fill="white"></path>
            </svg>
        </div>
        <div class="search-form-wrapper">
            <form>
                <div class="form-inputs">
                    <input type="search" placeholder="Search Product..." class="form-control search_input" list="products" name="search_product" id="product">
                    <datalist id="products">
                        {{-- @foreach ($search_products as $pro_id => $pros)
                            <option value="{{$pros}}"></option>
                        @endforeach --}}
                    </datalist>
                    <button type="submit" class="btn search_product_globaly">
                        <svg>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
<!--serch popup ends here-->

<!--cart popup start here-->
    <div class="overlay cart-overlay"></div>
    <div class="cartDrawer cartajaxDrawer">

    </div>
<!--cart popup ends here-->

@push('page-script')

<script>
    $(document).ready(function () {
        var responseData;
        $('.search_product_globaly').on('click', function (e) {
            e.preventDefault();
            search_data();
         });

        $(".search_input").on('input', function (e) {
            e.preventDefault();
            search_data();
        });

        function search_data(){
            var product = $('.search_input').val();
            var data = {
                product: product,
            }
            $.ajax({
                url: '{{ route('search.product', $slug) }}',
                context: this,
                data: data,
                success: function (response) {
                    responseData = response;
                    $('#products').empty();

                    $.each(response, function (key, value) {
                        $('#products').append('<option value="' + value.name + '">');
                    });
                }
            });
        }
        $('.search_input').change(function () {
            var selectedProduct = $(this).val();

            // Find the selected product's URL in the responseData array
            var productUrl = null;
            $.each(responseData, function (key, value) {
                if (value.name === selectedProduct) {
                    productUrl = value.url;
                    return false; // Exit the loop once found
                }
            });

            // Redirect to the product page when a suggestion is selected
            if (productUrl) {
                window.location.href = productUrl;
            }
        });
    });
</script>

@endpush
