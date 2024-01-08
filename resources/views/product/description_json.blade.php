@foreach ($json as $json_key => $section)
    @php $section = (array)$section; @endphp
    <div class="row">
        @foreach ($section['inner-list'] as $inner_list_key => $field)
            @php $field = (array)$field; @endphp
            <div felid_name="{{ $field['field_name'] }}">
                <input type="hidden" name="array[{{ $json_key }}][section_name]" value="{{ $section['section_name'] }}">
                <input type="hidden" name="array[{{ $json_key }}][section_slug]" value="{{ $section['section_slug'] }}">
                <input type="hidden" name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_name]"
                    value="{{ $field['field_name'] }}">
                <input type="hidden" name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_slug]"
                    value="{{ $field['field_slug'] }}">
                <input type="hidden"
                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_help_text]"
                    value="{{ $field['field_help_text'] }}">
                <input type="hidden"
                    name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                    value="{{ $field['field_default_text'] }}">
                <input type="hidden" name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_type]"
                    value="{{ $field['field_type'] }}">
            </div>


            @if ($field['field_type'] == 'text area')
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label">{{ $field['field_name'] }}</label>
                        <textarea class="form-control autogrow" name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                            rows="3">{{ !empty($field['value']) ? $field['value'] : $field['field_default_text'] }}</textarea>
                        <small>{{ $field['field_help_text'] }}</small>
                    </div>
                </div>
            @endif

            @if ($field['field_type'] == 'photo upload')
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label">{{ $field['field_name'] }}</label>
                        <input type="hidden"
                            name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                            value="{{ !empty($field['value']) ? $field['value'] : '' }}" >

                        <input type="file"
                            name="array[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                            class="form-control">
                        <small>{{ $field['field_help_text'] }}</small>
                    </div>
                </div>
                <div class="col-sm-2">                    
                    @if (!empty($field['value']) && !empty(@getimagesize(url($field['value']))))
                        {!! Html::image($field['value'], '', array('class' => 'w-100')) !!}
                    @endif
                    
                </div>
            @endif
        @endforeach
    </div>
@endforeach