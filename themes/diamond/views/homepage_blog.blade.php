<div class="main-blog">
    @foreach ($landing_blogs->take(5) as $blogs)
    @php
        $b_id = hashidsencode($blogs->id);
    @endphp
        <div class="blog-card">
            <div class="blog-card-image">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    {{-- {{get_file($blogs->cover_image_path , APP_THEME())}} --}}
                    <img src="{{get_file($blogs->cover_image_path , APP_THEME())}}" class="default-img">
                </a>
            </div>
            <div class="blog-card-content">
                <span>{{ __('ARTICLES') }}</span>
                <h3>
                    <a href="{{route('page.article',[$slug,$b_id])}}">
                        {{ $blogs->title }}
                    </a>
                </h3>
                <p>
                    {{ $blogs->short_description }}
                </p>
                <div class="blog-card-bottom">
                    <a href="{{route('page.article',[$slug,$b_id])}}" class=" btn">
                        {{ __('Read More') }}
                    </a>
                    <span class="date">

                       {{ date("d M Y", strtotime($blogs->created_at))}} <br>
                        <a href="#">
                            @john
                        </a>
                    </span>
                </div>
            </div>
        </div>
    @endforeach


</div>
