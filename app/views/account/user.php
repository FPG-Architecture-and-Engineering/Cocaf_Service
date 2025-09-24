    <div class="br-mainpanel">
        <div class="br-pageheader">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <span class="breadcrumb-item">Account</span>
                <span class="breadcrumb-item">User</span>
                <span class="breadcrumb-item active">Records</span>
            </nav>
            <div class="control">
                <button class="btn btn-primary btn-list add" data-toggle="modal" data-target="#modal_add">
                    <i class="fa fa-plus-circle fa-lg"></i> &nbsp;<small>ADD RECORD</small>
                </button>
            </div>
        </div>
        <div class="br-pagetitle">
            <h4>Account User Records</h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php flash(promptMessage('message')); ?>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table_default" width="100%">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>A.D USERNAME</th>
                                <th>ROLE</th>
                                <th><center>ACTION</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($data['user'])) {
                                    foreach ($data['user'] as $key => $value) {

                                        $list_role = '';
                                        if (!empty($value['role_id']) && !empty($data['role'])) {
                                            $role = explode('-', $value['role_id']);
                                            foreach ($data['role'] as $key_role => $value_role) {
                                                if (in_array($value_role['id'], $role)) {
                                                    $list_role .= '<i class="fa fa-caret-right"></i> '.htmlDecode($value_role['name']).'<br>';
                                                }
                                            }
                                        }

                                        echo 
                                            '<tr id="'.$value['id'].'">
                                                <td>'.htmlDecode($value['first_name']).' '.htmlDecode($value['last_name']).'</td>
                                                <td>'.htmlDecode($value['username']).'</td>
                                                <td>'.$list_role.'</td>
                                                <td>
                                                    <center>
                                                        <a id="'.htmlDecode($value['id']).'" class="btn btn-sm btn-warning edit" data-action="edit" title="Update Record"><i class="fa fa-pencil-square-o"></i></a>
                                                        <a id="'.htmlDecode($value['id']).'" class="btn btn-sm btn-danger delete" data-action="delete" data-title="'.htmlDecode($value['first_name']).' '.htmlDecode($value['last_name']).'" title="Delete Record"><i class="fa fa-trash"></i></a>   
                                                        <a id="'.htmlDecode($value['id']).'" class="btn btn-sm btn-teal view" data-action="view" title="View Record"><i class="fa fa-file-text-o"></i></a>
                                                    </center>
                                                </td>
                                            </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_add" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <form id="form">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-primary tx-bold modal-title"><span></span> Record</h6>
                        <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body pd-25">
                        <div class="row mg-b-10">
                            <label class="col-sm-3 form-control-label">Full name: <span class="tx-danger">*</span></label>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="first_name" type="text" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="middle_name" type="text" class="form-control" placeholder="Middle Name">
                                <small class="text-muted">(optional)</small>
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="last_name" type="text" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="row mg-b-10">
                            <label class="col-sm-3 form-control-label">Account: <span class="tx-danger">*</span></label>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="username" type="text" class="form-control" placeholder="A.D Username" required>
                            </div>                            
                            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <input name="email" type="text" class="form-control" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="row mg-b-10">
                            <label class="col-sm-3 form-control-label">Contact Number: </label>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="mobile_no" type="text" class="form-control" placeholder="Mobile Number">
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input name="local_no" type="text" class="form-control number" placeholder="Office Local Number" maxlength="4">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 form-control-label">Role: <span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-10 mg-sm-t-0 checkbox_role">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <input name="id" type="hidden" class="form-control">
                            <button type="submit" class="btn btn-primary w-150px submit"><i class="fa fa-floppy-o"></i> &nbsp;<small>SAVE RECORD</small></button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="modal_view" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-primary tx-bold modal-title"><span></span> Record</h6>
                    <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body pd-25">
                    <div class="table-responsive">
                        <table class="table table-bordered bd rounded mg-b-0">
                            <tbody>
                                <tr>
                                    <td>A.D Username</td>
                                    <td id="username" class="tx-bold"></td>
                                </tr>
                                <tr>
                                    <td>Full name</td>
                                    <td id="name" class="tx-bold"></td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td id="email" class="tx-bold"></td>
                                </tr>
                                <tr>
                                    <td>Mobile Number</td>
                                    <td id="mobile_no" class="tx-bold"></td>
                                </tr>
                                <tr>
                                    <td>Office Local Number</td>
                                    <td id="local_no" class="tx-bold"></td>
                                </tr>        
                                <tr>
                                    <td>Role</td>
                                    <td id="role" class="tx-bold"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/lib/datatables/jquery.dataTables.js"></script>
    <script src="/public/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            'use strict';

            $('.table_default').DataTable({
                'language': {
                    'sSearch': '',
                    'searchPlaceholder': 'Search...',
                    'lengthMenu': '_MENU_ items/page',
                    'emptyTable': 'No Records Found'
                },
                'columnDefs': [
                    { 
                        'targets': 3, 
                        'orderable': false 
                    }
                ]
            });

            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });            
        });
    </script>

    <script type="text/javascript">
        // CLEAR FIELDS
        $(document).ready(function(){
            $('body').on('hidden.bs.modal', '.modal', function(){
                $('form input').val('');
                $('.required').remove();    
            });
        });

        // ADD
        $(document).on('click', '.add', function(e){
            $('#modal_add .modal-title span').html('Add New');

            var role   = '<?php echo $data['role_list']; ?>';
            checkboxRole(role);
        });

        // ADD
        $(document).on('click', '.submit', function(e){
            e.preventDefault();
            
            $('.required').remove();

            $('#form input, #form select').each(
                function(index){  
                    var input   = $(this);
                    var prop    = input.prop("required");
                    var name    = input.prop("name");
                    var type    = input.prop("type");
                    var value   = input.val();
                    var parent  = input.parent();

                    if (typeof prop !== typeof undefined && prop !== false) {
                        if(value == ''){
                            parent.append('<i class="required">required field</i>');
                        }
                    }
                }
            );

            if($('#form .required').length <= 0){
                $.ajax({
                    url: '/account/user_json/',
                    type: 'post',
                    data: $('#form').serializeArray(),
                    beforeSend: function(){
                        promptAjaxLoading('form');
                    },
                    success: function(data){
                        promptAjaxSuccess('modal_add', data.message);
                        // console.log(data);
                    },
                    error: function(xhr, desc, err){ 
                        // console.log(xhr);
                        // console.warn(xhr.responseText);
                    }
               });
            }
        });

        // EDIT
        $(document).on('click', '.edit', function(e){
            e.preventDefault();

            var id      = $(this).attr('id');
            var action  = $(this).data('action');

            $.ajax({
                url: '/account/user_json/',
                type: 'post',
                data: {id:id, action:action},
                success: function(data){
                    $('input[name=id]').val(data.id);
                    $('input[name=first_name]').val(data.first_name);
                    $('input[name=middle_name]').val(data.middle_name);
                    $('input[name=last_name]').val(data.last_name);
                    $('input[name=username]').val(data.username);
                    $('input[name=email]').val(data.email);
                    $('input[name=mobile_no]').val(data.mobile_no);
                    $('input[name=local_no]').val(data.local_no);

                    var role = '<?php echo $data['role_list']; ?>';
                    checkboxRole(role, data.role_id);

                    $('#modal_add .modal-title span').html('Edit');
                    $('#modal_add').modal('show');
                    
                    // console.log(data);
                },
                error: function(xhr, desc, err){ 
                    // console.log(xhr);
                    // console.warn(xhr.responseText);
                }
           });
        });

        // DELETE
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id      = $(this).attr('id');
            var action  = $(this).data('action');
            var title   = $(this).data('title');

            var check = confirm("Are you sure you want to delete?\n\n"+title);
            if(check == true){
                $.ajax({
                    url: '/account/user_json/',
                    type: 'post',
                    data: {id:id, action:action},
                    success: function(data){
                        // console.log(data);
                        alert(data.message);
                        location.reload();
                    },
                    error: function(xhr, desc, err){ 
                        // console.log(xhr);
                        // console.warn(xhr.responseText);
                    }
               });
            }
        });

        // VIEW
        $(document).on('click', '.view', function(e){
            e.preventDefault();

            var id      = $(this).attr('id');
            var action  = $(this).data('action');

            $.ajax({
                url: '/account/user_json/',
                type: 'post',
                data: {id:id, action:action},
                success: function(data){
                    $('#id').html(data.id);
                    $('#name').html(data.first_name+' '+data.middle_name+' '+data.last_name);
                    $('#username').html(data.username);
                    $('#email').html(data.email);
                    $('#mobile_no').html(data.mobile_no);
                    $('#local_no').html(data.local_no);

                    var list_role = '<?php echo $data['role_list']; ?>';
                    displayList('role', list_role, data.role_id);

                    $('#modal_view .modal-title span').html('View');
                    $('#modal_view').modal('show');
                    
                    // console.log(data);
                },
                error: function(xhr, desc, err){ 
                    // console.log(xhr);
                    // console.warn(xhr.responseText);
                }
           });
        });
    </script>

    <script type="text/javascript">
        function displayList(id, list, row=''){
            var arr = list.split('+');

            $('#'+id).html('');
            $.each(arr, function(index, value){

                var check = '';
                var data  = value.split('_');
                var item  = row.split('-');

                if($.inArray(data[0], item) != '-1'){
                    $('#'+id).append(data[1]+', ');
                }
            });
        }
    </script>

    <script type="text/javascript">
        function checkboxRole(list, row=''){
            var arr = list.split('+');

            $('.checkbox_role').html('');
            $.each(arr, function(index, value){

                var check = '';
                var data  = value.split('_');
                var item  = row.split('-');

                if($.inArray(data[0], item) != '-1'){
                    check = 'checked';
                }else{
                    check = '';
                }

                $('.checkbox_role').append('<label class="ckbox mg-b-10 wd-50p ckbox-inline"><input name="role_id[]" type="checkbox" value="'+data[0]+'" '+check+'><span>'+data[1]+'</span></label>');
            });
        }
    </script>