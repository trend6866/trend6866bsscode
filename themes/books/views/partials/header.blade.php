@php
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());

@endphp
<header class="site-header header-style-one">
    <div class="announcebar">
        <div class="container">
            @php
                $homepage_header_title = '';

                $homepage_header = array_search('home-header', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header != '') {
                    $homepage_header_value = $theme_json[$homepage_header];

                    foreach ($homepage_header_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'home-header-title') {
                            $homepage_header_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'home-header-link-text') {
                            $homepage_header_subtext = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_header_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'home-header-title') {
                                $homepage_header_title = $homepage_header_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'home-header-link-text') {
                                $homepage_header_subtext = $homepage_header_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp
            @php
                $homepage_headers = array_search('home-header', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_headers != '') {
                    $homepage_header_1 = $theme_json[$homepage_headers];
                    //  dd('hey');
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-header-title') {
                            $home_header = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <div class="announce-row row align-items-center">
                <div class="annoucebar-left col-6 d-flex">
                    <p>

                        {!! $homepage_header_title !!}
                        <b><a href="">{{ $homepage_header_subtext }}</a></b>
                    </p>
                </div>
                <div class="announcebar-right col-6 d-flex justify-content-end">
                    <ul>
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
                                alt="Style theme"> </a>
                    </h1>
                </div>
                <div class="menu-items-col">
                    <ul class="main-nav nav-desk-only">
                        <li class="menu-lnk has-item">
                            <a href="#" class="category-btn active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16"
                                    viewBox="0 0 13 16" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 2.90909C0 1.30244 1.2934 0 2.88889 0H8.91449C9.68067 0 10.4155 0.306493 10.9572 0.852053L12.1539 2.05704C12.6956 2.6026 13 3.34254 13 4.11408V13.0909C13 14.6976 11.7066 16 10.1111 16H2.88889C1.2934 16 0 14.6976 0 13.0909V2.90909ZM11.5556 5.09091V13.0909C11.5556 13.8942 10.9089 14.5455 10.1111 14.5455H2.88889C2.09114 14.5455 1.44444 13.8942 1.44444 13.0909V2.90909C1.44444 2.10577 2.09114 1.45455 2.88889 1.45455H7.94444V2.90909C7.94444 4.11408 8.91449 5.09091 10.1111 5.09091H11.5556ZM11.4754 3.63636C11.4045 3.43098 11.2881 3.24224 11.1325 3.08556L9.93587 1.88057C9.78028 1.72389 9.59285 1.60665 9.38889 1.53523V2.90909C9.38889 3.31075 9.71224 3.63636 10.1111 3.63636H11.4754Z"
                                        fill="#E8BA96" />
                                    <path
                                        d="M5.25003 7.1016L8.57902 8.83789C9.14033 9.13064 9.14033 9.86936 8.57902 10.1621L5.25003 11.8984C4.69303 12.1889 4 11.8218 4 11.2363L4 7.76372C4 7.17818 4.69303 6.8111 5.25003 7.1016Z"
                                        fill="#E8BA96" />
                                </svg>
                                {{ __(' Audiobooks') }}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($MainCategoryList as $category)
                                        <li><a
                                                href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
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
                                    <li><a href="{{ route('page.faq',$slug) }}">{{ __('FAQs') }}</a></li>
                                    <li><a href="{{ route('page.blog',$slug) }}">{{ __('Blog') }}</a></li>
                                    <li><a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a></li>
                        <li class="menu-lnk">
                            <a href="{{ route('page.contact_us',$slug) }}">{{ __('Contact us') }}</a>
                        </li>
                    </ul>

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
                                    <input type="search" placeholder="Search Product..."
                                        class="form-control search_input" list="products" name="search_product"
                                        id="product">
                                    <datalist id="products">
                                        @foreach ($search_products as $pro_id => $pros)
                                            <option value="{{ $pros }}"></option>
                                        @endforeach
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

                    <ul class="menu-right d-flex justify-content-end align-items-center">
                        <li class="search-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                    viewBox="0 0 15 14" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.2122 11.3214C9.14028 12.1539 7.79329 12.6497 6.33041 12.6497C2.83422 12.6497 0 9.81797 0 6.32485C0 2.83173 2.83422 0 6.33041 0C9.82659 0 12.6608 2.83173 12.6608 6.32485C12.6608 7.78645 12.1646 9.13226 11.3313 10.2033L13.78 12.6496C14.089 12.9583 14.089 13.4589 13.78 13.7677C13.4709 14.0764 12.9699 14.0764 12.6609 13.7677L10.2122 11.3214ZM11.0782 6.32485C11.0782 8.94469 8.95255 11.0685 6.33041 11.0685C3.70827 11.0685 1.5826 8.94469 1.5826 6.32485C1.5826 3.70501 3.70827 1.58121 6.33041 1.58121C8.95255 1.58121 11.0782 3.70501 11.0782 6.32485Z"
                                        fill="black" />
                                </svg>
                            </a>
                        </li>



                        @guest
                            <li class="profile-header">
                                {{-- <li class="menu-lnk has-item"> --}}
                                <a href="{{ route('login',$slug) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18"
                                        viewBox="0 0 15 18" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.5 9.81818C4.27834 9.81818 1.66667 12.3824 1.66667 15.5455V17.1818C1.66667 17.6337 1.29357 18 0.833333 18C0.373096 18 0 17.6337 0 17.1818V15.5455C0 11.4786 3.35786 8.18182 7.5 8.18182C11.6421 8.18182 15 11.4786 15 15.5455V17.1818C15 17.6337 14.6269 18 14.1667 18C13.7064 18 13.3333 17.6337 13.3333 17.1818V15.5455C13.3333 12.3824 10.7217 9.81818 7.5 9.81818Z"
                                            fill="#1D1D1B" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.5 8.18182C9.34095 8.18182 10.8333 6.71657 10.8333 4.90909C10.8333 3.10161 9.34095 1.63636 7.5 1.63636C5.65905 1.63636 4.16667 3.10161 4.16667 4.90909C4.16667 6.71657 5.65905 8.18182 7.5 8.18182ZM7.5 9.81818C10.2614 9.81818 12.5 7.62031 12.5 4.90909C12.5 2.19787 10.2614 0 7.5 0C4.73858 0 2.5 2.19787 2.5 4.90909C2.5 7.62031 4.73858 9.81818 7.5 9.81818Z"
                                            fill="#1D1D1B" />
                                    </svg>
                                </a>
                                {{-- <div class="menu-dropdown">
                                        <ul>
                                            <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                        </ul>
                                    </div> --}}
                                {{-- </li> --}}

                            </li>
                        @endguest

                        @auth
                            <ul class="main-nav nav-desk-only profile-header">
                                <li class="menu-lnk has-item">
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18"
                                            viewBox="0 0 15 18" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.5 9.81818C4.27834 9.81818 1.66667 12.3824 1.66667 15.5455V17.1818C1.66667 17.6337 1.29357 18 0.833333 18C0.373096 18 0 17.6337 0 17.1818V15.5455C0 11.4786 3.35786 8.18182 7.5 8.18182C11.6421 8.18182 15 11.4786 15 15.5455V17.1818C15 17.6337 14.6269 18 14.1667 18C13.7064 18 13.3333 17.6337 13.3333 17.1818V15.5455C13.3333 12.3824 10.7217 9.81818 7.5 9.81818Z"
                                                fill="#1D1D1B" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.5 8.18182C9.34095 8.18182 10.8333 6.71657 10.8333 4.90909C10.8333 3.10161 9.34095 1.63636 7.5 1.63636C5.65905 1.63636 4.16667 3.10161 4.16667 4.90909C4.16667 6.71657 5.65905 8.18182 7.5 8.18182ZM7.5 9.81818C10.2614 9.81818 12.5 7.62031 12.5 4.90909C12.5 2.19787 10.2614 0 7.5 0C4.73858 0 2.5 2.19787 2.5 4.90909C2.5 7.62031 4.73858 9.81818 7.5 9.81818Z"
                                                fill="#1D1D1B" />
                                        </svg>
                                    </a>
                                    <div class="menu-dropdown">
                                        <ul>
                                            <li><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout_user',$slug) }}"
                                                    id="form_logout">
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

                            </ul>
                        @endauth
                        &nbsp;&nbsp;

                        @auth
                            <li class="header-wishlist wish-header">
                                <a href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                        viewBox="0 0 20 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.6295 3.52275C10.2777 3.85668 9.7223 3.85668 9.37055 3.52275L8.74109 2.92517C8.00434 2.22574 7.00903 1.79867 5.90909 1.79867C3.64974 1.79867 1.81818 3.61057 1.81818 5.84567C1.81818 7.98845 2.99071 9.75782 4.68342 11.2116C6.37756 12.6666 8.40309 13.6316 9.61331 14.1241C9.86636 14.2271 10.1336 14.2271 10.3867 14.1241C11.5969 13.6316 13.6224 12.6666 15.3166 11.2116C17.0093 9.75782 18.1818 7.98845 18.1818 5.84567C18.1818 3.61057 16.3503 1.79867 14.0909 1.79867C12.991 1.79867 11.9957 2.22574 11.2589 2.92517L10.6295 3.52275ZM10 1.62741C8.93828 0.619465 7.49681 0 5.90909 0C2.64559 0 0 2.6172 0 5.84567C0 11.5729 6.33668 14.7356 8.92163 15.7875C9.61779 16.0708 10.3822 16.0708 11.0784 15.7875C13.6633 14.7356 20 11.5729 20 5.84567C20 2.6172 17.3544 0 14.0909 0C12.5032 0 11.0617 0.619465 10 1.62741Z"
                                            fill="#051512"></path>
                                    </svg>
                                    <span class="count"> {!! \App\Models\Wishlist::WishCount() !!}</span>
                                </a>
                            </li>
                        @endauth
                        <li class="cart-header-bg">
                            <div class="cart-header-main">
                                <div class="cart-header">
                                    <a href="javascript:;">
                                        <span class="header-desk-only icon-lable"> <b>My Cart:</b><br><b
                                                id="sub_total_main_page"> {{ 0 }} {{ __('items') }}</b>
                                            {{ $currency }}</span>
                                        <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                            viewBox="0 0 19 17" fill="#1D1D1B">`
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                                fill="#1D1D1B">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
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
                        {{ __('Shop All') }}
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
                                    <li><a
                                            href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="mobile-item has-children">
                    <a href="javascript:void(0)" class="acnav-label">
                        {{ __('Page') }}
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
                                    <li>
                                        <a
                                            href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ route('page.faq',$slug) }}">{{ __('FAQs') }}</a></li>
                                <li><a href="{{ route('page.blog',$slug) }}">{{ __('Blog') }}</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="mobile-item has-children">
                    <a href="{{ route('page.product-list',$slug) }}" class="acnav-label">
                        {{ __('Collection') }}
                    </a>

                </li>
                <li class="mobile-item has-children">
                    <a href="{{ route('page.faq',$slug) }}" class="acnav-label">
                        {{ __('FAQs') }}

                    </a>
                </li>
                <li class="mobile-item">
                    <a href="{{ route('page.contact_us',$slug) }}">{{ __('Contact Us') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Mobile menu end here -->
    {{-- <div class="search-popup">
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
                </div>
            </form>
        </div>
    </div> --}}
    <!--header end here-->
</header>
