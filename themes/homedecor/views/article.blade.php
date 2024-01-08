
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
        <div class="wrapper">
            <section class="blog-page-banner common-banner-section" style="background-image:url({{ asset('themes/' . APP_THEME() . '/assets/images/blog-banner.jpg')}});">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="common-banner-content">
                                <ul class="blog-cat">
                                    <li class="active"><a href="#">{{__('Featured')}}</a></li>
                                    <li><a href="#"><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</a></li>
                                    <li><a href="#"><b>{{__('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</a></li>
                                </ul>
                                <div class="section-title">
                                    <h2>{{$blog->title}}</h2>
                                </div>
                                <p>{{$blog->short_description}}</p>
                                <a href="#" class="btn ">
                                    <span class="btn-txt">{{__('Read MORE')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="article-section padding-top padding-bottom">
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
                            {{-- <div class="section-title">
                                <h2>Article title first with light weight</h2>
                            </div> --}}
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="aticleleftbar">
                                {!! html_entity_decode($blog->content) !!}
                                {{-- <div class="article-banner-img">
                                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="article">
                                </div> --}}
                                <div class="art-auther"><b> {{ __('Tags:')}} </b>{{$blog->MainCategory->name}}</div>
                                @php
                                    $homepage_footer_key7 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key7 != '') {
                                        $homepage_footer_section7 = $theme_json[$homepage_footer_key7];

                                    }
                                @endphp
                                <ul class="article-socials d-flex align-items-center">
                                    <li><span>{{ __('Share:')}}</span></li>
                                    @for($i=0 ; $i < $homepage_footer_section7['loop_number'];$i++)
                                    @php
                                        foreach ($homepage_footer_section7['inner-list'] as $homepage_footer_section7_value)
                                        {
                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                                $homepage_footer_section7_sub_title = $homepage_footer_section7_value['field_default_text'];
                                            }
                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                $homepage_footer_section7_social_link = $homepage_footer_section7_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']]))
                                            {
                                                if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon'){
                                                    $homepage_footer_section7_sub_title = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i]['field_prev_text'];
                                                }
                                                if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                                    $homepage_footer_section7_social_link = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    @if($homepage_footer_section7['section_enable'] == 'on')
                                    <li> <a href="{{$homepage_footer_section7_social_link}}" target="_blank">
                                        <img src="{{get_file($homepage_footer_section7_sub_title , APP_THEME())}}">
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
                                    <h3>{{ __('Related articles')}}</h3>
                                </div>
                                @foreach ($datas->take(2) as $data)
                                    @php
                                        $b_id = hashidsencode($data->id);
                                    @endphp
                                    <div class="blog-itm">
                                        <div class="blog-widget-inner">
                                            <div class="blog-media">
                                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                                    <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="blog">
                                                </a>
                                            </div>
                                            <div class="blog-caption">
                                                <div class="blog-lbl-row d-flex justify-content-between">
                                                    <div class="blog-labl">
                                                        {{$blog->MainCategory->name}}
                                                    </div>
                                                    <div class="blog-labl">
                                                        {{$blog->created_at->format('d M,Y ')}}
                                                    </div>
                                                </div>
                                                <h4>
                                                    <a href="{{route('page.article',[$slug,$b_id])}}">{{$data->title}}</a>
                                                </h4>
                                                <p>{{$data->short_description}}</p>
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="link-btn dark-link-btn" tabindex="0">
                                                    {{__('Show More')}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                                                    </svg>
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
            @php
                $homepage_blog_section_title = $homepage_blog_section_btn_text  = '';

                $homepage_blog_section_key1 = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if($homepage_blog_section_key1 != '') {
                    $homepage_blog_section = $theme_json[$homepage_blog_section_key1];

                foreach ($homepage_blog_section['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-blog-title-text') {
                    $homepage_blog_section_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-btn-text') {
                    $homepage_blog_section_btn_text = $value['field_default_text'];
                    }
                }
                }
            @endphp
            @if($homepage_blog_section['section_enable'] == 'on')
                <section class="blog-section">
                    <div class="container">
                        <div class="section-title d-flex align-items-center justify-content-between">
                            <h2>{!! $homepage_blog_section_title !!}</h2>
                            <a href="{{route('page.product-list',$slug)}}" class="btn-secondary btn-secondary-theme-color m-0 w-100" tabindex="0">
                                {!! $homepage_blog_section_btn_text !!}
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
                                </svg>
                            </a>
                        </div>
                        <div class="row">
                            {!! \App\Models\Blog::HomePageBlog($slug ,$no = 3) !!}
                        </div>
                    </div>
                </section>
            @endif
        </div>
    @endforeach

@endsection
