@php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    // dd($theme_logo);
    $store = \App\Models\Store::where('slug', $slug)->where('is_active', '1')->first();
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    // dd($currantLang);
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp

<style>
    .profile-header {
        padding: 12px 0;
    }
    .profile-header .menu-dropdown li{
        margin: 20px;
    }
    .profile-header .menu-dropdown {
        position: absolute;
        background-color: var(--theme-color);
        z-index: 8;
        display: none;
        top: 35px !important;
       
    }
    .profile-header:hover .menu-dropdown{
        display: block;
    }
    .search-form-wrapper .menu-dropdown {
        left: 50%;
        transform: translateX(-50%);
    }
</style>
<style>
    .profile-headers .menu-dropdown li{
        margin: 14px 10px;
        line-height: 1;
    }
    .profile-headers .menu-dropdown {
        position: absolute;
        background-color: var(--theme-color);
        z-index: 8;
        top: 39px;
        display: none;
        width: 100%;
        border: 1px solid #284C4E;
    }
    .profile-headers:hover .menu-dropdown{
        display: block;
    }
</style>
<header class="site-header header-style-one">
    <div class="announcebar">
        <div class="container">
                @php
                    $homepage_footer_section1_title = $homepage_footer_section1_label = $homepage_footer_section1_support = $homepage_footer_section1_offer='';

                    $homepage_footer_key1 = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_footer_key1 != '') {
                        $homepage_footer_section1 = $theme_json[$homepage_footer_key1];

                    foreach ($homepage_footer_section1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-header-label-text') {
                        $homepage_footer_section1_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-support-label') {
                        $homepage_footer_section1_label = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-support-text') {
                        $homepage_footer_section1_support = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-offer-text') {
                        $homepage_footer_section1_offer= $value['field_default_text'];
                        }
                    }
                    }
                @endphp
            {{-- @if ($homepage_footer_section1['section_enable'] == 'on') --}}

            <div class="announce-row row align-items-center">
                <div class="annoucebar-left col-6 d-flex">
                    <p>
                        {!!$homepage_footer_section1_title!!}
                    </p>
                </div>
                <div class="announcebar-right col-6 d-flex justify-content-end">
                    <a href="tel:+12 002-224-111">
                        <span>{!! $homepage_footer_section1_label !!}<b>{!! $homepage_footer_section1_support!!}</b></span>
                    </a>
                    <button id="announceclose">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation"
                            class="icon icon-close" viewBox="0 0 18 17">
                            <path
                                d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-header-wrapper">
        <div class="top-header">
            <div class="logo-col">

                <h1>
                    <a href="{{route('landing_page',$slug)}}">
                        <img src="{{isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/'.APP_THEME().'/assets/images/logo.png'}}" alt="Nav brand">
                    </a>
                </h1>
            </div>
            <div class="right-side-header">
                <div class="search-form-wrapper">
                    <form>
                        <div class="form-inputs">
                            <input type="search" placeholder="Search Product..." class="form-control search_input" list="products" name="search_product" id="product" >
                            <datalist id="products">
                                {{-- @foreach ($search_products as $pro_id => $pros)
                                    <option value="{{$pros}}"></option>
                                @endforeach --}}
                            </datalist>
                            <button type="submit" class="btn search_product_globaly">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                    viewBox="0 0 13 13" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.47487 10.5131C8.48031 11.2863 7.23058 11.7466 5.87332 11.7466C2.62957 11.7466 0 9.11706 0 5.87332C0 2.62957 2.62957 0 5.87332 0C9.11706 0 11.7466 2.62957 11.7466 5.87332C11.7466 7.23058 11.2863 8.48031 10.5131 9.47487L12.785 11.7465C13.0717 12.0332 13.0717 12.4981 12.785 12.7848C12.4983 13.0715 12.0334 13.0715 11.7467 12.7848L9.47487 10.5131ZM10.2783 5.87332C10.2783 8.30612 8.30612 10.2783 5.87332 10.2783C3.44051 10.2783 1.46833 8.30612 1.46833 5.87332C1.46833 3.44051 3.44051 1.46833 5.87332 1.46833C8.30612 1.46833 10.2783 3.44051 10.2783 5.87332Z"
                                        fill="#545454" />
                                </svg>
                            </button>
                        </div>
                        <li class=" form-select profile-headers">
                            <a href="#">
                                {{__('All Categories')}}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($MainCategoryList as $category)
                                      <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        
                    </form>
                    
                </div>
                <div class="store-info-wrapper">
                    {{-- <div class="store-info-block">
                        <p>{!!$homepage_footer_section1_title!!}</p>
                    </div> --}}
                    <div class="store-info-block">
                        <a href="tel:+12 002-224-111"><span class="label">{!! $homepage_footer_section1_label !!}</span> <b>{!! $homepage_footer_section1_support!!}</b></a>
                    </div>
                </div>

                <div class="header-info-end">
                    <ul class="menu-right d-flex align-items-center  justify-content-end">
                        <li class="search-header mobile-only">
                            <a href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                    viewBox="0 0 13 13" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.47487 10.5131C8.48031 11.2863 7.23058 11.7466 5.87332 11.7466C2.62957 11.7466 0 9.11706 0 5.87332C0 2.62957 2.62957 0 5.87332 0C9.11706 0 11.7466 2.62957 11.7466 5.87332C11.7466 7.23058 11.2863 8.48031 10.5131 9.47487L12.785 11.7465C13.0717 12.0332 13.0717 12.4981 12.785 12.7848C12.4983 13.0715 12.0334 13.0715 11.7467 12.7848L9.47487 10.5131ZM10.2783 5.87332C10.2783 8.30612 8.30612 10.2783 5.87332 10.2783C3.44051 10.2783 1.46833 8.30612 1.46833 5.87332C1.46833 3.44051 3.44051 1.46833 5.87332 1.46833C8.30612 1.46833 10.2783 3.44051 10.2783 5.87332Z"
                                        fill="#545454"></path>
                                </svg>
                            </a>
                        </li>


                        @auth
                        <li class="profile-header">
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
                                    <li class="menu-lnk has-item"><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
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
                    @auth
                        <li class="wishlist-header wish-header">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                    viewBox="0 0 20 16" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.6295 3.52275C10.2777 3.85668 9.7223 3.85668 9.37055 3.52275L8.74109 2.92517C8.00434 2.22574 7.00903 1.79867 5.90909 1.79867C3.64974 1.79867 1.81818 3.61057 1.81818 5.84567C1.81818 7.98845 2.99071 9.75782 4.68342 11.2116C6.37756 12.6666 8.40309 13.6316 9.61331 14.1241C9.86636 14.2271 10.1336 14.2271 10.3867 14.1241C11.5969 13.6316 13.6224 12.6666 15.3166 11.2116C17.0093 9.75782 18.1818 7.98845 18.1818 5.84567C18.1818 3.61057 16.3503 1.79867 14.0909 1.79867C12.991 1.79867 11.9957 2.22574 11.2589 2.92517L10.6295 3.52275ZM10 1.62741C8.93828 0.619465 7.49681 0 5.90909 0C2.64559 0 0 2.6172 0 5.84567C0 11.5729 6.33668 14.7356 8.92163 15.7875C9.61779 16.0708 10.3822 16.0708 11.0784 15.7875C13.6633 14.7356 20 11.5729 20 5.84567C20 2.6172 17.3544 0 14.0909 0C12.5032 0 11.0617 0.619465 10 1.62741Z"
                                        fill="#545454" />
                                </svg>
                                <span class="count">{!! \App\Models\Wishlist::WishCount() !!}</span>
                            </a>
                        </li>
                    @endauth
                        <li class="cart-header">
                            <a href="javascript:;">
                            <span class="icon-lable desk-only" > {{__('My Cart:')}} <b> </b>
                                    <span id ="sub_total_main_page">{{0}}</span>
                                    {{ $currency }}

                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                    viewBox="0 0 19 19" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.91797 15.8359C7.91797 17.1476 6.85465 18.2109 5.54297 18.2109C4.23129 18.2109 3.16797 17.1476 3.16797 15.8359C3.16797 14.5243 4.23129 13.4609 5.54297 13.4609C6.85465 13.4609 7.91797 14.5243 7.91797 15.8359ZM6.33464 15.8359C6.33464 16.2732 5.98019 16.6276 5.54297 16.6276C5.10574 16.6276 4.7513 16.2732 4.7513 15.8359C4.7513 15.3987 5.10574 15.0443 5.54297 15.0443C5.98019 15.0443 6.33464 15.3987 6.33464 15.8359Z"
                                        fill="#545454" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.8346 15.8359C15.8346 17.1476 14.7713 18.2109 13.4596 18.2109C12.148 18.2109 11.0846 17.1476 11.0846 15.8359C11.0846 14.5243 12.148 13.4609 13.4596 13.4609C14.7713 13.4609 15.8346 14.5243 15.8346 15.8359ZM14.2513 15.8359C14.2513 16.2732 13.8969 16.6276 13.4596 16.6276C13.0224 16.6276 12.668 16.2732 12.668 15.8359C12.668 15.3987 13.0224 15.0443 13.4596 15.0443C13.8969 15.0443 14.2513 15.3987 14.2513 15.8359Z"
                                        fill="#545454" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.66578 2.01983C1.86132 1.62876 2.33685 1.47025 2.72792 1.66578L3.52236 2.06301C4.25803 2.43084 4.75101 3.15312 4.82547 3.97225L4.86335 4.38888C4.88188 4.59276 5.05283 4.74887 5.25756 4.74887H15.702C17.0838 4.74887 18.0403 6.12909 17.5551 7.42297L16.1671 11.1245C15.8195 12.0514 14.9333 12.6655 13.9433 12.6655H6.19479C4.96644 12.6655 3.94076 11.7289 3.82955 10.5056L3.24864 4.1156C3.22382 3.84255 3.05949 3.60179 2.81427 3.47918L2.01983 3.08196C1.62876 2.88643 1.47025 2.41089 1.66578 2.01983ZM5.47346 6.3322C5.2407 6.3322 5.05818 6.53207 5.07926 6.76388L5.40638 10.3622C5.44345 10.77 5.78534 11.0822 6.19479 11.0822H13.9433C14.2733 11.0822 14.5687 10.8775 14.6845 10.5685L16.0726 6.86702C16.1696 6.60825 15.9783 6.3322 15.702 6.3322H5.47346Z"
                                        fill="#545454" />
                                </svg>
                                <span class="count"{!! \App\Models\Cart::CartCount() !!} ></span>
                            </a>
                        </li>
                        <li class="menu-lnk has-item lang-dropdown">
                            <a href="#">
                                <span class="link-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="24px"><path d="M160 243.1L147.2 272h25.69L160 243.1zM576 63.1L336 64v384l240 0c35.35 0 64-28.65 64-64v-256C640 92.65 611.3 63.1 576 63.1zM552 232h-1.463c-8.082 27.78-21.06 49.29-35.06 66.34c7.854 4.943 13.33 7.324 13.46 7.375c12.22 5 18.19 18.94 13.28 31.19C538.4 346.3 529.5 352 519.1 352c-2.906 0-5.875-.5313-8.75-1.672c-1-.3906-14.33-5.951-31.26-18.19c-16.69 12.04-29.9 17.68-31.18 18.19C445.9 351.5 442.9 352 440 352c-9.562 0-18.59-5.766-22.34-15.2c-4.844-12.3 1.188-26.19 13.44-31.08c.748-.3047 6.037-2.723 13.25-7.189c-3.375-4.123-6.742-8.324-9.938-13.03c-7.469-10.97-4.594-25.89 6.344-33.34c11.03-7.453 25.91-4.594 33.34 6.375c1.883 2.77 3.881 5.186 5.854 7.682C487.3 256.8 494.1 245.5 499.5 232H408C394.8 232 384 221.3 384 208S394.8 184 408 184h48c0-13.25 10.75-24 24-24S504 170.8 504 184h48c13.25 0 24 10.75 24 24S565.3 232 552 232zM0 127.1v256c0 35.35 28.65 64 64 64L304 448V64L64 63.1C28.65 63.1 0 92.65 0 127.1zM74.06 318.3l64-144c7.688-17.34 36.19-17.34 43.88 0l64 144c5.375 12.11-.0625 26.3-12.19 31.69C230.6 351.3 227.3 352 224 352c-9.188 0-17.97-5.312-21.94-14.25L193.1 319.6C193.3 319.7 192.7 320 192 320H128c-.707 0-1.305-.3418-1.996-.4023l-8.066 18.15c-5.406 12.14-19.69 17.55-31.69 12.19C74.13 344.5 68.69 330.4 74.06 318.3z" fill="#FEBD2F"/></svg>
                                </span>
                                <span class="drp-text">{{ Str::upper($currantLang) }}</span>
                                <div class="lang-icn">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" version="1.1" id="svg2223" xml:space="preserve" width="682.66669" height="682.66669" viewBox="0 0 682.66669 682.66669">
                                    <g id="g2229" transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)"><g id="g2231"><g id="g2233" clip-path="url(#clipPath2237)"><g id="g2239" transform="translate(497,256)"><path d="m 0,0 c 0,-132.548 -108.452,-241 -241,-241 -132.548,0 -241,108.452 -241,241 0,132.548 108.452,241 241,241 C -108.452,241 0,132.548 0,0 Z" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2241"/></g><g id="g2243" transform="translate(376,256)"><path d="m 0,0 c 0,-132.548 -53.726,-241 -120,-241 -66.274,0 -120,108.452 -120,241 0,132.548 53.726,241 120,241 C -53.726,241 0,132.548 0,0 Z" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2245"/></g><g id="g2247" transform="translate(256,497)"><path d="M 0,0 V -482" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2249"/></g><g id="g2251" transform="translate(15,256)"><path d="M 0,0 H 482" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2253"/></g><g id="g2255" transform="translate(463.8926,136)"><path d="M 0,0 H -415.785" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2257"/></g><g id="g2259" transform="translate(48.1079,377)"><path d="M 0,0 H 415.785" style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" id="path2261"/></g></g></g></g></svg>
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
                        <div class="mobile-menu">
                            <button class="mobile-menu-button" id="menu">
                                <div class="one"></div>
                                <div class="two"></div>
                                <div class="three"></div>
                            </button>
                        </div>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center justify-content-between">
                {{-- @if (\Request::route()->getName() != 'landing_page') --}}
                    <div class="menu-items-col">
                        <ul class="main-nav">
                            <li class="menu-lnk has-item">
                                <a href="#" class="category-btn active">
                                    <span class="link-icon">
                                        <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 7.15C8.2763 7.15 7.92491 7.18438 7.5591 7.23448C7.3882 7.25788 7.25788 7.3882 7.23448 7.5591C7.18438 7.92491 7.15 8.2763 7.15 8.525C7.15 8.7737 7.18438 9.12509 7.23448 9.4909C7.25788 9.6618 7.3882 9.79212 7.5591 9.81552C7.92491 9.86562 8.2763 9.9 8.525 9.9C8.7737 9.9 9.12509 9.86562 9.4909 9.81552C9.6618 9.79212 9.79212 9.6618 9.81552 9.4909C9.86562 9.12509 9.9 8.7737 9.9 8.525C9.9 8.2763 9.86562 7.92491 9.81552 7.5591C9.79212 7.3882 9.6618 7.25788 9.4909 7.23448C9.12509 7.18438 8.7737 7.15 8.525 7.15ZM7.40984 6.14465C6.74989 6.23503 6.23503 6.74989 6.14465 7.40984C6.09281 7.78836 6.05 8.19949 6.05 8.525C6.05 8.85051 6.09281 9.26165 6.14465 9.64016C6.23503 10.3001 6.74989 10.815 7.40984 10.9053C7.78836 10.9572 8.19949 11 8.525 11C8.85051 11 9.26165 10.9572 9.64016 10.9053C10.3001 10.815 10.815 10.3001 10.9053 9.64016C10.9572 9.26165 11 8.85051 11 8.525C11 8.19949 10.9572 7.78836 10.9053 7.40984C10.815 6.74989 10.3001 6.23503 9.64016 6.14465C9.26165 6.09281 8.85051 6.05 8.525 6.05C8.19949 6.05 7.78836 6.09281 7.40984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 7.15C2.2263 7.15 1.87491 7.18438 1.5091 7.23448C1.3382 7.25788 1.20788 7.3882 1.18448 7.5591C1.13438 7.92491 1.1 8.2763 1.1 8.525C1.1 8.7737 1.13438 9.12509 1.18448 9.4909C1.20788 9.6618 1.3382 9.79212 1.5091 9.81552C1.87491 9.86562 2.2263 9.9 2.475 9.9C2.7237 9.9 3.07509 9.86562 3.4409 9.81552C3.6118 9.79212 3.74212 9.6618 3.76552 9.4909C3.81562 9.12509 3.85 8.7737 3.85 8.525C3.85 8.2763 3.81562 7.92491 3.76552 7.5591C3.74212 7.3882 3.6118 7.25788 3.4409 7.23448C3.07509 7.18438 2.7237 7.15 2.475 7.15ZM1.35984 6.14465C0.699894 6.23503 0.185033 6.74989 0.0946504 7.40984C0.0428112 7.78836 0 8.19949 0 8.525C0 8.85051 0.0428112 9.26165 0.0946504 9.64016C0.185033 10.3001 0.699894 10.815 1.35984 10.9053C1.73836 10.9572 2.14949 11 2.475 11C2.80051 11 3.21165 10.9572 3.59016 10.9053C4.25011 10.815 4.76497 10.3001 4.85535 9.64016C4.90719 9.26165 4.95 8.85051 4.95 8.525C4.95 8.19949 4.90719 7.78836 4.85535 7.40984C4.76497 6.74989 4.25011 6.23503 3.59016 6.14465C3.21165 6.09281 2.80051 6.05 2.475 6.05C2.14949 6.05 1.73836 6.09281 1.35984 6.14465Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.525 1.1C8.2763 1.1 7.92491 1.13438 7.5591 1.18448C7.3882 1.20788 7.25788 1.3382 7.23448 1.5091C7.18438 1.87491 7.15 2.2263 7.15 2.475C7.15 2.7237 7.18438 3.07509 7.23448 3.4409C7.25788 3.6118 7.3882 3.74212 7.5591 3.76552C7.92491 3.81562 8.2763 3.85 8.525 3.85C8.7737 3.85 9.12509 3.81562 9.4909 3.76552C9.6618 3.74212 9.79212 3.6118 9.81552 3.4409C9.86562 3.07509 9.9 2.7237 9.9 2.475C9.9 2.2263 9.86562 1.87491 9.81552 1.5091C9.79212 1.3382 9.6618 1.20788 9.4909 1.18448C9.12509 1.13438 8.7737 1.1 8.525 1.1ZM7.40984 0.0946504C6.74989 0.185033 6.23503 0.699894 6.14465 1.35984C6.09281 1.73836 6.05 2.14949 6.05 2.475C6.05 2.80051 6.09281 3.21165 6.14465 3.59016C6.23503 4.25011 6.74989 4.76497 7.40984 4.85535C7.78836 4.90719 8.19949 4.95 8.525 4.95C8.85051 4.95 9.26165 4.90719 9.64016 4.85535C10.3001 4.76497 10.815 4.25011 10.9053 3.59016C10.9572 3.21165 11 2.80051 11 2.475C11 2.14949 10.9572 1.73836 10.9053 1.35984C10.815 0.699894 10.3001 0.185033 9.64016 0.0946504C9.26165 0.0428112 8.85051 0 8.525 0C8.19949 0 7.78836 0.0428112 7.40984 0.0946504Z"
                                                fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.475 1.1C2.2263 1.1 1.87491 1.13438 1.5091 1.18448C1.3382 1.20788 1.20788 1.3382 1.18448 1.5091C1.13438 1.87491 1.1 2.2263 1.1 2.475C1.1 2.7237 1.13438 3.07509 1.18448 3.4409C1.20788 3.6118 1.3382 3.74212 1.5091 3.76552C1.87491 3.81562 2.2263 3.85 2.475 3.85C2.7237 3.85 3.07509 3.81562 3.4409 3.76552C3.6118 3.74212 3.74212 3.6118 3.76552 3.4409C3.81562 3.07509 3.85 2.7237 3.85 2.475C3.85 2.2263 3.81562 1.87491 3.76552 1.5091C3.74212 1.3382 3.6118 1.20788 3.4409 1.18448C3.07509 1.13438 2.7237 1.1 2.475 1.1ZM1.35984 0.0946504C0.699894 0.185033 0.185033 0.699894 0.0946504 1.35984C0.0428112 1.73836 0 2.14949 0 2.475C0 2.80051 0.0428112 3.21165 0.0946504 3.59016C0.185033 4.25011 0.699894 4.76497 1.35984 4.85535C1.73836 4.90719 2.14949 4.95 2.475 4.95C2.80051 4.95 3.21165 4.90719 3.59016 4.85535C4.25011 4.76497 4.76497 4.25011 4.85535 3.59016C4.90719 3.21165 4.95 2.80051 4.95 2.475C4.95 2.14949 4.90719 1.73836 4.85535 1.35984C4.76497 0.699894 4.25011 0.185033 3.59016 0.0946504C3.21165 0.0428112 2.80051 0 2.475 0C2.14949 0 1.73836 0.0428112 1.35984 0.0946504Z"
                                                fill="white"></path>
                                        </svg>
                                    </span>
                                    {{__('All Categories')}}
                                </a>
                                @if ($has_subcategory)
                                    <div class="mega-menu menu-dropdown">
                                        <div class="mega-menu-container container">
                                            <ul class="row">
                                                @foreach ($MainCategoryList as $category)
                                                <li class="col-md-3 col-12">
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
                            @foreach ($MainCategoryList as $category)
                                <li class="">
                                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">
                                        <span class="link-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                viewBox="0 0 13 13" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.19178 10.2779C6.37663 10.1508 6.6207 10.1508 6.80555 10.2779L7.11244 10.4889C7.45128 10.7219 7.79006 10.8333 8.12365 10.8333C8.72841 10.8333 9.38816 10.4492 9.95049 9.66199C10.5068 8.8832 10.832 7.88189 10.832 7.04167C10.832 5.47332 9.69207 4.33333 8.12365 4.33333C7.68321 4.33333 7.28574 4.4228 6.9418 4.57698L6.72023 4.6763C6.57928 4.73948 6.41805 4.73949 6.2771 4.6763L6.05553 4.57698C5.71158 4.4228 5.31409 4.33333 4.87365 4.33333C3.30527 4.33333 2.16536 5.47328 2.16536 7.04167C2.16536 7.88191 2.49061 8.88322 3.04688 9.662C3.60918 10.4492 4.2689 10.8333 4.87365 10.8333C5.20724 10.8333 5.54603 10.7219 5.88489 10.4889L6.19178 10.2779ZM6.49866 3.58842C6.98579 3.37006 7.53471 3.25 8.12365 3.25C10.2904 3.25 11.9154 4.875 11.9154 7.04167C11.9154 9.20833 10.2904 11.9167 8.12365 11.9167C7.53471 11.9167 6.98579 11.7166 6.49866 11.3816C6.01152 11.7166 5.4626 11.9167 4.87365 11.9167C2.70694 11.9167 1.08203 9.20833 1.08203 7.04167C1.08203 4.875 2.70694 3.25 4.87365 3.25C5.4626 3.25 6.01152 3.37006 6.49866 3.58842Z"
                                                    fill="white" />
                                                <path
                                                    d="M4.60286 6.5C4.45329 6.5 4.33203 6.62126 4.33203 6.77083V7.3125C4.33203 7.76123 4.6958 8.125 5.14453 8.125C5.29411 8.125 5.41536 8.00374 5.41536 7.85417V7.3125C5.41536 6.86377 5.0516 6.5 4.60286 6.5Z"
                                                    fill="white" />
                                                <path
                                                    d="M8.39453 6.5C8.54411 6.5 8.66536 6.62126 8.66536 6.77083V7.3125C8.66536 7.76123 8.3016 8.125 7.85286 8.125C7.70329 8.125 7.58203 8.00374 7.58203 7.85417V7.3125C7.58203 6.86377 7.9458 6.5 8.39453 6.5Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.33333 2.16732C5.04453 2.16732 5.64901 2.62419 5.8693 3.26046C5.96717 3.54315 6.20085 3.79232 6.5 3.79232C6.79915 3.79232 7.04732 3.54736 6.98819 3.25411C6.73859 2.01617 5.64482 1.08398 4.33333 1.08398H3.79167C3.49251 1.08398 3.25 1.3265 3.25 1.62565C3.25 1.92481 3.49251 2.16732 3.79167 2.16732H4.33333Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M10.832 2.34787C10.832 1.64985 10.2662 1.08398 9.56814 1.08398H7.94314C6.84624 1.08398 5.95703 1.9732 5.95703 3.0701C5.95703 3.76812 6.52289 4.33398 7.22092 4.33398H8.84592C9.94282 4.33398 10.832 3.44477 10.832 2.34787ZM9.56814 2.16732C9.66786 2.16732 9.7487 2.24816 9.7487 2.34787C9.7487 2.84646 9.34451 3.25065 8.84592 3.25065H7.22092C7.1212 3.25065 7.04036 3.16981 7.04036 3.0701C7.04036 2.57151 7.44455 2.16732 7.94314 2.16732H9.56814Z"
                                                    fill="white" />
                                            </svg>
                                        </span>
                                        {{$category->name}}
                                    </a>
                                    
                                </li>
                            @endforeach
                        
                            <li class="menu-lnk has-item">
                                <a href="#">
                                    <span class="link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                            viewBox="0 0 14 13" fill="none">
                                            <path
                                                d="M2.33464 9.20768C2.33464 9.50684 2.07347 9.74935 1.7513 9.74935C1.42914 9.74935 1.16797 9.50684 1.16797 9.20768C1.16797 8.90853 1.42914 8.66602 1.7513 8.66602C2.07347 8.66602 2.33464 8.90853 2.33464 9.20768Z"
                                                fill="white" />
                                            <path
                                                d="M2.33464 11.3743C2.33464 11.6735 2.07347 11.916 1.7513 11.916C1.42914 11.916 1.16797 11.6735 1.16797 11.3743C1.16797 11.0752 1.42914 10.8327 1.7513 10.8327C2.07347 10.8327 2.33464 11.0752 2.33464 11.3743Z"
                                                fill="white" />
                                            <path
                                                d="M4.08464 11.3743C4.4068 11.3743 4.66797 11.1318 4.66797 10.8327C4.66797 10.5335 4.4068 10.291 4.08464 10.291C3.76247 10.291 3.5013 10.5335 3.5013 10.8327C3.5013 11.1318 3.76247 11.3743 4.08464 11.3743Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.09628 1.6908C8.7797 1.05619 9.88774 1.05619 10.5712 1.6908L12.1796 3.18437C12.863 3.81897 12.863 4.84786 12.1796 5.48246L7.65449 9.68436C6.97107 10.319 5.86303 10.319 5.17962 9.68436L3.57116 8.19079C2.88774 7.55619 2.88774 6.5273 3.57116 5.8927L8.09628 1.6908ZM9.7462 2.45683L11.3547 3.9504C11.5825 4.16193 11.5825 4.50489 11.3547 4.71643L8.50876 7.35905L6.07534 5.09945L8.92124 2.45683C9.14905 2.24529 9.51839 2.24529 9.7462 2.45683ZM5.20034 5.91195L4.39611 6.65873C4.16831 6.87026 4.16831 7.21323 4.39611 7.42476L6.00457 8.91833C6.23238 9.12987 6.60173 9.12987 6.82953 8.91833L7.63376 8.17155L5.20034 5.91195Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                    {{__('Page')}}
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        @foreach ($pages as $page)
                                            @if($page->page_slug == 'contactus')
                                                <li><a href="{{ route('custom.page',[$slug,$page->page_slug]) }}">{{ __('Contact Us')}}</a></li>
                                            @else
                                                <li><a href="{{ route('custom.page',[$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                                            @endif
                                        @endforeach    
                                        <li><a href="{{route('page.faq',$slug)}}">{{__('FAQs')}}</a></li>
                                        <li><a href="{{route('page.blog',$slug)}}">{{__('Blog')}}</a></li>
                                        <li><a href="{{route('page.product-list',$slug)}}">{{__('Collection')}}</a>                      
                                    </ul>
                                </div>
                            </li>
                            <li class="">
                                <a href="{{route('page.product-list',[$slug,'filter_product' => 'best-selling' ])}}">
                                    <span class="link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                            viewBox="0 0 16 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.05935 3.37598L8.53356 2.72589C8.26679 2.39606 7.73788 2.39606 7.47111 2.72589L6.94532 3.37598C6.63964 3.75392 6.14025 3.94784 5.63905 3.88324L4.77693 3.77211C4.33952 3.71573 3.96553 4.06635 4.02567 4.47642L4.14421 5.28466C4.21312 5.75454 4.00626 6.22271 3.60313 6.50928L2.9097 7.00222C2.55788 7.25231 2.55788 7.74816 2.9097 7.99826L3.60313 8.49119C4.00626 8.77776 4.21312 9.24594 4.14421 9.71581L4.02567 10.5241C3.96553 10.9341 4.33952 11.2847 4.77693 11.2284L5.63905 11.1172C6.14025 11.0526 6.63964 11.2466 6.94532 11.6245L7.47111 12.2746C7.73788 12.6044 8.26679 12.6044 8.53356 12.2746L9.05936 11.6245C9.36503 11.2466 9.86442 11.0526 10.3656 11.1172L11.2277 11.2284C11.6652 11.2847 12.0391 10.9341 11.979 10.5241L11.8605 9.71581C11.7916 9.24594 11.9984 8.77776 12.4015 8.49119L13.095 7.99826C13.4468 7.74816 13.4468 7.25231 13.095 7.00222L12.4015 6.50928C11.9984 6.22271 11.7916 5.75454 11.8605 5.28466L11.979 4.47642C12.0391 4.06635 11.6652 3.71573 11.2277 3.77211L10.3656 3.88324C9.86442 3.94784 9.36503 3.75392 9.05935 3.37598ZM9.596 1.97064C8.79569 0.981141 7.20898 0.98114 6.40867 1.97064L5.88287 2.62074C5.86832 2.63873 5.84454 2.64797 5.82067 2.64489L4.95855 2.53376C3.64631 2.36461 2.52434 3.41647 2.70476 4.64668L2.8233 5.45493C2.82658 5.4773 2.81673 5.4996 2.79753 5.51324L2.1041 6.00618C1.04863 6.75647 1.04863 8.24401 2.1041 8.9943L2.79753 9.48724C2.81673 9.50088 2.82658 9.52318 2.8233 9.54555L2.70476 10.3538C2.52434 11.584 3.64631 12.6359 4.95855 12.4667L5.82067 12.3556C5.84454 12.3525 5.86832 12.3617 5.88287 12.3797L6.40867 13.0298C7.20898 14.0193 8.79569 14.0193 9.596 13.0298L10.1218 12.3797C10.1364 12.3617 10.1601 12.3525 10.184 12.3556L11.0461 12.4667C12.3584 12.6359 13.4803 11.584 13.2999 10.3538L13.1814 9.54555C13.1781 9.52318 13.1879 9.50088 13.2071 9.48724L13.9006 8.9943C14.956 8.24401 14.956 6.75647 13.9006 6.00618L13.2071 5.51324C13.1879 5.4996 13.1781 5.4773 13.1814 5.45493L13.2999 4.64668C13.4803 3.41647 12.3584 2.36461 11.0461 2.53376L10.184 2.64489C10.1601 2.64797 10.1364 2.63873 10.1218 2.62074L9.596 1.97064Z"
                                                fill="white" />
                                            <path
                                                d="M9.80474 6.69194L7.13807 9.19194C6.87772 9.43602 6.45561 9.43602 6.19526 9.19194C5.93491 8.94786 5.93491 8.55214 6.19526 8.30806L8.86193 5.80806C9.12228 5.56398 9.54439 5.56398 9.80474 5.80806C10.0651 6.05214 10.0651 6.44786 9.80474 6.69194Z"
                                                fill="white" />
                                            <path
                                                d="M7.33333 6.25C7.33333 6.59518 7.03486 6.875 6.66667 6.875C6.29848 6.875 6 6.59518 6 6.25C6 5.90482 6.29848 5.625 6.66667 5.625C7.03486 5.625 7.33333 5.90482 7.33333 6.25Z"
                                                fill="white" />
                                            <path
                                                d="M8.66667 8.75C8.66667 9.09518 8.96514 9.375 9.33333 9.375C9.70152 9.375 10 9.09518 10 8.75C10 8.40482 9.70152 8.125 9.33333 8.125C8.96514 8.125 8.66667 8.40482 8.66667 8.75Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                 {{__('Bestsellers')}}
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route('page.contact_us',$slug)}}">
                                    <span class="link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                            viewBox="0 0 16 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.05935 3.37598L8.53356 2.72589C8.26679 2.39606 7.73788 2.39606 7.47111 2.72589L6.94532 3.37598C6.63964 3.75392 6.14025 3.94784 5.63905 3.88324L4.77693 3.77211C4.33952 3.71573 3.96553 4.06635 4.02567 4.47642L4.14421 5.28466C4.21312 5.75454 4.00626 6.22271 3.60313 6.50928L2.9097 7.00222C2.55788 7.25231 2.55788 7.74816 2.9097 7.99826L3.60313 8.49119C4.00626 8.77776 4.21312 9.24594 4.14421 9.71581L4.02567 10.5241C3.96553 10.9341 4.33952 11.2847 4.77693 11.2284L5.63905 11.1172C6.14025 11.0526 6.63964 11.2466 6.94532 11.6245L7.47111 12.2746C7.73788 12.6044 8.26679 12.6044 8.53356 12.2746L9.05936 11.6245C9.36503 11.2466 9.86442 11.0526 10.3656 11.1172L11.2277 11.2284C11.6652 11.2847 12.0391 10.9341 11.979 10.5241L11.8605 9.71581C11.7916 9.24594 11.9984 8.77776 12.4015 8.49119L13.095 7.99826C13.4468 7.74816 13.4468 7.25231 13.095 7.00222L12.4015 6.50928C11.9984 6.22271 11.7916 5.75454 11.8605 5.28466L11.979 4.47642C12.0391 4.06635 11.6652 3.71573 11.2277 3.77211L10.3656 3.88324C9.86442 3.94784 9.36503 3.75392 9.05935 3.37598ZM9.596 1.97064C8.79569 0.981141 7.20898 0.98114 6.40867 1.97064L5.88287 2.62074C5.86832 2.63873 5.84454 2.64797 5.82067 2.64489L4.95855 2.53376C3.64631 2.36461 2.52434 3.41647 2.70476 4.64668L2.8233 5.45493C2.82658 5.4773 2.81673 5.4996 2.79753 5.51324L2.1041 6.00618C1.04863 6.75647 1.04863 8.24401 2.1041 8.9943L2.79753 9.48724C2.81673 9.50088 2.82658 9.52318 2.8233 9.54555L2.70476 10.3538C2.52434 11.584 3.64631 12.6359 4.95855 12.4667L5.82067 12.3556C5.84454 12.3525 5.86832 12.3617 5.88287 12.3797L6.40867 13.0298C7.20898 14.0193 8.79569 14.0193 9.596 13.0298L10.1218 12.3797C10.1364 12.3617 10.1601 12.3525 10.184 12.3556L11.0461 12.4667C12.3584 12.6359 13.4803 11.584 13.2999 10.3538L13.1814 9.54555C13.1781 9.52318 13.1879 9.50088 13.2071 9.48724L13.9006 8.9943C14.956 8.24401 14.956 6.75647 13.9006 6.00618L13.2071 5.51324C13.1879 5.4996 13.1781 5.4773 13.1814 5.45493L13.2999 4.64668C13.4803 3.41647 12.3584 2.36461 11.0461 2.53376L10.184 2.64489C10.1601 2.64797 10.1364 2.63873 10.1218 2.62074L9.596 1.97064Z"
                                                fill="white" />
                                            <path
                                                d="M9.80474 6.69194L7.13807 9.19194C6.87772 9.43602 6.45561 9.43602 6.19526 9.19194C5.93491 8.94786 5.93491 8.55214 6.19526 8.30806L8.86193 5.80806C9.12228 5.56398 9.54439 5.56398 9.80474 5.80806C10.0651 6.05214 10.0651 6.44786 9.80474 6.69194Z"
                                                fill="white" />
                                            <path
                                                d="M7.33333 6.25C7.33333 6.59518 7.03486 6.875 6.66667 6.875C6.29848 6.875 6 6.59518 6 6.25C6 5.90482 6.29848 5.625 6.66667 5.625C7.03486 5.625 7.33333 5.90482 7.33333 6.25Z"
                                                fill="white" />
                                            <path
                                                d="M8.66667 8.75C8.66667 9.09518 8.96514 9.375 9.33333 9.375C9.70152 9.375 10 9.09518 10 8.75C10 8.40482 9.70152 8.125 9.33333 8.125C8.96514 8.125 8.66667 8.40482 8.66667 8.75Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                    {{ __('Contact') }}
                                </a>
                            </li>
                        </ul>
                    </div>

            </div>
        </div>
    </div>


    <!-- Mobile menu start here -->
    <div class="mobile-menu-wrapper">
        <div class="menu-close-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                <path fill="#24272a"
                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
            </svg>
        </div>
        <div class="mobile-menu-bar">
            <ul>
                <li class="mobile-item has-children">
                    <a href="javascript:void(0)" class="acnav-label">
                        {{__('All Categories')}}
                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="11" viewBox="0 0 20 11">
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
                                @foreach ($MainCategoryList as $category)
                                <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
    
                    </ul>
                </li>
                <li class="mobile-item has-children">
                    <a href="javascript:void(0)" class="acnav-label">
                        {{__('Page')}}
                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="11" viewBox="0 0 20 11">
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
                                    @if($page->page_slug == 'contactus')
                                        <li><a href="{{ route('custom.page',[$slug,$page->page_slug]) }}">{{ __('Contact Us')}}</a></li>
                                    @else
                                        <li><a href="{{ route('custom.page',[$slug,$page->page_slug]) }}">{{$page->name}}</a></li>
                                    @endif
                                @endforeach
                                <li><a href="{{route('page.faq',$slug)}}">{{__('FAQs')}}</a></li>
                                <li><a href="{{route('page.blog',$slug)}}">{{__('Blog')}}</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="mobile-item has-children">
                    <a href="{{route('page.product-list',[$slug,'filter_product' => 'best-selling' ])}}" class="acnav-label">
                        {{__('Bestsellers')}}
                        
                    </a>
                </li>
                <li class="mobile-item has-children">
                    <a href="{{route('page.product-list',$slug)}}" class="acnav-label">
                        {{__('Collection')}}                        
                    </a>

                </li>
                <li class="mobile-item">
                    <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact Us') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Mobile search start here -->
    <div class="search-popup">
        <div class="close-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                fill="none">
                <path
                    d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                    fill="white"></path>
            </svg>
        </div>
        <div class="search-form-wrapper">
            <form>
                <div class="form-inputs">
                    <input type="search" placeholder="Search Product..." class="form-control">
                    <button type="submit" class="btn">
                        <svg>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                            </path>
                        </svg>
                    </button>
                    <div class="form-select">
                        <select>
                            <option value="Vegetable">Vegetable</option>
                            <option value="sweetener">Sweetener</option>
                            <option value="spices">spices</option>
                            <option value="fruits">Fruits</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>
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