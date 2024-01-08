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

 <!-- footer start  -->
 <footer class="site-footer">
    <div class="container">
        @if($whatsapp_setting_enabled)
        <div class="floating-wpp"></div>
        @endif
        <div class="footer-row">
            @php
                $homepage_subscribe = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_subscribe != '')
                {
                    $home_subscribe = $theme_json[$homepage_subscribe];
                    $section_enable = $home_subscribe['section_enable'];
                    foreach ($home_subscribe['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-newsletter-label-text') {
                            $home_subscribe_label= $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-title-text') {
                            $home_subscribe_text= $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                            $home_subscribe_sub_text= $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-newsletter-description') {
                            $home_subscribe_description = $value['field_default_text'];
                        }
                    }
                }
                $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
                $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;
            @endphp
            @if($home_subscribe['section_enable'] == 'on')
                <div class="footer-col footer-subscribe-col">
                    <div class="footer-widget">
                        <div class="footer-subscribe">
                            <div class="subtitle">{!! $home_subscribe_label !!}</div>
                            <h3>{!! $home_subscribe_text !!}</h3>
                        </div>
                        <p>{!! $home_subscribe_sub_text !!}</p>
                        <div class="footer-subscribe-form">
                            <form class="" action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                    <button class="btn-subscibe">{{__('Subscribe')}}</button>
                                </div>
                                    <label for="123">{!! $home_subscribe_description !!}</label>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="footer-col footer-link footer-link-1">
                @php
                    $homepage_footer1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer1 != '')
                    {
                        $home_footer1 = $theme_json[$homepage_footer1];
                        $section_enable = $home_footer1['section_enable'];
                        foreach ($home_footer1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                $home_footer_text= $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer_checkbox= $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer_checkbox == 'on')
                    <div class="footer-widget">
                        <h4> {!! $home_footer_text !!} </h4>
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
                                <li><a href="{{ $homepage_footer_section3_url }}">{!! $homepage_footer_section3_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-2">
                @php
                    $homepage_footer4 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));

                    if($homepage_footer4 != '')
                    {
                        $home_footer4 = $theme_json[$homepage_footer4];
                        foreach ($home_footer4['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                $home_footer4_text= $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer4_checkbox= $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer4_checkbox == 'on')
                <div class="footer-widget">
                    <h4> {!! $home_footer4_text !!} </h4>
                    @php
                        $homepage_footer_key5 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key5 != '') {
                            $homepage_footer_section5 = $theme_json[$homepage_footer_key5];
                        }
                    @endphp
                    <ul>
                        @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                            @php
                                foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                                {
                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-text') {
                                        $homepage_footer_section5_sub_title = $homepage_footer_section5_value['field_default_text'];
                                    }
                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-link') {
                                        $homepage_footer_section5_url= $homepage_footer_section5_value['field_default_text'];
                                    }

                                    if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                    {
                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-text'){
                                            $homepage_footer_section5_sub_title = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                        }
                                    }
                                    if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                    {
                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-label-link'){
                                            $homepage_footer_section5_url = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                        }
                                    }
                                }
                            @endphp
                            <li><a href="{{ $homepage_footer_section5_url }}">{!! $homepage_footer_section5_sub_title !!}</a></li>
                        @endfor
                    </ul>
                </div>
                @endif
            </div>

            @php
                $homepage_footer4 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                if($homepage_footer4 != '')
                {
                    $home_footer4 = $theme_json[$homepage_footer4];
                    $section_enable4 = $home_footer4['section_enable'];
                    foreach ($home_footer4['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-title-text') {
                            $home_footer_title4 = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-enable') {
                            $home_footer_enable4 = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($home_footer_enable4 == 'on')
                <div class="footer-col footer-link footer-link-3">
                    <div class="footer-widget">
                        <h4> {!! $home_footer_title4 !!} </h4>
                        @php
                            $homepage_footer_key5 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_key5 != '') {
                                $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                            }
                        @endphp
                        <ul class="footer-list-social" role="list">
                            @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                                    {
                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon') {
                                            $homepage_footer_section5_icon = $homepage_footer_section5_value['field_default_text'];
                                        }
                                        if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                            $homepage_footer_section5_social_link = $homepage_footer_section5_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                        {
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon'){
                                                $homepage_footer_section5_icon = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                                $homepage_footer_section5_social_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{{$homepage_footer_section5_social_link}}">
                                        <img src="{{get_file($homepage_footer_section5_icon , APP_THEME())}}" class="footer-icon" alt="youtube">
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</footer>
 <!-- footer end  -->
 <div class="overlay cart-overlay"></div>
    <div class="cartDrawer cartajaxDrawer">
    </div>

    <div class="overlay wish-overlay"></div>
    <div class="wishDrawer wishajaxDrawer">
    </div>
</body>

</html>
