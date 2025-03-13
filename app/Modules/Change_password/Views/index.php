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
                                <form class="m-t-25" id="change_password_form" method="POST" action="<?= base_url('change_password') ?>" enctype="multipart/form-data">

                                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>">

                                    <div class="form-group col-md-12">
                                        <label>Enter Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="form-control" value="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Enter New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" value="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Repeat New Password</label>
                                        <input type="password" name="repeat_password" id="repeat_password" class="form-control" value="">
                                    </div>
                                    

                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
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
        $('#change_password_form').validate({ 
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true
                },
                repeat_password: {
                required: true,
                equalTo: "#new_password"
                
            },
               
                
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#change_password_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/change_password',

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
                        }
                    }               
                });
            }
            });
        });
    </script>