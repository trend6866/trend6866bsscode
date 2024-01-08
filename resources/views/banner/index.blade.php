@extends('layouts.app')

@section('page-title', __('Banner'))

@section('action-button')
<div class=" text-end d-flex all-button-box justify-content-md-end justify-content-center">
    <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
        data-title="Add Banner"
        data-url="{{ route('admin.banner.create') }}"
        data-toggle="tooltip" title="{{ __('Create Banner') }}">
        <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
    </a>
</div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Banner') }}</li>
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
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Button Text') }}</th>
                            <th>{{ __('Theme') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th class="text-end">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                        <tr>
                            <td>{{ $banner->heading }}</td>
                            <td>{{ $banner->button_text }}</td>
                            <td>{{ $banner->theme->name }}</td>
                            <td>
                                <img src="{{ $banner->image_url }}" alt="" class="category_Image">
                            </td>
                            <td>{{ $banner->status == 1 ? __('Active') : __('InActive') }}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-primary me-2"
                                    data-url="{{ route('admin.banner.edit', $banner->id) }}"
                                    data-size="md" data-ajax-popup="true"
                                    data-title="{{ __('Edit Banner') }}" >
                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                </button>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['admin.banner.destroy', $banner->id], 'class' => 'd-inline']) !!}
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
@endsection

@push('custom-script')
@endpush
