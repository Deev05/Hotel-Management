<?php use App\Models\CommonModel; 

    $CommonModel = new CommonModel;  ?>    
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            
            <?php
                $query = "select * from sop_applications where service_provider_id = $service_provider_id and is_deleted = 0 and application_status <> 'Completed'";
                $result = $CommonModel->custome_query($query);
            
                if(!empty($result))
                {
                    foreach ($result as  $row) 
                    {
                        $filter = array("id" => $row->service_provider_id);
                        $service_provider = $CommonModel->get_single("service_providers",$filter);
            
                        if(!empty($service_provider))
                        {
                            $data['service_provider'] = $service_provider->name;
                        }
                        else
                        {
                            $data['service_provider'] = "Not Assigned";
                        }
                        
                        $application_deadline   = strtotime($row->service_provider_deadline); 
                        $secondsLeft            = $application_deadline - time();
                        $days                   = floor($secondsLeft / (60*60*24)); 
                        $hours                  = floor(($secondsLeft - ($days*60*60*24)) / (60*60));
                        $minutes                = floor(($secondsLeft % 3600) / 60);
                        
                        //$data['deadline']       = $hours." Hour(s) Left";
                        
                        //$hours  = $hours - 8;
                        
                        if($hours < 0 )
                        {
                      
                           $hours  = floor(($secondsLeft - ($days*60*60*24)) / (60*60)); 
                        }
                        else
                        {
                            $hours  = floor(($secondsLeft - ($days*60*60*24)) / (60*60));
                            //$hours  = $hours - 8;
                        }
                        
                        if($row->deadline == "")
                        {
                           $data['deadline']       = ""; 
                        }
                        else
                        {
                            if($row->application_status == "Completed")
                            {
                                $data['deadline'] = "Completed";
                            }
                            else
                            {
                                echo '<div class="alert alert-danger">Application No : '.$row->application_no.' Has  '.$hours.' Hours '.$minutes.' Minutes remaining to complete</div>';
                            } 
                        }
                        
                        
                    }
                }
            ?>
            
            
            <div class="row" id="inquiry_row">
                <!-- column -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Recent Inquiries</h4>
                        </div>
                        <div class="comment-widgets scrollable" id="service_provider_inquiry">
                            
                          
                            
                           
                            
                        </div>
                    </div>
                </div>
                <!-- column -->
            </div>
            

            
                <!-- ============================================================== -->
                <!-- Sales Summery -->
                <!-- ============================================================== -->
                
                <?php
                
                        ///////////////////////////////////////////////////
                        ///////////////////////////////////////////////////
                        
                        $query              = "select IFNULL(SUM(amount),0) as credit from transactions where type = 'credit' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                        $total_credit       = $CommonModel->custome_query_single_record($query);
                        
                        $query              = "select IFNULL(SUM(amount),0) as benefit from transactions where type = 'benefit' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                        $total_benefits     = $CommonModel->custome_query_single_record($query);
                        
                        $query              = "select IFNULL(SUM(amount),0) as penalty from transactions where type = 'penalty' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                        $total_penalty      = $CommonModel->custome_query_single_record($query);
                        
                        $totalcredit        = $total_credit->credit;
                        $totalbenefits      = $total_benefits->benefit;
                        $totalpenalty       = $total_penalty->penalty;
                        $totaloutstanding   = $totalcredit + $totalbenefits - $totalpenalty;
                        
                        //Total Revenue//
                        $query              = "select IFNULL(SUM(amount),0) as credit from transactions where type = 'credit' and service_provider_id = $service_provider_id and payment_status = 'paid'; ";
                        $total_paid_credit       = $CommonModel->custome_query_single_record($query);
                        
                        $query              = "select IFNULL(SUM(amount),0) as benefit from transactions where type = 'benefit' and service_provider_id = $service_provider_id and payment_status = 'paid'; ";
                        $total_paid_benefits     = $CommonModel->custome_query_single_record($query);
                        
                        $query              = "select IFNULL(SUM(amount),0) as penalty from transactions where type = 'penalty' and service_provider_id = $service_provider_id and payment_status = 'paid'; ";
                        $total_paid_penalty      = $CommonModel->custome_query_single_record($query);
                        
                        $totalpaidcredit        = $total_paid_credit->credit;
                        $totalpaidbenefits      = $total_paid_benefits->benefit;
                        $totalpaidpenalty       = $total_paid_penalty->penalty;
                        $totalrevenue           = $totalpaidcredit + $totalpaidbenefits - $totalpaidpenalty;
                        
                        ///////////////////////////////////////////////////
                        ///////////////////////////////////////////////////
                
                
                         $today = date('Y-m-d');
            	       // $query = "select sum(transaction_amount) as revenue from sop_applications where service_provider_id = $service_provider_id and transaction_status = 'TXN_SUCCESS' and date = '$today'" ;
            	       // $today_revenues = $CommonModel->custome_query_single_record($query);
                    //     $today_revenue = $today_revenues->revenue;
                        
                    //     $query = "select sum(transaction_amount) as revenue from sop_applications where service_provider_id = $service_provider_id and transaction_status = 'TXN_SUCCESS'" ;
            	       // $total_revenues = $CommonModel->custome_query_single_record($query);
                    //     $total_revenue = $today_revenues->revenue;
                        
                        
            	        $query = "select count(id) as total_applications from sop_applications where service_provider_id = $service_provider_id" ;
            	        $total_applications = $CommonModel->custome_query_single_record($query);
            	        
            	        
            	        $query = "select count(id) as total_applications from sop_applications where service_provider_id = $service_provider_id and date = '$today'" ;
            	        $today_applications = $CommonModel->custome_query_single_record($query);

                ?>

                <div class="row">

                    <!-- column -->
                    <div class="col-sm-12 col-lg-3">
                        <div class="card bg-light-info no-card-border">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="m-r-10">
                                        <span>Total Outstanding</span>
                                        <h4>₹ <?php echo $totaloutstanding; ?></h4>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="" id="ravenue"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-sm-12 col-lg-3">
                        <div class="card bg-light-warning no-card-border">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-10">
                                        <span>Total Revenue</span>
                                        <h4>₹ <?php echo $totalrevenue; ?></h4>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-sm-12 col-lg-3">
                        <div class="card bg-light-success no-card-border">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="m-r-10">
                                        <span>Total Applications</span>
                                        <h4><?php echo $total_applications->total_applications; ?></h4>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-sm-12 col-lg-3">
                        <div class="card bg-light-warning no-card-border">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-10">
                                        <span>Today's Applications</span>
                                        <h4><?php echo $today_applications->total_applications; ?></h4>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>

                
                
                <!-- ROW -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                           <?php
                                // $query = "select DATE_FORMAT(created, '%M-%Y') AS month, DATE_FORMAT(created, '%Y') AS year, DATE_FORMAT(created, '%M') AS months, SUM(transaction_amount) as total FROM orders where transaction_status = 'TXN_SUCCESS' and DATE_FORMAT(created, '%Y-%m-%d') >= CURDATE() - INTERVAL 6 MONTH group by DATE_FORMAT(created, '%M-%Y') Order by max(created) desc";
                                // $result = $CommonModel->custome_query($query);
                                
                                // $dataPoints = array();
                                
                                // foreach($result as $row)
                                // {
                                //     $data = array('label' => $row->month, 'y' => $row->total);
                                //     array_push($dataPoints,$data);
                                // }
                            ?>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div> 
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <?php
                    
                            //$query = "select DATE_FORMAT(created, '%M-%Y') AS month, count(id) as total FROM user_master  group by DATE_FORMAT(created, '%M-%Y') order by total desc";
                            // $query = "select DATE_FORMAT(created, '%M-%Y') AS month, count(id) as total FROM user_master where DATE_FORMAT(created, '%Y-%m-%d') >= CURDATE() - INTERVAL 6 MONTH group by DATE_FORMAT(created, '%M-%Y') order by max(created) desc";
                            // $result = $CommonModel->custome_query($query);
                            
                            // //print_r($result);
                            
                            // $dataPoints3 = array();
                            
                            // foreach($result as $row)
                            // {
                            //     $data = array('label' => $row->month, 'y' => $row->total);
                            //     array_push($dataPoints3,$data);
                            // }
                        ?>
                        <div id="chartContainer3" style="height: 370px; width: 100%;"></div>   
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- ROW -->
                <!-- ============================================================== -->
                
                <br/>
                <br/>
                <!-- ============================================================== -->
                <!-- ROW -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                       <?php
            
                            // $query = "SELECT o.address_id, u.id, a.id as area_id, a.area, count(a.id) as total_orders from orders o, user_address u, area a where o.address_id = u.id and u.area_id = a.id GROUP BY a.id  ";
                            // $result = $CommonModel->custome_query($query);
                            
                            // //print_r($result);
                            
                            // $dataPoints4 = array();
                            
                            // foreach($result as $row)
                            // {
                            //     $data = array('y' => $row->total_orders, 'label' => $row->area);
                            //     array_push($dataPoints4,$data);
                            // }
                        ?>
                        <div id="chartContainer4" style="height: 370px; width: 100%;"></div>     
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <?php
                    
                            // $query = "SELECT count(id) as android from user_master where device_type = 'android'";
                            // $aresult = $CommonModel->custome_query_single_record($query);
                            // $android = $aresult->android;
                            
                            
                            // $query = "SELECT count(id) as ios from user_master where device_type = 'ios'";
                            // $iresult = $CommonModel->custome_query_single_record($query);
                            // $ios = $iresult->ios;
                            
                            
                              
                            // $query = "SELECT count(id) as un from user_master where device_type IS NULL";
                            // $nresult = $CommonModel->custome_query_single_record($query);
                            // $nulls = $nresult->un;
                            
                            
                            // $query = "SELECT count(id) as b from user_master where device_type = '' ";
                            // $bresult = $CommonModel->custome_query_single_record($query);
                            // $blank = $bresult->b;
                            
                            // $unknown = $nulls + $blank;
                                
                            // //$results['android'] = $android;
                            // //$results['ios'] = $ios;
                            
                            // $results = array(
                            //                     array(
                            //                             "label" => "android",
                            //                             "total_users" => $android
                            //                         ),
                            //                         array(
                            //                             "label" => "ios",
                            //                             "total_users" => $ios,
                            //                         ),
                            //                         array(
                            //                             "label" => "unknown",
                            //                             "total_users" => $unknown,
                            //                         ),
                            //                 );
                            
                         
                            
                            // $dataPoints5 = array();
                          
                            //  foreach($results as $row)
                            // {
                                
                            // //print_r($row['total_users']);die;
                            //     $data = array('y' => $row['total_users'], 'label' => $row['label']);
                            //     array_push($dataPoints5,$data);
                            // }
                        ?>
                        <div id="chartContainer5" style="height: 370px; width: 100%;"></div>         
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- ROW -->
                <!-- ============================================================== -->
                
                
                
                <br/>
                <br/>
                <br/>
                


              
            
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        
        
     
        

            
    
            
        
        </div>
        
        

        
        
	</div>
	<!-- /Container -->

 <script>
        $(document).ready(function()
        {
       
            get_service_provider_inquiries();
    
            function get_service_provider_inquiries() 
            {
          
                var myurl = "<?php echo base_url().'/serviceproviderhome/get_service_provider_inquiries' ?>";
                $.ajax({
                    
                    url: myurl,
                    type: "GET",
     
                    success: function(message) {
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                            $("#inquiry_row").css("display", "none");
                           // alert(obj.message);  	
                        } else {
                           
                            $("#service_provider_inquiry").html(obj.service_provider_inquiry);
                        }
                    }
                });
            }
            
      
            $('body').on('click','.sop_application_request_accpet',function(e){
                var application_id = $(this).attr("data-id");
           
                swal({
                        title: "Are you sure?",
                        text: "You want to accept this SOP Application request ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, accept it!",
                        cancelButtonText: "No, cancel!",
                      
                      }).then(function()
                            {    
                                $.ajax({
                                      type: 'POST',
                                      url: '<?php echo base_url().'/serviceproviderhome/accept_sop_application' ?>',
                            
                                            data : { application_id : application_id },
                                         success: function(message) {
                                            obj = JSON.parse(message);
                                            var status = obj.status;
                                            if (status == 0) {
                                                alert(obj.message);
                                                $("#service_provider_inquiry").html('');
                                                get_service_provider_inquiries()
                                                  	
                                            } else {
                                                $("#service_provider_inquiry").html('');
                                                get_service_provider_inquiries()
                                            }
                                        }
                                });
                     
                            }).catch(function(reason){
                                    alert("The alert was dismissed by the user: ");
                            });    
                     
            });
            
            
            $('body').on('click','.sop_application_request_reject',function(e){
                var application_id = $(this).attr("data-id");
           
                swal({
                        title: "Are you sure?",
                        text: "You want to Reject this SOP Application request ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, reject it!",
                        cancelButtonText: "No, cancel!",
                      
                      }).then(function()
                            {    
                                $.ajax({
                                      type: 'POST',
                                      url: '<?php echo base_url().'/serviceproviderhome/reject_sop_application' ?>',
                            
                                            data : { application_id : application_id },
                                         success: function(message) {
                                            obj = JSON.parse(message);
                                            var status = obj.status;
                                            if (status == 0) {
                                               // alert(obj.message);  	
                                            } else {
                                               
                                                $("#service_provider_inquiry").html('');
                                                
                                                get_service_provider_inquiries()
                                            }
                                        }
                                });
                     
                            }).catch(function(reason){
                                    alert("The alert was dismissed by the user: ");
                            });    
                     
            });
            
          
            
          
        });

    </script>

		
		
    <script>
// window.onload = function () {
 
// var chart = new CanvasJS.Chart("chartContainer", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	title: {
// 		text: "Sales Revenue"
// 	},
// 	axisY: {
// 		suffix: "",
// 	},
// 	data: [{
// 		type: "column",
// 		yValueFormatString: "#,##0\"\"",
// 		indexLabel: "{y}",
// 		indexLabelPlacement: "inside",
// 		indexLabelFontColor: "white",
// 		dataPoints: <?php //echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
// 	}]
// });
// chart.render();
 



// var chart = new CanvasJS.Chart("chartContainer3", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	title: {
// 		text: "User's Analytics"
// 	},
// 	axisY: {
// 		suffix: "",
	
// 	},
// 	data: [{
// 		type: "column",
// 		yValueFormatString: "#,##0\"\"",
// 		indexLabel: "{y}",
// 		indexLabelPlacement: "inside",
// 		indexLabelFontColor: "white",
// 		dataPoints: <?php //echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
// 	}]
// });
// chart.render();



// var chart = new CanvasJS.Chart("chartContainer4", {
// 	theme: "light2", // "light1", "light2", "dark1", "dark2"
// 	exportEnabled: true,
// 	animationEnabled: true,
// 	title: {
// 		text: "Orders From Popular Area"
// 	},
// 	data: [{
// 		type: "pie",
// 		startAngle: 25,
// 		toolTipContent: "<b>{label}</b>: {y}",
// 		showInLegend: "true",
// 		legendText: "{label}",
// 		indexLabelFontSize: 16,
// 		indexLabel: "{label} - {y}",
// 			dataPoints: <?php //echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
		
// 	}]
// });
// chart.render();



// var chart = new CanvasJS.Chart("chartContainer5", {
// 	theme: "light1", // "light1", "light2", "dark1", "dark2"
// 	exportEnabled: true,
// 	animationEnabled: true,
// 	title: {
// 		text: "User Devices"
// 	},
// 	data: [{
// 		type: "pie",
// 		startAngle: 25,
// 		toolTipContent: "<b>{label}</b>: {y}",
// 		showInLegend: "true",
// 		legendText: "{label}",
// 		indexLabelFontSize: 16,
// 		indexLabel: "{label} - {y}",
// 			dataPoints: <?php //echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
		
// 	}]
// });
// chart.render();
 
// }
</script>