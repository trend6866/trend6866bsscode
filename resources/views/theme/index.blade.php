@extends('layouts.app')

@section('page-title', __('Theme'))

@section('action-button')
<div class=" text-end d-flex all-button-box justify-content-md-end justify-content-center">
    <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
        data-title="{{ __('Add Theme') }}"
        data-url="{{ route('admin.theme.create') }}"
        data-toggle="tooltip" title="{{ __('Add Theme') }}">
        <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
    </a>
</div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Theme') }}</li>
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ basic-table ] start -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($themes as $theme)
                                <tr>
                                    <td>{{ $theme->name }}</td>
                                    <td>{{ $theme->slug_name }}</td>
                                    <td>{{ APP_THEME() == $theme->slug_name ? 'Active' : 'Inactive' }}</td>
                                    <td class="text-end">

                                        <a class="btn btn-sm btn-success me-2" href="{{ route('admin.theme.change', $theme->slug_name) }}">
                                            <i class="ti ti-exchange py-1" data-bs-toggle="tooltip" title="Theme change"></i>
                                        </a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['admin.theme.destroy', $theme->id], 'class' => 'd-inline']) !!}
                                            <button type="button" class="btn btn-sm btn-danger show_confirm"><i class="ti ti-trash text-white py-1"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ basic-table ] end -->
</div>
<!-- [ Main Content ] end -->
@endsection

@push('custom-script')
@endpush
