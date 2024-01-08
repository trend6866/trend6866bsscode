<div class="blog-head-row tab-nav d-flex justify-content-between">
    <div class="blog-col-left">
        <ul class="d-flex tabs">
            @foreach ($MainCategory as $cat_key => $category)
                <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
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
@foreach ($MainCategory as $cat_k => $category)
    <div id="{{ $cat_k }}" class="tab-content {{ $cat_k == 0 ? 'active' : '' }} ">
        <div class="row blog-grid f_blog">

        </div>
    </div>
@endforeach
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
