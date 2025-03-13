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
  
  
  <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js"></script>


	  <script type="module">
	  
	  var admin_token = "";
      // Import the functions you need from the SDKs you need
      //import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-app.js";
     // import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-analytics.js";
      // TODO: Add SDKs for Firebase products that you want to use
      // https://firebase.google.com/docs/web/setup#available-libraries
    
      // Your web app's Firebase configuration
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      const firebaseConfig = {

    apiKey: "AIzaSyAmfqUMy9Ee6EOKUrfATiRfkf_yAmKeVCU",

  authDomain: "okkirana-36673.firebaseapp.com",

  projectId: "okkirana-36673",

  storageBucket: "okkirana-36673.appspot.com",

  messagingSenderId: "81119382087",

  appId: "1:81119382087:web:af6947f63a136e9dd73f62",

  measurementId: "G-J9GZ4DQE2L"


};
    
      // Initialize Firebase
     //const app = initializeApp(firebaseConfig);
     // const analytics = getAnalytics(app);
      
      ///////////
      
          firebase.initializeApp(firebaseConfig);
        const messaging=firebase.messaging();
      
      
       function IntitalizeFireBaseMessaging() {
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification Permission");
                return  messaging.getToken({vapidKey: "BF6pVNpRvYrvUjpE_wLL7m8X519W-zWyhSXYABotgWaIdA2dgIdfJznddzOsN7k-uPtQhg_Ux_MOV4hXSaGqwgc"});
            })
            .then(function (token) {
                admin_token = token;
                console.log("Token : "+token);
               // document.getElementById("token").innerHTML=token;
                update_token(token);
               
            
                
                
            })
            .catch(function (reason) {
                console.log(reason);
            });
    }

    messaging.onMessage(function (payload) {
        console.log(payload);
        const notificationOption={
            body:payload.notification.body,
            icon:payload.notification.icon
        };

        if(Notification.permission==="granted"){
            var notification=new Notification(payload.notification.title,notificationOption);

            notification.onclick=function (ev) {
                ev.preventDefault();
                window.open(payload.notification.click_action,'_blank');
                notification.close();
            }
        }

    });
    messaging.onTokenRefresh(function () {
        messaging.getToken({vapidKey: "BF6pVNpRvYrvUjpE_wLL7m8X519W-zWyhSXYABotgWaIdA2dgIdfJznddzOsN7k-uPtQhg_Ux_MOV4hXSaGqwgc"})
            .then(function (newtoken) {
                console.log("New Token : "+ newtoken);
            })
            .catch(function (reason) {
                console.log(reason);
				//alert(reason);
            })
    })
    IntitalizeFireBaseMessaging();
      
      function update_token(token)
      {
         
            var myurl = "<?php echo base_url().'/admin/update_admin_token' ?>";
                $.ajax({
                    
                    url: myurl,
                    type: "POST",
                    data: {"token" : token},
                    success: function(message) {
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                            console.log(obj.message);
                        } else {
                            console.log(obj.message);
                          	
                        }
                    }
                });
      }
      
    </script>
    
    <script>
        if ("serviceWorker" in navigator) {
          window.addEventListener("load", function () {
            // navigator.serviceWorker.register("/flutter_service_worker.js");
            navigator.serviceWorker.register("/firebase-messaging-sw.js");
          });
        }
    </script>
    
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
            
              <a class="navbar-brand text-center" href="<?php echo base_url('admin');?>">
                  <!-- Logo icon -->
                  <b class="logo-icon"><i class="fab fa-dashboard"></i></b>
                  <!--End Logo icon -->
                  <!-- Logo text -->
                  <span class="logo-text text-center">
                      <!-- dark Logo text -->
                      <div class="text-center">
                      <img src="<?=base_url()?>/uploads/setting/<?= $setting->logo; ?>" alt="homepage" class="dark-logo mt-5" height="50px">
                      <!-- Light Logo text -->
                      <img src="<?=base_url()?>/uploads/setting/<?= $setting->light_logo; ?>" class="light-logo mt-5" alt="homepage" height="50px">
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
 