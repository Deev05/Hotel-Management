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
						$form_location = base_url()."/permissions/add_permission";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Title" id="title" name="title" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Code" id="code" name="code" />
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
                                                <th>Title</th>
                                                <th>Code</th>
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
                
                
                    <!-- Edit Permission modal content -->
                    <div id="responsive-modal" class="modal fade edit_permission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_permission_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Title</label>
                                            <input type="text" class="form-control" name="edit_title" id="edit_title">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Code</label>
                                            <input type="text" class="form-control" name="edit_code" id="edit_code">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="permission_id" id="permission_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_permission">Save</button>
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
                    "url": "<?= base_url() ?>/permissions/get_permissions",
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
                        "data": "title"
                    },
                    {
                        "data": "code"
                    },
                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("permissions/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info permission_modal">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>' +
                                '<a href="javascript:void(0)" class="btn btn-danger">' +
                                '<i class="fa fa-trash delete_button"></i>' +
                                '</a>' ;
                        },
                    },
                ],
            });
                    


    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/permissions/delete/" + id,
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
            title: {
                required: true
            },
            code: {
                required: true
            },
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/permissions/add_permission',

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
    
    $(document).on('click', '.permission_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var title    = table.row($(this).closest('tr')).data().title;
        var code    = table.row($(this).closest('tr')).data().code;
     
        e.preventDefault();
         
        $('#permission_id').val(id);
        $('#edit_title').val(title);
        $('#edit_code').val(code);
        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_permission', function(e) {
    $("#update_permission_form").validate({
        rules: {
            edit_title: {
                required: true
            },
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/permissions/update_permission',
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


       