@extends('layouts.layouts')

@section('page-title')
{{ __('Blog') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

    <!--wrapper start here-->
    <div class="wrapper" style="margin-top: 79.6023px;">
        <section class="blog-page-banner common-banner-section"
            style="background-image:url({{ asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg')}});">
            <div class="container">
                @php
                    $homepage_header_1_key = array_search('home-banner-content', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'home-banner-content-title') {
                                $blog_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-banner-content-sub-text') {
                                $blog_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'home-banner-content-button') {
                                $blog_button = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="common-banner-content">
                            <ul class="blog-cat">
                                <li class="active">{{ __('Featured')}}</li>
                                {{-- <li><b>Category:</b> Fashion</li>
                                <li><b>Date:</b> 12 Mar, 2022</li> --}}
                            </ul>
                            <div class="section-title">
                                <h2>{!! $blog_title !!}</h2>
                            </div>
                            <p>{{$blog_text}}</p>
                            <a href="#" class="btn-secondary white-btn">
                                <span class="btn-txt">{{$blog_button}}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>

         <section class="blog-grid-section padding-top padding-bottom tabs-wrapper">
            <div class="container">
                <div class="section-title">
                    <div class="subtitle">{{__('ALL BLOGS')}}</div>
                    <h2>{{__('From')}} <b>{{__(' our blog')}}</b></h2>
                </div>
                <div class="blog-head-row d-flex justify-content-between">
                    <div class="blog-col-left">
                        <ul class="d-flex tabs">
                            @foreach ($MainCategory as $cat_key =>  $category)
                                <li class="tab-link on-tab-click {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">{{ $category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="blog-col-right d-flex align-items-center justify-content-end">
                        <span class="select-lbl"> {{ __('Sort by') }} </span>
                        <select class="position">
                            <option value="lastest"> {{ __('Lastest') }} </option>
                            <option value="new"> {{ __('new') }} </option>
                        </select>
                    </div>
                </div>

                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="blog-grid-row row f_blog">
                            @foreach ($blogs as $blog)
                                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                                @php
                                    $b_id = hashidsencode($blog->id);
                                @endphp
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card  blog-itm">
                                        <div class="blog-card-inner">
                                            <div class="blog-top">
                                                <span class="badge">{{$blog->MainCategory->name}}</span>
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wrapper">
                                                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" alt="" width="120" class="cover_img{{ $blog->id }}">
                                                </a>
                                            </div>
                                            <div class="blog-caption">
                                                <div class="author-info">
                                                    <span class="date">{{ $blog->created_at->format('d M,Y ') }}</span>
                                                    <span class="auth-name">{{ $blog->name }}</span>
                                                </div>
                                                <h4><a href="{{route('page.article',[$slug,$b_id])}}">{!! $blog->title !!}</h4>
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
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
    <!---wrapper end here-->
    @endsection

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
