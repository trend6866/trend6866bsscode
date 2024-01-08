<!DOCTYPE html>
<html lang="en">

<body>
    @php
        $theme_json = $homepage_json;
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $profile = asset(Storage::url('uploads/logo/'));
        $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
        $theme_logo = get_file($theme_logo, APP_THEME());
        if (Auth::user()) {
            $carts = App\Models\Cart::where('user_id', Auth::user()->id)
                ->where('theme_id', APP_THEME())
                ->get();
            $cart_product_count = $carts->count();
        }

        $route_name = \Request::route()->getName();
        $languages = \App\Models\Utility::languages();
        $currantLang = Cookie::get('LANGUAGE');
        if (!isset($currantLang)) {
            $currantLang = $store->default_language;
        }
    @endphp
    <style>
        .profile-header .menu-dropdown li {
            margin: 10px;
        }

        .profile-header .menu-dropdown {
            position: absolute;
            background-color: #01170e;
            z-index: 9;
            display: none;
        }

        .profile-header:hover .menu-dropdown {
            display: block;
        }
    </style>
    <header class="site-header header-style-one">
        <div class="main-navigationbar">
            <div class="container">
                <div class="navigationbar-row d-flex align-items-center right-side-header">
                    <div class="logo-col">
                        <h1>
                            <a href="{{ route('landing_page', $slug) }}">
                                <img
                                    src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}">
                            </a>
                        </h1>
                    </div>
                    <div class="menu-items-col">
                        <ul class="main-nav">
                            <li class="menu-lnk has-item">
                                <a href="#" class="category-btn active">
                                    {{ __('All products') }}
                                </a>
                                @if ($has_subcategory)
                                    <div class="mega-menu menu-dropdown">
                                        <div class="mega-menu-container container">
                                            <ul class="row">
                                                @foreach ($MainCategoryList as $category)
                                                    <li class="col-md-3 col-12">
                                                        <ul class="megamenu-list arrow-list">
                                                            <li class="list-title"><span>{{ $category->name }}</span>
                                                            </li>
                                                            <li><a
                                                                    href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ __('All') }}</a>
                                                            </li>
                                                            @foreach ($SubCategoryList as $cat)
                                                                @if ($cat->maincategory_id == $category->id)
                                                                    <li><a
                                                                            href="{{ route('page.product-list', [$slug, 'main_category' => $category->id, 'sub_category' => $cat->id]) }}">{{ $cat->name }}</a>
                                                                    </li>
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
                                                <li><a
                                                        href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                            <li class="menu-lnk has-item">
                                <a href="#" class="category-btn">
                                    {{ __('Pages') }}
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        @foreach ($pages as $page)
                                            <li><a
                                                    href="{{ route('custom.page', [$slug, $page->page_slug]) }}">{{ $page->name }}</a>
                                            </li>
                                        @endforeach
                                        <li><a href="{{ route('page.faq', $slug) }}">{{ __('FAQs') }}</a></li>
                                        <li><a href="{{ route('page.blog', $slug) }}">{{ __('Blog') }}</a></li>
                                        <li><a
                                                href="{{ route('page.product-list', $slug) }}">{{ __('Collection') }}</a>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-lnk">
                                <a href="{{ route('page.product-list', $slug) }}">
                                    {{ __('Shop All') }}
                                </a>
                            </li>
                            <li class="menu-lnk">
                                <a href="{{ route('page.contact_us', $slug) }}">
                                    {{ __('Contact') }}
                                </a>
                            </li>
                        </ul>
                        <ul class="menu-right d-flex justify-content-end align-items-center">
                            @auth
                                <ul class="main-nav">
                                    <li class="menu-lnk has-item">
                                        <a href="#" class="category-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22"
                                                viewBox="0 0 16 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                    fill="#fff"></path>
                                            </svg>
                                        </a>
                                        <div class="menu-dropdown">
                                            <ul>
                                                <li><a
                                                        href="{{ route('my-account.index', $slug) }}">{{ __('My Account') }}</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout_user', $slug) }}"
                                                        id="form_logout">
                                                        @csrf
                                                        <a href="{{ route('logout', $slug) }}"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            style="background-color: transparent; width: auto;">{{ __('Log Out') }}
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <li class="wishlist-icon heart-header">
                                    <a href="javascript:;" title="wish" class="wish-header">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8"
                                            viewBox="0 0 10 8" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.31473 1.76137C5.13885 1.92834 4.86115 1.92834 4.68527 1.76137L4.37055 1.46259C4.00217 1.11287 3.50452 0.899334 2.95455 0.899334C1.82487 0.899334 0.909091 1.80529 0.909091 2.92284C0.909091 3.99423 1.49536 4.87891 2.34171 5.6058C3.18878 6.33331 4.20155 6.8158 4.80666 7.06205C4.93318 7.11354 5.06682 7.11354 5.19334 7.06205C5.79845 6.8158 6.81122 6.33331 7.65829 5.6058C8.50464 4.87891 9.09091 3.99422 9.09091 2.92284C9.09091 1.80529 8.17513 0.899334 7.04545 0.899334C6.49548 0.899334 5.99783 1.11287 5.62946 1.46259L5.31473 1.76137ZM5 0.813705C4.46914 0.309733 3.74841 0 2.95455 0C1.3228 0 0 1.3086 0 2.92284C0 5.78643 3.16834 7.3678 4.46081 7.89376C4.80889 8.03541 5.19111 8.03541 5.53919 7.89376C6.83166 7.3678 10 5.78643 10 2.92284C10 1.3086 8.67721 0 7.04545 0C6.25159 0 5.53086 0.309733 5 0.813705Z"
                                                fill="white"></path>
                                        </svg>
                                        <span class="count"> {!! \App\Models\Wishlist::WishCount() !!}</span>
                                    </a>
                                </li>
                            @endauth

                            @guest
                                <li class="profile-header">
                                    <a href="{{ route('login', $slug) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22"
                                            viewBox="0 0 16 22" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                fill="#fff"></path>
                                        </svg>
                                    </a>
                                </li>
                            @endguest
                            <li class="cart-header">
                                <a href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                        viewBox="0 0 19 17" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                            fill="white"></path>
                                    </svg>
                                    <span class="count">4</span>
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
                        </ul>
                        <div class="mobile-menu">
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
        @php
            $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
            if ($homepage_header_1_key != '') {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if ($value['field_slug'] == 'homepage-header-title-text') {
                        $home_header_title_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-header-link-text') {
                        $home_header_link_text = $value['field_default_text'];
                    }
                    if ($value['field_slug'] == 'homepage-header-link') {
                        $home_header_link = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if ($homepage_header_1['section_enable'] == 'on')
            <div class="announcebar">
                <div class="container">
                    <div class="announce-row">
                        <div class="annoucebar-bottom">
                            <p>
                                {!! $home_header_title_text !!}
                                <a href="{{ $home_header_link }}">
                                    {!! $home_header_link_text !!}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
                        <a href="#" class="acnav-label">
                            {{ __('Shop All') }}
                            <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="11" viewBox="0 0 20 11">
                                <path fill="#24272a"
                                    d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                            </svg>
                            <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="18" viewBox="0 0 20 18">
                                <path fill="#24272a"
                                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                            </svg>
                        </a>
                        @if ($has_subcategory)
                            <ul class="mobile_menu_inner acnav-list">
                                @foreach ($MainCategoryList as $category)
                                    <li class="menu-h-link">
                                        <ul>
                                            <li>
                                                <span>{{ $category->name }}
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ __('All') }}</a>
                                            </li>
                                            @foreach ($SubCategoryList as $cat)
                                                @if ($cat->maincategory_id == $category->id)
                                                    <li><a
                                                            href="{{ route('page.product-list', [$slug, 'main_category' => $category->id, 'sub_category' => $cat->id]) }}">{{ $cat->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="mobile_menu_inner acnav-list">
                                <li class="menu-h-link">
                                    <ul>
                                        @foreach ($MainCategoryList as $category)
                                            <li>
                                                <a
                                                    href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    </li>
                    <li class="mobile-item">
                        <a href="{{ route('page.product-list', $slug) }}"> {{ __('Collection') }} </a>
                    </li>
                    <li class="mobile-item has-children">
                        <a href="#" class="acnav-label">
                            {{ __('Pages') }}
                            <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="11" viewBox="0 0 20 11">
                                <path fill="#24272a"
                                    d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                            </svg>
                            <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="18" viewBox="0 0 20 18">
                                <path fill="#24272a"
                                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                            </svg>
                        </a>
                        <ul class="mobile_menu_inner acnav-list">
                            <li class="menu-h-link">
                                <ul>
                                    @foreach ($pages as $page)
                                        <li><a
                                                href="{{ route('custom.page', [$slug, $page->page_slug]) }}">{{ $page->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                    <li><a href="{{ route('page.faq', $slug) }}"> {{ __('FAQs') }} </a></li>
                    </li>
                    <li class="mobile-item">
                        <a href="{{ route('page.contact_us', $slug) }}">
                            {{ __('Contact') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Mobile menu end here -->
        @if ($route_name == 'landing_page')
            <div class="fixed-left-header">
                <div class="mobile-menu">
                    <button class="mobile-menu-button">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                    </button>
                    <span>{{ __('Menu') }}</span>
                </div>
                <ul>
                    @foreach ($MainCategoryList as $category)
                        <li>
                            <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">
                                <img src="{{ get_file($category->image_path, APP_THEME()) }}">
                                <span>{{ $category->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </header>
</body>

</html>
