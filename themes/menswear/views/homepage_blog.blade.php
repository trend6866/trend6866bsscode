
<div class="home-blog-slider white-dots">
    @foreach ($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-itm">
        <div class="blog-itm-inner">
            <div class="blog-img">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                </a>
                <span class="blg-lbl">{{ $blog->name }}</span> 
            </div>
            <div class="blog-caption">
                <h3>
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="description">
                        {!! $blog->title !!}
                    </a>
                </h3>
                <p class="descriptions">
                    {!!$blog->short_description!!}
                </p>  
                <div class="blog-lbl-row d-flex">
                    <div class="blog-labl">
                        @John
                     </div>
                     <div class="blog-labl">
                        {{ $blog->created_at->format('d M,Y ') }}
                     </div>
                </div>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                    {{ __('SHOW MORE')}}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
