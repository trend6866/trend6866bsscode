

@extends('layouts.layouts')

@section('page-title')
{{ __('Contactus') }}
@endsection

@section('content')

{{-- <div class="wrapper"> --}}

    <section class="common-ptrn common-banner-section contact-page">
        <div class="container">
            @foreach ($pages_data as $page)
            <div class="row">
                <div class="col-md-5 col-12">
                    <div class="common-banner-content">
                        <a href="{{ route('landing_page',$slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z" fill="white"></path>
                                </svg>
                            </span>
                            {{ __('Back to Home') }}
                        </a>
                        <div class="section-title">
                            <h2> {{$page->name}}  </h2>
                        </div>
                        <p>{!! html_entity_decode($page->short_description ) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <section class="contact-page padding-top padding-bottom">
        <div class="container">
            <div class="row">
                @php
                    $other_info = json_decode($page->other_info);
                @endphp
                <div class="col-md-5 col-12 contact-left-column">
                    <div class="contact-left-inner row">
                        <ul class="col-sm-6 col-12">
                            <li>
                                <h3> {{ __('Call us:')}} </h3>
                                <p><a href="tel:+48 0021-32-12">{{isset($other_info->call) ? $other_info->call : '+48 0021-32-12'}}</a></p>
                            </li>
                            <li>
                                <h3> {{ __('Email:')}} </h3>
                                <p><a href="mailto:shop@company.com">{{isset($other_info->email) ? $other_info->email : 'shop@company.com'}}</a></p>
                            </li>
                        </ul>
                        <ul class="col-sm-6 col-12">
                            <li>
                                <h3> {{ __('Address:')}} </h3>
                                <p class="address">{{isset($other_info->address) ? $other_info->address : 'Marigold Lane,Coral Way, Miami,Florida, 33169'}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 col-12 contact-right-column">
                    <div class="contact-right-inner">
                        <div class="section-title">
                            <h2> {{ __('Contact') }} <b> {{ __('form') }} </b></h2>
                        </div>
                        <form class="contact-form"  action="{{ route("admin.contacts.store",$slug) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ _('First Name') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input type="text" name="first_name" class="form-control"  placeholder="John" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Last Name') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input type="text" name="last_name" class="form-control"  placeholder="Doe" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('E-mail') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input type="email" name="email" class="form-control" placeholder="shop@company.com" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Telephone') }} <sup aria-hidden="true">*</sup>:</label>
                                        <input type="number"  name="contact" class="form-control"  placeholder="1234567890" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Subject:') }} </label>
                                        <input type="text" name="subject" class="form-control"  placeholder="Doe" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label> {{ __('Description:') }} </label>
                                        <textarea  class="form-control" name="description"  placeholder="How can we help?" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-8   col-12">
                                    <div class="checkbox-custom">
                                        <input type="checkbox" id="ch1">
                                        <label for="ch1">
                                            <span> {{ __('I have read and agree to the') }} <a href="{{route('privacy_page',$slug)}}"> {{ __('Terms & Conditions.') }} </a>  </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <button class="btn submit-btn" type="submit">
                                        {{ __('Send message') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                            <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- </div> --}}
@endsection
