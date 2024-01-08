@extends('layouts.layouts')
@section('page-title')
{{ __('Blog') }}
@endsection
@section('content')
@php
    $theme_json = $homepage_json;
    $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME');

@endphp
@php
$theme_json = $homepage_json;
$homepage_blog_section1_heading = '';

$homepage_blog_section_key1 = array_search('blogpage-blog-section-1', array_column($theme_json, 'unique_section_slug'));
if($homepage_blog_section_key1 != '') {
    $homepage_blog_section1 = $theme_json[$homepage_blog_section_key1];

foreach ($homepage_blog_section1['inner-list'] as $key => $value) {
    if($value['field_slug'] == 'blogpage-blog-section-heading') {
    $homepage_blog_section1_heading = $value['field_default_text'];
    }
}
}
@endphp

    <div class="">
        <section class="blog-page-banner common-banner-section"
            style="background-image:url({{asset('themes/'.APP_THEME().'/assets/images/blog-page-banner.jpg')}}) ;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="common-banner-content">
                            <ul class="blog-cat">
                                <li class="active">{{__('Featured')}}</li>
                                {{-- <li><b>Category:</b> Fashion</li>
                                <li><b>Date:</b> 12 Mar, 2022</li> --}}
                            </ul>
                            <div class="section-title">
                                {!!$homepage_blog_section1_heading!!}
                            </div>

                            <a href="#" class="btn-secondary white-btn">
                                <span class="btn-txt">
                                    {{__('Read MORE')}}</span>
                                <span class="btn-ic">
                                    <svg viewBox="0 0 10 5">
                                        <path
                                            d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog-grid-section padding-bottom padding-top">
            @php
                $homepage_blog_title = $homepage_blog_heading = $homepage_blog_button = '';
                $homepage_blog_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_blog_key != '') {
                    $homepage_blog = $theme_json[$homepage_blog_key];
                    foreach ($homepage_blog['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-title') {
                            $homepage_blog_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-sub-title') {
                            $homepage_blog_heading = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-button') {
                            $homepage_blog_button = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            <div class="container">
                <div class="section-title">
                    <div class="subtitle">{!!$homepage_blog_title!!}</div>
                    <h2>{!!$homepage_blog_heading!!}</b></h2>
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
                        <span class="select-lbl">{{__('Sort by')}}</span>
                        <select class="position">
                            <option value="lastest">{{ __('Lastest')}}</option>
                            <option value="new"> {{ __('new')}}</option>
                        </select>
                    </div>
                </div>

                @foreach ($MainCategory as $cat_k => $category)
                    <div class="tabs-container">
                        <div id="{{ $cat_k }}" class="tab-content  {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="blog-grid-row row f_blog">
                                @foreach ($blogs as $key => $blog)
                                    @if($cat_k == '0' || $blog->maincategory_id == $cat_k)
                                        @php
                                            $b_id = hashidsencode($blog->id);
                                        @endphp
                                        <div class="blog-widget our-blog-itm col-xl-3 col-lg-4 col-sm-6 col-12">
                                            <div class="our-blog-itm-inner">
                                                <div class="our-blog-img">
                                                    <a href="#" class="blog-img">
                                                        <img src="{{get_file($blog->cover_image_path , APP_THEME())}}">
                                                    </a>
                                                    <a href="{{ route('page.article', [$slug,$b_id]) }}" class="btn article-btn">{{ $blog->SubCategory->name }}</a>
                                                </div>
                                                <div class="our-blog-content">
                                                    <div class="our-blog-content-top">
                                                        <div class="date-blg">
                                                            {{$blog->created_at->format('d M,Y ')}} </div>
                                                        <h3><a href="#">{{ $blog->title }}</a></h3>
                                                        <p>{{ $blog->short_description}}</p>
                                                    </div>
                                                    <div class="our-blog-content-bottom">
                                                        <div class="our-blog-contnt-btm-row d-flex align-items-center justify-content-between">
                                                            <h5>John Doe</h5>
                                                            <a href="{{ route('page.article', [$slug,$b_id]) }}" class="btn-secondary">
                                                                <span class="btn-txt">{{__('READ MORE')}}</span>
                                                                <span class="btn-ic">
                                                                    <svg viewBox="0 0 10 5">
                                                                        <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
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
