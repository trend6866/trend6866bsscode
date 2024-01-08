{{ Form::open(['route' => 'admin.theme.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

<div class="form-group">
    {!! Form::label('', __('Title'), ['class' => 'form-label']) !!}
    <select name="name" id="" class="form-control">
        @foreach ($folders as $folder)
            <option value="{{ $folder }}">{{ $folder }}</option>
        @endforeach
    </select>
    {{-- {!! Form::select('name', $folders,null, ['class' => 'form-control', 'data-role' => 'tagsinput', 'placeholder' => 'Select Option']) !!} --}}
</div>



<div class="form-group">
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
{!! Form::close() !!}
