<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shahroz Khan - {{config('global.project_shortname')}}">
    <meta name="keywords" content="Shahroz Khan - {{config('global.project_shortname')}}">
    <meta name="author" content="Shahroz Kha">
    <link rel="icon" href="{{asset(config('global.asset_path').'/images/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset(config('global.asset_path').'/images/favicon.png')}}" type="image/x-icon">
     <title>{{config('global.project_shortname')}}</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">

    @include('layouts.authentication.css')
    @yield('style')
  </head>
  <body>
    <!-- login page start-->
    @yield('content')
    <!-- latest jquery-->
    @include('layouts.authentication.script')
  </body>
</html>
