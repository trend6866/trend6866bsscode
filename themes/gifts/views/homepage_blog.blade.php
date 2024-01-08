@foreach ($landing_blogs as $blog)
@php
    $b_id = hashidsencode($blog->id);
@endphp
<div class="blog-card-itm">
    <div class="blog-card-itm-inner">
        <div class="blog-card-image">
            <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                <img src="{{get_file($blog->cover_image_path , APP_THEME())}}">
            </a>
            <div class="tip-lable">
                <div class="live">{{$blog->MainCategory->name}}</div> 
            </div>
            <div class="tip-lable">
                <div class="blog-bagde">{{$blog->created_at->format('d M,Y ')}}</div> 
            </div>
        </div>
        <div class="blog-card-content">
            <div class="blog-card-heading-detail">
                <span>@johndoe</span>
            </div>
            <h3>
                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">{{$blog->title}} 
                </a>
            </h3>
            <p class="description">{{$blog->short_description}}</p>
            <div class="blog-card-bottom">
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                    {{ __('View Blog')}}
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach