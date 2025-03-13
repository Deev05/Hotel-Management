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
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('activitylogs') ?>" aria-expanded="false">
                            <i class="fas fa-clock"></i>
                            <span class="hide-menu">Activity Logs</span>
                        </a>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="fab fa-product-hunt"></i>
                            <span class="hide-menu">SOP Services </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="<?= base_url('sopservices') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu"> Services </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('sopcountries') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Countries </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('soppackages') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Packages </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('sopemployment') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Employment Drop Down </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('sopapplications') ?>" aria-expanded="false">
                            <i class="fas fa-file"></i>
                            <span class="hide-menu">SOP Applications</span>
                        </a>
                    </li>

                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('customers') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-users"></i>-->
                    <!--        <span class="hide-menu">Customer's</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('serviceproviders') ?>" aria-expanded="false">
                            <i class="fas fa-briefcase"></i>
                            <span class="hide-menu">Service Providers</span>
                        </a>
                    </li>

                   
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('usermaster') ?>" aria-expanded="false">
                            <i class="fas fa-users"></i>
                            <span class="hide-menu">Users</span>
                        </a>
                    </li>

                    <!--<li class="sidebar-item">-->
                    <!--    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('manage_notification/') ?>" aria-expanded="false">-->
                    <!--        <i class="fas fa-bell"></i>-->
                    <!--        <span class="hide-menu">Notifications</span>-->
                    <!--    </a>-->
                    <!--</li>-->


                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                            <span class="hide-menu">Settings </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <!--<li class="sidebar-item">-->
                            <!--    <a href="<?= base_url('manage_page') ?>" class="sidebar-link">-->
                            <!--        <i class="mdi mdi-email-alert"></i>-->
                            <!--        <span class="hide-menu"> Page </span>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="sidebar-item">
                                <a href="<?= base_url('change_password') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Change Password </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-mobile-alt"></i>
                            <span class="hide-menu">App Settings </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="<?= base_url('settings') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu"> Settings </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= base_url('sliders') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Sliders </span>
                                </a>
                            </li>
                             <li class="sidebar-item">
                                <a href="<?= base_url('bottominfo') ?>" class="sidebar-link">
                                    <i class="mdi mdi-email-alert"></i>
                                    <span class="hide-menu"> Bottom info </span>
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