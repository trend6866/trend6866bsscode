{{ Form::open(['route' => 'admin.product.store', 'method' => 'POST', 'id' => 'choice_form', 'enctype' => 'multipart/form-data']) }}

@php
    $plan = \App\Models\Plan::find(\Auth::user()->plan);
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $stock_management = \App\Models\Utility::GetValueByName('stock_management', $theme_name);
    $low_stock_threshold = \App\Models\Utility::GetValueByName('low_stock_threshold', $theme_name);
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

<div class="row">
    @if ($ThemeSubcategory == 1)
        <div class="form-group col-md-12">
            {!! Form::label('', __('Name'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('', __('Category'), ['class' => 'form-label']) !!}
            {!! Form::select('category_id', $MainCategory, null, [
                'class' => 'form-control',
                'data-role' => 'tagsinput',
                'id' => 'maincategory',
                'data-val' => '0',
            ]) !!}
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
            {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}
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
        <textarea name="description" rows="3" class="autogrow form-control" required></textarea>
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
    <h6>{{__('Product Image')}}</h6>
    <br><br>
    <div class="form-group form-group1 col-md-6">
        {!! Form::label('', __('Cover Image'), ['class' => 'form-label']) !!}
        <label for="upload_image" class="image-upload bg-primary pointer w-100">
            <i class="ti ti-upload px-1"></i> {{ __('Choose file here') }}
        </label>
        <input type="file" name="cover_image" id="upload_image" class="off-screen d-none" required accept="image/*">
        <small id="file-error-msg" class="form-text text-danger d-none">{{__('Cover image is required.')}}</small>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('', __('Sub Image'), ['class' => 'form-label']) !!}
        <label for="sub_upload_image" class="image-upload bg-primary pointer w-100">
            <i class="ti ti-upload px-1"></i> {{ __('Choose file here') }}
        </label>
        <input type="file" name="product_image[]" id="sub_upload_image" multiple="true" class="d-none" data-bouncer-target="#sub-file-error-msg" required>
        <small id="sub-file-error-msg" class="form-text text-danger d-none">{{ __('Sub image is required.') }}</small>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('', __('Custom  Field'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="custom_field_status" value="0">
            <input type="checkbox" class="form-check-input" name="custom_field_status" id="enable_custom_field"
                value="1">
            <label class="form-check-label" for="enable_custom_field"></label>
        </div>
    </div>
    <div class="form-group col-md-12" style="display: none;" id="custom_value">
        <div id="custom_field_repeater_basic">
            <!--begin::Form group-->
            <div class="form-group">
                <div data-repeater-list="custom_field_repeater_basic">
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
    <div class="form-group col-md-6" id="preview_type">
        {{ Form::label('preview_type', __('Preview Type'), ['class' => 'form-label']) }}
        {{ Form::select('preview_type', $preview_type, null, ['class' => 'form-control font-style', 'id' => 'preview_type']) }}
    </div>

    <div class="form-group col-lg-6" id="preview-video-div">
        <div class="form-group">
            <div class="choose-file">
                <label for="preview_video" class="form-label">{{ __('Preview Video') }}</label>
                <input type="file" class="form-control" name="preview_video" id="preview_video">
                <div class="invalid-feedback">{{ __('invalid form file') }}</div>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6 ml-auto d-none" id="preview-iframe-div">
        {{ Form::label('preview_iframe', __('Preview iFrame'), ['class' => 'form-label']) }}
        {{ Form::textarea('preview_iframe', null, ['class' => 'form-control font-style', 'rows' => 2]) }}
    </div>
    <div class="form-group col-md-6" id="video_url_div">
        {{ Form::label('video_url', __('Video URL'), ['class' => 'form-label']) }}
        {{ Form::text('video_url', null, ['class' => 'form-control font-style']) }}
    </div>
    <h6>{{__('Additional Information')}}</h6>
    <br><br>

    @if (!empty($product_tag_json_HTML))
        {!! $product_tag_json_HTML !!}
    @endif
    <div class="form-group col-md-6">
        {!! Form::label('', __('Trending'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="trending" value="0">
            <input type="checkbox" class="form-check-input" name="trending" id="trending_product" value="1">
            <label class="form-check-label" for="trending_product"></label>
        </div>
    </div>
    <div class="form-group col-md-6" id="downloadable-product-div">
        <div class="form-group">
            <div class="choose-file">
                <label for="downloadable_product" class="form-label">{{ __('Downloadable Product') }}</label>
                <input type="file" class="form-control" name="downloadable_product" id="downloadable_product">
                <div class="invalid-feedback">{{ __('invalid form file') }}</div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6 product-weight">
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


    {{-- <div class="form-group col-md-4 product_stock">
        {!! Form::label('', __('Stock'), ['class' => 'form-label']) !!}
        {!! Form::number('product_stock', null, ['class' => 'form-control', 'min' => '0']) !!}
    </div> --}}


    <div class="form-group col-md-2 d-none">
        {!! Form::label('', __('Status'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="status" value="1">
        </div>
    </div>
    <h6>{{__('Product Stock')}}</h6>
    <br><br>
    @if ($stock_management == 'on')
        <div class="form-group col-md-4">
            {!! Form::label('', __('Stock Management'), ['class' => 'form-label']) !!}
            <div class="form-check form-switch">
                <input type="hidden" name="track_stock" value="0">
                <input type="checkbox" class="form-check-input enable_product_stock" name="track_stock"
                    id="enable_product_stock" value="1">
                <label class="form-check-label" for="enable_product_stock"></label>
            </div>
        </div>
    @else
        <div class="form-group col-md-4 product_stock">
            {!! Form::label('', __('Stock Management'), ['class' => 'form-label']) !!}<br>
            <label name="trending" value=""><small>Disabled in <a
                        href="{{ route('admin.setting.index') . '#Brand_Setting ' }}"> store setting</a></small></label>
        </div>
    @endif

    <div class="form-group col-md-6 stock_stats">
        {!! Form::label('', __('Stock Status:'), ['class' => 'form-label']) !!}
        <div class="col-mb-9">
            <div class="form-check form-check-inline">
                <input class="form-check-input code" type="radio" id="in_stock" value="in_stock"
                    name="stock_status" checked="checked">
                <label class="form-check-label" for="in_stock">
                    {{ __('In Stock') }}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input code" type="radio" id="out_of_stock" value="out_of_stock"
                    name="stock_status">
                <label class="form-check-label" for="out_of_stock">
                    {{ __('Out of stock') }}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input code" type="radio" id="on_backorder" value="on_backorder"
                    name="stock_status">
                <label class="form-check-label" for="on_backorder">
                    {{ __('On Backorder') }}
                </label>
            </div>
        </div>
    </div>
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
                        class="form-check-input code" checked="checked">
                    <label class="form-check-label" for="not_allow">{{ __('Do Not Allow') }}</label>
                </div>
                <div class="form-check m-1">
                    <input type="radio" id="notify_customer" value="notify_customer" name="stock_order_status"
                        class="form-check-input code">
                    <label class="form-check-label"
                        for="notify_customer">{{ __('Allow, But notify customer') }}</label>
                </div>
                <div class="form-check m-1">
                    <input type="radio" id="allow" value="allow" name="stock_order_status"
                        class="form-check-input code">
                    <label class="form-check-label" for="allow">{{ __('Allow') }}</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('', __('Low stock threshold'), ['class' => 'form-label']) !!}
                {!! Form::number('low_stock_threshold', $low_stock_threshold, ['class' => 'form-control', 'min' => '0']) !!}
            </div>
        </div>
    @endif



    <h6>{{__('Product Variant')}}</h6>
    <br><br>
    <div class="form-group col-md-4">
        {!! Form::label('', __('Display Variants'), ['class' => 'form-label']) !!}
        <div class="form-check form-switch">
            <input type="hidden" name="variant_product" value="0">
            <input type="checkbox" class="form-check-input enable_product_variant" name="variant_product"
                id="enable_product_variant" value="1">
            <label class="form-check-label" for="enable_product_variant"></label>
        </div>
    </div>

    <div class="form-group col-md-12">
        {!! Form::label('', __('Product Attribute'), ['class' => 'form-label']) !!}
        {!! Form::select('attribute_id[]', $ProductAttribute, null, [
            'class' => 'form-control attribute_option',
            'multiple' => 'multiple',
            'data-role' => 'tagsinput',
            'id' => 'attribute_id',
        ]) !!}
        <small>{{ __('Choose Existing Attribute') }}</small>
    </div>
    <div class="attribute_options" id="attribute_options">
    </div>
    <div class="attribute_combination" id="attribute_combination">
    </div>



    {{-- <div class="form-group col-md-12" style="display: none;" id="Product_Variant_Select">
        {!! Form::label('', __('Product Variant'), ['class' => 'form-label']) !!}
        {!! Form::select('variants_id[]', $ProductVariants, null, ['class' => 'form-control', 'multiple' => 'multiple', 'data-role' => 'tagsinput', 'id' => 'variant_tag']) !!}
        <small>{{ __('Choose the attributes of this product and then input values of each attribute') }}</small>
    </div>

    <div class="Product_Variant_atttt" id="customer_choice_options">
    </div>

    <div class="sku_combination Product_Variant_atttt" id="sku_combination">
    </div> --}}



    <div class="modal-footer pb-0">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" id="submit" value="Create" class="btn btn-primary">
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
    $(document).on("change", "#enable_custom_field", function() {
        $('#custom_value').hide();
        $('.custom_field').hide();
        if ($(this).prop('checked') == true) {
            $('#custom_value').show();
            $('.custom_field').show();
        }
    });
</script>
<script>
    $(document).on("change", "#enable_product_variant", function() {
        $('.product-price-div').show();
        $('.product-weight').show();
        $('#Product_Variant_Select').hide();
        $('.Product_Variant_atttt').hide();
        $('#use_for_variation').addClass("d-none");
        $('.product_price input').prop('readOnly', false);
        $('.product_discount_amount input').prop('readOnly', false);
        $('.product_discount_type input').prop('readOnly', false);
        if ($(this).prop('checked') == true) {
            $('.product-price-div').hide();
            $('.product-weight').hide();
            $('#Product_Variant_Select').show();
            $('.Product_Variant_atttt').show();
            $("#use_for_variation").removeClass("d-none");
            $('.product_price input').prop('readOnly', true);
            $('.product_discount_amount input').prop('readOnly', true);
            $('.product_discount_type input').prop('readOnly', true);
        }
    });
    $(document).ready(function() {
        $('#options').hide();
        $('.stock_stats').show();
        $(document).on("change", "#enable_product_stock", function() {
            $('#options').prop('checked', false);

            if ($(this).prop('checked')) {
                $('#options').show();
                $('.stock_stats').hide();
            } else {
                $('#options').hide();
                $('.stock_stats').show();
            }
        });
    });

    function update_sku(val = '') {
        var variant_val = $('.variant_choice').val();
        if (variant_val == '') {
            return;
        }
        $.ajax({
            type: "POST",
            url: '{{ route('admin.products.sku_combination') }}',
            data: $('#choice_form').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content'),
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

    $(document).on('change', '#variant_tag', function() {
        $('#customer_choice_options').html("<h3 class='d-none'>Variation</h3>");
        $.each($("#variant_tag option:selected"), function() {
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

    $(document).on('change', '#attribute_id', function() {
        $('#attribute_options').html("<h3 class='d-none'>Variation</h3>");

        var selectedOptions = $("#attribute_id option:selected");

        selectedOptions.each(function() {
            var optionValue = $(this).val();
            var optionText = $(this).text();

            add_more_choice_option(optionValue, optionText);

            var attribute_id = optionValue;

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
                        $(".attribute").append(
                            '<option class="option-item" value="' + key + '">' +
                            value + '</option>');
                    });

                    var multipleCancelButton = new Choices('#attribute' + attribute_id, {
                        removeItemButton: true,
                    });
                }
            });
        });
    });

    function update_attribute() {
        var variant_val = $('.attribute option:selected')
            .toArray().map(item => item.text).join();
        if (variant_val == '') {
            return;
        }
        $.ajax({
            type: "POST",
            url: '{{ route('admin.products.attribute_combination') }}',
            data: $('#choice_form').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content'),
            success: function(data) {

                $('#attribute_combination').html(data);
                if (data.length > 1) {
                    $('#quantity').hide();
                } else {
                    $('#quantity').show();
                }


            }
        });
    }

    $(document).on("change", "#enable_product_variant", function() {
        if ($(this).prop('checked') == true) {
            $(document).on('change', '.attribute', function() {
                var b = $(this).closest('.parent-clase').find('.input-options');
                var enableVariationValue = b.data('enable-variation');
                var dataid = b.attr('data-id');
                if ($('.enable_variation_' + dataid).prop('checked') == true) {
                    update_attribute();
                }
            });

            var b = $(this).closest('.parent-clase').find('.input-options');
            var enableVariationValue = b.data('enable-variation');
            var dataid = b.attr('data-id');
            if ($('.enable_variation_' + dataid).prop('checked') == true) {
                $('input[name="price"]').on('keyup', function() {
                    update_attribute();
                });
                $('input[name="sku"]').on('keyup', function() {
                    update_attribute();
                });
            }
        }
    });

    $(document).on('change', '#attribute_id', function() {
        $('#attribute_options').html("<h3 class='d-none'>Variation</h3>");
        $.each($("#attribute_id option:selected"), function() {
            add_more_choice_option($(this).val(), $(this).text());
        });
    });
</script>
<script>
    $(document).ready(function() {
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
</script>
