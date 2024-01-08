@if(!empty($product_review))
    {{-- <div class="pdp-review-left"> --}}
        {{-- <p>{{ $product_review->description }}</p> --}}
    {{-- </div> --}}
    <div class="rating-start-outer" style="margin-bottom: 30px;">
        <div class="reviews-stars_inner">
            @for ($i = 0; $i < 5; $i++)
                <i class="ti ti-star {{ $i < $product_review->rating_no ? 'text-warning' : '' }} "></i>
            @endfor
            <span class="review-point">{{ $product_review->rating_no }}.0 / 5.0</span>
        </div>
        {{-- <p>{{!empty($product_review->UserData()) ? $product_review->UserData->first_name : '' }}, Client</p> --}}
    </div>
@endif
