<?php 
use App\Models\CommonModel;
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
                    <!-- ============================================================== -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="m-t-25" id="contact_form" method="POST" action="<?= base_url('serviceprovidercontact') ?>" enctype="multipart/form-data">

                                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>">

                                    <div class="form-group col-md-12">
                                        <label>Enter Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control" value="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Enter Your Message</label>
                                        <textarea type="password" name="message" id="message" class="form-control" value="Your message..."></textarea>
                                    </div>

                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

    <script>
        $(document).ready(function () {
        //General Settings
        $('#contact_form').validate({ 
            rules: {
                message: {
                    required: true
                },
                subject: {
                    required: true
                },
               
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#contact_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/serviceprovidercontact',

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
                            $('#contact_form').trigger("reset");
                        }
                    }               
                });
            }
            });
        });
    </script>