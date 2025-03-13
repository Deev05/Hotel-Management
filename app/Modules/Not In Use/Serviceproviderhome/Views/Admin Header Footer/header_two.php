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
    
</head>

<body>

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
  <!-- Main wrapper -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
   