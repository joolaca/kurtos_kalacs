<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title>{{ config('app.name', 'Kurtoskalacs') }}</title>


    <!-- Links -->
    <link href="{{ URL::asset('/assets/template/css/template_bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/template/css/camera.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/template/css/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
            <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a>
    </div>
    <script src="{{ URL::asset('/assets/template/js/html5shiv.js') }}" type="text/javascript"></script>
    <![endif]-->


</head>
<body class="{{session('lang_obj')['body_class']}}">
<div class="page">
    <!--========================================================
                              HEADER
    =========================================================-->
    <header>

        {!!  \App\Http\Controllers\CRUD\MenuController::renderFrontendMenu()!!}


    </header>

    <!--========================================================
                              CONTENT
    =========================================================-->

    <main>

        @yield('content')


    </main>

    <!--========================================================
                            FOOTER
  =========================================================-->
    <footer>
        <div class="container">
            <ul class="inline-list">
                <li><a href="https://twitter.com/Krtsmester1" class="fa fa-twitter" target="_blank"></a></li>
                <li><a href="https://www.facebook.com/kurtos.kalacs1/" class="fa fa-facebook" target="_blank"></a></li>
                {{--<li><a href="#" class="fa fa-google-plus"></a></li>--}}
            </ul>

            <hr>

            <h5 class="copyright">
                Kürtősmester
            </h5>
        </div>
    </footer>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->


<!-- </script> -->

<script src="{{ URL::asset('/js/bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/metronic/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/template/js/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('/assets/template/js/device.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/template/js/tm-scripts.js') }}" type="text/javascript"></script>

@stack('script_src')


</body>
</html>
