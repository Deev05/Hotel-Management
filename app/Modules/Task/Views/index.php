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
                    <div class="col-12 mb-3 mt-2">
                        <!-- <div class="card"> -->
                            <!-- <div class="card-body"> -->
                                <div class="row button-group">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-2 offset-md-2">
                                        <a href="<?= base_url('Task/create')?>" class="btn btn-block btn-outline-info"> + Add</a>
                                    </div>
                                </div>
                            <!-- </div> -->
                        <!-- </div> -->
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
                                                <th>Room No</th>
                                                
                                                <th>Task type</th>
                                                <th>Task name</th>
                                                <th>Assigned To</th>
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


                <div id="task_details_modal" class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title"> Task Details </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body" id="task_details_in_modals">
                                <div class="task_details_data"></div>                     
                            </div>
                       
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
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

                        "aaSorting": [ [0,"desc" ]],
                        "serverSide": true,
                        "processing": true,
                        "start": 1,
                        "end": 8,
                        "pageLength": 10,
                        "paging": true,
                        "ajax": {
                            "url": "<?= base_url() ?>/Task/get_Task",
                            "type": 'POST',
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
                                "data": "id",
                                "defaultContent": '',
                                "render": function(data) {
                                    return data;
                                }
                            },
                            {
                                "data": "room_no"
                            },
                           
                            {
                                "data": "task_type",
                                
                            },
                            {
                                "data": "task_name",
                                
                            },
                            {
                                "data": "assigned_to"
                            },
                            
                            {
                                "data": "created"
                            },
                            {
                                "orderable": false,
                                "data": "id",
                                "render": function(data) {
                                    var edit_url = "<?= base_url("Task/update") ?>/"+data ;
                                    var delete_url = "<?= base_url("Task/delete") ?>/" +data;
                                    return '<div class="btn-group">' +
                                        '<a href="' + edit_url + '" class="btn btn-info view">' +
                                        '<i class="fa fa-pencil-alt"></i>' +
                                        '</a>' +
                                        '<a href="javascript:void(0)" class="btn btn-danger">' +
                                        '<i class="fa fa-trash delete_button"></i>' +
                                        '</a>'+
                                         '<a href="javascript:void(0)" class="btn btn-success">' +
                                        '<i class="fa fa-eye task_details_modal"></i>' +
                                        '</a>';
                                },
                            },
                        ],
                    });
                    $(document).on('click', '.change_status', function() {
                        var id = table.row($(this).closest('tr')).data().id;
                        $.ajax({
                            method: "POST",
                            url: "<?= base_url(); ?>/Task/change_status/" + id,
                            success: function(message) {
                                table.draw();
                                obj = JSON.parse(message);
                                var status = obj.status;
            
                                if (status == 0) {
                                    toastr.error(obj.message);
                                } else {
                                    toastr.success(obj.message);
                                }
                            },
                        });
                    })
                    $(document).on('click', '.delete_button', function() {
                        var id = table.row($(this).closest('tr')).data().id;
                    
                        $.ajax({
                            method: "POST",
                            url: "<?= base_url(); ?>/Task/delete/" + id,
                            success: function(message) {
                                table.draw();
                                obj = JSON.parse(message);
                                var status = obj.status;

                                if (status == 0) {
                                    toastr.error(obj.message);
                                } else {
                                    toastr.success(obj.message);
                                }
                            },
                        });
                    });
                    $(document).on('click', '.view_button', function() {
                        var id = table.row($(this).closest('tr')).data().id;
                    
                        $.ajax({
                            method: "POST",
                            url: "<?= base_url(); ?>/Task/view_sub_task_details/" + id,
                            success: function(message) {
                                table.draw();
                                obj = JSON.parse(message);
                                var status = obj.status;

                                if (status == 0) {
                                    toastr.error(obj.message);
                                } else {
                                    toastr.success(obj.message);
                                }
                            },
                        });
                    });
                    $(document).on('click', '.task_details_modal', function(e) {
                        var id    = table.row($(this).closest('tr')).data().id;
                    
                        e.preventDefault();

                        $.ajax({
                                url: '<?= base_url(); ?>/Task/view_sub_task_details/' + id,
                                enctype: 'multipart/form-data',
                                data:{id:id},
                                dataType:"JSON",
                                method:"POST",

                                success: function(message) {
                                    
                                    obj = message;
                                    var status = obj.status;
                                    if (status == 0) {
                                        toastr.error(obj.message);
                                    } else {
                                        
                                        $('.task_details_data').html(obj.task_details_in_modals);
                                    
                                    }
                                }
                            });

                        $("#task_details_modal").modal('show');

                    })
                
                
                
                
                });


                
            </script>

       