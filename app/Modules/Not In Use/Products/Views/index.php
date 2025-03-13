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
                
                <div class="text-left">
                    <button type="submit" class="btn btn-info add_product_button" name="add_product_button">Add Product</button>
                </div>
                <br/>
                                <div class="card">
                    <div class="card-body">
                    <?php
						$form_location = base_url()."/products/import_products";
					?>
                    

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-6">
                                        <form id="import_product_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group mb-0">
                                                        <input type="file" class="form-control" placeholder="Import File" id="file" name="file" />
                                                    </div>
                                                </div>
    
                                                <div  class="col-md-4">
                                                     <div class="form-actions">
                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-info">Import Products</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form id="upload_image" name="upload_image" enctype="multipart/form-data" role="form"  action="<?= base_url()."/products/upload_product_images" ?>" method="POST" >
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group mb-0">
                                                        <input type="file" class="form-control" placeholder="Upload Images" id="product_image" name="product_image[]" multiple />
                                                    </div>
                                                </div>
    
                                                <div  class="col-md-4">
                                                     <div class="form-actions">
                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-info">Upload Product Image</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                
                            </div>
   
                       
                    </div>
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
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Price</th>
                                                <th>Sell Price</th>
                                                <th>Stock</th>
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
                
                <!-- Add Product modal content -->
                <div id="add_product_model" class="modal fade add_product bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Add New Product </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form id="add_product_form" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Category</label>
                                                    <select name="category_id" id="category_id" class="form-control select2" style="height: 36px;width: 100%;">
                                                        <option value="" >Select Category</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $category = $CommonModel->get_by_condition("categories",$filter);

                                                            if(!empty($category))
                                                            {
                                                                foreach($category as $row)
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
                                                    <label for="recipient-name" class="control-label">Product Name</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Code</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="product_code" name="product_code" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="button" id="generate_product_code"><i class=" fas fa-undo"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">HSN Code</label>
                                                    <input type="text" class="form-control" name="hsn_code" id="hsn_code">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Unit</label>
                                                    <select name="unit_id" id="unit_id" class="form-control">
                                                        <option value="">Select Unit</option>
                                                        <?php
                                                            $filter = array("status" => 1,"base_unit" => 0);
                                                            $units = $CommonModel->get_by_condition("units",$filter);

                                                            if(!empty($units))
                                                            {
                                                                foreach($units as $row)
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
                                                    <label for="recipient-name" class="control-label">Per Sell Unit Value</label>
                                                    <input type="text" class="form-control" name="unit_value" id="unit_value">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Price</label>
                                                    <input type="text" class="form-control" name="product_price" id="product_price">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Sell Price</label>
                                                    <input type="text" class="form-control" name="product_sell_price" id="product_sell_price">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="1"  name="is_popular" id="is_popular"> Is Popular Product ?
                                                        </label>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Tax</label>
                                                    <select name="tax_id" id="tax_id" class="form-control">
                                                        <option value="">Select Tax</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $tax = $CommonModel->get_by_condition("tax_rates",$filter);

                                                            if(!empty($tax))
                                                            {
                                                                foreach($tax as $row)
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
                                                    <label for="recipient-name" class="control-label">Quantity Alert</label>
                                                    <input type="text" class="form-control" name="quantity_alert" id="quantity_alert">
                                                </div>


                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Description</label>
                                                    <textarea type="text" class="form-control" name="description" id="description"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Image</label>
                                                    <input type="file" class="form-control" name="product_image" id="product_image">
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Suppliers</label>
                                                    <select  name="suppliers[]" id="suppliers" class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;">
                                                        <option value="" disabled>Select Supplier</option>
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

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Tags</label>
                                                    <input class="form-control col-md-12 tag" type="text" id="tags" name="tags" value="" data-role="tagsinput">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>   

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
                <!-- <div id="responsive-modal" class="modal fade edit_product bs-example-modal-lg"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
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
                </div> -->
                <!-- /Edit Product modal Ends -->

                <!-- View Product modal content -->
                <div id="product_details_modal" class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
            
            
                <!-- /Update Product Price -->
                <div id="update_product_price_modal" class="modal fade edit_product bs-example-modal-lg"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Update Details </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                                <form id="update_price_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body" id="product_update_form_in_models">
                                        <div class="modal-body-inner">
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Price</label>
                                                    <input type="hidden" class="form-control" name="edit_price_product_id" id="edit_price_product_id">
                                                    <input type="text" class="form-control" name="edit_product_price" id="edit_product_price">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Sell Price</label>
                                                    <input type="text" class="form-control" name="edit_product_sell_price" id="edit_product_sell_price">
                                                </div>
                                        </div>                     
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_product_price">Update</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div> 
                <!-- /Update Product Price -->
                
                
                <!-- /Copy Product -->
                <div id="copy_product_modal" class="modal fade edit_product bs-example-modal-lg"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">  </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                                <form id="copy_product_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body" id="product_update_form_in_models">
                                        <div class="modal-body-inner">
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Name</label>
                                                    <input type="hidden" class="form-control" name="copy_product_id" id="copy_product_id">
                                                    <input type="text" class="form-control" name="copy_product_name" id="copy_product_name">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Unit</label>
                                                    <select name="copy_unit_id" id="copy_unit_id" class="form-control">
                                                        <option value="">Select Unit</option>
                                                        <?php
                                                            $filter = array("status" => 1,"base_unit" => 0);
                                                            $units = $CommonModel->get_by_condition("units",$filter);

                                                            if(!empty($units))
                                                            {
                                                                foreach($units as $row)
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
                                                    <label for="recipient-name" class="control-label">Per Sell Unit Value</label>
                                                    <input type="text" class="form-control" name="copy_unit_value" id="copy_unit_value">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Price</label>
                                                    <input type="text" class="form-control" name="copy_product_price" id="copy_product_price">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Product Sell Price</label>
                                                    <input type="text" class="form-control" name="copy_product_sell_price" id="copy_product_sell_price">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="1"  name="copy_is_popular" id="copy_is_popular"> Is Popular Product ?
                                                        </label>
                                                    </fieldset>
                                                </div>
                                        </div>                     
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_product_price">Update</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div> 
                <!-- /Copy Product -->
            
            
            
            
            
            
            
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
                    "url": "<?= base_url() ?>/products/get_products",
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
                        "data": "product_name",
                         "render": function(data) {
                          return  '<i class="fa fa-copy product_copy_icon" data-toggle="tooltip" data-placement="top" title="Copy this product"></i>   ' + data;
                        },
                        
                    },

                    {
                        "data": "product_image",
                        "orderable": false,
                        "render" : function(data){
                                var image_url = "<?= base_url("uploads/products") ?>/" + data;
                            return '<div class="text-center"><img src="'+image_url+'" height=80px;width=80px;></div>';
                        }
                    },

  
                    {
                        "data": "product_price",
                        "render": function(data) {
                          return  '<i class="fa fa-edit product_price_icon" data-toggle="tooltip" data-placement="top" title="Click to update price"></i>  ' + data;
                        },
                    },

                    {
                        "data": "product_sell_price"
                    },

                    {
                        "data": "main_stock"
                    },

                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("products/edit_product") ?>/" + data;
                            var stock_logs_url = "<?= base_url("products/stock_logs") ?>/" + data;
                            var delete_url = "<?= base_url("products/create") ?>/" + data;
                            
                            return '<div class="text-center">' +
                                
                                '<button type="button" class="btn btn-secondary product_details_modal">' +
                                '<i class="fa fa-eye"></i>' +
                                '</button>' +

                                '<a href="'+edit_url+'" class="btn btn-info">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>' +

                                '<a href="'+stock_logs_url+'" class="btn btn-primary">' +
                                '<i class="fa fa-list"></i>' +
                                '</a>' +

                                '<a href="javascript:void(0)" class="btn btn-danger delete_button">' +
                                '<i class="fa fa-trash"></i>' +
                                '</a>' +
                            
                                '</div>';  
                        },
                    },
                ],
    });
    
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

                    
    ///Add Product Form Model Open
    $(document).on('click', '.add_product_button', function(e) {
        
        
        $('#category_id').select2({
            dropdownParent: $('#add_product_model')
        });
        
         $('#suppliers').select2({
            dropdownParent: $('#add_product_model')
        });
        
        $("#add_product_model").modal('show');

    })

    $('#add_product_form').validate({ 
        rules: {
            category_id: {
                required: true
            },
            product_name: {
                required: true
            },
            // product_code: {
            //     required: true
            // },
            // product_unit: {
            //     required: true
            // },
            // product_price: {
            //     required: true
            // },
            // product_sell_price: {
            //     required: true
            // },
            // unit_id: {
            //     required: true
            // },
            // tax_id: {
            //     required: true
            // },
            // quantity_alert: {
            //     required: true
            // },
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/products/add_product',

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
						$('#add_product_model').modal('hide');
						$('#add_product_form').trigger("reset");
			
						
					    table.draw();
					}
				}               
			});
		}
    });


    //View Product Details Starts//
    $(document).on('click', '.product_details_modal', function(e) {
        var id    = table.row($(this).closest('tr')).data().id;
       
        e.preventDefault();

        $.ajax({
                url: '<?= base_url(); ?>/products/get_details_for_view',
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

        $("#product_details_modal").modal('show');

    })
    

    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/products/delete/" + id,
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
        $(this).parent().parent().remove();
    });

    $(document).on('click', '#generate_product_code', function() {
        var random = Math.floor(100000 + Math.random() * 900000);
        $('#product_code').val(random);  
    });
    
    $('#import_product_form').validate({ 
    rules: {
        file: {
            required: true
        },

    },
    
    	submitHandler: function(form) 
    	{
    	    
    	 
        var form_data = new FormData();                  

        var formData = new FormData($("#import_product_form")[0]);

		$.ajax({

			url: '<?php echo base_url(); ?>/products/import_products',

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
					toastr.error(obj.message);
				}
				else
				{
					toastr.success(obj.message);
					$('#import_product_form').trigger("reset");
					//$('#add_product_model').modal('hide');
					//$('#add_product_form').trigger("reset");
		
					
				    table.draw();
				}
			}               
		});
    	}
    });
    
    //Import Product Image
    $('#upload_image').validate({ 
        rules: {
        product_image: {
            required: true
        },

    },
    
    	submitHandler: function(form) 
    	{
    	    
    	 
        var form_data = new FormData();                  

        var formData = new FormData($("#upload_image")[0]);

		$.ajax({

			url: '<?php echo base_url(); ?>/products/upload_product_images',

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
					toastr.error(obj.message);
				}
				else
				{
					toastr.success(obj.message);
					$('#upload_image').trigger("reset");
					//$('#add_product_model').modal('hide');
					//$('#add_product_form').trigger("reset");
		
					
				    table.draw();
				}
			}               
		});
    	}
    });
    
    //Update Product Price Starts
    $(document).on('click', '.product_price_icon', function(e) {
        var id = table.row($(this).closest('tr')).data().id;
        e.preventDefault();
        $.ajax({
                url: '<?= base_url(); ?>/products/get_product_price',
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
                        $('#edit_price_product_id').val(obj.product_id);
                        $('#edit_product_price').val(obj.product_price);
                        $('#edit_product_sell_price').val(obj.product_sell_price);
                       
                    }
                }
            });

        $("#update_product_price_modal").modal('show');

    });
    
    
         $('#update_price_form').validate({ 
            rules: {
            edit_product_price: {
                required: true
            },
             edit_product_sell_price: {
                required: true
            },
    
        },
    
    	submitHandler: function(form) 
    	{
    	  
        var form_data = new FormData();                  

    		$.ajax({
    
    			url: '<?php echo base_url(); ?>/products/update_price',
    
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
    					toastr.error(obj.message);
    				}
    				else
    				{
    					toastr.success(obj.message);
    					$("#update_product_price_modal").modal('hide');
    				    table.draw();
    				}
    			}               
    		});
    	}
    });
    //Update Product Price Ends
    
    //Copy Product Starts
    $(document).on('click', '.product_copy_icon', function(e) {
        var id = table.row($(this).closest('tr')).data().id;
        var product_name = table.row($(this).closest('tr')).data().product_name;
        e.preventDefault();
        $.ajax({
                url: '<?= base_url(); ?>/products/get_product_details_for_copy',
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
                        $('#copy_product_id').val(obj.product_id);
                        var title = "Duplicate of " + product_name;
                        var modal       = $(this);
                    
                        var modal = $(copy_product_modal);
                        modal.find('.modal-title').text(title);
                        modal.modal();
                         
                        $("#copy_product_modal").modal('show');
                    }
                }
            });
    });
    
    
         $('#copy_product_form').validate({ 
            rules: {
            copy_product_name: {
                required: true
            },
            copy_unit_id: {
                required: true
            },
            copy_unit_value: {
                required: true
            },
            copy_product_price: {
                required: true
            },
            copy_product_sell_price: {
                required: true
            },
    
        },
    
    	submitHandler: function(form) 
    	{
    	  
        var form_data = new FormData();                  

    		$.ajax({
    
    			url: '<?php echo base_url(); ?>/products/duplicate_product',
    
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
    					toastr.error(obj.message);
    				}
    				else
    				{
    					toastr.success(obj.message);
    					
    					$("#copy_product_modal").modal('hide');
    					
    					$('#copy_product_form').trigger("reset");
    				    table.draw();
    				}
    			}               
    		});
    	}
    });
                    
});
</script>


       