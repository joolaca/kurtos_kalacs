<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{ Form::select($field->getName(), ['' => trans('crud.select.first_option_name'), '0' => trans('crud.select.no'), '1' => trans('crud.select.yes')], $value, $field->getAttributes()) }}