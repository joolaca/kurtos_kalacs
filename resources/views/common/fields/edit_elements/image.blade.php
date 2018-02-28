@php($controller = Route::getCurrentRoute()->getController())
<div class='image_upload_container'>
    <label class="control-label">{{ $field->getLabel() }}</label>
    @if($field->hasValidaionRule('required') || $field->getAttributes('required'))
        @include($field->getBladeHtmlExtensionsLocation(), ['type' => 'requiredSpan'])
    @endif
    {{ Form::file($field->getName(), $field->getAttributes()) }}

    {{trans('crud.edit_view.max_upload_size')}}

</div>


@if(!is_null($item) && !is_null($item->{$field->getName()}))
    <div class="uploaded_image_container pull-left">
        <label>{{trans('crud.current_picture')}}</label><br>

        <div class="image_field_container">

            <div class="image_field_overlay"> </div>

            <img style="max-width:400px;" src='{{url($item->{$field->getPathCol()} . $item->{$field->getName()})}}'>
            <div class="icons_container">
                {{-- base_crud js-ben van az (click) eseménykezelés --}}
                <a class="btn default btn-outline delete_file" title="Kép törlése"
                   href="#"
                   data-parent_container=".uploaded_image_container"
                   data-href="{{ url('admin/delete_image/'.$field->getName().'/'.$item->id) }}"
                   data-model="{{ $controller->crud_data['model_class'] }}"
                >
                    <i class="icon-trash"></i>
                </a>
                @if(!empty($thumbnailable) && $thumbnailable === TRUE)
                    <a class="btn default btn-outline" title="Kép részletei" target="_blank"
                       href="/admin/crop_image/{!! $item->id.'/'. $field->getName().'/'.encrypt($controller->crud_data['model_class']) !!}"
                    >
                        <i class="icon-link"></i>
                    </a>
                @endif

                {{--<a class="btn default btn-outline" href="#" title="Eredeti kép">
                    <i class="icon-magnifier"></i>
                </a>--}}

            </div>
        </div>

        @if(!is_null($item))
            <a class="btn btn-default" style="margin-left: 10px;" href="/{{ $item->{$field->getPath()}.$item->{$field->getName()} }}" download>kép letöltése</a>
        @endif

    </div>
@endif