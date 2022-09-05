@extends('layouts.errors.master')
@section('title', 'Error 500')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- error-500 start-->
  <div class="error-wrapper">
    <div class="container"><img class="img-100" src="{{asset(config('global.asset_path').'/images/other-images/sad.png')}}" alt="">
      <div class="error-heading">
        <h2 class="headline font-danger">500</h2>
          <h5 class="  font-danger">Internal Server Error</h5>
      </div>
      <div class="col-md-8 offset-md-2">
        <p class="sub-content">The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.</p>
      </div>
      <div><a class="btn btn-danger-gradien btn-lg" href="{{route('/')}}">BACK TO HOME PAGE</a></div>
    </div>
  </div>
  <!-- error-500 end-->
</div>
@endsection

@section('script')

@endsection
