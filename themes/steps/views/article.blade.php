@extends('layouts.layouts')
@section('page-title')
{{ __('Article') }}
@endsection
@php
            $theme_json = $homepage_json;

@endphp
@section('content')
@foreach ($blogs as $blog)
@php
    $theme_json = $homepage_json;
    $sub = explode(',',$blog->subcategory_id);
@endphp
    <section class="blog-page-banner article-banner common-banner-section" style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-12">
                    <div class="common-banner-content text-center">
                        <a href="{{route('landing_page',$slug)}}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z" fill="white"></path>
                                </svg>
                            </span>
                            {{ __('Back to Home')}}
                        </a>
                        <ul class="blog-cat justify-content-center">
                            <li class="active">{{ __('Featured')}}</li>
                            <li><b>{{ __('Category:')}}</b> {{$blog->MainCategory->name}}</li>
                            <li><b>{{ __('Date:')}}</b> {{$blog->created_at->format('d M, Y ')}}</li>
                        </ul>
                        <div class="section-title text-center">
                            <h2>{{$blog->title}}</h2>
                        </div>
                        <p>{{$blog->description}}</p>
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
                            <img src="{{ asset('themes/'.APP_THEME().'/assets/images/john.png') }}">
                        </div>
                        <h3>
                            <span>{{ __('John Doe,')}}</span>
                             {{ __('company.com')}}
                        </h3>
                        <div class="post-lbl"><b>{{ __('Category:')}}</b>{{$blog->MainCategory->name}}</div>
                        <div class="post-lbl"><b>{{ __('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</div>
                    </div>


                </div>
                <div class="col-md-8 col-12">
                    <div class="aticleleftbar">
                        {{-- <h4>{{$blog->description}}</h4> --}}
                        {{-- <img src="{{asset($blog->cover_image_url)}} " alt="article"> --}}
                        {{-- <div class="art-auther"><b>{{ __('John Doe')}}</b>, <a href="company.com">{{ __('company.com')}}</a></div> --}}
                        <p>{!! html_entity_decode($blog->content) !!} </p>

                        <div class="art-auther"><b>{{__('Tags:')}}</b>  @foreach ($sub as $k)
                            {{$blog->getSubId($k)}}
                         @endforeach</div>
                        <ul class="article-socials d-flex align-items-center">
                            @php
                            $homepage_footer_social_icon = $homepage_footer_social_link='';

                            $homepage_footer_key3 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_key3 != '') {
                                $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                            }

                        @endphp
                        @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                        @php
                                foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                {

                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_social_icon = $homepage_footer_section3_value['field_default_text'];
                                    }

                                    if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                    {
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                            $homepage_footer_social_icon = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                        }
                                    }
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link') {
                                        $homepage_footer_social_link = $homepage_footer_section3_value['field_default_text'];
                                    }

                                    if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                    {
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-link'){
                                            $homepage_footer_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                        }
                                        // dd($homepage_footer_social_link);
                                    }
                                }
                            @endphp
                            @if($homepage_footer_section3['section_enable'] == 'on')
                                <li>
                                    <a href="{!! $homepage_footer_social_link !!}" >
                                        <img src=" {{ get_file($homepage_footer_social_icon, APP_THEME()) }}">
                                    </a>
                                </li>
                            @endif
                        @endfor

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="articlerightbar">
                        <div class="section-title">
                            <h3>{{__('Related articles')}}</h3>
                        </div>
                        <div class="blog-widget">
                            @foreach ($datas as $data)
                            @php
                                $b_id = hashidsencode($data->id);
                            @endphp
                            <div class="blog-widget-inner big-blog-widget">
                                    <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="">
                                    <div class="blog-widget-content">
                                        <ul class="blog-cat">
                                            <li class="active">{{__('Featured')}}</li>
                                            <li><b>{{__('Category:')}}</b> {{$data->MainCategory->name}}</li>
                                            <li><b>{{__('Date')}}</b> {{$data->created_at->format('d M, Y ')}}</li>
                                        </ul>
                                        <h3><a href="{{route('page.article',[$slug,$b_id])}}" class="name">{{$data->title}}</b></a></h3>
                                        <p>{{$data->short_description}}</p>
                                        <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary white-btn">
                                            <span class="btn-txt">{{__('Read More')}}</span>
                                            <span class="btn-ic">
                                                <svg viewBox="0 0 10 5">
                                                    <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        <div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="our-blog-section  padding-bottom related-blogs">
        <div class="container">
            <div class="section-title padding-top d-flex align-items-center justify-content-between">
                @php
                $homepage_blog_title = $homepage_blog_heading = $homepage_blog_button = '';
                $homepage_blog_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_blog_key != '') {
                    $homepage_blog = $theme_json[$homepage_blog_key];
                    foreach ($homepage_blog['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-title') {
                            $homepage_blog_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-sub-title') {
                            $homepage_blog_heading = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-button') {
                            $homepage_blog_button = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            {{-- @if ($homepage_blog['section_enable'] == 'on') --}}
                <div class="section-title-left">
                    <div class="subtitle">{!! $homepage_blog_title !!}</div>
                    {!! $homepage_blog_heading !!}
                </div>
                <a href="{{route('page.blog',$slug)}}" class="btn-secondary ">
                    <span class="btn-txt">{!! $homepage_blog_button !!}</span>
                    <span class="btn-ic">
                        <svg viewBox="0 0 10 5">
                            <path
                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </span>
                </a>
            {{-- @endif
                --}}
            </div>
            <div class="our-blogs-slider common-arrow ">
                @foreach ($l_articles as $article)

                <div class="our-blog-itm">
                    <div class="our-blog-itm-inner">
                        @php
                            $a_id = hashidsencode($article->id);
                        @endphp
                            <div class="our-blog-img">
                                <a href="{{route('page.article',[$slug,$a_id])}}" class="blog-img">
                                    <img src="{{get_file($article->cover_image_path , APP_THEME())}} ">
                                </a>
                                <a href="{{route('page.article',[$slug,$a_id])}}" class="btn article-btn">Article</a>
                            </div>
                            <div class="our-blog-content">
                                <div class="our-blog-content-top">
                                    <div class="date-blg">
                                        {{$article->created_at->format('d M, Y ')}}
                                    </div>
                                    <h3><a href="{{route('page.article',[$slug,$a_id])}}" class ="name">{{$article->title}}</a></h3>
                                    <p>{{$article->short_description}}</p>
                                </div>
                                <div class="our-blog-content-bottom">
                                    <div class="our-blog-contnt-btm-row d-flex align-items-center justify-content-between">
                                        <h4>{{__('John Due')}}</h4>
                                        <a href="{{route('page.article',[$slug,$a_id])}}" class="btn-secondary">
                                            <span class="btn-txt"> {{__('READ MORE')}}</span>
                                            <span class="btn-ic">
                                                <svg viewBox="0 0 10 5">
                                                    <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @endforeach

    @endsection
