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
						$form_location = base_url()."/sopcountries/add_sop_country";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">


                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Country" id="name" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 input-group custom-file">
                                               
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
                                                <th>Country</th>
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
                
                
                    <!-- Edit Country modal content -->
                    <div id="responsive-modal" class="modal fade edit_sop_country" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_country_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">


                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Country Name</label>
                                            <input type="text" class="form-control" name="edit_name" id="edit_name">
                                        </div>
                                        
                                         <div class="form-group col-md-12 input-group custom-file">
                                            <input type="file" class="custom-file-input" id="edit_country_image" name="edit_country_image">
                                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>  
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <div id="current_image">
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="sop_country_id" id="sop_country_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_country">Save</button>
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
                    "url": "<?= base_url() ?>/sopcountries/get_sop_countries",
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
                        "data": "country_name"
                    },
                    {
                        "data": "image",
                        "orderable": false,
                        "render" : function(data){
                             var image_url = "<?= base_url("uploads/sop_countries") ?>/" + data;
                            return '<div class="text-center"><img src="'+image_url+'" height=60%; width="60%"></div>';
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
                            var edit_url = "<?= base_url("sopcountries/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info country_modal">' +
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
            url: "<?= base_url(); ?>/sopcountries/change_status/" + id,
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
            url: "<?= base_url(); ?>/sopcountries/delete/" + id,
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
          
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/sopcountries/add_sop_country',

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
    
    $(document).on('click', '.country_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var name            = table.row($(this).closest('tr')).data().country_name;
        var image           = table.row($(this).closest('tr')).data().image;
        var image_url       = '<?php echo base_url(); ?>/uploads/sop_countries/'+image;
        
        e.preventDefault();
        $("#current_image").html('<br/><label for="recipient-name" class="control-label">Current Image</label><br/><img height="20%" width="20%" src="' +image_url + '" />');
         
     
        e.preventDefault();
         
        $('#sop_country_id').val(id);
        $('#edit_name').val(name);


        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_country', function(e) {
    $("#update_country_form").validate({
        rules: {
            edit_name: {
                required: true
            },
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/sopcountries/update_sop_country',
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


       