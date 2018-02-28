<div class="link_content_container {{ $field->isHideEdit() ? "hidden" : "" }}">
    <label class="control-label">{{ $field->getLabel() ? $field->getLabel() : trans('global.please_select') }}</label>
    {{-- Kötelező jelölés ha be van állítva  --}}
    @if($field->hasValidaionRule('required'))
        @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
    @endif

    {{-- Konténer div  --}}
    <div class="input">
        {{-- Rejtett input mező  --}}
        {{ Form::hidden($field->getName(), $value, array('id' => 'link_content_id')) }}

        @if($value && $content_type_item)

            <a id="choose_content_type_item" title="{{ trans('global.modification') }}" data-content-type-id="{{ $field->getContentTypeId() }}" data-type="{{ $field->getContentType() }}" class="btn btn-link">
                <i class="fa fa-check"></i> {{ $content_type_item->title }}
            </a>
        @else
            {{--
            Látható hivatkozás
            data-content-type-id => pl: 10
            data-type => pl: galleries
            --}}
            <a id="choose_content_type_item" data-content-type-id="{{ $field->getContentTypeId() }}" data-type="{{ $field->getContentType() }}" class="btn btn-info">
                {{ $field->getButtonLabel() ? $field->getButtonLabel() : trans('global.selection')  }}
            </a>
        @endif
    </div>
</div>

@push('include_scripts')
<script src="{{ URL::asset('/assets/js/content_type/content_type.js') }}" type="text/javascript"></script>
@endpush