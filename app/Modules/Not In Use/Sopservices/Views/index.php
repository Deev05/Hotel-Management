<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();
?> 
			<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="text-left">
                    <button type="submit" class="btn btn-info reorder_button" name="reorder_button">Reorder Services</button>
                </div>
                <br/>
                <!-- Reorder Services modal content -->
                <div id="reorder_model" class="modal fade reorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Reorder Services </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form id="reorder_form" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="myadmin-dd dd" id="nestable">
                                        <ol class="dd-list">


                                            <!-- <li class="dd-item" data-id="1">
                                                <div class="dd-handle"> Item 1 </div>
                                            </li> -->

                                            <?php 	 
                                              
                                                $query = "select * from sop_services where is_deleted = 0 and status = 1 order by orders asc";
                                                $exist = $CommonModel->custome_query($query);
                                                if(!empty($exist))
                                                {
                                                    foreach($exist as $row)
                                                    {
                                            ?>          
                                                        <li class="dd-item" data-id="<?php echo $row->id; ?>">
                                                            <div class="dd-handle"> <?php echo $row->name; ?> </div>
                                                        </li>                                           
                                            <?php
                                                    }
                                                }
                                            ?>
                                          
                                        </ol>
                                    </div>
                                </div>   

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->


                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="card">
                    <div class="card-body">
                    <?php
						$form_location = base_url()."/sopservices/add_sop_service";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Service Name" id="name" name="name" />
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
                                                <th>Service</th>
                                                <th>Image</th>
                                                <th>Order</th>
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
                
                
                    <!-- Edit Service modal content -->
                    <div id="responsive-modal" class="modal fade edit_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_service_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Service Name</label>
                                            <input type="text" class="form-control" name="edit_service_name" id="edit_service_name">
                                        </div>

                                       
                                        <div class="form-group col-md-12 input-group custom-file">
                                            <input type="file" class="custom-file-input" id="edit_service_image" name="edit_service_image">
                                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>  
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <div id="current_image">
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="service_id" id="service_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_service">Save</button>
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
                    "url": "<?= base_url() ?>/sopservices/get_sop_services",
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
                        "data": "image",
                        "orderable": false,
                        "render" : function(data){
                             var image_url = "<?= base_url("uploads/sop_services") ?>/" + data;
                            return '<div class="text-center"><img src="'+image_url+'" height=60%; width="60%"></div>';
                        }
                    },
                    {
                        "data": "order"
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
                            var edit_url = "<?= base_url("sopservices/create") ?>/" + data;
                            
                            return '<div class="btn-group">' +
                                '<a href="javascript:void(0)" class="btn btn-info service_modal">' +
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
            url: "<?= base_url(); ?>/sopservices/change_status/" + id,
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
            url: "<?= base_url(); ?>/sopservices/delete/" + id,
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

				url: '<?php echo base_url(); ?>/sopservices/add_sop_service',

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
    
    $(document).on('click', '.service_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var service_name    = table.row($(this).closest('tr')).data().name;
        var image           = table.row($(this).closest('tr')).data().image;
        var image_url       = '<?php echo base_url(); ?>/uploads/sop_services/'+image;
        
        e.preventDefault();
        $("#current_image").html('<br/><label for="recipient-name" class="control-label">Current Image</label><br/><img height="20%" width="20%" src="' +image_url + '" />');
         
        $('#service_id').val(id);
        $('#edit_service_name').val(service_name);


        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_service', function(e) {
        $("#update_service_form").validate({
            rules: {
                edit_service_name: {
                    required: true
                },
            },

            submitHandler: function(form) {
                $.ajax({
                    url: '<?= base_url(); ?>/sopservices/update_sop_service',
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

    $(document).on('click', '.reorder_button', function(e) {
        $("#reorder_model").modal('show');
    });

        // Nestable
        var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),output = list.data('output');
            
                if (window.JSON) 
                {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                    //alert(output);
                    //var sorted_list = output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                    var sorted_list = list.nestable('serialize');
                    $.ajax({
                                url: '<?= base_url(); ?>/sopservices/reorder_list',
                                enctype: 'multipart/form-data',
                                data: {sorted_list:sorted_list},
                                type: "POST",
                                //dataType: 'JSON',

                                success: function(message) {
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
                else 
                {
                    output.val('JSON browser support required for this demo.');
                }
            };

            $('#nestable').nestable({group: 1}).on('change', updateOutput);

            updateOutput($('#nestable').data('output', $('#nestable-output')));
        
    
                    
});
</script>


       