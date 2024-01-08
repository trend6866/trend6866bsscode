    @php
        $theme_json = $homepage_json;
        if(Auth::user()){
            $carts = App\Models\Cart::where('user_id',Auth::user()->id)->where('theme_id', APP_THEME())->get();
            $cart_product_count = $carts->count();
        }
        $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    @endphp

<!--footer start here-->
<footer class="site-footer">
    <img src="{{asset('themes/'.APP_THEME().'/assets/images/right-gilter.png')}}" class="right-gliter gliter-img">
    <div class="container">
        <div class="footer-row">
            <div class="footer-col footer-subscribe-col">
                @php
                    $homepage_footer_section1_title = $homepage_footer_section1_subtext = $homepage_footer_section1_text = '';

                    $homepage_footer_key1 = array_search('homepage-footer-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key1 != '') {
                        $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                    foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-title') {
                        $homepage_footer_section1_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-sub-text') {
                        $homepage_footer_section1_subtext = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-text') {
                        $homepage_footer_section1_text = $value['field_default_text'];
                        }
                    }
                    }
                @endphp
                @if($homepage_footer_section1['section_enable'] == 'on')
                    <div class="footer-widget">
                        {!! $homepage_footer_section1_title !!}
                    <p> {!! $homepage_footer_section1_subtext !!} </p>
                        <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                            @csrf
                            <div class="input-wrapper">
                                <input type="email" placeholder="Enter email address..." name="email">
                                <button type="submit" class="btn-subscibe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.97863e-08 9.99986C-7.09728e-06 10.4601 0.373083 10.8332 0.83332 10.8332L17.113 10.8335L15.1548 12.7358C14.8247 13.0565 14.817 13.584 15.1377 13.9142C15.4584 14.2443 15.986 14.2519 16.3161 13.9312L19.7474 10.5979C19.9089 10.441 20.0001 10.2254 20.0001 10.0002C20.0001 9.77496 19.9089 9.55935 19.7474 9.40244L16.3161 6.0691C15.986 5.74841 15.4584 5.75605 15.1377 6.08617C14.817 6.41628 14.8247 6.94387 15.1548 7.26456L17.1129 9.1668L0.833346 9.16654C0.373109 9.16653 7.24653e-06 9.53962 4.97863e-08 9.99986Z"
                                            fill="#183A40" />
                                    </svg>
                                </button>
                            </div>
                            <div class="checkbox">
                                {{-- <input type="checkbox" id="subscibecheck"> --}}
                                <label for="subscibecheck">
                                    {!! $homepage_footer_section1_text !!}
                                </label>
                            </div>
                        </form>
                    </div>

                @php
                    $homepage_footer_10_icon = $homepage_footer_10_link = '';

                    $homepage_footer_10 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_10 != '') {
                        $homepage_footer_section_10 = $theme_json[$homepage_footer_10];

                    }

                @endphp
                <ul class="article-socials d-flex align-items-center icon">
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
                            <img src="{{get_file($homepage_footer_10_icon , APP_THEME())}}" alt="">
                        </a>
                    </li>
                    @endfor
                </ul>
            </div>
            <div class="footer-col footer-link footer-link-1">
                @php
                    $homepage_footer_section2_title =  '';

                    $homepage_footer_key2 = array_search('homepage-footer-2', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key2 != '') {
                        $homepage_footer_section2 = $theme_json[$homepage_footer_key2];
                        // dd($homepage_footer_section2);
                    foreach ($homepage_footer_section2['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-title') {
                        $homepage_footer_section2_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-enable') {
                        $homepage_footer_section2_enable = $value['field_default_text'];
                        // dd($homepage_footer_section2_enable);
                        }


                    }
                    }
                @endphp
            @if($homepage_footer_section2_enable == 'on')
                <div class="footer-widget">
                    <h4>{!! $homepage_footer_section2_title !!}</h4>

                    @php
                        $homepage_footer_section3_sub_title = '';

                        $homepage_footer_key3 = array_search('homepage-footer-3', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];

                        }

                    @endphp
                        <ul>
                            @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                            @php
                                foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                {

                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-sub-title') {
                                    $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                    }
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-footer-link') {
                                    $homepage_footer_section3_link = $homepage_footer_section3_value['field_default_text'];
                                    }

                                    if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                    {
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-sub-title'){
                                        $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                        }
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-footer-link'){
                                        $homepage_footer_section3_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                        }
                                    }
                                }
                            @endphp
                                <li><a href="{{$homepage_footer_section3_link}}">{!! $homepage_footer_section3_sub_title !!}</a></li>
                            @endfor
                        </ul>
                </div>
                @endif
            </div>
            <div class="footer-col footer-link footer-link-2">
                @php
                    $homepage_footer_section4_title =  '';

                    $homepage_footer_key4 = array_search('homepage-footer-4', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key4 != '') {
                        $homepage_footer_section4 = $theme_json[$homepage_footer_key4];

                    foreach ($homepage_footer_section4['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-title') {
                        $homepage_footer_section4_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-enable') {
                        $homepage_footer_section4_enable = $value['field_default_text'];
                        }
                    }
                    }
                @endphp
                @if($homepage_footer_section4_enable == 'on')
                <div class="footer-widget">
                   <h4> {!! $homepage_footer_section4_title !!}</h4>

                    @php
                        $homepage_footer_section5_sub_title = '';

                        $homepage_footer_key5 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key5 != '') {
                            $homepage_footer_section5 = $theme_json[$homepage_footer_key5];
                            // dd($homepage_footer_section5);

                        }

                    @endphp

                    <ul>
                        @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                            {
                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-sub-title') {
                                $homepage_footer_section5_sub_title = $homepage_footer_section5_value['field_default_text'];
                                }
                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-footer-link') {
                                $homepage_footer_section5_link = $homepage_footer_section5_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                {
                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-sub-title'){
                                        $homepage_footer_section5_sub_title = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                    }
                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-footer-link'){
                                        $homepage_footer_section5_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                            <li><a href="{{$homepage_footer_section5_link}}">{!! $homepage_footer_section5_sub_title !!}</a></li>
                        @endfor
                    </ul>
                </div>
                @endif
            </div>
            @php
                $homepage_footer_section6_title = $homepage_footer_section6_title_value = '';

                $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                if($homepage_footer_key6 != '') {
                    $homepage_footer_section6 = $theme_json[$homepage_footer_key6];

                }

            @endphp

            <div class="footer-col footer-link footer-link-3">
                <div class="footer-widget">
                    @for($i=0 ; $i < $homepage_footer_section6['loop_number'];$i++)
                    @php
                        foreach ($homepage_footer_section6['inner-list'] as $homepage_footer_section6_value)
                        {
                            if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section6_title = $homepage_footer_section6_value['field_default_text'];
                            }
                            if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-value') {
                            $homepage_footer_section6_title_value = $homepage_footer_section6_value['field_default_text'];
                            }

                            if(!empty($homepage_footer_section6[$homepage_footer_section6_value['field_slug']]))
                            {
                                if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-title'){
                                        $homepage_footer_section6_title = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i];
                                    }
                                if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-value'){
                                    $homepage_footer_section6_title_value = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i];
                                }
                            }
                        }
                    @endphp
                    <h4>{!! $homepage_footer_section6_title !!}<h4>
                    <div class="calllink contactlink">
                        <a href="{{ $homepage_footer_section6_title_value }}">{!! $homepage_footer_section6_title_value !!}</a>
                    </div>
                    {{-- <h4>EMAIL:</h4>
                    <div class="emaillink contactlink">
                        <a href="mailto:shop@company.com">shop@company.com</a>
                    </div> --}}
                    @endfor
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    @php
                        $homepage_footer_section7_title = '';

                        $homepage_footer_key7 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key7 != '') {
                            $homepage_footer_section7 = $theme_json[$homepage_footer_key7];

                        foreach ($homepage_footer_section7['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section7_title = $value['field_default_text'];
                            }
                        }
                        }
                    @endphp

                  <p> {!! $homepage_footer_section7_title !!} </p>
                </div>

                    @php
                        $homepage_footer_section8_title = '';

                        $homepage_footer_key8 = array_search('homepage-footer-8', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key8 != '') {
                            $homepage_footer_section8 = $theme_json[$homepage_footer_key8];

                        }

                    @endphp

                <div class="col-12 col-md-6">
                    <ul class="policy-links d-flex align-items-center justify-content-end">
                        @for($i=0 ; $i < $homepage_footer_section8['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section8['inner-list'] as $homepage_footer_section8_value)
                            {
                                if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-title') {
                                $homepage_footer_section8_title = $homepage_footer_section8_value['field_default_text'];
                                }
                                if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-link') {
                                $homepage_footer_section8_link = $homepage_footer_section8_value['field_default_text'];
                                }



                                if(!empty($homepage_footer_section8[$homepage_footer_section8_value['field_slug']]))
                                {
                                    if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-title'){
                                        $homepage_footer_section8_title = $homepage_footer_section8[$homepage_footer_section8_value['field_slug']][$i];
                                    }
                                    if($homepage_footer_section8_value['field_slug'] == 'homepage-footer-link'){
                                        $homepage_footer_section8_link = $homepage_footer_section8[$homepage_footer_section8_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                            <li><a href="{!! $homepage_footer_section8_link !!}">{!! $homepage_footer_section8_title !!}</a></li>
                        @endfor
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

@push('page-script')

@endpush
