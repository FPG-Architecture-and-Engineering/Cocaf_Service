    <div class="br-mainpanel">
        <div class="br-pageheader top-sticky">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <span class="breadcrumb-item">Transaction</span>
                <span class="breadcrumb-item active">All</span>
            </nav>
            <?php if (accessGranted(['2'])) { ?>
                <div class="control">
                    <a href="/transaction/register/" class="btn btn-primary btn-list">
                        <i class="fa fa-plus-circle fa-lg"></i> &nbsp;<small>ADD RECORD</small>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="br-pagetitle">
            <h4>Transaction List</h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-message">
                <?php flash(promptMessage('message')); ?>
            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center valign-middle">TRANSACTION ID</th>
                                <th class="text-center valign-middle">TYPE</th>
                                <th class="text-center valign-middle">APPLICATION</th>
                                <th class="text-center valign-middle">COC NO</th>
                                <th class="text-center valign-middle">INCEPTION DATE</th>
                                <th class="text-center valign-middle">EXPIRY DATE</th>
                                <th class="text-center valign-middle">CREATED DATE</th>
                                <th class="text-center valign-middle">CREATED BY</th>
                                <th class="text-center valign-middle">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/lib/datatables/jquery.dataTables.js"></script>
    <script src="/public/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script type="text/javascript">
        function format(d){
            var html = 
                `<div class="row">
                    <div class="col-sm-12">`;

            if (d.status == 'Success' && d.transaction_type == 'VERIFY') {
                html += '<span class="text-success">'+d.status+': COC Verification Successful!</span>';
            } else if (d.status == 'Success') {
                html += '<span class="text-success">'+d.status+': '+d.success_message+'</span>';
            } else {
                html += '<span class="text-danger">'+d.status+': '+d.error_message+'</span>';
            }

            html += `</div>
                </div>`;

            if (d.transaction_type != 'VERIFY') {
                html +=
                    `<div class="row pd-t-5">
                        <div class="col-sm-5">
                            <small><strong>PLATE NO.:</strong></small> `+d.plate_no+`<br>
                            <small><strong>MV FILE NO.:</strong></small> `+d.mv_file_no+`<br>
                            <small><strong>ENGINE NO.:</strong></small> `+d.engine_no+`<br>
                            <small><strong>CHASSIS NO.:</strong></small> `+d.chassis_no+`
                        </div>
                        <div class="col-sm-5">
                            <small><strong>MV TYPE:</strong></small> `+d.mv_type+`<br>
                            <small><strong>MV PREMIUM TYPE:</strong></small> `+d.mv_prem_type+`<br>
                            <small><strong>TAX TYPE:</strong></small> `+d.tax_type+`<br>
                            <small><strong>ASSURED:</strong></small> `+d.assured_name+` <small>(`+d.assured_tin+`)</small>
                        </div>
                    </div>`;
            }

            return html;
        }

        var table;
        $(document).ready(function() {
            'use strict';
            
            table = $('.table').DataTable({
                'language': {
                    'sSearch': '',
                    'searchPlaceholder': 'Search...',
                    'lengthMenu': '_MENU_ items/page',
                    'emptyTable': 'No Records Found'
                },
                'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '/transaction/all_json/'
                },
                'columns': [
                    { data: 'transaction_id' },
                    { data: 'transaction_type' },
                    { data: 'app' },
                    { data: 'coc_no' },
                    { data: 'inception_date' },
                    { data: 'expiry_date' },
                    { data: 'created_when' },
                    { data: 'created_name' },
                    { data: 'action' }
                ],
                'columnDefs': [
                    {
                        'targets': [4, 5, 6, 8],
                        'className': 'text-center valign-middle'
                    },
                    {
                        'targets': 8,
                        'orderable': false
                    },
                    {   
                        'targets': '_all', 
                        'className': 'valign-middle' 
                    }
                ],
                'createdRow': function(row, data, dataIndex){
                    this.api().row(row).child(format(data)).show();
                }
            });

            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
        });
    </script>