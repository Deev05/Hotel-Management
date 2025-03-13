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
                    <button type="submit" class="btn btn-info add_role_button" name="add_role_button">Add Role</button>
                </div>
                <br/>
                <!-- Add Role modal content -->
                <div id="add_role_model" class="modal fade add_role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Add New Role </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form id="add_role_form" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                
                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="control-label">Permissions</label>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>Name</th>
                                                <th class="text-center" width="50"><input type="checkbox" class="check-select-all-p"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                        
                                                        <?php 	 
                                                            $exist = $CommonModel->get_all_data('permissions');
                                                            if(!empty($exist))
                                                            {
                                                                foreach($exist as $row)
                                                                {
                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo $row->title; ?></td>
                                                                        <td width="50" class="text-center"><input type="checkbox" class="check-select-p" name="permission[]" value="<?php echo $row->code ?>"></td>
                                                                    </tr>
                                                                                                
                                                                                                            
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger waves-effect waves-light add_role">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->
    
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
                                                <th>Title</th>
                                      
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
                
                
                <!-- Edit Role modal content -->
                <div id="responsive-modal" class="modal fade edit_role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Update Details </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                                <form id="update_role_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body" id="role_update_form_in_models">
                                    <div class="modal-body-inner"></div>                     
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_role">Save</button>
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

    $('.check-select-all-p').on('change', function() {

        $('.check-select-p').attr('checked', $(this).is(':checked'));

    })

    $(document).on('change', '.edit-check-select-all-p', function() { 
    //$('.edit-check-select-all-p').on('change', function() {
        $('.edit-check-select-p').attr('checked', $(this).is(':checked'));

    })
            
    var table = $('.show-child-rows').DataTable({

                "aaSorting": [ [0,"desc" ]],
                "serverSide": true,
                "processing": true,
                "start": 1,
                "end": 8,
                "pageLength": 10,
                "paging": true,
                "ajax": {
                    "url": "<?= base_url() ?>/roles/get_roles",
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
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("roles/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info role_modal">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>'  ;
                        },
                    },
                ],
            });
                    


    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/roles/delete/" + id,
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


    ///Add Role Form Model Open
    $(document).on('click', '.add_role_button', function(e) {
        
        $("#add_role_model").modal('show');

    })

    $('#add_role_form').validate({ 
        rules: {
            name: {
                required: true
            },
            permission: {
                required: true
            },
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/roles/add_role',

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
						$('#add_role_form').trigger("reset");
						$('#add_role_model').modal('hide');
					    table.draw();
					}
				}               
			});
		}
    });
    
    $(document).on('click', '.role_modal', function(e) {
        var id    = table.row($(this).closest('tr')).data().id;

        e.preventDefault();

        $.ajax({
                url: '<?= base_url(); ?>/roles/get_details_for_update',
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
                        
                        $('.modal-body-inner').html(obj.role_update_form_in_model);
                       
                    }
                }
            });

        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_role', function(e) {
    $("#update_role_form").validate({
        rules: {
            edit_name: {
                required: true
            },
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/roles/update_role',
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


       