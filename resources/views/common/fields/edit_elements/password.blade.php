<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{-- Container div class beállítása  --}}
@php
    $input_class = 'input';
    if(!empty($field->getIcon())) { $input_class .= '-icon'; }
@endphp

<div class="{{ $input_class }}">
    {{-- Icon beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'iconFa', 'icon' => $field->getIcon()])

    {{-- Tartalmi megjelenítés --}}
    {{ Form::password($field->getName(), $field->getAttributes()) }}


    {{-- Popover beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), [
        'type' => 'popover',
        'popover' => [
            'title' => !empty($field->getPopover()['title']) ? $field->getPopover()['title'] : null,
            'content' => !empty($field->getPopover()['content']) ? $field->getPopover()['content'] : null,
        ]
    ])

</div>