@extends('layouts.app')

@section('page-title', __('Blogs'))

@section('action-button')
@can('Create Blog')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="Add Blog"
            data-url="{{ route('admin.blogs.create') }}" data-toggle="tooltip" title="{{ __('Create Blog') }}">
            <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
        </a>
    </div>
@endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Blogs') }}</li>
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
                                    <th>{{ __('Cover Image') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Short Description') }}</th>
                                    @if ($ThemeSubcategory == 1)
                                    <th>{{ __('Sub Category') }}</th>
                                    @endif
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                @php
                                    $sub = explode(',',$blog->subcategory_id);
                                @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ get_file($blog->cover_image_path,APP_THEME()) }}" alt="" width="100" class="cover_img{{ $blog->id }}">
                                        </td>
                                        <td>{{$blog->MainCategory->name}}</td>
                                        <td class="fix-content">{{$blog->title}}</td>
                                        <td class="fix-content">{{$blog->short_description}}</td>

                                        @if ($ThemeSubcategory == 1)
                                        <td>@foreach ($sub as $k)
                                            <span class="badge bg-primary p-2 px-3 rounded">
                                                {{$blog->getSubId($k)}}
                                            </span>
                                            @endforeach
                                        </td>
                                        @endif
                                        <td class="text-end">
                                            @can('Edit Blog')
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('admin.blogs.edit', $blog->id) }}" data-size="lg"
                                                data-ajax-popup="true" data-title="{{ __('Edit Blog') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            @endcan
                                            @can('Delete Blog')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.blogs.destroy', $blog->id], 'class' => 'd-inline']) !!}
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

