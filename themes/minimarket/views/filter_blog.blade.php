@foreach ($blogs as $blog)
    @if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
        @php
            $b_id = hashidsencode($blog->id);
        @endphp
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
            <div class="article-card">
                <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wraper">
                    {{-- <img src="{{ $blog->cover_image_url }}" alt="card-img" class="cover_img{{ $blog->id }}"> --}}
                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="card-img" class="cover_img{{ $blog->id }}">
                </a>
                <div class="card-content blog-caption">
                    <span>{{$blog->MainCategory->name}}</span>
                    <h3><a href="{{route('page.article',[$slug,$b_id])}}"> {{$blog->title}} </a></h3>
                    <p>{{$blog->short_description}}</p>
                    <span class="date"> <a href="#">@john</a> • {{$blog->created_at->format('d M,Y ')}}</span>
                    <a href="{{route('page.article',[$slug,$b_id])}}" class="common-btn2">Read More</a>
                </div>
            </div>
        </div>
    @endif
@endforeach
