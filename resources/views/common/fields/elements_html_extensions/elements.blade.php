@if($type == 'requiredSpan')
{{-- required span --}}
<span class="required">*</span>
@elseif($type == 'iconFa' && isset($icon) && !empty($icon))
{{-- i fa icon --}}
<i class="fa fa-{{ $icon }}"></i>
@elseif($type == 'addonSpan' && isset($addon_text) && !empty($addon_text))
{{-- addon span --}}
<span class="input-group-addon">{{ $addon_text }}</span>
@elseif($type == 'popover' && isset($popover) && !empty($popover['content']))
{{-- popover --}}
<span class="input-group-btn">
    <button type="button" class="btn btn-default text-info input_info_popover" data-html="true" data-container="body" data-toggle="popover" data-placement="left" title="{{ !empty($popover["title"]) ? $popover["title"] : '' }}" data-content="{!! !empty($popover["content"]) ? htmlentities($popover["content"]) : ''  !!}" data-trigger="click">
    <i class="fa fa-info"></i>
    </button>
</span>
@elseif($type == 'requiredSpanForJsAsString')<span class="required">*</span>@endif