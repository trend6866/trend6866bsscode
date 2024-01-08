{{Form::model($productVariant, array('route' => array('admin.product-variant.update', $productVariant->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('', __('name'), ['class' => 'form-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-12">
        {!! Form::label('', __('Variant Type'), ['class' => 'form-label']) !!}
        {!! Form::select('type', App\Models\ProductVariant::$form_type, null, ["class"=>"form-control", "data-role" => "tagsinput", "id" => "type"]) !!}
    </div>

    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="Update" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
