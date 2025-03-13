<?php use App\Models\CommonModel; 
    $CommonModel = new CommonModel;  
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


        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#general" role="tab"> <span class="hidden-xs-down">General</span></a> </li>
            <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#app" role="tab"> <span class="hidden-xs-down">App Settings</span></a> </li>-->
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#social" role="tab"> <span class="hidden-xs-down">Social Links</span></a> </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">

            <div class="tab-pane  active p-20" id="general" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form class="m-t-25" id="general_setting_form" method="POST" action="<?= base_url('settings') ?>" enctype="multipart/form-data">

                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?= $name ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Headline</label>
                                    <input type="text" name="headline" id="headline" class="form-control" value="<?= $headline ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Contact</label>
                                    <input type="text" name="contact" id="contact" class="form-control" value="<?= $contact ?>">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Address</label>
                                    <textarea class="form-control" rows="3" name="address" id="address" placeholder="Short Description Here..."><?= $address ?></textarea>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>

                                <?php
                                    if($logo)
                                    {
                                ?>
                                
                                        <div class="form-group col-md-6">
                                            <label>Current Logo</label>
                                            <div class="el-card-avatar el-overlay-1 mb-2 ml-2"> 
                                                <img src="<?=base_url()?>/uploads/setting/<?= $logo; ?>" height="60px"  alt="Image" />
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                            
                            <div class="row">
                            
                                <div class="form-group col-md-6">
                                    <label>Light Logo</label>
                                    <input type="file" class="form-control" id="light_logo" name="light_logo">
                                </div>

                                <?php
                                    if($light_logo)
                                    {
                                ?>
                                
                                            <div class="form-group col-md-6 ">
                                                <label>Current Light Logo</label>
                                                <div class="el-card-avatar el-overlay-1 mb-2 ml-2 "> 
                                                    <img src="<?=base_url()?>/uploads/setting/<?= $light_logo; ?>" height="60px"  alt="Image" class="bg-dark"/>
                                                </div>
                                            </div>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>Favicon</label>
                                    <input type="file" class="form-control" id="favicon" name="favicon">
                                </div>

                                <?php
                                    if($favicon)
                                    {
                                ?>
                                
                                <div class="form-group col-md-6">
                                    <label>Current Favicon</label>
                                    <div class="el-card-avatar el-overlay-1 mb-2 ml-2"> 
                                        <img src="<?=base_url()?>/uploads/setting/<?= $favicon; ?>" height="60px"  alt="Image" />
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
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

            <div class="tab-pane  p-20" id="app" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form class="m-t-25" id="app_setting_form" method="POST" action="<?= base_url('settings/app_settings') ?>" enctype="multipart/form-data">

                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $app_settings->id ?>">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>App Name</label>
                                    <input type="text" name="app_name" id="app_name" class="form-control" value="<?= $app_settings->app_name ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>App Version</label>
                                    <input type="text" name="app_version" id="app_version" class="form-control" value="<?= $app_settings->app_version ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Primary Color</label>
                                    <input type="text" name="primary_color" id="hue-demo" class="form-control demo" value="<?= $app_settings->primary_color ?>">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Secondary Color</label>
                                    <input type="text" name="secondary_color" id="hue-demo" class="form-control demo" value="<?= $app_settings->secondary_color ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Text Color Dark</label>
                                    <input type="text" name="text_color_dark" id="hue-demo" class="form-control demo" value="<?= $app_settings->text_color_dark ?>">
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label>Text Color Semi Dark</label>
                                    <input type="text" name="text_color_semi_dark" id="hue-demo" class="form-control demo" value="<?= $app_settings->text_color_semi_dark ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Text Color Light</label>
                                    <input type="text" name="text_color_light" id="hue-demo" class="form-control demo" value="<?= $app_settings->text_color_light ?>">
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label>App Logo</label>
                                    <input type="file" class="form-control" id="app_logo" name="app_logo">
                                </div>

                                <?php
                                    if($app_settings->app_logo)
                                    {
                                ?>
                                
                                        <div class="form-group col-md-6">
                                            <label>Current App Logo</label>
                                            <div class="el-card-avatar el-overlay-1 mb-2 ml-2"> 
                                                <img src="<?=base_url()?>/uploads/setting/<?= $app_settings->app_logo; ?>" height="60px"  alt="Image" />
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" name="app_form_submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            

            <div class="tab-pane p-20 " id="social" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form class="m-t-25" id="social_media_link_form" method="POST" action="<?= base_url('settings/social_media_links') ?>" enctype="multipart/form-data">

                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>">

                            <div class="form-group col-md-12">
                                <label>Instagram Url</label>
                                <input type="text" name="instagram_url" id="instagram_url" class="form-control" value="<?= $setting->instagram_url ?>">
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Facebook Url</label>
                                <input type="text" name="facebook_url" id="facebook_url" class="form-control" value="<?= $setting->facebook_url ?>">
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Twitter Url</label>
                                <input type="text" name="twitter_url" id="twitter_url" class="form-control" value="<?= $setting->twitter_url ?>">
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Pinterest Url</label>
                                <input type="text" name="pinterest_url" id="pinterest_url" class="form-control" value="<?= $setting->pinterest_url ?>">
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Youtube Url</label>
                                <input type="text" name="youtube_url" id="youtube_url" class="form-control" value="<?= $setting->youtube_url ?>">
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
        $('#general_setting_form').validate({ 
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                contact: {
                    required: true
                },
               
                
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#general_setting_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/settings',

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
        //App Settings
        $('#app_setting_form').validate({ 
            rules: {
                app_name: {
                    required: true
                },
                primary_color: {
                    required: true
                },
                secondary_color: {
                    required: true
                },
               
                
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#app_setting_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/settings/app_settings',

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
        ///Payment Method 
        $('.toggle-event').change(function() {
           
            var id      =   $(this).attr('pid');
            var status  =   $(this).val();

            if(status == 1) 
            {
                status = 0; 
            } 
            else 
            {
                status = 1; 
            }

        $.ajax({
                type:'POST',
                url: '<?= base_url(); ?>/settings/update_payment_method_status',
                data:{pid:id, status:status},
                success: function(message)
                {
                    obj = JSON.parse(message);
                
                    var status = obj.status;

                    if (status == 0) {
                        toastr.error(obj.message);
                    }
                    else
                    {
                        toastr.success(obj.message);
                    }
                }
            });
        });
        ///Social Media Settings
        $('#social_media_link_form').validate({ 
            rules: {
                instagram_url: {
                    required: true
                },
                facebook_url: {
                    required: true
                },
                twitter_url: {
                    required: true
                },
               
                
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#social_media_link_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/settings/social_media_links',

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