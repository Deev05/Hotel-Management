<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <!--<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/admin_theme/assets/images/favicon.png">-->
  <!--<title>AdminBite admin Template - The Ultimate Multipurpose admin template</title>-->
  <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/uploads/setting/<?= $setting->favicon; ?>">
  <title><?= $setting->headline ?> - <?= $page_headline ?></title>

  <!-- Plugins -->
  <link href="<?=base_url()?>/admin_theme/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/select2/dist/css/select2.min.css">
  <link href="<?=base_url()?>/admin_theme/assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
  
  <?php if ($page_title == 'Pages' || $page_title == 'Add New Product' || $page_title == 'Update Product Details') : ?>
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/ckeditor/samples/css/samples.css">
  <?php endif ?>
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>

  <!-- Custom CSS -->
  <link href="<?=base_url()?>/admin_theme/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
  <link href="<?=base_url()?>/admin_theme/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
  <link href="<?=base_url()?>/admin_theme/assets/libs/morris.js/morris.css" rel="stylesheet">
  
  <!-- Popup CSS -->
  <link href="<?=base_url()?>/admin_theme/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Custom CSS -->
  <link href="<?=base_url()?>/admin_theme/dist/css/style.min.css" rel="stylesheet">
  <link href="<?=base_url()?>/admin_theme/dist/css/custom.css" rel="stylesheet">
  <link href="<?=base_url()?>/admin_theme/dist/css/cropper.css" rel="stylesheet">

  <!-- New Added -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/daterangepicker/daterangepicker.css">

  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/libs/@claviska/jquery-minicolors/jquery.minicolors.css">
  
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>/admin_theme/assets/extra-libs/prism/prism.css">
      
       <link href="<?=base_url()?>/admin_theme/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
  

</head>

<body>

  <!-- ============================================================== -->
  <!-- Preloader -->
  <!-- ============================================================== -->
  <!-- <div class="preloader">
      <div class="lds-ripple">
          <div class="lds-pos"></div>
          <div class="lds-pos"></div>
      </div>
  </div> -->

  <!-- ============================================================== -->
  <!-- Main wrapper -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header -->
    <!-- ============================================================== -->
    <header class="topbar">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            
              <a class="navbar-brand text-center" href="<?php echo base_url('admin');?>" style="display:block ruby">
                  <!-- Logo icon -->
                  <b class="logo-icon"><i class="fab fa-dashboard"></i></b>
                  <!--End Logo icon -->
                  <!-- Logo text -->
                  <span class="logo-text text-center">
                      <!-- dark Logo text -->
                      <div class="text-center">
                      <img src="<?=base_url()?>/uploads/setting/<?= $setting->logo; ?>" alt="homepage" class="dark-logo mt-5" height="80px">
                      <!-- Light Logo text -->
                      <img src="<?=base_url()?>/uploads/setting/<?= $setting->light_logo; ?>" class="light-logo mt-5" alt="homepage" height="80px">
                      </div>  
                  </span>
              </a>
            
        
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-left mr-auto">
            <li class="nav-item d-none d-md-block">
              <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                <i class="sl-icon-menu font-20"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-bell font-20"></i>

                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <ul class="list-style-none">
                                    
                                    <li>
                                        <div id="notifications" class="message-center notifications ps-container ps-theme-default" data-ps-id="8a451627-6eef-9a73-387c-c7a58ffbe532">
                                            
                                            
                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                    </li>
                                   
                                </ul>
                            </div>
                        </li>
           
            
            
          </ul>
          <!-- ============================================================== -->
          <!-- Right side toggle and nav items -->
          <!-- ============================================================== -->
          
        </div>
      </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function()
        {
       
            get_notifications();
    
            function get_notifications() 
            {
          
                var myurl = "<?php echo base_url().'/admin/get_admin_notifications' ?>";
                $.ajax({
                    
                    url: myurl,
                    type: "GET",
                    //data: {},=
                    success: function(message) {
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                           // alert(obj.message);  	
                        } else {
             
                            $("#notifications").html(obj.notifications);
                        }
                    }
                });
            }
            
            
            $("#notification_icon").click(function(){
            
                $("#notifications").html('');
                get_notifications();
            }); 
    
        });

    </script>
 