
<div class="blog-main-slider">
    @foreach($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-card">
        <div class="blog-card-inner">
            <div class="blog-card-image">
                <span class="label">{{__('Articles')}}</span>
                <a href="{{route('page.article',[$slug,$b_id])}}">
                        <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                    </a>
            </div>
            <div class="blog-card-content">
                <h3>
                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="short-description">
                        {!! $blog->title !!}
                    </a>
                </h3>
                <p class="description">{!!$blog->short_description!!}</p>
                <div class="blog-card-author-name">
                    <span>@johndoe</span>
                    <span> {{ $blog->created_at->format('d M,Y ') }}</span>
                </div>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                    {{ __('READ MORE')}}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
