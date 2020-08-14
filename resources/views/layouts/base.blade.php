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

    @include('leadinc.base_style')

    @include('leadinc.base_script')

    @yield('other_source')

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

  </body>
</html>