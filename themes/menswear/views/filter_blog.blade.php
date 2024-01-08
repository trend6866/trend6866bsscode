

@foreach ($blogs as $blog)
    @if($request->cat_id == '0' || $blog->maincategory_id == $request->cat_id)
    @php
        $b_id = hashidsencode($blog->id);
    @endphp
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-itm">
        <div class="blog-itm-inner">
            <div class="blog-img">
                <a href="{{ route("page.article",[$slug,$b_id]) }}">
                    <img src="{{get_file($blog->cover_image_path , APP_THEME())}}" alt="" width="120" class="cover_img{{$blog->id}}">
                </a>
                <span class="blg-lbl">{{__('ACCESSORIES')}}</span>
            </div>
            <div class="blog-caption">
                <h3><a href="{{ route("page.article",[$slug,$b_id]) }}" class="description"> {{$blog->title}} </a></h3>
                <p>{!! $blog->short_description !!}</p>
                <div class="blog-lbl-row d-flex">
                    <div class="blog-labl">
                        <b> {{ __('Category:') }} </b> {{$blog->MainCategory->name}}
                    </div>
                    <div class="blog-labl">
                        <b> {{ __('Date:') }} </b> {{$blog->created_at->format('d M,Y ')}}
                    </div>
                </div>
                <a href="{{ route("page.article",[$slug,$b_id]) }}" class="btn">{{ __('SHOW MORE')}}</a>
            </div>
        </div>
    </div>
    @endif
@endforeach

