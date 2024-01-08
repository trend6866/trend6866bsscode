{{ Form::open(['route' => 'admin.product-variant.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
        <input type="text" name="name" class="form-control"/>
    </div>
    <div class="form-group col-md-12">
        {!! Form::label('', __('Variant Type'), ['class' => 'form-label']) !!}
        {!! Form::select('type', App\Models\ProductVariant::$form_type, null, ["class"=>"form-control", "data-role" => "tagsinput", "id" => "type"]) !!}
    </div>

    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="Create" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
