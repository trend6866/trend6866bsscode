

    @foreach ($landing_categories as $key => $category)
    {{-- @DD($category) --}}
    <div class="card-slides">
        <div class="img-box">

            <img src=" {{get_file($category->image_path, APP_THEME())}}"
                class="card-img" alt="img2">
            <div class="category-box">
                <div class="top-content">
                    <div class="section-title">
                        <h4>
                            <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}">
                                {{ $category->name }}
                            </a>
                        </h4>
                    </div>

                </div>
                <div class= "btn-wrapper">
                    <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}" class="btn-secondary" style="background:var(--theme-color);">
                        {{__('Check more products')}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                            viewBox="0 0 8 8" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.18164 3.99989C0.181641 3.82416 0.324095 3.68171 0.499822 3.68171L6.73168 3.68171L4.72946 1.67942C4.60521 1.55516 4.60521 1.3537 4.72947 1.22944C4.85373 1.10519 5.05519 1.10519 5.17945 1.22945L7.72482 3.7749C7.84907 3.89916 7.84907 4.10062 7.72482 4.22487L5.17945 6.77033C5.05519 6.89459 4.85373 6.89459 4.72947 6.77034C4.60521 6.64608 4.60521 6.44462 4.72946 6.32036L6.73168 4.31807L0.499822 4.31807C0.324095 4.31807 0.181641 4.17562 0.18164 3.99989Z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>



@endforeach

