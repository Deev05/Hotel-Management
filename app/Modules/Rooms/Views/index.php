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
						$form_location = base_url()."/Rooms/add_rooms";
					?>
                    <form id="add_form" enctype="multipart/form-data" role="form"  action="<?= $form_location ?>" method="POST" >

                            <div class="form-body">
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="Room number" id="room_no" name="room_no" />
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" placeholder="carpet area" id="carpet_area" name="carpet_area" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <select name="room_type" id="room_type" class="form-control">
                                                        <option value="">Select Room type</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $room_types = $CommonModel->get_by_condition("room_types",$filter);

                                                            if(!empty($room_types))
                                                            {
                                                                foreach($room_types as $row)
                                                                {
                                                        ?>
                                                                    <option value="<?php echo $row->id; ?>"><?php echo $row->room_type_name; ?></option>
                                                        <?php
                                                                }    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            
                                            
                                            
                                            
                                        </div>
                                        <br/>
                                        <div class="row">
                                            
                                           

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
                                                <th>Room no</th>
                                                <th>carpet_area</th>
                                                
                                                
                                                <th>Role</th>
                                                
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
                                <form id="update_rooms_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Room number</label>
                                            <input type="text" class="form-control" name="edit_room_no" id="edit_room_no">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label"> Carpet area</label>
                                            <input type="text" class="form-control" name="edit_carpet_area" id="edit_carpet_area" disabled>
                                        </div>

                                        


                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Room type</label>
                                            <select name="edit_room_type" id="edit_room_type" class="form-control">
                                                <option value="">Select Room type</option>
                                                <?php
                                                    $filter = array("status" => 1);
                                                    $room_types = $CommonModel->get_by_condition("room_type",$filter);

                                                    if(!empty($room_types))
                                                    {
                                                        foreach($room_types as $row)
                                                        {
                                                ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->room_type_name; ?></option>
                                                <?php
                                                        }    
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="room_id" id="room_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_rooms">Save</button>
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
                    "url": "<?= base_url() ?>/Rooms/get_rooms",
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
                        "data": "room_no"
                    },
                    {
                        "data": "carpet_area"
                    },
                    
                    {
                        "data": "room_type"
                    },
                   
                    

                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            var edit_url = "<?= base_url("Rooms/create") ?>/" + data;
                            
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
            url: "<?= base_url(); ?>/Rooms/delete/" + id,
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
            room_no: {
                required: true
            },
            carpet_area :{
                required:true
            },
            
            room_type: {
                required: true
            },
            
            
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/Rooms/add_user',

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
    
    $(document).on('click', '.Rooms_modal', function(e) {
        var id              = table.row($(this).closest('tr')).data().id;
        var room_no            = table.row($(this).closest('tr')).data().room_no;
        var carpet_area       = table.row($(this).closest('tr')).data().carpet_area;
        
        var room_type         = table.row($(this).closest('tr')).data().room_type;
 
        e.preventDefault();
         
        $('#room_id').val(id);
        $('#edit_room_no').val(room_no);
        $('#edit_carpet_area').val(carpet_area);
        

        $('#edit_room_type option').filter(function() {
            return this.textContent == room_type
        }).prop('selected', true);

        $("#responsive-modal").modal('show');

    })

    $(document).on('click', '.update_rooms', function(e) {
    $("#update_rooms_form").validate({
        rules: {
            edit_room_no: {
                required: true
            },
            
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?= base_url(); ?>/Rooms/update_user',
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


       