@extends('layouts.layouts')

@section('page-title')
{{ __('Login') }}
@endsection

@section('content')
<div class="wrapper" style="margin-top: 123.594px;">
    <section class="register-page padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-12">
                    <div class="d-flex justify-content-center back-toshop">
                        <a href="{{route('page.product-list',$slug)}}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 21 21" fill="none">
                                    <circle cx="10.5" cy="10.5" r="10.1912" stroke="#051512" stroke-width="0.617647"></circle>
                                    <g clip-path="url(#clip0_110_2391)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9453 10.6796C13.9453 10.8299 13.8234 10.9518 13.6731 10.9518L8.3543 10.9519L8.99407 11.5734C9.10192 11.6782 9.10442 11.8506 8.99964 11.9584C8.89487 12.0663 8.7225 12.0688 8.61465 11.964L7.49361 10.8749C7.44083 10.8237 7.41106 10.7532 7.41106 10.6797C7.41106 10.6061 7.44083 10.5356 7.49361 10.4844L8.61465 9.39534C8.7225 9.29056 8.89487 9.29306 8.99964 9.40091C9.10442 9.50876 9.10192 9.68113 8.99407 9.7859L8.35432 10.4074L13.673 10.4073C13.8234 10.4073 13.9453 10.5292 13.9453 10.6796Z" fill="#051512"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_110_2391">
                                            <rect width="6.53423" height="6.53423" fill="white" transform="matrix(-1 0 0 1 13.9453 7.41211)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            {{ __('Back to Shop') }}
                        </a>
                    </div>
                    <div class="section-title text-center">
                        <h2 class="h1">{{ __('Log In') }}</h2>
                    </div>
                    <div class="form-wrapper">
                        <form method="POST" action="{{ route('login',$slug) }}" class="login-form">
                            @csrf
                            <div class="form-container">
                                <div class="form-heading">
                                    <h3>{{ __('Log in') }}</h3>
                                </div>
                            </div>
                            <div class="form-container">
                                <div class="row">
                                    <div class="col-12">
                                        <p>{{ __('I am a returning customer') }}</p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('E-mail') }}<sup aria-hidden="true">*</sup>:</label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="shop@company.com" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ _('Password') }}<sup aria-hidden="true">*</sup>:</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="**********" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-container">
                                <div class="row align-items-center form-footer justify-content-end">
                                    <div class="col-lg-12  col-12 d-flex align-items-center justify-content-end mobile-direction-column">
                                        <a href="{{ route('password.request',$slug) }}" class="forgot-pass">{{ __('Forgot Password?') }}</a>
                                        {!! Form::hidden('type', 'customer') !!}
                                        <button type="submit" class="btn submit-btn login-do-btn" id="login_button">
                                            {{ __('Login') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-container">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-12 d-flex align-items-center justify-content-center">
                                        <div class="reg-lbl">{{ __('If you dont have account') }}</div>
                                        <a href="{{ route('register',$slug) }}" class="btn register-btn" type="submit">
                                            {{ __('Register') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
