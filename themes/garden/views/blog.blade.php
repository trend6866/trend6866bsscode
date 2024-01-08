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
        $homepage_blog_section1_title = $value['field_default_text'];
        }
    }
    }
@endphp
@section('content')
    <!--wrapper start here-->
    <div class="blog-wrapper" >
        <section class="top-bg-wrapper" style="background-image: url({{ asset('themes/' . APP_THEME() . '/assets/images/article-pic.jpg')}});">
           <div class=" container">
              <div class="col-md-6 col-12">
                 <div class="common-banner-content">
                    <ul class="blog-cat">
                       <li class="active"><a href="#">{{ __('Featured')}}</a></li>
                    </ul>
                    <div class="section-title">
                       <h2>{!! $homepage_blog_section1_heading !!}</h2>
                       <p>{!! $homepage_blog_section1_title !!}</p>
                    </div>
                    <a href="#" class="common-btn2 white-btn" tabindex="0">
                        {{ __('Read More')}}
                    </a>
                 </div>
              </div>
           </div>
        </section>
        <section class="blog-grid-section">
            <div class="container">
              <div class="section-title d-flex justify-content-between align-items-end padding-top">
                 <div class="blog-title">
                    <span>{{__('ALL PRODUCTS')}}</span>
                    <h2>{{__('From our blog')}}</h2>
                 </div>
                 <a href="#" class="common-btn2 white-btn" tabindex="0">
                   {{__(' Read More')}}
                 </a>
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
                        <div class="row blog-grid f_blog">
                            @foreach ($blogs as $blog)
                                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                                    @php
                                        $b_id = hashidsencode($blog->id);
                                    @endphp
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
                                        <div class="article-card">
                                            <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wraper">
                                                {{-- <img src="{{ $blog->cover_image_url }}" alt="card-img" class="cover_img{{ $blog->id }}"> --}}
                                                <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="card-img" class="cover_img{{ $blog->id }}">
                                            </a>
                                            <div class="card-content blog-caption">
                                                <span>{{$blog->MainCategory->name}}</span>
                                                <h5><a href="{{route('page.article',[$slug,$b_id])}}"> {{$blog->title}} </a></h5>
                                                <p>{{$blog->short_description}}</p>
                                                <span class="date"> <a href="#">@john</a> • {{$blog->created_at->format('d M,Y ')}}</span>
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="common-btn2">{{__('Read More')}}</a>
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
@push('page-script')
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
@endpush

