
    @foreach ($landing_categories as $category)
        <div class="col-sm-6 col-12 modern-cat-col">
            <div class="modern-cat-column-inner">
                <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class=" row align-items-center">
                    <div class="modern-cat-img col-md-3 col-sm-4 col-4">
                        <img src="{{get_file($category->image_path , APP_THEME())}}">
                    </div>
                    <div class="modern-cat-conent col-md-9 col-sm-8 col-8">
                        <h3>{{$category->name}}</h3>
                        <div class="go-to-btn">
                            <p> {{ __('Go to category') }}
                                <svg viewBox="0 0 10 5">
                                    <path
                                        d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                            </p>
                            @php
                                $landing_categories_products_count = App\Models\product::where('category_id', $category->id)->where('theme_id', APP_THEME())->count();
                            @endphp
                            <span>[{{$landing_categories_products_count}}]</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
