<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif
<?php $val = $field->getItemValue($item); ?>

<select name="{{ $field->getName() }}" data-show-icon="true"
    @foreach($field->getAttributes() as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
>
    @foreach($options as $key => $value)
        <option value="{{ $key }}"
            @if($val==$key  || $key == old( $field->getName()) ) selected="selected" @endif
        >
            <i class="fa fa-long-arrow-right"></i>{!! $value !!}
        </option>
    @endforeach
</select>
