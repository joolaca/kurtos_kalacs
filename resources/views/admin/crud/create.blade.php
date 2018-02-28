@extends('admin.layouts.admin_layout')
@section('content')

    <h1 class="page-title"> {{ $create_title or "" }}
        <small>{{ $create_subtitle or "" }}</small>
    </h1>

    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">{{ $create_title or "" }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    @yield('before_form')

                    @include('admin/crud/crudform')

                    @yield('after_form')

                    @yield('modals')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-full" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe frameborder="0" scrolling="no" id="modalframe" data-callback="" data-caller="" width="100%" height="560"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.close') }}</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@if(isset($js_blade_path) && !empty($js_blade_path))
    @include($js_blade_path)
@endif

@push('include_scripts')

@if(isset($js_path) && !empty($js_path))
    <script src="{{ url($js_path) }}" type="text/javascript"></script>
@endif

@if(isset($js_path2) && !empty($js_path2))
    <script src="{{ url($js_path2) }}" type="text/javascript"></script>
@endif
@endpush



@push('extend_scripts')
url = '{{ $url }}';
$(document).ready(function(){
$(".loadingButton").on("click", function(){
if($("#crudform")[0].checkValidity()){
$(".loadingButton").button('loading');
}
});
});
@endpush


@if(isset($js_blade_path) && !empty($js_blade_path))
    @include($js_blade_path)
@endif


@push('extend_scripts')
var preload_img_src = '{{ URL::asset('/assets/images/preload.png') }}';
@endpush