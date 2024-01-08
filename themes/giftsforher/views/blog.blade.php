
@extends('layouts.layouts')

@section('page-title')
{{ __('Blog') }}
@endsection

    @php
        $theme_json = $homepage_json;
        $homepage_blog_section1_heading = '';

        $homepage_blog_section_key1 = array_search('homepage-blog-section-1', array_column($theme_json, 'unique_section_slug'));
        if($homepage_blog_section_key1 != '') {
            $homepage_blog_section1 = $theme_json[$homepage_blog_section_key1];

        foreach ($homepage_blog_section1['inner-list'] as $key => $value) {
            if($value['field_slug'] == 'homepage-blog-section-heading') {
                $homepage_blog_section1_heading = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-blog-section-description') {
                $homepage_blog_section1_desc = $value['field_default_text'];
            }
            if($value['field_slug'] == 'homepage-blog-section-button') {
                $homepage_blog_section1_btn_text = $value['field_default_text'];
            }
        }
        }
    @endphp
@section('content')
<div class="wrapper">
    <section class="blog-page-banner common-banner-section" style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="common-banner-content">
                        <ul class="blog-cat">
                            <li class="active">{{ __('Featured')}} </li>
                            {{-- <li><b>Category:</b> Fashion</li>
                            <li><b>Date:</b> 12 Mar, 2022</li> --}}
                        </ul>
                        <div class="section-title">
                            <h2>{!! $homepage_blog_section1_heading !!}</h2>
                        </div>
                        <p>{!! $homepage_blog_section1_desc !!}</p>
                        <a href="#" class="btn">
                            <span class="btn-txt">{!! $homepage_blog_section1_btn_text !!}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-grid-section padding-top tabs-wrapper">
        <div class="container">
            <div class="section-title">
                <div class="subtitle">{{__('ALL  PRODUCTS')}}</div>
                <h2>{{__('From  our blog')}} </h2>
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
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="blog-grid-row row f_blog">
                            @foreach ($blogs as $blog)
                                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                                    @php
                                        $b_id = hashidsencode($blog->id);
                                    @endphp
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 blog-itm">
                                        <div class="blog-widget-inner">
                                            <div class="blog-media">
                                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                                    {{-- <div class="decorative-text">CHAIRS</div> --}}
                                                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" alt="" width="120" class="cover_img{{ $blog->id }}" alt="blog">
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
                                                    <a href="{{route('page.article',[$slug,$b_id])}}">{{$blog->title}}</a>
                                                </h4>
                                                <p>{{$blog->short_description}}</p>
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="link-btn dark-link-btn" tabindex="0">
                                                    {{__('Show More')}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 4 6" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z" fill=""></path>
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
        </div>
    </section>
</div>
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
