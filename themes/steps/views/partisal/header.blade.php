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
            <div class="announce-row no-gutters row align-items-center">
                <div class=" col-6">
                    <div class="annoucebar-left justify-content-between">
                        @php
                            $homepage_header_1_key = array_search('homepage-main-header', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-header-icon-image') {
                                        $contact_us_header_worktime_image = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-title') {
                                        $contact_us_header_worktime = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-label') {
                                        $contact_us_header_calling = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-link') {
                                        $contact_us_header_call = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-header-call-icon-image') {
                                        $contact_us_header_image = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <p>
                                <img src="{{ get_file($contact_us_header_worktime_image, APP_THEME()) }}" alt=""
                                    class="contact">&nbsp;&nbsp;
                                {!! $contact_us_header_worktime !!}
                            </p>
                            <a href="tel:610403403">
                                <span>{!! $contact_us_header_calling !!}<b>{!! $contact_us_header_call !!}</b></span>&nbsp;&nbsp;
                                <img src="{{ get_file($contact_us_header_image, APP_THEME()) }}" alt="">
                            </a>
                        @endif
                    </div>
                </div>
                {{-- <div class=" col-6 d-flex justify-content-end">
                    <div class="announcebar-right d-flex align-items-center justify-content-end">
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
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center">
                <div class="menu-items-col row align-items-center no-gutters">
                    <div class="col-md-6 col-2 d-flex align-items-center">
                        <div class="logo-col">
                            <h1>
                                <a href="{{ route('landing_page', $slug) }}">
                                    <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                        alt="Style theme">
                                </a>
                            </h1>
                        </div>
                        <ul class="main-nav">
                            @if ($has_subcategory)
                                @foreach ($MainCategoryList as $category)
                                    <li class="menu-lnk has-item">
                                        <a href="#">
                                            {{ $category->name }}
                                        </a>
                                        <div class="menu-dropdown">
                                            <ul>
                                                <li>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('page.product-list', [$slug, 'main_category' => $category->id]) }}">{{ __('All') }}</a></a>
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
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
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


                            <li class="menu-lnk has-item">
                                <a href="#">
                                    {{ __('pages')}}
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
                        </ul>


                    </div>
                    <div class="col-md-6 col-10">
                        <ul class="menu-right d-flex">
                            <li class="search-header">
                                <a href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        viewBox="0 0 19 19" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z"
                                            fill="#183A40" />
                                    </svg>
                                    <span class="desk-only icon-lable">Search</span>
                                </a>
                            </li>
                            @auth
                                <li class="profile-header">
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22"
                                            viewBox="0 0 16 22" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                fill="#183A40" />
                                        </svg>
                                        <span class="desk-only icon-lable">{{ __('My profile') }}</span>
                                    </a>
                                    <div class="menu-dropdown">
                                        <ul>
                                            <li><a
                                                    href="{{ route('my-account.index', $slug) }}">{{ __('My Account') }}</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout_user', $slug) }}"
                                                    id="form_logout">
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
                                    <a href="{{ route('login', $slug) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22"
                                            viewBox="0 0 16 22" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                                fill="#183A40" />
                                        </svg>
                                        <span class="">{{ __('Login') }}</span>
                                    </a>
                                </li>

                            @endguest
                            <li class="cart-header" style="pointer-events: auto">
                                <a href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                        viewBox="0 0 19 17" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                            fill="white" />
                                    </svg>

                                    <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>
                                </a>
                            </li>
                            <li class="mobile-menu">
                                <button class="mobile-menu-button" id="menu">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="22"
                                        viewBox="0 0 45 22" fill="none">
                                        <line y1="1" x2="45" y2="1" stroke="white"
                                            stroke-width="2" />
                                        <line y1="11" x2="45" y2="11" stroke="white"
                                            stroke-width="2" />
                                        <line y1="21" x2="45" y2="21" stroke="white"
                                            stroke-width="2" />
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <input type="search" placeholder="Search Product..." class="form-control search_input"
                        list="products" name="search_product" id="product">
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
</header>
</body>
</header>

@push('page-script')
    <script>
        $(document).ready(function() {
            var responseData;
            $(".search_input").on('keyup', function(e) {
                e.preventDefault();
                var product = $(this).val();

                var data = {
                    product: product,
                }

                $.ajax({
                    url: '{{ route('search.product', $slug) }}',
                    context: this,
                    data: data,
                    success: function(response) {
                        responseData = response;
                        $('#products').empty();

                        $.each(response, function(key, value) {
                            $('#products').append('<option value="' + value.name +
                                '">');
                        });
                    }
                });
            });

            $('.search_input').change(function() {
                var selectedProduct = $(this).val();

                // Find the selected product's URL in the responseData array
                var productUrl = null;
                $.each(responseData, function(key, value) {
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