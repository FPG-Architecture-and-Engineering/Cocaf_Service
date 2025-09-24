    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <h4>Reports Generation</h4>
        </div>
        <div class="br-pagebody">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-message">
                    <?php flash(promptMessage('message')); ?>
                </div>
            </div>
            <div class="br-section-wrapper">
                <form id="form" method="post" enctype="multipart/form-data">
                    <div class="row mg-b-10">
                        <label class="col-sm-3 form-control-label">Client:</label>
                        <div class="col-sm-6">
                            <select name="app" class="form-control select" style="width: 100%" data-placeholder="Choose Client" required>
                                <option value=""></option>
                                <option value="all">All</option>
                                <?php 
                                    if (!empty($data['client'])) {
                                        foreach ($data['client'] as $key => $value) {
                                            echo '<option value="'.$value['app'].'">'.$value['app'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 form-control-label">Date:</label>
                        <div class="col-sm-3 pd-r-5">
                            <div class="input-group">
                                <input name="date_from" class="form-control input-readonly calendar" type="text" placeholder="From" autocomplete="off" readonly required />
                                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3 pd-l-5">
                            <div class="input-group">
                                <input name="date_to" class="form-control input-readonly calendar" type="text" placeholder="To" autocomplete="off" readonly required />
                                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-8 mg-t-30">
                            <center>
                                <button type="submit" class="btn btn-primary btn-list wd-150 submit">
                                    <i class="fa fa-file-text"></i> &nbsp;<small>EXPORT</small>
                                </button>
                                <button class="btn btn-danger btn-list wd-150 reset">
                                    <i class="fa fa-ban"></i> &nbsp;<small>RESET</small>
                                </button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[name=date_from]').datepicker({
                'dateFormat': 'MM dd, yy',
                'yearRange': '1970:+1',
                'changeMonth': true,
                'changeYear': true,
                beforeShow: function(){
                    $(this).datepicker('option','maxDate', $('input[name=date_to]').val());
                }
            });

            $('input[name=date_to]').datepicker({
                'dateFormat': 'MM dd, yy',
                'yearRange': '1970:+1',
                'changeMonth': true,
                'changeYear': true,
                beforeShow: function(){
                    $(this).datepicker('option','minDate', $('input[name=date_from]').val());
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '.reset', function(e){
            e.preventDefault();
            $('select[name=app]').val('').trigger('change');
            $('input[name=date_from]').val('');
            $('input[name=date_to]').val('');
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '.submit', function(e){
            e.preventDefault();
            
            $('.required').remove();

            $('#form input, #form select').each(

                function(index){  
                    var input       = $(this);
                    var prop        = input.prop('required');
                    var name        = input.prop('name');
                    var type        = input.prop('type');
                    var value       = input.val();
                    var parent      = input.parent();

                    var input_name  = ['date_from', 'date_to'];

                    if (input_name.includes(name)) {
                        parent  = parent.parent();
                    }

                    if (typeof prop !== typeof undefined && prop !== false) {
                        if(value == ''){
                            parent.append('<i class="required">required field</i>');
                        }
                    }
                }
            );

            if ($('#form .required').length <= 0) {
                $('#form').submit(); 
            } else {
                alertMessage('failed', 'Please fill in required fields');
            }
        });
    </script>