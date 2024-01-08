<div class="blog-slider">
    @foreach ($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-itm">
        <div class="blog-inner">
            <div class="blog-img">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="blog-img">
                </a>
            </div>
            <div class="blog-content">
                <h4><a href="{{route('page.article',[$slug,$b_id])}}">{{$blog->title}}</a> </h4>
                <p>{{$blog->short_description}}</p>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                    {{ __('Read more') }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
