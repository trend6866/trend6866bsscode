@extends('layouts.app')

@section('page-title', __('Users'))

@section('action-button')
@can('Create Store')
        <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
            <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Store"
                data-url="{{ route('admin.stores.create') }}" data-toggle="tooltip" title="{{ __('Create Store') }}">
                <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
            </a>
        </div>
        @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Users') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('User Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Store') }}</th>
                                    <th>{{ __('Plan') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->countStore($user->id) }}</td>
                                        <td>{{ !empty($user->currentPlan->name) ? $user->currentPlan->name : '-' }}</td>
                                        <td class="text-end">
                                            @if(\Auth::user()->type == 'superadmin')
                                                <button class="btn p-0" data-url=""  data-bs-original-title="{{ __('Login As Admin')}}">
                                                    <a class="btn btn-sm btn-secondary me-2" href="{{ route('admin.login.with.admin',$user->id) }}">
                                                        <i class="ti ti-replace py-1" data-bs-toggle="tooltip" title="Login As Admin"> </i>
                                                    </a>
                                                </button>

                                                <button class="btn btn-sm btn-info me-2"
                                                    data-url="{{ route('admin.stores.link', $user->id) }}" data-size="md"
                                                    data-ajax-popup="true" data-title="{{ __('Store Links') }}">
                                                    <i class="ti ti-unlink py-1" data-bs-toggle="tooltip" title="Store Links"></i>
                                                </button>
                                            @endif

                                            @can('Edit Store')
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('admin.stores.edit', $user->id) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Edit Store') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            @endcan

                                            @can('Upgrade Plan')
                                            <button class="btn btn-sm btn-warning me-2"
                                                data-url="{{ route('admin.plan.upgrade', $user->id) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Upgrade Plan') }}">
                                                <i class="ti ti-trophy py-1" data-bs-toggle="tooltip" title="upgrade plan"></i>
                                            </button>
                                            @endcan

                                            @can('Reset Password')
                                            <button class="btn btn-sm btn-secondary me-2"
                                                data-url="{{ route('admin.storepassword.reset', \Crypt::encrypt($user->id)) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Reset Password') }}">
                                                <i class="ti ti-key py-1" data-bs-toggle="tooltip" title="reset password"></i>
                                            </button>
                                            @endcan

                                            @can('Delete Store')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.stores.destroy', $user->id], 'class' => 'd-inline']) !!}
                                            <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                    title="Delete"></i>
                                            </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
