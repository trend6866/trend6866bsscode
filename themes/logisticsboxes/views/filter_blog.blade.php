@foreach ($blogs as $blog)
    @if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
        @php
        $b_id = hashidsencode($blog->id);
        @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-widget">
                <div class="blog-widget-inner">
                    <div class="blog-media">
                        <a href="{{ route('page.article', [$slug,$b_id]) }}">
                            <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="">
                        </a>
                    </div>
                    <div class="blog-caption">
                        <div class="row captio-top d-flex justify-content-between align-items-center">
                            <span class="badge">{{ $blog->MainCategory->name }}</span>
                            <span class="date"> {{$blog->created_at->format('d M,Y ')}}</span>
                        </div>
                        <h4>
                            <a href="{{ route('page.article', [$slug,$b_id]) }}" class ="name" >{{ $blog->title }}</a>
                        </h4>
                        <p class="description">{{$blog->short_description}}</p>
                        <strong class="auth-name">@johndoe</strong>
                        <a class="btn-secondary blog-btn" href="{{ route('page.article', [$slug,$b_id]) }}">
                        {{__('Read more')}}
                        </a>
                    </div>
                </div>
            </div>
        @endif
@endforeach


