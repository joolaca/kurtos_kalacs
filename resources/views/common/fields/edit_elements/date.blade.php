<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

@php
    $input_class = 'input';
    if(!empty($field->getIcon())) { $input_class .= '-icon'; }
@endphp

<div class="{{ $input_class }}">

    {{-- Icon beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'iconFa', 'icon' => $field->getIcon()])

    {{-- Tartalmi megjelenítés --}}
    @if($field->getPermission())
        {{ Form::datetime($field->getName(), $value, $field->getAttributes()) }}
    @else
        {{ $value }}
    @endif

</div>