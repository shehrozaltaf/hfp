@extends('layouts.errors.master')
@section('title', 'Error 403')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- error-403 start-->
        <div class="error-wrapper">
            <div class="container"><img class="img-100" src="{{asset(config('global.asset_path').'/images/other-images/sad.png')}}"
                                        alt="">
                <div class="error-heading">
                    <h2 class="headline font-danger">403</h2>
                    <h4 class="  font-danger">Forbidden Access or Unauthorized</h4>
                </div>
                <div class="col-md-8 offset-md-2">
                    <p class="sub-content">The user does not have access to view this content.</p>
                </div>
                <div><a class="btn btn-danger-gradien btn-lg" href="{{route('/')}}">BACK TO HOME PAGE</a></div>
            </div>
        </div>
        <!-- error-403 end-->
    </div>
@endsection

@section('script')

@endsection
