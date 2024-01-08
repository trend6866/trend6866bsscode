

@foreach ($blogs as $blog)
@if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
@php
    $b_id = hashidsencode($blog->id);
@endphp
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 blog-itm">
    <div class="blog-inner">
        <div class="blog-img">
            <a href="{{route('page.article',[$slug,$b_id])}}">
                <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="" class="cover_img{{ $blog->id }}">
            </a>
        </div>
        <div class="blog-content">
            <h3><a href="{{route('page.article',[$slug,$b_id])}}">{{$blog->title}}</a> </h3>
            <p>{{$blog->short_description}}</p>
            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-secondary">
                Read more
            </a>
        </div>
    </div>
</div>

@endif

@endforeach
