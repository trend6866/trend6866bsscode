@extends('layouts.app')

@section('page-title', __('Review'))

@section('action-button')
@can('Create Ratting')
    <div class=" text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="Add Review"
            data-url="{{ route('admin.review.create') }}" data-toggle="tooltip" title="{{ __('Create Review') }}">
            <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
        </a>
    </div>
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Review') }}</li>
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
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Rating') }}</th>
                                    <th>{{ __('Review') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ !empty($review->UserData) ? $review->UserData->name : '' }}</td>
                                        <td>{{ !empty($review->CategoryData) ? $review->CategoryData->name : '' }}</td>
                                        <td>{{ !empty($review->ProductData) ? $review->ProductData->name : '' }}</td>
                                        <td>
                                            @for ($i = 0; $i < 5; $i++)
                                            <i class="ti ti-star {{ $i < $review->rating_no ? 'text-warning' : '' }} "></i>
                                            @endfor
                                        </td>
                                        <td class="fix-content">{{ $review->description }}</td>
                                        <td class="text-end">
                                            @can('Edit Ratting')
                                            <button class="btn btn-sm btn-primary me-2"
                                                data-url="{{ route('admin.review.edit', $review->id) }}" data-size="md"
                                                data-ajax-popup="true" data-title="{{ __('Edit Review') }}">
                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                            </button>
                                            @endcan

                                            @can('Delete Ratting')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.review.destroy', $review->id], 'class' => 'd-inline']) !!}
                                            <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                    title="delete"></i>
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
            <!-- [ basic-table ] end -->
        </div>
    </div>
        <!-- [ Main Content ] end -->
    @endsection

    @push('custom-script')
        <script>
            $(document).on('change', '#category_id', function(e) {
                var id = $(this).val();
                var val = $('.product_id_div').attr('data_val');

                var data = {
                    id: id,
                    val: val
                }
                $.ajax({
                    url: '{{ route('admin.get.product') }}',
                    method: 'POST',
                    data: data,
                    context: this,
                    success: function(response) {
                        var val = $('.product_id_div').attr('data_val', 0);
                        $('.product_id_div span').html(response.html);
                        comman_function();
                    }
                });

            });
        </script>
    @endpush
