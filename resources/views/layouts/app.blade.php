
@php
    $theme_name = !empty(APP_THEME()) ? APP_THEME() : '';
    $profile = asset(Storage::url('uploads/logo/'));
    $favicon = \App\Models\Utility::GetValueByName('favicon',$theme_name);
    $favicon = get_file($favicon , APP_THEME());

    $settings = \App\Models\Setting::where('store_id',getCurrentStore())->where('theme_id', $theme_name)->pluck('value', 'name')->toArray();
    // $settings = App\Models\Setting::pluck('value','name')->toArray();

    $cust_darklayout = \App\Models\Utility::GetValueByName('cust_darklayout',$theme_name);
    $cust_theme_bg = \App\Models\Utility::GetValueByName('cust_theme_bg',$theme_name);
    $SITE_RTL = \App\Models\Utility::GetValueByName('SITE_RTL',$theme_name);

    $color = 'theme-3';
    if (!empty($settings['color'])) {
        $color = $settings['color'];
    }

    $lang = (!empty(Auth::guard('admin')->user())) ? Auth::guard('admin')->user()->lang : 'en';
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }

    $superadmin = \App\Models\Admin::where('type','superadmin')->first();
    $superadmin_setting = \App\Models\Setting::where('store_id',$superadmin->current_store)->where('theme_id', $superadmin->theme_id)->pluck('value', 'name')->toArray();

    $settings_data = \App\Models\Utility::Seting();
@endphp

<!DOCTYPE html>
<html lang="en" dir="{{isset($SITE_RTL) && $SITE_RTL == 'on'? 'rtl' : '' }}">

<head>
    <title> {{ isset($settings['title_text']) ? $settings['title_text'] : $superadmin_setting['title_text'] }} - @yield('page-title') </title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <meta name="base-url" content="{{URL::to('/')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon icon -->
    <link rel="icon" href="{{(!empty($favicon))? $favicon.'?timestamp=' . time() : $profile.'/logo-sm.svg'.'?timestamp=' . time()}}" type="image/x-icon" />
    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <!-- datatable css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/style.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/material.css') }}">

    <link rel="stylesheet" href="{{ asset('public/assets/css/customizer.css') }}">

    @if ($cust_darklayout == 'on' && $SITE_RTL == 'on')
    <link rel="stylesheet" href="{{ asset('public/assets/css/style-dark.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @elseif($cust_darklayout == 'on')
    <link rel="stylesheet" href="{{ asset('public/assets/css/style-dark.css') }}" id="main-style-link">
    @elseif($SITE_RTL == 'on')
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}" id="main-style-link">
    @endif
    

    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}{{ "?v=".time() }}">


    <style>
        {!! isset($superadmin_setting['storecss']) ? $superadmin_setting['storecss'] :  $settings_data['storecss'] !!}
    </style>

</head>

<body class={{$color}}>
    @include('partision.sidebar')

    @include('partision.header')

    <!-- [ Main Content ] start -->
    <div class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-xl-5">
                            <div class="page-header-title">
                                <h4 class="m-b-10">@yield('page-title')</h4>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    @if(\Request::route()->getName() != 'admin.dashboard')
                                    <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                                    @endif
                                </li>
                                @yield('breadcrumb')
                            </ul>
                        </div>
                        <div class="col-xl-7">
                            @yield('action-button')
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->

    {{-- @include('partision.footer') --}}
        <div id="commanModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div id="commanModelOver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel"
        aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    
    @include('partision.settingPopup')
    @include('partision.footerlink')

    @stack('custom-script')
    @stack('custom-script1')

    @if ($message = Session::get('success'))
        <script>
            show_toastr('{{ __('Success') }}', '{!! $message !!}', 'success')
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            show_toastr('{{ __('Error') }}', '{!! $message !!}', 'error')
        </script>
    @endif

</body>

@if ($superadmin_setting['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif

</html>
