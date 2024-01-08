@extends('layouts.layouts')

@section('page-title')
    {{ __('Cart') }}
@endsection

@section('content')

@php
    $currency = App\Models\Utility::GetValueByName('CURRENCY_NAME');
    $currency_icon = App\Models\Utility::GetValueByName('CURRENCY');
@endphp
<div class="wrapper">
        <section class="cart-page-section padding-bottom">

        </section>

        <section class="product-categories-section padding-bottom prod-listing-cat">
            {!! \App\Models\Cart::CartPageBestseller() !!}
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
