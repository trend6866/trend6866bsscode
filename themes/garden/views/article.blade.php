
@extends('layouts.layouts')

@section('page-title')
{{ __('Article page') }}
@endsection

@php
    $theme_json = $homepage_json;
@endphp
@section('content')
<div class="blog-wrapper" style="">
@foreach ($blogs as $blog)
    @php
        $sub = explode(',',$blog->subcategory_id);
    @endphp

    <section class="top-bg-wrapper" style="background-image: url({{ asset('themes/' . APP_THEME() . '/assets/images/article-pic.jpg')}});">
       <div class=" container">
          <div class="col-md-6 col-12">
             <div class="common-banner-content">
                <ul class="blog-cat">
                   <li class="active"><a href="#">{{__('Featured')}}</a></li>
                   <li><a href="#"><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</a></li>
                   <li><a href="#"><b>{{__('Date:')}}</b> {{$blog->created_at->format('d M, Y ')}}</a></li>
                </ul>
                <div class="section-title common-heading" >
                   <h2>{{$blog->title}}</h2>
                   <p>{{$blog->short_description}}</p>
                </div>
                <a href="{{ route('landing_page',$slug) }}" class="common-btn2 white-btn" tabindex="0">
                    {{ __('Back to Home') }}
                </a>
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
                      <img src="{{ asset('themes/' . APP_THEME() . '/assets/images/article-user.png')}}">
                   </div>
                   <h6>
                      <span>{{__('John Doe,')}}</span>
                      {{__('company.com')}}
                   </h6>
                   <div class="post-lbl"><b>{{__('Category:')}}</b> {{$blog->MainCategory->name}}</div>
                   <div class="post-lbl"><b>{{__('Date:')}}</b> {{$blog->created_at->format('d M, Y ')}}</div>
                </div>
                <div class="section-title">
                   <h2>{{__('Article title first with light weight')}}</h2>
                </div>
             </div>
             <div class="col-md-8 col-12">
                <div class="aticleleftbar">
                    {!! html_entity_decode($blog->content) !!}

                    {{-- <div class="article-banner-img">
                        <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="article">
                    </div>
                     <div class="art-auther"><b> {{__('John Doe')}}</b>, <a href="company.com">{{__('company.com')}}</a></div> --}}
                    <div class="art-auther"><b>{{__('Tags:')}}</b>{{$blog->MainCategory->name}}</div>
                    @php
                        $homepage_footer_section10_title = $homepage_footer_section10_enable  = '';

                        $homepage_footer_key10 = array_search('homepage-footer-10', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key10 != '') {
                            $homepage_footer_section10 = $theme_json[$homepage_footer_key10];

                        foreach ($homepage_footer_section10['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-footer-10-label') {
                            $homepage_footer_section10_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-footer-10-enable') {
                            $homepage_footer_section10_enable = $value['field_default_text'];
                            }
                        }
                        }
                    @endphp
                    @if($homepage_footer_section10_enable == 'on')
                        <ul class="article-socials d-flex align-items-center">
                            <li><span>{!! $homepage_footer_section10_title !!}</span></li>
                            @php
                                $homepage_footer_section7_icon = '';
                                $homepage_footer_key7 = array_search('homepage-footer-7', array_column($theme_json, 'unique_section_slug'));
                                if($homepage_footer_key7 != '') {
                                    $homepage_footer_section7 = $theme_json[$homepage_footer_key7];
                                }
                            @endphp
                            @for($i=0 ; $i < $homepage_footer_section7['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section7['inner-list'] as $homepage_footer_section7_value)
                                    {
                                        if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_section7_icon = $homepage_footer_section7_value['field_default_text'];
                                        }
                                        if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-label-link') {
                                        $homepage_footer_section7_link = $homepage_footer_section7_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section7[$homepage_footer_section7_value['field_slug']]))
                                        {
                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-social-icon'){
                                                $homepage_footer_section7_icon = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i]['field_prev_text'];
                                            }
                                            if($homepage_footer_section7_value['field_slug'] == 'homepage-footer-link'){
                                                $homepage_footer_section7_link = $homepage_footer_section7[$homepage_footer_section7_value['field_slug']][$i];
                                            }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a href="{{$homepage_footer_section7_link}}" target="_blank">
                                        {{-- <img src="{{asset('/' . $homepage_footer_section7_icon)}}" alt=""> --}}
                                    <img src="{{get_file($homepage_footer_section7_icon , APP_THEME())}}" alt="">
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
                      <h3>{{__('Related articles')}}</h3>
                   </div>
                   <div class="row blog-grid">
                   @foreach ($datas->take(2) as $data)
                    @php
                        $b_id = hashidsencode($data->id);
                    @endphp
                      <div class="col-md-12 col-sm-6 col-12 blog-widget">
                        <div class="article-card blog-caption">
                            <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wraper">
                               <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="card-img">
                            </a>
                            <div class="card-content">
                               <span>{{$blog->MainCategory->name}}</span>
                               <h3><a href="#">{{$data->title}}</a></h3>
                               <p>{{$data->short_description}}</p>
                               <span class="date"> <a href="{{route('page.article',[$slug,$b_id])}}">@john</a> • {{$blog->created_at->format('d M, Y ')}}</span>
                               <a href="{{route('page.article',[$slug,$b_id])}}" class="common-btn2">Read More</a>
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
    <div class="container">
        <hr class="hr-line">
     </div>
     <section class="blog-grid-section">
        <div class="container">
           <div class="section-title d-flex justify-content-between align-items-end padding-top">
              <div class="blog-title">
                 <span>{{__('ALL PRODUCTS')}}</span>
                 <h2>{{__('From our blog')}}</h2>
              </div>
              <a href="{{route('page.product-list',$slug)}}" class="common-btn2 white-btn" tabindex="0">
                 {{__('Read More')}}
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
                 <span class="select-lbl">{{__('Sort by')}}</span>
                 <select>
                    <option>{{__('Lastest')}}</option>
                    <option>{{__('new')}}</option>
                 </select>
              </div>
           </div>
           @foreach ($MainCategory as $cat_k => $category)
           <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{$cat_k == 0 ? 'active' : ''}}">
              <div class="row blog-grid f_blog">
                @foreach ($blog1 as $blog)
                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                    @php
                        $b_id = hashidsencode($blog->id);
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
                        <div class="article-card">
                        <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wraper">
                            <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="card-img" class="cover_img{{ $blog->id }}">
                        </a>
                        <div class="card-content">
                            <span>{{$blog->MainCategory->name}}</span>
                            <h3><a href="{{route('page.article',[$slug,$b_id])}}"> {{$blog->title}} </a></h3>
                            <p>{{$blog->short_description}}</p>
                            <span class="date"> <a href="#">@john</a> • {{$blog->created_at->format('d M,Y ')}}</span>
                            <a href="{{route('page.article',[$slug,$b_id])}}" class="common-btn2">Read More</a>
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
@endforeach
</div>
@endsection
