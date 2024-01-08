@extends('layouts.app')

@section('page-title', __('Terms'))

@section('action-button')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Terms&Condition') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script1')
@endpush