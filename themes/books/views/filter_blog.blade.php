@foreach ($blogs as $blog)
    @if ($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
        @php
            $b_id = hashidsencode($blog->id);
        @endphp
         <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-itm">
            <div class="blog-card-itm">
                <div class="blog-card-itm-inner">
                    <div class="blog-card-image">
                        <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                            <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" class="default-img">
                        </a>
                        <div class="tip-lable">

                        </div>
                    </div>
                    <div class="blog-card-content">
                        <div class="blog-card-heading-detail">
                            <span>{{$blog->created_at->format('d M,Y ')}}</span>
                        </div>
                        <h4>
                            <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                {{$blog->title}}
                            </a>
                        </h4>
                        <p class="long_sting_to_dots">
                            {{$blog->short_description}}
                        </p>
                        <div class="blog-card-bottom">
                            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn" tabindex="0">
                                {{ __('Read More') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-md-4 col-sm-6 col-12  blog-itm">
            <div class="about-card-main">
                <div class="blog-card-inner">
                    <div class="blog-card">
                        <div class="blog-card-image">
                            <a href="{{ route('page.article', $b_id) }}" tabindex="-1">
                                <img src="{{ $blog->cover_image_url }}" class="default-img {{ $blog->id }}">
                            </a>

                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-heading-detail">
                                <span>Categoty: {{$blog->MainCategory->name}}</span>
                                <span>DATE: {{$blog->created_at->format('d M,Y ')}}</span>
                            </div>
                            <h4>
                                <a href="{{ route('page.article', $b_id) }}" tabindex="-1">
                                    {{ $blog->title }}
                                </a>
                            </h4>
                            <p>
                                {{ $blog->short_description }}
                            </p>
                            <div class="blog-card-bottom">
                                <a href="{{ route('page.article', $b_id) }}" class=" btn" tabindex="-1">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    @endif
@endforeach
