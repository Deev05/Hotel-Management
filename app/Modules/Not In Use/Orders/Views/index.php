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
                <button type="button" data-label_filter="" class="filterlabel btn waves-effect waves-light btn-secondary">All(<?= $all_orders ?>)</button>
                <button type="button" data-label_filter="0" class="filterlabel btn waves-effect waves-light btn-warning">Pending(<?= $pending_orders ?>)</button>
                <button type="button" data-label_filter="1" class="filterlabel btn waves-effect waves-light btn-info">Accepted(<?= $accepted_orders ?>)</button>
                <button type="button" data-label_filter="2" class="filterlabel btn waves-effect waves-light btn-info">Processing(<?= $processing_orders ?>)</button>
                <button type="button" data-label_filter="3" class="filterlabel btn waves-effect waves-light btn-primary">Out For Delivery(<?= $outfordelivery_orders ?>)</button>
                <button type="button" data-label_filter="4" class="filterlabel btn waves-effect waves-light btn-success">Delivered(<?= $delivered_orders ?>)</button>
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
                <button id="" type="button" class="btn waves-effect waves-light btn-success downloadexcel">Download Excel</button>
            </div>
        </div>
    </div>
    <!-- Child rows (show extra / detailed information) -->
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
                                    <th>View</th>
                                    <th>User Name</th>
                                    <th>Order No.</th>
                                    <th>Transaction Id</th>
                                    <th>Amount</th>
                                    <th>Payment Type</th>
                                    <th>Order Status</th>
                                    <th>Transaction Status</th>
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
    <!-- sample modal content -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="order_details">
                    </div>
                    
  
                    
                    <div class="row m-t-30">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Item Name</th>
                                            <th>Image</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order_datas">
                                    </tbody>
                                </table>
                            </div>
                        </div>
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



    <!--Stock Info modal content -->
    <div id="stock_info_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="stockhtmldata">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Stock Info modal content -->

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
            tableChildRows.draw();
        });
        ////////////////// FOR DATE ENDS///////////////////
        
        ////////////  Reset btn //////////
        $(".reset_btn").click(function() {
            my_label_filter = "";
            filter_dates = "";
            tableChildRows.draw();
        });
        ////////////  Reset btn //////////

        ////////////////// FOR LABLE START///////////////////
        $(".filterlabel").click(function() {
            my_label_filter = $(this).attr('data-label_filter');
            tableChildRows.draw();
        });
        ////////////////// FOR LABLE ENDS///////////////////

        ////////////////// FOR Download Excel Start///////////////////
        $(".downloadexcel").click(function() {
            var get_label_filter = my_label_filter;
            var get_filter_dates = filter_dates;
            $.ajax({
                method: "POST",
                url: '<?= base_url() ?>/orders/download_excel',
                data: {
                    'label_filter': get_label_filter,
                    'filter_dates': get_filter_dates
                },
                success: function(message) {
                    obj = JSON.parse(message);
                    var status = obj.status;
                    if (status == 0) {
                        return false;
                    } else {window.location.href = obj.download_url;
                    }
                }
            });
        });
        ////////////////// FOR Download Excel End///////////////////

        var tableChildRows = $('.show-child-rows').DataTable({
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
                "url": "<?= base_url() ?>/orders/get_data",
                "type": 'POST',
                "data": function(d) {
                    d.label_filter = my_label_filter;
                    d.filter_dates = filter_dates;
                }
            },
            // "ajax": "<?= base_url() ?>/orders/get_data",
            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": "no",
                    "defaultContent": 'number'
                },
                {
                    "className": 'id',
                    "visible": false,
                    "orderable": true,
                    "data": "id",
                    "defaultContent": '',
                    "render": function(data) {
                        return data;
                    }
                },
                {
                    "orderable": false,
                    "data": "id",
                    "render": function(data) {
                        var url = "<?= base_url() ?>/orders/order_details/" + data;
                        return '<div class="btn-group">' +
                            '<button type="button" class="btn btn-info view">' +
                            '<i class="ti-eye"></i>' +
                            '</button>';
                    },
                },
                {
                    "data": "user_id"
                },
                {
                    "data": "order_no"
                },
                {
                    "data": "transaction_id"
                },
                {
                    "data": "transaction_amount"
                },
                {
                    "orderable": false,
                    "data": "payment_type",
                    "render": function(data) {
                        if (data === 'COD') {
                            return '<center><span class="label label-info font-weight-100"> ' + data + ' </span></center>';
                        } else {
                            return '<center><span class="label label-primary font-weight-100"> ' + data + ' </span></center>';
                        }
                    }
                },
                {
                    "orderable": false,
                    "data": "order_status",
                    "render": function(data) {
                        if (data == 0) 
                        {
                            return '<center><span class="label label-warning font-weight-100"> Pending </span></center>';
                        } 
                        else if (data == 1){ 
                            return '<center><span class="label label-info font-weight-100"> Accepted </span></center>';
                        } else if (data == 2) {
                            return '<center><span class="label label-info font-weight-100"> Processing </span></center>';
                        } else if (data == 3) {
                            return '<center><span class="label label-primary font-weight-100"> OutForDelivery </span></center>';
                        } else if (data == 4) {
                            return '<center><span class="label label-success font-weight-100"> Delivered </span></center>';
                        } else if (data == 5) {
                            return '<center><span class="label label-danger font-weight-100"> Failed </span></center>';
                        }
                    }
                },
                {
                    "orderable": false,
                    "data": "transaction_status",
                    "render": function(data) {
                        if (data == "TXN_SUCCESS") {
                            return '<center><span class="label label-success font-weight-100"> Paid </span></center>';
                        } else if (data == "TXN_FAILED") {
                            return '<center><span class="label label-danger font-weight-100"> Failed </span></center>';
                        } else if (data == "TXN_PENDING") {
                            return '<center><span class="label label-warning font-weight-100"> Pending </span></center>';
                        } else {
                            return '<center><span class="label label-warning font-weight-100"> Pending </span></center>';
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
                        var url = "<?= base_url() ?>/orders/order_details/" + data;
                        return '<div class="btn-group">' +
                            '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="ti-settings"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu  " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">' +
                            '<a class="dropdown-item" href="' + url + '"><i class="fas fa-align-justify"></i> Order Details</a>' +
                            '<div class="dropdown-header">Change Order Status</div>' +
                            '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="0" href="javascript:void(0)"> <i class="fas fa-clock"></i> Pending</a>' +
                            '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="1" href="javascript:void(0)"> <i class="fas fa-check"></i> Accept</a>' +
                            '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="2" href="javascript:void(0)"> <i class="fas fa-spinner"></i> Processing</a>' +
                            '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="3" href="javascript:void(0)"> <i class="fas fa-shipping-fast"></i> Out For Delivery</a>' +
                            '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="4" href="javascript:void(0)"> <i class="fas fa-truck"></i> Delivered</a>' +
                            '<a class="dropdown-item custom_pointer paid" dataid="'+data+'"  href="javascript:void(0)"> <i class="fas fa-check"></i> Paid</a>' +
                            '</div>' +
                            '</div>';
                    },
                },
            ],
        });

        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        /////////////////// Important Example For Get Value From DataTable ////////////////////////
        // $('.show-child-rows tbody').on('click', '.view', function() {
        //     var row = $(this).closest('tr');
        //     var data = tableChildRows.row($(this).closest('tr')).data().id ;
        //     alert(data);
        //     console.log(data);
        // });

        $(document).on('click', '.view', function() {
            var id = tableChildRows.row($(this).closest('tr')).data().id;
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/orders/get_order_data",
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
                        $('#order_details').html(obj.order_details);
                        $('#order_datas').html(obj.table_data);
                        $(".bs-example-modal-lg").modal('show');
                    }
                },
            });
        })


            setInterval(function() {

                my_label_filter = "";

                filter_dates = "";

                tableChildRows.draw();

            }, 120000);


        $(document).on('click', '.status', function() {
            var id = $(this).attr('dataid');
            var status = $(this).attr('datastatus');

    
            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/orders/change_order_status/"+ status +"/"+ id,
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
        
        $(document).on('click', '.paid', function() {
            var id = $(this).attr('dataid');
                       $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/orders/change_transaction_status/" + id,
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


        $(document).on('click', '#stock_info_button', function() {
            var id = $(this).attr('data-orderid');

            $.ajax({
                method: "POST",
                url: "<?= base_url(); ?>/orders/get_item_stock_details/" + id,
                success: function(message) {
                    table.draw();
                    obj = JSON.parse(message);
                    var status = obj.status;

                    if (status == 0) {
                        toastr.error(obj.message);
                    } else {
                        
                        $('#stockhtmldata').html(obj.stock_data);
                       
                    }
                },
            });

            $('#stock_info_modal').modal('show');
           
        });
        


    $(document).on('submit', '#stock_update_form', function(e) 
    {
        e.preventDefault();
    
        var form = $(this);
        var actionUrl = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), 
            success: function(message)
            {
                obj = message;
        
    			var status = obj.status;
    			
    			if(status == 0)
    			{
    				 toastr.error(obj.message);
    			}
    			else
    			{
    				toastr.success(obj.message);
    				$('#stock_update_form').trigger("reset");
    				$('#stock_info_modal').modal('hide');
    				$(".bs-example-modal-lg").modal('hide');
    			    table.draw();
    			}
            }
        });
    });


          
           
      

    });

</script>