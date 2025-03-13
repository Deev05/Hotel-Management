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
                                    $session = session()->get('mySession');
                                ?>
                                <h5 class="m-b-10 user-name font-medium">Welcome, <?php echo $session['full_name']; ?></h5>
                                <?php
                                    $filter = array('id' => $session['role']);
                                    $roles = $CommonModel->get_single('roles',$filter);
                                   
                                ?>    
                                <p><?php echo $roles->name; ?></p>
                                
                                <a href="<?= base_url('/admin_login/logout') ?>" title="Logout" class="btn btn-circle btn-sm">
                                    <i class="ti-power-off"></i>
                                </a>
                            </div>
                        </div>
                        <!-- End User Profile-->
                    </li>

                   

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('admin') ?>" aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-lock"></i>
                            <span class="hide-menu">Role & Permissions </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="<?= base_url('permissions') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu"> Permissions </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('roles') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Roles </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('users') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Users </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('Task') ?>" aria-expanded="false">
                            <i class="fas fa-clock"></i>
                            <span class="hide-menu">Tasks</span>
                        </a>
                    </li>
                    
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('activitylogs') ?>" aria-expanded="false">
                            <i class="fas fa-clock"></i>
                            <span class="hide-menu">Activity Logs</span>
                        </a>
                    </li>

                    
                   
                   
                    
                    <!--  <li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('sopusertickets') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-ticket-alt"></i>-->
                    <!--        <span class="hide-menu">Tickets</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">-->
                    <!--        <i class="fas fa-ticket-alt"></i>-->
                    <!--        <span class="hide-menu">Tickets </span>-->
                    <!--    </a>-->
                    <!--    <ul aria-expanded="false" class="collapse  first-level">-->
                    <!--        <li class="sidebar-item">-->
                    <!--            <a href="<?= base_url('sopusertickets') ?>" class="sidebar-link">-->
                    <!--                <i class="fas fa-phone"></i>-->
                    <!--                <span class="hide-menu"> Users </span>-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--        <li class="sidebar-item">-->
                    <!--            <a href="<?= base_url('sopsptickets') ?>" class="sidebar-link">-->
                    <!--                <i class="mdi mdi-email-alert"></i>-->
                    <!--                <span class="hide-menu"> Service Providers </span>-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <li class="sidebar-item">
                       <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                           <i class="fas fa-ticket-alt"></i>
                           <span class="hide-menu">Rooms </span>
                       </a>
                       <ul aria-expanded="false" class="collapse  first-level">
                           <li class="sidebar-item">
                               <a href="<?= base_url('Roomtypes') ?>" class="sidebar-link">
                                   <i class="fas fa-phone"></i>
                                   <span class="hide-menu">Room Type</span>
                               </a>
                           </li>
                           <li class="sidebar-item">
                               <a href="<?= base_url('Rooms') ?>" class="sidebar-link">
                                   <i class="mdi mdi-email-alert"></i>
                                   <span class="hide-menu"> Rooms </span>
                               </a>
                           </li>
                       </ul>
                    </li>
                    <li class="sidebar-item">
                       <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                           <i class="fas fa-ticket-alt"></i>
                           <span class="hide-menu">Areas </span>
                       </a>
                       <ul aria-expanded="false" class="collapse  first-level">
                           <li class="sidebar-item">
                               <a href="<?= base_url('Areatypes') ?>" class="sidebar-link">
                                   <i class="fas fa-phone"></i>
                                   <span class="hide-menu">Area Types</span>
                               </a>
                           </li>
                           <li class="sidebar-item">
                               <a href="<?= base_url('Areas') ?>" class="sidebar-link">
                                   <i class="mdi mdi-email-alert"></i>
                                   <span class="hide-menu"> Areas </span>
                               </a>
                           </li>
                       </ul>
                    </li>
                    



                    
                    
                    
                    
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
                        <a href="<?= base_url('admin') ?>">Home</a>
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