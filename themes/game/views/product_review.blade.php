

@if(!empty($product_review))
    <h5>{{ __('Ratings:') }}</h5>
    <div class="testimonials-card">
        <div class="testimonials-card-inner">
            <div class="testimonial-top d-flex align-items-center justify-content-between">
                <div class="reviews-stars-wrap d-flex align-items-center">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="fa fa-star {{ $i < $product_review->rating_no ? '' : 'text-warning' }} "></i>
                    @endfor
                    <span><b>{{ $product_review->rating_no }}.0</b> / 5.0</span>
                </div>
                <div class="customer-nam"><strong>{{!empty($product_review->UserData()) ? $product_review->UserData->first_name : '' }},</strong> Client</div>
            </div>
            <div class="reviews-words">
                <h4 class="main-word">{!! $product_review->name !!}</h4>
                <p class="description">{{ $product_review->description }}</p>
            </div>
        </div>
    </div>

@endif