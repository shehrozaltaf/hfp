@extends('layouts.simple.master')

@section('title', 'Default')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Complaints <small>Top 10 Complaints</small></h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.complaints_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6  col-lg-6  col-sm-12">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Lahore</h4></div>
                    <div class="div">
                        <div id="container_top5_u5"></div>
                    </div>
                    <div class="div">
                        <div id="container_top5_wra"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6  col-lg-6  col-sm-12">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Rawalpindi</h4></div>
                    <div class="div">
                        <div id="container_top5_u5_rwp"></div>
                    </div>
                    <div class="div">
                        <div id="container_top5_wra_rwp"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('script')

    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/stock-prices.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/chart-custom.js')}}"></script>
    <script>

        $(document).ready(function () {
            top5_u5();
            top5_u5_rwp();
            top5_wra();
            top5_wra_rwp();
        });


        function top5_u5() {
            var options = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val +'%'
                    },
                },
                series: [],
                title: {
                    text: 'Under 5',
                },
                noData: {
                    text: 'Loading...'
                },
                tooltip: {
                    y: {
                        formatter: function (value, {series, seriesIndex, dataPointIndex, w}) {
                            return value + '%';
                        }
                    }
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#container_top5_u5"),
                options
            );

            chart.render();

            var url = '{{route('getTopComplaint')}}';
            $.getJSON(url,{id:'Lahore',graph:'u5'}, function (response) {
                chart.updateSeries([{
                    name: 'Complaints',
                    data: response
                }])
            });
        }

        function top5_u5_rwp() {
            var options = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                colors: ['#E91E63'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val +'%'
                    },
                },
                series: [],
                title: {
                    text: 'Under 5',
                },
                noData: {
                    text: 'Loading...'
                },
                tooltip: {
                    y: {
                        formatter: function (value, {series, seriesIndex, dataPointIndex, w}) {
                            return value + '%';
                        }
                    }
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#container_top5_u5_rwp"),
                options
            );

            chart.render();

            var url = '{{route('getTopComplaint')}}';
            $.getJSON(url,{id:'Rawalpindi',graph:'u5'}, function (response) {
                chart.updateSeries([{
                    name: 'Complaints',
                    data: response
                }])
            });
        }


        function top5_wra() {
            var options = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val +'%'
                    },
                },
                series: [],
                title: {
                    text: 'WRA',
                },
                noData: {
                    text: 'Loading...'
                },
                tooltip: {
                    y: {
                        formatter: function (value, {series, seriesIndex, dataPointIndex, w}) {
                            return value + '%';
                        }
                    }
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#container_top5_wra"),
                options
            );

            chart.render();

            var url = '{{route('getTopComplaint')}}';
            $.getJSON(url,{id:'Lahore',graph:'wra'}, function (response) {
                chart.updateSeries([{
                    name: 'Complaints',
                    data: response
                }])
            });
        }

        function top5_wra_rwp() {
            var options = {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                colors: ['#E91E63'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val +'%'
                    },
                },
                series: [],
                title: {
                    text: 'WRA',
                },
                noData: {
                    text: 'Loading...'
                },
                tooltip: {
                    y: {
                        formatter: function (value, {series, seriesIndex, dataPointIndex, w}) {
                            return value + '%';
                        }
                    }
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#container_top5_wra_rwp"),
                options
            );

            chart.render();

            var url = '{{route('getTopComplaint')}}';
            $.getJSON(url,{id:'Rawalpindi',graph:'wra'}, function (response) {
                chart.updateSeries([{
                    name: 'Complaints',
                    data: response
                }])
            });
        }
    </script>
@endsection
