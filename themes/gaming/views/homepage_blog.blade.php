
    @foreach($landing_blogs as $blog)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="blog-itm-card">  
        <div class="blog-card-inner">
            <div class="blog-card-image">
                <a href="{{route('page.article',[$slug,$b_id])}}">
                    <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}">
                </a>
                {{-- <div class="blog-labl">
                    {{ $blog->name }}
                </div> --}}
                <div class="date-labl">
                    {{ $blog->created_at->format('d M,Y ') }}
                </div>
            </div>
            <div class="blog-product-content">
                <h3 class="product-title">
                    <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="short-description">
                        {!! $blog->title !!}
                    </a>
                </h3>
            </div>  
            <div class="read-more-btn">
                <a href="{{route('page.article',[$slug,$b_id])}}" class="btn-primary add-cart-btn" tabindex="0">
                    {{ __('READ MORE')}}
                </a>
            </div>
        </div>
    </div>
    @endforeach