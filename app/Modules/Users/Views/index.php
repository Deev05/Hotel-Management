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
						$form_location = base_url()."/users/add_user";
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
                                                    <input type="text" class="form-control" placeholder="Username" id="user_name" name="user_name" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <select name="role" id="role" class="form-control">
                                                        <option value="">Select Role</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $roles = $CommonModel->get_by_condition("roles",$filter);

                                                            if(!empty($roles))
                                                            {
                                                                foreach($roles as $row)
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
                                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" />
                                                </div>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Contact" id="contact" name="contact" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password" />
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
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Role</th>
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
                                            <label for="recipient-name" class="control-label"> Username</label>
                                            <input type="text" class="form-control" name="edit_user_name" id="edit_user_name" disabled>
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
                                            <label for="recipient-name" class="control-label">Role</label>
                                            <select name="edit_role" id="edit_role" class="form-control">
                                                <option value="">Select Role</option>
                                                <?php
                                                    $filter = array("status" => 1);
                                                    $roles = $CommonModel->get_by_condition("roles",$filter);

                                                    if(!empty($roles))
                                                    {
                                                        foreach($roles as $row)
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
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="">
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
                    "url": "<?= base_url() ?>/users/get_users",
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
                        "data": "user_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "contact"
                    },
                    {
                        "data": "role"
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
                            var edit_url = "<?= base_url("users/create") ?>/" + data;
                            
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
            url: "<?= base_url(); ?>/users/change_status/" + id,
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
            url: "<?= base_url(); ?>/users/delete/" + id,
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
            role: {
                required: true
            },
            password: {
                required: true
            },
            user_name: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
                
            },
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/users/add_user',

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
        var user_name       = table.row($(this).closest('tr')).data().user_name;
        var email           = table.row($(this).closest('tr')).data().email;
        var contact         = table.row($(this).closest('tr')).data().contact;
        var role            = table.row($(this).closest('tr')).data().role;
 
        e.preventDefault();
         
        $('#user_id').val(id);
        $('#edit_full_name').val(name);
        $('#edit_user_name').val(user_name);
        $('#edit_email').val(email);
        $('#edit_contact').val(contact);

        $('#edit_role option').filter(function() {
            return this.textContent == role
        }).prop('selected', true);

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
                url: '<?= base_url(); ?>/users/update_user',
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


       