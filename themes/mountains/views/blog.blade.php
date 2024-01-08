@extends('layouts.layouts')

@section('page-title')
    {{ __('Blog') }}
@endsection


@section('content')
    <div class="wrapper" style="">
        <section class="blog-page-banner common-banner-section" style="background-image:url({{ asset('themes/'. APP_THEME().'/assets/images/blog-page-banner.jpg') }}">
            @php
                $homepage_blog_title = '';
                $theme_json = $homepage_json;

                $homepage_blog = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if ($homepage_blog != '') {
                    $homepage_blog_value = $theme_json[$homepage_blog];

                    foreach ($homepage_blog_value['inner-list'] as $key => $value) {
                        if ($value['field_slug'] == 'homepage-blog-label-text') {
                            $homepage_blog_title = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-title-text') {
                            $homepage_blog_text = $value['field_default_text'];
                        }
                        if ($value['field_slug'] == 'homepage-blog-sub-text') {
                            $homepage_blog_sub_text = $value['field_default_text'];
                        }

                        //Dynamic
                        if (!empty($homepage_blog_value[$value['field_slug']])) {
                            if ($value['field_slug'] == 'homepage-blog-label-text') {
                                $homepage_blog_title = $homepage_blog_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'homepage-blog-title-text') {
                                $homepage_blog_text = $homepage_blog_value[$value['field_slug']][$i];
                            }
                            if ($value['field_slug'] == 'homepage-blog-sub-text') {
                                $homepage_blog_sub_text = $homepage_blog_value[$value['field_slug']][$i];
                            }
                        }
                    }
                }
            @endphp
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="common-banner-content">
                            <ul class="blog-cat">
                                <li class="active"><a href="#">{{ __('Featured') }}</a></li>
                                {{-- <li><a href="#"><b>{{ __('Category') }}:</b> Fashion</a></li>
                            <li><a href="#"><b>{{ __('Date') }}:</b> 12 Mar, 2022</a></li> --}}
                            </ul>
                            <div class="section-title">
                                <h2> {!! $homepage_blog_text !!} </h2>
                            </div>
                            <p>{{ $homepage_blog_sub_text }}</p>
                            <a href="#" class="btn-secondary white-btn">
                                <span class="btn-txt">{{ __('Read More') }}</span>
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
        </section>

        <section class="blog-grid-section tabs-wrapper padding-bottom padding-top">
            <div class="container">
                <div class="blog-page-header">
                    <div class="section-title">
                        <div class="subtitle">{{ __('ALL  PRODUCTS') }}</div>
                        <h2>{{ __('From') }} <b> {{ __('our blog') }}</b></h2>
                    </div>
                    <button class="btn continue-btn" type="submit">
                        {{ __('Continue') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14"
                            fill="none">
                            <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                        </svg>
                    </button>
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
                <div class="tabs-container">
                    @foreach ($MainCategory as $cat_k => $category)
                        <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }}">
                            <div class="blog-grid-row row f_blog">
                                @foreach ($blogs as $blog)
                                    @if ($cat_k == '0' || $blog->maincategory_id == $cat_k)
                                        @php
                                            $b_id = hashidsencode($blog->id);
                                        @endphp
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12  blog-itm">
                                            <div class="about-card-main">
                                                <div class="blog-card-inner">
                                                    <div class="blog-card">
                                                        <div class="blog-card-image">
                                                            <a href="{{ route('page.article', [$slug,$b_id]) }}" tabindex="-1">
                                                                <img src="{{ $blog->cover_image_url }}"
                                                                    class="default-img {{ $blog->id }}">
                                                            </a>

                                                        </div>
                                                        <div class="blog-card-content">
                                                            <div class="blog-card-heading-detail">
                                                                <span>Categoty: {{ $blog->MainCategory->name }}</span>
                                                                <span> {{ __('DATE') }}
                                                                    :{{ $blog->created_at->format('d M,Y ') }}</span>
                                                            </div>

                                                            <h4>
                                                                <a href="{{ route('page.article', [$slug,$b_id]) }}" tabindex="-1">
                                                                    {{ $blog->title }}
                                                                </a>
                                                            </h4>
                                                            <p>
                                                                {{ $blog->short_description }}
                                                            </p>
                                                            <div class="blog-card-bottom">
                                                                <a href="{{ route('page.article', [$slug,$b_id]) }}" class=" btn"
                                                                    tabindex="-1">
                                                                    Read More
                                                                </a>
                                                            </div>
                                                        </div>
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
