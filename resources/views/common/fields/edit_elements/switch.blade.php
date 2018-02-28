<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

<div class="input">
    {{ Form::checkbox($field->getName(), $value, ($value==1), $field->getAttributes()) }}
</div>