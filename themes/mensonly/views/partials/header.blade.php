@php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
    $theme_logo = get_file($theme_logo , APP_THEME());
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp

<!-- ------- NAVIGATION-SECTION-START ------- -->
<header class="site-header header-style-one">
    <div class="announcebar">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                // dd($homepage_header_1_key);
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        // if($value['field_slug'] == 'homepage-header-icon') {
                        //     $header_icon = $value['field_default_text'];
                        // }
                        if($value['field_slug'] == 'homepage-header-title-text') {
                            $header_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-call-label') {
                            $header_label = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-contact') {
                            $header_contact = $value['field_default_text'];
                        }
                        // if($value['field_slug'] == 'homepage-header-call-icon') {
                        //     $header_call_icon = $value['field_default_text'];
                        // }
                    }
                }
            @endphp
            <div class="announce-row row align-items-center">
                <ul class="annoucebar-left col-4">
                    @foreach ($pages as $page)
                        @if($page->page_status == "custom_page")
                            <li class="menu-lnk"><a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                        @else

                        @endif
                    @endforeach
                </ul>
                <div class="annoucebar-left col-4 d-flex justify-content-end">
                    <p>
                        {{-- <img src="{{ get_file($header_icon, APP_THEME()) }}" alt=""> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <g clip-path="url(#clip0_1_508)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8704 1.16417C12.0074 1.31521 12.0389 1.53425 11.9501 1.71777L7.59593 10.7178C7.52579 10.8628 7.3901 10.9651 7.23141 10.9926C7.07272 11.0202 6.91047 10.9696 6.79555 10.8568L5.06335 9.1561L3.34961 10.6517C3.2065 10.7766 3.00497 10.8096 2.82949 10.737C2.654 10.6643 2.53486 10.4984 2.52199 10.3089L2.31069 7.19698L0.246224 5.98083C0.0797703 5.88277 -0.0153014 5.6976 0.00202164 5.50519C0.0193447 5.31278 0.145963 5.14756 0.327254 5.08081L11.3273 1.03081C11.5186 0.960374 11.7335 1.01314 11.8704 1.16417ZM3.34923 7.73073L3.45141 9.23561L4.34766 8.45343L3.87393 7.98831L3.34923 7.73073ZM4.91243 7.60651L6.9991 9.65524L10.0489 3.35145L4.91243 7.60651ZM8.93151 2.97851L1.66281 5.65471L3.02908 6.45956L4.09673 6.98368L8.93151 2.97851Z" fill="#ffff"></path>
                            </g>
                            <defs>
                            <clipPath id="clip0_1_508">
                            <rect width="12" height="12" fill="white"></rect>
                            </clipPath>
                            </defs>
                        </svg>
                        {!! $header_text !!}
                    </p>
                </div>
                <div class="announcebar-right col-4 d-flex justify-content-end">
                    <a href="tel:610403403">
                        <span>{{$header_label}}<b> {!! $header_contact !!}</b></span>
                        {{-- <img src="{{ get_file($header_call_icon, APP_THEME()) }}" alt=""> --}}
                        <svg viewBox="0 0 12 18">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 2.25C0.75 1.00736 1.75736 0 3 0H9C10.2426 0 11.25 1.00736 11.25 2.25V15.75C11.25 16.9926 10.2426 18 9 18H3C1.75736 18 0.75 16.9926 0.75 15.75V2.25ZM3 1.5C2.58579 1.5 2.25 1.83579 2.25 2.25V15.75C2.25 16.1642 2.58579 16.5 3 16.5H9C9.41421 16.5 9.75 16.1642 9.75 15.75V2.25C9.75 1.83579 9.41421 1.5 9 1.5H3ZM4.5 2.25C4.08579 2.25 3.75 2.58579 3.75 3C3.75 3.41421 4.08579 3.75 4.5 3.75H7.5C7.91421 3.75 8.25 3.41421 8.25 3C8.25 2.58579 7.91421 2.25 7.5 2.25H4.5ZM6 14.25C5.58579 14.25 5.25 14.5858 5.25 15C5.25 15.4142 5.58579 15.75 6 15.75C6.41421 15.75 6.75 15.4142 6.75 15C6.75 14.5858 6.41421 14.25 6 14.25Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-navigationbar">
        <div class="container">
            <div class="header-bottom display-align">
                <div class="logo-col">
                    <h1>
                        <a href="{{route('landing_page',$slug)}}">

                            <img src="{{isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/'.APP_THEME().'/assets/images/logo.svg'}}" alt="">

                        </a>
                    </h1>
                </div>
                <div class="navigationbar-row d-flex align-items-center">
                    <div class="menu-right">
                        <div class="menu-items-col right-side-header">
                            <div class="menu-right-one">
                                <ul class="main-nav">
                                    <li class="menu-lnk has-item">
                                        <a href="#" class="category-btn active">

                                            {{ __('All categories')}}
                                        </a>
                                        @if ($has_subcategory)
                                            <div class="mega-menu menu-dropdown">
                                                <div class="mega-menu-container container">
                                                    <ul class="row">
                                                        @foreach ($MainCategoryList as $category)
                                                            <li class="col-md-2 col-12">
                                                                <ul class="megamenu-list arrow-list">
                                                                    <li class="list-title"><span>{{$category->name}}</span></li>
                                                                    <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{ __('All') }}</a></li>
                                                                    @foreach ($SubCategoryList as $cat)
                                                                        @if ($cat->maincategory_id == $category->id)
                                                                            <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $cat->id ])}}">{{$cat->name}}</a></li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="menu-dropdown">
                                                <ul>
                                                    @foreach ($MainCategoryList as $category)
                                                        <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                    <li class="menu-lnk">
                                        <a href="{{route('page.product-list',$slug)}}"> {{ __('Shop All') }} </a>
                                    </li>
                                    <li class="menu-lnk">
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
                                </ul>
                            </div>
                            <div class="menu-right-two">
                                <ul class="menu-right d-flex justify-content-end ">
                                    <li class="search-header">
                                        <a href="javascript:;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                                viewBox="0 0 9 9" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.38419e-07 3.375C2.38419e-07 5.23896 1.51104 6.75 3.375 6.75C4.15424 6.75 4.87179 6.48592 5.44305 6.04237C5.46457 6.08789 5.49415 6.13055 5.5318 6.1682L8.2318 8.8682C8.40754 9.04393 8.69246 9.04393 8.8682 8.8682C9.04393 8.69246 9.04393 8.40754 8.8682 8.2318L6.1682 5.5318C6.13055 5.49415 6.08789 5.46457 6.04237 5.44305C6.48592 4.87179 6.75 4.15424 6.75 3.375C6.75 1.51104 5.23896 0 3.375 0C1.51104 0 2.38419e-07 1.51104 2.38419e-07 3.375ZM0.9 3.375C0.9 2.0081 2.0081 0.9 3.375 0.9C4.7419 0.9 5.85 2.0081 5.85 3.375C5.85 4.7419 4.7419 5.85 3.375 5.85C2.0081 5.85 0.9 4.7419 0.9 3.375Z"
                                                    fill="#0A062D" />
                                            </svg>
                                            <span class="desk-only icon-lable">Search</span>
                                        </a>
                                    </li>


                                    @auth
                                    <li class="wishlist-header">
                                        <a href="javascript:;" title="wish" class="wish-header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8"
                                            viewBox="0 0 10 8" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.31473 1.76137C5.13885 1.92834 4.86115 1.92834 4.68527 1.76137L4.37055 1.46259C4.00217 1.11287 3.50452 0.899334 2.95455 0.899334C1.82487 0.899334 0.909091 1.80529 0.909091 2.92284C0.909091 3.99423 1.49536 4.87891 2.34171 5.6058C3.18878 6.33331 4.20155 6.8158 4.80666 7.06205C4.93318 7.11354 5.06682 7.11354 5.19334 7.06205C5.79845 6.8158 6.81122 6.33331 7.65829 5.6058C8.50464 4.87891 9.09091 3.99422 9.09091 2.92284C9.09091 1.80529 8.17513 0.899334 7.04545 0.899334C6.49548 0.899334 5.99783 1.11287 5.62946 1.46259L5.31473 1.76137ZM5 0.813705C4.46914 0.309733 3.74841 0 2.95455 0C1.3228 0 0 1.3086 0 2.92284C0 5.78643 3.16834 7.3678 4.46081 7.89376C4.80889 8.03541 5.19111 8.03541 5.53919 7.89376C6.83166 7.3678 10 5.78643 10 2.92284C10 1.3086 8.67721 0 7.04545 0C6.25159 0 5.53086 0.309733 5 0.813705Z"
                                                    fill="#0A062D" />
                                            </svg>
                                            <span class="desk-only icon-lable">{{ __('Wishlist')}}</span>
                                        </a>
                                    </li>
                                    @endauth

                                    @auth
                                    <ul class="main-nav mr-5" style="padding-left:0px !important">
                                        <li class="menu-lnk">
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                                    fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                        fill="#183A40" />
                                                </svg>
                                                <span class="desk-only icon-lable">{{ __('My profile') }}</span>
                                            </a>
                                            <div class="menu-dropdown">
                                                <ul>
                                                    <li><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('logout_user',$slug) }}" id="form_logout">
                                                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                                                                {{-- <i class="ti ti-power"></i> --}}
                                                                @csrf
                                                                {{ __('Log Out') }}
                                                            </a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    @endauth

                                    @guest
                                        <li class="profile-header">
                                            <a href="{{ route('login',$slug) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                                    fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                        fill="#183A40" />
                                                </svg>
                                                <span class="desk-only icon-lable">{{ __('Login') }}</span>
                                            </a>
                                        </li>
                                    @endguest

                                    <li class="menu-lnk has-item lang-dropdown">
                                        <a href="#">
                                            <span class="link-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="24px">
                                                    <path
                                                        d="M160 243.1L147.2 272h25.69L160 243.1zM576 63.1L336 64v384l240 0c35.35 0 64-28.65 64-64v-256C640 92.65 611.3 63.1 576 63.1zM552 232h-1.463c-8.082 27.78-21.06 49.29-35.06 66.34c7.854 4.943 13.33 7.324 13.46 7.375c12.22 5 18.19 18.94 13.28 31.19C538.4 346.3 529.5 352 519.1 352c-2.906 0-5.875-.5313-8.75-1.672c-1-.3906-14.33-5.951-31.26-18.19c-16.69 12.04-29.9 17.68-31.18 18.19C445.9 351.5 442.9 352 440 352c-9.562 0-18.59-5.766-22.34-15.2c-4.844-12.3 1.188-26.19 13.44-31.08c.748-.3047 6.037-2.723 13.25-7.189c-3.375-4.123-6.742-8.324-9.938-13.03c-7.469-10.97-4.594-25.89 6.344-33.34c11.03-7.453 25.91-4.594 33.34 6.375c1.883 2.77 3.881 5.186 5.854 7.682C487.3 256.8 494.1 245.5 499.5 232H408C394.8 232 384 221.3 384 208S394.8 184 408 184h48c0-13.25 10.75-24 24-24S504 170.8 504 184h48c13.25 0 24 10.75 24 24S565.3 232 552 232zM0 127.1v256c0 35.35 28.65 64 64 64L304 448V64L64 63.1C28.65 63.1 0 92.65 0 127.1zM74.06 318.3l64-144c7.688-17.34 36.19-17.34 43.88 0l64 144c5.375 12.11-.0625 26.3-12.19 31.69C230.6 351.3 227.3 352 224 352c-9.188 0-17.97-5.312-21.94-14.25L193.1 319.6C193.3 319.7 192.7 320 192 320H128c-.707 0-1.305-.3418-1.996-.4023l-8.066 18.15c-5.406 12.14-19.69 17.55-31.69 12.19C74.13 344.5 68.69 330.4 74.06 318.3z"
                                                        fill="#FEBD2F" />
                                                </svg>
                                            </span>
                                            <span class="drp-text">{{ Str::upper($currantLang) }}</span>
                                            <div class="lang-icn">

                                            </div>
                                        </a>
                                        <div class="menu-dropdown">
                                            <ul>
                                                @foreach ($languages as $code => $language)
                                                    <li><a href="{{ route('change.languagestore', [$code]) }}"
                                                            class="@if ($language == $currantLang) active-language text-primary @endif">{{ ucFirst($language) }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="cart-header ">
                                        <a href="javascript:;" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14" viewBox="0 0 17 14" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4504 8.90368H6.43855C5.48981 8.90395 4.67569 8.22782 4.50176 7.29517L3.58917 2.35144C3.53142 2.03558 3.25368 1.80784 2.93263 1.81308H1.40947C1.04687 1.81308 0.75293 1.51913 0.75293 1.15654C0.75293 0.793942 1.04687 0.5 1.40947 0.5H2.94577C3.8945 0.499732 4.70862 1.17586 4.88255 2.10852L5.79514 7.05225C5.85289 7.3681 6.13063 7.59584 6.45168 7.59061H13.4569C13.778 7.59584 14.0557 7.3681 14.1135 7.05225L14.9407 2.58779C14.9761 2.3943 14.923 2.19512 14.7958 2.04506C14.6686 1.89499 14.4808 1.80986 14.2842 1.81308H6.66177C6.29917 1.81308 6.00523 1.51913 6.00523 1.15654C6.00523 0.793942 6.29917 0.5 6.66177 0.5H14.2776C14.8633 0.499835 15.4187 0.760337 15.793 1.2108C16.1673 1.66126 16.3218 2.25494 16.2144 2.83071L15.3872 7.29517C15.2132 8.22782 14.3991 8.90395 13.4504 8.90368ZM9.28827 11.5304C9.28827 10.4426 8.40644 9.56081 7.31866 9.56081C6.95606 9.56081 6.66212 9.85475 6.66212 10.2173C6.66212 10.5799 6.95606 10.8739 7.31866 10.8739C7.68125 10.8739 7.97519 11.1678 7.97519 11.5304C7.97519 11.893 7.68125 12.187 7.31866 12.187C6.95606 12.187 6.66212 11.893 6.66212 11.5304C6.66212 11.1678 6.36818 10.8739 6.00558 10.8739C5.64299 10.8739 5.34904 11.1678 5.34904 11.5304C5.34904 12.6182 6.23087 13.5 7.31866 13.5C8.40644 13.5 9.28827 12.6182 9.28827 11.5304ZM13.2277 12.8432C13.2277 12.4806 12.9338 12.1867 12.5712 12.1867C12.2086 12.1867 11.9146 11.8928 11.9146 11.5302C11.9146 11.1676 12.2086 10.8736 12.5712 10.8736C12.9338 10.8736 13.2277 11.1676 13.2277 11.5302C13.2277 11.8928 13.5217 12.1867 13.8843 12.1867C14.2468 12.1867 14.5408 11.8928 14.5408 11.5302C14.5408 10.4424 13.659 9.56055 12.5712 9.56055C11.4834 9.56055 10.6016 10.4424 10.6016 11.5302C10.6016 12.6179 11.4834 13.4998 12.5712 13.4998C12.9338 13.4998 13.2277 13.2058 13.2277 12.8432Z" fill="#0A062D"></path>
                                            </svg>
                                            {{ __('Cart')}}: {{ $currency_icon }}<span class="desk-only icon-lable" id="sub_total_main_page">  {{ 0 }}</span>
                                            <div class="cart-badge">
                                                <span class="count">{!! \App\Models\Cart::CartCount() !!} </span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mobile-menu mobile-only">
                                <button class="mobile-menu-button" id="menu">
                                    <div class="one"></div>
                                    <div class="two"></div>
                                    <div class="three"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile menu start here -->



    <!-- Mobile menu end here -->
    <div class="search-popup">
        <div class="close-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                <path
                    d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                    fill="white"></path>
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
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--header end here-->
</header>


@push('page-script')
<script>
    $(document).ready(function () {
        var responseData;

        $(".search_input").on('keyup', function (e) {
            e.preventDefault();
            var product = $(this).val();

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
        });

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
