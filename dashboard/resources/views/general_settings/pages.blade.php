@extends('layouts.simple.master')
@section('title',  trans('lang.pages_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.pages_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.pages_main_heading') }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header project-list">
                        <h5>{{ trans('lang.pages_dt_heading') }}</h5>
                        <span>{{ trans('lang.pages_dt_paragraph') }}</span>
                        <span><a class="btn btn-primary addbtn" href="javascript:void(0)"
                                 data-uk-modal="{target:'#addModal'}" id="add"> <i data-feather="plus-square"> </i>Create New Pages</a></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive2">
                            <table class="display datatables" id="datatable_custom">
                                <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Parent</th>
                                    <th>Icon</th>
                                    <th>Class</th>
                                    <th>Menu</th>
                                    <th>Sort No</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp
                                @foreach ($data['data'] as $keys=>$value)
                                    <tr data-id="{{ $value->idPages }}">
                                        <td>{{$sno++}}</td>
                                        <td>{{(isset($value->pageName) && $value->pageName!=''?$value->pageName:'')}}</td>
                                        <td>{{(isset($value->pageUrl) && $value->pageUrl!=''?$value->pageUrl:'')}}</td>
                                        <td>{{(isset($value->idParent) && $value->idParent!=''?$value->idParent:'')}}</td>
                                        <td>{{(isset($value->menuIcon) && $value->menuIcon!=''?$value->menuIcon:'')}}</td>
                                        <td>{{(isset($value->menuClass) && $value->menuClass!=''?$value->menuClass:'')}}</td>
                                        <td>{{(isset($value->isMenu) && $value->isMenu!=''?$value->isMenu:'')}}</td>
                                        <td>{{(isset($value->sort_no) && $value->sort_no!=''?$value->sort_no:'')}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-original-title="Edit"
                                               title="Edit"
                                               onclick="getEdit(this)">
                                                <i data-feather="edit" class="txt-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-original-title="Delete"
                                               title="Delete"
                                               onclick="getDelete(this)">
                                                <i data-feather="trash-2" class="txt-danger"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SNo</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Parent</th>
                                    <th>Icon</th>
                                    <th>Class</th>
                                    <th>Menu</th>
                                    <th>Sort No</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

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
                                        <h4 class="modal-title white" id="myModalLabel_add">Add Page</h4>
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="pageName">Page Name: </label>
                                            <input type="text" class="form-control pageName"
                                                   onkeyup="copyURL('pageName','pageUrl');"
                                                   id="pageName" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="pageUrl">Page URL: </label>
                                            <input type="text" class="form-control pageUrl"
                                                   id="pageUrl" onkeyup="validateURL('Page_url')" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="menuParent">Parent: </label>
                                            <select name="menuParent" id=menuParent" class="form-control" required>
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="idParent">id Parent: </label>
                                            <input type="text" class="form-control" id="idParent" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="menuIcon">Icon: </label>
                                            <input type="text" class="form-control" id="menuIcon" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="menuClass">Class: </label>
                                            <input type="text" class="form-control" id="menuClass" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="isMenu">Menu: </label>
                                            <select name="isMenu" id="isMenu" class="form-control" required>
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="sort_no">Sort No: </label>
                                            <input type="number" class="form-control" id="sort_no" required>
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
                                        <h4 class="modal-title white" id="myModalLabel_edit">Edit Page</h4>
                                        <input type="hidden" id="hiddenEditId" name="hiddenEditId" value="">
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_pageName">Page Name: </label>
                                            <input type="text" class="form-control edit_pageName"
                                                   onkeyup="copyURL('edit_pageName','edit_pageUrl');"
                                                   id="edit_pageName" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_pageUrl">Page URL: </label>
                                            <input type="text" class="form-control edit_pageUrl" readonly disabled
                                                   id="edit_pageUrl"  required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_menuParent">Parent: </label>
                                            <select name="edit_menuParent" id=edit_menuParent" class="form-control"
                                                    required>
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_idParent">id Parent: </label>
                                            <input type="text" class="form-control" id="edit_idParent" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_menuIcon">Icon: </label>
                                            <input type="text" class="form-control" id="edit_menuIcon" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_menuClass">Class: </label>
                                            <input type="text" class="form-control" id="edit_menuClass" required>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_isMenu">Menu: </label>
                                            <select name="edit_isMenu" id="edit_isMenu" class="form-control" required>
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_sort_no">Sort No: </label>
                                            <input type="number" class="form-control" id="edit_sort_no" required>
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
                                        <h4 class="modal-title white" id="myModalLabel_delete">Delete Page</h4>
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

        function copyURL(Projectname, Projecturl) {
            var Project_name = $('#' + Projectname).val().replace(/[_\W]+/g, "_");
            return $('#' + Projecturl).val(Project_name.toLowerCase());
        }

        function validateURL(Projecturl) {
            return $('#' + Projecturl).val($('#' + Projecturl).val().replace(/[_\W]+/g, "_"));
        }

        function addData() {
            $('#pageName').css('border', '1px solid #babfc7');
            $('#pageUrl').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['pageName'] = $('#pageName').val();
            data['pageUrl'] = $('#pageUrl').val();
            data['menuParent'] = $('#menuParent').val();
            data['idParent'] = $('#idParent').val();
            data['menuIcon'] = $('#menuIcon').val();
            data['menuClass'] = $('#menuClass').val();
            data['isMenu'] = $('#isMenu').val();
            data['sort_no'] = $('#sort_no').val();
            if (data['pageName'] == '' || data['pageName'] == undefined) {
                $('#pageName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Page Name', 'Invalid Page Name', 'danger');
                return false;
            }
            if (data['pageUrl'] == '' || data['pageUrl'] == undefined) {
                $('#pageName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Page URL', 'Invalid Page URL', 'danger');
                return false;
            }
            if (data['menuClass'] == '' || data['menuClass'] == undefined) {
                $('#menuClass').css('border', '1px solid red');
                flag = 1;
                toastMsg('Menu Class', 'Invalid Menu Class', 'danger');
                return false;
            }
            if (data['sort_no'] == '' || data['sort_no'] == undefined) {
                $('#sort_no').css('border', '1px solid red');
                flag = 1;
                toastMsg('Sort No', 'Invalid Sort No', 'danger');
                return false;
            }
            if (flag == 0) {
                showloader();
                CallAjax('{{ route('addPages') }}', data, 'POST', function (result) {
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
            }
        }

        function getEdit(obj) {
            var data = {};
            data['id'] = $(obj).parents('tr').attr('data-id');
            if (data['id'] != '' && data['id'] != undefined) {
                CallAjax('{{ route('detailPages') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#edit_pageName').val(a[0]['pageName']);
                            $('#edit_pageUrl').val(a[0]['pageUrl']);
                            $('#edit_menuParent').val(a[0]['menuParent']);
                            $('#edit_idParent').val(a[0]['idParent']);
                            $('#edit_menuIcon').val(a[0]['menuIcon']);
                            $('#edit_menuClass').val(a[0]['menuClass']);
                            $('#edit_isMenu').val(a[0]['isMenu']);
                            $('#edit_sort_no').val(a[0]['sort_no']);
                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            $('#edit_pageName').css('border', '1px solid #babfc7');
            $('#edit_pageUrl').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['pageName'] = $('#edit_pageName').val();
            data['menuParent'] = $('#edit_menuParent').val();
            data['idParent'] = $('#edit_idParent').val();
            data['menuIcon'] = $('#edit_menuIcon').val();
            data['menuClass'] = $('#edit_menuClass').val();
            data['isMenu'] = $('#edit_isMenu').val();
            data['sort_no'] = $('#edit_sort_no').val();
            if (data['id'] == '' || data['id'] == undefined || data['id'].length < 1) {
                flag = 1;
                toastMsg('Error', 'Invalid Page Id', 'danger');
                return false;
            }
            if (data['pageName'] == '' || data['pageName'] == undefined) {
                $('#edit_pageName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Page Name', 'Invalid Page Name', 'danger');
                return false;
            }
            if (data['menuClass'] == '' || data['menuClass'] == undefined) {
                $('#edit_menuClass').css('border', '1px solid red');
                flag = 1;
                toastMsg('Menu Class', 'Invalid Menu Class', 'danger');
                return false;
            }
            if (data['sort_no'] == '' || data['sort_no'] == undefined) {
                $('#edit_sort_no').css('border', '1px solid red');
                flag = 1;
                toastMsg('Sort No', 'Invalid Sort No', 'danger');
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ route('editPages') }}', data, 'POST', function (result) {
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
                toastMsg('Group', 'Something went wrong', 'danger');
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
                toastMsg('Error', 'Invalid Group Id', 'danger');
                return false;
            } else {
                showloader();
                CallAjax('{{ route('deletePages') }}', data, 'POST', function (result) {
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
