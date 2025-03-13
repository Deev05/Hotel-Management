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
						$form_location = base_url()."/serviceproviders/add_service_provider";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Full Name" id="name" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Commission" id="commission" name="commission" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Contact" id="contact" name="contact" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <br/>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input class="form-control" placeholder="Enter pincode" name="pincode" id="pincode" value=""/>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input class="form-control" placeholder="Enter state" name="state" id="state" value="" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                     <input class="form-control" placeholder="Enter city" name="city" id="city" value="" readonly>
                                                </div>
                                            </div>
                                            
                                            <div  class="col-md-3">
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Commission</th>
                                                <th>Pincode</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Status</th>
                                                <th>Logged In</th>
                                                <th>Last Login</th>
                                                <th>Last Login IP</th>
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
                
                
                    <!-- Edit User modal content -->
                    <div id="responsive-modal" class="modal fade edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_user_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Full Name</label>
                                            <input type="text" class="form-control" name="edit_full_name" id="edit_full_name">
                                        </div>

                                       

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Email</label>
                                            <input type="email" class="form-control" name="edit_email" id="edit_email">
                                        </div>
                                        
                                       
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Contact</label>
                                            <input type="text" class="form-control" name="edit_contact" id="edit_contact">
                                        </div>
                                        
                                         <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Commission</label>
                                            <input type="text" class="form-control" name="edit_commission" id="edit_commission">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Pincode</label>
                                            <input type="text" class="form-control" name="edit_pincode" id="edit_pincode">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">State</label>
                                            <input type="text" class="form-control" name="edit_state" id="edit_state" readonly>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">City</label>
                                            <input type="text" class="form-control" name="edit_city" id="edit_city" readonly>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="service_provider_id" id="service_provider_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_user">Save</button>
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
                    "url": "<?= base_url() ?>/serviceproviders/get_service_providers",
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
                        "data": "name"
                    },
                    
                    {
                        "data": "email"
                    },
                    {
                        "data": "contact"
                    },
                    {
                        "data": "commission"
                    },
                    {
                        "data": "pincode"
                    },
                    {
                        "data": "state"
                    },
                    {
                        "data": "city"
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
                        "orderable": false,
                        "data": "logged_in",
                        "render": function(data) {
                            
                             if (data == 1) {
                                return '<div class="text-center"><i class="fa fa-circle text-success m-r-10"></i></div>';
                            } else if (data == 0) {
                                return '<div class="text-center"><i class="fa fa-circle text-default m-r-10"></i></div>';
                            }
                           
                        }
                    },
                    {
                        "data": "last_login"
                    },
                    {
                        "data": "last_login_ip_address"
                    },
                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("serviceproviders/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info user_modal">' +
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
            url: "<?= base_url(); ?>/serviceproviders/change_status/" + id,
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
            url: "<?= base_url(); ?>/serviceproviders/delete/" + id,
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
            name: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            contact: {
                required: true,
                number: true,
				minlength: 10,
				maxlength: 10
            },
            commission: {
                required: true
            },
           pincode: {
                required: true
            },
           
         
            
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/serviceproviders/add_service_provider',

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
						//alert(obj.message);
						$('#add_form').trigger("reset");
					    table.draw();
					}
				}               
			});
		}
    });
    
    $(document).on('click', '.user_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var name            = table.row($(this).closest('tr')).data().name;
        var email           = table.row($(this).closest('tr')).data().email;
        var contact         = table.row($(this).closest('tr')).data().contact;
        var commission            = table.row($(this).closest('tr')).data().commission;
        var pincode            = table.row($(this).closest('tr')).data().pincode;
        var state            = table.row($(this).closest('tr')).data().state;
        var city            = table.row($(this).closest('tr')).data().city;
 
        e.preventDefault();
         
        $('#service_provider_id').val(id);
        $('#edit_full_name').val(name);
        $('#edit_email').val(email);
        $('#edit_contact').val(contact);
        $('#edit_commission').val(commission);
        $('#edit_pincode').val(pincode);
        $('#edit_state').val(state);
        $('#edit_city').val(city);

  
        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_user', function(e) {
        $("#update_user_form").validate({
            rules: {
                edit_full_name: {
                    required: true
                },
                
            },
    
            submitHandler: function(form) {
                $.ajax({
                    url: '<?= base_url(); ?>/serviceproviders/update_service_provider',
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
    
    
      ////CITY STATE////////
    $( "#pincode" ).keyup(function() 
    {
        if($('#pincode').val().length == 6) 
        {
            pincode = $('#pincode').val();
            
            $.ajax({
                    url: "<?php echo base_url(); ?>serviceproviders/get_city_state", 
                    type: "post",
                    data: {
                            "pincode"               : pincode,
                            },
                        	   
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
                    			    state = obj.state;
                    			    city = obj.city;
                    			  
                    			    $('#state').val(state);
                    			    $('#city').val(city);
                    			}
                    		}               
            	});
        } 
    });
    
    
    $( "#edit_pincode" ).keyup(function() 
    {
        if($('#edit_pincode').val().length == 6) 
        {
            pincode = $('#edit_pincode').val();
            
            $.ajax({
                    url: "<?php echo base_url(); ?>serviceproviders/get_city_state", 
                    type: "post",
                    data: {
                            "pincode"               : pincode,
                            },
                        	   
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
                    			    state = obj.state;
                    			    city = obj.city;
                    			  
                    			    $('#edit_state').val(state);
                    			    $('#edit_city').val(city);
                    			}
                    		}               
            	});
        } 
    });
                    
});
</script>


       