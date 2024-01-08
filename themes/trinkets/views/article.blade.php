@extends('layouts.layouts')

@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
{{ __('Article page') }}
@endsection

@section('content')
    @foreach ($blogs as $blog)
        <!--wrapper start here-->
        <div class="wrapper">
            <section class="blog-page-banner common-banner-section" style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg')}});">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="common-banner-content">
                                <ul class="blog-cat">
                                    <li class="active">{{__('Featured')}}</li>
                                    <li><b> {{__('Category')}}: </b> {{ $blog->MainCategory->name }}</li>
                                    <li><b>{{__('Date')}}:</b> {{ $blog->created_at->format('d M,Y ') }}</li>
                                </ul>
                                <div class="section-title">
                                    <h2>{!! $blog->title !!}</h2>
                                </div>
                                <p class="description">{!!$blog->short_description!!}</p>
                                <a href="#" class="btn-secondary white-btn">
                                    <span class="btn-txt">{{__('READ MORE')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="article-section padding-top">
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
                            {{-- <div class="section-title">
                                <h2>{!! $blog->title !!}</h2>
                            </div> --}}
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="aticleleftbar">
                                {{-- <h5>{!! $blog->short_description !!}</p> --}}
                                {{-- <div class="art-auther"><b>John Doe</b>, <a href="company.com">company.com</a></div> --}}
                                <p>{!! html_entity_decode($blog->content) !!}</p>
                                <div class="art-auther"><b>{{ __('Tags:')}}</b>{{$blog->MainCategory->name}}</div>
                                    @php
                                        $homepage_text = '';
                                        $homepage_logo_key = array_search('home-social-links-1', array_column($theme_json,'unique_section_slug'));
                                        $section_enable = 'on';
                                        if($homepage_logo_key != ''){
                                            $homepage_main_logo = $theme_json[$homepage_logo_key];
                                            $section_enable = $homepage_main_logo['section_enable'];
                                        }
                                    @endphp
                                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                    @php
                                        if($homepage_main_logo_value['field_slug'] == 'home-social-links-1-title')
                                        {
                                            $social_text = $homepage_main_logo_value['field_default_text'];
                                            if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                $social_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                            }
                                        }
                                    @endphp
                                    @endforeach
                                    <span>{{ $social_text }}:</span>
                                    <ul class="article-socials d-flex align-items-center">
                                        @php
                                            $homepage_text = '';
                                            $homepage_logo_key = array_search('home-social-links-2', array_column($theme_json,'unique_section_slug'));
                                            $section_enable = 'on';
                                            if($homepage_logo_key != ''){
                                                $homepage_main_logo = $theme_json[$homepage_logo_key];
                                                $section_enable = $homepage_main_logo['section_enable'];
                                            }
                                            @endphp
                                        @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                                            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                                                @php
                                                    if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-contact-image')
                                                    {
                                                        $social_icon = $homepage_main_logo_value['field_default_text'];
                                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                            $social_icon = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                                        }
                                                    }
                                                    if($homepage_main_logo_value['field_slug'] == 'home-social-links-2-url')
                                                    {
                                                        $social_link = $homepage_main_logo_value['field_default_text'];
                                                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                                            $social_link = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                                        }
                                                    }
                                                @endphp
                                            @endforeach
                                            <li>
                                                <a href="{{ $social_link }}" target="_blank">
                                                    <img src="{{ get_file($social_icon, APP_THEME()) }}" alt="twitter" style="margin-bottom: 0px;">
                                                </a>
                                            </li>
                                        @endfor
                                    </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="articlerightbar blog-grid-section">
                                <div class="section-title">
                                    <h3>{{ __('Related articles')}}</h3>
                                </div>
                                <div class="row blog-grid">
                                    @foreach($datas as $blog)
                                    @php
                                        $b_id = hashidsencode($blog->id);
                                    @endphp
                                    <div class="col-md-12 col-sm-6 col-12 blog-widget">
                                        <div class="blog-card  blog-itm">
                                            <div class="blog-card-inner">
                                                <div class="blog-top">
                                                    <span class="badge">{{ __('ARTICLES')}}</span>
                                                    <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wrapper">
                                                        <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                                                    </a>
                                                </div>
                                                <div class="blog-caption">
                                                    <div class="author-info">
                                                        <span class="date">{{ $blog->created_at->format('d M,Y ') }}</span>
                                                        <span class="auth-name">{{ $blog->name }}</span>
                                                    </div>
                                                    <h4><a href="{{route('page.article',[$slug,$b_id])}}">{!! $blog->title !!}</a></h4>
                                                    <p>{{$blog->short_description}}</p>
                                                        <a class="btn blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                                                            {{__('Read more')}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z" fill="white"></path>
                                                            </svg>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="home-blog-section blog-page">
                <div class="container">
                    <div class="sectoion-title">
                        <h2></h2>
                    </div>
                    <div class=" blog-slider-main-blog-page flex-slider">
                        @foreach ($l_articles as $blog)
                        @php
                            $b_id = hashidsencode($blog->id);
                        @endphp
                        <div class="blog-card card">
                            <div class="blog-card-inner card-inner">
                                <div class="blog-top">
                                    <span class="badge">{{$blog->MainCategory->name}}</span>
                                    <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wrapper">
                                        <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                                    </a>
                                </div>
                                <div class="blog-caption">
                                    <div class="author-info">
                                        <span class="date">{{ $blog->created_at->format('d M,Y ') }}</span>
                                        <span class="auth-name" >{{ $blog->name }}</span>
                                    </div>
                                    <h4><a href="{{route('page.article',[$slug,$b_id])}}">{!! $blog->title !!}</a></h4>
                                    <p class="description">{{$blog->short_description}}</p>
                                        <a class="btn blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                                            {{ __('Read more')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z" fill="white"></path>
                                            </svg>
                                        </a>
                                </div>

                            </div>
                        </div>
                       @endforeach
                    </div>
                </div>
            </section>
        </div>
        <!---wrapper end here-->
    @endforeach
@endsection
