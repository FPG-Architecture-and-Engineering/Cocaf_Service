    <div class="br-mainpanel">
        <div class="br-pageheader top-sticky">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <span class="breadcrumb-item">Transaction</span>
                <span class="breadcrumb-item active">View</span>
            </nav>
            <div class="control">
                <a href="/transaction/all/" class="btn btn-primary btn-list">
                    <i class="fa fa-arrow-circle-left fa-lg"></i> &nbsp;<small>BACK</small>
                </a>
            </div>
        </div>
        <div class="br-pagetitle">
            <h4>View Transaction</h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-message">
                <?php flash(promptMessage('message')); ?>
            </div>
        </div>
        <div class="br-pagebody mg-b-15">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="tx-info mg-b-15 tx-18">
                            REQUEST INFORMATION
                        </h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered bd rounded mg-b-0" width="100%">
                        <tbody>
                            <tr>
                                <td>Transaction ID</td>
                                <td><strong><?php echo htmlDecode($data['request']['transaction_id']); ?></strong></td>
                                <td>Transaction Type</td>
                                <td><strong><?php echo htmlDecode($data['request']['transaction_type']); ?></strong></td>
                            </tr>
                            <?php if ($data['request']['transaction_type'] != 'VERIFY') { ?>
                                <tr>
                                    <td>Application</td>
                                    <td><strong><?php echo htmlDecode($data['request']['app']); ?></strong></td>
                                    <td>Registration Type</td>
                                    <td><strong><?php echo htmlDecode($data['request']['reg_type']); ?></strong></td>
                                </tr>
                                <?php if ($data['request']['transaction_type'] == 'RENEWAL') { ?>
                                    <tr>
                                        <td>Plate No.</td>
                                        <td><strong><?php echo htmlDecode($data['request']['plate_no']); ?></strong></td>
                                        <td>MV File No.</td>
                                        <td><strong><?php echo htmlDecode($data['request']['mv_file_no']); ?></strong></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($data['request']['transaction_type'] == 'NEW') { ?>
                                    <tr>
                                        <td>Engine No.</td>
                                        <td><strong><?php echo htmlDecode($data['request']['engine_no']); ?></strong></td>
                                        <td>Chassis No.</td>
                                        <td><strong><?php echo htmlDecode($data['request']['chassis_no']); ?></strong></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>COC No.</td>
                                    <td><strong><?php echo htmlDecode($data['request']['coc_no']); ?></strong></td>
                                    <td>Tax Type</td>
                                    <td><strong><?php echo htmlDecode($data['request']['tax_type']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>MV Type</td>
                                    <td><strong><?php echo htmlDecode($data['request']['mv_type']); ?></strong></td>
                                    <td>MV Premium Type</td>
                                    <td><strong><?php echo htmlDecode($data['request']['mv_prem_type']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Inception Date</td>
                                    <td><strong><?php echo htmlDecode($data['request']['inception_date']); ?></strong></td>
                                    <td>Expiry Date</td>
                                    <td><strong><?php echo htmlDecode($data['request']['expiry_date']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Assured Name</td>
                                    <td><strong><?php echo htmlDecode($data['request']['assured_name']); ?></strong></td>
                                    <td>Assured TIN</td>
                                    <td><strong><?php echo htmlDecode($data['request']['assured_tin']); ?></strong></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>COC No.</td>
                                    <td><strong><?php echo htmlDecode($data['request']['coc_no']); ?></strong></td>
                                    <td>Application</td>
                                    <td><strong><?php echo htmlDecode($data['request']['app']); ?></strong></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>Created By</td>
                                <td><strong><?php echo htmlDecode($data['request']['created_name']); ?></strong></td>
                                <td>Created Date</td>
                                <td><strong><?php echo htmlDecode($data['request']['created_when']); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="br-pagebody mg-t-15">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-message">
                        <?php flash(promptMessage('message')); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="tx-info mg-b-15 tx-18">
                            RESPONSE INFORMATION
                        </h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered bd rounded mg-b-0" width="100%">
                        <tbody>
                            <tr>
                                <td width="21%">Message</td>
                                <td colspan="3">
                                    <strong>
                                        <?php if ($data['response']['status'] == 'success' && $data['response']['transaction_type'] == 'VERIFY') { ?>
                                            <span class="text-success">Success: COC Verification Successful!</span>
                                        <?php } elseif ($data['response']['status'] == 'success') { ?>
                                            <span class="text-success">Success: <?php echo htmlDecode($data['response']['success_message']); ?></span>
                                        <?php } else { ?>
                                            <span class="text-danger">Failed: <?php echo htmlDecode($data['response']['error_message']); ?></span>
                                        <?php } ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php 
                                if ($data['response']['status'] == 'success') {
                                    if ($data['response']['transaction_type'] == 'NEW') { 
                            ?>
                                        <tr>
                                            <td>Authentication No.</td>
                                            <td><strong><?php echo $data['response']['auth_no']; ?></strong></td>
                                            <td>COC No.</td>
                                            <td><strong><?php echo $data['response']['coc_no']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Premium Type</td>
                                            <td><strong><?php echo $data['response']['premium_type']; ?></strong></td>
                                            <td>Created Date</td>
                                            <td><strong><?php echo $data['response']['created_when']; ?></strong></td>
                                        </tr>
                                    <?php } elseif ($data['response']['transaction_type'] == 'RENEWAL') { ?>
                                        <tr>
                                            <td>Authentication No.</td>
                                            <td><strong><?php echo $data['response']['auth_no']; ?></strong></td>
                                            <td>Premium Type</td>
                                            <td><strong><?php echo $data['response']['premium_type']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>COC No.</td>
                                            <td><strong><?php echo $data['response']['coc_no']; ?></strong></td>
                                            <td>Plate No.</td>
                                            <td><strong><?php echo $data['response']['plate_no']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Created Date</td>
                                            <td><strong><?php echo $data['response']['created_when']; ?></strong></td>
                                        </tr>
                                    <?php } elseif ($data['response']['transaction_type'] == 'VERIFY') { ?>
                                        <tr>
                                            <td>Authentication No.</td>
                                            <td><strong><?php echo $data['response']['auth_no']; ?></strong></td>
                                            <td>Authentication Type</td>
                                            <td><strong><?php echo $data['response']['auth_type']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Authentication Date</td>
                                            <td><strong><?php echo $data['response']['auth_date']; ?></strong></td>
                                            <td>COC Status</td>
                                            <td><strong><?php echo $data['response']['coc_status']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>COC No.</td>
                                            <td><strong><?php echo $data['response']['coc_no']; ?></strong></td>
                                            <td>Organization ID</td>
                                            <td><strong><?php echo $data['response']['org_id']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Plate No.</td>
                                            <td><strong><?php echo $data['response']['plate_no']; ?></strong></td>
                                            <td>MV File No.</td>
                                            <td><strong><?php echo $data['response']['mv_file_no']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Engine No.</td>
                                            <td><strong><?php echo $data['response']['engine_no']; ?></strong></td>
                                            <td>Chassis No.</td>
                                            <td><strong><?php echo $data['response']['chassis_no']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle Type</td>
                                            <td><strong><?php echo $data['response']['vehicle_type']; ?></strong></td>
                                            <td>Tax Type</td>
                                            <td><strong><?php echo $data['response']['tax_type']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>MV Type</td>
                                            <td><strong><?php echo $data['response']['mv_type']; ?></strong></td>
                                            <td>Premium Type</td>
                                            <td><strong><?php echo $data['response']['premium_type']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Inception Date</td>
                                            <td><strong><?php echo $data['response']['inception_date']; ?></strong></td>
                                            <td>Expiry Date</td>
                                            <td><strong><?php echo $data['response']['expiry_date']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Registration Type</td>
                                            <td><strong><?php echo $data['response']['reg_type']; ?></strong></td>
                                            <td>LTO Verification Code</td>
                                            <td><strong><?php echo $data['response']['lto_verification_code']; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><strong><?php echo $data['response']['username']; ?></strong></td>
                                            <td>Created Date</td>
                                            <td><strong><?php echo $data['response']['created_when']; ?></strong></td>
                                        </tr>
                            <?php 
                                    } 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>