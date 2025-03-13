<?php 
namespace App\Modules\Purchases\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Purchases extends BaseController {
    protected $CommonModel;
    protected $table;
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "purchases";
        helper(['form', 'url']);

        
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
        
	}

    public function index()
    {

        $this->permissionCheckNormal('purchase_list','normal');

        $data['page_title']     = 'Purchases';
        $data['page_headline']  = 'Purchases';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        
        /////////////// Purchase Counts //////////////
        
        $query = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day ";
        $all_purchases   = $this->CommonModel->custome_query($query);
        $data['all_purchases'] = count($all_purchases);
        
        $query = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day AND status = 'ordered' ";
        $ordered   = $this->CommonModel->custome_query($query);
        $data['ordered'] = count($ordered);

        $query = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day AND status = 'pending' ";
        $pending 	   = $this->CommonModel->custome_query($query);
        $data['pending'] = count($pending );
        
        $query = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day AND status = 'recieved' ";
        $recieved 	   = $this->CommonModel->custome_query($query);
        $data['recieved'] = count($recieved );
        
        $query              = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day AND payment_status = 1 ";
        $paid	        = $this->CommonModel->custome_query($query);
        $data['paid']   = count($paid );

        $query              = "SELECT * FROM purchases WHERE  created >= CURDATE() - interval 30 day AND payment_status = 0 ";
        $unpaid	        = $this->CommonModel->custome_query($query);
        $data['unpaid']   = count($unpaid );

        /////////////// Purchase Counts //////////////

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Purchases\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_purchases()
    {
        
        $label_filter = $this->request->getVar('label_filter');
        $filter_dates = $this->request->getVar('filter_dates');
        $payment_filter = $this->request->getVar('payment_filter');
        $startdate = "";
        $enddate = "";
       

       
        
        
        
        
                $where = '';
        
        $where = 'WHERE p.warehouse_id = w.id';
        $where .= " And p.is_deleted = 0";
        
 
        
        $where .= " And p.created >= CURDATE() - interval 30 day ";
        
        ///////////PURCHASE STATUS FILTER START
        if ($label_filter != "") {
            $where .= " AND p.status = '$label_filter'  ";
        }
        ///////////PURCHASE STATUS FILTER ENDS
        
         ///////////PURCHASE PAYMENT FILTER START
        if ($payment_filter != "") {
            $where .= " AND p.payment_status = $payment_filter  ";
        }
        ///////////PURCHASE STATUS FILTER ENDS

        ///////////PURCHASE DATEWISE FILTER STARTS
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

            $where .= " AND (date BETWEEN '$startdate' AND '$enddate') ";
        }
        ///////////PURCHASE DATEWISE FILTER ENDS

        if (!empty($_REQUEST['search']['value'])) {
            //$where .= " And ( p.reference_no LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
            $where .= " And ( w.name LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
            $where .= " or ( p.batch LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
            $where .= " or ( p.reference_no LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
        }

        $totalRecordsSql = "SELECT p.*, w.name as warehouse from purchases p, warehouse w  $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'batch',
            3 => 'reference_no',
            4 => 'warehouse',
            5 => 'status',
            6 => 'payment_status',
            7 => 'cgst',
            8 => 'sgst',
            9 => 'igst',
            10 => 'total_tax',
            11 => 'grand_total',
            12 => 'created',
            13 => 'action',
        );

        $sql = "SELECT p.*, w.name as warehouse from purchases p, warehouse w ";
        $sql .= "$where";
      
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {

            
            $data['no']                     = ++$count;
            $data['id']                     = $row->id;
            $data['batch']                  = $row->batch;
            $data['reference_no']           = $row->reference_no;
            $data['warehouse']              = $row->warehouse;
            $data['cgst']              = $row->cgst;
            $data['sgst']              = $row->sgst;
            $data['igst']              = $row->igst;
            $data['total_tax']              = $row->total_tax;
            $data['status']                 = $row->status;
            $data['grand_total']            = $row->grand_total;
            $data['payment_status']         = $row->payment_status;
            $data['created']                = $row->created;


            array_push($data_array, $data);
        }

        $json_data = array(
            "draw"            => intval($_REQUEST['draw']),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data_array
        );

        return json_encode($json_data);
    }
    
    public function download_excel()
    {
        $label_filter = $this->request->getVar('label_filter');
        $filter_dates = $this->request->getVar('filter_dates');
        $payment_filter = $this->request->getVar('payment_filter');
        $startdate = "";
        $enddate = "";
       
        $where = '';
        
        $where = 'WHERE p.warehouse_id = w.id';
        $where .= " And p.is_deleted = 0";
       
        
        $where .= " And p.created >= CURDATE() - interval 30 day ";
        
        ///////////PURCHASE STATUS FILTER START
        if ($label_filter != "") {
            $where .= " AND p.status = '$label_filter'  ";
        }
        ///////////PURCHASE STATUS FILTER ENDS
        
         ///////////PURCHASE PAYMENT FILTER START
        if ($payment_filter != "") {
            $where .= " AND p.payment_status = $payment_filter  ";
        }
        ///////////PURCHASE STATUS FILTER ENDS

        ///////////PURCHASE DATEWISE FILTER STARTS
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

            $where .= " AND (date BETWEEN '$startdate' AND '$enddate') ";
        }
        ///////////PURCHASE DATEWISE FILTER ENDS

        $sql = "SELECT p.*, w.name as warehouse from purchases p, warehouse w ";
        $sql .= "$where";

        $result = $this->CommonModel->custome_query($sql);

        //////////// Excel Start //////////////

        $fileName = 'data-' . time() . '.xlsx';

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // set Header
        $sheet->SetCellValue('A1', 'Sr No.');
        $sheet->SetCellValue('B1', 'Invoice No');
        $sheet->SetCellValue('C1', 'Invoice Date');
        $sheet->SetCellValue('D1', 'GSTIN');
        $sheet->SetCellValue('E1', 'Name');
        $sheet->SetCellValue('F1', 'Order Status');
        $sheet->SetCellValue('G1', 'Payment Status');
        $sheet->SetCellValue('H1', 'Bill Amount');
        $sheet->SetCellValue('I1', 'CGST');
        $sheet->SetCellValue('J1', 'SGST');
        $sheet->SetCellValue('K1', 'IGST');
        $sheet->SetCellValue('L1', 'Total Tax');
        $sheet->SetCellValue('M1', 'Total');

        $rowCount = 2;

        ///////////////  Data Start //////////////

        $count = 0;
        foreach ($result as  $row) 
        {

            $filter = array('id' => $row->supplier_id);
            $supplier =  $this->CommonModel->get_single('suppliers', $filter);

            $purchase_status = $row->status;
            if ($purchase_status == "pending"){$purchase_status = "Pending";} 
            else if ($purchase_status == "recieved") 
            {$purchase_status = "Recieved";} 
            else if ($purchase_status == "ordered"){$purchase_status = "Ordered";} 

            $payment_status = $row->payment_status;
            if ($payment_status == 0) {$payment_status = "Unpaid";} 
            else if ($payment_status == 1) {$payment_status = "Paid";}

            $orgDate    = $row->created;
            $order_date = date("d-m-Y h:i A", strtotime($orgDate));

            $sheet->SetCellValue('A' . $rowCount, ++$count);
            $sheet->SetCellValue('B' . $rowCount, $row->reference_no);
            $sheet->SetCellValue('C' . $rowCount, $row->date);
            $sheet->SetCellValue('D' . $rowCount, $supplier->gst_no);
            $sheet->SetCellValue('E' . $rowCount, $supplier->name);
            $sheet->SetCellValue('F' . $rowCount, $purchase_status);
            $sheet->SetCellValue('G' . $rowCount, $payment_status);
            $sheet->SetCellValue('H' . $rowCount, $row->total_cost_wo_tax);
            $sheet->SetCellValue('I' . $rowCount, $row->cgst);
            $sheet->SetCellValue('J' . $rowCount, $row->sgst);
            $sheet->SetCellValue('K' . $rowCount, $row->igst);
            $sheet->SetCellValue('L' . $rowCount, $row->total_tax);
            $sheet->SetCellValue('M' . $rowCount, $row->grand_total);

            $rowCount++;
        }
        
        // $total_tax = $total_cgst + $total_sgst;
        
        // $sheet->SetCellValue('B' . $rowCount, "Total Sell");
        // $sheet->SetCellValue('C' . $rowCount, $total_sell);
        // $sheet->SetCellValue('B' . ++$rowCount, "Total CGST");
        // $sheet->SetCellValue('C' . $rowCount, $total_cgst);
        // $sheet->SetCellValue('B' . ++$rowCount, "Total SGST");
        // $sheet->SetCellValue('C' . $rowCount, $total_sgst);
        // $sheet->SetCellValue('B' . ++$rowCount, "Total Tax");
        // $sheet->SetCellValue('C' . $rowCount, $total_tax);

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
    
    public function add_purchase()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_purchase');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////


        $batch                  = $this->request->getVar('batch');
        $reference_no           = $this->request->getVar('reference_no');
        $warehouse_id           = $this->request->getVar('warehouse_id');
        $status                 = $this->request->getVar('status');
        $supplier_id            = $this->request->getVar('supplier_id');
        $note                   = $this->request->getVar('note');
        $total                  = $this->request->getVar('total');
        $product_discount       = $this->request->getVar('product_discount');
        $order_discount         = $this->request->getVar('order_discount');
        $total_discount         = $this->request->getVar('total_discount');
        $product_tax            = $this->request->getVar('product_tax');
        $order_tax              = $this->request->getVar('order_tax');
        $sub_total_tax              = $this->request->getVar('sub_total_tax');
        $grand_total            = $this->request->getVar('grand_total');
        $payment_status         = $this->request->getVar('payment_status');
        $total_igst         = $this->request->getVar('total_igst');
        $total_sgst         = $this->request->getVar('total_sgst');
        $total_cgst        = $this->request->getVar('total_cgst');
        $total_cost_wo_tax        = $this->request->getVar('total_cost_wo_tax');


        $pucost         = $this->request->getVar('pucost');
        $puqty          = $this->request->getVar('puqty');
        $puproduct_id   = $this->request->getVar('puproduct_id');
        $puexpiry       = $this->request->getVar('puexpiry');
        $pualbeda       = $this->request->getVar('pualbeda');
        $pusupplierid   = $this->request->getVar('pusupplierid');
        $cost_wo_tax    = $this->request->getVar('cost_wo_tax');
        $sgst           = $this->request->getVar('sgst');
        $cgst           = $this->request->getVar('cgst');
        $igst           = $this->request->getVar('igst');
        $total_tax      = $this->request->getVar('total_tax');


        //Attachment Upload//
        if(!empty($_FILES['attachment']['name'])) 
        {
            $strtotime = strtotime("now");
            $filename = $strtotime.'_'.$_FILES['attachment']['name'];

            $file_path = $_FILES['attachment']['tmp_name'];
            $file_error = $_FILES['attachment']['error'];

            $file_destination ='uploads/purchase/'.$filename;
            move_uploaded_file($file_path, $file_destination);

            $attachment = $filename;
        }
        else
        {
            $attachment = "";
        }
        //Attachment Upload//

        $date       = $this->request->getVar('purchase_date');
        $created    = date("Y-m-d H:i:s");

        $insert_data = array(
                                "batch"             => $batch,
                                "reference_no"      => $reference_no,
                                "warehouse_id"      => $warehouse_id,
                                "status"            => $status,
                                "supplier_id"       => $supplier_id,
                                "note"              => $note,
                                "attachment"        => $attachment,
                                "total"             => $total,
                                "product_discount"  => $product_discount,
                                "order_discount"    => $order_discount,
                                "total_discount"    => $total_discount,
                                "product_tax"       => $product_tax,
                                "order_tax"         => $order_tax,
                                "total_tax"         => $sub_total_tax,
                                "total_cost_wo_tax"         => $total_cost_wo_tax,
                                "igst"              => $total_igst,
                                "cgst"              => $total_cgst,
                                "sgst"              => $total_sgst,
                                "grand_total"       => $grand_total,
                                "payment_status"    => $payment_status,
                                "date"              => $date,
                                "created"           => $created,
                            );

        // echo '<pre>';
        // print_r("Purchase Cost");
        // print_r($pucost);
        // print_r("Qty");
        // print_r($puqty);
        // print_r("Alert Before Days");
        // print_r($pualbeda);
        // print_r("Product Id");
        // print_r($puproduct_id);
        // print_r("Supplier Id");
        // print_r($pusupplierid);
        // print_r("Expirty Dates");
        // print_r($puexpiry);
        // print_r("Cost W/o Tax");
        // print_r($cost_wo_tax);
        // print_r("SGST");
        // print_r($sgst);
        // print_r("CGST");
        // print_r($cgst);
        // print_r("IGST");
        // print_r($igst);
        // print_r("Totax Tax");
        // print_r($total_tax);
        // print_r($insert_data);
        // die;

       
        $purchase_insert = $this->CommonModel->common_insert_data('purchases', $insert_data);
        
        if($purchase_insert != false)
        {
            $purchase_id = $purchase_insert;
         
            $data_array = array();
            $stock_log_array = array();
            
            $length = count($puproduct_id);

            for ($i = 0; $i < $length; $i++) 
            {
                
                $data['purchase_id']        = $purchase_id;
                $data['product_id']         = $puproduct_id[$i];
                $data['net_unit_cost']      = $pucost[$i];
                $data['quantity']           = $puqty[$i];
                $data['alert_before_days']  = $pualbeda[$i];
                
                $data['sgst']       = $sgst[$i];
                $data['cgst']       = $cgst[$i];
                $data['igst']       = $igst[$i];
                $data['total_tax']  = $total_tax[$i];
                
                $originalDate           = $puexpiry[$i];
                $newDate                = date("Y-m-d", strtotime($originalDate));
                $data['expiry']         = $newDate;

                $data['warehouse_id']       = $warehouse_id;
                $data['cost_before_tax']    = $cost_wo_tax[$i];
                $data['discount']           = "";
                $data['date']               = $date;

                $data['created']             = date("Y-m-d H:i:s");

                $stockdata['product_id']     = $puproduct_id[$i];
                $stockdata['warehouse_id']   = $warehouse_id;
                $stockdata['type']           = "Add";
                $stockdata['description']    = "Purchase Quantity";
                $stockdata['quantity']       = $puqty[$i];
                $stockdata['created']        = date("Y-m-d H:i:s");


                //Update Main Stock//
                $filter = array("id" => $puproduct_id[$i]);
                $exist = $this->CommonModel->get_single("products",$filter);
                $old_stock = $exist->main_stock;

                $new_stock = $old_stock + $puqty[$i];

                $update_data = array("main_stock" => $new_stock);
                $update = $this->CommonModel->update_data("products",$update_data,$filter);

                array_push($data_array,$data);
                array_push($stock_log_array,$stockdata);
            }


            $insert_purchase_options  = $this->db->table('purchase_items')->insertBatch($data_array);
            

          
            if($insert_purchase_options != false)
            {

                $insert_stock_logs          = $this->db->table('stock_logs')->insertBatch($stock_log_array);

                $activity_title = "Purchase Added " . $purchase_id;
                $this->addActivityLog($activity_title);

                $message = ['status' => '1', 'message' => 'New Purchase has been added!'];
                return json_encode($message);
            }
            else
            {
                $message = ['status' => '0', 'message' => 'Something went wrong!'];
                return json_encode($message);
            }
        }
        
       

    }
    
    public function delete()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('delete_purchase');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id = $this->request->uri->getSegment(3);
	    $update_data = array("is_deleted"    => 1);

        $update = $this->CommonModel->common_update_data($this->table,$id,$update_data);
        
        
        if ($update != false) 
        {

            $activity_title = "Purchase Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Purchase has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_purchase()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('purchase_update');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id             = $this->request->getVar('product_id');
        $name           = $this->request->getVar('edit_name');
        $permissions    = $this->request->getVar('permission');
       
        $filter = array("id" => $id);
        $update_data = array(
                                "name" => $name,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Purchase Updated " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Details Updated!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }


    }
    
    public function change_purchase_status()
    {
       
        $purchase_status = $this->request->uri->getSegment(3);
        $purchase_id = $this->request->uri->getSegment(4);


        $filter = array("id" => $purchase_id);
        $update_data = array("status" => $purchase_status);
        $update = $this->CommonModel->update_data('purchases', $update_data, $filter);

        if ($update != false) {
    
            $message = ['status' => '1', 'message' => 'Purchase Status Updated!'];
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

    public function change_payment_status()
    {
       
        $purchase_status = $this->request->uri->getSegment(3);
        $purchase_id = $this->request->uri->getSegment(4);


        $filter = array("id" => $purchase_id);
        $update_data = array("payment_status" => $purchase_status);
        $update = $this->CommonModel->update_data('purchases', $update_data, $filter);

        if ($update != false) {
    
            $message = ['status' => '1', 'message' => 'Payment Status Updated!'];
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

    public function get_supplier_products()
    {
        $supplier_id = $this->request->getVar('supplier_id');
        $query         = "SELECT * FROM products WHERE FIND_IN_SET($supplier_id,suppliers) and is_deleted = 0 and status = 1 and linked_id = 0 ";
        $supplier_products      = $this->CommonModel->custome_query($query);
        // echo '<pre>';
        // print_r($product_details);die;
        echo json_encode($supplier_products);
    }
    
    public function get_supplier_info()
    {
        $supplier_id = $this->request->getVar('supplier_id');
        $filter = array("id" => $supplier_id,"is_deleted" => 0 ,"status" =>1);
        $details = $this->CommonModel->get_single("suppliers",$filter);
        $message = [
                        'status' => '1',
                        'supplier_id' => $details->id,
                        'out_of_state' => $details->out_of_state,
                        'message' => 'Success'
                    ];
        echo json_encode($message);
        die;
    }

    public function get_product_details()
    {
        $product_id = $this->request->getVar('product_id');
        
        $filter = array("id" => $product_id);
        
        $query = "SELECT p.*,u.name,u.code,u.value, t.name as tax_name, t.tax_rate FROM products p, units u, tax_rates t WHERE p.id = $product_id and p.unit_id = u.id and p.status = 1 and t.id = p.tax_id and p.is_deleted = 0";
        
        $product_details = $this->CommonModel->custome_query_single_record($query);
        
        //$product_details = $this->CommonModel->get_single("products",$filter);

        echo json_encode($product_details);
    }
 
    public function get_details_for_view()
    {
        $id = $this->request->getVar('id');

        $result_html = '';

        $filter                = array("id" => $id);
        $purchase_details      = $this->CommonModel->get_single('purchases',$filter);

        // $filter         = array("id" => $product_details->category_id);
        // $category_details   = $this->CommonModel->get_single('categories',$filter);

        // $filter         = array("id" => $product_details->unit_id);
        // $unit_details   = $this->CommonModel->get_single('units',$filter);

       
        $filter         = array("purchase_id" => $purchase_details->id);
        $purchase_items   = $this->CommonModel->get_by_condition('purchase_items',$filter);
        
        $filter         = array("id" => $purchase_details->warehouse_id);
        $warehouse   = $this->CommonModel->get_single('warehouse',$filter);
        
        $filter         = array("id" => $purchase_details->supplier_id);
        $supplier   = $this->CommonModel->get_single('suppliers',$filter);

        // $filter = array("role_id" => $id);
        // $role_permission = $this->CommonModel->get_by_condition('role_permissions',$filter);

        // $all_role_permission  = $this->CommonModel->get_all_data('permissions');


        $result_html .= '

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h3 class="box-title">General Info</h3>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Date</td>
                                                                    <td> '.$purchase_details->date.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reference No</td>
                                                                    <td> '.$purchase_details->reference_no.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Supplier</td>
                                                                    <td> '.$supplier->name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Note</td>
                                                                    <td> '.$purchase_details->note.' </td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h3 class="box-title">Info</h3
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Batch</td>
                                                                    <td> '.$purchase_details->batch.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Warehouse</td>
                                                                    <td> '.$warehouse->name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td> '.$purchase_details->status.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Attachment</td>
                                                                    <td> <a target="_blank" href="'.base_url().'uploads/purchase/'.$purchase_details->attachment.'">View Attachment</a> </td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                           
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <th>Item</th>
                                                        <th>Image</th>
                                                        <th>Expiry</th>
                                                        <th>Alert Before Days</th>
                                                        <th>Net Unit Cost</th>
                                                        <th>Quantity</th>
                                                        <th>Tax</th>
                                                        <th>SGST</th>
                                                        <th>CGST</th>
                                                        <th>IGST</th>
                                                        <th>Total Tax</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>';
                                                        if(!empty($purchase_items))
                                                        {
                                                            foreach($purchase_items as $row)
                                                            {
                                                                $filter = array("id" => $row->product_id);
                                                                $product= $this->CommonModel->get_single("products",$filter);
                                                                
                                                                $filter         = array("id" => $product->tax_id);
                                                                $tax_details   = $this->CommonModel->get_single('tax_rates',$filter);

                                                            
                                                                $result_html .='
                                                                <tr>
                                                                    <td> '.$product->product_name.' </td>
                                                                    <td> <img height="50" width="50" src="'.base_url().'uploads/products/'.$product->product_image.'"> </td>
                                                                    <td> '.$row->expiry.' </td>
                                                                    <td> '.$row->alert_before_days.' </td>
                                                                    <td> '.$row->net_unit_cost.' </td>
                                                                    <td> '.$row->quantity.' </td>
                                                                    <td> '.$tax_details->tax_rate.'%</td>
                                                                    <td> '.$row->sgst.' </td>
                                                                    <td> '.$row->cgst.' </td>
                                                                    <td> '.$row->igst.' </td>
                                                                    <td> '.$row->total_tax.' </td>
                                                                    <td> '.$row->net_unit_cost *  $row->quantity.' </td>
                                                                </tr>   ';
                                                            }
                                                        }
                                                    
                                                        $result_html .='    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                ';
            
            $val = ['status' => '1','product_details_in_model' => $result_html ,'message' => 'Success'];
            echo json_encode($val);
            die;
    }
    
    public function purchase_invoice()
    {
        $purchase_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $purchase_id);
        $data['purchase_details'] = $this->CommonModel->get_single('purchases', $filter);

        $filter = array("purchase_id" => $purchase_id);
        $data['purchase_items'] = $this->CommonModel->get_by_condition('purchase_items', $filter);

        $data['page_title'] = 'Purchases';
        $data['page_headline'] = 'Purchases';
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Purchases\Views\purchase_invoice', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function print()
    {
        $purchase_id = $this->request->uri->getSegment(3);

        $filter = array("id" => $purchase_id);
        $data['purchase_details'] = $this->CommonModel->get_single('purchases', $filter);

        $filter = array("purchase_id" => $purchase_id);
        $data['purchase_items'] = $this->CommonModel->get_by_condition('purchase_items', $filter);

        $data['page_title'] = 'Purchases';
        $data['page_headline'] = 'Purchases';
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Purchases\Views\print', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }

}