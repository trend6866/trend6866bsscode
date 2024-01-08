@extends('layouts.app')

@section('page-title', __('Tax'))

@section('action-button')
@can('Create Product Tax')
    {{-- @if (count($taxes) >= 2)
        <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
            <b><small class="text-danger">{{ __('You can only add 2 taxes.') }}</small></b>
        </div>
    @else --}}
        <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
            <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Tax"
                data-url="{{ route('admin.tax.create') }}" data-toggle="tooltip" title="{{ __('Create Tax') }}">
                <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
            </a>
        </div>
    {{-- @endif --}}
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Tax') }}</li>
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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    {{-- <th>{{ __('Theme id') }}</th> --}}
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxes as $tax)
                                    <tr>
                                        <td>{{ $tax->tax_name }}</td>
                                        <td>{{ $tax->tax_amount }}<i
                                            class="{{ $tax->tax_type == 'flat' ? 'ti ti-currency-dollar' : 'ti ti-percentage' }}"></i>
                                            {{ __('Discount') }} </td>
                                        {{-- <td>{{ $tax->theme_id }}</td> --}}
                                        <td class="text-end">
                                            @can('Edit Product Tax')
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('admin.tax.edit', $tax->id) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Edit Tax') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            @endcan

                                            @can('Delete Product Tax')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.tax.destroy', $tax->id], 'class' => 'd-inline']) !!}
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

    @push('custom-script')
    @endpush
