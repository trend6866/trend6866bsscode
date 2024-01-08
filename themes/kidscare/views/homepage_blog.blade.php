


@foreach ($landing_blogs as $blog)
<div class="our-blog-itm">
    {{-- @dd($landing_blogs); --}}
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="our-blog-itm-inner">
        <div class="our-blog-img">
            <a href="{{route('page.article',[$slug,$b_id])}}" class="blog-img">
                <img src=" {{get_file($blog->cover_image_path , APP_THEME())}}">
            </a>
            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn article-btn">Article</a>
        </div>
        <div class="our-blog-content">
            <div class="our-blog-content-top">
                <div class="date-blg">
                    {{$blog->created_at->format('d M,Y ')}}
                </div>
                <h3><a href="{{route('page.article',[$slug,$b_id])}}" class ="name">{{$blog->title}}</b></a></h3>
                <p class="description">{{$blog->short_description}}</p>
            </div>
            <div class="our-blog-content-bottom">
                <div class="our-blog-contnt-btm-row d-flex align-items-center justify-content-between">
                    <h5>John Due</h5>
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                        <span class="btn-txt">{{__('READ MORE')}}</span>
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
</div>
@endforeach
