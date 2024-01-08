
{{Form::model($page, array('route' => array('admin.pages.update', $page->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}

@php
    $plan = \App\Models\Plan::find(\Auth::user()->plan);
@endphp

@if ($plan->enable_chatgpt == 'on')
<div class="d-flex justify-content-end mb-1">
    <a href="#" class="btn btn-primary me-2 ai-btn" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('admin.generate',['custom page']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
        <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
    </a>
</div>
@endif

<div class="row">
    @if($page->name == 'About' || $page->name == 'Privacy Policy' || $page->name == 'Contactus' || $page->name == 'Terms and conditions' || $page->name == 'Refund Policy')
        <div class="form-group col-md-12">
            {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control','readonly']) !!}
        </div>
    @else
    <div class="form-group col-md-12">
        {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    @endif

    <div class="form-group col-md-12">
        {!! Form::label('', __('Short Description'), ['class' => 'form-label']) !!}
        {!! Form::text('short_description', null, ['class' => 'form-control']) !!}
    </div>

    @if($page->name != 'Contactus')
        <div class="form-group col-md-12">
            {!! Form::label('', __('Content'), ['class' => 'form-label']) !!}
                <div class="form-group mt-3">
                    {!! Form::textarea('content', null, ['id' => 'content', 'rows' => 8, 'class'=>'pc-tinymce-2']) !!}
                </div>
        </div>
    @endif

    @php
        $other_info = json_decode($page->other_info);
    @endphp

    @if($page->name == 'Contactus')
        <div class="form-group col-md-12">
            {!! Form::label('', __('Call us'), ['class' => 'form-label']) !!}
            {!! Form::text('other_info[][call]', isset($other_info->call) ? $other_info->call : '', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('', __('Email'), ['class' => 'form-label']) !!}
            {!! Form::text('other_info[][email]',  isset($other_info->email) ? $other_info->email : '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('', __('Address'), ['class' => 'form-label']) !!}
            {!! Form::textarea('other_info[][address]',  isset($other_info->address) ? $other_info->address : '', ['rows' => 4, 'class'=>'form-control']) !!}
        </div>
    @endif

    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="Update" class="btn btn-primary">
    </div>
</div>
{!! Form::close() !!}

<script src="{{asset('assets/css/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/js/plugins/tinymce/tinymce.min.js')}}"></script>
    <script>
        if ($(".pc-tinymce-2").length) {
            tinymce.init({
                selector: '.pc-tinymce-2',
                toolbar: 'link image',
                plugins: 'image code',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
                };

                input.click();
            },
                height: "400",
                content_style: 'body { font-family: "Inter", sans-serif; }'
            });
        }
        document.addEventListener('focusin', function (e) {
            if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
                e.stopImmediatePropagation();
            }
        });

    </script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
            });
        });
    </script>

@push('custom-css')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-bs4.css')}}">
    <style>
        .nav-tabs .nav-link-tabs.active {
            background: none;
        }
    </style>
@endpush
