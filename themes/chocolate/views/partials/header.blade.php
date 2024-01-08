<!DOCTYPE html>
<html>
@php
    $theme_json = $homepage_json;
    if (Auth::user()) {
        $carts = App\Models\Cart::where('user_id', Auth::user()->id)
            ->where('theme_id', env('APP_THEME'))
            ->get();
        $cart_product_count = $carts->count();
    }
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp


<!--header start here-->
<header class="site-header header-style-one">
    <div class="announcebar">
        <div class="container">
            <div class="announce-row row align-items-center">
                <div class="annoucebar-left col-6 d-flex">
                    @php
                        $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = '';
                        $homepage_header_1_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-header-header-text') {
                                    $contact_us_header_worktime = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-header-call-label') {
                                    $contact_us_header_calling = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-header-contact') {
                                    $contact_us_header_call = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <p>
                            {!! $contact_us_header_worktime !!}
                        </p>
                    @endif
                </div>
                <div class="announcebar-right col-6 d-flex justify-content-end">
                    <ul class="d-flex">
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
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center">
                <div class="logo-col">
                    <h1>
                        <a href="{{ route('landing_page',$slug) }}">
                            <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                alt="Style theme">
                        </a>
                    </h1>
                </div>
                <div class="menu-items-col right-side-header">
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="#" class="category-btn active">
                                {{ __('All categories') }}
                            </a>
                            @if ($has_subcategory)
                                <div class="mega-menu menu-dropdown">
                                    <div class="mega-menu-container container">
                                        <ul class="row">
                                                @foreach ($MainCategoryList as $category)
                                                <li class="col-md-2 col-12">
                                                    <ul class="megamenu-list arrow-list">
                                                        <li class="list-title"><span>{{ $category->name }}</span></li>
                                                        <li><a
                                                                href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ __('All') }}</a>
                                                        </li>
                                                        @foreach ($SubCategoryList as $cat)
                                                            @if ($cat->maincategory_id == $category->id)
                                                                <li><a
                                                                        href="{{ route('page.product-list', [$slug,'main_category' => $category->id, 'sub_category' => $cat->id]) }}">{{ $cat->name }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                            <li class="col-md-3 col-12">
                                                <a href="#">
                                                    <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/product-img-1.png') }}"
                                                        alt="chocolate">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="menu-dropdown">
                                    <ul>
                                        @foreach ($MainCategoryList as $category)
                                            <li><a
                                                    href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                        <li class="menu-lnk has-item">
                            <a href="#">
                                {{ __('Pages') }}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($pages as $page)
                                        {{-- <li><a href="{{env('APP_URL').'page/'.$page->page_slug}}">{{$page->name}}</a></li> --}}
                                        <li><a
                                                href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                        </li>
                                    @endforeach
                                    <li><a href="{{ route('page.faq',$slug) }}">{{ __('FAQs') }}</a></li>
                                    <li><a href="{{ route('page.blog',$slug) }}">{{ __('Blog') }}</a></li>
                                    <li><a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a>
                                </ul>
                            </div>
                        </li>


                        @auth
                            <li class="menu-lnk has-item">
                                <a href="#">
                                    <span class="menu-lnk">{{ __('My profile') }}</span>
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        <li><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout_user',$slug) }}" id="form_logout">
                                                <a href="#"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="dropdown-item">
                                                    <i class=""></i>
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
                            <li class="menu-dropdown">
                                <a href="{{ route('login',$slug) }}">

                                    <span class="">{{ __('Login') }}</span>
                                </a>
                            </li>

                        @endguest
                        <li class="menu-lnk ">
                            <a href="{{ route('page.contact_us',$slug) }}">
                                {{ __('Contact') }}
                            </a>
                        </li>
                    </ul>
                    <ul class="menu-right d-flex  justify-content-end align-items-center">
                        <a href="tel:+00 544-213-615" class="phone-icons">
                            <svg height="22" viewBox="0 0 48 48" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49 2.24.74 4.65 1.14 7.14 1.14 1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2-18.78 0-34-15.22-34-34 0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"
                                    fill="#fff"></path>
                            </svg>
                        </a>
                        <li class="profile-header">
                            <div class="profile-suport">
                                @if ($homepage_header_1['section_enable'] == 'on')
                                    <span>{!! $contact_us_header_calling !!}</span>
                                    <a href="tel:+00 544-213-615">
                                        <span class="support-span">{!! $contact_us_header_call !!}</span>
                                    </a>
                                @endif
                            </div>
                        </li>

                        <li class="cart-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                    viewBox="0 0 19 17" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                        fill="white" />
                                </svg>
                                <span>  {{ GetCurrency() }}
                                   <span  id="sub_total_main_page">{{ 0 }}</span>
                                </span>
                                <svg class="bottom-icons-header" xmlns="http://www.w3.org/2000/svg" width="12"
                                    height="10" viewBox="0 0 8 5" fill="none">
                                    <path d="M1 1L4 4L7 1" stroke="white" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
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
    <!------MOBILE MENU START ------>
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
                    <a href="#" class="acnav-label">
                        {{__('Shop All')}}
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
                <li class="mobile-item">
                    <a href="{{route('page.product-list',$slug)}}" class="acnav-label">
                        {{__('Collection')}}

                    </a>

                </li>
                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        {{ __('Pages') }}
                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                            viewBox="0 0 20 11">
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
                                <li>
                                    <a href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{$page->name}}</a>
                                </li>
                                @endforeach
                                <li><a href="{{route('page.faq',$slug)}}">{{__('FAQs')}}</a></li>
                                <li><a href="{{route('page.blog',$slug)}}">{{__('Blog')}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="mobile-item">
                    <a href="{{route('page.faq',$slug)}}">FAQs</a>
                </li>
                <li class="mobile-item">
                    <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact Us') }}</a>
                </li>

            </ul>
        </div>
    </div>
</header>
<!--cart popup start-->

</body>

</html>
