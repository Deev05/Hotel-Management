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
                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                    <!-- ============================================================== -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <?php

                                    $action = base_url('/products/create/'.$product_id);

                                ?>
                                <form class="m-t-25" id="form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">

                                    <input type="hidden" name="product_id" id="product_id" class="form-control" value="<?= $product_details->id ?>">

                                    <div class="form-group col-md-12">
                                        <label>Select Category</label> <br>
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="category_id" id="category_id">
                                            <option disabled selected>Select</option>
                                        <?php 
     	                                    $CommonModel = new CommonModel();
                                            $filter = array("is_deleted" => 0);
                                             $category   = $CommonModel->get_by_condition('categories', $filter);                                            
                                            foreach($category as $row):
                                        ?>
                                                <option value="<?= $row->id ?>" <?php if($row->id == $product_details->category_id) { echo 'selected';} ?>><?= $row->name ?></option>
                                        <?php
                                            endforeach
                                        ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group col-md-12">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" value="<?= $product_details->product_name ?>">
                                       
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>HSN Code</label>
                                        <input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?= $product_details->hsn_code ?>">
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
                                                        <option value="<?php echo $row->id; ?>" <?php if($row->id == $product_details->unit_id) { echo 'selected';} ?> ><?php echo $row->name; ?></option>
                                            <?php
                                                    }    
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Per Sell Unit Value</label>
                                        <input type="text" class="form-control" name="unit_value" id="unit_value" value="<?= $product_details->unit_value ?>">
                                    </div>
 

                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Product Price</label>
                                        <input type="text" class="form-control" name="product_price" id="product_price" value="<?= $product_details->product_price ?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Product Sell Price</label>
                                        <input type="text" class="form-control" name="product_sell_price" id="product_sell_price" value="<?= $product_details->product_sell_price ?>">
                                    </div>


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
                                                        <option value="<?php echo $row->id; ?>" <?php if($row->id == $product_details->tax_id) { echo 'selected';} ?>><?php echo $row->name; ?></option>
                                            <?php
                                                    }    
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Quantity Alert</label>
                                        <input type="text" class="form-control" name="quantity_alert" id="quantity_alert" value="<?= $product_details->quantity_alert ?>">
                                    </div>



                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Product Description</label>
                                        <textarea type="text" class="form-control" name="description" id="description"><?= $product_details->description ?></textarea>
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
                                                        $s="";
                                                        foreach($suppliers as $row)
                                                        {

                                                            $suppliers_array = explode(',',$product_details->suppliers);
                                                           

                                                            if (in_array($row->id, $suppliers_array)) {$s = "selected";}
                                                ?>
                                                            <option value="<?php echo $row->id; ?>" <?php echo $s; ?>><?php echo $row->name; ?></option>
                                                <?php
                                                            $s = "";
                                                        }    
                                                    }
                                                ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group col-md-12">
                                        <label>Product Image</label>
                                        <input type="file" class="form-control" id="product_image" name="product_image">
                                    </div>
                                    
                                     
                                    <?php
                                        if($product_details->product_image)
                                        {
                                    ?>
                                    
                                    <div class="form-group col-md-12">
                                        <label>Current Image</label>
                                        <div class="el-card-avatar el-overlay-1 mb-2 ml-2"> 
                                            <img src="<?=base_url()?>/uploads/products/<?= $product_details->product_image; ?>" height="85px" width="95px" alt="Image" />
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    

                                    

                                    <div class="form-group col-md-12">
                                        <label>Tags</label> <br>
                                        <input class="form-control col-md-12 tag" type="text" id="tags" name="tags" value="<?= $product_details->tags ?>" data-role="tagsinput">
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <fieldset class="checkbox">
                                            <label>
                                                <input type="checkbox" value="1" <?php if($product_details->is_popular == 1) { echo "checked"; } ?>  name="is_popular" id="is_popular"> Is Popular Product ?
                                            </label>
                                        </fieldset>
                                    </div>
                                    
                                    
                                
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                    <!-- ============================================================== -->

                    
                            <div class="col-md-6">
                                
       

                                
                                <!-- ============================================================== -->
                                <!-- card no. 2 -->
                                <!-- ============================================================== -->

                                
                                

                                <!-- ============================================================== -->
                                <!-- End card no. 2 -->
                                <!-- ============================================================== -->
                                
                                

                            </div>




                    <!-- ============================================================== -->
                    <!-- col no. 2 -->
                    <!-- ============================================================== -->

                   

                    <!-- ============================================================== -->
                    <!-- End col no. 2 -->
                    <!-- ============================================================== -->

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



    $('#form').validate({ 
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
   
            var formData = new FormData($("#form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/products/update_product/',

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
                        location.reload();
					}
				}               
			});
		}
    });


    $('#product_option_form').validate({ 
        rules: {
            product_unit_id: {
                required: true
            },
        },

		submitHandler: function(form) 
		{
            var form_data = new FormData();                  
            var formData = new FormData($("#product_option_form")[0]);
			$.ajax({
				url: '<?php echo base_url(); ?>/products/add_product_option/',
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
                        $("#product_option_form")[0].reset();
						location.reload();
					}
				}               
			});
		}
    });

    $(document).on('click', '.delete_button', function() {
        var id = $(this).attr("data-deleteid")

        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/products/delete_product_option/" + id,
            success: function(message) {
                table.draw();
                obj = JSON.parse(message);
                var status = obj.status;

                if (status == 0) {
                    toastr.error(obj.message);
                } else {
                    toastr.success(obj.message);
                    location.reload();
                }
            },
        });
    });


    $(document).on('click', '.status', function() {
        var id = $(this).attr("data-statusid")
  
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/products/change_product_option_status/" + id,
            success: function(message) {
                table.draw();
                obj = JSON.parse(message);
                var status = obj.status;

                if (status == 0) {
                    toastr.error(obj.message);
                } else {
                    toastr.success(obj.message);
                    location.reload();
                }
            },
        });
    })

                    
});
</script>


       