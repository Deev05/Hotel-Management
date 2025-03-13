
<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();
?>




<div class="container-fluid">

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                <form style="width: 100%; display:flex;" id="update_task_form" method="POST" enctype="multipart/form-data" action="">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                
                                    <div class="modal-body">
                                        <div class="form-group col-md-12">
                                            
                                            <select multiple="multiple" name="edit_room_id[]" id="edit_room_id" class="form-control select2" style="width:100%;">
                                                    <option value="">Select Room no</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $rooms = $CommonModel->get_by_condition("rooms",$filter);


                                                            if(!empty($rooms))
                                                            {
                                                            foreach($rooms as $row)
                                                            {
                                                        ?>
                                                        <option <?php if($task_details->room_id == $row->id){ echo "selected"; } ?> value="<?php echo $row->id; ?>"><?php echo $row->room_no; ?></option>
                                                        <?php
                                                                
                                                        }
                                                    }
                                                        ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-12">
                                        <label>Task type</label> <br>
                                                <select value="<?php $task_type ?>" name="edit_task_type" id="edit_task_type" class="form-control">
                                                    <option value="<?php $task_type ?>">Select Task type</option>
                                                        
                                                        <option <?php if($task_details->task_type=="individual"){ echo "selected"; } ?> value="individual">Individual</option>
                                                        <option <?php if($task_details->task_type=="dynamic"){ echo "selected"; } ?> value="dynamic">Dynamic</option>
                                                       
                                                </select>
                                        </div>

                                        


                                        <div class="form-group col-md-12">
                                            
                                            <label>Task Name</label> <br>
                                            <input class="form-control col-md-12 tag" type="text" id="edit_task_name" name="edit_task_name" value="<?php echo $task_details->task_name?>" >
                                        </div>

                                        <div class="form-group col-md-12">
                                        <label>Select user</label> <br>
                                                <select name="edit_user_id" id="edit_user_id" class="form-control select2" style="width:100%;">
                                                    <option value="<?php ?>">Select user</option>
                                                        <?php
                                                            $query = "SELECT * FROM user WHERE role = 6 or role = 7 or role = 8";
                                                       
                                                            $users = $CommonModel->custome_query($query);


                                                            if(!empty($users))
                                                            {
                                                            foreach($users as $row)
                                                            {
                                                        ?>
                                                        <option <?php if($task_details->assigned_to==$row->id){ echo "selected"; } ?>  value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                        <?php
                                                            }    
                                                        }
                                                        ?>
                                                </select>
                                        </div>


                                        <div class="form-group col-md-12" style="display:flex;flex-direction:column;">
                                            
                                            <label>Task Description</label>
                                            <textarea name="edit_description" id="edit_description" rows="3" class="form-control" placeholder="" value="<?php echo $task_details->description?>"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="task_id" id="task_id" value="<?php $update_id ?>">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><a style="color: white; text-decoration:none" href="<?= base_url('/Task'); ?>">Close</a></button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_rooms"><i class="fa fa-check"></i> Save</button>
                                    </div>

                                
                            </div>
                        </div>
                    </div>




                    <div class="col-md-6 hiddenForm" style="display:block">
                        <div class="sub-tasks"><h4>Update Sub Tasks</h4></div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 form_field_outer p-0">
                                    <?php 
                                    if(!empty($task_details->sub_task)){
                                        foreach( json_decode($task_details->sub_task) as $index => $row )
                                        { 
                                            ?>

                                        <div class="row form_field_outer_row">
                                                <div class="form-group col-md-10">
                                                    <label class="col-md-6">Task name : </label>
                                                    <input value="<?php echo $row->sub_task_name; ?>" type="text" class="form-control w_90" name="edit_sub_task_name[]" id="sub_task_name_<?php echo $index; ?> " placeholder="Enter task name" />
                                                </div>
                                                <div class="form-group col-md-2 add_del_btn_outer">
                                                

                                                    <button style="margin-top:30px" class="btn btn_round remove_node_btn_frm_field btn-danger">
                                                        <i class="fas fa-trash delete_button"></i>
                                                    </button>
                                                </div>

                                        </div>
                                    <?php } }?>

                                </div>
                                <div class="col-md-12 ">
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                            
                                        </div>
                                        
                                        <div style="padding-left:15px" class="form-group col-md-2">
                                            <button type="button"  class="btn btn-circle btn-outline-lite py-0 add_new_frm_field_btn"><i class="fas fa-plus add_icon"></i></butto>              
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                </form>



                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                    <!-- ============================================================== -->
                   

                    <!-- ============================================================== -->
                    <!-- col no. 2 -->
                    <!-- ============================================================== -->

                   

                    <!-- ============================================================== -->
                    <!-- End col no. 2 -->
                    <!-- ============================================================== -->

                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>



<script>

$(document).ready(function() {



    $('#update_task_form').validate({ 
        rules: {
            edit_room_id: {
                required: true
            },
            edit_task_name: {
                required: true
            },
            edit_task_type :{
                required: true
            },
            

        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#form")[0]);

			$.ajax({

				url: '<?= base_url('/Task/update_Task/'.$update_id); ?>',

				enctype: 'multipart/form-data',
				data:new FormData(form),  
				processData: false,
				contentType: false,
				type: "POST",

				success: function(message) 
				{

					obj = JSON.parse(message);
                    // alert(message)
                    // return false;
					var status = obj.status;
					
					if(status == 0)
					{
						toastr.error(obj.message);
					}
					else
					{
						toastr.success(obj.message);
                        //location.reload();
					}
				}               
			});
		}
    });
    
/////////////////////////////
    var existing_task_type = $('#edit_task_type').val();

    if(existing_task_type == 'dynamic'){
        $('.hiddenForm').css('display', 'block');
    }
    else{
        $('.hiddenForm').css('display', 'none');
    }
 /////////////////////////////   /
    

    

});

$(document).ready(function () {
  $("body").on("click", ".add_node_btn_frm_field", function (e) {
    var index = $(e.target).closest(".form_field_outer").find(".form_field_outer_row").length + 1;
    var cloned_el = $(e.target).closest(".form_field_outer_row").clone(true);

    $(e.target).closest(".form_field_outer").last().append(cloned_el).find(".remove_node_btn_frm_field:not(:first)").prop("disabled", false);

    $(e.target).closest(".form_field_outer").find(".remove_node_btn_frm_field").first().prop("disabled", true);

    //change id
    $(e.target)
      .closest(".form_field_outer")
      .find(".form_field_outer_row")
      .last()
      .find("input[type='text']")
      .attr("id", "sub_task_name_" + index);

    $(e.target)
      .closest(".form_field_outer")
      .find(".form_field_outer_row")
      .last()
      .find("select")
      .attr("id", "no_type_" + index);

    console.log(cloned_el);
    //count++;
  });
});

$(document).ready(function(){ $("body").on("click",".add_new_frm_field_btn", function (){ console.log("clicked"); 
var index = $(".form_field_outer").find(".form_field_outer_row").length + 1; $(".form_field_outer").append(`
<div class="row form_field_outer_row">
  <div class="form-group col-md-10 ">
    <label>Task Name : </label>
    <input type="text" class="form-control w_90" name="edit_sub_task_name[]" id="sub_task_name_${index}" placeholder="Enter task name" />
  </div>
  
  <div class="form-group col-md-2 add_del_btn_outer">


    <button style="margin-top:30px" class="btn btn_round remove_node_btn_frm_field btn-danger">
      <i class="fas fa-trash delete_button"></i>
    </button>
  </div>
</div>
`);
     $(".form_field_outer").find(".remove_node_btn_frm_field:not(:first)").prop("disabled", false); $(".form_field_outer").find(".remove_node_btn_frm_field").first().prop("disabled", true);
    }); 
});
$(document).ready(function () {
  //===== delete the form fieed row
  $("body").on("click", ".remove_node_btn_frm_field", function () {
    $(this).closest(".form_field_outer_row").remove();
    console.log("success");
  });
});


</script>