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
        $homepage_store_title = '';

        $homepage_store = array_search('online-store-section', array_column($theme_json, 'unique_section_slug'));
        if($homepage_store != '' ){
            $homepage_store_value = $theme_json[$homepage_store];

            foreach ($homepage_store_value['inner-list'] as $key => $value) {

                if($value['field_slug'] == 'online-store-section-title') {
                    $homepage_store_title = $value['field_default_text'];
                }

                //Dynamic
                if(!empty($homepage_store_value[$value['field_slug']]))
                {
                    if($value['field_slug'] == 'online-store-section-title'){
                        $homepage_store_title = $homepage_store_value[$value['field_slug']][$i];
                    }

                }
            }
        }
    @endphp
     <section class="online-store-section tabs-wrapper padding-top padding-bottom">
        @php
        $theme_json = $homepage_json;

    $homepage_store_title = '';

    $homepage_store = array_search('online-store-section', array_column($theme_json, 'unique_section_slug'));
    if($homepage_store != '' ){
        $homepage_store_value = $theme_json[$homepage_store];

        foreach ($homepage_store_value['inner-list'] as $key => $value) {

            if($value['field_slug'] == 'online-store-section-title') {
                $homepage_store_title = $value['field_default_text'];
            }

            //Dynamic
            if(!empty($homepage_store_value[$value['field_slug']]))
            {
                if($value['field_slug'] == 'online-store-section-title'){
                    $homepage_store_title = $homepage_store_value[$value['field_slug']][$i];
                }

            }
        }
    }
    @endphp

    <div class="container">
    <div class="section-title d-flex justify-content-between align-items-center">

        {!! $homepage_store_title !!}
        {!! \App\Models\Cart::CartPageBestseller($slug ,$no =10) !!}

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
