@php
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo',$theme_name);
    $theme_logo = get_file($theme_logo ,APP_THEME());

    $theme_favicon = \App\Models\Utility::GetValueByName('theme_favicon',$theme_name);
    $theme_favicon = get_file($theme_favicon , APP_THEME());

    $metakeyword = \App\Models\Utility::GetValueByName('metakeyword',$theme_name);
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
    $google_analytic = \App\Models\Utility::GetValueByName('google_analytic',$theme_name);
    $storejs = \App\Models\Utility::GetValueByName('storejs',$theme_name);
    $fbpixel_code = \App\Models\Utility::GetValueByName('fbpixel_code',$theme_name);
    $store = \App\Models\Store::where('slug', $slug)->where('is_active', '1')->first();
    $title = \App\Models\Utility::GetValueByName('theme_name',$theme_name) ? \App\Models\Utility::GetValueByName('theme_name',$theme_name) : 'Style';
    $whatsapp_contact_number =\App\Models\Utility::GetValueByName('whatsapp_contact_number',$theme_name);
@endphp



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>@yield('page-title') - {{ $title }} </title>
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">
    <meta name="keywords"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">

    {{-- <meta name="keywords" content="{{ $metakeyword }}"> --}}
        {!! metaKeywordSetting($metakeyword,$metadesc,$metaimage,$slug) !!}
    {{-- <meta name="description" content="{{ $metadesc }}"> --}}

    <link rel="shortcut icon" href="{{isset($theme_favicon) && !empty($theme_favicon) ? $theme_favicon : 'themes/'.APP_THEME().'/assets/images/Favicon.png'}}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/floating-wpp.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
    <style>
        nav ul li .active {
            background: #00EAB2 !important;
            color: #151414;
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
<body @if (in_array(\Request::route()->getName(), [$slug,'my-account.index'])) class="myaccont-no-scroll" @else @endif>
    @php
        $route_name = \Request::route()->getName();
    @endphp
    <svg style="display: none;">
        <symbol viewBox="0 0 6 5" id="slickarrow">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.89017 2.75254C6.03661 2.61307 6.03661 2.38693 5.89017 2.24746L3.64017 0.104605C3.49372 -0.0348681 3.25628 -0.0348681 3.10984 0.104605C2.96339 0.244078 2.96339 0.470208 3.10984 0.609681L5.09467 2.5L3.10984 4.39032C2.96339 4.52979 2.96339 4.75592 3.10984 4.8954C3.25628 5.03487 3.49372 5.03487 3.64016 4.8954L5.89017 2.75254ZM0.640165 4.8954L2.89017 2.75254C3.03661 2.61307 3.03661 2.38693 2.89017 2.24746L0.640165 0.104605C0.493719 -0.0348682 0.256282 -0.0348682 0.109835 0.104605C-0.0366115 0.244078 -0.0366115 0.470208 0.109835 0.609681L2.09467 2.5L0.109835 4.39032C-0.0366117 4.52979 -0.0366117 4.75592 0.109835 4.8954C0.256282 5.03487 0.493719 5.03487 0.640165 4.8954Z">
            </path>
        </symbol>
    </svg>


    @include('partials.header')

    <!-- [ Main Content ] start -->
    <div class="wrapper" style="margin-top: 128.188px;">
        {{-- @foreach ($pixelScript as $script)
                    <?= $script; ?>
                @endforeach --}}
                @yield('content')
    </div>
    <!-- [ Main Content ] end -->
    <div class="modal modal-popup" id="commanModel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-inner lg-dialog" role="document">
            <div class="modal-content">
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
    <script src="{{ asset('themes/'.APP_THEME().'/assets/js/script.js') }}" defer="defer"></script>
    <script src='{{ asset('themes/' . APP_THEME() . '/assets/js/custom.js') }}' defer="defer"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('public/assets/js/plugins/bootstrap.min.js') }}"></script>
     <script src="{{ asset('assets/js/floating-wpp.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/notifier.js') }}"></script>
    <script src='{{ asset('js/custom.js') }}' defer="defer"></script>
    <!--scripts end here-->
    @stack('page-script')

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

        $(document).on('click', '.wishbtn-globaly', function(e) {
            var product_id = $(this).attr('product_id');
            var wishlist_type = $(this).attr('in_wishlist');
            var data = {
                product_id: product_id,
                wishlist_type: wishlist_type,
            }

            $.ajax({
                url: '{{ route('product.wishlist',$slug) }}',
                method: 'POST',
                data: data,
                context: this,
                success: function(response) {
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


        $(document).on('load', '.cart_price', function(e) {
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
                }
            });
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
    {!! $storejs !!}
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
