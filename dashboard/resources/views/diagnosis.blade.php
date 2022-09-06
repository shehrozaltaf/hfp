@extends('layouts.simple.master')
@section('title',  trans('lang.diagnosis_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.diagnosis_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.diagnosis_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="basic-select2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header ">
                            <h5>Filters</h5>
                        </div>
                        <div class="card-body">
                            <div class="row  mb-2">
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="province_filter" class="">Province</label>
                                        <select class="select2 form-control province_filter" id="province_filter"
                                                name="province_filter"
                                                onchange="changeProvince('province_filter','district_filter')">
                                            <option value="0" readonly >All Provinces</option>
                                            @if(isset($data['province']) && $data['province']!='')
                                                @foreach($data['province'] as $k=>$d)
                                                    <option
                                                        value="{{$d->provcode}}" {{  $data['province_slug'] == $d->provcode ? 'selected' :''}}>
                                                        {{$d->provname}} ({{$d->provcode}})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="district_filter" class="">District</label>
                                        <select class="select2 form-control district_filter" id="district_filter"
                                                name="district_filter"
                                                onchange="changeDistrict('district_filter','uc_filter')">
                                            <option value="0" readonly selected>All Districts</option>
                                            @if(isset($data['districts']) && $data['districts']!='')
                                                @foreach($data['districts'] as $k=>$d)
                                                    <option
                                                        value="{{$d->distcode}}" {{  $data['district_slug'] === $d->distcode ? 'selected' :''}}>
                                                        {{$d->distname}} ({{$d->distcode}})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="uc_filter" class="">UC</label>
                                        <select class="select2 form-control uc_filter" id="uc_filter"
                                                name="uc_filter">
                                            <option value="0" readonly selected>All UCs</option>
                                            @if(isset($data['ucs']) && $data['ucs']!='')
                                                @foreach($data['ucs'] as $k=>$d)
                                                    <option
                                                        value="{{$d->uccode}}" {{  $data['uc_slug'] === $d->uccode ? 'selected' :''}}>
                                                        {{$d->ucname}} ({{$d->uccode}})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="uc_filter" class="">Date Range</label>
                                        <div class="col-md-12">
                                            <input id="date_range_slider" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-12 mt-2">
                                    <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                        Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section>
            <div class="row">
                <!-- Ajax data source array start-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display datatables" id="datatable_custom">
                                    <thead>
                                    <tr>
                                        <th>District</th>
                                        <th>UC</th>
                                        <th>Upper Respiratory Tract Infection</th>
                                        <th>Lower Respiratory Tract Infection</th>
                                        <th>Allergic Rhinitis</th>
                                        <th>Acute Gastroenteritis</th>
                                        <th>Dysentery</th>
                                        <th>Typhoid Fever</th>
                                        <th>Cellulitis</th>
                                        <th>Ophthalmitis</th>
                                        <th>Otitis Media</th>
                                        <th>Scabies</th>
                                        <th>Anemia</th>
                                        <th>Jaundice</th>
                                        <th>Malaria</th>
                                        <th>Urinary Tract Infection</th>
                                        <th>Pyrexia of Unknown Origin</th>
                                        <th>Pre-Eclampsia</th>
                                        <th>Eclampsia</th>
                                        <th>Undernutrition</th>
                                        <th>Obesity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($data['getData']) && $data['getData']!='')
                                        @foreach($data['getData'] as $k=>$v)
                                            <tr class="red">
                                                <td class="p-1">{{$v->distname}}</td>
                                                <td class="p-1">{{$v->ucname}}</td>
                                                <td class="p-1">{{$v->upper_respiratory_tract_infection}}</td>
                                                <td class="p-1">{{$v->lower_respiratory_tract_infection}}</td>
                                                <td class="p-1">{{$v->allergic_rhinitis}}</td>
                                                <td class="p-1">{{$v->acute_gastroenteritis}}</td>
                                                <td class="p-1">{{$v->dysentery}}</td>
                                                <td class="p-1">{{$v->typhoid_fever}}</td>
                                                <td class="p-1">{{$v->cellulitis}}</td>
                                                <td class="p-1">{{$v->ophthalmitis}}</td>
                                                <td class="p-1">{{$v->otitis_media}}</td>
                                                <td class="p-1">{{$v->scabies}}</td>
                                                <td class="p-1">{{$v->anemia}}</td>
                                                <td class="p-1">{{$v->jaundice}}</td>
                                                <td class="p-1">{{$v->malaria}}</td>
                                                <td class="p-1">{{$v->urinary_tract_infection}}</td>
                                                <td class="p-1">{{$v->pyrexia_of_unknown_origin}}</td>
                                                <td class="p-1">{{$v->pre_eclampsia}}</td>
                                                <td class="p-1">{{$v->eclampsia}}</td>
                                                <td class="p-1">{{$v->undernutrition}}</td>
                                                <td class="p-1">{{$v->obesity}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>District</th>
                                        <th>UC</th>
                                        <th>Upper Respiratory Tract Infection</th>
                                        <th>Lower Respiratory Tract Infection</th>
                                        <th>Allergic Rhinitis</th>
                                        <th>Acute Gastroenteritis</th>
                                        <th>Dysentery</th>
                                        <th>Typhoid Fever</th>
                                        <th>Cellulitis</th>
                                        <th>Ophthalmitis</th>
                                        <th>Otitis Media</th>
                                        <th>Scabies</th>
                                        <th>Anemia</th>
                                        <th>Jaundice</th>
                                        <th>Malaria</th>
                                        <th>Urinary Tract Infection</th>
                                        <th>Pyrexia of Unknown Origin</th>
                                        <th>Pre-Eclampsia</th>
                                        <th>Eclampsia</th>
                                        <th>Undernutrition</th>
                                        <th>Obesity</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Ajax data source array end-->
            </div>
        </section>
    </div>

    <input type="hidden"
           value="{{ isset($data['province_slug']) && $data['province_slug'] !='' ? $data['province_slug'] :'0'}}"
           id="hidden_slug_province" name="hidden_slug_province">
    <input type="hidden"
           value="{{ isset($data['district_slug']) && $data['district_slug'] !='' ? $data['district_slug'] :'0'}}"
           id="hidden_slug_district" name="hidden_slug_district">
    <input type="hidden" value="{{ isset($data['uc_slug']) && $data['uc_slug'] !='' ? $data['uc_slug'] :'0'}}"
           id="hidden_slug_uc" name="hidden_slug_uc">

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var lang = "en-US";
            var year = 2022;
            var today = new Date();
            var dd = String(today. getDate()). padStart(2, '0');
            var mm = String(today. getMonth() + 1). padStart(2, '0'); //January is 0!
            var yyyy = today. getFullYear();
            function dateToTS (date) {
                return date.valueOf();
            }

            function tsToDate (ts) {
                var d = new Date(ts);
                return d.toLocaleDateString(lang, {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            $("#date_range_slider").ionRangeSlider({
                skin: "flat",
                type: "double",
                grid: true,
                min: dateToTS(new Date(year, 6, 1)),
                max: dateToTS(new Date(yyyy, mm-1, dd)),
                from: dateToTS(new Date(<?=$data['from_year']?>, <?=$data['from_month']-1?>, <?=$data['from_day']?>)),
                // from: dateToTS(new Date(year, 6, 1)),
                to: dateToTS(new Date(<?=$data['to_year']?>, <?=$data['to_month']-1?>, <?=$data['to_day']?>)),
                prettify: tsToDate
            });

            $('#datatable_custom').DataTable({
                "displayLength": 50,
                "oSearch": {"sSearch": " "},
                autoFill: false,
                attr: {
                    autocomplete: 'off'
                },
                initComplete: function () {
                    $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
                },
            });
            changeProvince('province_filter','district_filter')
        });

        function changeProvince(pro, dist) {
            var data = {};
            data['province'] = $('#' + pro).val();
            if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
                CallAjax('{{ url('/districts/changeProvince/') }}', data, 'POST', function (res) {
                    var slug=$('#hidden_slug_district').val();
                    var items = '<option value="0">Select District</option>';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<option value="' + v.distcode + '"  ' + (slug==v.distcode?'selected':'')+
                                    ' data-district="' + v.distname + '">' + v.distname + ' (' + v.distcode + ')</option>';
                            })
                        } catch (e) {
                        }
                    }
                    $('#' + dist).html('').html(items);
                    $('#uc_filter').val(0);
                    setTimeout(function () {
                        changeDistrict('district_filter', 'uc_filter');
                    },1000);

                });
            } else {
                $('#' + dist).html('');
            }
        }

        function changeDistrict(dist, uc) {
            var data = {};
            data['district'] = $('#' + dist).val();
            if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
                CallAjax('{{ url('/districts/changeDistrict/') }}', data, 'POST', function (res) {
                    var slug=$('#hidden_slug_uc').val();
                    var items = '<option value="0">Select UC</option>';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<option value="' + v.uccode + '" '  + (slug==v.uccode?'selected':'')+
                                    ' data-uc="' + v.ucname + '">' + v.ucname + ' (' + v.uccode + ')</option>';
                            })
                        } catch (e) {
                        }
                    }
                    $('#' + uc).html('').html(items);
                });
            } else {
                $('#' + uc).html('');
            }
        }

        function searchData() {
            var data = {};
            data['province'] = $('#province_filter').val();
            data['district'] = $('#district_filter').val();
            data['uc'] = $('#uc_filter').val();
            var slider = $("#date_range_slider").data("ionRangeSlider");
            var from = slider.result.from;
            var to = slider.result.to;
            var pathname = window.location.pathname;
            pathname += '?f=1';
            if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
                pathname += '&p=' + data['province'];
            }
            if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
                pathname += '&d=' + data['district'];
            }
            if (data['uc'] != '' && data['uc'] != undefined && data['uc'] != '0' && data['uc'] != '$1') {
                pathname += '&u=' + data['uc'];
            }
            pathname += '&from=' + new Date(from).toUTCString();
            pathname += '&to=' + new Date(to).toUTCString();
            window.location.href = pathname;
        }
    </script>
@endsection
