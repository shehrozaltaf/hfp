@extends('layouts.simple.master')
@section('title',  trans('lang.health_facility_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.health_facility_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.health_facility_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header project-list">
                        <h5>{{ trans('lang.health_facility_dt_heading') }}</h5>
                        <span>{{ trans('lang.health_facility_dt_paragraph') }}</span>
                        @if(isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1)
                            <span><a class="btn btn-primary addbtn" href="javascript:void(0)"
                                     data-uk-modal="{target:'#addModal'}" id="add"> <i data-feather="plus-square"> </i>Create New Health_facility</a></span>
                        @endif

                    </div>
                    <div class="card-body">
                        <div class="table-responsive2">
                            <table class="display datatables" id="datatable_custom">

                                <thead>
                                <tr>
                                    <th width="5%">SNo</th>
                                    <th width="15%">Health Facility Code</th>
                                    <th width="20%">Health Facility Name</th>
                                    <th width="15%">UC</th>
                                    <th width="15%">District</th>
                                    <th width="15%">Province</th>
                                    <th width="15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp
                                @foreach ($data['data'] as $keys=>$value)
                                    <tr data-id="{{ $value->id }}">
                                        <td>{{$sno++}}</td>
                                        <td>{{(isset($value->hf_code) && $value->hf_code!=''?$value->hf_code:'')}}</td>
                                        <td>{{(isset($value->hf_name) && $value->hf_name!=''?$value->hf_name:'')}}</td>
                                        <td>{{(isset($value->ucname) && $value->ucname!=''?$value->ucname:'')}}</td>
                                        <td>{{(isset($value->distname) && $value->distname!=''?$value->distname:'')}}</td>
                                        <td>{{(isset($value->provname) && $value->provname!=''?$value->provname:'')}}</td>

                                        <td data-id="{{ $value->id }}"
                                            data-hf_code="{{ $value->hf_code }}"
                                            data-hf_name="{{ $value->hf_name }}">
                                            @if(isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1)
                                                <a href="javascript:void(0)" data-original-title="Edit"
                                                   title="Edit"
                                                   onclick="getEdit(this)">
                                                    <i data-feather="edit" class="txt-secondary"></i>
                                                </a>
                                            @endif @if(isset($data['permission'][0]->CanDelete) && $data['permission'][0]->CanDelete == 1)
                                                <a href="javascript:void(0)" data-original-title="Delete"
                                                   title="Delete"
                                                   onclick="getDelete(this)">
                                                    <i data-feather="trash-2" class="txt-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SNo</th>
                                    <th>Health Facility Code</th>
                                    <th>Health Facility Name</th>
                                    <th>UC</th>
                                    <th>District</th>
                                    <th>Province</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Add Modal-->
                        @if(isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1)
                            <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel_add"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="loader-box hide loader">
                                            <div class="loader-1 myloader"></div>
                                            <div class="myloader"> Loading..</div>
                                        </div>
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title white" id="myModalLabel_add">Add Health Facility</h4>
                                            <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="province">Province: </label>
                                                <select class="form-control col-sm-12" id="province" required
                                                        onchange="changeProvince('province','district')">
                                                    <option value="2" selected>Punjab</option>
                                                </select>
                                            </div>

                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="district">District: </label>
                                                <select class="form-control col-sm-12" id="district" required
                                                        onchange="changeDistrict('district','uc')">
                                                    <option value="0" data-district="0">Select District</option>
                                                </select>
                                            </div>

                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="uc">UC: </label>
                                                <select class="form-control col-sm-12" id="uc" required>
                                                    <option value="0" data-uc="0">Select UC</option>
                                                </select>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="hf_name">Health Facility
                                                    Name: </label>
                                                <input type="text" class="form-control hf_name"
                                                       id="hf_name" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-primary mybtn" onclick="addData()">Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <!-- Edit Modal-->
                        @if(isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1)
                            <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel_edit"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="loader-box hide loader">
                                            <div class="loader-1 myloader"></div>
                                            <div class="myloader"> Loading..</div>
                                        </div>
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title white" id="myModalLabel_edit">Edit
                                                Health_facility</h4>
                                            <input type="hidden" id="hiddenEditId" name="hiddenEditId" value="">
                                            <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="province_edit">Province: </label>
                                                <select class="form-control col-sm-12" id="province_edit" required
                                                onchange="changeProvince('province_edit','district_edit')">
                                                    <option value="0">Select Province</option>
                                                    @if (isset($data['province']) && $data['province'] != '')
                                                        @foreach ($data['province'] as $keys=>$d)
                                                            <option
                                                                value="{{(isset($d->provcode) && $d->provcode!=''?$d->provcode:'')}}"
                                                                data-provname="{{(isset($d->provname) && $d->provname!=''?$d->provname:'')}}"
                                                            >
                                                                {{(isset($d->provname) && $d->provname!=''?$d->provname:'')}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="district_edit">District: </label>
                                                <select class="form-control col-sm-12" id="district_edit" required
                                                onchange="changeDistrict('district_edit','uc_edit')">
                                                    <option value="0" data-district="0">Select District</option>
                                                </select>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="uc_edit">UC: </label>
                                                <select class="form-control col-sm-12" id="uc_edit" required>
                                                    <option value="0" data-uc="0">Select UC</option>
                                                </select>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="hf_name_edit">Health_facility
                                                    Name: </label>
                                                <input type="text" class="form-control hf_name_edit"
                                                       id="hf_name_edit" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-primary mybtn" onclick="editData()">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Delete Modal-->
                        @if(isset($data['permission'][0]->CanDelete) && $data['permission'][0]->CanDelete == 1)
                            <!-- Delete Modal-->
                            <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel_delete"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="loader-box hide loader">
                                            <div class="loader-1 myloader"></div>
                                            <div class="myloader"> Loading..</div>
                                        </div>
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title white" id="myModalLabel_delete">Delete
                                                Health_facility</h4>
                                            <input type="hidden" id="hiddenDeleteId" name="hiddenDeleteId" value="">
                                            <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="px-3">
                                                <p>Are you sure, you want to delete it?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-primary mybtn" onclick="deleteData()">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
            $('.myselect2').select2({
                dropdownParent: $('#addModal')
            });
            $('.addbtn').click(function () {
                $('#addModal').modal('show');
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
        });

        function changeProvince(pro, dist) {
            var data = {};
            data['province'] = $('#' + pro).val();
            if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
                CallAjax('{{ url('/districts/changeProvince/') }}', data, 'POST', function (res) {
                    var items = '<option value="0">Select District</option>';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<option value="' + v.distcode + '"  data-district="' + v.distname + '">' + v.distname + ' (' + v.distcode + ')</option>';
                            })
                        } catch (e) {
                        }
                    }
                    $('#' + dist).html('').html(items);
                    setTimeout(function () {
                        changeDistrict('district', 'uc');
                        changeDistrict('district_edit', 'uc_edit');
                    })
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
                    var items = '<option value="0">Select UC</option>';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<option value="' + v.uccode + '"  data-uc="' + v.ucname + '">' + v.ucname + ' (' + v.uccode + ')</option>';
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

        function addData() {
            $('#distcode').css('border', '1px solid #babfc7');
            $('#uc').css('border', '1px solid #babfc7');
            $('#hf_name').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['distcode'] = $('#district').val();
            data['uc'] = $('#uc').val();
            data['hf_name'] = $('#hf_name').val();
            if (data['distcode'] == '' || data['distcode'] == undefined || data['distcode'] == 0) {
                $('#district').css('border', '1px solid red');
                flag = 1;
                toastMsg('District', 'Invalid District', 'danger');
                return false;
            }
            if (data['uc'] == '' || data['uc'] == undefined || data['uc'] == 0) {
                $('#uc').css('border', '1px solid red');
                flag = 1;
                toastMsg('UC', 'Invalid UC', 'danger');
                return false;
            }
            if (data['hf_name'] == '' || data['hf_name'] == undefined || data['hf_name'] == 0) {
                $('#hf_name').css('border', '1px solid red');
                flag = 1;
                toastMsg('Health Facility Name', 'Invalid Health Facility Name', 'danger');
                return false;
            }
            if (flag == 0) {
                showloader();
                CallAjax('{{ url('/health_facility/addHealth_facility') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('addModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            } else {
                toastMsg('User', 'Something went wrong', 'danger');
            }
        }

        function getEdit(obj) {
            var data = {};
            data['id'] = $(obj).parents('tr').attr('data-id');
            if (data['id'] != '' && data['id'] != undefined) {
                CallAjax('{{ url('/health_facility/detail/') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#province_edit').val(a[0]['provcode']);
                            changeProvince('province_edit','district_edit');
                            setTimeout(function (){
                                $('#district_edit').val(a[0]['distcode']);
                                changeDistrict('district_edit','uc_edit');
                               setTimeout(function () {
                                   $('#uc_edit').val(a[0]['uccode']);
                               },1000)
                            },1000);

                            $('#hf_name_edit').val(a[0]['hf_name']);
                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            $('#fullName_edit').css('border', '1px solid #babfc7');
            $('#userPassword_edit').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['distcode'] = $('#district_edit').val();
            data['uc'] = $('#uc_edit').val();
            data['hf_name'] = $('#hf_name_edit').val();
            if (data['id'] == '' || data['id'] == undefined) {
                $('#distname_edit').css('border', '1px solid red');
                flag = 1;
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            }

            if (data['district'] == '' || data['distcode'] == undefined || data['distcode'] == 0) {
                $('#distcode').css('border', '1px solid red');
                flag = 1;
                toastMsg('District', 'Invalid District', 'danger');
                return false;
            }
            if (data['uc'] == '' || data['uc'] == undefined || data['uc'] == 0) {
                $('#uc').css('border', '1px solid red');
                flag = 1;
                toastMsg('UC', 'Invalid UC', 'danger');
                return false;
            }
            if (data['hf_name'] == '' || data['hf_name'] == undefined || data['hf_name'] == 0) {
                $('#hf_name').css('border', '1px solid red');
                flag = 1;
                toastMsg('Health Facility Name', 'Invalid Health Facility Name', 'danger');
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ url('/health_facility/editHealth_facility') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('editModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            } else {
                toastMsg('User', 'Something went wrong', 'danger');
            }
        }

        function getDelete(obj) {
            $('#hiddenDeleteId').val($(obj).parents('tr').attr('data-id'));
            showModal('deleteModal');
        }

        function deleteData() {
            var data = {};
            data['id'] = $('#hiddenDeleteId').val();
            if (data['id'] == '' || data['id'] == undefined) {
                $('#hiddenDeleteId').css('border', '1px solid red');
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            } else {
                showloader();
                CallAjax('{{ url('/health_facility/deleteHealth_facility') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('deleteModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            }
        }
    </script>
@endsection
