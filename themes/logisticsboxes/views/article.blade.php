
@extends('layouts.layouts')

@section('page-title')
{{ __('Article ') }}
@endsection
@php
       $theme_json = $homepage_json;

@endphp
@section('content')
{{-- @dd($blogs) --}}
@foreach ($blogs as $blog)
    @php
        $sub = explode(',',$blog->subcategory_id);
    @endphp

<div class="wrapper" style="margin-top: 155.594px;">
    <section class="blog-page-banner common-banner-section" style="background-image:url( {{asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg')}});">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="common-banner-content">
                    <ul class="blog-cat">
                        <li class="active">{{__('Featured')}}</li>
                        <li><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</li>
                        <li><b>{{__('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</li>
                    </ul>
                    <div class="section-title">
                        <h2>{{$blog->title}}</h2>
                    </div>
                    <p> {{$blog->description}}</p>
                    <a href="#" class="btn-secondary white-btn">
                        <span class="btn-txt">read MORE</span>
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
                        <img src="{{ asset('themes/'.APP_THEME().'/assets/images/john.png') }}">
                    </div>
                    <h6>
                        <span>{{__('John Doe,')}}</span>
                            {{__('company.com')}}
                    </h6>
                    <div class="post-lbl"><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</div>
                    <div class="post-lbl"><b>{{__('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="aticleleftbar">
                    <h5>{{$blog->description}}</h5>
                    <p> {!! html_entity_decode($blog->content) !!}</p>
                    {{-- <img src="assets/images/article-img.jpg" alt="article"> --}}
                    <div class="art-auther"><b>{{__('John Doe')}}</b>, <a href="company.com">{{__('company.com')}}</a></div>

                    <div class="art-auther"><b>Tags:</b>  {{$blog->MainCategory->name}}</div>
                    <ul class="article-socials d-flex align-items-center">
                        <li><span>Share:</span></li>
                        @php
                            $homepage_footer_10_icon = $homepage_footer_10_link = '';

                            $homepage_footer_10 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer_10 != '') {
                                $homepage_footer_section_10 = $theme_json[$homepage_footer_10];

                            }

                        @endphp
                        @for($i=0 ; $i < $homepage_footer_section_10['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section_10['inner-list'] as $homepage_footer_section_10_value)
                            {
                                if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon') {
                                $homepage_footer_10_icon = $homepage_footer_section_10_value['field_default_text'];
                                }
                                if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                $homepage_footer_10_link = $homepage_footer_section_10_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                {
                                    if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon'){
                                    $homepage_footer_10_icon = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i]['field_prev_text'];
                                }
                                }
                                if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                {
                                    if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                    $homepage_footer_10_link = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i];
                                }
                                }
                            }
                        @endphp
                            <li>
                                <a href="{!! $homepage_footer_10_link!!}" target="_blank">
                                    <img src="{{get_file($homepage_footer_10_icon , APP_THEME())}} " alt="">
                                </a>
                            </li>
                        @endfor

                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="articlerightbar blog-grid-section">
                    <div class="section-title">
                        <h3>{{__('Related articles')}}</h3>
                    </div>
                    @foreach ($datas as $data)
                    <div class="blog-widget">
                            @php
                            $b_id = hashidsencode($data->id);
                            @endphp
                        <div class="blog-widget-inner">
                            <div class="blog-media">
                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                    <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="">
                                </a>
                            </div>
                            <div class="blog-caption">
                                <div class="captio-top d-flex justify-content-between align-items-center">
                                    <span class="badge">{{$data->Maincategory->name}}</span>
                                    <span class="date">{{$data->created_at->format('d M, Y ')}}</span>
                                </div>
                                <h4>
                                    <a href="{{route('page.article',[$slug,$b_id])}}">{{$data->title}}</a>
                                </h4>
                                <p>{{$data->short_description}}</p>
                                <strong class="auth-name">@johndoe</strong>
                                <a class="btn-secondary blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
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

    <section class="padding-top blog-grid-section padding-bottom">
        <div class="container">
            <div class="section-title">
            <h2>{{__('Latest Blogs')}}</h2>
            </div>
            <div class="blog-slider2 post-slider">
                @foreach ($l_articles as $article)
                    @php
                        $b_id = hashidsencode($article->id);
                    @endphp
                    <div class="blog-widget">
                        <div class="blog-widget-inner">
                            <div class="blog-media">
                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                    <img src="{{get_file($article->cover_image_path , APP_THEME())}}" alt="">
                                </a>
                            </div>
                            <div class="blog-caption">
                                <div class="captio-top d-flex justify-content-between align-items-center">
                                    <span class="badge">{{$article->Maincategory->name}}</span>
                                    <span class="date"> {{$article->created_at->format('d M, Y ')}}</span>
                                </div>
                                <h4>
                                    <a href="{{route('page.article',[$slug,$b_id])}}" class="name">{{$article->title}}</a>
                                </h4>
                                <p class ="description">{{$article->short_description}}</p>
                                <strong class="auth-name">@johndoe</strong>
                                <a class="btn-secondary blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                                {{__('Read more')}}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</div >
@endforeach




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        getProducts('lastest','0');
      $(".position").change(function () {
        var value = $(this).val();
        var cat_id = $('.tabs .active').attr('data-tab');
        getProducts(value,cat_id);


      });

      $(".on-tab-click").click(function(){

        var value = $(".position").val();
        var cat_id = $(this).attr('data-tab');

        getProducts(value,cat_id);
    });

    });

    function getProducts(value,cat_id) {
        $.ajax({
            url: "{{ route('blogs.filter.view',$slug) }}",
            type: 'POST',
            data: {'value': value,'cat_id':cat_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('.f_blog').html(data.html);
            }
        });
    }


  </script>
