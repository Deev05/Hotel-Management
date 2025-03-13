<?php 
use App\Models\CommonModel;
$CommonModel = new CommonModel();
?>
 
 <!-- ============================================================== -->
    <!-- Left Sidebar -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <!-- User Profile-->
                    <li>
                        <!-- User Profile-->
                        <div class="user-profile dropdown m-t-20">
                          
                                <!--<img src="<?=base_url()?>/uploads/setting/logo_white.png" alt="homepage" height="80px"  class="light-logo"  />-->
                     
                            <div class="user-content hide-menu m-t-10">
                                <?php
                                    $session = session()->get('service_provider_session');
                                ?>
                                <h5 class="m-b-10 user-name font-medium">Welcome, <?php echo $session['full_name']; ?></h5>
                                  
                                <p>Service Provider</p>
                                
                                <a href="<?= base_url('/service_provider_login/logout') ?>" title="Logout" class="btn btn-circle btn-sm">
                                    <i class="ti-power-off"></i>
                                </a>
                            </div>
                        </div>
                        <!-- End User Profile-->
                    </li>

                   

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviderhome') ?>" aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                  
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviderapplications') ?>" aria-expanded="false">
                            <i class="fas fa-file"></i>
                            <span class="hide-menu">SOP Applications</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviderpaymenthistory') ?>" aria-expanded="false">
                            <i class="fas fa-history"></i>
                            <span class="hide-menu">Payment History</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviderhome/profile') ?>" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span class="hide-menu">My Profile</span>
                        </a>
                    </li>
                    
                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceprovidertickets') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-ticket-alt"></i>-->
                    <!--        <span class="hide-menu">Tickets</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceprovidercontact') ?>" aria-expanded="false">
                            <i class=" fas fa-phone"></i>
                            <span class="hide-menu">Contact Admin</span>
                        </a>
                    </li>
                    

                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('customers') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-users"></i>-->
                    <!--        <span class="hide-menu">Customer's</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviders') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-briefcase"></i>-->
                    <!--        <span class="hide-menu">Service Providers</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('manage_notification/') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-bell"></i>-->
                    <!--        <span class="hide-menu">Notifications</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->




    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"><?= $page_title ?></h4>
                <div class="d-flex align-items-center"></div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('serviceproviderhome') ?>">Home</a>
                    </li>
                    <!-- <li class="breadcrumb-item active" aria-current="page"><?= $page_title ?></li> -->
                    </ol>
                </nav>
                </div>
            </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->