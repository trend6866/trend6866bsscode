@foreach ($blogs as $blog)
{{-- @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k) --}}
@if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 blog-widget blog-card blog-itm">
        <div class="blog-card-inner">
            <div class="blog-top">
                <span class="badge">{{__('ARTICLES')}}</span>
                <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wrapper">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" alt="" width="120" class="cover_img{{ $blog->id }}">
                </a>
            </div>
            <div class="blog-caption">
                <div class="author-info">
                    <span class="date">{{ $blog->created_at->format('d M,Y ') }}</span>
                    <span class="auth-name">{{ $blog->name }}</span>
                </div>
                <h3><a href="{{route('page.article',[$slug,$b_id])}}" class="description">{!! $blog->title !!}</h3></a>
                <p class="description">{{$blog->short_description}}</p>
                    <a class="btn blog-btn" href="{{route('page.article',[$slug,$b_id])}}">
                        {{ __('Read more')}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z" fill="white"></path>
                        </svg>
                    </a>
            </div>
        </div>
    </div>
@endif
@endforeach
