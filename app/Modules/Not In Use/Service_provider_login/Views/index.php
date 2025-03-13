<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/uploads/setting/<?= $setting->favicon; ?>">
    <title><?= $setting->headline ?> - <?= $page_headline ?></title>
    <!-- Custom CSS -->
    <link href="<?=base_url()?>/admin_theme/dist/css/style.min.css" rel="stylesheet">
    
    <link href="<?=base_url()?>/admin_theme/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- New Added -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(<?=base_url()?>admin_theme/assets/images/background/login-register.jpg) no-repeat center center;">
            <div class="auth-box on-sidebar">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="<?=base_url()?>/uploads/setting/<?= $setting->logo; ?>" height="72px" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Sign In to Service Provider Panel</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" id="login_form" action="<?php echo base_url(); ?>/admin_login/login_check"   method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="Contact" name="contact" aria-label="Contact" aria-describedby="basic-addon1">
                                </div>
                               
                                <!--<div class="form-group row">-->
                                <!--    <div class="col-md-12">-->
                                <!--        <div class="custom-control custom-checkbox">-->
                                           
                                <!--            <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                                    </div>
                                </div>
                                <p class="text-primary text-center"><a  href="<?php echo base_url(); ?>admin">Admin Login</a></p>

                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <span class="db"><img src="<?=base_url()?>/uploads/setting/<?= $setting->logo; ?>" height="72px" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Enter 6 Digit OTP</h5>
                        <span>OTP Sent to registered mobile number!</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="post" name="otp_form" id="otp_form" action="">
                            <!-- email -->
                            
                            <div class="form-group row">
                                 <div class="col-12">
                                    <input class="form-control form-control-lg" name="otp_contact" id="otp_contact" type="text" value="" readonly>
                                </div>
                            </div>
                                    
                                    
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control form-control-lg" name="otp" id="otp" type="text" required="" placeholder="OTP">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Verify OTP</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    
    
     <script>
        $(document).ready(function(){
        $('#login_form').validate({ 
            rules: {
                contact: {
                    required: true,
                    number: true,
    				minlength: 10,
    				maxlength: 10
                }, 
            },
    
    		submitHandler: function(form) 
    		{
    			$.ajax({
    				url: '<?php echo base_url(); ?>service_provider_login/login_check',
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
    						Swal.fire(obj.message);
    					}
    					else
    					{
    					    $("#otp_contact").val(obj.contact);
    					    $("#loginform").slideUp();
                            $("#recoverform").fadeIn();
    					    //window.location.replace("<?php echo base_url(); ?>serviceproviderhome");
    					}
    				}               
    			});
    		}
        });
        
        
        $('#otp_form').validate({ 
            rules: {
                otp: {
                    required: true,
                    number: true,
    				minlength: 6,
    				maxlength: 6
                }, 
            },
    
    		submitHandler: function(form) 
    		{
    			$.ajax({
    				url: '<?php echo base_url(); ?>service_provider_login/verify_otp',
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
    						Swal.fire(obj.message);
    					}
    					else
    					{
    					    window.location.replace("<?php echo base_url(); ?>serviceproviderhome");
    					}
    				}               
    			});
    		}
        });

        })
    </script>
    
    
    <script src="<?=base_url()?>/admin_theme/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>

</body>

</html>






