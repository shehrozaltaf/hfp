@extends('layouts.simple.master')
@section('title',  trans('lang.GroupSetting_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.GroupSetting_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.GroupSetting_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header project-list">
                        <h5>{{ trans('lang.GroupSetting_dt_heading') }}</h5>
                        <span>{{ trans('lang.GroupSetting_dt_paragraph') }}</span>
                    </div>
                    <input type="hidden" id="idGroup" name="idGroup"
                           value="{{ request()->id }}">
                    <div class="card-body cardHtml">

                    </div>
                </div>
            </div>
            <!-- Ajax data source array end-->
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            getFormGroupData();
        });

        function getFormGroupData() {
            var data = {};
            data['idGroup'] = $('#idGroup').val();
            CallAjax("{{route('getFormGroupData')}}", data, "GET", function (Result) {
                var a = JSON.parse(Result);
                var items = "";
                $('.cardHtml').html('');
                if (a != null) {
                    items += "<div class='table-responsive'>";
                    items += "<table class='table table-striped table-bordered '>";
                    items += "<tr>";
                    items += "<td></td>";
                    items += "<td></td>";
                    items += "<td></td>";
                    items += "<td></td>";
                    items += "<td><h4>Check All</h4></td>";
                    items += '<td><input type="checkbox"  name="CheckAll" value="Check All"  ' +
                        'id="CheckAll"   onchange="CheckAll(this)" /></td>';
                    items += "</tr>";
                    items += "<tr>";
                    items += "<th> Form Name </th>";
                    items += "<th> Can View All Detail </th>";
                    items += "<th> Can View </th>";
                    items += "<th> Can Add </th>";
                    items += "<th> Can Edit </th>";
                    items += "<th> Can Delete </th>";
                    items += "</tr>";
                    if (a.length > 0) {
                        try {
                            $.each(a, function (i, val) {
                                items += "<tr class='fgtr'>";
                                items += "<td>" + val.pageName + "</td>";
                                items += "<td>";
                                if (val.CanViewAllDetail == 1) {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanViewAllDetail" value="' + val.CanViewAllDetail + '"  ' +
                                        'id="CanViewAllDetail' + i + '"   checked/>';
                                } else {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanViewAllDetail" value="' + val.CanViewAllDetail + '"  ' +
                                        'id="CanViewAllDetail' + i + '"  />';
                                }
                                items += "</td>";
                                items += "<td>";
                                if (val.CanView == 1) {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanView" value="' + val.CanView + '"  ' +
                                        'id="CanView' + i + '"   checked/>';
                                } else {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanView" value="' + val.CanView + '"  ' +
                                        'id="CanView' + i + '"  />';
                                }
                                items += "</td>";

                                items += "<td>";
                                if (val.CanAdd == 1) {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanAdd" value="' + val.CanAdd + '"  ' +
                                        'id="CanAdd' + i + '"   checked/>';
                                } else {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanAdd" value="' + val.CanAdd + '"  ' +
                                        'id="CanAdd' + i + '"  />';
                                }
                                items += "</td>";

                                items += "<td>";
                                if (val.CanEdit == 1) {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanEdit" value="' + val.CanEdit + '"  ' +
                                        'id="CanEdit' + i + '"   checked/>';
                                } else {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanEdit" value="' + val.CanEdit + '"  ' +
                                        'id="CanEdit' + i + '"  />';
                                }
                                items += "</td>";

                                items += "<td>";
                                if (val.CanDelete == 1) {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanDelete" value="' + val.CanDelete + '"  ' +
                                        'id="CanDelete' + i + '"   checked/>';
                                } else {
                                    items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanDelete" value="' + val.CanDelete + '"  ' +
                                        'id="CanDelete' + i + '"    />';
                                }

                                items += "</td>";
                                items += "</tr>";
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                    items += "</table></div>";
                    items += "<input type='button' value='Send All' id='btn-Edit' onclick='SaveChanges()' class='btn bg-secondary white addbtn'/>";
                    $('.cardHtml').html(items);
                } else {

                }
            });
        }

        function CheckAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }



        function SaveChanges() {
            $('#btn-Edit').css('display', 'none');
            var tr;
            var arr = {};
            tr = $('.fgtr');
            var count = $(tr).find('input');
            for (i = 0; i < count.length; i++) {
                var data = {};
                data["idPageGroup"] = $(count[i]).attr('data-idPageGroup');
                console.log('asdas  d   ', $(count[i]).attr('data-idPageGroup'));
                data[$(count[i]).attr('name')] = ($(count[i]).is(':checked')) ? true : false;
                arr[i] = data;
            }
            var url = "{{route('fgAdd')}}";
            CallAjax(url, arr, "POST", function (data) {
                if (data) {
                    toastMsg('Success', 'Successfully Changed', 'success');
                    setTimeout(function () {
                        $('#btn-Edit').css('display', 'block');
                        // window.location.reload();
                    }, 2000);
                } else {
                    toastMsg('Error', 'Something went wrong', 'danger');
                }
            });
        }
    </script>
@endsection
