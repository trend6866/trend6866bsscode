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
        $homepage_custom_banner_img = $homepage_custom_banner_label = $homepage_custom_banner_title = $homepage_custom_banner_sub_text = $homepage_custom_banner_text = '';

        $homepage_custom_banner = array_search('homepage-custom-banner', array_column($theme_json, 'unique_section_slug'));
        if($homepage_custom_banner != '' ){
            $homepage_custom_banner_value = $theme_json[$homepage_custom_banner];

            foreach ($homepage_custom_banner_value['inner-list'] as $key => $value) {
                if($value['field_slug'] == 'homepage-custom-banner-bg-image') {
                    $homepage_custom_banner_img = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-custom-banner-label') {
                    $homepage_custom_banner_label = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-custom-banner-title') {
                    $homepage_custom_banner_title = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-custom-banner-sub-text') {
                    $homepage_custom_banner_sub_text = $value['field_default_text'];
                }
                if($value['field_slug'] == 'homepage-custom-banner-text') {
                    $homepage_custom_banner_text = $value['field_default_text'];
                }
            }
        }
    @endphp

    <section class="custom-banner-section-two custom-banner-section-two-pdp">
        <div class="container">
            <div class="custom-banner-two" style="background-image: url({{get_file($homepage_custom_banner_img,APP_THEME())}});">
                <div class="custom-banner-inner">                   <div class="label">{!! $homepage_custom_banner_label !!}</div>
                <h2>{!! $homepage_custom_banner_title !!}</h2>
                <p>{!! $homepage_custom_banner_sub_text !!}</p>
                <form class="footer-subscribe-form" action="{{ route("newsletter.store",$slug) }}" method="post">
                    @csrf
                   <div class="input-box">
                      <input type="email" placeholder="Type your address email......" name="email">
                      <button class="btn-subscibe">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6883 2.12059C14.0686 1.54545 15.4534 2.93023 14.8782 4.31056L10.9102 13.8338C10.1342 15.6962 7.40464 15.3814 7.07295 13.3912L6.5779 10.4209L3.60764 9.92589C1.61746 9.5942 1.30266 6.8646 3.16509 6.08859L12.6883 2.12059ZM13.6416 3.79527C13.7566 3.51921 13.4796 3.24225 13.2036 3.35728L3.68037 7.32528C3.05956 7.58395 3.1645 8.49381 3.82789 8.60438L6.79816 9.09942C7.36282 9.19353 7.80531 9.63602 7.89942 10.2007L8.39446 13.171C8.50503 13.8343 9.41489 13.9393 9.67356 13.3185L13.6416 3.79527Z" fill="#12131A"/>
                        </svg>
                      </button>
                   </div>
                   <div class="checkbox">
                      {{-- <input type="checkbox" id="footercheck" name="footercheck"> --}}
                      <label for="footercheck">
                         {!! $homepage_custom_banner_text !!}
                      </label>
                   </div>
                </form>
                </div>
            </div>
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
