
@extends('layouts.layouts')

@section('page-title')
{{ __('Article ') }}
@endsection
@php
       $theme_json = $homepage_json;

@endphp
@section('content')
@foreach ($blogs as $blog)
    @php
        $sub = explode(',',$blog->subcategory_id);
    @endphp
<section class="blog-page-banner common-banner-section"
style="background-image: url({{asset('themes/'.APP_THEME().'/assets/images/blog-banner.png')}})">
<div class="container">
   <div class="row">
      <div class="col-md-6 col-12">
         <div class="common-banner-content">
            <ul class="blog-cat">
               <li class="active"><a href="#">{{__('Featured')}}</a></li>
               <li>
                  <a href="#"><b>{{__('Category:')}}</b>{{$blog->MainCategory->name}}</a>
               </li>
               <li>
                  <a href="#"><b>{{__('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</a>
               </li>
            </ul>
            <div class="section-title">
               <h2>{{$blog->title}}</h2>
            </div>
            <a href="#" class="btn" tabindex="0">
              {{__('Read More')}}
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
                   <img src="{{ asset('themes/'.APP_THEME().'/assets/images/john.png') }}">
                </div>
                <h6>
                   <span>John Doe,</span>
                   company.com
                </h6>
                <div class="post-lbl"><b>{{ __('Category:')}}</b>{{$blog->MainCategory->name}}</div>
                        <div class="post-lbl"><b>{{ __('Date:')}}</b>  {{$blog->created_at->format('d M, Y ')}}</div>
             </div>

          </div>
          <div class="col-md-8 col-12">
             <div class="aticleleftbar">
                <h5>
                    {{$blog->description}}
                </h5>
                <p>
                    {!! html_entity_decode($blog->content) !!}
                </p>
                <div class="art-auther">
                   <b>{{ __('John Doe')}}</b>, <a href="company.com">{{ __('company.com')}}</a>
                </div>
                <div class="art-auther">
                   <b>{{__('Tags:')}}</b> {{$blog->MainCategory->name}}
                </div>
                <ul class="article-socials d-flex align-items-center" >
                   <li><span>{{__('Share:')}}</span></li>
                    @php
                        $homepage_footer_social_icon = $homepage_footer_social_link='';

                        $homepage_footer_key3 = array_search('homepage-footer-6', array_column($theme_json, 'unique_section_slug'));
                        if($homepage_footer_key3 != '') {
                            $homepage_footer_section3 = $theme_json[$homepage_footer_key3];
                        }
                    @endphp
                    @for($i=0 ; $i < $homepage_footer_section3['loop_number'];$i++)
                        @php
                            foreach ($homepage_footer_section3['inner-list'] as $homepage_footer_section3_value)
                            {

                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon') {
                                    $homepage_footer_social_icon = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon'){
                                        $homepage_footer_social_icon = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                                if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link') {
                                    $homepage_footer_social_link = $homepage_footer_section3_value['field_default_text'];
                                }

                                if(!empty($homepage_footer_section3[$homepage_footer_section3_value['field_slug']]))
                                {
                                    if($homepage_footer_section3_value['field_slug'] == 'homepage-footer-social-icon-link'){
                                        $homepage_footer_social_link = $homepage_footer_section3[$homepage_footer_section3_value['field_slug']][$i];
                                    }
                                }
                            }
                        @endphp
                        <li>
                            <a href ="{!! $homepage_footer_social_link !!}">
                                <img src=" {{ get_file($homepage_footer_social_icon, APP_THEME()) }}" style=" margin-bottom: 0px; width: 61%;">
                            </a>
                        </li>
                    @endfor
                </ul>
             </div>
          </div>
          <div class="col-md-4 col-12">
             <div class="articlerightbar">
                <div class="section-title">
                   <h2>{{__('Related articles')}}</h2>
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
                               <a href="{{route('page.article',[$slug,$b_id])}}">
                                  <img src="{{get_file($data->cover_image_path , APP_THEME())}}" class="default-img">
                               </a>
                            </div>
                            <div class="blog-card-content">
                               <span class="sub-title">{{$blog->MainCategory->name}}</span>
                               <div class="section-title">
                                  <h3>
                                     <a class="title" href="{{route('page.article',[$slug,$b_id])}}">{{$data->title}}
                                     </a>
                                  </h3>
                               </div>
                               <p class="description">
                                {{$data->short_description}}
                               </p>
                               <div class="blog-card-bottom">
                                  <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                                     {{__('Read More')}}
                                     <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                           d="M0.18164 3.99989C0.181641 3.82416 0.324095 3.68171 0.499822 3.68171L6.73168 3.68171L4.72946 1.67942C4.60521 1.55516 4.60521 1.3537 4.72947 1.22944C4.85373 1.10519 5.05519 1.10519 5.17945 1.22945L7.72482 3.7749C7.84907 3.89916 7.84907 4.10062 7.72482 4.22487L5.17945 6.77033C5.05519 6.89459 4.85373 6.89459 4.72947 6.77034C4.60521 6.64608 4.60521 6.44462 4.72946 6.32036L6.73168 4.31807L0.499822 4.31807C0.324095 4.31807 0.181641 4.17562 0.18164 3.99989Z"
                                           fill="white" />
                                     </svg>
                                  </a>
                                  <span class="date">
                                    {{$blog->created_at->format('d M, Y ')}} <br>
                                     <a href="#">
                                        @john
                                     </a>
                                  </span>
                               </div>
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

@endforeach
<section class="blog-grid-section tabs-wrapper padding-bottom padding-top">
    {!! \App\Models\Blog::ArticlePageBlog() !!}
</section>


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
