@extends('layouts.app')

@section('page-title')
    {{ __('DeliveryBoy') }}
@endsection

@php
    $logo = asset(Storage::url('uploads/profile/'));
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('DeliveryBoy') }}</li>
@endsection

@section('action-button')
    @can('Create DeliveryBoy')
        <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
            <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Create User"
                data-url="{{ route('admin.deliveryboy.create') }}" data-toggle="tooltip" title="{{ __('Create User') }}">
                <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="row">
        @foreach ($deliveryboys as $deliveryboy)
            <div class="col-lg-3 col-sm-6 col-md-6">
                <div class="card text-center">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <div class="badge p-2 px-3 rounded bg-primary">{{ ucfirst($deliveryboy->type) }}</div>
                            </h6>
                        </div>
                        @if (Gate::check('Edit DeliveryBoy') || Gate::check('Delete DeliveryBoy') || Gate::check('Reset Password'))
                            <div class="card-header-right">
                                <div class="btn-group card-option">
                                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="feather icon-more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @can('Edit DeliveryBoy')
                                            <a href="#" class="dropdown-item"
                                                data-url="{{ route('admin.deliveryboy.edit', $deliveryboy->id) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Update User') }}">
                                                <i class="ti ti-edit"></i>
                                                <span class="ms-2">{{ __('Edit') }}</span>
                                            </a>
                                        @endcan
                                        @can('Reset Password')
                                            <a href="#" class="dropdown-item"
                                                data-url="{{ route('admin.deliveryboy.reset', \Crypt::encrypt($deliveryboy->id)) }}"
                                                data-ajax-popup="true" data-size="md" data-title="{{ __('Change Password') }}">
                                                <i class="ti ti-key"></i>
                                                <span class="ms-2">{{ __('Reset Password') }}</span>
                                            </a>
                                        @endcan
                                        @can('Delete DeliveryBoy')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.deliveryboy.destroy', $deliveryboy->id], 'class' => 'd-inline']) !!}
                                            <a href="#" class="bs-pass-para dropdown-item show_confirm"
                                                data-confirm-yes="delete-form-{{ $deliveryboy->id }}"><i class="ti ti-trash"></i>
                                                <span class="ms-2">{{ __('Delete') }}</span>
                                            </a>
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="img-fluid rounded-circle card-avatar">
                            <a href="{{ !empty($deliveryboy->avatar) ? asset(Storage::url('uploads/profile/' . $deliveryboy->avatar)) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                                target="_blank">
                                <img src="{{ !empty($deliveryboy->avatar) ? asset(Storage::url('uploads/profile/' . $deliveryboy->avatar)) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                                    class="img-user wid-80 round-img rounded-circle">
                            </a>
                        </div>
                        <h4 class="mt-2 text-primary">{{ $deliveryboy->name }}</h4>
                        <small class="">{{ $deliveryboy->email }}</small>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-3">
            @can('Create User')
                <a class="btn-addnew-project" data-url="{{ route('admin.deliveryboy.create') }}" data-title="{{ __('Create User') }}"
                    data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create User') }}"><i
                        class="ti ti-plus text-white"></i>
                    <div class="bg-primary proj-add-icon">
                        <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
                    </div>
                    <h6 class="mt-4 mb-2">{{ __('New User') }}</h6>
                    <p class="text-muted text-center">{{ __('Click here to add New User') }}</p>
                </a>
            @endcan
        </div>
    </div>
@endsection
