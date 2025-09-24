    <div class="br-mainpanel">
        <div class="br-pageheader">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <span class="breadcrumb-item">System</span>
                <span class="breadcrumb-item active">Configuration</span>
            </nav>
            <div class="control">
                <button class="btn btn-primary btn-list add" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus-circle fa-lg"></i> &nbsp;<small>ADD RECORD</small>
                </button>
            </div>
        </div>
        <div class="br-pagetitle">
            <h4>System Configuration Records</h4>
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
                                <th>APPLICATION</th>
                                <th>USERNAME</th>
                                <th>PASSWORD</th>
                                <th><center>ACTION</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (is_array($data)) {
                                    foreach ($data as $key => $value) {
                                        echo '
                                            <tr id="'.$value['id'].'">
                                                <td>'.htmlDecode($value['app']).'</td>
                                                <td>'.htmlDecode($value['username']).'</td>
                                                <td>'.htmlDecode($value['password']).'</td>
                                                <td>
                                                    <center>
                                                        <a id="'.htmlDecode($value['id']).'" class="btn btn-sm btn-warning edit" data-action="edit" title="Update Record"><i class="fa fa-pencil-square-o"></i></a>
                                                        <a id="'.htmlDecode($value['id']).'" class="btn btn-sm btn-danger delete" data-action="delete" data-title="'.htmlDecode($value['app']).'" title="Delete Record"><i class="fa fa-trash"></i></a>   
                                                    </center>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <form id="form">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-primary tx-bold modal-title"><span></span> Record</h6>
                        <button type="button" class="close cursor-pointer" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body pd-25">
                        <div class="row">
                            <label class="col-sm-3 form-control-label">Application: <span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input name="app" type="text" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 form-control-label">Username: <span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input name="username" type="text" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 form-control-label">Password: <span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input name="password" type="text" class="form-control" placeholder="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <input name="id" type="hidden" class="form-control">
                            <button type="submit" class="btn btn-primary w-150px submit"><i class="fa fa-floppy-o"></i> &nbsp; <small>SAVE RECORD</small></button>
                        </center>
                    </div>
                </div>
            </form>
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
        // ADD
        $(document).on('click', '.add', function(e){
            $('#modal .modal-title span').html('Add New');
            $('#modal input').val('');
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

            if($('#form .required').length <= 0) {
                $.ajax({
                    url: '/system/configuration_json/',
                    type: 'post',
                    data: $('#form').serialize(),
                    beforeSend: function(){
                        promptAjaxLoading('form');
                    },
                    success: function(data){
                        promptAjaxSuccess(data.result, data.message);
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
        $(document).ready(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();

                var id      = $(this).attr('id');
                var action  = $(this).data('action');

                $.ajax({
                    url: '/system/configuration_json/',
                    type: 'post',
                    data: {id:id, action:action},
                    success: function(data){

                        $('input[name=id]').val(data.id);
                        $('input[name=app]').val(data.app);
                        $('input[name=username]').val(data.username);
                        $('input[name=password]').val(data.password);

                        $('#modal .modal-title span').html('Edit');
                        $('#modal').modal('show');
                        
                        // console.log(data);
                    },
                    error: function(xhr, desc, err){ 
                        // console.log(xhr);
                        // console.warn(xhr.responseText);
                    }
               });
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
                    url: '/system/configuration_json/',
                    type: 'post',
                    data: {id:id, action:action},
                    success: function(data){
                        // console.log(data);
                        alert(data.message);
                        // location.reload();
                        window.location = document.URL;
                    },
                    error: function(xhr, desc, err){ 
                        // console.log(xhr);
                        // console.warn(xhr.responseText);
                    }
               });
            }
        });
    </script>