@extends('layouts.simple.master')
@section('title',  trans('lang.apps_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Apps</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Apps</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          {{--  <div class="col-sm-12 col-xl-4">
                <div class="ribbon-wrapper card">
                    <div class="card-body">
                        <div class="ribbon ribbon-primary">HHListing</div>
                        <h5>UEN RS HHListing</h5>
                        <p><a href="./listing/UEN_MidHH_Listing_2021_12_24_Rv428.apk">Download and Install UEN RS HHListing
                                App</a> <span>Version: 1.6R.428</span></p>
                    </div>
                </div>
            </div>--}}

        </div>
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>INSTRUCTIONS</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Download and run the app file to install.</li>
                            <li class="list-group-item">If asked to unblock, select 'Unblock'</li>
                            <li class="list-group-item">'Open' the app.</li>
                            <li class="list-group-item"><span style="color:red">NEVER USE TEST ACCOUNT FOR ACTUAL DATA COLLECTION</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
