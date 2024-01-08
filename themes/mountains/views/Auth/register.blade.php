@extends('layouts.layouts')

@section('page-title')
{{ __('Register') }}
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
                    <h2>{{ __('Register') }}</h2>
                </div>
                <div class="form-wrapper register-form">
                    <form method="POST" action="{{ route('register',$slug) }}">
                        @csrf
                        <div class="form-container">
                            <div class="form-heading">
                                <h3> {{ __('Your') }} <b> {{ __('Personal Details') }} </b></h3>
                            </div>
                        </div>
                        <div class="form-container">
                            <div class="row">
                                <div class="col-12">
                                    @if ($errors->any())
                                        <ul class="mt-3 list-disc list-inside ">
                                            @foreach ($errors->all() as $error)
                                                <li class="text-sm text-danger text-600">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <br>
                                    @endif
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{ __('First Name') }}<sup aria-hidden="true">*</sup>:</label>
                                        <input name="first_name" type="text" class="form-control" placeholder="John" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Last Name') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input name="last_name" type="text" class="form-control" placeholder="Doe" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('E-mail') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input name="email" type="email" class="form-control" placeholder="shop@company.com" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Telephone') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input name="mobile" type="number" class="form-control" placeholder="1234567890" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-container">
                            <h4> {{ __('Your') }} <b> {{ __('Password') }} </b></h4>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{ __('Password') }}<sup aria-hidden="true">*</sup>:</label>
                                        <input name="password" type="password" class="form-control" placeholder="**********" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Confirm password') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input name="password_confirmation" type="password" class="form-control" placeholder="***********" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-container">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <h4><b> {{ __('Subscribe') }} </b> {{ __('our newsletter?')}} </h4>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="radio-group">
                                                <input type="radio" id="yes" name="subscribe" value="yes" checked/>
                                                <label for="yes"> {{ __('Yes')}} </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="radio-group">
                                                <input type="radio" id="no" name="subscribe" value="no"/>
                                                <label for="no"> {{ __('No')}} </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center form-footer">
                                <div class="col-lg-8   col-12">
                                    <div class="checkbox-custom">
                                        <input type="checkbox" id="ch1">
                                        <label for="ch1">
                                            <span> {{ __('I have read and agree to the ')}} <a href="{{route('privacy_page',$slug)}}"> {{ __('Terms')}} &amp; {{ __('Conditions.')}} </a>  </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    {!! Form::hidden('login_type', 'customer') !!}
                                    <button class="btn submit-btn" type="submit">
                                        {{ __('Register') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                            <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                        </svg>
                                    </button>
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
