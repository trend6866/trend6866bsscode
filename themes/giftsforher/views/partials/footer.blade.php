@php
    $theme_json = $homepage_json;
    if(Auth::user()){
        $carts = App\Models\Cart::where('user_id',Auth::user()->id)->where('theme_id', APP_THEME())->get();
        $cart_product_count = $carts->count();
    }
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');

@endphp
@php
    $homepage_footer = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
    if($homepage_footer != '')
    {
        $home_footer = $theme_json[$homepage_footer];
        $section_enable = $home_footer['section_enable'];
        foreach ($home_footer['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-footer-title-text') {
                $home_footer_title = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-footer-enable') {
                $home_footer_enable = $value['field_default_text'];
            }
        }
    }
    $whatsapp_setting_enabled =\App\Models\Utility::GetValueByName('whatsapp_setting_enabled',$theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;
@endphp
<!--footer start here-->
<footer class="site-footer">
    @if($home_footer['section_enable'] == 'on')
        <div class="container">
            @if($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
            @endif
            <div class="footer-row">
                @if($home_footer_enable == 'on')
                    <div class="footer-col footer-link footer-link-1">
                        <div class="footer-widget">
                            <h4> {!! $home_footer_title !!} </h4>
                            @php
                                $homepage_footer_key1 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key1 != '') {
                                    $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                                }
                            @endphp
                            <ul>
                                @for($i=0 ; $i < $homepage_footer_section1['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section1['inner-list'] as $homepage_footer_section1_value)
                                    {
                                        if($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-text') {
                                            $homepage_footer_section1_sub_title = $homepage_footer_section1_value['field_default_text'];
                                        }
                                        if($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-link') {
                                            $homepage_footer_section1_social_link = $homepage_footer_section1_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section1[$homepage_footer_section1_value['field_slug']]))
                                        {
                                            if($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-text'){
                                                $homepage_footer_section1_sub_title = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                            if($homepage_footer_section1_value['field_slug'] == 'homepage-footer-label-link'){
                                                $homepage_footer_section1_social_link = $homepage_footer_section1[$homepage_footer_section1_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{{$homepage_footer_section1_social_link}}">{!! $homepage_footer_section1_sub_title !!}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endif
                @php
                    $homepage_footer2 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer2 != '')
                    {
                        $home_footer2 = $theme_json[$homepage_footer2];
                        $section_enable2 = $home_footer2['section_enable'];
                        foreach ($home_footer2['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                $home_footer_title2 = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer_enable2 = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer_enable2 == 'on')
                    <div class="footer-col footer-link footer-link-2">
                        <div class="footer-widget">
                            <h4> {!! $home_footer_title2 !!} </h4>
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
                                            $homepage_footer_section3_social_link = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-text'){
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                            }
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-label-link'){
                                                $homepage_footer_section3_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li><a href="{{$homepage_footer_section3_social_link}}">{!! $homepage_footer_section3_sub_title !!}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endif
                @php
                    $homepage_footer4 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer4 != '')
                    {
                        $home_footer4 = $theme_json[$homepage_footer4];
                        $section_enable4 = $home_footer4['section_enable'];
                        foreach ($home_footer4['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-label-text') {
                                $home_footer_title4 = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-enable') {
                                $home_footer_enable4 = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_footer_enable4 == 'on')
                    <div class="footer-col footer-link-3">
                        <div class="footer-widget footer-social-links">
                            <h4>{!! $home_footer_title4 !!}</h4>
                            @php
                                $homepage_footer_key5 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key5 != '') {
                                    $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                                }
                            @endphp
                            <ul>
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
                                        <img src="{{get_file($homepage_footer_section5_icon , APP_THEME())}}" alt="youtube">
                                    </a>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endif
                @php
                    $homepage_newsletter = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                    $section_enable = 'on';
                    if($homepage_newsletter != '')
                    {
                        $home_newsletter = $theme_json[$homepage_newsletter];
                        $section_enable = $home_newsletter['section_enable'];
                        foreach ($home_newsletter['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-newsletter-title-text') {
                                $home_newsletter_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                $home_newsletter_sub_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-newsletter-description') {
                                $home_newsletter_decription = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-newsletter-bg-img') {
                                $home_newsletter_image= $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($home_newsletter['section_enable'] == 'on')
                    <div class="footer-col footer-subscribe-col">
                        <div class="footer-widget">
                            <h4>{!! $home_newsletter_text !!}</h4>
                            <p>{!! $home_newsletter_sub_text !!}</p>
                            <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                @csrf
                                <div class="input-wrapper">
                                    <input type="email" placeholder="Type your address email..." name="email">
                                    <button type="submit" class="btn-subscibe">
                                        {{__('Subscribe')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 4 6"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                fill="white" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" id="subscibecheck" style="display: none;">
                                    <label for="subscibecheck">
                                    {!! $home_newsletter_decription !!}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            @php
                $homepage_footer6 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                if($homepage_footer6 != '')
                {
                    $home_footer6 = $theme_json[$homepage_footer6];
                    foreach ($home_footer6['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-copyrgt-text') {
                            $home_footer_text6 = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($home_footer_enable4 == 'on')
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <p>{!! $home_footer_text6 !!}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endif
</footer>
<!--footer end here-->
{{-- <div class="overlay "></div> --}}

<!--cart popup start here-->
<div class="overlay cart-overlay"></div>
<div class="cartDrawer cartajaxDrawer">

</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
<!--cart popup ends here-->

@push('page-script')

@endpush
