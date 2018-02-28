@extends('admin.layouts.admin_layout')
@section('content')
<h1 class="page-title"></h1>


@if(!empty($search))
    @include('admin/crud/search')
@endif


<div class="row">
    <div class="col-md-12 col-sm-12">

        <div class="portlet light">

            <div class="portlet-title">

                <div class="caption">
                    <i class="icon-share font-dark hide"></i>
                    <span class="caption-subject font-green bold uppercase">{{$crud_data['index_title'] or ""}}</span>
                </div>
                @if(isset($crud_data['export_btn']) && $crud_data['export_btn'] )
                    <a class="btn btn-success pull-right" id="export_crud"> {{ trans('global.export') }} </a>
                @endif
                @if(isset($crud_data['render_index_button']))

                    {!!   $crud_data['controller_path']::{$crud_data['render_index_button']}() !!}
                @endif

                @if(!(isset($crud_data['hide_create_button']) && $crud_data['hide_create_button']))
                    @if(isset($crud_data['create_in_modal']) && !empty($crud_data['create_in_modal']))
                        {{--@include('common/content_type/new_item_modal')--}}
                        <button type="button" class="new_content_type_view btn btn-success pull-right "
                                data-href="{{url('/'.$crud_data['url'].'/modal/create_modal_view')}}">
                            {{ trans('global.add_new') }}
                        </button>
                    @else
                        <a class="btn btn-success pull-right" href="{{url('/admin/'.$crud_data['url'].'/create')}}"> {{ trans('global.add_new') }} </a>
                    @endif
                @endif


            </div>

            <div class="portlet-body">
                @if($is_orderable)
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-primary" href="/{{$crud_data['url']}}">{{ trans('global.save_order') }}</a>
                        </div>

                        <div class="col-md-6">
                        </div>
                    </div>

                    @include('common/crud/crudtable_sort')
                @else
                    @include('admin/crud/crudtable')
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

@push('include_scripts')

@if(isset($crud_data['js_path']) && !empty($crud_data['js_path']))
    <script src="{{ url($crud_data['js_path']) }}" type="text/javascript"></script>
@endif

@endpush