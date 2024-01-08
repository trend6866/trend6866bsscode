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
                            <h3>
                                <span>John Doe,</span>
                                 company.com
                            </h3>
                            <div class="post-lbl"><b>{{__('Category')}}:</b>{{$blog->MainCategory->name}}</div>
                            <div class="post-lbl"><b>{{__('Date')}}:</b>{{$blog->created_at->format('d M, Y ')}}</div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="aticleleftbar">
                            <p>{!! html_entity_decode($blog->content) !!}</p>

                            <div class="art-auther"><b>{{__('Tags:')}}</b> {{$blog->MainCategory->name}} </div>

                            <ul class="article-socials d-flex align-items-center">
                                @php
                                    $homepage_footer = array_search('homepage-article-1', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer != '')
                                    {
                                        $home_footer = $theme_json[$homepage_footer];
                                        $section_enable = $home_footer['section_enable'];
                                        foreach ($home_footer['inner-list'] as $key => $value) {
                                            if($value['field_slug'] == 'homepage-article-1-label') {
                                                $footer_text = $value['field_default_text'];
                                            }
                                            if($value['field_slug'] == 'homepage-article-1-enable') {
                                                $home_artical_checkbox= $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                <li><span>{{$footer_text}} :</span></li>
                                @php
                                    $homepage_footer_key3 = array_search('homepage-article-2', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key3 != '') {
                                        $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                                    }
                                @endphp
                                @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                                    {

                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-article-social-icon') {
                                            $homepage_footer_section3_sub_title = $homepage_footer_section3_value['field_default_text'];
                                        }
                                        if($homepage_footer_section3_value['field_slug'] == 'homepage-article-social-label-link') {
                                            $homepage_footer_section3_url = $homepage_footer_section3_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-article-social-icon'){
                                                $homepage_footer_section3_sub_title = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];

                                            }
                                        }
                                        if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                        {
                                            if($homepage_footer_section3_value['field_slug'] == 'homepage-article-social-label-link'){
                                                $homepage_footer_section3_url = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];

                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{{$homepage_footer_section3_url}}" target="_blank">
                                        <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="" style="margin-bottom: inherit; width:60%;">
                                    </a>
                                </li>

                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="articlerightbar">
                            <div class="section-title">
                                <h3>{{__('Related articles')}}</h3>
                            </div>
                            @foreach ($datas->take(2) as $data)
                            @php
                                $b_id = hashidsencode($data->id);
                            @endphp
                            <div class="blog-itm">
                                <div class="blog-itm-inner">
                                    <div class="blog-img">
                                        <a href="{{route('page.article',[$slug,$b_id])}}">
                                            <img src="{{get_file($data->cover_image_path , APP_THEME())}}">
                                        </a>
                                        <span class="blg-lbl">{{__('ACCESSORIES')}}</span>
                                    </div>
                                    <div class="blog-caption">
                                        <h4> <a href="{{route('page.article',[$slug,$b_id])}}">{{$data->title}}</a></h4>
                                        <p>{!!$data->short_description!!}</p>
                                        <div class="blog-lbl-row d-flex">
                                            <div class="blog-labl">
                                                @John
                                            </div>
                                            <div class="blog-labl">
                                                {{$blog->created_at->format('d M,Y ')}}
                                            </div>
                                        </div>
                                        <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">{{__('Read More')}}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-blog-section padding-top">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-blog-label') {
                                $home_label = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-blog-title-text') {
                                $home_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                {{-- @if($homepage_header_1['section_enable'] == 'on') --}}
                <div class="section-title">
                    <div class="subtitle">{{$home_label}}</div>
                    <h2>{{$home_text}}</h2>
                </div>
                {{-- @endif --}}

                <div class="home-blog-slider white-dots">
                    @foreach ($l_articles as $blog)
                    @php
                        $b_id = hashidsencode($blog->id);
                    @endphp
                    <div class="blog-itm">
                        <div class="blog-itm-inner">
                            <div class="blog-img">
                                <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wrapper">
                                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                                </a>
                                <span class="blg-lbl">{{$blog->MainCategory->name}}</span>
                            </div>
                            <div class="blog-caption">
                                <h3><a href="{{route('page.article',[$slug,$b_id])}}" class="description">{!! $blog->title !!}</a></h3>
                                <p class="descriptions">{!! $blog->short_description !!}</p>
                                <div class="blog-lbl-row d-flex">
                                    <div class="blog-labl">
                                        @John
                                    </div>
                                    <div class="blog-labl">
                                    {{ $blog->created_at->format('d M,Y ') }}
                                    </div>
                                </div>
                                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">{{ __('Read more')}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
