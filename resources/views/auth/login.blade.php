@extends('layouts.guest')
@php
    $adminSettings = \App\Models\Utility::Seting();
@endphp

@section('page-title')
    {{__('Login')}}
@endsection

@if(env('RECAPTCHA_MODULE') == 'yes')
    {!! NoCaptcha::renderJs() !!}
@endif

@section('content')
    <div class="">
        <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
    </div>
    <div class="">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="remember" id="invalidCheck" >
                <label class="form-check-label" for="invalidCheck">
                    Remember me
                </label>
            </div>

            <div class="my-1">
                @if (Route::has('admin.password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
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

            <div class="d-grid">
                {{-- {!! Form::hidden('type', 'admin') !!} --}}
                <button class="btn btn-primary btn-block mt-2"> {{ __('Login') }} </button>
            </div>

            <p class="my-4 text-center">{{ __("Don't have an account?") }}
                @if ($adminSettings['SIGNUP'] == 'on')
                <a href="{{route('admin.register')}}" class="my-4 text-primary">{{__('Register')}}</a>
                @endif
            </p>



        </form>


    </div>
@endsection
