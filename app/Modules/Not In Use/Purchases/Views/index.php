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
                    <div class="col-12 text-center mb-3">
                        <div class="button-group">
                            <button type="button" data-label_filter="" class="filterlabel btn waves-effect waves-light btn-secondary">All(<?= $all_purchases ?>)</button>
                            
                            <button type="button" data-label_filter="recieved" class="filterlabel btn waves-effect waves-light btn-success">Recieved(<?= $recieved ?>)</button>
                            <button type="button" data-label_filter="ordered" class="filterlabel btn waves-effect waves-light btn-secondary">Ordered(<?= $ordered ?>)</button>
                            <button type="button" data-label_filter="pending" class="filterlabel btn waves-effect waves-light btn-warning">Pending(<?= $pending ?>)</button>
                            
                            <button type="button" data-paymentfilter="1" class="paymentfilter btn waves-effect waves-light btn-info">Paid(<?= $paid ?>)</button>
                            <button type="button" data-paymentfilter="0" class="paymentfilter btn waves-effect waves-light btn-primary">Unpaid(<?= $unpaid ?>)</button>
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
                
                <div class="text-left">
                    <button type="submit" class="btn btn-info add_purchase_button" name="add_purchase_button">Add Purchase</button>
                </div>
                <br/>
               
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
                                                <th>Batch</th>
                                                <th>Referenec No</th>
                                                <th>Warehouse</th>
                                                <th>Purchase Status</th>
                                                <th>Payment Status</th>
                                                <th>SGST</th>
                                                <th>CGST</th>
                                                <th>IGST</th>
                                                <th>Total Tax</th>
                                                <th>Grand Total</th>
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
                
                <!-- Add Purchase modal content -->
                <div id="add_purchase_model" class="modal fade add_purchase bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Add New Purchase </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form id="add_purchase_form" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Batch</label>
                                                    <select name="batch" id="batch" class="form-control">
                                                        <option value="">Select Batch</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $batch = $CommonModel->get_by_condition("batch",$filter);

                                                            if(!empty($batch))
                                                            {
                                                                foreach($batch as $row)
                                                                {
                                                        ?>
                                                                    <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                                        <?php
                                                                }    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Reference No</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="button" id="generate_reference_no"><i class=" fas fa-undo"></i></button>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Status</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="recieved">Recieved</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="ordered">Ordered</option>
                                                      
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Suppliers</label>
                                                    <select  name="supplier_id" id="supplier_id" class="select2 form-control"  style="height: 36px;width: 100%;">
                                                        <option value="">Select Supplier</option>
                                                            <?php
                                                                $filter = array("status" => 1);
                                                                $suppliers = $CommonModel->get_by_condition("suppliers",$filter);

                                                                if(!empty($suppliers))
                                                                {
                                                                    foreach($suppliers as $row)
                                                                    {
                                                            ?>
                                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                            <?php
                                                                    }    
                                                                }
                                                            ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Warehouse</label>
                                                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                                                        <option value="">Select Warehouse</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $warehouse = $CommonModel->get_by_condition("warehouse",$filter);

                                                            if(!empty($warehouse))
                                                            {
                                                                foreach($warehouse as $row)
                                                                {
                                                        ?>
                                                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                        <?php
                                                                }    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Note</label>
                                                    <textarea type="text" class="form-control" name="note" id="note"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Attachment</label>
                                                    <input type="file" class="form-control" name="attachment" id="attachment">
                                                </div>
                                                
                                                <div class="col-12">
                                                    <label for="recipient-name" class="control-label">Purchase Date</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                                        </div>
                                                        <input id="purchase_date" name="purchase_date" type='text' class="form-control purchase_date" value="" />
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-12">
                                                <label for="recipient-name" class="control-label">Product</label>
                                                <select name="product_item" id="product_item" class="form-control select2 product_item" style="height: 36px;width: 100%;">
                                                    <option value="">Select Product</option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-primary" id="puorderitems">
                                                    <thead class="bg-primary text-white">
                                                        <tr>
                                                            <th scope="col">Product Name</th>
                                                            <th scope="col">Expiry</th>
                                                            <th scope="col">Alert B/F Days</th>
                                                            
                                                            <th scope="col">Unit</th>
                                                            <th scope="col">Unit Cost</th>
                                                            <th scope="col">Quantity</th>
                                                            
                                                            <th scope="col">Tax</th>
                                                            <th scope="col">Cost W/o Tax</th>
                                                            <th scope="col">SGST</th>
                                                            <th scope="col">CGST</th>
                                                            <th scope="col">IGST</th>
                                                            <th scope="col">Total Tax</th>
                                                            
                                                            
                                                            <th scope="col">Subtotal</th>
                                                            <th scope="col"><i class="fa fa-times"></i></th>
                                                            <th hidden></th>
                                                            <th hidden></th>
                                                            <th hidden></th>
                                                            <th hidden></th>
                                                            <th hidden></th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ex-products-items">

                                                  
                                                    </tbody>
                                                    <tfoot>
                                                        <th>Total</th>
                                                        <th id="expiry_dates">Expiry</th>
                                                        <th id="">Alert Before Days</th>
                                                        
                                                        <th scope="col">Unit</th>
                                                        <th id="total_net_cost">0.00</th>
                                                        <th id="total_quantity">-</th>
                                                        
                                              
                                                        <th scope="col">Tax</th>
                                                        <th scope="col" id="sub_total_cost_wo_tax">Cost W/o Tax</th>
                                                        <th scope="col" id="sub_total_sgst">SGST</th>
                                                        <th scope="col" id="sub_total_cgst">CGST</th>
                                                        <th scope="col" id="sub_total_igst">IGST</th>
                                                        <th scope="col" id="sub_total_tax">Total Tax</th>
                                                       
                                                        
                                                        <th id="grand_total">0.00</th>
                                                        <th scope="col"></th>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                        <th hidden></th>
                                                        
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                 
                                <input type="hidden" name="total" id="total" value="">
                                <input type="hidden" name="grand_total" id="grand_total_input" value="">
                                <input type="hidden" name="product_discount" id="product_discount_input" value="">
                                <input type="hidden" name="order_discount" id="order_discount_input" value="">
                                <input type="hidden" name="total_discount" id="total_discount_input" value="">
                                <input type="hidden" name="product_tax" id="product_tax_input" value="">
                                <input type="hidden" name="order_tax" id="order_tax_input" value="">
                                <input type="hidden" name="sub_total_tax" id="total_tax_input" value="">
                                <input type="hidden" name="expiry_dates" id="expiry_dates" value="">
                                <input type="hidden" name="total_quantity_input" id="total_quantity_input" value="">
                                <input type="hidden" name="payment_status" id="payment_status" value="">
                                <input type="hidden" name="total_igst" id="total_igst" value="">
                                <input type="hidden" name="total_cgst" id="total_cgst" value="">
                                <input type="hidden" name="total_sgst" id="total_sgst" value="">
                                <input type="hidden" name="total_cost_wo_tax" id="total_cost_wo_tax" value="">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger waves-effect waves-light add_product">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Add Product modal Ends -->
                
                <!-- Edit Product modal content -->
                <div id="responsive-modal" class="modal fade edit_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Update Details </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                                <form id="update_product_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body" id="product_update_form_in_models">
                                        <div class="modal-body-inner"></div>                     
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_product">Save</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- /Edit Product modal Ends -->

                <!-- View Product modal content -->
                <div id="purchase_details_modal" class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title"> Product Details </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body" id="product_details_in_models">
                                <div class="product_details_data"></div>                     
                            </div>
                       
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            </div>
                         
                        </div>
                    </div>
                </div>
                <!-- /View Product modal Ends -->
                

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->         
<script>

$(document).ready(function() {
    
    ///FILTER//
      var my_label_filter       = "";
      var my_payment_filter     = "";
      
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
            my_payment_filter = "";
            filter_dates = "";
            tableChildRows.draw();
        });
        ////////////  Reset btn //////////

        ////////////////// FOR LABLE START///////////////////
        $(".filterlabel").click(function() {
            my_label_filter = $(this).attr('data-label_filter');
            tableChildRows.draw();
        });
        
         $(".paymentfilter").click(function() {
            my_payment_filter = $(this).attr('data-paymentfilter');
            tableChildRows.draw();
        });
        ////////////////// FOR LABLE ENDS///////////////////

        ////////////////// FOR Download Excel Start///////////////////
        $(".downloadexcel").click(function() {
            var get_label_filter = my_label_filter;
            var get_filter_dates = filter_dates;
            var getpaymentfilter = my_payment_filter;
            $.ajax({
                method: "POST",
                url: '<?= base_url() ?>/purchases/download_excel',
                data: {
                    'label_filter': get_label_filter,
                    'filter_dates': get_filter_dates,
                    'payment_filter': getpaymentfilter,
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
    ///FILTER//
    
    $("#product_item").select2({
        dropdownParent: $("#add_purchase_model")
    });

    $("#supplier_id").select2({
        dropdownParent: $("#add_purchase_model")
    });
    
    $('.purchase_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
                format: 'YYYY-MM-DD'
            },
    });
   

            
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
                    "url": "<?= base_url() ?>/purchases/get_purchases",
                    "type": 'POST',
                    "data": function(d) {
                        d.label_filter = my_label_filter;
                        d.payment_filter = my_payment_filter;
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
                        "data": "batch"
                    },

                    {
                        "data": "reference_no"
                    },
                    
                    {
                        "data": "warehouse"
                    },

                    {
                        "orderable": false,
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 'recieved') {
                                return '<div class="text-center"><span class="badge badge-pill badge-success custom_pointer status">Recieved</span></div>';
                            } else if (data == 'pending') {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer status">Pending</span></div>';
                            }
                            else if (data == 'ordered') {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer status">Ordered</span></div>';
                            }
                           
                        }
                    },

                    
                    {
                        "orderable": false,
                        "data": "payment_status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer status">Unpaid</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-success custom_pointer status">Paid</span></div>';
                            }
                           
                        }
                    },
                    
                     {
                        "data": "sgst"
                    },
                     {
                        "data": "cgst"
                    },
                     {
                        "data": "igst"
                    },
                    
                    {
                        "data": "total_tax"
                    },
                    
                    {
                        "data": "grand_total"
                    },

                   

                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("purchase/create") ?>/" + data;
                            var delete_url = "<?= base_url("purchase/delete") ?>/" + data;
                            var invoice_url = "<?= base_url("purchases/purchase_invoice") ?>/" + data;
                            var print = "<?= base_url("purchases/print") ?>/" + data;


                            return '<div class="btn-group">' +

                            '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +

                            '<i class="ti-settings"></i>' +

                            '</button>' +

                             

                         

                            '<div class="dropdown-menu  " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">' +

                            


                            '<a class="dropdown-item purchase_details_modal" href="javascript:void(0)"><i class="fas fa-align-justify"></i> Purchase Details</a>' +
                            
                            '<a class="dropdown-item" href="'+invoice_url+'"><i class="fas fa-copy"></i> Invoice</a>' +
                            
                            '<a class="dropdown-item" href="'+print+'"><i class="fas fa-print"></i> Print Invoice</a>' +



                            '<div class="dropdown-header">Change Purchase Status</div>' +

                            '<a class="dropdown-item custom_pointer purchase_status" dataid="'+data+'" datastatus="pending" href="javascript:void(0)">  Pending</a>' +

                            '<a class="dropdown-item custom_pointer purchase_status" dataid="'+data+'" datastatus="ordered" href="javascript:void(0)"> Orderd</a>' +

                            '<a class="dropdown-item custom_pointer purchase_status" dataid="'+data+'" datastatus="recieved" href="javascript:void(0)">  Recieved</a>' +

                            '<a class="dropdown-item custom_pointer payment_status" dataid="'+data+'" datastatus="0" href="javascript:void(0)">  Payment Pending</a>' +

                            '<a class="dropdown-item custom_pointer payment_status" dataid="'+data+'" datastatus="1" href="javascript:void(0)">  Paid</a>' +

                            '</div>' +

                            

                            '</div>';
                            
         
                        },
                    },
                ],
    });
    
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

                    
    ///Add Purchase Form Model Open
    $(document).on('click', '.add_purchase_button', function(e) {
        
        $("#add_purchase_model").modal('show');

    })

    $('#add_purchase_form').validate({ 
        rules: {
            batch: {
                required: true
            },
            status: {
                required: true
            },
            supplier_id: {
                required: true
            },
            warehouse_id: {
                required: true
            },
            
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/purchases/add_purchase',

				enctype: 'multipart/form-data',
				data:new FormData(form),  
				processData: false,
				contentType: false,
				type: "POST",

				success: function(message) 
				{

					obj = JSON.parse(message);

					var status = obj.status;
					
					if(status == 0)
					{
						alert(obj.message);
					}
					else
					{
						//alert(obj.message);
						$('#add_purchase_form').trigger("reset");
						$("#add_purchase_model").modal('hide');
					    table.draw();
					}
				}               
			});
		}
    });


    //View Product Details Starts//
    $(document).on('click', '.purchase_details_modal', function(e) {
        var id    = table.row($(this).closest('tr')).data().id;
       
        e.preventDefault();

        $.ajax({
                url: '<?= base_url(); ?>/purchases/get_details_for_view',
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
                        
                        $('.product_details_data').html(obj.product_details_in_model);
                       
                    }
                }
            });

        $("#purchase_details_modal").modal('show');

    })
    

    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/purchases/delete/" + id,
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

    $(document).on('click', '#remCF', function() {
        $(this).parent().remove();
        calculate_total();
    });

    $(document).on('click', '#generate_reference_no', function() {
        var random = Math.floor(100000 + Math.random() * 900000);
        $('#reference_no').val(random);  
    });

    //Add Purchase Product Items Starts//
    $('#supplier_id').on('change', function (e) {
       
        var supplier_id = this.value;

        $.ajax({
            url:"<?= base_url('purchases/get_supplier_products'); ?>",
            method:"POST",
            data:{supplier_id:supplier_id},
            dataType:"JSON",
            success:function(data)
            {
                
                var options = '<option value="">Select Product</option>';
                for(var count = 0; count < data.length; count++)
                {
                    options += '<option  value="'+data[count]['id']+'">'+data[count]['product_name']+'</option>';
                }
                $('.product_item').html(options);
            }
        });

       
    });

    $('#product_item').on('change', function (e) {
        var product_id = this.value;

        $.ajax({
            url:"<?= base_url('purchases/get_product_details'); ?>",
            method:"POST",
            data:{product_id:product_id},
            dataType:"JSON",
            success:function(data)
            {
                var product_cost = data.product_cost;

                var tax = product_cost;

                var subtotal = product_cost * 1;
              
                var html =  '<tr>'+   
                                '<td>'+data.product_name+' <input type="hidden" name="puproduct_id[]" value="'+data.id+'" ></td>'+  
                                
                                '<td><input class="form-control puexpiry" type="date" name="puexpiry[]" id="puexpiry"  ></td>'+    
                                '<td><input class="form-control pualbeda" type="text" name="pualbeda[]" id="pualbeda" value="" ></td>'+
                                
                                '<td>'+data.code+' <input type="hidden" name="unitcode[]" value="'+data.code+'" ></td>'+   
                                
                                '<td><input style="width: 95px;" class="form-control pucost" type="text" name="pucost[]" id="pucost" value="" ></td>'+  
                                '<td><input style="width: 95px;" class="form-control puqty" type="text" name="puqty[]" id="puqty" value="1" ></td>'+   
                                  
                                '<td>'+data.tax_rate+'% <input type="hidden" name="unitcode[]" value="'+data.tax_rate+'" ></td>'+
                                
                                '<td><input class="form-control cost_wo_tax" type="hidden" name="cost_wo_tax[]" id="cost_wo_tax" value="" ></td>'+ 
                                
                                '<td><input class="form-control sgst" type="hidden" name="sgst[]" id="sgst" value="" ></td>'+ 
                                '<td><input class="form-control cgst" type="hidden" name="cgst[]" id="cgst" value="" ></td>'+ 
                                '<td><input class="form-control igst" type="hidden" name="igst[]" id="igst" value="" ></td>'+ 
                                '<td><input class="form-control total_tax" type="hidden" name="total_tax[]" id="total_tax" value="" ></td>'+  
                                
                                
                                '<td>'+subtotal+'</td>'+
                                '<td id="remCF"><i class="fa fa-times"></i></td>'+
                                
                                '<td hidden><input class="form-control pusupplierid" type="hidden" name="pusupplierid[]" id="pusupplierid" value="" ></td>'+  
                                
                                '<td hidden><input class="form-control cost_wo_tax" type="hidden" name="cost_wo_tax[]" id="cost_wo_tax" value="" ></td>'+ 
                                '<td hidden><input class="form-control sgst" type="hidden" name="sgst[]" id="sgst" value="" ></td>'+ 
                                '<td hidden><input class="form-control cgst" type="hidden" name="cgst[]" id="cgst" value="" ></td>'+ 
                                '<td hidden><input class="form-control igst" type="hidden" name="igst[]" id="igst" value="" ></td>'+ 
                                '<td hidden><input class="form-control total_tax" type="hidden" name="total_tax[]" id="total_tax" value="" ></td>'+  

                            '</tr>';
                $('#ex-products-items').append(html);   

                calculate_total();
            }
        });
    });

    $(document).on('focusout', '.pucost, .puqty', function() {
     
        var currentRow          =   $(this).closest("tr");

        var product_name        = currentRow.find("td:eq(0)").html();

        var product_id          = currentRow.find("td:eq(0) input").val();
        
        var expiry_date         = currentRow.find("td:eq(1) input").val();
        
        var alert_before_days   = currentRow.find("td:eq(2) input").val();
       
        var product_cost        = currentRow.find("td:eq(4) input").val();
        
        var product_quantity    = currentRow.find("td:eq(5) input").val();
        
        var tax_rate            = currentRow.find("td:eq(6) input").val();
        
        var cost_wo_tax        = currentRow.find("td:eq(7) input").val();
        
        var sgst                = currentRow.find("td:eq(8) input").val();
        
        var cgst                = currentRow.find("td:eq(9) input").val();
        
        var igst                = currentRow.find("td:eq(10) input").val();
        
        var sub_total           = product_cost * product_quantity;
        
        //Check For IGST
        var supplier_id = $('#supplier_id').find(":selected").val();
        
        currentRow.find("td:eq(14) input").val(supplier_id);
        
        var out_of_state = "";
      
        $.ajax({
            url:"<?= base_url('purchases/get_supplier_info'); ?>",
            method:"POST",
            data:{supplier_id:supplier_id},
            dataType:"JSON",
            success:function(data)
            {
                out_of_state = data.out_of_state;
                //out_of_state = "false";

                if(out_of_state == "true")
                {
                    //alert("Calcualte IGST");
                    
                    var cgst_tax_rate = parseFloat(tax_rate)/2;
                    var sgst_tax_rate = parseFloat(tax_rate)/2;
                    
                    var sgst = parseFloat(0);
                    currentRow.find("td:eq(8)").html(sgst);
                    currentRow.find("td:eq(16) input").val(sgst);
                    
                    var cgst = parseFloat(0);
                    currentRow.find("td:eq(9)").html(cgst);
                    currentRow.find("td:eq(17) input").val(cgst);
                    
                    var step1 = parseFloat(sub_total * 100);
                    var step2 = parseFloat(tax_rate)+100;
                  
                    var price_without_gst = parseFloat(step1/step2).toFixed(2);
                    
                    var igst = parseFloat(sub_total - price_without_gst).toFixed(2);
                  
                    currentRow.find("td:eq(10)").html(igst);
                    currentRow.find("td:eq(18) input").val(igst);
                    
                    var total_tax = parseFloat( cgst) + parseFloat(sgst) + parseFloat(igst);
                    
                    currentRow.find("td:eq(11)").html(total_tax);
                    currentRow.find("td:eq(19) input").val(total_tax);
                    
                    currentRow.find("td:eq(7)").html(price_without_gst);
                    currentRow.find("td:eq(15) input").val(price_without_gst);
                    
                    calculate_total();

                }
                else
                {
                    var cgst_tax_rate = parseFloat(tax_rate)/2;
                    var sgst_tax_rate = parseFloat(tax_rate)/2;
                    
                    var step1 = parseFloat(sub_total * 100);
                    var step2 = parseFloat(tax_rate)+100;
                  
                    var price_without_gst = parseFloat(step1/step2).toFixed(2);
                    
                    var total_gst_tax = parseFloat(sub_total - price_without_gst).toFixed(2);
                    
                    var sgst = parseFloat(total_gst_tax/2).toFixed(2);
                    currentRow.find("td:eq(8)").html(sgst);
                    currentRow.find("td:eq(16) input").val(sgst);
                    
                    var cgst = parseFloat(total_gst_tax/2).toFixed(2);
                    currentRow.find("td:eq(9)").html(cgst);
                    currentRow.find("td:eq(17) input").val(cgst);

                    
                    
                    var igst = parseFloat(0);
                    currentRow.find("td:eq(10)").html(igst);
                    currentRow.find("td:eq(18) input").val(igst);
                    
                    var total_tax = parseFloat( cgst) + parseFloat(sgst) + parseFloat(igst);
                    
                    currentRow.find("td:eq(11)").html(total_tax);
                    currentRow.find("td:eq(19) input").val(total_tax);
                    
                    currentRow.find("td:eq(7)").html(price_without_gst);
                    currentRow.find("td:eq(15) input").val(price_without_gst);
                    
                    calculate_total();
                }
            }
        });

       

        
        $('.expiry_date').val(expiry_date)
        //currentRow.find("td:eq(4)").html(expiry_date);
        
        currentRow.find("td:eq(12)").html(sub_total);

        calculate_total();
       
    });

    function calculate_total()
    {
        var items           = 0;
        var sub_total       = 0;
        var sub_net_cost    = 0.00;
        var sub_qty         = 0.00;
        
        var sub_total_tax = 0.00
        
        var total_sgst         = 0.00;
        var total_cgst         = 0.00;
        var total_igst         = 0.00;
        var total_cost_wo_tax         = 0.00;

        $("#puorderitems tbody tr").each(function () {
            var currentRow1         =   $(this).closest("tr");
            
            ++items;

            total_cost_wo_tax += parseFloat(currentRow1.find("td:eq(7)").html());
            total_sgst += parseFloat(currentRow1.find("td:eq(8)").html());
            total_cgst += parseFloat(currentRow1.find("td:eq(9)").html());
            total_igst += parseFloat(currentRow1.find("td:eq(10)").html());
        sub_total_tax += parseFloat(currentRow1.find("td:eq(11)").html());
            sub_total += parseFloat(currentRow1.find("td:eq(12)").html());
            
         sub_net_cost += parseInt(currentRow1.find("td:eq(4) input").val());
            
            

            
        })
        
        var newsub = sub_total.toFixed(2);
  
        $('#total_net_cost').html(sub_net_cost);  
        
        $('#grand_total').html(newsub);
        
        
        
        $('#total_net_cost__input').val(sub_net_cost)
        
        $('#grand_total_input').val(sub_total)
        
        
         var newtotaltax = sub_total_tax.toFixed(2);
         var newigst = total_igst.toFixed(2);
         var newsgst = total_sgst.toFixed(2);
         var newcgst = total_cgst.toFixed(2);
         var new_total_cost_wo_tax = total_cost_wo_tax.toFixed(2);
        
        $('#total_sgst').val(newcgst)
        $('#total_cgst').val(newsgst)
        $('#total_igst').val(newigst)
        $('#total_tax_input').val(newtotaltax);
        $('#total_cost_wo_tax').val(new_total_cost_wo_tax);
       
    }
    //Add Purchase Product Items Ends///


    $(document).on('click', '.purchase_status', function() {
        var id = $(this).attr('dataid');
        var status = $(this).attr('datastatus');


        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/purchases/change_purchase_status/"+ status +"/"+ id,
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

    $(document).on('click', '.payment_status', function() {
        var id = $(this).attr('dataid');
        var status = $(this).attr('datastatus');


        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/purchases/change_payment_status/"+ status +"/"+ id,
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


       