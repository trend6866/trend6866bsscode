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
        style="background-image:url( {{ asset('themes/' . APP_THEME() . '/assets/images/blog-banner.jpg ') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="common-banner-content">
                        <ul class="blog-cat">
                            <li class="active">{{ __('Featured') }}</li>
                            {{-- <li><b>Category:</b> Fashion</li>
                        <li><b>Date:</b> 12 Mar, 2022</li> --}}
                        </ul>
                        <div class="section-title">
                            @php
                            $contact_us_header_worktime =$contact_us_header_sub = $contact_us_header_calling ='';
                            $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                            if ($homepage_header_1_key != '') {
                                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                                    if ($value['field_slug'] == 'homepage-blog-title-text') {
                                        $contact_us_header_worktime = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                        $contact_us_header_sub = $value['field_default_text'];
                                    }
                                    if ($value['field_slug'] == 'homepage-blog-btn-text') {
                                        $contact_us_header_calling = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if ($homepage_header_1['section_enable'] == 'on')
                            <h2>{!!$contact_us_header_worktime!!}</h2>
                        </div>
                        <p>{!!$contact_us_header_sub!!}</p>
                        <a href="#" class="btn">
                            <span class="btn-txt">{!!$contact_us_header_calling!!}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="blog-grid-section padding-top padding-bottom tabs-wrapper">
        <div class="container">
            <div class="section-title">
                <div class="subtitle">{{__('ALL BLOGS')}}</div>
                <h2>{{__('From ')}}  <b> {{__('our blog')}}</b></h2>
            </div>
            <div class="blog-head-row d-flex justify-content-between">
                <div class="blog-col-left">
                    <ul class="d-flex tabs">
                        @foreach ($MainCategory as $cat_key => $category)
                        <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}"
                            data-tab="{{ $cat_key }}">
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
                <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{ $cat_k == 0 ? 'active' : '' }}">
                    <div class= "blog-grid-row row f_blog">
                    @foreach ($blogs as $key => $blog)
                            @if($cat_k == '0' || $blog->maincategory_id == $cat_k)
                                @php
                                    $b_id = hashidsencode($blog->id);
                                @endphp
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-widget">
                                    <div class="blog-widget-inner">
                                        <div class="blog-media">
                                            <a href="{{ route('page.article', [$slug,$b_id]) }}">
                                                <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="">
                                            </a>
                                        </div>
                                        <div class="blog-caption">
                                            <div class="captio-top d-flex justify-content-between align-items-center">
                                                <span class="badge">{{ $blog->MainCategory->name }}</span>
                                                <span class="date"> {{$blog->created_at->format('d M,Y ')}}</span>
                                            </div>
                                            <h4>
                                                <a href="{{ route('page.article', [$slug,$b_id]) }}" class="name">{{ $blog->title }}</a>
                                            </h4>
                                            <p>{{$blog->short_description}}</p>
                                            <strong class="auth-name">@johndoe</strong>
                                            <a class="btn-secondary blog-btn" href="{{ route('page.article', [$slug,$b_id]) }}">
                                            {{__('Read more')}}
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
