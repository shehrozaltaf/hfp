@extends('layouts.errors.master')
@section('title', 'Error 401')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
<!-- error-401 start-->
<div class="error-wrapper">
  <div class="container"><img class="img-100" src="{{asset(config('global.asset_path').'/images/other-images/sad.png')}}" alt="">
    <div class="error-heading">
      <h2 class="headline font-warning">401</h2>
        <h5 class="  font-warning">Unauthorized</h5>
    </div>
    <div class="col-md-8 offset-md-2">
      <p class="sub-content">The user trying to access the resource has not been authenticated or has not been authenticated correctly.</p>
    </div>
    <div><a class="btn btn-warning-gradien btn-lg" href="{{route('/')}}">BACK TO HOME PAGE</a></div>
  </div>
</div>
<!-- error-401 end-->
</div>
@endsection

@section('script')

@endsection
