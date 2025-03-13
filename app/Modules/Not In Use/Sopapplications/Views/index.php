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
        <div class="col-12 text-center mb-3">
            <div class="button-group">
                <button type="button" data-label_filter="" class="filterlabel btn waves-effect waves-light btn-secondary">All(<?= $all_applications ?>)</button>
                <button type="button" data-label_filter="Documents Under Verification" class="filterlabel btn waves-effect waves-light btn-warning">Documents Under Verification(<?= $documents_under_verification ?>)</button>
                <button type="button" data-label_filter="Service Provider Assigned" class="filterlabel btn waves-effect waves-light btn-info">Service Provider Assigned(<?= $service_provider_assigned ?>)</button>
                <button type="button" data-label_filter="SOP Document Sent" class="filterlabel btn waves-effect waves-light btn-info">SOP Document Sent(<?= $sop_document_sent ?>)</button>
                <button type="button" data-label_filter="Completed" class="filterlabel btn waves-effect waves-light btn-primary">Completed(<?= $completed ?>)</button>
                <button type="button" class="reset_btn btn waves-effect waves-light btn-success">Reset</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
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
                                    <th>Applicant Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Service Provider</th>
                                    <th>Draft Status</th>
                                    <th>Process</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Deadline</th>
                                    <th>Edit Mode</th>
                                    <th>SOP Document</th>
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
    <!-- Application Details modal content -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="personal_details">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    
    <!-- Send Notifcaion modal content -->                 
    <div  class="modal fade send_notificaion_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Notification To Service Provider </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="send_notification_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <h4>Are you sure you want to send notification to all service providers ?</h4>
                        </div>

                      
                        
                        <div class="form-group col-md-12">
                            <input type="hidden" class="form-control" name="application_id" id="application_id" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light send_notifications">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->
    
     <!-- EDIT  modal content -->                 
    <div  class="modal fade edit_message_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Send Edit Application Message </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="edit_message_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <input type="hidden" class="form-control" name="edit_application_id" id="edit_application_id" value="">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Note</label>
                            <textarea type="text" class="form-control" name="edit_message" id="edit_message" value="" ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light send_edit_message">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.modal -->


    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<script>
    $(document).ready(function() {

        var my_label_filter = "";
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
        });
        ////////////////// FOR DATE ENDS///////////////////
        
        ////////////  Reset btn //////////
        $(".reset_btn").click(function() {
            my_label_filter = "";
            filter_dates = "";
            table.draw();
        });
        ////////////  Reset btn //////////

        ////////////////// FOR LABLE START///////////////////
        $(".filterlabel").click(function() {
            my_label_filter = $(this).attr('data-label_filter');
            table.draw();
        });
        ////////////////// FOR LABLE ENDS///////////////////
     
        
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
                    "url": "<?= base_url() ?>/sopapplications/get_data",
                    "type": 'POST',
                     "data": function(d) {
                            d.label_filter = my_label_filter;
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
                        "data": "application_no"
                    },
                    {
                        "data": "applicant_name"
                    },
                    {
                        "data": "contact"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "service_provider"
                    },
                     {
                        "orderable": false,
                        "data": "draft_status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer">Submitted</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer">In Draft</span></div>';
                            }
                           
                        }
                    },
                    {
                        "data": "application_status"
                    },
                    {
                        "orderable": false,
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer main_status">Inactive</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer main_status">Active</span></div>';
                            }
                           
                        }
                    },
                    {
                        "orderable": false,
                        "data": "payment_status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-danger custom_pointer payment_status">Unpaid</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-success custom_pointer payment_status">Paid</span></div>';
                            }
                           
                        }
                    },
                     {
                        "data": "deadline"
                    },
                    {
                        "orderable": false,
                        "data": "edit_mode",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-secondary custom_pointer edit_mode_status">Disabled</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer edit_mode_status">Enabled</span></div>';
                            }
                           
                        }
                    },
                    {
                        "orderable": false,
                        "data": "sop_application_document",
                        "render": function(data) {
                            
                              var view_doc = "<?= base_url("uploads/sop_documents") ?>/" + data;
                              
                             if (data == null || data == "") {
                                return '<div class="text-center"><span class="badge badge-pill custom_pointer badge-warning">Not Uploaded</span></div>';
                            } else {
                                return '<div class="text-center"><a target="_blank" href="'+view_doc+'" class="text-center">View Doc</a></div>';
                            }
                           
                        }
                    },
                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var conversation = "<?= base_url("sopapplications/conversation") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                            
                            
                                '<a title="View Application" href="javascript:void(0)" class="btn btn-info view">' +
                                '<i class="fa fa-eye"></i>' +
                                '</a>' +
                                
                                
                                '<a title="Send Notification To Service Provider" href="javascript:void(0)" class="btn btn-warning send_notifiaction_link">' +
                                '<i class="fa fa-bell"></i>' +
                                '</a>' +
                                
                                '<a title="View Conversation" target="_blank" href="'+conversation+'" class="btn btn-primary">' +
                                '<i class="fab fa-rocketchat"></i>' +
                                '</a>'  +
                                
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="ti-settings"></i>' +
                            '</button>' +
                                '<div class="dropdown-menu  " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">' +
                                        

                                    '<div class="dropdown-header">Change Application Status</div>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Documents Under Verification" href="javascript:void(0)"> Documents Under Verification</a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Service Provider Assigned" href="javascript:void(0)"> Service Provider Assigned</a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="SOP Document Sent" href="javascript:void(0)"> SOP Document Sent </a>' +
                                    '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Completed" href="javascript:void(0)"> Completed</a>' +
                                '</div>' +
                            '</div>';
                        },
                    },
                ],
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        $(document).on('click', '.view', function() {
            var id = table.row($(this).closest('tr')).data().id;
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/sopapplications/get_application_details",
                data: {
                    'id': id,
                },
                success: function(message) {
                    obj = JSON.parse(message);
                    var status = obj.status;
                    if (status == 0) {
                        alert(obj.message);
                    } else {

                        $('#modal_title').html(obj.modal_title);
                        $('#personal_details').html(obj.personal_details);
                        $(".bs-example-modal-lg").modal('show');
                    }
                },
            });
        })

        $(document).on('click', '.send_notifiaction_link', function() {
            var id = table.row($(this).closest('tr')).data().id;
            $('#application_id').val(id);     
            $(".send_notificaion_modal").modal('show'); 
        })
        
        $(document).on('click', '.send_notifications', function(e) {
            $("#send_notification_form").validate({
                rules: {
                    application_id: {
                        required: true
                    },
                },
        
                submitHandler: function(form) {
                    $.ajax({
                        url: '<?= base_url(); ?>/sopapplications/send_notification_to_service_provider',
                        enctype: 'multipart/form-data',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        type: "POST",
        
                        success: function(message) {
                            // return false;
                            $('.send_notificaion_modal').modal('hide');
                            $('.send_notificaion_modal').find('input').val('');
                            
                            table.draw();
        
                            obj = JSON.parse(message);
                            var status = obj.status;
                            if (status == 0) {
                                toastr.error(obj.message);
                            } else {
                                toastr.success(obj.message);
                            }
                        }
                    });
                }
            });
        });




        setInterval(function() {
            table.draw();
        }, 120000);


        $(document).on('click', '.status', function() {
            var id = $(this).attr('dataid');
            var status = $(this).attr('datastatus');
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/sopapplications/change_application_status",
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
                        table.draw();
                    }
                },
            });
        });
        
        $(document).on('click', '.main_status', function() {
        var id = table.row($(this).closest('tr')).data().id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/sopapplications/change_status/" + id,
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
    
        $(document).on('click', '.payment_status', function() {
        var id = table.row($(this).closest('tr')).data().id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/sopapplications/change_payment_status/" + id,
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
        
    //     $(document).on('click', '.edit_mode_status', function() {
    //     var id = table.row($(this).closest('tr')).data().id;
    //     $.ajax({
    //         method: "POST",
    //         url: "<?= base_url(); ?>/sopapplications/change_edit_mode/" + id,
    //         success: function(message) {
    //             table.draw();
    //             obj = JSON.parse(message);
    //             var status = obj.status;

    //             if (status == 0) {
    //                 toastr.error(obj.message);
    //             } else {
    //                 toastr.success(obj.message);
    //             }
    //         },
    //     });
    // });
    
     $(document).on('click', '.edit_mode_status', function() {

            var id = table.row($(this).closest('tr')).data().id;
            var service_provider_id = table.row($(this).closest('tr')).data().service_provider_id;
            $('#edit_application_id').val(id);     
            $(".edit_message_modal").modal('show'); 
        })
    
    
     $(document).on('click', '.send_edit_message', function(e) {
            $("#edit_message_form").validate({
                rules: {
                    edit_application_id: {
                        required: true
                    },
                    edit_message: {
                        required: true
                    },
                },
        
                submitHandler: function(form) {
                    $.ajax({
                        url: '<?= base_url(); ?>/sopapplications/send_edit_message',
                        enctype: 'multipart/form-data',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        type: "POST",
        
                        success: function(message) {
                            // return false;
                            $('.edit_message_modal').modal('hide');
                            $('.edit_message_modal').find('input').val('');
                            
                            table.draw();
        
                            obj = JSON.parse(message);
                            var status = obj.status;
                            if (status == 0) {
                                toastr.error(obj.message);
                            } else {
                                toastr.success(obj.message);
                            }
                        }
                    });
                }
            });
        });

    });

</script>