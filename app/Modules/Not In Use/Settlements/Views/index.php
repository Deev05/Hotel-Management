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
                                    <th>Process</th>
                                    <th>Payment Status</th>
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
                    <h4 class="modal-title"> Summary Of Settlement </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="send_notification_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <input type="hidden" class="form-control" name="application_id" id="application_id" value="">
                            <input type="hidden" class="form-control" name="service_provider_id" id="service_provider_id" value="">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Service Provider Partnership Rate</label>
                            <input type="text" class="form-control" name="commission_rate" id="commission_rate" value="" readonly>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Package Price</label>
                            <input type="text" class="form-control" name="package_price" id="package_price" value="" readonly>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Fees/Charges</label>
                            <input type="text" class="form-control" name="fees" id="fees" value="" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Final Amount To Pay Service Provider</label>
                            <input type="text" class="form-control" name="final_amount" id="final_amount" value="" readonly>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Final Amount To Pay Service Provider</label>
                            <select name="payment_mode" id="payment_mode" class="form-control">
                                <option value="">Please choose Payment Mode</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Bank NEFT">Bank NEFT</option>
                                <option value="Bank IMPS">Bank IMPS</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Transaction Id/Reference Id</label>
                            <input type="text" class="form-control" name="transaction_id" id="transaction_id" value="">
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
                    "url": "<?= base_url() ?>/settlements/get_data",
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
                        "data": "application_status"
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
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("coupons/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                            
                            
                                '<a title="View Application" href="javascript:void(0)" class="btn btn-secondary view">' +
                                '<i class="fa fa-eye"></i>' +
                                '</a>' +
                                
                                
                                '<a title="Payment To Service Provider" href="javascript:void(0)" class="btn btn-success send_notifiaction_link">' +
                                '<i class="fa fa-check"></i>' +
                                '</a>';
                                
                                
                        },
                    },
                ],
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        $(document).on('click', '.view', function() {
            var id = table.row($(this).closest('tr')).data().id;
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/settlements/get_application_details",
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
            var service_provider_id = table.row($(this).closest('tr')).data().service_provider_id;
            var package_price = table.row($(this).closest('tr')).data().package_price;
            var commission_rate = table.row($(this).closest('tr')).data().commission_rate;
            var fees = table.row($(this).closest('tr')).data().fees;
            var final_amount = table.row($(this).closest('tr')).data().final_amount;
            
            
            $('#application_id').val(id);     
            $('#service_provider_id').val(service_provider_id);     
            $('#package_price').val(package_price);     
            $('#commission_rate').val(commission_rate);     
            $('#fees').val(fees);     
            $('#final_amount').val(final_amount);     
            
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
                        url: '<?= base_url(); ?>/settlements/make_payment_to_service_provider',
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

    });

</script>