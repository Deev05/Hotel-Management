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
                <div class="card">
                    <div class="card-body">
                    <?php
						$form_location = base_url()."/area/add_area";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <select name="city_id" id="city_id" class="form-control">
                                                        <option value="">Select City</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $city = $CommonModel->get_by_condition("city",$filter);

                                                            if(!empty($city))
                                                            {
                                                                foreach($city as $row)
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

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <select name="pincode_id" id="pincode_id" class="form-control">
                                                        <option value="">Select Pincode</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Area" id="area" name="area" />
                                                </div>
                                            </div>

                                            <div  class="col-md-1">
                                                 <div class="form-actions">
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-info">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  

                                    </div>
                                </div>
                                
                            </div>
   
                        </form>
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
                                                <th>City</th>
                                                <th>Pincode</th>
                                                <th>Area</th>
                                                <th>Status</th>
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
                
                
                    <!-- Edit area modal content -->
                    <div id="responsive-modal" class="modal fade edit_area" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_area_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">City</label>
                                            <select name="edit_city" id="edit_city" class="form-control">
                                                <option value="">Select City</option>
                                                <?php
                                                    $filter = array("status" => 1);
                                                    $city = $CommonModel->get_by_condition("city",$filter);

                                                    if(!empty($city))
                                                    {
                                                        foreach($city as $row)
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
                                            <label for="recipient-name" class="control-label">Pincode</label>
                                            <select name="edit_pincode" id="edit_pincode" class="form-control">
                                                <option value="">Select Pincode</option>
                                               
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Area</label>
                                            <input type="text" class="form-control" name="edit_area" id="edit_area">
                                        </div>

                                      
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="area_id" id="area_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_area">Save</button>
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

                "aaSorting": [ [0,"desc" ]],
                "serverSide": true,
                "processing": true,
                "start": 1,
                "end": 8,
                "pageLength": 10,
                "paging": true,
                "ajax": {
                    "url": "<?= base_url() ?>/area/get_area",
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
                        "data": "city_id"
                    },
                    {
                        "data": "pincode_id"
                    },
                    {
                        "data": "area"
                    },

                    {
                        "orderable": false,
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer status">Inactive</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer status">Active</span></div>';
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
                            var edit_url = "<?= base_url("area/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info area_modal">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>' +
                                '<a href="javascript:void(0)" class="btn btn-danger">' +
                                '<i class="fa fa-trash delete_button"></i>' +
                                '</a>' ;
                        },
                    },
                ],
            });
                    

    $(document).on('click', '.status', function() {
        var id = table.row($(this).closest('tr')).data().id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/area/change_status/" + id,
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

    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/area/delete/" + id,
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

    $('#add_form').validate({ 
        rules: {
            city_id: {
                required: true
            },
            pincode_id:{
                required: true
            },
            area: {
                required: true
            },
          
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/area/add_area',

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
						$('#add_form').trigger("reset");
					    table.draw();
					}
				}               
			});
		}
    });
    
    $(document).on('click', '.area_modal', function(e) {

        e.preventDefault();

        var id              = table.row($(this).closest('tr')).data().id;
        var area            = table.row($(this).closest('tr')).data().area;
        var city_id         = table.row($(this).closest('tr')).data().city_id;
        var select_city_id  = table.row($(this).closest('tr')).data().select_city_id;
        var select_pincode_id  = table.row($(this).closest('tr')).data().select_pincode_id;
        var pincode_id      = table.row($(this).closest('tr')).data().pincode_id;
       
        $.ajax({
            url:"<?= base_url('area/get_pincodes'); ?>",
            method:"POST",
            data:{city_id:select_city_id},
            dataType:"JSON",
            async: "false",
            success:function(data)
            {
                var html = '<option disabled>Select Pincode</option>';
                for(var count = 0; count < data.length; count++)
                {
                    if(data[count]['pincode'] === pincode_id)
                    {
                        html += '<option selected value="'+data[count]['id']+'">'+data[count]['pincode']+'</option>';     
                    }
                    else
                    {
                        html += '<option value="'+data[count]['id']+'">'+data[count]['pincode']+'</option>';     
                    }
                }
                $('#edit_pincode').html(html);
            }
        });
     
 
        $('#area_id').val(id);
        $('#edit_area').val(area);

        $('#edit_city option').filter(function() {
            return this.textContent == city_id
        }).prop('selected', true);

        $('#edit_pincode option').filter(function() {
            return this.textContent == pincode_id
        }).prop('selected', true);

        $("#responsive-modal").modal('show');
        
    })

    $(document).on('click', '.update_area', function(e) {
    $("#update_area_form").validate({
        rules: {
            edit_area: {
                required: true
            },
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/area/update_area',
                enctype: 'multipart/form-data',
                data: new FormData(form),
                processData: false,
                contentType: false,
                type: "POST",

                success: function(message) {
                    // return false;
                    $('#responsive-modal').modal('hide');
                    $('#responsive-modal').find('input').val('');
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


    $('#city_id').change(function(){

        var city_id = $('#city_id').val();

        $.ajax({
            url:"<?= base_url('area/get_pincodes'); ?>",
            method:"POST",
            data:{city_id:city_id},
            dataType:"JSON",
            success:function(data)
            {
                var html = '<option disabled>Select Pincode</option>';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<option value="'+data[count]['id']+'">'+data[count]['pincode']+'</option>';
                }
                $('#pincode_id').html(html);
            }
        });

    });

    $('#edit_city').change(function(){

        var city_id = $('#edit_city').val();

        $.ajax({
            url:"<?= base_url('area/get_pincodes'); ?>",
            method:"POST",
            data:{city_id:city_id},
            dataType:"JSON",
            async: "false",
            success:function(data)
            {
                var html = '<option disabled>Select Pincode</option>';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<option value="'+data[count]['id']+'">'+data[count]['pincode']+'</option>';
                }
                $('#edit_pincode').html(html);
            }
        });

    });
                    
});
</script>


       