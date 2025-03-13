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
               
    

                        <div class="card-body">
                            <h4 class="card-title text-center mt-3"><?php echo $application_details->application_no; ?></h4>
                            <div class="chat-box scrollable" style="height:calc(100vh - 300px);">
                                <div id="conversation">
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top">
                            <form id="message_form" name="message_form" > 
                                <div class="row">
                                    <div class="col-9">
                                        <div class="input-field m-t-0 m-b-0">
                                            <input id="message" name="message" placeholder="Type and enter" class="form-control border-0" type="text">
                                            <input id="application_id" name="application_id" value="<?php echo $application_id; ?>" type="text" hidden>
                                            <input id="user_id" name="user_id" value="<?php echo $user_id; ?>" type="text" hidden>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn-circle btn-lg btn-cyan float-right text-white">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>   
                                </div>
                            </form>
                        </div>
                        
                       
                
          
                

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->         
<script>

$(document).ready(function() {

    get_conversation_data();

    function get_conversation_data()
    {
           var id = '<?php echo $application_id; ?>';
        $.ajax({
            method: "GET",
            url: "<?= base_url(); ?>/sopuserwebview/get_conversation/<?php echo $application_id; ?>",
            success: function(message) {
                
                obj = JSON.parse(message);
                var status = obj.status;
                if (status == 0) {
                    alert(obj.message);
                } else {
                    $(".chat-box").animate({ scrollTop: $(".chat-box")[0].scrollHeight }, 1000);
                
                    $('#conversation').html(obj.conversation); 
                }
            },
        }); 
    }
    
    
    function check_new_message()
    {
           var id = '<?php echo $application_id; ?>';
        $.ajax({
            method: "GET",
            url: "<?= base_url(); ?>/sopuserwebview/get_conversation/<?php echo $application_id; ?>",
            success: function(message) {
                
                obj = JSON.parse(message);
                var status = obj.status;
                if (status == 0) {
                    alert(obj.message);
                } else {
                    $("#conversation").html('');
                    $('#conversation').html(obj.conversation); 
                    
                }
            },
        }); 
    }
    
      setInterval(function() {
          
          //alert()
          
            check_new_message();
        }, 10000);


    
    
      $('#message_form').validate({ 
        rules: {
            message: {
                required: true
            },
           
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#message_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>sopuserwebview/send_message',
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
						$('#message_form').trigger("reset");
						$("#conversation ul").append(obj.new_message);
						$(".chat-box").animate({ scrollTop: $(".chat-box")[0].scrollHeight }, 1000);
					}
				}               
			});
		}
    });

});
</script>


       