@extends('layouts.simple.master')
@section('title',  'Users - Log Report' )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Logs</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Users - Log Report</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="javascript:void(0)" autocomplete="off">
                                <div class="row printcontent">
                                    <div class="col-sm-12 col-md-12 col-6">
                                        <div class="form-group">
                                            <label for="idUser" class="label-control">User</label>
                                            <select name="idUser" id="idUser"
                                                    class="form-control select2 idUser">
                                                <option value="0">All Users</option>
                                                @if(isset($data['users']) && $data['users']!='')
                                                    @foreach ($data['users'] as $keys=>$u)
                                                        <option
                                                            value="{{$u->id}}" {{(isset($data['user_slug']) && $data['user_slug'] == $u->id ? 'selected' : '')}}>{{$u->name . ' ('.  $u->username .')'  }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12 mt-2">
                                        <button type="button" class="btn btn-primary mybtn" onclick="getData()">
                                            Get Report
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($data['user_slug']) && $data['user_slug'] != '' && $data['user_slug'] != '0')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        User Data
                    </div>
                    <div class="card-content">
                        <div class="card-body ">
                            <ul class="list-group ">
                                <li>User Name:
                                    <strong><?php echo(isset($data['getUserData'][0]->username) && $data['getUserData'][0]->username != '' ? $data['getUserData'][0]->username : ''); ?></strong>
                                </li>
                                <li>User Created by:
                                    <strong><?php echo(isset($data['getUserData'][0]->createdBy) && $data['getUserData'][0]->createdBy != '' ? $data['getUserData'][0]->createdBy : ''); ?></strong>
                                </li>
                                <li>User Created date:
                                    <strong><?php echo(isset($data['getUserData'][0]->created_at) && $data['getUserData'][0]->created_at != '' ? date('d-M-Y H:i:s', strtotime($data['getUserData'][0]->created_at)) : ''); ?></strong>
                                </li>
                                <li>User Roles/privileges:
                                    <strong><?php echo(isset($data['getUserData'][0]->groupName) && $data['getUserData'][0]->groupName != '' ? $data['getUserData'][0]->groupName : ''); ?></strong>
                                </li>
                                <li>User Access level:
                                    <strong><?php echo(isset($data['getUserData'][0]->groupName) && $data['getUserData'][0]->groupName != '' ? $data['getUserData'][0]->groupName : ''); ?></strong>
                                </li>
                                <li>User Access Rights Assigned by:
                                    <strong><?php echo(isset($data['getUserData'][0]->createdBy) && $data['getUserData'][0]->createdBy != '' ? $data['getUserData'][0]->createdBy : ''); ?></strong>
                                </li>
                                <li>User Modified by:
                                    <strong><?php echo(isset($data['getUserData'][0]->updateBy) && $data['getUserData'][0]->updateBy != '' ? $data['getUserData'][0]->updateBy : ''); ?></strong>
                                </li>
                                <li>User Modified date:
                                    <strong><?php echo(isset($data['getUserData'][0]->updated_at) && $data['getUserData'][0]->updated_at != '' ? date('d-M-Y H:i:s', strtotime($data['getUserData'][0]->updated_at)) : ''); ?></strong>
                                </li>
                                <li>User Revoked by:
                                    <strong><?php echo(isset($data['getUserData'][0]->deleteBy) && $data['getUserData'][0]->deleteBy != '' ? $data['getUserData'][0]->deleteBy : ''); ?></strong>
                                </li>
                                <li>User Revoked/disabled date:
                                    <strong><?php echo(isset($data['getUserData'][0]->deletedDateTime) && $data['getUserData'][0]->deletedDateTime != '' ? date('d-M-Y H:i:s', strtotime($data['getUserData'][0]->deletedDateTime)) : ''); ?></strong>
                                </li>
                                <li>User Last login date:
                                    <strong><?php echo(isset($data['getUserData'][0]->getLastLogin) && $data['getUserData'][0]->getLastLogin != '' ? date('d-M-Y H:i:s', strtotime($data['getUserData'][0]->getLastLogin)) : ''); ?></strong>
                                </li>
                                <li>User Status:
                                    <strong><?php if (isset($data['getUserData'][0]->status) && $data['getUserData'][0]->status == '1') {
                                            echo '<span class="primary">Active</span>';
                                        } else {
                                            echo '<span class="danger">Revoked</span>';
                                        } ?></strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($data['getUserLoginActivity']) && $data['getUserLoginActivity']!='')
        <div class="row">
            <!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header project-list">
                        <h5>User Login Activity</h5>
                        <span>{{ trans('lang.dashboard_users_dt_paragraph') }}</span>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive2">
                            <table class="display datatables table table-striped dataex-html5-selectors-login"
                                   id="datatable_custom">
                                <thead>
                                <tr>
                                    <th>SNO</th>
                                    <th>Result</th>
                                    <th>User</th>
                                    <th>Date Time</th>
                                    <th>IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp

                                    @foreach ($data['getUserLoginActivity'] as $keys=>$value)
                                        <tr data-id="{{ $value->id }}">
                                            <td>{{$sno++}}</td>
                                            <td>{{(isset($value->result) && $value->result!=''?wordwrap($value->result, 80, "<br>\n") :'')}}</td>
                                            <td>{{(isset($value->name) && $value->name!=''?$value->name:'')}}</td>
                                            <td>{{(isset($value->attempted_at) && $value->attempted_at!=''?date('d-M-Y H:i:s', strtotime($value->attempted_at)):'')}}</td>
                                            <td>{{(isset($value->ip_address) && $value->ip_address!=''?$value->ip_address:'')}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SNO</th>
                                    <th>Result</th>
                                    <th>User</th>
                                    <th>Date Time</th>
                                    <th>IP</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ajax data source array end-->
        </div>
        @endif

        @if(isset($data['getUserActivity']) && $data['getUserLoginActivity']!='')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Daily Log</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-striped dataex-html5-selectors">
                                    <thead>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Activity</th>
                                        <th>Result</th>
                                        <th>User</th>
                                        <th>Date Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $ss = 1
                                    @endphp

                                        @foreach ($data['getUserActivity'] as $k=>$u)
                                            <tr>
                                                <td>{{$sno++}}</td>
                                                <td>{{(isset($u->activityName) && $u->activityName!=''?wordwrap($u->activityName, 50, "<br>\n"):'')}}</td>
                                                <td>{{(isset($u->result) && $u->result!=''?wordwrap($u->result, 50, "<br>\n"):'')}}</td>
                                                <td>{{(isset($u->name) && $u->name!=''?$u->name:'')}}</td>
                                                <td>{{(isset($u->createdDateTime) && $u->createdDateTime!=''? date('d-M-Y H:i:s', strtotime($u->createdDateTime)):'')}}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Activity</th>
                                        <th>Result</th>
                                        <th>User</th>
                                        <th>Date Time</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('.dataex-html5-selectors-login').DataTable({
                dom: 'Bfrtip',
                "displayLength": 15,
                "oSearch": {"sSearch": " "},
                autoFill: false,
                attr: {
                    autocomplete: 'off'
                },
                initComplete: function () {
                    $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: 'JSON',
                        action: function (e, dt, button, config) {
                            var data = dt.buttons.exportData();

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(data)]),
                                'Export.json'
                            );
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
            $('.dataex-html5-selectors').DataTable({
                dom: 'Bfrtip',
                "displayLength": 15,
                "oSearch": {"sSearch": " "},
                autoFill: false,
                attr: {
                    autocomplete: 'off'
                },
                initComplete: function () {
                    $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: 'JSON',
                        action: function (e, dt, button, config) {
                            var data = dt.buttons.exportData();

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(data)]),
                                'Export.json'
                            );
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
        });


        function getData() {
            var flag = 0;
            var data = {};
            data['idUser'] = $('#idUser').val();
            if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'] == 0 || data['idUser'] == '0') {
                $('#idUser').css('border', '1px solid red');
                flag = 1;
                toastMsg('User', 'Invalid User', 'danger');
                return false;
            } else {
                var url = '{{url('settings/Dashboard_Users/user_log_reports?u=')}}' + data['idUser'];
                window.location.href = url;
            }
        }
    </script>
@endsection
