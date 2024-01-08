
        @php
            $theme_json = $homepage_json;
            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
            $profile = asset(Storage::url('uploads/logo/'));
            $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
            $theme_logos = get_file($theme_logo , APP_THEME());

        @endphp
        <header class="site-header header-style-one">
            <div class="announcebar">
                <div class="container">

                    <div class="announce-row row align-items-center">
                        <div class="annoucebar-left col-6 d-flex">
                            @php
                                $contact_us_header_worktime_image = $contact_us_header_worktime = $contact_us_header_calling = $contact_us_header_call = $contact_us_header_image = '';

                                $homepage_header_1_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_header_1_key != '' ) {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if($value['field_slug'] == 'homepage-header-icon-image') {
                                            $contact_us_header_worktime_image = $value['field_default_text'];
                                        }
                                        if($value['field_slug'] == 'homepage-header-title') {
                                            $contact_us_header_worktime = $value['field_default_text'];
                                        }
                                        if($value['field_slug'] == 'homepage-header-label') {
                                            $contact_us_header_calling = $value['field_default_text'];
                                        }
                                        if($value['field_slug'] == 'homepage-header-link') {
                                            $contact_us_header_call = $value['field_default_text'];
                                        }
                                        if($value['field_slug'] == 'homepage-header-call-icon-image') {
                                            $contact_us_header_image = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp

                            <p style="display: contents;">
                                <img src="{{get_file($contact_us_header_worktime_image , APP_THEME())}}" alt="" class="contact" >
                                {!! $contact_us_header_worktime !!}
                            </p>
                        </div>
                        <div class="announcebar-right col-6 d-flex justify-content-end">
                            <a href="tel:610403403">
                                <span>{!! $contact_us_header_calling !!}<b> {!! $contact_us_header_call !!}</b></span>
                                <img src="{{get_file($contact_us_header_image ,APP_THEME())}}" alt="" class="contact_us">
                            </a>
                            <button id="announceclose">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"
                                    role="presentation" class="icon icon-close" viewBox="0 0 18 17">
                                    <path
                                        d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-navigationbar">
                <div class="container">
                    <div class="navigationbar-row d-flex align-items-center">
                        <div class="logo-col">
                            <h1>
                                <a href="{{route('landing_page',$slug)}}">
                                    <img src="{{  (isset($theme_logos) && !empty($theme_logos) ? $theme_logos : 'themes/'.APP_THEME().'/assets/images/logo.png') }}" alt="style" >
                                 </a>
                            </h1>
                        </div>
                        <div class="menu-items-col">
                            <ul class="main-nav">
                                <li class="menu-lnk has-item">
                                    <a href="#" class="category-btn active">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.3068 6H4.69348C3.82825 6 3.14243 6.73002 3.1964 7.59357L3.5714 13.5936C3.62081 14.3841 4.27638 15 5.06848 15H12.9318C13.7239 15 14.3794 14.3841 14.4289 13.5936L14.8039 7.59357C14.8578 6.73002 14.172 6 13.3068 6ZM4.69348 4.5C2.96301 4.5 1.59138 5.96004 1.69932 7.68714L2.07432 13.6871C2.17314 15.2682 3.48429 16.5 5.06848 16.5H12.9318C14.516 16.5 15.8271 15.2682 15.9259 13.6871L16.3009 7.68713C16.4089 5.96004 15.0372 4.5 13.3068 4.5H4.69348Z"
                                                fill="#183A40" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.25 5.25C5.25 3.17893 6.92893 1.5 9 1.5C11.0711 1.5 12.75 3.17893 12.75 5.25V6.75C12.75 7.16421 12.4142 7.5 12 7.5C11.5858 7.5 11.25 7.16421 11.25 6.75V5.25C11.25 4.00736 10.2426 3 9 3C7.75736 3 6.75 4.00736 6.75 5.25V6.75C6.75 7.16421 6.41421 7.5 6 7.5C5.58579 7.5 5.25 7.16421 5.25 6.75V5.25Z"
                                                fill="#183A40" />
                                        </svg>
                                        {{ __('Style Products') }}
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
                                <li class="menu-lnk has-item">
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
                                            {{-- <li><a href="{{route('page.cart')}}"> {{ __('Cart')}} </a> --}}
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-lnk">
                                    <a href="{{route('page.contact_us',$slug)}}">
                                        {{ __('Contact') }}
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-right d-flex  justify-content-end">
                                <li class="search-header">
                                    <a href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z"
                                                fill="#183A40" />
                                        </svg>
                                        <span class="desk-only icon-lable"> {{ __('Search')}} </span>
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
                                <li class="cart-header" style="pointer-events: auto">
                                    <a href="javascript:;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 19 17"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                                fill="white" />
                                        </svg>

                                        <span class="count">{!! \App\Models\Cart::CartCount() !!}</span>
                                    </a>
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
                                        @foreach ($MainCategoryList as $category)
                                            <li class="menu-h-link menu-h-drop has-children">
                                                <a href="#" class="acnav-label">
                                                    <span>{{$category->name}}</span>
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
                                                    @foreach ($SubCategoryList as $cat)
                                                        @if ($cat->maincategory_id == $category->id)
                                                            <li>
                                                                <a href="{{route('page.product-list',[$slug,'main_category' => $category->id,'sub_category' => $cat->id ])}}">{{$cat->name}}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="mobile-item has-children">
                            <a href="{{route('page.product-list',$slug)}}" class="">
                                {{ __('Collection') }}
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
                                    </ul>   
                                </li>
                            </ul>
                        </li>
                        <li class="mobile-item">
                            <a href="{{route('page.contact_us',$slug)}}">{{ __('Contact Us') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
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
                                @foreach ($search_products as $pro_id => $pros)
                                    <option value="{{$pros}}"></option>
                                @endforeach
                            </datalist>

                            <button type="submit"  class="btn search_product_globaly">
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
