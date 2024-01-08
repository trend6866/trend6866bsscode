@extends('layouts.app')

@section('page-title', __('Store Settings'))

@section('action-button')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Store Settings') }}</li>
@endsection

@php
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());

    $invoice_logo = \App\Models\Utility::GetValueByName('invoice_logo', $theme_name);
    $invoice_logo = get_file($invoice_logo, APP_THEME());

    $theme_favicon = \App\Models\Utility::GetValueByName('theme_favicon', $theme_name);
    $theme_favicon = get_file($theme_favicon, APP_THEME());

    $metaimage = \App\Models\Utility::GetValueByName('metaimage', $theme_name);
    $metaimage = get_file($metaimage, APP_THEME());

    $enable_storelink = \App\Models\Utility::GetValueByName('enable_storelink', $theme_name);
    $enable_domain = \App\Models\Utility::GetValueByName('enable_domain', $theme_name);
    $domains = \App\Models\Utility::GetValueByName('domains', $theme_name);
    $enable_subdomain = \App\Models\Utility::GetValueByName('enable_subdomain', $theme_name);
    $subdomain = \App\Models\Utility::GetValueByName('subdomain', $theme_name);
    $Additional_notes = \App\Models\Utility::GetValueByName('additional_notes', $theme_name);
    $is_checkout_login_required = \App\Models\Utility::GetValueByName('is_checkout_login_required', $theme_name);
@endphp

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card sticky-top " style="top:60px">
                <div class="list-group list-group-flush theme-set-tab" id="useradd-sidenav">
                    <ul class="nav nav-pills w-100 gap-3" id="pills-tab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <a href="#Theme_Setting"
                                class="nav-link active  list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
                                role="tab" aria-controls="pills-home" aria-selected="true">
                                {{ __('Store Settings') }}
                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#SEO_Setting"
                                class="nav-link   list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo" type="button"
                                role="tab" aria-controls="pills-seo" aria-selected="true">
                                {{ __('SEO Settings') }}
                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#custom_Setting"
                                class="nav-link   list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-custom-tab" data-bs-toggle="pill" data-bs-target="#pills-custom" type="button"
                                role="tab" aria-controls="pills-custom" aria-selected="true">
                                {{ __('Custom Settings') }}
                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#checkout_Setting"
                                class="nav-link   list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-checkout-tab" data-bs-toggle="pill" data-bs-target="#pills-checkout"
                                type="button" role="tab" aria-controls="pills-checkout" aria-selected="true">
                                {{ __('Checkout Settings') }}
                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#shippinglabel_Setting"
                                class="nav-link   list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-shipping-tab" data-bs-toggle="pill" data-bs-target="#pills-shipping"
                                type="button" role="tab" aria-controls="pills-shipping" aria-selected="true">
                                {{ __('Shipping Label Settings') }}
                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#Main_Page_Content_web"
                                class="nav-link  list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                                role="tab" aria-controls="pills-profile" aria-selected="false">
                                {{ __('Home Page Content') }}
                            </a>
                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#Order_Complete_Page_Content"
                                class="nav-link  list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"
                                role="tab" aria-controls="pills-contact" aria-selected="false">
                                {{ __('Order Complete Screen') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="tab-content store-tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div id="Theme_Setting">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                                <h5 class=""> {{ __('Store Settings') }} </h5>

                                {{-- @if ($plan->enable_chatgpt == 'on')
                                    <a href="#" class="btn btn-primary btn-sm float-end ai-btn" data-size="lg"
                                        data-ajax-popup-over="true" data-url="{{ route('admin.generate', ['meta']) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}"
                                        data-title="{{ __('Generate Content With AI') }}">
                                        <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
                                    </a>
                                @endif --}}

                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.theme.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                {{-- {{ Form::open(['route' => 'theme.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                                <div class="row mt-2">
                                    {{-- <div class="form-group col-md-7" id="StoreLink">
                                        {{ Form::label('store_link', __('Store Link'), ['class' => 'form-label']) }}
                                        <div class="input-group">
                                            <input type="text" value="{{ route('landing_page', $slug) }}" id="myInput"
                                                class="form-control d-inline-block" aria-label="Recipient's username"
                                                aria-describedby="button-addon2" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button" onclick="myFunction()"
                                                    id="button-addon2"><i class="far fa-copy"></i>
                                                    {{ __('Copy Link') }}</button>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="form-group col-md-6">
                                            {{ Form::label('theme_name', __('Store Name'), ['class' => 'form-label']) }}
                                            {!! Form::text('theme_name', null, ['class' => 'form-control', 'placeholder' => __('Store Name')]) !!}
                                            @error('theme_name')
                                                <span class="invalid-store_name" role="alert">
                                                    <strong class="text-danger">
                                                        {{ $message }}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Store Logo') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-3">
                                                        <a href="#" target="_blank">
                                                            <img src="{{ !empty($theme_logo) ? $theme_logo : $profile . '/logo.png' }}"
                                                                class="big-logo invoice_logo img_setting" id="storeLogo">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-4">
                                                        <label for="theme_logo">
                                                            <div class=" bg-primary logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="theme_logo" id="theme_logo"
                                                                data-filename="logo_update"
                                                                onchange="document.getElementById('storeLogo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('theme_logo')
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Invoice Logo') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-3">
                                                        <a href="#" target="_blank">
                                                            <img src="{{ !empty($invoice_logo) ? $invoice_logo : $profile . '/logo.png' }}"
                                                                class="big-logo invoice_logo img_setting"
                                                                id="invoiceLogo">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-4">
                                                        <label for="invoice_logo">
                                                            <div class=" bg-primary logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="invoice_logo" id="invoice_logo"
                                                                class="form-control file"
                                                                data-filename="invoice_logo_update"
                                                                onchange="document.getElementById('invoiceLogo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('invoice_logo')
                                                        <div class="row">
                                                            <span class="invalid-invoice_logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Store Favicon') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-3">
                                                        <a href="#" target="_blank">
                                                            <img src="{{ !empty($theme_favicon) ? $theme_favicon : $profile . '/logo.png' }}"
                                                                class="big-logo invoice_logo img_setting"
                                                                id="theme_favicon">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-4">
                                                        <label for="theme_favicon">
                                                            <div class=" bg-primary logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="theme_favicon" id="theme_favicon"
                                                                class="form-control file"
                                                                data-filename="theme_favicon_update"
                                                                onchange="document.getElementById('theme_favicon').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('theme_favicon')
                                                        <div class="row">
                                                            <span class="invalid-theme_favicon" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- @if ($plan->enable_domain == 'on' || $plan->enable_subdomain == 'on')
                                        <div class="col-md-6 py-4">
                                            <div class="radio-button-group row gy-2 mts">
                                                <div class="col-sm-4">
                                                    <label
                                                        class="btn btn-outline-primary w-100 {{ $enable_storelink == 'on' ? 'active' : '' }}">
                                                        <input type="radio" class="domain_click  radio-button"
                                                            name="enable_domain" value="enable_storelink"
                                                            id="enable_storelink"
                                                            {{ $enable_storelink == 'on' ? 'checked' : '' }}>
                                                        {{ __('Store Link') }}
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($plan->enable_domain == 'on')
                                                        <label
                                                            class="btn btn-outline-primary w-100 {{ $enable_domain == 'on' ? 'active' : '' }}">
                                                            <input type="radio" class="domain_click radio-button"
                                                                name="enable_domain" value="enable_domain"
                                                                id="enable_domain"
                                                                {{ $enable_domain == 'on' ? 'checked' : '' }}>
                                                            {{ __('Domain') }}
                                                        </label>
                                                    @endif
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($plan->enable_subdomain == 'on')
                                                        <label
                                                            class="btn btn-outline-primary w-100 {{ $enable_subdomain == 'on' ? 'active' : '' }}">
                                                            <input type="radio" class="domain_click radio-button"
                                                                name="enable_domain" value="enable_subdomain"
                                                                id="enable_subdomain"
                                                                {{ $enable_subdomain == 'on' ? 'checked' : '' }}>
                                                            {{ __('Sub Domain') }}
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($domainPointing == 1)
                                                <div class="text-sm mt-2" id="domainnote"
                                                    style="{{ $enable_domain == 'on' ? 'display: block' : '' }}">
                                                    <span><b class="text-success">{{ __('Note : Before add Custom Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|
                                                            {{ __('Your Custom Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @else
                                                <div class="text-sm mt-2" id="domainnote" style="display: none">
                                                    <span><b>{{ __('Note : Before add Custom Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|</b>
                                                        <b
                                                            class="text-danger">{{ __('Your Custom Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @endif
                                            @if ($subdomainPointing == 1)
                                                <div class="text-sm mt-2" id="subdomainnote" style="display: none">
                                                    <span><b class="text-success">{{ __('Note : Before add Sub Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|
                                                            {{ __('Your Sub Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @else
                                                <div class="text-sm mt-2" id="subdomainnote" style="display: none">
                                                    <span><b>{{ __('Note : Before add Sub Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|</b>
                                                        <b
                                                            class="text-danger">{{ __('Your Sub Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6" id="StoreLink"
                                            style="{{ $enable_storelink == 'on' ? 'display: block' : 'display: none' }}">
                                            {{ Form::label('store_link', __('Store Link'), ['class' => 'form-label']) }}
                                            <div class="input-group">
                                                <input type="text" value="{{ route('landing_page', $slug) }}"
                                                    id="myInput" class="form-control d-inline-block"
                                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                                    readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        onclick="myFunction()" id="button-addon2"><i
                                                            class="far fa-copy"></i>
                                                        {{ __('Copy Link') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 domain"
                                            style="{{ $enable_domain == 'on' ? 'display:block' : 'display:none' }}">
                                            {{ Form::label('store_domain', __('Custom Domain'), ['class' => 'form-label']) }}
                                            {{ Form::text('domains', $domains, ['class' => 'form-control', 'placeholder' => __('xyz.com')]) }}
                                        </div>
                                        @if ($plan->enable_subdomain == 'on')
                                            <div class="form-group col-md-6 sundomain"
                                                style="{{ $enable_subdomain == 'on' ? 'display:block' : 'display:none' }}">
                                                {{ Form::label('store_subdomain', __('Sub Domain'), ['class' => 'form-label']) }}
                                                <div class="input-group">
                                                    {{ Form::text('subdomain', $slug, ['class' => 'form-control', 'placeholder' => __('Enter Domain'), 'readonly']) }}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                            id="basic-addon2">.{{ $subdomain_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="form-group col-md-6" id="StoreLink">
                                            {{ Form::label('store_link', __('Store Link'), ['class' => 'form-label']) }}
                                            <div class="input-group">
                                                <input type="text" value="{{ route('landing_page', $slug) }}"
                                                    id="myInput" class="form-control d-inline-block"
                                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                                    readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        onclick="myFunction()" id="button-addon2"><i
                                                            class="far fa-copy"></i>
                                                        {{ __('Copy Link') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}

                                    {{-- <div class="form-group col-lg-4 col-sm-6 col-md-6">
                                        <div class="custom-control form-switch p-0">
                                            <label class="form-check-label mb-2"
                                                for="additional_notes">{{ __('Additional Notes') }}</label><br>
                                            <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                                data-onstyle="primary" name="additional_notes" id="additional_notes"
                                                {{ $Additional_notes == 'on' ? 'checked="checked"' : '' }}>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-sm-6 col-md-6">
                                        <div class="custom-control form-switch p-0">
                                            <label class="form-check-label mb-2"
                                                for="is_checkout_login_required">{{ __('Is Checkout Login Required') }}</label><br>
                                            <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                                data-onstyle="primary" name="is_checkout_login_required"
                                                id="is_checkout_login_required"
                                                {{ $is_checkout_login_required == 'on' ? 'checked="checked"' : '' }}>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group col-lg-4 col-sm-6 col-md-6"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_address', __('Address'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_address', null, ['class' => 'form-control', 'placeholder' => 'Address']) }}
                                            @error('store_Address')
                                                <span class="invalid-store_Address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_city', __('City'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_city', null, ['class' => 'form-control', 'placeholder' => 'City']) }}
                                            @error('store_city')
                                                <span class="invalid-store_city" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_state', __('State'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_state', null, ['class' => 'form-control', 'placeholder' => 'State']) }}
                                            @error('store_state')
                                                <span class="invalid-store_state" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_zipcode', __('Zipcode'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_zipcode', null, ['class' => 'form-control', 'placeholder' => 'Zipcode']) }}
                                            @error('store_zipcode')
                                                <span class="invalid-store_zipcode" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_country', __('Country'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_country', null, ['class' => 'form-control', 'placeholder' => 'Country']) }}
                                            @error('store_country')
                                                <span class="invalid-store_country" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <i class="fab fa-google" aria-hidden="true"></i>
                                            {{ Form::label('google_analytic', __('Google Analytic'), ['class' => 'form-label']) }}
                                            {{ Form::text('google_analytic', null, ['class' => 'form-control', 'placeholder' => 'UA-XXXXXXXXX-X']) }}
                                            @error('google_analytic')
                                                <span class="invalid-google_analytic" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                            {{ Form::label('facebook_pixel_code', __('Facebook Pixel'), ['class' => 'form-label']) }}
                                            {{ Form::text('fbpixel_code', null, ['class' => 'form-control', 'placeholder' => 'UA-0000000-0']) }}
                                            @error('facebook_pixel_code')
                                                <span class="invalid-google_analytic" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div class="row">
                                        <div class="form-group col-md-6">
                                            {{ Form::label('storejs', __('Store Custom JS'), ['class' => 'form-label']) }}
                                            {{ Form::textarea('storejs', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('console.log(hello);')]) }}
                                            @error('storejs')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            {{ Form::label('storecss', __('Store Custom CSS'), ['class' => 'form-label']) }}
                                            {{ Form::textarea('storecss', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Custom CSS')]) }}
                                            @error('storecss')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('metakeyword', __('Meta Keywords'), ['class' => 'form-label']) }}
                                            {!! Form::textarea('metakeyword', null, [
                                                'class' => 'form-control',
                                                'rows' => 3,
                                                'placeholder' => __('Meta Keyword'),
                                            ]) !!}
                                            @error('meta_keywords')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('metadesc', __('Meta Description'), ['class' => 'form-label']) }}
                                            {!! Form::textarea('metadesc', null, [
                                                'class' => 'form-control',
                                                'rows' => 3,
                                                'placeholder' => __('Meta Description'),
                                            ]) !!}

                                            @error('meta_description')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-md-6">
                                        <div class="form-group pt-0">
                                            <div class=" setting-card">
                                                <label for="" class="form-label">{{ __('Meta Image') }}</label>
                                                <div class="logo-content mt-4">
                                                    <a href="{{ !empty($metaimage) ? $metaimage : asset('themes/' . $slug . '/theme_img/img_1.png') }}"
                                                        target="_blank">
                                                        <img id="meta_image" alt="your image"
                                                            src="{{ !empty($metaimage) ? $metaimage : asset('themes/' . $slug . '/theme_img/img_1.png') }}"
                                                            width="150px" class="img_setting">
                                                    </a>
                                                </div>
                                                <div class="choose-files mt-3">
                                                    <label for="metaimage">
                                                        <div class=" bg-primary full_logo"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        <input type="file" name="metaimage" id="metaimage"
                                                            class="form-control file" data-filename="metaimage"
                                                            onchange="document.getElementById('meta_image').src = window.URL.createObjectURL(this.files[0])">
                                                    </label>
                                                </div>
                                                @error('metaimage')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-12 text-end">
                                        @can('Edit Store Setting')
                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                class="btn-submit btn btn-primary">
                                            {!! Form::close() !!}
                                        @endcan

                                        @if (\Auth::guard('admin')->user()->type == 'admin')
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['admin.ownerstore.remove', getCurrentStore()],
                                                'class' => 'd-inline',
                                            ]) !!}
                                            <button type="button"
                                                class="btn btn-secondary btn-danger btn-sm  show_confirm danger-btn">
                                                <span class="text-black">{{ __('Delete Store') }}</span>
                                            </button>
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-seo" role="tabpanel" aria-labelledby="pills-seo-tab">
                    <div id="SEO_Setting">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                                <h5 class=""> {{ __('SEO Settings') }} </h5>

                                @if ($plan->enable_chatgpt == 'on')
                                    <a href="#" class="btn btn-primary btn-sm float-end ai-btn" data-size="lg"
                                        data-ajax-popup-over="true" data-url="{{ route('admin.generate', ['meta']) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}"
                                        data-title="{{ __('Generate Content With AI') }}">
                                        <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
                                    </a>
                                @endif

                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.theme.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                {{-- {{ Form::open(['route' => 'theme.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <i class="fab fa-google" aria-hidden="true"></i>
                                            {{ Form::label('google_analytic', __('Google Analytic'), ['class' => 'form-label']) }}
                                            {{ Form::text('google_analytic', null, ['class' => 'form-control', 'placeholder' => 'UA-XXXXXXXXX-X']) }}
                                            @error('google_analytic')
                                                <span class="invalid-google_analytic" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                            {{ Form::label('facebook_pixel_code', __('Facebook Pixel'), ['class' => 'form-label']) }}
                                            {{ Form::text('fbpixel_code', null, ['class' => 'form-control', 'placeholder' => 'UA-0000000-0']) }}
                                            @error('facebook_pixel_code')
                                                <span class="invalid-google_analytic" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('metakeyword', __('Meta Keywords'), ['class' => 'form-label']) }}
                                            {!! Form::textarea('metakeyword', null, [
                                                'class' => 'form-control',
                                                'rows' => 3,
                                                'placeholder' => __('Meta Keyword'),
                                            ]) !!}
                                            @error('meta_keywords')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            {{ Form::label('metadesc', __('Meta Description'), ['class' => 'form-label']) }}
                                            {!! Form::textarea('metadesc', null, [
                                                'class' => 'form-control',
                                                'rows' => 3,
                                                'placeholder' => __('Meta Description'),
                                            ]) !!}

                                            @error('meta_description')
                                                <span class="invalid-about" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group pt-0">
                                            <div class=" setting-card">
                                                <label for="" class="form-label">{{ __('Meta Image') }}</label>
                                                <div class="logo-content mt-4">
                                                    <a href="{{ !empty($metaimage) ? $metaimage : asset('themes/' . $slug . '/theme_img/img_1.png') }}"
                                                        target="_blank">
                                                        <img id="meta_image" alt="your image"
                                                            src="{{ !empty($metaimage) ? $metaimage : asset('themes/' . $slug . '/theme_img/img_1.png') }}"
                                                            width="150px" class="img_setting">
                                                    </a>
                                                </div>
                                                <div class="choose-files mt-3">
                                                    <label for="metaimage">
                                                        <div class=" bg-primary full_logo"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                        </div>
                                                        <input type="file" name="metaimage" id="metaimage"
                                                            class="form-control file" data-filename="metaimage"
                                                            onchange="document.getElementById('meta_image').src = window.URL.createObjectURL(this.files[0])">
                                                    </label>
                                                </div>
                                                @error('metaimage')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        @can('Edit Store Setting')
                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                class="btn-submit btn btn-primary">
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-custom" role="tabpanel" aria-labelledby="pills-custom-tab">
                    <div id="custom_Setting">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                                <h5 class=""> {{ __('Custom Settings') }} </h5>

                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.theme.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                {{-- {{ Form::open(['route' => 'theme.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                                <div class="row mt-2">
                                    @if ($plan->enable_domain == 'on' || $plan->enable_subdomain == 'on')
                                        <div class="col-md-6 py-4">
                                            <div class="radio-button-group row gy-2 mts">
                                                <div class="col-sm-4">
                                                    <label
                                                        class="btn btn-outline-primary w-100 {{ $enable_storelink == 'on' ? 'active' : '' }}">
                                                        <input type="radio" class="domain_click  radio-button"
                                                            name="enable_domain" value="enable_storelink"
                                                            id="enable_storelink"
                                                            {{ $enable_storelink == 'on' ? 'checked' : '' }}>
                                                        {{ __('Store Link') }}
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($plan->enable_domain == 'on')
                                                        <label
                                                            class="btn btn-outline-primary w-100 {{ $enable_domain == 'on' ? 'active' : '' }}">
                                                            <input type="radio" class="domain_click radio-button"
                                                                name="enable_domain" value="enable_domain"
                                                                id="enable_domain"
                                                                {{ $enable_domain == 'on' ? 'checked' : '' }}>
                                                            {{ __('Domain') }}
                                                        </label>
                                                    @endif
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($plan->enable_subdomain == 'on')
                                                        <label
                                                            class="btn btn-outline-primary w-100 {{ $enable_subdomain == 'on' ? 'active' : '' }}">
                                                            <input type="radio" class="domain_click radio-button"
                                                                name="enable_domain" value="enable_subdomain"
                                                                id="enable_subdomain"
                                                                {{ $enable_subdomain == 'on' ? 'checked' : '' }}>
                                                            {{ __('Sub Domain') }}
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($domainPointing == 1)
                                                <div class="text-sm mt-2" id="domainnote"
                                                    style="{{ $enable_domain == 'on' ? 'display: block' : '' }}">
                                                    <span><b class="text-success">{{ __('Note : Before add Custom Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|
                                                            {{ __('Your Custom Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @else
                                                <div class="text-sm mt-2" id="domainnote" style="display: none">
                                                    <span><b>{{ __('Note : Before add Custom Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|</b>
                                                        <b
                                                            class="text-danger">{{ __('Your Custom Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @endif
                                            @if ($subdomainPointing == 1)
                                                <div class="text-sm mt-2" id="subdomainnote" style="display: none">
                                                    <span><b class="text-success">{{ __('Note : Before add Sub Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|
                                                            {{ __('Your Sub Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @else
                                                <div class="text-sm mt-2" id="subdomainnote" style="display: none">
                                                    <span><b>{{ __('Note : Before add Sub Domain, your domain A record is pointing to our server IP :') }}{{ $serverIp }}|</b>
                                                        <b
                                                            class="text-danger">{{ __('Your Sub Domain IP Is This: ') }}</b></span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6" id="StoreLink"
                                            style="{{ $enable_storelink == 'on' ? 'display: block' : 'display: none' }}">
                                            {{ Form::label('store_link', __('Store Link'), ['class' => 'form-label']) }}
                                            <div class="input-group">
                                                <input type="text" value="{{ route('landing_page', $slug) }}"
                                                    id="myInput" class="form-control d-inline-block"
                                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                                    readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        onclick="myFunction()" id="button-addon2"><i
                                                            class="far fa-copy"></i>
                                                        {{ __('Copy Link') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 domain"
                                            style="{{ $enable_domain == 'on' ? 'display:block' : 'display:none' }}">
                                            {{ Form::label('store_domain', __('Custom Domain'), ['class' => 'form-label']) }}
                                            {{ Form::text('domains', $domains, ['class' => 'form-control', 'placeholder' => __('xyz.com')]) }}
                                        </div>
                                        @if ($plan->enable_subdomain == 'on')
                                            <div class="form-group col-md-6 sundomain"
                                                style="{{ $enable_subdomain == 'on' ? 'display:block' : 'display:none' }}">
                                                {{ Form::label('store_subdomain', __('Sub Domain'), ['class' => 'form-label']) }}
                                                <div class="input-group">
                                                    {{ Form::text('subdomain', $slug, ['class' => 'form-control', 'placeholder' => __('Enter Domain'), 'readonly']) }}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                            id="basic-addon2">.{{ $subdomain_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="form-group col-md-6" id="StoreLink">
                                            {{ Form::label('store_link', __('Store Link'), ['class' => 'form-label']) }}
                                            <div class="input-group">
                                                <input type="text" value="{{ route('landing_page', $slug) }}"
                                                    id="myInput" class="form-control d-inline-block"
                                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                                    readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        onclick="myFunction()" id="button-addon2"><i
                                                            class="far fa-copy"></i>
                                                        {{ __('Copy Link') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group col-md-6">
                                        {{ Form::label('storejs', __('Store Custom JS'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('storejs', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('console.log(hello);')]) }}
                                        @error('storejs')
                                            <span class="invalid-about" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{ Form::label('storecss', __('Store Custom CSS'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('storecss', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Custom CSS')]) }}
                                        @error('storecss')
                                            <span class="invalid-about" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        @can('Edit Store Setting')
                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                class="btn-submit btn btn-primary">
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-checkout" role="tabpanel" aria-labelledby="pills-checkout-tab">
                    <div id="checkout_Setting">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                                <h5 class=""> {{ __('Checkout Settings') }} </h5>

                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.theme.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                {{-- {{ Form::open(['route' => 'theme.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                                <div class="row mt-2">

                                    <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                        <div class="custom-control form-switch p-0">
                                            <label class="form-check-label mb-2 text-primary"
                                                for="additional_notes">{{ __('Additional Notes') }}</label><br>
                                            <small class="mb-2 d-inline-block"> {{ __('Note') }}:
                                                {{ __('Enable the Additional Notes functionality to allow users to provide extra order-specific information on the checkout page.') }}</small><br>
                                            <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                                data-onstyle="primary" name="additional_notes" id="additional_notes"
                                                {{ $Additional_notes == 'on' ? 'checked="checked"' : '' }}>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                        <div class="custom-control form-switch p-0 ">
                                            <label class="form-check-label mb-2 text-primary"
                                                for="is_checkout_login_required">{{ __('Is Checkout Login Required') }}</label><br>
                                            <small class="mb-2 d-inline-block"> {{ __('Note') }}:
                                                {{ __('Use the Is Checkout Required feature to prevent guest checkout, requiring users to log in before completing their purchase for added security.') }}</small><br>
                                            <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                                data-onstyle="primary" name="is_checkout_login_required"
                                                id="is_checkout_login_required"
                                                {{ $is_checkout_login_required == 'on' ? 'checked="checked"' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        @can('Edit Store Setting')
                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                class="btn-submit btn btn-primary">
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
                    <div id="shippinglabel_Setting">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                                <h5 class=""> {{ __('Shipping Label Settings') }} </h5>

                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.theme.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                {{-- {{ Form::open(['route' => 'theme.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                                <div class="row mt-2">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_address', __('Address'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_address', null, ['class' => 'form-control', 'placeholder' => 'Address']) }}
                                            @error('store_Address')
                                                <span class="invalid-store_Address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_city', __('City'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_city', null, ['class' => 'form-control', 'placeholder' => 'City']) }}
                                            @error('store_city')
                                                <span class="invalid-store_city" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_state', __('State'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_state', null, ['class' => 'form-control', 'placeholder' => 'State']) }}
                                            @error('store_state')
                                                <span class="invalid-store_state" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_zipcode', __('Zipcode'), ['class' => 'form-label']) }}
                                            {{ Form::number('store_zipcode', null, ['class' => 'form-control', 'placeholder' => 'Zipcode']) }}
                                            @error('store_zipcode')
                                                <span class="invalid-store_zipcode" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('store_country', __('Country'), ['class' => 'form-label']) }}
                                            {{ Form::text('store_country', null, ['class' => 'form-control', 'placeholder' => 'Country']) }}
                                            @error('store_country')
                                                <span class="invalid-store_country" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        @can('Edit Store Setting')
                                            <input type="submit" value="{{ __('Save Changes') }}"
                                                class="btn-submit btn btn-primary">
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div id="Main_Page_Content_web">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Home Page') }}</h5>
                                <small class="text-muted"></small>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => 'admin.product.page.setting', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'Main_Page_Content_web_post']) }}
                                {!! Form::hidden('page_name', 'home_page_web') !!}
                                @foreach ($homepage_web_json as $homepage_web_json_key => $homepage_web_json_section)
                                    @php
                                        $id = '';

                                        if ($homepage_web_json_section['section_name'] == 'Home-Brand-Logo') {
                                            $id = 'Brand_Logo';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Header') {
                                            $id = 'Header_Setting';
                                            $class = 'card';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Promotions') {
                                            $id = 'Features_Setting';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Email-Subscriber') {
                                            $id = 'Email_Subscriber_Setting';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Categories') {
                                            $id = 'Categories';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Testimonial') {
                                            $id = 'Testimonials';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Footer-1') {
                                            $id = 'Footer_1';
                                        }
                                        if ($homepage_web_json_section['section_name'] == 'Home-Footer-2') {
                                            $id = 'Footer_2';
                                        }

                                    @endphp
                                    <input type="hidden" name="array[{{ $homepage_web_json_key }}][section_name]"
                                        value="{{ $homepage_web_json_section['section_name'] }}">
                                    <input type="hidden" name="array[{{ $homepage_web_json_key }}][section_slug]"
                                        value="{{ $homepage_web_json_section['section_slug'] }}">
                                    <input type="hidden" name="array[{{ $homepage_web_json_key }}][array_type]"
                                        value="{{ $homepage_web_json_section['array_type'] }}">
                                    <input type="hidden" name="array[{{ $homepage_web_json_key }}][section_enable]"
                                        value="{{ $homepage_web_json_section['section_enable'] }}">
                                    <input type="hidden" name="array[{{ $homepage_web_json_key }}][loop_number]"
                                        value="{{ $homepage_web_json_section['loop_number'] }}">
                                    <input type="hidden"
                                        name="array[{{ $homepage_web_json_key }}][unique_section_slug]"
                                        value="{{ $homepage_web_json_section['unique_section_slug'] }}">

                                    @php
                                        $loop = 1;
                                        $homepage_web_json_section = (array) $homepage_web_json_section;
                                        // $homepage_web_json_new_key = $homepage_web_json_key - 1;
                                    @endphp

                                    @if (
                                        ($homepage_web_json_key - 1 > 0 &&
                                            $homepage_web_json[$homepage_web_json_key - 1]['section_slug'] != $homepage_web_json_section['section_slug']) ||
                                            $homepage_web_json_key == 0)
                                        <div class="card" id="{{ $id }}">
                                            <div class="card-header d-flex justify-content-between">
                                                <div>
                                                    <h5> {{ $homepage_web_json_section['section_name'] }} </h5>
                                                </div>
                                                <div class="text-end">
                                                    <div class="form-check form-switch form-switch-right">
                                                        <input type="hidden"
                                                            name="array[{{ $homepage_web_json_key }}][section_enable]{{ $homepage_web_json_section['section_enable'] }}"
                                                            value="off">
                                                        <input type="checkbox" class="form-check-input mx-2 off switch"
                                                            data-toggle="switchbutton"
                                                            name="array[{{ $homepage_web_json_key }}][section_enable]{{ $homepage_web_json_section['section_enable'] }}"
                                                            id="array[{{ $homepage_web_json_key }}]{{ $homepage_web_json_section['section_slug'] }}"
                                                            {{ $homepage_web_json_section['section_enable'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                    <div class="card-body">
                                        @php $loop1 = 1; @endphp
                                        @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                            @php
                                                $loop1 = (int) $homepage_web_json_section['loop_number'];
                                            @endphp
                                        @endif

                                        @for ($i = 0; $i < $loop1; $i++)
                                            <div class="row">
                                                @foreach ($homepage_web_json_section['inner-list'] as $inner_list_key => $homepage_web_field)
                                                    <?php $homepage_web_field = (array) $homepage_web_field; ?>
                                                    <input type="hidden"
                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_name]"
                                                        value="{{ $homepage_web_field['field_name'] }}">
                                                    <input type="hidden"
                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_slug]"
                                                        value="{{ $homepage_web_field['field_slug'] }}">
                                                    <input type="hidden"
                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_help_text]"
                                                        value="{{ $homepage_web_field['field_help_text'] }}">
                                                    <input type="hidden"
                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                        value="{{ $homepage_web_field['field_default_text'] }}">
                                                    <input type="hidden"
                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_type]"
                                                        value="{{ $homepage_web_field['field_type'] }}">

                                                    @if ($homepage_web_field['field_type'] == 'text')
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                @php
                                                                    $checked1 = $homepage_web_field['field_default_text'];
                                                                    if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']][$i])) {
                                                                        $checked1 = $homepage_web_json_section[$homepage_web_field['field_slug']][$i];
                                                                    }
                                                                @endphp
                                                                @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                                                    <input type="text"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}]"
                                                                        class="form-control" value="{{ $checked1 }}"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                @else
                                                                    <input type="text"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"class="form-control"
                                                                        value="{{ $homepage_web_field['field_default_text'] }}"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($homepage_web_field['field_type'] == 'text area')
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                @php
                                                                    $checked1 = $homepage_web_field['field_default_text'];
                                                                    if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']][$i])) {
                                                                        $checked1 = $homepage_web_json_section[$homepage_web_field['field_slug']][$i];
                                                                    }
                                                                @endphp
                                                                @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                                                    <textarea class="form-control"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}]"
                                                                        rows="3" placeholder="{{ $homepage_web_field['field_help_text'] }}">{{ $checked1 }}</textarea>
                                                                @else
                                                                    <textarea class="form-control"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                                        rows="3" placeholder="{{ $homepage_web_field['field_help_text'] }}">{{ $homepage_web_field['field_default_text'] }}</textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($homepage_web_field['field_type'] == 'photo upload')
                                                        <div class="col-sm-6">
                                                            @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                                                @php
                                                                    $checked2 = $homepage_web_field['field_default_text'];

                                                                    if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']])) {
                                                                        $checked2 = $homepage_web_json_section[$homepage_web_field['field_slug']][$i];

                                                                        if (is_array($checked2)) {
                                                                            $checked2 = $checked2['field_prev_text'];
                                                                        }
                                                                    }
                                                                @endphp
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                    <input type="hidden"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}][field_prev_text]"
                                                                        value="{{ $checked2 }}">
                                                                    <input type="file"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}][image]"
                                                                        class="form-control"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                </div>
                                                                <img src="{{ get_file($checked2, APP_THEME()) }}"
                                                                    style="width: auto; max-height: 80px;">
                                                            @else
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                    <input type="hidden"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_prev_text]"
                                                                        value="{{ $homepage_web_field['field_default_text'] }}">
                                                                    <input type="file"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                                        class="form-control"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                </div>
                                                                <img src="{{ get_file($homepage_web_field['field_default_text'], APP_THEME()) }}"
                                                                    style="width: 200px; height: 200px;">
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if ($homepage_web_field['field_type'] == 'button')
                                                        @php
                                                            $checked1 = $homepage_web_field['field_default_text'];
                                                            if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']][$i])) {
                                                                $checked1 = $homepage_web_json_section[$homepage_web_field['field_slug']][$i];
                                                            }
                                                        @endphp

                                                        @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                    <input type="text"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}]"
                                                                        class="form-control" value="{{ $checked1 }}"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                                    <input type="text"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                                        class="form-control"
                                                                        value="{{ $homepage_web_field['field_default_text'] }}"
                                                                        placeholder="{{ $homepage_web_field['field_help_text'] }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @php
                                                        $checked = '';
                                                        if ($homepage_web_field['field_slug'] == 'homepage-quick-link-enable') {
                                                            $checked = $homepage_web_field['field_default_text'] == 'on' ? 'checked' : '';
                                                        }
                                                        if ($homepage_web_field['field_slug'] == 'homepage-testimonial-card-enable') {
                                                            $checked = $homepage_web_field['field_default_text'] == 'on' ? 'checked' : '';
                                                        }
                                                    @endphp

                                                    @if ($homepage_web_field['field_type'] == 'checkbox')
                                                        <div class="col-sm-6 text-end">
                                                            <label
                                                                class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                            <div class="form-check form-switch form-switch-right mb-2">
                                                                @if ($homepage_web_json_section['array_type'] == 'multi-inner-list')
                                                                    @php
                                                                        $checked1 = '';
                                                                        if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']][$i]) && $homepage_web_json_section[$homepage_web_field['field_slug']][$i] == 'on') {
                                                                            $checked1 = 'checked';
                                                                        }
                                                                    @endphp
                                                                    <input type="hidden"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}]"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input mx-2"
                                                                        name="array[{{ $homepage_web_json_key }}][{{ $homepage_web_field['field_slug'] }}][{{ $i }}]"
                                                                        id="array[{{ $homepage_web_json_section['section_slug'] }}][{{ $homepage_web_field['field_slug'] }}]"
                                                                        {{ $checked1 }}>
                                                                @else
                                                                    @php
                                                                        $checked1 = '';
                                                                        if (!empty($homepage_web_field['field_default_text']) && $homepage_web_field['field_default_text'] == 'on') {
                                                                            $checked1 = 'checked';
                                                                        }
                                                                    @endphp
                                                                    <input type="hidden"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input mx-2"
                                                                        name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                                        id="array[{{ $homepage_web_json_section['section_slug'] }}][{{ $homepage_web_field['field_slug'] }}]"
                                                                        {{ $checked1 }}>
                                                                @endif
                                                                <label class="form-check-label"
                                                                    for="array[ {{ $homepage_web_json_section['section_slug'] }}][{{ $homepage_web_field['field_slug'] }}]">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($homepage_web_field['field_type'] == 'multi file upload')
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ $homepage_web_field['field_name'] }}</label>
                                                            <input type="file"
                                                                name="array[{{ $homepage_web_json_key }}][inner-list][{{ $inner_list_key }}][multi_image][]"
                                                                class="form-control custom-input-file" multiple>
                                                        </div>
                                                        <div id="img-count" class="badge badge-success rounded-pill">
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="card-wrapper p-3 lead-common-box">
                                                                @if (!empty($homepage_web_json_section[$homepage_web_field['field_slug']]))
                                                                    @foreach ($homepage_web_json_section[$homepage_web_field['field_slug']] as $key => $file_pathh)
                                                                        <div
                                                                            class="card mb-3 border shadow-none product_Image">
                                                                            <div class="px-3 py-3">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col ml-n2">
                                                                                        <p
                                                                                            class="card-text small text-muted">
                                                                                            <input type="hidden"
                                                                                                name='array[{{ $homepage_web_json_key }}][prev_image][]'
                                                                                                value="{{ $file_pathh['image'] }}">
                                                                                            <img src="{{ get_file($file_pathh['image'], APP_THEME()) }}"
                                                                                                alt=""
                                                                                                style="max-width: 100px;max-height: 100px;"
                                                                                                data-dz-thumbnail="">
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-auto actions">
                                                                                        <button
                                                                                            class="btn btn-sm btn-primary btn-icon image_delete"
                                                                                            data-id="{{ get_file($file_pathh['image'], APP_THEME()) }}">
                                                                                            <i class="ti ti-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endfor
                                    </div>

                                    {{-- if($key+1 <= count($data_arr)-1){
                                                    if($data_arr[$key+1]->section_slug != $section['section_slug']){ --}}

                                    @if ($homepage_web_json_key > 0 && $homepage_web_json_key + 1 <= count($homepage_web_json) - 1)
                                        @if ($homepage_web_json[$homepage_web_json_key + 1]['section_slug'] != $homepage_web_json_section['section_slug'])
                            </div>
                        @else
                            <hr>
                            @endif
                            @endif
                            {{-- @if ($homepage_web_json_key == 0 || $homepage_web_json[$homepage_web_json_key]['section_slug'] != $homepage_web_json_section['section_slug'])
                                                </div></div>
                                            @endif --}}
                            @endforeach
                            <div class="text-end">
                                @can('Edit Store Setting')
                                    <button type="submit"
                                        class="btn btn-primary submit_form mb-3 me-3">{{ __('save') }}</button>
                                @endcan
                            </div>

                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div id="Order_Complete_Page_Content">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=""> {{ __('Order Complete Screen') }} </h5>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => ['admin.product.page.setting'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                            {!! Form::hidden('page_name', 'order_complete') !!}
                            @foreach ($order_complete_json as $json_key => $section)
                                @php $section = (array)$section; @endphp
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ $section['section_name'] }}</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            @foreach ($section['inner-list'] as $inner_list_key => $field)
                                                @php $field = (array)$field; @endphp

                                                <input type="hidden" name="array[{{ $json_key }}][section_name]"
                                                    value="{{ $section['section_name'] }}">
                                                <input type="hidden" name="array[{{ $json_key }}][section_slug]"
                                                    value="{{ $section['section_slug'] }}">
                                                <input type="hidden"
                                                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_name]"
                                                    value="{{ $field['field_name'] }}">
                                                <input type="hidden"
                                                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_slug]"
                                                    value="{{ $field['field_slug'] }}">
                                                <input type="hidden"
                                                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_help_text]"
                                                    value="{{ $field['field_help_text'] }}">
                                                <input type="hidden"
                                                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                                                    value="{{ $field['field_default_text'] }}">
                                                <input type="hidden"
                                                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_type]"
                                                    value="{{ $field['field_type'] }}">

                                                @if ($field['field_type'] == 'text')
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <input type="text"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                                                                class="form-control"
                                                                value="{{ !empty($field['value']) ? $field['value'] : $field['field_default_text'] }}">
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($field['field_type'] == 'text area')
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <textarea class="form-control" name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                                                                rows="3">{{ !empty($field['value']) ? $field['value'] : $field['field_default_text'] }}</textarea>
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($field['field_type'] == 'photo upload')
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <input type="hidden"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][image_path]"
                                                                value="{{ !empty($field['value']) ? $field['value'] : $field['field_default_text'] }}">
                                                            <input type="file"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                                                                class="form-control">
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        @php
                                                            $path = !empty($field['image_url']) ? $field['image_url'] : $field['field_default_text'];
                                                        @endphp
                                                        <img src="{{ get_file($path, APP_THEME()) }}" alt=""
                                                            class="w-100">
                                                    </div>
                                                @endif

                                                @if ($field['field_type'] == 'product single')
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <select class="form-select"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($field['field_type'] == 'product multi')
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <select class="form-select"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($field['field_type'] == 'category')
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label capitalize">{{ $field['field_name'] }}</label>
                                                            <select class="form-select"
                                                                name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                            <small>{{ $field['field_help_text'] }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-end">
                                @can('Edit Store Setting')
                                    <button type="submit" class="btn btn-primary">save</button>
                                @endcan
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

@endsection

@push('custom-script')
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
        }

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        });
    </script>


    <script>
        $(function() {
            $('body').on('click', '.image_delete', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var data = {
                    'image': id
                };
                // now make the ajax request
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.product.image.delete') }}",
                    data: data,
                    context: this,
                    success: function(data) {
                        $(this).closest('.product_Image').remove();
                        $('#Main_Page_Content_web_post').find('.submit_form').click();
                    }
                });
            });
        });
    </script>
@endpush
