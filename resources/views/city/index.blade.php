@extends('layouts.app')

@section('page-title', __('Blogs'))

@section('action-button')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Blogs') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6 col-md-6 col-xxl-6">
        <div class="p-2 card mt-2">
            <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                        data-bs-target="#pills-user-1" type="button"><i
                        class="fas fa-location-arrow mx-2"></i>{{ __('Country') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                        data-bs-target="#pills-user-2" type="button"> <i class="fas fa-shipping-fast mx-2"></i>
                        {{ __('State') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-user-tab-3" data-bs-toggle="pill"
                        data-bs-target="#pills-user-3" type="button"><i
                        class="fas fa-location-arrow mx-2"></i>{{ __('City') }}</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-xxl-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-user-1" role="tabpanel"
                        aria-labelledby="pills-user-tab-1">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0">{{ __('Country') }}</h3>
                            <a class="btn btn-sm btn-icon  btn-primary me-2 text-white" data-url="{{ route('admin.country.create') }}" data-title="{{ __('Add Country') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Add Country') }}">
                                <i  data-feather="plus"></i>
                            </a>
                        </div>
                        <div class="row mt-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    {{-- <table class="table mb-0 dataTable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Slug') }}</th>
                                                <th>{{ __('Descriptions') }}</th>
                                                <th class="text-end">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        
                                    </table> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-user-2" role="tabpanel" aria-labelledby="pills-user-tab-2">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0"> {{ __('State') }}</h3>
                                <a class="btn btn-sm btn-icon  btn-primary me-2 text-white" data-url="{{ route('admin.state.create') }}" data-title="{{ __('Add State') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Add State') }}">
                                    <i  data-feather="plus"></i>
                                </a>
                        </div>

                        <div class="row mt-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    {{-- <table class="table mb-0 dataTable1">
                                        <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Country') }}</th>
                                                <th>{{ __('State') }}</th>
                                                <th>{{ __('Shipping Method') }}</th>
                                                <th class="text-start">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        
                                    </table> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-user-3" role="tabpanel" aria-labelledby="pills-user-tab-3">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0"> {{ __('City') }}</h3>
                                <a class="btn btn-sm btn-icon  btn-primary me-2 text-white" data-url="{{ route('admin.city.create') }}" data-title="{{ __('Add State') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Add State') }}">
                                    <i  data-feather="plus"></i>
                                </a>
                        </div>

                        <div class="row mt-3">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table mb-0 dataTable2">
                                        <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Shipping Method') }}</th>
                                                <th>{{ __('Shipping Zone') }}</th>
                                                <th>{{ __('Shipping Cost') }}</th>
                                                <th class="text-start">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection