@extends('layouts.app')

@section('page-title', __('Variant'))

@section('action-button')
@can('Create Variants')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="#" class="btn btn-sm btn-primary mx-1" data-ajax-popup="true" data-size="md" data-title="Add Variant"
            data-url="{{ route('admin.product-variant.create') }}" data-toggle="tooltip" title="{{ __('Create Variant') }}">
            <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
        </a>
    </div>
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.product.index') }}">{{ __('Product') }}</a>
    </li>
    <li class="breadcrumb-item">{{ __('Variant') }}</li>
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
                                    <th>{{ __('Type') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ProductVariants as $variant)
                                    <tr>
                                        <td>{{ $variant->name }}</td>
                                        <td class="text-capitalize"> {{ str_replace("_"," ", $variant->type) }} </td>
                                        <td class="text-end">
                                            @can('Edit Variants')
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('admin.product-variant.edit', $variant->id) }}"
                                                data-size="md" data-ajax-popup="true"
                                                data-title="{{ __('Edit variant') }}" >
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            @endcan
                                            @can('Delete Variants')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.product-variant.destroy', $variant->id], 'class' => 'd-inline']) !!}
                                            <button type="button" class="btn btn-sm btn-danger show_confirm"><i class="ti ti-trash text-white py-1"></i></button>
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
            <!-- [ basic-table ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection

@push('custom-script')
    <script>

    </script>
@endpush
