
@extends('layouts.layouts')

@section('page-title')
{{ __('Article') }}
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
        <section class="blog-page-banner common-banner-section" style="background-image:url({{ asset('themes/' . APP_THEME() . '/assets/images/blog-banner.png')}});">
           <div class="container">
               <div class="row">
                   <div class="col-md-6 col-12">
                       <div class="common-banner-content">
                            <ul class="blog-cat">
                                <li class="active"><a href="#"> {{ __('Featured')}} </a></li>
                                <li><a href="#"><b> {{ __('Category:')}} </b> {{$blog->MainCategory->name}}</a></li>
                                <li><a href="#"><b> {{ __('Date:')}} </b> {{$blog->created_at->format('d M, Y ')}}</a></li>
                            </ul>
                           <div class="section-title">
                               <h3>{{$blog->title}}</h3>
                           </div>
                           <p>{{$blog->short_description}}</p>
                           <a href="#" class="btn-secondary white-btn" tabindex="0">
                               {{__('Go to Article')}}
                               <svg viewBox="0 0 10 5">
                                   <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                   </path>
                               </svg>
                           </a>
                       </div>
                   </div>
               </div>
           </div>
        </section>
        <section class="article-section padding-bottom padding-top">
           <div class="container">
              <div class="row">
                 <div class="col-12">
                    <div class="about-user d-flex align-items-center">
                       <div class="abt-user-img">
                          <img src="{{asset('themes/'.APP_THEME().'/assets/images/john.png')}}" />
                       </div>
                       <h6>
                          <span>{{__('John Doe')}},</span>
                          {{__('company.com')}}
                       </h6>
                       <div class="post-lbl"><b> {{ __('Category:')}} </b> {{$blog->MainCategory->name}}</div>
                        <div class="post-lbl"><b> {{ __('Date:')}} </b> {{$blog->created_at->format('d M, Y ')}}</div>
                    </div>
                    {{-- <div class="section-title">
                       <h2>{{$blog->title}}</h2>
                    </div> --}}
                 </div>
                 <div class="col-md-8 col-12">
                    <div class="aticleleftbar">
                        {!! html_entity_decode($blog->content) !!}
                       <div class="art-auther">
                        <div class="art-auther"><b>{{__('Tags:')}} </b> {{$blog->MainCategory->name}}</div>
                       </div>
                       @php
                            $homepage_footer4 = array_search('homepage-footer-5', array_column($theme_json, 'unique_section_slug'));
                            if($homepage_footer4 != '')
                            {
                                $home_footer4 = $theme_json[$homepage_footer4];
                                $section_enable4 = $home_footer4['section_enable'];
                                foreach ($home_footer4['inner-list'] as $key => $value) {
                                    if($value['field_slug'] == 'homepage-footer-label-text') {
                                        $home_footer_title4 = $value['field_default_text'];
                                    }
                                    if($value['field_slug'] == 'homepage-footer-enable') {
                                        $home_footer_enable4 = $value['field_default_text'];
                                    }
                                }
                            }
                        @endphp
                        @if($home_footer_enable4 == 'on')
                            <ul class="article-socials d-flex align-items-center">
                                <li><span>{!! $home_footer_title4 !!}</span></li>
                                @php
                                    $homepage_footer_key5 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                                    if($homepage_footer_key5 != '') {
                                        $homepage_footer_section5 = $theme_json[$homepage_footer_key5];

                                    }
                                @endphp
                                @for($i=0 ; $i < $homepage_footer_section5['loop_number'];$i++)
                                    @php
                                        foreach ($homepage_footer_section5['inner-list'] as $homepage_footer_section5_value)
                                        {
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon') {
                                                $homepage_footer_section5_icon = $homepage_footer_section5_value['field_default_text'];
                                            }
                                            if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                                $homepage_footer_section5_social_link = $homepage_footer_section5_value['field_default_text'];
                                            }

                                            if(!empty($homepage_footer_section5[$homepage_footer_section5_value['field_slug']]))
                                            {
                                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon'){
                                                    $homepage_footer_section5_icon = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i]['field_prev_text'];
                                                }
                                                if($homepage_footer_section5_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                                    $homepage_footer_section5_social_link = $homepage_footer_section5[$homepage_footer_section5_value['field_slug']][$i];
                                                }
                                            }
                                        }
                                    @endphp
                                    <li>
                                        <a href="{{$homepage_footer_section5_social_link}}">
                                            <img src="{{get_file($homepage_footer_section5_icon , APP_THEME())}}" alt="youtube">
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        @endif
                    </div>
                 </div>
                 <div class="col-md-4 col-12">
                    <div class="articlerightbar">
                       <div class="section-title">
                          <h2>{{ __('Related articles')}}</h2>
                       </div>
                       <div class="row blog-grid">
                       @foreach ($datas->take(2) as $data)
                        @php
                            $b_id = hashidsencode($data->id);
                        @endphp
                            <div class="col-md-12 col-sm-6 col-12 blog-widget">
                                <div class="blog-card">
                                    <div class="blog-card-inner">
                                        <div class="blog-card-image">
                                            <span class="label">{{$blog->MainCategory->name}}</span>
                                            <a href="{{route('page.article',[$slug,$b_id])}}">
                                                <img src="{{get_file($data->cover_image_path , APP_THEME())}}" class="default-img">
                                            </a>
                                        </div>
                                        <div class="blog-card-content blog-caption">
                                            <h3>
                                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                                    {{$data->title}}
                                                </a>
                                            </h3>
                                            <p>{{$data->short_description}}</p>
                                            <div class="blog-card-author-name">
                                                <span>{{__('AUTHOR')}}: {{__('JOHN DOE')}}</span>
                                                <span>{{__('DATE:')}} {{$blog->created_at->format('d M,Y ')}}</span>
                                            </div>
                                            <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                                            {{__(' Read More')}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                    fill="white" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                 </div>
              </div>
           </div>
        </section>
        <hr class="article-line">
       <section class="blog-grid-section tabs-wrapper padding-bottom padding-top">
           <div class="container">
              <div class="blog-title-row d-flex justify-content-between align-items-center ">
                 <div class="section-title">
                     <span class="sub-title">{{__('ALL PRODUCTS')}}</span>
                     <h3>{{__('From our blog')}}</h3>
                 </div>
                 <a href="#" class="btn">{{__('Read More')}}</a>
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
                   <div class="blog-col-right d-flex align-items-center justify-content-end"style="max-width: 165px;">
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
                                                    <span class="label">{{$blog->MainCategory->name}}</span>
                                                    <a href="{{route('page.article',[$slug,$b_id])}}">
                                                        <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img {{ $blog->id }}">
                                                    </a>
                                                </div>
                                                <div class="blog-card-content">
                                                    <h4>
                                                        <a href="{{route('page.article',[$slug,$b_id])}}">
                                                            {{$blog->title}}
                                                        </a>
                                                    </h4>
                                                    <p>{{$blog->short_description}}</p>
                                                    <div class="blog-card-author-name">
                                                        <span>{{__('AUTHOR: JOHN DOE')}}</span>
                                                        <span>{{ __('Date:') }} {{$blog->created_at->format('d M,Y ')}}</span>
                                                    </div>
                                                    <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                                                        {{__('Read More')}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                                                            fill="white" />
                                                        </svg>
                                                    </a>
                                                </div>
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
@endforeach

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
