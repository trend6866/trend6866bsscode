@foreach ($homeproducts as $homeproduct)
    @if($value == '0' ||  $homeproduct->category_id == $value)
        <div class="shop-protab-itm product-card">
            <div class="product-card-inner">
                <div class="product-card-image">
                    <a href="#">
                        <img src="{{ asset('/' . $homeproduct->cover_image_path) }}" class="default-img">
                        @if ($homeproduct->Sub_image($homeproduct->id)['status'] == true)
                        <img src="{{ asset('/' . $homeproduct->Sub_image($homeproduct->id)['data'][0]->image_path) }}"
                            class="hover-img">
                        @else
                        <img src="{{ $homeproduct->Sub_image($homeproduct->id) }}" class="hover-img">
                        @endif
                    </a>
                    <div class="new-labl">
                        {{__('new')}}
                    </div>
                </div>
                <div class="product-content">
                    <div class="product-content-top">
                        <h3 class="product-title">
                            <a href="#">
                                {{$homeproduct->name}}
                            </a>
                        </h3>
                        <div class="product-type">{{ $homeproduct->ProductData()->name }} / {{ $homeproduct->SubCategoryctData->name }}</div>
                        <div class="pro-labl">
                            {{__('COLOR')}}
                        </div>
                        <div class="color-swatch-variants d-flex">
                            <div class="pro-color active">
                                <input type="radio" />
                                <label  style="background-color: #159AB1;"></label>
                            </div>
                            <div class="pro-color">
                                <input type="radio"  />
                                <label  style="background-color: #B1A215;"></label>
                            </div>
                        </div>
                    </div>
                    <div class="product-content-bottom d-flex align-items-center justify-content-between">
                        <div class="price">
                            <ins>{{ $homeproduct->final_price }} <span class="currency-type">{{$currency}}</span></ins>
                            <del>{{ $homeproduct->original_price }}</del>
                        </div>
                        <button class="addtocart-btn">
                            <span> {{__('Add to cart')}}</span>
                                <svg viewBox="0 0 10 5">
                                    <path
                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
