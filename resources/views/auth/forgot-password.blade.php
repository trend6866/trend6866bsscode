@extends('layouts.guest')

@section('page-title')
    {{__('Forget password')}}
@endsection

@if(env('RECAPTCHA_MODULE') == 'yes')
    {!! NoCaptcha::renderJs() !!}
@endif

@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{ __('Forgot Password') }}</h2>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="" class="form-label">{{ __('Email') }}</label>
                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                    autofocus placeholder="{{ __('Enter email Address') }}" />
            </div>

            @if(env('RECAPTCHA_MODULE') == 'yes')
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                    <span class="error small text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            @endif

            {!! Form::hidden('type', 'admin') !!}
            <button class="btn btn-primary btn-block mt-3 w-100" type="submit">
                {{ __('Email Password Reset Link') }}
            </button>
            <div class="mt-3 text-center">
                <a class="underline text-gray-600 hover:text-gray-900"
                    href="{{ route('admin.login') }}">
                    {{ __('Back to signin') }}
                </a>
            </div>
        </form>
    </div>
@endsection