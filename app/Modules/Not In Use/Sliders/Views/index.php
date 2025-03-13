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
						$form_location = base_url()."/sliders/add_slider";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                        
                                             <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="Top">Top</option>
                                                        <option value="Bottom">Bottom</option>
                                                        <option value="Promo">Promo</option>
                                                    </select>
                                                </div> 
                                            </div>
                                            
                                               
                                            
                                            <div class="col-md-3 input-group custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
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
                                                <th>Type</th>
                                                <th>Image</th>
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
                
                
                    <!-- Edit Category modal content -->
                    <div id="responsive-modal" class="modal fade edit_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_slider_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                       

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Type</label>
                                            <select name="edit_type" id="edit_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="Top">Top</option>
                                                <option value="Bottom">Bottom</option>
                                                <option value="Promo">Promo</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-12 input-group custom-file">
                                            <input type="file" class="custom-file-input" id="edit_slider_image" name="edit_slider_image">
                                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>  
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <div id="current_image">
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="slider_id" id="slider_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_slider">Save</button>
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
                    "url": "<?= base_url() ?>/sliders/get_sliders",
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
                        "data": "type"
                    },
                    {
                        "data": "image",
                        "orderable": false,
                        "render" : function(data){
                             var image_url = "<?= base_url("uploads/sliders") ?>/" + data;
                            return '<div class="text-center"><img src="'+image_url+'" height=80%; width="80%"></div>';
                        }
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
                            var edit_url = "<?= base_url("sliders/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info slider_modal">' +
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
            url: "<?= base_url(); ?>/sliders/change_status/" + id,
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
            url: "<?= base_url(); ?>/sliders/delete/" + id,
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
            image: {
                required: true
            },
            
        },

		submitHandler: function(form) 
		{
		    
		    var file_data = $('#image').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/sliders/add_slider',

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
						$('#add_form').trigger("reset");
					    table.draw();
					}
				}               
			});
		}
    });
    
    $(document).on('click', '.slider_modal', function(e) {
        var id                  = table.row($(this).closest('tr')).data().id;
        var type           = table.row($(this).closest('tr')).data().type;
        var image               = table.row($(this).closest('tr')).data().image;
        var image_url           = '<?php echo base_url(); ?>/uploads/sliders/'+image;
     
        
        e.preventDefault();
        $("#current_image").html('<br/><label for="recipient-name" class="control-label">Current Image</label><br/><img height="20%" width="20%" src="' +image_url + '" />');
         
        $('#slider_id').val(id);
        

        
         $('#edit_type option').filter(function() {
            return this.textContent == type
        }).prop('selected', true);

        

        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_slider', function(e) {
        $("#update_slider_form").validate({
           

            submitHandler: function(form) {
                $.ajax({
                    url: '<?= base_url(); ?>/sliders/update_slider',
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


       