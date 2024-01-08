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
    <div class="wrapper" style="margin-top: 128.391px;">
        <section class="cart-page-section padding-bottom min-padding-top">
            <div class="container">
                <div class="section-title">
                    <a href="{{route('page.product-list',$slug)}}" class="back-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                            <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                               d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z"
                               fill="white" />
                         </svg>
                         <span> {{__('Back to shop')}}</span>
                    </a>
                </div>
            </div>
        </section>
        <section class="filter-sec mb-6">
               {!! \App\Models\Cart::CartPageBestseller() !!}
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
