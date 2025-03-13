<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/uploads/setting/<?= $setting->favicon; ?>">
    <title><?= $setting->headline ?> - <?= $page_headline ?></title>
    <!-- Custom CSS -->
    <link href="<?=base_url()?>/admin_theme/dist/css/style.min.css" rel="stylesheet">

    <link href="<?=base_url()?>/admin_theme/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <!-- New Added -->
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Login -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(<?=base_url()?>/admin_theme/assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db "><img src="<?=base_url()?>/uploads/setting/<?= $setting->logo; ?> " height="72px"  alt="logo" /></span>
                        <h5 class="font-medium m-b-20 mt-5">Sign In to Admin</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" method="POST" id="login_form" action="<?php echo base_url(); ?>/admin_login/login_check">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="user_name"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" id="user_name" name="user_name" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="user_name">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info admin_login" type="submit">Log In</button>
                                    </div>
                                </div>
                                
                                <p class="text-primary text-center"><a  href="<?php echo base_url(); ?>service_provider_login">Service Provider Login</a></p>

                                
                            </form>
                        </div>
                    </div>
                    <!-- Form -->
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->

    <script>
        $(document).ready(function(){
                $('#login_form').validate({ 
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true
            },
            
        },

		submitHandler: function(form) 
		{
		    
           
           
			$.ajax({

				url: '<?php echo base_url(); ?>admin_login/login_check',

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
					    window.location.replace("<?php echo base_url(); ?>admin");
						
					}
				}               
			});
		}
    });

        })
    </script>

    <script src="<?=base_url()?>/admin_theme/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
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