@extends('layouts.layouts')
@section('page-title')
{{ __('Privacy Policy') }}
@endsection
@section('content')
    <!--wrapper start here-->
<div class="about-wrapper wrapper padding-bottom">
    @foreach ($pages_data as $page)
    <div class="privacy-policy-wrapper">
      <section class="top-bg-section" style="background-image: url({{ asset('themes/' . APP_THEME() . '/assets/images/about.png') }} ");>
         <div class=" container">
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
                    <div class="section-title">
                       <h2>{{$page->name}} </h2>
                       <p>{{$page->short_description}}</p>
                    </div>
                 </div>
              </div>
           </div>
        </section>
        <section class="policy-page cms-page padding-bottom padding-top">
            <div class="container">
                {!! html_entity_decode($page->content) !!}
            </div>
        </section>
    </div>
    @endforeach
    <!---wrapper end here-->
@endsection
