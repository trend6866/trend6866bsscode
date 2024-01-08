@php
    $theme_json = $homepage_json;

    $theme_favicon = \App\Models\Utility::GetValueByName('theme_favicon', $theme_name);
    $theme_favicons = get_file($theme_favicon, APP_THEME());
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());
    $languages = \App\Models\Utility::languages();
    $currantLang = Cookie::get('LANGUAGE');
    // dd($currantLang);
    if (!isset($currantLang)) {
        $currantLang = $store->default_language;
    }
@endphp

<!DOCTYPE html>
<html lang="en" dir="{{ isset($SITE_RTL) && $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <title>{{ __('User Order') }} -
        {{ \App\Models\Utility::GetValueByName('theme_name', $theme_name) ? \App\Models\Utility::GetValueByName('theme_name', $theme_name) : 'Foodmart' }}
    </title> <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author"
        content="Style - The Impressive Fashion Shopify Theme complies with contemporary standards. Meet The Most Impressive Fashion Style Theme Ever. Well Toasted, and Well Tested.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="shortcut icon"
        href="{{ isset($theme_favicon) && !empty($theme_favicon) ? $theme_favicons : 'themes/' . APP_THEME() . '/assets/images/Favicon.png' }}">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <script src="{{ asset('public/assets/js/plugins/bootstrap.min.js') }}"></script>

    @if ($currantLang == 'ar' || $currantLang == 'he')
        <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/rtl-main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/rtl-responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/rtl-custom.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/' . APP_THEME() . '/assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @endif

    <!-- datatable css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/flatpickr.min.css') }}">


    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/floating-wpp.min.css') }}">




    <!-- vendor css -->

    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}{{ '?v=' . time() }}">


</head>

<body>
    <header class=" order-detail site-header header-style-one">

        <div class="main-navigationbar">
            <div class="container">
                <div class="navigationbar-row d-flex align-items-center">
                    <div class="logo-col">
                        <h1>
                            <a href="#">
                                <img h="2px" style =" margin-bottom: 30px; margin-top: 30px;" class ="logo-detail "src="{{ isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . APP_THEME() . '/assets/images/logo.png' }}"
                                    alt="Nav brand">
                            </a>
                        </h1>
                    </div>
                    <span class="store-info-block ms-2">{{ $store->name }}</span>

                    <div class="menu-items-col justify-content-end">

                        <ul class="menu-right d-flex  justify-content-end">
                            <li class="menu-lnk has-item lang-dropdown">
                                <a href="#">

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

                    </div>
                </div>
            </div>
        </div>



    </header>
    <div class="wrapper" style="margin-top: 132.361px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <div class="common-banner-content">
                        <div class="row">
                            <div class="col-xl-5">
                                <div class="section-title">
                                    <h2>{{ __('Your Order Details') }}</h2>
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div
                                    class=" d-flex all-button-box justify-content-md-end justify-content-end text-end">

                                    <button type="submit" onclick="saveAsPDF();" title="Print" aria-label="Print"
                                        class="btn continue-btn  ">
                                        <i class="ti ti-printer" style="font-size:20px"> </i>
                                        <span class="btn-inner--text">{{ __('Print') }}</span>

                                    </button>
                                    <button
                                        class="btn  continue-btn "style="margin-left: 5px">{{ $order['order_status_text'] }}</button>
                                        @if($order['payment_status'] == 'Unpaid' && $order['order_status_text'] != 'Cancel'&& $order_data['delivered_status'] == 0 )
                                        <a class="delstatus btn btn  continue-btn " style="margin-left: 5px" data-id ="{{$order['id']}}"
                                        >
                                            <i class="ti ti-trash " style="font-size:20px"></i>
                                            <span class="btn-inner--text ">{{__('Order Cencel')}}</span>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <section class="product-listing-section padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row order-details-modal" id="printableArea">
                            <div class="col-xxl-7">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <p class="mb-0"><b>{{ _('Items from Order') }} {{ $order['order_id'] }}</b>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Item') }}</th>
                                                        <th>{{ __('Quantity') }}</th>
                                                        <th>{{ __('Total') }}</th>
                                                        @if ($order['order_status'] == 1 && $order['is_guest'] == 0)
                                                            <th>{{ __('Return') }}</th>
                                                        @endif
                                                        @if ($order['order_status'] == 1)
                                                            <th>{{ __('Downloadable Product') }}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order['product'] as $item)
                                                        @php
                                                            $download_prod = \App\Models\ProductStock::where('id', $item['variant_id'])->first();
                                                            $download_product = \App\Models\Product::where('id', $item['product_id'])->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="total">
                                                                <span class="p text-sm"> {{ $item['name'] }}</span>
                                                                <br>
                                                                <span class="text-sm"> {{ $item['variant_name'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($order['paymnet_type'] == 'POS')
                                                                    {{ $item['quantity'] }}
                                                                @else
                                                                    {{ $item['qty'] }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($order['paymnet_type'] == 'POS')
                                                                    {{ SetNumberFormat($item['orignal_price']) }}
                                                                @else
                                                                    {{ SetNumberFormat($item['final_price']) }}
                                                                @endif
                                                            </td>
                                                            @if ($order['order_status'] == 1 && $order['is_guest'] == 0)
                                                                <td> - </td>
                                                            @endif
                                                            @if ($order['order_status_text'] == 'Delivered')
                                                                @if (!empty($download_prod->downloadable_product) || !empty($download_product->downloadable_product))
                                                                    <td>
                                                                        <div class="detail-bottom">
                                                                            @if (!empty($download_product->downloadable_product))
                                                                                <a class="download_prod_{{ $item['product_id'] }}"
                                                                                    href="{{ get_file($download_product->downloadable_product) }} "
                                                                                    download></a>
                                                                            @endif
                                                                            @if (!empty($download_prod->downloadable_product))
                                                                                <a class="download_prod_{{ $item['product_id'] }}"
                                                                                    href="{{ get_file($download_prod->downloadable_product) }}"
                                                                                    download></a>
                                                                            @endif
                                                                            <button data-id="{{ $order['id'] }}"
                                                                                class="btn cart-btn downloadable_prodcut_variant_{{ $item['product_id'] }}">{{ __('Download') }}
                                                                                <i class="fas fa-shopping-basket"></i>
                                                                            </button>

                                                                        </div>
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-lg-6 ">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <b class="">{{ __('Shipping Information') }}</b>
                                            </div>
                                            <div class="card-body pt-0">
                                                <address class="mb-0 text-sm">
                                                    <ul class="row mt-4 align-items-center">
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Name') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['name']) ? $order['delivery_informations']['name'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Email') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['email']) ? $order['delivery_informations']['email'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('City') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['city']) ? $order['delivery_informations']['city'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('State') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['state']) ? $order['delivery_informations']['state'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Country') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['country']) ? $order['delivery_informations']['country'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Postal Code') }}</b>
                                                        </li>
                                                        <li class="col-sm-7 text-sm">
                                                            {{ !empty($order['delivery_informations']['post_code']) ? $order['delivery_informations']['post_code'] : '' }}
                                                        </li>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Phone') }} </b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            <a href="https://api.whatsapp.com/send?phone={{ !empty($order['delivery_informations']['phone']) ? $order['delivery_informations']['phone'] : '' }}&amp;text=Hi"
                                                                target="_blank">
                                                                {{ !empty($order['delivery_informations']['phone']) ? $order['delivery_informations']['phone'] : '' }}
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-lg-6 ">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <b class="">{{ __('Billing Information') }}</b>
                                            </div>
                                            <div class="card-body pt-0">
                                                <address class="mb-0 text-sm">
                                                    <ul class="row mt-4 align-items-center">
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Name') }}</b></li>
                                                        <dd class="col-sm-7 text-sm pb-2">
                                                            {{ !empty($order['billing_informations']['name']) ? $order['billing_informations']['name'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Email') }}</b></li>
                                                        <dd class="col-sm-7 text-sm">
                                                            {{ !empty($order['billing_informations']['email']) ? $order['billing_informations']['email'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('City') }}</b></li>
                                                        <dd class="col-sm-7 text-sm">
                                                            {{ !empty($order['billing_informations']['city']) ? $order['billing_informations']['city'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('State') }}</b></li>
                                                        <dd class="col-sm-7 text-sm">
                                                            {{ !empty($order['billing_informations']['state']) ? $order['billing_informations']['state'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Country') }}</b></li>
                                                        <dd class="col-sm-7 text-sm">
                                                            {{ !empty($order['billing_informations']['country']) ? $order['billing_informations']['country'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Postal Code') }}</b>
                                                        </li>
                                                        <dd class="col-sm-7 text-sm">
                                                            {{ !empty($order['billing_informations']['post_code']) ? $order['billing_informations']['post_code'] : '' }}
                                                        </dd>
                                                        <li class="col-sm-5 text-sm"><b>{{ __('Phone') }}</b></li>
                                                        <li class="col-sm-7 text-sm">
                                                            <a href="https://api.whatsapp.com/send?phone={{ !empty($order['billing_informations']['phone']) ? $order['billing_informations']['phone'] : '' }}&amp;text=Hi"
                                                                target="_blank">
                                                                {{ !empty($order['billing_informations']['phone']) ? $order['billing_informations']['phone'] : '' }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-md-6 col-12">
                                <div class="card  p-0">
                                    <div class="card-header d-flex justify-content-between pb-0">
                                        <b class="mb-4">{{ __('Extra Information') }}</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>{{ __('Sub Total') }} :</td>
                                                        <td>{{ SetNumberFormat($order['sub_total']) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Estimated Tax') }} :</td>
                                                        <td>
                                                            @if ($order['paymnet_type'] == 'POS')
                                                                {{ SetNumberFormat($order['tax_price']) }}
                                                            @else
                                                                {{ SetNumberFormat(array_sum(array_column($order['tax'], 'amountstring'))) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if ($order['paymnet_type'] == 'POS')
                                                        <tr>
                                                            <td>{{ __('Discount') }} :</td>
                                                            <td>{{ !empty($order['coupon_price']) ? SetNumberFormat($order['coupon_price']) : SetNumberFormat(0) }}
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ __('Apply Coupon') }} :</td>
                                                            <td>{{ !empty($order['coupon_info']['discount_amount']) ? SetNumberFormat($order['coupon_info']['discount_amount']) : SetNumberFormat(0) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>{{ __('Delivered Charges') }} :</td>
                                                        <td>{{ SetNumberFormat($order['delivered_charge']) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Grand Total') }} :</td>
                                                        <td><b>{{ SetNumberFormat($order['final_price']) }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Payment Type') }} :</td>
                                                        <td> {{ $order['paymnet_type'] }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Order Status') }} :</td>
                                                        <td>{{ $order['order_status_text'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="social-media">
            <div class="container">
                @php
                $homepage_footer_key7 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_footer_key7 != '') {
                    $homepage_footer_section7 = $theme_json[$homepage_footer_key7];
                }
            @endphp
            <ul class="social-icons social-links justify-content-end">
                @for ($i = 0; $i < $homepage_footer_section7['loop_number']; $i++)
                    @php
                        foreach ($homepage_footer_section7['inner-list'] as $homepage_footer_section7_value) {
                            if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                $homepage_footer_section7_sub_title = $homepage_footer_section7_value['field_default_text'];
                            }
                            if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link') {
                                $homepage_footer_section7_social_link = $homepage_footer_section7_value['field_default_text'];
                            }

                            if (!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']])) {
                                if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                    $homepage_footer_section7_sub_title = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i]['field_prev_text'];
                                }
                                if ($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link') {
                                    $homepage_footer_section7_social_link = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                }
                            }
                        }
                    @endphp
                    @if ($homepage_footer_section7['section_enable'] == 'on')
                        <li class> <a href="{{ $homepage_footer_section7_social_link }}" target="_blank">
                                <img src="{{ get_file($homepage_footer_section7_sub_title, APP_THEME()) }}"
                                    alt="youtube">

                            </a>
                        </li>
                    @endif
                @endfor
            </ul>
            </div>

        </div>
    </div>

    <script src="{{ asset('public/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/dash.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/flatpickr.min.js') }}"></script>

    <script src="{{ asset('public/assets/js/plugins/simple-datatables.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/notifier.js') }}"></script>
    <script src="{{ asset('public/assets/js/pages/ac-notification.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/plugins/choices.min.js') }}{{ '?' . time() }}"></script>
    <script src="{{ asset('public/js/custom.js') }}{{ '?' . time() }}"></script>
    <script src="{{ asset('public/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/css/summernote/summernote-bs4.js') }}"></script>


    <script src="{{ asset('js/html2pdf.bundle.min.js') }}{{ '?' . time() }}"></script>
    <script>
        var filename = $('#filesname').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();

        }

        $(document).on('click', '.delstatus', function()
        {

            var order_id  = $(this).attr('data-id');
            var data = {
                        order_id :order_id,
                        order_status :'cancel',
                    }
            $.ajax
            ({
                url: '{{route('status.cancel',$store->slug)}}',
                data: data,
                type: 'post',
                success: function(data)
                {
                    if(data.status == 'error') {
                                show_toastr('{{ __('Error') }}', data.message, 'error')
                            } else {
                                show_toastr('{{ __('Success') }}', data.message, 'success')
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }
                }
            });
        });
        const numbers = {!! json_encode($order['product']) !!};;
        numbers.forEach(myFunction)

        function myFunction(item, index, arr) {
            const fileLinks = document.querySelectorAll('.download_prod_' + item.product_id);
            const downloadButton = document.querySelector('.downloadable_prodcut_variant_' + item.product_id);
            downloadButton.addEventListener('click', function() {
                fileLinks.forEach(link => {
                    link.click();
                });
            });
        }
    </script>

    <body>

</html>
