@foreach ($product_tag_json as $json_key => $section)
    @php $section = (array)$section; @endphp
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('Tag') }}</label> <br>
            @foreach ($section['inner-list'] as $inner_list_key => $field)
                @php $field = (array)$field; @endphp

                <input type="hidden" name="tag[{{ $json_key }}][section_name]"
                    value="{{ $section['section_name'] }}">
                <input type="hidden" name="tag[{{ $json_key }}][section_slug]"
                    value="{{ $section['section_slug'] }}">
                <input type="hidden" name="tag[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_name]"
                    value="{{ $field['field_name'] }}">
                <input type="hidden" name="tag[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_slug]"
                    value="{{ $field['field_slug'] }}">
                <input type="hidden"
                    name="tag[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_help_text]"
                    value="{{ $field['field_help_text'] }}">
                <input type="hidden"
                    name="tag[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_default_text]"
                    value="{{ $field['field_default_text'] }}">
                <input type="hidden" name="tag[{{ $json_key }}][inner-list][{{ $inner_list_key }}][field_type]"
                    value="radio">
                <div class="d-inline">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="{{ $field['field_default_text'] }}"
                            {{ !empty($section['value']) && $section['value'] == $field['field_name'] ? 'checked' : '' }}
                            {{ empty($section['value']) && in_array($field['field_name'], ['none', 'None']) ? 'checked' : '' }}
                            id="customCheckinlh2{{ $inner_list_key }}" name="tag[{{ $json_key }}][value]">
                        <label class="form-check-label text-capitalize" for="customCheckinlh2{{ $inner_list_key }}">
                            {{ $field['field_name'] }} </label>
                    </div>
                </div>
            @endforeach
        </div>
@endforeach


