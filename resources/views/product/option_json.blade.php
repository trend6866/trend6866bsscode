@foreach ($option_json as $json_key => $section)
    @php $section = (array)$section; @endphp
    <div class="row">
        @foreach ($section['inner-list'] as $inner_list_key => $field)
        @php $field = (array)$field; @endphp
            <div felid_name="{{ $field['field_name'] }}">
                <input type="hidden" name="arrays[{{ $json_key }}][section_name]" value="{{ $section['section_name'] }}">
                <input type="hidden" name="arrays[{{ $json_key }}][section_slug]" value="{{ $section['section_slug'] }}">
                <input type="hidden" name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_name]"
                    value="{{ $field['field_name'] }}">
                <input type="hidden" name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_slug]"
                    value="{{ $field['field_slug'] }}">
                <input type="hidden"
                    name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_help_text]"
                    value="{{ $field['field_help_text'] }}">
                <input type="hidden"
                    name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                    value="{{ $field['field_default_text'] }}">
                <input type="hidden" name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_type]"
                    value="{{ $field['field_type'] }}">
            </div>

            @if ($field['field_type'] == 'text')
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ $field['field_name'] }}</label>
                        <input type="text"
                            name="arrays[{{ $json_key }}][inner-list][{{ $inner_list_key }}][value]"
                            class="form-control"
                            value="{{ !empty($field['value']) ? $field['value'] : $field['field_default_text'] }}">
                        <small>{{ $field['field_help_text'] }}</small>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endforeach