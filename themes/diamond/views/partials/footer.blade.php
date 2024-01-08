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
<footer class="site-footer footer-with-img">
    <div class="container">
        @if($whatsapp_setting_enabled)
            <div class="floating-wpp"></div>
        @endif

        <div class="footer-row">
            <div class="footer-col footer-subscribe-col">
                <div class="footer-widget">
                @php
                    $footer_section_1 = array_search('home-footer-subscribe-1', array_column($theme_json, 'unique_section_slug'));

                    if($footer_section_1 != '' ) {
                        $homepage_header_1 = $theme_json[$footer_section_1];

                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-footer-subscribe-title') {
                                $home_footer_title = $value['field_default_text'];

                            }
                            if($value['field_slug'] == 'home-footer-subscribe-sub-text') {
                                $home_footer_subtext = $value['field_default_text'];
                            }

                             //Dynamic
                            if(!empty($homepage_header_1[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'home-footer-subscribe-title'){
                                    $home_footer_title = $homepage_header_1[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'home-footer-subscribe-sub-text'){
                                    $home_footer_subtext = $homepage_header_1[$value['field_slug']][$i];
                                }
                            }

                        }
                    }

                    $footer_section_2 = array_search('home-footer-subscribe-2', array_column($theme_json, 'unique_section_slug'));
                    if($footer_section_2 != '' ) {
                        $homepage_footer_2 = $theme_json[$footer_section_2];
                        foreach ($homepage_footer_2['inner-list'] as $key => $value) {

                                if($value['field_slug'] == 'home-footer-subscribe-title') {
                                    $homepage_footer2_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'home-footer-subscribe-enable') {
                                    $homepage_footer2_enable = $value['field_default_text'];
                                }
                            }
                    }

                    $footer_section_3 = array_search('home-footer-subscribe-3', array_column($theme_json, 'unique_section_slug'));
                    if($footer_section_3 != '' ) {
                        $homepage_footer_3 = $theme_json[$footer_section_3];
                        foreach ($homepage_footer_3['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'home-footer-subscribe-label') {
                                    $homepage_footer_subscribe_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                    $homepage_footer_subscribe_enable = $value['field_default_text'];
                                }
                            }
                    }


                    $footer_section_4 = array_search('home-footer-subscribe-6', array_column($theme_json, 'unique_section_slug'));
                    if($footer_section_4 != '' ) {
                        $homepage_footer_4 = $theme_json[$footer_section_4];
                        foreach ($homepage_footer_4['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'home-footer-subscribe-title') {
                                    $homepage_footer_subscribe4_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                    $homepage_footer_subscribe4_enable = $value['field_default_text'];
                                }
                            }
                    }

                @endphp

                    {!! $home_footer_title !!}
                    <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                        @csrf
                        <div class="input-wrapper">
                            <input type="email" placeholder="Enter email address..." name="email">
                            <button type="submit" class="btn-subscibe">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M22.7071 12.7071C22.8946 12.5196 23 12.2652 23 12C23 11.7348 22.8946 11.4804 22.7071 11.2929L11.7071 0.292894C11.3166 -0.0976306 10.6834 -0.0976306 10.2929 0.292894C9.90237 0.683418 9.90237 1.31658 10.2929 1.70711L20.5858 12L10.2929 22.2929C9.90237 22.6834 9.90237 23.3166 10.2929 23.7071C10.6834 24.0976 11.3166 24.0976 11.7071 23.7071L22.7071 12.7071ZM13.7071 12.7071C13.8946 12.5196 14 12.2652 14 12C14 11.7348 13.8946 11.4804 13.7071 11.2929L2.70711 0.292894C2.31658 -0.0976302 1.68342 -0.0976302 1.29289 0.292894C0.902369 0.683419 0.902369 1.31658 1.29289 1.70711L11.5858 12L1.29289 22.2929C0.90237 22.6834 0.90237 23.3166 1.29289 23.7071C1.68342 24.0976 2.31658 24.0976 2.70711 23.7071L13.7071 12.7071Z"
                                        fill="#fff" />
                                </svg>
                            </button>
                        </div>
                        <div class="checkbox">
                            {{-- <input type="checkbox" id="subscibecheck"> --}}
                            <label for="subscibecheck">
                                {{ $home_footer_subtext }}
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-col footer-link footer-link-1">
                <div class="footer-widget">
                    {!! $homepage_footer2_title !!}
                    @php
                        $homepage_footer3_title_label = '';

                        $homepage_footer3 = array_search('home-footer-subscribe-3', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer3 != '') {
                            $homepage_footer3_title = $theme_json[$homepage_footer3];
                        }
                    @endphp

                    <ul>
                        @for($i=0 ; $i < $homepage_footer3_title['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer3_title['inner-list'] as $homepage_footer3_title_value)
                            {
                                if($homepage_footer3_title_value['field_slug'] == 'home-footer-subscribe-label') {
                                $homepage_footer3_title_label = $homepage_footer3_title_value['field_default_text'];
                                }

                                if($homepage_footer3_title_value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                $homepage_footer3_title_link = $homepage_footer3_title_value['field_default_text'];
                                }

                                if(!empty($homepage_footer3_title[$homepage_footer3_title_value['field_slug']]))
                                {
                                    if($homepage_footer3_title_value['field_slug'] == 'home-footer-subscribe-label'){
                                    $homepage_footer3_title_label = $homepage_footer3_title[$homepage_footer3_title_value['field_slug']][$i];
                                    }
                                    if($homepage_footer3_title_value['field_slug'] == 'home-footer-subscribe-footer-link'){
                                    $homepage_footer3_title_link = $homepage_footer3_title[$homepage_footer3_title_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                        <li><a href="{{ $homepage_footer3_title_link }}">{!! $homepage_footer3_title_label !!}</a></li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="footer-col footer-link footer-link-2">
                <div class="footer-widget">

                    <h2>{{$homepage_footer_subscribe_title }} : </h2>
                    @php
                        $homepage_footer4_title_label = '';

                        $homepage_footer4 = array_search('home-footer-subscribe-5', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer4 != '') {
                            $homepage_footer4_title = $theme_json[$homepage_footer4];
                        }
                    @endphp

                    <ul>
                        @for($i=0 ; $i < $homepage_footer_3['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer4_title['inner-list'] as $homepage_footer4_title_value)
                            {
                                if($homepage_footer4_title_value['field_slug'] == 'home-footer-subscribe-label') {
                                    $homepage_footer4_title_label = $homepage_footer4_title_value['field_default_text'];
                                }
                                if($homepage_footer4_title_value['field_slug'] == 'home-footer-subscribe-footer-link') {
                                    $homepage_footer4_title_link = $homepage_footer4_title_value['field_default_text'];
                                }


                                if(!empty($homepage_footer4_title[$homepage_footer4_title_value['field_slug']]))
                                {
                                    if($homepage_footer4_title_value['field_slug'] == 'home-footer-subscribe-label'){
                                    $homepage_footer4_title_label = $homepage_footer4_title[$homepage_footer4_title_value['field_slug']][$i];
                                    }
                                    if($homepage_footer4_title_value['field_slug'] == 'home-footer-subscribe-footer-link'){
                                    $homepage_footer4_title_link = $homepage_footer4_title[$homepage_footer4_title_value['field_slug']][$i];
                                    }

                                }
                            }
                        @endphp
                        <li><a href="{{ $homepage_footer4_title_link }}">{!! $homepage_footer4_title_label !!}</a></li>
                        @endfor
                    </ul>
                </div>
            </div>
            <div class="footer-col social-icons">
                <div class="footer-widget">
                    {!! $homepage_footer_subscribe4_title  !!}
                    @php
                        $homepage_footer5_title_label = '';

                        $homepage_footer5 = array_search('home-footer-subscribe-7', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer5 != '') {
                            $homepage_footer5_title = $theme_json[$homepage_footer5];
                            }
                    @endphp
                    <ul class=" d-flex align-items-center">
                        @for($i=0 ; $i < $homepage_footer5_title['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer5_title['inner-list'] as $homepage_footer5_title_value)
                            {
                                if($homepage_footer5_title_value['field_slug'] == 'home-footer-subscribe-social-icon') {
                                $homepage_footer5_title_label = $homepage_footer5_title_value['field_default_text'];
                                }
                                if($homepage_footer5_title_value['field_slug'] == 'home-footer-subscribe-link') {
                                $homepage_footer5_title_link = $homepage_footer5_title_value['field_default_text'];
                                }

                                if(!empty($homepage_footer5_title[$homepage_footer5_title_value['field_slug']]))
                                {
                                    if($homepage_footer5_title_value['field_slug'] == 'home-footer-subscribe-social-icon'){
                                    $homepage_footer5_title_label = $homepage_footer5_title[$homepage_footer5_title_value['field_slug']][$i]['field_prev_text'];

                                    }
                                    if($homepage_footer5_title_value['field_slug'] == 'home-footer-subscribe-link'){
                                    $homepage_footer5_title_link = $homepage_footer5_title[$homepage_footer5_title_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                        <li>
                            <a href="{{ $homepage_footer5_title_link }}" target="_blank">
								<img src ="{{get_file($homepage_footer5_title_label , APP_THEME())}}">
                            </a>
                        </li>
                        @endfor
                    </ul>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="row align-items-center">
                @php
                    $homepage_footer_section7_title = '';

                    $homepage_footer_key7 = array_search('homepage-footer', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key7 != '') {
                        $homepage_footer_section7 = $theme_json[$homepage_footer_key7];

                        foreach ($homepage_footer_section7['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-title') {
                            $homepage_footer_section7_title = $value['field_default_text'];
                            }

                            if(!empty($homepage_footer_section7[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'homepage-footer-title'){
                                    $homepage_footer_section7_title = $homepage_footer_section7[$value['field_slug']][$i];
                                }
                            }

                        }
                    }
                @endphp



                <div class="col-12 col-md-6">
                    {!! $homepage_footer_section7_title !!}
                </div>
                    @php
                        $footer_section_5 = '';

                        $footer_section_5 = array_search('home-footer-bottom-8', array_column($theme_json, 'unique_section_slug'));

                        if($footer_section_5 != '') {
                            $homepage_footer_5 = $theme_json[$footer_section_5];
                        }
                @endphp
                <div class="col-12 col-md-6">
                    <ul class="policy-links d-flex align-items-center justify-content-end">
                        @for($i=0 ; $i < $homepage_footer_5['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_5['inner-list'] as $homepage_footer_5_value)
                            {
                                if($homepage_footer_5_value['field_slug'] == 'home-footer-bottom-title') {

                                $homepage_footer_5_title = $homepage_footer_5_value['field_default_text'];
                                }
                                if($homepage_footer_5_value['field_slug'] == 'home-footer-bottom-link') {

                                $homepage_footer_5_link = $homepage_footer_5_value['field_default_text'];
                                }



                                if(!empty($homepage_footer_5[$homepage_footer_5_value['field_slug']]))
                                {
                                    if($homepage_footer_5_value['field_slug'] == 'home-footer-bottom-title'){
                                        $homepage_footer_5_title = $homepage_footer_5[$homepage_footer_5_value['field_slug']][$i];
                                    }
                                    if($homepage_footer_5_value['field_slug'] == 'home-footer-bottom-link'){
                                        $homepage_footer_5_link = $homepage_footer_5[$homepage_footer_5_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                            <li><a href="{!! $homepage_footer_5_link !!}">{!! $homepage_footer_5_title !!}</a></li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer end here-->

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
                        @foreach ($search_products as $pro_id => $pros)
                            <option value="{{$pros}}"></option>
                        @endforeach
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


    <div class="overlay wish-overlay"></div>
    <div class="wishDrawer wishajaxDrawer">
    </div>


<!--cart popup ends here-->

@push('page-script')

<script>
    $(document).ready(function(){
        $(".search_product_globaly").on('click',function(e){
            e.preventDefault();
            var product = $('.search_input').val();

            var data = {
                product   : product,
            }

            $.ajax({
                url:  '{{route('search.product',$slug)}}',
                context: this,
                data: data,
                success: function(responce) {
                    window.location.href =responce;
                }
            });
    });
    });
</script>

@endpush
