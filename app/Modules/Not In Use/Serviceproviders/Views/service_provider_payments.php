<?php
use App\Models\CommonModel;
?>
<!-- ============================================================= -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
  
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered show-child-rows w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>No.</th> -->
                                    <th hidden>Id</th>
                                    <th>Applicantion No</th>
                                    <th>Service</th>
                                    <th>Service Provider</th>
                                    <th>Payment Mode</th>
                                    <th>Transaction Id</th>
                                    <th>Package Price</th>
                                    <th>Fees/Charge</th>
                                    <th>Final Amount</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<script>
    $(document).ready(function() {
        
        
            var table = $('.show-child-rows').DataTable({
                     dom: 'Bfrtip',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "aaSorting": [ [0,"desc" ]],
                "serverSide": true,
                "processing": true,
                "start": 1,
                "end": 8,
                "pageLength": 10,
                "paging": true,
                "ajax": {
                    "url": "<?= base_url() ?>/serviceproviders/get_service_provider_payment_history",
                    "type": 'POST',
    
                    "data": function(d) {
                    }
                },
                "columns": [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": "no",
                        "defaultContent": 'number'
                    },
                    {
                        "className": 'id',
                        "visible": false,
                        // "orderable": true,
                        "data": "id",
                        "defaultContent": '',
                        "render": function(data) {
                            return data;
                        }
                    },
                    {
                        "data": "application_no"
                    },
                    {
                        "data": "service_name"
                    },
                    {
                        "data": "service_provider_name"
                    },
                 
                    {
                        "data": "payment_mode"
                    },
                    
                    {
                        "data": "transaction_id"
                    },
                    
                    {
                        "data": "package_price"
                    },
                    
                    {
                        "data": "commission"
                    },
                    
                    
                    {
                        "data": "final_amount"
                    },
                    
                    {
                        "data": "created"
                    },
                    
                ],
            });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');
    });

</script>