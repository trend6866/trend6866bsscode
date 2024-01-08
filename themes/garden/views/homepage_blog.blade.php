@foreach($landing_blogs as $blog)
<div class="article-card card">
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="article-card-inner">
    <a href="{{route('page.article',[$slug,$b_id])}}" class="img-wraper">
        <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="card-img">
    </a>
    <div class="card-content blog-caption">
        <span>{{$blog->MainCategory->name}}</span>
        <h3><a href="{{route('page.article',[$slug,$b_id])}}"> {{ $blog->title }}</b> </a></h3>
        <p>{{ $blog->short_description }}</p>
        <span class="date"> <a href="#">@john</a> • {{$blog->created_at->format('d M, Y ')}}</span>
        <a href="{{route('page.article',[$slug,$b_id])}}" class="common-btn">{{__(' Read More')}}</a>
    </div>
    </div>
</div>
@endforeach
