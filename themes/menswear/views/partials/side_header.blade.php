@php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');

@endphp

<!--header start here-->
<header class="site-header header-style-one dark-header">
    @php
        $homepage_header_1_key = array_search('homepage-header-1', array_column($theme_json, 'unique_section_slug'));
        // dd($homepage_header_1_key);
        if ($homepage_header_1_key != '') {
            $homepage_header_1 = $theme_json[$homepage_header_1_key];
            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                if ($value['field_slug'] == 'homepage-header-title') {
                    $home_header = $value['field_default_text'];
                }
            }
        }
    @endphp
    @if ($homepage_header_1['section_enable'] == 'on')
        <div class="announcebar">
            <div class="container">
                <div class="announce-row no-gutters row align-items-center">
                    <div class=" col-6">
                        <div class="annoucebar-left justify-content-between">
                            <p>{!! $home_header !!}</p>
                        </div>
                    </div>
                    <div class=" col-6 d-flex justify-content-end">
                        <div class="announcebar-right d-flex align-items-center justify-content-end">
                            <ul class="d-flex align-items-center">
                                @foreach ($pages as $page)
                                    @if ($page->page_status == 'custom_page')
                                        <li class="menu-lnk" style="color : black;"> <a
                                                href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                        </li>
                                    @else
                                    @endif
                                @endforeach
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
                <div class="menu-items-col row align-items-center no-gutters">
                    <div class="col-md-8 col-2 d-flex align-items-center">
                        <div class="hide-on-tblt">
                            @php
                                $homepage_header_1_key = array_search('homepage-header-3', array_column($theme_json, 'unique_section_slug'));
                                if ($homepage_header_1_key != '') {
                                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                        if ($value['field_slug'] == 'homepage-header-label') {
                                            $home_header = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if ($homepage_header_1['section_enable'] == 'on')
                                <div class="home-link">
                                    {!! $home_header !!}
                                </div>
                            @endif
                            <div class="fixed-headr-left">
                                <div class="logo-col">
                                    <h1>
                                        <a href="{{ route('landing_page',$slug) }}">
                                            <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                                alt="logo">
                                        </a>
                                    </h1>
                                </div>
                                <div class="cart-header desk-only">
                                    <a href="javascript:;">
                                        <svg width="20" height="20" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                            </path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                            </path>
                                        </svg>
                                        <span class="desk-only icon-lable cart-price"
                                            id="sub_total_main_page">{{ 0 }} </span>{{ $currency }}
                                        <span class="count">{!! \App\Models\Cart::CartCount() !!} </span>
                                    </a>

                                </div>
                                <ul class="main-nav">
                                    <li class="menu-lnk">
                                        <a href="{{ route('page.contact_us',$slug) }}">
                                            {{ __('Contact') }}
                                        </a>
                                    </li>

                                    {{-- <li class="menu-lnk">
                                        <a href="{{route('page.about')}}">
                                            {{ __('Blog') }}
                                        </a> --}}

                                    @foreach ($pages as $page)
                                        @if ($page->page_slug == 'about')
                                            <li class="menu-lnk"><a
                                                    href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                            </li>
                                        @else
                                        @endif
                                    @endforeach
                                    {{-- </li> --}}

                                    <li class="menu-lnk">
                                        <a href="{{ route('page.product-list',$slug) }}"> {{ __('Shop All') }} </a>
                                    </li>
                                </ul>
                                <div class="socials d-flex align-items-center justify-content-center">
                                    <a href="https://www.facebook.com/" target="_blank">FB</a>
                                    IN<a href="https://twitter.com/" target="_blank">TW</a>
                                </div>
                            </div>
                        </div>

                        <div class="show-on-tblt">
                            <div class="logo-col">
                                <h1>
                                    <a href="{{ route('landing_page',$slug) }}">
                                        <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                            alt="logo" style="filter: drop-shadow(1px 3px 8px #011c4b);">
                                    </a>
                                </h1>

                            </div>

                            <ul class="main-nav">
                                <li class="menu-lnk has-item">
                                    <a href="javascript:void()" class="category-btn">
                                        {{ __('ACCESSORIES') }}
                                    </a>
                                    @if ($has_subcategory)
                                        <div class="mega-menu menu-dropdown">
                                            <div class="mega-menu-container container">
                                                <ul class="row">
                                                    @foreach ($MainCategoryList as $category)
                                                        <li class="col-md-2 col-12">
                                                            <ul class="megamenu-list arrow-list">
                                                                <li class="list-title"><span>{{ $category->name }}</span>
                                                                </li>
                                                                <li><a
                                                                        href="{{ route('page.product-list', [$slug,'main_category' => $category->id]) }}">{{ __('All') }}</a>
                                                                </li>
                                                                @foreach ($SubCategoryList as $cat)
                                                                    @if ($cat->maincategory_id == $category->id)
                                                                        <li><a
                                                                                href="{{ route($slug,'page.product-list', ['main_category' => $category->id, 'sub_category' => $cat->id]) }}">{{ $cat->name }}</a>
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
                                <li class="menu-lnk">
                                    <a href="{{ route('page.product-list',$slug) }}"> {{ __('Shop All') }} </a>
                                </li>
                                <li class="menu-lnk has-item">
                                    <a href="#">
                                        {{ __('Pages') }}
                                    </a>
                                    <div class="menu-dropdown">
                                        <ul>
                                            @foreach ($pages as $page)
                                                <li><a
                                                        href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                                </li>
                                            @endforeach
                                            <li><a href="{{ route('page.faq',$slug) }}"> {{ __('FAQs') }} </a></li>
                                            <li><a href="{{ route('page.blog',$slug) }}"> {{ __('Blog') }} </a></li>
                                            <li><a href="{{ route('page.product-list',$slug) }}"> {{ __('Collection') }} </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-lnk">
                                    <a href="{{ route('page.contact_us',$slug) }}">
                                        {{ __('Contact') }}
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-4 col-10">
                        <ul class="menu-right d-flex justify-content-end">
                            @auth
                                <li>
                                    <a href="javascript:;" title="wish" class="wish-header">
                                        <svg width="15" height="12" viewBox="0 0 15 12">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.88653 2.64206C7.62555 2.89251 7.21347 2.89251 6.95248 2.64206L6.48546 2.19388C5.93882 1.6693 5.20036 1.349 4.38425 1.349C2.70793 1.349 1.349 2.70793 1.349 4.38425C1.349 5.99134 2.21896 7.31837 3.47486 8.4087C4.73184 9.49996 6.23468 10.2237 7.13261 10.5931C7.32035 10.6703 7.51866 10.6703 7.70641 10.5931C8.60433 10.2237 10.1072 9.49996 11.3642 8.4087C12.6201 7.31836 13.49 5.99133 13.49 4.38425C13.49 2.70793 12.1311 1.349 10.4548 1.349C9.63866 1.349 8.90019 1.6693 8.35356 2.19388L7.88653 2.64206ZM7.41951 1.22056C6.63176 0.464599 5.56226 0 4.38425 0C1.9629 0 0 1.9629 0 4.38425C0 8.67965 4.7015 11.0517 6.61941 11.8406C7.13592 12.0531 7.70309 12.0531 8.21961 11.8406C10.1375 11.0517 14.839 8.67964 14.839 4.38425C14.839 1.9629 12.8761 0 10.4548 0C9.27675 0 8.20725 0.464599 7.41951 1.22056Z">
                                            </path>
                                        </svg>
                                        <span class="desk-only icon-lable">{{ __('WISHLIST') }}</span>
                                    </a>
                                </li>
                            @endauth
                            <li class="search-header">
                                <a href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        viewBox="0 0 19 19" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z"
                                            fill="#183A40" />
                                    </svg>
                                    @auth
                                        <span class="desk-only icon-lable" style="margin-right: -23px;">
                                            {{ __('Search') }} </span>
                                    @endauth
                                    @guest
                                        <span class="desk-only icon-lable"> {{ __('Search') }} </span>
                                    @endguest
                                </a>
                            </li>

                            @auth
                            <li class="profile-nav-menu">
                                <ul class="main-nav top-main-nav profile-nav">
                                    <li class="menu-lnk has-item">
                                        <a href="#">
                                            <span>{{ __('My profile') }}</span>
                                        </a>
                                        <div class="menu-dropdown" style="padding: initial;">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('my-account.index',$slug) }}"
                                                        style="margin-left: 17px; width: fit-content; color: black;">{{ __('My Account') }}</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout_user',$slug) }}"
                                                        id="form_logout">
                                                        @csrf
                                                        <a href="#"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            style="color: black; width: fit-content;"
                                                            class="dropdown-item">
                                                            {{ __('Log Out') }}
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                                {{-- <li class="main-nav top-main-nav">
                                    <div class="menu-lnk has-item">
                                        <a href="#">
                                            <span>{{ __('My profile') }}</span>
                                        </a>
                                        <div class="menu-dropdown" style="padding: initial;">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('my-account.index',$slug) }}"
                                                        style="margin-left: 17px; width: fit-content; color: black;">{{ __('My Account') }}</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout_user',$slug) }}"
                                                        id="form_logout">
                                                        @csrf
                                                        <a href="#"
                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                            style="color: black; width: fit-content;"
                                                            class="dropdown-item">
                                                            {{ __('Log Out') }}
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li> --}}

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
                                        <span class="desk-only icon-lable">{{ __('Login') }}</span>
                                    </a>
                                </li>
                            @endguest

                            <li class="mobile-menu mobile-only">
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
                            <option value="{{ $pros }}"></option>
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
<!--header end here-->


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
