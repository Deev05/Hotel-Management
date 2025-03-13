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



    <!-- basic table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $count = 0; 
                                    foreach($contactus as $row)
                                    {
                                        $filter = array("id" => $row->service_provider_id);
                                        $user_data = $CommonModel->get_single("service_providers",$filter);
                                ?>
                                    <tr>
                                      <!--  <td class="id"  style="display:none;"><?php echo $row->id; ?></td>-->
                                        <td><?php echo ++$count; ?></td>
                                        <td><?php echo $user_data->name; ?></td>
                                        <td><?php echo $user_data->email; ?></td>
                                        <td><?php echo $user_data->contact; ?></td>
                                        <td><?php echo $row->subject; ?></td>
                                        <td><?php echo $row->message; ?></td>
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
    </div>
    
    <!-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-striped table-bordered" id="diamondsdata">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>MainCategory Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->

    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<script>

// $(document).ready(function() {
//     load_data();

//     function load_data()
//     {
       

//         $('#diamondsdata').DataTable({
//         lengthMenu: false,
//         bProcessing: true,
//         serverSide: true,
//         lengthChange: false,
//         //scrollY: "400px",
//         //scrollCollapse: true,
        
//         //   pageLength: 5,
        
//         ajax: {
//             url: "<?php echo base_url(); ?>/manage_main_category/get_data", // json datasource
//             type: "post",
//           data: {
                  
//             }
         
//         },
//         columns: [
//             { data: "id" },
//             { data: "main_category_name" },
     
   
//         ],

//         bFilter: true, // to display datatable search
//         });

//     }


// });
</script>
<script>
    
</script>
