@extends('layouts.layouts')

@section('page-title')
    {{ __('Blog') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp

@section('content')
    <div class="wrapper">
        <section class="blog-page-banner common-banner-section"
            style="background-image:url({{ asset('themes/' . APP_THEME() . '/assets/images/blog-banner.png') }});">
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
                                <li class="active"><a href="#"> {{ __('Featured') }} </a></li>
                                {{-- <li><b>Category:</b> Fashion</li>
                            <li><b>Date:</b> 12 Mar, 2022</li> --}}
                            </ul>
                            <div class="section-title">
                                <h2>{!! $blog_title !!}</h2>
                            </div>
                            <p>{{$blog_text}}</p>
                            <a href="#" class="btn">
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
                    <a href="#" class="btn">
                        {{$blog_btn_text}}
                    </a>
                </div>
                @endif
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
    $(document).ready(function() {
        getProducts('lastest', '0');
        $(".position").change(function() {
            var value = $(this).val();
            var cat_id = $('.tabs .active').attr('data-tab');
            getProducts(value, cat_id);


        });

        $(".on-tab-click").click(function() {

            var value = $(".position").val();
            var cat_id = $(this).attr('data-tab');

            getProducts(value, cat_id);
        });

    });

    function getProducts(value, cat_id) {
        $.ajax({
            url: "{{ route('blogs.filter.view',$slug) }}",
            type: 'POST',
            data: {
                'value': value,
                'cat_id': cat_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('.f_blog').html(data.html);
            }
        });
    }
</script>
