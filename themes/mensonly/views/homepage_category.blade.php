@foreach($landing_categories as $category)
    <div class="col-md-3 col-sm-6 col-12 category-card">
        <div class="category-inner">
            <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class="align-items-center">
            <div class="category-img">
                <img src="{{ get_file($category->icon_path , APP_THEME()) }}" alt="">
            </div>
            </a>
            <div class="category-contant">
                <div class="top-content">
                    <div class="section-title">
                        <h3>{{$category->name}}</h3>
                    </div>

                </div>
                <div class="bottom-content">
                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class="link-btn">{{__('Show More')}}</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
