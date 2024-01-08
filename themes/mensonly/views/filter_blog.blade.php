@foreach ($blogs as $blog)

@if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 blog-itm">
        <div class="blog-card-itm-inner">
            <div class="blog-card-image">
                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img" width="120" class="cover_img{{ $blog->id }}">
                </a>
                <div class="tip-lable">
                    {{-- <div class="live">{{ $blog->name }}</div> --}}
                </div>
                <div class="tip-lable">
                    <div class="blog-bagde">{{ $blog->created_at->format('d M,Y ') }}</div>
                </div>
            </div>
            <div class="blog-card-content">
                <div class="blog-card-heading-detail">
                    <span>@johndoe</span>
                </div>
                <h3>
                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">
                        {!! $blog->title !!}</b>
                    </a>
                </h3>
                <p class="description">{{$blog->short_description}}</p>
                <div class="blog-card-bottom">
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                        {{ __('View blog')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endforeach
