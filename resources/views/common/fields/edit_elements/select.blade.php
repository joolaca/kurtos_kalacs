<label class="control-label">{{ $field->getEdit()['label'] }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{ Form::select($field->getName(), $options, $field->getItemValue($item), $field->getAttributes()) }}