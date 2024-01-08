

@php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
    $theme_logo = get_file($theme_logo , APP_THEME());
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    // dd($theme_logo)
@endphp

<!--header start here-->
<header class="site-header header-style-one">
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center">

                @php
                    $homepage_header_1_key = array_search('homepage-header', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-header-logo-text') {
                                $home_logo_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-header-label-text') {
                                $home_label_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-header-contact') {
                                $home_contact = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="menu-items-col">
                    <div class="logo-col mobile-show">
                        <div class="h5 w-100">
                            <a href="{{route('landing_page',$slug)}}">
                                {{$home_logo_text}}
                            </a>
                        </div>
                    </div>
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="#" class="active">

                                {{ __('All Bicycle')}}
                            </a>
                            @if ($has_subcategory)
                            <div class="mega-menu menu-dropdown">
                                <div class="mega-menu-container container">
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
                        <li class="menu-lnk has-item">
                            <a href="#"> {{ __('Pages') }} </a>
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
                    <div class="logo-col desk-show">
                        <div class="h3 w-100">
                            <a href="{{route('landing_page',$slug)}}">
                                 {{$home_logo_text}}
                            </a>
                        </div>
                    </div>
                    <ul class="menu-right">
                        @guest
                        <li class="profile-header menu-lnk has-item">
                            <a href="{{ route('login',$slug) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40"></path>
                                </svg>
                            </a>
                        </li>
                        @endguest


                        @auth
                            <li class="profile-header menu-lnk has-item">
                                <a href="{{ route('my-account.index',$slug) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                            fill="#183A40"></path>
                                    </svg>
                                </a>

                                <div class="menu-dropdown pro-header">
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
                        @endauth


                        @auth
                        <li class="wishlist-icon">
                            <a href="javascript:;" class="wish-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.31473 1.76137C5.13885 1.92834 4.86115 1.92834 4.68527 1.76137L4.37055 1.46259C4.00217 1.11287 3.50452 0.899334 2.95455 0.899334C1.82487 0.899334 0.909091 1.80529 0.909091 2.92284C0.909091 3.99423 1.49536 4.87891 2.34171 5.6058C3.18878 6.33331 4.20155 6.8158 4.80666 7.06205C4.93318 7.11354 5.06682 7.11354 5.19334 7.06205C5.79845 6.8158 6.81122 6.33331 7.65829 5.6058C8.50464 4.87891 9.09091 3.99422 9.09091 2.92284C9.09091 1.80529 8.17513 0.899334 7.04545 0.899334C6.49548 0.899334 5.99783 1.11287 5.62946 1.46259L5.31473 1.76137ZM5 0.813705C4.46914 0.309733 3.74841 0 2.95455 0C1.3228 0 0 1.3086 0 2.92284C0 5.78643 3.16834 7.3678 4.46081 7.89376C4.80889 8.03541 5.19111 8.03541 5.53919 7.89376C6.83166 7.3678 10 5.78643 10 2.92284C10 1.3086 8.67721 0 7.04545 0C6.25159 0 5.53086 0.309733 5 0.813705Z"
                                        fill="white"></path>
                                </svg>
                                <span class="count"> {!! \App\Models\Wishlist::WishCount() !!}</span>
                            </a>
                        </li>
                        @endauth

                        <li class="cart-header">
                            <a href="javascript:;">
                                <div class="cart-price desk-only">
                                    <span>{{ __('My Cart:')}} </span>
                                    <span id="sub_total_main_page">{{ 0 }} {{$currency}}</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.2919 8.13529H5.50403C4.58559 8.13555 3.79748 7.48102 3.6291 6.57815L2.74566 1.79231C2.68975 1.48654 2.42089 1.26607 2.11009 1.27114H0.63557C0.284554 1.27114 0 0.986585 0 0.63557C0 0.284554 0.284554 7.71206e-08 0.63557 7.71206e-08H2.1228C3.04124 -0.000259399 3.82935 0.654274 3.99773 1.55715L4.88117 6.34299C4.93708 6.64875 5.20595 6.86922 5.51674 6.86415H12.2983C12.6091 6.86922 12.8779 6.64875 12.9338 6.34299L13.7347 2.02111C13.769 1.8338 13.7175 1.64099 13.5944 1.49571C13.4712 1.35044 13.2895 1.26802 13.0991 1.27114H5.72013C5.36911 1.27114 5.08456 0.986585 5.08456 0.63557C5.08456 0.284554 5.36911 7.71206e-08 5.72013 7.71206e-08H13.0927C13.6597 -0.000160116 14.1974 0.252022 14.5597 0.688096C14.9221 1.12417 15.0716 1.6989 14.9677 2.25627L14.1668 6.57815C13.9985 7.48102 13.2104 8.13555 12.2919 8.13529ZM8.26269 10.678C8.26269 9.62499 7.40902 8.77133 6.35598 8.77133C6.00496 8.77133 5.72041 9.05588 5.72041 9.4069C5.72041 9.75791 6.00496 10.0425 6.35598 10.0425C6.70699 10.0425 6.99155 10.327 6.99155 10.678C6.99155 11.0291 6.70699 11.3136 6.35598 11.3136C6.00496 11.3136 5.72041 11.0291 5.72041 10.678C5.72041 10.327 5.43585 10.0425 5.08484 10.0425C4.73382 10.0425 4.44927 10.327 4.44927 10.678C4.44927 11.7311 5.30293 12.5847 6.35598 12.5847C7.40902 12.5847 8.26269 11.7311 8.26269 10.678ZM12.0765 11.9491C12.0765 11.5981 11.7919 11.3135 11.4409 11.3135C11.0899 11.3135 10.8053 11.029 10.8053 10.6779C10.8053 10.3269 11.0899 10.0424 11.4409 10.0424C11.7919 10.0424 12.0765 10.3269 12.0765 10.6779C12.0765 11.029 12.361 11.3135 12.712 11.3135C13.063 11.3135 13.3476 11.029 13.3476 10.6779C13.3476 9.6249 12.4939 8.77124 11.4409 8.77124C10.3878 8.77124 9.53418 9.6249 9.53418 10.6779C9.53418 11.731 10.3878 12.5847 11.4409 12.5847C11.7919 12.5847 12.0765 12.3001 12.0765 11.9491Z"
                                        fill="#FFF"></path>
                                </svg>
                                <span class="count">{!! \App\Models\Cart::CartCount() !!} </span>
                            </a>
                        </li>

                        <div class="header-call">
                            <span class="call-text">{{$home_label_text}}</span>
                            <a href="tel:+48 222-512-234" target="_blank" title="call">
                                <span class="call-text">{{$home_contact}}</span>
                                <svg class="call-icon" height="30" viewBox="0 0 48 48" width="30"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49 2.24.74 4.65 1.14 7.14 1.14 1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2-18.78 0-34-15.22-34-34 0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"
                                        fill="#fff"></path>
                                </svg>
                            </a>
                        </div>
                    </ul>
                    <div class="mobile-menu">
                        <button class="mobile-menu-button" id="menu">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M 4 7 L 4 9 L 28 9 L 28 7 Z M 4 15 L 4 17 L 28 17 L 28 15 Z M 4 23 L 4 25 L 28 25 L 28 23 Z"
                                    fill="#fff" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endif
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
                    <a href="#" class="acnav-label">
                        Shop All
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
                                <li>
                                    <a href="product.html">NEW</a>
                                </li>
                                <li>
                                    <a href="product.html">TOP TEN FEDORAS</a>
                                </li>
                                <li>
                                    <a href="product.html">RESERVED</a>
                                </li>
                                <li>
                                    <a href="product.html">LAST CHANCE</a>
                                </li>
                                <li>
                                    <a href="product.html">OUTLET</a>
                                </li>
                                <li>
                                    <a href="product.html">NAME COLLABORATION</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-h-link menu-h-drop has-children">
                            <a href="#" class="acnav-label">
                                <span>Products</span>
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
                            <ul class="acnav-list">
                                <li>
                                    <a href="product.html">Necklaces</a>
                                </li>
                                <li>
                                    <a href="product.html">Rings</a>
                                </li>
                                <li>
                                    <a href="product.html">Bracelat</a>
                                </li>
                                <li>
                                    <a href="product.html">Bangles</a>
                                </li>
                                <li>
                                    <a href="product.html">Earring</a>
                                </li>
                                <li>
                                    <a href="product.html">Chains</a>
                                </li>
                                <li>
                                    <a href="product.html">Rings</a>
                                </li>
                                <li>
                                    <a href="product.html">Bracelat</a>
                                </li>
                                <li>
                                    <a href="product.html">Bangles</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-h-link menu-h-drop has-children">
                            <a href="#" class="acnav-label">
                                <span>The Edit</span>
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
                            <ul class="acnav-list">
                                <li>
                                    <a href="product.html">Panama</a>
                                </li>
                                <li>
                                    <a href="product.html">Western</a>
                                </li>
                                <li>
                                    <a href="product.html">Cut and Sew</a>
                                </li>
                                <li>
                                    <a href="product.html">Feminine</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        Collection
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
                                <li>
                                    <a href="product.html">NEW</a>
                                </li>
                                <li>
                                    <a href="product.html">TOP TEN FEDORAS</a>
                                </li>
                                <li>
                                    <a href="product.html">RESERVED</a>
                                </li>
                                <li>
                                    <a href="product.html">LAST CHANCE</a>
                                </li>
                                <li>
                                    <a href="product.html">OUTLET</a>
                                </li>
                                <li>
                                    <a href="product.html">NAME COLLABORATION</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-h-link menu-h-drop has-children">
                            <a href="#" class="acnav-label">
                                <span>Products</span>
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
                            <ul class="acnav-list">
                                <li>
                                    <a href="product.html">Necklaces</a>
                                </li>
                                <li>
                                    <a href="product.html">Rings</a>
                                </li>
                                <li>
                                    <a href="product.html">Bracelat</a>
                                </li>
                                <li>
                                    <a href="product.html">Bangles</a>
                                </li>
                                <li>
                                    <a href="product.html">Earring</a>
                                </li>
                                <li>
                                    <a href="product.html">Chains</a>
                                </li>
                                <li>
                                    <a href="product.html">Rings</a>
                                </li>
                                <li>
                                    <a href="product.html">Bracelat</a>
                                </li>
                                <li>
                                    <a href="product.html">Bangles</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="mobile-item">
                    <a href="about.html">About Us</a>
                </li>
                <li class="mobile-item">
                    <a href="faqs.html">FAQs</a>
                </li>
                <li class="mobile-item">
                    <a href="contact-us.html">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
    <!--header end here-->
</header>

<!--header end here-->

@push('page-script')
    <script>
        $(document).ready(function(){
            $(".search_product_globaly").on('click',function(e){
                e.preventDefault();
                var product = $('.search_input').val();

                var data = {
                    product   : product,
                }

                $.ajax({
                    url:  '{{route('search.product',$slug)}}',
                    context: this,
                    data: data,
                    success: function(responce) {
                        window.location.href =responce;
                    }
                });
            });
        });
    </script>
@endpush
