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
    
    <div class="row m-t-40">
        <!-- Column -->
        <div class="col-md-2 col-lg-2 col-xlg-2">
            <div class="card card-hover">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white"><?php echo $all_tickets; ?></h1>
                    <h6 class="text-white">Total</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-2 col-lg-2 col-xlg-2">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <h1 class="font-light text-white"><?php echo $opened; ?></h1>
                    <h6 class="text-white">Opened</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-md-2 col-lg-2 col-xlg-2">
            <div class="card card-hover">
                <div class="box bg-primary text-center">
                    <h1 class="font-light text-white"><?php echo $in_progress; ?></h1>
                    <h6 class="text-white">In Progress</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-2 col-lg-2 col-xlg-2">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><?php echo $responded; ?></h1>
                    <h6 class="text-white">Responded</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-2 col-lg-2 col-xlg-2">
            <div class="card card-hover">
                <div class="box bg-dark text-center">
                    <h1 class="font-light text-white"><?php echo $resolved; ?></h1>
                    <h6 class="text-white">Resolved</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
  
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
                                    <th>Status</th>
                                    <th>Ticket No</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Service Provider</th>
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
                    "url": "<?= base_url() ?>/sopsptickets/get_data",
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
                        "orderable": false,
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer">Opened</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-info custom_pointer">In Progress</span></div>';
                            }else if (data == 2) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer">Responded</span></div>';
                            }else if (data == 3) {
                                return '<div class="text-center"><span class="badge badge-pill badge-success custom_pointer">Resolved</span></div>';
                            }
                           
                        }
                    },
                   {
                        "orderable": false,
                        "data": "ticket_no",
                        "render": function(data) {
                            
                            return '<a href="javascript:void(0)" class="font-medium link"> ' + data +  '</a>';
                           
                        }
                    },
                    {
                        "orderable": false,
                        "data": "title",
                        "render": function(data) {
                            
                            return '<a href="javascript:void(0)" class="font-medium link"> ' + data +  '</a>';
                           
                        }
                    },
                    {
                        "data": "created"
                    },
                    {
                        "data": "service_provider_name"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            return '<div class="btn-group">' +
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="ti-settings"></i>' +
                            '</button>' +
                                '<div class="dropdown-menu  " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">' +
                                    '<div class="dropdown-header">Change Application Status</div>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="0" href="javascript:void(0)"> Opened</a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="1" href="javascript:void(0)"> In Progress</a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="2" href="javascript:void(0)"> Responded </a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="3" href="javascript:void(0)"> Resolved</a>' +
                                '</div>' +
                            '</div>';
                        },
                    },
                    
                ],
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        setInterval(function() {
            tableChildRows.draw();
        }, 120000);
        
        
        $(document).on('click', '.link', function() {
            var id = table.row($(this).closest('tr')).data().id;
            location.href = '<?= base_url() ?>sopsptickets/single/' + id
        });
        
          $(document).on('click', '.status', function() {
            var id = $(this).attr('dataid');
            var status = $(this).attr('datastatus');
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/sopsptickets/change_ticket_status",
                 data: {
                    'status': status,
                    'id': id,
                },
                success: function(message) {
                    table.draw();
                    obj = JSON.parse(message);
                    var status = obj.status;

                    if (status == 0) {
                        toastr.error(obj.message);
                    } else {
                        
                        toastr.success(obj.message);
                        tableChildRows.draw();
                    }
                },
            });
        });


    });

</script>