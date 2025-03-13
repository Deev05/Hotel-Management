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
                                <form class="m-t-25" id="update_profile" method="POST" action="<?= base_url('update_profile') ?>" enctype="multipart/form-data">

                                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $service_provider_id ?>">

                                    <div class="form-group col-md-12">
                                        <label>Name</label>
                                        <input type="text" name="name" id="name" value="<?php echo $service_provider->name; ?>" class="form-control" >
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" value="<?php echo $service_provider->email; ?>" class="form-control" >
                                    </div>

                                   <div class="form-group col-md-12">
                                        <label>Contact</label>
                                        <input readonly type="text" name="contact" id="contact" value="<?php echo $service_provider->contact; ?>" class="form-control" >
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>Pincode</label>
                                        <input readonly type="text" name="pincode" id="pincode" value="<?php echo $service_provider->pincode; ?>" class="form-control" >
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>State</label>
                                        <input readonly type="text" name="state" id="state" value="<?php echo $service_provider->state; ?>" class="form-control" >
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>City</label>
                                        <input readonly type="text" name="city" id="city" value="<?php echo $service_provider->city; ?>" class="form-control" >
                                    </div>
                                    
                                     <div class="form-group col-md-12">
                                        <label>Tibloo's Fees/Charges</label>
                                        <input readonly type="text" name="commission" id="commission" value="<?php echo $service_provider->commission; ?>%" class="form-control" >
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
        $('#update_profile').validate({ 
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                
                
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#update_profile")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/serviceproviderhome/update_profile',

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