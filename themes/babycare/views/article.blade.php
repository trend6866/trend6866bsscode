@extends('layouts.layouts')

@section('page-title')
{{ __('Article') }}
@endsection

@section('content')

{{-- @dd($blogs) --}}
@foreach ($blogs as $blog)
    @php
        $sub = explode(',',$blog->subcategory_id);
    @endphp
<div class="wrapper wrapper-top">
    <section class="blog-page-banner article-page-banner common-banner-section" style="background-image: url({{asset('themes/'.APP_THEME().'/assets/images/banner-inner.png')}});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-12">
                    <div class="common-banner-content text-center">
                        <a href="{{route('page.blog',$slug)}}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="5" viewBox="0 0 11 5" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5791 2.28954C10.5791 2.53299 10.3818 2.73035 10.1383 2.73035L1.52698 2.73048L2.5628 3.73673C2.73742 3.90636 2.74146 4.18544 2.57183 4.36005C2.40219 4.53467 2.12312 4.53871 1.9485 4.36908L0.133482 2.60587C0.0480403 2.52287 -0.000171489 2.40882 -0.000171488 2.2897C-0.000171486 2.17058 0.0480403 2.05653 0.133482 1.97353L1.9485 0.210321C2.12312 0.0406877 2.40219 0.044729 2.57183 0.219347C2.74146 0.393966 2.73742 0.673036 2.5628 0.842669L1.52702 1.84888L10.1383 1.84875C10.3817 1.84874 10.5791 2.04609 10.5791 2.28954Z" fill="white"></path>
                                </svg>
                            </span>
                            {{  __('Back to Blog') }}
                        </a>
                        <div class="section-title">
                            <h2>{{$blog->title}}</h2>
                        </div>
                        @php
                            $store = App\Models\Store::find($blog->store_id);
                            $user = App\Models\Admin::find($store->created_by);
                        @endphp
                        <div class="about-user d-flex align-items-center">
                            <div class="abt-user-img">
                                <img src="{{asset('themes/'.APP_THEME().'/assets/images/john-2.png')}}" alt="profile">
                            </div>
                            <h6>
                                <span>{{ $user->name }},</span>
                                 {{-- {{ __('company.com') }} --}}
                            </h6>
                            <div class="post-lbl"><b> {{ __('Category') }} :</b> {{$blog->MainCategory->name}}</div>
                            <div class="post-lbl"><b> {{ __('Date') }}:</b> {{$blog->created_at->format('d M, Y ')}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    <section class="article-section padding-top">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="aticleleftbar">
                        {!! html_entity_decode($blog->content) !!}

                        @php
                            $homepage_footer_10_icon = $homepage_footer_10_link = '';

                            $homepage_footer_10 = array_search('homepage-footer-10', array_column($homepage_json, 'unique_section_slug'));
                            if($homepage_footer_10 != '') {
                                $homepage_footer_section_10 = $homepage_json[$homepage_footer_10];
                            }
                        @endphp
                        <ul class="article-socials d-flex align-items-center mt-2">
                            <li><span> {{ __('Share') }} :</span></li>
                            @for($i=0 ; $i < $homepage_footer_section_10['loop_number'];$i++)
                                @php
                                    foreach ($homepage_footer_section_10['inner-list'] as $homepage_footer_section_10_value)
                                    {
                                        if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon') {
                                        $homepage_footer_10_icon = $homepage_footer_section_10_value['field_default_text'];
                                        }
                                        if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link') {
                                        $homepage_footer_10_link = $homepage_footer_section_10_value['field_default_text'];
                                        }

                                        if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                        {
                                            if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-social-icon'){
                                            $homepage_footer_10_icon = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i]['field_prev_text'];
                                        }
                                        }
                                        if(!empty($homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']]))
                                        {
                                            if($homepage_footer_section_10_value['field_slug'] == 'homepage-footer-link'){
                                            $homepage_footer_10_link = $homepage_footer_section_10[$homepage_footer_section_10_value['field_slug']][$i];
                                        }
                                        }
                                    }
                                @endphp
                                <li>
                                    <a target="_blank"  href="{!! $homepage_footer_10_link !!}">
                                        <img src="{{get_file('/' . $homepage_footer_10_icon)}}" alt="social-icon">
                                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.59131 2.23909C3.27183 2.11998 4.32047 2.00996 5.87035 2.00996C7.42023 2.00996 8.46887 2.11998 9.14939 2.23909C9.60942 2.3196 9.93616 2.77372 9.93616 3.42342V7.45757C9.93616 8.10727 9.60942 8.56138 9.14939 8.6419C8.46887 8.761 7.42023 8.87102 5.87035 8.87102C4.32047 8.87102 3.27183 8.761 2.59131 8.6419C2.13128 8.56138 1.80454 8.10727 1.80454 7.45757V3.42342C1.80454 2.77372 2.13128 2.3196 2.59131 2.23909ZM5.87035 0.866455C4.27902 0.866455 3.17701 0.979313 2.43505 1.10917C1.37337 1.29498 0.788086 2.34061 0.788086 3.42342V7.45757C0.788086 8.54038 1.37337 9.586 2.43505 9.77182C3.17701 9.90167 4.27902 10.0145 5.87035 10.0145C7.46168 10.0145 8.56369 9.90167 9.30564 9.77182C10.3673 9.586 10.9526 8.54038 10.9526 7.45757V3.42342C10.9526 2.34061 10.3673 1.29498 9.30564 1.10917C8.56369 0.979313 7.46168 0.866455 5.87035 0.866455ZM5.12231 3.79288C5.28757 3.69339 5.48808 3.70429 5.64404 3.82126L7.16872 4.96477C7.3101 5.07081 7.39503 5.24933 7.39503 5.44049C7.39503 5.63166 7.3101 5.81018 7.16872 5.91622L5.64404 7.05973C5.48808 7.1767 5.28757 7.1876 5.12231 7.0881C4.95706 6.98861 4.8539 6.79486 4.8539 6.584V4.29698C4.8539 4.08612 4.95706 3.89238 5.12231 3.79288Z" fill="white"/>
                                        </svg> --}}
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="articlerightbar blog-grid-section article-section-home">
                        <div class="section-title">
                            <h3> {{ __('Related articles') }} </h3>
                        </div>
                        @foreach ($datas->take(2) as $data)
                        @php
                            $b_id = hashidsencode($data->id);
                        @endphp
                            <div class="blog-itm">
                                <div class="blog-inner">
                                    <div class="blog-img">
                                        <a href="{{route('page.article',[$slug,$b_id])}}">
                                            <img src="{{get_file($data->cover_image_path , APP_THEME())}}" alt="blog-img">
                                        </a>
                                    </div>
                                    <div class="blog-content">
                                        <h4><a href="{{route('page.article',[$slug,$b_id])}}">{{$data->title}}</b></a> </h4>
                                        <p>{{$data->short_description}}</p>
                                        <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                                            {{ __('Read more') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-section-home padding-top">
        <div class="container">
            <div class="common-title d-flex align-items-center justify-content-between">
                <div class="section-title">
                    <h2> {{ __('From our blog') }} </h2>
                </div>
                <a href="{{route('page.blog',$slug)}}" class="btn-secondary">
                    {{ __('Read more') }}
                </a>
            </div>
            <div class="blog-slider">
                @foreach ($l_articles as $article)
                @php
                    $b_id = hashidsencode($article->id);
                @endphp
                    <div class="blog-itm">
                        <div class="blog-inner">
                            <div class="blog-img">
                                <a href="{{route('page.article',[$slug,$b_id])}}">
                                    <img src="{{get_file($article->cover_image_path , APP_THEME())}}" alt="blog-img">
                                </a>
                            </div>
                            <div class="blog-content">
                                <h4><a href="{{route('page.article',[$slug,$b_id])}}">{{$article->title}}</a> </h4>
                                <p>{{$article->short_description}} </p>
                                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                                    {{ __('Read more') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</div>
@endforeach

@endsection
