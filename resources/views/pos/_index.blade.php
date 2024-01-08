@php
    $logo= get_file('uploads/logo');
    $theme_name = !empty(APP_THEME()) ? APP_THEME() : '';
    $company_favicon= \App\Models\Utility::getValByName('company_favicon');
    $cust_darklayout = \App\Models\Utility::GetValueByName('cust_darklayout',$theme_name);
    $cust_theme_bg = \App\Models\Utility::GetValueByName('cust_theme_bg',$theme_name);
    $SITE_RTL = \App\Models\Utility::GetValueByName('SITE_RTL',$theme_name);
    $settings = \App\Models\Setting::where('store_id',getCurrentStore())->where('theme_id', $theme_name)->pluck('value', 'name')->toArray();
    $store_id = \App\Models\Store::where('id', getCurrentStore())->first();
    $Tax = \App\Models\Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('store_id', $store_id->id)->where('theme_id', $store_id->theme_id)->get();
    $color = 'theme-3';
    if (!empty($settings['color'])) {
        $color = $settings['color'];
    }
@endphp
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{ !empty($companySettings['header_text']) ? $companySettings['header_text']->value : config('app.name', 'Storego Saas') }}
        - {{ __('POS') }}</title>

    <link rel="icon"
          href="{{ asset(Storage::url('uploads/logo/')) . '/' . (isset($companySettings['company_favicon']) && !empty($companySettings['company_favicon']) ? $companySettings['company_favicon']->value : 'favicon.png') }}"
          type="image" sizes="16x16">


    <meta name="base-url" content="{{URL::to('/')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/material.css') }}">

    <!-- notification css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/plugins/notifier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}{{ "?v=".time() }}">

    <style>
        .bg-color{
            @if($color=='theme-1')
                background :linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d;
            @elseif($color=='theme-2')
                background : linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, #4ebbd3 99.86%), #1f3996;
            @elseif($color=='theme-3')
                background :  linear-gradient(141.55deg, #E9FFDF 3.46%, #E9FFDF 99.86%), #E9FFDF;
            @elseif($color=='theme-4')
                background :  linear-gradient(141.55deg, rgba(104, 94, 229, 0) 3.46%, #685ee5 99.86%), #584ed2;
            @endif
        }
    </style>

    @stack('css-page')
</head>

<body class="{{ $color }}">
    <div class="container-fluid px-2">
        <?php $lastsegment = request()->segment(count(request()->segments())) ?>
            <div class="row">
                <div class="col-12">
                    <div class="mt-2 pos-top-bar bg-primary d-flex justify-content-between">
                        <span class="text-white">{{__('POS')}}</span>
                        <a  href="{{ route('admin.dashboard') }}" class="text-white"><i class="ti ti-home" style="font-size: 20px;"></i> </a>
                    </div>
                </div>
            </div>
            <div class="mt-2 row">
                <div class="col-lg-7">
                    <div class="sop-card card">
                        <div class="card-header p-2">
                            <div class="search-bar-left">
                                <form>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                                        </div>
                                        <input id="searchproduct" type="text" data-url="{{ route('admin.search.products') }}" placeholder="{{ __('Search Product') }}" class="form-control pr-4 rounded-right">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <div class="right-content">
                                <div class="button-list b-bottom catgory-pad mb-4">
                                    <div class="form-row m-0" id="categories-listing">
                                    </div>
                                </div>
                                <div class="product-body-nop">
                                    <div class="form-row row" id="product-listing">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 ps-lg-0">
                    <div class="card m-0">
                        <div class="card-header p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::select('customer_id',$customers,'', array('class' => 'form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                    {{ Form::hidden('vc_name_hidden', '',['id' => 'vc_name_hidden']) }}
                                    <input type="hidden" id="store_id" value="{{ \Auth::user()->current_store }}">
                                    <input type="hidden" id="theme_id" value="{{ $theme_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-body carttable cart-product-list carttable-scroll" id="carthtml">
                            @php $total = 0 @endphp
                            <div class="table-responsive">
                                <table class="table pos-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-left">{{__('Name')}}</th>
                                        <th class="text-center">{{__('QTY')}}</th>
                                        <th>{{__('Tax')}}</th>
                                        <th class="text-center">{{__('Price')}}</th>
                                        <th class="text-center">{{__('Sub Total')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                        @foreach(session($lastsegment) as $id => $details)
                                            @php
                                                $product = \App\Models\Product::find($details['id']);
                                                $image_url = !empty($product->cover_image_path) ? $product->cover_image_path : 'default.jpg';
                                                $total = $total + (float) $details['total_orignal_price'];
                                            @endphp
                                            @if(\Auth::user()->current_store == $product->store_id)
                                                <tr data-product-id="{{$id}}" id="product-id-{{$id}}">
                                                    <td class="cart-images">
                                                        <img alt="Image placeholder" src="{{ get_file($image_url) }}" class="card-image avatar rounded-circle-sale shadow hover-shadow-lg">
                                                    </td>
                                                    <td class="text-left name">{{ $details['name'] }}</td>
                                                    <td>
                                                        <span class="quantity buttons_added">
                                                            <input type="button" value="-" class="minus">
                                                            <input type="number" step="1" min="1" max="" name="quantity"
                                                                title="{{ __('Quantity') }}" class="input-number"
                                                                data-url="{{ url('admin/update-cart/') }}" data-id="{{ $id }}"
                                                                size="4" value="{{ $details['quantity'] }}" style="width:50px;">
                                                            <input type="button" value="+" class="plus">
                                                        </span>
                                                    </td>

                                                    <td class=" cart-summary-table">
                                                        @foreach ($Tax as $key1 => $value1)
                                                            <span class="badge badge-primary"> {{ $value1->tax_name }} {{ $value1->tax_amount }}%</span><br>
                                                        @endforeach
                                                    </td>

                                                    <td class="price text-center">{{ SetNumberFormat($details['orignal_price']) }}</td>

                                                    <td class="text-center">
                                                        <span class="total_orignal_price">{{ SetNumberFormat($details['total_orignal_price']) }}</span>
                                                    </td>
                                                    <td>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.remove-from-cart'],'id' => 'delete-form-'.$id]) !!}
                                                        <button type="button" class="show_confirm btn btn-sm btn-icon bg-danger ">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                        <input type="hidden" name="session_key" value="{{ $lastsegment }}">
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr class="text-center no-found">
                                            <td colspan="7">{{__('No Data Found.!')}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="total-section mt-3">
                                <div class="row align-items-center">
                                    <div class="col-md-6 col-12">
                                        <div class="left-inner ">
                                        <div class="d-flex text-end justify-content-end align-items-center">
                                            <span class="input-group-text bg-transparent">{{SetNumberFormat()}}</span>
                                            {{ Form::number('discount',null, array('class' => ' form-control discount','required'=>'required','placeholder'=>__('Discount'))) }}
                                            {{ Form::hidden('discount_hidden', '',['id' => 'discount_hidden']) }}
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="right-inner mt-3">
                                            <div class="d-flex text-end justify-content-md-end  justify-content-flex-start">
                                                <h6 class="mb-0 text-dark">{{__('Sub Total')}} :</h6>
                                                <h6 class="mb-0 text-dark subtotal_price" id="displaytotal">{{  SetNumberFormat($total) }}</h6>
                                            </div>

                                        <div class="d-flex align-items-center justify-content-md-end  justify-content-flex-start">
                                            <h6 class="">{{__('Total')}} :</h6>
                                            <h6 class="totalamount" >{{ SetNumberFormat($total) }}</h6>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-3" id="btn-pur">
                                    @can('Create Pos')
                                        <button type="button" class="btn btn-primary rounded"  data-ajax-popup="true" data-size="xl"
                                                data-align="centered" data-url="{{route('admin.pos.create')}}" data-title="{{__('POS Invoice')}}"
                                                @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                            {{ __('PAY') }}
                                        </button>
                                    @endcan
                                    <div class="tab-content btn-empty text-end">
                                        {!! Form::open(['method' => 'post', 'route' => ['admin.empty-cart'],'id' => 'delete-form-emptycart']) !!}
                                        <a href="#" class="btn btn-danger show_confirm rounded m-0"  >{{ __('Empty Cart') }}
                                        </a>
                                        <input type="hidden" name="session_key" value="{{ $lastsegment }}" id="empty_cart">
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


<!-- Required Js -->
<script src="{{ asset('public/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('public/assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('public/js/jquery.form.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/feather.min.js') }}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-switch-button.min.js')}}"></script>
<script src="{{ asset('public/assets/js/dash.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/simple-datatables.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('public/assets/js/pages/ac-notification.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins/choices.min.js') }}{{ "?".time() }}"></script>
<script src="{{ asset('public/js/custom.js') }}{{ "?".time() }}"></script>


<!-- Apex Chart -->
<script src="{{ asset('public/assets/js/plugins/apexcharts.min.js') }}"></script>

@if ($message = Session::get('success'))
    <script>
        show_toastr('{{ __('Success') }}', '{!! $message !!}', 'success')
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        show_toastr('{{ __('Error') }}', '{!! $message !!}', 'error')
    </script>
@endif
@stack('script-page')

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).ready(function() {

        $( "#vc_name_hidden" ).val($('.customer_select').val());
        $( "#discount_hidden").val($('.discount').val());

        $(function () {
            getProductCategories();

        });

        if ($('#searchproduct').length > 0) {
            var url = $('#searchproduct').data('url');
            var store_id = $( "#store_id" ).val();
            searchProducts(url,'','0',store_id);
        }

        {{--  $( '#warehouse' ).change(function() {
           var ware_id = $( "#warehouse" ).val();
            searchProducts(url,'','0',ware_id);
        });  --}}
        $( '.customer_select' ).change(function() {
            $( "#vc_name_hidden" ).val($(this).val());
        });

        $(document).on('click', '#clearinput', function (e) {
            var IDs = [];
            $(this).closest('div').find("input").each(function () {
                IDs.push('#' + this.id);
            });
            $(IDs.toString()).val('');
        });

        $(document).on('keyup', 'input#searchproduct', function () {
            var url = $(this).data('url');
            var value = this.value;
            var cat = $('.cat-active').children().data('cat-id');
            var store_id = $( "#store_id" ).val();
            searchProducts(url, value,cat,store_id);
        });


        function searchProducts(url, value,cat_id,store_id = '0') {
            var session_key = $('#empty_cart').val();
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'search': value,
                    'cat_id': cat_id,
                    'store_id' : store_id,
                    'session_key': session_key
                },
                success: function (data) {
                    $('#product-listing').html(data);
                }
            });
        }

        function getProductCategories() {
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.product.categories') }}',
                success: function (data) {

                    $('#categories-listing').html(data);
                }
            });
        }

        $(document).on('click', '.toacart', function () {

            var sum = 0
            $.ajax({
                url: $(this).data('url'),

                success: function (data) {

                    if (data.code == '200') {

                        $('#displaytotal').text(addCommas(data.product.total_orignal_price));
                        $('.totalamount').text(addCommas(data.product.total_orignal_price));

                        if ('carttotal' in data) {
                            $.each(data.carttotal, function (key, value) {
                                $('#product-id-' + value.id + ' .total_orignal_price').text(addCommas(value.total_orignal_price));
                                sum += value.total_orignal_price;
                            });
                            $('#displaytotal').text(addCommas(sum));

                            $('.totalamount').text(addCommas(sum));

                       $('.discount').val('');
                        }

                        $('#tbody').append(data.carthtml);
                        $('.no-found').addClass('d-none');
                        $('.carttable #product-id-' + data.product.id + ' input[name="quantity"]').val(data.product.quantity);
                        $('#btn-pur button').removeAttr('disabled');
                        $('.btn-empty button').addClass('btn-clear-cart');

                        }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }
            });
        });

        $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
            e.preventDefault();
            var ele = $(this);
            var sum = 0;
            var quantity = ele.closest('span').find('input[name="quantity"]').val();
            var discount = $('.discount').val();
            var session_key = $('#empty_cart').val();
            if(quantity != 0 && quantity != null)
            {
                $.ajax({
                    url: ele.data('url'),
                    method: "patch",
                    data: {
                        id: ele.attr("data-id"),
                        quantity: quantity,
                        discount:discount,
                        session_key: session_key
                    },
                    success: function (data) {

                        if (data.code == '200') {

                            if (quantity == 0) {
                                ele.closest(".row").hide(250, function () {
                                    ele.closest(".row").remove();
                                });
                                if (ele.closest(".row").is(":last-child")) {
                                    $('#btn-pur button').attr('disabled', 'disabled');
                                    $('.btn-empty button').removeClass('btn-clear-cart');
                                }
                            }

                            $.each(data.product, function (key, value) {
                                sum += value.total_orignal_price;
                                $('#product-id-' + value.id + ' .total_orignal_price').text(addCommas(value.total_orignal_price));
                            });

                            $('#displaytotal').text(addCommas(sum));
                            console.log(sum, data);
                            if(discount <= sum){
                                $('.totalamount').text(data.discount);
                            }
                            else{
                                $('.totalamount').text(addCommas(0));
                            }
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.remove-from-cart', function (e) {
            e.preventDefault();

            var ele = $(this);
            var sum = 0;

            if (confirm('{{ __("Are you sure?") }}')) {
                ele.closest(".row").hide(250, function () {
                    ele.closest(".row").parent().parent().remove();
                });
                if (ele.closest(".row").is(":last-child")) {
                    $('#btn-pur button').attr('disabled', 'disabled');
                    $('.btn-empty button').removeClass('btn-clear-cart');
                }
                $.ajax({
                    url: ele.data('url'),
                    method: "DELETE",
                    data: {
                        id: ele.attr("data-id"),

                    },
                    success: function (data) {
                        if (data.code == '200') {

                            $.each(data.product, function (key, value) {
                                sum += value.total_orignal_price;
                                $('#product-id-' + value.id + ' .total_orignal_price').text(addCommas(value.total_orignal_price));
                            });

                            $('#displaytotal').text(addCommas(sum));

                            show_toastr('success', data.success, 'success')
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-clear-cart', function (e) {
            e.preventDefault();

            if (confirm('{{ __("Remove all items from cart?") }}')) {

                $.ajax({
                    url: $(this).data('url'),
                    data: {
                        session_key: session_key
                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-done-payment', function (e) {
            e.preventDefault();
            var ele = $(this);

            $.ajax({
                url: ele.data('url'),

                method: 'GET',
                data: {
                    vc_name: $('#vc_name_hidden').val(),
                    warehouse_name: $('#warehouse_name_hidden').val(),
                    discount : $('#discount_hidden').val(),
                },
                beforeSend: function () {
                    ele.remove();
                },
                success: function (data) {

                    if (data.code == 200) {
                        show_toastr('success', data.success, 'success')
                    }

                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }

            });

        });

        $(document).on('click', '.category-select', function (e) {
            var cat = $(this).data('cat-id');
            var white = 'text-white';
            var dark = 'text-dark';
            $('.category-select').find('.tab-btns').removeClass('btn-primary')
            $(this).find('.tab-btns').addClass('btn-primary')
            $('.category-select').parent().removeClass('cat-active');
            $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
            $('.category-select').find('.card-title').parent().removeClass('text-white').addClass('text-dark');
            $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
            $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
            $(this).parent().addClass('cat-active');
            var url = '{{ route('admin.search.products') }}'
            var store_id=$('#store_id').val();
            searchProducts(url,'',cat,store_id);
        });



        $(document).on('keyup', '.discount', function () {
            var discount = $('.discount').val();
            var total = $('#displaytotal').text();
            var maintotal = parseFloat(total.replace("$","").replace(",",""))
            if(discount <= maintotal){
                $( "#discount_hidden" ).val(discount);
            }else{
                $( "#discount_hidden" ).val(maintotal);
            }
            $.ajax({
                url: "{{route('admin.cartdiscount')}}",
                method: 'POST',
                data: {discount: discount,},
                success: function (data)
                {
                    if(discount <= maintotal){
                        $('.totalamount').text(data.total);
                    }else{
                        $('.totalamount').text(addCommas(0));
                    }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }
            });
            var price = {{$total}}
            var total_amount = price-discount;
            $('.totalamount').text(total_amount);
        });
    });



</script>
<script>
    var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('site_currency_symbol_position') }}';
    var site_currency_symbol = '{{ \App\Models\Utility::getValByName('site_currency_symbol') }}';
</script>

</body>

</html>
