{{Form::model($banner, array('route' => array('admin.banner.update', $banner->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
<div class="row">
    <div class="form-group col-md-12">
        {!! Form::label('', __('Theme'), ['class' => 'form-label']) !!}
        {!! Form::select('theme_id', $theme_list, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Heading'), ['class' => 'form-label']) !!}
        {!! Form::text('heading', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group  col-md-12">
        {!! Form::label('', __('Button Text'), ['class' => 'form-label']) !!}
        {!! Form::text('button_text', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-5">
        {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
        <label for="upload_image" class="image-upload bg-primary pointer w-100">
            <i class="ti ti-upload px-1"></i> {{ __('Choose file here') }}
        </label>
        <input type="file" name="image" id="upload_image" class="d-none">
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('', __('Status'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" class="form-check-input input-primary" id="customCheckdef1" value="1"
                checked>
            <label class="form-check-label" for="customCheckdef1"></label>
        </div>
    </div>

    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="Create" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}
