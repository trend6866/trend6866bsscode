{{ Form::open(['route' => 'admin.stores.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

@php
    $superadmin = \App\Models\Admin::where('type','superadmin')->first();
    $superadmin_setting = \App\Models\Setting::where('store_id',$superadmin->current_store)->where('theme_id', $superadmin->theme_id)->pluck('value', 'name')->toArray();
@endphp

@if((Auth::guard('admin')->user()->type == 'superadmin') && (!empty($superadmin_setting['chatgpt_key'])))
    <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary me-2 ai-btn mb-3" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('admin.generate',['store']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
        </a>
    </div>
@endif
@if ((Auth::guard('admin')->user()->type == 'admin') && ($plan->enable_chatgpt == 'on'))
    <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary me-2 ai-btn mb-3" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('admin.generate',['store']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
        </a>
    </div>
@endif

<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('', __('Store Name'), ['class' => 'form-label']) !!}
        {!! Form::text('storename', null, ['class' => 'form-control']) !!}
    </div>

    @if (Auth::user()->can('Create Admin Store'))
        <div class="form-group  col-md-12">
            @php
                $user = \Auth::guard('admin')->user();
                $store = App\Models\Store::where('id', $user->current_store)->first();
            @endphp
            {!! Form::label('', __('Theme'), ['class' => 'form-label']) !!}
            <ul class="uploaded-pics row">
                @foreach ($themes as $key => $value)
                    <li class="col-xl-4 col-lg-4 col-md-6">
                        <div class="theme-card border-primary theme1">
                        <input class="form-check-input email-template-checkbox d-none" type="radio" id="theme_{{!empty($value)?$value:''}}" name="theme_id" value="{{!empty($value)? $value :''}}"  @if(!empty($value)?$store->theme_id== $value :0 ) checked="checked" @endif/>
                        <label for="theme_{{!empty($value)?$value:''}}">
                            <img src="{{ asset('themes/'.$value.'/theme_img/img_1.png') }}" />
                        </label>
                    </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (Auth::guard('admin')->user()->type == 'superadmin')
        <div class="form-group col-md-12">
            {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('', __('Email'), ['class' => 'form-label']) !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('', __('Password'), ['class' => 'form-label']) !!}
            {{Form::password('password',array('class'=>'form-control'))}}
        </div>
    @endif

    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="Create" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
