<?php
use App\Models\CommonModel;
?>
<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ticket No. : <?php echo $ticket_details->ticket_no; ?> </h4> <?php echo $ticket_details->message; ?>
                            </div>
                        </div>
                        
         
                        <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $ticket_details->ticket_no; ?></h4>
                            <div class="chat-box scrollable ps-container ps-theme-default ps-active-y" style="height:calc(100vh - 300px);" data-ps-id="9e469714-c53d-2c4d-0908-83eddf9915d9">
                                <div id="conversation">
                                </div>
                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 315px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 194px;"></div></div></div>
                        </div>
                        <div class="card-body border-top">
                            <form id="message_form" name="message_form" > 
                                <div class="row">
                                    <div class="col-9">
                                        <div class="input-field m-t-0 m-b-0">
                                            <input id="message" name="message" placeholder="Type and enter" class="form-control border-0" type="text">
                                            <input id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" type="text" hidden>
                                            <input id="service_provider_id" name="service_provider_id" value="<?php echo $service_provider_id; ?>" type="text" hidden>
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
                    </div>
      
                        <!--<div class="card">-->
                        <!--    <div class="card-body">-->
                        <!--        <h4 class="m-b-20">Write a reply</h4>-->
                        <!--        <form method="post">-->
                        <!--             <textarea id="mymce" name="area"></textarea>-->
                        <!--            <button type="button" class="m-t-20 btn waves-effect waves-light btn-success">Reply</button>-->
                        <!--            <button type="button" class="m-t-20 btn waves-effect waves-light btn-info">Reply &amp; close</button>-->
                        <!--        </form>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ticket Info</h4>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row text-center">
                                    <div class="col-6 m-t-10 m-b-10">
                                        <?php
                                         if ($ticket_details->status == 0){
                                                echo '<div class="text-center"><span class="label label-warning">Opened</span></div>';
                                            } else if ($ticket_details->status == 1) {
                                                echo '<div class="text-center"><span class="label label-info">In Progress</span></div>';
                                            }else if ($ticket_details->status == 2) {
                                                echo '<div class="text-center"><span class="label label-primary">Responded</span></div>';
                                            }else if ($ticket_details->status == 3) {
                                                echo '<div class="text-center"><span class="label label-success">Resolved</span></div>';
                                            }
                                        ?>
                                        
                                    </div>
                                    <div class="col-6 m-t-10 m-b-10">
                                        <?php
                                            $orgDate    = $ticket_details->created;
                                            $msg_date_time = date("d-m-Y h:i A", strtotime($orgDate));
                                            echo $msg_date_time;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                       
                </div>
            </div>

<script>

$(document).ready(function() {

    get_conversation_data();

    function get_conversation_data()
    {
           var id = '<?php echo $ticket_id; ?>';
        $.ajax({
            method: "GET",
            url: "<?= base_url(); ?>/serviceprovidertickets/get_conversation/<?php echo $ticket_id; ?>",
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
           var id = '<?php echo $ticket_id; ?>';
        $.ajax({
            method: "GET",
            url: "<?= base_url(); ?>/serviceprovidertickets/get_conversation/<?php echo $ticket_id; ?>",
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

				url: '<?php echo base_url(); ?>serviceprovidertickets/send_message',
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