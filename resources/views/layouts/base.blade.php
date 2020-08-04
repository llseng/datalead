<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}@isset($view_title)-{{ $view_title }}@endisset</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('/') }}vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('/') }}vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{ asset('/') }}css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('/') }}css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('/') }}css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('/') }}favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page">
        @include('leadinc.top_nav')
      <div class="page-content d-flex align-items-stretch">
            @include('leadinc.left_nav')
        <div class="content-inner">
            @include('leadinc.content-h')
            @include('leadinc.content-b')
            @include('leadinc.content-alert')

            @yield('content')

            @include('leadinc.content-f')
        </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('/') }}vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}vendor/popper.js/umd/popper.min.js"> </script>
    <script src="{{ asset('/') }}vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="{{ asset('/') }}vendor/chart.js/Chart.min.js"></script>
    <script src="{{ asset('/') }}vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('/') }}js/charts-home.js"></script>
    <!-- Main File-->
    <script src="{{ asset('/') }}js/front.js"></script>
    <script>
        function delete_confirm_url( url ) {
            if( confirm( "删除后不可恢复,确认删除?" ) ) {
                window.location.href = url;
            }
        }
    </script>
  </body>
</html>