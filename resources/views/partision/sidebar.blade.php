@php
    $ThemeSubcategory = \App\Models\Utility::ThemeSubcategory();
    $logo = asset(Storage::url('uploads/logo/'));
    $company_logo = \App\Models\Utility::GetLogo();
    $company_logo = get_file($company_logo, APP_THEME());
    $woocommerce_setting_enabled = \App\Models\Utility::GetValueByName('woocommerce_setting_enabled', $theme_name);
    $shopify_setting_enabled = \App\Models\Utility::GetValueByName('shopify_setting_enabled', $theme_name);

    $plan = \App\Models\Plan::find(\Auth::user()->plan);
    $plano = \App\Models\Plan::where('name','Renew')->first();
@endphp

<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->
@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif
<div class="navbar-wrapper">
    <div class="m-header">
        <a href="#" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="{{ isset($company_logo) && !empty($company_logo) ? $company_logo . '?timestamp=' . time() : $logo . '/logo-dark.png' . '?timestamp=' . time() }}"
                alt="" class="logo logo-lg" />
        </a>
    </div>
    @if($plano->name != $plan->name)
    <div class="navbar-content">
        <ul class="dash-navbar">
            @if (\Auth::user()->can('Manage Dashboard') || \Auth::user()->can('Manage Store Analytics'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-home"></i>
                        </span><span class="dash-mtext">{{ __('Dashboard') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        @can('Manage Dashboard')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['admin.dashboard', '']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                        @endcan
                        @can('Manage Store Analytics')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['themeanalytic', '']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.themeanalytic') }}">{{ __('Store Analytics') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (\Auth::user()->can('Manage Themes'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.themes') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Themes') }}</span>
                    </a>
                </li>
            @endif


            @if (\Auth::user()->can('Manage User') || \Auth::user()->can('Manage Role'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon">
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="dash-mtext">{{ __('Staff') }}</span>
                        <span class="dash-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'admin.roles' || Request::segment(1) == 'admin.roles' ? ' show' : '' }}">
                        @can('Manage Role')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['admin.roles', '']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
                            </li>
                        @endcan
                        @can('Manage User')
                            <li
                                class="dash-item {{ Request::segment(1) == 'users.index' || Request::route()->getName() == 'users.show' ? ' active dash-trigger' : 'collapsed' }}">
                                <a class="dash-link" href="{{ route('admin.users.index') }}">{{ __('User') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (\Auth::user()->can('Manage DeliveryBoy'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['deliveryboy']) ? ' active' : '' }}">
                    <a href="{{ route('admin.deliveryboy.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-truck"></i></span>
                        <span class="dash-mtext">{{ __('Delivery Boy') }}</span>
                    </a>
                </li>
            @endif


            @if (\Auth::user()->can('Manage Store Setting'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.app-setting.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="fa fa-cogs"></i></span>
                        <span class="dash-mtext">{{ __('Store Settings') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'admin' && env('IS_MOBILE') == 'yes')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.mobilescreen.content') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-device-mobile"></i></span>
                        <span class="dash-mtext">{{ __('Mobile App Settings') }}</span>
                    </a>
                </li>
            @endif

            {{-- Product related section --}}
            @if (Auth::user()->can('Manage Products') ||
                    \Auth::user()->can('Manage Product Category') ||
                    \Auth::user()->can('Manage Product Sub Category') ||
                    \Auth::user()->can('Manage Product Tax') ||
                    \Auth::user()->can('Manage Ratting') ||
                    \Auth::user()->can('Manage Product Question'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-shopping-cart"></i>
                        </span><span class="dash-mtext">{{ __('Products') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        @can('Manage Products')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['product', 'product-variant']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.product.index') }}">{{ __('Product') }}</a>
                            </li>
                        @endcan

                        @can('Manage Variants')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['product-attribute', 'attribute-option']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.product-attribute.index') }}">{{ __('Attributes') }}</a>
                            </li>
                        @endcan

                        @can('Manage Ratting')
                            <li class="dash-item {{ in_array(Request::segment(1), ['review']) ? ' active' : '' }}">
                                <a href="{{ route('admin.review.index') }}" class="dash-link">
                                    {{ __('Review') }}
                                </a>
                            </li>
                        @endcan

                        @can('Manage Product Question')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['product-question']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.product-question.index') }}">{{ __('Question Answer') }}</a>
                            </li>
                        @endcan

                        @can('Manage Product Category')
                            <li class="dash-item {{ in_array(Request::segment(1), ['main-category']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.main-category.index') }}">{{ __('Main Category') }}</a>
                            </li>
                        @endcan
                        @can('Manage Product Sub Category')
                            @if ($ThemeSubcategory)
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['sub-category']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.sub-category.index') }}">{{ __('Sub Category') }}</a>
                                </li>
                            @endif
                        @endcan

                        @can('Manage Product Tax')
                            <li class="dash-item {{ in_array(Request::segment(1), ['tax']) ? ' active' : '' }}">
                                <a href="{{ route('admin.tax.index') }}" class="dash-link">
                                    {{ __('Tax') }}
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif

            @if ($plan->shipping_method == 'on')
                @if (\Auth::user()->can('Manage Shipping Class') || \Auth::user()->can('Manage Shipping Zone'))
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="ti ti-truck-delivery"></i>
                            </span><span class="dash-mtext">{{ __('Shipping') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'shipping' || Request::segment(1) == 'shippingZone' ? 'show' : '' }}">
                            @can('Manage Shipping Class')
                                <li class="dash-item {{ in_array(Request::segment(1), ['shipping']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.shipping.index') }}">{{ __('Shipping Class') }}</a>
                                </li>
                            @endcan
                            @can('Manage Shipping Zone')
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['shippingZone']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.shippingZone.index') }}">{{ __('Shipping Zone') }}</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif
            @endif

            {{-- order related section --}}
            @if (\Auth::user()->can('Manage Orders') || \Auth::user()->can('Manage Refund Request'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-briefcase"></i>
                        </span><span class="dash-mtext">{{ __('Orders') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        @can('Manage Orders')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['order', 'order-view']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.order.index') }}">{{ __('Order') }}</a>
                            </li>
                        @endcan
                        @can('Manage Refund Request')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['order', 'order-view']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.RefundRequest.index') }}">{{ __('Order Refund Request') }}</a>
                            </li>
                        @endcan


                    </ul>
                </li>
            @endif


            {{-- customer section --}}
            @if (\Auth::user()->can('Manage Customer'))
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['customer']) ? ' active' : '' }}">
                    <a href="{{ route('admin.customer.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user"></i></span>
                        <span class="dash-mtext">{{ __('Customer') }}</span>
                    </a>
                </li>
            @endif


            {{-- reports module --}}
            @if (
                \Auth::user()->can('Manage Customer Reports') ||
                    \Auth::user()->can('Manage Order Reports') ||
                    \Auth::user()->can('Manage Stock Reports'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-chart-bar"></i>
                        </span><span class="dash-mtext">{{ __('Reports') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'order' || Request::segment(1) == 'stock' ? 'show' : '' }}">
                        @can('Manage Customer Reports')
                            <li class="dash-item {{ in_array(Request::segment(1), ['reports']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.reports.index') }}">{{ __('Customer Reports') }}</a>
                            </li>
                        @endcan

                        @can('Manage Order Reports')
                            <li class="dash-item dash-hasmenu ">
                                <a class="dash-link"
                                    href="#">{{ __('Order Reports') }}<span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="dash-submenu">
                                    <li class="dash-item {{ in_array(Request::segment(1), ['order']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.reports.order_report') }}">{{ __('Sales Report') }}</a>
                                    </li>
                                    <li class="dash-item {{ in_array(Request::segment(1), ['product-order-sale-reports']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.reports.order_product_report') }}">{{ __('Sales Product Report') }}</a>
                                    </li>
                                    <li class="dash-item {{ in_array(Request::segment(1), ['category-order-sale-reports']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.reports.order_category_report') }}">{{ __('Sales Category Report') }}</a>
                                    </li>
                                    <li class="dash-item {{ in_array(Request::segment(1), ['downloadable-product-report']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.reports.order_downloadable_report') }}">{{ __('Sales Downloadable Product') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('Manage Stock Reports')
                            <li class="dash-item {{ in_array(Request::segment(1), ['stock']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.reports.stock_report') }}">{{ __('Stock Reports') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            {{-- marketing --}}
            @if (
                \Auth::user()->can('Manage Product Coupon') ||
                    \Auth::user()->can('Manage Subscriber') ||
                    \Auth::user()->can('Manage Wishlist') ||
                    \Auth::user()->can('Manage Cart'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-confetti"></i>
                        </span><span class="dash-mtext">{{ __('Marketing') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'order' || Request::segment(1) == 'stock' ? 'show' : '' }}">
                        @can('Manage Product Coupon')
                            <li class="dash-item {{ in_array(Request::segment(1), ['coupon']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.coupon.index') }}">{{ __('Coupon') }}</a>
                            </li>
                        @endcan
                        @can('Manage Subscriber')
                            <li class="dash-item {{ in_array(Request::segment(1), ['newsletter']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.newsletter.index') }}">{{ __('Newsletter') }}</a>
                            </li>
                        @endcan
                        @can('Manage Flashsale')
                        <li class="dash-item {{ in_array(Request::segment(1), ['flash']) ? ' active' : '' }}">
                            <a class="dash-link"
                                href="{{ route('admin.flash-sale.index') }}">{{ __('Flash Sale') }}</a>
                        </li>
                        @endcan
                        @can('Manage Wishlist')
                            <li class="dash-item {{ in_array(Request::segment(1), ['wishlist']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.wishlist.index') }}">{{ __('Wishlist') }}</a>
                            </li>
                        @endcan
                        @can('Manage Cart')
                            <li class="dash-item {{ in_array(Request::segment(1), ['abandon']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.abandon.carts.handled') }}">{{ __('Abandon Cart') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif


            {{-- Woocommerce related section --}}
            @if (
                \Auth::user()->can('Manage Woocommerce Category') ||
                    \Auth::user()->can('Manage Woocommerce Product') ||
                    \Auth::user()->can('Manage Woocommerce Customer') ||
                    \Auth::user()->can('Manage Woocommerce Coupon'))
                @if ($woocommerce_setting_enabled == 'on')
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="ti ti-letter-w"></i>
                            </span><span class="dash-mtext">{{ __('WooCommerce') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                            @can('Manage Woocommerce Category')
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['woocom_category']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.woocom_category.index') }}">{{ __('Main Category') }}</a>
                                </li>
                            @endcan

                            @can('Manage Woocommerce Product')
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['woocom_product']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.woocom_product.index') }}">{{ __('Product') }}</a>
                                </li>
                            @endcan

                            @can('Manage Woocommerce Customer')
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['woocom_customer']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.woocom_customer.index') }}">{{ __('Customer') }}</a>
                                </li>
                            @endcan

                            @can('Manage Woocommerce Coupon')
                                <li
                                    class="dash-item {{ in_array(Request::segment(1), ['woocom_coupon']) ? ' active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('admin.woocom_coupon.index') }}">{{ __('Coupon') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
            @endif
            {{-- Woocommerce related section --}}


            {{-- shopify related section --}}
                @if (
                    \Auth::user()->can('Manage Shopify Category') ||
                        \Auth::user()->can('Manage Shopify Product') ||
                        \Auth::user()->can('Manage Shopify Customer') ||
                        \Auth::user()->can('Manage Shopify Coupon'))
                    @if ($shopify_setting_enabled == 'on')
                        <li class="dash-item dash-hasmenu">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon">
                                <svg class="custom_svg" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="48px" height="48px"><path d="M 9.0253906 1 C 8.4771811 1 7.9869341 1.2551676 7.6308594 1.5800781 C 7.2747847 1.9049886 7.0116264 2.3049244 6.7871094 2.7597656 C 6.419507 3.5044784 6.1640451 4.4172783 6.0039062 5.4414062 L 3.3125 6.2402344 L 1.3300781 20.601562 L 14.507812 23.017578 L 14.693359 22.980469 L 22.683594 21.412109 L 20.089844 4.5996094 L 15.386719 2.6601562 L 14.380859 2.9589844 C 14.21929 2.6374669 14.038621 2.3383213 13.828125 2.0742188 C 13.356371 1.4823247 12.675562 1 11.853516 1 C 11.276705 1 10.805419 1.272447 10.390625 1.6191406 C 10.017225 1.277114 9.5836469 1 9.0253906 1 z M 9.0253906 3 C 8.9608854 3 9.047691 2.9742917 9.2558594 3.2714844 C 9.411183 3.493233 9.5778658 3.883755 9.7304688 4.3378906 L 8.1699219 4.8007812 C 8.2895591 4.3389782 8.4316818 3.9451621 8.5800781 3.6445312 C 8.7276861 3.3454976 8.8825591 3.1441989 8.9785156 3.0566406 C 9.0744722 2.9690824 9.0686002 3 9.0253906 3 z M 11.853516 3 C 11.895466 3 12.025676 3.021706 12.263672 3.3203125 C 12.307557 3.3753743 12.35309 3.4763757 12.398438 3.546875 L 11.613281 3.7792969 C 11.546007 3.6428945 11.477888 3.5094745 11.419922 3.3613281 C 11.656274 3.0587037 11.810998 3 11.853516 3 z M 14.53125 5 L 13.570312 20.8125 L 3.5742188 18.980469 L 5.1171875 7.7910156 L 14.53125 5 z M 16.517578 5.2890625 L 18.285156 6.0175781 L 20.414062 19.820312 L 15.578125 20.769531 L 16.517578 5.2890625 z M 10.390625 9.0039062 C 8.016625 9.0039062 6.8457031 10.605766 6.8457031 12.259766 C 6.8457031 14.235766 8.7773438 14.286422 8.7773438 15.482422 C 8.7773438 15.773422 8.5713594 16.169922 8.0683594 16.169922 C 7.3073594 16.169922 6.4042969 15.378906 6.4042969 15.378906 L 5.9414062 16.917969 C 5.9414062 16.917969 6.80525 18 8.53125 18 C 9.96025 18 11.017578 16.907891 11.017578 15.212891 C 11.017578 13.060891 8.6542969 12.707969 8.6542969 11.792969 C 8.6542969 11.626969 8.707625 10.949219 9.765625 10.949219 C 10.474625 10.949219 11.070312 11.271484 11.070312 11.271484 L 11.728516 9.265625 C 11.728516 9.265625 11.275625 8.9939062 10.390625 9.0039062 z"/></svg>
                                </span>
                                <span class="dash-mtext">{{ __('Shopify') }}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                            </a>
                            <ul
                                class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                                @can('Manage Shopify Category')
                                    <li
                                        class="dash-item {{ in_array(Request::segment(1), ['shopify_category']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.shopify_category.index') }}">{{ __('Main Category') }}</a>
                                    </li>
                                @endcan

                                @can('Manage Shopify Product')
                                    <li
                                        class="dash-item {{ in_array(Request::segment(1), ['shopify_product']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.shopify_product.index') }}">{{ __('Product') }}</a>
                                    </li>
                                @endcan

                                @can('Manage Shopify Customer')
                                    <li
                                        class="dash-item {{ in_array(Request::segment(1), ['shopify_customer']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.shopify_customer.index') }}">{{ __('Customer') }}</a>
                                    </li>
                                @endcan

                                @can('Manage Shopify Coupon')
                                    <li
                                        class="dash-item {{ in_array(Request::segment(1), ['shopify_coupon']) ? ' active' : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('admin.shopify_coupon.index') }}">{{ __('Coupon') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                @endif
            {{-- shopify related section --}}

            @if (\Auth::user()->can('Manage Support Ticket'))
                <li class="dash-item {{ Request::segment(1) == 'support_ticket' ? ' active' : '' }}">
                    <a href="{{ route('admin.support_ticket.index') }}"
                        class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                        <span class="dash-micon">
                            <i class="ti ti-ticket"></i>
                        </span>
                        <span class="dash-mtext">{{ __('Support Ticket') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::user()->can('Manage Pos'))
                <li class="dash-item {{ Request::segment(2) == 'pos' ? ' active' : '' }}">
                    <a href="{{ route('admin.pos.index') }}"
                        class="dash-link {{ request()->is('themes') ? 'active' : '' }}">
                        <span class="dash-micon">
                            <i class="ti ti-layers-difference"></i>
                        </span>
                        <span class="dash-mtext">{{ __('POS') }}</span>
                    </a>
                </li>
            @endif


            {{-- CMS --}}
            @if (
                \Auth::user()->can('Manage Faqs') ||
                    \Auth::user()->can('Manage Contact Us') ||
                    \Auth::user()->can('Manage Custom Page') ||
                    \Auth::user()->can('Manage Blog'))
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-layout-cards"></i>
                        </span><span class="dash-mtext">{{ __('CMS') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>

                    <ul
                        class="dash-submenu {{ Request::segment(1) == 'main-category' || Request::segment(1) == 'sub-category' ? 'show' : '' }}">
                        @can('Manage Custom Page')
                            <li class="dash-item {{ in_array(Request::segment(1), ['pages']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.pages.index') }}">{{ __('Custom Pages') }}</a>
                            </li>
                        @endcan

                        @can('Manage Contact Us')
                            <li class="dash-item {{ in_array(Request::segment(1), ['blogs']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.blogs.index') }}">{{ __('Blogs') }}</a>
                            </li>
                        @endcan

                        @can('Manage Faqs')
                            <li class="dash-item {{ in_array(Request::segment(1), ['faqs']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.faqs.index') }}">{{ __('FAQs') }}</a>
                            </li>
                        @endcan

                        @can('Manage Contact Us')
                            <li class="dash-item {{ in_array(Request::segment(1), ['contacts']) ? ' active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('admin.contacts.index') }}">{{ __('Contact Us') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif


            @if (\Auth::user()->can('Manage Super Dashboard'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['dashboard']) ? ' active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span>
                        <span class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::user()->can('Manage Store'))
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['stores']) ? ' active' : '' }}">
                    <a href="{{ route('admin.stores.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user"></i></span>
                        <span class="dash-mtext">{{ __('Users') }}</span>
                    </a>
                </li>
            @endif


            @if (\Auth::user()->can('Manage Coupon'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan-coupon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan-coupon.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-gift"></i></span>
                        <span class="dash-mtext">{{ __('Coupons') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::user()->can('Manage Plan'))
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                        <span class="dash-mtext">{{ __('Plan') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::user()->can('Manage Plan Request'))
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan-request']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan-request.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-arrow-up-right-circle"></i></span>
                        <span class="dash-mtext">{{ __('Plan Requests') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                <li
                    class="dash-item dash-hasmenu {{ in_array(Request::segment(2), ['email_template_lang']) ? ' active' : '' }}">
                    <a href="{{ route('admin.manage.email.language', \Auth::user()->lang) }}"
                        class="dash-link {{ request()->is('email_template') ? 'active' : '' }}">
                        <span class="dash-micon">
                            <i class="ti ti-mail"></i>
                        </span>
                        <span class="dash-mtext">{{ __('Email Templates') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                @include('landingpage::menu.landingpage')
            @endif

            @if (\Auth::user()->can('Manage Settings'))
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['setting']) ? ' active' : '' }}">
                    <a href="{{ route('admin.setting.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-settings"></i></span>
                        <span class="dash-mtext">{{ __('Settings') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['addon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.addon.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Add-on Theme') }}</span>
                    </a>
                </li>
            @endif

            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['addon']) ? ' active' : '' }}">
                    <a href="{{ route('admin.addon.apps') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Add-on Apps') }}</span>
                    </a>
                </li>
            @endif




        </ul>

    </div>
    @else
    <div class="navbar-content">
        <ul class="dash-navbar">
            @if (\Auth::user()->can('Manage Plan'))
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['plan']) ? ' active' : '' }}">
                    <a href="{{ route('admin.plan.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-trophy"></i></span>
                        <span class="dash-mtext">{{ __('Plan') }}</span>
                    </a>
                </li>
            @endif
        </ul>
        @endif
    </div>


</div>
</nav>
<!-- [ navigation menu ] end -->
