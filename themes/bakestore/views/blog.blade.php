
@extends('layouts.layouts')
@section('page-title')
{{ __('Blog') }}
@endsection
@section('content')
@php

    $theme_json = $homepage_json;
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp
<section class="blog-page-banner common-banner-section"
style="background-image:url({{ asset('themes/'.APP_THEME().'/assets/images/blog-banner.png ') }});">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="common-banner-content">
                @php
                $homepage_category_title_text = $homepage_category_sub_text = $homepage_category_description = '';
                $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_header_1_key != '') {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-title-text') {
                            $homepage_category_title_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-sub-text') {
                            $homepage_category_sub_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            {{-- @if ($homepage_header_1['section_enable'] == 'on') --}}

                <ul class="blog-cat">
                    <li class="active"><a href="#">{{__('Featured')}}</a></li>
                    {{-- <li><a href="#"><b>Category:</b> Fashion</a></li>
                    <li><a href="#"><b>Date:</b> 12 Mar, 2022</a></li> --}}
                </ul>

                <div class="section-title">
                    <h2>{!! $homepage_category_title_text !!}</h2>
                </div>
                <a href="#" class="btn-secondary white-btn" tabindex="0">
                    {{__('Go to Article')}}
                    <svg viewBox="0 0 10 5">
                        <path
                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                        </path>
                    </svg>
                </a>
            {{-- @if --}}
            </div>
        </div>
    </div>
</div>
</section>
<section class="blog-grid-section tabs-wrapper padding-bottom padding-top">
    <div class="container">
        <div class="blog-grid-title d-flex justify-content-between align-items-center ">
            <div class="section-title">
                <span class="sub-title">{{__('ALL PRODUCTS')}}</span>
                <h2>{{__('From our blog')}}
                    </h2>
            </div>
            <a href="#" class="btn">{{__('Read More')}}</a>
        </div>
        <div class="blog-head-row d-flex justify-content-between">
            <div class="blog-col-left">
                <ul class="d-flex tabs">
                    @foreach ($MainCategory as $cat_key => $category)
                    <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}"><a href="javascript:;">{{ $category }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="blog-col-right d-flex align-items-center justify-content-end" style="max-width: 155px;">
                <span class="select-lbl"> {{ __('Sort by') }} </span>
                <select class="position">
                    <option value="lastest"> {{ __('Lastest') }} </option>
                    <option value="new"> {{ __('new') }} </option>
                </select>
            </div>
        </div>


        @foreach ($MainCategory as $cat_k => $category)
        <div class="tabs-container">
            <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                <div class="row blog-grid f_blog">
                    @foreach ($blogs as $blog)
                        @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                            @php
                                $b_id = hashidsencode($blog->id);
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-widget">
                                <div class="blog-card">
                                    <div class="blog-card-inner">
                                        <div class="blog-card-image">
                                            <a href="{{route('page.article',[$slug,$b_id])}}">
                                                <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" class="default-img">
                                            </a>
                                        </div>
                                        <div class="blog-card-content">
                                            <span class="sub-title">{{$blog->MainCategory->name}}</span>
                                            <div class="section-title">
                                                <h3>
                                                    <a href="{{route('page.article',[$slug,$b_id])}}"> {{$blog->title}}
                                                    </a>
                                                </h3>
                                            </div>
                                            <p>
                                                {{$blog->short_description}}
                                            </p>
                                            <div class="blog-card-bottom">
                                                <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                                                   {{__('Read More')}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                        viewBox="0 0 8 8" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.18164 3.99989C0.181641 3.82416 0.324095 3.68171 0.499822 3.68171L6.73168 3.68171L4.72946 1.67942C4.60521 1.55516 4.60521 1.3537 4.72947 1.22944C4.85373 1.10519 5.05519 1.10519 5.17945 1.22945L7.72482 3.7749C7.84907 3.89916 7.84907 4.10062 7.72482 4.22487L5.17945 6.77033C5.05519 6.89459 4.85373 6.89459 4.72947 6.77034C4.60521 6.64608 4.60521 6.44462 4.72946 6.32036L6.73168 4.31807L0.499822 4.31807C0.324095 4.31807 0.181641 4.17562 0.18164 3.99989Z"
                                                            fill="white" />
                                                    </svg>
                                                </a>
                                                <span class="date">
                                                    {{$blog->created_at->format('d M,Y ')}} <br>
                                                    {{-- <a href="#">
                                                        @john
                                                    </a> --}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>

        </div>
        @endforeach
    </div>
</section>

      <!--cart popup start-->

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
