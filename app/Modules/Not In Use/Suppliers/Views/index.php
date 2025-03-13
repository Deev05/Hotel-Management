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
						$form_location = base_url()."/suppliers/add_supplier";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Full Name" id="name" name="name" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Contact" id="contact" name="contact" />
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <br/>

                                        <div class="row">
                                           

                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Address" id="address" name="address" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="State" id="state" name="state" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="City" id="city" name="city" />
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="GST No." id="gst_no" name="gst_no" />
                                                </div>
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="row mt-3">
                                        
                                             <div class="form-group col-md-3">
                                                <fieldset class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="true"  name="out_of_state" id="out_of_state"> Is Supplier Out Of Bengal(State) ?
                                                    </label>
                                                </fieldset>
                                            </div>
                                           

                                            <div  class="col-md-2">
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
                                                <th>Address</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Gst No</th>
                                                <th>Out Of State ?</th>
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
                
                
                    <!-- Edit Supplier modal content -->
                    <div id="responsive-modal" class="modal fade edit_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_supplier_form" method="POST" enctype="multipart/form-data">
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
                                            <label for="recipient-name" class="control-label">Address</label>
                                            <input type="text" class="form-control" name="edit_address" id="edit_address">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">State</label>
                                            <input type="text" class="form-control" name="edit_state" id="edit_state">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">City</label>
                                            <input type="text" class="form-control" name="edit_city" id="edit_city">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Gst No.</label>
                                            <input type="text" class="form-control" name="edit_gst_no" id="edit_gst_no">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <fieldset class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="true"  name="edit_out_of_state" id="edit_out_of_state"> Is Supplier Out Of Bengal(State) ?
                                                </label>
                                            </fieldset>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="supplier_id" id="supplier_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_supplier">Save</button>
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
                    "url": "<?= base_url() ?>/suppliers/get_suppliers",
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
                        "data": "address"
                    },
                    {
                        "data": "state"
                    },
                    {
                        "data": "city"
                    },
                    {
                        "data": "gst_no"
                    },
                    {
                        "data": "out_of_state"
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
                            var edit_url = "<?= base_url("Suppliers/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info supplier_modal">' +
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
            url: "<?= base_url(); ?>/suppliers/change_status/" + id,
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
            url: "<?= base_url(); ?>/suppliers/delete/" + id,
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
            address: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/suppliers/add_supplier',

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
    
    $(document).on('click', '.supplier_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var name            = table.row($(this).closest('tr')).data().name;
        var email           = table.row($(this).closest('tr')).data().email;
        var contact         = table.row($(this).closest('tr')).data().contact;
        var address         = table.row($(this).closest('tr')).data().address;
        var state           = table.row($(this).closest('tr')).data().state;
        var city            = table.row($(this).closest('tr')).data().city;
        var gst_no          = table.row($(this).closest('tr')).data().gst_no;
        var out_of_state    = table.row($(this).closest('tr')).data().out_of_state;
 
        if (out_of_state == "true")
        {
            $( "#edit_out_of_state").prop('checked', true);
            //$('#edit_out_of_state').val("true");
        }
        else
        {
            $( "#edit_out_of_state").prop('checked', false);
            //$('#edit_out_of_state').val("false");
        }

        e.preventDefault();
         
        $('#supplier_id').val(id);
        $('#edit_full_name').val(name);
        $('#edit_email').val(email);
        $('#edit_contact').val(contact);
        $('#edit_address').val(address);
        $('#edit_state').val(state);
        $('#edit_city').val(city);
        $('#edit_gst_no').val(gst_no);

        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_supplier', function(e) {
    $("#update_supplier_form").validate({
        rules: {
            edit_full_name: {
                required: true
            },
            
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/suppliers/update_supplier',
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
                    
});
</script>


       