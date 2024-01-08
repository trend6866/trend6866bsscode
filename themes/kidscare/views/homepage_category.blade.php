@foreach ($landing_categories as $key => $category)
    {{-- @DD($landing_categories) --}}
    <div class="col-12 {{ $key < 2 ? 'col-md-6' : 'col-md-12' }}">
        <div class="meet-cat-box-inner">
            <a href="#" class="cat-img">
                <img src=" {{ get_file($category->image_path, APP_THEME()) }}">
            </a>
            <div class="cat-content">
                <div class="featured-btn btn-secondary white-btn">
                    {{ __('Featured') }}
                </div>
                <h3>{{ $category->name }}</h3>
                {{-- <span class="subtitle">SNEAKERS 2022 EDITION</span>
                <p>Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum
                    Has
                    Been The Industry's Standard Dummy</p> --}}
                <a href="{{ route('page.product-list', [$slug'main_category' => $category->id]) }}" class="add-cart-btn">
                    <span>{{ __('find products') }}</span>
                    <span class="atc-ic">
                        <svg viewBox="0 0 10 5">
                            <path
                                d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                            </path>
                        </svg>
                    </span>
                    @php
                     $landing_categories_products_count = App\Models\product::where('category_id', $category->id)->where('theme_id', APP_THEME())->count();
                    @endphp

                    <span>[{{ $landing_categories_products_count }}]</span>
                </a>
            </div>

        </div>
    </div>
@endforeach
