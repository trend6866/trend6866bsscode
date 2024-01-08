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
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp

<style>
    .profile-header .menu-dropdown li {
        margin: 20px;
    }

    .profile-header .menu-dropdown {
        position: absolute;
        background-color: #ffffff;
        z-index: 8;
        bottom: -23px;
        display: none;
    }

    .profile-header:hover .menu-dropdown {
        display: block;
    }
</style>


<!--header start here-->
<header class="site-header header-style-one">
    <div class="announcebar">
        <div class="container">
            <div class="announce-row row align-items-center">
                <div class="annoucebar-left col-6 d-flex">
                    <p>

                        <svg viewBox="0 0 12 12">
                            <path
                                d="M11.8704 1.16417C12.0074 1.31521 12.0389 1.53425 11.9501 1.71777L7.59593 10.7178C7.52579 10.8628 7.3901 10.9651 7.23141 10.9926C7.07272 11.0202 6.91047 10.9696 6.79555 10.8568L5.06335 9.1561L3.34961 10.6517C3.2065 10.7766 3.00497 10.8096 2.82949 10.737C2.654 10.6643 2.53486 10.4984 2.52199 10.3089L2.31069 7.19698L0.246224 5.98083C0.0797703 5.88277 -0.0153014 5.6976 0.00202164 5.50519C0.0193447 5.31278 0.145963 5.14756 0.327254 5.08081L11.3273 1.03081C11.5186 0.960374 11.7335 1.01314 11.8704 1.16417ZM3.34923 7.73073L3.45141 9.23561L4.34766 8.45343L3.87393 7.98831L3.34923 7.73073ZM4.91243 7.60651L6.9991 9.65524L10.0489 3.35145L4.91243 7.60651ZM8.93151 2.97851L1.66281 5.65471L3.02908 6.45956L4.09673 6.98368L8.93151 2.97851Z">
                            </path>
                        </svg>
                        <b>7 days a week </b>
                        from 9:00 am to 7:00 pm
                    </p>
                </div>
                <div class="announcebar-right col-6 d-flex justify-content-end">
                    <a href="tel:610403403">
                        <span>Call us : <b> 610-403-403</b></span>
                        <svg viewBox="0 0 12 18">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.75 2.25C0.75 1.00736 1.75736 0 3 0H9C10.2426 0 11.25 1.00736 11.25 2.25V15.75C11.25 16.9926 10.2426 18 9 18H3C1.75736 18 0.75 16.9926 0.75 15.75V2.25ZM3 1.5C2.58579 1.5 2.25 1.83579 2.25 2.25V15.75C2.25 16.1642 2.58579 16.5 3 16.5H9C9.41421 16.5 9.75 16.1642 9.75 15.75V2.25C9.75 1.83579 9.41421 1.5 9 1.5H3ZM4.5 2.25C4.08579 2.25 3.75 2.58579 3.75 3C3.75 3.41421 4.08579 3.75 4.5 3.75H7.5C7.91421 3.75 8.25 3.41421 8.25 3C8.25 2.58579 7.91421 2.25 7.5 2.25H4.5ZM6 14.25C5.58579 14.25 5.25 14.5858 5.25 15C5.25 15.4142 5.58579 15.75 6 15.75C6.41421 15.75 6.75 15.4142 6.75 15C6.75 14.5858 6.41421 14.25 6 14.25Z">
                            </path>
                        </svg>
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

    <div class="header-top">
        <div class="container right-side-header">
            <div class="logo-col">
                <h1>
                    <a href="{{ route('landing_page',$slug) }}">
                        <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                            alt="">
                    </a>
                </h1>
            </div>

            <div class="search-form-wrapper">
                <form>
                    <div class="form-inputs">
                        <input type="search" placeholder="Search Product..." class="form-control search_input"
                            list="products" name="search_product" id="product">
                        <datalist id="products">
                            {{-- @foreach ($search_products as $pro_id => $pros)
                                <option value="{{ $pros }}"></option>
                            @endforeach --}}
                        </datalist>
                        <button type="submit" class="btn search_product_globaly">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.47487 10.5131C8.48031 11.2863 7.23058 11.7466 5.87332 11.7466C2.62957 11.7466 0 9.11706 0 5.87332C0 2.62957 2.62957 0 5.87332 0C9.11706 0 11.7466 2.62957 11.7466 5.87332C11.7466 7.23058 11.2863 8.48031 10.5131 9.47487L12.785 11.7465C13.0717 12.0332 13.0717 12.4981 12.785 12.7848C12.4983 13.0715 12.0334 13.0715 11.7467 12.7848L9.47487 10.5131ZM10.2783 5.87332C10.2783 8.30612 8.30612 10.2783 5.87332 10.2783C3.44051 10.2783 1.46833 8.30612 1.46833 5.87332C1.46833 3.44051 3.44051 1.46833 5.87332 1.46833C8.30612 1.46833 10.2783 3.44051 10.2783 5.87332Z"
                                    fill="#545454" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="center-header">
                <div class="store-info">
                    @php
                        $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_contact = '';
                        $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                        if ($homepage_header_1_key != '') {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if ($value['field_slug'] == 'homepage-header-label-text-1') {
                                    $contact_us_header_worktime = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-header-label-text-2') {
                                    $contact_us_header_calling = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-header-heading-text') {
                                    $contact_us_header_call = $value['field_default_text'];
                                }
                                if ($value['field_slug'] == 'homepage-header-contact') {
                                    $contact_us_header_contact = $value['field_default_text'];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_header_1['section_enable'] == 'on')
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="9" height="11" viewBox="0 0 9 11"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.82077 7.62223C7.52115 6.65004 8 5.58153 8 4.5C8 2.567 6.433 1 4.5 1C2.567 1 1 2.567 1 4.5C1 5.58153 1.47885 6.65004 2.17923 7.62223C2.87434 8.5871 3.72907 9.37514 4.33844 9.87424C4.4384 9.95611 4.5616 9.95611 4.66156 9.87424C5.27093 9.37514 6.12566 8.5871 6.82077 7.62223ZM5.2952 10.6479C6.58731 9.58957 9 7.24584 9 4.5C9 2.01472 6.98528 0 4.5 0C2.01472 0 0 2.01472 0 4.5C0 7.24584 2.41269 9.58957 3.7048 10.6479C4.17328 11.0316 4.82672 11.0316 5.2952 10.6479Z"
                                    fill="#5EA5DF" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.5 3.5C3.94772 3.5 3.5 3.94772 3.5 4.5C3.5 5.05228 3.94772 5.5 4.5 5.5C5.05228 5.5 5.5 5.05228 5.5 4.5C5.5 3.94772 5.05228 3.5 4.5 3.5ZM2.5 4.5C2.5 3.39543 3.39543 2.5 4.5 2.5C5.60457 2.5 6.5 3.39543 6.5 4.5C6.5 5.60457 5.60457 6.5 4.5 6.5C3.39543 6.5 2.5 5.60457 2.5 4.5Z"
                                    fill="#5EA5DF" />
                            </svg>{!! $contact_us_header_worktime !!}</p>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="9" height="11" viewBox="0 0 9 11"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.82077 7.62223C7.52115 6.65004 8 5.58153 8 4.5C8 2.567 6.433 1 4.5 1C2.567 1 1 2.567 1 4.5C1 5.58153 1.47885 6.65004 2.17923 7.62223C2.87434 8.5871 3.72907 9.37514 4.33844 9.87424C4.4384 9.95611 4.5616 9.95611 4.66156 9.87424C5.27093 9.37514 6.12566 8.5871 6.82077 7.62223ZM5.2952 10.6479C6.58731 9.58957 9 7.24584 9 4.5C9 2.01472 6.98528 0 4.5 0C2.01472 0 0 2.01472 0 4.5C0 7.24584 2.41269 9.58957 3.7048 10.6479C4.17328 11.0316 4.82672 11.0316 5.2952 10.6479Z"
                                    fill="#5EA5DF" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.5 3.5C3.94772 3.5 3.5 3.94772 3.5 4.5C3.5 5.05228 3.94772 5.5 4.5 5.5C5.05228 5.5 5.5 5.05228 5.5 4.5C5.5 3.94772 5.05228 3.5 4.5 3.5ZM2.5 4.5C2.5 3.39543 3.39543 2.5 4.5 2.5C5.60457 2.5 6.5 3.39543 6.5 4.5C6.5 5.60457 5.60457 6.5 4.5 6.5C3.39543 6.5 2.5 5.60457 2.5 4.5Z"
                                    fill="#5EA5DF" />
                            </svg>{!! $contact_us_header_calling !!}</p>
                </div>
                @endif
            </div>
            <div class="right-header">
                <ul class="menu-right d-flex  justify-content-end">

                    @auth
                        <li class="profile-header">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40" />
                                </svg>
                                {{-- <span class="desk-only icon-lable">{{ __('My profile') }}</span> --}}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    <li class="menu-lnk has-item"><a
                                            href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout_user',$slug) }}" id="form_logout">
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
                            <a href="{{ route('login',$slug) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22"
                                    viewBox="0 0 16 22" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40" />
                                </svg>
                                {{-- <p>{{ __('Login') }}</p> --}}
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="wishlist-header wish-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14"
                                    viewBox="0 0 17 14" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.18991 3.10164C8.89678 3.37992 8.43395 3.37992 8.14082 3.10164L7.61627 2.60366C7.00231 2.0208 6.17289 1.66491 5.25627 1.66491C3.37348 1.66491 1.84718 3.17483 1.84718 5.03741C1.84718 6.82306 2.82429 8.29753 4.23488 9.50902C5.64667 10.7215 7.33461 11.5257 8.34313 11.9361C8.554 12.0219 8.77673 12.0219 8.9876 11.9361C9.99612 11.5257 11.6841 10.7215 13.0959 9.50901C14.5064 8.29753 15.4835 6.82305 15.4835 5.03741C15.4835 3.17483 13.9572 1.66491 12.0745 1.66491C11.1578 1.66491 10.3284 2.0208 9.71446 2.60366L9.18991 3.10164ZM8.66537 1.52219C7.7806 0.682237 6.57937 0.166016 5.25627 0.166016C2.53669 0.166016 0.332031 2.34701 0.332031 5.03741C0.332031 9.81007 5.61259 12.4457 7.76672 13.3223C8.34685 13.5584 8.98388 13.5584 9.56401 13.3223C11.7181 12.4457 16.9987 9.81006 16.9987 5.03741C16.9987 2.34701 14.794 0.166016 12.0745 0.166016C10.7514 0.166016 9.55013 0.682237 8.66537 1.52219Z"
                                        fill="white" />
                                </svg>
                                <span class="count"> {!! \App\Models\Wishlist::WishCount() !!}</span>
                            </a>
                        </li>
                    @endauth
                    <li class="cart-header">
                        <a href="javascript:;">

                            <span class="desk-only icon-lable">{{ __('My Cart:') }} <span
                                    class="currency-type">{{ $currency}}</span><b
                                    id="sub_total_main_page">{{ 0 }} </span></b>

                            <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                viewBox="0 0 19 17" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                    fill="white"></path>
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
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center justify-content-between">
                <div class="menu-items-col">
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16"
                                    viewBox="0 0 24 16" fill="none">
                                    <path
                                        d="M23.8748 4.55L21.8748 0.550003C21.7917 0.385089 21.6646 0.246402 21.5075 0.149323C21.3504 0.0522431 21.1695 0.000559705 20.9848 0H2.9848C2.80013 0.000559705 2.61924 0.0522431 2.46214 0.149323C2.30505 0.246402 2.1779 0.385089 2.0948 0.550003L0.0948029 4.55C0.0323657 4.68299 0 4.82809 0 4.975C0 5.12191 0.0323657 5.26702 0.0948029 5.4C0.154808 5.53573 0.244263 5.65639 0.356689 5.75325C0.469116 5.85011 0.601689 5.92073 0.744797 5.96L2.0148 6.33V12.24C2.02062 12.6788 2.17063 13.1036 2.4417 13.4487C2.71276 13.7939 3.08985 14.0403 3.5148 14.15L10.7748 15.97C10.8545 15.9796 10.9351 15.9796 11.0148 15.97H11.2148L20.4248 14.13C20.8642 14.0309 21.2572 13.7865 21.5403 13.4362C21.8235 13.0859 21.9801 12.6504 21.9848 12.2V6.2L23.2048 5.93C23.3524 5.89583 23.4903 5.82856 23.6081 5.73328C23.7259 5.638 23.8205 5.5172 23.8848 5.38C23.9427 5.249 23.9717 5.10711 23.97 4.96391C23.9683 4.82072 23.9358 4.67957 23.8748 4.55ZM20.3648 2L21.5148 4.3L14.5148 5.85L12.5848 2H20.3648ZM3.6048 2H9.36481L7.4648 5.81L2.4648 4.37L3.6048 2ZM3.9848 6.9L7.7148 7.96C7.80421 7.97456 7.89539 7.97456 7.9848 7.96C8.16947 7.95944 8.35037 7.90776 8.50746 7.81068C8.66455 7.7136 8.7917 7.57492 8.8748 7.41L9.9848 5.2V13.68L3.9848 12.2V6.9ZM19.9848 12.18L11.9848 13.78V5.24L13.0948 7.45C13.1779 7.61491 13.3051 7.7536 13.4621 7.85068C13.6192 7.94776 13.8001 7.99944 13.9848 8H14.2048L19.9848 6.71V12.18Z"
                                        fill="#5EA5DF" />
                                </svg>
                                {{ __(' All products') }}
                            </a>
                            @if ($has_subcategory)
                                <div class="mega-menu menu-dropdown">
                                    <div class="mega-menu-container container">
                                        <ul class="row">
                                            @foreach ($MainCategoryList as $category)
                                                <li class="col-md-3 col-12">
                                                    <ul class="megamenu-list arrow-list">
                                                        <li class="list-title"><span>{{ $category->name }}</span></li>
                                                        <li><a
                                                                href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ __('All') }}</a>
                                                        </li>
                                                        @foreach ($SubCategoryList as $cat)
                                                            @if ($cat->maincategory_id == $category->id)
                                                                <li ><a
                                                                        href="{{ route('page.product-list', [$slug,'main_category' => $category->id, 'sub_category' => $cat->id]) }}">{{ $cat->name }}</a>
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
                                                    href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                        <li class="menu-lnk has-item">
                            <a href="javascript:void(0)">{{ __('Pages') }}</a>
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
                        <li class="menu-lnk">
                            <a href="{{ route('page.contact_us',$slug) }}">{{ __('Contact us') }}</a>
                        </li>
                        <li class="menu-lnk">
                            <a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a>
                        </li>

                    </ul>
                </div>
                <div class="contact-info">
                    <div class="contact-wrap">
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <a
                                href="tel:+48 222-512-234"><span>{!! $contact_us_header_call !!}</span><b>{!! $contact_us_header_contact !!}</b></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header end here-->
</header>
<!--cart popup start-->

</body>

</html>

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
