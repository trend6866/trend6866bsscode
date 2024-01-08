@extends('layouts.layouts')
@php
    $theme_json = $homepage_json;
@endphp

@section('page-title')
{{ __('Motorbikes') }}
@endsection

@section('content')


<div class=" wrapper home-wrapper">

    <section class="home-section">
        <div class="home-slider">
{{-- @dd($homepage_products) --}}
            @foreach($homepage_products as $homepage_product)
                @php
                    $description = json_decode($homepage_product->product_option);
                    foreach ($description as $k => $value)
                    {
                        $value =  json_decode(json_encode($value), true);
                        foreach ($value['inner-list'] as $description_val)
                        {
                            if($description_val['field_slug'] == 'product-option-engine'){
                                $description_value = $description_val['value'];
                            }
                            if($description_val['field_slug'] == 'product-option-bhp'){
                                $description_img = $description_val['value'];
                            }
                            if($description_val['field_slug'] == 'product-option-torque'){
                                $more_description_value = $description_val['value'];
                            }
                            if($description_val['field_slug'] == 'product-option-max-speed'){
                                $more_description_img = $description_val['value'];
                            }
                        }
                    }
                    // dd($description)
                @endphp
                <div class="home-slide-inner">
                    <div class="offset-container offset-left">
                        <div class="home-col d-flex">
                            <div class="home-text">
                                <div class="home-text-inner">
                                    <h2>
                                        <span class="sub-title">{{$homepage_product->ProductData()->name}}</span>
                                        <span class="short-description"> {{$homepage_product->name}} </span>
                                    </h2>
                                    <div class="price">
                                        <ins>{{$homepage_product->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                    </div>
                                    <div class="bike-ass-details">
                                        {{-- <li> --}}
                                            <p>{!! $homepage_product->description !!}</p>
                                        {{-- </li> --}}
                                    </div>
                                    <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $homepage_product->id }}" variant_id="{{ $homepage_product->default_variant_id }}" qty="1">
                                        {{ __('ADD TO CART')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                            viewBox="0 0 22 17" fill="none">
                                            <path
                                                d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                fill="#FF0A0A"></path>
                                        </svg>
                                    </a>

                                    <ul class="bike-details">
                                        @foreach($value['inner-list'] as $description_val)
                                            <li class="active">
                                                <span>{{$description_val['field_name']}}</span>
                                                {{$description_val['value']}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="home-img">
                                <img src="{{get_file($homepage_product->cover_image_path,APP_THEME())}}" alt="bike" />
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="home-slider-arrow">
            <div class="home-arrow-inner">
                <span class="left-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.292892 7.70711C-0.0976315 7.31658 -0.0976315 6.68342 0.292892 6.29289L6.29289 0.292894C6.68342 -0.0976307 7.31658 -0.0976307 7.70711 0.292894C8.09763 0.683418 8.09763 1.31658 7.70711 1.70711L2.41421 7L7.70711 12.2929C8.09763 12.6834 8.09763 13.3166 7.70711 13.7071C7.31658 14.0976 6.68342 14.0976 6.29289 13.7071L0.292892 7.70711ZM14.2929 13.7071L8.29289 7.70711C7.90237 7.31658 7.90237 6.68342 8.29289 6.29289L14.2929 0.292893C14.6834 -0.0976311 15.3166 -0.0976311 15.7071 0.292893C16.0976 0.683417 16.0976 1.31658 15.7071 1.70711L10.4142 7L15.7071 12.2929C16.0976 12.6834 16.0976 13.3166 15.7071 13.7071C15.3166 14.0976 14.6834 14.0976 14.2929 13.7071Z"
                            fill="#676767" />
                    </svg>
                </span>
                <div class="degree">360*</div>
                <span class="right-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.7071 7.70711C16.0976 7.31658 16.0976 6.68342 15.7071 6.29289L9.70711 0.292894C9.31658 -0.0976307 8.68342 -0.0976307 8.29289 0.292894C7.90237 0.683418 7.90237 1.31658 8.29289 1.70711L13.5858 7L8.29289 12.2929C7.90237 12.6834 7.90237 13.3166 8.29289 13.7071C8.68342 14.0976 9.31658 14.0976 9.70711 13.7071L15.7071 7.70711ZM1.70711 13.7071L7.70711 7.70711C8.09763 7.31658 8.09763 6.68342 7.70711 6.29289L1.70711 0.292893C1.31658 -0.0976311 0.683418 -0.0976311 0.292894 0.292893C-0.0976307 0.683417 -0.0976307 1.31658 0.292894 1.70711L5.58579 7L0.292894 12.2929C-0.0976312 12.6834 -0.0976312 13.3166 0.292894 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071Z"
                            fill="#676767" />
                    </svg>
                </span>
            </div>
        </div>
    </section>


    <section class="bike-deatail-slider-sec">
        <div class="offset-container offset-left">
            <div class="bike-slider-main">
                @foreach($products as $product)
                {{-- @dd($all_product) --}}
                <div class="bike-slides">
                    <div class="bike-slides-inner">
                        <div class="left-content">
                            <h2 class="short-description">{{$product->name}}</h2>
                            <div class="bike-ass-details">
                                {{-- <li> --}}
                                    <p class="description">{!! $product->description !!}</p>
                                {{-- </li> --}}
                            </div>
                            <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $product->id }}" variant_id="{{ $product->default_variant_id }}" qty="1">
                                {{ __('Add to cart')}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17" viewBox="0 0 22 17"
                                    fill="none">
                                    <path
                                        d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                        fill="#FF0A0A"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="right-side">
                            <img src="{{get_file( $product->cover_image_path, APP_THEME() )}}" alt="bike" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="logo-slider-section padding-top padding-bottom">
        <div class="container">
            <div class="logo-slider-main">
                @php
                    $homepage_logo = '';
                    $homepage_logo_key = array_search('homepage-logo', array_column($theme_json,'unique_section_slug'));
                    if($homepage_logo_key != ''){
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                    }
                @endphp

                @if(!empty($homepage_main_logo['homepage-logo-logo-text']))
                    @for ($i = 0; $i <= 10; $i++)
                        @php
                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            {
                                if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                }
                                if(!empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]))
                                {
                                    if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                        $homepage_logo = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                    }
                                }
                            }
                        @endphp
                        <div class="logo-slides">
                            <h4>{{$homepage_logo}}</h4>
                        </div>
                    @endfor
                @else
                    @for ($i = 0; $i <= 10; $i++)
                        @php
                            foreach ($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                            {
                                if($homepage_main_logo_value['field_slug'] == 'homepage-logo-logo-text'){
                                    $homepage_logo = $homepage_main_logo_value['field_default_text'];
                                }
                            }
                        @endphp
                        <div class="logo-slides">
                            <h4>{{$homepage_logo}}</h4>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>


    <section class="bestseller-section tabs-wrapper">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-products-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-btn-text') {
                            $home_btn_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex justify-content-between align-items-center">
                <h2>
                    {{$home_text}}
                </h2>
                <ul class="tabs">
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
                    <div class="bestseller-tab-slider">
                        @foreach ($all_products as $homeproduct)
                            @php
                                $p_id = hashidsencode($homeproduct->id);
                            @endphp
                            @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                                <div class="bestseller-card">
                                    <div class="bestseller-card-inner">
                                        <div class="card-top">
                                            <span>{{$homeproduct->tag_api}}</span>
                                            @auth
                                                <a href="javascript:void(0)" class="wishlist wbwish wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                                                    <span class="wish-ic">
                                                        <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                            style='color: #fff'></i>
                                                    </span>
                                                </a>
                                            @endauth
                                        </div>
                                        <div class="bestseller-card-image">
                                            <a href="{{route('page.product',[$slug,$p_id])}}">
                                                <img src="{{get_file($homeproduct->cover_image_path,APP_THEME())}}" class="default-img">
                                            </a>
                                        </div>
                                        <div class="cart-bottom">
                                            <div class="bestseller-title">
                                                <h3>
                                                    <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                                                        {{$homeproduct->name}}
                                                    </a>
                                                </h3>
                                                <div class="bike-ass-details">
                                                    {{-- <li> --}}
                                                        <p>{!! $homeproduct->description !!}</p>
                                                    {{-- </li> --}}
                                                </div>
                                            </div>

                                            <div class="price">
                                                <ins>{{$homeproduct->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                            </div>
                                            <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                                 {{ __('ADD TO CART')}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                                    viewBox="0 0 22 17" fill="none">
                                                    <path
                                                        d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                        fill="#FF0A0A"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <div class="show-more-div text-right">
                <a href="{{route('page.product-list',$slug)}}" class="btn show-more-btn">
                    {{$home_btn_text}}
                </a>
            </div>
            @endif
        </div>
    </section>


    <section class="best-pro-section padding-bottom">
        <div class="offset-container offset-right">
            <div class="row no-gutters">
                @php
                    $homepage_header_1_key = array_search('homepage-banner', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_header_1_key != '' ) {
                        $homepage_header_1 = $theme_json[$homepage_header_1_key];
                        foreach ($homepage_header_1['inner-list'] as $key => $value) {
                            if($value['field_slug'] == 'homepage-banner-label-text') {
                                $home_label_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-title-text') {
                                $home_title_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-sub-text') {
                                $home_sub_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-btn-text') {
                                $home_btn_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-banner-img') {
                                $home_image = $value['field_default_text'];
                            }
                        }
                    }
                @endphp
                @if($homepage_header_1['section_enable'] == 'on')
                <div class="col-md-6 left-side">
                    <div class="img-wrapper">
                        <img src="{{get_file($home_image , APP_THEME())}}" alt="bike">
                    </div>
                </div>
                <div class="col-md-6 right-side">
                    <div class="right-content">
                        <span class="sub-title">
                            {{$home_label_text}}
                        </span>
                        <div class="section-title">
                            {!!$home_title_text!!}
                        </div>
                        <p>{{$home_sub_text}} </p>
                        <a href="{{route('page.product-list',$slug)}}" class="btn">
                            {{$home_btn_text}}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>


    <section class="product-card-section padding-bottom tabs-wrapper">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-feature-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-feature-products-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex justify-content-between align-items-center">
                <h2>
                    {{$home_text}}
                </h2>
                <ul class="tabs">
                    @foreach ($MainCategory as $cat_key =>  $category)
                        <li class="tab-link {{$cat_key == 0 ? 'active' : ''}}" data-tab="{{ $cat_key }}_data">
                            <a href="javascript:;">{{$category}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tabs-container">
                @foreach ($MainCategory as $cat_k => $category)
                <div id="{{ $cat_k }}_data" class="tab-content {{$cat_k == 0 ? 'active' : ''}}">
                    <div class="product-tab-slider">
                        @foreach ($homeproducts as $homeproduct)
                            @php
                                $p_id = hashidsencode($homeproduct->id);
                            @endphp
                            @if($cat_k == '0' ||  $homeproduct->ProductData()->id == $cat_k)
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="card-top">
                                        <span>{{$homeproduct->tag_api}}</span>
                                        @auth
                                            <a href="javascript:void(0)" class="wishlist wbwish wishbtn-globaly" product_id="{{$homeproduct->id}}" in_wishlist="{{ $homeproduct->in_whishlist ? 'remove' : 'add'}}">
                                                <span class="wish-ic">
                                                    <i class="{{ $homeproduct->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                        style='color: #fff'></i>
                                                </span>
                                            </a>
                                        @endauth
                                    </div>
                                    <div class="product-card-image">
                                        <a href="{{route('page.product',[$slug,$p_id])}}">
                                            <img src="{{get_file($homeproduct->cover_image_path,APP_THEME())}}" class="default-img">
                                        </a>
                                    </div>
                                    <div class="cart-bottom">
                                        <div class="product-title">
                                            <h3>
                                                <a href="{{route('page.product',[$slug,$p_id])}}">
                                                    {{$homeproduct->name}}
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="price">
                                            <ins>{{$homeproduct->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                        </div>
                                        <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $homeproduct->id }}" variant_id="{{ $homeproduct->default_variant_id }}" qty="1">
                                                 {{ __('ADD TO CART')}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                                viewBox="0 0 22 17" fill="none">
                                                <path
                                                    d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                    fill="#FF0A0A"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>


    <section class="services-section">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-products', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-products-title-text') {
                            $home_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-products-btn-text') {
                            $home_btn_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex justify-content-between align-items-center">
                <h2>{{$home_text}}</h2>
                <a href="{{route('page.product-list',$slug)}}" class="btn show-more-btn">
                    {{$home_btn_text}}
                </a>
            </div>
            @endif
            <div class="row service-row">
                @php
                    $homepage_logo_key = array_search('homepage-info', array_column($theme_json,'unique_section_slug'));
                    if($homepage_logo_key != ''){
                        $homepage_main_logo = $theme_json[$homepage_logo_key];
                        $section_enable = $homepage_main_logo['section_enable'];
                    }
                @endphp
                @for ($i = 0; $i < $homepage_main_logo['loop_number']; $i++)
                    @foreach($homepage_main_logo['inner-list'] as $homepage_main_logo_value)
                        @php
                            if($homepage_main_logo_value['field_slug'] == 'homepage-info-icon')
                            {
                                $homepage_image = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_image = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i]['field_prev_text'];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-info-title-text') {
                                $homepage_text = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_text = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-info-sub-text') {
                                $homepage_text2 = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_text2 = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                            if($homepage_main_logo_value['field_slug'] == 'homepage-info-btn-text') {
                                $homepage_btn = $homepage_main_logo_value['field_default_text'];
                                if( !empty($homepage_main_logo[$homepage_main_logo_value['field_slug']]) ) {
                                    $homepage_btn = $homepage_main_logo[$homepage_main_logo_value['field_slug']][$i];
                                }
                            }
                        @endphp
                    @endforeach
                    <div class="col-md-4 col-sm-6 col-12 service-col">
                        <div class="service-card">
                            <div class="img-wrapper">
                                <img src="{{get_file($homepage_image , APP_THEME())}}" alt="service">
                            </div>
                            <h3>
                                {{$homepage_text}}
                            </h3>
                            <p>{{$homepage_text2}}</p>
                            <a href="{{route('page.product-list',$slug)}}" class="btn white-btn">
                                {{$homepage_btn}}
                            </a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>


    <section class="testimonials-section padding-bottom">
        <div class="container">
            <div class="testi-main-slider">
                @foreach($reviews as $review)
                @php
                    $r_id = hashidsencode($review->ProductData->id);
                @endphp
                <div class="testi-slides">
                    <div class="testi-inner">
                        <div class="img-wrapper">
                            <a href="{{route('page.product',[$slug,$r_id])}}">
                                <img src="{{ asset('/'. !empty($review->ProductData()) ? get_file($review->ProductData->cover_image_path , APP_THEME()) : '' ) }}" alt="testimonial-product">
                            </a>
                        </div>
                        <div class="ratings d-flex align-items-center">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fa fa-star {{ $i < $review->rating_no ? 'text-warning' : '' }}"></i>
                            @endfor
                            <span><b>{{$review->rating_no}}.0</b> / 5.0</span>
                         </div>
                         <h3>{!! $review->title !!}</h3>
                         <p>{{$review->description}}</p>
                         {{-- <h6>WSR-690 Superbike</h6> --}}
                         <span class="user-name"><a href="#">{{!empty($review->UserData()) ? $review->UserData->first_name : '' }}</a> Client </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="card-tab-slider-sec padding-top tabs-wrapper padding-bottom">
        @php
            $homepage_header_1_key = array_search('homepage-bestseller', array_column($theme_json, 'unique_section_slug'));
            if($homepage_header_1_key != '' ) {
                $homepage_header_1 = $theme_json[$homepage_header_1_key];
                foreach ($homepage_header_1['inner-list'] as $key => $value) {
                    if($value['field_slug'] == 'homepage-bestseller-title-text') {
                        $home_label_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'homepage-bestseller-bg-img') {
                        $home_image = $value['field_default_text'];
                    }
                }
            }
        @endphp
        @if($homepage_header_1['section_enable'] == 'on')
        <div class="container">
            <div class="section-title d-flex justify-content-between align-items-center">
                <h2>
                    {{$home_label_text}}
                </h2>
            </div>
        </div>
        <div class="offset-container offset-left">
            <div class="row no-gutters">
                <div class="col-lg-8 col-12">
                    <div class="card-tab-main-slider">
                        @foreach($bestSeller as $bestSellers)
                        @php
                            $p_id = hashidsencode($bestSellers->id);
                        @endphp
                        <div class="product-card">
                            <div class="product-card-inner">
                                <div class="product-card-image">
                                    <a href="{{route('page.product',[$slug,$p_id])}}">
                                        <img src="{{get_file($bestSellers->cover_image_path ,APP_THEME())}}" class="default-img">
                                    </a>
                                </div>
                                <div class="cart-bottom">
                                    <div class="card-top">
                                        <span>{{$bestSellers->tag_api}}</span>
                                        @auth
                                            <a href="javascript:void(0)" class="wishlist wbwish  wishbtn-globaly" product_id="{{$bestSellers->id}}" in_wishlist="{{ $bestSellers->in_whishlist ? 'remove' : 'add'}}">
                                                <span class="wish-ic">
                                                    <i class="{{ $bestSellers->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"
                                                        style='color: rgb(255, 254, 254)'></i>
                                                </span>
                                            </a>
                                        @endauth
                                    </div>
                                        {{-- {!! \App\Models\Review::ProductReview(1,$bestSellers->id) !!} --}}
                                    <div class="product-title">
                                        <h3>
                                            <a href="{{route('page.product',[$slug,$p_id])}}" class="short-description">
                                                {{$bestSellers->name}}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="price">
                                        <ins>{{$bestSellers->final_price}}<span class="currency-type">{{$currency}}</span></ins>
                                    </div>
                                    <a href="javascript:void(0)" class="btn addcart-btn-globaly" type="submit" product_id="{{ $bestSellers->id }}" variant_id="{{ $bestSellers->default_variant_id }}" qty="1">
                                        {{ __('ADD TO CART')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17"
                                            viewBox="0 0 22 17" fill="none">
                                            <path
                                                d="M17.9581 9.17105C17.7655 9.17169 17.5735 9.19217 17.385 9.23218L17.1405 8.5139C17.3064 8.46825 17.4748 8.43252 17.6448 8.40692H20.6326C20.8352 8.40692 21.0296 8.32642 21.1729 8.18312C21.3162 8.03982 21.3967 7.84546 21.3967 7.6428C21.4209 6.52521 21.2049 5.41545 20.7633 4.38853C20.3217 3.36161 19.6647 2.44146 18.8369 1.69029C17.6307 0.689417 16.1375 0.0980206 14.5731 0.00158359C14.4685 -0.00515881 14.3637 0.00967709 14.2651 0.0451693C14.1665 0.0806614 14.0763 0.136051 14 0.207896C13.9232 0.279143 13.8618 0.365426 13.8197 0.461386C13.7777 0.557346 13.7558 0.660931 13.7555 0.765706H12.2272C12.0246 0.765706 11.8302 0.846211 11.6869 0.989512C11.5436 1.13281 11.4631 1.32717 11.4631 1.52983C11.4631 1.73249 11.5436 1.92684 11.6869 2.07014C11.8302 2.21344 12.0246 2.29395 12.2272 2.29395H13.7555V3.05807H13.3963C12.9028 3.05642 12.4186 3.19296 11.9986 3.45224C11.5786 3.71152 11.2396 4.08319 11.0199 4.52519V4.58631H8.72754L8.20794 4.05907C7.6433 3.49768 6.93963 3.09642 6.16895 2.89637C5.39827 2.69632 4.58827 2.70465 3.82188 2.92053L0.559075 3.82219C0.42464 3.86093 0.303421 3.93584 0.208635 4.03874C0.113848 4.14164 0.0491319 4.26859 0.0215426 4.40575C-0.00604668 4.54291 0.00454971 4.68501 0.0521765 4.81656C0.0998033 4.94811 0.182632 5.06406 0.291633 5.15176L7.16873 10.6687H6.29763C5.8878 10.0553 5.29157 9.59003 4.597 9.3415C3.90244 9.09297 3.14635 9.0744 2.44042 9.28854C1.73449 9.50267 1.11614 9.93816 0.67669 10.5307C0.237243 11.1232 0 11.8413 0 12.579C0 13.3167 0.237243 14.0349 0.67669 14.6274C1.11614 15.2199 1.73449 15.6554 2.44042 15.8695C3.14635 16.0837 3.90244 16.0651 4.597 15.8166C5.29157 15.568 5.8878 15.1027 6.29763 14.4893H12.9913C13.0993 14.4902 13.2061 14.4681 13.3049 14.4246C13.4037 14.3812 13.4921 14.3173 13.5644 14.2372C13.6352 14.1563 13.6881 14.0614 13.7197 13.9587C13.7513 13.856 13.7609 13.7478 13.7478 13.6412C13.6348 12.7846 13.7614 11.9134 14.1134 11.1243C14.4655 10.3353 15.0292 9.65917 15.7422 9.17105L15.9638 9.84347C15.3085 10.329 14.848 11.0326 14.6654 11.8274C14.4827 12.6223 14.5899 13.4563 14.9675 14.1792C15.3452 14.902 15.9685 15.4663 16.7253 15.7704C17.4821 16.0745 18.3226 16.0985 19.0954 15.8379C19.8683 15.5773 20.5227 15.0494 20.9408 14.3491C21.359 13.6489 21.5134 12.8224 21.3762 12.0184C21.2391 11.2144 20.8194 10.4858 20.1927 9.9638C19.5661 9.44179 18.7737 9.16067 17.9581 9.17105ZM3.43982 14.5199C3.06199 14.5199 2.69265 14.4079 2.37851 14.198C2.06436 13.988 1.81951 13.6897 1.67492 13.3406C1.53034 12.9916 1.49251 12.6075 1.56622 12.2369C1.63993 11.8664 1.82186 11.526 2.08903 11.2588C2.35619 10.9916 2.69657 10.8097 3.06713 10.736C3.4377 10.6623 3.82179 10.7001 4.17086 10.8447C4.51992 10.9893 4.81827 11.2341 5.02818 11.5483C5.23808 11.8624 5.35012 12.2318 5.35012 12.6096C5.35012 12.8605 5.30071 13.1089 5.20471 13.3406C5.10871 13.5724 4.96799 13.783 4.7906 13.9604C4.61322 14.1378 4.40263 14.2785 4.17086 14.3745C3.93909 14.4705 3.69068 14.5199 3.43982 14.5199ZM13.9771 8.62852C12.8617 9.80845 12.2362 11.368 12.2272 12.9917H6.87836C6.89866 12.8652 6.91142 12.7376 6.91657 12.6096C6.91142 12.4816 6.89866 12.354 6.87836 12.2275H8.40661C8.52076 12.2279 8.63356 12.2027 8.7367 12.1538C8.83984 12.1049 8.93071 12.0335 9.00262 11.9448L10.0724 10.6C10.5717 9.96961 11.1961 9.44938 11.9062 9.07197C12.6163 8.69456 13.3968 8.46813 14.1987 8.40692L13.9771 8.62852ZM14.6418 6.87868C13.5351 6.87578 12.4421 7.12307 11.4444 7.60207C10.4467 8.08106 9.57019 8.77938 8.88036 9.6448L8.65877 9.91989L2.40061 4.91489L4.22686 4.39528C4.73261 4.25229 5.26749 4.24777 5.77559 4.38219C6.28369 4.51661 6.74636 4.78503 7.11524 5.15941L7.87936 5.92353C8.02455 6.05172 8.213 6.12 8.40661 6.11456H11.4631C11.6042 6.11413 11.7424 6.07464 11.8625 6.00046C11.9825 5.92628 12.0797 5.82031 12.1432 5.69429L12.3877 5.20525C12.4815 5.01844 12.6257 4.86153 12.8039 4.75218C12.9821 4.64284 13.1873 4.58539 13.3963 4.58631H14.5196C14.7222 4.58631 14.9166 4.50581 15.0599 4.36251C15.2032 4.21921 15.2837 4.02485 15.2837 3.82219V1.64445C16.2275 1.83071 17.1084 2.25408 17.8435 2.87468C19.0104 3.89764 19.7361 5.33254 19.8684 6.87868H14.6724H14.6418ZM17.9581 14.5199C17.5952 14.5217 17.2394 14.4196 16.9325 14.2257C16.6257 14.0319 16.3808 13.7543 16.2265 13.4258C16.0723 13.0973 16.0153 12.7315 16.0621 12.3716C16.109 12.0117 16.2578 11.6727 16.491 11.3946L16.8502 12.4721C16.9014 12.6238 16.9991 12.7556 17.1293 12.8489C17.2596 12.9421 17.4159 12.9921 17.5761 12.9917C17.6589 12.9896 17.7411 12.9767 17.8206 12.9535C17.9195 12.9255 18.0118 12.878 18.0919 12.8136C18.172 12.7492 18.2382 12.6693 18.2867 12.5787C18.3353 12.4881 18.365 12.3887 18.3742 12.2863C18.3834 12.184 18.3718 12.0808 18.3402 11.983L17.8741 10.6993H17.9581C18.4648 10.6993 18.9507 10.9006 19.3089 11.2588C19.6672 11.6171 19.8684 12.103 19.8684 12.6096C19.8684 13.1162 19.6672 13.6021 19.3089 13.9604C18.9507 14.3186 18.4648 14.5199 17.9581 14.5199Z"
                                                fill="#FF0A0A"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-12 img-col">
                    <div class="img-wrapper">
                        <img src="{{get_file($home_image ,APP_THEME())}}" alt="card-tab">
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>


    <section class="blog-section padding-bottom padding-top">
        <div class="container">
            @php
                $homepage_header_1_key = array_search('homepage-blog', array_column($theme_json, 'unique_section_slug'));
                if($homepage_header_1_key != '' ) {
                    $homepage_header_1 = $theme_json[$homepage_header_1_key];
                    foreach ($homepage_header_1['inner-list'] as $key => $value) {
                        if($value['field_slug'] == 'homepage-blog-title-text') {
                            $home_label_text = $value['field_default_text'];
                        }
                        if($value['field_slug'] == 'homepage-blog-btn-text') {
                            $home_btn_text = $value['field_default_text'];
                        }
                    }
                }
            @endphp
            @if($homepage_header_1['section_enable'] == 'on')
            <div class="section-title d-flex justify-content-between align-items-center">
                <h2>{!! $home_label_text !!}</h2>
                <a href="#" class="btn show-more-btn">
                    {{$home_btn_text}}
                 </a>
            </div>
            @endif

            {!! \App\Models\Blog::HomePageBlog($slug,12) !!}
        </div>
    </section>

</div>


@endsection
