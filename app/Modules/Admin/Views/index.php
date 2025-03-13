<?php 
use App\Models\CommonModel; 
$CommonModel = new CommonModel;  
?>    
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            <div class="assigned-tasks" style="display:flex ;flex-direction:row; flex-wrap :wrap" >
                <?php 
                
                foreach($CommonModel->get_all_data_array('rooms') as $row1){
                    foreach($task_details as $index => $row){
                    if($row['room_id'] == $row1['id'] && $row['assigned_to']==$id && $row['is_deleted']==0){?>
                        
                       <?php if($row['task_type']=='individual'){ ?>
                            <div class="col-md-6 individual-task" >
                                <div class="col-md-12 col-sm-12">
                                    <div class="card  card-hover" >
                                        <div class="card-header bg-info">
                                            <h4 class="m-b-0 text-white">Room No : <?php 
                                            $filter=array('id' => $row['room_id']); 
                                            echo $CommonModel->get_single('rooms',$filter)->room_no;  ?></h4>
                                        </div>
                                        <div  class="room" style="display:none;">
                                            <?php 
                                            $filter=array('id' => $row['room_id']); 
                                            echo $CommonModel->get_single('rooms',$filter)->room_no;  ?>
                                        </div>
                                        <div class="card-body" style="text-align:start">
                                            <div class="col-md-12" style="display:flex">
                                                <h5 class="card-title col-md-10" style="padding-left:0px;">Task Name : <?php echo $row['task_name'] ?></h5>
                                                <button class="btn btn-success task_start">Pending</button>
                                            </div>
                                            <hr>
                                            <p class="col-md-12 description">Description : <?php echo $row['description']  ?> </p>
                                        </div>    
                                            
                                        
                                    </div>
                                </div>
                            </div>
                       <?php }
                            else{ ?>
                            <div class="col-md-6 dynamic-task" >
                                <div class="col-md-12 col-sm-12">
                                    <div class="card  card-hover">
                                        <div class="card-header bg-info">
                                            <h4 class="m-b-0 text-white">Room No :<?php 
                                            $filter=array('id' => $row['room_id']); 
                                            echo $CommonModel->get_single('rooms',$filter)->room_no;  ?></h4>
                                        </div>
                                        <div id="<?php $row['room_id'] ?>" class="room" style="display:none;">
                                        <?php 
                                            
                                            echo $row['room_id'] ?>
                                        </div>
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">Task Name: <?php echo $row['task_name'] ?></h5>
                                            <p class="description">Description: <?php echo $row['description']  ?> </p>
                                            <table class="w-100 table" style="text-align:start">
                                                <thead>
                                                    <th>Sub task</th>
                                                    <th>Action</th>
                                                    <th hidden>Id</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach(json_decode($row['sub_task']) as $index=> $sub_task){  ?>
                                                        <tr>
                                                        <td>
                                                            <?php echo $sub_task->sub_task_name ;  ?>
                                                        </td>
                                                        <td>
                                                        <button id="<?php echo $index.$row['room_id'] ?>" class="btn btn-success task_start">pending</button>
                                                        </td>
                                                        <td ><div class="status">
                                                            <?php echo $sub_task->status;
                                                            ?>
                                                        </div></td>
                                                        <td class="id" hidden><?php echo $index ?></td>
                                                        </tr>
                                                    <?php }  ?>
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      <?php  } 
                    
                    }

                }}   ?>
            </div>
            
            
            
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
           
            
            
            <div id="final_approval" class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title"> final-call </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body" id="final_call">
                                <div class="final_call"></div>                     
                            </div>
                       
                            
                         
                        </div>
                    </div>
                </div>
               
                
                <!-- ============================================================== -->
                <!-- ROW -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- ROW -->
                <!-- ============================================================== -->
                
                
                
                <br/>
                <br/>
                <br/>
                


              
            
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        
  <script>
    
    $(document).ready(function(){
    
        $(".btn-success").prop("disabled", true);
    
    // Enable the first button
    $(".btn-success:first").prop("disabled", false);
        

        $(document).on('click', '.task_start', function(e) {
            var taskCard = $(this).closest('.card');
        var room = taskCard.find('.room').text().trim();
        var id = $(this).closest('tr').find('.id').text();

        if (!room) {
            room = taskCard.find('.card-header').text().trim().split(':')[1].trim();
        }

           
                        e.preventDefault();
                        $.ajax({
                                url: '<?= base_url(); ?>/admin/final_call/'+room+'/' + id,
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
                                        
                                        $('.final_call').html(obj.final_call);
                                    
                                    }
                                }
                            });
                        
                        $("#final_approval").modal('show');
        });

        $(document).on('click','.yes',  function(e){

            var room = $('.room_post').text();
            var id = $('.id_post').text();
            
            $(".task_start").prop("disabled", true);
            $("#"+id+room).prop("disabled", false);
            $("#"+id+room).removeClass().addClass("btn btn-warning in_progress").html("In progress");
            
            

                        $.ajax({
                                url: '<?= base_url(); ?>/admin/start_time/'+room+'/' + id,
                                enctype: 'multipart/form-data',
                                data:{id:id},
                                dataType:"JSON",
                                method:"POST",
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
        });
        
      
    })


    $(document).ready(function() {
            
        });
  </script>      
     
        

            
    
            
        
        
	<!-- /Container -->
		
		
  