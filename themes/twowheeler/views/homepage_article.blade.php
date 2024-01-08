<div class="blog-head-row d-flex justify-content-between">
    <div class="blog-col-left">
        <ul class="d-flex tabs">
            @foreach ($MainCategory as $cat_key =>  $category)
                <li class="tab-link on-tab-click {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                    <a href="javascript:;">{{ $category }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="blog-col-right d-flex align-items-center justify-content-end">
        <span class="select-lbl"> {{ __('Sort by') }} </span>
        <select class="position">
            <option value="lastest"> {{ __('Lastest') }} </option>
            <option value="new"> {{ __('new') }} </option>
        </select>
    </div>
</div>
<div class="tabs-container">
    @foreach ($MainCategory as $cat_k => $category)
    <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{$cat_k == 0 ? 'active' : ''}}">
        <div class="blog-grid-row row f_blog">
            @foreach ($blogs as $blog)
                @if($cat_k == '0' ||  $blog->maincategory_id == $cat_k)
                @php
                    $b_id = hashidsencode($blog->id);
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
                    <div class="blog-card-inner">
                        <div class="blog-card-image">
                            <span class="label">Articles</span>
                            <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0">
                                <img src="{{ get_file($blog->cover_image_path , APP_THEME()) }}" class="default-img" width="120" class="cover_img{{ $blog->id }}">
                            </a>
                        </div>
                        <div class="blog-card-content">
                            <h3>
                                <a href="{{route('page.article',[$slug,$b_id])}}" tabindex="0" class="description">
                                    {!! $blog->title !!}</b>
                                </a>
                            </h3>
                            <p class="descriptions">{{$blog->short_description}}</p>
                            <div class="blog-card-author-name">
                                <span>@johndoe</span>
                                <span>{{ $blog->created_at->format('d M,Y ') }}</span>
                            </div>
                            <a href="{{route('page.article',[$slug,$b_id])}}" class="btn">
                                {{ __('View blog')}}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        getProducts('lastest', '0');
        $(".position").change(function() {
            var value = $(this).val();
            var cat_id = $('.tabs .active').attr('data-tab');
            getProducts(value, cat_id);


        });

        $(".on-tab-click").click(function() {

            var value = $(".position").val();
            var cat_id = $(this).attr('data-tab');

            getProducts(value, cat_id);
        });

    });
    function getProducts(value, cat_id) {
        $.ajax({
            url: "{{ route('blogs.filter.view',$slug) }}",
            type: 'POST',
            data: {
                'value': value,
                'cat_id': cat_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('.f_blog').html(data.html);
            }
        });
    }

</script>
