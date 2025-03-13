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
                                    <th>Applicant No</th>
                                    <th>Applicant Name</th>
                                    <th>Process</th>
                                    <th>Deadline</th>
                                    <th>Edit Mode</th>
                                    <th>Status</th>
                                    <th>SOP Document</th>
                                    <th>Created</th>
                                    <th>Modification</th>
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
    
    
    <!-- Upload SOP Doc  modal content -->                 
    <div  class="modal fade upload_doc_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Upload SOP Application Document </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="upload_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <input type="hidden" class="form-control" name="upload_application_id" id="upload_application_id" value="">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Upload SOP Document</label>
                            <input type="file" class="form-control" name="sop_document" id="sop_document" value="" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light upload_application_document">Send</button>
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
                    "url": "<?= base_url() ?>/serviceproviderapplications/get_data",
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
                        "data": "applicant_name"
                    },
                 
                    {
                        "data": "application_status"
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
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning">Inactive</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary">Active</span></div>';
                            }
                           
                        }
                    },
                    {
                        "orderable": false,
                        "data": "sop_application_document",
                        "render": function(data) {
                            
                              var view_doc = "<?= base_url("uploads/sop_documents") ?>/" + data;
                              
                             if (data == null || data == "") {
                                return '<div class="text-center"><span class="badge badge-pill custom_pointer badge-warning upload_doc">Upload</span></div>';
                            } else {
                                return '<div class="text-center"><a target="_blank" href="'+view_doc+'" class="text-center">View Doc</a></div> <br/> <div class="text-center"><span class="badge badge-pill custom_pointer badge-warning upload_doc">Upload</span></div>';
                            }
                           
                        }
                    },
                    {
                        "data": "created"
                    },
                    {
                        "data": "modification_message"
                    },
                    
                    
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                          
                             var conversation = "<?= base_url("serviceproviderapplications/conversation") ?>/" + data;
                            return '<div class="btn-group">' +
                            
                            
                                    '<a title="View Application" href="javascript:void(0)" class="btn btn-info view">' +
                                    '<i class="fa fa-eye"></i>' +
                                    '</a>' +
                                    
                                     '<a title="View Conversation" target="_blank" href="'+conversation+'" class="btn btn-primary">' +
                                    '<i class="fab fa-rocketchat"></i>' +
                                    '</a>' +
                                    
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
                                
                                ;
                        },
                    },
                ],
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        $(document).on('click', '.view', function() {
            var id = table.row($(this).closest('tr')).data().id;
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/serviceproviderapplications/get_application_details",
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
        
        


        setInterval(function() {
            table.draw();
        }, 120000);


    
    
    $(document).on('click', '.upload_doc', function() {

              var id = table.row($(this).closest('tr')).data().id;

            $('#upload_application_id').val(id);     
            $(".upload_doc_modal").modal('show'); 
        })
    
    
    $(document).on('click', '.upload_application_document', function(e) {
            $("#upload_form").validate({
                rules: {
                    upload_application_id: {
                        required: true
                    },
                    sop_document: {
                        required: true
                    },
                },
        
                submitHandler: function(form) {
                    $.ajax({
                        url: '<?= base_url(); ?>/serviceproviderapplications/upload_sop_document',
                        enctype: 'multipart/form-data',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        type: "POST",
        
                        success: function(message) {
                            // return false;
                            $('.upload_doc_modal').modal('hide');
                            $('.upload_doc_modal').find('input').val('');
                            
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
                        url: '<?= base_url(); ?>/serviceproviderapplications/send_edit_message',
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
        
    $(document).on('click', '.status', function() {
            var id = $(this).attr('dataid');
            var status = $(this).attr('datastatus');
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/serviceproviderapplications/change_application_status",
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


    });
        


</script>