
@extends('layouts.layouts')

@section('page-title')
{{ __('Faqs') }}
@endsection

@section('content')
<div class="wrapper">
    <section class="common-ptrn common-banner-section faq-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
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
                            <h2> <b> {{ __('Featured') }} </b> {{ __('asked questions') }} </h2>
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
                        <p><b> {{ __('TIP:') }} </b> {{ __('Type tags like #install, #setup') }} </p>
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
