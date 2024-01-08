@extends('layouts.layouts')

@section('page-title')
{{ __('Article') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
    @foreach ($blogs as $blog)
    <div class="wrapper">
        <section class="blog-page-banner article-banner common-banner-section" style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg')}});">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-xl-6 col-md-8 col-12">
                        <div class="common-banner-content">
                            <a href="{{route('landing_page',$slug)}}" class="back-btn">
                                <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z"
                                            fill="white"></path>
                                    </svg>
                                </span>
                                {{ __('Back to Home')}}
                            </a>
                            <ul class="blog-cat justify-content-center">
                                <li class="active"><a href="#">{{__('Featured')}}</a></li>
                                <li><b> {{__('Category')}}: </b> {{ $blog->MainCategory->name }}</li>
                                <li><b>{{__('Date')}}:</b> {{ $blog->created_at->format('d M,Y ') }}</li>
                            </ul>
                            <div class="section-title text-center">
                                <h2>{!! $blog->title !!}</h2>
                            </div>
                            <div class="about-user d-flex align-items-center justify-content-center">
                                <div class="abt-user-img">
                                    <img src="{{asset('themes/'.APP_THEME().'/assets/images/john.png')}}">
                                </div>
                                <h6>
                                    <span>John Doe,</span>
                                    company.com
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="article-section padding-bottom padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="about-user d-flex align-items-center">
                            <div class="abt-user-img">
                                <img src="{{asset('themes/'.APP_THEME().'/assets/images/john.png')}}">
                            </div>
                            <h6>
                                <span>John Doe,</span>
                                 company.com
                            </h6>
                            <div class="post-lbl"><b>{{__('Category')}}:</b>{{$blog->MainCategory->name}}</div>
                            <div class="post-lbl"><b>{{__('Date')}}:</b>{{$blog->created_at->format('d M, Y ')}}</div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="aticleleftbar">

                            {!! html_entity_decode($blog->content) !!}

                            <div class="art-auther"><b>{{__('Tags:')}}</b> {{$blog->MainCategory->name}} </div>

                            <ul class="article-socials d-flex align-items-center">
                                @php
                                    $homepage_footer = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer != '')
                                    {
                                        $home_footer = $theme_json[$homepage_footer];
                                        foreach ($home_footer['inner-list'] as $key => $value) {
                                            if($value['field_slug'] == 'homepage-footer-label') {
                                                $footer_text = $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <li><span>{{$footer_text}} :</span></li>
                                @php
                                    $homepage_footer_key3 = array_search('homepage-footer-9', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key3 != '') {
                                        $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                    }
                                @endphp
                                @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                    {
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                            $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                        }
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                            $homepage_footer_section3_url = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];

                                            }
                                        }
                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                                $homepage_footer_section3_url = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{{$homepage_footer_section3_url}}" target="_blank">
                                        <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="" style="margin-bottom: 0px;">
                                    </a>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="articlerightbar">
                            <div class="section-title">
                                <h2>{{__('Related articles')}}</h2>
                            </div>
                            <div class="row blog-grid">
                            @foreach ($datas as $data)
                            @php
                                $b_id = hashidsencode($data->id);
                            @endphp

                                <div class="col-md-12 col-sm-6 col-12 blog-widget">
                                    <div class="blog-widget-inner">
                                        <div class="blog-media">
                                            <span class="badge">{{$data->MainCategory->name}}</span>
                                            <a href="{{route('page.article',[$slug,$b_id])}}">
                                                <img src="{{get_file($data->cover_image_path , APP_THEME())}}">
                                            </a>
                                        </div>
                                        <div class="blog-caption">
                                            <h3><a href="{{route('page.article',[$slug,$b_id])}}" class="short_description">{{$data->title}}</a></h3>
                                            <p class="description">{!!$data->short_description!!}</p>
                                            <div class="blog-lbl-row d-flex align-items-center justify-content-between">
                                                <a class="btn blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                                                    {{__('Read More')}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="3" height="6"
                                                        viewBox="0 0 3 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.15976 0.662719C-0.0532536 0.879677 -0.0532536 1.23143 0.15976 1.44839L1.68316 3L0.15976 4.55161C-0.0532533 4.76856 -0.0532532 5.12032 0.15976 5.33728C0.372773 5.55424 0.718136 5.55424 0.931149 5.33728L2.84024 3.39284C3.05325 3.17588 3.05325 2.82412 2.84024 2.60716L0.931149 0.662719C0.718136 0.445761 0.372773 0.445761 0.15976 0.662719Z"
                                                            fill="white"></path>
                                                    </svg>
                                                </a>
                                                <div class="author-info">
                                                    <strong class="auth-name">John Doe,</strong>
                                                    <span class="date">{{$blog->created_at->format('d M,Y ')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="latest-article-slider-section padding-bottom">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-article', array_column($theme_json, 'unique_section_slug'));
                    if ($homepage_header_1_key != '') {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if ($value['field_slug'] == 'homepage-article-title') {
                                $article_title = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if ($homepage_header_1['section_enable'] == 'on')
                <div class="section-title">
                    <h2>{!! $article_title !!}</h2>
                </div>
                @endif
                <div class="latest-article-slider blog-grid common-arrows">
                    @foreach ($l_articles as $blog)
                        @php
                            $b_id = hashidsencode($blog->id);
                        @endphp
                        <div class="blog-widget">
                            <div class="blog-widget-inner">
                                <div class="blog-media">
                                    <span class="badge">{{$blog->MainCategory->name}}</span>
                                    <a href="{{route('page.article',[$slug,$b_id])}}">
                                        <img src="{{get_file($blog->cover_image_path , APP_THEME())}}">
                                    </a>
                                </div>
                                <div class="blog-caption">
                                    <h3> <a href="{{route('page.article',[$slug,$b_id])}}" class="short_description">{{$blog->title}}</a></h3>
                                    <p class="descriptions">{!!$blog->short_description!!}</p>
                                    <div class="blog-lbl-row d-flex align-items-center justify-content-between">
                                        <a class="btn blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                                            {{__('Read More')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="3" height="6" viewBox="0 0 3 6"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.15976 0.662719C-0.0532536 0.879677 -0.0532536 1.23143 0.15976 1.44839L1.68316 3L0.15976 4.55161C-0.0532533 4.76856 -0.0532532 5.12032 0.15976 5.33728C0.372773 5.55424 0.718136 5.55424 0.931149 5.33728L2.84024 3.39284C3.05325 3.17588 3.05325 2.82412 2.84024 2.60716L0.931149 0.662719C0.718136 0.445761 0.372773 0.445761 0.15976 0.662719Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <div class="author-info">
                                            <strong class="auth-name">John Doe,</strong>
                                            <span class="date">{{$blog->created_at->format('d M,Y ')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>
    @endforeach
@endsection
