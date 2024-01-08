
@foreach ($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-itm">
        <div class="blog-itm-inner">
            <div class="blog-img">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                    <span class="blg-lbl">{{ $blog->MainCategory->name }}</span>
                </a>
            </div>
            <div class="blog-content">
                <div class="blog-content-top">
                    <span class="blog-itm-cat">{{ $blog->name }}</span>
                    <h3>
                        <a href="{{route('page.article',[$slug,$b_id])}}" class="description">{!! $blog->title !!}
                        </a>
                    </h3>
                    <p class="description">{!!$blog->short_description!!}</p>
                </div>
                <div class="blog-contnt-bottom">
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="link-btn">{{ __('READ MORE')}}</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
