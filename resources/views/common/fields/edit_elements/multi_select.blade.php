<label class=" control-label"> {{$field->getLabel()}} </label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

<select name="{{$field->getName()}}[]" id="{{$field->getName()}}" class="form-control select_" multiple>
    @foreach($options as $option)
        {!! $option !!}
    @endforeach
</select>