@foreach($landing_categories as $category)
    <div class="col-md-4 col-sm-6 col-12 service-col">
        <div class="services-card">
            <div class="services-card-inner">
                <img src="{{ get_file($category->icon_path , APP_THEME()) }}" alt="">
                <div class="services-text">
                    <h3>
                        <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}"><h5>{{$category->name}}</h5></a>
                    </h3>
                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class="btn">
                        {{__('Read More')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
