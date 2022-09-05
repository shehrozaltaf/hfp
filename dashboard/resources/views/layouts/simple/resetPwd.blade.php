<div class="modal fade text-left" id="changePasswordModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel_changePwd" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="loader-box hide loader">
                <div class="loader-1 myloader"></div>
                <div class="myloader"> Loading..</div>
            </div>
            <div class="modal-header bg-primary white">
                <h6 class="modal-title white" id="myModalLabel_changePwd">Change Password</h6>
                <button class="btn-close white hide closeModal" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="isNewUser" name="isNewUser"
                       value="<?php echo(isset(Auth::user()->isNewUser) && Auth::user()->isNewUser == '1' ? '1' : '0') ?>"
                       autocomplete="isNewUser">

                <?php $pwdExpiry = Auth::user()->pwdExpiry;
                if (isset($pwdExpiry) && $pwdExpiry != '' && date('Y-m-d', strtotime($pwdExpiry)) <= date('Y-m-d')) {
                    $pwdExpiry_val = date('Y-m-d', strtotime($pwdExpiry));
                } else {
                    $pwdExpiry_val = 0;
                } ?>
                <input type="hidden" id="pwdExpiry" name="pwdExpiry"
                       value="<?php echo $pwdExpiry_val ?>"
                       autocomplete="isNewUser">

                <div class="mb-2 form-group userPasswordDiv">
                    <label for="edit_newPassword">New Password: </label>
                    <input type="text" class="form-control edit_newPassword myPwdInput"
                           autocomplete="edit_newPassword_off" id="edit_newPassword">
                    <div class="form-control-position toggle-password">
                        <i class="ft-eye-off pwdIcon"></i>
                    </div>


                    <div class="mb-3 mt-1 small ">
                        <p class="m-0 mytext-sm">Password must contain:</p>
                        <ul class=" list-group">
                            <li class="list-group-item p-1"><p id="letter" class="letter invalid mytext-sm m-0">
                                    A <b>lowercase</b> letter</p></li>
                            <li class="list-group-item p-1"><p id="capital"
                                                               class="capital invalid mytext-sm m-0">A <b>capital
                                        (uppercase)</b> letter</p></li>
                            <li class="list-group-item p-1"><p id="number" class="number invalid mytext-sm m-0">
                                    A <b>number</b></p></li>
                            <li class="list-group-item p-1"><p id="length" class="length invalid mytext-sm m-0">
                                    Minimum <b>8 characters</b></p></li>
                        </ul>
                    </div>

                </div>

                <div class="mb-2 form-group">
                    <label for="edit_newPasswordConfirm">Confrim Password: </label>
                    <div class="position-relative  ">
                        <input type="text" class="form-control edit_newPasswordConfirm myPwdInput"
                               autocomplete="edit_newPasswordConfirm_off" id="edit_newPasswordConfirm">
                        <div class="form-control-position toggle-password">
                            <i class="ft-eye-off pwdIcon"></i>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="changePassword()">Change Password
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var closeButtonClicked = false;

    $('.closeModal').on('click', function () {
        closeButtonClicked = true;
        hideModal('changePasswordModal');
    });

    $('#changePasswordModal').on('hide.bs.modal', function (e) {
        if (!closeButtonClicked) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
        closeButtonClicked = false;
    });

    $(document).ready(function () {
        showFirstPwdModal(1);
        validatePwd('edit_newPassword');
        validatePwd('edit_newPasswordConfirm');
    });

    function showFirstPwdModal(type) {
        $('.closeModal').addClass('hide');
        var isNewUser = $('#isNewUser').val();
        var pwdExpiry = $('#pwdExpiry').val();
        var label = '';
        var showModal = 0;
        if (isNewUser == 1) {
            label = 'First time login, Please change password';
            showModal = 1;
        } else if (type == 2) {
            $('.closeModal').removeClass('hide');
            label = 'Change Password';
            showModal = 1;
        } else if (pwdExpiry != '' && pwdExpiry != '0') {
            label = 'You did not change your password from +90 days, Please change your password now.';
            showModal = 1;
        }
        if (showModal == 1) {
            $('#myModalLabel_changePwd').text(label);
            $('#changePasswordModal').modal('show', {backdrop: 'static', keyboard: false});
        }

    }

    function changePassword() {
        var flag = 0;
        $('#edit_newPassword').css('border', '1px solid #babfc7');
        $('#edit_newPasswordConfirm').css('border', '1px solid red');
        var data = {};
        data['isNewUser'] = $('#isNewUser').val();
        data['pwdExpiry'] = $('#pwdExpiry').val();
        data['newpassword'] = $('#edit_newPassword').val();
        data['newpasswordconfirm'] = $('#edit_newPasswordConfirm').val();

        if (data['newpassword'] == '' || data['newpassword'] == undefined) {
            $('#edit_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Invalid New Password', 'danger');
            flag = 1;
            return false;
        }
        if (data['newpassword'].length < 8) {
            $('#edit_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Password length must be greater than 8 digits', 'danger');
            flag = 1;
            return false;
        }
        if (validatePwdInp('edit_newPassword')==1) {
            $('#edit_newPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Password format Issue', 'danger');
            return false;
        }

        if (data['newpasswordconfirm'] == '' || data['newpasswordconfirm'] == undefined || data['newpassword'] != data['newpasswordconfirm']) {
            $('#edit_newPasswordConfirm').css('border', '1px solid red');
            toastMsg('Confirm Password', 'Invalid Confirm Password', 'danger');
            flag = 1;
            return false;
        }
        if (flag == 0) {
            showloader();
            CallAjax('{{ route('changePassword') }}', data, 'POST', function (result) {
                hideloader();
                if (result !== '' && JSON.parse(result).length > 0) {
                    var response = JSON.parse(result);
                    try {
                        toastMsg(response[0], response[1], response[2]);
                        if (response[0] === 'Success') {
                            CallAjax('{{ route('logout') }}', {}, 'POST', function (res) {
                                window.location.reload();
                            });
                            hideModal('changePasswordModal');
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    } catch (e) {
                    }
                } else {
                    toastMsg('Error', 'Something went wrong while saving data', 'danger');
                }
            });

        }
    }
</script>
