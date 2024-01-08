@extends('layouts.layouts')

@section('page-title')
{{ __('Blog') }}
@endsection

        @php
            $homepage_blog_title = $homepage_blog_btn = $homepage_blog_sub_text = '';

            $homepage_blog = array_search('homepage-blog', array_column($homepage_json, 'unique_section_slug'));
            if($homepage_blog != '' ){
                $homepage_blog_value = $homepage_json[$homepage_blog];

                foreach ($homepage_blog_value['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-blog-title') {
                        $homepage_blog_title = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-button') {
                        $homepage_blog_btn = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-blog-sub-text') {
                        $homepage_blog_sub_text = $value['field_default_text'];
                    }
                }
            }
        @endphp

@section('content')

<div class="wrapper-top">
    <section class="blog-page-banner common-banner-section" style="background-image: url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-12">
                    <div class="common-banner-content">
                        <ul class="blog-cat">
                            <li> {{ __('Jan 20, 2022') }} </li>
                        </ul>
                        <div class="section-title">
                            <h2> {!!  $homepage_blog_title !!} </h2>
                        </div>
                        <p> {!! $homepage_blog_sub_text !!} </p>
                        <a href="#" class="btn-secondary white-btn">
                            <span class="btn-txt"> {!! $homepage_blog_btn !!} </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-grid-section article-section-home padding-top tabs-wrapper">
        <div class="container">
            <div class="section-title">
                <div class="subtitle">{{ __('ALL  BLOGS') }}</div>
                <h2>{{ __('From') }}  <b> {{ __('our blog') }}</b></h2>
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
                    <span class="select-lbl">{{ __('Sort by') }}</span>
                    <select class="position">
                        <option value="lastest">{{ __('Lastest') }}</option>
                        <option value="new">{{ __('new') }}</option>
                    </select>
                </div>
            </div>
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                        <div class="blog-grid-row row f_blog">
                            @foreach ($blogs as $blog)
                                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                                @php
                                    $b_id = hashidsencode($blog->id);
                                @endphp
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12  blog-itm">
                                        <div class="blog-inner">
                                            <div class="blog-img">
                                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="" class="cover_img{{ $blog->id }}">
                                                </a>
                                            </div>
                                            <div class="blog-content">
                                                <h4><a href="{{route('page.article',[$slug,$b_id])}}" class="short_description">{{$blog->title}}</a> </h4>
                                                <p class="descriptions">{{$blog->short_description}}</p>
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                                                    {{ __('Read more')}}
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
