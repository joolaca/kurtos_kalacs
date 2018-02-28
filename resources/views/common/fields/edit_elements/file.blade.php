@php($controller = Route::getCurrentRoute()->getController())
<div class='image_upload_container'>
    <label class="control-label">{{ $field->getLabel() }}</label>
    @if($field->hasValidaionRule('required') || $field->getAttributes('required'))
        @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
    @endif

    {{ Form::file($field->getName(), $field->getAttributes()) }}

    @if(empty($item->{$field->getName()}))
        <?php echo $upload_max = ini_get('upload_max_filesize'); ?>
    @endif
</div>
@if($item && $item->{$field->getName()})
    <div class="uploaded_image_container pull-left">
        <label>Jelenlegi {{ $field->getLabel() }}</label><br>
        <div class="input-group">
            <div class="btn-group btn-group-circle" role="group">
                <a class="btn btn-default" title="/{{ $item->{$field->getPath()}.$item->{$field->getName()} }}" style="margin-left: 10px;" href="/{{ $item->{$field->getPath()}.$item->{$field->getName()} }}" download>Letöltés</a>
                <a class="btn btn-danger delete_file"
                   data-parent_container=".uploaded_image_container"
                   data-href="{{ url('ajax/delete_file/'.$field->getName().'/'.$item->id) }}"
                   data-model="{{ $controller->crud_data['model_class'] }}"
                   href="#">Törlés</a>
            </div>
        </div>
    </div>

@endif