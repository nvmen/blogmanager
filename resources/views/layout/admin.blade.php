<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('pageTitle') | Monita - Blog Manager</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ URL::asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href=" {{ URL::asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href=" {{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/cs-skin-elastic.css') }}">

    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/scss/style.css') }}">
    <link href="{{ URL::asset('assets/css/lib/vector-map/jqvmap.min.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/loader.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/jquery.nimble.loader.js') }}"></script>
    <script src="{{ URL::asset('js/common.js') }}"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>


<!-- Left Panel -->

    @include('includes.leftmenu')

<!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->

        @include('includes.toprightmenu')
   <!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>@yield('pageTitle')</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">@yield('pageTitle')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        @yield('content')

    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<script src="{{ URL::asset('assets/js/plugins.js') }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>


<!--<script src="{{ URL::asset('assets/js/lib/chart-js/Chart.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/js/dashboard.js') }}"></script>
<script src="{{ URL::asset('assets/js/widgets.js') }}"></script>
<script src="{{ URL::asset('assets/js/lib/vector-map/jquery.vmap.js') }}"></script>
<script src="{{ URL::asset('assets/js/lib/vector-map/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/lib/vector-map/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ URL::asset('assets/js/lib/vector-map/country/jquery.vmap.world.js') }}"></script>-->


</body>
</html>
