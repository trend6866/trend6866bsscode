@php
            $theme_json = $homepage_json;
            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
            $profile = asset(Storage::url('uploads/logo/'));
            $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
            if($theme_logo){
                $theme_logo = get_file($theme_logo , APP_THEME());
            }

        @endphp

<header class="site-header header-style-one style-two">
    <div class="main-navigationbar">
        <div class="offset-container offset-left">
            <div class="navigationbar-row d-flex align-items-center">
                <div class="logo-col">
                    <h1>
                        <a href="{{route('landing_page',$slug)}}">
                            <img src="{{ !empty($theme_logo) ? $theme_logo : asset('themes/'.APP_THEME().'/assets/images/logo.png')}}" alt="">
                        </a>
                    </h1>
                </div>
                <div class="menu-items-col">
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="#">
                                {{__('All Products')}}
                            </a>
                            <div class="menu-dropdown">
                                <div class="mega-menu-container container">
                                    <ul class="row">
                                        <li class="">
                                            <ul class="megamenu-list arrow-list">
                                                @foreach ($MainCategoryList as $category)
                                                    <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="menu-lnk">
                            <a href="{{route('page.product-list',$slug)}}"> {{ __('Shop All') }} </a>
                        </li>
                        <li class="menu-lnk has-item">
                            <a href="#">
                                {{ __('Pages') }}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($pages as $page)
                                        <li><a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                                    @endforeach
                                    <li><a href="{{route('page.faq',$slug)}}"> {{ __('FAQs')}} </a></li>
                                    <li><a href="{{route('page.blog',$slug)}}"> {{ __('Blog')}} </a></li>
                                    <li><a href="{{route('page.product-list',$slug)}}"> {{ __('Collection')}} </a>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-lnk">
                            <a href="{{route('page.contact_us',$slug)}}">
                                {{ __('Contact') }}
                            </a>
                        </li>

                        <li class="menu-lnk">
                            <a href="#" class="category-btn active">
                                Book a table
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <path d="M11.4343 5.68164H0.46875V8.29201C0.46875 9.76955 1.15143 11.0859 2.21776 11.9464H0.46875V12.9906H9.8678V11.9464H8.11926C8.92539 11.2949 9.50985 10.3824 9.74749 9.33618H11.4343C12.2992 9.33618 13.0008 8.63469 13.0008 7.77V7.24783C13.0008 6.38329 12.2992 5.68164 11.4343 5.68164ZM11.9564 7.77C11.9564 8.05849 11.7224 8.29201 11.4343 8.29201H9.8678V6.72582H11.4343C11.7224 6.72582 11.9564 6.96028 11.9564 7.24783V7.77Z" fill="#ffffff"/>
                                    <path d="M0.46875 4.63835C0.46875 2.33229 2.33916 0.460938 4.64616 0.460938C4.64616 1.32581 5.3478 2.02745 6.21267 2.02745H7.2569C8.69793 2.02745 9.8678 3.19622 9.8678 4.63835H0.46875Z" fill="#ffffff"/>
                                </svg>
                            </a>
                        </li>
                    </ul>

                    @auth
                        <ul class="main-nav">
                            <li class="menu-lnk has-item">
                                <a href="#">
                                    <span class="desk-only icon-lable">{{ __('My profile') }}</span>
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        <li><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout_user',$slug) }}" id="form_logout">
                                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                                                    @csrf
                                                    {{ __('Log Out') }}
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-lnk has-item lang-dropdown">
                                <a href="#">
                                    <span class="link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="24px"><path d="M160 243.1L147.2 272h25.69L160 243.1zM576 63.1L336 64v384l240 0c35.35 0 64-28.65 64-64v-256C640 92.65 611.3 63.1 576 63.1zM552 232h-1.463c-8.082 27.78-21.06 49.29-35.06 66.34c7.854 4.943 13.33 7.324 13.46 7.375c12.22 5 18.19 18.94 13.28 31.19C538.4 346.3 529.5 352 519.1 352c-2.906 0-5.875-.5313-8.75-1.672c-1-.3906-14.33-5.951-31.26-18.19c-16.69 12.04-29.9 17.68-31.18 18.19C445.9 351.5 442.9 352 440 352c-9.562 0-18.59-5.766-22.34-15.2c-4.844-12.3 1.188-26.19 13.44-31.08c.748-.3047 6.037-2.723 13.25-7.189c-3.375-4.123-6.742-8.324-9.938-13.03c-7.469-10.97-4.594-25.89 6.344-33.34c11.03-7.453 25.91-4.594 33.34 6.375c1.883 2.77 3.881 5.186 5.854 7.682C487.3 256.8 494.1 245.5 499.5 232H408C394.8 232 384 221.3 384 208S394.8 184 408 184h48c0-13.25 10.75-24 24-24S504 170.8 504 184h48c13.25 0 24 10.75 24 24S565.3 232 552 232zM0 127.1v256c0 35.35 28.65 64 64 64L304 448V64L64 63.1C28.65 63.1 0 92.65 0 127.1zM74.06 318.3l64-144c7.688-17.34 36.19-17.34 43.88 0l64 144c5.375 12.11-.0625 26.3-12.19 31.69C230.6 351.3 227.3 352 224 352c-9.188 0-17.97-5.312-21.94-14.25L193.1 319.6C193.3 319.7 192.7 320 192 320H128c-.707 0-1.305-.3418-1.996-.4023l-8.066 18.15c-5.406 12.14-19.69 17.55-31.69 12.19C74.13 344.5 68.69 330.4 74.06 318.3z" fill="#FEBD2F"/></svg>
                                    </span>
                                    <span class="drp-text">{{ Str::upper($currantLang) }}</span>
                                    <div class="lang-icn">
                                        
                                    </div>
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        @foreach ($languages as $code => $language)
                                            <li><a href="{{ route('change.languagestore', [$code]) }}"
                                                    class="@if ($language == $currantLang) active-language text-primary @endif">{{  ucFirst($language) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    @endauth

                    <ul class="menu-right d-flex justify-content-end">
                        {{--  --}}
                        @auth
                        <li class="wishlist-header">
                            <a href="javascript:;" title="wish" class="wish-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.56651 3.77008C9.24993 4.07062 8.75007 4.07062 8.43349 3.77008L7.86698 3.23227C7.2039 2.60277 6.30813 2.21841 5.31818 2.21841C3.28477 2.21841 1.63636 3.84913 1.63636 5.86071C1.63636 7.78921 2.69164 9.38165 4.21507 10.6901C5.73981 11.9996 7.56278 12.8681 8.65198 13.3113C8.87973 13.404 9.12027 13.404 9.34802 13.3113C10.4372 12.8681 12.2602 11.9996 13.7849 10.69C15.3084 9.38165 16.3636 7.78921 16.3636 5.86071C16.3636 3.84913 14.7152 2.21841 12.6818 2.21841C11.6919 2.21841 10.7961 2.60277 10.133 3.23227L9.56651 3.77008ZM9 2.06428C8.04445 1.15713 6.74713 0.599609 5.31818 0.599609C2.38103 0.599609 0 2.95509 0 5.86071C0 11.0152 5.70301 13.8617 8.02947 14.8084C8.65601 15.0634 9.34399 15.0633 9.97053 14.8084C12.297 13.8616 18 11.0152 18 5.86071C18 2.95509 15.619 0.599609 12.6818 0.599609C11.2529 0.599609 9.95555 1.15713 9 2.06428Z" fill="#ffffff"/>
                                </svg>
                            </a>
                        </li>
                        @endauth

                        @guest
                        <li class="profile-header">
                            <a href="{{ route('login',$slug) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 9.81818C4.27834 9.81818 1.66667 12.3824 1.66667 15.5455V17.1818C1.66667 17.6337 1.29357 18 0.833333 18C0.373096 18 0 17.6337 0 17.1818V15.5455C0 11.4786 3.35786 8.18182 7.5 8.18182C11.6421 8.18182 15 11.4786 15 15.5455V17.1818C15 17.6337 14.6269 18 14.1667 18C13.7064 18 13.3333 17.6337 13.3333 17.1818V15.5455C13.3333 12.3824 10.7217 9.81818 7.5 9.81818Z" fill="#ffffff"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 8.18182C9.34095 8.18182 10.8333 6.71657 10.8333 4.90909C10.8333 3.10161 9.34095 1.63636 7.5 1.63636C5.65905 1.63636 4.16667 3.10161 4.16667 4.90909C4.16667 6.71657 5.65905 8.18182 7.5 8.18182ZM7.5 9.81818C10.2614 9.81818 12.5 7.62031 12.5 4.90909C12.5 2.19787 10.2614 0 7.5 0C4.73858 0 2.5 2.19787 2.5 4.90909C2.5 7.62031 4.73858 9.81818 7.5 9.81818Z" fill="#ffffff"/>
                                </svg>
                            </a>
                        </li>
                        @endguest
                        <li class="cart-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.57747 17.321C8.57747 18.7419 7.42554 19.8939 6.00456 19.8939C4.58357 19.8939 3.43164 18.7419 3.43164 17.321C3.43164 15.9 4.58357 14.748 6.00456 14.748C7.42554 14.748 8.57747 15.9 8.57747 17.321ZM6.8622 17.321C6.8622 17.7946 6.47822 18.1786 6.00456 18.1786C5.5309 18.1786 5.14692 17.7946 5.14692 17.321C5.14692 16.8473 5.5309 16.4633 6.00456 16.4633C6.47822 16.4633 6.8622 16.8473 6.8622 17.321Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.1539 17.321C17.1539 18.7419 16.0019 19.8939 14.5809 19.8939C13.16 19.8939 12.008 18.7419 12.008 17.321C12.008 15.9 13.16 14.748 14.5809 14.748C16.0019 14.748 17.1539 15.9 17.1539 17.321ZM15.4386 17.321C15.4386 17.7946 15.0546 18.1786 14.5809 18.1786C14.1073 18.1786 13.7233 17.7946 13.7233 17.321C13.7233 16.8473 14.1073 16.4633 14.5809 16.4633C15.0546 16.4633 15.4386 16.8473 15.4386 17.321Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.80557 2.35709C2.0174 1.93344 2.53256 1.76172 2.95622 1.97354L3.81687 2.40387C4.61384 2.80235 5.1479 3.58483 5.22857 4.47221L5.2696 4.92356C5.28968 5.14444 5.47487 5.31356 5.69666 5.31356H17.0114C18.5085 5.31356 19.5447 6.80879 19.019 8.2105L17.5153 12.2204C17.1387 13.2247 16.1787 13.8899 15.1062 13.8899H6.712C5.38128 13.8899 4.27013 12.8752 4.14965 11.55L3.52034 4.62751C3.49345 4.33171 3.31543 4.07089 3.04977 3.93806L2.18912 3.50774C1.76547 3.29591 1.59375 2.78075 1.80557 2.35709ZM5.93056 7.02883C5.6784 7.02883 5.48068 7.24535 5.5035 7.49648L5.85789 11.3947C5.89805 11.8364 6.26843 12.1747 6.712 12.1747H15.1062C15.4637 12.1747 15.7837 11.9529 15.9092 11.6182L17.413 7.60822C17.5181 7.32788 17.3109 7.02883 17.0114 7.02883H5.93056Z" fill="white"/>
                                </svg>
                                <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>
                                <span class="desk-only icon-lable">{{ __('MY CART')}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="mobile-menu mobile-only">
                        <button class="mobile-menu-button">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-fixed-header">
        <ul class="right-head-top">
            @auth
            <li class="wishlist-header">
                <a href="javascript:;" title="wish" class="wish-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.56651 3.77008C9.24993 4.07062 8.75007 4.07062 8.43349 3.77008L7.86698 3.23227C7.2039 2.60277 6.30813 2.21841 5.31818 2.21841C3.28477 2.21841 1.63636 3.84913 1.63636 5.86071C1.63636 7.78921 2.69164 9.38165 4.21507 10.6901C5.73981 11.9996 7.56278 12.8681 8.65198 13.3113C8.87973 13.404 9.12027 13.404 9.34802 13.3113C10.4372 12.8681 12.2602 11.9996 13.7849 10.69C15.3084 9.38165 16.3636 7.78921 16.3636 5.86071C16.3636 3.84913 14.7152 2.21841 12.6818 2.21841C11.6919 2.21841 10.7961 2.60277 10.133 3.23227L9.56651 3.77008ZM9 2.06428C8.04445 1.15713 6.74713 0.599609 5.31818 0.599609C2.38103 0.599609 0 2.95509 0 5.86071C0 11.0152 5.70301 13.8617 8.02947 14.8084C8.65601 15.0634 9.34399 15.0633 9.97053 14.8084C12.297 13.8616 18 11.0152 18 5.86071C18 2.95509 15.619 0.599609 12.6818 0.599609C11.2529 0.599609 9.95555 1.15713 9 2.06428Z" fill="#ffffff"/>
                    </svg>
                </a>
            </li>
            @endauth
            @guest
            <li class="profile-header">
                <a href="{{ route('login',$slug) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 9.81818C4.27834 9.81818 1.66667 12.3824 1.66667 15.5455V17.1818C1.66667 17.6337 1.29357 18 0.833333 18C0.373096 18 0 17.6337 0 17.1818V15.5455C0 11.4786 3.35786 8.18182 7.5 8.18182C11.6421 8.18182 15 11.4786 15 15.5455V17.1818C15 17.6337 14.6269 18 14.1667 18C13.7064 18 13.3333 17.6337 13.3333 17.1818V15.5455C13.3333 12.3824 10.7217 9.81818 7.5 9.81818Z" fill="#ffffff"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 8.18182C9.34095 8.18182 10.8333 6.71657 10.8333 4.90909C10.8333 3.10161 9.34095 1.63636 7.5 1.63636C5.65905 1.63636 4.16667 3.10161 4.16667 4.90909C4.16667 6.71657 5.65905 8.18182 7.5 8.18182ZM7.5 9.81818C10.2614 9.81818 12.5 7.62031 12.5 4.90909C12.5 2.19787 10.2614 0 7.5 0C4.73858 0 2.5 2.19787 2.5 4.90909C2.5 7.62031 4.73858 9.81818 7.5 9.81818Z" fill="#ffffff"/>
                    </svg>
                </a>
            </li>
            @endguest
            <div class="mobile-menu ">
                <button class="mobile-menu-button">
                    <div class="one"></div>
                    <div class="two"></div>
                    <div class="three"></div>
                </button>
                <span>{{__('MENU')}}</span>
            </div>
        </ul>

        <ul class="header-socials" role="list">
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
            @php
                $homepage_footer = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                if($homepage_footer != '')
                {
                    $home_footer = $theme_json[$homepage_footer];
                    $section_enable = $home_footer['section_enable'];
                    foreach ($home_footer['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-footer-label') {
                            $footer_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-footer-enable') {
                            $home_artical_checkbox = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($home_footer['section_enable'] == 'on')
            <li>{{$footer_text}}</li>
            @endif
        </ul>
    </div>
</header>
