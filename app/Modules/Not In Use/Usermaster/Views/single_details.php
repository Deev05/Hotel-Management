<?php 

use App\Models\CommonModel;
$CommonModel = new CommonModel();

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
                     <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                            if($user_master->profile_picture != "")
                                            {
                                        ?>
                                                <img class="img img-responsive rounded-circle" height="80px" width="80px" src="<?php echo base_url(); ?>/uploads/customers/<?php echo $user_master->profile_picture; ?>">
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                                <img class="img img-responsive rounded-circle" height="80px" width="80px" src="<?php echo base_url(); ?>/uploads/static/user.png    ">
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h4 class="card-title m-t-10"><?php echo $user_master->firstname." ".$user_master->lastname; ?></h4>
                                        <div class="row text-center justify-content-md-center">
                                        <?php
                                            $filter = array("user_id" => $user_master->id,"is_deleted" => 0);
                                            $exist = $CommonModel->get_by_condition("sop_applications",$filter);
                                            $total_applications = count($exist);
                                            
                                          
                                        ?>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium"><?php echo $total_applications; ?></font></a> <br/>Total Applications</div>
                                    </div>
                                </div>
                            </div>

                            <div><hr></div>

                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Contact </small><h6><?= $user_master->contact ?></h6> 
                                    </div>   
                                    <div class="col-md-4">
                                        <small class="text-muted">Email address </small><h6><?= $user_master->email ?></h6> 
                                    </div> 
                                    <div class="col-md-4">
                                        <small class="text-muted p-t-30 db">Device Type</small><h6><?= $user_master->device_type ?></h6>  
                                    </div> 
                                     
                                </div>

                                <?php
                                    $originalDate = $user_master->last_online;
                                    $newDate = date("d-m-Y H:i:sa", strtotime($originalDate));

                                    $originalDate = $user_master->created;
                                    $created = date("d-m-Y H:i:sa", strtotime($originalDate));

                                ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted p-t-30 db">Last Active</small><h6><?php echo $newDate; ?></h6> 
                                    </div>   
                                    <div class="col-md-4">
                                        <small class="text-muted p-t-30 db">Account Created</small><h6><?php echo $created; ?></h6> 
                                    </div> 
                                    <div class="col-md-4">
                                        
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#applications" role="tab"> <span class="hidden-xs-down">Applictions</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#family" role="tab"> <span class="hidden-xs-down">Family Details</span></a> </li>  
                        </ul>
                        <div class="tab-content tabcontent-border">
                            <!-- Tab panes -->
                            <div class="tab-pane  active p-20" id="applications" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered show-child-rows w-100">
                                                <thead>
                                                    <tr>
                                                         <th>No.</th>
                                                        <!-- <th>No.</th> -->
                                                        <th hidden>Id</th>
                                                        <th>Applicant No</th>
                                                        <th>Applicant Name</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Service Provider</th>
                                                        <th>Process</th>
                                                        <th>Payment Status</th>
                                                        <!--<th>Edit Mode</th>-->
                                                        <th>Created</th>
                                                        <!--<th>Action</th>-->
                                                    </tr>
                                                </thead>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane  p-20" id="family" role="tabpanel">
                                <div class="row">
                                    <?php
                                        $user_id = $user_master->id;
                                        $query = "select * from family_details where user_id = $user_id and is_deleted = 0";
                                        $family_members = $CommonModel->custome_query($query);

                                        if(!empty($family_members))
                                        {
                                            foreach($family_members as $row)
                                            {
                                                
                                        ?>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <small class="text-muted p-t-30 db">Relation</small><h6><?php echo $row->relation; ?></h6> 
                                                            
                                                        <p class="list-group-item">   Name :<?php echo $row->name; ?></p>
                                                        <p class="list-group-item">   Profession :<?php echo $row->profession; ?></p>
                                                   
                                                        
                                                        <?php
                                                        if($row->relation == "Brother" || $row->relation == "Sister")
                                                        {
                                                        ?>
                                                            <p class="list-group-item">   Elder/Younger : <?php echo $row->elder_younger; ?></p>
                                                        
                                                        <?php    
                                                            if($row->profession == "Study")
                                                            {
                                                        ?>
                                                                <p class="list-group-item">   Profession : <?php echo $row->profession; ?></p>
                                                                <p class="list-group-item">   Education : <?php echo $row->education; ?></p>
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <p class="list-group-item">   Profession : <?php echo $row->profession; ?></p>
                                                                <p class="list-group-item">   Company Name : <?php echo $row->company_name; ?></p>
                                                                <p class="list-group-item">   Designation : <?php echo $row->designation; ?></p>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        else
                                        {
                                            echo "No Family Details Found";
                                        }
                                    ?>
                                </div>   
                                
                            </div>
                        </div>
                    </div>
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



<script>
    $(document).ready(function() {


    
        var table = $('.show-child-rows').DataTable({
    
            "aaSorting": [ [0,"desc" ]],
            "serverSide": true,
            "processing": true,
            "start": 1,
            "end": 8,
            "pageLength": 10,
            "paging": true,
            "ajax": {
                "url": "<?= base_url() ?>/usermaster/get_user_applications/" + <?php echo $user_master->id;?>,
                "type": 'POST',

                "data": function(d) {
                }
            },
            "columns": [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": "no",
                        "defaultContent": 'number'
                    },
                    {
                        "className": 'id',
                        "visible": false,
                        // "orderable": true,
                        "data": "id",
                        "defaultContent": '',
                        "render": function(data) {
                            return data;
                        }
                    },
                    {
                        "data": "application_no"
                    },
                    {
                        "data": "applicant_name"
                    },
                    {
                        "data": "contact"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "service_provider"
                    },
    
                    {
                        "data": "application_status"
                    },

                    {
                        "orderable": false,
                        "data": "payment_status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-danger custom_pointer payment_status">Unpaid</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-success custom_pointer payment_status">Paid</span></div>';
                            }
                           
                        }
                    },
                    // {
                    //     "orderable": false,
                    //     "data": "edit_mode",
                    //     "render": function(data) {
                            
                    //          if (data == 0) {
                    //             return '<div class="text-center"><span class="badge badge-pill badge-secondary custom_pointer edit_mode_status">Disabled</span></div>';
                    //         } else if (data == 1) {
                    //             return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer edit_mode_status">Enabled</span></div>';
                    //         }
                           
                    //     }
                    // },
                    {
                        "data": "created"
                    },
                    // {
                    //     "orderable": false,
                    //     "data": "id",
                    //     "render": function(data) {
                    //         var edit_url = "<?= base_url("coupons/create") ?>/" + data;
                            
                    //         return '<div class="btn-group">' +
                            
                            
                    //             '<a title="View Application" href="javascript:void(0)" class="btn btn-info view">' +
                    //             '<i class="fa fa-eye"></i>' +
                    //             '</a>' +
                                
                                
                    //             '<a title="Send Notification To Service Provider" href="javascript:void(0)" class="btn btn-warning send_notifiaction_link">' +
                    //             '<i class="fa fa-bell"></i>' +
                    //             '</a>' +
                                
                    //             // '<a title="View Progress" href="javascript:void(0)" class="btn btn-primary">' +
                    //             // '<i class="fa fa-list delete_button"></i>' +
                    //             // '</a>'  +
                                
                    //         '<div class="btn-group">' +
                    //         '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    //         '<i class="ti-settings"></i>' +
                    //         '</button>' +
                    //             '<div class="dropdown-menu  " x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">' +
                                        

                    //                 '<div class="dropdown-header">Change Application Status</div>' +
                    //                 '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Documents Under Verification" href="javascript:void(0)"> Documents Under Verification</a>' +
                    //                 '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Serivce Provider Assigned" href="javascript:void(0)"> Serivce Provider Assigned</a>' +
                    //                 '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="SOP Document Sent" href="javascript:void(0)"> SOP Document Sent </a>' +
                    //                 '<a class="dropdown-item custom_pointer status" dataid="'+data+'" datastatus="Completed" href="javascript:void(0)"> Completed</a>' +
                    //             '</div>' +
                    //         '</div>';
                    //     },
                    // },
                ],
            });

           

        $('#add_form').validate({ 
            rules: {
                credit: {
                    required: true
                },
            },

            submitHandler: function(form) 
            {
                
            
                var form_data = new FormData();                  
    
                var formData = new FormData($("#add_form")[0]);

                $.ajax({

                    url: '<?php echo base_url(); ?>/customers/add_credits',

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
                            alert(obj.message);
                        }
                        else
                        {
                            //alert(obj.message);
                            $('#add_form').trigger("reset");
                            table.draw();
                        }
                    }               
                });
            }
        });
            


    });


        
</script>
