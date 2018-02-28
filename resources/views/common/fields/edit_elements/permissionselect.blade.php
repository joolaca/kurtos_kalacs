<label class="control-label">{{ $field->getEdit()['label'] }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{ Form::select($field->getName(), ['' => trans('crud.select.first_option_name')] + $options, $value, $field->getAttributes()) }}