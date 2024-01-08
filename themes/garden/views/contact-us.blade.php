@extends('layouts.layouts')
@section('page-title')
    {{ __('Contact Us') }}
@endsection
@section('content')
    <!--wrapper start here-->
    <div class="contact-wrapper">
        <section class="top-bg-section">
           <div class=" container">
            @foreach ($pages_data as $page)
              <div class="col-md-5 col-12">
                 <div class="heading-wrapper">
                    <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                       <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                          <circle cx="15.5" cy="15.5" r="15.0441" stroke="#000" stroke-width="0.911765" />
                          <path fill-rule="evenodd" clip-rule="evenodd"
                             d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z"
                             fill="#000" />
                       </svg>
                       <span> {{__('Back to category')}}</span>
                    </a>
                    <div class=" section-title">
                          <h2>{{$page->name}} </h2>
                       <p>{!! html_entity_decode($page->short_description ) !!}</p>
                    </div>
                 </div>
              </div>
            @endforeach
           </div>
        </section>
        <section class="contact-page padding-bottom padding-top">
           <div class="container">
              <div class="row">
                @php
                    $other_info = json_decode($page->other_info);
                @endphp
                 <div class="col-md-5 col-12 contact-left-column">
                    <div class="contact-left-inner row">
                       <ul class="col-sm-6 col-12">
                          <li>
                             <h4>{{__('Call us:')}}</h4>
                             <p><a href="tel:+48 0021-32-12">{{isset($other_info->call) ? $other_info->call : '+48 0021-32-12'}}</a></p>
                          </li>
                          <li>
                             <h4>{{__('Email:')}}</h4>
                             <p><a href="mailto:shop@company.com">{{isset($other_info->email) ? $other_info->email : 'shop@company.com'}}</a></p>
                          </li>
                       </ul>
                       <ul class="col-sm-6 col-12">
                          <li>
                             <h4>{{__('Address:')}}</h4>
                             <p class="address">{{isset($other_info->address) ? $other_info->address : 'Marigold Lane,Coral Way, Miami,Florida, 33169'}}</p>
                          </li>
                       </ul>
                    </div>
                 </div>
                 <div class="col-md-7 col-12 contact-right-column">
                    <div class="contact-right-inner">
                        <div class="section-title">
                            <h2>{{__('Contact form')}} </h2>
                        </div>
                        <form class="contact-form" action="{{ route("contacts.store",$slug) }}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{__('First Name')}}<sup aria-hidden="true">*</sup>:</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="John" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{__('Last Name')}}<sup aria-hidden="true">*</sup>:</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{__('E-mail')}}<sup aria-hidden="true">*</sup>:</label>
                                        <input type="email" name="email" class="form-control" placeholder="shop@company.com" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{__('Telephone')}}<sup aria-hidden="true">*</sup>:</label>
                                        <input type="number" name="contact" class="form-control" placeholder="1234567890" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label> {{__('Subject:')}}</label>
                                        <input type="text" name="subject" class="form-control"  placeholder="Doe" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label> {{__('Description:')}}</label>
                                        <textarea  class="form-control" name="description" name="message" placeholder="How can we help?" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-8   col-12">
                                    <div class="checkbox-custom">
                                        <input type="checkbox" id="ch1">
                                        <label for="ch1">
                                            <span>{{__('I have read and agree to the')}} <a href="{{route('privacy_page',$slug)}}">{{__('Terms & Conditions.')}}</a>  </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <button class="common-btn2 submit-btn" type="submit">
                                        {{__('Send message')}}
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
    </div>
    <!---wrapper end here-->
@endsection

