@foreach ($blogs as $blog)
    @if ($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
        @php
            $b_id = hashidsencode($blog->id);
        @endphp
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 blog-itm">
            <div class="about-card-main">
                <div class="blog-card-inner">
                    <div class="blog-card">
                        <div class="blog-card-image">
                            <a href="{{ route('page.article', [$slug,$b_id]) }}" tabindex="-1">
                                <img src="{{ get_file($blog->cover_image_path,APP_THEME()) }}" class="default-img {{ $blog->id }}">
                            </a>

                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-heading-detail">
                                <span>Categoty: {{$blog->MainCategory->name}}</span>
                                <span>DATE: {{$blog->created_at->format('d M,Y ')}}</span>
                            </div>
                            <h3>
                                <a href="{{ route('page.article', [$slug,$b_id]) }}" tabindex="-1">
                                    {{ $blog->title }}
                                </a>
                            </h3>
                            <p>
                                {{ $blog->short_description }}
                            </p>
                            <div class="blog-card-bottom">
                                <a href="{{ route('page.article', [$slug,$b_id]) }}" class=" btn" tabindex="-1">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
