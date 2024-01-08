
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
        $sub = explode(',',$blog->subcategory_id);
    @endphp
        <section class="blog-page-banner article-banner common-banner-section" style="background-image:url({{ asset('themes/' . APP_THEME() . '/assets/images/blog-page-banner.jpg')}});">
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
                                {{__('Back to Home')}}
                            </a>
                            <ul class="blog-cat justify-content-center">
                                <li class="active"><a href="#">{{__('Featured')}}</a></li>
                                <li><a href="#"><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</a></li>
                                <li><a href="#"><b>{{__('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</a></li>
                            </ul>
                            <div class="section-title text-center">
                                <h2>{{$blog->title}}</h2>
                            </div>
                            <p>{{$blog->short_description}}</p>
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
                                <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/john.png')}}">
                            </div>
                            <h6>
                                <span>{{__('John Doe,')}}</span>
                                 {{__('company.com')}}
                            </h6>
                            <div class="post-lbl"><b> {{ __('Category:')}} </b> {{$blog->MainCategory->name}}</div>
                            <div class="post-lbl"><b> {{ __('Date:')}} </b> {{$blog->created_at->format('d M, Y ')}}</div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="aticleleftbar">
                            {!! html_entity_decode($blog->content) !!}
                            <div class="art-auther"><b> {{ __('Tags:')}} </b>{{$blog->MainCategory->name}}</div>
                            @php
                                $homepage_footer4 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer4 != '')
                                {
                                    $home_footer4 = $theme_json[$homepage_footer4];
                                    $section_enable4 = $home_footer4['section_enable'];
                                    foreach ($home_footer4['inner-list'] as $key => $value) {
                                        if($value['field_slug'] == 'homepage-footer-title-text') {
                                            $home_footer_title4 = $value['field_default_text'];
                                        }
                                        if($value['field_slug'] == 'homepage-footer-enable') {
                                            $home_footer_enable4 = $value['field_default_text'];
                                        }
                                    }
                                }
                            @endphp
                            @if($home_footer_enable4 == 'on')
                                <ul class="article-socials d-flex align-items-center">
                                    <li><span>{!! $home_footer_title4 !!}</span></li>
                                    @php
                                        $homepage_footer_key5 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer_key5 != '') {
                                            $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                                        }
                                    @endphp
                                    @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                                        @php
                                            foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                                            {
                                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon') {
                                                    $homepage_footer_section5_icon = $homepage_footer_section5_value['field_default_text'];
                                                }
                                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                    $homepage_footer_section5_social_link = $homepage_footer_section5_value['field_default_text'];
                                                }

                                                if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                                {
                                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon'){
                                                        $homepage_footer_section5_icon = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i]['field_prev_text'];
                                                    }
                                                    if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                                        $homepage_footer_section5_social_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                                    }
                                                }
                                            }
                                        @endphp
                                        <li>
                                            <a href="{{$homepage_footer_section5_social_link}}">
                                                <img src="{{get_file($homepage_footer_section5_icon , APP_THEME())}}" alt="youtube">
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12 blog-section blog-itm">
                        <div class="articlerightbar">
                            @foreach ($datas->take(2) as $data)
                                @php
                                    $b_id = hashidsencode($data->id);
                                @endphp
                                <div class="blog-card-itm">
                                    <div class="blog-card-itm-inner">
                                        <div class="blog-card-image">
                                            <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                                <img src="{{get_file($data->cover_image_path , APP_THEME())}}   " class="default-img">
                                            </a>
                                            <div class="tip-lable">
                                                <span>{{$blog->MainCategory->name}}</span>
                                            </div>
                                        </div>
                                        <div class="blog-card-content">
                                            <div class="blog-card-heading-detail">
                                                <span>{{$blog->created_at->format('d M,Y ')}}  / John Doe</span>
                                            </div>
                                            <h4>
                                                <a class="title" href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                                    {{$data->title}}
                                                </a>
                                            </h4>
                                            <p class="description">{{$data->short_description}}</p>
                                            <div class="blog-card-bottom">
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn" tabindex="0">
                                                    {{__('Read More')}}
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
        <section class="blog-section article-page padding-top padding-bottom">
            <div class="container">
                <div class="section-title">
                    <h2>
                        {{__('From our blog')}}
                    </h2>
                </div>
                <div class="about-card-slider">
                    {!! \App\Models\Blog::HomePageBlog($slug ,$no=10) !!}
                </div>
            </div>
        </section>
@endforeach

@endsection
