@if (count($combinations[0]) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="text-center">
                    <label for="" class="control-label">{{ __('Variant') }}</label>
                </td>
                <td class="text-center">
                    <label for="" class="control-label">{{ __('Variant Price') }}</label>
                </td>
                <td class="text-center">
                    <label for="" class="control-label">{{ __('SKU') }}</label>
                </td>
                <td class="text-center">
                    <label for="" class="control-label">{{ __('Stock') }}</label>
                </td>
                <td class="text-center">
                    <label for="" class="control-label">{{ __('Default ') }}</label>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($combinations as $key => $combination)
                @php
                    $sku = $product_name;
                    
                    $str = '';
                    foreach ($combination as $key => $item) {
                        if ($key > 0) {
                            $str .= '-' . str_replace(' ', '', $item);
                            $sku .= '-' . str_replace(' ', '', $item);
                        } else {
                            $str .= str_replace(' ', '', $item);
                            $sku .= '-' . str_replace(' ', '', $item);
                        }
                    }
                @endphp
                @if (strlen($str) > 0)
                    <tr>
                        <td>
                            <label for="" class="control-label">{{ $str }}</label>
                        </td>
                        <td>
                            <input type="number" name="price_{{ $str }}" value="{{ $unit_price }}"
                                min="0" step="0.01" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="sku_{{ $str }}" value="{{ $sku }}"
                                class="form-control" required>
                        </td>
                        <td>
                            <input type="number" name="stock_{{ $str }}" class="form-control" required
                                min='0' value="{{ $stock }}">
                        </td>
                        <td>
                            <div class="form-check">
                                {!! Form::radio('default_variant', $sku, ($key == 0) ? 1 : 0 , ['class' => 'form-check-input']) !!}
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif
