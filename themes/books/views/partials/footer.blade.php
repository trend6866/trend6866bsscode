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
    <div class="container">
        @if($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif
        @php
        $homepage_subscribe_title = '';

        $homepage_subscribe = array_search('subscribe-section', array_column($theme_json, 'unique_section_slug'));
        if($homepage_subscribe != '' ){
            $homepage_subscribe_value = $theme_json[$homepage_subscribe];

            foreach ($homepage_subscribe_value['inner-list'] as $key => $value) {

                if($value['field_slug'] == 'subscribe-section-title') {
                    $homepage_subscribe_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'subscribe-section-sub-text') {
                    $homepage_subscribe_subtext = $value['field_default_text'];
                }
                if($value['field_slug'] == 'subscribe-section-button') {
                    $homepage_subscribe_btn1 = $value['field_default_text'];
                }
                if($value['field_slug'] == 'subscribe-section-subscribe-text') {
                    $homepage_subscribe_subscribe_text = $value['field_default_text'];
                }


                //Dynamic
                if(!empty($homepage_subscribe_value[$value['field_slug']]))
                {
                    if($value['field_slug'] == 'subscribe-section-title'){
                        $homepage_subscribe_title = $homepage_subscribe_value[$value['field_slug']][$i];
                    }
                    if($value['field_slug'] == 'subscribe-section-sub-text'){
                        $homepage_subscribe_subtext = $homepage_subscribe_value[$value['field_slug']][$i];
                    }
                    if($value['field_slug'] == 'subscribe-section-button'){
                        $homepage_subscribe_btn1 = $homepage_subscribe_value[$value['field_slug']][$i];
                    }
                    if($value['field_slug'] == 'subscribe-section-subscribe-text') {
                        $homepage_subscribe_subscribe_text = $value['field_default_text'][$i];
                    }
                }
            }
        }
    @endphp

        <div class="footer-row">
            <div class="footer-col footer-subscribe-col">
                <div class="footer-widget">
                    <div class="footer-subscribe">
                        <h3>
                        {!! $homepage_subscribe_title !!} </h3>
                    </div>
                    <p>{{ $homepage_subscribe_subtext }}</p>
                    <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                        @csrf
                            <div class="input-wrapper">
                                <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                <button type="submit" class="btn-subscibe">{{ $homepage_subscribe_btn1 }}
                                </button>
                            </div>
                            <div class="">
                                {{-- <input type="checkbox" class="" id="PlaceCheckbox"> --}}
                                <label for="">{{ $homepage_subscribe_subscribe_text }}</label>
                            </div>
                    </form>

                    {{-- <div class="footer-subscribe-form">
                        <div class="input-wrapper">
                            <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS...">
                            <button class="btn-subscibe"></button>
                        </div>
                        <div class="checkbox-custom">
                            <input type="checkbox" id="123">
                            <label for="123">{{ $homepage_subscribe_subscribe_text }}</label>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="footer-col footer-link footer-link-1">
                @php
                    $homepage_footer_section_title =  '';

                    $homepage_footer_key = array_search('home-footer-subscribe-2', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key != '') {
                        $homepage_footer_section = $theme_json[$homepage_footer_key];
                        foreach ($homepage_footer_section['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-footer-subscribe-title') {
                            $homepage_footer_section_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-footer-subscribe-enable') {
                            $homepage_footer_section_enable = $value['field_default_text'];

                            }
                        }
                    }
                @endphp
                @if($homepage_footer_section_enable == 'on')
                    <div class="footer-widget">
                        {!! $homepage_footer_section_title !!}
                        <ul>
                        @php
                                $homepage_footer_section1_sub_title = '';

                                $homepage_footer_key1 = array_search('home-footer-subscribe-3', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key1 != '') {
                                    $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                }

                            @endphp
                            @for($i=0 ; $i < $homepage_footer_section1['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section1['inner-list'] as $homepage_footer_section1_value)
                                    {

                                        if($homepage_footer_section1_value['field_slug'] == 'home-footer-subscribe-label') {
                                        $homepage_footer_section1_sub_title = $homepage_footer_section1_value['field_default_text'];
                                        }
                                        if($homepage_footer_section1_value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                        $homepage_footer_section1_link = $homepage_footer_section1_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section1[$homepage_footer_section1_value['field_slug']]))
                                        {
                                            if($homepage_footer_section1_value['field_slug'] == 'home-footer-subscribe-label'){
                                            $homepage_footer_section1_sub_title = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                            if($homepage_footer_section1_value['field_slug'] == 'home-footer-subscribe-footer-link'){
                                            $homepage_footer_section1_link = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                    <li><a href="{{$homepage_footer_section1_link}}">{!! $homepage_footer_section1_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-2">
                @php
                    $homepage_footer_section2_title =  '';

                    $homepage_footer2_key = array_search('home-footer-subscribe-4', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer2_key != '') {
                        $homepage_footer2_section = $theme_json[$homepage_footer_key];
                        foreach ($homepage_footer2_section['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-footer-subscribe-title') {
                            $homepage_footer_section2_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-footer-subscribe-enable') {
                            $homepage_footer_section2_enable = $value['field_default_text'];

                            }
                        }
                    }
                @endphp
                @if($homepage_footer_section2_enable == 'on')
                    <div class="footer-widget">
                        {!! $homepage_footer_section2_title !!}
                        <ul>
                            @php
                                $homepage_footer_section2_sub_title = '';

                                $homepage_footer_key2 = array_search('home-footer-subscribe-5', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key2 != '') {
                                    $homepage_footer_section2 = $theme_json[$homepage_footer_key2];

                                }

                            @endphp
                            @for($i=0 ; $i < $homepage_footer_section2['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section2['inner-list'] as $homepage_footer_section2_value)
                                    {

                                        if($homepage_footer_section2_value['field_slug'] == 'home-footer-subscribe-label') {
                                        $homepage_footer_section2_sub_title = $homepage_footer_section2_value['field_default_text'];
                                        }
                                        if($homepage_footer_section2_value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                        $homepage_footer_section2_link = $homepage_footer_section2_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section2[$homepage_footer_section2_value['field_slug']]))
                                        {
                                            if($homepage_footer_section2_value['field_slug'] == 'home-footer-subscribe-label'){
                                            $homepage_footer_section2_sub_title = $homepage_footer_section2[$homepage_footer_section2_value['field_slug']][$i];
                                            }
                                            if($homepage_footer_section2_value['field_slug'] == 'home-footer-subscribe-footer-link'){
                                            $homepage_footer_section2_link = $homepage_footer_section2[$homepage_footer_section2_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                    <li><a href="{{$homepage_footer_section2_link}}">{!! $homepage_footer_section2_sub_title !!}</a></li>
                            @endfor
                        </ul>
                    </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-3">
                @php
                    $homepage_footer_section3_title =  '';

                    $homepage_footer3_key = array_search('home-footer-subscribe-6', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer3_key != '') {
                        $homepage_footer3_section = $theme_json[$homepage_footer_key];
                        foreach ($homepage_footer3_section['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-footer-subscribe-title') {
                            $homepage_footer_section3_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-footer-subscribe-enable') {
                            $homepage_footer_section3_enable = $value['field_default_text'];

                            }
                        }
                    }
                @endphp
                @if ($homepage_footer_section3_enable == 'on')
                    <div class="footer-widget">
                        {!! $homepage_footer_section3_title !!}
                        @php
                            $homepage_footer_section3_sub_title = '';

                            $homepage_footer_key3 = array_search('home-footer-subscribe-7', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_key3 != '') {
                                $homepage_footer_section3 = $theme_json[$homepage_footer_key3];

                            }

                        @endphp
                        <ul class="footer-list-social" role="list">
                            @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                    {

                                        if($homepage_footer_section3_value['field_slug'] == 'home-footer-subscribe-social-icon') {
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];

                                        }
                                        if($homepage_footer_section3_value['field_slug'] == 'home-footer-subscribe-link') {
                                        $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'home-footer-subscribe-social-icon'){
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_footer_section3_value['field_slug'] == 'home-footer-subscribe-link'){
                                            $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp

                                    <li><a href="{{$homepage_footer_section3_link}}" target="_blank">
                                        <img src="{{get_file($homepage_footer_section3_sub_title , APP_THEME())}}" alt=""></a></li>
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
<div class="overlay cart-overlay"></div>
    <div class="cartDrawer cartajaxDrawer">
</div>
<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
