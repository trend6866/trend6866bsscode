@php
    $path = base_path('themes/'.APP_THEME().'/theme_json/web/homepage.json');
    $homepage_json = json_decode(file_get_contents($path), true);
    $theme_json = $homepage_json;
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
@endphp

<div class="container">
    <div class="section-title d-flex align-items-center justify-content-between">
        @php
            $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));

            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-bestseller-title-text') {
                        $home_title = $value['field_default_text'];
                    }
                }
            }
        @endphp
            <h2>{{$home_title}}</h2>
        <ul class="cat-tab tabs">
            @foreach ($MainCategory as $cat_key =>  $category)
                <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}">
                    <a href="javascript:;">{{$category}}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="tabs-container">
        @foreach ($MainCategory as $cat_k => $category)
        <div id="{{ $cat_k }}" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
            <div class="bg-black product-card-reverse bestsell-slider">
                @foreach($homeproducts as $homeproduct)
                    @php
                        $p_id = hashidsencode($homeproduct->id);
                    @endphp
                    @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                        <div class="bestseller-itm product-card">
                            <div class="product-card-inner">
                                <div class="product-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{ get_file($homeproduct->cover_image_path , APP_THEME()) }}">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <div class="product-cont-top">
                                        <div class="subtitle">{{$homeproduct->tag_api}}</div>
                                        <h3>
                                            <a href="{{route('page.product',[$slug,$p_id])}}">{{$homeproduct->name}}</a>
                                        </h3>
                                    </div>
                                    <div class="product-cont-bottom">
                                        {{-- <div class="size-selectors d-flex align-items-center"> --}}
                                            {{-- <select class="color-select">
                                                <option>Black</option>
                                                <option>Grey</option>
                                                <option>Red</option>
                                            </select>
                                            <select class="size-select">
                                                <option>M</option>
                                                <option>XL</option>
                                                <option>X</option>
                                            </select>
                                            <select class="material-select">
                                                <option>Cotton</option>
                                                <option>Fabric</option>
                                                <option>Leather</option>
                                            </select> --}}
                                        {{-- </div> --}}
                                        <div class="price-btn">
                                            <span class="price">
                                                <ins>{{$homeproduct->final_price}}{{$currency}}</ins>
                                            </span>
                                            <button class="cart-button addcart-btn-globaly" type="submit" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">                                                <svg width="20" height="20" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15.7424 6H4.25797C3.10433 6 2.1899 6.97336 2.26187 8.12476L2.76187 16.1248C2.82775 17.1788 3.70185 18 4.75797 18H15.2424C16.2985 18 17.1726 17.1788 17.2385 16.1248L17.7385 8.12476C17.8104 6.97336 16.896 6 15.7424 6ZM4.25797 4C1.95069 4 0.121837 5.94672 0.265762 8.24951L0.765762 16.2495C0.89752 18.3577 2.64572 20 4.75797 20H15.2424C17.3546 20 19.1028 18.3577 19.2346 16.2495L19.7346 8.24951C19.8785 5.94672 18.0496 4 15.7424 4H4.25797Z">
                                                    </path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 5C5 2.23858 7.23858 0 10 0C12.7614 0 15 2.23858 15 5V7C15 7.55228 14.5523 8 14 8C13.4477 8 13 7.55228 13 7V5C13 3.34315 11.6569 2 10 2C8.34315 2 7 3.34315 7 5V7C7 7.55228 6.55228 8 6 8C5.44772 8 5 7.55228 5 7V5Z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
