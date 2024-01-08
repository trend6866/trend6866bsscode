@extends('layouts.layouts')

@section('page-title')
{{ __('FAQS Page') }}
@endsection

@section('content')

<div class="wrapper" style="margin-top: 121.594px;">
    <section class="faqs-pages-section common-banner-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="common-banner-content">
                        <a href="{{ route('landing_page',$slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                    <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765"></circle>
                                    <g clip-path="url(#clip0_318_284)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="white"></path>
                                    </g>
                                </svg>
                            </span>
                          {{__('Back to Home')}}
                        </a>
                        <div class="section-title">
                            <h2>{{ __('Featured asked questions') }} </h2>
                        </div>
                        <form class="faq-search-form">
                            <div class="input-wrapper">
                                <input type="text" placeholder="Search question">
                                <button type="submit" class="btn-subscibe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.97863e-08 9.99986C-7.09728e-06 10.4601 0.373083 10.8332 0.83332 10.8332L17.113 10.8335L15.1548 12.7358C14.8247 13.0565 14.817 13.584 15.1377 13.9142C15.4584 14.2443 15.986 14.2519 16.3161 13.9312L19.7474 10.5979C19.9089 10.441 20.0001 10.2254 20.0001 10.0002C20.0001 9.77496 19.9089 9.55935 19.7474 9.40244L16.3161 6.0691C15.986 5.74841 15.4584 5.75605 15.1377 6.08617C14.817 6.41628 14.8247 6.94387 15.1548 7.26456L17.1129 9.1668L0.833346 9.16654C0.373109 9.16653 7.24653e-06 9.53962 4.97863e-08 9.99986Z" fill="#183A40"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <p><b>{{ __('TIP') }}:</b> {{ __('Type tags like #install, #setup') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-page padding-top">
        @foreach ($faqs as $faq)
            <div class="container">
                <div class="section-title">
                    <h2>{{$faq->topic}}</h2>
                </div>

                <div class="faqs-container row">
                    @if ($faq->description)
                        @foreach (json_decode($faq->description, true) as $item)
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="set has-children">
                                    <a href="javascript:;" class="acnav-label">
                                        <span>{{$item['question']}}</span>
                                    </a>
                                    <div class="acnav-list">
                                        <p>{{$item['answer']}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </section>

</div>
@endsection
