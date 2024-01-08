@extends('layouts.layouts')

@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
{{ __('Article') }}
@endsection

@section('content')

<div class="wrapper">
    @foreach ($blogs as $blog)
        <section class="blog-page-banner common-banner-section" style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.png')}});">
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
                            {!! html_entity_decode($blog->content) !!}

                            <div class="art-auther"><b>John Doe</b>, <a href="company.com">company.com</a></div>

                            <div class="art-auther"><b>{{ __('Tags:')}}</b> {{$blog->MainCategory->name}}</div>

                            <ul class="article-socials d-flex align-items-center">
                                @php
                                    $homepage_footer = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer != '')
                                    {
                                        $home_footer = $theme_json[$homepage_footer];
                                        $section_enable = $home_footer['section_enable'];
                                        foreach ($home_footer['inner-list'] as $key => $value) {
                                            if($value['field_slug'] == 'homepage-footer-title-text') {
                                                $footer_text = $value['field_default_text'];
                                            }
                                            if($value['field_slug'] == 'homepage-footer-label') {
                                                $home_footer_checkbox= $value['field_default_text'];
                                            }
                                        }
                                    }
                                @endphp
                                {{-- @if($home_footer_checkbox == 'on') --}}
                                    <li><span>{{$footer_text}}</span></li>
                                    @php
                                        $homepage_footer_key3 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
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
                                                <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="" style="margin-bottom: inherit;">
                                            </a>
                                        </li>
                                    @endfor
                                {{-- @endif --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="articlerightbar blog-grid-section">
                            <div class="section-title">
                                <h3>{{__('Related articles')}}</h3>
                            </div>
                            @foreach ($datas as $blog)
                            <div class="blog-card">
                                @php
                                    $b_id = hashidsencode($blog->id);
                                @endphp
                                <div class="blog-card-inner">
                                    <div class="blog-card-image">
                                    <span class="label">Articles</span>
                                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                        <img src="{{get_file($blog->cover_image_path , APP_THEME())}}">
                                    </a>
                                    </div>
                                    <div class="blog-card-content">
                                    <h3>
                                        <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">{{$blog->title}}
                                        </a>
                                    </h3>
                                    <p class="descriptions">{{$blog->short_description}}</p>
                                    <div class="blog-card-author-name">
                                        <span>@johndoe</span>
                                        <span>{{$blog->created_at->format('d M,Y ')}}</span>
                                    </div>
                                    <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                                        {{ __('READ MORE')}}
                                    </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog-grid-section padding-top padding-bottom tabs-wrapper">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('homepage-blog-1', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-blog-title') {
                                $blog_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-blog-title-text-1') {
                                $blog_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-blog-btn-text') {
                                $blog_btn_text = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="section-title d-flex justify-content-between align-items-end">
                    <div>
                        <div class="subtitle">{{$blog_title}}</div>
                        <h2>{{$blog_text}} </h2>
                    </div>
                    <a href="{{route('page.blog',$slug)}}" class="btn">
                        {{$blog_btn_text}}
                    </a>
                </div>
                @endif
                {!! \App\Models\Blog::ArticlePageBlog($slug) !!}
            </div>
        </section>
    @endforeach
</div>

@endsection

