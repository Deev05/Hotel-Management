<?php

namespace App\Modules\Orders\Controllers;
use App\Modules\Orders\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once (APPPATH . '../PHPMailer/src/PHPMailer.php');
// require_once (APPPATH . '../PHPMailer/src/SMTP.php');
// require_once (APPPATH . '../PHPMailer/src/Exception.php');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

class Orders extends BaseController
{

    private $web_api = "AAAAtyCh2_g:APA91bEmZzaWwRLzcsGdjo5I12pM5q3u2cEKJSJJWMVzJXAwodAvFQ8q5PYVClVJJrz-wj3QIuOO4zaLUmRTW6ZaOwe3ystQaIhRZ92BnTvIt6RiBl0TrfA44iYGo7ejRD3CnRSVlE__";


    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        //$this->notification = new Notification;
        $this->table = "orders";
        helper(['form', 'url']);
    }

    // Index
    public function index()
    {

        $data['page_title'] = 'Orders';
        $data['page_headline'] = 'Orders';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['order']   = $this->CommonModel->get_all_data($this->table);
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);


        /////////////// Order Counts //////////////
        
        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day ";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['all_orders'] = count($allorders);
        
        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 0 ";
        $pendingorders   = $this->CommonModel->custome_query($query);
        $data['pending_orders'] = count($pendingorders);

        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 1 ";
        $acceptedorders   = $this->CommonModel->custome_query($query);
        $data['accepted_orders'] = count($acceptedorders);

        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 2 ";
        $processinggorders   = $this->CommonModel->custome_query($query);
        $data['processing_orders'] = count($processinggorders);

        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 3 ";
        $outfordeliveryorders   = $this->CommonModel->custome_query($query);
        $data['outfordelivery_orders'] = count($outfordeliveryorders);
        
        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 4 ";
        $deliveredorders   = $this->CommonModel->custome_query($query);
        $data['delivered_orders'] = count($deliveredorders);
        
        $query = "SELECT * FROM orders WHERE  created >= CURDATE() - interval 30 day AND order_status = 5 ";
        $failedorders   = $this->CommonModel->custome_query($query);
        $data['failed_orders'] = count($failedorders);

        /////////////// Order Counts //////////////
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Orders\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function get_data()
    {
        $label_filter = $this->request->getVar('label_filter');
        $filter_dates = $this->request->getVar('filter_dates');
        $startdate = "";
        $enddate = "";

        $where = '';
        $where .= " WHERE created >= CURDATE() - interval 30 day ";
        ///////////ORDER STATUS FILTER START
        if ($label_filter != "") {
            $where .= " AND order_status = $label_filter  ";
        }
        ///////////ORDER STATUS FILTER ENDS

        ///////////ORDER DATEWISE FILTER STARTS
        if (!empty($filter_dates)) {
            $split = explode('-', $filter_dates);

            #check make sure have 2 elements in array
            $count = count($split);
            if ($count <> 2) {
                #invalid data
            }

            $start = $split[0];

            $startdate = str_replace('/', '-', $start);
            $startdate = date('Y-m-d', strtotime($startdate));

            $end = $split[1];

            $enddate = str_replace('/', '-', $end);
            $enddate = date('Y-m-d', strtotime($enddate));


            if($label_filter == ""){

            }

            $where .= " AND (order_date BETWEEN '$startdate' AND '$enddate') ";
        }
        ///////////ORDER DATEWISE FILTER ENDS


        if (!empty($_REQUEST['search']['value'])) {
            $where .= " AND ( order_no LIKE '" . $_REQUEST['search']['value'] . "%' ";
            $where .= " OR tracking_no LIKE '" . $_REQUEST['search']['value'] . "%' )";
        }


        // $totalRecordsSql = "SELECT count(*) as total FROM orders $where;";
        $totalRecordsSql = "SELECT * FROM orders $where;";


        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);

        $columns = array(
            0 => 'id',
            2 => 'user_id',
            3 => 'order_no',
            4 => 'transaction_id',
            5 => 'transaction_amount',
            10 => 'created',
        );


        $sql = "SELECT *";
        $sql .= " FROM orders $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);


        $data_array = array();
        $count = 0;
        foreach ($result as  $row) {

            $filter = array('id' => $row->user_id);
            $user =  $this->CommonModel->get_single('user_master', $filter);

            $data['no']    = ++$count;
            $data['id']    = $row->id;
            $data['user_id']    = $user->full_name;
            $data['order_no']    = $row->order_no;
            $data['transaction_id']    = $row->transaction_id;
            $data['transaction_amount']    = $row->transaction_amount;
            $data['payment_type']    = $row->payment_type;
            $data['order_status']    = $row->order_status;
            $data['transaction_status']    = $row->transaction_status;
            $data['tracking_no']    = $row->tracking_no;
            $data['created']    = $row->created;
            
  
            $data['shipping_id']    = "";
       
         
            array_push($data_array, $data);
        }


        $json_data = array(
            "query" => $sql,
            "draw"            => intval($_REQUEST['draw']),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data_array
        );

        echo json_encode($json_data);
    }
    
    public function download_excel()
    {
        $label_filter = $this->request->getVar('label_filter');
        $filter_dates = $this->request->getVar('filter_dates');
        $startdate = "";
        $enddate = "";

        $where = '';
        $where .= " WHERE created >= CURDATE() - interval 30 day ";
        ///////////ORDER STATUS FILTER START
        if ($label_filter != "") {
            $where .= " AND order_status = $label_filter  ";
        }
        ///////////ORDER STATUS FILTER ENDS

        ///////////ORDER DATEWISE FILTER STARTS
        if (!empty($filter_dates)) {
            $split = explode('-', $filter_dates);

            #check make sure have 2 elements in array
            $count = count($split);
            if ($count <> 2) {
                #invalid data
            }

            $start = $split[0];

            $startdate = str_replace('/', '-', $start);
            $startdate = date('Y-m-d', strtotime($startdate));

            $end = $split[1];

            $enddate = str_replace('/', '-', $end);
            $enddate = date('Y-m-d', strtotime($enddate));


            if ($label_filter == "") {
            }

            $where .= " AND (order_date BETWEEN '$startdate' AND '$enddate') ";
        }
        ///////////ORDER DATEWISE FILTER ENDS

        $sql = "SELECT *";
        $sql .= " FROM orders $where";

        $result = $this->CommonModel->custome_query($sql);

        //////////// Excel Start //////////////
        
        $total_sell = 0;
        $total_cgst = 0;
        $total_sgst = 0;
        $total_tax = 0;
    

        $fileName = 'data-' . time() . '.xlsx';

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // set Header
        $sheet->SetCellValue('A1', 'User Name');
        $sheet->SetCellValue('B1', 'Order No');
        $sheet->SetCellValue('C1', 'Amount');
        $sheet->SetCellValue('D1', 'Delivery Charge');
        $sheet->SetCellValue('E1', 'Transaction Id');
        $sheet->SetCellValue('F1', 'Order Status');
        $sheet->SetCellValue('G1', 'Payment Mode');
        $sheet->SetCellValue('H1', 'Payment Status');
        // $sheet->SetCellValue('I1', 'Address');
        $sheet->SetCellValue('J1', 'Order Date');

        $rowCount = 2;

        ///////////////  Data Start //////////////

        foreach ($result as  $row) {

            ////////////////  User Start ///////////////////////
            $filter = array('id' => $row->user_id);
            $user =  $this->CommonModel->get_single('user_master', $filter);

            ////////////////  User End  ///////////////////////

            ////////////////  Order Items Start ///////////////////////
            $filter = array("order_id" => $row->id);
            $order_items = $this->CommonModel->get_by_condition('order_items', $filter);

            ////////////////  Order Items End ///////////////////////

            ////////////////  Order Status Start ///////////////////////

            $order_status = $row->order_status;

            if ($order_status == 0) {
                $status_label = "label-warning";
                $order_status = "Pending";
            } else if ($order_status == 1) {
                $status_label = "label-info";
                $order_status = "Accepted";
            } else if ($order_status == 2) {
                $status_label = "label-info";
                $order_status = "Processing";
            } else if ($order_status == 3) {
                $status_label = "label-primary";
                $order_status = "Out For Delivery";
            } else if ($order_status == 4) {
                $status_label = "label-success";
                $order_status = "Delivered";
            } else if ($order_status == 5) {
                $status_label = "label-danger";
                $order_status = "Failed";
            }

            ////////////////  Order Status End ///////////////////////


            ////////////////  Delivery Address Start ///////////////////////
            $address_id = $row->address_id;
            $filter = array("id" => $address_id);
            $single_address_details =  $this->CommonModel->get_single('user_address', $filter);
            // $delivery_address = $single_address_details->address_line_one . ", " . $single_address_details->address_line_two . ", " . $single_address_details->locality . ", " . $single_address_details->state . ", " . $single_address_details->pincode;
            // $delivery_address = $single_address_details->address_line_one;
            // print_r($delivery_address); die;

            ////////////////  Delivery Address End ///////////////////////


            ////////////////  Payment Type Start ///////////////////////]

            $payment_type = $row->payment_type;

            if ($payment_type == 'COD') {
                $payment_type_label = "label-info";
                $payment_type_desc = "COD";
            } else if ($payment_type == 'Online') {
                $payment_type_label = "label-primary";
                $payment_type_desc = "Online";
            }

            ////////////////  Payment Type End ///////////////////////


            ////////////////  Transaction Status Start ///////////////////////

            $transaction_status = $row->transaction_status;

            if ($transaction_status == "TXN_SUCCESS") {
                $payment_statuse_label = "label-success";
                $payment_status_desc = "Paid";
            } else if ($transaction_status == "TXN_FAILED") {
                $payment_statuse_label = "label-danger";
                $payment_status_desc = "Failed";
            } else if ($transaction_status == "TXN_PENDING") {
                $payment_statuse_label = "label-warning";
                $payment_status_desc = "Pending";
            } else {
                $payment_statuse_label = "label-warning";
                $payment_status_desc = "Pending";
            }

            ////////////////  Transaction Status End ///////////////////////

            ////////////////  Order Date Start ///////////////////////

            $orgDate    = $row->created;
            $order_date = date("d-m-Y h:i A", strtotime($orgDate));

            ////////////////  Order Date End ///////////////////////


            if (!empty($order_items)) {
                $sheet->SetCellValue('A' . $rowCount, $user->full_name);
                $sheet->SetCellValue('B' . $rowCount, $row->order_no);
                $sheet->SetCellValue('C' . $rowCount, $row->cart_total);
                $sheet->SetCellValue('D' . $rowCount, $row->delivery_charge);
                $sheet->SetCellValue('E' . $rowCount, $row->transaction_id);
                $sheet->SetCellValue('F' . $rowCount, $order_status);
                $sheet->SetCellValue('G' . $rowCount, $payment_type_desc);
                $sheet->SetCellValue('H' . $rowCount, $payment_status_desc);
                // $sheet->SetCellValue('I' . $rowCount, $delivery_address);
                $sheet->SetCellValue('J' . $rowCount, $order_date);

                $sheet->SetCellValue('A' . ++$rowCount, " ");

                $sheet->SetCellValue('B' . ++$rowCount, "Order Items");
                $sheet->SetCellValue('C' . $rowCount, "MRP");
                $sheet->SetCellValue('D' . $rowCount, "Sell Price");
                $sheet->SetCellValue('E' . $rowCount, "Quantity");
                $sheet->SetCellValue('F' . $rowCount, "Total");
                $sheet->SetCellValue('G' . $rowCount, "GST");
                $sheet->SetCellValue('H' . $rowCount, "CGST");
                $sheet->SetCellValue('I' . $rowCount, "SGST");
                
               
 
                foreach ($order_items as $order_item) {

                    $product_id = $order_item->product_id;

                    $filter = array("id" => $product_id);
                    $product = $this->CommonModel->get_single("products", $filter);
                    
                   

                    $sheet->SetCellValue('B' . ++$rowCount, $product->product_name);
                    $sheet->SetCellValue('C' . $rowCount, $order_item->actual_price);
                    $sheet->SetCellValue('D' . $rowCount, $order_item->order_price);
                    $sheet->SetCellValue('E' . $rowCount, $order_item->quantity);
                    $sheet->SetCellValue('F' . $rowCount, $order_item->amount);
                    $sheet->SetCellValue('G' . $rowCount, $order_item->gst);
                    $sheet->SetCellValue('H' . $rowCount, $order_item->cgst_amount);
                    $sheet->SetCellValue('I' . $rowCount, $order_item->sgst_amount);
                    
                    $total_sell += $order_item->amount;
                    $total_cgst += $order_item->cgst_amount;
                    $total_sgst += $order_item->sgst_amount;
                }
                
                $sheet->SetCellValue('J' . ++$rowCount, " ");
            }
            
            $rowCount++;
        }
        
        $total_tax = $total_cgst + $total_sgst;
        
        $sheet->SetCellValue('B' . $rowCount, "Total Sell");
        $sheet->SetCellValue('C' . $rowCount, $total_sell);
        $sheet->SetCellValue('B' . ++$rowCount, "Total CGST");
        $sheet->SetCellValue('C' . $rowCount, $total_cgst);
        $sheet->SetCellValue('B' . ++$rowCount, "Total SGST");
        $sheet->SetCellValue('C' . $rowCount, $total_sgst);
        $sheet->SetCellValue('B' . ++$rowCount, "Total Tax");
        $sheet->SetCellValue('C' . $rowCount, $total_tax);

        ///////////////  Data End   //////////////

        //////////////// File Part Start ////////////////

        $styleArray = array(
            'font' => array(
                'bold' => true
            )
        );
        

        $sheet->getStyle("A1:J1")->applyFromArray($styleArray);
        
        // $sheet = $spreadsheet->getActiveSheet();
        
        $filename = "List On" . date("d-M-Y") . ".xls";
        
        $writer = new Xlsx($spreadsheet);
        
        //$writer->save($filename);
       
        // $writer->save('php://output');
        
       /* header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        header('Content-Length:' . filesize($filename));
*/
        $writer->save("uploads/excel/".$fileName);
        
        $message = ['status' => '1','message' => 'success', 'download_url' => base_url().'/uploads/excel/'.$fileName];
        echo json_encode($message);
        die;
   
        
  
        
   
        //redirect(base_url()."/uploads/excel/".$fileName); 
        // header('Content-Type: application/vnd.ms-excel'); 
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0'); 
        // $writer = new Xlsx($spreadsheet);
        // $writer->save($filename);


        //////////////// File Part End ////////////////



        //////////// Excel End ////////////////

    }

    public function get_order_data()
    {
        $id = $this->request->getVar('id');


        $filter = array("id" => $id);
        $order = $this->CommonModel->get_single('orders', $filter);

        $user_id = $order->user_id;
        $order_items_id = $order->id;
        $address_id = $order->address_id;
        $order_status = $order->order_status;
        $payment_type = $order->payment_type;
        $transaction_status = $order->transaction_status;
        $order_no = $order->order_no;

        ////////////////  Get User  ///////////////////////
        $filter = array("id" => $user_id);
        $user_details =  $this->CommonModel->get_single('user_master', $filter);

        ////////////////  Get Order Items  ///////////////////////
        $filter = array("order_id" => $order_items_id);
        $order_items = $this->CommonModel->get_by_condition('order_items', $filter);

        ////////////////  Get Address  ///////////////////////
        $filter = array("user_id" => $user_id);
        $address_details = $this->CommonModel->get_by_condition('user_address', $filter);

        ////////////////  Delivery Address  ///////////////////////
        $filter = array("user_id" => $user_id);
        $single_address_details =  $this->CommonModel->get_single('user_address', $filter);

        $city_id 		= $single_address_details->city_id;
        $pincode_id 	= $single_address_details->pincode_id;
        $area_id 		= $single_address_details->area_id;
        $locality_id 	= $single_address_details->locality_id;
        
        $filter = array("id" => $city_id);
        $citys = $this->CommonModel->get_single("city",$filter);
        $city = $citys->name; 
        
        $filter = array("id" => $pincode_id);
        $pincodes = $this->CommonModel->get_single("pincodes",$filter);
        $pincode = $pincodes->pincode; 
        
        $filter = array("id" => $area_id);
        $areas = $this->CommonModel->get_single("area",$filter);
        $area = $areas->area; 
        
        $filter = array("id" => $locality_id);
        $localitys = $this->CommonModel->get_single("locality",$filter);
        $locality = $localitys->locality; 

        $is_default         = $single_address_details->is_default;
        $name        	    = $single_address_details->name;
        $contact            = $single_address_details->contact;
        $type        	    = $single_address_details->type;
        $delivery_address   = $single_address_details->address_line_one .", ". $single_address_details->address_line_two .", ". $locality . ", " .$area .", " . $city . ", ". $pincode;;

        //$delivery_address = $single_address_details->address_line_one . ", " . $single_address_details->address_line_two . ", " . $single_address_details->locality . ", " . $single_address_details->state . ", " . $single_address_details->pincode;

        ////////////////  Order Status  ///////////////////////



        if ($order_status == 0) {
            $status_label = "label-warning";
            $order_status = "Pending";
        } else if ($order_status == 1) {
            $status_label = "label-info";
            $order_status = "Accepted";
        } else if ($order_status == 2) {
            $status_label = "label-info";
            $order_status = "Processing";
        } else if ($order_status == 3) {
            $status_label = "label-primary";
            $order_status = "Out For Delivery";
        } else if ($order_status == 4) {
            $status_label = "label-success";
            $order_status = "Delivered";
        } else if ($order_status == 5) {
            $status_label = "label-danger";
            $order_status = "Failed";
        }

        ////////////////  Payment Type  ///////////////////////

        if ($payment_type == 'COD') {
            $payment_type_label = "label-info";
            $payment_type_desc = "COD";
        } else if ($payment_type == 'Online') {
            $payment_type_label = "label-primary";
            $payment_type_desc = "Online";
        }else if ($payment_type == 'PAYLATER') {
            $payment_type_label = "label-info";
            $payment_type_desc = "Paylater";
        }

        ////////////////  Transaction Status  ///////////////////////


        if ($transaction_status == "TXN_SUCCESS") {
            $payment_statuse_label = "label-success";
            $payment_status_desc = "Paid";
        } else if ($transaction_status == "TXN_FAILED") {
            $payment_statuse_label = "label-danger";
            $payment_status_desc = "Failed";
        } else if ($transaction_status == "TXN_PENDING") {
            $payment_statuse_label = "label-warning";
            $payment_status_desc = "Pending";
        } else {
            $payment_statuse_label = "label-warning";
            $payment_status_desc = "Pending";
        }


        ////////////////  Model  ///////////////////////

        $modal_title = 'Order Details of Order No : ' . $order_no;


        $order_details = '
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Groups</h4>
                            <div class="list-group">
                                <p class="list-group-item"><i class="fas fa-user m-r-10"></i> Full Name : ' . $user_details->full_name . ' </p>
                                <p class="list-group-item"><i class="fas fa-envelope m-r-10"></i> Email : ' . $user_details->email . '</p>
                                <p class="list-group-item"><i class="fas fa-phone m-r-10"></i> Phone : ' . $user_details->contact . '</p>
                                <p class="list-group-item"><i class="fas fa-calendar-alt m-r-10"></i> Order Date : ' . $order->order_date . '</p>
                                <p class="list-group-item"><i class="fas fa-map-pin m-r-10"></i> Delivery Address : ' . $delivery_address . '</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="card-title">Groups</h4>
                            <div class="list-group">
                                <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Order Number : ' . $order_no . '</p>
                                <p class="list-group-item"><i class="far fa-dot-circle m-r-10"></i> Order Status : <span class="label ' . $status_label . ' font-weight-100">' . $order_status . '</span></p>
                                <p class="list-group-item"><i class="far fa-credit-card m-r-10"></i> Payment Mode : <span class="label ' . $payment_type_label . ' font-weight-100">' . $payment_type_desc . '</span></p>
                                <p class="list-group-item"><i class="far fa-dot-circle m-r-10"></i> Payment Status : <span class="label ' . $payment_statuse_label . ' font-weight-100">' . $payment_status_desc . '</span></p>
                                <p class="list-group-item"><i class="fas fa-shopping-bag m-r-10"></i> Order Total : ' . $order->transaction_amount . ' </p>
                            </div>
                        </div>
                    </div>
                    
                   <button id="stock_info_button" data-orderid="' . $order->id . '" type="button" class="btn waves-effect waves-light btn-success">Stock</button>
        ';



        ////////////////  Table  ///////////////////////

        $result_html = '';
        $count = 0;

        foreach ($order_items as $row) {
            $filter = array('id' => $row->product_id);
            $product =  $this->CommonModel->get_single('products', $filter);

            $image_url = base_url() . "/uploads/products/" . $product->product_image;

            if ($row->status == 0) {
                $item_status = "Pending";
            } else if ($row->status == 1) {
                $item_status = "Picked Up";
            } else if ($row->status == 2) {
                $item_status = "Not Available/Cancelled";
            } else {
                $item_status = "In Review";
            }
            
            
        $filter = array("is_deleted" => 0);
        $warehouse = $this->CommonModel->get_by_condition('warehouse',$filter);

        $product_id = $row->product_id;
        
        
        
        $available_qty = array();
        foreach($warehouse as $rows)
        {
            $add_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $product_id and type='Add'";
            $total_add = $this->CommonModel->custome_query_single_record($add_query);

            $sub_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $product_id and type='Sub'";
            $total_sub = $this->CommonModel->custome_query_single_record($sub_query);

            $available_quantity = $total_add->total_sum -  $total_sub->total_sum;

            $data['warehouse_id']         = $rows->id;
            $data['warehouse_name']         = $rows->name;
            $data['available_quantity']     = $available_quantity;

            array_push($available_qty,$data);

        }

            $result_html .= '
            
            <tr>
                <td>' . ++$count . '</td>
                <td>' . $product->product_name . '</td>
                <td> <img src="' . $image_url . '" height="80px" width="80px" ></td>
                <td>' . $row->quantity . '</td>
                <td>' . $row->order_price . '</td>
                <td>' . $row->amount . '</td>
                <td>' . $item_status . '</td>
                 </tr>';
                                    
     
                
           
            
        }
        
 
        $message = ['status' => '1', 'message' => 'Driver Assigned!', 'table_data' => $result_html, 'order_details' => $order_details, 'modal_title' => $modal_title];
        echo json_encode($message);
        die;
        return $this->response->setJSON($message);
    }
    


    public function change_order_status()
    {
       
        $order_status = $this->request->uri->getSegment(3);
        $order_id = $this->request->uri->getSegment(4);


        $filter = array("id" => $order_id);
        $update_data = array("order_status" => $order_status);
        $update = $this->CommonModel->update_data('orders', $update_data, $filter);

        $filter = array("order_id" => $order_id);
        $order_items = $this->CommonModel->get_by_condition('order_items', $filter);

        $filter = array("order_id" => $order_id);
        $update_data = array("status" => $order_status);
        $update = $this->CommonModel->update_data('order_items', $update_data, $filter);
        if ($update != false) {
            
            
            $filter = array("id" => $order_id);
            $order_data = $this->CommonModel->get_single("orders",$filter);
            $user_id = $order_data->user_id;
            
            if ($order_status == 0) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Your order is Pending ! We will deliver your order in short time.";
            } 
            else if ($order_status == 1) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Your order is Accepted ! We will deliver your order in short time.";
            } 
            else if ($order_status == 2) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Your order is now processing ! We will deliver your order in short time.";
            } 
            else if ($order_status == 3) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Out For Delivery ! Our delivery partner is on the way to deliver your Order";
            } 
            else if ($order_status == 4) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Order Delivered ! Thanks for orderding";
            } 
            else if ($order_status == 5) 
            {
                $title = "Order Update ". $order_data->order_no;
                $message = "Order Failed ! Please contact admin for more information";
            }
            
            $data['order_data'] = $this->CommonModel->get_single("orders",$filter);
            $data['title']=$title;
            $data['message']=$message;
            $data['user']=$this->CommonModel->get_single("user_master",array('id'=>$data['order_data']->user_id));

            // if($data['user']->email!='' && $data['user']->email!=Null){
            //     $msg=view('email/order_status',$data);
            //     $this->order_status_mail($data['user']->email,$data['user']->full_name,$msg);
            // }

            $filter         = array("id" => $user_id);
            $user           = $this->CommonModel->get_single("user_master",$filter);
            $token          = $user->token;
            $token_array    = array($token);
            
            // $imageUrl   = ""; 
 
    		// require_once __DIR__ . '/Notification.php';
    		// $notification = $this->notification;
    		// $notification->setTitle($title);
    		// $notification->setMessage($message);
    		// $notification->setImage($imageUrl);
    		// $firebase_api = $this->web_api;
    		// $requestData = $notification->getNotificatin();
    		// $fields = array(
    		// 	'registration_ids' => $token_array,
    		// 	'data' => $requestData,
    		// 	'priority' => 'high',
    		// 	'notification' => array(
    		// 	'title' => $title,
    		// 	'body' => $message,
    		// 	'image' => $imageUrl,
    		// 	)
    		// );
    		// $url = 'https://fcm.googleapis.com/fcm/send';
    
    		// $headers = array(
    		// 	'Authorization: key=' . $firebase_api,
    		// 	'Content-Type: application/json'
    		// 	);
    	
    		// $ch = curl_init();
    		// curl_setopt($ch, CURLOPT_URL, $url);
    		// curl_setopt($ch, CURLOPT_POST, true);
    		// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		// $result = curl_exec($ch);
    		// if($result === FALSE){
    		// 	die('Curl failed: ' . curl_error($ch));
    		// }
    		// curl_close($ch);
     		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
     		echo json_encode($fields,JSON_PRETTY_PRINT);
     		echo '</pre></p><h3>Response </h3><p><pre>';
     		echo $result;
    		echo '</pre></p>';
    		die;*/

            $message = ['status' => '1', 'message' => 'Order Status Updated!'];
            echo json_encode($message);
            die;
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong'];
            echo json_encode($message);
            die;
        }
    }

    public function change_transaction_status()
    {
        $order_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $order_id);
        $update_data = array("transaction_status" => "TXN_SUCCESS");
        $update = $this->CommonModel->update_data('orders', $update_data, $filter);
        
        if ($update != false) 
        {
            $message = ['status' => '1', 'message' => 'Transaction Status Updated!'];
            echo json_encode($message);
            die;
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong'];
            echo json_encode($message);
            die;
        }
    }

    public function order_invoice()
    {
        $order_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $order_id);
        $data['orders'] = $this->CommonModel->get_single('orders', $filter);

        $filter = array("order_id" => $order_id);
        $data['order_items'] = $this->CommonModel->get_by_condition('order_items', $filter);

        $data['page_title'] = 'Orders';
        $data['page_headline'] = 'Orders';
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Orders\Views\order_invoice', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
        public function order_details()
    {
        $order_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $order_id);
        $data['orders'] = $this->CommonModel->get_single('orders', $filter);

        $filter = array("order_id" => $order_id);
        $data['order_items'] = $this->CommonModel->get_by_condition('order_items', $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        $user_id = $data['orders']->user_id;
        $filter = array("id" => $user_id);
        $data['user_details'] =  $this->CommonModel->get_single('user_master', $filter);

        ////////////////  Delivery Address  ///////////////////////
        $address_id = $data['orders']->address_id;
        $filter = array("id" => $address_id);
        $single_address_details =  $this->CommonModel->get_single('user_address', $filter);

        $city_id 		= $single_address_details->city_id;
        $pincode_id 	= $single_address_details->pincode_id;
        $area_id 		= $single_address_details->area_id;
        $locality_id 	= $single_address_details->locality_id;
        
        $filter = array("id" => $city_id);
        $citys = $this->CommonModel->get_single("city",$filter);
        $city = $citys->name; 
        
        $filter = array("id" => $pincode_id);
        $pincodes = $this->CommonModel->get_single("pincodes",$filter);
        $pincode = $pincodes->pincode; 
        
        $filter = array("id" => $area_id);
        $areas = $this->CommonModel->get_single("area",$filter);
        $area = $areas->area; 
        
        $filter = array("id" => $locality_id);
        $localitys = $this->CommonModel->get_single("locality",$filter);
        $locality = $localitys->locality; 

        $is_default     = $single_address_details->is_default;
        $name        	= $single_address_details->name;
        $contact        = $single_address_details->contact;
        $type        	= $single_address_details->type;
        $data['delivery_address']   = $single_address_details->address_line_one .", ". $single_address_details->address_line_two .", ". $locality . ", " .$area .", " . $city . ", ". $pincode;;

       // $data['delivery_address'] = $single_address_details->address_line_one . ", " . $single_address_details->address_line_two . ", " . $single_address_details->locality . ", " . $single_address_details->state . ", " . $single_address_details->pincode;


        ////////////////  Order Status  ///////////////////////
        $order_status = $data['orders']->order_status;

        if ($order_status == 0) {
            $data['status_label'] = "label-warning";
            $data['order_status'] = "Pending";
        } else if ($order_status == 1) {
            $data['status_label'] = "label-info";
            $data['order_status'] = "Accepted";
        } else if ($order_status == 2) {
            $data['status_label'] = "label-info";
            $data['order_status'] = "Processing";
        } else if ($order_status == 3) {
            $data['status_label'] = "label-primary";
            $data['order_status'] = "Out For Delivery";
        } else if ($order_status == 4) {
            $data['status_label'] = "label-success";
            $data['order_status'] = "Delivered";
        } else if ($order_status == 5) {
            $data['status_label'] = "label-danger";
            $data['order_status'] = "Failed";
        }

        ////////////////  Payment Type  ///////////////////////
        $payment_type = $data['orders']->payment_type;

        if ($payment_type == 'COD') {
            $data['payment_type_label'] = "label-info";
            $data['payment_type_desc'] = "COD";
        } else if ($payment_type == 'Online') {
            $data['payment_type_label'] = "label-primary";
            $data['payment_type_desc'] = "Online";
        }else if ($payment_type == 'PAYLATER') {
            $data['payment_type_label'] = "label-primary";
            $data['payment_type_desc'] = "Paylater";
        }

        ////////////////  Transaction Status  ///////////////////////
        $transaction_status = $data['orders']->transaction_status;

        if ($transaction_status == "TXN_SUCCESS") {
            $data['payment_statuse_label'] = "label-success";
            $data['payment_status_desc'] = "Paid";
        } else if ($transaction_status == "TXN_FAILED") {
            $data['payment_statuse_label'] = "label-danger";
            $data['payment_status_desc'] = "Failed";
        } else if ($transaction_status == "TXN_PENDING") {
            $data['payment_statuse_label'] = "label-warning";
            $data['payment_status_desc'] = "Pending";
        } else {
            $data['payment_statuse_label'] = "label-warning";
            $data['payment_status_desc'] = "Pending";
        }

        $data['page_title'] = 'Order Details Of #' . $data['orders']->order_no;
        $data['page_headline'] = 'Order Details Of #' . $data['orders']->order_no;

        $data['summary_title'] = 'Order Summary Of #' . $data['orders']->order_no;
        $data['items_title'] = 'Order Items Of #' . $data['orders']->order_no;
        $data['order_no'] = $data['orders']->order_no;

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Orders\Views\order_details', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }

    public function update_order_summary()
    {
        $update_id          = $this->request->uri->getSegment(3);
        $cart_total         = $this->request->getVar('cart_total');
        $delivery_charge    = $this->request->getVar('delivery_charge');
        $transaction_amount = $this->request->getVar('transaction_amount');

        $data = array(
            'cart_total'            => $cart_total,
            'delivery_charge'       => $delivery_charge,
            'transaction_amount'    => $transaction_amount
        );

        $update = $this->CommonModel->common_update_data($this->table, $update_id, $data);

        if ($update != false) {
            $_SESSION['message'] = 'Order Summary Updated!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('orders/order_details/'. $update_id));
        } else {
            $_SESSION['message'] = 'No Changes Found!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('orders/order_details/'. $update_id));
        }
    }

    public function data_table()
    {

        ////////////////  Table  ///////////////////////
        //$query = "SELECT * FROM orders WHERE created >= CURDATE() - interval 30 day order by id desc";
        //$orders   = $this->CommonModel->custome_query($query);

        $filter = array("is_deleted" => 0);
        $orders   = $this->CommonModel->get_all_data($this->table);
        $result_html = '';
        $count = 0;

        foreach ($orders as $row) {

            ///////////////  User Details  /////////////////
            $filter = array('id' => $row->user_id);
            $user =  $this->CommonModel->get_single('user_master', $filter);

            ///////////////  Payment Type  /////////////////
            if ($row->payment_type == 'COD') {
                $payment_type_label = "label-info";
                $payment_type_desc = "COD";
            } else if ($row->payment_type == 'Online') {
                $payment_type_label = "label-primary";
                $payment_type_desc = "Online";
            }

            ///////////////  Order Status  /////////////////
            if ($row->order_status == 0) {
                $status_label = "label-warning";
                $order_status = "Pending";
            } else if ($row->order_status == 1) {
                $status_label = "label-info";
                $order_status = "Accepted";
            } else if ($row->order_status == 2) {
                $status_label = "label-info";
                $order_status = "Processing";
            } else if ($row->order_status == 3) {
                $status_label = "label-primary";
                $order_status = "OutForDelivery";
            } else if ($row->order_status == 4) {
                $status_label = "label-success";
                $order_status = "Delivered";
            } else if ($row->order_status == 5) {
                $status_label = "label-danger";
                $order_status = "Failed";
            }


            ///////////////  Transaction Status  /////////////////
            if ($row->transaction_status == "TXN_SUCCESS") {
                $payment_statuse_label = "label-success";
                $payment_status_desc = "Paid";
            } else if ($row->transaction_status == "TXN_FAILED") {
                $payment_statuse_label = "label-danger";
                $payment_status_desc = "Failed";
            } else if ($row->transaction_status == "TXN_PENDING") {
                $payment_statuse_label = "label-warning";
                $payment_status_desc = "Pending";
            } else {
                $payment_statuse_label = "label-warning";
                $payment_status_desc = "Pending";
            }

            $result_html .= '
            <tr>
                <td>' . ++$count . '</td>
                <td class="id" hidden>' . $row->id . '</td>
                <td>' . $user->full_name . '</td>
                <td>' . $row->order_no . '</td>
                <td>' . $row->transaction_id . '</td>
                <td>' . $row->transaction_amount . '</td>
                <td><center><span class="label ' . $payment_type_label . ' font-weight-100"> ' . $payment_type_desc . ' </span></center></td>
                <td><center><span class="label ' . $status_label . ' font-weight-100"> ' . $order_status . ' </span></center></td>
                <td><center><span class="label ' . $payment_statuse_label . ' font-weight-100"> ' . $payment_status_desc . ' </span></center></td>
                <td>' . $row->created . '</td>
                <td><center><a href="' . base_url("orders/order_invoice/" . $row->id) . '" class="btn btn-primary btn-circle "><i class="icon-Receipt-3"></i></a></center></td>
                <td>
                    <center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-circle dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i> </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item list-group-item list-group-item-warning" href="' . base_url("orders/change_order_status/0/" . $row->id) . '">Panding</a>
                                <a class="dropdown-item list-group-item list-group-item-info" href="' . base_url("orders/change_order_status/1/" . $row->id) . '">Accept</a>
                                <a class="dropdown-item list-group-item list-group-item-info" href="' . base_url("orders/change_order_status/2/" . $row->id) . '">Processing</a>
                                <a class="dropdown-item list-group-item list-group-item-primary" href="' . base_url("orders/change_order_status/3/" . $row->id) . '">Out For Delivery</a>
                                <a class="dropdown-item list-group-item list-group-item-success" href="' . base_url("orders/change_order_status/4/" . $row->id) . '">Delivered</a>
                                <a class="dropdown-item list-group-item list-group-item-danger" href="' . base_url("orders/change_order_status/5/" . $row->id) . '">Failed</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-circle view"><i class="fa fa-eye"></i> </button>
                    </center>
                </td>
             
            </tr>';
        };
        $message = ['status' => '1', 'table_data' => $result_html];
        echo json_encode($message);
        die;
    }

    public function order_table()
    {
        
        $label_filter = $this->request->getVar('label_filter');
        $filter_dates = $this->request->getVar('filter_dates');
        $startdate = "";
        $enddate = "";
        
        
        
        ///////////ORDER STATUS FILTER START
        if($label_filter == "")
        {
            $query = "SELECT * FROM orders WHERE ";
        }
        else
        {
            $query = "SELECT * FROM orders WHERE order_status = $label_filter AND ";
        }
        ///////////ORDER STATUS FILTER ENDS
        
        ///////////ORDER DATEWISE FILTER STARTS
        if(!empty($filter_dates))
        {
            $split = explode('-', $filter_dates);
    
            #check make sure have 2 elements in array
            $count = count($split);
            if($count <> 2){
              #invalid data
            }
    
            $start = $split[0];
            
            $startdate = str_replace('/', '-', $start);
            $startdate = date('Y-m-d', strtotime($startdate));
            
            $end = $split[1];
            
            $enddate = str_replace('/', '-', $end);
            $enddate = date('Y-m-d', strtotime($enddate));
            
            
            $query .= "(order_date BETWEEN '$startdate' AND '$enddate') AND ";
            
        }
        ///////////ORDER DATEWISE FILTER ENDS
        
        
        $query .= "created >= CURDATE() - interval 30 day ";

        $data   = $this->CommonModel->custome_query($query);
         
 

        foreach ($data as $row) {
            $filter = array('id' => $row->user_id);
            $user = $this->CommonModel->get_by_condition('user_master', $filter);

            foreach ($user as $user_row) {
                $user_name = $user_row->full_name;
            }
        }

        $json_data = array(
            // "draw" => intval($params['draw']),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "filter_dates" => $filter_dates,
            "start" => $startdate,
            "end" => $enddate,
            "query" => $query,
            "label_filter" => $label_filter,
            "user_name" => $user_name,
            "data" => $data   // total data array
        );
        echo json_encode($json_data);
    }

    public function tracking_order()
    {
        $id = $this->request->getVar('id');
        $tracking_no = $this->request->getVar('tracking_no');

        $update_data = array(
            "tracking_no" => $tracking_no,
        );
        $update = $this->CommonModel->common_update_data($this->table,$id,$update_data);

        if ($update != false) {
            $_SESSION['message'] = 'Tracking Details Added!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('orders'));
        } else {
            $_SESSION['message'] = 'No Changes Found!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('orders'));
        }
    }
    
    public function get_sub_category()
    {
        $main_category_id = $this->request->getVar('main_category_id');

        $filter = array("main_category_id" => $main_category_id);
        $data = $this->CommonModel->get_by_condition('sub_category', $filter);
        echo json_encode($data);
    }

    public function get_sub_sub_category()
    {
        $sub_category_id = $this->request->getVar('sub_category_id');

        $filter = array("sub_category_id" => $sub_category_id);
        $data = $this->CommonModel->get_by_condition('sub_sub_category', $filter);
        echo json_encode($data);
    }

    public function get_product()
    {
        //$category_id = $this->request->getVar('category_id');
        $category_id = 5;

        $filter = array("category_id" => $category_id);
        $data = $this->CommonModel->get_by_condition('products', $filter);
        echo json_encode($data);
    }

    public function get_product_variation()
    {
        $product_id = $this->request->getVar('product');

        $filter = array("product_id" => $product_id);
        $data = $this->CommonModel->get_by_condition('product_variation', $filter);
        echo json_encode($data);
    }

    public function insert_product()
    {
        $user_id    = $this->request->getVar('user_id');
        $order_id   = $this->request->getVar('order_id');
        $product_id = $this->request->getVar('product');
        $quantity   = $this->request->getVar("quantity");


        $filter     = array("id" => $product_id);
        $products   = $this->CommonModel->get_single("products", $filter);


        $discount               = $products->product_price - $products->product_sell_price;
        $discount_percentage    = ($discount / $products->product_price) * 100;
        $discount_percentages   = round($discount_percentage);

        $offer_price    = $products->product_price * $quantity - $products->product_sell_price * $quantity;
        $offer_prices   = sprintf("%.2f", $offer_price);

        $days           = 7;
        $pay_date       = date('Y-m-d');
        $expiry_date    = date('Y-m-d', strtotime("+" . $days . " day"));
        $expiry_date    = date('Y-m-d', strtotime($pay_date . ' + ' . $days . ' days'));

        $insert_data = array(
            "user_id"               =>  $user_id,
            "order_id"              =>  $order_id,
            "product_id"            =>  $product_id,
            "actual_price"          =>  $products->product_price,
            "quantity"              =>  $quantity,
            "order_price"           =>  $products->product_sell_price,
            "discount"              =>  $offer_prices,
            "amount"                =>  $products->product_sell_price * $quantity,
            "status"                =>  0,
            "return_expiry_date"    =>  $expiry_date,
            "created"               =>  date('Y-m-d H:i:s'),
            "note"                  =>  ""
        );

        $insert = $this->CommonModel->common_insert_data("order_items", $insert_data);

        if ($insert != false) {
            session()->setFlashdata('msg', 'Your order was placed successfully!');
            return redirect()->to($_SERVER['HTTP_REFERER']);
        } else {
            session()->setFlashdata('error', 'Error! Please Try Again Later!');
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }
    
    
    public function send_notification($token_array,$title,$message)
    {
    

    	
     	$title = $this->request->getVar('title');
     	
     	$message = $this->request->getVar('message');
     	
     	$imageUrl   = "https://ok.graphionicinfotech.com//uploads/setting/1681022272_941.png"; 
     	
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notification.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
     		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
     		echo json_encode($fields,JSON_PRETTY_PRINT);
     		echo '</pre></p><h3>Response </h3><p><pre>';
     		echo $result;
    		echo '</pre></p>';
    		die;
    	}
    	
    	/***************************Notification********************************/
    }
    
    
 
    public function order_status_mail($email,$name,$msg){
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            //$mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'viviifashion6@gmail.com';                     //SMTP username
            $mail->Password   = 'ynunfilrpxwonzgx';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = '587';                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('info@viviifashion.com', 'ViviiFashion');
            $mail->addAddress($email, $name);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@viviifashion.com', 'ViviiFashion');
            
            $mail->Subject = 'Your Order Status';
            $mail->Body    = $msg;
            $mail->IsHTML(true);
            $mail->send();
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function get_item_stock_details()
    {
        $order_id = $this->request->uri->getSegment(3);
        
        $filter = array("order_id" => $order_id);
        $order_items = $this->CommonModel->get_by_condition("order_items",$filter);
      
        $result_html = '';
        $result_html .= '
                        <form method="POST" enctype="multipart/form-data" role="form"  action="'.base_url().'orders/update_quantity" id="stock_update_form" name="stock_update_form">
                                    <div class="modal-body">';
        
        foreach($order_items as $order_item)
        {
            $item_id = $order_item->id;
            
            
            $filter = array("id" => $item_id);
            $item_details = $this->CommonModel->get_single("order_items",$filter);
            
            $filter = array("id" => $order_item->product_id);
            $product = $this->CommonModel->get_single("products",$filter);
            
            $filter = array("product_id" => $order_item->product_id);
            $batch  = $this->CommonModel->get_by_condition("purchase_items",$filter);
            
            $product_id = $item_details->product_id;
            
            $available_qty = array();
            foreach($batch as $row)
            {
                $filter = array("id" => $row->warehouse_id);
                $warehouse = $this->CommonModel->get_single("warehouse",$filter);
                
                $filter = array("id" => $row->purchase_id);
                $purchase = $this->CommonModel->get_single("purchases",$filter);
                
                // $filter = array("id" => $purchase->batch);
                // $batch_data = $this->CommonModel->get_single("batch",$filter);
                
                $add_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->warehouse_id and product_id = $product_id and type='Add'";
                $total_add = $this->CommonModel->custome_query_single_record($add_query);
    
                $sub_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->warehouse_id and product_id = $product_id and type='Sub'";
                $total_sub = $this->CommonModel->custome_query_single_record($sub_query);
    
                $available_quantity = $total_add->total_sum -  $total_sub->total_sum;
                
                $data['purchase_item_id']       = $row->id;
                $data['warehouse_id']           = $warehouse->id;
                $data['warehouse_name']         = $warehouse->name;
                $data['batch_name']             = $purchase->batch;
                $data['available_quantity']     = $available_quantity;
    
                array_push($available_qty,$data);
    
            }
            
            // $filter = array("is_deleted" => 0);
            // $warehouse = $this->CommonModel->get_by_condition('warehouse',$filter);
    
            // $product_id = $item_details->product_id;
            
            // $available_qty = array();
            // foreach($warehouse as $row)
            // {
            //     $add_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $product_id and type='Add'";
            //     $total_add = $this->CommonModel->custome_query_single_record($add_query);
    
            //     $sub_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $product_id and type='Sub'";
            //     $total_sub = $this->CommonModel->custome_query_single_record($sub_query);
    
            //     $available_quantity = $total_add->total_sum -  $total_sub->total_sum;
    
            //     $data['warehouse_id']         = $row->id;
            //     $data['warehouse_name']         = $row->name;
            //     $data['available_quantity']     = $available_quantity;
    
            //     array_push($available_qty,$data);
    
            // }
            
                                            $result_html .= '
                                                <div class="form-group">
                                                
                                                
                                                    
                                                    <img src="'.base_url().'uploads/products/'.$product->product_image.'" height="30"> <label for="tracking_no" class="control-label">Select Warehouse for '.$product->product_name.'</label> 
                                                    <select id="warehouse_id" name="warehouse_id[]" class="form-control">
                                                        <option value="">Select Warehouse </option>';
                                                         if(!empty($available_qty))
                                                                {
                                                                    foreach($available_qty as $row)
                                                                    {
                                                                        $result_html .='
                                                                            <option value="'.$row['warehouse_id'].'" > '.$row['batch_name'].' '.$row['warehouse_name'].' ('.$row['available_quantity'].') </option>
                                                                          ';
                                                                    }
                                                                }
                                           $result_html .= '          </select>
                                                                    <input type="hidden" value="'.$item_id.'" class="form-control" name="itemid[]" id="itemid">
                                                </div>';
                                                
        }

                                            $result_html .= '
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light">Save changes</button>
                                                </div>
                                            </form>';
        
        $message = ['status' => '1', 'message' => 'Data Sucessfully Fetched!', 'stock_data' => $result_html];
        echo json_encode($message);
        die;

    }
    
    public function update_quantity()
    {
        $itemid = $this->request->getVar('itemid');
        $warehouse_id = $this->request->getVar('warehouse_id');
        
        $count = count($itemid);
        
        $loop_count = 0;
        
        for($i=0;$i<$count;$i++)
        {
            
            ++$loop_count;
            
            $item_id = $itemid[$i];
            
            $filter = array("id" => $item_id);
            $item_details = $this->CommonModel->get_single("order_items",$filter);
            
            $filter = array("id" => $item_details->product_id);
            $product = $this->CommonModel->get_single("products",$filter);
            
            $available_stock = $product->main_stock;
            $quantity_to_be_sent = $item_details->quantity * $product->unit_value;
 
            
           
            
                //stock log
                $insert_stock_data = array(
                                                "product_id"    => $product->id,
                                                "warehouse_id"  => $warehouse_id[$i],
                                                "type"          => "Sub",
                                                "description"   => "Substract From Order",
                                                "quantity"      => $quantity_to_be_sent,
                                                "created"       => date("Y-m-d H:i:s")
                                            );
                
                $insert_stock_log = $this->CommonModel->common_insert_data("stock_logs",$insert_stock_data);
                
                //Update Main Stock
                $new_stock = $available_stock - $quantity_to_be_sent;

                $filter = array("id" => $product->id);
                $update_data = array("main_stock" => $new_stock);
                $update = $this->CommonModel->update_data("products",$update_data,$filter);
            
            //echo $itemid[$i];
            //echo "/";
            //echo $warehouse_id[$i];
            //echo "-------";
            //echo "\n";
        }
        
        if($loop_count == $count)
        {
            $message = ['status' => '1', 'message' => 'Stock has been updated!'];
            echo json_encode($message);
            die;
        }
        else
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            echo json_encode($message);
            die;
        }

    }
    
    public function send_invoice_email()
    {
        
        
        $email = \Config\Services::email();
        $email->setFrom('graphionic@gmail.com', 'Inquiry From Website');
        $email->setTo('djhemzz@gmail.com');
        $email->setSubject('Inquiry From Website');
        $email->setMessage("Hello");//your message here
        $email->send();
                    die;
        
        $email = \Config\Services::email();

        $email->setTo('djhemzz@gmail.com');
        $email->setFrom('johndoe@gmail.com', 'Confirm Registration');
        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');
        $email->setNewLine("\r\n");
        
        if($email->send())
        {
            echo "Send";
        }
        else
        {
            echo "error";   
        }
die;
        
        
        $table = "orders";
        $filter = array("id" => 27);
        $exist = $this->CommonModel->get_single("orders",$filter);
        $user_id = $exist->user_id;
        
        $filter = array("id" => $user_id);
        $user_exist =  $this->CommonModel->get_single("user_master",$filter);

            
    //     $mobileNumber = $user_exist['contact'];
	   // $user_email   = $user_exist['email'];
	   // $user_name    = $user_exist['full_name'];
	    
        $mobileNumber = "8849346919";
	    $user_email   = "djhemzz@gmail.com";
	    $user_name    = "Mayank Parmar";

        //Send Email
        $message = '<!DOCTYPE html>';
		$message .= '<html>';
		$message .= '<head>';
		$message .= '</head>';
		$message .= '<body>';
        $message .= '<table cellspacing="0" cellpadding="0" border="0" style="color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em Helvetica Neue,Arial, Helvetica"> <tbody><tr width="100%"> <td valign="top" align="left" style="background:#eef0f1;font:15px/1.25em Helvetica Neue ,Arial,Helvetica"> <table style="border:none;padding:0 18px;margin:50px auto;width:500px"> <tbody> <tr width="100%" height="60"> <td valign="top" align="left" style="border-top-left-radius:4px;border-top-right-radius:4px;background:#fff url(https://ci5.googleusercontent.com/proxy/EX6LlCnBPhQ65bTTC5U1NL6rTNHBCnZ9p-zGZG5JBvcmB5SubDn_4qMuoJ-shd76zpYkmhtdzDgcSArG=s0-d-e1-ft#https://trello.com/images/gradient.png) bottom left repeat-x;padding:10px 18px;text-align:center"> OK Kirana </td> </tr> <tr width="100%"> <td valign="top" align="left" style="background:#fff;padding:18px">';
        $message .= '<p style="font:15px/1.25em Helvetica Neue ,Arial,Helvetica;color:#333;text-align:center">  Order No # '.$exist->order_no.' Has been delivered by our delivery person. thanks for being with us.</p>';
        $message .= '<div style="background:#d2c2b0;border-radius:3px"> <br>';
        $message .= '<p style="text-align:center"> <a href="#" style="color:#fff;font:26px/1.25em Helvetica Neue, Arial,Helvetica;text-decoration:none;font-weight:bold" target="_blank">'.$user_name.'</a> </p>';
        $message .= '<p style="font:15px/1.25em Helvetica Neue ,Arial,Helvetica;margin-bottom:0;text-align:center"> <a href="#" style="border-radius:3px;background:#fff;color:#9f9f9f;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 6px;padding:10px 18px;text-decoration:none;width:180px" target="_blank">Order No :  '.$exist->order_no.'</a> </p>';
        $message .= '<br><br> </div>';
        $message .= '</td>';
        $message .= '</tr>';
        $message .= '</tbody> </table> </td> </tr></tbody> </table>'; 
		$message .= "</body>";
		$message .= "</html>";
		$datetime = date('d-M-Y h:i A');
		$heads = "Order No. ". $exist->order_no." Delivered successfully!" ." - OK Kirana!";
        
        
        $email = \Config\Services::email();
        $email->setTo($user_email);
        $email->setFrom('info@okkirana.in', $user_name);
        
        $email->setSubject($heads);
        $email->setMessage($message);
        $email->send(); 
        
                                            	      

    }
    
    public function app_invoice()
    {
        $order_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $order_id);
        $data['order_details'] = $this->CommonModel->get_single('orders', $filter);

        $filter = array("order_id" => $order_id);
        $data['order_items'] = $this->CommonModel->get_by_condition('order_items', $filter);

        $data['page_title'] = 'Orders';
        $data['page_headline'] = 'Orders';
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Orders\Views\app_invoice', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    
    public function print()
    {
        $order_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $order_id);
        $data['order_details'] = $this->CommonModel->get_single('orders', $filter);

        $filter = array("order_id" => $order_id);
        $data['order_items'] = $this->CommonModel->get_by_condition('order_items', $filter);

        $data['page_title'] = 'Orders';
        $data['page_headline'] = 'Orders';
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        //echo view('App\Modules\Admin\Views\header', $data);
        //echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Orders\Views\print', $data);
        //echo view('App\Modules\Admin\Views\footer', $data);
    }
}
