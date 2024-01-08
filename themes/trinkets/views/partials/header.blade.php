@php
    $theme_json = $homepage_json;
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    if ($theme_logo) {
        $theme_logo = get_file($theme_logo, APP_THEME());
    }
    // dd($theme_logo)
@endphp

<!--header start here-->
<header class="site-header header-style-one">
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigationbar-row d-flex align-items-center">
                <div class="logo-col">
                    <h1>
                        <a href="{{ route('landing_page',$slug) }}">
                            <img src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : asset('themes/' . APP_THEME() . '/assets/images/logo-dark.svg') }}"
                                alt="logo">
                        </a>
                    </h1>
                </div>
                <div class="menu-items-col">
                    <ul class="main-nav">
                        <li class="menu-lnk has-item">
                            <a href="javascript:void()" class="category-btn">
                                {{ __('ALL CATEGORY') }}
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

                        <li class="menu-lnk" style="margin-right: 22px;">
                            <a href="{{ route('page.product-list',$slug) }}"> {{ __('Shop All') }} </a>

                        </li>

                        <li class="menu-lnk has-item">
                            <a href="javascript:void()">
                                {{ __('PAGES') }}
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    @foreach ($pages as $page)
                                        <li><a
                                                href="{{ route('custom.page', [$slug,$page->page_slug]) }}">{{ $page->name }}</a>
                                        </li>
                                    @endforeach
                                    <li><a href="{{ route('page.faq',$slug) }}">{{ __('FAQs') }}</a></li>
                                    <li><a href="{{ route('page.blog',$slug) }}">{{ __('Blog') }}</a></li>
                                    <li><a href="{{ route('page.product-list',$slug) }}">{{ __('Collection') }}</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-lnk">
                            <a href="{{ route('page.contact_us',$slug) }}">
                                {{ __('Contact') }}
                            </a>
                        </li>

                    </ul>

                    <ul class="menu-right d-flex  justify-content-end align-items-center">
                        @auth
                            <li class="profile-header has-item">
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
                                        <li><a href="{{ route('my-account.index',$slug) }}">{{ __('My Account') }}</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout_user',$slug) }}" id="form_logout"
                                                style="margin-right: 130px;">
                                                @csrf
                                                <a href="{{ route('logout',$slug) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endauth
                        @guest
                            <li class="profile-header has-item">
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
                        <li class="cart-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17"
                                    viewBox="0 0 19 17" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.5698 10.627H6.97178C5.80842 10.6273 4.81015 9.79822 4.59686 8.65459L3.47784 2.59252C3.40702 2.20522 3.06646 1.92595 2.67278 1.93238H0.805055C0.360435 1.93238 0 1.57194 0 1.12732C0 0.682701 0.360435 0.322266 0.805055 0.322266H2.68888C3.85224 0.321937 4.85051 1.15101 5.0638 2.29465L6.18282 8.35672C6.25364 8.74402 6.5942 9.02328 6.98788 9.01686H15.5778C15.9715 9.02328 16.3121 8.74402 16.3829 8.35672L17.3972 2.88234C17.4407 2.64509 17.3755 2.40085 17.2195 2.21684C17.0636 2.03283 16.8334 1.92843 16.5922 1.93238H7.2455C6.80088 1.93238 6.44044 1.57194 6.44044 1.12732C6.44044 0.682701 6.80088 0.322266 7.2455 0.322266H16.5841C17.3023 0.322063 17.9833 0.641494 18.4423 1.19385C18.9013 1.74622 19.0907 2.4742 18.959 3.18021L17.9447 8.65459C17.7314 9.79822 16.7331 10.6273 15.5698 10.627ZM10.466 13.8478C10.466 12.5139 9.38464 11.4326 8.05079 11.4326C7.60617 11.4326 7.24573 11.7931 7.24573 12.2377C7.24573 12.6823 7.60617 13.0427 8.05079 13.0427C8.49541 13.0427 8.85584 13.4032 8.85584 13.8478C8.85584 14.2924 8.49541 14.6528 8.05079 14.6528C7.60617 14.6528 7.24573 14.2924 7.24573 13.8478C7.24573 13.4032 6.88529 13.0427 6.44068 13.0427C5.99606 13.0427 5.63562 13.4032 5.63562 13.8478C5.63562 15.1816 6.71693 16.2629 8.05079 16.2629C9.38464 16.2629 10.466 15.1816 10.466 13.8478ZM15.2963 15.4579C15.2963 15.0133 14.9358 14.6528 14.4912 14.6528C14.0466 14.6528 13.6862 14.2924 13.6862 13.8478C13.6862 13.4032 14.0466 13.0427 14.4912 13.0427C14.9358 13.0427 15.2963 13.4032 15.2963 13.8478C15.2963 14.2924 15.6567 14.6528 16.1013 14.6528C16.5459 14.6528 16.9064 14.2924 16.9064 13.8478C16.9064 12.5139 15.8251 11.4326 14.4912 11.4326C13.1574 11.4326 12.076 12.5139 12.076 13.8478C12.076 15.1816 13.1574 16.2629 14.4912 16.2629C14.9358 16.2629 15.2963 15.9025 15.2963 15.4579Z"
                                        fill="white"></path>
                                </svg>

                                <span class="desk-only icon-lable">{{ __('CART') }}</span>
                                <span class="desk-only">(</span>
                                <span class="count"> {{ \App\Models\Cart::CartCount() }} </span>
                                <span class="desk-only">)</span>
                            </a>
                        </li>
                        <li class="search-header">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                    viewBox="0 0 21 21" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.3056 16.9828C13.699 18.2316 11.6802 18.9753 9.48767 18.9753C4.24777 18.9753 0 14.7276 0 9.48767C0 4.24777 4.24777 0 9.48767 0C14.7276 0 18.9753 4.24777 18.9753 9.48767C18.9753 11.6802 18.2316 13.699 16.9828 15.3056L20.6526 18.9752C21.1158 19.4383 21.1158 20.1892 20.6526 20.6524C20.1895 21.1155 19.4386 21.1155 18.9754 20.6524L15.3056 16.9828ZM16.6034 9.48767C16.6034 13.4176 13.4176 16.6034 9.48767 16.6034C5.55775 16.6034 2.37192 13.4176 2.37192 9.48767C2.37192 5.55775 5.55775 2.37192 9.48767 2.37192C13.4176 2.37192 16.6034 5.55775 16.6034 9.48767Z"
                                        fill="white"></path>
                                </svg>
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

                <div class="menu-btn mobile-menu-button">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                            fill="none">
                            <g clip-path="url(#clip0_9_1486)">
                                <path
                                    d="M17.25 11.25L0.75 11.25L0.75 16.5C0.749999 17.3284 1.42157 18 2.25 18L15.75 18C16.5784 18 17.25 17.3284 17.25 16.5L17.25 11.25Z"
                                    fill="white" fill-opacity="0.3"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.25 0.749999C8.25 0.335786 8.58579 -8.23017e-07 9 -7.86805e-07C9.41421 -7.50593e-07 9.75 0.335786 9.75 0.749999L9.75 6.43965L10.7197 5.46999C11.0126 5.17709 11.4874 5.17709 11.7803 5.46998C12.0732 5.76288 12.0732 6.23775 11.7803 6.53065L9.53033 8.78065C9.38968 8.9213 9.19891 9.00032 9 9.00032C8.80109 9.00032 8.61032 8.9213 8.46967 8.78065L6.21967 6.53064C5.92678 6.23775 5.92678 5.76288 6.21967 5.46998C6.51256 5.17709 6.98744 5.17709 7.28033 5.46999L8.25 6.43966L8.25 0.749999ZM15.75 1.5C16.9926 1.5 18 2.50736 18 3.75L18 10.5C18 11.7426 16.9926 12.75 15.75 12.75L2.25 12.75C1.00736 12.75 -1.02657e-06 11.7426 -9.17939e-07 10.5L-3.27835e-07 3.75C-2.192e-07 2.50736 1.00736 1.5 2.25 1.5L4.125 1.5C4.53921 1.5 4.875 1.83579 4.875 2.25C4.875 2.66421 4.53921 3 4.125 3L2.25 3C1.83579 3 1.5 3.33579 1.5 3.75L1.5 10.5C1.5 10.9142 1.83578 11.25 2.25 11.25L15.75 11.25C16.1642 11.25 16.5 10.9142 16.5 10.5L16.5 3.75C16.5 3.33579 16.1642 3 15.75 3L13.8857 3C13.4715 3 13.1357 2.66421 13.1357 2.25C13.1357 1.83579 13.4715 1.5 13.8857 1.5L15.75 1.5Z"
                                    fill="white"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_9_1486">
                                    <rect width="18" height="18" fill="white"
                                        transform="translate(18) rotate(90)">
                                    </rect>
                                </clipPath>
                            </defs>
                        </svg>
                        {{ __('MENU')}}
                    </button>
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
