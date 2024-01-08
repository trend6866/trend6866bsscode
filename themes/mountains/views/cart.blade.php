@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection


@section('content')
    @php
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    @endphp
    <div class="wrapper wrapper-top">
        <section class="cart-page-section padding-bottom">

        </section>

        @php
            $home_pro_card_sec = '';

            $home_pro_card_sec = array_search('home-pro-card-section', array_column($theme_json, 'unique_section_slug'));
            if($home_pro_card_sec != '' ){
                $home_pro_card_sec_value = $theme_json[$home_pro_card_sec];

                foreach ($home_pro_card_sec_value['inner-list'] as $key => $value) {

                    if($value['field_slug'] == 'home-pro-card-section-title') {
                        $home_pro_card_sec_text = $value['field_default_text'];
                    }
                    if($value['field_slug'] == 'home-pro-card-section-button') {
                        $home_pro_card_sec_btn = $value['field_default_text'];
                    }
                }
            }

        @endphp
        <section class="img-product-card product-list-page padding-bottom">
            <div class="container">
                @php
                    $homepage_card_title = '';

                    $homepage_card = array_search('homepage-card', array_column($theme_json, 'unique_section_slug'));
                    if($homepage_card != '' ){
                        $homepage_card_value = $theme_json[$homepage_card];

                        foreach ($homepage_card_value['inner-list'] as $key => $value) {

                            if($value['field_slug'] == 'homepage-card-label-text') {
                                $homepage_card_title = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-card-title-text') {
                                $homepage_card_text = $value['field_default_text'];
                            }
                            if($value['field_slug'] == 'homepage-card-sub-text') {
                                $homepage_card_sub = $value['field_default_text'];
                            }


                            //Dynamic
                            if(!empty($homepage_card_value[$value['field_slug']]))
                            {
                                if($value['field_slug'] == 'homepage-card-label-text'){
                                    $homepage_card_title = $homepage_card_value[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'homepage-card-title-text'){
                                    $homepage_card_image = $homepage_card_value[$value['field_slug']][$i];
                                }
                                if($value['field_slug'] == 'homepage-card-sub-text'){
                                    $homepage_card_sub = $homepage_card_value[$value['field_slug']][$i];
                                }
                            }
                        }
                    }
                @endphp

                <div class="section-title">
                    <span class="subtitle">{{ $homepage_card_title }}</span>
                    <h2>
                        {!! $homepage_card_text !!}
                    </h2>
                </div>
                
                    {!! \App\Models\Cart::CartPageBestseller() !!}
                
            </div>
        </section>
    </div>
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
