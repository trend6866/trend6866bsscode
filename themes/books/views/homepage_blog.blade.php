@foreach ($landing_blogs->take(5) as $blogs)
    @php
        $b_id = hashidsencode($blogs->id);
    @endphp
    <div class="blog-card-itm">
        <div class="blog-card-itm-inner">
            <div class="blog-card-image">
                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                    <img src="{{get_file($blogs->cover_image_path , APP_THEME())}}" class="default-img">
                </a>
                <div class="tip-lable">
                    <span>NEW</span>
                </div>
            </div>
            <div class="blog-card-content">
                <div class="blog-card-heading-detail">
                    <span>{{ date("d M Y", strtotime($blogs->created_at))}}</span>
                </div>
                <h4>
                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                        {{ $blogs->title }}
                    </a>
                </h4>
                <p>
                    {{ $blogs->short_description }}
                </p>
                <div class="blog-card-bottom">
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="btn" tabindex="0">
                        {{__(' Read More')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

