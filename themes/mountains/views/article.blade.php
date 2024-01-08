{{-- @extends('frontend.'.env('APP_THEME').'.layouts.layouts') --}}
@extends('layouts.layouts')

@section('page-title')
{{ __('Article page') }}
@endsection

@section('content')
<div class="wrapper" style="margin-top: 123.594px;">
@foreach ($blogs as $blog)
    @php
        $sub = explode(',',$blog->subcategory_id);
        $theme_json = $homepage_json;
    @endphp

    <section class="blog-page-banner article-banner common-banner-section" style="background-image:url({{ asset('themes/'. APP_THEME().'/assets/images/blog-page-banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-8 col-12">
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
                        <ul class="blog-cat">
                            <li class="active"><a href="#">{{ __('Featured') }}</a></li>
                            <li><b>{{ __('Category:') }}</b> {{$blog->MainCategory->name}}</li>
                            <li><b>{{ __('Date:') }} </b> {{$blog->created_at->format('d M, Y ')}}</li>
                        </ul>
                        <div class="section-title">
                            <h2>{!! $blog->title !!}</h2>
                        </div>
                        <p class="description">{!!$blog->short_description!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
    <section class="article-section padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="about-user d-flex align-items-center">
                        <div class="abt-user-img">
                            <img src="{{asset('themes/'.APP_THEME().'/assets/img/john.png')}}" />
                        </div>
                        <h6>
                            <span>John Doe,</span>
                            company.com
                        </h6>
                        <div class="post-lbl"><b>{{__('Category')}}:</b> {{$blog->MainCategory->name}}</div>
                        <div class="post-lbl"><b>Date:</b> {{$blog->created_at->format('d M, Y ')}}</div>
                    </div>

                </div>
                <div class="col-md-8 col-12">
                    <div class="aticleleftbar">

                        <p>
                            {!! $blog->content !!}
                        </p>

                        <div class="art-auther">
                            <b>{{ __('Tags:') }} </b> {{ $blog->MainCategory->name}}
                        </div>


                        @php
                            $homepage_footer_section6_sub_title = '';

                            $homepage_footer_key6 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_key6 != '') {
                                $homepage_footer_section6 = $theme_json[$homepage_footer_key6];

                            }

                        @endphp
                        <ul class="header-list-social">
                            @for($i=0 ; $i < $homepage_footer_section6['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section6['inner-list'] as $homepage_footer_section6_value)
                                    {

                                        if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_section6_sub_image = $homepage_footer_section6_value['field_default_text'];
                                        }
                                        if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                        $homepage_footer_section6_link = $homepage_footer_section6_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section6[$homepage_footer_section6_value['field_slug']]))
                                        {
                                            if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon'){
                                            $homepage_footer_section6_sub_image = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_footer_section6_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                            $homepage_footer_section6_link = $homepage_footer_section6[$homepage_footer_section6_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                    <li>
                                        <a href="{{$homepage_footer_section6_link}}" target="_blank">
                                            <img src="{{get_file($homepage_footer_section6_sub_image , APP_THEME())}}" alt="">

                                        </a>
                                    </li>

                            @endfor
                        </ul>


                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="articlerightbar">
                        <div class="section-title">
                            <h3>{{ __('Related articles') }}</h3>
                        </div>
                            @foreach ($datas as $data)
                            @php
                                $b_id = hashidsencode($data->id);
                            @endphp
                        <div class="row blog-grid">

                            <div class="col-md-12 col-sm-6 col-12 blog-widget">
                                <div class="blog-card">
                                    <div class="blog-card-image">
                                        <a href="{{route('page.article',[$slug,$b_id])}}">
                                            <img src="{{get_file($data->cover_image_path,APP_THEME())}}" class="default-img" />
                                        </a>
                                    </div>
                                    <div class="blog-card-content">
                                        <span>{{ __('ARTICLES') }}</span>
                                        <h3>

                                            <a href="{{route('page.article',[$slug,$b_id])}}">
                                              {{$data->title}}
                                            </a>
                                        </h3>
                                        <p>
                                            {{$data->short_description}}
                                        </p>
                                        <div class="blog-card-bottom">
                                            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn"> {{ __('Read More') }} </a>
                                            <span class="date">
                                                {{$data->created_at->format('d M, Y ')}}<br />
                                                <a href="#"> @john </a>
                                            </span>
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
    </section>
@endforeach

@endsection
