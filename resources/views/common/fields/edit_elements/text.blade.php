<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{-- Container div class beállítása  --}}
@php
    $input_class = 'input';
    if(!empty($field->getIcon())) { $input_class .= '-icon'; }
    if(!empty($field->getPopover()) || !empty($field->getAddon())) { $input_class .= ' input-group'; }
@endphp

<div class="{{ $input_class }}">
    {{-- Icon beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'iconFa', 'icon' => $field->getIcon()])

    {{-- Addon beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'addonSpan', 'addon_text' => $field->getAddon()])

    {{-- Tartalmi megjelenítés --}}
    @if($field->getPermission())
        {{ Form::text($field->getName(), $field->getItemValue($item), $field->getAttributes()) }}
    @else
        {{ $field->getItemValue($item) }}
    @endif

    {{-- Popover beállítása --}}
    @include($field->getBladeHtmlExtensionsLocation(), [
        'type' => 'popover',
        'popover' => [
            'title' => !empty($field->getPopover()['title']) ? $field->getPopover()['title'] : null,
            'content' => !empty($field->getPopover()['content']) ? $field->getPopover()['content'] : null,
        ]
    ])

</div>
