@php
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);

    $theme_favicon = \App\Models\Utility::GetValueByName('theme_favicon', $theme_name);
    $theme_favicon = get_file($theme_favicon , APP_THEME());

    $metakeyword = \App\Models\Utility::GetValueByName('metakeyword', $theme_name);
    $metadesc = \App\Models\Utility::GetValueByName('metadesc',$theme_name);
    $metaimage = \App\Models\Utility::GetValueByName('metaimage', $theme_name);
    $metaimage = get_file($metaimage , APP_THEME());

    $pixels = \App\Models\PixelFields::where('store_id',getCurrentStore())->where('theme_id', $theme_name)->get();
    $pixelScript = [];
    foreach ($pixels as $pixel)
        {
            $pixelScript[] = pixelSourceCode( $pixel['platform'], $pixel['pixel_id'] );
        }

    $superadmin = \App\Models\Admin::where('type','superadmin')->first();
    $superadmin_setting = \App\Models\Setting::where('store_id',$superadmin->current_store)->where('theme_id', $superadmin->theme_id)->pluck('value', 'name')->toArray();
    $google_analytic = \App\Models\Utility::GetValueByName('google_analytic', $theme_name);
    $storejs = \App\Models\Utility::GetValueByName('storejs', $theme_name);
    $fbpixel_code = \App\Models\Utility::GetValueByName('fbpixel_code', $theme_name);
    $store = \App\Models\Store::where('slug', $slug)->where('is_active', '1')->first();
    $whatsapp_contact_number =\App\Models\Utility::GetValueByName('whatsapp_contact_number',$theme_name);
    $storecss = \App\Models\Utility::GetValueByName('storecss', $theme_name);
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>
        {{ \App\Models\Utility::GetValueByName('theme_name', $theme_name) ? \App\Models\Utility::GetValueByName('theme_name', $theme_name) : 'logisticsboxes' }}
        - @yield('page-title')</title>
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">
    <meta name="keywords"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">

    {{-- <meta name="keywords" content="{{ $metakeyword }}"> --}}
        {!! metaKeywordSetting($metakeyword,$metadesc,$metaimage,$slug) !!}
    {{-- <meta name="description" content="{{ $metadesc }}"> --}}

    <link rel="shortcut icon"
        href="{{ isset($theme_favicon) && !empty($theme_favicon) ? $theme_favicon : 'themes/' . APP_THEME() . '/assets/images/Favicon.png' }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/floating-wpp.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/customizer.css') }}">

    @if($currantLang == 'ar' || $currantLang == 'he')
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/rtl-main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/rtl-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rtl-custom.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @endif

    <style>
        {!! $storecss !!}
    </style>
    <style>
        .notifier {
            padding: calc(25px - 5px) calc(25px - 5px);
            border-radius: 10px;
        }

        .notifier-title {
            margin: 0 0 4px;
            padding: 0;
            font-size: 18px;
            font-weight: 400;
            color: #000;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .notifier .notifier-body {
            font-size: 0.875rem;
        }
    </style>
{{-- pwa customer app --}}
    <meta name="mobile-wep-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon" href="{{ isset($theme_favicon) && !empty($theme_favicon) ? $theme_favicon : 'themes/' . APP_THEME() . '/assets/images/Favicon.png' }}">

    @if ($store->enable_pwa_store == 'on')
        <link rel="manifest" href="{{ asset('storage/uploads/customer_app/store_' . $store->id . '/manifest.json') }}" />
    @endif
    @if (!empty($store->pwa_store($store->slug)->theme_color))
        <meta name="theme-color" content="{{ $store->pwa_store($store->slug)->theme_color }}" />
    @endif
    @if (!empty($store->pwa_store($store->slug)->background_color))
        <meta name="apple-mobile-web-app-status-bar"
            content="{{ $store->pwa_store($store->slug)->background_color }}" />
    @endif
</head>

<body
    @if (in_array(\Request::route()->getName(), ['landing_page',$slug])) class="home-page"  @elseif (in_array(\Request::route()->getName(), ['page.product',$slug]))class="product-page" @else @endif>

    @include('partials.header')

    <!-- [ Main Content ] start -->
    <div class="wrapper">
        <div class="pct-customizer">
            <div class="pct-c-btn">
                <button class="btn btn-primary" id="pct-toggler" data-toggle="tooltip"
                    data-bs-original-title="Order Track" aria-label="Order Track">
                    <i class='fas fa-shipping-fast' style='font-size:24px;'></i>
                </button>
            </div>
            <div class="pct-c-content">
                <div class="pct-header bg-primary">
                    <h5 class="mb-0 text-white f-w-500">{{ 'Order Tracking' }}</h5>
                </div>
                <div class="pct-body">
                    {{ Form::open(['route' => ['order.track', $slug], 'method' => 'POST', 'id' => 'choice_form', 'enctype' => 'multipart/form-data']) }}
                    <div class="form-group col-md-12">
                        {!! Form::label('order_number', __('Order Number'), ['class' => 'form-label']) !!}
                        {!! Form::text('order_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Order Id']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('email', __('Email Address'), ['class' => 'form-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                    </div>
                    <button type="submit" class="btn justify-contrnt-end">{{ __('Submit') }}</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        {{-- @foreach ($pixelScript as $script)
                <?= $script; ?>
            @endforeach --}}
            @yield('content')
    </div>
    <!-- [ Main Content ] end -->
    <div class="modal modal-popup" id="commanModel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-inner lg-dialog" role="document">
            <div class="modal-content support-modal">
                <div class="popup-content">
                    <div class="modal-header  popup-header align-items-center">
                        <div class="modal-title">
                            <h6 class="mb-0" id="modelCommanModelLabel"></h6>
                        </div>
                        <button type="button" class="close close-button" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.footer')

    <!--scripts start here-->
    <script src="{{ asset('themes/' . APP_THEME() . '/assets/js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('themes/' . APP_THEME() . '/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('themes/' . APP_THEME() . '/assets/js/slick.min.js') }}" defer="defer"></script>
    <script src="{{ asset('themes/' . APP_THEME() . '/assets/js/slick-lightbox.js') }}" defer="defer"></script>
    <script src='{{ asset('themes/' . APP_THEME() . '/assets/js/custom.js') }}' defer="defer"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('public/assets/js/plugins/notifier.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/floating-wpp.min.js') }}"></script>
    <script src='{{ asset('js/custom.js') }}' defer="defer"></script>
    <script src="{{ asset('public/assets/js/plugins/feather.min.js') }}"></script>
    <!--scripts end here-->
    @stack('page-script')
    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }
    </script>

    <script type="text/javascript">
         $(function () {
            $('.floating-wpp').floatingWhatsApp({
                phone: '{{ $whatsapp_contact_number }}',
                popupMessage: 'how may i help you?',
                showPopup: true,
                message: 'Message To Send',
                headerTitle: 'Ask Questions'
            });
        });

        var site_url = $('meta[name="base-url"]').attr('content');

        $(document).ready(function() {
            range_slide();
        });
        $(document).ready(function() {
            range_slide();
            get_cartlist();
        });

        function range_slide() {
            // Range slider - gravity forms
            if ($('.slider-range').length > 0) {
                $('.slider-range').each(function(index, element) {
                    var object_id = $(this).attr('id');
                    if (typeof object_id === "undefined") {
                        var object_id = 'slider-range';
                    }
                    var object_id = '#' + object_id;

                    var min_price = $(this).attr('min_price');
                    if (typeof min_price === "undefined") {
                        var min_price = 0;
                    }

                    var max_price = $(this).attr('max_price');
                    if (typeof max_price === "undefined") {
                        var max_price = 5000;
                    }

                    var step = $(this).attr('price_step');
                    if (typeof step === "undefined") {
                        var step = 1;
                    }

                    var currency = $(this).attr('currency');
                    if (typeof currency === "undefined") {
                        var currency = '$';
                    }

                    $(object_id).slider({
                        range: true,
                        min: parseInt(min_price),
                        max: parseInt(max_price),
                        step: parseInt(step),
                        values: [parseInt(min_price), parseInt(max_price)],
                        slide: function(event, ui) {
                            $(this).parent().parent().find('.min_price_select').attr('price', ui.values[
                                0]).html(currency + '' + ui.values[0]);
                            $(this).parent().parent().find('.max_price_select').attr('price', ui.values[
                                1]).html(currency + '' + ui.values[1]);
                            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                        }
                    });

                });
            }
        }

        $(document).ready(function() {
            $(document).on('click', '.wishbtn-globaly', function(e) {
                var product_id = $(this).attr('product_id');
                var wishlist_type = $(this).attr('in_wishlist');
                var isAuthenticated = {{ \Auth::check() ? 'true' : 'false' }};
                // var wishlist_type = $('.wishlist_type').val();

                if (!isAuthenticated) {
                    var loginUrl = "{{ route('login', $slug) }}";
                    var message = "Please login to continue";
                    window.location.href = loginUrl;
                } else {
                    var data = {
                        product_id: product_id,
                        wishlist_type: wishlist_type,
                    }
                    $.ajax({
                        url: '{{ route('product.wishlist', $slug) }}',
                        method: 'POST',
                        data: data,
                        context: this,
                        success: function(response) {
                            // console.log(response.status);
                            if (response.status == 0) {
                                show_toastr('Error', response.data.message, 'error');
                            } else {
                                $(this).find('i').hasClass('ti ti-heart') ? $(this).find('i')
                                    .removeClass('ti ti-heart') : $(this).find('i').addClass(
                                        'ti ti-heart');
                                $(this).find('i').hasClass('fa fa-heart') ? $(this).find('i')
                                    .removeClass('fa fa-heart') : $(this).find('i').addClass(
                                        'fa fa-heart');
                                if (wishlist_type == 'add') {
                                    $(this).attr('in_wishlist', 'remove');
                                }
                                if (wishlist_type == 'remove') {
                                    $(this).attr('in_wishlist', 'add');
                                }

                                show_toastr('Success', response.data.message, 'success');
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.cart-header', function(e) {
            get_cartlist();
        });

        function get_cartlist() {
            var data = {};
            $.ajax({
                url: '{{ route('cart.list.sidebar',$slug) }}',
                method: 'POST',
                data: data,
                context: this,

                success: function(response) {
                    if (response.status == 0) {
                        $('.cart-header').css("pointer-events", "auto");
                        $('.cart-header .count').html(0);
                        $('.cartDrawer .closecart').click();
                    }
                    if (response.status == 1) {
                        $('.cart-header .count').html(response.cart_total_product);
                        $('.cartajaxDrawer').html(response.html);
                        $('.cart-page-section').html(response.checkout_html);
                        $('.checkout_page_cart').html(response.checkout_html_2);
                        $('.checkout_products').html(response.checkout_html_products);
                        $('.checkout_amount').html(response.checkout_amounts);
                        $('#sub_total_checkout_page').attr('value', response.sub_total);
                        $('#sub_total_main_page').html(response.sub_total);
                    }
                }
            });
        }


        $(document).on('click', '.remove_item_from_cart', function(e) {
            var cart_id = $(this).attr('data-id');
            var data = {
                cart_id: cart_id
            }
            $.ajax({
                url: '{{ route('cart.remove',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    get_cartlist();
                }
            });
        });

        $(document).on('click', '.closewish', function(e) {
           location.reload ();

        });

        $(document).on('click', '.addcart-btn-globaly', function(e) {
            var product_id = $(this).attr('product_id');
            var variant_id = $(this).attr('variant_id');
            var qty = $(this).attr('qty');
            var data = {
                product_id: product_id,
                variant_id: variant_id,
                qty: qty,
            };
            $.ajax({
                url: '{{ route('product.cart',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    $('.cart-header .count').html(response.data.count);
                    if (response.status == 0) {
                        show_toastr('Error', response.data.message, 'error');
                    } else {
                        show_toastr('Success', response.data.message, 'success');
                    }
                    get_cartlist();
                }
            });
        });


        $(document).on('click', '.change-cart-globaly', function(e) {
            var cart_id = $(this).attr('cart-id');
            var quantity_type = $(this).attr('quantity_type');

            var data = {
                cart_id: cart_id,
                quantity_type: quantity_type,
            };

            $.ajax({
                url: '{{ route('change.cart',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    if (response.status == 0) {
                        show_toastr('Error', response.data.message, 'error');
                    } else {
                        show_toastr('Success', response.data.message, 'success');
                    }

                    get_cartlist();
                }
            });
        });

        $(document).on('change', '.country_change', function(e) {
            var country_id = $(this).val();
            var data = {
                country_id: country_id
            }
            $.ajax({
                url: '{{ route('states.list',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    $(this).closest('.row').find('.state_chage').html('').show();
                    $(this).closest('.row').find('.nice-select.state_chage').remove();
                    var state = $(this).closest('.row').find('.state_chage').attr('data-select');

                    var option = '';
                    $.each(response, function(i, item) {
                        var checked = '';
                        if (i == state) {
                            var checked = 'checked';
                        }
                        option += '<option value="' + i + '" ' + checked + '>' + item +
                            '</option>';
                    });
                    $(this).closest('.row').find('.state_chage').html(option);
                    $(this).closest('.row').find('.state_chage').val(state);

                    if (state != 0) {
                        $(this).closest('.row').find('.state_chage').trigger('change');
                    }
                    getBillingdetail();
                    $('select').niceSelect();
                }
            });
        });

        $(document).on('change', '.state_chage', function(e) {
            var state_id = $(this).val();
            var data = {
                state_id: state_id
            }
            $.ajax({
                url: '{{ route('city.list',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    $(this).closest('.row').find('.city_change').html('').show();
                    $(this).closest('.row').find('.nice-select.city_change').remove();
                    var city = $(this).closest('.row').find('.city_change').attr('data-select');


                    var option = '';
                    $.each(response, function(i, item) {
                        var checked = '';
                        if (i == city) {
                            var checked = 'checked';
                        }
                        option += '<option value="' + i + '" ' + checked + '>' + item +
                            '</option>';
                    });

                    $(this).closest('.row').find('.city_change').html(option);
                    $(this).closest('.row').find('.city_change').val(city);

                    if (city != 0) {
                        $(this).closest('.row').find('.city_change').trigger('change');
                    }
                    getBillingdetail();
                    $('select').niceSelect();

                }
            });
        });

        $(document).on('change', '.state_chage', function(e) {
            getBillingdetail();
        });



        function getBillingdetail() {
            $('.delivery_address').html($('input[name="billing_info[delivery_address]"]').val());
            $('.delivery_country').html($('select[name="billing_info[delivery_country]"] option:selected').text());
            $('.delivery_state').html($('select[name="billing_info[delivery_state]"] option:selected').text());
            $('.delivery_city').html($('select[name="billing_info[delivery_city]"] option:selected').text());
            $('.delivery_postcode').html($('input[name="billing_info[delivery_postcode]"]').val());
            var guest = '{{ Auth::guest() }}';
            if (guest == 1) {
                $('.billing_address').html($('input[name="billing_info[billing_address]"]').val());
                $('.billing_country').html($('select[name="billing_info[billing_country]"] option:selected').text());
                $('.billing_state').html($('select[name="billing_info[billing_state]"] option:selected').text());
                $('.billing_city').html($('select[name="billing_info[billing_city]"] option:selected').text());
                $('.billing_postecode').html($('input[name="billing_info[billing_postecode]"]').val());
            } else {
                $('.billing_address').html($('input[name="billing_info[billing_address]"]').val());
                $('.billing_country').html($('input[name="billing_info[billing_country_name]"]').val());
                $('.billing_state').html($('input[name="billing_info[billing_state_name]"]').val());
                $('.billing_city').html($('input[name="billing_info[billing_city_name]"]').val());
                $('.billing_postecode').html($('input[name="billing_info[billing_postecode]"]').val());
            }
        }
    </script>
    <script>
        $(document).on('click', '.wish-header', function(e) {
            get_wishlist();
        });

        function get_wishlist() {
            var data = {};
            $.ajax({
                url: '{{ route('wish.list.sidebar',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
                    if (response.status == 0) {

                        // show_toster('error', response.message);
                        $('.wish-header').css("pointer-events", "auto");
                        $('.wish-header .count').html(0);
                        $('.wishDrawer .closewish').click();
                    }
                    if (response.status == 1) {
                        $('.wish-header .count').html(response.wish_total_product);
                        $('.wishajaxDrawer').html(response.html);

                        $('.wish-page-section').html(response.checkout_html);
                        $('.checkout_page_wish').html(response.checkout_html_2);
                        $('.checkout_products').html(response.checkout_html_products);
                        $('.checkout_amount').html(response.checkout_amounts);
                        $('#sub_total_checkout_page').attr('value', response.sub_total);

                    }
                }
            });
        }
    </script>
    <script>
        $(document).on('click', '.delete_wishlist', function() {
            var id = $(this).attr('data-id');
            var url = '{{ route('delete.wishlist',$slug) }}?id=' + id;
            $.ajax({
                url: url,
                method: 'GET',
                context: this,
                success: function(response) {

                    get_wishlist();

                }
            });
        });
    </script>
    {{-- google analytic --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $google_analytic }}"></script>
    <script>
        {!! $storejs !!}
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{ $google_analytic }}');
    </script>

    {{-- facebook pixel code --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $fbpixel_code }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript={{ $fbpixel_code }}" /></noscript>

    @if ($message = Session::get('success'))
        <script>
            notifier.show('Success', '{!! $message !!}', 'success', site_url +
                '/public/assets/images/notification/ok-48.png', 4000);
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            notifier.show('Error', '{!! $message !!}', 'danger', site_url +
                '/public/assets/images/notification/high_priority-48.png', 4000);
        </script>
    @endif

    <script>
        function show_toster(status = '', message = '') {
            if (status == 'Success' || status == 'success') {
                notifier.show('Success', message, 'success', site_url +
                    '/public/assets/images/notification/ok-48.png', 4000);
            }
            if (status == 'Error' || status == 'error') {
                notifier.show('Error', message, 'danger', site_url +
                    '/public/assets/images/notification/high_priority-48.png', 4000);
            }
        }
    </script>

@if ($store->enable_pwa_store == 'on')
        <script type="text/javascript">
            const container = document.querySelector("body")

            const coffees = [];

            if ("serviceWorker" in navigator) {
                window.addEventListener("load", function() {
                    navigator.serviceWorker
                        .register("{{ asset('serviceWorker.js') }}")
                        .then(res => console.log(""))
                        .catch(err => console.log("service worker not registered", err))

                })
            }
        </script>
    @endif

</body>
{{-- @if ($superadmin_setting['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif --}}
</html>
