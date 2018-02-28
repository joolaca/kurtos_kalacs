<label class=" control-label">{{$field->getLabel()}}</label>
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

<?php
    $value = $field->getItemValue($item);
	$attributes = $field->getAttributes();
?>

{{ Form::textarea($field->getName(), $value, [
    'class' => 'form-control '.(isset($attributes['class']) ? $attributes['class'] : '' ) ,
    'size' => ((isset($attributes['cols']) ? $attributes['cols'] : '100' ) . 'x' . (isset($attributes['rows']) ? $attributes['rows'] : '5' )),
    'placeholder' => (isset($attributes['placeholder']) ? $attributes['placeholder'] : "")
]) }}