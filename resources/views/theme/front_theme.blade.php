@extends('layouts.app')

@section('page-title', __('Manage Themes'))

@section('action-button')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Manage Themes') }}</li>
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ basic-table ] start -->
   <div class="border border-primary rounded p-3">
        @php
            $user = \Auth::guard('admin')->user();
            $store = App\Models\Store::where('id', $user->current_store)->first();
        @endphp
        <div class="row uploaded-picss gy-4">
            @foreach ($themes as $folder)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="theme-card border-primary theme1  selected">
                        <input class="form-check-input email-template-checkbox d-none" type="radio" id="themes_{{!empty($folder)?$folder:''}}" name="theme" value="{{!empty($folder)?$store->theme_id== $folder :0}}"  @if(!empty($folder)?$store->theme_id== $folder :0 ) checked="checked" @endif data-url="{{route('admin.theme.change',[!empty($folder)?$folder:''])}}"/>

                        <label for="themes_{{!empty($folder)?$folder:''}}">
                            <img src="{{ asset('themes/'.$folder.'/theme_img/img_1.png') }}" class="front-img">
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
   </div>
    <!-- [ basic-table ] end -->
</div>
<!-- [ Main Content ] end -->
@endsection

@push('custom-script')
<script type="text/javascript">

    $(".email-template-checkbox").click(function(){
    
        var chbox = $(this);
        $.ajax({
            url: chbox.attr('data-url'),
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
            type: 'post',
            success: function (response) {
                if (response.is_success) {
                    show_toastr('Success', response.success, 'success');
                    if (chbox.val() == 1) {
                        $('#' + chbox.attr('id')).val(0);
                    } else {
                        $('#' + chbox.attr('id')).val(1);
                    }
                } else {
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function (response) {
                response = response.responseJSON;
                if (response.is_success) {
                    show_toastr('Error', response.error, 'error');
                } else {
                    show_toastr('Error', response, 'error');
                }
            }
        })
    });
</script>
@endpush
