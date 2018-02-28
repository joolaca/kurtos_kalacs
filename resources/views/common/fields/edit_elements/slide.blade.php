<div id="slide_container_{{$field->getName()}}">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 slide-element">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-layers font-green"></i>
                    <span class="caption-subject font-green bold uppercase">{{$field->getLabel()}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="mt-element-overlay">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mt-overlay-1 margin-bottom-15 data_container_{{$field->getName()}}">

                                {{ Form::hidden($field->getName(), $value) }}

                                @if($slide)

                                    <img src="{{$slide->adminIndexImageUrl('image', 'admin_form_')}}">

                                    <div class="mt-overlay">
                                        <ul class="mt-info">
                                            <li>
                                                <a class="btn default btn-outline" href="#" data-toggle="modal" data-target="#show_image_modal" title="{{trans('crud.slide.original_image')}}" data-original_image="{{$slide->adminIndexImageUrl('image', '')}}">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="btn default btn-outline" target="_blank" href="{{url('/slides/'.$slide->id.'/edit')}}" title="{{trans('crud.slide.image_details')}}">
                                                    <i class="icon-link"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="{{trans('crud.slide.image_delete')}}" class="btn default btn-outline delete_contentype_image" data-col="{{$field->getName()}}">
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>


                                @else
                                    <img src="{{ URL::asset('/assets/images/preload.png') }}">
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">

                            <a href="#" id="btn_add_related_{{ $field->getName() }}" class="btn btn-success btn_related_add"
                               data-id="{{ $item->id or "0" }}"
                               data-src="{{ url('slides/modal') }}"
                               data-col="{{$field->getName()}}"
                               data-container="slide_container_{{$field->getName()}}"
                               data-target="#edit_modal"
                               data-toggle="modal"
                               data-callback="add_image">
                                {{trans('global.add_new')}}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('modals')
    <div id="show_image_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-full" role="document">
            <div class="modal-content">
                <div class="modal-body text-center"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('global.close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
