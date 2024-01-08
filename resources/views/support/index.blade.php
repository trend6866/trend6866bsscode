@extends('layouts.app')

@section('page-title', __('Support Ticket'))


@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Support Ticket') }}</li>
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
                                    <th>{{ __('Ticket ID') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    {{-- <th>{{ __('Subject') }}</th> --}}
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-end me-3">

                                        {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supports as $ticket)
                                    <tr>
                                        <td class="Id sorting_1">
                                            @can('Replay Support Ticket')
                                            <a class="btn btn-outline-primary" href="{{route('admin.support_ticket.edit',$ticket->id)}}">
                                                #{{$ticket->ticket_id}}
                                            </a>
                                            @endcan
                                        </td>
                                        <td>{{$ticket->title}}</td>
                                        <td>{{$ticket->created_at}}</td>
                                        {{-- <td >{!! $ticket->description !!}</td> --}}
                                        <td>{{ !empty($ticket->UserData->name) ? $ticket->UserData->name : '' }}</td>
                                        <td >
                                            <span class="badge fix_badges bg-primary  p-2 px-3 rounded">
                                                {{$ticket->status}}
                                        </span>
                                        </td>
                                        <td class="text-end">
                                            @can('Replay Support Ticket')
                                            <a class="btn btn-sm btn-info me-2" href="{{route('admin.support_ticket.edit',$ticket->id)}}">
                                                <i class="fas fa-share py-1"></i>
                                            </a>
                                            @endcan

                                            @can('Delete Support Ticket')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.support_ticket.destroy', $ticket->id], 'class' => 'd-inline']) !!}
                                            <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                <i class="ti ti-trash text-white py-1"></i>
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

