@foreach ($blogs as $blog)
    @if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
        @php
            $b_id = hashidsencode($blog->id);
        @endphp
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-itm">
            <div class="blog-card-itm">
                <div class="blog-card-itm-inner">
                    <div class="blog-card-image">
                        <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                            <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img {{ $blog->id }}">
                        </a>
                        <div class="tip-lable">
                            <span>{{$blog->MainCategory->name}}</span>
                        </div>
                    </div>
                    <div class="blog-card-content">
                        <div class="blog-card-heading-detail">
                            <span>{{$blog->created_at->format('d M,Y ')}} / John Doe</span>
                        </div>
                        <h4>
                            <a class="title" href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                {{$blog->title}}
                            </a>
                        </h4>
                        <p class="description"> {{$blog->short_description}}</p>
                        <div class="blog-card-bottom">
                            <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn" tabindex="0">
                                {{__('Read More')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

