    <div class="br-mainpanel">
        <div class="br-pageheader top-sticky">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <span class="breadcrumb-item">Transaction</span>
                <span class="breadcrumb-item active">Register</span>
            </nav>
            <div class="control">
                <a href="/transaction/all/" class="btn btn-primary btn-list">
                    <i class="fa fa-arrow-circle-left fa-lg"></i> &nbsp;<small>BACK</small>
                </a>
            </div>
        </div>
        <div class="br-pagetitle">
            <h4>Register Transaction</h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-message">
                <?php flash(promptMessage('message')); ?>
            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <form id="form" method="post">

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Transaction Type: <span class="tx-danger">*</span></strong></label>
                                <select name="transaction_type" class="form-control select" style="width: 100%" data-placeholder="Choose Transaction Type" required>
                                    <option value=""></option>
                                    <option value="NEW">NEW</option>
                                    <option value="RENEWAL">RENEWAL</option>
                                    <option value="VERIFY">VERIFY</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Transaction ID</strong></label>
                                <input name="transaction_id" class="form-control" type="text" value="<?php echo 'COCAF-'.dateTimeAsId(); ?>" readonly required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>COC No.: <span class="tx-danger">*</span></strong></label>
                                <input name="coc_no" class="form-control" type="text" value="" required />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-not-verify">
                            <div class="form-group">
                                <label><strong>Tax Type: <span class="tx-danger">*</span></strong></label>
                                <input name="tax_type" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                    </div>

                    <div class="row row-not-add row-not-verify">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Plate No.: <span class="tx-danger">*</span></strong></label>
                                <input name="plate_no" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>MV File No.: <span class="tx-danger">*</span></strong></label>
                                <input name="mv_file_no" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                    </div>

                    <div class="row row-not-renewal row-not-verify">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Engine No.: <span class="tx-danger">*</span></strong></label>
                                <input name="engine_no" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Chassis No.: <span class="tx-danger">*</span></strong></label>
                                <input name="chassis_no" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                    </div>

                    <div class="row row-not-verify">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Inception Date: <span class="tx-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input name="inception_date" class="form-control input-readonly calendar not-verify" type="text" value="" autocomplete="off" readonly required />
                                    <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Expiry Date: <span class="tx-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input name="expiry_date" class="form-control input-readonly calendar not-verify" type="text" value="" autocomplete="off" readonly required />
                                    <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-not-verify">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>MV Type: <span class="tx-danger">*</span></strong></label>
                                <select name="mv_type" class="form-control select not-verify" style="width: 100%" data-placeholder="Choose MV Type" required>
                                    <option value=""></option>
                                    <?php 
                                        if (!empty($data['mv_type'])) {
                                            foreach ($data['mv_type'] as $key => $value) { 
                                                echo '<option value="'.htmlDecode($value['name']).'">'.htmlDecode($value['name']).' - '.htmlDecode($value['description']).'</option>';
                                            } 
                                        }
                                        unset($key, $value);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>MV Premium Type: <span class="tx-danger">*</span></strong></label>
                                <select name="mv_premium_type" class="form-control select not-verify" style="width: 100%" data-placeholder="Choose MV Premium Type" required>
                                    <option value=""></option>
                                    <?php 
                                        if (!empty($data['premium_type'])) {
                                            foreach ($data['premium_type'] as $key => $value) { 
                                                echo '<option value="'.htmlDecode($value['name']).'">'.htmlDecode($value['name']).' - '.htmlDecode($value['description']).'</option>';
                                            } 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row row-not-verify">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Assured Name: <span class="tx-danger">*</span></strong></label>
                                <input name="assured_name" class="form-control not-verify" type="text" value="" required />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label><strong>Assured TIN: <span class="tx-danger">*</span></strong></label>
                                <input name="assured_tin" class="form-control not-verify" type="text" value="" placeholder="999-999-999-99999" required />
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 tx-right">
                            <button type="submit" class="btn btn-primary w-150px submit"><i class="fa fa-floppy-o"></i> &nbsp;<small>SAVE RECORD</small></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[name=inception_date]').datepicker({
                'dateFormat': 'MM dd, yy',
                'yearRange': '-3:+3',
                'changeMonth': true,
                'changeYear': true,
                beforeShow: function(){
                    $(this).datepicker('option','maxDate', $('input[name=expiry_date]').val());
                }
            });

            $('input[name=expiry_date]').datepicker({
                'dateFormat': 'MM dd, yy',
                'yearRange': '-3:+3',
                'changeMonth': true,
                'changeYear': true,
                beforeShow: function(){
                    $(this).datepicker('option','minDate', $('input[name=inception_date]').val());
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', 'select[name=transaction_type]', function(){
            if ($('select[name=transaction_type]').val() == 'NEW') {

                $('.row-not-add').addClass('d-none');

                $('.row-not-renewal').removeClass('d-none');
                $('.row-not-verify').removeClass('hidden');
                $('.col-not-verify').removeClass('hidden');

                $('.not-verify').prop('required', true);

                $('input[name=plate_no]').val('');
                $('input[name=plate_no]').prop('required', false);

                $('input[name=mv_file_no]').val('');
                $('input[name=mv_file_no]').prop('required', false);

            } else if ($('select[name=transaction_type]').val() == 'RENEWAL') {

                $('.row-not-renewal').addClass('d-none');

                $('.row-not-add').removeClass('d-none');
                $('.row-not-verify').removeClass('hidden');
                $('.col-not-verify').removeClass('hidden');

                $('.not-verify').prop('required', true);

                $('input[name=engine_no]').val('');
                $('input[name=engine_no]').prop('required', false);

                $('input[name=chassis_no]').val('');
                $('input[name=chassis_no]').prop('required', false);

            } else if ($('select[name=transaction_type]').val() == 'VERIFY') {

                $('.row-not-verify').addClass('hidden');
                $('.col-not-verify').addClass('hidden');
                $('.not-verify').val('');
                $('.not-verify').prop('required', false);

                $('select[name=mv_type]').val('').trigger('change');
                $('select[name=mv_premium_type]').val('').trigger('change');

            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '.submit', function(e){
            e.preventDefault();
            
            $('.required').remove();

            $('#form input, #form select').each(

                function(index){  
                    var input   = $(this);
                    var prop    = input.prop('required');
                    var name    = input.prop('name');
                    var type    = input.prop('type');
                    var value   = input.val();
                    var parent  = input.closest('.form-group');

                    if (typeof prop !== typeof undefined && prop !== false) {
                        if(value == ''){
                            parent.append('<i class="required">required field</i>');
                        }
                    }
                }
            );

            if ($('#form .required').length <= 0) {
               $('#form').submit(); 
            }
        });
    </script>