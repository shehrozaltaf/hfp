@extends('layouts.errors.master')
@section('title', 'Error 401')

@section('css')
@endsection

@section('style')
@endsection


@section('content')

<div class="page-wrapper compact-wrapper" id="pageWrapper">
<!-- error-400 start-->
   <div class="error-wrapper">
        <div class="container"><img class="img-100" src="{{ asset(config('global.asset_path').'/images/other-images/sad.png') }}" alt="">
               <div class="error-heading">
                  <h2 class="headline font-info">400</h2>
                  <h5 class="  font-info">Bad Request</h5>
               </div>
               <div class="col-md-8 offset-md-2">
                  <p class="sub-content">The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).</p>
               </div>
               <div><a class="btn btn-info-gradien btn-lg" href="{{route('/')}}">BACK TO HOME PAGE</a></div>
        </div>
   </div>
<!-- error-400 end-->
</div>
@endsection

@section('script')

@endsection
