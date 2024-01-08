@php
    $theme_json = $homepage_json;
    if (Auth::user()) {
        $carts = App\Models\Cart::where('user_id', Auth::user()->id)
            ->where('theme_id', APP_THEME())
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

<svg style="display: none;">
    <symbol viewBox="0 0 6 5" id="slickarrow">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
        </path>
    </symbol>
</svg>
<!--header start here-->

@if (\Route::current()->getName() != 'landing_page')
    <header class="site-header header-style-one header-style-three home-header">
    @else
        <header class="site-header header-style-one home-header">
@endif
@php
    $homepage_header_title = $homepage_header_icon = $homepage_header_contact_icon = $homepage_header_contact_title = '';

    $homepage_header = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
    if ($homepage_header != '') {
        $homepage_header_value = $theme_json[$homepage_header];
        foreach ($homepage_header_value['inner-list'] as $key => $value) {
            if ($value['field_slug'] == 'homepage-header-title') {
                $homepage_header_title = $value['field_default_text'];
            }
            if ($value['field_slug'] == 'homepage-header-contact-title') {
                $homepage_header_contact_title = $value['field_default_text'];
            }
        }
    }
@endphp
@if ($homepage_header_value['section_enable'] == 'on')
    <div class="announce-bar">
        <div class="container">
            <div class="announcebar-inner">
                <div class="row align-items-center">
                    <div class="col-md-6 col-12">
                        <p>
                            {{-- <img src="{{get_file($homepage_header_icon , APP_THEME())}}" alt="" class="svg"> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <g clip-path="url(#clip0_1_508)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.8704 1.16417C12.0074 1.31521 12.0389 1.53425 11.9501 1.71777L7.59593 10.7178C7.52579 10.8628 7.3901 10.9651 7.23141 10.9926C7.07272 11.0202 6.91047 10.9696 6.79555 10.8568L5.06335 9.1561L3.34961 10.6517C3.2065 10.7766 3.00497 10.8096 2.82949 10.737C2.654 10.6643 2.53486 10.4984 2.52199 10.3089L2.31069 7.19698L0.246224 5.98083C0.0797703 5.88277 -0.0153014 5.6976 0.00202164 5.50519C0.0193447 5.31278 0.145963 5.14756 0.327254 5.08081L11.3273 1.03081C11.5186 0.960374 11.7335 1.01314 11.8704 1.16417ZM3.34923 7.73073L3.45141 9.23561L4.34766 8.45343L3.87393 7.98831L3.34923 7.73073ZM4.91243 7.60651L6.9991 9.65524L10.0489 3.35145L4.91243 7.60651ZM8.93151 2.97851L1.66281 5.65471L3.02908 6.45956L4.09673 6.98368L8.93151 2.97851Z"
                                        fill="black"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1_508">
                                        <rect width="12" height="12" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            {!! $homepage_header_title !!}
                        </p>
                    </div>
                    <div class="col-md-6 col-12">
                        <ul class="d-flex align-items-center justify-content-end">
                            <li>
                                <a href="tel:1234567890">
                                    {{-- <img src="{{get_file($homepage_header_contact_icon , APP_THEME())}}" alt="" class="svg"> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 14 14" fill="none">
                                        <g clip-path="url(#clip0_1_562)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.71108 1.3729C3.46413 0.619858 4.70955 0.708369 5.34852 1.56034L6.40918 2.97455C6.93171 3.67126 6.86243 4.64618 6.24662 5.26199L5.46462 6.04398C5.5404 6.24124 5.78989 6.67412 6.54962 7.43386C7.30935 8.19359 7.74224 8.44307 7.9395 8.51885L8.72149 7.73686C9.3373 7.12105 10.3122 7.05176 11.0089 7.5743L12.4231 8.63496C13.2751 9.27393 13.3636 10.5194 12.6106 11.2724C12.3658 11.5172 12.3243 11.5586 11.9158 11.9672C11.4994 12.3836 10.6152 12.7728 9.72011 12.8117C8.31934 12.8726 6.41664 12.2506 4.07475 9.90873C1.73285 7.56684 1.11087 5.66414 1.17177 4.26337C1.20565 3.48415 1.45339 2.62832 2.01953 2.07097C2.42483 1.65915 2.47754 1.60644 2.71108 1.3729ZM2.33734 4.31404C2.29512 5.28503 2.70433 6.8884 4.89971 9.08377C7.09508 11.2791 8.69845 11.6884 9.66944 11.6461C10.5759 11.6067 11.0621 11.1688 11.0908 11.1423L11.7856 10.4474C12.0366 10.1964 12.0071 9.78128 11.7231 9.56829L10.3089 8.50763C10.0767 8.33345 9.75172 8.35655 9.54645 8.56182C9.23717 8.87109 9.02606 9.08534 8.6128 9.49703C7.75435 10.3522 6.28489 8.81904 5.72466 8.25882C5.20982 7.74398 3.64086 6.22786 4.48561 5.37309C4.48728 5.37141 4.71481 5.14388 5.42166 4.43703C5.62693 4.23176 5.65002 3.90679 5.47585 3.67455L4.41519 2.26034C4.2022 1.97635 3.78706 1.94685 3.53604 2.19786C3.30501 2.42889 3.04355 2.69035 2.84193 2.89337C2.42696 3.3112 2.35954 3.80328 2.33734 4.31404Z"
                                                fill="#12131A"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_562">
                                                <rect width="14" height="14" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    {!! $homepage_header_contact_title !!}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="main-navigationbar">
    <div class="container">
        <div class="navigationbar-row d-flex align-items-center">
            <div class="logo-col">
                <h1>
                    <a href="{{ route('landing_page', $slug) }}">
                        <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.svg' }}"
                            alt="Nutritions logo">
                    </a>
                </h1>
            </div>
            <div class="menu-items-col">
                <ul class="main-nav">
                    <li class="menu-lnk has-item all-product">
                        <a href="#">
                            {{ __('All products') }}
                        </a>
                        <div class="menu-dropdown">
                            <ul>
                                @foreach ($MainCategoryList as $category)
                                    <li><a
                                            href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="menu-lnk">
                        <a href="{{ route('page.product-list', $slug) }}">
                            {{ __('Shop All') }}
                        </a>
                    </li>
                    <li class="menu-lnk has-item">
                        <a href="#">
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
                                <li><a href="{{ route('page.product-list', $slug) }}">{{ __('Collection') }}</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-lnk">
                        <a href="{{ route('page.contact_us', $slug) }}">{{ __('Contact') }} </a>
                    </li>
                </ul>
                <ul class="menu-right d-flex">
                    <li class="search-header">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z"
                                    fill="#183A40"></path>
                            </svg>
                        </a>
                    </li>
                    @auth
                        <li class="profile-header">
                            <a href="{{ route('my-account.index', $slug) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40"></path>
                                </svg>
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    <li><a href="{{ route('my-account.index', $slug) }}">{{ __('My Account') }}</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout_user', $slug) }}" id="form_logout">
                                            <a href="#"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="dropdown-item">
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
                            <a href="{{ route('login', $slug) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40"></path>
                                </svg>
                                <span class="icon-lable">Login</span>
                            </a>
                        </li>
                    @endguest
                    <li class="menu-lnk has-item lang-dropdown">
                        <a href="#">
                            
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
                    <li class="cart-header" style="pointer-events: auto">
                        <a href="javascript:;">
                            <span class="desk-only icon-lable ">{{ __('Cart') }}: <span
                                    class="p_count">{!! \App\Models\Cart::CartCount() !!}</span>{{ __(' items') }}</span>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                    viewBox="0 0 19 17" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                        fill="white"></path>
                                </svg>
                                <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>
                            </div>
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
</header>
<!--header end here-->
