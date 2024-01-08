@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection

@section('content')

@php
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
@endphp

    <!--wrapper start here-->
    <div class="wrapper">
        <section class="cart-page-section padding-bottom">

        </section>

        <section class="shop-products-section pdp-page padding-bottom padding-top" >
            <div class="container">
                @php
                    $homepage_logo_key = array_search('homepage-shop-products',array_column($theme_json,'unique_section_slug'));
                    $section_enable = 'on';
                    if($homepage_logo_key != '')
                    {
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @if($homepage_main_logo['section_enable'] == 'on')
                    <div class="section-title d-flex justify-content-between align-items-center">
                        @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            @php
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-title')
                                {
                                    $products_title = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                                if($homepage_main_logo_value['field_slug'] == 'homepage-shop-products-button')
                                {
                                    $products_button = $homepage_main_logo_value['field_default_text'];
                                    if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                        $products_button = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                    }
                                }
                            @endphp
                        @endforeach
                        <h2>{{ $products_title }}</h2>
                        <a href="{{route('page.product-list',$slug)}}" class="btn">
                            {{$products_button}}
                        </a>
                    </div>
                @endif

                <div class="shop-products-slider flex-slider">
                    @foreach ($bestSeller as $data)
                        @php
                            $p_id = hashidsencode($data->id);
                        @endphp
                        <div class="product-card card">
                            <div class="product-card-inner card-inner">
                                <div class="product-content-top ">
                                    <div class="new-labl">
                                        {{ $data->tag_api }}
                                    </div>
                                    <h4 class="product-title">
                                        <a href="{{route('page.product',[$slug,$p_id])}}" class="description">
                                            {{$data->name}}
                                        </a>
                                    </h4>
                                    <div class="product-type">{{ !empty($data->SubCategoryctData) ? $data->SubCategoryctData->name : "" }}</div>
                                </div>
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="img-wrapper">
                                        <img src="{{get_file($data->cover_image_path , APP_THEME())}}" class="default-img">
                                    </a>
                                </div>
                                <div class="product-content-bottom">
                                    <div class="price">
                                        <ins>{{$data->final_price}} <span class="currency-type">{{$currency}}</span></ins>
                                    </div>

                                    <button class="addtocart-btn btn addcart-btn-globaly" tabindex="0" product_id="{{ $data->id }}" variant_id="{{ $data->default_variant_id }}"
                                        qty="1">
                                        <span> {{__('Add to cart')}}</span>
                                        <span class="roun-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                                    fill="white" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- {!! \App\Models\Product::GetLatProduct(10) !!} --}}
                </div>

            </div>
        </section>

        <section class="newsletter-section padding-bottom padding-top">
            @php
                $homepage_text = '';
                $homepage_logo_key = array_search('home-newsletter-section',array_column($theme_json,'unique_section_slug'));
                $section_enable = 'on';
                if($homepage_logo_key != '')
                {
                    $homepage_main_logo = $theme_json[$homepage_logo_key];
                    $section_enable = $homepage_main_logo['section_enable'];
                }
            @endphp
            @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                @php
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-title')
                    {
                        $homepage_title = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_title = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-sub-text')
                    {
                        $homepage_sub_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_sub_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                    // if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-background-image')
                    // {
                    //     $homepage_image = $homepage_main_logo_value['field_default_text'];
                    //     if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                    //         $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                    //     }
                    // }
                    if($homepage_main_logo_value['field_slug'] == 'home-newsletter-section-text')
                    {
                        $homepage_text = $homepage_main_logo_value['field_default_text'];
                        if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                            $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                        }
                    }
                @endphp
            @endforeach
            {{-- <img src="{{ get_file($homepage_image, APP_THEME()) }}" class="subs-design-img" alt="newsletter-right-glass"> --}}
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class=" banner-content-inner">
                        <div class="section-title">
                            <h2>{!! $homepage_title !!}</h2>
                        </div>
                        <p>{!! $homepage_sub_text !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                            @csrf
                            <div class="input-wrapper">
                                <input type="email" name="email" placeholder="Enter email address...">
                                <button type="submit" class="btn-subscibe">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.58455 4.76994C8.79734 4.55716 8.79734 4.21216 8.58455 3.99938L5.31532 0.730146C5.10253 0.51736 4.75754 0.51736 4.54476 0.730146C4.33197 0.942931 4.33197 1.28793 4.54476 1.50071L7.4287 4.38466L4.54476 7.26861C4.33197 7.48139 4.33197 7.82639 4.54476 8.03917C4.75754 8.25196 5.10253 8.25196 5.31532 8.03917L8.58455 4.76994ZM0.956346 8.03917L4.22558 4.76994C4.43836 4.55716 4.43836 4.21216 4.22558 3.99938L0.956346 0.730146C0.74356 0.51736 0.398567 0.51736 0.185781 0.730146C-0.0270049 0.942931 -0.0270049 1.28792 0.185781 1.50071L3.06973 4.38466L0.185781 7.26861C-0.0270052 7.48139 -0.0270052 7.82639 0.185781 8.03917C0.398566 8.25196 0.74356 8.25196 0.956346 8.03917Z"
                                            fill="white"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="checkbox">
                                {{-- <input type="checkbox" id="subscibecheck"> --}}
                                <label for="subscibecheck">
                                    {!! $homepage_text !!}
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!---wrapper end here-->

@endsection

@push('page-script')
<script>
    $(document).on('click', '.addcart-btn-globaly', function() {
        setTimeout(() => {
            get_cartlist();
        }, 200);
    });

    $(document).ready(function() {
        get_cartlist();
    });
</script>
@endpush
