

<!--footer start here-->
@php
    $theme_json = $homepage_json;
    $homepage_header_1_key = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
    if($homepage_header_1_key != '' ) {
        $homepage_header_1 = $theme_json[$homepage_header_1_key];
        foreach ($homepage_header_1['inner-list'] as $key => $value) {

            if($value['field_slug'] == 'homepage-newsletter-title-text') {
                $news_text = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                $news_sub_text = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-newsletter-description') {
                $news_desc = $value['field_default_text'];
            }
        }
    }

    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;

@endphp
@if($homepage_header_1['section_enable'] == 'on')
    <footer class="site-footer">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/footer-ring-right.png')}}" class="footer-ring-1" alt="image">
        <img src="{{asset('themes/'.APP_THEME().'/assets/images/design-circle-5.png')}}" class="design-circle-5" alt="image">
        <div class="container">
            @if($whatsapp_setting_enabled)
                <div class="floating-wpp"></div>
            @endif
            <div class="footer-row">
                <div class="footer-col footer-subscribe-col">
                    <div class="footer-widget">
                        <h3>{!! $news_text !!}</h3>
                        <p>{{$news_sub_text}}</p>
                        <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                            @csrf
                            <div class="form-inputs">
                                <input type="search" placeholder="Type your address email..." class="form-control border-radius-50" name="email">
                                <button type="submit" class="btn">
                                    {{ __('Subscribe')}}
                                </button>
                            </div><br>
                            <label for="subscribechecked">
                                {{$news_desc}}
                            </label>
                        </form>
                    </div>
                </div>
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
                                    $home_footer_checkbox= $value['field_default_text'];
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
                <div class="footer-col social-icons">
                    @php
                        $homepage_footer = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer != '')
                        {
                            $home_footer = $theme_json[$homepage_footer];
                            $section_enable = $home_footer['section_enable'];
                            foreach ($home_footer['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-footer-label-text') {
                                    $footer_text = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-footer-enable') {
                                    $home_footer_checkbox= $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($home_footer_checkbox == 'on')
                        <div class="footer-widget">
                            <h4>{{$footer_text}}</h4>
                            <ul class=" d-flex align-items-center">
                                @php
                                    $homepage_footer_key3 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key3 != '') {
                                        $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                    }
                                @endphp
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
                                        <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="">
                                    </a>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    @php
                        $homepage_header_1_key = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_header_1_key != '' ) {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-footer-copyrgt-text') {
                                    $footer = $value['field_default_text'];
                                }
                            }
                        }
                        @endphp
                    @if($homepage_header_1['section_enable'] == 'on')
                    <div class="col-12 col-md-6">
                        <p>{{$footer}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>
    <!--footer end here-->
@endif
    <div class="overlay"></div>

    <!--cart popup start here-->
    <div class="cartDrawer cartajaxDrawer">
    </div>

    <div class="overlay wish-overlay"></div>
    <div class="wishDrawer wishajaxDrawer">
    </div>

</body>

</html>
