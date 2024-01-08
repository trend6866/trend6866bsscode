@foreach ($landing_blogs as $blog)
<div class="blog-card ">
        @php
            $b_id = hashidsencode($blog->id);
        @endphp
        <div class="blog-card-inner">
            <div class="blog-card-image">
                <span class="label">{{$blog->MainCategory->name}}</span>
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" class="default-img">
                </a>
            </div>
            <div class="blog-card-content">
                <h3>
                    <a  href="{{route('page.article',[$slug,$b_id])}}">
                        {{$blog->title}}
                    </a>
                </h3>
                <p>{{$blog->short_description}}</p>
                <div class="blog-card-author-name">
                    <span>AUTHOR: JOHN DOE</span>
                    <span>{{__('DATE:')}} {{$blog->created_at->format('d M,Y ')}}</span>
                </div>
                <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                    {{__('Read More')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="8" viewBox="0 0 11 8" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.92546 0.237956C6.69464 0.00714337 6.32042 0.00714327 6.08961 0.237955C5.8588 0.468767 5.8588 0.842988 6.08961 1.0738L9.01507 3.99926L6.08961 6.92471C5.8588 7.15552 5.8588 7.52974 6.08961 7.76055C6.32042 7.99137 6.69464 7.99137 6.92545 7.76055L10.2688 4.41718C10.4996 4.18636 10.4996 3.81214 10.2688 3.58133L6.92546 0.237956ZM1.91039 0.237955C1.67958 0.00714327 1.30536 0.00714337 1.07454 0.237956C0.843732 0.468768 0.843733 0.842988 1.07454 1.0738L4 3.99925L1.07454 6.92471C0.843732 7.15552 0.843733 7.52974 1.07455 7.76055C1.30536 7.99137 1.67958 7.99137 1.91039 7.76055L5.25377 4.41718C5.48458 4.18637 5.48458 3.81214 5.25377 3.58133L1.91039 0.237955Z"
                        fill="white" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endforeach
