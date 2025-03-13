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
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                <form style="width:100% ; display:flex;" class="m-t-25" id="form" method="POST" action="" enctype="multipart/form-data">
                    <!-- ============================================================== -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                

                                    <div class="row" style="margin-bottom:5%;">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label>Room no</label> <br>
                                                <select multiple="multiple" name="room_id[]" id="room_id" class="form-control select2" style="width:100%;">
                                                    <option value="">Select Room no</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $rooms = $CommonModel->get_by_condition("rooms",$filter);


                                                            if(!empty($rooms))
                                                            {
                                                            foreach($rooms as $row)
                                                            {
                                                        ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->room_no; ?></option>
                                                        <?php
                                                            }    
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5%;">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label>Task type</label> <br>
                                                <select name="task_type" id="task_type" class="form-control ">
                                                    <option value="">Select Task type</option>
                                                        
                                                        <option value="individual">Individual</option>
                                                        <option value="dynamic">Dynamic</option>
                                                       
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0" style="margin-bottom:5%;">
                                        <label>Task Name</label> <br>
                                        <input class="form-control col-md-12 tag" type="text" id="task_name" name="task_name" value=""
                                          >
                                    </div>

                                    


                                    <div class="row" style="margin-bottom:5%;margin-top:5%;">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label>User name</label> <br>
                                                <select name="user_id" id="user_id" class="form-control select2" style="width:100%;">

                                                    <option value="">Select user</option>
                                                        <?php
                                                            $query = "SELECT * FROM user WHERE role = 6 or role = 7 or role = 8";
                                                       
                                                            $users = $CommonModel->custome_query($query);


                                                            if(!empty($users))
                                                            {
                                                            foreach($users as $row)
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
                                    </div>
                                    


                                    
                                    <div class="form-group mb-0" style="display:flex ; flex-direction:column;">
                                        <label>Task Description</label>
                                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Long Description Here..." value="<?php echo'' ;?>">
                                           
                                        </textarea>
                                    </div>

                                    
                                    
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit"  class="btn btn-info submit"> <i class="fa fa-check"></i> Save</button>
                                            <a href="<?= base_url('Task') ?>" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>

                             
                            </div>
                        </div>
                    </div>
                                                        
                    <div class="col-md-6 hiddenForm" style="display:none" id="results">
                        <div class="check_box" >
                            <label>apply same for all rooms </label>
                            <input id="apply_to_all" type="checkbox" >
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
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

<script>
$(document).ready(function(){
    $('#room_id').on('change', function() {
        //$('.hiddenForm').css('display', 'block');

    var selectedOptions = $(this).val();
    console.log('All Selected Options:', selectedOptions);

    // Get all options that are currently selected
    var currentlySelectedOptions = $(this).find('option:selected').map(function() {
        return this.value;
    }).get();
    console.log('Currently Selected Options:', currentlySelectedOptions);

    // Get all previously selected options (before the change event)
    var previouslySelectedOptions = $(this).data('previouslySelectedOptions') || [];

    // Determine which options were deselected
    var deselectedOptions = previouslySelectedOptions.filter(function(option) {
        return !currentlySelectedOptions.includes(option);
    });

    deselectedOptions.forEach(function(option) {
        $(`#${option}`).remove();
        console.log(`Removed div with ID: #${option}`);
    });

    // Save the current state of selected options for the next change event
    $(this).data('previouslySelectedOptions', currentlySelectedOptions);
     
    if (selectedOptions && selectedOptions.length > 0) 
    {
            $.each(selectedOptions, function(index, value) 
            {
               
                if (!$('#results').find(`#${value}`).length) {
                    
                $('#results').append(`
                    <div id="${value}" class="sub-tasks"><h4>Add Sub Tasks for Room ${index+1} </h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 form_field_outer p-0">
                                    <div class="row form_field_outer_row">
                                        <div class="form-group col-md-10">
                                            <label class="col-md-6">Task name : </label>
                                            <input type="text" class="form-control w_90" name="sub_task_name_${value}[]" id="sub_task_name_${value}_1" placeholder="Enter task name" />
                                        </div>
                                        <div class="form-group col-md-2 add_del_btn_outer">
                                            <button style="margin-top:30px" class="btn btn_round remove_node_btn_frm_field btn-danger" disabled>
                                                <i class="fas fa-trash delete_button"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                        </div>
                                        <div style="padding-left:15px" class="form-group col-md-2">
                                            <button type="button" class="btn btn-circle btn-outline-lite py-0 add_new_frm_field_btn" data-index="${value}"><i class="fas fa-plus add_icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }});
        } else {
            $('#results').append('<h3>No Rooms selected.</h3>');
        }
    });

    
});
$(document).ready(function() {
    // Handle the checkbox change event
    $('#apply_to_all').change(function() {
        if ($(this).is(':checked')) {
            // Checkbox is checked
            // Get sub-task names from the first room
            var firstRoomId = $('#results .sub-tasks').first().attr('id');
            var subTaskNames = $(`#${firstRoomId} input[name^="sub_task_name_${firstRoomId}"]`).map(function() {
                return $(this).val();
            }).get();

            // Apply sub-task names to all other rooms
            $('#results .sub-tasks').each(function() {
                var roomId = $(this).attr('id');
                if (roomId !== firstRoomId) {
                    $(`#${roomId} input[name^="sub_task_name_${roomId}"]`).each(function(index) {
                        $(this).val(subTaskNames[index]);
                    });
                }
            });
        } else {
             
           // $('#results .sub-tasks').each(function() {
              //  var roomId = $(this).attr('id');
              //  if (roomId !== firstRoomId) {
            //        $(`#${roomId} input[name^="sub_task_name_${roomId}"]`).val('');
             //  }
            // });
        }
    });
});


</script>

    









    <script>

$(document).ready(function() {



    $('#form').validate({ 
        rules: {
            room_id: {
                required: true
            },
            task_name: {
                required: true
            },
            task_type :{
                required: true
            },
            

        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/Task/add_Task/',

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
						toastr.success(obj.message);
                        location.reload();
					}
				}               
			});
		}
    });

    $('#task_type').change(function() {
        if ($(this).val() === 'dynamic') {
            $('.hiddenForm').css('display', 'block');
        } else {
            $('.hiddenForm').css('display', 'none');
        }
    });

});




///======Clone method
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

$(document).ready(function(){
    $('body').on('click', '.add_new_frm_field_btn', function() {
        var index = $(this).data('index');
        var newTaskIndex = $(`#results #sub_task_name_${index}_1`).closest('.form_field_outer').find('.form_field_outer_row').length + 1;
        $(`#results #sub_task_name_${index}_1`).closest('.form_field_outer').append(`
            <div class="row form_field_outer_row">
                <div class="form-group col-md-10">
                    <label>Task Name : </label>
                    <input type="text" class="form-control w_90" name="sub_task_name_${index}[]" id="sub_task_name_${index}_${newTaskIndex}" placeholder="Enter task name" />
                </div>
                <div class="form-group col-md-2 add_del_btn_outer">
                    <button style="margin-top:30px;" class="btn btn_round remove_node_btn_frm_field btn-danger">
                        <i class="fas fa-trash delete_button"></i>
                    </button>
                </div>
            </div>
        `);
    });
    $('body').on('click', '.remove_node_btn_frm_field', function() {
        $(this).closest('.form_field_outer_row').remove();
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
