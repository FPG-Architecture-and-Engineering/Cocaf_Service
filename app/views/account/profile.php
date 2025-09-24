    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <h4>Your Profile</h4>
            <p class="mg-b-0">User account information</p>
        </div>        
        <div class="br-pagebody">
            <?php flash(promptMessage('message')); ?>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <form id="form" method="POST" enctype="multipart/form-data">
                    <div class="table-responsive bd rounded">
                        <table class="table table-bordered mg-b-0">
                            <tbody>
                                <tr>
                                    <td width="20%">A.D Username</td>
                                    <td class="tx-bold"><?php echo arrayKeyExist($data['profile'], 'username'); ?></td>
                                </tr>
                                <tr>
                                    <td>Full name</td>
                                    <td class="tx-bold"><?php echo arrayKeyExist($data['profile'], 'full_name'); ?></td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td class="tx-bold"><?php echo arrayKeyExist($data['profile'], 'email'); ?></td>
                                </tr>
                                <tr>
                                    <td class="form-control-label">Mobile Number</td>
                                    <td class="tx-bold">
                                        <input name="mobile_no" type="text" class="form-control number wd-200" maxlength="11" value="<?php echo arrayKeyExist($data['profile'], 'mobile_no'); ?>">
                                        <small class="text-muted">( max 11 characters )</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-control-label">Office Local Number</td>
                                    <td class="tx-bold">
                                        <input name="local_no" type="text" class="form-control number wd-200" maxlength="4" value="<?php echo arrayKeyExist($data['profile'], 'local_no'); ?>">
                                        <small class="text-muted">( max 4 characters )</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td class="tx-bold">
                                        <?php
                                            if (!empty(arrayKeyExist($data['profile'], 'role_id')) && !empty($data['role'])) {
                                                $count = 0;
                                                $role = explode('-', arrayKeyExist($data['profile'], 'role_id'));
                                                foreach ($data['role'] as $key_role => $value_role) {
                                                    if (in_array($value_role['id'], $role)) {
                                                        echo $value_role['name'];
                                                        $count++;
                                                        if ($count != count($role)) echo ', ';
                                                    }
                                                }
                                            } else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>  
                                <tr>
                                    <td class="form-control-label">Photo</td>
                                    <td>
                                        <label class="custom-file">
                                            <input name="file_1" type="file" class="custom-file-input">
                                            <span class="custom-file-control"></span>
                                        </label>
                                        <input name="file_1_hidden" type="hidden" class="form-control" readonly value="<?php echo arrayKeyExist($data['profile'], 'photo'); ?>">
                                        <?php if(!empty($data['profile']['photo'])){ ?>
                                            <div class="row mg-t-10 control">
                                                <div class="col-sm-4 mg-b-10"> 
                                                    <img src="<?php echo displayImage(arrayKeyExist($data['profile'], 'photo'), 'account') ?>" class="wd-80 rounded-circle" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="ckbox">
                                                        <input name="file_1_delete" type="checkbox">
                                                        <span class="text-muted">Delete Photo</span>
                                                    </label>
                                                </div>
                                            </div> 
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <center>
                        <button name="submit" type="submit" class="btn btn-success tx-mont wd-230">
                            <small>UPDATE RECORD</small>
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('change', 'input[name=file_1]', function(e){
            var file_name = e.target.files[0].name;
            $(this).next('.custom-file-control').html(file_name);
        });
    </script>