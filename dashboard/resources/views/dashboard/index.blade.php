@extends('layouts.simple.master')

@section('title', 'Default')

@section('css')

    <link rel="stylesheet" type="text/css"
          href="{{asset(config('global.asset_path').'/highcharts/css/highcharts.css')}}">

@endsection

@section('style')
    <style>

    </style>
@endsection

@section('breadcrumb-title')
    <h3>Health Facility Punjab</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-sm-12 ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-text ">Total</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6 class=""><?php  echo (isset($data['getTotalPatient'][0]->opd) && $data['getTotalPatient'][0]->opd!=''?$data['getTotalPatient'][0]->opd:'')?></h6>
                                <p class="card-text text-primary">Patients</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="">{{(isset($data['getTotalPatient'][0]->u5) && $data['getTotalPatient'][0]->u5!='')?$data['getTotalPatient'][0]->u5:0}}</h6>
                                <p class="card-text text-primary">Under 5</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="">{{(isset($data['getTotalPatient'][0]->vaccination) && $data['getTotalPatient'][0]->vaccination!=''?$data['getTotalPatient'][0]->vaccination:0)}}</h6>
                                <p class="card-text text-primary">Under 5 Vaccination</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="">{{(isset($data['getTotalPatient'][0]->wra) && $data['getTotalPatient'][0]->wra!=''?$data['getTotalPatient'][0]->wra:0)}}</h6>
                                <p class="card-text text-primary">WRA</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class=""><?php  echo (isset($data['getTotalPatient'][0]->anc) && $data['getTotalPatient'][0]->anc!=''?$data['getTotalPatient'][0]->anc:'')?></h6>
                                <p class="card-text text-primary">ANC</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8  col-sm-12 ">
                <div class="card  ">
                    <div class="card-body">
                        <div class="card-header"><h4 class="card-title">Patient Visited</h4><span>Last 10 weeks</span>
                        </div>
                        <div id="container"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8  xl-50  col-sm-12  box-col-12">
                <div class="card  ">
                    <div class="card-body ">
                        <div id="container_pie"></div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4  col-lg-4 xl-50 col-sm-12   box-col-12">
                <div class="card">

                    <div class="card-header"><h4 class="card-title">Top 5 Diagnosis</h4></div>
                    <div class="div">
                        <h6 class="card-title p-2 text-align-center text-center ">Under 5</h6>
                        <div id="container_top5_u5"></div>
                    </div>
                    <div class="div">
                        <h6 class="card-title p-2   text-center ">WRA</h6>
                        <div id="container_top5_wra"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')

    <script src="{{asset(config('global.asset_path').'/highcharts/highcharts.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/highcharts/modules/data.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/highcharts/modules/series-label.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/highcharts/modules/exporting.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/highcharts/modules/export-data.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/highcharts/modules/accessibility.js')}}"></script>


    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/stock-prices.js')}}"></script>
    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/chart-custom.js')}}"></script>
    <script>

        $(document).ready(function () {
            weekly_chart();
             top5_u5();
             top5_wra();
        });

        function weekly_chart() {
            var options = {
                series: [{
                    name: 'Lahore',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                }, {
                    name: 'Rawalpindi',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                },],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                },
                yaxis: {
                    title: {
                        text: 'Number of Patients'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Number of " + val + " Patients"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#container"), options);
            chart.render();


            /*Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Patient Visited'
                },
                xAxis: {
                    categories: [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Numbers of Patient'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Lahore',
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4,
                        194.1, 95.6, 54.4]

                }, {
                    name: 'Rawalpindi',
                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5,
                        106.6, 92.3]

                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 900
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom',
                                layout: 'horizontal'
                            },
                            yAxis: {
                                labels: {
                                    align: 'left',
                                    x: 0,
                                    y: -5
                                },
                                title: {
                                    text: null
                                }
                            },
                            subtitle: {
                                text: null
                            },
                            credits: {
                                enabled: false
                            }
                        }
                    }]
                }
            });*/
        }


        var colors = Highcharts.getOptions().colors,
            categories = [
                'Chrome',
                'Safari',
                'Edge',
                'Firefox',
                'Other'
            ],
            data = [
                {
                    y: 61.04,
                    color: colors[2],
                    drilldown: {
                        name: 'Chrome',
                        categories: [
                            'Chrome v97.0',
                            'Chrome v96.0',
                            'Chrome v95.0',
                            'Chrome v94.0',
                            'Chrome v93.0',
                            'Chrome v92.0',
                            'Chrome v91.0',
                            'Chrome v90.0',
                            'Chrome v89.0',
                            'Chrome v88.0',
                            'Chrome v87.0',
                            'Chrome v86.0',
                            'Chrome v85.0',
                            'Chrome v84.0',
                            'Chrome v83.0',
                            'Chrome v81.0',
                            'Chrome v89.0',
                            'Chrome v79.0',
                            'Chrome v78.0',
                            'Chrome v76.0',
                            'Chrome v75.0',
                            'Chrome v72.0',
                            'Chrome v70.0',
                            'Chrome v69.0',
                            'Chrome v56.0',
                            'Chrome v49.0'
                        ],
                        data: [
                            36.89,
                            18.16,
                            0.54,
                            0.7,
                            0.8,
                            0.41,
                            0.31,
                            0.13,
                            0.14,
                            0.1,
                            0.35,
                            0.17,
                            0.18,
                            0.17,
                            0.21,
                            0.1,
                            0.16,
                            0.43,
                            0.11,
                            0.16,
                            0.15,
                            0.14,
                            0.11,
                            0.13,
                            0.12
                        ]
                    }
                },
                {
                    y: 9.47,
                    color: colors[3],
                    drilldown: {
                        name: 'Safari',
                        categories: [
                            'Safari v15.3',
                            'Safari v15.2',
                            'Safari v15.1',
                            'Safari v15.0',
                            'Safari v14.1',
                            'Safari v14.0',
                            'Safari v13.1',
                            'Safari v13.0',
                            'Safari v12.1'
                        ],
                        data: [
                            0.1,
                            2.01,
                            2.29,
                            0.49,
                            2.48,
                            0.64,
                            1.17,
                            0.13,
                            0.16
                        ]
                    }
                },
                {
                    y: 9.32,
                    color: colors[5],
                    drilldown: {
                        name: 'Edge',
                        categories: [
                            'Edge v97',
                            'Edge v96',
                            'Edge v95'
                        ],
                        data: [
                            6.62,
                            2.55,
                            0.15
                        ]
                    }
                },
                {
                    y: 8.15,
                    color: colors[1],
                    drilldown: {
                        name: 'Firefox',
                        categories: [
                            'Firefox v96.0',
                            'Firefox v95.0',
                            'Firefox v94.0',
                            'Firefox v91.0',
                            'Firefox v78.0',
                            'Firefox v52.0'
                        ],
                        data: [
                            4.17,
                            3.33,
                            0.11,
                            0.23,
                            0.16,
                            0.15
                        ]
                    }
                },
                {
                    y: 11.02,
                    color: colors[6],
                    drilldown: {
                        name: 'Other',
                        categories: [
                            'Other'
                        ],
                        data: [
                            11.02
                        ]
                    }
                }
            ],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;
        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    color: Highcharts.color(data[i].color).brighten(brightness).get()
                });
            }
        }
        // Create the chart
        Highcharts.chart('container_pie', {
            chart: {
                type: 'pie',
                width: 600
            },
            title: {
                text: 'Browser market share, January, 2022'
            },
            subtitle: {
                text: 'Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
                valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: 'Versions',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function () {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                            this.y + '%' : null;
                    }
                },
                id: 'versions'
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{}, {
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }
        });


        function top5_u5() {
            var options = {
                series: [{
                    data: [400, 430, 448, 470, 540]
                }],
                chart: {
                    type: 'bar',
                    height: 200
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy'],
                }
            };

            var chart = new ApexCharts(document.querySelector("#container_top5_u5"), options);
            chart.render();
        }
        function top5_wra() {
            var options = {
                series: [{
                    data: [400, 430, 448, 470, 540]
                }],
                chart: {
                    type: 'bar',
                    height: 200
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy'],
                }
            };

            var chart = new ApexCharts(document.querySelector("#container_top5_wra"), options);
            chart.render();
        }
    </script>
@endsection
