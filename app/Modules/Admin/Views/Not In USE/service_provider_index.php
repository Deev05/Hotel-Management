<?php use App\Models\CommonModel; 

    $CommonModel = new CommonModel;  ?>    
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            
            
           
            
            
            <div class="card-group">
                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10">
                                <span class="btn btn-circle btn-lg bg-warning">
                                    <i class="mdi mdi-google-earth text-white"></i>
                                </span>
                            </div>
                            <div>Tilte One </div>
                            <div class="ml-auto">
                                
                                <h2 class="m-b-0 font-light">100</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10">
                                <span class="btn btn-circle btn-lg bg-warning">
                                    <i class="mdi mdi-google-earth text-white"></i>
                                </span>
                            </div>
                            <div> Title Two </div>
                            <div class="ml-auto">
                                 <?php
                                    // $query = "select count(id) as total from products where status = 1 and is_deleted = 0";
                                    // $total = $CommonModel->custome_query_single_record($query);
                                    // $total_count = $total->total;
                                ?>
                                <h2 class="m-b-0 font-light">100</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10">
                                <span class="btn btn-circle btn-lg bg-warning">
                                    <i class="mdi mdi-google-earth text-white"></i>
                                </span>
                            </div>
                            <div> Title Three </div>
                            <div class="ml-auto">
                                 <?php
                                    // $query = "select count(id) as total from products where status = 1 and is_deleted = 0";
                                    // $total = $CommonModel->custome_query_single_record($query);
                                    // $total_count = $total->total;
                                ?>
                                <h2 class="m-b-0 font-light">150</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card -->
                <!-- Column -->
            </div>
            <!-- ============================================================== -->
            <!-- Info box -->
            <!-- ============================================================== -->
            
                            <!-- ============================================================== -->
                <!-- Sales Summery -->
                <!-- ============================================================== -->

                <div class="row">

                    <!-- column -->
                    <div class="col-sm-12 col-lg-3">
                        <div class="card bg-light-info no-card-border">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="m-r-10">
                                        <span>Total Revenue</span>
                                            <?php 
    									       // $query = "select sum(transaction_amount) as revenue from orders where transaction_status = 'TXN_SUCCESS'" ;
    									       // $subs = $CommonModel->custome_query_single_record($query);
    									    ?>
                                        <h4>₹0.00</h4>
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
                                        <span>Today's Revenue</span>
                                        <?php 
                //                             $today = date('Y-m-d');
									       // $query = "select sum(transaction_amount) as revenue from orders where transaction_status = 'TXN_SUCCESS' and order_date = '$today'" ;
									       // $today_r = $CommonModel->custome_query_single_record($query);
									    ?>
                                        <h4>₹0.00</h4>
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
                                        <span>Title</span>
                                        <?php 
                    //                         $today = date('Y-m-d');
    								        // $query = "select count(id) as total_orders from orders" ;
    								        // $total_orders = $CommonModel->custome_query_single_record($query);
    								    ?>
                                        <h4>157</h4>
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
                                        <span>Title Two</span>
                                        <?php 
                    //                         $today = date('Y-m-d');
    								        // $query = "select count(id) as today_orders from orders where order_date = '$today'" ;
    								        // $today_orders = $CommonModel->custome_query_single_record($query);
    								    ?>
                                        <h4>652</h4>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>

                
                
                
                
                <div class="card-group">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center text-info">Users</h4>
                            <?php 
            //                     $today = date('Y-m-d');
						      //  $query = "select count(id) as total_customers from user_master where status = 1";
						      //  $total_customers = $CommonModel->custome_query_single_record($query);
						    ?>
                            <h2>562</h2>
                            <div class="row p-t-10 p-b-10">
                                <!-- Column -->
                                <div class="col text-center align-self-center">
                                    <div data-label="20%" class="css-bar m-b-0 css-bar-primary css-bar-20">
                                        <i class="display-6 mdi mdi-account-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center text-danger">Active User's</h4>
                            <?php 
                     
							        //$query = "SELECT count(last_online) as last_online FROM user_master WHERE last_online > now() - INTERVAL 5 MINUTE ";
							        //$last_online = $CommonModel->custome_query_single_record($query);
							        /*print_r(NOW());
							        die;*/
							    ?>
                            <h2>+920 in Last 5 Mins</h2>
                            <div class="row p-t-10 p-b-10">
                                <!-- Column -->
                                <div class="col text-center align-self-center">
                                    <div data-label="20%" class="css-bar m-b-0 css-bar-danger css-bar-20">
                                        <i class="display-6 mdi mdi-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="text-center text-cyan">Total</h4>
                            <?php
                                //$query = "SELECT sum(quantity) as total_sold FROM order_items WHERE status = 4 and is_returned = 'false'";
						        //$sold = $CommonModel->custome_query_single_record($query);
                            ?>
                            <h2>124</h2>
                            <div class="row p-t-10 p-b-10">
                                <!-- Column -->
                                <div class="col text-center align-self-center">
                                    <div data-label="20%" class="css-bar m-b-0 css-bar-success css-bar-20">
                                        <i class="display-6 mdi mdi-briefcase-check"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- ============================================================== -->
                <!-- Sales Summery -->
                <!-- ============================================================== -->

                                <!-- ============================================================== -->
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