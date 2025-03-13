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
						$form_location = base_url()."/warehouse/add_warehouse";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Warehouse Name" id="name" name="name" />
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
                                            <div class="col-md-5">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Address Line One" id="address_line_one" name="address_line_one" />
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Address Line Two" id="address_line_two" name="address_line_two" />
                                                </div>
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
                                                <th>Address Line 1</th>
                                                <th>Address Line 2</th>
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
                
                
                    <!-- Edit Warehouse modal content -->
                    <div id="responsive-modal" class="modal fade edit_warehouse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_warehouse_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Warehouse Name</label>
                                            <input type="text" class="form-control" name="edit_warehouse_name" id="edit_warehouse_name">
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
                                            <label for="recipient-name" class="control-label">Address Line One</label>
                                            <input type="text" class="form-control" name="edit_address_line_one" id="edit_address_line_one">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Address Line Two</label>
                                            <input type="text" class="form-control" name="edit_address_line_two" id="edit_address_line_two">
                                        </div>
                                      
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="warehouse_id" id="warehouse_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_warehouse">Save</button>
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
                    "url": "<?= base_url() ?>/warehouse/get_warehouse",
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
                        "data": "address_line_one"
                    },
                    {
                        "data": "address_line_two"
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
                            var edit_url = "<?= base_url("warehouse/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info warehouse_modal">' +
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
            url: "<?= base_url(); ?>/warehouse/change_status/" + id,
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
            url: "<?= base_url(); ?>/warehouse/delete/" + id,
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
                required: true
            },
            contact: {
                required: true
            },
            address_line_one: {
                required: true
            },
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/warehouse/add_warehouse',

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
    
    $(document).on('click', '.warehouse_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var warehouse_name    = table.row($(this).closest('tr')).data().name;
        var email    = table.row($(this).closest('tr')).data().email;
        var contact    = table.row($(this).closest('tr')).data().contact;
        var address_line_one    = table.row($(this).closest('tr')).data().address_line_one;
        var address_line_two    = table.row($(this).closest('tr')).data().address_line_two;
       
        
        e.preventDefault();
         
        $('#warehouse_id').val(id);
        $('#edit_warehouse_name').val(warehouse_name);
        $('#edit_email').val(email);
        $('#edit_contact').val(contact);
        $('#edit_address_line_one').val(address_line_one);
        $('#edit_address_line_two').val(address_line_two);
        

        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_warehouse', function(e) {
    $("#update_warehouse_form").validate({
        rules: {
            edit_warehouse_name: {
                required: true
            },
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/warehouse/update_warehouse',
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


       