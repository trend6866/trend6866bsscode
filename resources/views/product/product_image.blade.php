
{{ Form::model($product, ['route' => ['admin.product.image.update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'product_image_update']) }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="" class="form-label">{{ __('Upload Cover Image') }}</label>
            <label for="product_cover_upload_image" class="image-upload bg-primary pointer w-100">
                <i class="ti ti-upload px-1"></i> {{ __('Choose Cover Image') }}
            </label>
            <input type="file" name="product_cover_image_update" id="product_cover_upload_image" class="d-none product_image_update">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="" class="form-label">{{ __('Upload Sub Image') }}</label>
            <label for="sub_upload_image" class="image-upload bg-primary pointer w-100">
                <i class="ti ti-upload px-1"></i> {{ __('Choose Sub Image') }}
            </label>
            <input type="file" name="product_image_update[]" id="sub_upload_image" multiple="true"
                class="d-none product_image_update">
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="card-body table-border-style p-0">
    <h5>{{ __('Cover Image') }}</h5>
    <div class="row product_cover_img">
        <div class="col-4 mb-4">
            <section class="position-relative remove_image_section">
                <img src="{{ get_file($product->cover_image_path , APP_THEME()) }}" alt="dsa" class="img-fluid">
            </section>
        </div>
    </div>

    <h5>{{ __('Sub Image') }}</h5>
    <div class="row product_img">
        @foreach ($ProductImages as $ProductImage)
            <div class="col-4 mb-4">
                <section class="position-relative remove_image_section">
                    <img src="{{ get_file($ProductImage->image_path , APP_THEME()) }}" alt="dsa" class="img-fluid">
                    <button class="btn btn-sm btn-danger m-2 remove_image" data-id="{{ $ProductImage->id }}">
                        <i class="ti ti-circle-x py-1" data-bs-toggle="tooltip" title="Remove Image"></i>
                    </button>
                </section>
            </div>
        @endforeach
    </div>
</div>
