@foreach ($blogs as $blog)
@if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
        <div class="blog-card-inner">
            <div class="blog-card-image">
                <span class="label">{{$blog->MainCategory->name}}</span>
                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img" width="120" class="cover_img{{ $blog->id }}">
                </a>
            </div>
            <div class="blog-card-content">
                <h3>
                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="short-description">
                        {!! $blog->title !!}</b>
                    </a>
                </h3>
                <p class="description">{{$blog->short_description}}</p>
                <div class="blog-card-author-name">
                    <span>@johndoe</span>
                    <span>{{ $blog->created_at->format('d M,Y ') }}</span>
                </div>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                    {{ __('View blog')}}
                </a>
            </div>
        </div>
    </div>
@endif
@endforeach
