<div class="blog-slider">
    @foreach ($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-itm">
        <div class="blog-inner">
            <div class="blog-img">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}">
                </a>
            </div>
            <div class="blog-content">
                <h3><a href="{{route('page.article',[$slug,$b_id])}}" class="short_description">{{$blog->title}}</a> </h3>
                <p>{{$blog->short_description}}</p>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                    {{ __('Read more') }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
