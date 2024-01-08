{{ Form::model($product, ['route' => ['admin.product.update', $product->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'choice_form', 'class' => 'choice_form_edit']) }}

@php
    $plan = \App\Models\Plan::find(\Auth::user()->plan);
@endphp

@if ($plan->enable_chatgpt == 'on')
    <div class="d-flex justify-content-end mb-1">
        <a href="#" class="btn btn-primary me-2 ai-btn" data-size="lg" data-ajax-popup-over="true"
            data-url="{{ route('admin.generate', ['products']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
        </a>
    </div>
@endif

<input type="hidden" name="id" value="{{ $product->id }}">
<div class="row">
    @if ($ThemeSubcategory == 1)
        <div class="form-group col-md-12">
            {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('', __('Category'), ['class' => 'form-label']) !!}
            {!! Form::select(
                'category_id',
                $MainCategory,
                [$product->maincategory_id],
                [
                    'class' => 'form-control',
                    'data-role' => 'tagsinput',
                    'id' => 'maincategory',
                    'data-val' => $product->subcategory_id,
                ],
            ) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('', __('Sub Category'), ['class' => 'form-label']) !!}
            <div class="subcategory_selct">
                {!! Form::select('subcategory_id', [], null, [
                    'class' => 'form-control',
                    'data-role' => 'tagsinput',
                    'id' => 'subcategory_id',
                ]) !!}
            </div>
        </div>
    @else
        <div class="form-group col-md-6">
            {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('', __('Category'), ['class' => 'form-label']) !!}
            {!! Form::select('category_id', $MainCategory, null, [
                'class' => 'form-control',
                'data-role' => 'tagsinput',
                'id' => 'maincategory',
            ]) !!}
            <p class="text-danger d-none" id="user_validation">{{__('Category field is required.')}}</p>
        </div>
    @endif

    <div class="form-group col-md-12">
        {!! Form::label('', __('Product Description'), ['class' => 'form-label']) !!}
        <textarea name="description" rows="3" class="autogrow form-control" required>{{ $product->description }}</textarea>
    </div>
    <br>
    <h6>{{__('More Description')}}</h6>
    <br><br>
    @if (!empty($option_json_HTML))
        {!! $option_json_HTML !!}
    @endif

    @if (!empty($description_json_HTML))
        {!! $description_json_HTML !!}
    @endif

    <div class="form-group col-md-6">
        {!! Form::label('', __('Custom  Field'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="custom_field_status" value="0">
            {!! Form::checkbox('custom_field_status', 1, null, [
                'class' => 'form-check-input',
                'id' => 'enable_custom_field',
            ]) !!}
            <label class="form-check-label" for="enable_custom_field"></label>
        </div>
    </div>

    <div class="form-group col-md-12" style="display: none" id="custom_value">
        <div id="custom_field_repeater_basic">
            <!--begin::Form group-->
            <div class="form-group">
                <div data-repeater-list="custom_field_repeater_basic">
                    @if (!empty($product->custom_field))
                        @foreach (json_decode($product->custom_field, true) as $item)
                            <div data-repeater-item>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        {!! Form::label('', __('Custom Field'), ['class' => 'form-label']) !!}
                                        {!! Form::text('custom_field', $item['custom_field'], ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('', __('Custom Value'), ['class' => 'form-label']) !!}
                                        {!! Form::text('custom_value', $item['custom_value'], [
                                            'id' => 'answer',
                                            'rows' => 4,
                                            'class' => 'form-control',
                                        ]) !!}

                                    </div>
                                    <div class="col-md-4">
                                        <a href="javascript:;" data-repeater-delete
                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                            <i class="la la-trash-o"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    {!! Form::label('', __('Custom Field'), ['class' => 'form-label']) !!}
                                    {!! Form::text('custom_field', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('', __('Custom Value'), ['class' => 'form-label']) !!}
                                    {!! Form::text('custom_value', null, ['id' => 'answer', 'rows' => 2, 'class' => 'form-control']) !!}

                                </div>
                                <div class="col-md-4">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="la la-trash-o"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Form group-->

            <!--begin::Form group-->
            <div class="form-group mt-5">
                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                    <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
                </a>
            </div>
            <!--end::Form group-->
        </div>
    </div>
    <h6>{{__('Product Video')}}</h6>
    <br><br>
    <div class="form-group col-md-6 ml-auto" id="preview_type">
        {{ Form::label('preview_type', __('Preview Type'), ['class' => 'form-label']) }}
        {{ Form::select('preview_type', $preview_type, null, ['class' => 'form-control font-style', 'id' => 'preview_type']) }}
    </div>

    <div class="form-group col-lg-6" id="preview-video-div">
        <div class="form-group">
            <div class="form-file">
                <label for="preview_video" class="form-label">{{ __('Preview Video') }}</label>
                <input type="file" class="form-control" name="preview_video" id="preview_video"
                    aria-label="file example"
                    value="{{ $product->preview_type == 'Video File' ? $product->preview_content : '' }}">
                @if ($product->preview_content != '')
                    <a href="{{ get_file($product->preview_content, APP_THEME()) }}" target="_blank">
                        <video height="100px" controls="" class="mt-2">
                            <source id="preview_video" src="{{ get_file($product->preview_content, APP_THEME()) }}"
                                type="video/mp4">
                        </video>
                    </a>
                @endif
                <div class="invalid-feedback">
                    {{ __('invalid form file') }}</div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6" id="preview-iframe-div">
        {{ Form::label('preview_iframe', __('Preview iFrame'), ['class' => 'form-label']) }}
        <textarea name="preview_iframe" id="preview_iframe" class="form-control font-style" rows="2" value="">{{ $product->preview_type == 'iFrame' ? $product->preview_content : '' }}</textarea>
    </div>
    <div class="form-group col-md-6" id="video_url_div">
        {{ Form::label('video_url', __('Video URL'), ['class' => 'form-label']) }}
        <input class="form-control font-style" name="video_url" type="text" id="video_url"
            value="{{ $product->preview_type == 'Video Url' ? $product->preview_content : '' }}">
    </div>
    <h6>{{__('Additional Information')}}</h6>
    <br><br>
    @if (!empty($product_tag_json_HTML))
        {!! $product_tag_json_HTML !!}
    @endif
    <div class="form-group col-md-4">
        {!! Form::label('', __('Trending'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            {!! Form::hidden('trending', 0) !!}
            {!! Form::checkbox('trending', 1, null, ['class' => 'form-check-input', 'id' => 'trending_product']) !!}
            {!! Form::label('', '', ['class' => 'form-check-label', 'for' => 'trending_product']) !!}
        </div>
    </div>
    <div class="form-group col-md-6" id="downloadable-product-div">
        <div class="form-group">
            <div class="choose-file">
                <label for="downloadable_product" class="form-label">{{ __('Downloadable Product') }}</label>
                <input type="file" class="form-control" name="downloadable_product" id="downloadable_product">
                @if ($product->downloadable_product != '')
                    <img height="100px" src="{{ get_file($product->downloadable_product, APP_THEME()) }}">
                    <div class="invalid-feedback">{{ __('invalid form file') }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group col-md-4 product-weight">
        {!! Form::label('', __('Weight(Kg)'), ['class' => 'form-label ']) !!}
        {!! Form::number('product_weight', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
    </div>

    <div class="row product-price-div">
        <div class="form-group col-md-4 product_price">
            {!! Form::label('', __('Price'), ['class' => 'form-label']) !!}
            {!! Form::number('price', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('', __('Discount Type'), ['class' => 'form-label']) !!}
            {!! Form::select(
                'discount_type',
                ['' => __('Select Discount Type'), 'percentage' => 'Percentage', 'flat' => 'Flat'],
                null,
                ['class' => 'form-control'],
            ) !!}
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('', __('Discount Amount'), ['class' => 'form-label']) !!}
            {!! Form::number('discount_amount', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
        </div>
    </div>

    @if ($plan->shipping_method == 'on')
        <div class="form-group col-md-4">
            {!! Form::label('', __('Shipping'), ['class' => 'form-label']) !!}
            {!! Form::select('shipping_id', $Shipping, null, [
                'class' => 'form-control',
                'data-role' => 'tagsinput',
                'id' => 'Shipping',
            ]) !!}
        </div>
    @endif
    <h6>{{__('Product Stock')}}</h6>
    <br><br>
    @php
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $stock_management = \App\Models\Utility::GetValueByName('stock_management', $theme_name);
    @endphp
    @if ($stock_management == 'on')
        <div class="form-group col-md-4">
            {!! Form::label('', __('Stock Management'), ['class' => 'form-label']) !!}
            <div class="form-check form-switch">
                <input type="hidden" name="track_stock" value="0">
                {!! Form::checkbox('track_stock', 1, null, [
                    'class' => 'form-check-input enable_product_stock',
                    'id' => 'enable_product_stock',
                ]) !!}
                <label class="form-check-label" for="enable_product_stock"></label>
            </div>
        </div>
    @else
        <div class="form-group col-md-4 product_stock">
            {!! Form::label('', __('Stock Management'), ['class' => 'form-label']) !!}<br>
            <label name="trending" value=""><small>{{ __('Disabled in') }} <a
                        href="{{ route('admin.setting.index') . '#Brand_Setting ' }}"> store
                        {{ __('setting') }}</a></small></label>
        </div>
    @endif
    <div class="form-group col-md-6 stock_div_status">
        {!! Form::label('', __('Stock Status:'), ['class' => 'form-label']) !!}
        <div class="col-mb-9">
            <div class="form-check form-check-inline">
                <input type="radio" id="in_stock" value="in_stock" name="stock_status" class="form-check-input"
                    {{ $product->stock_status == 'in_stock' ? 'checked' : '' }}>
                <label class="form-check-label" for="in_stock">{{ __('In Stock') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="out_of_stock" value="out_of_stock" name="stock_status"
                    class="form-check-input" {{ $product->stock_status == 'out_of_stock' ? 'checked' : '' }}>
                <label class="form-check-label" for="out_of_stock">{{ __('Out of stock') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="on_backorder" value="on_backorder" name="stock_status"
                    class="form-check-input" {{ $product->stock_status == 'on_backorder' ? 'checked' : '' }}>
                <label class="form-check-label" for="on_backorder">{{ __('On Backorder') }}</label>
            </div>
        </div>
    </div>
    @php
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $stock_management = \App\Models\Utility::GetValueByName('stock_management', $theme_name);
        $low_stock_threshold = \App\Models\Utility::GetValueByName('low_stock_threshold', $theme_name);
    @endphp

    @if ($stock_management == 'on')
        <div class="form-group row col-md-12" id="options">
            <div class="form-group col-md-4 product_stock">
                {!! Form::label('', __('Stock'), ['class' => 'form-label']) !!}
                {!! Form::number('product_stock', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('', __('Allow BackOrders:'), ['class' => 'form-label']) !!}
                <div class="form-check m-1">
                    <input type="radio" id="not_allow" value="not_allow" name="stock_order_status"
                        class="form-check-input" {{ $product->stock_order_status == 'not_allow' ? 'checked' : '' }}>
                    <label class="form-check-label" for="not_allow">{{ __('Do Not Allow') }}</label>
                </div>
                <div class="form-check m-1">
                    <input type="radio" id="notify_customer" value="notify_customer" name="stock_order_status"
                        class="form-check-input"
                        {{ $product->stock_order_status == 'notify_customer' ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="notify_customer">{{ __('Allow, But notify customer') }}</label>
                </div>
                <div class="form-check m-1">
                    <input type="radio" id="allow" value="allow" name="stock_order_status"
                        class="form-check-input" {{ $product->stock_order_status == 'allow' ? 'checked' : '' }}>
                    <label class="form-check-label" for="allow">{{ __('Allow') }}</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('', __('Low stock threshold'), ['class' => 'form-label']) !!}
                {!! Form::number('low_stock_threshold', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) !!}
            </div>
        </div>
    @endif
    <h6>{{__('Product Variant')}}</h6>
    <br><br>
    <div class="form-group col-md-4">
        {!! Form::label('', __('Display Variants'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="variant_product" value="0">
            {!! Form::checkbox('variant_product', 1, null, [
                'class' => 'form-check-input enable_product_variant',
                'id' => 'enable_product_variant',
            ]) !!}
            <label class="form-check-label" for="enable_product_variant"></label>
        </div>
    </div>
    <div class="form-group col-md-2 d-none">
        {!! Form::label('', __('Status'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="status" value="1">
        </div>
    </div>


    {{-- <div class="form-group col-md-12" style="display: none" id="Product_Variant_Select">
        {!! Form::label('', __('Product Variant'), ['class' => 'form-label']) !!}
        {!! Form::select('variants_id[]', $ProductVariants, null, [
            'class' => 'form-control',
            'multiple' => 'multiple',
            'data-role' => 'tagsinput',
            'id' => 'choice_attributes',
        ]) !!}
        <small>{{ __('Choose the attributes of this product and then input values of each attribute') }}</small>
    </div>

    <div class="customer_choice_options Product_Variant_atttt" id="customer_choice_options">
        @if ($product->variant_attribute == 'NULL')
        @else
            @if (isset($product->variant_attribute))
                @foreach (json_decode($product->variant_attribute) as $key => $choice_option)
                    <div class="form-group">
                        <input type="hidden" name="choice_no[]" value="{{ $choice_option->attribute_id }}">
                        <label
                            for="choice_attributes">{{ \App\Models\ProductVariant::find($choice_option->attribute_id)->name }}:</label>
                        <input type="text" class="form-control"
                            name="choice_options_{{ $choice_option->attribute_id }}[]"
                            id="choice_options_{{ $choice_option->attribute_id }}"
                            placeholder="{{ __('Enter choice values') }}"
                            value="{{ implode(',', $choice_option->values) }}" data-role="tagsinput"
                            onchange="update_sku()">
                    </div>
                @endforeach
            @endif
        @endif
    </div>
    <div class="sku_combination Product_Variant_atttt" id="sku_combination">
    </div> --}}
    <div class="form-group col-md-12" id="">
        {!! Form::label('', __('Product Attribute'), ['class' => 'form-label']) !!}
        {!! Form::select('attribute_id[]', $ProductAttribute, null, [
            'class' => 'form-control product_attribute',
            'multiple' => 'multiple',
            'data-role' => 'tagsinput',
            'id' => 'attribute_id',
        ]) !!}
        <small>{{ __('Choose the attributes of this product and then input values of each attribute') }}</small>
    </div>
    <div class="attribute_options" id="attribute_options">
        @if ($product->product_attribute == 'NULL')
        @else
            @if (isset($product->product_attribute))
                @foreach (json_decode($product->product_attribute) as $key => $choice_option)
                    @php
                        $value = implode(',', $choice_option->values);
                        $idsArray = explode('|', $value);
                        $get_datas = \App\Models\ProductAttributeOption::whereIn('id', $idsArray)
                            ->get()
                            ->pluck('terms')
                            ->toArray();
                        $get_data = implode(',', $get_datas);
                        $option = \App\Models\ProductAttributeOption::where('attribute_id', $choice_option->attribute_id)
                            ->get()
                            ->pluck('terms')
                            ->toArray();

                        $attribute_id = $choice_option->attribute_id;

                        $visible_attribute = isset($choice_option->{'visible_attribute_' . $attribute_id}) ? $choice_option->{'visible_attribute_' . $attribute_id} : 0;
                        $for_variation = isset($choice_option->{'for_variation_' . $attribute_id}) ? $choice_option->{'for_variation_' . $attribute_id} : 0;
                    @endphp

                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="attribute_no[]" value="{{ $choice_option->attribute_id }}">
                            <div class="form-group row col-12">
                                <div class="form-group col-md-6">
                                    <label
                                        for="attribute_id">{{ \App\Models\ProductAttribute::find($choice_option->attribute_id)->name }}:</label>
                                </div>
                                <div
                                    class="form-group col-md-6 text-end d-flex all-button-box justify-content-md-end justify-content-center">
                                    <a href="#" class="btn btn-sm btn-primary add_attribute"
                                        data-ajax-popup="true" data-title="{{ __('Add Attribute Option') }}"
                                        data-size="md"
                                        data-url="{{ route('admin.product-attribute-option.create', $choice_option->attribute_id) }}"
                                        data-toggle="tooltip">
                                        <i class="ti ti-plus">{{ __('Add Attribute option') }}</i></a>
                                </div>
                            </div>
                            <div class="form-group row col-12 parent-clase">
                                <div class="form-group col-md-5">
                                    <div class="form-chec1k form-switch">
                                        {!! Form::hidden('visible_attribute_' . $choice_option->attribute_id, 0) !!}
                                        {!! Form::checkbox('visible_attribute_' . $choice_option->attribute_id, 1, $visible_attribute == 1, [
                                            'class' => 'form-check-input',
                                            'id' => 'visible_attribute_' . $choice_option->attribute_id,
                                        ]) !!}
                                        {!! Form::label('', __('Visible on the product page'), [
                                            'class' => 'form-check-label',
                                            'for' => 'visible_attribute_' . $choice_option->attribute_id,
                                        ]) !!}
                                    </div>
                                    <div style="margin-top: 9px;"></div>
                                    <div class="use_for_variation form-chec1k form-switch">

                                        {!! Form::hidden('for_variation_' . $choice_option->attribute_id, 0) !!}
                                        {!! Form::checkbox('for_variation_' . $choice_option->attribute_id, 1, $for_variation == 1, [
                                            'class' => 'form-check-input input-options enable_variation_' . $choice_option->attribute_id,
                                            'id' => 'for_variation_' . $choice_option->attribute_id,
                                            'data-enable-variation' => 'enable_variation_' . $choice_option->attribute_id,
                                            'data-id' => $choice_option->attribute_id,
                                        ]) !!}
                                        {!! Form::label('', __('Used for variations'), [
                                            'class' => 'form-check-label',
                                            'for' => 'for_variation_' . $choice_option->attribute_id,
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group col-md-7">
                                    <select name="attribute_options_{{ $choice_option->attribute_id }}[]"
                                        data-role="tagsinput"
                                        id="attribute_options_{{ $choice_option->attribute_id }}" multiple
                                        class="attribute_option_data">
                                        @foreach ($option as $f)
                                            <option @if (in_array($f, $get_datas)) selected @endif>
                                                {{ $f }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
    <div class="attribute_combination" id="attribute_combination">
    </div>
</div>

<div class="modal-footer pb-0">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" id="submit" value="Update" class="btn btn-primary">
</div>
</div>
{!! Form::close() !!}

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/repeater.js') }}"></script>
<script>
    var selectedCategory;
    $('#maincategory').on('change', function() {
        selectedCategory = $(this).val();
    });

    $("#submit").click(function() {

        if (selectedCategory) {
            $('#user_validation').addClass('d-none')
        } else {
            $('#user_validation').removeClass('d-none')
                return false;
        }
        var fileInput = $('#upload_image');
        if (fileInput[0].files.length === 0) {
            $('#file-error-msg').removeClass('d-none');
            return false;
        }else{
            $('#file-error-msg').addClass('d-none');
        }
        var Input = $('#sub_upload_image');
        if (Input[0].files.length === 0) {
            event.preventDefault();
            $('#sub-file-error-msg').removeClass('d-none');
            return false;
        }else{
            $('#sub-file-error-msg').addClass('d-none');
        }
    });
    $('#custom_field_repeater_basic').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
        },

        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    $(document).ready(function() {
        if ($('#enable_custom_field').prop('checked') == true) {
            $('#custom_value').show();
        }

        $(document).on("change", "#enable_custom_field", function() {
            $('#custom_value').hide();
            if ($(this).prop('checked') == true) {
                $('#custom_value').show();
            }
        });
    });
</script>
<script>
    $(document).on("change", "#enable_product_variant", function() {
        $('.product-weight').show();
        $('#Product_Variant_Select').hide();
        $('.Product_Variant_atttt').hide();
        $('.attribute_combination').hide();
        $('.product-price-div').show();
        if ($(this).prop('checked') == true) {
            $('.product-price-div').hide();
            $('.product-weight').hide();
            $('#Product_Variant_Select').show();
            $('.Product_Variant_atttt').show();
            $(".use_for_variation").removeClass("d-none");
            $('.attribute_combination').show();

            update_sku();
            attribute_option_data();
        }
    });

    function update_sku() {
        $.ajax({
            type: "PUT",
            url: '{{ route('admin.products.sku_combination_edit') }}',
            data: $('#choice_form').serialize(),
            success: function(data) {
                $('#sku_combination').html(data);
                if (data.length > 1) {
                    $('#quantity').hide();
                } else {
                    $('#quantity').show();
                }
            }
        });
    }

    function delete_row(em) {
        $(em).closest('.form-group').remove();
        update_sku();
    }

    $('#choice_attributes').on('change', function() {
        $('#customer_choice_options').html("<h3>Variation</h3>");
        $.each($("#choice_attributes option:selected"), function() {
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
        update_sku();
    });

    $('input[name="price"]').on('keyup', function() {
        update_sku();
    });

    $('input[name="sku"]').on('keyup', function() {
        update_sku();
    });
</script>
<script>
    $(document).ready(function() {
        type();
        $("#preview_type").change(function() {
            $(this).find("option:selected").each(function() {
                var optionValue = $(this).attr("value");
                if (optionValue == 'Video Url') {

                    $('#video_url_div').removeClass('d-none');
                    $('#video_url_div').addClass('d-block');

                    $('#preview-iframe-div').addClass('d-none');
                    $('#preview-iframe-div').removeClass('d-block');

                    $('#preview-video-div').addClass('d-none');
                    $('#preview-video-div').removeClass('d-block');

                } else if (optionValue == 'iFrame') {
                    $('#video_url_div').addClass('d-none');
                    $('#video_url_div').removeClass('d-block');

                    $('#preview-iframe-div').removeClass('d-none');
                    $('#preview-iframe-div').addClass('d-block');

                    $('#preview-video-div').addClass('d-none');
                    $('#preview-video-div').removeClass('d-block');

                } else if (optionValue == 'Video File') {

                    $('#video_url_div').addClass('d-none');
                    $('#video_url_div').removeClass('d-block');

                    $('#preview-iframe-div').addClass('d-none');
                    $('#preview-iframe-div').removeClass('d-block');

                    $('#preview-video-div').removeClass('d-none');
                    $('#preview-video-div').addClass('d-block');
                }
            });
        }).change();
    });

    $(document).on("change", "#enable_product_stock", function() {

        if ($("#enable_product_stock").prop("checked")) {
            $("#options").show();
            $('.stock_div_status').hide();
        } else {
            $("#options").hide();
            $('.stock_div_status').show();
        }
    });

    function type() {
        if ($('#enable_product_stock').is(":checked") == true) {
            $("#options").show();
            $('.stock_div_status').hide();
        } else {
            $("#options").hide();
            $('.stock_div_status').show();
        }
    }

    function attribute_option_data() {
        $.ajax({
            type: "PUT",
            url: '{{ route('admin.products.attribute_combination_data') }}',
            data: $('#choice_form').serialize(),
            success: function(data) {
                $('.attribute_combination').html(data);
                if (data.length > 1) {
                    $('#quantity').hide();
                } else {
                    $('#quantity').show();
                }
            }
        });
    }

    function update_attribute() {
        $.ajax({
            type: "PUT",
            url: '{{ route('admin.products.attribute_combination_edit') }}',
            data: $('#choice_form').serialize(),
            success: function(data) {
                $('.attribute_combination').html(data);
                if (data.length > 1) {
                    $('#quantity').hide();
                } else {
                    $('#quantity').show();
                }
            }
        });
    }

    function delete_attribute_row(buttonElement) {
        var accordionItem = $(buttonElement).closest('.accordion-item');
        accordionItem.remove();
        update_attribute();
    }

    $(document).on('change', '#attribute_id', function() {
        $('#attribute_options').html("<h3 class='d-none'>Variation</h3>");
        var option = $('.attribute_option').val();
        $.each($("#attribute_id option:selected"), function() {
            add_more_choice_option($(this).val(), $(this).text());
            var attribute_id = $(this).val();
            $.ajax({
                url: '{{ route('admin.products.attribute_option') }}',
                type: 'POST',
                data: {
                    "attribute_id": attribute_id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('.attribute').empty();
                    $.each(data, function(key, value) {
                        console.log(value);
                        $('.attribute_options_datas').empty();
                        $(".attribute").append('<option value="' + value + '">' +
                            value + '</option>');
                    });

                    var multipleCancelButton = new Choices('#attribute' + attribute_id, {
                        removeItemButton: true,
                    });
                }
            });
        });
    });

    $(document).on("change", "#enable_product_variant", function() {
        if ($(this).prop('checked') == true) {
            $(document).on('change', '.attribute_option_data', function() {

                var b = $(this).closest('.parent-clase').find('.input-options');
                var enableVariationValue = b.data('enable-variation');
                var dataid = b.attr('data-id');
                if ($('.enable_variation_' + dataid).prop('checked') == true) {
                    update_attribute();
                }

            });

            if ($('.enable_variation').prop('checked') == true) {
                $('input[name="price"]').on('keyup', function() {
                    update_attribute();
                });

                $('input[name="sku"]').on('keyup', function() {
                    update_attribute();
                });
            }
        }
    });
    $(document).ready(function() {
        $(document).on("change", ".product_attribute", function() {
            if ($('.enable_product_variant').prop('checked') == true) {
                $(".use_for_variation").removeClass("d-none");
            } else {
                $(".use_for_variation").addClass("d-none");
            }
        });
    });
</script>
@push('custom-script')
@endpush
