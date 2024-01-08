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
@endphp
    <footer class="site-footer ">
        @if($home_footer['section_enable'] == 'on')
            <div class="container">
                @if($whatsapp_setting_enabled)
                    <div class="floating-wpp"></div>
                @endif
                <div class="footer-row">
                    @if($home_footer_enable == 'on')
                        <div class="footer-col footer-link footer-link-1">
                            <div class="footer-widget">
                                <h2> {!! $home_footer_title !!} </h2>
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
                                <h2> {!! $home_footer_title2 !!} </h2>
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
                        $homepage_subscribe = array_search('homepage-newsletter', array_column($theme_json, 'unique_section_slug'));
                        $section_enable = 'on';
                        if($homepage_subscribe != '')
                        {
                            $home_subscribe = $theme_json[$homepage_subscribe];
                            $section_enable = $home_subscribe['section_enable'];
                            foreach ($home_subscribe['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-newsletter-title-text') {
                                    $home_subscribe_title_text= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-sub-text') {
                                    $home_subscribe_sub_text= $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-newsletter-description') {
                                    $home_subscribe_description= $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if($home_subscribe['section_enable'] == 'on')
                        <div class="footer-col footer-subscribe-col">
                            <div class="footer-widget">
                                <h2>{!! $home_subscribe_title_text !!}</h2>
                                <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                                    @csrf
                                    <div class="contnent">
                                        <div class="input-box">
                                            <input type="email" placeholder="TYPE YOUR EMAIL ADDRESS..." name="email">
                                            <button>
                                                {{__('SUBSCRIBE')}}
                                            </button>
                                        </div><br>
                                        <label for="subscibecheck">
                                            {!! $home_subscribe_description !!}
                                        </label>
                                    </div>
                                </form>
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
                        <div class="footer-col social-icons">
                            <div class="footer-widget">
                                <h2> {!! $home_footer_title4 !!} </h2>
                                @php
                                    $homepage_footer_key5 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key5 != '') {
                                        $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                                    }
                                @endphp
                                <ul class="social-ul d-flex align-items-center">
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
                </div>
                @php
                    $homepage_footer6 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer6 != '')
                    {
                        $home_footer6 = $theme_json[$homepage_footer6];
                        foreach ($home_footer6['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-copygyt-text') {
                                $home_footer_text6 = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        @if($home_footer_enable4 == 'on')
                            <div class="col-sm-6 col-12">
                                <p>{!! $home_footer_text6 !!}</p>
                            </div>
                        @endif
                        <div class="col-sm-6 col-12">
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
        @endif
    </footer>
<!--footer end here-->
<div class="overlay "></div>

<!--cart popup start here-->
<div class="cartDrawer cartajaxDrawer">

</div>


<!--cart popup ends here-->
<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>

@push('page-script')

@endpush
