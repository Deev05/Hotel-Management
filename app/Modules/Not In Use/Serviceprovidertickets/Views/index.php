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
                                    <th>Status</th>
                                    <th>Ticket No</th>
                                    <th>Title</th>
                                    <th>Date</th>
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
                    "url": "<?= base_url() ?>/serviceprovidertickets/get_data",
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
                   
                   
                    
                ],
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        setInterval(function() {
            tableChildRows.draw();
        }, 120000);
        
        
        $(document).on('click', '.link', function() {
            var id = table.row($(this).closest('tr')).data().id;
            location.href = '<?= base_url() ?>serviceprovidertickets/single/' + id
        });
        
          $(document).on('click', '.status', function() {
            var id = $(this).attr('dataid');
            var status = $(this).attr('datastatus');
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/serviceprovidertickets/change_ticket_status",
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