@extends('layouts.layouts')

@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
{{ __('Article page') }}
@endsection

@section('content')
    @foreach ($blogs as $blog)
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
                                <a href="" class="btn">
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
                            <div class="section-title">
                                <h2>{!! $blog->title !!}</h2>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="aticleleftbar">
                                
                                <p> {!! $blog->content !!}</p>


                                <div class="art-auther"><b>John Doe</b>, <a href="company.com">company.com</a></div>
                                <div class="art-auther"><b>{{__('Tags:')}}</b> {{$blog->MainCategory->name}} </div>

                                <ul class="article-socials d-flex align-items-center">

                                    @php
                                        $homepage_footer = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                                        if($homepage_footer != '')
                                        {
                                            $home_footer = $theme_json[$homepage_footer];
                                            $section_enable = $home_footer['section_enable'];
                                            foreach ($home_footer['inner-list'] as $key => $value) {
                                                if($value['field_slug'] == 'homepage-footer-label-text') {
                                                    $footer_text = $value['field_default_text'];
                                                }
                                            }
                                        }
                                    @endphp
                                    <li><span>{{ $footer_text }}:</span></li>
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
                                            <img src="{{get_file($homepage_footer_section3_sub_title, APP_THEME())}}" alt="" class="mb-0" style="margin-bottom: initial;">
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
                                @foreach($datas as $blog)
                                <div class="blog-itm-card">
                                        @php
                                            $b_id = hashidsencode($blog->id);
                                        @endphp
                                        <div class="blog-card-inner">
                                            <div class="blog-card-image">
                                                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img">
                                                </a>
                                                <div class="blog-labl">
                                                    {{$blog->MainCategory->name}}
                                                </div>
                                                <div class="date-labl">
                                                    {{ $blog->created_at->format('d M,Y ') }}
                                                </div>
                                            </div>
                                            <div class="blog-product-content">
                                                <h4 class="product-title">
                                                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">
                                                        {!! $blog->title !!}
                                                    </a>
                                                </h4>
                                            </div>
                                            <p class="descriptions">{{$blog->short_description}}</p>
                                            <div class="read-more-btn">
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-primary add-cart-btn" tabindex="0">
                                                    {{__('Read more')}}
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


            <section class="related-blogs-section padding-top padding-bottom">
                <div class="container">
                    @php
                        $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_header_1_key != '' ) {
                            $homepage_header_1 = $theme_json[$homepage_header_1_key];
                            foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                if($value['field_slug'] == 'homepage-blog-title-text') {
                                    $blog_title = $value['field_default_text'];
                                }
                                if($value['field_slug'] == 'homepage-blog-btn-text') {
                                    $blog_btn = $value['field_default_text'];
                                }
                            }
                        }
                        @endphp
                    {{-- @if($homepage_header_1['section_enable'] == 'on') --}}
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <div class="section-title-left">
                                <h2>{!! $blog_title !!}</h2>
                            </div>
                            <div class="section-title-right">
                                <a href="{{route('page.product-list',$slug)}}" class="btn-primary btn-transparent">
                                    {{$blog_btn}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="rgba(131, 131, 131, 1)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0801 11.334L11.5042 11.9203C11.8709 12.4273 12.4637 12.7507 13.1277 12.7507C14.3316 12.7507 15.2631 11.6955 15.1137 10.5008L14.5652 6.11208C14.4322 5.04867 13.5283 4.25065 12.4566 4.25065H4.54294C3.47125 4.25065 2.56727 5.04867 2.43435 6.11208L1.88575 10.5008C1.73642 11.6955 2.66792 12.7507 3.87184 12.7507C4.53583 12.7507 5.12857 12.4273 5.49529 11.9203L5.91944 11.334H11.0801ZM10.3564 12.7507C10.9792 13.6116 11.9918 14.1673 13.1277 14.1673C15.1837 14.1673 16.7745 12.3653 16.5195 10.3251L15.9709 5.93636C15.7493 4.16401 14.2427 2.83398 12.4566 2.83398H4.54294C2.75679 2.83398 1.25016 4.16401 1.02862 5.93636L0.480024 10.3251C0.225003 12.3653 1.81579 14.1673 3.87184 14.1673C5.00767 14.1673 6.02032 13.6116 6.64311 12.7507H10.3564Z" fill="rgba(131, 131, 131, 1)"></path>
                                        <path d="M5.66797 5.66602C5.27677 5.66602 4.95964 5.98315 4.95964 6.37435V7.08268H4.2513C3.8601 7.08268 3.54297 7.39981 3.54297 7.79102C3.54297 8.18222 3.8601 8.49935 4.2513 8.49935H4.95964V9.20768C4.95964 9.59888 5.27677 9.91601 5.66797 9.91601C6.05917 9.91601 6.3763 9.59888 6.3763 9.20768V8.49935H7.08464C7.47584 8.49935 7.79297 8.18222 7.79297 7.79102C7.79297 7.39981 7.47584 7.08268 7.08464 7.08268H6.3763V6.37435C6.3763 5.98315 6.05917 5.66602 5.66797 5.66602Z" fill="rgba(131, 131, 131, 1)"></path>
                                        <path d="M12.75 7.08268C13.1412 7.08268 13.4583 6.76555 13.4583 6.37435C13.4583 5.98315 13.1412 5.66602 12.75 5.66602C12.3588 5.66602 12.0417 5.98315 12.0417 6.37435C12.0417 6.76555 12.3588 7.08268 12.75 7.08268Z" fill="rgba(131, 131, 131, 1)"></path>
                                        <path d="M11.3333 9.91601C11.7245 9.91601 12.0417 9.59888 12.0417 9.20768C12.0417 8.81648 11.7245 8.49935 11.3333 8.49935C10.9421 8.49935 10.625 8.81648 10.625 9.20768C10.625 9.59888 10.9421 9.91601 11.3333 9.91601Z" fill="rgba(131, 131, 131, 1)"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    {{-- @endif --}}
                    <div class="blog-grid-row related-blogs-slider">
                        @foreach ($l_articles as $blog)
                        @php
                            $b_id = hashidsencode($blog->id);
                        @endphp
                        <div class="blog-itm-card">
                            <div class="blog-card-inner">
                                <div class="blog-card-image">
                                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                        <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img">
                                    </a>
                                    <div class="blog-labl">
                                        {{ $blog->MainCategory->name }}
                                    </div>
                                    <div class="date-labl">
                                        {{ $blog->created_at->format('d M,Y ') }}
                                    </div>
                                </div>
                                <div class="blog-product-content">
                                    <h4 class="product-title">
                                        <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">
                                            {!! $blog->title !!}
                                        </a>
                                    </h4>
                                </div>
                                <p class="descriptions">{{$blog->short_description}}</p>
                                <div class="read-more-btn">
                                    <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-primary add-cart-btn" tabindex="0">
                                        {{ __('READ MORE')}}
                                    </a>
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
