<label class="control-label">{{ $field->getLabel() }}</label>
{{-- Kötelező jelölés ha be van állítva  --}}
@if($field->hasValidaionRule('required'))
    @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
@endif

{{ Form::text($field->getAjaxId(), $field->getAutocompleteTextValue(), $field->getAttributes()) }}
{{ Form::hidden($field->getName(), $value, ['id' => $field->getName()]) }}


@push('scripts_code')
<script>
    $( function() {
        $(".ajax_select").autocomplete({
            source: "{{ $field->getSource() }}",
            minLength: 3,
            autoFocus: true,
            select: function( event, ui ) {

                var target = $(this).data('target');
                $('#'+target).val(ui.item.id);
            }
        });
    });
</script>
@endpush