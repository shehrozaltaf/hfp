@extends('layouts.simple.master')
@section('title',  trans('lang.dashboard_users_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.dashboard_users_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.dashboard_users_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header project-list">
                        <h5>{{ trans('lang.dashboard_users_dt_heading') }}</h5>
                        <span>{{ trans('lang.dashboard_users_dt_paragraph') }}</span>
                        <?php if (isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1) { ?>
                        <span><a class="btn btn-primary addbtn" href="javascript:void(0)"
                                 data-uk-modal="{target:'#addModal'}" id="add"> <i data-feather="plus-square"> </i>Create New User</a></span>
                        <?php }?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive2">
                            <table class="display datatables" id="datatable_custom">

                                <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Full Name</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Contract</th>
                                    <th>District</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp
                                @foreach ($data['data'] as $keys=>$value)
                                    <tr data-id="{{ $value->id }}">
                                        <td>{{$sno++}}</td>
                                        <td>{{(isset($value->name) && $value->name!=''?$value->name:'')}}</td>
                                        <td>{{(isset($value->username) && $value->username!=''?$value->username:'')}}</td>
                                        <td>{{(isset($value->email) && $value->email!=''?$value->email:'')}}</td>
                                        <td>{{(isset($value->designation) && $value->designation!=''?$value->designation:'')}}</td>
                                        <td>{{(isset($value->contact) && $value->contact!=''?$value->contact:'')}}</td>
                                        <td>{{(isset($value->district) && $value->district!=''?wordwrap($value->district,15,"<br>\n"):'')}}</td>
                                        <td>{{(isset($value->groupName) && $value->groupName!=''?$value->groupName:'')}}</td>
                                        <td data-id="<?php echo $value->id ?>"
                                            data-fullname="<?php echo $value->name ?>"
                                            data-username="<?php echo $value->username ?>">
                                            <?php if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                                            <a href="{{url('settings/Dashboard_Users/user_log_reports?u='.$value->id)}}" target="_blank">
                                                <i data-feather="eye" class="txt-primary"></i>
                                            </a>
                                            <?php }
                                            if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                                            <a href="javascript:void(0)" title="Reset Password"
                                               onclick="getResetPwd(this)">
                                                <i data-feather="settings" class="txt-info"></i>
                                            </a>
                                            <?php }
                                            if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                                            <a href="javascript:void(0)" data-original-title="Edit"
                                               title="Edit"
                                               onclick="getEdit(this)">
                                                <i data-feather="edit" class="txt-secondary"></i>
                                            </a>
                                            <?php }
                                            if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                                            <a href="javascript:void(0)" data-original-title="Delete"
                                               title="Delete"
                                               onclick="getDelete(this)">
                                                <i data-feather="trash-2" class="txt-danger"></i>
                                            </a>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sno</th>
                                    <th>Full Name</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Contract</th>
                                    <th>District</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php if (isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1) { ?>
                    <!-- Add Modal-->
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
                                        <h4 class="modal-title white" id="myModalLabel_add">Add Dashboard User</h4>
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="fullName">Full Name: </label>
                                            <input type="text" class="form-control fullName"
                                                   id="fullName" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="userName">User Name: </label>
                                            <input type="email" class="form-control userName" minlength="8"
                                                   id="userName" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="userEmail">Email: </label>
                                            <input type="email" class="form-control userEmail"
                                                   autocomplete="user_userEmail" id="userEmail" required>
                                        </div>
                                        <div class="mb-1 form-group userPasswordDiv">
                                            <label class="col-form-label" for="userPassword">Password</label>
                                            <input class="form-control" id="userPassword" type="text"
                                                   name="userPassword"
                                                   required minlength="8"
                                                   placeholder="*********" autocomplete="current-userPassword">


                                            <div class="mb-3 mt-1 small ">
                                                <p class="m-0 mytext-sm">Password must contain:</p>
                                                <ul class=" list-group">
                                                    <li class="list-group-item p-1"><p id="letter"
                                                                                       class="letter invalid mytext-sm">
                                                            A <b>lowercase</b> letter</p></li>
                                                    <li class="list-group-item p-1"><p id="capital"
                                                                                       class="capital invalid mytext-sm">
                                                            A <b>capital
                                                                (uppercase)</b> letter</p></li>
                                                    <li class="list-group-item p-1"><p id="number"
                                                                                       class="number invalid mytext-sm">
                                                            A <b>number</b></p></li>
                                                    <li class="list-group-item p-1"><p id="length"
                                                                                       class="length invalid mytext-sm">
                                                            Minimum <b>8 characters</b></p></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="district">District: </label>
                                            <select class="form-control col-sm-12   myselect2" id="district"
                                                    name="district[]" multiple="multiple">
                                                <option value="0" readonly disabled>Select District</option>
                                                @if (isset($data['districts']) && $data['districts'] != '')
                                                    @foreach ($data['districts'] as $keys=>$d)
                                                        <option
                                                            value="{{(isset($d->distcode) && $d->distcode!=''?$d->distcode:$d->distname)}}">
                                                            {{(isset($d->distname) && $d->distname!=''?$d->distname:$d->distcode)}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="designation">Designation: </label>
                                            <input type="text" class="form-control" id="designation" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label for="contactNo">Contact No: </label>
                                            <input type="text" class="form-control" id="contactNo" required
                                                   autocomplete="user_contactNo">
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label for="userGroup">User Group: </label>
                                            <select class="form-control" id="userGroup" required>
                                                <option value="0">Select Group</option>
                                                @if (isset($data['groups']) && $data['groups'] != '')
                                                    @foreach ($data['groups'] as $keys=>$g)
                                                        <option
                                                            value="{{(isset($g->idGroup) && $g->idGroup!=''?$g->idGroup:$g->groupName)}}">
                                                            {{(isset($g->groupName) && $g->groupName!=''?$g->groupName:$g->idGroup)}}
                                                        </option>
                                                    @endforeach
                                                @endif
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
                    <?php } ?>
                    <?php if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                    <!-- Edit Modal-->
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
                                        <h4 class="modal-title white" id="myModalLabel">Edit User</h4>
                                        <input type="hidden" id="hiddenEditId" name="hiddenEditId" value="">
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_fullName">Full Name: </label>
                                            <input type="text" class="form-control edit_fullName"
                                                   id="edit_fullName" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_userName">User Name: </label>
                                            <input type="email" class="form-control edit_userName" minlength="8"
                                                   id="edit_userName" readonly disabled required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_userEmail">Email: </label>
                                            <input type="text" class="form-control edit_userEmail"
                                                   autocomplete="user_userEmail" readonly disabled id="edit_userEmail"
                                                   required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_district">District: </label>
                                            <select class="form-control col-sm-12 edit_district_myselect2"
                                                    id="edit_district"
                                                    name="edit_district[]" multiple="multiple">
                                                <option value="0">All Districts</option>
                                                @if (isset($data['districts']) && $data['districts'] != '')
                                                    @foreach ($data['districts'] as $keys=>$d)
                                                        <option
                                                            value="{{(isset($d->distcode) && $d->distcode!=''?$d->distcode:$d->distname)}}">
                                                            {{(isset($d->distname) && $d->distname!=''?$d->distname:$d->distcode)}}
                                                        </option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_designation">Designation: </label>
                                            <input type="text" class="form-control" id="edit_designation" required>
                                        </div>
                                        <div class="edit_form-group">
                                            <label for="edit_contactNo">Contact No: </label>
                                            <input type="text" class="form-control" id="edit_contactNo" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_userGroup">User Group: </label>
                                            <select class="form-control" id="edit_userGroup" required>
                                                <option value="0">Select Group</option>
                                                @if (isset($data['groups']) && $data['groups'] != '')
                                                    @foreach ($data['groups'] as $keys=>$g)
                                                        <option
                                                            value="{{(isset($g->idGroup) && $g->idGroup!=''?$g->idGroup:$g->groupName)}}">
                                                            {{(isset($g->groupName) && $g->groupName!=''?$g->groupName:$g->idGroup)}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary mybtn" onclick="editData()">Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($data['permission'][0]->CanDelete) && $data['permission'][0]->CanDelete == 1) { ?>
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
                                        <h4 class="modal-title white" id="myModalLabel_delete">Delete User</h4>
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
                        <?php } ?>

                        <?php if (isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1) { ?>
                        <div class="modal fade text-left" id="editPwdModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel_editPwd"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary white">
                                        <h4 class="modal-title white" id="myModalLabel_editPwd">Reset Password</h4>
                                        <input type="hidden" id="editPwd_idUser" name="editPwd_idUser">
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="edit_fullNamePwd">Full Name: </label>
                                            <input type="text" class="form-control edit_fullNamePwd"
                                                   id="edit_fullNamePwd" required readonly disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_userNamePwd">User: </label>
                                            <input type="text" class="form-control edit_userNamePwd"
                                                   id="edit_userNamePwd" readonly
                                                   disabled>
                                        </div>

                                        <div class="mb-2 form-group userPasswordDiv">
                                            <label class="col-form-label" for="edit_userPassword">Password</label>
                                            <input class="form-control" id="edit_userPassword" type="text"
                                                   name="edit_userPassword"
                                                   required="" minlength="8"
                                                   placeholder="*********" autocomplete="current-userPassword">
                                            <div class="mb-3 mt-1 small ">
                                                <p class="m-0 mytext-sm">Password must contain:</p>
                                                <ul class=" list-group">
                                                    <li class="list-group-item p-1"><p id="letter"
                                                                                       class="letter invalid mytext-sm">
                                                            A <b>lowercase</b> letter</p></li>
                                                    <li class="list-group-item p-1"><p id="capital"
                                                                                       class="capital invalid mytext-sm">
                                                            A <b>capital
                                                                (uppercase)</b> letter</p></li>
                                                    <li class="list-group-item p-1"><p id="number"
                                                                                       class="number invalid mytext-sm">
                                                            A <b>number</b></p></li>
                                                    <li class="list-group-item p-1"><p id="length"
                                                                                       class="length invalid mytext-sm">
                                                            Minimum <b>8 characters</b></p></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mb-2 form-group">
                                            <label for="edit_userPasswordConfirm">Confrim Password: </label>
                                            <div class="position-relative  ">
                                                <input type="text"
                                                       class="form-control edit_userPasswordConfirm myPwdInput"
                                                       autocomplete="edit_userPasswordConfirm_off"
                                                       id="edit_userPasswordConfirm">
                                                <div class="form-control-position toggle-password">
                                                    <i class="ft-eye-off pwdIcon"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="resetPwd()">Reset Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
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
            validateNum('contactNo');

            validatePwd('userPassword');
            validatePwd('edit_userPassword');
            validatePwd('edit_userPasswordConfirm');

            $('.myselect2').select2({
                dropdownParent: $('#addModal')
            });
            $('.edit_district_myselect2').select2({
                dropdownParent: $('#editModal')
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

        function getResetPwd(obj) {
            var data = {};
            data['id'] = $(obj).parent('td').attr('data-id');
            data['fullname'] = $(obj).parent('td').attr('data-fullname');
            data['username'] = $(obj).parent('td').attr('data-username');
            if (data['id'] != '' && data['id'] != undefined) {
                $('#editPwd_idUser').val(data['id']);
                $('#edit_fullNamePwd').val(data['fullname']);
                $('#edit_userNamePwd').val(data['username']);
                $('#editPwdModal').modal('show');
            } else {
                toastMsg('User', 'Invalid User', 'error');
            }
        }

        function resetPwd() {
            $('#edit_userNamePwd').css('border', '1px solid #babfc7');
            $('#edit_fullNamePwd').css('border', '1px solid #babfc7');
            $('#edit_userPassword').css('border', '1px solid #babfc7');
            $('#edit_userPasswordConfirm').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['idUser'] = $('#editPwd_idUser').val();
            data['fullName'] = $('#edit_fullNamePwd').val();
            data['userName'] = $('#edit_userNamePwd').val();
            data['userPassword'] = $('#edit_userPassword').val();
            data['userPasswordConfirm'] = $('#edit_userPasswordConfirm').val();

            if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'].length < 1) {
                flag = 1;
                ('#edit_userNamePwd').css('border', '1px solid red');
                toastMsg('User', 'Invalid User', 'error');
                return false;
            }
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#edit_fullName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'error');
                return false;
            }
            if (data['userPassword'].length < 8) {
                $('#edit_userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password must be 8 characters long', 'danger');
                return false;
            }
            if (data['userPassword'] == '' || data['userPassword'] == undefined || data['userPassword'].length < 8) {
                $('#edit_userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Invalid Password', 'danger');
                return false;
            }
            if (validatePwdInp('edit_userPassword') == 1) {
                $('#edit_userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password format Issue', 'danger');
                return false;
            }
            if (data['userPasswordConfirm'] == '' || data['userPasswordConfirm'] == undefined || data['userPasswordConfirm'] != data['userPassword']) {
                $('#edit_userPasswordConfirm').css('border', '1px solid red');
                flag = 1;
                toastMsg('Confirm Password', 'Invalid Confirm Password', 'danger');
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ route('resetPwd') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('editPwdModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }

                    /*if (res == 1) {
                        $('#editPwdModal').modal('hide');
                        toastMsg('User', 'Password successfully reset', 'success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else if (res == 4) {
                        toastMsg('Password', 'Invalid Password', 'error');
                    } else if (res == 5) {
                        toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
                    } else if (res == 6) {
                        toastMsg('Confirm Password', 'Confirm Password is not matching with Password', 'error');
                    } else if (res == 2) {
                        toastMsg('User', 'Something went wrong', 'error');
                    } else if (res == 3) {
                        toastMsg('User', 'Invalid User', 'error');
                    }*/
                });
            }
        }

        function addData() {
            $('#fullName').css('border', '1px solid #babfc7');
            $('#userName').css('border', '1px solid #babfc7');
            $('#userEmail').css('border', '1px solid #babfc7');
            $('#userPassword').css('border', '1px solid #babfc7');
            $('#userGroup').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['fullName'] = $('#fullName').val();
            data['userName'] = $('#userName').val();
            data['userEmail'] = $('#userEmail').val();
            data['userPassword'] = $('#userPassword').val();
            data['district'] = $('#district').val();
            data['designation'] = $('#designation').val();
            data['contactNo'] = $('#contactNo').val();
            data['userGroup'] = $('#userGroup').val();
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#fullName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'danger');
                return false;
            }
            if (data['userName'].length < 8) {
                $('#userName').css('border', '1px solid red');
                flag = 1;
                toastMsg('User Name', 'Username must be 8 characters long', 'danger');
                return false;
            }
            if (data['userName'] == '' || data['userName'] == undefined || data['userName'].length < 8) {
                $('#userName').css('border', '1px solid red');
                flag = 1;
                toastMsg('User Name', 'Invalid User Name', 'danger');
                return false;
            }
            if (data['userEmail'] == '' || data['userEmail'] == undefined) {
                $('#userEmail').css('border', '1px solid red');
                flag = 1;
                toastMsg('Email', 'Invalid Email', 'danger');
                return false;
            }
            if (validateEmail(data['userEmail']) == false) {
                $('#userEmail').css('border', '1px solid red');
                flag = 1;
                toastMsg('Email', 'Invalid Email format', 'danger');
                return false;
            }
            if (data['userPassword'].length < 8) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password must be 8 characters long', 'danger');
                return false;
            }
            if (data['userPassword'] == '' || data['userPassword'] == undefined || data['userPassword'].length < 8) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Invalid Password', 'danger');
                return false;
            }
            if (validatePwdInp('userPassword') == 1) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password format Issue', 'danger');
                return false;
            }

            if (data['userGroup'] == '' || data['userGroup'] == undefined || data['userGroup'] == 0 || data['userGroup'] == '0') {
                $('#userGroup').css('border', '1px solid red');
                flag = 1;
                toastMsg('Group', 'Invalid Group', 'danger');
                return false;
            }
            if (flag == 0) {
                showloader();
                CallAjax('{{ route('addDashboardUsers') }}', data, 'POST', function (result) {
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
                CallAjax('{{ route('getDashboardUsersData') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#edit_fullName').val(a[0]['name']);
                            $('#edit_userName').val(a[0]['username']);
                            $('#edit_userEmail').val(a[0]['email']);
                            $('#edit_district').val(a[0]['district']).select2({'val': a[0]['district']});
                            $('#edit_designation').val(a[0]['designation']);
                            $('#edit_contactNo').val(a[0]['contact']);
                            $('#edit_userGroup').val(a[0]['idGroup']);
                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            $('#edit_fullName').css('border', '1px solid #babfc7');
            $('#edit_userName').css('border', '1px solid #babfc7');
            $('#edit_userEmail').css('border', '1px solid #babfc7');
            $('#edit_userGroup').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['fullName'] = $('#edit_fullName').val();
            data['userName'] = $('#edit_userName').val();
            data['userEmail'] = $('#edit_userEmail').val();
            data['district'] = $('#edit_district').val();
            data['designation'] = $('#edit_designation').val();
            data['contactNo'] = $('#edit_contactNo').val();
            data['userGroup'] = $('#edit_userGroup').val();
            if (data['id'] == '' || data['id'] == undefined) {
                $('#hiddenEditId').css('border', '1px solid red');
                flag = 1;
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            }
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#edit_fullName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'error');
                return false;
            }

            if (data['userGroup'] == '' || data['userGroup'] == undefined) {
                $('#edit_userGroup').css('border', '1px solid red');
                flag = 1;
                toastMsg('Group', 'Invalid Group', 'error');
                return false;
            }

            if (flag === 0) {
                showloader();
                CallAjax('{{ route('editDashboardUsers') }}', data, 'POST', function (result) {
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
                $('#hiddenEditId').css('border', '1px solid red');
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            } else {
                showloader();
                CallAjax('{{ route('deleteDashboardUsers') }}', data, 'POST', function (result) {
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
