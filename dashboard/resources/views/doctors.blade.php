@extends('layouts.simple.master')
@section('title',  trans('lang.doctors_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.doctors_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.doctors_main_heading') }}</li>
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

                        <div class="card-header project-list">
                            <h5>{{ trans('lang.doctors_dt_heading') }}</h5>
                            <span>{{ trans('lang.doctors_dt_paragraph') }}</span>
                            @if(isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1)
                                <span><a class="btn btn-primary addbtn" href="javascript:void(0)"
                                         data-uk-modal="{target:'#addModal'}" id="add"> <i data-feather="plus-square"> </i>Create New Doctor</a></span>
                            @endif

                        </div>
                        <div class="card-body">
                            <div class="table-responsive2">
                                <table class="display datatables" id="datatable_custom">
                                    <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>District</th>
                                        <th>UC</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($data['getData']) && $data['getData']!='')
                                        @php $s=1; @endphp
                                        @foreach($data['getData'] as $k=>$v)
                                            <tr class="red" data-id="{{ $v->idDoctor }}" >
                                                <td class="p-1">{{$s++}}</td>
                                                <td class="p-1">{{$v->staff_name}}</td>
                                                <td class="p-1">{{$v->staff_type}}</td>
                                                <td class="p-1">{{$v->distname}}</td>
                                                <td class="p-1">{{$v->ucname}}</td>
                                                <td data-id="{{ $v->idDoctor }}" >
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
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Doctor</th>
                                        <th>Type</th>
                                        <th>District</th>
                                        <th>UC</th>
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
                                                <h4 class="modal-title white" id="myModalLabel_add">Add Doctor</h4>
                                                <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body  ">
                                                <div class="mb-1 form-group">
                                                    <label class="col-form-label" for="province">Province: </label>
                                                    <select class="form-control col-sm-12" id="province" required
                                                            onchange="changeProvince('province','district')">
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
                                                    <label class="col-form-label" for="staff_name">Doctor
                                                        Name: </label>
                                                    <input type="text" class="form-control staff_name"
                                                           id="staff_name" required>
                                                </div>
                                                <div class="mb-1 form-group">
                                                    <label class="col-form-label" for="staff_type">Staff Type: </label>
                                                    <select class="form-control col-sm-12" id="staff_type" required>
                                                        <option value="0">Select Type</option>
                                                        <option value="Medical Officer">Medical Officer</option>
                                                        <option value="Woman Medical Officer">Woman Medical Officer</option>
                                                    </select>
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
                                                    Doctor</h4>
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
                                                    <label class="col-form-label" for="staff_name_edit">Doctor
                                                        Name: </label>
                                                    <input type="text" class="form-control staff_name_edit"
                                                           id="staff_name_edit" required>
                                                </div>

                                                <div class="mb-1 form-group">
                                                    <label class="col-form-label" for="staff_type_edit">Staff Type: </label>
                                                    <select class="form-control col-sm-12" id="staff_type_edit" required>
                                                        <option value="0">Select Type</option>
                                                        <option value="Medical Officer">Medical Officer</option>
                                                        <option value="Woman Medical Officer">Woman Medical Officer</option>
                                                    </select>
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
                                                    Doctor</h4>
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
            changeProvince('province_filter','district_filter');


            $('.myselect2').select2({
                dropdownParent: $('#addModal')
            });
            $('.addbtn').click(function () {
                $('#addModal').modal('show');
            });
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

        function addData() {
            $('#distcode').css('border', '1px solid #babfc7');
            $('#uc').css('border', '1px solid #babfc7');
            $('#staff_name').css('border', '1px solid #babfc7');
            $('#staff_type').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['distcode'] = $('#district').val();
            data['uc'] = $('#uc').val();
            data['staff_name'] = $('#staff_name').val();
            data['staff_type'] = $('#staff_type').val();
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
            if (data['staff_name'] == '' || data['staff_name'] == undefined || data['staff_name'] == 0) {
                $('#hf_name').css('border', '1px solid red');
                flag = 1;
                toastMsg('Doctor Name', 'Invalid Doctor Name', 'danger');
                return false;
            }
            if (data['staff_type'] == '' || data['staff_type'] == undefined || data['staff_type'] == 0) {
                $('#staff_type').css('border', '1px solid red');
                flag = 1;
                toastMsg('Staff Type', 'Invalid Staff Type', 'danger');
                return false;
            }
            if (flag == 0) {
                showloader();
                CallAjax('{{ url('/Doctors/addDoctor') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('addModal');
                                setTimeout(function () {
                                    // window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            } else {
                toastMsg('Error', 'Something went wrong', 'danger');
            }
        }

        function getEdit(obj) {
            var data = {};
            data['id'] = $(obj).parents('tr').attr('data-id');
            if (data['id'] != '' && data['id'] != undefined) {
                CallAjax('{{ url('/Doctors/detail/') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#province_edit').val(a[0]['provcode']);
                            changeProvince('province_edit','district_edit');
                            setTimeout(function (){
                                $('#district_edit').val(a[0]['dist_id']);
                                changeDistrict('district_edit','uc_edit');
                                setTimeout(function () {
                                    $('#uc_edit').val(a[0]['ucCode']);
                                },1000)
                            },1000);

                            $('#staff_name_edit').val(a[0]['staff_name']);
                            $('#staff_type_edit').val(a[0]['staff_type']);
                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['distcode'] = $('#district_edit').val();
            data['uc'] = $('#uc_edit').val();
            data['staff_name'] = $('#staff_name_edit').val();
            data['staff_type'] = $('#staff_type_edit').val();
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
            if (data['staff_name'] == '' || data['staff_name'] == undefined || data['staff_name'] == 0) {
                $('#hf_name').css('border', '1px solid red');
                flag = 1;
                toastMsg('Doctor Name', 'Invalid Doctor Name', 'danger');
                return false;
            }

            if (data['staff_type'] == '' || data['staff_type'] == undefined || data['staff_type'] == 0) {
                $('#staff_type').css('border', '1px solid red');
                flag = 1;
                toastMsg('Staff Type', 'Invalid Staff Type', 'danger');
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ url('/Doctors/editDoctor') }}', data, 'POST', function (result) {
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
                toastMsg('Error', 'Something went wrong', 'danger');
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
                CallAjax('{{ url('/Doctors/deleteDoctor') }}', data, 'POST', function (result) {
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

        function searchData() {
            var data = {};
            data['province'] = $('#province_filter').val();
            data['district'] = $('#district_filter').val();
            data['uc'] = $('#uc_filter').val();
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
            window.location.href = pathname;
        }
    </script>
@endsection
