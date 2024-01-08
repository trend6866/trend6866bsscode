 <!--header start here-->
 @php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
 @endphp


<style>
    .profile-header .menu-dropdown li {
        margin: 20px;
    }

    .profile-header .menu-dropdown {
        position: absolute;
        background-color: #1f1f1f;
        z-index: 8;
        top: 78px;
        transition: all ease-in-out 0.3s;
        opacity: 0;
        visibility: hidden;
        transform: scaleY(0);
        transform-origin: top;
    }

    .profile-header:hover .menu-dropdown {
       opacity: 1;
        visibility: visible;
        transform: scaleY(1)
    }
</style>
<style>
    .profile-headers .menu-dropdown li{
        margin: 20px;
    }
    .profile-headers .menu-dropdown {
        position: absolute;
        background-color: var(--theme-color);
        z-index: 8;
        top: -39px;
        display: none;
    }
    .profile-headers:hover .menu-dropdown{
        display: block;
    }
</style>

<header class="site-header header-style-one">
    <div class="logobar">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                // dd($homepage_header_1_key);
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-header-title') {
                            $header_title = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-title-text-here') {
                            $header_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-contact') {
                            $header_contact = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-header-contact-1') {
                            $header_contacts = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <div class="logobar-row d-flex align-items-center">
                <div class="logo-col">
                    <h1>
                        <a href="{{ route('landing_page',$slug) }}">
                            <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : asset('themes/' . APP_THEME() . '/assets/images/Logo.svg') }}"
                                alt="logo">
                        </a>
                    </h1>
                </div>
                <div class="logo-items-col">
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
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <li class=" form-select profile-headers">
                                <div class="nice-select">
                                    <span class="current">{{ __('All Category') }}</span>
                                    <ul class="list">
                                        @foreach ($MainCategoryList as $category)
                                            <li class="option"><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </form>
                    </div>
                    <div class="store-info-wrapper">
                        <div class="store-info-block">
                            <p>{!! $header_title !!}</p>
                        </div>
                        <div class="store-info-block">
                            <a href="tel:+12 002-224-111"><span class="label">{{$header_text}}</span> <b>{{$header_contact}}</b></a>
                        </div>
                    </div>
                    <div class="logobar-right">
                        <ul class="menu-right d-flex align-items-center  justify-content-end">
                            @guest
                            <li class="profile-header">
                                <a href="{{ route('login',$slug) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.5 9.81818C4.27834 9.81818 1.66667 12.3824 1.66667 15.5455V17.1818C1.66667 17.6337 1.29357 18 0.833333 18C0.373096 18 0 17.6337 0 17.1818V15.5455C0 11.4786 3.35786 8.18182 7.5 8.18182C11.6421 8.18182 15 11.4786 15 15.5455V17.1818C15 17.6337 14.6269 18 14.1667 18C13.7064 18 13.3333 17.6337 13.3333 17.1818V15.5455C13.3333 12.3824 10.7217 9.81818 7.5 9.81818Z"
                                            fill="#545454" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.5 8.18182C9.34095 8.18182 10.8333 6.71657 10.8333 4.90909C10.8333 3.10161 9.34095 1.63636 7.5 1.63636C5.65905 1.63636 4.16667 3.10161 4.16667 4.90909C4.16667 6.71657 5.65905 8.18182 7.5 8.18182ZM7.5 9.81818C10.2614 9.81818 12.5 7.62031 12.5 4.90909C12.5 2.19787 10.2614 0 7.5 0C4.73858 0 2.5 2.19787 2.5 4.90909C2.5 7.62031 4.73858 9.81818 7.5 9.81818Z"
                                            fill="#545454" />
                                    </svg>
                                </a>
                            </li>
                            @endguest
                            @auth
                                <li class="profile-header">
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                fill="#183A40" />
                                        </svg>
                                        <span class="desk-only icon-lable" style="color: #1f1f1f">{{ __('My profile') }}</span>
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
                            @auth
                                <li class="wishlist-header">
                                    <a href="javascript:;" title="wish" class="wish-header">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.6295 3.52275C10.2777 3.85668 9.7223 3.85668 9.37055 3.52275L8.74109 2.92517C8.00434 2.22574 7.00903 1.79867 5.90909 1.79867C3.64974 1.79867 1.81818 3.61057 1.81818 5.84567C1.81818 7.98845 2.99071 9.75782 4.68342 11.2116C6.37756 12.6666 8.40309 13.6316 9.61331 14.1241C9.86636 14.2271 10.1336 14.2271 10.3867 14.1241C11.5969 13.6316 13.6224 12.6666 15.3166 11.2116C17.0093 9.75782 18.1818 7.98845 18.1818 5.84567C18.1818 3.61057 16.3503 1.79867 14.0909 1.79867C12.991 1.79867 11.9957 2.22574 11.2589 2.92517L10.6295 3.52275ZM10 1.62741C8.93828 0.619465 7.49681 0 5.90909 0C2.64559 0 0 2.6172 0 5.84567C0 11.5729 6.33668 14.7356 8.92163 15.7875C9.61779 16.0708 10.3822 16.0708 11.0784 15.7875C13.6633 14.7356 20 11.5729 20 5.84567C20 2.6172 17.3544 0 14.0909 0C12.5032 0 11.0617 0.619465 10 1.62741Z"
                                                fill="#545454" />
                                        </svg>
                                        <span class="count"> {!! \App\Models\Wishlist::WishCount() !!}</span>
                                    </a>
                                </li>
                            @endauth
                            <li class="cart-header">
                                <a href="javascript:;">
                                    <span class="icon-lable">{{__('My Cart:')}} <b id ="sub_total_main_page">{{0}} {{ $currency }}</b></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"
                                        fill="none">
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
                                    <span class="count">{!! \App\Models\Cart::CartCount() !!} </span>
                                </a>
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
    </div>
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center justify-content-between">
                <div class="menu-items-col">
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="javascript:void(0);" class="category-btn active">
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
                                {{ __('All Categories')}}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($MainCategoryList as $category)
                                        <li><a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @foreach ($MainCategoryList->take(7) as $category)
                        <li class="menu-lnk">
                            <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">
                                {{$category->name}}
                            </a>
                        </li>
                        @endforeach
                        <li class="menu-lnk has-item">
                            <a href="javascript:void(0);">
                                <span class="link-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" viewBox="0 0 490 490" xml:space="preserve">
                                        <g>
                                            <g id="XMLID_50_">
                                                <g>
                                                    <polygon style="fill:#FFFFFF;" points="480,110 480,480 110,480 110,425 280,425 280,147.5 202.5,70 110,70 110,10 380,10      380,110    "></polygon>
                                                    <polygon style="fill:#AFB6BB;" points="480,110 380,110 380,10    "></polygon>
                                                    <polygon style="fill:#E7ECED;" points="280,147.5 280,425 110,425 10,425 10,70 110,70 202.5,70 202.5,147.5    "></polygon>
                                                    <polygon style="fill:#AFB6BB;" points="280,147.5 202.5,147.5 202.5,70    "></polygon>
                                                </g>
                                                <g>
                                                    <path style="fill:#231F20;" d="M489.976,110c-0.001-2.602-0.993-5.158-2.905-7.071l-100-100c-1.913-1.912-4.47-2.903-7.071-2.904     V0H110c-5.523,0-10,4.477-10,10v50H10C4.477,60,0,64.478,0,70v355c0,5.522,4.477,10,10,10h90v45c0,5.522,4.477,10,10,10h370     c5.523,0,10-4.478,10-10V110H489.976z M390,34.143L455.858,100H390V34.143z M20,80h172.5v67.5c0,5.523,4.477,10,10,10H270V415H20     V80z M212.5,94.143l43.357,43.357H212.5V94.143z M120,470v-35h160c5.523,0,10-4.478,10-10V147.5c0-2.652-1.054-5.195-2.929-7.071     l-77.5-77.5C207.696,61.054,205.152,60,202.5,60H120V20h250v90c0,5.522,4.477,10,10,10h90v350H120z"></path>
                                                    <rect x="310" y="160" style="fill:#ffffff;" width="130" height="20"></rect>
                                                    <rect x="310" y="220" style="fill:#ffffff;" width="130" height="20"></rect>
                                                    <rect x="310" y="280" style="fill:#ffffff;" width="130" height="20"></rect>
                                                    <rect x="310" y="340" style="fill:#ffffff;" width="130" height="20"></rect>
                                                    <rect x="310" y="400" style="fill:#ffffff;" width="130" height="20"></rect>
                                                    <rect x="45" y="105" style="fill:#ffffff;" width="65" height="20"></rect>
                                                    <rect x="45" y="145" style="fill:#ffffff;" width="65" height="20"></rect>
                                                    <rect x="45" y="205" style="fill:#ffffff;" width="200" height="20"></rect>
                                                    <rect x="45" y="255" style="fill:#ffffff;" width="200" height="20"></rect>
                                                    <rect x="45" y="305" style="fill:#ffffff;" width="200" height="20"></rect>
                                                    <rect x="45" y="355" style="fill:#ffffff;" width="200" height="20"></rect>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
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
                    </ul>
                </div>
                <div class="contact-info">
                    <div class="contact-wrap">
                        <a href="mailto:contact@shop.com">{!! $header_contacts !!}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

 <!--header end here-->

@push('page-script')
    <script>
        $(document).ready(function() {
            $(".search_product_globaly").on('click', function(e) {
                e.preventDefault();
                var product = $('.search_input').val();

                var data = {
                    product: product,
                }

                $.ajax({
                    url: '{{ route('search.product',$slug) }}',
                    context: this,
                    data: data,
                    success: function(responce) {
                        window.location.href = responce;
                    }
                });
            });
        });
    </script>
@endpush
