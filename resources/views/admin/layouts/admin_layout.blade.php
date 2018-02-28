<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/metronic/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/jcrop/jquery.Jcrop.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/metronic/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/metronic/pages/css/login.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/css/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/sweetalert-master/dist/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/css/crud.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ URL::asset('favicon.ico') }}" rel="shortcut icon" />

    <link href="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('/assets/js/other/moment.min.js') }}" type="text/javascript"></script>
    <link href="{{ URL::asset('/assets/metronic/global/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/x-editable/x-editable.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('/assets/metronic/global/plugins/jstree/style.min.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>


<div class="content">
    {{ URL::asset('/assets/metronic/layouts/layout/css/themes/darkblue.min.css') }}
    @include('flash::message')
<div class="page-wrapper">
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                @include('admin/menu')
            </div>
        </div> {{--end  page-sidebar-wrapper--}}

        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div> {{--end page-content-wrapper--}}

    </div>
</div>


</div>

<!-- Scripts -->
<script src="{{ url('/js/bootstrap.js') }}"></script>

<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/pages/scripts/ui-nestable.js?1484121695') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jcrop/jquery.Jcrop.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/timepicker/jquery-ui-timepicker-addon.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/x-editable/x-editable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/sweetalert-master/dist/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jstree/jstree.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/pages/scripts/ui-tree.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/js/crud/base_crud.js') }}" type="text/javascript"></script>

<script  src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{url('/js/tinymce_init.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/admin/menu.js')}}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    url_prefix = '{{ url('/') }}';
</script>

@stack('include_scripts')

@stack('scripts_code')

@yield('include_script')

</body>
</html>
