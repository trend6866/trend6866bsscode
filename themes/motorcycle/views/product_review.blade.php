

@if(!empty($product_review))

    <div class="ratings d-flex align-items-center">
        @for ($i = 0; $i < 5; $i++)                                            
        <i class="fa fa-star {{ $i < $product_review->rating_no ? '' : 'text-warning' }} "></i>
        @endfor
        <span><b>{{$product_review->rating_no}}</b> / 5.0</span>
    </div>

@endif
