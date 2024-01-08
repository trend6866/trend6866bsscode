@extends('layouts.app')

@section('page-title', __('Custom Pages'))

@section('action-button')
@can('Create Custom Page')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="Add Page"
            data-url="{{ route('admin.pages.create') }}" data-toggle="tooltip" title="{{ __('Create Page') }}">
            <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
        </a>
    </div>
    @endcan
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Custom Pages') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style page-border">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Page link') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $page)
                                    <tr>
                                        <td>{{$page->name}}</td>
                                       <td>
                                        <div class="input-group gap-3">
                                            <input type="text"
                                                value="{{ route('custom.page',[$slug, $page->page_slug]) }}"
                                                id="myInput_{{$page->id}}" class="form-control d-inline-block"
                                                aria-label="Recipient's username"
                                                aria-describedby="button-addon2" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button"
                                                    onclick="myFunction('myInput_{{$page->id}}')" id="button-addon2"><i
                                                        class="far fa-copy"></i>
                                                    {{ __('Copy Link') }}</button>
                                            </div>
                                        </div>
                                       </td>
                                        <td class="text-end d-flex align-items-center justify-content-end">
                                            @if ($page->page_status == 'custom_page')
                                                <div class="form-check form-switch form-switch-right">
                                                    <input class="form-check-input page-checkbox" id="{{$page->id}}" type="checkbox" name="page_active"
                                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" @if($page->status == 1) checked="checked" @endif/>
                                                </div>
                                                @can('Delete Custom Page')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.pages.destroy', $page->id], 'class' => 'd-inline mx-3    ']) !!}
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                            title="Delete"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                @endcan
                                            @endif
                                            @can('Edit Custom Page')
                                                <button class="btn btn-sm btn-primary me-2"
                                                    data-url="{{ route('admin.pages.edit', $page->id) }}" data-size="lg"
                                                    data-ajax-popup="true" data-title="{{ __('Edit Page') }}">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>
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
        <script type="text/javascript">

            $(function() {

                $('.page-checkbox').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var page_id = $(this).attr('id');

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{ route('admin.update.page.status') }}",
                        data: {'status': status, 'page_id': page_id},
                        success: function(data){
                            if (data.success)
                            {
                                show_toastr('Success', data.success, 'success');
                            } else {
                                show_toastr('Error', "{{ __('Something went wrong') }}", 'error');
                            }
                        },
                    });
                })
            })


            function myFunction(id) {
            var copyText = document.getElementById(id);
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
            }
        </script>
    @endpush
