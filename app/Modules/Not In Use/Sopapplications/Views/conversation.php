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
                                <h4 class="card-title">Application No. : <?php echo $application_details->application_no; ?> </h4> 
                            </div>
                        </div>
                        
         
                        <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $application_details->application_no; ?></h4>
                            <div class="chat-box scrollable ps-container ps-theme-default ps-active-y" style="height:calc(100vh - 300px);" data-ps-id="9e469714-c53d-2c4d-0908-83eddf9915d9">
                                <div id="conversation">
                                </div>
                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 315px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 194px;"></div></div></div>
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
                    
                    
            
                </div>
            </div>

<script>

$(document).ready(function() {

    get_conversation_data();

    function get_conversation_data()
    {
           var id = '<?php echo $application_id; ?>';
        $.ajax({
            method: "GET",
            url: "<?= base_url(); ?>/sopapplications/get_conversation/<?php echo $application_id; ?>",
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
            url: "<?= base_url(); ?>/sopapplications/get_conversation/<?php echo $application_id; ?>",
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




});
</script>