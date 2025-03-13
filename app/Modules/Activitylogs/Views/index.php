<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();
?>
			<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row">
                    <div class="col-4">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            </div>
                            <input id="date_range" type='text' class="form-control dateLimit" value="" />
                        </div>

                    </div>

                    <div class="col-6">
                        <div class="button-group">
                            <button id="daterange" type="button" class="btn waves-effect waves-light btn-success">Find</button>
                        </div>
                    </div>
                </div>


                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered show-child-rows w-100">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th hidden>Id</th>
                                                <th>IP Address</th>
                                                <th>Message</th>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Created</th>
                                                <th>Action</th>
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

    var filter_dates = "";
        ////////////////// FOR DATE START///////////////////
        /*******************************************/
        // Date Limit
        /*******************************************/
        $('.dateLimit').daterangepicker({
            dateLimit: {
                days: 30
            },
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $("#daterange").click(function() {
            filter_dates = $("#date_range").val();
            table.draw();
            // alert(date_range);
        });
        ////////////////// FOR DATE ENDS///////////////////
            
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
                    "url": "<?= base_url() ?>/activitylogs/get_activity_logs",
                    "type": 'POST',
    
                    "data": function(d) {
                        d.filter_dates = filter_dates;
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
                        "data": "ip_address"
                    },
                    {
                        "data": "message"
                    },
                    {
                        "data": "user"
                    },
                    {
                        "data": "role",
                        "orderable": false,
                    },
                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("warehouse/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info warehouse_modal">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>' ;
                        },
                    },
                ],
            });
            
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-info mr-1');

               
});
</script>


       