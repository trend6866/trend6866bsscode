
@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection

@section('content')
    @php
        $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
    @endphp

    <section class="cart-page-section padding-bottom">
    </section>

    <section class="bestseller-section product-card-section product-list padding-bottom">
        {!! \App\Models\Cart::CartPageBestseller($slug) !!}
    </section>
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
