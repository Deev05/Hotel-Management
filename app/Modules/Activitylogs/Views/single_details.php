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
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <h4 class="card-title m-t-10"><?= $user_master->full_name ?></h4>
                       
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium"><?php echo $video_counts; ?></font></a> <br/>Total Videos</div>
                                        
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> 
                                <small class="text-muted">Email address </small><h6><?= $user_master->email ?></h6> 
                                <small class="text-muted p-t-30 db">Device Type</small><h6><?= $user_master->device_type ?></h6> 
                                <?php
                                    $originalDate = $user_master->last_online;
                                    $newDate = date("d-m-Y H:i:sa", strtotime($originalDate));
                                ?>
                                <small class="text-muted p-t-30 db">Last Active</small><h6><?php echo $newDate; ?></h6> 
                                <?php
                                    $originalDate = $user_master->created;
                                    $created = date("d-m-Y H:i:sa", strtotime($originalDate));
                                ?>
                                <small class="text-muted p-t-30 db">Account Created</small><h6><?php echo $created; ?></h6> 
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Videos</a>
                                </li>
                                
                            </ul>
                            <!-- Tabs -->
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                    <div class="card-body">
                                    
                                            <?php
                                                
                                                
                                                if(!empty($videos))
                                                {
                                                    
                                            ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Video's</h4>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Video</th>
                                                                                <th scope="col">Likes</th>
                                                                                <th scope="col">Comments</th>
                                                                                <th scope="col">Created</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $count  = 0;
                                                                                foreach($videos as $row)
                                                                                {
                                                                                    $CommonModel = new CommonModel();
                                                                                    $query = "select count(id) as total_likes from likes where video_id = $row->id and is_deleted = 0";
                                                                                    $count_likes = $CommonModel->custome_query_single_record($query);
                                                                                    
                                                                                    $query = "select count(id) as total_comments from comments where video_id = $row->id and is_removed = 0";
                                                                                    $count_comments = $CommonModel->custome_query_single_record($query);
                                                                            ?>
                                                                                    <tr>
                                                                                        <th scope="row"><?php echo ++$count; ?></th>
                                                                                        <td><video width="100" height="150" ><source src="<?php echo base_url(); ?>/uploads/videos/<?php echo $row->video; ?>" type="video/mp4"></video></td>
                                                                                        <td><?php echo $count_likes->total_likes; ?></td>
                                                                                        <td><?php echo $count_comments->total_comments; ?></td>
                                                                                        <td><?php echo $row->created; ?></td>
                                                                                    </tr>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
      
                                            <?php
                                                }
                                                else
                                                {
                                                    echo "No Video Found !";
                                                }
                                            ?>
                                     
                                    </div>
                                </div>
                                <di
                                
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

