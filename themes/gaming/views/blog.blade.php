@extends('layouts.layouts')

@section('page-title')
{{ __('Blog') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')

{{-- <div class="wrapper"> --}}
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
                            </ul>
                            <div class="section-title">
                                {!! $blog_title !!}
                            </div>
                            <p>{{$blog_text}}</p>
                            <a href="" class="btn">
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
                        @foreach ($MainCategory->take(7) as $cat_key =>  $category)
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
                <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                    <div class="blog-grid-row row f_blog">
                        @foreach ($blogs as $blog)
                            @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                                @php
                                    $b_id = hashidsencode($blog->id);
                                @endphp
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-itm-card">
                                    <div class="blog-card-inner">
                                        <div class="blog-card-image">
                                            <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                                <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img">
                                            </a>
                                            <div class="blog-labl">
                                                {{$blog->MainCategory->name}}
                                            </div>
                                            <div class="date-labl">
                                                {{$blog->created_at->format('d M,Y ')}}
                                            </div>
                                        </div>
                                        <div class="blog-product-content">
                                            <h3 class="product-title">
                                                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="short-description">
                                                    {{$blog->title}}
                                                </a>
                                            </h3>
                                        </div>
                                        <p class="descriptions">{{$blog->short_description}}</p>
                                        <div class="read-more-btn">
                                            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-primary add-cart-btn" tabindex="0">
                                                {{ __('READ MORE')}}
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
{{-- </div> --}}

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
