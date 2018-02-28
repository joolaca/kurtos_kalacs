<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required') || $field->getAttributes('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{ Form::file($field->getName().'[]', $field->getAttributes()) }}

@if(is_null($item))
Maximális mérete: 15MB
@endif