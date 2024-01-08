<div class="row">
    <div class="col-md-6">
        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('sku', 'SKU:') !!}
            {!! Form::text('sku', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Category Id Field -->
        <div class="form-group">
            {!! Form::label('category_id', 'Category:') !!}
            {!! Form::select('category_id', $categories,null, ['class' => 'form-control']) !!}
        </div>

        <!-- Category Id Field -->
        <div class="form-group">
            {!! Form::label('sub_category_id', 'Sub Category:') !!}
            {!! Form::select('sub_category_id', [],null, ['class' => 'form-control']) !!}
        </div>

        <!-- Price Field -->
        <div class="form-group">
            {!! Form::label('price', 'Price:') !!}
            {!! Form::number('price', null, ['class' => 'form-control','step'=>'0.01']) !!}
        </div>

        <!-- Status Field -->
        <div class="form-group">
            {!! Form::label('stock', 'Stock:') !!}
            {!! Form::select('stock', ['in_stock'=>'In Stock','out_of_stock'=>'Out of Stock'],null, ['class' => 'form-control']) !!}
        </div>

        <!-- Images Field -->
        <div class="form-group">
            {!! Form::label('images', 'Images:') !!}
            {!! Form::file('images', ['name'=>'images[]','class' => 'form-control','multiple'=>true,'accept'=>'.jpg,.png,.jpeg']) !!}
        </div>



    </div>
    <div class="col-md-6">
        <!-- Description Field -->
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group" id="images">
            @if(isset($product))
                <div class="row">
                    @foreach($product->images as $image)
                    <div class="col-md-4">
                        <img class="img-fluid img-thumbnail" src="{{ Storage::url("product/".\Auth::user()->getCompanyId()."/".$image) }}"/>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
    <div class="col-md-12">
        <hr>
        <h3>{{ __('Product Variation') }}</h3>
        <!-- Status Field -->
        <div class="form-group">
            {!! Form::label('choice_attributes', 'Attributes:') !!}
            {!! Form::select('choice_attributes', $attributes,null, ['name'=>'choice_attributes[]','class' => 'form-control','multiple'=>'multiple']) !!}
            <small>{{ __('Choose the attributes of this product and then input values of each attribute') }}</small>
        </div>

        <div class="row">
            <div class="col">
                <div class="customer_choice_options" id="customer_choice_options">
                    @if(isset($product))
                        @foreach (json_decode($product->choice_options) as $key => $choice_option)
                        <div class="form-group">
                            <input type="hidden" name="choice_no[]" value="{{ $choice_option->attribute_id }}">
                            <label for="choice_attributes">{{ \App\Models\Attribute::find($choice_option->attribute_id)->name }}:</label>
                            <input type="text" class="form-control" name="choice_options_{{ $choice_option->attribute_id }}[]" __="{{ __('Enter choice values') }}" value="{{ implode(',', $choice_option->values) }}" data-role="tagsinput" onchange="update_sku()">
                        </div>
                        @endforeach
                    @endif
                </div>
                <div class="sku_combination" id="sku_combination">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group mt-3">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
