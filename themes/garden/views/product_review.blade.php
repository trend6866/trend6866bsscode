@if(!empty($product_review))
    <div class="pdp-review-box d-flex justify-content-between w-100">
        <div class="review-star-pdp text-right">
            <div class="review-wrapper">
                @for ($i = 0; $i < 5; $i++)
                    <i class="ti ti-star {{ $i < $product_review->rating_no ? 'text-warning' : '' }} "></i>
                @endfor
                <span>{{ $product_review->rating_no }}.0 / 5.0</span>
            </div>
        </div>
    </div>
@endif
